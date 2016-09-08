<?php

namespace  Tests\PayPal\CommunicationEntity;

use SwedbankPaymentPortal\PayPal\CommunicationEntity\DoExpressCheckoutPaymentResponse\DoExpressCheckoutPaymentResponse;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\DoExpressCheckoutPaymentResponse\PayPalTxn;
use SwedbankPaymentPortal\PayPal\Type\AcknowledgmentStatus;
use SwedbankPaymentPortal\PayPal\Type\PaymentStatus;
use SwedbankPaymentPortal\SharedEntity\Type\MerchantMode;
use SwedbankPaymentPortal\SharedEntity\Type\PurchaseStatus;
use Tests\AbstractCommunicationEntityTest;

/**
 * Check if response is serialized and de-serialized correctly.
 */
class DoExpressCheckoutResponseTest extends AbstractCommunicationEntityTest
{
    /**
     * Test with response object.
     */
    public function testDoExpressCheckoutResponse()
    {
        $payPalTn = new PayPalTxn(
            AcknowledgmentStatus::success(),
            '10.00',
            '18308778',
            'd675c542912e3',
            'EUR',
            '0',
            'false',
            new \DateTime('2016-01-08 10:35:36'),
            PaymentStatus::pending(),
            'instant',
            'multicurrency',
            'Eligible',
            'ItemNotReceivedEligible,UnauthorizedPaymentEligible',
            'None',
            'ZSB25R5CXNMJY',
            'false',
            'false',
            '0.00',
            new \DateTime('2016-01-08 10:35:36'),
            'EC-46690288NG459311W',
            '3MS18119XY756351N',
            'expresscheckout',
            '124.0'
        );
        $expected = new DoExpressCheckoutPaymentResponse(
            $payPalTn,
            'DoExpress007',
            '3100900013649568',
            MerchantMode::live(),
            'ACCEPTED',
            PurchaseStatus::accepted(),
            '1452249333'
        );

        $xml = file_get_contents(__DIR__ . '/../../data/PayPal/do_express_checkout_payment_response_docs_sample.xml');

        $this->assertEquals($expected, $this->serializer->getObject($xml, DoExpressCheckoutPaymentResponse::class));

        $this->assertEquals($xml, $this->serializer->getXml($expected));
    }
}
