<?php

namespace  Tests\CC\HPSCommunicationEntity;

use SwedbankPaymentPortal\CC\HPSCommunicationEntity\HPSQueryRequest\HPSQueryRequest;
use SwedbankPaymentPortal\SharedEntity\Authentication;
use SwedbankPaymentPortal\SharedEntity\HPSQueryRequest\Transaction;
use Tests\AbstractCommunicationEntityTest;

/**
 * Check if HPS query request is serialized and de-serialized correctly.
 */
class HPSQueryRequestTest extends AbstractCommunicationEntityTest
{
    /**
     * Test with hps query object.
     */
    public function testHPSQueryRequest()
    {
        $authentication = new Authentication(88120987, 'gDarz27q');
        $transaction = new Transaction(new Transaction\HistoricTxn('3600900013805976'));
        $expectedHPSQueryRequest = new HPSQueryRequest($authentication, $transaction);

        $xml = file_get_contents(__DIR__ . '/../../data/CC/HPS/hps_query_request.xml');

        $this->assertEquals($expectedHPSQueryRequest, $this->serializer->getObject($xml, HPSQueryRequest::class));

        $this->assertEquals($xml, $this->serializer->getXml($expectedHPSQueryRequest));
    }
}
