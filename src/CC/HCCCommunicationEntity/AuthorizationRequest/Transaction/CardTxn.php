<?php

namespace SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction;

use Jms\Serializer\Annotation;

/**
 * The container for the details pertaining to the card transaction.
 *
 * @Annotation\AccessType("public_method")
 */
class CardTxn
{
    /**
     * @const Default method value.
     */
    const METHOD_DEFAULT = 'auth';

    /**
     * Indicates which transaction type is to be used.
     *
     * AUTH indicates that the transaction is to be authorized using the one stage processing model and will be marked
     * for settlement automatically by the gateway.
     *
     * @var string
     *
     * @Annotation\XmlElement(cdata=false)
     * @Annotation\Type("string")
     */
    private $method = self::METHOD_DEFAULT;

    /**
     * The container for the HPS (hosted page) details.
     *
     * @var CardDetails
     *
     * @Annotation\SerializedName("card_details")
     * @Annotation\Type("SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction\CardDetails")
     */
    private $cardDetails;

    /**
     * CardTxn constructor.
     *
     * @param CardDetails $cardDetails
     * @param string      $method
     */
    public function __construct(CardDetails $cardDetails, $method = self::METHOD_DEFAULT)
    {
        $this->method = $method;
        $this->cardDetails = $cardDetails;
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
     * CardDetails getter.
     *
     * @return CardDetails
     */
    public function getCardDetails()
    {
        return $this->cardDetails;
    }

    /**
     * CardDetails setter.
     *
     * @param CardDetails $cardDetails
     */
    public function setCardDetails($cardDetails)
    {
        $this->cardDetails = $cardDetails;
    }
}
