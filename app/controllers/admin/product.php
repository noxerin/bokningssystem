<?php
class Product extends Controller_Admin
{
	public function index(){
		$productmodel = $this->model('model_product');
		
		$this->view('admin/partials/header', "The Lodge - Kategorier");
		$this->view('admin/partials/menu');
		$this->view('admin/product', $productmodel->getAllActive());
		$this->view('admin/partials/footer');
	}
	
	public function add(){
		$productmodel = $this->model('model_product');
		
		$this->view('admin/partials/header', "The Lodge - Skapa kategori");
		$this->view('admin/partials/menu');
		$this->view('admin/product_add');
		$this->view('admin/partials/footer');
	}
	
	public function remove($data){
		$productmodel = $this->model('model_product');
		
		$productmodel->deactivate($data);
		$this->nxi_warning("Kategori inaktiverad","");
		header("Location: /admin/product");
	}
	
	public function edit($id){
		$productmodel = $this->model('model_product');
		
		$this->view('admin/partials/header', "The Lodge - Redigera kategori");
		$this->view('admin/partials/menu');
		$this->view('admin/product_edit', $productmodel->getProduct($id));
		$this->view('admin/partials/footer');
	}
	
	//Call functions
	
	public function update(){
		$productmodel = $this->model("model_product");
		
		$id = $_POST['product']['id'];
		$name = $_POST['product']['name'];
		$desc = $_POST['product']['desc'];
		$price = $_POST['product']['price'];
		$type = $_POST['product']['type'];
				
		if(isset($id) &&
		   strlen($name) > 3 &&
		   strlen($desc) > 5 &&
		   strlen($price) > 0 &&
		   ($type == "person" || $type == "fixed")){

		   if($productmodel->updateinfo($id,$name,$desc,$price,$type)){
			   $this->nxi_warning('Kategori uppdaterad', '');
		   }

		}else{
			$this->nxi_error('Ett eller flera fält saknar text', 'kontrollera all text en gång till');
		}
		header("Location: /admin/product/edit/".$id);
	}
	
	public function updateimg(){
		$id = $_POST['id'];
		$oldimg = $_POST['oldimg'];
		$productmodel = $this->model('model_product');
		
		$imageFileType = pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION);

		$target_dir = "assets/images/";
		$target_file = substr(hash('sha512', basename($_FILES["image"]["name"] . rand(1, 1000))), 0, 10);

		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
			    $this->nxi_error("Bilden har inte ett stött format!", "Testa med jpg,png,jpeg,gif");
		}else{
			if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir.$target_file.".".$imageFileType)){
				$productmodel->updateimage($id, $target_file.".".$imageFileType);
				$this->nxi_warning("Bilden är uppladdad!", "");
				unlink("assets/images/".$oldimg);
			}else{
				$this->nxi_error("Fel uppstod vi flytt av bild från temporära platsen!", "");		
			}
		}
		header("Location: /admin/product/edit/".$id);
	}
	
}