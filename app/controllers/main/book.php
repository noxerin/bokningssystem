<?php
class Book extends Controller{
	
	public function index(){
		//Model import
		
		$this->view('main/partials/header', "The Lodge - Presentkort");
		$this->view('main/book');
		$this->view('main/partials/footer');
	}
	
	public function show(){
		$ordermodel = $this->model('model_orders');
		
		$result = $ordermodel->checkIfExist($_GET['code']);
		
		if(!$result[0]){
			$this->nxi_error('Du har antingen skrivit in fel kod eller så finns ej denna order!','');
			header('Location: /book/');
		}else{
			
			$data = $ordermodel->retriveOrder($result[1]);
			
			$this->view('main/partials/header', "The Lodge - Boka");
			$this->view('main/book_show', $data);
			$this->view('main/partials/footer');	
		}
	}
	
}