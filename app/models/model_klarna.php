<?php

class model_klarna
{	
	function __construct(){	
		//Configure the klarna obj
		$GLOBALS['klarna']->config(
		    3950,                    // Merchant ID
		    'eTtv64VfxLIsum8',       // Shared secret
		    KlarnaCountry::SE,    // Purchase country
		    KlarnaLanguage::SV,   // Purchase language
		    KlarnaCurrency::SEK,  // Purchase currency
		    Klarna::BETA,         // Server
		    'json',               // PClass storage
		    './pclasses.json'     // PClass storage URI path
		);
	}
	
	public function fetchPclasses(){
		$k = $GLOBALS['klarna'];
		$k->getCheapestPClass(19990, KlarnaFlags::CHECKOUT_PAGE);
	}
	
	public function makeReservation($article, $shipping, $buyer){
		$k = $GLOBALS['klarna'];
		
		foreach($article as $row){
			$k->addArticle($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);			
		}

		$k->addArticle(1, "", "Frakt", $shipping, 25, 0, KlarnaFlags::INC_VAT | KlarnaFlags::IS_SHIPMENT);
		
		$addr = new KlarnaAddr($buyer[0], $buyer[1], $buyer[2], $buyer[3], $buyer[4], $buyer[5], $buyer[6], $buyer[7], $buyer[8], $buyer[9], $buyer[10], $buyer[11]);
		
		$k->setAddress(KlarnaFlags::IS_BILLING, $addr);
		$k->setAddress(KlarnaFlags::IS_SHIPPING, $addr);
		
		try {
		    $result = $k->reserveAmount(
		        $buyer[12], // PNO (Date of birth for AT/DE/NL)
		        null, // KlarnaFlags::MALE, KlarnaFlags::FEMALE (AT/DE/NL only)
		        -1,   // Automatically calculate and reserve the cart total amount
		        KlarnaFlags::NO_FLAG,
		        KlarnaPClass::INVOICE
		    );
		
		    $rno = $result[0];
		    $status = $result[1];
		
		    // $status is KlarnaFlags::PENDING or KlarnaFlags::ACCEPTED.
		
		    return array($rno, $status);
		} catch(Exception $e) {
		    return array(false, $e->getCode(), $e->getMessage()); 
		}
	}
	
	public function cancleReservation($rno){
		$k = $GLOBALS['klarna'];

		try {
		    $k->cancelReservation($rno);
		
		    echo "OK\n";
		} catch(Exception $e) {
		    echo "{$e->getMessage()} (#{$e->getCode()})\n";
		}
	}
	
	public function activateReservation($rno){
		$k = $GLOBALS['klarna'];
		
		try {
		    $result = $k->activate($rno, null, KlarnaFlags::RSRV_SEND_BY_EMAIL);
		
		    // For optional arguments, flags, partial activations and so on, refer to the documentation.
		    // See Klarna::setActivateInfo
		
		    $risk = $result[0];  // "ok" or "no_risk"
		    $invNo = $result[1]; // "9876451"
		
		    echo "OK: invoice number {$invNo} - risk status {$risk}\n";
		} catch(Exception $e) {
		    echo "{$e->getMessage()} (#{$e->getCode()})\n";
		}
	}
	
}