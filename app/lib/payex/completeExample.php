<?php

include_once 'settings.php';
include_once './payex/PxOrder.php';

	
	$orderRef = stripcslashes( $_GET['orderRef'] );
	
	//Parameters for Complete. Check payexpim.com for how the array should be constructed. For PxOrder.Complete: http://www.payexpim.com/technical-reference/pxorder/complete/.
	$completeParams = array
		(
		'accountNumber' => $accountNumber, 
		'orderRef' => $orderRef,
        'hash' => "" // Leave empty, will be calculated by PxOrder.php
		);
	
	//create a pxOrderMethods object(PxOrder.php).
	$pxorder = new pxOrderMethods($testMode);
	
	//call desired method with appropriate array of parameters + encryption key.
	$response = $pxorder->complete($completeParams, $encryptionKey);

	//Check if Complete call was OK. IMPORTANT! This will only tell you if the Complete-request was sent successfully, not if the purchase/transaction was successful. $response->transactionStatus need to be validated to show purchase status, see example below.
	if(strval($response->status->errorCode) == 'OK'){
		
		/** Check $response->transactionStatus to see if the purchase was successful.
		 * 0=Sale
		 * 1=Initialize
		 * 2=Credit
		 * 3=Authorize
		 * 4=Cancel
		 * 5=Failure
		 * 6=Capture
		 * In this example we expect Sale or Authorize, any other status will tell the user that the purchase failed.
		 */
		if(strval($response->transactionStatus) == 0 || strval($response->transactionStatus) == 3){
			echo 'The purchase was successful. A receipt should be shown on this page.';
			var_dump($response);
		}
		else{
			echo 'The purchase was unsuccessful, information about this should be displayed to the customer on this page.';
			var_dump($response);
		}
	}
	else{
		
		//Dumping responseXML if Complete call failed.
		var_dump($response);
	}

?>