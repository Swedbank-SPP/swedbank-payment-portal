<?php

namespace  Tests\BankLink\CommunicationEntity;

use SwedbankPaymentPortal\BankLink\BankLinkContainer as DependencyInjection;
use SwedbankPaymentPortal\SharedEntity\Authentication;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\TransactionQueryRequest\APMTxn;
use SwedbankPaymentPortal\Serializer;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\TransactionQueryRequest\Transaction;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\TransactionQueryRequest\TransactionQueryRequest;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\Type\PaymentMethod;
use Tests\AbstractCommunicationEntityTest;

/**
 * Check if transaction query request is serialized and de-serialized correctly.
 */
class TransactionQueryRequestTest extends AbstractCommunicationEntityTest
{
    /**
     * Test with purchase object.
     */
    public function testTransactionQueryRequest()
    {
        $authentication = new Authentication(123, '********');
        $transaction = new Transaction(new APMTxn(PaymentMethod::swedbank(), 'P_061b8d8'));
        $expectedTXQuery = new TransactionQueryRequest($authentication, $transaction);

        $xml = file_get_contents(__DIR__ . '/../../data/transaction_query_request_docs_sample.xml');

        $this->assertEquals($expectedTXQuery, $this->serializer->getObject($xml, TransactionQueryRequest::class));

        $this->assertEquals($xml, $this->serializer->getXml($expectedTXQuery));
    }
}
