<?php 

class Main extends Controller
{
	public function index($param = null)
	{
		//Model import
		
		$this->view('main/partials/header', "Admin page - HOME");
		$this->view('main/main');
		$this->view('main/partials/footer');
	}
}
?>