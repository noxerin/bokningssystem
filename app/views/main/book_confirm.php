<div class="confirmContainer">
	<div style="color: #3fd47d; position: absolute; left: 45%; top: 20px;">
		<i class="fa fa-check-circle-o fa-5x"></i>
	</div>
	<div style="position: absolute; left: 25%; top: 130px;">
		<h2>Tack för din bokning</h2>
		<br>
		<p>Du är välkommen på <?=$data[1][0]['name']?> den <u><?=date('j F \k\l H:i', $data[0][0]['time_from'])?></u></p>
	</div>
</div>

<style>
.confirmContainer{
	position: relative;
	width: 80%;
	margin-left: 10%;
	height: 200px;
	border: 3px dotted #e7e78a;
}
</style>