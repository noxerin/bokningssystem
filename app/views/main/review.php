<div class="textcontainer">
	<h2 style="font-size: 22px; text-align: center;">Granska och betala</h2>
</div>
<div class="dottedborder"></div>  
<div class="itemcontainer">
	<div class="receipt">
		<div class="product-head">
			<ul>
				<li class="li1"><h3>TYP</h3></li>
				<li class="li2"><h3>ANTAL</h3></li>
				<li class="li3"><h3>PRIS Á</h3></li>
				<li class="li4"><h3>TOTAL</h3></li>
			</ul>
		</div>
		<?php

			if($_SESSION['count'] == "sum"){
				$totalsum = $_SESSION['sum'];
				echo '
					<div class="product">
						<ul>
							<li class="li1"><p>Presentkort - ' . $data[1]['product']['name'] . '</p></li>
							<li class="li2"><p>1</p></li>
							<li class="li3"><p>' . $_SESSION['sum'] . ' :-</p></li>
							<li class="li4"><p>' . $_SESSION['sum'] . ' :-</p></li>
						</ul>
						<div class="product-seperator"></div>
					</div>';
			}else{
				$totalsum = $data[1]['product']['price']*$_SESSION['count'];
				echo '
					<div class="product">
						<ul>
							<li class="li1"><p>Presentkort - ' . $data[1]['product']['name'] . '</p></li>
							<li class="li2"><p>' . $_SESSION['count'] . '</p></li>
							<li class="li3"><p>' . $data[1]['product']['price'] . ' :-</p></li>
							<li class="li4"><p>' . $data[1]['product']['price']*$_SESSION['count'] . ' :-</p></li>
						</ul>
						<div class="product-seperator"></div>
					</div>';
			}
			if(strlen($_SESSION['extras'][0]) > 0){
				foreach($data[1]['extras'] as $row){
					$totalsum += $row['price'];
					echo '
					<div class="product">
						<ul>
							<li class="li1"><p>Tillägg - ' . $row['name'] . '</p></li>
							<li class="li2"><p>1</p></li>
							<li class="li3"><p>' . $row['price'] . ' :-</p></li>
							<li class="li4"><p>' . $row['price'] . ' :-</p></li>
						</ul>
						<div class="product-seperator"></div>
					</div>';
				}
			}
			$totalsum += $data[1]['shipping']['cost'];
			echo '
				<div class="product">
					<ul>
						<li class="li1"><p>Frakt + paket - ' . $data[1]['shipping']['title'] . '</p></li>
						<li class="li2"><p>' . 1 . '</p></li>
						<li class="li3"><p>' . $data[1]['shipping']['cost'] . ' :-</p></li>
						<li class="li4"><p>' . $data[1]['shipping']['cost'] . ' :-</p></li>
					</ul>
					<div class="product-seperator"></div>
				</div>';
		?>
		<div class="receipt-sum">
			<h3>Total summa (inkl moms)</h3>
			<p><?=$totalsum?> kr</p>
		</div>
	</div>
</div>
   <?=$data[0]?>
<style>
.receipt{
	background: #f2f2ea;
	border: 1px dotted #cac7c7;
	max-width: 100%;
	padding: 20px;
	overflow: auto;
	position: relative;
}
.product-head{
	border-bottom: 1px solid #7f7a7a;
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
	width: 35%;
}
.li2, .li3, .li4{
	width: 15%;
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
.receipt-sum h3{
	margin-bottom: 10px;
	padding-bottom: 5px;
	border-bottom: 1px solid #7f7a7a;
}
.receipt-sum p{
	padding-left: 15px; 
}
</style>