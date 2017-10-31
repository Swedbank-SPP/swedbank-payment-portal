<?php

use SwedbankPaymentPortal\BankLink\CommunicationEntity\HPSQueryResponse\HPSQueryResponse;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\NotificationQuery\ServerNotification;
use SwedbankPaymentPortal\CallbackInterface;
use SwedbankPaymentPortal\CC\PaymentCardTransactionData;
use SwedbankPaymentPortal\SharedEntity\Type\TransactionResult;
use SwedbankPaymentPortal\Transaction\TransactionFrame;

class Swedbank_Ordering_Handler_PaymentCompletedCallback implements CallbackInterface
{

    private $merchantReferenceId;

    public function __construct($merchantReferenceId)
    {
        $this->merchantReferenceId = $merchantReferenceId;
    }

    /**
     * Method for handling finished transaction which ended because of the specified response status.
     *
     * @param TransactionResult         $status
     * @param TransactionFrame          $transactionFrame
     * @param PaymentCardTransactionData $creditCardTransactionData
     */
    public function handleFinishedTransaction(TransactionResult $status, TransactionFrame $transactionFrame, PaymentCardTransactionData $creditCardTransactionData = null)
    {
        if ($status == TransactionResult::success()) {
            // success no you can put flag payment done
        } else if ($status == TransactionResult::failure()) {
            // failure. Do some action here
        } else {
            // unfinished payment
        }
        file_put_contents('information.txt', print_r($status, true).print_r($transactionFrame, true).print_r($creditCardTransactionData, true));
    }

    public function serialize()
    {
        return json_encode(
            [
                'merchantReferenceId' => $this->merchantReferenceId
            ]
        );
    }
                    
    public function unserialize($serialized)
    {
        $data = json_decode($serialized);

        $this->merchantReferenceId = $data->merchantReferenceId;
    }
}