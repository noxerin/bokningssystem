<div class="bookerDetails">
	<h2 style="margin-bottom: 10px;">Fyll i dina uppgifter så vi vet vem du är när du kommer hit</h2>
	<form action="/book/create_booking" method="post" id="bookerInfo">
		<div style="display: inline-block; margin-bottom: 20px;">
			<div style="display: inline-block;">
				<p>Förnamn*</p>
				<input type="text" class="inputfield" name="fname" required style="margin-right: 30px;">
			</div>
			<div style="display: inline-block;">
				<p>Efternamn*</p>
				<input type="text" class="inputfield" name="lname" required>
			</div>
		</div>
		<div style="display: inline-block;">
			<div style="display: inline-block;">
				<p>Mobilnummer*</p>
				<input type="text" class="inputfield" name="phone" required style="margin-right: 30px;">
			</div>
			<div style="display: inline-block;">
				<p>E-mail*</p>
				<input type="text" class="inputfield" name="email" required>
			</div>
		</div>
		<input type="hidden" name="bookingId" value="<?=$data[0]?>">
	</form>
</div>
<div class="bookItems">
	<h2><i>Kommer att bokas in från den <u><?=date('j F \k\l H:i', $data[3][0]['time_from'])?></u> till <u><?=date('j F \k\l H:i', $data[3][0]['time_to'])?></u></i></h2>
	<div class="dottedborder"></div>
	<div class="bookItemsContainer">
		<div class="orderInfo">
			<div class="itemcontainer">
				<div class="receipt">
					<div class="product-head">
						<ul>
							<li class="li1"><h3>TYP</h3></li>
							<li class="li2"><h3>KOMMER BOKAS / DITT TOTAL</h3></li>
						</ul>
					</div>
					<?php
					echo '
						<div class="product">
							<ul>
								<li class="li1"><p>Presentkort - ' . $data[2][1][0]['name'] . '</p></li>
								<li class="li2"><p>' . $data[1]['product']['count'] . ' stycken av ' . $data[2][1][0]['count'] . '</p></li>
							</ul>
							<div class="product-seperator"></div>
						</div>';
		
						if(count($data[2][2]) > 0){
							foreach($data[2][2] as $row){
								echo '
								<div class="product">
									<ul>
										<li class="li1"><p>Tillägg - ' . $row['name'] . '</p></li>
										<li class="li2"><p>' . $row['count'] . ' stycken av 1</p></li>
									</ul>
									<div class="product-seperator"></div>
								</div>';
							}
						}
					?>
				</div>
			</div>
		</div>
	</div>
	<input type="submit" value="Boka" class="btn" style="position: absolute; right: 10px; bottom: 10px;" form="bookerInfo" >
</div>
<style>
.bookerDetails{
	width: 47%;
	margin: 0 auto;
	margin-bottom: 20px;
}
.bookItems{	
	width: 80%;
	padding: 5px;
	margin: 0 auto;
	border: 1px solid #e4e49e;
	position: relative;
}
.bookItemsContainer{
	
}
h2{
	font-size: 18px;
}
.orderInfo{
	margin-top: 15px;
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
	width: 40%;
}
.li2{
	width: 35%;
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