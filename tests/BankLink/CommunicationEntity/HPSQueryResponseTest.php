<?php

namespace  Tests\BankLink\CommunicationEntity;

use SwedbankPaymentPortal\BankLink\CommunicationEntity\HPSQueryResponse\HPSQueryResponse;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\HPSQueryResponse\AuthAttempt;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\HPSQueryResponse\HpsTxn;
use SwedbankPaymentPortal\SharedEntity\Type\MerchantMode;
use SwedbankPaymentPortal\SharedEntity\Type\PurchaseStatus;
use SwedbankPaymentPortal\SharedEntity\Type\ResponseStatus;
use Tests\AbstractCommunicationEntityTest;

/**
 * Check if HPS query response is serialized and de-serialized correctly.
 */
class HPSQueryResponseTest extends AbstractCommunicationEntityTest
{
    /**
     * Test with purchase object.
     */
    public function testHPSQueryResponse()
    {
        $expectedHPSQueryResponse = new HPSQueryResponse(
            new HpsTxn([new AuthAttempt(ResponseStatus::accepted(), 'ACCEPTED', '3700900010241729')]),
            'ordernumber/01',
            '3300900010288021',
            MerchantMode::live(),
            'You have queried a Full-HPS transaction, where at least one payment attempt ' .
            'has been made and the card details are waiting to be collected',
            'ACCEPTED',
            PurchaseStatus::accepted(),
            12345454
        );

        $xml = file_get_contents(__DIR__ . '/../../data/hps_query_response_docs_sample.xml');

        $this->assertEquals($expectedHPSQueryResponse, $this->serializer->getObject($xml, HPSQueryResponse::class));

        $this->assertEquals($xml, $this->serializer->getXml($expectedHPSQueryResponse));
    }
}
