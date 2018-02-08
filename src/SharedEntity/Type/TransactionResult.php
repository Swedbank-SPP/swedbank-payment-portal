<?php

namespace SwedbankPaymentPortal\SharedEntity\Type;

/**
 * Marks transaction result for callback.
 */
class TransactionResult extends AbstractEnumerableType
{
    /**
     * Successful transaction.
     *
     * @return TransactionResult
     */
    final public static function success()
    {
        return self::get('SUCCESS');
    }

    /**
     * Failed transaction.
     *
     * @return TransactionResult
     */
    final public static function failure()
    {
        return self::get('FAIL');
    }

    /**
     * Unfinished transaction.
     *
     * @return TransactionResult
     */
    final public static function unfinished()
    {
        return self::get('UNFINISHED');
    }
    
    /**
     * Requires Investigation transaction.
     *
     * @return TransactionResult
     */
    final public static function requiresInvestigation()
    {
        return self::get('REQUIRESINVESTIGATION');
    }
}
