<?php
class model_orders
{
	
	public function create(){
		
		//Create order in our system
		$sql = "
				INSERT INTO 
					orders 
					(fname, lname, email, address, postal, city, country, phone, shipping_alternative, image, message, code, time)
				VALUES 
					(?,?,?,?,?,?,?,?,?,?,?,?,?);";
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
								substr(hash('sha512', uniqid() . rand(1, 1000)), 1, 8),
								time()));
		$id = $GLOBALS['db']->lastInsertedId();
		//Create relation table for products and extras in order
		//Select id from order
		$sql = "SELECT 
					id
				FROM
					orders
				WHERE
					id = ?";
		$id = $GLOBALS['db']->query($sql, $id);
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
		
		return $id;
		
	}
	
	public function update($orderId){
		//Create order in our system
		$sql = "
				UPDATE
					orders 
				SET 
					fname = ?, lname = ?, email = ?, address = ?, postal = ?, city = ?, country = ?, phone = ?, shipping_alternative = ?, image = ?, message = ?, code = ?, time = ?
				WHERE
					id = ?;";
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
								substr(hash('sha512', uniqid() . rand(1, 1000)), 1, 8),
								time(),
								$orderId));
		//Create relation table for products and extras in order
		//Select id from order
		$sql = "SELECT 
					id
				FROM
					orders
				WHERE
					id = ?";
		$id = $GLOBALS['db']->query($sql, $orderId);
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
		
		$sql = "
			DELETE FROM
				order_items
			WHERE
				order_items.order = ?";
		$GLOBALS['db']->query($sql, $orderId);
		
		//Initiate insert
		$sql = "INSERT INTO 
					order_items
					(order_items.order, item_id, category, count, cost) 
				VALUES 
					(?,?,?,?,?)";
		$GLOBALS['db']->query($sql, array($orderId, $_SESSION['product'], $category, $count, $cost[0]['price']));
		
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
				$GLOBALS['db']->query($sql, array($orderId, $row, "EXTRAS", $cost[0]['price']));
			}
		}
		
	}
	
	public function remove($orderId){
		$sql = "
			SET SQL_SAFE_UPDATES = 0;
			DELETE FROM
				orders
			WHERE
				id = ?;
			DELETE FROM
				order_items
			WHERE
				order_items.order = ?";
		$GLOBALS['db']->query($sql, array($orderId, $orderId));
	}
	
	public function updateOrderStatus($payment, $status){
		$sql = "
			SET SQL_SAFE_UPDATES = 0;
			UPDATE
				orders
			SET
				orders.status = ?
			WHERE
				payment = ?";
		$GLOBALS['db']->query($sql, array($status, $payment));
	}
	
	public function retriveLastOrders($count){
		$sql = "
			SELECT
				*
			FROM
				orders
			ORDER BY
				(case 
					status 
					WHEN 'PENDING' THEN 1
					WHEN 'RESERVED' THEN 1
					WHEN 'ACTIVE' THEN 2
					WHEN 'REFUNDED' THEN 3
					WHEN 'CANCELED' THEN 3
					ELSE 4 END)
			LIMIT 
				$count";
			
		return $GLOBALS['db']->query($sql);			
			
	}
	
	public function retriveSearchOrders($search){
		$search = $search . "%";
		
		$sql = "
			SELECT
				*
			FROM
				orders
			WHERE
				((fname LIKE ?) OR (lname LIKE ?) OR (address LIKE ?) OR (code LIKE ?) OR (payment LIKE ?) OR (id LIKE ?) OR (FROM_UNIXTIME(time, '%Y-%m-%d') LIKE ?) OR (status LIKE ?))
			ORDER BY
				id
					DESC";
			
		return $GLOBALS['db']->query($sql, array($search,$search,$search,$search,$search,$search,$search, $search));
	}
	
	public function retriveGiftcardSearchOrders($search){
		$search = $search . "%";
		
		$sql = "
			SELECT
				*
			FROM
				orders
			WHERE
				((fname LIKE ?) OR (lname LIKE ?) OR (address LIKE ?) OR (code LIKE ?) OR (payment LIKE ?) OR (id LIKE ?) OR (FROM_UNIXTIME(time, '%Y-%m-%d') LIKE ?) OR (status LIKE ?))
			AND	
				status = 'APPROVED'
			ORDER BY
				id
					DESC";
			
		return $GLOBALS['db']->query($sql, array($search,$search,$search,$search,$search,$search,$search, $search));
	}

	
	public function retriveOrder($orderId){
		$sql = "
			SELECT 
				*
			FROM
				orders
			WHERE
				id = ?";
		$order = $GLOBALS['db']->query($sql, $orderId);

		$sql = "
			SELECT
				*
			FROM
				order_items
			JOIN
				products
			ON
				products.id = order_items.item_id
			WHERE
				order_items.order = ?
			AND
				(category = 'PRODUCT'
			OR	
				category = 'SUM')";
		$order_items_product = $GLOBALS['db']->query($sql, $orderId);
		
		$sql = "
			SELECT
				*
			FROM
				order_items
			JOIN
				extras
			ON
				extras.id = order_items.item_id
			WHERE
				order_items.order = ?
			AND
				category = 'EXTRAS'";
		$order_items_extras = $GLOBALS['db']->query($sql, $orderId);
				
		$sql = "
			SELECT
				*
			FROM
				images
			WHERE
				id = ?";
		$image = $GLOBALS['db']->query($sql, $order[0]['image']);
		
		return array($order, $order_items_product, $order_items_extras);

	}
	
	public function retriveOrderByPaymentId($payment){
		$sql = "
			SELECT
				*
			FROM
				orders
			WHERE
				payment = ?";
		return $GLOBALS['db']->query($sql, $payment);
	}
	
	public function markAs($paymentId, $mark){
		$sql = "
			UPDATE
				orders
			SET
				status = ?
			WHERE
				payment = ?";
		$GLOBALS['db']->query($sql, array($mark, $paymentId));
	}
	
	public function updatePaymentNumber($currentpaymentId, $paymentInvoice){
		$sql = "
			UPDATE
				orders
			SET
				payment = ?
			WHERE
				payment = ?";
		$GLOBALS['db']->query($sql, array($paymentInvoice, $currentpaymentId));
	}
	
	public function calculateTotalSum($orderId){
		
		//Define variables to be used
		$totalSum = 0;
		
		//Select all items contained in specific order
		$sql = "
			SELECT
				item_id, category, count
			FROM
				order_items
			WHERE
				order_items.order = ?";
		$items = $GLOBALS['db']->query($sql, $orderId);
		
		//Add total sum of every item
		
		foreach($items as $row){
			if($row['category'] == "PRODUCT"){
				$sql = "
					SELECT
						price
					FROM
						products
					WHERE
						id = ?";
				$result = $GLOBALS['db']->query($sql, $row['item_id']);

				//Add the product times the number ordered
				$totalSum += $result[0]['price']*$row['count'];
				
			}else if($row['category'] == "EXTRAS"){
				$sql = "
					SELECT
						price
					FROM
						extras
					WHERE
						id = ?";
				$result = $GLOBALS['db']->query($sql, $row['item_id']);
				//Add the product times the number ordered
				$totalSum += $result[0]['price']*$row['count'];
				
			}else if($row['category'] == "SUM"){
				$totalSum += $row['count'];
			}
		}
		return $totalSum;
	}
	
	public function compile_order($orderId){
		$sql = "
			SELECT
				id, fname, lname, email, address, postal, city, country, phone, time, shipping_alternative
			FROM
				orders
			WHERE
				id= ?
			AND
				type = 'CUSTOMER'";
		$order = $GLOBALS['db']->query($sql, $orderId);
		
		$sql = "
			SELECT
				*
			FROM
				order_items
			WHERE
				order_items.order = ?";
		$order_items = $GLOBALS['db']->query($sql, $orderId);
				
		$totalSum = null;
		foreach($order_items as $row){
			$totalSum += $row['cost'] * $row['count'];
		}

		switch ($order[0]['shipping_alternative']) {
		    case 1:
		        $shipping = "25";
		        break;
		    case 2:
		        $shipping = "80";
		        break;
		    case 3:
				$shipping = "0";
				break;
		}
		//Push total sum to end of array
		//Add shipping cost
		$order = $order[0] + array("totalSum" => $totalSum) + array("shipping" => $shipping);
		
		return $order;
	}
	
	public function compile_order_byDate($timeSpanStart, $timeSpanEnd){
		$sql = "
			SELECT
				id, fname, lname, email, address, postal, city, country, phone, time, shipping_alternative
			FROM
				orders
			WHERE
				time 
					BETWEEN 
						? and ?";
		$order = $GLOBALS['db']->query($sql, array($timeSpanStart, $timeSpanEnd));
		
		$count = 0;
		foreach($order as $row){
			$totalSum = null;
			
			$sql = "
				SELECT
					*
				FROM
					order_items
				WHERE
					order_items.order = ?";
			$order_items = $GLOBALS['db']->query($sql, $row['id']);
			
			foreach($order_items as $row2){
				$totalSum += $row2['cost'] * $row2['count'];
			}
			
			switch ($order[0]['shipping_alternative']) {
			    case 1:
			        $shipping = "25";
			        break;
			    case 2:
			        $shipping = "80";
			        break;
			    case 3:
					$shipping = "0";
					break;
			}
			
			//Push total sum to end of array
			//Add shipping cost
			$order[$count] = $order[$count] + array("totalSum" => $totalSum) + array("shipping" => $shipping);
			$count++;
		}
		
		return $order;
	}
	
	public function shipped($id, $value){
		$sql = "
			UPDATE
				orders
			SET
				shipped = ?
			WHERE
				id = ?";
		$GLOBALS['db']->query($sql, array($value, $id));
	}
	
	public function checkIfExist($code){
		$sql = "
			SELECT
				*
			FROM
				orders
			WHERE
				code = ?";
		$result = $GLOBALS['db']->query($sql, $code);
		if($GLOBALS['db']->countRow() > 0){
			return array(true, $result[0]['id']);
		}else{
			return false;
		}
	}
	
	public function extend($orderId){
		$sql = "
			SET SQL_SAFE_UPDATES = 0;

			UPDATE
				order_items
			SET
				used = used + (count * 10 / 100)
			WHERE
				order_items.order = ?
			AND
				category = 'SUM'";
		$GLOBALS['db']->query($sql, $orderId);
		
		$sql = "
			UPDATE
				orders
			SET
				expires = orders.expires + '63072000'
			WHERE
				id = ?";
		$GLOBALS['db']->query($sql, $orderId);
	}
	
}
