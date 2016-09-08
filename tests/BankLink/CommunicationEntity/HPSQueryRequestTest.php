<?php

namespace  Tests\BankLink\CommunicationEntity;

use SwedbankPaymentPortal\BankLink\CommunicationEntity\HPSQueryRequest\HPSQueryRequest;
use SwedbankPaymentPortal\SharedEntity\Authentication;
use SwedbankPaymentPortal\SharedEntity\HPSQueryRequest\Transaction;
use Tests\AbstractCommunicationEntityTest;

/**
 * Check if HPS query request is serialized and de-serialized correctly.
 */
class HPSQueryRequestTest extends AbstractCommunicationEntityTest
{
    /**
     * Test with purchase object.
     */
    public function testHPSQueryRequest()
    {
        $authentication = new Authentication(123456, '********');
        $transaction = new Transaction(new Transaction\HistoricTxn('3300900010288021'));
        $expectedHPSQueryRequest = new HPSQueryRequest($authentication, $transaction);

        $xml = file_get_contents(__DIR__ . '/../../data/hps_query_request_docs_sample.xml');

        $this->assertEquals($expectedHPSQueryRequest, $this->serializer->getObject($xml, HPSQueryRequest::class));

        $this->assertEquals($xml, $this->serializer->getXml($expectedHPSQueryRequest));
    }
}
