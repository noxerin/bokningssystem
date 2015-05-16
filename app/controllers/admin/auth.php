<?php
class Auth extends Controller
{
	public function index(){
		$this->view('admin/partials/header', "The Lodge - Login");
		$this->view('admin/auth');
		$this->view('admin/partials/footer');
	}
	
	public function logIn(){
		$authmodel = $this->model('model_auth');
		
		$user = $_POST['user'];
		$pass = $_POST['pass'];
		
		$hash = substr(hash("sha512", $pass."nxisol19982x"), 0, 40);
		
		if($authmodel->authenticate($user, $hash)){
			header('Location: /admin');
		}else{
			$this->nxi_error('Fel anv/lösenord!', 'Försök igen!');
			header('Location: /admin/auth');
		}
	}
	
	public function logOut(){
		$_SESSION['admin']['auth'] = FALSE;
		$_SESSION['admin'] = FALSE;
		header("Location: /admin");
	}
	
}
