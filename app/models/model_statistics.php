<?php
class model_statistics
{
	
	public function year_report(){
		$year = date('Y');
		$start = mktime(0, 0, 0, 1, 1, $year);
		$end = mktime(0, 0, 0, 12, 31, $year);
		
		$sql = "
			SELECT
				*
			FROM
				orders
			WHERE
				time 
					BETWEEN 
						? and ?";
		$data = $GLOBALS['db']->query($sql, array($start, $end));
		
		$data_array = array("Januari" => 0, "Februari" => 0, "Mars" => 0, "April" => 0, "Maj" => 0, "Juni" => 0, "Juli" => 0, "Augusti" => 0, "September" => 0, "Oktober" => 0, "November" => 0, "December" => 0);
		
		foreach($data as $row){
			switch(date('M', $row['time'])){
				case "Jan":
					$data_array['Januari']++;
				break;
				case "Feb":
					$data_array['Februari']++;
				break;
				case "Mar":
					$data_array['Mars']++;
				break;
				case "Apr":
					$data_array['April']++;
				break;
				case "May":
					$data_array['Maj']++;
				break;
				case "Jun":
					$data_array['Juni']++;
				break;
				case "Jul":
					$data_array['Juli']++;
				break;
				case "Aug":
					$data_array['Augusti']++;
				break;
				case "Sep":
					$data_array['September']++;
				break;
				case "Oct":
					$data_array['Oktober']++;
				break;
				case "Nov":
					$data_array['November']++;
				break;
				case "Dec":
					$data_array['December']++;
				break;
			}
		}
		
		return $data_array;
		
	}
	
	public function most_sold(){
		
		$sql = "
			SELECT      
				item_id,
				COUNT(`item_id`) AS `item_occurrence`,
				products.name
			FROM
				order_items
			JOIN
				products
					ON order_items.item_id = products.id
			WHERE
				category = 'PRODUCT'
					OR
				category = 'SUM'
			GROUP BY 
				item_id
			ORDER BY 
				`item_occurrence` 
						DESC
			LIMIT
			    5";
		
		return $GLOBALS['db']->query($sql);
	}
	
	public function most_sold_extras(){
		$sql = "
			SELECT      
				item_id,
				COUNT(`item_id`) AS `item_occurrence`,
				extras.name
			FROM
				order_items
			JOIN
				extras
					ON order_items.item_id = extras.id
			WHERE
				category = 'EXTRAS'
			GROUP BY 
				item_id
			ORDER BY 
				`item_occurrence` 
						DESC
			LIMIT
			    5";
		
		return $GLOBALS['db']->query($sql);
	}
	
}