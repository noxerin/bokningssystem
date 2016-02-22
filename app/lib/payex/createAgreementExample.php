<?php
ob_start();
include_once 'settings.php';
include_once 'payex/PxOrder.php';
include_once 'payex/PxAgreement.php';

	//Parameters for CreateAgreement3. Check payexpim.com for how the array should be constructed. For PxAgreement.CreateAgreement3: http://www.payexpim.com/technical-reference/pxagreement/createagreement3/.
	$createAgreement3Params = array
		(
		'accountNumber' => $accountNumber, 
		'merchantRef' => "Test product",
		'description' => "test Description",
		'purchaseOperation' => "SALE",
		'maxAmount' => "500000",
		'notifyUrl' => "",
		'startDate' => "",
		'stopDate' => "",
		'hash' => "" // Leave empty, will be calculated by PxAgreement.php
		);
		
	//create a pxAgreementMethods object(PxAgreement.php).
	$pxAgreement = new pxAgreementMethods($testMode);
	
	//call desired method with appropriate array of parameters + encryption key.
	$agreementResponse = $pxAgreement->createAgreement3($createAgreement3Params, $encryptionKey);
	
		//check if CreateAgreement3 was successful. If successful, start initialize to make a payment with the reference.
		if(strval($agreementResponse->status->errorCode) == 'OK'){
			
			//NOTE! You should save agreementRef before calling Initialize. AgreementRef will later be used to call autoPay3 and deleteAgreement.
			initialize(strval($agreementResponse->agreementRef));
		}
		else{
			var_dump($agreementResponse);
		}
	
	
	//same as initialize8Example.php, except agreementRef parameter in initialize8params.
	function initialize($ref){
	
	
	//Parameters for Initialize8. Check payexpim.com for how the array should be constructed. In this example: http://www.payexpim.com/technical-reference/pxorder/initialize8/.
	$initialize8Params = array
		(
		'accountNumber' => $GLOBALS['accountNumber'], 
		'purchaseOperation' => "SALE",
		'price' => "20000", //NOTE: if you fetch price from another variable, you should make sure price does not get stored as a float data type in this array. Example of how to solve this: 'price' => (string)$myPriceVariable,
		'priceArgList' => "",
		'currency' => "SEK",
		'vat' => "0",
		'orderID' => "orderID 1",
		'productNumber' => "1",
		'description' => "test Description",
		'clientIPAddress' => $_SERVER['REMOTE_ADDR'],
		'clientIdentifier' => "USERAGENT=".$_SERVER['HTTP_USER_AGENT'],
		'additionalValues' => "",
		'externalID' => "",
		'returnUrl' => "http://localhost/payexExampleCode/completeExample.php", //point to the completeExample.php file if you want to test PxOrder.Complete.
		'view' => "CREDITCARD",
		'agreementRef' => $ref,
		'cancelUrl' => "",
		'clientLanguage' => "en-US",
        'hash' => "" // Leave empty, will be calculated by PxOrder.php
		);
	
	//create a pxOrderMethods object (PxOrder.php).
	$pxorder = new pxOrderMethods($GLOBALS['testMode']);
	
	//call desired method with appropriate array of parameters + encryption key.
	$initializeResponse = $pxorder->initialize8($initialize8Params, $GLOBALS['encryptionKey']);

	//Check if response was OK.
	if(strval($initializeResponse->status->errorCode) == 'OK'){
		
		//If OK, redirect.
		header('Location: '.strval($initializeResponse->redirectUrl));
	}
	else{
		
		//Dumping soap request and responseXML if initialize8 call failed.
		echo($pxorder->getLastRequest());
		var_dump($response);
	}

}
ob_end_flush();
?>