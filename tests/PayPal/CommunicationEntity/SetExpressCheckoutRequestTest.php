<?php

namespace  Tests\PayPal\CommunicationEntity;

use SwedbankPaymentPortal\PayPal\CommunicationEntity\SetExpressCheckoutRequest\SetExpressCheckoutRequest;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\SetExpressCheckoutRequest\Transaction;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\ShippingAddress;
use SwedbankPaymentPortal\PayPal\Type\PayPalBool;
use SwedbankPaymentPortal\SharedEntity\Amount;
use SwedbankPaymentPortal\Serializer;
use SwedbankPaymentPortal\SharedEntity\Authentication;
use Tests\AbstractCommunicationEntityTest;

/**
 * Check if authorization request is serialized and de-serialized correctly.
 */
class SetExpressCheckoutRequestTest extends AbstractCommunicationEntityTest
{
    /**
     * Test with authorization object.
     */
    public function testSetExpressCheckoutRequest()
    {
        $authentication = new Authentication('88120987', 'gDarz27q');
        $payPalTxn = new Transaction\PayPalTxn(
            new ShippingAddress(
                'San Jose',
                'US',
                'Test User',
                '95131',
                'CA',
                '1 Main St'
            ),
            'ABCQWH',
            'PayPal test payment',
            'customer@customer.com',
            'InvoiceNr:1464179342',
            'US',
            '10.00',
            PayPalBool::false(),
            PayPalBool::false(),
            PayPalBool::false(),
            'https://www.sppshop.eu/spptest/card_auth_result_pp.php',
            'https://www.sppshop.eu/spptest/card_auth_result_pp.php'
        );
        $txnDetails = new Transaction\TxnDetails(new Amount('0.10'), 'SPPtestPayPal_1464179342');
        $transaction = new Transaction($txnDetails, $payPalTxn);
        $expectedRequest = new SetExpressCheckoutRequest($transaction, $authentication);

        $xml = file_get_contents(__DIR__ . '/../../data/PayPal/set_express_checkout_request_docs_sample.xml');

        $this->assertEquals($expectedRequest, $this->serializer->getObject($xml, SetExpressCheckoutRequest::class));

        $this->assertEquals($xml, $this->serializer->getXml($expectedRequest));
    }
}
