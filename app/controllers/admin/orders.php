<?php
class Orders extends Controller_Admin
{
	public function index(){
		$ordermodel = $this->model('model_orders');
		
		$ordermodel->calculateTotalSum(9);
		
		$this->view('admin/partials/header', "The Lodge - Ordrar");
		$this->view('admin/partials/menu');
		$this->view('admin/orders', $ordermodel->retriveLastOrders(10));
		$this->view('admin/partials/footer');
	}
	
	//Call functions
	
}