<div class="textcontainer">
	<h2 style="font-size: 22px; text-align: center;">Välj en kategori</h2>
</div>
<div class="dottedborder"></div>
<div class="itemcontainer">
	<?php 
		foreach($data as $row){
			$price = "";
			if($row['type'] == "person"){
				$price = $row['price'] . " kr / person";
			}else if($row['type'] == "fixed"){
				$price = $row['price'] . " kr";
			}
			
			if(isset($_SESSION['product']) && $_SESSION['product'] == $row['id']){
				echo '
				<div class="item" data-id="' . $row['id'] . '">
					<img src="/assets/images/' . $row['image'] . '">
					<i class="fa fa-check fa-3x selected"></i>
					<h1>' . $row['name'] . '</h1>
					<p><b>' . $price . '</b></p>
				</div>';
			}else{
				echo '<div class="item" data-id="' . $row['id'] . '">
						<img src="/assets/images/' . $row['image'] . '">
						<i class="fa fa-circle-o fa-3x"></i>
						<h1>' . $row['name'] . '</h1>
						<p><b>' . $price . '</b></p>
					</div>';
			}
		}

	?>
</div>
<form action="/save/category" method="post">
	<input type="hidden" value="none" name="product" id="productid">
	<input type="submit" value="Nästa: Mer info" class="btn" style="margin-right: 20px;">
</form>
<script>
	$(document).ready(function(){
		var id = $(".selected").parent('.item').data('id');
		$("#productid").val(id);
	});
	
	$(".item").on("click", function(){
		$(".item i").removeClass("selected fa-check").addClass("fa-circle-o");
		$(this).find("i").removeClass('fa-circle-o').addClass("selected fa-check");
		var id = $(this).data("id");
		$("#productid").val(id);
	});
</script>
<style>
.itemcontainer{
	overflow: hidden;
}
.item{
	height: 250px;
	display: block;
	width: 430px;
	float: left;
	margin-right: 5px;
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