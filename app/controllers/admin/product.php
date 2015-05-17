<?php
class Product extends Controller_Admin
{
	public function index(){
		$productmodel = $this->model('model_product');
		
		$this->view('admin/partials/header', "The Lodge - Admin");
		$this->view('admin/partials/menu');
		$this->view('admin/product', $productmodel->getAllActive());
		$this->view('admin/partials/footer');
	}
	
	public function add(){
		$productmodel = $this->model('model_product');
		
		$this->view('admin/partials/header', "The Lodge - Admin");
		$this->view('admin/partials/menu');
		$this->view('admin/produc_add');
		$this->view('admin/partials/footer');
	}
	
	public function remove($data){
		$productmodel = $this->model('model_product');
		
		$productmodel->deactivate($data);
		header("Location: /admin/product");
	}
	
}