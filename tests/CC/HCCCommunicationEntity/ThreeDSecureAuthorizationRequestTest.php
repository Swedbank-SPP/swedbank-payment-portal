<?php

namespace  Tests\CC\HCCCommunicationEntity;

use SwedbankPaymentPortal\CC\HCCCommunicationEntity\ThreeDSecureAuthorizationRequest\HistoricTxn;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\ThreeDSecureAuthorizationRequest\ThreeDSecureAuthorizationRequest;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\ThreeDSecureAuthorizationRequest\Transaction;
use SwedbankPaymentPortal\SharedEntity\Authentication;
use Tests\AbstractCommunicationEntityTest;

/**
 * Check if Setup query request is serialized and de-serialized correctly.
 */
class ThreeDSecureAuthorizationRequestTest extends AbstractCommunicationEntityTest
{
    /**
     * Test with setup object.
     */
    public function testThreeDSecureAuthorizationRequest()
    {
        $authentication = new Authentication('********', '********');
        $transaction = new Transaction(
            new HistoricTxn('4600204433138438', '…IZqN7pJXQWuzaaHTq0WCj2tqKjP8GOH5JFBOQ7/3J6')
        );
        $expected3D = new ThreeDSecureAuthorizationRequest($transaction, $authentication);

        $xml = file_get_contents(__DIR__ . '/../../data/CC/three_d_authorization_request_sample.xml');

        $this->assertEquals($expected3D, $this->serializer->getObject($xml, ThreeDSecureAuthorizationRequest::class));

        $this->assertEquals($xml, $this->serializer->getXml($expected3D));
    }
}
