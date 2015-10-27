<?php
class Giftcard extends Controller_Admin
{
	
	public function index(){
		$this->view('admin/partials/header', 'The Lodge - Presentkort ');
		$this->view('admin/partials/menu');
		$this->view("admin/giftcard");
		$this->view('admin/partials/footer');
	}
	
	public function search($data = null){
		$ordermodel = $this->model("model_orders");
		
		$this->view('admin/partials/header', 'The Lodge - Presentkort ');
		$this->view('admin/partials/menu');
		$this->view("admin/giftcard", $ordermodel->retriveGiftcardSearchOrders($data));
		$this->view('admin/partials/footer');
	}
	
	public function show($orderId){
		$ordermodel = $this->model("model_orders");
		
		$this->view('admin/partials/header', 'The Lodge - Presentkort ');
		$this->view('admin/partials/menu');
		$this->view("admin/giftcard_show", $ordermodel->retriveOrder($orderId));
		$this->view('admin/partials/footer');
	}
	
	public function edit($orderId){
		$ordermodel = $this->model("model_orders");
		
		$this->view('admin/partials/header', 'The Lodge - Presentkort ');
		$this->view('admin/partials/menu');
		$this->view('admin/giftcard_edit', $ordermodel->retriveOrder($orderId));
		$this->view('admin/partials/footer');
	}
	
	
	//Call functions
	
	public function convert($orderId){
		$giftcardmodel = $this->model("model_giftcard");
		
		if($giftcardmodel->convertToSum($orderId)){
			$this->nxi_warning('Lyckad konvertering','');
			header("Location: /admin/giftcard/show/".$orderId);
		}
	}
	
	public function save($orderId){
		$ordermodel = $this->model("model_orders");
		$giftcardmodel = $this->model("model_giftcard");
		
		$productCount = $_GET['product'];
		$addonCountArr = $_GET['addons'];
		
		if($giftcardmodel->editUsed($orderId, $productCount, $addonCountArr,  $ordermodel->retriveOrder($orderId))){
			$this->nxi_warning("Antalet använda uppdaterat","");
			header("Location: /admin/giftcard/show/".$orderId);
		}else{
			$this->nxi_warning("Uppdatering misslyckades!","Kontrollera och försök igen");
			header("Location: /admin/giftcard/edit/".$orderId);
		}
	}
	
	public function extend($orderId){
		$ordermodel = $this->model("model_orders");
		
		$ordermodel->extend($orderId);
		
		header("Location: /admin/giftcard/show/".$orderId);
	}
	
}