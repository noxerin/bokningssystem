<?php
class Book extends Controller{
	
	public function index(){
		//Model import
		
		$this->view('main/partials/header', "The Lodge - Presentkort");
		$this->view('main/book');
		$this->view('main/partials/footer');
	}
	
	public function show(){	
		if($_SESSION['book']['code'] != $_GET['code']){
			$_SESSION['book'] = "";
		}
		$ordermodel = $this->model('model_orders');
		
		$result = $ordermodel->checkIfExist(str_replace("-", "", str_replace(" ", "", $_GET['code'])));
		
		if(!$result[0]){
			$this->nxi_error('Du har antingen skrivit in fel kod eller så finns ej denna order!','');
			header('Location: /book/');
		}else{
			
			$data = $ordermodel->retriveOrder($result[1]);
			
			$this->view('main/partials/header', "The Lodge - Boka");
			$this->view('main/book_show', $data);
			$this->view('main/partials/footer');	
		}
	}
	
	public function book_details($booking_id){
		$ordermodel = $this->model('model_orders');
		$bookingmodel = $this->model('model_booking');

		if(!isset($booking_id)){
			$this->nxi_error('Välj ett datum!','');
			header('Location: /book/');
		}else{
			$data[0] = $booking_id;
			$data[1] = $_SESSION['book'];
			
			$result = $ordermodel->checkIfExist($_SESSION['book']['code']);
			$data[2] = $ordermodel->retriveOrder($result[1]);
			
			$data[3] = $bookingmodel->getBookingTime($booking_id);
			
			$this->view('main/partials/header', "The Lodge - Boka");
			$this->view('main/book_details', $data);
			$this->view('main/partials/footer');	
		}
	}
	
	//Call functions
	public function save_count(){
		$_SESSION['book'] = "";
		$_SESSION['book']['code'] = $_POST['code'];
		
		if($_POST['count'][0]['count'] <= 0){
			$this->nxi_warning("Det är inte tillåtet att boka 0","");
			header("Location: /book/show?code=" . $_SESSION['book']['code']);
			break;
		}else{
			$_SESSION['book']['product']["id"] = $_POST['count'][0]['id'];
			$_SESSION['book']['product']["count"] = $_POST['count'][0]['count'];
		}
				
		$addons = $_POST;
		unset($addons['count'][0]);
		
		if(count($addons) >= 1){
			$i = 0;
			foreach($addons['count'] as $row){
				if($row['count'] <= 0){
					header("Location: /book/show?code=" . $_SESSION['book']['code']);
					break;
				}else{
					$_SESSION['book']['addon'][$i]["id"] = $row['id'];
					$_SESSION['book']['addon'][$i]["count"] = $row['count'];				
				}
				$i++;
			}
		}
		header("Location: /book/show?code=" . $_SESSION['book']['code']);
	}
	
	public function create_booking(){
		$ordermodel = $this->model('model_orders');
		$bookingmodel = $this->model('model_booking');
		
		$booking_id = $_POST['bookingId'];
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		
		$result = $ordermodel->checkIfExist($_SESSION['book']['code']);
		$order = $ordermodel->retriveOrder($result[1]);
		
		$booking_time = $bookingmodel->getBookingTime($booking_id);
		
		if($bookingmodel->addBooking($booking_time[0]['id'], $order[0][0]['id'], $fname, $lname, $phone, $email)){
			$_SESSION['book'] = "";
			header("Location: /book/success");
		}else{
			$this->nxi_error("Något gick fel!","Gå till baka till början och försök igen!");
			$_SESSION['book'] = "";
			header("Location: /book/");
		}
	}
	
	
	/***
	*
	*	This is classes used in live querys using ajax
	*
	*	These classes still requires session var if used from admin panel
	*
	***/
	
	public function ajax_fetchTimes(){
		$bookingmodel = $this->model('model_booking');
		
		$bookingmodel->fetchTimes($_POST['id'], strtotime($_POST['date']));
	}
	
}