<?php
class model_orders
{
	
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
				((fname LIKE ?) OR (lname LIKE ?) OR (address LIKE ?) OR (code LIKE ?) OR (klarna LIKE ?) OR (id LIKE ?) OR (FROM_UNIXTIME(time, '%Y-%m-%d') LIKE ?) OR (status LIKE ?))
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
				((fname LIKE ?) OR (lname LIKE ?) OR (address LIKE ?) OR (code LIKE ?) OR (klarna LIKE ?) OR (id LIKE ?) OR (FROM_UNIXTIME(time, '%Y-%m-%d') LIKE ?) OR (status LIKE ?))
			AND	
				status = 'ACTIVE'
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
	
	public function retriveOrderByKlarnaId($klarna){
		$sql = "
			SELECT
				*
			FROM
				orders
			WHERE
				klarna = ?";
		return $GLOBALS['db']->query($sql, $klarna);
	}
	
	public function markAs($klarnaId, $mark){
		$sql = "
			UPDATE
				orders
			SET
				status = ?
			WHERE
				klarna = ?";
		$GLOBALS['db']->query($sql, array($mark, $klarnaId));
	}
	
	public function updateKlarnaNumber($currentKlarnaId, $klarnaInvoice){
		$sql = "
			UPDATE
				orders
			SET
				klarna = ?
			WHERE
				klarna = ?";
		$GLOBALS['db']->query($sql, array($klarnaInvoice, $currentKlarnaId));
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
				id= ?";
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
	
}
