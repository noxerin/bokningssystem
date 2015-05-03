<?php
class model_images
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
}