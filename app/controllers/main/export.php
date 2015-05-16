<?php
class Export extends Controller
{
	public function index(){
		$this->view('main/partials/header', "Admin page - EXPORT");
		$this->view('main/partials/menu');
		$this->view('main/export');
		$this->view('main/partials/footer');
	}
	
	public function generate(){
		$export = $this->model('model_export');
		
		$option = $_POST['option'];
		$sql = "";
		switch($option){
			case "bookings": 
				$sql = "
					SELECT
						bokningar.status, personnummer, fnamn, enamn, alder, username, bord, pos
					FROM
						bokningar
					JOIN
						users
						ON
							users.id = bokningar.kund
					JOIN
						platser
						ON
							platser.id = bokningar.plats_id";
				break;
			case "payments":
				$sql = "
					SELECT
						pay_id, trans_id, username, fnamn, enamn, personnummer
					FROM
						betalningar
					JOIN
						users
						ON
							users.id = betalningar.pay_by";
				break;
			case "userdetails":
				$sql = "
					SELECT
						id, personnummer, fnamn, enamn, alder, username
					FROM
						users";
				break;	
		}
		
		$filename = "fragtime_" . $option . "_" . date('Y-m-d') . ".xls";

		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Content-Type: application/vnd.ms-excel");
		$export->prepare($GLOBALS["db"]->querySecured($sql));

	}
}