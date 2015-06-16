<div class="container">
	<div class="col-md-12 wrapper">
		<div class="col-md-6 control-create">
			<h3 class="control-header">Byt bild för tillägg</h3>
			<form method="post" action="/admin/extras/updateimg" enctype="multipart/form-data">
				<input class="" type="file" name="image" style="margin-top: 30px;" required>
				<input type="hidden" name="id" value="<?=$data[0]['id']?>">
				<input type="hidden" name="oldimg" value="<?=$data[0]['image']?>">
				<input type="submit" class="btn" value="Ladda upp" style="margin-top: 30px;">
			</form>
		</div>
		<div class="col-md-6">
			<h3>Nuvarande bild</h3>
			<img src="<?="/assets/images/".$data[0]['image']?>" id="currentimg">
		</div>
	</div>
	<div class="col-md-10 wrapper col-md-offset-1">
		<form method="post" action="/admin/extras/update">
			<div class="col-md-12">
				<input type="hidden" name="product[id]" value="<?=$data[0]['id']?>">
				<label for="input">Tilläggstitel</label>
				<input class="input" type="text" name="product[name]" value="<?=$data[0]['name']?>">
				<label for="input">Tilläggsbeskrivning</label>
				<textarea class="input" name="product[desc]" style="height: 200px;"><?=$data[0]['desc']?></textarea>
				<div class="col-md-2" style="padding: 0;">
					<label for="input">Tilläggspris</label>
					<input class="input" type="number" name="product[price]" value="<?=$data[0]['price']?>">
					<label for="input">Typ av tillägg</label>
					  <label>
					    <input type="radio" name="product[type]" value="person" <?php if($data[0]['type'] == "person"){echo "checked";}?>> Per person
					  </label>
					  <label>
					    <input type="radio" name="product[type]" value="fixed" <?php if($data[0]['type'] == "fixed"){echo "checked";}?>> Fast pris
					  </label>
				</div>
			</div>
			<div class="col-md-6 col-md-offset-3">
				<input type="submit" class="btn" value="Uppdatera" style="margin-top: 30px; background: #2ecc71;">
			</div>
		</form>
	</div>
</div>

<style>
.wrapper{
	margin-top: 20px;
	margin-bottom: 20px;
	background: #f1f1f1;
	padding: 20px;
}
#currentimg{
	width: 420px;
	height: 190px;
	margin: 0 auto;
	display: block;
}

</style>