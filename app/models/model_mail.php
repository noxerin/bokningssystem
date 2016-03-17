<?php
class model_mail{
	
	public function mail_confirm($data){
		$subject = 'Orderbekräftelse - The Lodge';
		
		$headers = "From: noreply@thelodge.se\n";
		$headers .= "Reply-To: noreply@thelodge.se\n";
		$headers .= "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=UTF-8";
		
		$message = '
<!DOCTYPE html>
<html style="font-family: Raleway;">
	<head style="font-family: Raleway;">
		<meta charset="UTF-8" style="font-family: Raleway;">
		<link href="http://fonts.googleapis.com/css?family=Raleway" rel="stylesheet" type="text/css" style="font-family: Raleway;">
	</head>
	<body style="font-family: Raleway;">
		<div class="container" style="font-family: Raleway;width: 1000px;background: #EDEDDE;padding-bottom: 40px;">
			<div class="head" style="font-family: Raleway;">
			</div>
			<div class="body" style="font-family: Raleway;">		
				<div class="seperator" style="font-family: Raleway;border-bottom: 1px dotted #292929;width: 90%;margin: 0 auto;margin-bottom: 20px;"></div>
				<h2 style="font-family: Raleway;width: 300px;display: block;margin: 0 auto;">Tack för din beställning</h2>
				<p style="font-family: Raleway;">Detta mail innehåller viktiga uppgifter om din beställning! Om du inte hör av dig snarast så utgår vi ifrån att dina uppgifter är korrekta!</p>
				<p style="font-family: Raleway;">Om något ej stämmer var vänlig och kontakta oss snarast på support@thelodge.se och uppge ordernummer ' . $data[0][0]['id'] . '</p>
				<br style="font-family: Raleway;">
				<small style="font-family: Raleway;">Order information</small>
				<div class="seperator" style="font-family: Raleway;border-bottom: 1px dotted #292929;width: 90%;margin: 0 auto;margin-bottom: 20px;"></div>
				<div class="info" style="font-family: Raleway;margin-left: 2%;width: 23%;display: inline-block;">
					<p style="font-family: Raleway;">Ordernummer: ' . $data[0][0]['id'] . '</p>
					<br style="font-family: Raleway;">
					<p style="font-family: Raleway;">Namn: ' . $data[0][0]['fname'] . " " . $data[0][0]['lname'] . '</p>
					<p style="font-family: Raleway;">Email: ' . $data[0][0]['email'] . '</p>
					<p style="font-family: Raleway;">Adress: ' . $data[0][0]['address'] . '</p>
					<p style="font-family: Raleway;">Postadress: ' . $data[0][0]['postal'] . '</p>
					<p style="font-family: Raleway;">Stad: ' . $data[0][0]['city'] . '</p>
					<p style="font-family: Raleway;">Land: ' . $data[0][0]['country'] . '</p>
					<p style="font-family: Raleway;">Mobil: ' . $data[0][0]['phone'] . '</p>
				</div>
				<div class="order" style="font-family: Raleway;width: 75%;float: right;">
				<div class="receipt" style="font-family: Raleway;max-width: 100%;padding: 20px;padding-top: 10px;padding-left: 0;overflow: auto;position: relative;">
					<div class="product-head" style="font-family: Raleway;height: 20px;margin-bottom: 10px;">
						<ul style="font-family: Raleway;">
							<li class="li1" style="font-family: Raleway;float: left;margin-left: 5%;display: inline-block;width: 35%;"><h3 style="font-family: Raleway;">TYP</h3></li>
							<li class="li2" style="font-family: Raleway;float: left;margin-left: 5%;display: inline-block;width: 15%;"><h3 style="font-family: Raleway;">ANTAL</h3></li>
							<li class="li3" style="font-family: Raleway;float: left;margin-left: 5%;display: inline-block;width: 15%;"><h3 style="font-family: Raleway;">PRIS Á</h3></li>
							<li class="li4" style="font-family: Raleway;float: left;margin-left: 5%;display: inline-block;width: 15%;text-align: center;"><h3 style="font-family: Raleway;">TOTAL</h3></li>
						</ul>
					</div>';
					
					$totalSum = $data[1][0]['cost']*$data[1][0]['count'];
					$message .= '
						<div class="product" style="font-family: Raleway;margin-top: 10px;border-width: 80%;">
							<ul style="font-family: Raleway;">
								<li class="li1" style="font-family: Raleway;float: left;margin-left: 5%;display: inline-block;width: 35%;"><p style="font-family: Raleway;">Presentkort - ' . $data[1][0]['name'] . '</p></li>
								<li class="li2" style="font-family: Raleway;float: left;margin-left: 5%;display: inline-block;width: 15%;"><p style="font-family: Raleway;">' . $data[1][0]['count'] . '</p></li>
								<li class="li3" style="font-family: Raleway;float: left;margin-left: 5%;display: inline-block;width: 15%;"><p style="font-family: Raleway;">' . $data[1][0]['cost'] . ' :-</p></li>
								<li class="li4" style="font-family: Raleway;float: left;margin-left: 5%;display: inline-block;width: 15%;text-align: center;"><p style="font-family: Raleway;">' . $data[1][0]['cost']*$data[1][0]['count'] . ' :-</p></li>
							</ul>
							<div class="product-seperator" style="font-family: Raleway;width: 90%;height: 28px;border-bottom: 1px solid #7f7a7a;margin: 0 auto;"></div>
						</div>';
	
						if(count($data[2]) > 0){
							foreach($data[2] as $row){
								$totalSum += $row['cost'];
								$message .= '
								<div class="product" style="font-family: Raleway;margin-top: 10px;border-width: 80%;">
									<ul style="font-family: Raleway;">
										<li class="li1" style="font-family: Raleway;float: left;margin-left: 5%;display: inline-block;width: 35%;"><p style="font-family: Raleway;">Tillägg - ' . $row['name'] . '</p></li>
										<li class="li2" style="font-family: Raleway;float: left;margin-left: 5%;display: inline-block;width: 15%;"><p style="font-family: Raleway;">1</p></li>
										<li class="li3" style="font-family: Raleway;float: left;margin-left: 5%;display: inline-block;width: 15%;"><p style="font-family: Raleway;">' . $row['cost'] . ' :-</p></li>
										<li class="li4" style="font-family: Raleway;float: left;margin-left: 5%;display: inline-block;width: 15%;text-align: center;"><p style="font-family: Raleway;">' . $row['cost'] . ' :-</p></li>
									</ul>
									<div class="product-seperator" style="font-family: Raleway;width: 90%;height: 28px;border-bottom: 1px solid #7f7a7a;margin: 0 auto;"></div>
								</div>';
							}
						}
						$shipping_name = null;
						$shipping_cost = null;
						if($data[0][0]['shipping_alternative'] == 1){
							$shipping_name = "Brev";
							$shipping_cost = 25;
							$totalSum += 25;
						}else if($data[0][0]['shipping_alternative'] == 2){
							$shipping_name = "Special";
							$shipping_cost = 80;
							$totalSum += 80;
						}else{
							$shipping_name = "PDF";
							$shipping_cost = 0;
						}
						$message .= '
							<div class="product" style="font-family: Raleway;margin-top: 10px;border-width: 80%;">
								<ul style="font-family: Raleway;">
									<li class="li1" style="font-family: Raleway;float: left;margin-left: 5%;display: inline-block;width: 35%;"><p style="font-family: Raleway;">Frakt + paket - ' . $shipping_name . '</p></li>
									<li class="li2" style="font-family: Raleway;float: left;margin-left: 5%;display: inline-block;width: 15%;"><p style="font-family: Raleway;">' . 1 . '</p></li>
									<li class="li3" style="font-family: Raleway;float: left;margin-left: 5%;display: inline-block;width: 15%;"><p style="font-family: Raleway;">' . $shipping_cost . ' :-</p></li>
									<li class="li4" style="font-family: Raleway;float: left;margin-left: 5%;display: inline-block;width: 15%;text-align: center;"><p style="font-family: Raleway;">' . $shipping_cost . ' :-</p></li>
								</ul>
								<div class="product-seperator" style="font-family: Raleway;width: 90%;height: 28px;border-bottom: 1px solid #7f7a7a;margin: 0 auto;"></div>
							</div>
					<div class="receipt-sum" style="font-family: Raleway;width: 200px;height: 60px;float: right;margin-top: 30px;margin-right: 42px;">
						<h5 style="font-family: Raleway;margin-bottom: 10px;padding-bottom: 5px;border-bottom: 1px solid #7f7a7a;">Total summa (inkl moms)</h5>
						<p style="font-family: Raleway;padding-left: 15px;">' . $totalSum . ' kr</p>
					</div>
				</div>
				</div>
			</div>
		</div>
	</body>
</html>';
		
		//send the email
		$mail_sent = @mail($data[0][0]['email'], $subject, $message, $headers);
		//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed"
	}
	
}