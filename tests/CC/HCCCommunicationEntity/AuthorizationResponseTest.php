<?php

namespace  Tests\CC\HCCCommunicationEntity;

use SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationResponse\AuthorizationResponse;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationResponse\CardTxn;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\AuthorizationResponse\ThreeDSecure;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\SetupRequest\Transaction;
use SwedbankPaymentPortal\CC\Type\AuthorizationStatus;
use SwedbankPaymentPortal\SharedEntity\Type\MerchantMode;
use Tests\AbstractCommunicationEntityTest;

/**
 * Check if authorization response is serialized and de-serialized correctly.
 */
class AuthorizationResponseTest extends AbstractCommunicationEntityTest
{
    /**
     * Test with response object.
     */
    public function testAuthorizationResponse()
    {
        $cardTxn = new CardTxn(
            new ThreeDSecure(
                'https://accreditation.datacash.com/acs-acq_a',
                'bla'
            ),
            'VISA',
            'E95316CD5E381C5032C9B77B90EC4F90F77C88AE'
        );
        $expectedAuthResponse = new AuthorizationResponse(
            2,
            'Swedbank Baltic Latvia',
            '3600900013801799',
            'SPPtestHCC_1462778604',
            '1000000000',
            MerchantMode::live(),
            '3DS Payer Verification Required',
            AuthorizationStatus::secureAuthenticationRequired(),
            1462778649,
            $cardTxn
        );

        $xml = file_get_contents(__DIR__ . '/../../data/CC/authorization_response_sample.xml');

        $this->assertEquals($expectedAuthResponse, $this->serializer->getObject($xml, AuthorizationResponse::class));

        $this->assertEquals($xml, $this->serializer->getXml($expectedAuthResponse));
    }
}
