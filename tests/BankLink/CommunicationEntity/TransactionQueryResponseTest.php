<?php

namespace  Tests\BankLink\CommunicationEntity;

use SwedbankPaymentPortal\BankLink\BankLinkContainer as DependencyInjection;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\HPSQueryRequest\Transaction;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PaymentAttemptResponse\QueryTxnResult;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PaymentAttemptResponse\QueryTxnResult\APMTxn;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PaymentAttemptResponse\QueryTxnResult\Purchase;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PaymentAttemptResponse\QueryTxnResult\Amount;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PaymentAttemptResponse\QueryTxnResult\RiskResult;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PaymentAttemptResponse\QueryTxnResult\Method;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\TransactionQueryResponse\TransactionQueryResponse;
use SwedbankPaymentPortal\SharedEntity\Type\MerchantMode;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\Type\PaymentMethod;
use SwedbankPaymentPortal\SharedEntity\Type\ResponseStatus;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\Type\ServiceType;
use SwedbankPaymentPortal\Serializer;
use Tests\AbstractCommunicationEntityTest;

/**
 * Check if HPS query request is serialized and de-serialized correctly.
 */
class TransactionQueryResponseTest extends AbstractCommunicationEntityTest
{
    /**
     * Test with transaction query object.
     */
    public function testTransactionQueryResponse()
    {
        $purchase = new Purchase(
            new Method(PaymentMethod::swedbank(), 1364, 1101, 'APPROVED', ServiceType::ltvBank(), []),
            new RiskResult(100, 'No Risk'),
            '318240',
            'D_1446323968',
            new Amount(1, 2, 978),
            'Your transaction has been processed successfully.',
            ResponseStatus::accepted()
        );
        $expectedTQResponse = new TransactionQueryResponse(
            new APMTxn('DATACASH', $purchase),
            '3300900013503310',
            'DLINK1446323968',
            'ACCEPTED',
            ResponseStatus::accepted(),
            MerchantMode::live(),
            new \DateTime('2015-11-21 11:36:20')
        );
        $xml = file_get_contents(__DIR__ . '/../../data/transaction_query_response_docs_sample.xml');

        $this->assertEquals($expectedTQResponse, $this->serializer->getObject($xml, TransactionQueryResponse::class));
        $this->assertEquals($xml, $this->serializer->getXml($expectedTQResponse));
    }

    /**
     * Test with cancelled transaction object.
     */
    public function testTransactionQueryCancelledResponse()
    {
        $purchase = new Purchase(
            new Method(PaymentMethod::swedbank(), '', null, null, null, []),
            new RiskResult(100, 'No Risk'),
            '1935419',
            'A9_88888',
            new Amount(500, 2, 978),
            '',
            ResponseStatus::cancelled()
        );
        $expectedTQResponse = new TransactionQueryResponse(
            new APMTxn('BL_W3O4IUZ', $purchase),
            '3000900010000498',
            'A9_88888',
            'Transaction was cancelled',
            ResponseStatus::cancelled(),
            MerchantMode::live(),
            new \DateTime('2015-11-21 11:36:20')
        );
        $xml = file_get_contents(__DIR__ . '/../../data/transaction_query_response_docs_cancelled_sample.xml');

        $this->assertEquals($expectedTQResponse, $this->serializer->getObject($xml, TransactionQueryResponse::class));
    }
}
