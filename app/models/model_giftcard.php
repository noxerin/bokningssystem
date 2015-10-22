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
		if($result[0]['category'] == "SUM"){
			header("Location: /admin/giftcard/show/" . $orderId);
			die;
		}
		
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
					('". $row['order'] ."', '". $row['item_id'] ."', '". $row['category'] ."', '". $row['count'] ."', '". $row['used'] ."', '". $row['cost'] ."')";
			$GLOBALS['db']->query($sql);
			
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
	
}