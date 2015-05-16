<?php
class Image extends Controller_Admin
{
	public function index(){
		$imagemodel = $this->model('model_image');
		
		$this->view('admin/partials/header', "The Lodge - Bilder");
		$this->view('admin/partials/menu');
		$this->view('admin/image', $imagemodel->getAll());
		$this->view('admin/partials/footer');
	}
	
	public function remove($data){
		$imagemodel = $this->model('model_image');
		$result = $imagemodel->getImage($data);

		if(unlink("assets/images/".$result[0]['src'])){
			$imagemodel->remove($data);	
			$this->nxi_warning("Bilden är borttagen!", "");
			header("Location: /admin/image");
		}else{
			$this->nxi_error("Fel inträffade när bilden försöktes ta bort", "Försök igen!");
			header("Location: /admin/image");
		}
	}
	
	public function add(){
		$imagemodel = $this->model('model_image');
		
		$imageFileType = pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION);

		$target_dir = "assets/images/";
		$target_file = substr(hash(sha512, basename($_FILES["image"]["name"] . rand(1, 1000))), 0, 10);

		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
			    $this->nxi_error("Bilden har inte ett stött format!", "Testa med jpg,png,jpeg,gif");
		}else{
			if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir.$target_file.".".$imageFileType)){
				$imagemodel->add($target_file.".".$imageFileType);
				$this->nxi_warning("Bilden är uppladdad!", "");
			}else{
				$this->nxi_error("Fel uppstod vi flytt av bild från temporära platsen!", "");		
			}
		}
		header("Location: /admin/image");
	}
}