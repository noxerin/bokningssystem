<?php
class model_product
{
	public function getAll(){
		$sql = "
			SELECT
				*
			FROM
				products
			WHERE
				active = 1";
		return $GLOBALS['db']->query($sql);
	}	
	
	public function getProduct($id){
		$sql = "
			SELECT
				*
			FROM
				products
			WHERE
				id = ?";
		return $GLOBALS['db']->query($sql, $id);
	}
}