<?php
class Orders extends Controller_Admin
{
	public function index($search = null, $sortBy = null){
		$ordermodel = $this->model('model_orders');
				
		$this->view('admin/partials/header', "The Lodge - Ordrar");
		$this->view('admin/partials/menu');
		if(!isset($search)){
			$this->view('admin/orders', array($ordermodel->retriveLastOrders(15)));
		}else{
			$this->view('admin/orders', array($ordermodel->retriveSearchOrders($search), $search));
		}
		$this->view('admin/partials/footer');
	}
	
	public function order($orderId){		
		$ordermodel = $this->model('model_orders');
				
		$this->view('admin/partials/header', 'The Lodge - Order ' . $orderId);
		$this->view('admin/partials/menu');
		$this->view('admin/orders_order', $ordermodel->retriveOrder($orderId));
		$this->view('admin/partials/footer');
	}
	
	//Call functions
	
	/* Deprecated
	public function order_decline($klarnaId, $orderId){
		$klarnamodel = $this->model('model_klarna');
		$ordermodel = $this->model('model_orders');
		
		try{
			$klarnamodel->cancelOrder($klarnaId);
			$ordermodel->markAs($klarnaId, "CANCELED");
		}catch (Exception $E){
			$this->nxi_error('Ett fel inträffade', 'Systemet kunde ej avbryta fakturan');	
		}
		
		header("Location: /admin/orders/order/".$orderId);
	}*/
	
	/* Deprecated 
	public function order_activate($klarnaId, $orderId){		
		$klarnamodel = $this->model('model_klarna');
		$ordermodel = $this->model('model_orders');
		
		try{
			$invoiceNumber = $klarnamodel->activateOrder($klarnaId, $orderId); 
			//Update with new invoicenumber
			$ordermodel->markAs($klarnaId, "ACTIVE");
			$ordermodel->updateKlarnaNumber($klarnaId, $invoiceNumber[1]);
		}catch (Exception $E){
			$this->nxi_error('Ett fel inträffade', 'Systemet kunde ej aktivera fakturan');	
		}

		header("Location: /admin/orders/order/".$orderId);
	}*/
	
	/*Deprecated
	public function order_refund($invoiceId){		
		$klarnamodel = $this->model('model_klarna');
		$ordermodel = $this->model('model_orders');
		
		try{
			$klarnamodel->refundOrder($invoiceId); 
			$ordermodel->markAs($invoiceId, "REFUNDED");
		}catch (Exception $E){
			$this->nxi_error('Ett fel inträffade', 'Systemet kunde ej återbetala till kunden');	
		}

		header("Location: /admin/orders/order/".$invoiceId);
	}*/
	
	public function order_checkstatus($paymentId){
		$payexmodel = $this->model('model_payex');
		$ordermodel = $this->model('model_orders');
		$status = $payexmodel->confirm($paymentId);
		if($status[0]){
			$ordermodel->updateOrderStatus($paymentId, "APPROVED");
		}else{
			$ordermodel->updateOrderStatus($paymentId, "FAILED");			
		}
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	
	public function order_export($type, $var = null){
		$ordermodel = $this->model('model_orders');
		$exportmodel = $this->model('model_export');
		
		if($type == "ORDER"){
			$compile = $ordermodel->compile_order($var);
			$exportmodel->generate($compile, $type);
		}else if($type == "DAY"){ //Call by /DAY/2015-09-11
			$compile = $ordermodel->compile_order_byDate(strtotime($var), strtotime($var) + 86400);
			$exportmodel->generate($compile, $type, strtotime($var), strtotime($var));
		}else if($type == "MONTH"){ //Call by /MONTH/2015-09 
			$compile = $ordermodel->compile_order_byDate(strtotime($var), strtotime($var) + (date("t", strtotime($var)) * 86400));	
			$exportmodel->generate($compile, $type, strtotime($var), strtotime($var) + (date("t", strtotime($var)) * 86400));
		}else if($type == "YEAR"){ //Call by /YEAR/2015-01-01
			$compile = $ordermodel->compile_order_byDate(strtotime($var), strtotime('+1 year', strtotime($var)));
			$exportmodel->generate($compile, $type, strtotime($var), strtotime('+1 year', strtotime($var)));
		}else if($type == "ALL"){	
			$compile = $ordermodel->compile_order_byDate(0, time());
			$exportmodel->generate($compile, $type);
		}
	}
	
	public function order_shipped($id){
		$ordermodel = $this->model('model_orders');
		
		$order = $ordermodel->retriveOrder($id);
		if($order[0][0]['shipped'] == 0){
			$ordermodel->shipped($id, 1);
		}else{
			$ordermodel->shipped($id, 0);
		}
		header("Location: /admin/orders/order/".$id);
	}
	
	public function remove($id){
		$ordermodel = $this->model('model_orders');
		$ordermodel->remove($id);
		header("Location: /admin/orders/");
	}

	
}