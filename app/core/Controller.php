<?php

class Controller
{
	/*
	*
	* Error handling 
	*
	*/
	public function __construct(){
		if(isset($_SESSION['error'])){
			$this->view('main/partials/error', $_SESSION['error']);
			unset($_SESSION['error']);
		}
		if(isset($_SESSION['warning'])){
			$this->view('main/partials/warning', $_SESSION['warning']);
			unset($_SESSION['warning']);
		}
	}
	
	public function nxi_error($reason, $message){
		$_SESSION['error']['reason'] = $reason;
		$_SESSION['error']['message'] = $message;
	}
	public function nxi_warning($reason, $message){
		$_SESSION['warning']['reason'] = $reason;
		$_SESSION['warning']['message'] = $message;
	}
		
	public function model($model)
	{
		require_once 'app/models/' . $model . '.php';
		return new $model;
	}
	
	public function view($view, $data = [])
	{
		require_once 'app/views/' . $view . '.php';
	}
	
}