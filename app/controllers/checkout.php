<?php 

class Checkout extends Controller
{
	public function index(){
		if(!isset($_SESSION['accepted'])){
			header("Location: /preview");
			$this->nxi_error('Du har inte accepterad designen och dina val. Detta kan bero på att du råkat hoppa över något val!', "Var god och försök igen, alla dina val ska vara sparade!");
			die;
		}
		//Model import
		
		$this->view('main/partials/header', "The Lodge - Presentkort");
		$this->view('main/checkout');
		$this->view('main/partials/footer');

	}
	
	public function pay(){
		$klarna = $this->model('model_klarna');
		$product = $this->model('model_product');
		$extras = $this->model('model_extras');
		
		//Fetch product info
		$selectedProduct = $product->getProduct($_SESSION['product']);
		$productCount = $_SESSION['count'];

		//Fetch extras info
		$selectedExtra = $extras->getSelected($_SESSION['extras']);


		//Prepeare article array
		// Quantity, Article number, Article name/title, Price, VAT, Discount, Price is including VAT.
		$prepArticle = array(array($productCount, "Main", "Presentkort - Sunday Brunch", 295.99, 25, 0, KlarnaFlags::INC_VAT));
		foreach($selectedExtra as $row){
			array_push($prepArticle, array(1, "Extra", "Tillägg - " . $row['name'], $row['price'], 25, 0, KlarnaFlags::INC_VAT));
		}		
		
		$prepShipping = 75;
		$personNummer = '4103219202';
		//Email, Telephone not needed, Cellphone, First name, Last name, C/O not needed, Streed addr, zip code, City, Country, house number not needed, house ext not needed, PersonNnummer
		$prepAddr = array('always_approved@klarna.com', '', '0762560000', 'Testperson-se', 'Approved', '', 'Stårgatan 1', '12345', 'Ankeborg', KlarnaCountry::SE, null, null, $personNummer);
		
		//Reserve the amount on the customers account
		$resnumber = $klarna->makeReservation($prepArticle, $prepShipping, $prepAddr);
		if(!$resnumber[0]){
			$this->nxi_error("Felkod: " . $resnumber[1], $resnumber[2]);
		}
		//Payment insertion into database
		
		//Create presentkort
		
		//Debit customer
		//Change paymentstatus from VERIFYING to PAID
	}
	
	public function cancel($data){
		$klarna = $this->model('model_klarna');
		$klarna->cancleReservation($data);
	}
	
}