<?php

namespace SwedbankPaymentPortal\BankLink\CommunicationEntity\TransactionQueryRequest;

use SwedbankPaymentPortal\BankLink\CommunicationEntity\TransactionQueryRequest\APMTxn\AlternativePayment;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\Type\PaymentMethod;
use JMS\Serializer\Annotation;

/**
 * The container for the APM transaction.
 *
 * @Annotation\AccessType("public_method")
 */
class APMTxn
{
    /**
     * The transaction type. The value purchase should be sent through in this field.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     */
    private $method = 'transaction_query';

    /**
     * @var PaymentMethod
     *
     * @Annotation\Type("SwedbankPaymentPortal\BankLink\CommunicationEntity\Type\PaymentMethod")
     */
    private $paymentMethod;

    /**
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\SerializedName("transaction_type")
     * @Annotation\Type("string")
     */
    private $transactionType = 'purchase';

    /**
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\SerializedName("transaction_id")
     * @Annotation\Type("string")
     */
    private $transactionId;

    /**
     * @var AlternativePayment
     *
     * @Annotation\SerializedName("AlternativePayment")
     * @Annotation\Type("SwedbankPaymentPortal\BankLink\CommunicationEntity\TransactionQueryRequest\APMTxn\AlternativePayment")
     */
    private $alternativePayment;

    /**
     * APMTxn constructor.
     *
     * @param PaymentMethod $paymentMethod
     * @param string        $transactionId
     */
    public function __construct(PaymentMethod $paymentMethod, $transactionId)
    {
        $this->paymentMethod = $paymentMethod;
        $this->transactionId = $transactionId;
        $this->alternativePayment = new AlternativePayment();
    }

    /**
     * AlternativePayment getter.
     *
     * @return AlternativePayment
     */
    public function getAlternativePayment()
    {
        return $this->alternativePayment;
    }

    /**
     * AlternativePayment setter.
     *
     * @param AlternativePayment $alternativePayment
     */
    public function setAlternativePayment($alternativePayment)
    {
        $this->alternativePayment = $alternativePayment;
    }

    /**
     * Method getter.
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Method setter.
     *
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * PaymentMethod getter.
     *
     * @return PaymentMethod
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * PaymentMethod setter.
     *
     * @param PaymentMethod $paymentMethod
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * TransactionType getter.
     *
     * @return string
     */
    public function getTransactionType()
    {
        return $this->transactionType;
    }

    /**
     * TransactionType setter.
     *
     * @param string $transactionType
     */
    public function setTransactionType($transactionType)
    {
        $this->transactionType = $transactionType;
    }

    /**
     * TransactionId getter.
     *
     * @return string
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * TransactionId setter.
     *
     * @param string $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
    }
}
