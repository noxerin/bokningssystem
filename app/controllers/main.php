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
	
	public function category(){
		$this->view('main/partials/header', "The Lodge - Presentkort");
		$this->view('main/partials/footer');
	}
	
	
	public function save($data){		
		$headTo = "";
		switch($data){
			case "image":
				$headTo = "/category";
				$_SESSION['image'] = $_POST['image'];
				$_SESSION['message'] = $_POST['message'];
				break;
			case "category":
				break;
			case "addon":
				break;
		}
		header("Location: $headTo");
	}
}
?>