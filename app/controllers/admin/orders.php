<?php
class Orders extends Controller_Admin
{
	public function index(){
		$productmodel = $this->model('model_product');
		
		$this->view('admin/partials/header', "The Lodge - Ordrar");
		$this->view('admin/partials/menu');
		$this->view('admin/orders');
		$this->view('admin/partials/footer');
	}
	
	//Call functions
	
}