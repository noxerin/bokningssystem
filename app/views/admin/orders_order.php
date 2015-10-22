<div class="container" style="margin-top: 50px;">
	<div class="col-md-10 col-md-offset-1 control">
		<div class="col-md-6 control-create">
			<h3 class="control-header">Order id #<?=$data[0][0]['id']?></h3>
			<h4>Skapad: <?=date("Y-m-d h:m", $data[0][0]['time'])?></h4>
			<h4>Klarna ID: <?=$data[0][0]['klarna']?></h4>
			<h4>Status: <?=$data[0][0]['status']?></h4>
			<?php
				if($data[0][0]['status'] == "ACTIVE"){
					echo '
						<a href="/admin/orders/order_refund/' . $data[0][0]['klarna'] . '/' . $data[0][0]['id'] . '" class="btn accept" style="padding-top: 12px; color: #fff !important; margin: 5px 0; 								background: #c0392b;">
							Återbetala
						</a>';
				}else if ($data[0][0]['status'] == "REFUNDED" || $data[0][0]['status'] == "CANCELED"){
				}else{
				?>
				<a href="/admin/orders/order_decline/<?=$data[0][0]['klarna']?>/<?=$data[0][0]['id']?>" class="btn accept" style="padding-top: 12px; color: #fff !important; margin-top: 30px; background: 						#e67e22;">
					Neka order
				</a>
				<a href="/admin/orders/order_activate/<?=$data[0][0]['klarna']?>/<?=$data[0][0]['id']?>" class="btn accept" style="padding-top: 12px; color: #fff !important; margin-top: 5px; background: 						#35cf76;">
					Debitera kund
				</a>
				<?php		
				}
			?>
		</div>
		<div class="col-md-6">
			<a href="/admin/orders/order_export/ORDER/<?=$data[0][0]['id']?>" style="float: right;" class="box-link">Exportera till ett excel doc</a>
			<?php
				if($data[0][0]['shipped'] == 0){
					echo '<a href="/admin/orders/order_shipped/' . $data[0][0]['id'] . '" style="float: right; margin-right: 10px;" class="box-link">Markera som skickad</a>';
				}else{
					echo '<a href="/admin/orders/order_shipped/' . $data[0][0]['id'] . '" style="float: right; margin-right: 10px;" class="box-link accept">Ordern är skickad, avmarkera?</a>';
				}
			?>
			<h2>Order</h2>
			<p>Klarnas fakturor har alla en typ av status!</p>
			<p>PENDING: Betyder att statusen på fakturan ej är känd! Det går oftast ändå att aktivera fakturan!</p>
			<p>RESERVED: Detta betyder att en kreditvärdering har gjorts på kunden och att systemet väntar på ett godkännande från administratör!</p>
			<p>ACTIVE: Detta betyder att klarna nu har fått bekräftelse på att administratör godkänt ordern och faktura har blivit utskickat! Du kan nu skicka produkten</p>
			<p>REFUNDED: Detta betyder att en administratör har gjort en återbetalning till kunden på ordern</p>
		</div>
	</div>
</div>

<div class="container">
	<div class="col-md-10 col-md-offset-1" style="background: #f1f1f1; border: 1px solid #131313;">
		<div class="row" style="border-bottom: 1px solid #131313;">
			<div class="col-md-5 cell">
				<i>Förnamn:</i>
				<p><?=$data[0][0]['fname']?></p>
			</div>
			<div class="col-md-5 cell">
				<i>Efternamn:</i>
				<p><?=$data[0][0]['lname']?></p>
			</div>
		</div>
		<div class="row" style="border-bottom: 1px solid #131313;">
			<div class="col-md-5 cell">
				<i>Address:</i>
				<p><?=$data[0][0]['address']?></p>
			</div>
			<div class="col-md-2 cell">
				<i>Postadress:</i> 
				<p><?=$data[0][0]['postal']?></p>
			</div>
			<div class="col-md-2 cell">
				<i>Stad:</i>
				<p><?=$data[0][0]['city']?></p>
			</div>
			<div class="col-md-2 cell">
				<i>Land:</i>
				<p><?=$data[0][0]['country']?></p>
			</div>
		</div>
		<div class="row" style="border-bottom: 1px solid #131313;">
			<div class="col-md-5 cell">
				<i>Email:</i>
				<p><?=$data[0][0]['email']?></p>
			</div>
			<div class="col-md-5 cell">
				<i>Telefon:</i>
				<p><?=$data[0][0]['phone']?></p> 
			</div>
		</div>
		<div class="row">
			<div class="col-md-5 cell">
				<i>Frakt:</i>
				<?php
					if($data[0][0]['shipping_alternative'] == 1){
						echo "<p>Vanligt brev</p>";
					}else if($data[0][0]['shipping_alternative'] == 2){
						echo "<p>Special paket</p>";
					}
				?>
			</div>
			<div class="col-md-4 cell">
				<i>Leveransstatus:</i>
				<p><?=$data[0][0]['shipped']?></p> 
			</div>
			<div class="col-md-3 cell">
				<i>Presentkortskod:</i>
				<p><?=$data[0][0]['code']?></p> 
			</div>
		</div>
	</div>
</div>

<div class="container" style="margin-top: 10px;">
	<div class="col-md-10 col-md-offset-1" style="background: #f1f1f1;">
		<div class="itemcontainer">
			<div class="receipt">
				<div class="product-head">
					<ul>
						<li class="li1"><h3>TYP</h3></li>
						<li class="li2"><h3>ANVÄNDNA/ANTAL</h3></li>
						<li class="li3"><h3>PRIS Á</h3></li>
						<li class="li4"><h3>TOTAL</h3></li>
					</ul>
				</div>
				<?php
				$totalSum = $data[1][0]['cost']*$data[1][0]['count'];
				echo '
					<div class="product">
						<ul>
							<li class="li1"><p>Presentkort - ' . $data[1][0]['name'] . '</p></li>
							<li class="li2"><p>' . $data[1][0]['used'] . ' / ' .$data[1][0]['count'] . '</p></li>
							<li class="li3"><p>' . $data[1][0]['cost'] . ' :-</p></li>
							<li class="li4"><p>' . $data[1][0]['cost']*$data[1][0]['count'] . ' :-</p></li>
						</ul>
						<div class="product-seperator"></div>
					</div>';

					if(count($data[2]) > 0){
						foreach($data[2] as $row){
							$totalSum += $row['cost'];
							echo '
							<div class="product">
								<ul>
									<li class="li1"><p>Tillägg - ' . $row['name'] . '</p></li>
									<li class="li2"><p>' . $row['used'] . ' / ' .$row['count'] . '</p></li>
									<li class="li3"><p>' . $row['cost'] . ' :-</p></li>
									<li class="li4"><p>' . $row['cost'] . ' :-</p></li>
								</ul>
								<div class="product-seperator"></div>
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
					echo '
						<div class="product">
							<ul>
								<li class="li1"><p>Frakt + paket - ' . $shipping_name . '</p></li>
								<li class="li2"><p>' . 1 . '</p></li>
								<li class="li3"><p>' . $shipping_cost . ' :-</p></li>
								<li class="li4"><p>' . $shipping_cost . ' :-</p></li>
							</ul>
							<div class="product-seperator"></div>
						</div>';
				?>
				<div class="receipt-sum">
					<h5>Total summa (inkl moms)</h5>
					<p><?=$totalSum?> kr</p>
				</div>
			</div>
		</div>
	</div>
</div>
<style>	
.control{
	background: #f1f1f1;
	padding: 20px;
	margin-bottom: 40px;
}
.cell{
	padding: 15px;
	padding-bottom: 5px;
	position: relative;
}
.cell i{
	position: absolute;
	top: 5px;
}
.cell p{
	margin-top: 10px;
	margin-left: 10px;
}
.receipt{
	max-width: 100%;
	padding: 20px;
	padding-top: 10px;
	padding-left: 0;
	overflow: auto;
	position: relative;
}
.product-head{
	height: 20px;
	margin-bottom: 10px;
}
.product{
	margin-top: 10px;
	border-width: 80%;
}
.product-seperator{
	width: 90%;
	height: 20px;
	border-bottom: 1px solid #7f7a7a;
	margin: 0 auto;
}
li{
	float: left;
	margin-left: 5%;
	display: inline-block;
}
.li1{
	width: 30%;
}
.li2{
	width: 25%;
}
.li3, .li4{
	width: 10%;
}
.li4{
	text-align: center;
}
.receipt-sum{
	width: 200px;
	height: 60px;
	float: right;
	margin-top: 30px;
	margin-right: 42px;
}
.receipt-sum h5{
	margin-bottom: 10px;
	padding-bottom: 5px;
	border-bottom: 1px solid #7f7a7a;
}
.receipt-sum p{
	padding-left: 15px; 
}

</style>
<script>	

</script>