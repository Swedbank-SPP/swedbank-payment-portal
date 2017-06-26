<?php
namespace SwedbankPaymentPortal\CC;

use SwedbankPaymentPortal\CC\HCCCommunicationEntity\HCCQueryResponse\HCCQueryResponse;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\HCCQueryResponse\QueryTxnResult;

class PaymentCardTransactionData
{
    private $pan;
    private $expiryDate;
    private $authorizationCode;
    private $merchantReference;
    private $fulfillDate;

    /**
     * @param HCCQueryResponse $queryResponse
     * @return PaymentCardTransactionData
     */
    public static function createFromHCCQueryResponse(HCCQueryResponse $queryResponse)
    {
        $transactionData = new PaymentCardTransactionData();

        /** @var QueryTxnResult $result */
        $result = $queryResponse->getQueryTxnResult();

        $transactionData->expiryDate        = $result->getCard()->getExpiryDate();
        $transactionData->pan               = $result->getCard()->getPan();
        $transactionData->authorizationCode = $result->getAuthCode();
        $transactionData->merchantReference = $result->getMerchantReference();
        $transactionData->fulfillDate       = $result->getFulfillDate();

        return $transactionData;
    }

    /**
     * @return mixed
     */
    public function getPan()
    {
        return $this->pan;
    }

    /**
     * @return mixed
     */
    public function getExpiryDate()
    {
        return $this->expiryDate;
    }

    /**
     * @return mixed
     */
    public function getAuthorizationCode()
    {
        return $this->authorizationCode;
    }

    /**
     * @return mixed
     */
    public function getMerchantReference()
    {
        return $this->merchantReference;
    }

    /**
     * @return \DateTime
     */
    public function getFulfillDate()
    {
        return $this->fulfillDate;
    }

    public function toArray()
    {
        return [
            'expiryDate'        => $this->expiryDate,
            'pan'               => $this->pan,
            'authorizationCode' => $this->authorizationCode,
            'merchantReference' => $this->merchantReference,
            'fulfillDate'       => $this->fulfillDate,
        ];
    }
}