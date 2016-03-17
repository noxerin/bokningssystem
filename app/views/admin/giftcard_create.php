<div class="container" style="margin-top: 50px;">
	<div class="col-md-10 col-md-offset-1 control">
		<div class="col-md-6 control-create">
			<h3 class="control-header">Presentkort</h3>
		</div>
		<div class="col-md-6">
			<input class="btn " type="submit" form="create" style="padding-top: 12px; color: #fff !important; margin-top: 10px; background: #35cf76;" value="Skapa presentkort">
			<a href="/admin/giftcard/show/<?=$data[0][0]['id']?>" class="btn" style="padding-top: 12px; color: #fff !important; margin-top: 30px; background: #c0392b;">
				Avbryt
			</a>
		</div>
	</div>
</div>
<form method="post" action="/admin/giftcard/create_new" id="create">
<div class="container">
	<div class="col-md-10 col-md-offset-1" style="background: #f1f1f1; border: 1px solid #131313;">
		<div class="row" style="border-bottom: 1px solid #131313;">
			<div class="col-md-5 cell">
				<i>Förnamn:</i>
				<br>
				<input type="text" name="fname" class="input" required>
			</div>
			<div class="col-md-5 cell">
				<i>Efternamn:</i>
				<br>
				<input type="text" name="lname" class="input" required>
			</div>
		</div>
		<div class="row" style="border-bottom: 1px solid #131313;">
			<div class="col-md-5 cell">
				<i>Address:</i>
				<br>
				<input type="text" name="address" class="input" required>
			</div>
			<div class="col-md-2 cell">
				<i>Postadress:</i> 
				<br>
				<input type="number" name="postal" class="input" required>
			</div>
			<div class="col-md-2 cell">
				<i>Stad:</i>
				<br>
				<input type="text" name="city" class="input" required>
			</div>
			<div class="col-md-2 cell">
				<i>Land:</i>
				<br>
				<select name="country" class="input" required>
					<option value="SE">Sverige</option>
					<option value="DK">Danmark</option>
					<option value="NO">Norge</option>
				</select>
			</div>
		</div>
		<div class="row" style="border-bottom: 1px solid #131313;">
			<div class="col-md-5 cell">
				<i>Email:</i>
				<br>
				<input type="email" name="email" class="input" required>
			</div>
			<div class="col-md-5 cell">
				<i>Telefon:</i>
				<br>
				<input type="number" name="phone" class="input" required>
			</div>
		</div>
		<div class="row" style="border-bottom: 1px solid #131313;">
			<div class="col-md-5 cell">
				<i>Typ av presentkort:</i>
				<br>
				<input type="radio" name="type" value="OWNER" required> Eget
				<input type="radio" name="type" value="MARKETING"> Marknadsförning
				<input type="radio" name="type" value="COMPLAINT"> Reklamation
			</div>
			<div class="col-md-5 cell">
				<i>Antal månader:</i>
				<br>
				<input type="number" name="expires" class="input" required>
			</div>
		</div>
		<div class="row" style="border-bottom: 1px solid #131313;">
			<div class="col-md-5 cell">
				<i>Meddelande:</i>
				<br>
				<textarea name="message" class="input" required style="width: 760px; height: 70px;"></textarea>
			</div>
		</div>
	</div>
</div>

<div class="container" style="margin-top: 20px">
	<div class="col-md-12 wrapper" style="position: relative;">
		<h3 style="margin-top: 0;">Välj produkt</h3>
			<div class="col-md-12" style="margin-left: 30px;">
			<?php
				

				foreach($data[0] as $row){
					
					echo '
					<div class="product-item">
						<img src="/assets/images/' .$row['image']. '" class="extras-item-img">
						<input type="number" class="input input-disabled product-count" disabled placeholder="Antal" name="product-count">
						<p>' . $row['name'] . '</p>
						<i class="fa fa-check"></i>
						<input type="checkbox" class="product-id" value="'.$row['id'].'" hidden name="product-id">
					</div>';
				}


			?>
			</div>
			<div class="col-md-4 col-md-offset-4">
				<input type="text" value="<?=$data[2]?>" name="id" hidden >
			</div>
	</div>
</div>

<div class="container">
	<div class="col-md-12 wrapper" style="position: relative;">
		<h3 style="margin-top: 0;">Välj tillägg</h3>
		<form method="post" action="/admin/product/updateAddonSelection">
			<div class="col-md-12" style="margin-left: 30px;">
			<?php
				

				foreach($data[1] as $row){
					
					echo '
					<div class="extras-item">
						<img src="/assets/images/' .$row['image']. '" class="extras-item-img">
						<p>' . $row['name'] . '</p>
						<i class="fa fa-check"></i>
						<input type="checkbox" value="'.$row['id'].'" hidden name="extras[]">
					</div>';
				}


			?>
			</div>
			<div class="col-md-4 col-md-offset-4">
				<input type="text" value="<?=$data[2]?>" name="id" hidden >
			</div>
		</form>
	</div>
</div>

<style>
.control{
	background: #f1f1f1;
	padding: 20px;
	margin-bottom: 40px;
}
.cell{
	padding: 15px;
	padding-bottom: 5px;
	position: relative;
}
.cell i{
	position: absolute;
	top: 5px;
}
.cell p{
	margin-top: 10px;
	margin-left: 10px;
}
.extras-item, .product-item{
	background: #dddddd;
	width: 200px;
	height: 180px;
	margin-right: 3px;
	margin-bottom: 3px;
	float: left;
	position: relative;
	cursor: pointer;
	margin-bottom: 25px;
}
.product-count{
	width: 120px;
	padding: 4px;
	position: absolute;
	bottom: 0px;
	left: 40px;
}
.extras-item-img{
	width: 100%;
	height: 100%;
}
.extras-item p, .product-item p{
	text-align: center;
}
.fa-check{
	display: none;
	font-size: 60px;
	position: absolute;
	left: 70px;
	top: 60px;
	color: #2ecc71;
}
.selected{
	display: block;
}
</style>
<script>
	$(".product-item").on("click", function(){
		$(".product-item i").removeClass("selected");
		$(".product-count").prop("disabled", true).addClass("input-disabled");	
		$(".product-id").find("input").prop('checked', false);		
		$(this).find(".fa-check").addClass("selected");
		$(this).find('.product-count').prop("disabled", false).removeClass("input-disabled");
		$(this).find("input").prop('checked', true);
	});

	$(".extras-item").on("click", function(){
		if($(this).find(".fa-check").hasClass('selected')){
			$(this).find(".fa-check").removeClass("selected");
			$(this).find("input").prop('checked', false);		
		}else{
			$(this).find(".fa-check").addClass("selected");
			$(this).find("input").prop('checked', true);		
		}
	});
</script>