<?php

namespace  Tests\BankLink\CommunicationEntity;

use SwedbankPaymentPortal\BankLink\BankLinkContainer as DependencyInjection;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PaymentAttemptRequest\PaymentAttemptRequest;
use SwedbankPaymentPortal\SharedEntity\Authentication;
use SwedbankPaymentPortal\Serializer;
use SwedbankPaymentPortal\SharedEntity\HPSQueryRequest\Transaction;
use Tests\AbstractCommunicationEntityTest;

/**
 * Check if HPS query request is serialized and de-serialized correctly.
 */
class PaymentAttemptRequestTest extends AbstractCommunicationEntityTest
{
    /**
     * Test with purchase object.
     */
    public function testHPSQueryRequest()
    {
        $authentication = new Authentication(123456, '********');
        $transaction = new Transaction(new Transaction\HistoricTxn('3300900010288021'));
        $expectedPARequest = new PaymentAttemptRequest($authentication, $transaction);

        $xml = file_get_contents(__DIR__ . '/../../data/hps_query_request_docs_sample.xml');

        $this->assertEquals($expectedPARequest, $this->serializer->getObject($xml, PaymentAttemptRequest::class));

        $this->assertEquals($xml, $this->serializer->getXml($expectedPARequest));
    }
}
