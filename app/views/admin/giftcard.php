<div class="container" style="margin-top: 50px;">
	<div class="col-md-10 col-md-offset-1 control">
		<div class="col-md-9">
			<h2>Presentkort</h2>
			<p>Här kan du granska, ändra, konvertera och förlänga presentkort!</p>
			<p>Endast aktiva / delvis använda presentkort visas här, för att se kort som ej har blivit aktiverade ännu gå till "ORDRAR"</p>
		</div>
		<div class="col-md-3">
			<a href="/admin/giftcard/create" class="btn" style="padding-top: 12px; color: #fff !important; margin-top: 30px;">
				Skapa presentkort
			</a>
		</div>
	</div>
</div>

<div class="container">
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading" style="padding-bottom: 23px;">
				<h4>Presentkort</h4>
				<div style="position: relative;">
					<input type="text" class="form-control search" style="float: right; width: 250px; margin-top: -27px;" placeholder="Sök: kod, kunduppgifter" value="">
					<a href="" class="search-href">	
						<i class="fa fa-search search-icon"></i>
					</a>
				</div>
			</div>
			<table class="table table-hover">
				<tr>
					<th>#</th>
					<th>Kod</th>
					<th>Förnamn</th>
					<th>Efternamn</th>
					<th>Utfärdad</th>
					<th>Löper ut</th>
					<th></th>
				</tr>
				<?php
					foreach($data as $row){
						echo "
						<tr class='active'>
							<td>" . $row['id'] . "</td>
							<td>" . $row['code'] . "</td>
							<td>" . $row['fname'] . "</td>
							<td>" . $row['lname'] . "</td>
							<td>" . date("Y-m-d", $row['time']) . "</td>
							<td>" . date("Y-m-d", $row['time'] + $row['expires']) ."</td>
							<td>
								<a href='/admin/giftcard/show/" . $row['id'] . "'>Visa presentkort</a>
							</td>
						</tr>";
					}
				?>
			</table>
			<?php
				if(!isset($data[0])){
					echo '
					<div class="infoTd col-md-8 col-md-offset-2">
						<p>Sök efter presentkortskod, eller kunduppgifter uppe i sökrutan för att visa resultat </p>
					</div>'	;
				}
			?>
		</div>
	</div>
</div>
<style>	
.control{
	background: #f1f1f1;
	padding: 20px;
	margin-bottom: 40px;
}
.orderscontainer{
	background: #f1f1f1;
	overflow: auto;
	padding: 10px;
}
.order-container{
	background: #DAD7D7;
}
.search-icon{
	position: absolute;
    right: 9px;
    top: -17px;
}
.infoTd{
	padding: 5px;
}
</style>
<script>
	$('.search').on("change", function(){
		var term = $(this).val();
		$('.search-href').attr("href", "/admin/giftcard/search/" + term)

	});
</script>