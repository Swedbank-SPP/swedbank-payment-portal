<?php

namespace  Tests\CC\HPSCommunicationEntity;

use SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\SetupRequest;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction\Action;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction\MerchantConfiguration;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction\CustomerDetails;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction\BillingDetails;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction\PersonalDetails;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction\ShippingDetails;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction\RiskDetails;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction\TxnDetails;
use SwedbankPaymentPortal\SharedEntity\Amount;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction\ThreeDSecure;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction\CardTxn;
use SwedbankPaymentPortal\CC\Type\ScreeningAction;
use SwedbankPaymentPortal\CC\Type\TransactionChannel;
use SwedbankPaymentPortal\SharedEntity\Authentication;
use Tests\AbstractCommunicationEntityTest;

/**
 * Check if hps setup request is serialized and de-serialized correctly.
 */
class SetupRequestTest extends AbstractCommunicationEntityTest
{
    /**
     * Test with setup object.
     */
    public function testSetupRequest()
    {
        $authentication = new Authentication(88120987, 'gDarz27q');
        $customerDetails = new CustomerDetails(
            new BillingDetails(
                'testpro',
                'Admin',
                '12345',
                'Backer Street 221b',
                'Backer Street 221c',
                'London',
                'GB'
            ),
            new PersonalDetails('Admin', 'Admins', '123'),
            new ShippingDetails(
                'Mr.',
                'Admin',
                'Admins',
                'Backer Street 221b',
                'Backer Street 221c',
                'London',
                'GB',
                '12345'
            ),
            new RiskDetails('85.206.55.250', 'admin@admin.com')
        );
        $action = new Action(
            ScreeningAction::preAuthorization(),
            new MerchantConfiguration(TransactionChannel::web(), null),
            $customerDetails
        );
        $txnDetails = new TxnDetails(
            $action,
            'SPPtestHPS_1463064393',
            new Amount(1),
            new ThreeDSecure(
                'Invoice nr: Demoshop_1211160054',
                'www.sppshop.eu',
                new \DateTime('2015-12-11 16:01:02')
            )
        );
        $hpsTxn = new Transaction\HPSTxn(
            'expired',
            'https://www.sppshop.eu/spptest/card_auth_result.php',
            'https://www.sppshop.eu/spptest/card_error.php',
            164,
            new Transaction\DynamicData(null, 'https://www.sppshop.eu/spptest/index.php')
        );

        $transaction = new Transaction($txnDetails, $hpsTxn, new CardTxn());
        $expectedAuthRequest = new SetupRequest($authentication, $transaction);

        $xml = file_get_contents(__DIR__ . '/../../data/CC/HPS/setup_request_sample.xml');

        $this->assertEquals($expectedAuthRequest, $this->serializer->getObject($xml, SetupRequest::class));

        $this->assertEquals($xml, $this->serializer->getXml($expectedAuthRequest));
    }
}
