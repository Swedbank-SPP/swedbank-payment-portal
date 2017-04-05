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

### Projects which doesn`t have composer installed

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

Any of the magic card numbers can be used while integrating 3-D Secure. The response will be determined first by the 3-D Secure configuration on your account, and then by the expiry date of the card number.

In order to generate specific responses, please use the  card expiry dates shown below:

Code | Response
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
 SVENSKA HANDELSBANKEN AB (SWEDEN) |  | PaymentMethod::svenska()
 SKANDINAVISKA ENSKILDA BANKEN AB (SWEDEN) | ServiceType::sebSwd() | PaymentMethod::seb()
 SWEDBANK AS (ESTONIA) | ServiceType::estBank() | PaymentMethod::swedbank()
 SEB AS Pank (ESTONIA) | ServiceType::sebEst() | PaymentMethod::seb()
 Nordea Bank AB Estonia Branch (ESTONIA) | ServiceType::nrdEst() | PaymentMethod::nordea()
 SWEDBANK AS (LATVIA) | ServiceType::ltvBank() | PaymentMethod::swedbank()
 SEB AS banka (LATVIA) | ServiceType::sebLtv() | PaymentMethod::seb()
 AS CITADELE BANKA (LATVIA) |  | PaymentMethod::citadele()
 SWEDBANK AB (LITHUANIA) | ServiceType::litBank() | PaymentMethod::swedbank()
 SEB AB bankas (LITHUANIA) | ServiceType::sebLit() | PaymentMethod::seb()
 AB DNB BANKAS (LITHUANIA) |  | PaymentMethod::dnb()
 NORDEA BANK AB LITHUANIA BRANCH (LITHUANIA) | ServiceType::nrdLit() | PaymentMethod::nordea()
 DANSKE BANK AS LITHUANIA BRANCH (LITHUANIA) |  | PaymentMethod::danske()
 
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

 
 
