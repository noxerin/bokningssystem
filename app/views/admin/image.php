<div class="container" style="margin-top: 50px;">
	<div class="col-md-10 col-md-offset-1 control">
		<div class="col-md-6 control-create">
			<h3 class="control-header">Ladda upp en bild</h3>
			<form method="post" action="/admin/image/add" enctype="multipart/form-data">
				<input class="" type="file" name="image" style="margin-top: 30px;" required>
				<input type="submit" class="btn" value="Ladda upp" style="margin-top: 30px;">
			</form>
		</div>
		<div class="col-md-6">
			<h2>Bildhantering</h2>
			<p>Här kan du lägga till eller ta bort bilder i användning för presentkort!</p>
			<p>För att ta bort en bild klicka på <i class="fa fa-times fa-2x" style="color: #e74c3c"></i> som är på den bilden</p>
			<p>När en bild har tagits bort så går det inte att ändra på. Bilden måste då laddas upp igen!</p>
		</div>
	</div>
</div>

<div class="container">
	<div class="col-md-10 col-md-offset-1 imagecontainer">
		<?php
			foreach($data as $row){
				echo '
					<div class="image">
						<img src="/assets/images/' . $row['src'] . '">
						<a href="/admin/image/remove/' . $row['id'] . '">
							<i class="fa fa-times fa-3x"></i>
						</a>
					</div>
				';
			}
		?>
	</div>
</div>

<style>
.imagecontainer{
	background: #f1f1f1;
	overflow: auto;
	padding: 10px;
}
.image{
	position: relative;
	width: 49.5%;
	height: 200px;
	float: left;
	overflow: hidden;
	margin-right: 3px;
	margin-bottom: 3px; 
}
.image img{
	width: 100%;
	height: 100%;
}
.image i{
	position: absolute;
	bottom: 10px;
	right: 10px;
	transition: .8s ease;
	z-index: 999;
	color: #e74c3c;
	cursor: pointer;
}
.control{
	background: #f1f1f1;
	padding: 20px;
	margin-bottom: 40px;
}
</style>