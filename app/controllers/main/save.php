<?php 

class Save extends Controller
{
	
	public function image(){
		$image = $this->model('model_images');
		if($image->getImage($_POST['image'])){
			$_SESSION['image'] = $_POST['image'];	
			$headTo = "/products";
		}else{
			$this->nxi_error("Bilden du försökt välja finns inte!", "Försök igen!");
			$headTo = "/";
		}
		$_SESSION['message'] = $_POST['message'];
		header("Location: $headTo");
	}

	public function category(){
		$product = $this->model('model_product');
		if($product->getProduct($_POST['product'])){
			$headTo = "/productssecond";
			$_SESSION['product'] = $_POST['product'];
		}else{
			$headTo = "/products";
			$this->nxi_error('Kategorin du försökte välja finns inte!', 'Var god försök igen!');
		}
		header("Location: $headTo");
	}	
	
	public function categorieschoice(){
		if($_POST['count'] > 0 && $_POST['count'] <= 12){	
			$headTo = "/extras";
			$_SESSION['count'] = $_POST['count'];	
		}else{		
			$headTo = "/productssecond";
			$this->nxi_error("Du ar valt antingen för många eller för få antal!", "");
		}
		header("Location: $headTo");
	}
	
	public function extras(){
		$headTo = "/preview";
		if(isset($_POST['extras']) && strlen($_POST['extras']) >= 1){
			$_SESSION['extras'] = explode(",", $_POST['extras']);
		}else{
			$_SESSION['extras'] = "";
		}
		header("Location: $headTo");
	}
	
	public function accepted(){
		$_SESSION['accepted'] = "yes";
		header("Location: /checkout");
	}
	
	public function customer(){
		if(strlen($_POST['buyer']['fname']) > 1 &&
		   strlen($_POST['buyer']['lname']) > 1 &&
		   strpos($_POST['buyer']['email'], "@") &&
		   strpos($_POST['buyer']['email'], ".") &&
		   strlen($_POST['buyer']['address']) > 2 &&
		   strlen($_POST['buyer']['postal']) == 5 &&
		   strlen($_POST['buyer']['city']) > 1 &&
		   in_array($_POST['buyer']['country'], array("SE", "DK", "NO")) &&
		   strlen($_POST['buyer']['phone']) > 4 &&
		   in_array($_POST['buyer']['alternative'], array('1', '2', '3'))){
			$_SESSION['buyer'] = $_POST['buyer'];
			header('Location: /checkout/review');
		}else{
			$this->nxi_error('Fel på något fält kontrollera igen!', '');
			header("Location: /checkout");
		}
	}
	
}