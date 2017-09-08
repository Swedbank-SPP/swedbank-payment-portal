<?php

namespace  Tests\CC\HCCCommunicationEntity;

use SwedbankPaymentPortal\SharedEntity\Amount;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\SetupRequest\SetupRequest;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\SetupRequest\Transaction;
use SwedbankPaymentPortal\SharedEntity\Authentication;
use Tests\AbstractCommunicationEntityTest;

/**
 * Check if Setup query request is serialized and de-serialized correctly.
 */
class SetupRequestTest extends AbstractCommunicationEntityTest
{
    /**
     * Test with setup object.
     */
    public function testSetupRequest()
    {
        $authentication = new Authentication('********', '********');
        $transaction = new Transaction(
            new Transaction\TxnDetails(new Amount(1), 'SPPTESTHCC_1462531357'),
            new Transaction\HPSTxn(
                'http://www.example.com/expiry.html',
                'https://www.sppshop.eu/spptest/hcc_request.php',
                'https://www.sppshop.eu/spptest/card_error.php',
                164,
                new Transaction\DynamicData(null, 'https://www.sppshop.eu/spptest/index.php')
            )
        );
        $expectedHPSQueryRequest = new SetupRequest($transaction, $authentication);

        $xml = file_get_contents(__DIR__ . '/../../data/CC/setup_request_sample.xml');

        $this->assertEquals($expectedHPSQueryRequest, $this->serializer->getObject($xml, SetupRequest::class));

        $this->assertEquals($xml, $this->serializer->getXml($expectedHPSQueryRequest));
    }
}
