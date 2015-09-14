<?php
class Options extends Controller_Admin
{
	public function index(){
		$this->view('admin/partials/header', 'The Lodge - Options');
		$this->view('admin/partials/menu');
		$this->view('admin/partials/footer');
	}
	
	public function export(){
		$this->view('admin/partials/header', 'The Lodge - Export');
		$this->view('admin/partials/menu');
		$this->view('admin/export');
		$this->view('admin/partials/footer');
	}
}