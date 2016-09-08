<?php

namespace SwedbankPaymentPortal\BankLink;

use SwedbankPaymentPortal\AbstractCommunication;
use SwedbankPaymentPortal\AbstractService;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\NotificationQuery\ServerNotification;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\PurchaseRequest;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseResponse\PurchaseResponse;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\TransactionQueryRequest\APMTxn;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\TransactionQueryRequest\Transaction;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\TransactionQueryRequest\TransactionQueryRequest;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\TransactionQueryResponse\TransactionQueryResponse;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\Type\PaymentMethod;
use SwedbankPaymentPortal\CallbackInterface;
use SwedbankPaymentPortal\Options\ServiceOptions;
use SwedbankPaymentPortal\Serializer;
use SwedbankPaymentPortal\SharedEntity\Type\ResponseStatus;
use SwedbankPaymentPortal\SharedEntity\Type\TransactionResult;
use SwedbankPaymentPortal\SharedEntity\Type\TransportType;
use SwedbankPaymentPortal\Transaction\TransactionContainer;
use SwedbankPaymentPortal\Transaction\TransactionFrame;

/**
 * BankLinkService handling all of the processes during payment.
 */
class BankLinkService extends AbstractService
{

    /**
     * For nordea bank we need to query transaction only after 1.1 minute after entering to success url.
     * @var float
     */
    private $NORDEA_FIRST_QUERYING_INTERVAL = 1.1;

    /**
     * @var \SwedbankPaymentPortal\Logger\LoggerInterface
     */
    private $logger;

    public function __construct(ServiceOptions $serviceOptions, AbstractCommunication $communication, Serializer $serializer)
    {
        parent::__construct($serviceOptions, $communication, $serializer);
        $this->logger = $serviceOptions->getLogger();
    }

    /**
     * @var Communication
     */
    protected $communication;

    /**
     * Handles and starts a purchase.
     *
     * @param PurchaseRequest   $purchase
     * @param CallbackInterface $callback
     *
     * @return PurchaseResponse
     */
    public function initPayment(PurchaseRequest $purchase, CallbackInterface $callback)
    {
        $purchase->setAuthentication($this->serviceOptions->getAuthentication());
        $response = $this->communication->sendPurchaseRequest($purchase);

        $transactionFrame = new TransactionFrame($purchase);
        $transactionFrame->setResponse($response);
        $transactionContainer = new TransactionContainer(
            $purchase->getTransaction()->getTxnDetails()->getMerchantReference(),
            $callback
        );

        $transactionContainer->setPendingResult(true);
        $transactionContainer->addFrame($transactionFrame);

        $this->getTransactionRepository()->persist($transactionContainer);

        return $response;
    }

    /**
     * Handles notification response.
     *
     * @param string $xmlData
     *
     * @return ServerNotification
     */
    public function handleNotification($xmlData)
    {
        /** @var ServerNotification $notification */
        $notification = $this->serializer->getObject($xmlData, ServerNotification::class);

        $this->logger->logData(
            $xmlData,
            '',
            $notification,
            null,
            TransportType::notification()
        );

        if ($notification->getEvent()->getPurchase()->getStatus() == ResponseStatus::accepted()) {
            $merchantId = $notification->getEvent()->getPurchase()->getTransactionId();
            $transaction = $this->getTransactionRepository()->get($merchantId);

            if (!$transaction) {
                throw new \RuntimeException(
                    'Cannot find a given transaction in our pending list. (transaction id: ' .
                    $notification->getEvent()->getPurchase()->getTransactionId() . ')'
                );
            }

            $transactionFrame = new TransactionFrame($notification);
            $transaction->getCallback()->handleFinishedTransaction(TransactionResult::success(), $transactionFrame);

            $this->getTransactionRepository()->remove($merchantId);
        }

        return $notification;
    }

    /**
     * Handles unfinished transactions.
     *
     * @param string $merchantReferenceId
     * @return null|TransactionResult
     */
    public function handlePendingTransaction($merchantReferenceId)
    {
        $purchaseResponse = $this->getFirstTransactionFrame($merchantReferenceId);

        return $purchaseResponse ? $this->handlePendingUnfinishedResponse($purchaseResponse) : null;
    }

    /**
     * Checks if purchase specified in hps query is finished, if it is - remove it.
     * return an array of Exceptions occurred during process.
     * If everything was success array will be empty.
     *
     * @return array[]
     */
    public function checkPendingTransactions()
    {
        $errors = [];

        $transactionRepository = $this->getTransactionRepository();

        foreach ($transactionRepository->getPendingTransactions() as $unfinishedTransaction) {

            if ($this->shouldQueryTransaction($unfinishedTransaction)) {

                $unfinishedTransaction->setLastQueryingTime(new \DateTime());
                $transactionRepository->persist($unfinishedTransaction);

                try {
                    $this->handlePendingUnfinishedResponse($unfinishedTransaction->getFirstFrame());
                } catch (\Exception $e) {
                    $errors [] = $e;
                }

            }
        }

        return $errors;
    }

    /**
     * @param TransactionContainer $transaction
     * @return bool
     */
    private function shouldQueryTransaction(TransactionContainer $transaction)
    {
        $firstFrame = $transaction->getFirstFrame();

        /** @var APMTxn[] $apmtxns */
        $apmtxns = $firstFrame->getRequest()->getTransaction()->getApmTxns();

        /** @var PaymentMethod $paymentMethod */
        $paymentMethod = $apmtxns[0]->getPaymentMethod();

        // * for Nordea there is an exception, on first querying we should query transaction after 1.1 minute.
        if (($paymentMethod->id() === PaymentMethod::nordea()->id()) && $transaction->getEnteredToSuccessUrlTime() &&
            // * this will determine: is this querying is first querying or next.
            ($transaction->getLastQueryingTime() < $transaction->getEnteredToSuccessUrlTime())
        ) {
            $transactionTime = $transaction->getEnteredToSuccessUrlTime()->getTimestamp();
            $timeout = $this->NORDEA_FIRST_QUERYING_INTERVAL;

            if ((time() - $transactionTime) >= $timeout * 60.0) {
                return true;
            }
        }

        $transactionTime = $transaction->getLastQueryingTime()->getTimestamp();
        $timeout = $this->serviceOptions->getPendingTransactionQueryingInterval();

        if ((time() - $transactionTime) >= $timeout * 60.0) {
            return true;
        }

        return false;
    }

    /**
     * @param string $transactionId
     */
    public function transactionWasRedirectedToSuccessUrl($transactionId)
    {
        $transaction = $this->getTransactionRepository()->get($transactionId);
        if ($transaction) {
            $transaction->setEnteredToSuccessUrlTime(new \DateTime());
            $this->getTransactionRepository()->persist($transaction);
        }
    }

    /**
     * Failed response statuses.
     *
     * @return ResponseStatus[]
     */
    private function getFailedStatuses()
    {
        return [
            ResponseStatus::cancelled(),
            ResponseStatus::error(),
            ResponseStatus::refused(),
            ResponseStatus::requiresInvestigation(),
        ];
    }

    /**
     * Checks purchase status and if needed removes it.
     *
     * @param TransactionFrame $transactionFrame
     *
     * @return null|TransactionResult
     */
    private function handlePendingUnfinishedResponse(TransactionFrame $transactionFrame)
    {
        /** @var PurchaseRequest $purchaseRequest */
        $purchaseRequest = $transactionFrame->getRequest();

        $merchantReference = $purchaseRequest->getTransaction()->getTxnDetails()->getMerchantReference();

        $container = $this->getTransactionRepository()->get($merchantReference);
        if (!$container) {
            throw new \RuntimeException(
                'Unable to handle a given purchase response (merchantReference: ' .
                $transactionFrame->getRequest()->getMerchantReference() .
                ") because we couldn't find a callback which could be called during transaction resolution."
            );
        }

        $transactionQueryRequest = new TransactionQueryRequest($this->serviceOptions->getAuthentication(),
            new Transaction(
                    new APMTxn(
                        $purchaseRequest->getTransaction()->getApmTxns()[0]->getPaymentMethod(),
                        $merchantReference
                    )
            )
        );

        $response = $this->communication->sendTransactionQueryRequest($transactionQueryRequest);

        $transactionFrame = new TransactionFrame($transactionQueryRequest);
        $transactionFrame->setResponse($response);

        $transactionResult = $this->getTransactionResultFromQueryResponse($response);

        if ($transactionResult) {
            $callback = $container->getCallback();
            $callback->handleFinishedTransaction($transactionResult, $transactionFrame);
            $this->getTransactionRepository()->remove($merchantReference);
        };

        $container->addFrame($transactionFrame);
        $this->getTransactionRepository()->persist($container);

        return $transactionResult;
    }

    /**
     * Returns finished purchase from cache.
     *
     * @param string $merchantReference
     *
     * @return TransactionFrame|null
     */
    private function getFirstTransactionFrame($merchantReference)
    {
        foreach ($this->getTransactionRepository()->getPendingTransactions() as $unsettledTransaction) {
            if ($unsettledTransaction->getKey() == $merchantReference) {
                $frames = $unsettledTransaction->getFrames();
                return reset($frames);
            }
        }

        return null;
    }

    /**
     * Method will determine is given query response is success or failure.
     *
     * Returns TransactionResult::success()  - IF PAYMENT WAS MADE.
     *         TransactionResult::failure()  - IF PAYMENT WAS DECLINED.
     *                                 null  - still unknown state..
     *
     * @param TransactionQueryResponse $response
     *
     * @return TransactionResult|null
     */
    private function getTransactionResultFromQueryResponse(TransactionQueryResponse $response)
    {
        switch ($response->getApmTxn()->getPurchase()->getStatus()) {
            case ResponseStatus::accepted():
                return TransactionResult::success();

            case ResponseStatus::cancelled():
                return TransactionResult::failure();

            case ResponseStatus::refused():
                return TransactionResult::failure();

            case ResponseStatus::error():
                return TransactionResult::failure();

            case ResponseStatus::pending():
            case ResponseStatus::requiresInvestigation():
            case ResponseStatus::redirect():
            default:
                return null;
        }
    }
}
