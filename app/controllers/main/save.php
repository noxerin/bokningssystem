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
		$product = $this->model("model_product");
		$isSum = $product->isSum($_SESSION['product']);
		unset($_SESSION['extras']);
		if($_POST['count'] > 0 && $_POST['count'] > 150 && $isSum[0]['type'] == "sum"){
				$headTo = "/extras";
				$_SESSION['count'] = "sum";
				$_SESSION['sum'] = $_POST['count'];
		}else{
			if($_POST['count'] > 0 && $_POST['count'] <= 12 && $isSum[0]['type'] != "sum"){	
				$headTo = "/extras";
				$_SESSION['count'] = $_POST['count'];	
			}else{		
				$headTo = "/productssecond";
				$this->nxi_error("Du ar valt antingen för många eller för få antal!", "");
			}
		}
		header("Location: $headTo");
	}
	
	public function extras(){
		$headTo = "/preview";
		unset($_SESSION['extras']);

		if(isset($_POST) && count($_POST) >= 1){
			foreach($_POST['extra-id'] as $key => $row){
				if($_POST['extra-count'][$key] >= 1){
					$_SESSION['extras'][$row] = $_POST['extra-count'][$key];
				}
			}
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
			$_SESSION['buyer'] = $_POST['buyer'];
			$this->nxi_error('Fel på något fält kontrollera igen!', '');
			header("Location: /checkout");
		}
	}
	
}