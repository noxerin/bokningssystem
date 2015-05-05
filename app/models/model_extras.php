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
	
}