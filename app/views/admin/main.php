<div class="container" style="margin-top: 50px;">
	<div class="col-md-2 latest-boxes latest-boxes-1">
		<div class="latest-text">
			<h1>1</h1>
			<small>Nya köp idag</small>
		</div>
	</div>
	<div class="col-md-2 col-md-offset-1 latest-boxes latest-boxes-3">
		<div class="latest-text">
			<h1>10</h1>
			<small>Totalt sålda</small>
		</div>
	</div>
	<div class="col-md-2 col-md-offset-1 latest-boxes latest-boxes-2">
		<div class="latest-text">
			<h1>2</h1>
			<small>Bokningar för idag</small>
		</div>
	</div>
	<div class="col-md-2 col-md-offset-1 latest-boxes latest-boxes-4">
		<div class="latest-text">
			<h1>200</h1>
			<small>Totalt antal bokningar</small>
		</div>
	</div>
	<div class="col-md-12" style="margin-top: 30px;">
		<h2>Statistik</h2>
	</div>
	<div class="col-md-12 latest-actions">
		<div class="row">
			<div class="col-md-12">
				<canvas id="yearreport" style="width: 100%; height: 300px;"></canvas>
			</div>
		</div>
		<div class="row" style="padding-top: 40px;">
			<div class="col-md-3 col-md-offset-1">
				<h3>Mest säljande produkterna</h3>
				<canvas id="mostselling" width="300" height="300"></canvas>
			</div>
			<div class="col-md-3 col-md-offset-3">	
				<h3>Mest säljande tilläggen</h3>
				<canvas id="mostsoldtoday" width="300" height="300"></canvas>
			</div>
		</div>
	</div>
</div>
<script src="/assets/Chart.js"></script>
<script>
//Year statistics
var ctx = [$("#yearreport").get(0).getContext("2d"), $("#mostselling").get(0).getContext("2d"), $("#mostsoldtoday").get(0).getContext("2d")];

var data = {
    labels: ["Januari", "Februari", "Mars", "April", "Maj", "Juni", "Juli", "Augusti", "September", "Oktober", "November", "December"],
    datasets: [
        {
            label: "Årsstatistik",
            fillColor: "rgba(220,220,220,0.2)",
            strokeColor: "rgba(220,220,220,1)",
            pointColor: "rgba(220,220,220,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: [
            <?php
	            foreach($data[0] as $row){
		            echo $row . ',';
	            }
            ?>
            ]
        }
    ]
};
var myLineChart = new Chart(ctx[0]).Line(data, {
	///Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines : true,

    //String - Colour of the grid lines
    scaleGridLineColor : "rgba(0,0,0,.05)",

    //Number - Width of the grid lines
    scaleGridLineWidth : 1,

    //Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,

    //Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines: true,
});

//Most selling product
var data = [
    {
        value: <?=$data[1][0]['item_occurrence']?>,
        color:"#F7464A",
        highlight: "#FF5A5E",
        label: "<?=$data[1][0]['name']?>"
    },
    {
        value: <?=$data[1][1]['item_occurrence']?>,
        color: "#46BFBD",
        highlight: "#5AD3D1",
        label: "<?=$data[1][1]['name']?>"
    },
    {
        value: <?=$data[1][2]['item_occurrence']?>,
        color: "#FDB45C",
        highlight: "#FFC870",
        label: "<?=$data[1][2]['name']?>"
    },
    {
        value: <?=$data[1][3]['item_occurrence']?>,
        color:"#2ecc71",
        highlight: "#2cc36b",
        label: "<?=$data[1][3]['name']?>"
    },
    {
        value: <?=$data[1][4]['item_occurrence']?>,
        color: "#2c3e50",
        highlight: "#34495e",
        label: "<?=$data[1][4]['name']?>"
    }
]
var myLineChart = new Chart(ctx[1]).Pie(data);
//Most sold today
var data = [
	<?php
		$int = 1;
		foreach($data[2] as $row){
			switch($int){
			    case 1:
			    	echo '
			    	{
				        value: ' . $data[2][0]['item_occurrence'] . ',
				        color:"#F7464A",
				        highlight: "#FF5A5E",
				        label: "' . $data[2][0]['name'] . ' "
				    }';
				break;
				case 2:
					echo '
			    	,{
				        value: ' . $data[2][1]['item_occurrence'] . ',
				        color:"#46BFBD",
				        highlight: "#5AD3D1",
				        label: "' . $data[2][1]['name'] . ' "
				    }';
				break;
				case 3:
					echo '
			    	,{
				        value: ' . $data[2][2]['item_occurrence'] . ',
				        color:"#2980b9",
				        highlight: "#3498db",
				        label: "' . $data[2][2]['name'] . ' "
				    }';
				break;
				case 4:
					echo '
			    	,{
				        value: ' . $data[2][3]['item_occurrence'] . ',
				        color:"#f39c12",
				        highlight: "#f1c40f",
				        label: "' . $data[2][3]['name'] . ' "
				    }';
				break;
				case 5:
					echo '
			    	,{
				        value: ' . $data[2][4]['item_occurrence'] . ',
				        color:"#2c3e50",
				        highlight: "#34495e",
				        label: "' . $data[2][4]['name'] . ' "
				    }';
				break;
			}
			$int++;
		}
		?>
]
var myLineChart = new Chart(ctx[2]).Doughnut(data);

</script>