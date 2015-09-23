<div class="textcontainer">
	<div class="book btn">
		<a href="/book">Har du redan ett presentkort?</a>
	</div>
	<h1>PRESENTKORT</h1>
	<p>Först bestämm en design.<p>
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
					<img src='/assets/checked.png' class='checkedimg selected'>
				</div>";
			}else{
				echo "
				<div class='item' data-id='" . $row['id'] . "'>
					<img src='/assets/images/" . $row['src'] . "'>
					<img src='/assets/checked.png' class='checkedimg' style='display: none;'>
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
	<div class="infobox">
		<p>Skriv ett meddelande, för att göra ditt presentkort lite mer personligt</p>
		<input type="submit" value="Nästa: Välj upplevelse" class="btn" style="right: 20px; position: absolute; bottom: 20px;">	
	</div>
</form>
<style>
	.book{
		
	}
</style>

<script>
	$(document).ready(function(){
		var id = $(".selected").parent('.item').data('id');
		$("#imageid").val(id);
	});
	
	$(".item").on("click", function(){
		$(".checkedimg").fadeOut().removeClass("selected");
		$(this).find(".checkedimg").fadeIn().addClass("selected");
		var id = $(this).data("id");
		$("#imageid").val(id);
	});
</script>