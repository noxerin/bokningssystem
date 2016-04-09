<div class="textcontainer">
	<h1>Ditt presentkort</h1>
	<p>Kontrollera ditt presentkort eller gör en bokning!<p>
	<p><b>Löper ut: <?=date("Y-m-d h:m", ($data[0][0][0]['time'] + $data[0][0][0]['expires']));?>
	<?php
	if(($data[0][0][0]['time'] + $data[0][0][0]['expires']) < time()){
		echo "<br><i style='color: #f18477;'>* Ditt presentkort har tyvär löpt ut! Kontakta Thelodge för att förlänga giltighetstiden</i>";	
	}
	?>
</div>
<div class="dottedborder"></div>
<div class="infoContainer">
	<div class="infoImage">
		<img src="/assets/images/<?=$data[0][1][0]['image']?>">
	</div>
	<div class="infoText">
		<h2><?=$data[0][1][0]['name']?></h2>
		<br>
		<p><?=$data[0][1][0]['desc']?></p>
		<div class="dottedborder"></div>
		<h2>Presentkortsmedelande:</h2>
		<br>
		<?php 
			if(strlen($data[0][0][0]['message']) > 0){
				echo '<p style="text-align: center;">' . $data[0][0][0]['message'] . '</p>';
			}else{
				echo '<p style="text-align: center;">Inget meddelande!</p>';
			}
		?>
	</div>
</div>
<div class="orderInfo">
	<h3 style="margin-left: 90px; margin-bottom: -30px;"><i>Detta <u>presentkortet</u> innehåller</i></h3>
	<div class="itemcontainer">
		<div class="receipt">
			<div class="product-head">
				<ul>
					<li class="li1"><h3>TYP</h3></li>
					<li class="li2"><h3>ANVÄNDNA/TOTALT ANTAL</h3></li>
					<li class="li3"><h3>PRIS Á</h3></li>
					<li class="li4"><h3>TOTAL</h3></li>
				</ul>
			</div>
			<?php
			$totalSum = $data[0][1][0]['cost']*$data[0][1][0]['count'];
			echo '
				<div class="product">
					<ul>
						<li class="li1"><p>Presentkort - ' . $data[0][1][0]['name'] . '</p></li>
						<li class="li2"><p>' . $data[0][1][0]['used'] . ' / ' .$data[0][1][0]['count'] . '</p></li>
						<li class="li3"><p>' . $data[0][1][0]['cost'] . ' :-</p></li>
						<li class="li4"><p>' . $data[0][1][0]['cost']*$data[0][1][0]['count'] . ' :-</p></li>
					</ul>
					<div class="product-seperator"></div>
				</div>';

				if(count($data[0][2]) > 0){
					foreach($data[0][2] as $row){
						$totalSum += $row['cost']*$row['count'];
						echo '
						<div class="product">
							<ul>
								<li class="li1"><p>Tillägg - ' . $row['name'] . '</p></li>
								<li class="li2"><p>' . $row['used'] . ' / '. $row['count'] .'</p></li>
								<li class="li3"><p>' . $row['cost'] . ' :-</p></li>
								<li class="li4"><p>' . $row['cost']*$row['count'] . ' :-</p></li>
							</ul>
							<div class="product-seperator"></div>
						</div>';
					}
				}
			?>	
			<small style="margin-left: 41px;">* Vill du ändra till en annan produkt kontakta The lodge på telefon</small>
		</div>
	</div>
</div>
<?php
	if($data[0][1][0]['bookable'] == 1 && ($data[0][0][0]['time'] + $data[0][0][0]['expires']) > time()){	
?>
<div class="dottedborder">
	<h2 style="margin-top: -30px;">Välj ett datum så får vi se vilka tider som ligger nära!</h2>
</div>
<div class="bookingContainer">
	<div id="datepicker"></div>
	<div class="bookingAltContainer">
			<?php 
				if($_SESSION['book']['code'] != $_GET['code']){
					if($data[0][1][0]['used'] == $data[0][1][0]['count']){
						echo '
						<div class="bookingCountContainer">
							<div class="bookingCountMain">
								<h2>Du har förbrukat ditt presentkort</h2>
								<p>Även om du har tillägg kvar så går dessa ej att bokas ensamstående</p>
							</div>
						</div>';
					}else{
			?>
		<div class="bookingCountContainer">
			<div class="bookingCountMain">
				<h2>Välj antal</h2>
				<p>Välj hur många av varje produkt du vill boka</p>
				<div>
					<form action="/book/save_count" method="post">
						<div class="bookingCountInput">
							<p><?=$data[0][1][0]['name']?></p>
							<input type="number" name="count[0][count]" class="inputCount" value="" max="<?=$data[0][1][0]['count']-$data[0][1][0]['used']?>" min="1" onkeydown="return false">
							<input type="hidden" name="count[0][id]" value="<?=$data[0][1][0]['id']?>">
						</div>
						<?php
						$count = 1;
						foreach($data[0][2] as $row){
							if($row['used'] != $row['count']){
								echo '
								<div class="bookingCountInput">
									<p>' . $row['name'] . '</p>
									<input type="number" name="count[' . $count . '][count]" class="inputCount" value="" max="' . (1 - $row['used']) . '" min="0" onkeydown="return false">
									<input type="hidden" name="count[' . $count . '][id]" value="' . $row['id'] . '">
								</div>';
							}
							$count++;
						}	
							
						?>
						<input type="hidden" name="code" value="<?=$_GET['code']?>">
						<input type="submit" class="CountBtn btn" value="Välj" style="right: 5px; bottom: 5px; position: absolute;">
					</form>	
				</div>
			</div>
		</div>
			<?php
					}
				}
			?>
		<div class="bookingAltHead">
			<h2>Tillgängliga bokningstider</h2>
			<i class="fa fa-calendar" style="float: right; margin-top: -22px; margin-right: 15px;"></i>
		</div>
		<div class="bookingAltBodyContainer">
			<p class="bookingInfo bookingRemove">Du har inte valt ett datum i kalendern till höger!</p>
		</div>
	</div>
	<form action="/book/" method="post" class="bookSubmit">
		<input type="submit" class="btn btndisabled" value="Nästa" disabled style="padding: 10px 15px;">
	</form>
</div>
<?php
	}	
?>
<style>
.bookingContainer{
	width: 95%;
	margin: 0 auto;
}
#datepicker{
	float: right;
	width: 35%;
}
.bookingAltContainer{
	width: 55%;
	margin-left: 5%;
	min-height: 245px;
	max-height: 600px;
	background: #F7F7F9;
	border: 1px solid #393939;
	border-radius: 5px 5px 0 0;
}
.bookingAltHead{
	border-bottom: 1px solid #393939;
	padding: 8px 0 5px 10px;
}
.bookingAltBodyContainer{
	width: 100%;
}
.bookingInfo{
	text-align: center;
	margin-top: 85px;
	padding: 5px;
	background: #ccccd1;
}
.bookingItem{
	width: 94%;
	padding: 15px 2%;
	background: #fff;
	margin: 5px 5px;
	border-radius: 4px;
	border: 1px solid #6b6b66;
	cursor: pointer;
}
.bookingCountContainer{
	position: absolute;
	margin-top: -5px;
	margin-left: -6px;
	width: 85%;
	height: 300px;
	background: rgba(205, 205, 209, .92);
	border-radius: 5px 5px 0 0;
	z-index: 999;
}
.bookingCountMain{
	background: #fff;
	width: 80%;
	height: 180px;
	margin-top: 60px;
	margin-left: 10%;
	border: 4px dotted #EDEDDE;
	padding: 5px;
	position: relative;
}
.bookingCountInput{
	margin-top: 30px;
	margin-right: 10px;
	display: inline-block;
}
.bookingCountInput input{
	width: 30px;
	display: block;
	margin: 0 auto;
}
.bookingItem:hover{
	background: #e7ebd9;
}
.bookingItem:active{
	background: #acb294;
}
.selectedItem{
	background: #acb294;
	color: #fff;
}
.bookSubmit{
	margin-right: 60px;
	margin-top: 10px;
}
.inputCount{
	border-radius: 4px;
	width: 20px;
	border: 1px solid #d5d5d0;
    padding: 6px 14px;
}
.ui-datepicker{
	font-size: 15px;
}
.ui-datepicker-current{
	visibility: hidden;
}
.ui-datepicker-current-day{
	background: #a2a419;
}
.dottedborder{
	border-color: #a1a197 !important;
}
.infoContainer{
	width: 95%;
	height: 300px;
	margin: 0 auto;
}
.infoImage{
	float: left;
	height: 100%;
	width: 45%;
	margin-left: 5px;
}
.infoImage img{
	margin: 0 auto;
	margin-top: ;
	display: block;
	width: 100%;
	height: 100%;
}
.infoText{
	float: right;
	height: 100%;
	width: 52%;
	margin-right: 5px;
}
h2{
	font-size: 24px;
}
.orderInfo{
	margin-top: 15px;
}
.receipt{
	max-width: 100%;
	padding: 20px;
	padding-top: 10px;
	padding-left: 0;
	overflow: auto;
	position: relative;
}
.product-head{
	height: 20px;
	margin-bottom: 10px;
}
.product{
	margin-top: 10px;
	border-width: 80%;
}
.product-seperator{
	width: 90%;
	height: 20px;
	border-bottom: 1px solid #7f7a7a;
	margin: 0 auto;
}
li{
	float: left;
	margin-left: 5%;
	display: inline-block;
}
.li1{
	width: 30%;
}
.li2{
	width: 25%;
}
.li3, .li4{
	width: 10%;
}
.li4{
	text-align: center;
}
.receipt-sum{
	width: 200px;
	height: 60px;
	float: right;
	margin-top: 30px;
	margin-right: 42px;
}
.receipt-sum h5{
	margin-bottom: 10px;
	padding-bottom: 5px;
	border-bottom: 1px solid #7f7a7a;
}
.receipt-sum p{
	padding-left: 15px; 
}

</style>
<script>

function fetchDates(bookingid, date_str){
	var containerID = $(".bookingAltBodyContainer");
	var request = $.ajax({
		url: "/book/ajax_fetchTimes",
		type: "POST",
		data: {id : bookingid, date: date_str},
		dataType: "html"
	});
	
	request.done(function(msg) {
		$(".bookingRemove").remove();
		$(containerID).append(msg);
	});
	
	request.fail(function(jqXHR, textStatus) {
		console.log( "Request failed: " + textStatus );
	});
}	
	
function resetChoice(){
	$('.bookSubmit').attr('action', "book/");
	$('.bookSubmit input').addClass('btndisabled');
	$('.bookSubmit input').prop("disabled", true);
}

$(function() {
	<?php
		if(count($data[1]) >= 1){
			echo "availableDates = [";
			foreach($data[1] as $row){
				echo '"' . date("m-d-Y", $row['time_from']) . '",';
			}
			echo "];";
		}
	?>
    $('#datepicker').datepicker({
	    dateFormat: 'yy-mm-dd',
	    beforeShowDay: function(d) {
	        var dmy = (d.getMonth()+1)
	        if(d.getMonth()<9) 
	            dmy="0"+dmy; 
	        dmy+= "-"; 
	
	        if(d.getDate()<10) dmy+="0"; 
	            dmy+=d.getDate() + "-" + d.getFullYear(); 
	
	        console.log(dmy+' : '+($.inArray(dmy, availableDates)));
	
	        if ($.inArray(dmy, availableDates) != -1) {
	            return [true, "","Available"]; 
	        } else{
	             return [false,"","unAvailable"]; 
	        }
	    },
	    changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
	    todayBtn: "linked",
	    autoclose: true,
	    todayHighlight: true,
		onSelect: function (dateText, inst) {
        	console.log(dateText + " Chosen");
        	fetchDates(<?=$data[0][1][0]['id']?>  , dateText);
        	resetChoice();
        },
        onClose: function(dateText, inst) { 
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
        }
    });
	$(".date-picker-day").focus(function () {
    });
});

$('.bookingAltBodyContainer').on('click',  ".bookingItem" , function(){
	var selected = $(this);
	var selectedId = 0;
	$('.bookingItem').removeClass('selectedItem');
	selected.addClass('selectedItem');
	selectedId = selected.data('id');
	$('.bookSubmit').attr('action', "/book/book_details/" +selectedId);
	$('.bookSubmit input').removeClass('btndisabled');
	$('.bookSubmit input').prop("disabled", false);
});
</script>