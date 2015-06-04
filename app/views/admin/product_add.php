<div class="container">
	<div class="col-md-12 wrapper">
		<div class="col-md-6 control-create">
			<h3 class="control-header">Välj en bild till kategori</h3>
			<form method="post" action="/admin/product/addnew" enctype="multipart/form-data">
				<input class="" type="file" name="image" style="margin-top: 30px;" required>
		</div>
		<div class="col-md-6">
			<h2>Skapa en ny kategori</h2>
			<p>Här lägger du till ny kategorier!</p>
			<p>För att koppla extratilläggen går då in på tillägg <i>"koppla"!</i></p>
		</div>
			<div class="col-md-12" style="margin-top: 40px;">
				<input type="hidden" name="product[id]" required>
				<label for="input">Kategorititel</label>
				<input class="input" type="text" name="product[name]" required>
				<label for="input">Kategoribeskrivning</label>
				<textarea class="input" name="product[desc]" style="height: 200px;" required></textarea>
				<div class="col-md-2" style="padding: 0;">
					<label for="input">Kategoripris</label>
					<input class="input" type="number" name="product[price]" required>
					<label for="input">Typ av produkt</label>
					  <label>
					    <input type="radio" name="product[type]" value="person" required> Per person
					  </label>
					  <label>
					    <input type="radio" name="product[type]" value="fixed" required> Fast pris
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