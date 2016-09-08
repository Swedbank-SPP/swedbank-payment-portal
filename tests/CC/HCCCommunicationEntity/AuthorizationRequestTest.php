<?php

namespace  Tests\CC\HCCCommunicationEntity;

use SwedbankPaymentPortal\CC\ATMContainer;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\AuthorizationRequest;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction\Risk;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction\Action;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction\MerchantConfiguration;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction\CustomerDetails;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction\BillingDetails;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction\PersonalDetails;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction\ShippingDetails;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction\RiskDetails;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction\TxnDetails;
use SwedbankPaymentPortal\SharedEntity\Amount;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction\ThreeDSecure;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction\Browser;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction\CardTxn;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationRequest\Transaction\CardDetails;
use SwedbankPaymentPortal\CC\Type\ScreeningAction;
use SwedbankPaymentPortal\CC\Type\TransactionChannel;
use SwedbankPaymentPortal\SharedEntity\Authentication;
use SwedbankPaymentPortal\Serializer;
use Tests\AbstractCommunicationEntityTest;

/**
 * Check if authorization request is serialized and de-serialized correctly.
 */
class AuthorizationRequestTest extends AbstractCommunicationEntityTest
{
    /**
     * Test with authorization object.
     */
    public function testAuthorizationRequest()
    {
        $authentication = new Authentication('********', '********');
        $customerDetails = new CustomerDetails(
            new BillingDetails(
                'District of Columbia',
                'Cardholder Name',
                'DC 20500',
                '2000 Purchase Street',
                '',
                'Washington',
                'US'
            ),
            new PersonalDetails('Cardholder', 'Name', '00 123 456 789'),
            new ShippingDetails(
                'Mr',
                'Cardholder',
                'Name',
                'Landsvagen 40',
                '',
                'Stockholm',
                'SE',
                '105 34'
            ),
            new RiskDetails('8.8.8.8', 'e-mail@email.com')
        );
        $action = new Action(
            ScreeningAction::preAuthorization(),
            new MerchantConfiguration(TransactionChannel::web(), null),
            $customerDetails
        );
        $txnDetails = new TxnDetails(
            $action,
            'OrderNumber001/01',
            new Amount('10.00'),
            new ThreeDSecure(
                'Laptop',
                'http://www.example.com',
                new Browser('0'),
                new \DateTime('2015-10-15 09:00:00')
            )
        );

        $transaction = new Transaction($txnDetails, new CardTxn(new CardDetails('4700204432740764')));
        $expectedAuthRequest = new AuthorizationRequest($authentication, $transaction);

        $xml = file_get_contents(__DIR__ . '/../../data/CC/authorization_request_sample.xml');

        $this->assertEquals($expectedAuthRequest, $this->serializer->getObject($xml, AuthorizationRequest::class));

        $this->assertEquals($xml, $this->serializer->getXml($expectedAuthRequest));
    }
}
