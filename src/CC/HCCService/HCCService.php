<?php

namespace SwedbankPaymentPortal\CC\HCCService;

use SwedbankPaymentPortal\AbstractService;
use SwedbankPaymentPortal\CallbackInterface;
use SwedbankPaymentPortal\CC\PaymentCardTransactionData;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\ThreeDSecureAuthorizationResponse\ThreeDSecureAuthorizationResponse;
use SwedbankPaymentPortal\CC\Type\AuthorizationStatus;
use SwedbankPaymentPortal\SharedEntity\Amount;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\AuthorizationRequest;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction\CardTxn;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction\Action;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction\CustomerDetails;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction\MerchantConfiguration;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction\ThreeDSecure;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction\TxnDetails;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction\CardDetails;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationResponse\AuthorizationResponse;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\HCCQueryRequest\HCCQueryRequest;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\HCCQueryResponse\HCCQueryResponse;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\SetupRequest\SetupRequest;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\SetupResponse\SetupResponse;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\ThreeDSecureAuthorizationRequest\HistoricTxn;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\ThreeDSecureAuthorizationRequest\ThreeDSecureAuthorizationRequest;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\ThreeDSecureAuthorizationRequest\Transaction as ThreeDSecureTransaction;
use SwedbankPaymentPortal\Transaction\TransactionContainer;
use SwedbankPaymentPortal\Transaction\TransactionFrame;
use SwedbankPaymentPortal\CC\Type\ScreeningAction;
use SwedbankPaymentPortal\CC\Type\ThreeDAuthorizationStatus;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\HCCQueryRequest\Transaction as HCCTransaction;
use SwedbankPaymentPortal\SharedEntity\Type\TransactionResult;

/**
 * Service handling all of the payment card processes using HPS queries.
 */
class HCCService extends AbstractService
{
    /**
     * @var Communication
     */
    protected $communication;

    /**
     * Handles and starts a purchase.
     *
     * @param SetupRequest      $setupRequest
     * @param CallbackInterface $finalCallback
     *
     * @return SetupResponse
     */
    public function initPayment(SetupRequest $setupRequest, CallbackInterface $finalCallback)
    {
        $setupRequest->setAuthentication($this->serviceOptions->getAuthentication());
        $transactionFrame = new TransactionFrame($setupRequest);
        $response = $this->communication->sendSetupRequest($setupRequest);
        $transactionFrame->setResponse($response);

        $transactionContainer = new TransactionContainer(
            $setupRequest->getTransaction()->getTxnDetails()->getMerchantReference(),
            $finalCallback
        );
        $transactionContainer->addFrame($transactionFrame);
        $this->getTransactionRepository()->persist($transactionContainer);

        return $response;
    }

    /**
     * Continues with authorization.
     *
     * @param string                $merchantReference
     * @param CustomerDetails       $customerDetails
     * @param MerchantConfiguration $merchantConfiguration
     * @param Amount                $amount
     * @param ThreeDSecure          $threeDSecure
     * @param ScreeningAction       $screeningAction
     *
     * @return AuthorizationResponse
     */
    public function authorization(
        $merchantReference,
        CustomerDetails $customerDetails,
        MerchantConfiguration $merchantConfiguration,
        Amount $amount,
        ThreeDSecure $threeDSecure = null,
        ScreeningAction $screeningAction = null
    ) {
        /** @var TransactionContainer $transactionContainer */
        $transactionContainer = $this->getTransactionRepository()->get($merchantReference);

        $frames = $transactionContainer->getFrames();

        /** @var SetupResponse $firstResponse */
        $firstResponse = reset($frames)->getResponse();

        $screeningAction = $screeningAction ? $screeningAction : ScreeningAction::preAuthorization();

        $action = new Action($screeningAction, $merchantConfiguration, $customerDetails);
        $txnData = new TxnDetails($action, $merchantReference, $amount, $threeDSecure);
        $transaction = new Transaction($txnData, new CardTxn(new CardDetails($firstResponse->getDataCashReference())));
        $authRequest = new AuthorizationRequest($this->serviceOptions->getAuthentication(), $transaction);

        /** @var AuthorizationResponse $response */
        $response = $this->communication->sendAuthRequest($authRequest);

        $transactionFrame = new TransactionFrame($authRequest);
        $transactionFrame->setResponse($response);
        $transactionContainer->addFrame($transactionFrame);
        $this->getTransactionRepository()->persist($transactionContainer);

        $transactionResult = $this->getTransactionResultFromAuthorizationResponse($response);

        $this->callbackProcessing($merchantReference, $transactionResult, $transactionContainer, $transactionFrame);

        return $response;
    }

    /**
     * @param                        $merchantReference
     * @param TransactionResult|null $transactionResult
     * @param TransactionContainer   $transactionContainer
     * @param TransactionFrame       $transactionFrame
     */
    private function callbackProcessing($merchantReference, $transactionResult, TransactionContainer $transactionContainer, TransactionFrame $transactionFrame)
    {
        if ($transactionResult) {

            if ($transactionResult === TransactionResult::success()) {
                $queryResponse             = $this->hccQuery($merchantReference);
                $paymentCardTransactionData = PaymentCardTransactionData::createFromHCCQueryResponse($queryResponse);
            } else {
                $paymentCardTransactionData = null;
            }

            /** @var CallbackInterface $callback */
            $callback = $transactionContainer->getCallback();
            $callback->handleFinishedTransaction($transactionResult, $transactionFrame, $paymentCardTransactionData);

            $this->getTransactionRepository()->remove($merchantReference);
        };
    }

    /**
     * Method will determine is given query response is success or failure.
     *
     * Returns TransactionResult::success()  - IF PAYMENT WAS MADE.
     *         TransactionResult::failure()  - IF PAYMENT WAS DECLINED.
     *                                 null  - still unknown state..
     *
     * @param AuthorizationResponse $response
     *
     * @return TransactionResult|null
     */
    private function getTransactionResultFromAuthorizationResponse(AuthorizationResponse $response)
    {
        if (AuthorizationStatus::canBeProcessedWithout3DS($response->getStatus())) {
            return null;
        }

        switch ($response->getStatus()) {
            case AuthorizationStatus::accepted():
                return TransactionResult::success();

            case AuthorizationStatus::invalidXml():
            case AuthorizationStatus::secureAuthenticationRequired():
                return null;

            default:
                return TransactionResult::failure();
        }
    }

    /**
     * @param ThreeDSecureAuthorizationResponse $response
     * @return null|TransactionResult
     */
    private function getTransactionResultFromThreeDSecureAuthorizationResponse(ThreeDSecureAuthorizationResponse $response)
    {
        switch ($response->getStatus()) {
            case ThreeDAuthorizationStatus::accepted():
                return TransactionResult::success();

            case ThreeDAuthorizationStatus::secureAuthenticationRequired():
                return null;

            default:
                return TransactionResult::failure();
        }
    }

    /**
     * Three D authentication step. Only to be used if ThreeD security was requested..
     *
     * @param string $merchantReference
     * @param string $paresMessage
     *
     * @return null|TransactionResult
     */
    public function threeDauthentication($merchantReference, $paresMessage)
    {
        /** @var TransactionContainer $transactionContainer */
        $transactionContainer = $this->getTransactionRepository()->get($merchantReference);

        /** @var TransactionFrame[] $frames */
        $frames = $transactionContainer->getFrames();

        /** @var TransactionFrame $secondFrame */
        $secondFrame = $frames[1];

        /** @var AuthorizationResponse $authorizationResponse */
        $authorizationResponse = $secondFrame->getResponse();

        $dataCashReference = $authorizationResponse->getDataCashReference();

        $transaction   = new ThreeDSecureTransaction(new HistoricTxn($dataCashReference, $paresMessage));
        $threeDRequest = new ThreeDSecureAuthorizationRequest($transaction, $this->serviceOptions->getAuthentication());

        /** @var ThreeDSecureAuthorizationResponse $response */
        $response = $this->communication->sendThreeDAuthRequest($threeDRequest);

        $transactionFrame = new TransactionFrame($threeDRequest);
        $transactionFrame->setResponse($response);
        $transactionContainer->addFrame($transactionFrame);
        $this->getTransactionRepository()->persist($transactionContainer);

        $transactionResult = $this->getTransactionResultFromThreeDSecureAuthorizationResponse($response);

        $this->callbackProcessing($merchantReference, $transactionResult, $transactionContainer, $transactionFrame);

        return $transactionResult;
    }

    /**
     * Finishes with a hcc query.
     *
     * @param string $merchantReference
     *
     * @return HCCQueryResponse
     */
    public function hccQuery($merchantReference)
    {
        $transactionContainer = $this->getTransactionRepository()->get($merchantReference);

        $frames = $transactionContainer->getFrames();

        /** @var SetupResponse $firstResponse */
        $firstResponse = reset($frames)->getResponse();

        $hccQuery = new HCCQueryRequest(
            $this->serviceOptions->getAuthentication(),
            new HCCTransaction(new HCCTransaction\HistoricTxn($firstResponse->getDataCashReference()))
        );
        $transactionFrame = new TransactionFrame($hccQuery);

        /** @var HCCQueryResponse $response */
        $response = $this->communication->sendHCCQueryRequest($hccQuery);
        $transactionFrame->setResponse($response);

        return $response;
    }
}
