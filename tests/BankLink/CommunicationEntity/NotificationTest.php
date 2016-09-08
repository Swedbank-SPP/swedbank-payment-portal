<?php

namespace  Tests\BankLink\CommunicationEntity;

use SwedbankPaymentPortal\BankLink\BankLinkContainer as DependencyInjection;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\NotificationQuery\Event;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\NotificationQuery\MerchantNotificationResponse;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\NotificationQuery\ServerNotification;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PaymentAttemptResponse\QueryTxnResult\Amount;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PaymentAttemptResponse\QueryTxnResult\Method;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PaymentAttemptResponse\QueryTxnResult\Purchase;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PaymentAttemptResponse\QueryTxnResult\RiskResult;
use SwedbankPaymentPortal\Serializer;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\Type\PaymentMethod;
use SwedbankPaymentPortal\SharedEntity\Type\ResponseStatus;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\Type\ServiceType;
use Tests\AbstractCommunicationEntityTest;

/**
 * Check if purchase response is de-serialized as expected.
 */
class NotificationTest extends AbstractCommunicationEntityTest
{
    /**
     * Test with merchant notification response object.
     */
    public function testMerchantNotificationResponse()
    {
        $expectedMNR = new MerchantNotificationResponse();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" .
        '<Response>OK</Response>' . "\n";

        $this->assertEquals($expectedMNR, $this->serializer->getObject($xml, MerchantNotificationResponse::class));

        $this->assertEquals($xml, $this->serializer->getXml($expectedMNR));
    }

    /**
     * Test with purchase object.
     */
    public function testServerNotification()
    {
        $methodExtraData = [
            'VK_LANG' => 'ENG',
            'VK_MSG' => 'Message from Processor',
            'VK_REC_ACC' => '12345678',
            'VK_REC_NAME' => 'TEST MERCHANT',
            'VK_SND_ACC' => '12345678',
            'VK_SND_ID' => '1234',
            'VK_SND_NAME' => 'TEST CLIENT',
            'VK_T_DATE' => '15.11.2013',
        ];

        $purchase = new Purchase(
            new Method(PaymentMethod::swedbank(), 56235634, 1101, 'APPROVED', ServiceType::ltvBank(), $methodExtraData),
            new RiskResult(100, 'No Risk'),
            '239389',
            'ordernumber/01',
            new Amount(500, 2, 978),
            'transaction…',
            ResponseStatus::accepted()
        );
        $notification = new ServerNotification('2.0', '10001', new Event($purchase));

        $xml = file_get_contents(__DIR__ . '/../../data/event_response_sample.xml');

        $this->assertEquals($notification, $this->serializer->getObject($xml, ServerNotification::class));
    }
}
