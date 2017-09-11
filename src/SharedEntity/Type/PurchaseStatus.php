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
     * Invalid Merchant reference:
     * Rules:
     * min 6 characters
     * max 30 characters
     * Allowed characters (including the space): ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789 _-/
     * Shorter numbers should be padded out with leading zeros to fit these length restrictions, if required.
     * @return PurchaseStatus
     */
    final public static function invalidMerchantReference()
    {
        return self::get(22);
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
     * Bank Card 3-D Secure Service: 3DS Expired Awaiting Authorization
     *
     * @return PurchaseStatus
     */
    final public static function ExpiredAwaitingAuthorization()
    {
        return self::get(184);
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
     * PayPal: Invalid reference
     * @return $this
     */
    final public static function payPalInvalidReference()
    {
        return self::get(565);
    }

    /**
     * PayPal: Customer login pending
     * @return $this
     */
    final public static function customerLoginPending()
    {
        return self::get(571);
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
     * HPS: You have queried a Full-HPS transaction, where the customer has been sent for ACS validation
     *
     * @return PurchaseStatus
     */
    final public static function HpsQueringTransactionWHereCustomerBeenSentForAcsValidation()
    {
        return self::get(824);
    }


    /**
     * HPS: You have queried a Full-HPS transaction, where the transaction is awaiting authorization
     *
     * @return PurchaseStatus
     */
    final public static function HpsAwaitingAuthorization()
    {
        return self::get(828);
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
     * APG: Transaction has been redirected by APM
     * @return $this
     */
    final public static function transactionBeingRedirected()
    {
        return self::get(2053);
    }

    /**
     * APG: Transaction cancelled
     * @return $this
     */
    final public static function transactionCancelled()
    {
        return self::get(2054);
    }

    /**
     * APG: Transaction was rejected by the fraud gateway
     * @return $this
     */
    final public static function transactionWasRejectedByTheFraudGateway()
    {
        return self::get(2055);
    }

    /**
     * APG: Transaction sent for capture
     * @return $this
     */
    final public static function transactionSentForCapture()
    {
        return self::get(2056);
    }

    /**
     * APG: Transaction sent for refund
     * @return $this
     */
    final public static function transactionSentForRefund()
    {
        return self::get(2057);
    }

    /**
     * APG: Transaction refunded
     * @return $this
     */
    final public static function transactionRefunded()
    {
        return self::get(2058);
    }

    /**
     * APG: Transaction cannot be found on APM gateway
     * @return $this
     */
    final public static function transactionCannotBeFoundOnAPMGateway()
    {
        return self::get(2059);
    }

    /**
     * APG: Requested information supplied
     * @return $this
     */
    final public static function requestedInformationSupplied()
    {
        return self::get(2060);
    }

    /**
     * APG: Unable to parse APG response
     * @return $this
     */
    final public static function unableToParseApgResponse()
    {
        return self::get(2061);
    }

    /**
     * APG: Comms error
     * @return $this
     */
    final public static function commsError()
    {
        return self::get(2062);
    }

    /**
     * APG: No connection tickets available
     * @return $this
     */
    final public static function noConnectionTicketsAvailable()
    {
        return self::get(2063);
    }

    /**
     * APG: vTid not subscribed
     * @return $this
     */
    final public static function vTidNotSubscribed()
    {
        return self::get(2064);
    }

    /**
     * APG: Unknown APG DPG Reference ID provided
     * @return $this
     */
    final public static function unknownApgDpgReferenceIdProvided()
    {
        return self::get(2065);
    }

    /**
     * APG: Missing mandatory data
     * @return $this
     */
    final public static function missingMandatoryData()
    {
        return self::get(2066);
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
