<?php
class model_export
{	
	
	public function generate($order_array, $type, $dateStart = null, $dateStop = null){
		
		if($type == "ORDER"){
			$filename = "The Lodge_order_" . $order_array['id'] . ".xls";
		}else if($type == "DAY" || "WEEK" || "MONTH" || "YEAR" || "ALL"){	
			if(isset($dateStart) && isset($dateStop)){
				$filename = "The Lodge_" . $type . "_" . date("Y-M-d", $dateStart) . ' till ' . date("Y-M-d", $dateStop) . ".xls";	
			}else if($type == "ALL"){
				$filename = "The Lodge_" . $type . ".xls";
			}else{
				$filename = "The Lodge_" . $type . "_" . date("Y-M-d", $dateStart) . ".xls";
			}
		}

		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Content-Type: application/vnd.ms-excel");
		
		//Set excel headers
		$headers = array(
			'Id',
			'Förnamn',
			'Efternamn',
			'Email',
			'Address',
			'Postnummer',
			'Stad',
			'Land',
			'Mobil',
		    'Datum',
			'Frakt Alternativ',
			'Total Summa',
			'Frakt'
		);
		
		$data = array();
		if($type == "ORDER"){
			$data += array($order_array);
		}else{
			foreach($order_array as $row){
				array_push($data, $row); 
			}
		}
		
		array_unshift($data, $headers);
		
		model_export::prepare($data);

	}
	
	function cleanData($str)
	{
		$str = preg_replace("/\t/", "\\t", $str);
	    $str = preg_replace("/\r?\n/", "\\n", $str);
	}
	
	public function prepare($data){
		header("Content-Type: text/plain");

		foreach($data as $row) {
		    array_walk($row, array($this, 'cleanData'));
		    echo implode("\t", array_values($row)) . "\r\n";
		}
		
	}

}