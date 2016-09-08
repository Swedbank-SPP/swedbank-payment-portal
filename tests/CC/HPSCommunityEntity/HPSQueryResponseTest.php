<?php

namespace  Tests\CC\HPSCommunicationEntity;

use SwedbankPaymentPortal\CC\HPSCommunicationEntity\HPSQueryResponse\AuthAttempt;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\HPSQueryResponse\HPSQueryResponse;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\HPSQueryResponse\HpsTxn;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\HPSQueryResponse\ResponseStatus;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\HPSQueryResponse\RiskResponse\RiskResponse;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\HPSQueryResponse\RiskResponse\ScreeningResponse;
use SwedbankPaymentPortal\SharedEntity\Type\MerchantMode;
use SwedbankPaymentPortal\SharedEntity\Type\PurchaseStatus;
use Tests\AbstractCommunicationEntityTest;

/**
 * Check if HPS query response is serialized and de-serialized correctly.
 */
class HPSQueryResponseTest extends AbstractCommunicationEntityTest
{
    /**
     * Test with purchase object.
     */
    public function testHPSQueryResponse()
    {
        $authAttempts = [
            new AuthAttempt(
                new RiskResponse(new ScreeningResponse('test', '00', 'Transaction Approved')),
                '3400900013805977',
                ResponseStatus::accepted(),
                'ACCEPTED'
            ),
        ];
        $expectedHPSQueryResponse = new HPSQueryResponse(
            2,
            new HpsTxn($authAttempts, '3400900013805977'),
            'SPPtestHPS_1463064393',
            '3600900013805976',
            MerchantMode::live(),
            'You have queried a Full-HPS transaction, where the payment was successfully collected',
            'ACCEPTED',
            PurchaseStatus::accepted(),
            1463064451
        );

        $xml = file_get_contents(__DIR__ . '/../../data/CC/HPS/hps_query_response.xml');

        $this->assertEquals($expectedHPSQueryResponse, $this->serializer->getObject($xml, HPSQueryResponse::class));

        $this->assertEquals($xml, $this->serializer->getXml($expectedHPSQueryResponse));
    }
}
