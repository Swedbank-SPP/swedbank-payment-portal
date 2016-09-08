<?php

namespace SwedbankPaymentPortal\PayPal\CommunicationEntity\SetExpressCheckoutResponse;

use SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\Transaction;
use JMS\Serializer\Annotation;
use SwedbankPaymentPortal\SharedEntity\AbstractResponse;
use SwedbankPaymentPortal\SharedEntity\Type\MerchantMode;
use SwedbankPaymentPortal\SharedEntity\Type\PurchaseStatus;

/**
 * The container for the XML response.
 *
 * @Annotation\XmlRoot("Response")
 * @Annotation\AccessType("public_method")
 */
class SetExpressCheckoutResponse extends AbstractResponse
{
    /**
     * API version used.
     *
     * @var string
     *
     * @Annotation\XmlAttribute
     * @Annotation\Type("string")
     */
    private $version = '2';

    /**
     * The container for the HPS (hosted page) details.
     *
     * @var PayPalTxn
     *
     * @Annotation\SerializedName("PayPalTxn")
     * @Annotation\Type("SwedbankPaymentPortal\PayPal\CommunicationEntity\SetExpressCheckoutResponse\PayPalTxn")
     */
    private $payPalTxn;
    
    /**
     * A 16 digit unique identifier for the transaction.
     * This reference will be used when submitting QUERY transactions to the Payment Gateway.
     *
     * @var string
     *
     * @Annotation\SerializedName("datacash_reference")
     * @Annotation\Type("string")
     * @Annotation\XmlElement(cdata=false)
     */
    private $dataCashReference;

    /**
     * The unique reference for each transaction which is echoed from the Purchase Request.
     *
     * @var string
     *
     * @Annotation\SerializedName("merchantreference")
     * @Annotation\Type("string")
     * @Annotation\XmlElement(cdata=false)
     */
    private $merchantReference;

    /**
     * Indicates if simulators have been used or a payment provider has been contacted.
     *
     * @var MerchantMode
     *
     * @Annotation\Type("SwedbankPaymentPortal\SharedEntity\Type\MerchantMode")
     */
    private $mode;

    /**
     * A numeric status code.
     *
     * @var PurchaseStatus
     *
     * @Annotation\Type("SwedbankPaymentPortal\SharedEntity\Type\PurchaseStatus")
     */
    private $status;

    /**
     * PurchaseResponse constructor.
     *
     * @param PayPalTxn      $payPalTxn
     * @param string         $merchantReference
     * @param string         $dataCashReference
     * @param MerchantMode   $mode
     * @param string         $reason
     * @param PurchaseStatus $status
     * @param int            $time
     */
    public function __construct(
        PayPalTxn $payPalTxn,
        $merchantReference,
        $dataCashReference,
        MerchantMode $mode,
        $reason,
        PurchaseStatus $status,
        $time
    ) {
        parent::__construct($reason, $time);
        $this->payPalTxn = $payPalTxn;
        $this->merchantReference = $merchantReference;
        $this->dataCashReference = $dataCashReference;
        $this->mode = $mode;
        $this->status = $status;
    }

    /**
     * Version getter.
     *
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Version setter.
     *
     * @param int $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * PayPalTxn getter.
     *
     * @return PayPalTxn
     */
    public function getPayPalTxn()
    {
        return $this->payPalTxn;
    }

    /**
     * PayPalTxn setter.
     *
     * @param PayPalTxn $payPalTxn
     */
    public function setPayPalTxn($payPalTxn)
    {
        $this->payPalTxn = $payPalTxn;
    }

    /**
     * DataCashReference getter.
     *
     * @return int
     */
    public function getDataCashReference()
    {
        return $this->dataCashReference;
    }

    /**
     * DataCashReference setter.
     *
     * @param int $dataCashReference
     */
    public function setDataCashReference($dataCashReference)
    {
        $this->dataCashReference = $dataCashReference;
    }

    /**
     * Mode getter.
     *
     * @return MerchantMode
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Mode setter.
     *
     * @param MerchantMode $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    /**
     * Status getter.
     *
     * @return PurchaseStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Status setter.
     *
     * @param PurchaseStatus $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * MerchantReference getter.
     *
     * @return string
     */
    public function getMerchantReference()
    {
        return $this->merchantReference;
    }

    /**
     * MerchantReference setter.
     *
     * @param string $merchantReference
     */
    public function setMerchantReference($merchantReference)
    {
        $this->merchantReference = $merchantReference;
    }

    /**
     * @return string
     * @throws \RuntimeException
     */
    public function getCustomerRedirectUrl()
    {
        if (!$this->status == PurchaseStatus::accepted()) {
            throw new \RuntimeException("Cannot get Customer redirect URL for Purchase Response   status != 1");
        }

        return sprintf(
            "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=%s",
            $this->getPayPalTxn()->getToken()
        );

    }

}
