<?php

namespace  Tests\BankLink\CommunicationEntity;

use SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\PurchaseRequest;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\Transaction\APMTxn\AlternativePayment\TransactionDetails\PersonalDetails;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\Transaction\APMTxn\AlternativePayment\TransactionDetails\BillingDetails;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\Transaction\APMTxn\AlternativePayment\TransactionDetails;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\Transaction\APMTxn\AlternativePayment\MethodDetails;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\Transaction\APMTxn\AlternativePayment;
use SwedbankPaymentPortal\SharedEntity\Transaction\TxnDetails;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\Transaction\APMTxn;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\Transaction\HPSTxn;
use SwedbankPaymentPortal\SharedEntity\Authentication;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\Transaction;
use SwedbankPaymentPortal\BankLink\BankLinkContainer as DependencyInjection;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\Type\PaymentMethod;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\Type\ServiceType;
use SwedbankPaymentPortal\Serializer;
use Tests\AbstractCommunicationEntityTest;

/**
 * Checks if stuff is serialized as expected.
 */
class SerializerTest extends AbstractCommunicationEntityTest
{
    /**
     * Test with purchase object.
     */
    public function testPurchase()
    {
        $billingDetails = new BillingDetails(new BillingDetails\AmountDetails(100, 2, 978));
        $personalDetails = new PersonalDetails('test@example.com');

        $transactionDetails = new TransactionDetails(
            'description',
            'https://www.redirect.com/TestSite/Success.aspx',
            'https://www.redirect.com/TestSite/Failure.aspx',
            'en',
            $personalDetails,
            $billingDetails
        );
        $methodDetails = new MethodDetails(ServiceType::litBank());
        $alternativePayment = new AlternativePayment($transactionDetails, $methodDetails);

        $apmTransaction = new APMTxn(PaymentMethod::swedbank(), $alternativePayment);
        $hpsTransaction = new HPSTxn();
        $txnDetails = new TxnDetails('ordernumber/01');

        $transaction = new Transaction($txnDetails, $hpsTransaction, $apmTransaction);
        $authentication = new Authentication(123, '********');
        $purchase = new PurchaseRequest($transaction, $authentication);

        $expectedXML = file_get_contents(__DIR__ . '/../../data/purchase_docs_sample.xml');

        $this->assertEquals($expectedXML, $this->serializer->getXml($purchase));

        $this->assertEquals($purchase, $this->serializer->getObject($expectedXML, PurchaseRequest::class));
    }
}
