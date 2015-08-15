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
		$klarna = $this->model('model_klarna');
		$product = $this->model('model_product');
		$extra = $this->model('model_extras');
		
		
		//Fetch data about product and extras
		$products = $product->getProduct($_SESSION['product']);
		$data['product'] = $products[0];
		if(strlen($_SESSION['extras'][0]) > 0){
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
		$this->view('main/review', array($klarna->checkout($data), $data));
		$this->view('main/partials/footer');
	}
	
	public function complete(){
		if(!isset($_SESSION['buyer'])){
			header("Location: /");
			$this->nxi_error('Du har inte accepterad designen och dina val. Detta kan bero på att du råkat hoppa över något val!', "Var god och försök igen, alla dina val ska vara sparade!");
			die;
		}
		//Model import
		$klarna = $this->model('model_klarna');
		
		$this->view('main/partials/header', "The Lodge - Presentkort");
		$this->view('main/partials/empty', $klarna->complete($_GET['klarna_id']));
		$this->view('main/partials/footer');
	}
	
	public function confirm(){
		$klarna = $this->model('model_klarna');
		$klarna->confirm($_GET['klarna_order']);
	}
	
}