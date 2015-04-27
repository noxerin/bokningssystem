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
}