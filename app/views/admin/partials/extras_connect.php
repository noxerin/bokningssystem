<div class="container">
	<div class="col-md-12 wrapper" style="position: relative;">
		<h3 style="margin-top: 0;">Välj tillägg</h3>
		<form method="post" action="/admin/product/updateAddonSelection">
			<div class="col-md-12" style="margin-left: 30px;">
			<?php
				foreach($data[0] as $row){
					if($data[1]){
						foreach($data[1] as $row2){
							if($row['id'] == $row2['id']){
								echo '
								<div class="extras-item">
									<img src="/assets/images/' .$row['image']. '" class="extras-item-img">
									<p>' . $row['name'] . '</p>
									<i class="fa fa-check selected"></i>
									<input type="checkbox" value="' .$row['id']. '" checked hidden name="extras[]">
								</div>';
							}else{
								echo '
								<div class="extras-item">
								<img src="/assets/images/' .$row['image']. '" class="extras-item-img">
									<p>' . $row['name'] . '</p>
									<i class="fa fa-check"></i>
									<input type="checkbox" value="' .$row['id']. '" hidden name="extras[]">
								</div>';
							}
						}
					}else{
						echo '
						<div class="extras-item">
							<img src="/assets/images/' .$row['image']. '" class="extras-item-img">
							<p>' . $row['name'] . '</p>
							<i class="fa fa-check"></i>
							<input type="checkbox" value="'.$row['id'].'" hidden name="extras[]">
						</div>';
					}
				}
			?>
			</div>
			<div class="col-md-4 col-md-offset-4">
				<input type="text" value="<?=$data[2]?>" name="id" hidden >
				<input type="submit" class="btn col-md-12" style="margin-top: 20px;" value="Uppdatera">
			</div>
		</form>
	</div>
</div>

<style>
.extras-item{
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
.extras-item-img{
	width: 100%;
	height: 100%;
}
.extras-item p{
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