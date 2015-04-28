<div class="textcontainer">
	<h1>Presentkort</h1>
	<p>Nu är det dags att välja den upplevelsen som du vill ge bort<p>
	<p>Välj en upplevelse</p>
</div>
<div class="dottedborder"></div>
<div class="textcontainer">
	<h2 style="font-size: 22px; text-align: center;">Välj en kategori</h2>
</div>
<div class="itemcontainer">
	<?php 
		foreach($data as $row){
			$price = "";
			if($row['type'] == "person"){
				$price = $row['price'] . " kr / person";
			}else if($row['type'] == "fixed"){
				$price = $row['price'] . " kr";
			}
			echo($price);
		}

	?>
</div>
<form action="/save/category" method="post">
	<input type="hidden" value="1" name="product" id="productid">
	<input type="submit" value="Nästa: Välj extratillägg" class="btn" style="margin-right: 20px;">
</form>
<style>
.item{
	height: 250px;
	margin-right: 2px;
}
.item img{
	height: 80%;
}
.item i{
	bottom: 0;
}
.fa-info{
	position: relative !important;
	left: 14px;
	float: left;
	bottom: -7px !important;
}
.item h1{
	color: #000;
	text-align: center;
	margin-top: 5px;
	font-size: 24px;
}
.item p{
	text-align: center;
}
</style>