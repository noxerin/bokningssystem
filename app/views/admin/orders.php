<div class="container" style="margin-top: 50px;">
	<div class="col-md-10 col-md-offset-1 control">
		<div class="col-md-6 control-create">
			<h3 class="control-header">Granska ordrar</h3>
			<a href="/admin/orders/add" class="btn" style="padding-top: 12px; color: #fff !important; margin-top: 40px;">Skapa order</a>
		</div>
		<div class="col-md-6">
			<h2>Ordrar</h2>
			<p>Här kan du granska, korrigera och neka ordrar</p>
		</div>
	</div>
</div>

<div class="container">
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading">Ordrar</div>			
				<table class="table table-hover">
					<tr>
						<th>#</th>
						<th>Förnamn</th>
						<th>Efternamn</th>
						<th>Summa</th>
						<th>Status</th>
						<th>Datum</th>
						<th></th>
					</tr>
					<?php
						foreach($data as $row){
							echo "
							<tr>
								<td>" . $row['id'] . "</td>
								<td>" . $row['fname'] . "</td>
								<td>" . $row['lname'] . "</td>
								<td>" . $row['sum'] . " :-</td>
								<td>" . $row['status'] . "</td>
								<td>" . date("Y-m-d", $row['time']) . "</td>
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
</style>