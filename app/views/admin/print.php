<!doctype html>
<html lang="sv">
	<head>
		<meta charset="utf-8">
	</head>
	<body onload="window.print()" onfocus="window.close()">
		<div class="container">
			<h1 style="letter-spacing: 6.5px; text-align: center; margin-bottom: 0;">LIFE LESS ORDINARY</h1>
			<div id="userimg">
				<img id="userimgimg" src="/assets/brasa.jpg">
				<img id="userimgoverlay" src="/assets/thelodge-trasnparent-line.png">
			</div>
			<div id="info">
				<div class="info-item">
					<h3>PRESENTKORT</h3>
					<p style="margin-top: -10px;">
						<b><?=$data[1][0]['name']?></b><br>
						<?=$data[1][0]['desc']?>
						<br>
						<br>
						<?php
							if(count($data[2][0]['desc']) >= 1){
								echo "
								<b>Och så något litet extra</b>
								<br>";
								foreach($data[2] as $row){
									echo $row['name'] . "<br>";
								}
							}
							
						?>
						</p>
				</div>
				<div class="info-item-small">
					<b>Personligt medelande:</b>
					<p><?=$data[0][0]['message']?></p>
				</div>
				<div class="info-item-small">
					<b>Presentkortskod:</b>
					<p># <?=$data[0][0]['code']?></p>
				</div>
			</div>
			<div id="footer">
				<img src="/assets/thelodge-logo.png">
				<p>Central reservations +46 46-24 89 05 info@thelodge.se www.thelodge.se</p>
			</div>
		</div>
	</body>
	<style>
		@font-face{
			font-family: thelodge;
			src: url("/assets/fonts/thelodge1.woff");
		}
		.container{
			-webkit-print-color-adjust: exact;
			font-family: thelodge;
			color: rgb(112,100,60);
			padding: 5px 30px;
			width: 530px;
			background: #fff;
			position: relative;
		}
		#userimg{
			position: relative;
			display: block;
			width: 100%;
			height: 280px;
		}
		#userimgimg{
			position: absolute;
			display: block;
			width: 100%;
			height: 280px;
			z-index: 998;
		}
		#userimgoverlay{
			position: relative;
			color: transparent;
			opacity: 0.2;
			width: 100%;
			z-index: 999;
		}
		#info{
			position: relative;
			background: #E9E7D1;
			margin-top: -10px;
			margin-left: -10px;
			padding-top: 5px;
			width: 103.5%;
			z-index: 900;
		}
		.info-item{
			width: 94%;
			margin: 10px;
			padding-left: 10px;
			border-radius: 9px;
			padding-bottom: 5px;
			background: rgba(253,253,252,1);
			background: -moz-linear-gradient(top, rgba(253,253,252,1) 74%, rgba(233,231,210,1) 100%);
			background: -webkit-gradient(left top, left bottom, color-stop(74%, rgba(253,253,252,1)), color-stop(100%, rgba(233,231,210,1)));
			background: -webkit-linear-gradient(top, rgba(253,253,252,1) 74%, rgba(233,231,210,1) 100%);
			background: -o-linear-gradient(top, rgba(253,253,252,1) 74%, rgba(233,231,210,1) 100%);
			background: -ms-linear-gradient(top, rgba(253,253,252,1) 74%, rgba(233,231,210,1) 100%);
			background: linear-gradient(to bottom, rgba(253,253,252,1) 74%, rgba(233,231,210,1) 100%);
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fdfdfc', endColorstr='#e9e7d2', GradientType=0 );
		}
		.info-item-small{
			width: 40%;
			margin: 15px;
			margin-top: 0px;
			display: inline-block;
			vertical-align: top;
			padding: 10px;
			padding-left: 10px;
			border-radius: 9px;
			background: rgba(253,253,252,1);
			background: -moz-linear-gradient(top, rgba(253,253,252,1) 74%, rgba(233,231,210,1) 100%);
			background: -webkit-gradient(left top, left bottom, color-stop(74%, rgba(253,253,252,1)), color-stop(100%, rgba(233,231,210,1)));
			background: -webkit-linear-gradient(top, rgba(253,253,252,1) 74%, rgba(233,231,210,1) 100%);
			background: -o-linear-gradient(top, rgba(253,253,252,1) 74%, rgba(233,231,210,1) 100%);
			background: -ms-linear-gradient(top, rgba(253,253,252,1) 74%, rgba(233,231,210,1) 100%);
			background: linear-gradient(to bottom, rgba(253,253,252,1) 74%, rgba(233,231,210,1) 100%);
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fdfdfc', endColorstr='#e9e7d2', GradientType=0 );
		}
		#footer{
			text-align: center;
		}
		#footer img{
			width: 220px;
			display: block;
			margin: 0 auto;
		}
	</style>
</html>