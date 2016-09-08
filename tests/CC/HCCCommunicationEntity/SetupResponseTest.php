<?php

namespace  Tests\CC\HCCCommunicationEntity;

use SwedbankPaymentPortal\CC\HCCCommunicationEntity\SetupRequest\Transaction;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\SetupResponse\HpsTxn;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\SetupResponse\SetupResponse;
use SwedbankPaymentPortal\SharedEntity\Type\MerchantMode;
use SwedbankPaymentPortal\SharedEntity\Type\PurchaseStatus;
use Tests\AbstractCommunicationEntityTest;

/**
 * Check if Setup query response is serialized and de-serialized correctly.
 */
class SetupResponseTest extends AbstractCommunicationEntityTest
{
    /**
     * Test with setup object.
     */
    public function testSetupRequest()
    {
        $hpsTxn = new HpsTxn('https://accreditation.datacash.com/hps-acq_a/', '838a3964-8931-4bd1-baf4-35d7f504faaa');
        $expectedPurchaseResponse = new SetupResponse(
            $hpsTxn,
            'OrderNumber001/01',
            '4700204432740764',
            MerchantMode::live(),
            'ACCEPTED',
            PurchaseStatus::accepted(),
            1434617190
        );

        $xml = file_get_contents(__DIR__ . '/../../data/CC/setup_response_sample.xml');

        $this->assertEquals($expectedPurchaseResponse, $this->serializer->getObject($xml, SetupResponse::class));

        $this->assertEquals($xml, $this->serializer->getXml($expectedPurchaseResponse));
    }
}
