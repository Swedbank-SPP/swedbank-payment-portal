<?php

namespace  Tests\PayPal\CommunicationEntity;

use SwedbankPaymentPortal\PayPal\CommunicationEntity\DoExpressCheckoutPaymentRequest\DoExpressCheckoutPaymentRequest;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\DoExpressCheckoutPaymentRequest\Transaction;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\ShippingAddress;
use SwedbankPaymentPortal\SharedEntity\Amount;
use SwedbankPaymentPortal\Serializer;
use SwedbankPaymentPortal\SharedEntity\Authentication;
use Tests\AbstractCommunicationEntityTest;

/**
 * Check if authorization request is serialized and de-serialized correctly.
 */
class DoExpressCheckoutRequestTest extends AbstractCommunicationEntityTest
{
    /**
     * Test with authorization object.
     */
    public function testDoExpressCheckoutRequest()
    {
        $authentication = new Authentication('*******', '***');
        $payPalTxn = new Transaction\PayPalTxn(
            new ShippingAddress(
                'San Jose',
                'US',
                'Test User',
                '95131',
                'CA',
                '1 Main St',
                'Hose'
            ),
            '3700900013649551'
        );
        $txnDetails = new Transaction\TxnDetails(new Amount('10.00'), 'Do Express 007');
        $transaction = new Transaction($txnDetails, $payPalTxn);
        $expected = new DoExpressCheckoutPaymentRequest($transaction, $authentication);

        $xml = file_get_contents(__DIR__ . '/../../data/PayPal/do_express_checkout_payment_request_docs_sample.xml');

        $this->assertEquals($expected, $this->serializer->getObject($xml, DoExpressCheckoutPaymentRequest::class));

        $this->assertEquals($xml, $this->serializer->getXml($expected));
    }
}
