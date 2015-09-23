<div class="container" style="margin-top: 50px;">
	<div class="col-md-10 col-md-offset-1 control">
		<div class="col-md-6 control-create">
			<h3 class="control-header">Exportera data</h3>
			<a href="" class="btn day" style="padding-top: 12px; color: #fff !important; margin-top: 40px;">En dag</a>
			<input type="text" id="day" class="input date-input date-picker-day">
			
			<a href="" class="btn month" style="padding-top: 12px; color: #fff !important; margin-top: 10px;">En månad</a>
			<input type="text" name="month" id="month" class="input date-input date-picker-month">

			<a href="" class="btn year" style="padding-top: 12px; color: #fff !important; margin-top: 10px;">Ett år</a>
			<input type="text" name="year" id="year" class="input date-input date-picker-year">
			
			<a href="/admin/orders/order_export/ALL" class="btn" style="padding-top: 12px; color: #fff !important; margin-top: 10px;">Allt</a>
		</div>
		<div class="col-md-6">
			<h2>Export</h2>
			<p>Här kan du exportera data för bruk i bokföring!</p>
		</div>
	</div>
</div>
<style>
.control{
	background: #f1f1f1;
	padding: 20px;
	margin-bottom: 40px;
}
.date-input{
	width: 150px;
	margin-top: 5px;
}
</style>
<script>
	
$('.btn').on('click', function(e){
	e.preventDefault();
	var href = null;
	if($(this).hasClass('day')){
		var href = "/admin/orders/order_export/DAY/";
		href += $(this).next('input').val();
	}else if($(this).hasClass('month')){
		var href = "/admin/orders/order_export/MONTH/";
		href += $(this).next('input').val();
	}else if($(this).hasClass('year')){
		var href = "/admin/orders/order_export/YEAR/";
		href += $(this).next('input').val();
		href += "-01-01";
	}
	location.href = href;
});
	

$(function() {
    $('.date-picker-day').datepicker({
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'yy-mm-dd',
        onClose: function(dateText, inst) { 
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
        }
    });
	$(".date-picker-day").focus(function () {
    });
});

$(function() {
    $('.date-picker-month').datepicker({
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'yy-mm',
        onClose: function(dateText, inst) { 
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        }
    });
	$(".date-picker-month").focus(function () {
    });
});

$(function() {
    $('.date-picker-year').datepicker({
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'yy',
        onClose: function(dateText, inst) { 
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, 1));
        }
    });
	$(".date-picker-year").focus(function () {
        $(".ui-datepicker-month").hide();
    });
});
</script>
