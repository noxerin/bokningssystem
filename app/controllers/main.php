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
	
	public function productssecond(){
		$product = $this->model('model_product');
		
		$products = $product->getProduct($_SESSION['product']);
		
		$this->view('main/partials/header', "The Lodge - Presentkort");
		$this->view('main/products_second', $products);
		$this->view('main/partials/footer');
	}
	
	public function extras(){
		$product = $this->model('model_product');
		$extra = $this->model('model_extras');
		
		$extras = $extra->getExtras($_SESSION['product']);
		
		$this->view('main/partials/header', "The Lodge - Presentkort");
		$this->view('main/extras', $extras);
		$this->view('main/partials/footer');
	}
	
	public function preview(){	
		$images = $this->model('model_images');
		$product = $this->model('model_product');
			
		$image = $images->getImage($_SESSION['image']);
		$products = $product->getProduct($_SESSION['product']);
		$data[0] = $image[0];
		$data[1] = $products[0];
		
		$this->view('main/partials/header', "The Lodge - Presentkort");
		$this->view('main/preview', $data);
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
				if($_POST['product'] <= 0){
					$headTo = "/products";
					$this->nxi_error('Du har inte valt någon upplevelse!', '');
				}else{
					$headTo = "/productssecond";
					$_SESSION['product'] = $_POST['product'];
				}
				break;
			case "categorieschoice":
				$headTo = "/extras";
				if($_POST['count'] > 0 && $_POST['count'] <= 12){
					$_SESSION['count'] = $_POST['count'];	
				}else{		
					$headTo = "/productssecond";
					$this->nxi_error("Du ar valt antingen för många eller för få antal!", "");
				}
				break;
			case "extras":
				$headTo = "/preview";
				if(isset($_POST['extras']) && strlen($_POST['extras'][0]) >= 1){
					$_SESSION['extras'] = explode(",", $_POST['extras']);
				}else{
					$_SESSION['extras'] = "";
				}
				break;
		}
		header("Location: $headTo");
	}
}
?>