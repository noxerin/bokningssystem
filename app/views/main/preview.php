<div class="textcontainer">
	<h2 style="font-size: 22px; text-align: center;">Förhandsgranska</h2>
</div>
<div class="dottedborder"></div>
<div class="itemcontainer">
	<?php 
			echo '
				<div class="item">
					<img src="/assets/images/' . $data[0]['src'] . '">
					<h1>' . $_SESSION['count'] . ' st ' . $data[1]['name'] . '</h1>
					<p class="info">' . $data[1]['desc'] . '</p>';
			if(strlen($_SESSION['extras'][0]) > 0){
				echo "extras";
			}
				var_dump($_SESSION['extras']);
					
					
			echo '
					<div class="dottedborder" style="border-color: #898989;"></div>
					<h2>' . $_SESSION['message'] . '</h2>
				</div>';
	?>
</div>
<form action="/checkout" method="post">
	<input type="submit" value="Gå till kassa" class="btn" style="margin-right: 20px;">
</form>
<style>
.item{
	width: 700px;
	margin: 0 auto;
	display: block;
	height: auto;
	cursor: default;
	background: #ededed;
	padding: 10px;
	border-radius: 4px;
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
.item h2{
	text-align: center;
	margin-top: 5px;
	line-height: 26px;
	font-size: 22px;
	margin-bottom: 10px;
	color: #000;
	font-family: applegaramond-italic;
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
	$(".item select").on("change", function(){
		var id = $(this).val();
		$("#count").val(id);
	});
</script>