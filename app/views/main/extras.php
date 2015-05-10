<div class="textcontainer">
	<h2 style="font-size: 22px; text-align: center;">Välj eventuella tillägg</h2>
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
			if(in_array($row['id'], $_SESSION['extras'])){
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
<form action="/save/extras" method="post">
	<input type="hidden" value="" name="extras" id="extras">
		<input type="submit" value="Nästa: Välj upplevelse" class="btn" style="right: 20px; position: absolute; bottom: 20px;">	
</form>

<script>
	$(document).ready(function(){
		var allAttributes = $('.item').map(function(){
			if($(this).find('i').hasClass("selected")){
				return $(this).data('id');				
			}
		}).get();
		$("#extras").val(allAttributes);
	});
	
	$(".item").on("click", function(){
		if($(this).find("i").hasClass("selected")){
			$(this).find("i").removeClass("selected fa-check").addClass("fa-circle-o");
		}else{
	 		$(this).find("i").removeClass('fa-circle-o').addClass("selected fa-check");			
		}
		var allAttributes = $('.item').map(function(){
			if($(this).find('i').hasClass("selected")){
				return $(this).data('id');				
			}
		}).get();
		$("#extras").val(allAttributes);
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
	margin-bottom: 15px;
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