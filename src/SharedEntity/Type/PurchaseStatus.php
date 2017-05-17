<?php

namespace SwedbankPaymentPortal\SharedEntity\Type;

use JMS\Serializer\Annotation;
use JMS\Serializer\Context;
use JMS\Serializer\XmlDeserializationVisitor;
use JMS\Serializer\XmlSerializationVisitor;

/**
 * A numeric status code. A successful Purchase setup is indicated by a status code of 1.
 *
 * Any other code indicates a rejected request or an error.
 */
class PurchaseStatus extends AbstractStatus
{
    /**
     * Successful purchase setup.
     *
     * @return PurchaseStatus
     */
    final public static function accepted()
    {
        return self::get(1);
    }

    /**
     * Authentication error.
     *
     * @return PurchaseStatus
     */
    final public static function authenticationFail()
    {
        return self::get(10);
    }

    /**
     * Duplicate Merchant Reference.
     *
     * @return PurchaseStatus
     */
    final public static function duplicateReference()
    {
        return self::get(20);
    }

    /**
     * Reference already in use
     *
     * @return PurchaseStatus
     */
    final public static function referenceAlreadyInUse()
    {
        return self::get(51);
    }


    /**
     * Invalid request.
     *
     * @return PurchaseStatus
     */
    final public static function invalid()
    {
        return self::get(60);
    }

    /**
     * VERes error response received
     *
     * This return code applies to the 3-D Secure system, when attempting to initiate the 3DS check on a card.
     * This response will be generated if the Directory Server generates a VERes that indicates a problem with the transaction.
     * In most cases, the VERes will contain additional information about the cause of the message. If this is the case,
     * it will be available in the XML Response within the information element.
     *
     * @return PurchaseStatus
     *
     */
    final public static function VEResErrorResponseReceived()
    {
        return self::get(196);
    }

    /**
     * Cannot locate transaction to query.
     *
     * @return PurchaseStatus
     */
    final public static function cannotLocateTransactionToQuery()
    {
        return self::get(274);
    }


    /**
     * PayPal: Not configured for service
     * @return $this
     */
    final public static function notConfiguredForPayPal()
    {
        return self::get(560);
    }


    /**
     * InappropriateData
     *
     * @return PurchaseStatus
     */
    final public static function inappropriateData()
    {
        return self::get(810);
    }

    /**
     * HPS: You have queried a Full-HPS transaction, where the card details are waiting to be collected
     * If this return code is received , your system should wait a few minutes before sending another query transaction
     * to the Payment Gateway (DPG/DataCash Platform).
     * During this time period, the customer may have completed their payment.
     *
     * @return PurchaseStatus
     */
    final public static function awaitingForCustomerCardDetails()
    {
        return self::get(820);
    }

    /**
     * HPS: At least one auth attempted. Awaiting payment details.
     *
     * @return PurchaseStatus
     */
    final public static function waitingForPaymentDetails()
    {
        return self::get(821);
    }


    /**
     * HPS: The maximum number of retry transaction was breached.
     * @return $this
     */
    final public static function HpsMaximumNumberOfRetryTransactionWasBreached()
    {
        return self::get(822);
    }

    /**
     * HPS: You have queried a Full-HPS transaction, where the customer did not complete before the HPS session expired.
     *
     * @return PurchaseStatus
     */
    final public static function HpsSessionTimedOut()
    {
        return self::get(823);
    }

    /**
     * System error
     *
     * @return PurchaseStatus
     */
    final public static function systemError()
    {
        return self::get(10110);
    }

    /**
     * APG: Transaction pending
     * @return $this
     */
    final public static function transactionPending()
    {
        return self::get(2051);
    }


    /**
     * APG: A processing error occurred
     * @return $this
     */
    final public static function processingError()
    {
        return self::get(2052);
    }

    /**
     * APG: Invalid data
     *
     * @return PurchaseStatus
     */
    final public static function invalidData()
    {
        return self::get(2067);
    }

    /**
     * PayPal: Error returned in response
     *
     * @return $this
     */
    final public static function paypalError()
    {
        return self::get(561);
    }

    /**
     * Custom deserialization logic.
     *
     * @Annotation\HandlerCallback("xml", direction = "deserialization")
     *
     * @param XmlDeserializationVisitor $visitor
     * @param null|array                $data
     * @param Context                   $context
     */
    public function deserialize(XmlDeserializationVisitor $visitor, $data, Context $context)
    {
        $this->assignId((int)$data);
    }

    /**
     * Custom serialization logic.
     *
     * @Annotation\HandlerCallback("xml", direction = "serialization")
     *
     * @param XmlSerializationVisitor $visitor
     */
    public function serialize(XmlSerializationVisitor $visitor)
    {
        $visitor->getCurrentNode()->nodeValue = $this->id();
    }
}
