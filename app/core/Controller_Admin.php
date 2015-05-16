<?php
	
class Controller_Admin extends Controller
{
	function __construct(){
		$this->showError();
		$this->checkAuth();
		ob_start();
	}
	
	private function checkAuth(){
		if($_SESSION['admin']['auth'] != TRUE){
			header("Location: /admin/auth");
			die;
		}
	}
}