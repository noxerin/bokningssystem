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
	
	public function create(){
		$productmodel = $this->model("model_product");
		$extrasmodel = $this->model("model_extras");

		$this->view('admin/partials/header', 'The Lodge - Presentkort ');
		$this->view('admin/partials/menu');
		$this->view("admin/giftcard_create", array($productmodel->getAllActive(), $extrasmodel->getAll()));
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
	
	public function create_new(){
		$giftcardmodel = $this->model('model_giftcard');
		$productmodel = $this->model('model_product');
		
		$id = $giftcardmodel->create($productmodel->isSum($_POST['product-id']));
		header('Location: /admin/giftcard/show/'.$id[0]['id']);
	}
	
	public function printer($orderId){
		$ordermodel = $this->model("model_orders");
		
		$order = $ordermodel->retriveOrder($orderId);
		if(is_null($order[0][0]['image'])){
			$order[3][0]['src'] = "../brasa.jpg";
		}
		$this->view('admin/print', $order);
	}
	
}