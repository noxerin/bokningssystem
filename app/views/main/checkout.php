<div class="textcontainer">
	<h2 style="font-size: 22px; text-align: center;">Var ska vi skicka presentkortet?</h2>
</div>
<div class="dottedborder"></div>
<div class="itemcontainer">
	<div class="item" data-id="1">
		<img src="/assets/images/badkar.jpg">
		<i class="fa fa-check fa-3x selected"></i>
		<h1>Brev</h1>
		<p><b>Ditt presentkort skickas via posten!</b></p>
		<p>+25 kr</p>
	</div>
	<div class="item" data-id="2">
		<img src="/assets/images/rum.jpg">
		<i class="fa fa-circle-o fa-3x"></i>
		<h1>Special</h1>
		<p><b>Ditt presentkort skickas via posten! Men med en liten bit extra lyx!</b></p>
		<p>+80 kr</p>
	</div>
	<div class="item" style="margin: 0 auto; float: none;" data-id="3">
		<img src="/assets/images/brasa.jpg">
		<i class="fa fa-circle-o fa-3x"></i>
		<h1>Nerladdning</h1>
		<p><b>Du laddar ner presentkortet direkt efter betalningen!</b></p>
	</div>
</div>
<div class="dottedborder"></div>
<form action="/save/extras" method="post">
	<input type="hidden" value="" name="alternative" id="alternative">
	<div class="itemcontainer">
		<h1 style="font-size: 22px; text-align: center;">Kontaktuppgifter! Alla fält med * måste vara ifyllda</h1>
		<div class="iteminputcontainer">
			<div class="iteminput">
				<p>Förnamn * </p>
				<input type="text" value="" name="buyer[fname]" class="inputfield">
			</div>
			<div class="iteminput">
				<p>Efternamn * </p>
				<input type="text" value="" name="buyer[ename]" class="inputfield">
			</div>
		</div>
		<div class="iteminputcontainer">
			<div class="iteminput">
				<p>Personnummer * </p>
				<input type="text" value="" name="buyer[pnumber]" class="inputfield">
			</div>

			<div class="iteminput">
				<p>E-post * </p>
				<input type="text" value="" name="buyer[email]" class="inputfield">
			</div>
		</div>
		<div class="iteminputcontainer">
			<div class="iteminput">
				<p>Adress * </p>
				<input type="text" value="" name="buyer[adress]" class="inputfield">
			</div>
			<div class="iteminput">
				<p>Postnummer * </p>
				<input type="text" value="" name="buyer[postal]" class="inputfield">
			</div>
		</div>
		<div class="iteminputcontainer">
			<div class="iteminput">
				<p>Stad * </p>
				<input type="text" value="" name="buyer[city]" class="inputfield">
			</div>
			<div class="iteminput">
				<p>Land * </p>
				<select name="buyer[country]" class="inputfield">
					<option value="1">Sverige</option>
					<option value="2">Danmark</option>
					<option value="3">Norge</option>
				</select>
			</div>
		</div>
		<div class="iteminputcontainer">
			<div class="iteminput">
				<p>Telefonnummer * </p>
				<input type="text" value="" name="buyer[phone]" class="inputfield">
			</div>
		</div>
		<div class="iteminputcontainer">
			<div class="iteminput">
				<p>Företagsnamn </p>
				<input type="text" value="" name="buyer[company]" class="inputfield">
			</div>
			<div class="iteminput">
				<p>Företagsnummer </p>
				<input type="text" value="" name="buyer[companyid]" class="inputfield">
			</div>

		</div>
	</div>
	<div class="dottedborder"></div>
	<div class=""></div>
	<input type="submit" value="Nästa: Bekräfta och betala" class="btn" style="right: 20px; position: absolute; bottom: 20px;">	
</form>

<script>
	$(document).ready(function(){
		var id = $(".selected").parent('.item').data('id');
		$("#alternative").val(id);
	});
	
	$(".item").on("click", function(){
		$(".item i").removeClass("selected fa-check").addClass("fa-circle-o");
		$(this).find("i").removeClass('fa-circle-o').addClass("selected fa-check");
		var id = $(this).data("id");
		$("#alternative").val(id);
	});
</script>
<style>
.itemcontainer{
	overflow: hidden;
}
.item{
	height: 270px;
	display: block;
	width: 430px;
	float: left;
	margin-right: 5px;
	margin-bottom: 15px;
}
.iteminputcontainer{
	width: 660px;
	margin: 0 auto;
	margin-top: 20px;
	clear: both;
}
.iteminput{
	margin-right: 12px;
	margin-bottom: 20px;
	float: left;
}
.iteminput p{
	margin-bottom: 4px;
}
.inputfield{
	width: 300px;
}
.item img{
	height: 200px;
}
.item i{
	top: 150px;
}
.item h1{
	color: #000;
	text-align: center;
	margin-top: 5px;
	font-size: 24px;
}
.item p{
	text-align: center;
}
</style>