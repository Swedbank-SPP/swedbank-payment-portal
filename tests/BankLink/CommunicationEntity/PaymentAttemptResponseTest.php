<?php

namespace  Tests\BankLink\CommunicationEntity;

use SwedbankPaymentPortal\BankLink\BankLinkContainer as DependencyInjection;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\HPSQueryRequest\Transaction;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PaymentAttemptResponse\PaymentAttemptResponse;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PaymentAttemptResponse\QueryTxnResult;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PaymentAttemptResponse\QueryTxnResult\APMTxn;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PaymentAttemptResponse\QueryTxnResult\Purchase;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PaymentAttemptResponse\QueryTxnResult\Amount;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PaymentAttemptResponse\QueryTxnResult\RiskResult;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PaymentAttemptResponse\QueryTxnResult\Method;
use SwedbankPaymentPortal\Serializer;
use SwedbankPaymentPortal\SharedEntity\Type\MerchantMode;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\Type\PaymentMethod;
use SwedbankPaymentPortal\SharedEntity\Type\PurchaseStatus;
use SwedbankPaymentPortal\SharedEntity\Type\ResponseStatus;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\Type\ServiceType;
use Tests\AbstractCommunicationEntityTest;

/**
 * Check if HPS query request is serialized and de-serialized correctly.
 */
class PaymentAttemptResponseTest extends AbstractCommunicationEntityTest
{
    /**
     * Test with purchase object.
     */
    public function testPaymentAttemptResponse()
    {
        $methodExtraData = [
            'VK_LANG' => 'ENG',
            'VK_MSG' => 'Test LIT',
            'VK_REC_ACC' => 'LT10000000000000001',
            'VK_REC_NAME' => 'SWEDBANK, AB',
            'VK_SND_ACC' => 'LT20000000000000002',
            'VK_SND_ID' => 'HP',
            'VK_SND_NAME' => 'John Doe',
            'VK_T_DATE' => '27.04.2015',
        ];
        $purchase = new Purchase(
            new Method(PaymentMethod::swedbank(), 392, 1101, 'APPROVED', ServiceType::litBank(), $methodExtraData),
            new RiskResult(100, 'No Risk'),
            '244580',
            'ordernumber/01',
            new Amount(1, 2, 978),
            'Your transaction has been processed successfully.',
            ResponseStatus::accepted()
        );
        $queryTxn = new QueryTxnResult(
            new APMTxn('10001', $purchase),
            '3700900010241729',
            'ordernumber/01',
            'ACCEPTED',
            PurchaseStatus::accepted(),
            new \DateTime('2015-04-27 12:51:15')
        );
        $expectedPAResponse = new PaymentAttemptResponse(
            $queryTxn,
            MerchantMode::live(),
            'ACCEPTED',
            PurchaseStatus::accepted(),
            1437055617
        );
        $xml = file_get_contents(__DIR__ . '/../../data/hps_payment_attemp_response_docs_sample.xml');

        $this->assertEquals($expectedPAResponse, $this->serializer->getObject($xml, PaymentAttemptResponse::class));
        $this->assertEquals($xml, $this->serializer->getXml($expectedPAResponse));
    }
}
