<?php

namespace  Tests\BankLink\CommunicationEntity;

use SwedbankPaymentPortal\BankLink\BankLinkContainer as DependencyInjection;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseResponse\PurchaseResponse;
use SwedbankPaymentPortal\Serializer;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseResponse\HpsTxn;
use SwedbankPaymentPortal\SharedEntity\Type\MerchantMode;
use SwedbankPaymentPortal\SharedEntity\Type\PurchaseStatus;
use Tests\AbstractCommunicationEntityTest;

/**
 * Check if purchase response is de-serialized as expected.
 */
class PurchaseResponseTest extends AbstractCommunicationEntityTest
{
    /**
     * Test with purchase object.
     */
    public function testPurchaseResponse()
    {
        $hpsTxn = new HpsTxn('https://accreditation.datacash.com/hps-acq_a/', '4d02d85a-dd6a-47b3-8da8-a40047c482ec');
        $expectedPurchaseResponse = new PurchaseResponse(
            2,
            $hpsTxn,
            'ordernumber/01',
            '3300900010288021',
            MerchantMode::live(),
            'ACCEPTED',
            PurchaseStatus::accepted()
        );

        $xml = file_get_contents(__DIR__ . '/../../data/purchase_response_docs_sample.xml');

        $this->assertEquals($expectedPurchaseResponse, $this->serializer->getObject($xml, PurchaseResponse::class));

        $this->assertEquals($xml, $this->serializer->getXml($expectedPurchaseResponse));
    }
}
