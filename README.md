# Swedbank Payment Portal
## About 

Swedbank developed and maintaining API library to help and speed up merchant integrations in to e-shop.

## Benefit to merchant

Usually Swedbank Payment Portal integration is done using technical specification (API documentation). Developers need to analyse it, prepare specific software architecture, logic to send and receive payment request messages towards Swedbank Payment Portal. By having library developer can **save lot of development time** and just reuse code and logic already created by us. This greatly speed up integration process on Merchant side and of course **substantially saving the integration costs**.

This library supports Swedbank payment types:

+ Cards integration type HPS;
+ Cards integration type HCC (with 3D-secure);
+ Cards integration type HCC (without 3D-secure);
+ Banklinks;
+ PayPal Express Checkout;

## Requirements

Minimum PHP version required 5.4 and above. 

## Installation Instruction

### Projects with composer installed

This is recommended way of installation. Add dependency in your `composer.json`:
```json
"require": {
    "swedbank-spp/swedbank-payment-portal": "^0.8"
}
```
and rum "composer update" in command prompt or shell.

Alternative you can execute "composer require swedbank-spp/swedbank-payment-portal" from your command prompt or shell.

### Projects which doesn\`t have composer installed

+ First download composer to your project root folder ( https://getcomposer.org/composer.phar )
+ Run command: php composer.phar init
+ Press Enter until command completes ("composer.json" file will be created)
+ Open "composer.json" and replace "require": {} with: 
```json
"require": {
    "swedbank-spp/swedbank-payment-portal": "^0.8"
 }
```
+ Run command: php composer.phar update  (after success "vendor" folder will be created)
+ In your project index.php please include php line require_once(\_\_DIR\_\_.'/vendor/autoload.php'); that way you’ll register composer default autoloader to your project.
+ Done. From now you can use Swedbank Payment Portal library.


## Integration

### Credentials

To be able to test Swedbank payment system you will need to get credentials for development and production environment. Only to test is enouth test credentials.

### Banklink integration

Here is a sequence diagram which illustrates full banklink process. You can see that for Banklink integration you’ll need to call only three methods in a library “initPayment()”, “handlePendingTransaction()” and “checkPendingTransactions()”.

![alt tag](https://github.com/Swedbank-SPP/swedbank-payment-portal/raw/master/ignore/diagram_4.png)

#### Notification

Notification is used by banks to inform merchants about transaction statuses. 
Event notifications are communicated via a POST to a pre-configured merchant event URL. This URL must be different from the success and failure URL’s specified in the purchase setup requests. Multiple event notification URL’s can be configured on your Payment Gateway account, should the merchant require these messages to be delivered to a number of locations. The format of these event notifications is XML.
Upon successful delivery of an event notification to an event URL, the merchant application must acknowledge receipt of such notification with an OK post back response to the Payment Gateway.
The event notification mechanism is utilised to notify merchants of payment event statuses throughout the lifecycle of a transaction. For Banklink purchase transactions, the following event notifications could be delivered: AUTHORISED, REQUIRES_INVESTIGATION, CANCELLED.
When a merchant receives the above event notifications, they are expected to respond with the following XML:
<Response>OK</Response>
In the event that the Payment Gateway does not receive a confirmation of receipt, the gateway will retry multiple times to send the notification.
Using SPP library you need to call BankLinkService.handleNotification($xmlData) method to handle notification. “handleNotification” will parse XML and updates appropriate transaction status in the system. Also callback which was given in “initPayment” will be called if transaction resolves.
Security note: Notification URL must be known and be accessible only from SPP server IP address. Configure your server to deny all other requests to that URL.

Usage example:
```php
function someControllerAction() {  // this method must be called whenever Notification URL is accessed.
      $xml = file_get_contents("php://input"); // POST raw data
      try {
          $spp->getBankLinkGateway()->handleNotification($xm);
      } catch (\Exception $e) {
          // here log any exceptions if occurs, because if you will not respond
          // with “<Response>OK</Response>” SPP will repeatedly submit notifications.
      }
      echo "<Response>OK</Response>";
}
```

### Payment Card (HPS) integration

Payment Card HPS integration is the same as Banklink.

![alt tag](https://github.com/Swedbank-SPP/swedbank-payment-portal/raw/master/ignore/diagram_5.png)

### Payment Card (HCC) integration

![alt tag](https://github.com/Swedbank-SPP/swedbank-payment-portal/raw/master/ignore/diagram_6.png)

### PayPal integration (Express Checkout)

PayPal integration is also the same as HPS and banklink.

![alt tag](https://github.com/Swedbank-SPP/swedbank-payment-portal/raw/master/ignore/diagram_7.png)

## Cron job operations

System should call “checkPendingTransactions” operation on each minute. This will trigger status checking of transactions which are in PENDING state.
Status checking operation time for each transaction is not related to cron job calling interval. Each transaction is queried in 30 minutes intervals. These settings can be changed in a library.
One exception is for Banklink payment of Nordea: The first status querying of Nordea transaction is done only after 1 minute when user hits success URL, and later querying (if needed) after 30 minutes.
These pending transaction checking is done only for Banklink and Payment Card HPS pending transactions as these transactions in some circumstances cannot be directly resolved (e.g. user didn’t get redirected to success url due internet problems).

## Testing

Test transactions can be performed by using the test data in this section to process test transactions. The response received from the Payment Gateway will depend on the card number used. The responses are simulated and are intended to allow testing of common scenarios when processing Credit and Debit cards.  

It is recommended that the following scenarios are tested as a minimum:
+ Successful Authorisation including 3-D Secure authentication with different amounts
+ Unsuccessful Authorisation
+ Failed 3-D Secure authentication
Each merchant must ensure the interaction between the Payment Gateway and their own e-commerce system is behaving as expected.

Below are card numbers that are behaving on a predefined way. They are an excellent help when integrating and in testing/debugging of various scenarios.

Please note – magic cards are provided for Accreditation only and NOT intended for use in the Production Environment.

### MasterCard Test Data

Test Card Number | Return Code | Description | Sample Message
--- | --- | --- | ---
5573470000000001 | 1 | Authorised with random auth code | AUTH CODE
5573470000000027 | 14 | Test Server Response | Payment Gateway Busy Please Retry
5573470000000035 | 440 | Test Server Response | Payment Gateway Busy
5573470000000050 | 661 | Test Server Response | Unknown Error
5573470000000068 | 653 | Test Server Response | Failure at Bank

### Maestro Test Data

Test Card Number | Return Code | Description | Sample Message
--- | --- | --- | ---
5001630100011248 | 1 | Authorised with random auth code | AUTH CODE
5001630100011255 | 7 | Test Server Response | DECLINED
5001630100011263 | 7 | Test Server Response | DECLINED

### Visa Test Data

Test Card Number | Return Code | Description | Sample Message
--- | --- | --- | ---
4929498311405001 | 1 | Authorised with random auth code | AUTH CODE
4978056100000019 | 7 | Decline the transaction | DECLINED

### Test Data for 3-D Secure

Any of the magic card numbers can be used while integrating 3-D Secure. The response will be determined first by the 3-D Secure configuration on your account, and then by the expiry month of the test card number.

In order to generate specific responses, please use the  card expiry **month** shown below:

Test card expiry  month | Test system response
--- | ---
01 | Card is enrolled
02 | Card is not enrolled
03 | No result received from the directory server
04 | 3DS Invalid VERes from DS - Failed to parse VERes
05 | 3DS Invalid VERes from DS - invalid protocol value 'SET' 
06 | 3DS invalid VEReq
07 | Unable to verify
08 | Card is enrolled
any other value | Unable to verify

All library is under “SwedbankPaymentPortal” namespace. Main entry point for a library is “SwedbankPaymentPortal” class.

Here is a short example how to initialize a library:

```php
use SwedbankPaymentPortal\Options\CommunicationOptions;
use SwedbankPaymentPortal\Options\ServiceOptions;
use SwedbankPaymentPortal\SharedEntity\Authentication;
use SwedbankPaymentPortal\SwedbankPaymentPortal;

$options = new ServiceOptions(
    new CommunicationOptions('https://accreditation.datacash.com/Transaction/acq_a'),
    new Authentication( 'login', 'password' )
);

$spp = new SwedbankPaymentPortal($options);
```

After that you can retrieve all payment services which are needed.

Next step is to retrieve your needed payment service by calling one of a methods of “SwedbankPaymentPortal” object.

Example:

```php
$paypal   = $spp->getPayPalGateway();
$banklink = $spp->getBankLinkGateway();
$hps      = $spp->getPaymentCardHostedPagesGateway();
$hcc      = $spp->getPaymentCardHostedCardCaptureGateway();
```

Whatever service you’ll retrieve all services contains a method “initPayment” which is a main payment initialization point.

**Update:**

To help other which projects do not have any dependency containers we’ve added couple static methods in a library which helps for global library initialization.

```php
SwedbankPaymentPortal::init(ServiceOptions $options); // you must call this once to initialize library
$spp = SwedbankPaymentPortal::getInstance();  // method will return an object of SwedbankPaymentPortal.
```

Please use these methods if your system do not have any dependency container to simplify process.

# Success / Failure URL Handling

Whatever payment method you’ll use there is a need to specify success/failure URL for each “initPayment” call.

Success or Failure URL should be your custom page with appropriate message to user. Swedbank Payment Portal will redirect a customer to that URL in case of success or failure of purchase operation.
Swedbank Payment Portal library is using additional server to server verification of success or failure of operation so you must call one of methods which finalizes a payment inside a library:

```php
$spp->getBankLinkGateway()->handlePendingTransaction($orderId);
 $spp->getPayPalGateway()->handlePendingTransaction($orderId);
 $spp->getPaymentCardHostedPagesGateway()->hpsQuery($orderId);
 $spp->getPaymentCardHostedCardCaptureGateway()->hccQuery($orderId);
```
(please look at sequence diagrams above to see what library methods must be called on each step)

Finalization will trigger a callbacks which you’ve been given in “initPayment” method calls.

So, to fully complete a transaction you must know what payment method was used and what is an order ID of that payment and that information must be included in your success/failure URL.
E.g:  http://yoururl.com/success.html?payment=banklink&orderid={order_id}

> Warning: entering to success URL doesn’t mean that purchase was 100% completed. Never do any order completion logic inside success url action! That logic must go in Callbacks.

# Callback setup

The main idea is that purchase process is fully asynchronous and you’ll be notified some time in future by callback method which you’ve had given during payment initialization(“initPayment”). Here is a short description about what is a callback.

Callback is an object which has implemented CallbackInterface. CallbackInterface contains one method

```php
public function handleFinishedTransaction(
   TransactionResult $transactionResult,
   TransactionFrame $transactionFrame,
   PaymentCardTransactionData $paymentCardTransactionData = null
);
```

and it will be called when transaction resolves (success or failure).

$transactionResult can be one of these values  TransactionResult::success(), TransactionResult::failure(), TransactionResult::unfinished().

$transactionFrame - contains a request and a response of a last request which determined success/failure.

$paymentCardTransactionData - contains payment card information (expiry date, pan, authorization code). This parameter is optional and will be available only on HPS or HCC payment methods.

Because transactions is asynchronous that callback will be called some time in future on the different process so callback must be a PHP serializable object and must implement  serialize() and unserialize() methods.

When a library calls a “handleFinishedTransaction” it will unserialize a callback to it’s previous state (time when had called “initPayment”).

If you need some additional information inside “handleFinishedTransaction” call the best way is to pass that information in callback constructor and implement serialize which persists that data.

For example it can be invoice id, order id, user id and other information which is required for your operations after transaction completion.

**Update:**

We have included default implementation of CallbackInterface called \`**UrlCallback**\` which now on you can use as Callback in “initPayment” (for all payment methods).

Example:

```php
$spp->getBankLinkGateway()->initPayment(
    $purchaseRequest,
    UrlCallback::create(“http://yourdomain.com/some_secret_complete_handler?order_id={$orderId}”)
);
```

UrlCallback will call the given url using HTTP POST operation, with these POST fields:
“status” one of these: SUCCESS or FAIL or UNFINISHED.

# E-Receipt for Payment Card transactions

After payment card transaction completion the third argument of “handleFinishedTransaction” method will be set. Third argument will contain object of PaymentCardTransactionData.

“PaymentCardTransactionData” consists of:
+ pan
+ expiryDate
+ authorzationCode
+ merchantReference
+ fulfillDate

This information must be included in e-receipt which must be generated after purchase using payment cards.

# Banklink payments

Here is a table of available banks and what serviceType and paymentMethod you need to specify in purchase request:

**Bank** | **serviceType** | **paymentMethod**
 --- | --- | ---
 SWEDBANK AB (SWEDEN) | ServiceType::swdBank() | PaymentMethod::swedbank()
 NORDEA BANK AB (SWEDEN) | ServiceType::nrdSwd() | PaymentMethod::nordea()
 SVENSKA HANDELSBANKEN AB (SWEDEN) | ServiceType::undefined() | PaymentMethod::svenska()
 SKANDINAVISKA ENSKILDA BANKEN AB (SWEDEN) | ServiceType::sebSwd() | PaymentMethod::seb()
 SWEDBANK AS (ESTONIA) | ServiceType::estBank() | PaymentMethod::swedbank()
 SEB AS Pank (ESTONIA) | ServiceType::sebEst() | PaymentMethod::seb()
 Nordea Bank AB Estonia Branch (ESTONIA) | ServiceType::nrdEst() | PaymentMethod::nordea()
 SWEDBANK AS (LATVIA) | ServiceType::ltvBank() | PaymentMethod::swedbank()
 SEB AS banka (LATVIA) | ServiceType::sebLtv() | PaymentMethod::seb()
 AS CITADELE BANKA (LATVIA) | ServiceType::undefined() | PaymentMethod::citadele()
 SWEDBANK AB (LITHUANIA) | ServiceType::litBank() | PaymentMethod::swedbank()
 SEB AB bankas (LITHUANIA) | ServiceType::sebLit() | PaymentMethod::seb()
 AB DNB BANKAS (LITHUANIA) | ServiceType::undefined() | PaymentMethod::dnb()
 NORDEA BANK AB LITHUANIA BRANCH (LITHUANIA) | ServiceType::nrdLit() | PaymentMethod::nordea()
 DANSKE BANK AS LITHUANIA BRANCH (LITHUANIA) | ServiceType::undefined() | PaymentMethod::danske()
 
 Example how to initiate banklink payment:
 
 ```php
 $purchaseAmount = 1500; // 15 Eur 00 ct
$merchantReferenceId = "Invoice01234";

$purchaseRequest = (new PurchaseBuilder())
    ->setDescription("SPP demoshop Order $merchantReferenceId")
    ->setAmountValue($purchaseAmount)
    ->setAmountExponent(2)
    ->setAmountCurrencyCode(978)// for EUR
    ->setConsumerEmail("customer@email.com")
    ->setServiceType(ServiceType::swdBank())
    ->setPaymentMethod(PaymentMethod::swedbank())
    ->setSuccessUrl("SPP") // see chapter “Success / Failure URL Handling” for more info
    ->setFailureUrl("SPP")
    ->setMerchantReference($merchantReferenceId)
    ->setLanguage("lt")
    ->setPageSetId(1)
    ->getPurchaseRequest();

    $response = $spp->getBankLinkGateway()->initPayment(
        $purchaseRequest,
        new PaymentCompletedCallback(
            $orderId,
            $merchantReferenceId
        )
    );
 ```
 
 # HPS Example using calback
 
 Replace sppdemoshop.eu to your shop address.
 
 **callback.php**
 This is example of callback. Callback function need be available in setup call and final process.
 ```php
use SwedbankPaymentPortal\BankLink\CommunicationEntity\HPSQueryResponse\HPSQueryResponse;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\NotificationQuery\ServerNotification;
use SwedbankPaymentPortal\CallbackInterface;
use SwedbankPaymentPortal\CC\PaymentCardTransactionData;
use SwedbankPaymentPortal\SharedEntity\Type\TransactionResult;
use SwedbankPaymentPortal\Transaction\TransactionFrame;

class Swedbank_Ordering_Handler_PaymentCompletedCallback implements CallbackInterface
{

    private $merchantReferenceId;

    public function __construct($merchantReferenceId)
    {
        $this->merchantReferenceId = $merchantReferenceId;
    }

    /**
     * Method for handling finished transaction which ended because of the specified response status.
     *
     * @param TransactionResult         $status
     * @param TransactionFrame          $transactionFrame
     * @param PaymentCardTransactionData $creditCardTransactionData
     */
    public function handleFinishedTransaction(TransactionResult $status, 
         TransactionFrame $transactionFrame, 
         PaymentCardTransactionData $creditCardTransactionData = null)
    {
        if ($status == TransactionResult::success()) {
            // success no you can put flag payment done
        } else if ($status == TransactionResult::failure()) {
            // failure. Do some action here
        } else {
            // unfinished payment
        }
	// This is only for debug. You can log into file if needed.
        mail('YourEmail@domain.lt', 
	    'DONE', print_r($status, true).print_r($transactionFrame, true).print_r($creditCardTransactionData, true)); 
	    
    }

    public function serialize()
    {
        return json_encode(
            [
                'merchantReferenceId' => $this->merchantReferenceId
            ]
        );
    }
                    
    public function unserialize($serialized)
    {
        $data = json_decode($serialized);

        $this->merchantReferenceId = $data->merchantReferenceId;
    }
}
 ```
 
 **hps.php**
 This is setup script
 ```php
 // in autoloader and library needed for HPS payment
include dirname(__FILE__) . '/../SwedbankPaymentPortal/vendor/autoload.php';

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

$auth = new Authentication('*********', '*********'); // VtID and password
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
        TransactionChannel::web(), 'http://sppdemoshop.eu' //your shop URL
        ), new Transaction\CustomerDetails(
        new Transaction\BillingDetails(// Customer details
        'Mr', // title
        'Name Surname', // Name and surname
        'Zip0000', // Post code
        'Street address', // address line 1
        '', // address line 2
        'London', // City
        'UK' // Country
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
        'UK', // Country
        'Zip0000' // Post code
        ), new Transaction\RiskDetails(
        '127.15.21.55', // Required. Card holder IP address
        'test@test.lt' // Required. Card holder email
        )
        )
);

$txnDetails = new TxnDetails(
        $riskAction, $merchantReferenceId, new Amount($purchaseAmount), new ThreeDSecure(
        'Order nr: ' . $merchantReferenceId, 'http://sppdemoshop.eu/', new \DateTime()
        )
);

$hpsTxn = new Transaction\HPSTxn(
        'http://sppdemoshop.eu/test/hps_confirm.php?way=expiry&order_id=' . $merchantReferenceId, // expire url
        'http://sppdemoshop.eu/test/hps_confirm.php?way=confirmed&order_id=' . $merchantReferenceId, // return url
        'http://sppdemoshop.eu/test/hps_confirm.php?way=cancelled&order_id=' . $merchantReferenceId, // error url
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
 ```
 
**hps\_confirm.php**
This is final payment process

```php
namespace SwedbankPaymentPortal;

include dirname(__FILE__).'/../SwedbankPaymentPortal/vendor/autoload.php';

use SwedbankPaymentPortal\Options\CommunicationOptions;
use SwedbankPaymentPortal\Options\ServiceOptions;
use SwedbankPaymentPortal\SharedEntity\Authentication;
use SwedbankPaymentPortal\SwedbankPaymentPortal;

include dirname(__FILE__) . '/callback.php';


$orderId = $_GET['order_id'];
$way  = $_GET['way'];

if ($way == 'confirmed'){
  $auth = new Authentication('*********','***********');
  $options = new ServiceOptions(
      new CommunicationOptions(
        'https://accreditation.datacash.com/Transaction/acq_a' //this is test environment 
		// for production/live use this URL: https://mars.transaction.datacash.com/Transaction
      ),
   $auth
  );
  SwedbankPaymentPortal::init($options);  // <- library  initiation
  $spp = SwedbankPaymentPortal::getInstance();  // <- library usage

  $rez = $spp->getPaymentCardHostedPagesGateway()->handlePendingTransaction($orderId); 
  // now you can show user "thank you for your payment, but don't put flag 
  //flag need to put inside callback
  
  echo 'Thank you';
} else if ($way == 'expiry'){
	echo 'Session expired';
	// do same logic if seesion expired
} else { // cancelled
	echo 'Payment cancelled';
	// do some action for cancel logic
}
```

 # HPS Example using UrlCalback
 
 Replace sppdemoshop.eu to your shop address. Use this only if you can't use above example.
 
 **hps\_url\_calback\_hps.php**
 ```php
namespace SwedbankPaymentPortal;
// in autoloader and library needed for HPS payment
include dirname(__FILE__).'/SwedbankPaymentPortal/vendor/autoload.php'; 

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


$auth = new Authentication('8*****','********'); // VtID and password
// Generating unique merchant reference. To generate merchant reference 
//please use your one logic. This is only example.
$merchantReferenceId = 'ID235r'.strtotime('now'); 
$purchaseAmount = '4.99'; // Euro and cents needs to be separated by dot.  

$options = new ServiceOptions(
    new CommunicationOptions(
        'https://accreditation.datacash.com/Transaction/acq_a' //this is test environment 
		// for production/live use this URL: https://mars.transaction.datacash.com/Transaction
    ),
   $auth
);

SwedbankPaymentPortal::init($options);  // <- library  initiation
$spp = SwedbankPaymentPortal::getInstance();  // <- library usage

$riskAction = new Transaction\Action(
    ScreeningAction::preAuthorization(),
    new Transaction\MerchantConfiguration(
        TransactionChannel::web(),
        'http://sppdemoshop.eu' //your shop URL
    ),
    new Transaction\CustomerDetails( 
        new Transaction\BillingDetails( // Customer details
            'Mr', // title
            'Name Surname', // Name and surname
            'Zip0000', // Post code
            'Street address', // address line 1
            '', // address line 2
            'London', // City
            'UK' // Country
        ),
        new Transaction\PersonalDetails( // Personal details
            'Name', // Required, Card holder name
            'Surname', // Required. Card holder surname
            '+3705555555' // Required. Card holder phone
        ),

        new Transaction\ShippingDetails( // Shipping details
            'Mr', // title
            'Name', // name
            'Surname', // surname
            'Street address', // address line 1
            '', // address line 2
            'City', // City
            'UK', // Country
            'Zip0000' // Post code
        ),

        new Transaction\RiskDetails( 
            '127.15.21.55', // Required. Card holder IP address
            'test@test.lt' // Required. Card holder email
        )
    )
);

$txnDetails = new TxnDetails(
    $riskAction,
    $merchantReferenceId,
    new Amount($purchaseAmount),
    new ThreeDSecure(
        'Order nr: ' . $merchantReferenceId,
        'http://sppdemoshop.eu/',
        new \DateTime()
    )
);
	 
$hpsTxn = new Transaction\HPSTxn(
    'http://sppdemoshop.eu/confirm.php?way=expiry&order_id='.$merchantReferenceId, // expire url
       'http://sppdemoshop.eu/confirm.php?way=confirmed&order_id='.$merchantReferenceId, // return url
       'http://sppdemoshop.eu/confirm.php?way=cancelled&order_id='.$merchantReferenceId, // error url
    164, // Page set ID
    // Firs field to show in card input form Name and Surname field. 
    //Firs parameter goes as string 'show' or null. Second field is url for back button in card input form.
    new Transaction\DynamicData(null, 'http://sppdemoshop.eu/') 
);

$transaction  = new Transaction($txnDetails, $hpsTxn, new CardTxn());
$setupRequest = new SetupRequest($auth, $transaction);
$response = $spp->getPaymentCardHostedPagesGateway()->initPayment(
   $setupRequest,
   // This url card holder won't be redirected. This url will be called by cronjob to finalize transaction.
  UrlCallback::create("http://sppdemoshop.eu/secretprocesor.php?order_id={$merchantReferenceId}") 
);
$url=$response->getCustomerRedirectUrl(); // Getting redirect url
header('Location: '.$url); // redirecting card holder to card input form.
die();
 ```
 
 **confirm.php**
  ```php

include dirname(__FILE__).'/SwedbankPaymentPortal/vendor/autoload.php';

use SwedbankPaymentPortal\Options\CommunicationOptions;
use SwedbankPaymentPortal\Options\ServiceOptions;
use SwedbankPaymentPortal\SharedEntity\Authentication;
use SwedbankPaymentPortal\SwedbankPaymentPortal;

$orderId = $_GET['order_id'];
$way  = $_GET['way'];

if ($way == 'confirmed'){
  $auth = new Authentication('8******','******');
  $options = new ServiceOptions(
      new CommunicationOptions(
        'https://accreditation.datacash.com/Transaction/acq_a' //this is test environment 
		// for production/live use this URL: https://mars.transaction.datacash.com/Transaction
      ),
   $auth
  );
  SwedbankPaymentPortal::init($options);  // <- library  initiation
  $spp = SwedbankPaymentPortal::getInstance();  // <- library usage

  $rez = $spp->getPaymentCardHostedPagesGateway()->handlePendingTransaction($orderId); 
  // now you can show user "thank you for your payment, but don't put flag 
  //what this payment is done. This is done in secretprocesor.php file
  
  echo 'Thank you';
} else if ($way == 'expiry'){
	// do same logic if seesion expired
} else { // cancelled
	// do some action for cancel logic
}
 ```
 
 **secretprocesor.php**
 This file newer will be loaded in browser. This will be called by cron job.
  ```php
 $orderId = $_GET['order_id'];
 
 if($_POST['status'] === 'SUCCESS') {
		//Do action for success. This is final confirmations of success
		// now you can set flag what payment is success
	} else if($_POST['status'] === 'FAIL') {
		// Do action if failed
	} else if($_POST['status'] === 'UNFINISHED'){
		// Do action if unfinished
	} else {
	    // log this attempt 
	}
    
 ```

# Bank link

Replace sppdemoshop.eu to your shop address.

**banklink_setup.php**
```php
// in autoloader and library needed for banklink payment
include dirname(__FILE__) . '/../SwedbankPaymentPortal/vendor/autoload.php';

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
        'https://accreditation.datacash.com/Transaction/acq_a' //this is test environment 
        // for production/live use this URL: https://mars.transaction.datacash.com/Transaction
        ), $auth
);

SwedbankPaymentPortal::init($options);  // <- library  initiation
$spp = SwedbankPaymentPortal::getInstance();  // <- library usage


$purchaseAmount = 1500; // 15 Eur 00 ct


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
    ->setSuccessUrl('http://sppdemoshop.eu/test/banklink_confirm.php?way=confirmed&order_id=' . $merchantReferenceId) // see chapter “Success / Failure URL Handling” for more info
    ->setFailureUrl('http://sppdemoshop.eu/test/banklink_confirm.php?way=cancelled&order_id=' . $merchantReferenceId)
    ->setMerchantReference($merchantReferenceId)
    ->setLanguage("lt")
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
```

**callback.php**
```php
use SwedbankPaymentPortal\BankLink\CommunicationEntity\HPSQueryResponse\HPSQueryResponse;
use SwedbankPaymentPortal\BankLink\CommunicationEntity\NotificationQuery\ServerNotification;
use SwedbankPaymentPortal\CallbackInterface;
use SwedbankPaymentPortal\CC\PaymentCardTransactionData;
use SwedbankPaymentPortal\SharedEntity\Type\TransactionResult;
use SwedbankPaymentPortal\Transaction\TransactionFrame;

class Swedbank_Ordering_Handler_PaymentCompletedCallback implements CallbackInterface
{

    private $merchantReferenceId;

    public function __construct($merchantReferenceId)
    {
        $this->merchantReferenceId = $merchantReferenceId;
    }

    /**
     * Method for handling finished transaction which ended because of the specified response status.
     *
     * @param TransactionResult         $status
     * @param TransactionFrame          $transactionFrame
     * @param PaymentCardTransactionData $creditCardTransactionData
     */
    public function handleFinishedTransaction(TransactionResult $status, 
         TransactionFrame $transactionFrame, 
         PaymentCardTransactionData $creditCardTransactionData = null)
    {
        if ($status == TransactionResult::success()) {
            // success no you can put flag payment done
        } else if ($status == TransactionResult::failure()) {
            // failure. Do some action here
        } else {
            // unfinished payment
        }
	// This is only for debug. You can log into file if needed.
        mail('YourEmail@domain.lt', 
	    'DONE', print_r($status, true).print_r($transactionFrame, true).print_r($creditCardTransactionData, true)); 
	    
    }

    public function serialize()
    {
        return json_encode(
            [
                'merchantReferenceId' => $this->merchantReferenceId
            ]
        );
    }
                    
    public function unserialize($serialized)
    {
        $data = json_decode($serialized);

        $this->merchantReferenceId = $data->merchantReferenceId;
    }
}
```

**banklink_confirm.php**
```php
namespace SwedbankPaymentPortal;

include dirname(__FILE__).'/../SwedbankPaymentPortal/vendor/autoload.php';

use SwedbankPaymentPortal\Options\CommunicationOptions;
use SwedbankPaymentPortal\Options\ServiceOptions;
use SwedbankPaymentPortal\SharedEntity\Authentication;
use SwedbankPaymentPortal\SwedbankPaymentPortal;

include dirname(__FILE__) . '/callback.php';


$orderId = $_GET['order_id'];
$way  = $_GET['way'];

if ($way == 'confirmed'){
  $auth = new Authentication('******', '*****');
  $options = new ServiceOptions(
      new CommunicationOptions(
        'https://accreditation.datacash.com/Transaction/acq_a' //this is test environment 
		// for production/live use this URL: https://mars.transaction.datacash.com/Transaction
      ),
   $auth
  );
  SwedbankPaymentPortal::init($options);  // <- library  initiation
  $spp = SwedbankPaymentPortal::getInstance();  // <- library usage

  $rez = $spp->getBankLinkGateway()->handlePendingTransaction($orderId); 
  // now you can show user "thank you for your payment, but don't put flag 
  //flag need to put inside callback
  
  echo 'Thank you';
} else { // cancelled
	echo 'Payment cancelled';
	// do some action for cancel logic
}
```

# Paypal example

Replace sppdemoshop.eu to your shop address.

**paypal_setup.php**

```php
// include autoloader and library needed for paypal payment
include dirname(__FILE__) . '/../SwedbankPaymentPortal/vendor/autoload.php';

use SwedbankPaymentPortal\Options\CommunicationOptions;
use SwedbankPaymentPortal\Options\ServiceOptions;
use SwedbankPaymentPortal\SharedEntity\Authentication;
use SwedbankPaymentPortal\SwedbankPaymentPortal;
use SwedbankPaymentPortal\SharedEntity\Amount;

use SwedbankPaymentPortal\PayPal\CommunicationEntity\ShippingAddress;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\SetExpressCheckoutRequest\Transaction;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\SetExpressCheckoutRequest\Transaction\TxnDetails;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\SetExpressCheckoutRequest\SetExpressCheckoutRequest;
use SwedbankPaymentPortal\PayPal\Type\PayPalBool;


include dirname(__FILE__) . '/callback.php';
include dirname(__FILE__) . '/logger.php';

$auth = new Authentication('*******', '*********'); // VtID and password
// Generating unique merchant reference. To generate merchant reference 
//please use your one logic. This is only example.
$merchantReferenceId = 'ID235r' . strtotime('now');
$purchaseAmount = '4.99'; // Euro and cents needs to be separated by dot.  

$options = new ServiceOptions(
        new CommunicationOptions(
        'https://accreditation.datacash.com/Transaction/acq_a' //this is test environment 
        // for production/live use this URL: https://mars.transaction.datacash.com/Transaction
        ), $auth, new Swedbank_Client_Logger()
);

SwedbankPaymentPortal::init($options);  // <- library  initiation
$spp = SwedbankPaymentPortal::getInstance();  // <- library usage

$payPalTxn = new Transaction\PayPalTxn(
        null,
    'ABCQWH', // Custom
    'PayPal test payment', //Description
    'customer@customer.com', //Email
    $merchantReference, // Invoice number
    'LT', // Locale code
    $purchaseAmount, // Max amount
    PayPalBool::false(),// No Shipping
    PayPalBool::false(), // Overide address
    PayPalBool::false(), // Requere confirmed shipping
    'http://sppdemoshop.eu/test/paypal_confirm.php?way=confirmed&order_id=' . $merchantReferenceId, //Return URL. See chapter “Success / Failure URL Handling” for more info
    'http://sppdemoshop.eu/test/paypal_confirm.php?way=cancelled&order_id=' . $merchantReferenceId // error url
);

$txnDetails  = new TxnDetails(new Amount($purchaseAmount), $merchantReferenceId);
$transaction = new Transaction($txnDetails, $payPalTxn);
$request = new SetExpressCheckoutRequest($transaction, null);

$response = $spp->getPayPalGateway()->initPayment(
    $request,
    new Swedbank_Ordering_Handler_PaymentCompletedCallback(
        $merchantReferenceId
    )
);

$url = $response->getCustomerRedirectUrl(false); // Getting redirect url. False - if test enviroment, true - if live enviroment

header('Location: ' . $url); // redirecting card holder to card input form.

```

**paypal_confirm.php**

```php
include dirname(__FILE__).'/../SwedbankPaymentPortal/vendor/autoload.php';

use SwedbankPaymentPortal\Options\CommunicationOptions;
use SwedbankPaymentPortal\Options\ServiceOptions;
use SwedbankPaymentPortal\SharedEntity\Authentication;
use SwedbankPaymentPortal\SwedbankPaymentPortal;
use SwedbankPaymentPortal\SharedEntity\Amount;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\ShippingAddress;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\SetExpressCheckoutRequest\Transaction;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\SetExpressCheckoutRequest\Transaction\TxnDetails;
use SwedbankPaymentPortal\PayPal\CommunicationEntity\SetExpressCheckoutRequest\SetExpressCheckoutRequest;
use SwedbankPaymentPortal\PayPal\Type\PayPalBool;

include dirname(__FILE__) . '/callback.php';
include dirname(__FILE__) . '/logger.php';


$orderId = $_GET['order_id'];
$way  = $_GET['way'];

if ($way == 'confirmed'){
  $auth = new Authentication('*********', '*********');
  $options = new ServiceOptions(
      new CommunicationOptions(
        'https://accreditation.datacash.com/Transaction/acq_a' //this is test environment 
		// for production/live use this URL: https://mars.transaction.datacash.com/Transaction
      ),
   $auth, new Swedbank_Client_Logger()
  );
  SwedbankPaymentPortal::init($options);  // <- library  initiation
  $spp = SwedbankPaymentPortal::getInstance();  // <- library usage

  $spp->getPayPalGateway()->handlePendingTransaction($orderId); 
  // now you can show user "thank you for your payment, but don't put flag 
  //flag need to put inside callback
  
  echo 'Thank you';
} else { // cancelled
	echo 'Payment cancelled';
	// do some action for cancel logic
}

```

# Debugging / logging xml

To log xml needed to modify code.

```php
include 'swedbank_logger.php';
```

Add logger object to ServiceOptions

```php
$options = new ServiceOptions(
      new CommunicationOptions(
        'https://accreditation.datacash.com/Transaction/acq_a' //this is test environment 
		// for production/live use this URL: https://mars.transaction.datacash.com/Transaction
      ),
   $auth, new Swedbank_Client_Logger()
  );
```

**swedbank_logger.php**
```php
use SwedbankPaymentPortal\Logger\LoggerInterface;

class Swedbank_Client_Logger implements LoggerInterface
{
    public function __construct()
    {
    }

    /**
     * @param string                                                                                                                                                                                                                                                                                                                                                 $requestXml
     * @param string                                                                                                                                                                                                                                                                                                                                                 $responseXml
     * @param object|\SwedbankPaymentPortal\BankLink\CommunicationEntity\HPSQueryRequest\HPSQueryRequest|\SwedbankPaymentPortal\BankLink\CommunicationEntity\PaymentAttemptRequest\PaymentAttemptRequest|\SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseRequest\PurchaseRequest|\SwedbankPaymentPortal\BankLink\CommunicationEntity\TransactionQueryRequest\TransactionQueryRequest $requestObject
     * @param object|\SwedbankPaymentPortal\BankLink\CommunicationEntity\PaymentAttemptResponse\PaymentAttemptResponse|\SwedbankPaymentPortal\BankLink\CommunicationEntity\PurchaseResponse\PurchaseResponse|\SwedbankPaymentPortal\BankLink\CommunicationEntity\TransactionQueryResponse\TransactionQueryResponse|\SwedbankPaymentPortal\SharedEntity\HPSQueryResponse\HPSQueryResponse         $responseObject
     * @param \SwedbankPaymentPortal\SharedEntity\Type\TransportType                                                                                                                                                                                                                                                                                                        $type
     */
    public function logData(
        $requestXml,
        $responseXml,
        $requestObject,
        $responseObject,
        \SwedbankPaymentPortal\SharedEntity\Type\TransportType $type
    ) {

        $requestType = $type->id();
        $request = $this->prettyXml($requestXml);
        $response = $responseXml;

		file_put_contents(dirname(__FILE__) . '/../../../storage/logs/swedbank.log', "\n-----\n$requestType\n$request\n\n$response\n", FILE_APPEND | LOCK_EX);
    }

    /**
     * Method formats given XML into pretty readable format
     *
     * @param $xml
     *
     * @return string
     */
    private function prettyXml($xml)
    {
        $doc = new DomDocument('1.0');
        $doc->loadXML($xml);
        $doc->preserveWhiteSpace = false;
        $doc->formatOutput       = true;

        $prettyXml = $doc->saveXML();

        return $prettyXml;
    }
}
```

