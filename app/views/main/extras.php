<div class="textcontainer">
	<h2 style="font-size: 22px; text-align: center;">Välj eventuella tillägg</h2>
</div>
<div class="dottedborder"></div>
<form action="/save/extras" method="post">
<div class="itemcontainer">
	<?php
		foreach($data as $row){
			$price = "";
			if($row['type'] == "person"){
				$price = $row['price'] . " kr / person";
			}else if($row['type'] == "fixed"){
				$price = $row['price'] . " kr";
			}
			if(array_key_exists($row['id'], $_SESSION['extras'])){
				echo '
				<div class="item">
					<img src="/assets/images/' . $row['image'] . '">
					<div class="checkedimg selected"></div>
					<div class="amount">
						<input type="number" class="input extra-count" value="'. $_SESSION['extras'][$row['id']] .'" placeholder="Antal" name="extra-count[]">
						<input type="checkbox" class="extra-id" value="'.$row['id'].'" hidden name="extra-id[]" checked>
					</div>
					<h1>' . $row['name'] . '</h1>
					<p><b>' . $price . '</b></p>
				</div>';
			}else{
				echo '<div class="item">
						<img src="/assets/images/' . $row['image'] . '">
						<div class="checkedimg" style="display: none"></div>
						<div class="amount">
							<input type="number" class="input input-disabled extra-count" placeholder="Antal" name="extra-count[]" disabled>
							<input type="checkbox" class="extra-id" value="'.$row['id'].'" hidden name="extra-id[]" disabled>
						</div>
						<h1>' . $row['name'] . '</h1>
						<p><b>' . $price . '</b></p>
					</div>';
			}
		}		
	?>
</div>
	<input type="submit" value="Nästa: Välj upplevelse" class="btn" style="right: 20px; position: absolute; bottom: 20px;">	
</form>

<script>
	$(".item").on("click", function(e){
		if($(e.target).attr('class') != "input extra-count"){
			if($(this).find(".checkedimg").hasClass("selected")){
				$(this).find(".checkedimg").fadeOut().removeClass("selected");
				$(this).find(".extra-count").prop("disabled", true).addClass("input-disabled");	
				$(this).find(".extra-id").prop('disabled', true);	
		 		$(this).find("input").prop('checked', false);				
			}else{
		 		$(this).find(".checkedimg").fadeIn().addClass("selected");			
		 		$(this).find('.extra-count').prop("disabled", false).removeClass("input-disabled");
				$(this).find(".extra-id").prop('disabled', false);		
		 		$(this).find("input").prop('checked', true);			
			}
		}
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
.checkedimg{
	top: -45px !important;
}
.amount{
	position: absolute;
	width: 150px;
	left: 92px;
}
.extra-count{
	width: 120px;
	padding: 4px;
	position: absolute;
	bottom: 0px;
	left: 40px;
}
.input {
  background-color: #ffffff;
  height: 40px;
  width: 100%;
  margin-bottom: 10px;
  outline: 0;
  padding-left: 10px;
  font-family: 'Source Sans Pro', sans-serif;
  font-size: 15px;
  border: 2px solid #dddddd;
  border-radius: 3px;
}
.input-disabled{
	background-color: #e1dede;
}
</style>