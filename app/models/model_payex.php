<?php
class model_payex
{
	
	public function __construct(){
		
		   $GLOBALS['testMode'] = true;
		   $GLOBALS['accountNumber'] = "60097534";
		   $GLOBALS['encryptionKey'] = "V4292P95m595dz9498Fb";
	}
	
	public function paymentGateway($products, $orderid){
		ob_start();

		// Create an invoiceOrderlines-object and add some orderlines to it.
		$ivol = new invoiceOrderLines();
		$productDesc = "";
		
		if($_SESSION['count'] == "sum"){
			$productCount = 1;
		}else{
			$productCount =	(int)$_SESSION['count'];
		}
		
		$productDesc .= $products['product']['name'];
		$ivol->addOrderLine($products['product']['name'], $productCount, $products['product']['price'], 0);
		foreach($products['extras'] as $row ){
			$ivol->addOrderLine($row['name'], $products['extras_count'][$row['id']], $row['price'], 0);
			$productDesc .= ", " . $row['name'];
		}
		$ivol->addOrderLine($products['shipping']['title'], 1, $products['shipping']['cost'], 0);
		$productDesc .= ", " . $products['shipping']['title'];
		
		
		//Parameters for Initialize8. Check payexpim.com for how the array should be constructed. For PxOrder.Initialize8: http://www.payexpim.com/technical-reference/pxorder/initialize8/.
		$initialize8Params = array
		    (
		    'accountNumber' => $GLOBALS['accountNumber'],
		    'purchaseOperation' => "SALE", //this example is showing a 1-phase transaction. If 2-phase, orderlines need to be sent in the PxOrder.Capture5 request.
		    'price' => (string)$ivol->getTotalAmount()*100, //getTotalAmount returns a float. Price needs to be and string or int where price * 100 (example 250SEK = 25000)
		    'priceArgList' => "",
		    'currency' => "SEK",
		    'vat' => "0",
		    'orderID' => "Ordernummer $orderid",
		    'productNumber' => "1",
		    'description' => "$productDesc",
		    'clientIPAddress' => $_SERVER['REMOTE_ADDR'],
		    'clientIdentifier' => "USERAGENT=" . $_SERVER['HTTP_USER_AGENT'],
		    'additionalValues' => "PAYMENTMENU=TRUE",
		    'externalID' => "",
		    'returnUrl' => "http://dev.nxi.se/checkout/confirm", //point to the completeExample.php file if you want to test PxOrder.Complete.
		    'view' => "CREDITCARD",
		    'agreementRef' => "",
		    'cancelUrl' => "http://dev.nxi.se/checkout/review",
		    'clientLanguage' => "sv-SE",
		    'hash' => "" // Leave empty, will be calculated by PxOrder.php
		);
		
		//create a pxorderMethods object(PxOrder.php).
		$pxorder = new pxOrderMethods($GLOBALS['testMode']);
		
		//call desired method with appropriate array of parameters + encryption key.
		$response = $pxorder->initialize8($initialize8Params, $GLOBALS['encryptionKey']);
		
		//Check if response was OK.
		if (strval($response->status->errorCode) == 'OK') {
		    //If OK insert orderRef, redirect.
			$sql = "
				UPDATE
					orders
				SET
					payment = ?
				WHERE
					id = ?";
			$GLOBALS['db']->query($sql, array($response->orderRef, $orderid));
			header('Location: '.strval($response->redirectUrl));
			return true;
		} else {
		
		    //Dumping soap request and responseXML if initialize8 call failed.
		    return false;
		}
		
		ob_end_flush();
	}
	
	public function confirm($orderRef){
		
		//Parameters for Complete. Check payexpim.com for how the array should be constructed. For PxOrder.Complete: http://www.payexpim.com/technical-reference/pxorder/complete/.
		$completeParams = array
			(
			'accountNumber' => $GLOBALS['accountNumber'], 
			'orderRef' => $orderRef,
	        'hash' => "" // Leave empty, will be calculated by PxOrder.php
			);
		
		//create a pxOrderMethods object(PxOrder.php).
		$pxorder = new pxOrderMethods($GLOBALS['testMode']);
		
		//call desired method with appropriate array of parameters + encryption key.
		$response = $pxorder->complete($completeParams, $GLOBALS['encryptionKey']);
	
		//Check if Complete call was OK. IMPORTANT! This will only tell you if the Complete-request was sent successfully, not if the purchase/transaction was successful. $response->transactionStatus need to be 		validated to show purchase status, see example below.
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
				//echo 'The purchase was successful. A receipt should be shown on this page.';
				return array(true, $response->transactionStatus);
			}
			else{
				//echo 'The purchase was unsuccessful, information about this should be displayed to the customer on this page.';
				return false;
			}
		}
		else{
			
			//Dumping responseXML if Complete call failed.
			var_dump($response);
		}
	}
	
	public function callback(){
		ob_start();
		
		//array of allowed PayEx IPaddress for transaction callback.
		$allowedIP = array ("82.115.146.170","82.115.146.10");
        
        //check if the call is coming from an PayEx IP
        if(in_array($_SERVER['REMOTE_ADDR'], $allowedIP)){   

            //get orderRef from the HTTP POST data.
            $orderRef = $_POST['orderRef'];

            //call complete with the orderRef to get transactionDetails. Check completeExample.php for a better description of this method.
            $completeParams = array
                    (
                    'accountNumber' => $GLOBALS['accountNumber'], 
                    'orderRef' => $orderRef,
                    'hash' => ""
                    );
	
            $pxorder = new pxorderMethods($GLOBALS['testMode']);
	
            $response = $pxorder->complete($completeParams, $GLOBALS['encryptionKey']);     
                
            //If Complete call was successful (just the call, not the transaction) return OK in body. Otherwise return "FAILURE".
            if(strval($response->status->errorCode) == 'OK'){
				header("HTTP/1.0 200 OK");
				echo("OK");
            }
            else{
				header("HTTP/1.0 200 OK");
				echo("FAILED");
            }
	
            /*Writing log to server for troubleshooting. Not needed for actual implementation.
            $log = fopen("callbackLog.txt", "a") or die ("unable to open file");
	
            fwrite($log, date("Y-m-d H:i:s") . "\n");
            fwrite($log, "Headers: " . print_r(getallheaders(), true));
            fwrite($log, "Post data: " . print_r($_POST, true));
            fwrite($log, "Complete response: " . $response->asXML() . "\n");
            fwrite($log, "\n"); 
            */
        }
        else{
            echo("Connection is not allowed. Only accepting PayEx Transaction Callback.");
            
            /*Writing log to server for troubleshooting. Not needed for actual implementation.
             
             $log = fopen("callbackLog.txt", "a") or die ("unable to open file");
             fwrite($log, date("Y-m-d H:i:s") . "\n");
             fwrite($log, $_SERVER['REMOTE_ADDR'] . " Was not allowed, not a PayEx IP." . "\n");
             */
        }
	
		ob_end_flush();	
	}
	
	
}