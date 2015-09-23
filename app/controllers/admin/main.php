<?php
class Main extends Controller_Admin
{
	
	public function index()
	{	
		$statisticsmodel = $this->model('model_statistics');
		
		$this->view('admin/partials/header', "The Lodge - Admin");
		$this->view('admin/partials/menu');
		$this->view('admin/main', array($statisticsmodel->year_report(), $statisticsmodel->most_sold(), $statisticsmodel->most_sold_extras()));
		$this->view('admin/partials/footer');
	}
}