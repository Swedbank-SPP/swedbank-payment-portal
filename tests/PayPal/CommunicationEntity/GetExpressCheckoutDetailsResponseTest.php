<?php

namespace  Tests\PayPal\CommunicationEntity;

use SwedbankPaymentPortal\PayPal\CommunicationEntity\GetExpressCheckoutDetailsResponse\BillingAddress;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\GetExpressCheckoutDetailsResponse\GetExpressCheckoutDetailsResponse;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\GetExpressCheckoutDetailsResponse\PayPalTxn;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\ShippingAddress;
use SwedbankPaymentPortal\PayPal\Type\AcknowledgmentStatus;
use SwedbankPaymentPortal\PayPal\Type\AddressStatus;
use SwedbankPaymentPortal\PayPal\Type\PayerStatus;
use SwedbankPaymentPortal\PayPal\Type\PayPalBool;
use SwedbankPaymentPortal\SharedEntity\Type\MerchantMode;
use SwedbankPaymentPortal\SharedEntity\Type\PurchaseStatus;
use Tests\AbstractCommunicationEntityTest;

/**
 * Check if response is serialized and de-serialized correctly.
 */
class GetExpressCheckoutDetailsResponseTest extends AbstractCommunicationEntityTest
{
    /**
     * Test with authorization object.
     */
    public function testSetExpressCheckoutResponse()
    {
        $payPalTn = new PayPalTxn(
            new BillingAddress(AddressStatus::confirmed()),
            new ShippingAddress(
                'San Jose',
                'US',
                'Test User',
                '95131',
                'CA',
                '1 Main St'
            ),
            AcknowledgmentStatus::success(),
            AddressStatus::confirmed(),
            'None',
            10.0,
            PayPalBool::false(),
            '18308778',
            null,
            'PaymentActionNotInitiated',
            '92fef4b58bec2',
            'GB',
            'GBP',
            'UPS_ID432555',
            'CD',
            'sir_gibbs@hotmail.com',
            '0',
            'Shaun',
            0.0,
            0.0,
            'false',
            'abc5681234',
            null,
            'Smith',
            'BBEXK7Q7JBASG',
            PayerStatus::verified(),
            null,
            0.0,
            0.0,
            'United States',
            0.0,
            new \DateTime('2016-01-08 10:34:24'),
            'EC-46690288NG459311W',
            '124.0'
        );
        $expected = new GetExpressCheckoutDetailsResponse(
            $payPalTn,
            'Getrequest007',
            '3200900013649558',
            MerchantMode::live(),
            'ACCEPTED',
            PurchaseStatus::accepted(),
            '1452249263'
        );

        $xml = file_get_contents(__DIR__ . '/../../data/PayPal/get_express_checkout_details_response_docs_sample.xml');

        $this->assertEquals($expected, $this->serializer->getObject($xml, GetExpressCheckoutDetailsResponse::class));

        $this->assertEquals($xml, $this->serializer->getXml($expected));
    }
}
