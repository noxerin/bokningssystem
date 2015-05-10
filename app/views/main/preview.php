<div class="textcontainer">
	<h2 style="font-size: 22px; text-align: center;">Förhandsgranska</h2>
</div>
<div class="dottedborder"></div>
<div class="itemcontainer">
	<?php 
			echo '
				<div class="item">
					<img src="/assets/images/' . $data[0]['src'] . '">
					<h1>' . $_SESSION['count'] . ' st ' . $data[1]['name'] . '</h1>';
				if(isset($data[2])){
					echo "<h2 class='extra'><b>Och så nåt litet extra</b></h2>";
					foreach($data[2] as $row){
						echo "<p>" . $row['name'] . "</p>";
					}
				}				
			echo '
					<p class="info">' . $data[1]['desc'] . '</p>
					<div class="dottedborder" style="border-color: #898989;"></div>
					<p class="message">' . $_SESSION['message'] . '</p>
				</div>';
	?>
</div>
<form action="/save/accepted" method="post">
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
.item h1, h2{
	color: #000;
	text-align: center;
	margin-top: 15px;
	font-size: 24px;
}
.item h2{
	font-size: 18px;
}
.message{
	text-align: center;
	margin-top: 5px;
	line-height: 26px;
	font-size: 25px;
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
.extra{
	margin-top: 20px;
	margin-bottom: 5px;
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