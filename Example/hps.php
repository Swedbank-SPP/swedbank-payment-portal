<?php

// in autoloader and library needed for HPS payment
include dirname(__FILE__) . '/SwedbankPaymentPortal/vendor/autoload.php';

use SwedbankPaymentPortal\Options\CommunicationOptions;
use SwedbankPaymentPortal\Options\ServiceOptions;
use SwedbankPaymentPortal\SharedEntity\Authentication;
use SwedbankPaymentPortal\SwedbankPaymentPortal;
use SwedbankPaymentPortal\SharedEntity\Amount;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\SetupRequest;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction;
use SwedbankPaymentPortal\CC\Type\ScreeningAction;
use SwedbankPaymentPortal\CC\Type\TransactionChannel;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction\TxnDetails;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction\ThreeDSecure;
use SwedbankPaymentPortal\CC\HPSCommunicationEntity\SetupRequest\Transaction\CardTxn;

include dirname(__FILE__) . '/callback.php';

$auth = new Authentication('**********', '*********'); // VtID and password
// Generating unique merchant reference. To generate merchant reference 
//please use your one logic. This is only example.
$merchantReferenceId = 'ID235r' . strtotime('now');
$purchaseAmount = '4.99'; // Euro and cents needs to be separated by dot.  

$options = new ServiceOptions(
        new CommunicationOptions(
        'https://accreditation.datacash.com/Transaction/acq_a' //this is test environment 
        // for production/live use this URL: https://mars.transaction.datacash.com/Transaction
        ), $auth
);

SwedbankPaymentPortal::init($options);  // <- library  initiation
$spp = SwedbankPaymentPortal::getInstance();  // <- library usage

$riskAction = new Transaction\Action(
        ScreeningAction::preAuthorization(), new Transaction\MerchantConfiguration(
        TransactionChannel::web(), 'http://your-shop' //your shop URL
        ), new Transaction\CustomerDetails(
        new Transaction\BillingDetails(// Customer details
        'Mr', // title
        'Name Surname', // Name and surname
        'Zip0000', // Post code
        'Street address', // address line 1
        '', // address line 2
        'London', // City
        'Unated States' // Country
        ), new Transaction\PersonalDetails(// Personal details
        'Name', // Required, Card holder name
        'Surname', // Required. Card holder surname
        '+3705555555' // Required. Card holder phone
        ), new Transaction\ShippingDetails(// Shipping details
        'Mr', // title
        'Name', // name
        'Surname', // surname
        'Street address', // address line 1
        '', // address line 2
        'City', // City
        'Unated Kingdom', // Country
        'Zip0000' // Post code
        ), new Transaction\RiskDetails(
        '127.15.21.55', // Required. Card holder IP address
        'test@test.lt' // Required. Card holder email
        )
        )
);

$txnDetails = new TxnDetails(
        $riskAction, $merchantReferenceId, new Amount($purchaseAmount), new ThreeDSecure(
        'Order nr: ' . $merchantReferenceId, 'http://your-shop/', new \DateTime()
        )
);

$hpsTxn = new Transaction\HPSTxn(
        'http://your-shop/hps_confirm.php?way=expiry&order_id=' . $merchantReferenceId, // expire url
        'http://your-shop/hps_confirm.php?way=confirmed&order_id=' . $merchantReferenceId, // return url
        'http://your-shop/hps_confirm.php?way=cancelled&order_id=' . $merchantReferenceId, // error url
        164, // Page set ID
        // Firs field to show in card input form Name and Surname field. 
        //Firs parameter goes as string 'show' or null. Second field is url for back button in card input form.
        new Transaction\DynamicData(null, 'http://sppdemoshop.eu/')
);

$transaction = new Transaction($txnDetails, $hpsTxn, new CardTxn());
$setupRequest = new SetupRequest($auth, $transaction);
$response = $spp->getPaymentCardHostedPagesGateway()->initPayment(
        $setupRequest,
        new Swedbank_Ordering_Handler_PaymentCompletedCallback($merchantReferenceId)
);
$url = $response->getCustomerRedirectUrl(); // Getting redirect url
header('Location: ' . $url); // redirecting card holder to card input form.



