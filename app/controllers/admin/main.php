<?php
class Main extends Controller_Admin
{
	
	public function index()
	{	
		$this->view('admin/partials/header', "The Lodge - Admin");
		$this->view('admin/partials/menu');
		$this->view('admin/main');
		$this->view('admin/partials/footer');
	}
}