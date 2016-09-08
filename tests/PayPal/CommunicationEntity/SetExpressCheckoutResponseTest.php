<?php

namespace  Tests\PayPal\CommunicationEntity;

use SwedbankPaymentPortal\PayPal\CommunicationEntity\SetExpressCheckoutResponse\PayPalTxn;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\SetExpressCheckoutResponse\SetExpressCheckoutResponse;
use SwedbankPaymentPortal\PayPal\Type\AcknowledgmentStatus;
use SwedbankPaymentPortal\SharedEntity\Type\MerchantMode;
use SwedbankPaymentPortal\SharedEntity\Type\PurchaseStatus;
use Tests\AbstractCommunicationEntityTest;

/**
 * Check if response is serialized and de-serialized correctly.
 */
class SetExpressCheckoutResponseTest extends AbstractCommunicationEntityTest
{
    /**
     * Test with authorization object.
     */
    public function testSetExpressCheckoutResponse()
    {
        $expectedResponse = new SetExpressCheckoutResponse(
            new PayPalTxn(
                AcknowledgmentStatus::success(),
                '18308778',
                '48b47eeeefbca',
                new \DateTime('2016-01-08 10:31:34'),
                'EC-46690288NG459311W',
                '124.0'
            ),
            'SETrequest007',
            '3700900013649551',
            MerchantMode::live(),
            'ACCEPTED',
            PurchaseStatus::accepted(),
            '1452249093'
        );

        $xml = file_get_contents(__DIR__ . '/../../data/PayPal/set_express_checkout_response_docs_sample.xml');

        $this->assertEquals($expectedResponse, $this->serializer->getObject($xml, SetExpressCheckoutResponse::class));

        $this->assertEquals($xml, $this->serializer->getXml($expectedResponse));
    }
}
