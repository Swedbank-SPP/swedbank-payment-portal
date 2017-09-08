<?php

namespace SwedbankPaymentPortal\CC;


class Validator
{
    /**
     * @param string $merchantReference
     * @throws \RuntimeException
     */
    public static function merchantReferenceMustBeValid($merchantReference)
    {
        if (strlen($merchantReference) < 6) {
            throw new \RuntimeException(
                "Payment Cards merchantReference must be min 6 characters. Given: {$merchantReference}, chars: " .
                strlen($merchantReference)
            );
        }

        if (strlen($merchantReference) > 30) {
            throw new \RuntimeException(
                "Payment Cards merchantReference must be max 30 characters. Given: {$merchantReference}, chars: " .
                strlen($merchantReference)
            );
        }

        if (!preg_match('/^[ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789 _\-\/]+$/', $merchantReference)) {
            throw new \RuntimeException(
                "Payment Cards merchantReference must contain only characters: ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789 _-/. Given: {$merchantReference}"
            );
        }
    }
}