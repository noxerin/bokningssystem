<?php

ob_start();
include_once 'settings.php';
include_once './payex/PxOrder.php';
include_once './payex/InvoiceOrderlines.php';

// Create an invoiceOrderlines-object and add some orderlines to it.
$ivol = new invoiceOrderLines();
$ivol->addOrderLine("stekpanna", 3, 255.50, 25);
$ivol->addOrderLine("gryta", 2, 202.501, 25);
$ivol->addOrderLine("matlagning4dumies", 1, 202.50, 12);


//Parameters for Initialize8. Check payexpim.com for how the array should be constructed. For PxOrder.Initialize8: http://www.payexpim.com/technical-reference/pxorder/initialize8/.
$initialize8Params = array
    (
    'accountNumber' => $accountNumber,
    'purchaseOperation' => "SALE", //this example is showing a 1-phase transaction. If 2-phase, orderlines need to be sent in the PxOrder.Capture5 request.
    'price' => (string)$ivol->getTotalAmount()*100, //getTotalAmount returns a float. Price needs to be and string or int where price * 100 (example 250SEK = 25000)
    'priceArgList' => "",
    'currency' => "SEK",
    'vat' => "0",
    'orderID' => "orderID 1",
    'productNumber' => "1",
    'description' => "test description",
    'clientIPAddress' => $_SERVER['REMOTE_ADDR'],
    'clientIdentifier' => "USERAGENT=" . $_SERVER['HTTP_USER_AGENT'],
    'additionalValues' => "FINANCINGINVOICE_ORDERLINES=" . urlencode($ivol->getXML()), //FINANCINGINVOICE_ORDERLINES needs an urlencoded xml.
    'externalID' => "",
    'returnUrl' => "http://localhost/payexExampleCode/completeExample.php", //point to the completeExample.php file if you want to test PxOrder.Complete.
    'view' => "FINANCING",
    'agreementRef' => "",
    'cancelUrl' => "",
    'clientLanguage' => "da-DK",
    'hash' => "" // Leave empty, will be calculated by PxOrder.php
);

//create a pxorderMethods object(PxOrder.php).
$pxorder = new pxOrderMethods($testMode);

//call desired method with appropriate array of parameters + encryption key.
$response = $pxorder->initialize8($initialize8Params, $encryptionKey);

//Check if response was OK.
if (strval($response->status->errorCode) == 'OK') {

    echo('Success!');
    var_dump($response);
    var_dump($ivol->getXML());
} else {

    //Dumping soap request and responseXML if initialize8 call failed.
    echo($pxorder->getLastRequest());
    var_dump($response);
}

ob_end_flush();
?>