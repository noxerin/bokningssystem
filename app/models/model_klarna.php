<?php

class model_klarna
{	
	function __construct(){	
		//Configure the klarna obj
		$GLOBALS['klarna']->config(
		    $GLOBALS['config']['klarna']['eid'], // Merchant ID
		    $GLOBALS['config']['klarna']['sharedSecret'],       // Shared secret
		    KlarnaCountry::SE,    // Purchase country
		    KlarnaLanguage::SV,   // Purchase language
		    KlarnaCurrency::SEK,  // Purchase currency
		    Klarna::BETA,         // Server
		    'json',               // PClass storage
		    './pclasses.json'     // PClass storage URI path
		);
	}
	
	public function checkout($data){
		
		//If value sum
		if($_SESSION['count'] == "sum"){
			$productCount = 1;
		}else{
			$productCount =	(int)$_SESSION['count'];
		}
		
		//Create array and input product
		$cart = array(
		    array(
		        'reference' => $data['product']['id'],
		        'name' => 'Presentkort - ' . $data['product']['name'],
		        'quantity' => $productCount,
		        'unit_price' => $data['product']['price']*100,
		        'discount_rate' => 00,
		        'tax_rate' => 2500
		    )
		);
		
		//Add extras if selected
		foreach($data['extras'] as $row){
			array_push($cart,
			    array(
			        'reference' => $row['id'],
			        'name' => 'Extra - ' . $row['name'],
			        'quantity' => 1,
			        'unit_price' => $row['price']*100,
			        'tax_rate' => 2500
				)
			);
		}
		
		
		//Add shipping to cart
		array_push($cart,
			    array(
			        'type' => 'shipping_fee',
			        'reference' => 'FRAKT',
			        'name' => 'Frakt - ' . $data['shipping']['title'],
			        'quantity' => 1,
			        'unit_price' => $data['shipping']['cost']*100,
			        'tax_rate' => 2500
				)
		);
		
		$create = array();
		foreach ($cart as $item) {
		    $create['cart']['items'][] = $item;
		}
		
		$create['shipping_address']['email'] = $_SESSION['buyer']['email'];
		$create['shipping_address']['postal_code'] = $_SESSION['buyer']['postal'];
		$create['shipping_address']['given_name'] = $_SESSION['buyer']['fname'];
		$create['shipping_address']['family_name'] = $_SESSION['buyer']['lname'];
		$create['shipping_address']['street_address'] = $_SESSION['buyer']['address'];
		$create['shipping_address']['postal_code'] = $_SESSION['buyer']['postal'];
		$create['shipping_address']['city'] = $_SESSION['buyer']['city'];


		
		$create['purchase_country'] = 'SE';
		$create['purchase_currency'] = 'SEK';
		$create['locale'] = 'sv-se';
		$create['merchant']['id'] = $GLOBALS['config']['klarna']['eid'];
		$create['merchant']['terms_uri'] = 'http://'. $_SERVER['SERVER_NAME'] . '/checkout/terms';
		$create['merchant']['checkout_uri'] = 'http://'. $_SERVER['SERVER_NAME'] . '/checkout/review';
		$create['merchant']['confirmation_uri'] = 'http://'. $_SERVER['SERVER_NAME'] . '/checkout/complete' . '/?klarna_id={checkout.order.uri}';
		$create['merchant']['push_uri'] = 'http://'. $_SERVER['SERVER_NAME'] . '/checkout/confirm' . '/?klarna_order={checkout.order.uri}';
		    
	    $create['options']['color_button'] = '#61614C';
		    
		Klarna_Checkout_Order::$baseUri
		    = 'https://checkout.testdrive.klarna.com/checkout/orders';
		Klarna_Checkout_Order::$contentType
		    = "application/vnd.klarna.checkout.aggregated-order-v2+json";
		
		$connector = Klarna_Checkout_Connector::create($GLOBALS['config']['klarna']['sharedSecret']);
		$order = new Klarna_Checkout_Order($connector);
		$order->create($create);
		
		$order->fetch();

		// Store location of checkout session
		$_SESSION['klarna_checkout'] = $sessionId = $order->getLocation();
		
		// Display checkout
		$snippet = $order['gui']['snippet'];
		return "<div>{$snippet}</div>";
	}
	
	public function complete($orderid){
		Klarna_Checkout_Order::$contentType
		    = "application/vnd.klarna.checkout.aggregated-order-v2+json";
		
		$connector = Klarna_Checkout_Connector::create('eTtv64VfxLIsum8');
		
		@$checkoutId = $orderid;
		$order = new Klarna_Checkout_Order($connector, $checkoutId);
		$order->fetch();
		
		//If not already created, Create order in our system
		$sql = "SELECT * FROM orders WHERE klarna = ?";
		if(!is_array($GLOBALS['db']->query($sql, $order['reservation']))){
			$sql = "
					INSERT INTO 
						orders 
						(fname, lname, email, address, postal, city, country, phone, shipping_alternative, image, message, code, klarna, time) 
					VALUES 
						(?,?,?,?,?,?,?,?,?,?,?,?,?,?);
					SELECT LAST_INSERT_ID()";
			$GLOBALS['db']->query($sql, 
								array($_SESSION['buyer']['fname'],
									$_SESSION['buyer']['lname'],
									$_SESSION['buyer']['email'],
									$_SESSION['buyer']['address'],
									$_SESSION['buyer']['postal'],
									$_SESSION['buyer']['city'],
									$_SESSION['buyer']['country'],
									$_SESSION['buyer']['phone'],
									$_SESSION['buyer']['alternative'],
									$_SESSION['image'],
									$_SESSION['message'],
									substr(hash('sha512', $order['reservation'] . rand(1, 1000)), 1, 8),
									$order['reservation'],
									time()));
			//Create relation table for products and extras in order
			//Select id from order
			$sql = "SELECT 
						id
					FROM
						orders
					WHERE
						klarna = ?";
			$id = $GLOBALS['db']->query($sql, $order['reservation']);
			//Fist insert product
			//If value sum count = amount && category = sum
			if($_SESSION['count'] == "sum"){
				$count = $_SESSION['sum'];
				$category = "SUM";
			}else{
				$count = $_SESSION['count'];
				$category = "PRODUCT";
			}
			
			//Get current price
			$sql = "SELECT
						price
					FROM
						products
					WHERE
						id = ?";
			$cost = $GLOBALS['db']->query($sql, $_SESSION['product']);
			
			//Initiate insert
			$sql = "INSERT INTO 
						order_items
						(`order`, item_id, category, count, cost) 
					VALUES 
						(?,?,?,?,?)";
			$GLOBALS['db']->query($sql, array($id[0]['id'], $_SESSION['product'], $category, $count, $cost[0]['price']));
			
			//Insert every extras
			if(strlen($_SESSION['extras'][0]) >= 1){
				foreach($_SESSION['extras'] as $row){
					//Get current price
					$sql = "SELECT
								price
							FROM
								extras
							WHERE
								id = ?";
					$cost = $GLOBALS['db']->query($sql, $row);

					$sql = "
						INSERT INTO 
							order_items
							(`order`, item_id, category, count, cost) 
						VALUES 
							(?,?,?,1,?)";
					$GLOBALS['db']->query($sql, array($id[0]['id'], $row, "EXTRAS", $cost[0]['price']));
				}
			}
			session_destroy();
		}
		
		$snippet = $order['gui']['snippet'];
		unset($_SESSION['klarna_checkout']);
		return "<div>{$snippet}</div>";
	}
	
	public function confirm($orderid){
		Klarna_Checkout_Order::$contentType
		    = "application/vnd.klarna.checkout.aggregated-order-v2+json";
		
		$connector = Klarna_Checkout_Connector::create('eTtv64VfxLIsum8');
		
		@$checkoutId = $orderid;
		$order = new Klarna_Checkout_Order($connector, $checkoutId);
		$order->fetch();
		
		if ($order['status'] == "checkout_complete") {
		    // At this point make sure the order is created in your system and send a 
		    // confirmation email to the customer
		    
		    //Mail sendout
		    //Both customer and admin
		    				    
		    //Update order in our system
			$sql = "
				UPDATE
					orders
				SET
					status = 'RESERVED'
				WHERE
					klarna = ?;";
			$GLOBALS['db']->query($sql, $order['reservation']);

		    $update = array();
		    $update['status'] = 'created';
		
		    $order->update($update);
		    
		    return true;
		}else{
			return false;
		}
		
	}
	
	public function cancelOrder($klarnaId){
		return $GLOBALS['klarna']->cancelReservation($klarnaId);
	}
	
	public function activateOrder($klarnaId, $orderid){
		return $GLOBALS['klarna']->activate(
		    $klarnaId, 
		    $orderId,    
		    KlarnaFlags::RSRV_SEND_BY_EMAIL
		);
	}
	
	public function refundOrder($invoiceId){
		return $GLOBALS['klarna']->creditInvoice($invoiceId);
	}
	
}