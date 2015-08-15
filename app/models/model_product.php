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
	
	public function isSum($id){
		$sql = "
			SELECT
				type
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
	
	public function updateimage($id, $fileid){
		$sql = "
			UPDATE
				products
			SET
				image = ?
			WHERE
				id = ?";
		return $GLOBALS['db']->query($sql, array($fileid, $id));
	}
	
	public function updateinfo($id, $name, $desc, $price, $type){
		$sql = "
			UPDATE
				products
			SET
				name = ?,
				products.desc = ?,
				price = ?,
				type = ?
			WHERE
				id = ?";
		return $GLOBALS['db']->query($sql, array($name, $desc, $price, $type, $id));
	}
	
	public function create($name, $image, $desc, $price, $type){
		$sql = "
			INSERT INTO
				products
				(name,image,products.desc,price,type,active)
			VALUES
				(?,?,?,?,?,1)";
		return $GLOBALS['db']->query($sql, array($name, $image, $desc, $price, $type));
	}
	
}