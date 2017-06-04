<?php
require_once('funk.php');
session_start();
connect_db();
$page="login";
include_once('vaated/head.html');

if (isset($_GET['page']) && $_GET['page']!=""){
	$page=htmlspecialchars($_GET['page']);
}

switch($page){
	case "login":
		include('vaated/login.html');
	break;
	case "hindamine":
		include('vaated/hindamine.html');
	break;
}

if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['hindan'])){hindamine($_POST["id"], $_POST["pakkumine"]);}
include_once('vaated/foot.html');
?>