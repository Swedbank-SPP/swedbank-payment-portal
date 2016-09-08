<?php

namespace  Tests\CC\HCCCommunicationEntity;

use SwedbankPaymentPortal\CC\HCCCommunicationEntity\HCCQueryRequest\HCCQueryRequest;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\HCCQueryRequest\Transaction;
use SwedbankPaymentPortal\SharedEntity\Authentication;
use Tests\AbstractCommunicationEntityTest;

/**
 * Check if HPS query request is serialized and de-serialized correctly.
 */
class HCCQueryRequestTest extends AbstractCommunicationEntityTest
{
    /**
     * Test with purchase object.
     */
    public function testHPSQueryRequest()
    {
        $authentication = new Authentication(88120987, 'gDarz27q');
        $transaction = new Transaction(new Transaction\HistoricTxn('3000900013804475'));
        $expectedHCCQueryRequest = new HCCQueryRequest($authentication, $transaction);

        $xml = file_get_contents(__DIR__ . '/../../data/CC/hcc_query_request_sample.xml');

        $this->assertEquals($expectedHCCQueryRequest, $this->serializer->getObject($xml, HCCQueryRequest::class));

        $this->assertEquals($xml, $this->serializer->getXml($expectedHCCQueryRequest));
    }
}
