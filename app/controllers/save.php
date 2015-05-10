<?php 

class Save extends Controller
{
	
	public function image(){
		$headTo = "/products";
		$_SESSION['image'] = $_POST['image'];
		$_SESSION['message'] = $_POST['message'];
		header("Location: $headTo");
	}

	public function category(){
		if($_POST['product'] <= 0){
			$headTo = "/products";
			$this->nxi_error('Du har inte valt någon upplevelse!', '');
		}else{
			$headTo = "/productssecond";
			$_SESSION['product'] = $_POST['product'];
		}
		header("Location: $headTo");
	}	
	
	public function categorieschoice(){
		$headTo = "/extras";
		if($_POST['count'] > 0 && $_POST['count'] <= 12){
			$_SESSION['count'] = $_POST['count'];	
		}else{		
			$headTo = "/productssecond";
			$this->nxi_error("Du ar valt antingen för många eller för få antal!", "");
		}
		header("Location: $headTo");
	}
	
	public function extras(){
		$headTo = "/preview";
		if(isset($_POST['extras']) && strlen($_POST['extras'][0]) >= 1){
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
	
}