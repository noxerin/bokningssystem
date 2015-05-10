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
		$extra = $this->model('model_extras');
			
		$image = $images->getImage($_SESSION['image']);
		$products = $product->getProduct($_SESSION['product']);
		
		$data[0] = $image[0];
		$data[1] = $products[0];
		
		if(strlen($_SESSION['extras'][0]) > 0){
			$extras = $extra->getSelected($_SESSION['extras']);			
			$data[2] = $extras;
		}
		
		$this->view('main/partials/header', "The Lodge - Presentkort");
		$this->view('main/preview', $data);
		$this->view('main/partials/footer');
	}
	
}
?>