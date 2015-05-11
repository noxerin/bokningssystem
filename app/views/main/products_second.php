<div class="textcontainer">
	<h2 style="font-size: 22px; text-align: center;">Välj antal</h2>
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
			echo '
				<div class="item" data-id="' . $row['id'] . '">
					<img src="/assets/images/' . $row['image'] . '">
					<h1>' . $row['name'] . '</h1>
					<p><b>' . $price . '</b></p>
					<div class="countcontainer">
						<label for="count">Antal</label>
						<select class="count">';
						for($i = 1; $i <= 12; $i ++){
							if($_SESSION['count'] == $i){
								echo "<option selected='selected' value='$i'>$i</option>";
							}else{
								echo "<option value='$i'>$i</option>";
							}
						}
			echo '
						</select>
					</div>
					<p class="info">' . $row['desc'] . '</p>
				</div>';
		}

	?>
</div>
<form action="/save/categorieschoice" method="post">
	<input type="hidden" value="1" name="count" id="count">
	<input type="submit" value="Nästa: Välj extratillägg" class="btn" style="margin-right: 20px;">
</form>
<style>
.item{
	width: 700px;
	margin: 0 auto;
	display: block;
	height: auto;
	cursor: default;
}
.item img{
	height: 290px;
	width: 700px;
}
.item h1{
	color: #000;
	text-align: center;
	margin-top: 5px;
	font-size: 24px;
}
.item p{
	text-align: center;
	margin-top: 3px;
}
.info{
	margin-top: 20px !important;
}
.countcontainer{
	width: 85px;
	margin: 0 auto;
	margin-top: 10px;
	text-align: center;
	vertical-align: middle;
}
.countcontainer label{
	color: #000;
	font-size: 19px;
}
</style>
<script>
	$(document).ready(function(){
		var id = $(".count").val();
		$("#count").val(id);
	});
	
	$(".item select").on("change", function(){
		var id = $(this).val();
		$("#count").val(id);
	});
</script>