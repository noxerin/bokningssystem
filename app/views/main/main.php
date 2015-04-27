<div class="textcontainer">
	<h1>Presentkort</h1>
	<p>Första steget för att skapa ett presentkort är att bestämma en design.<p>
	<p>Välj ett motiv och skriv ett passande text till ditt presentkort</p>
</div>
<div class="dottedborder"></div>
<div class="textcontainer">
	<h2 style="font-size: 22px; text-align: center;">Välj ett motiv</h2>
</div>
<div class="itemcontainer">
	<?php 
		foreach($data as $row){
			if(isset($_SESSION['image']) && $_SESSION['image'] == $row['id']){
				echo "
				<div class='item' data-id='" . $row['id'] . "'>
					<img src='/assets/images/" . $row['src'] . "'>
					<i class='fa fa-circle-o fa-3x selected'></i>
				</div>";
			}else{
				echo "
				<div class='item' data-id='" . $row['id'] . "'>
					<img src='/assets/images/" . $row['src'] . "'>
					<i class='fa fa-circle-o fa-3x'></i>
				</div>";
			}
		}
		
	?>
</div>
<form action="/save/image" method="post">
	<input type="hidden" value="1" name="image" id="imageid">
	<div class="textcontainer">
		<textarea name="message" class="textarea" placeholder="Skriv ett medelande"><?=$_SESSION['message']?></textarea>
	</div>
	<div class="textcontainer">
		<input type="submit" value="Nästa: Välj upplevelse" class="btn">
	</div>
</form>
<script>
	$(document).ready(function(){
		var id = $(".selected").parent('.item').data('id');
		$("#imageid").val(id);
	});
	
	$(".item").on("click", function(){
		$(".item i").removeClass("selected");
		$(this).find("i").addClass("selected");
		var id = $(this).data("id");
		$("#imageid").val(id);
	});
</script>