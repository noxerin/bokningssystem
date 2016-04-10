<?php 

class Checkout extends Controller
{
	
	public function index(){
		if(!isset($_SESSION['accepted'])){
			header("Location: /");
			$this->nxi_error('Du har inte accepterad designen och dina val. Detta kan bero på att du råkat hoppa över något val!', "Var god och försök igen, alla dina val ska vara sparade!");
			die;
		}
		//Model import
		
		$this->view('main/partials/header', "The Lodge - Presentkort");
		$this->view('main/checkout');
		$this->view('main/partials/footer');
	}
	
	public function review(){
		if(!isset($_SESSION['buyer'])){
			header("Location: /");
			$this->nxi_error('Du har inte accepterad designen och dina val. Detta kan bero på att du råkat hoppa över något val!', "Var god och försök igen, alla dina val ska vara sparade!");
			die;
		}
		//Model import
		$product = $this->model('model_product');
		$extra = $this->model('model_extras');
		
		
		//Fetch data about product and extras
		$products = $product->getProduct($_SESSION['product']);
		$data['product'] = $products[0];
		if(count($_SESSION['extras']) > 0){
			$extras = $extra->getSelected($_SESSION['extras']);			
			$data['extras'] = $extras;
		}

		//Determine if product is value sum
		if($_SESSION['count'] == "sum"){
			$data['product']['price'] = $_SESSION['sum'];
		}
				
		//Determine price for shipping and paket
		$data['shipping'] = array();
		switch($_SESSION['buyer']['alternative']){
			case 1:
				$data['shipping']['cost'] = 25;
				$data['shipping']['title'] = "Brev";
				break;
			
			case 2:
				$data['shipping']['cost'] = 80;
				$data['shipping']['title'] = "Special";
				break;
			
			case 3:
				$data['shipping']['cost'] = 0;
				$data['shipping']['title'] = "Nerladdning";
				break;
		}

		
		$this->view('main/partials/header', "The Lodge - Presentkort");
		$this->view('main/review', array($data));
		$this->view('main/partials/footer');
	}
	
	public function complete(){
		if(!isset($_SESSION['buyer'])){
			header("Location: /");
			$this->nxi_error('Du har inte accepterad designen och dina val. Detta kan bero på att du råkat hoppa över något val!', "Var god och försök igen, alla dina val ska vara sparade!");
			die;
		}
		//Model import
		$payexmodel = $this->model("model_payex");
		$product = $this->model('model_product');
		$extra = $this->model('model_extras');
		$order = $this->model("model_orders");
		
		
		//Fetch data about product and extras
		$products = $product->getProduct($_SESSION['product']);
		$data['product'] = $products[0];
		if(count($_SESSION['extras']) > 0){
			$extras = $extra->getSelected($_SESSION['extras']);			
			$data['extras'] = $extras;
			$data['extras_count'] = $_SESSION['extras'];
		}

		//Determine if product is value sum
		if($_SESSION['count'] == "sum"){
			$data['product']['price'] = $_SESSION['sum'];
		}
				
		//Determine price for shipping and paket
		$data['shipping'] = array();
		switch($_SESSION['buyer']['alternative']){
			case 1:
				$data['shipping']['cost'] = 25;
				$data['shipping']['title'] = "Brev";
				break;
			
			case 2:
				$data['shipping']['cost'] = 80;
				$data['shipping']['title'] = "Special";
				break;
			
			case 3:
				$data['shipping']['cost'] = 0;
				$data['shipping']['title'] = "Nerladdning";
				break;
		}
		
		//wait for response from payex if true Create order
		if(!isset($_SESSION['currentOrder'])){
			$orderId = $order->create();	
			$_SESSION['currentOrder'] = $orderId[0]['id'];		
		}else{
			$order->update($_SESSION['currentOrder']);
		}
		if(!$payexmodel->paymentGateway($data, $_SESSION['currentOrder'])){
			$order->remove($orderId[0]['id']);
		}
		
		$this->view('main/partials/header', "The Lodge - Presentkort");
		$this->view('main/partials/footer');
	}
	
	public function confirm(){

		$payexmodel = $this->model('model_payex');
		$authmodel = $this->model('model_auth');
		$ordermodel = $this->model('model_orders');
		$mailmodel = $this->model('model_mail');
		
		$status = $payexmodel->confirm(stripcslashes( $_GET['orderRef']));
		if($status[0]){
			$ordermodel->updateOrderStatus($_GET['orderRef'], "APPROVED");
			$order_data = $ordermodel->retriveOrderByPaymentId($_GET['orderRef']);
			$total_data = $ordermodel->retriveOrder($order_data[0]['id']);
			$mailmodel->mail_confirm($total_data);
			
			//Clear session and move it to old
			if(isset($_SESSION['old'])){
				unset($_SESSION['old']);
			}
			$tempSess = $_SESSION; 
			session_unset();
			$_SESSION['old'] = $tempSess;
			header("Refresh:3; url=/checkout/receipt");
		}else{
			$ordermodel->updateOrderStatus($_GET['orderRef'], "DENIED");
			header("Refresh:3; url=/checkout/review");
			$this->nxi_error('Ditt köp gick inte igenom', "Vänta en stund och försök igen dina val har sparats");
		}
		
		$this->view('main/partials/header', "The Lodge - Presentkort");
		$this->view('main/partials/checkout_status');
		$this->view('main/partials/footer');
	}
	
	public function receipt(){
		//Model import
		$order = $this->model('model_orders');
		$product = $this->model('model_product');
		$extra = $this->model('model_extras');
		
		$data['order'] = $order->retriveOrder($_SESSION['old']['currentOrder']);
		
		//Fetch data about product and extras
		$products = $product->getProduct($_SESSION['old']['product']);
		$data['product'] = $products[0];
		if(count($_SESSION['old']['extras']) > 0){
			$extras = $extra->getSelected($_SESSION['old']['extras']);			
			$data['extras'] = $extras;
		}

		//Determine if product is value sum
		if($_SESSION['old']['count'] == "sum"){
			$data['product']['price'] = $_SESSION['old']['sum'];
		}
				
		//Determine price for shipping and paket
		$data['shipping'] = array();
		switch($_SESSION['old']['buyer']['alternative']){
			case 1:
				$data['shipping']['cost'] = 25;
				$data['shipping']['title'] = "Brev";
				break;
			
			case 2:
				$data['shipping']['cost'] = 80;
				$data['shipping']['title'] = "Special";
				break;
			
			case 3:
				$data['shipping']['cost'] = 0;
				$data['shipping']['title'] = "Nerladdning";
				break;
		}

		
		$this->view('main/partials/header', "The Lodge - Presentkort");
		$this->view('main/partials/receipt', array($data));
		$this->view('main/partials/footer');
	}
	
	public function printer(){
		$ordermodel = $this->model("model_orders");
		
		$this->view('admin/print', $ordermodel->retriveOrder($_SESSION['old']['currentOrder']));
	}
	
	public function denied(){
		$this->view('main/partials/header', "The Lodge - Presentkort");
		$this->view('main/partials/denied');
		$this->view('main/partials/footer');
	}
	
	public function callback(){
		$payexmodel = $this->model('model_payex');
		$ordermodel = $this->model('model_orders');
		
		$payexmodel->callback();
	}
	
}