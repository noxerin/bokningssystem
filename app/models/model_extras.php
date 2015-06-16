<?php
class model_extras
{
	public function getAll(){
		$sql = "
			SELECT
				* 
			FROM
				extras";
		return $GLOBALS['db']->query($sql);
	}
	
	public function getExtra($id){
		$sql = "
			SELECT
				*
			FROM
				extras
			WHERE
				id = ?";
		return $GLOBALS['db']->query($sql, $id);
	}
	
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
	
		public function updateimage($id, $fileid){
		$sql = "
			UPDATE
				extras
			SET
				image = ?
			WHERE
				id = ?";
		return $GLOBALS['db']->query($sql, array($fileid, $id));
	}
	
	public function updateinfo($id, $name, $desc, $price, $type){
		$sql = "
			UPDATE
				extras
			SET
				name = ?,
				extras.desc = ?,
				price = ?,
				type = ?
			WHERE
				id = ?";
		return $GLOBALS['db']->query($sql, array($name, $desc, $price, $type, $id));
	}
	
}