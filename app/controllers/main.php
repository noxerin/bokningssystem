<?php 

class Main extends Controller
{
	public function index($param = null)
	{
		//Model import
		$image = $this->model("model_images");
		$images = $image->getAll();
		
		$this->view('main/partials/header', "The Lodge - Presentkort");
		$this->view('main/main', $images);
		$this->view('main/partials/footer');
	}
	
	public function products(){
		$product = $this->model('model_product');
		
		$products = $product->getAll();
		
		$this->view('main/partials/header', "The Lodge - Presentkort");
		$this->view('main/products', $products);
		$this->view('main/partials/footer');
	}
	
	public function productsInfo(){
		$product = $this->model('model_product');
		
		$products = $product->getProduct($_SESSION['product']);
		
		$this->view('main/partials/header', "The Lodge - Presentkort");
		$this->view('main/products_info', $products);
		$this->view('main/partials/footer');
	}
	
	public function save($data){		
		$headTo = "";
		switch($data){
			case "image":
				$headTo = "/products";
				$_SESSION['image'] = $_POST['image'];
				$_SESSION['message'] = $_POST['message'];
				break;
			case "category":
				if($_POST['product'] == "none"){
					$headTo = "/products";
					$this->nxi_error('Du har inte valt någon upplevelse!', '');
				}else{
					$headTo = "/productsinfo";
				}
				$_SESSION['product'] = $_POST['product'];
				break;
			case "extra":
				break;
		}
		header("Location: $headTo");
	}
}
?>