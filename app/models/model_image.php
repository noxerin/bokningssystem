<?php
class model_image
{
	public function getAll(){
		$sql = "
			SELECT
				*
			FROM
				images";
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
	
	public function add($src){
		$sql = "
			INSERT INTO
				images
					(src)
			VALUES
				(?)";
		$GLOBALS['db']->query($sql, $src);
	}
}