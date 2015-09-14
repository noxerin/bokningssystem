<div class="container" style="margin-top: 50px;">
	<div class="col-md-10 col-md-offset-1 control">
		<div class="col-md-12">
			<h2>Ordrar</h2>
			<p>Här kan du granska, debitera, avbryta och återbetala ordrar!</p>
			<p>Klarnas ordrar är från början endast en reservation, fakturorna förblir så tills att administratören 
			av webbshoppen debiterar kunden! Detta kan göras genom att välja faktura och klicka på "Visa order"</p>
			<p>Reservationer förfaller efter 7 dagar! Systemet kommer att varna administratören genom att markera den ordern med en gul färg och 
				<span style='color: red;' title='Få dagar återstår på fakturan!'> !!!</span> efter att halva tiden har gått!
			</p>
			<p>Systemet kommer när det endast återstår en dag / några timmar att markera ordern röd och 
				<span style='color: red;' title='Få timmar återstår på fakturan!'> !!!</span>
			</p>
		</div>
	</div>
</div>

<div class="container">
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading" style="padding-bottom: 23px;">
				<h4>Ordrar</h4>
				<div style="position: relative;">
					<input type="text" class="form-control search" style="float: right; width: 250px; margin-top: -27px;" placeholder="Sök efter order: namn, order-ID" value="<?=$data[1]?>">
					<a href="" class="search-href">	
						<i class="fa fa-search search-icon"></i>
					</a>
				</div>
			</div>
				<table class="table table-hover">
					<tr>
						<th>#</th>
						<th>Förnamn</th>
						<th>Efternamn</th>
						<th>Status</th>
						<th>Genomförd</th>
						<th>Debitera senast</th>
						<th></th>
					</tr>
					<?php
						foreach($data[0] as $row){
							$class = null;
							$notation = null;
							if($row['status'] == "ACTIVE"){
								$class = "success";
							}else if($row['status'] == "REFUNDED" || $row['status'] == "CANCELED"){
								$class = "active";
							}else if((($row['time'] + 604800) - time()) <= 86400 ){
								$class = "danger";	
								$notation = "<span style='color: red;' title='Få timmar återstår på fakturan!'> !!!</span>";
							}else if((($row['time'] + 604800) - time()) <= 259200){
								$class = "warning";
								$notation = "<span style='color: red;' title='Få dagar återstår på fakturan!'> !!!</span>";
							}
							
							echo "
							<tr class='$class'>
								<td>" . $row['id'] . "</td>
								<td>" . $row['fname'] . "</td>
								<td>" . $row['lname'] . "</td>
								<td>" . $row['status'] . "</td>
								<td>" . date("Y-m-d", $row['time']) . "</td>
								<td>" . date("Y-m-d", $row['time'] + 604800) . $notation . "</td>
								<td>
									<a href='/admin/orders/order/" . $row['id'] . "'>Visa order</a>
								</td>
							</tr>";
						}
					?>
				</table>
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
</style>
<script>
	$('.search').on("change", function(){
		var term = $(this).val();
		$('.search-href').attr("href", "/admin/orders/" + term)

	});
</script>