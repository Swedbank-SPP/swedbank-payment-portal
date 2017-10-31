<?php

namespace SwedbankPaymentPortal;

include dirname(__FILE__).'/SwedbankPaymentPortal/vendor/autoload.php';

use SwedbankPaymentPortal\Options\CommunicationOptions;
use SwedbankPaymentPortal\Options\ServiceOptions;
use SwedbankPaymentPortal\SharedEntity\Authentication;
use SwedbankPaymentPortal\SwedbankPaymentPortal;

include dirname(__FILE__) . '/callback.php';


$orderId = $_GET['order_id'];
$way  = $_GET['way'];

if ($way == 'confirmed'){
  $auth = new Authentication('*******', '********');
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

