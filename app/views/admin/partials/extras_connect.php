<div class="container">
	<div class="col-md-12 wrapper">
		<div style="margin-left: 50px;">
			<div class="extras-item">
			</div>
			<div class="extras-item">
			</div>
			<div class="extras-item">
			</div>
			<div class="extras-item">
			</div>
			<div class="extras-item">
			</div>
			<div class="extras-item">
			</div>
			<div class="extras-item">
			</div>
			<div class="extras-item">
			</div>
		</div>
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
}
</style>


<?php

			foreach($data[0] as $row){
				if($data[1]){
					foreach($data[1] as $row2){
						if($row['id'] == $row2['id']){
							echo $row['name'] . " Selected";
						}else{
							echo $row['name'];
						}
					}
				}else{
					echo $row['name'];
				}
			}

?>