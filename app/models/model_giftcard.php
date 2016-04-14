<?php
class model_giftcard
{
	
	public function convertToSum($orderId){
		
		$newSum = 0;
		
		//Check if already sum
		$sql = "
			SELECT
				category
			FROM
				order_items
			WHERE
				order_items.order = ?";
		$result = $GLOBALS['db']->query($sql, $orderId);
		
		
		//Select order items and add the sum together minus any used ones
		$sql = "
			SELECT
				*
			FROM
				order_items
			WHERE
				order_items.order = ?";
		$result = $GLOBALS['db']->query($sql, $orderId);
		
		foreach($result as $row){
			$count = $row['count'];
			$used = $row['used'];
			$amount = $count - $used;
			
			$newSum += $row['cost'] * $amount; 	
		}
		
		//Sum calculation done move items to history for traceback and insert new sum item
		foreach($result as $row){
			$sql = "
				INSERT INTO
					order_items_history
						(order_items_history.order, item_id, category, count, used, cost)
				VALUES
					(?, ?, ?, ?, ? ,?)";
			$GLOBALS['db']->query($sql, array($row['order'], $row['item_id'], $row['category'], $row['count'], $row['used'], $row['cost']));

			//If fail dont remove from db
			if($GLOBALS['db']->affectedRow() == 0){
				header("Location: /admin/giftcard/show/" . $orderId);
				die;
			}
		}
		
		$sql = "
			DELETE FROM
				order_items
			WHERE
				order_items.order = ?";
		$GLOBALS['db']->query($sql, $orderId);
		
		//Find sum product
		$sql = "
			SELECT 
				id
			FROM
				products
			WHERE
				type = 'sum'";
		$sum = $GLOBALS['db']->query($sql);
		//Then finally insert newly calculated restsum
		$sql = "
			INSERT INTO
				order_items
					(order_items.order, item_id, category, count, used, cost)
			VALUES
				('" . $orderId . "', '" . $sum[0]['id'] . "', 'SUM', '" . $newSum . "', '0', '1')";
		$GLOBALS['db']->query($sql);
		
		return true;
	}
	
	public function editUsed($orderId, $productCount, $addonCountArr, $orderArr){

		if($orderArr[1]['count'] <= $productCount){
			$sql = "
				SET SQL_SAFE_UPDATES = 0;
				UPDATE
					order_items
				SET
					used = ?
				WHERE
					order_items.order = ?
				AND
					((category = 'SUM') OR (category = 'PRODUCT')) ";
			$GLOBALS['db']->query($sql, array($productCount, $orderId));
			
			foreach($addonCountArr as $key => $row){
				$sql = "
					SET SQL_SAFE_UPDATES = 0;
					UPDATE
						order_items
					SET
						used = ?
					WHERE
						order_items.order = ?
					AND
						category = 'EXTRAS'
					AND
						item_id = ?";
				$GLOBALS['db']->query($sql, array($row, $orderId, $orderArr[2][$key]['item_id']));
			}
			
			return true;
		}else{
			return false;
		}
	}
	
	public function create($isSum){
		//Create order in our system
		$sql = "
				INSERT INTO 
					orders 
					(fname, lname, email, address, postal, city, country, phone, shipping_alternative, message, code, time, expires, status, type)
				VALUES 
					(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
		$GLOBALS['db']->query($sql, 
							array($_POST['fname'],
								$_POST['lname'],
								$_POST['email'],
								$_POST['address'],
								$_POST['postal'],
								$_POST['city'],
								$_POST['country'],
								$_POST['phone'],
								"3",
								$_POST['message'],
								substr(hash('sha512', uniqid() . rand(1, 1000)), 1, 8),
								time(),
								$_POST['expires']*2592000,
								"APPROVED",
								$_POST['type']));
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
		if($isSum[0]['type'] == "sum"){
			$count = $_POST['product-count'];
			$category = "SUM";
		}else{
			$count = $_POST['product-count'];
			$category = "PRODUCT";
		}
		
		//Get current price
		$sql = "SELECT
					price
				FROM
					products
				WHERE
					id = ?";
		$cost = $GLOBALS['db']->query($sql, $_POST['product-id']);
		
		//Initiate insert
		$sql = "INSERT INTO 
					order_items
					(`order`, item_id, category, count, cost) 
				VALUES 
					(?,?,?,?,?)";
		$GLOBALS['db']->query($sql, array($id[0]['id'], $_POST['product-id'], $category, $count, $cost[0]['price']));
		
		//Insert every extras
		if(count($_POST['extras']) >= 1){
			foreach($_POST['extras'] as $key => $row){
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
						(?,?,?,?,?)";
				$GLOBALS['db']->query($sql, array($id[0]['id'], $row, "EXTRAS", $_POST['extras-count'][$key] ,$cost[0]['price']));
			}
		}
		return $id;	
	}
	
}