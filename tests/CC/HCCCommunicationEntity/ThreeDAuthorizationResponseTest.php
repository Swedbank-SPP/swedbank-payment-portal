<?php

namespace  Tests\CC\HCCCommunicationEntity;

use SwedbankPaymentPortal\CC\HCCCommunicationEntity\ThreeDSecureAuthorizationResponse\Cv2Avs;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\ThreeDSecureAuthorizationResponse\MAC;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\ThreeDSecureAuthorizationResponse\Risk;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\ThreeDSecureAuthorizationResponse\ThreeDSecureAuthorizationResponse;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\ThreeDSecureAuthorizationResponse\CardTxn;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\ThreeDSecureAuthorizationResponse\ThreeDSecure;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\SetupRequest\Transaction;
use SwedbankPaymentPortal\CC\Type\AuthorizationStatus;
use SwedbankPaymentPortal\CC\Type\CardholderRegisterStatus;
use SwedbankPaymentPortal\CC\Type\ThreeDAuthorizationStatus;
use SwedbankPaymentPortal\SharedEntity\Type\MerchantMode;
use Tests\AbstractCommunicationEntityTest;

/**
 * Check if authorization response is serialized and de-serialized correctly.
 */
class ThreeDAuthorizationResponseTest extends AbstractCommunicationEntityTest
{
    /**
     * Test with response object.
     */
    public function test3DAuthorizationResponse()
    {
        $cardTxn = new CardTxn(
            new Cv2Avs('SECURITY CODE MATCH ONLY'),
            new ThreeDSecure(
                'AAABBDAkUUYpYUYpZSRQAAAAAAA=',
                CardholderRegisterStatus::enrolled(),
                '2',
                '05',
                'MDAwMDAwMDAwMDAwMTM4MDQ0NzU='
            ),
            'ABCDEF',
            'VISA'
        );
        $risk = new Risk(
            new Risk\ActionResponse(
                new Risk\BankResultResponse(
                    'testcpi1',
                    '00',
                    'Successful',
                    '3000900013804475'
                ),
                new Risk\ScreeningResponse(
                    ['test'],
                    'testcpi2',
                    '00',
                    'Transaction Approved',
                    '3000900013804475'
                )
            )
        );
        $expectedRes = new ThreeDSecureAuthorizationResponse(
            2,
            $cardTxn,
            new MAC('ACCEPT'),
            $risk,
            'Swedbank Baltic Latvia',
            '3000900013804475',
            'Approved, OK',
            '000',
            '3000900013804475',
            '1000000000',
            MerchantMode::live(),
            'ACCEPTED',
            ThreeDAuthorizationStatus::accepted(),
            1462965245
        );

        $xml = file_get_contents(__DIR__ . '/../../data/CC/three_d_authorization_response_sample.xml');

        $this->assertEquals($expectedRes, $this->serializer->getObject($xml, ThreeDSecureAuthorizationResponse::class));

        $this->assertEquals($xml, $this->serializer->getXml($expectedRes));
    }
}
