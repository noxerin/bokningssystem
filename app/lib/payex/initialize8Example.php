<?php
ob_start();
include_once 'settings.php';
include_once 'payex/PxOrder.php';

	
	//Parameters for Initialize8. Check payexpim.com for how the array should be constructed. For PxOrder.Initialize8: http://www.payexpim.com/technical-reference/pxorder/initialize8/.
	$initialize8Params = array
		(
		'accountNumber' => $accountNumber, 
		'purchaseOperation' => "AUTHORIZATION",
		'price' => "20000", //NOTE: if you fetch price from another variable, you should make sure price does not get stored as a float data type in this array. Example of how to solve this: 'price' => (string)$myPriceVariable,
		'priceArgList' => "",
		'currency' => "SEK",
		'vat' => "0",
		'orderID' => "orderID 1",
		'productNumber' => "1",
		'description' => "test description",
		'clientIPAddress' => $_SERVER['REMOTE_ADDR'],
		'clientIdentifier' => "USERAGENT=".$_SERVER['HTTP_USER_AGENT'],
		'additionalValues' => "",
		'externalID' => "",
		'returnUrl' => "http://localhost/payexExampleCode/completeExample.php", //point to the completeExample.php file if you want to test PxOrder.Complete.
		'view' => "CREDITCARD",
		'agreementRef' => "",
		'cancelUrl' => "",
		'clientLanguage' => "en-US",
        'hash' => "" // Leave empty, will be calculated by PxOrder.php
		);
	
	//create a pxorderMethods object(PxOrder.php).
	$pxorder = new pxOrderMethods($testMode);
	
	//call desired method with appropriate array of parameters + encryption key.
	$response = $pxorder->initialize8($initialize8Params, $encryptionKey);

	//Check if response was OK.
	if(strval($response->status->errorCode) == 'OK'){
		
		//If OK, redirect.
		header('Location: '.strval($response->redirectUrl));
	}
	else{
		
		//Dumping soap request and responseXML if initialize8 call failed.
		echo($pxorder->getLastRequest());
		var_dump($response);
	}

ob_end_flush();	
?>