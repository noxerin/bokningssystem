<?php
class model_extras
{
	public function getExtras($pid){
		$sql = "
			SELECT
				e.*
			FROM
				extras e
			JOIN
				extras_relations er
			ON
				er.extras = e.id
			WHERE
				er.product = ?";
		return $GLOBALS['db']->query($sql, $pid);
	}	
	
	public function getSelected($ids){
		$vars = "";
		for($i = 0; count($ids) > $i; $i++){
			$vars = $vars . "? ,";
		}
		$vars = rtrim($vars, ",");
		$sql = "
			SELECT
				*
			FROM
				extras e
			WHERE
				e.id 
					IN (" . $vars . ")";

		return $GLOBALS['db']->query($sql, $ids);;	
	}
	
}