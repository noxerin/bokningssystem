<?php
ob_start();
include_once 'settings.php';
include_once './payex/PxOrder.php';

        //array of allowed PayEx IPaddress for transaction callback.
		$allowedIP = array ("82.115.146.170","82.115.146.10");
        
        //check if the call is coming from an PayEx IP
        if(in_array($_SERVER['REMOTE_ADDR'], $allowedIP)){   

            //get orderRef from the HTTP POST data.
            $orderRef = $_POST['orderRef'];

            //call complete with the orderRef to get transactionDetails. Check completeExample.php for a better description of this method.
            $completeParams = array
                    (
                    'accountNumber' => $accountNumber, 
                    'orderRef' => $orderRef,
                    'hash' => ""
                    );
	
            $pxorder = new pxorderMethods($testMode);
	
            $response = $pxorder->complete($completeParams, $encryptionKey);     
                
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
?>