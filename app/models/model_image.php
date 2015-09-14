<?php
class model_image
{
	public function getAll(){
		$sql = "
			SELECT
				*
			FROM
				images
			WHERE
				active = 1";
		return $GLOBALS['db']->query($sql);
	}
	
	public function getImage($id){
		$sql = "
			SELECT
				*
			FROM
				images
			WHERE
				id = ?";
		return $GLOBALS['db']->query($sql, $id);
	}
	
	public function remove($id){
		$sql = "
			DELETE FROM
				images
			WHERE
				id = ?";
		$GLOBALS['db']->query($sql, $id);
	}
	
	public function inactivate($id){
		$sql = "
			UPDATE
				images
			SET
				active = 0
			WHERE
				id = ?";
		$GLOBALS['db']->query($sql, $id);
	}
	
	public function add($src){
		$sql = "
			INSERT INTO
				images
					(src)
			VALUES
				(?)";
		$GLOBALS['db']->query($sql, $src);
	}
	
	public function isUsed($id){
		$sql = "
			SELECT
				*
			FROM
				orders
			WHERE
				image = ?";
		$GLOBALS['db']->query($sql, $id);
		
		if($GLOBALS['db']->countRow() >= 1){
			return true;
		}else{
			return false;
		}
	}
}