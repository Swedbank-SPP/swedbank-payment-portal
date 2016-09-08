<?php

namespace  Tests\CC\HCCCommunicationEntity;

use SwedbankPaymentPortal\CC\HCCCommunicationEntity\HCCQueryResponse\Card;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\HCCQueryResponse\Cv2Avs;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\HCCQueryResponse\HCCQueryResponse;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\HCCQueryResponse\MAC;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\HCCQueryResponse\QueryTxnResult;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\HCCQueryResponse\Risk;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\HCCQueryResponse\ThreeDSecure;
use SwedbankPaymentPortal\CC\HCCCommunicationEntity\SetupRequest\Transaction;
use SwedbankPaymentPortal\CC\Type\AuthorizationStatus;
use SwedbankPaymentPortal\CC\Type\CardholderRegisterStatus;
use SwedbankPaymentPortal\CC\Type\ThreeDAuthorizationStatus;
use SwedbankPaymentPortal\SharedEntity\Type\MerchantMode;
use Tests\AbstractCommunicationEntityTest;

/**
 * Check if hcc query response is serialized and de-serialized correctly.
 */
class HCCQueryResponseTest extends AbstractCommunicationEntityTest
{
    /**
     * Test with response object.
     */
    public function testHCCQueryResponse()
    {
        $queryTxnResult = new QueryTxnResult(
            new Card(
                new Cv2Avs('SECURITY CODE MATCH ONLY'),
                'Unknown',
                '01/17',
                'Unknown',
                '444433******1111',
                'VISA',
                'E95316CD5E381C5032C9B77B90EC4F90F77C88AE'
            ),
            new MAC('ACCEPT'),
            new ThreeDSecure(
                'AAABBDAkUUYpYUYpZSRQAAAAAAA=',
                'MDAwMDAwMDAwMDAwMTM4MDQ0NzU=',
                CardholderRegisterStatus::enrolled(),
                '05'
            ),
            'Swedbank Baltic Latvia',
            'ABCDEF',
            '3000900013804475',
            'ecomm',
            new \DateTime('2016-05-11 12:13:59'),
            1462965239,
            'SPPtestHCC_1462965207',
            'ACCEPTED',
            'Settled',
            ThreeDAuthorizationStatus::accepted(),
            new \DateTime('2016-05-11 12:13:59'),
            1462965239
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
        $expectedRes = new HCCQueryResponse(
            2,
            $queryTxnResult,
            $risk,
            MerchantMode::live(),
            'ACCEPTED',
            ThreeDAuthorizationStatus::accepted(),
            1462965255
        );

        $xml = file_get_contents(__DIR__ . '/../../data/CC/hcc_query_response_sample.xml');

        $this->assertEquals($expectedRes, $this->serializer->getObject($xml, HCCQueryResponse::class));

        $this->assertEquals($xml, $this->serializer->getXml($expectedRes));
    }
}
