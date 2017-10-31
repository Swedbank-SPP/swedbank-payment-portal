<?php

// in autoloader and library needed for banklink payment
include dirname(__FILE__) . '/SwedbankPaymentPortal/vendor/autoload.php';

use SwedbankPaymentPortal\Options\CommunicationOptions;
use SwedbankPaymentPortal\Options\ServiceOptions;
use SwedbankPaymentPortal\SharedEntity\Authentication;
use SwedbankPaymentPortal\SwedbankPaymentPortal;

use SwedbankPaymentPortal\BankLink\PurchaseBuilder;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\Type\PaymentMethod;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\Type\ServiceType;

include dirname(__FILE__) . '/callback.php';

$auth = new Authentication('*******', '********'); // VtID and password
// Generating unique merchant reference. To generate merchant reference 
//please use your one logic. This is only example.
$merchantReferenceId = 'ID235r' . strtotime('now');

$options = new ServiceOptions(
        new CommunicationOptions(
        //'https://accreditation.datacash.com/Transaction/acq_a' //this is test environment 
         'https://mars.transaction.datacash.com/Transaction'
        ), $auth
);

SwedbankPaymentPortal::init($options);  // <- library  initiation
$spp = SwedbankPaymentPortal::getInstance();  // <- library usage


$purchaseAmount = 1; // 0 Eur 01 ct


$purchaseRequest = (new PurchaseBuilder())
    ->setDescription("SPP demoshop Order $merchantReferenceId")
    ->setAmountValue($purchaseAmount)
    ->setAmountExponent(2)
    ->setAmountCurrencyCode(978)// for EUR
    ->setConsumerEmail("customer@email.com")
    /*
ServiceType::swdBank() - SWEDBANK AB (SWEDEN)
ServiceType::nrdSwd() - NORDEA BANK AB (SWEDEN)
ServiceType::sebSwd() - SKANDINAVISKA ENSKILDA BANKEN AB (SWEDEN)
ServiceType::estBank() - SWEDBANK AS (ESTONIA)
ServiceType::sebEst() - SEB AS Pank (ESTONIA)
ServiceType::nrdEst() - Nordea Bank AB Estonia Branch (ESTONIA)
ServiceType::ltvBank() - SWEDBANK AS (LATVIA)
ServiceType::sebLtv() - SEB AS banka (LATVIA)
ServiceType::litBank() - SWEDBANK AB (LITHUANIA)
ServiceType::sebLit() - SEB AB bankas (LITHUANIA)
ServiceType::nrdLit() - NORDEA BANK AB LITHUANIA BRANCH (LITHUANIA)
*/        
    ->setServiceType(ServiceType::litBank())
/*
PaymentMethod::swedbank() - SWEDBANK AB (SWEDEN)
PaymentMethod::nordea() - NORDEA BANK AB (SWEDEN)
PaymentMethod::svenska() - SVENSKA HANDELSBANKEN AB (SWEDEN)
PaymentMethod::seb() - SKANDINAVISKA ENSKILDA BANKEN AB (SWEDEN)
PaymentMethod::swedbank() - SWEDBANK AS (ESTONIA)
PaymentMethod::seb() - SEB AS Pank (ESTONIA)
PaymentMethod::nordea() - Nordea Bank AB Estonia Branch (ESTONIA)
PaymentMethod::swedbank() - SWEDBANK AS (LATVIA)
PaymentMethod::seb() - SEB AS banka (LATVIA)
PaymentMethod::citadele() - AS CITADELE BANKA (LATVIA)
PaymentMethod::swedbank() - SWEDBANK AB (LITHUANIA)
PaymentMethod::seb() - SEB AB bankas (LITHUANIA)
PaymentMethod::dnb() - AB DNB BANKAS (LITHUANIA)
PaymentMethod::nordea() - NORDEA BANK AB LITHUANIA BRANCH (LITHUANIA)
PaymentMethod::danske() - DANSKE BANK AS LITHUANIA BRANCH (LITHUANIA)
*/
    ->setPaymentMethod(PaymentMethod::swedbank())
    ->setSuccessUrl('http://your-daomaim/banklink_confirm.php?way=confirmed&order_id=' . $merchantReferenceId) // see chapter “Success / Failure URL Handling” for more info
    ->setFailureUrl('http://your-domain/banklink_confirm.php?way=cancelled&order_id=' . $merchantReferenceId)
    ->setMerchantReference($merchantReferenceId)
    ->setLanguage("lv")
    ->setPageSetId(1) // Always 1
    ->getPurchaseRequest();

    $response = $spp->getBankLinkGateway()->initPayment(
        $purchaseRequest,
        new Swedbank_Ordering_Handler_PaymentCompletedCallback(
            $merchantReferenceId
        )
    );

$url = $response->getCustomerRedirectUrl(); // Getting redirect url
header('Location: ' . $url); // redirecting card holder to card input form.



