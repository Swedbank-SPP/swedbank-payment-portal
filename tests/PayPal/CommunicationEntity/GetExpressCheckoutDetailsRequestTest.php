<?php

namespace  Tests\PayPal\CommunicationEntity;

use SwedbankPaymentPortal\PayPal\CommunicationEntity\GetExpressCheckoutDetailsRequest\GetExpressCheckoutDetailsRequest;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\GetExpressCheckoutDetailsRequest\Transaction;
use SwedbankPaymentPortal\SharedEntity\Authentication;
use Tests\AbstractCommunicationEntityTest;

/**
 * Check if authorization request is serialized and de-serialized correctly.
 */
class GetExpressCheckoutDetailsRequestTest extends AbstractCommunicationEntityTest
{
    /**
     * Test with authorization object.
     */
    public function testSetExpressCheckoutRequest()
    {
        $authentication = new Authentication('*******', '***');
        $payPalTxn = new Transaction\PayPalTxn('3700900013649551');
        $txnDetails = new Transaction\TxnDetails('Get request 007');
        $transaction = new Transaction($txnDetails, $payPalTxn);
        $expected = new GetExpressCheckoutDetailsRequest($transaction, $authentication);

        $xml = file_get_contents(__DIR__ . '/../../data/PayPal/get_express_checkout_details_request_docs_sample.xml');

        $this->assertEquals($expected, $this->serializer->getObject($xml, GetExpressCheckoutDetailsRequest::class));

        $this->assertEquals($xml, $this->serializer->getXml($expected));
    }
}
