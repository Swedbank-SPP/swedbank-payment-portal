<?php

namespace SwedbankPaymentPortal\SharedEntity\Type;

/**
 * Specifies what kind of query is this communication.
 */
class TransportType extends AbstractEnumerableType
{
    /**
     * Setup (SetupRequest and SetupResponse).
     *
     * @return TransportType
     */
    final public static function setup()
    {
        return self::get('setup');
    }

    /**
     * HPS query (HPSQueryRequest and HPSQueryResponse).
     *
     * @return TransportType
     */
    final public static function hpsQuery()
    {
        return self::get('hps');
    }
    
    /**
     * HPS cancel (HPSCancelRequest and HPSCancelResponse).
     *
     * @return TransportType
     */
    final public static function hpsCancel()
    {
        return self::get('cancel');
    }
    
    /**
     * HPS refund (HPSRefundRequest and HPSRefundResponse).
     *
     * @return TransportType
     */
    final public static function hpsRefund()
    {
        return self::get('refund');
    }
    
    /**
     * Payment (PaymentAttemptRequest and PaymentAttemptResponse).
     *
     * @return TransportType
     */
    final public static function paymentAttempt()
    {
        return self::get('payment');
    }

    /**
     * TransactionQuery (TransactionQueryRequest and TransactionQueryResponse).
     *
     * @return TransportType
     */
    final public static function transactionQuery()
    {
        return self::get('transaction');
    }

    /**
     * Purchase (PurchaseRequest and PurchaseResponse).
     *
     * @return TransportType
     */
    final public static function purchase()
    {
        return self::get('purchase');
    }

    /**
     * Notification (NotificationQuery).
     *
     * @return TransportType
     */
    final public static function notification()
    {
        return self::get('notification');
    }

    /**
     * Authorization (AuthorizationRequest and AuthorizationResponse).
     *
     * @return TransportType
     */
    final public static function authorization()
    {
        return self::get('authorization');
    }

    /**
     * Authorization (ThreeDSecureAuthorizationRequest and ThreeDSecureAuthorizationResponse).
     *
     * @return TransportType
     */
    final public static function threeDauthorization()
    {
        return self::get('3dauthorization');
    }

    /**
     * Authorization (ThreeDSecureAuthorizationRequest and ThreeDSecureAuthorizationResponse).
     *
     * @return TransportType
     */
    final public static function hccQueryRequest()
    {
        return self::get('hccQueryRequest');
    }

    /**
     * Details request (GetExpressCheckoutDetailsRequest and GetExpressCheckoutDetailsResponse).
     *
     * @return TransportType
     */
    final public static function expressDetailsRequest()
    {
        return self::get('details');
    }
}
