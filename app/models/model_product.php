<?php
class model_product
{
	public function getAllActive(){
		$sql = "
			SELECT
				*
			FROM
				products
			WHERE
				active = 1";
		return $GLOBALS['db']->query($sql);
	}	
	
	public function getAll(){
		$sql = "
			SELECT
				*
			FROM
				products";
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
	
	public function deactivate($id){
		$sql = "
			UPDATE
				products
			SET
				active = 0
			WHERE
				id = ?";
		return $GLOBALS['db']->query($sql, $id);
	}
	
}