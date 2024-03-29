<!DOCTYPE html>
<html lang="sv">
	<head>
		<title><?=$data;?></title>
		<meta charset="utf-8">
		<link rel="icon" type="image/png" href="/assets/favicon.png">
		<link rel="stylesheet" type="text/css" href="//<?=$GLOBALS['baseurl'];?>/css/style.css">
		<link rel="stylesheet" type="text/css" href="//<?=$GLOBALS['baseurl'];?>/css/font-awesome.css">
		<link rel="stylesheet" href="/css/nivo-slider.css" type="text/css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<script src="/assets/jquery.nivo.slider.pack.js" type="text/javascript"></script>
		<link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
		<link rel='stylesheet' href="/assets/fonts/font-awesome.min.css">
	</head>
	<body>
	<div class="page">
		<div class="header">
			<div id="logoContainer">
				<a href="http://thelodge.se" class="logo"><img src="/assets/logo.png"></a>
			</div>
			<div class="search">
				<div class="searchowl"></div>
				<form method="get" id="searchform" action="http://thelodge.se">
					<input type="text" class="searchbox" name="s" placeholder="Sök">
					<input type="submit" class="submit btn" name="submit" id="searchsubmit" value="Sök" style="margin-right: 10px;margin-top: 2px;">
				</form>
			</div>
			<div class="bildspel">
				<div id="slider" class="nivoSlider">
				    <img src="/assets/brasa.jpg" alt="" class="bildspel-bild"/>
				    <img src="/assets/seng.jpg" alt="" class="bildspel-bild"/>
				    <img src="/assets/jaccuzi.jpg" alt="" class="bildspel-bild" />
				</div>
			</div>
		</div>
		<div class="menu">
			<a href="//thelodge.se">
				<div class="menu-item">
					TILLBAKA TILL HOTELLET
				</div>
			</a>
		</div>