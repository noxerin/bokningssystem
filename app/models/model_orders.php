<?php
class model_orders
{
	
	public function retriveLastOrders($count){
		$sql = "
			SELECT
				*
			FROM
				orders
			LIMIT $count";
			
		$result = $GLOBALS['db']->query($sql);			
			
		return null;--------
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
	
}
