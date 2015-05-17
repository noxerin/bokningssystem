<div class="container" style="margin-top: 50px;">
	<div class="col-md-10 col-md-offset-1 control">
		<div class="col-md-6 control-create">
			<h3 class="control-header">Skapa en ny kategori</h3>
			<a href="/admin/product/add" class="btn" style="padding-top: 12px; color: #fff !important; margin-top: 70px;">Lägg till</a>
		</div>
		<div class="col-md-6">
		<h2>Kategorihantering</h2>
		<p>Här kan du lägga till, ta bort eller ändra kategorier!</p>
		<p>För att uppdatera en redan skapad kategori klicka <i class="fa fa-pencil fa-2x" style="color: #f1c40f"></i></p>
		<p>För att ta bort en kategori klicka på <i class="fa fa-times fa-2x" style="color: #e74c3c"></i></p>
	</div>
	</div>
</div>

<div class="container">
	<div class="col-md-10 col-md-offset-1 productcontainer">
		<?php
			foreach($data as $row){
				echo '
					<div class="product">
						<img src="/assets/images/' . $row['image'] . '">
						<a href="/admin/product/remove/' . $row['id'] . '">
							<i class="fa fa-times fa-3x"></i>
						</a>
						<a href="/admin/product/edit/' . $row['id'] . '">
							<i class="fa fa-pencil fa-3x" style="color: #f1c40f; left: 10px; right: auto;"></i>
						</a>
						<h1>' . $row['name'] . '</h1>
					</div>
				';
			}
		?>
	</div>
</div>

<style>
.productcontainer{
	background: #f1f1f1;
	overflow: auto;
	padding: 10px;
}
.product{
	position: relative;
	width: 49.5%;
	height: 230px;
	float: left;
	overflow: hidden;
	margin-right: 3px;
	margin-bottom: 10px;
	padding-bottom: 30px;
}
.product img{
	width: 100%;
	height: 100%;
}
.product i{
	position: absolute;
	bottom: 30px;
	right: 10px;
	transition: .8s ease;
	z-index: 999;
	color: #e74c3c;
	cursor: pointer;
}
.product h1{
	color: #000;
	text-align: center;
	margin-top: 5px;
	font-size: 24px;
}
.control{
	background: #f1f1f1;
	padding: 20px;
	margin-bottom: 40px;
}
</style>