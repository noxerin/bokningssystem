<?php
class Model
{
	public $db;
	public function __Construct()
	{
		$db = new Database($GLOBALS['config']);	
	}	
	
}