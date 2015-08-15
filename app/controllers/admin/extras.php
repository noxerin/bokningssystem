<?php
class Extras extends Controller_Admin
{
	public function index(){
		$extrasmodel = $this->model('model_extras');
		
		$this->view('admin/partials/header', "The Lodge - Tillägg");
		$this->view('admin/partials/menu');
		$this->view('admin/extras', $extrasmodel->getAll());
		$this->view('admin/partials/footer');
	}
	
	public function add(){
		$extrasmodel = $this->model('model_extras');		
		
		$this->view('admin/partials/header', "The Lodge - Skapa tillägg");
		$this->view('admin/partials/menu');
		$this->view('admin/extras_add');
		$this->view('admin/partials/footer');
	}
	
	public function edit($id){
		$extrasmodel = $this->model('model_extras');		
		
		$this->view('admin/partials/header', "The Lodge - Redigera tillägg");
		$this->view('admin/partials/menu');
		$this->view('admin/extras_edit', $extrasmodel->getExtra($id));
		$this->view('admin/partials/footer');
	}
	
	public function remove($data){
		$extrasmodel = $this->model('model_extras');		
		
		$extrasmodel->deactivate($data);
		$this->nxi_warning("Tillägg inaktiverat","");
		header("Location: /admin/extras");
	}
	
	
	//Call functions
	
	public function addnew(){
		$extrasmodel = $this->model('model_extras');		
		
		$name = $_POST['product']['name'];
		$desc = $_POST['product']['desc'];
		$price = $_POST['product']['price'];
		$type = $_POST['product']['type'];
				
		if(strlen($name) > 3 &&
		   strlen($desc) > 3 &&
		   strlen($price) > 0 &&
		   ($type == "person" || $type == "fixed")){
		   
		   //Move image			
		   $imageFileType = pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION);
	
		   $target_dir = "assets/images/";
		   $target_file = substr(hash('sha512', basename($_FILES["image"]["name"] . rand(1, 1000))), 0, 10);
	
		   if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
		   		$this->nxi_error("Bilden har inte ett stött format!", "Testa med jpg,png,jpeg,gif");
			}else{
				if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir.$target_file.".".$imageFileType)){
					if($extrasmodel->create($name,$target_file.".".$imageFileType,$desc,$price,$type)){
						$this->nxi_warning('Tillägg tillagd', '');
				    }
				}else{
					$this->nxi_error("Fel uppstod vi flytt av bild från temporära platsen!", "");		
				}
			}

		}else{
			$this->nxi_error('Ett eller flera fält saknar text', 'kontrollera all text en gång till');
		}
		header("Location: /admin/extras/");
	}
	
	public function update(){
		$extrasmodel = $this->model('model_extras');		
		
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

		   if($extrasmodel->updateinfo($id,$name,$desc,$price,$type)){
			   $this->nxi_warning('Tillägget uppdaterad', '');
		   }

		}else{
			$this->nxi_error('Ett eller flera fält saknar text', 'kontrollera all text en gång till');
		}
		header("Location: /admin/extras/edit/".$id);
	}
	
	public function updateimg(){
		$id = $_POST['id'];
		$oldimg = $_POST['oldimg'];
		$extrasmodel = $this->model('model_extras');		
		
		$imageFileType = pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION);

		$target_dir = "assets/images/";
		$target_file = substr(hash('sha512', basename($_FILES["image"]["name"] . rand(1, 1000))), 0, 10);

		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
			    $this->nxi_error("Bilden har inte ett stött format!", "Testa med jpg,png,jpeg,gif");
		}else{
			if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir.$target_file.".".$imageFileType)){
				$extrasmodel->updateimage($id, $target_file.".".$imageFileType);
				$this->nxi_warning("Bilden är uppladdad!", "");
				unlink("assets/images/".$oldimg);
			}else{
				$this->nxi_error("Fel uppstod vi flytt av bild från temporära platsen!", "");		
			}
		}
		header("Location: /admin/extras/edit/".$id);
	}
	

}