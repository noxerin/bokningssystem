<?php
	
error_reporting(-1);
ini_set('display_errors', 'On');
	

session_start();
date_default_timezone_set("Europe/Stockholm");

global $baseurl;
$baseurl = $_SERVER['SERVER_NAME'];	

require_once "core/Config.php";

require_once "lib/Database.php";
$db = new NXI\Database($config);

require_once('lib/klarna/klarna.php');
require_once('lib/klarna/transport/xmlrpc-3.0.0.beta/lib/xmlrpc.inc');
require_once('lib/klarna/transport/xmlrpc-3.0.0.beta/lib/xmlrpc_wrappers.inc');
$klarna = new Klarna();

require_once "core/App.php";
require_once "core/Controller.php";