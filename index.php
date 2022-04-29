<?php

include 'config/Db.php';
include 'config/functions.php';

$pages = scandir('pages/');
if (isset($_GET['page']) && !empty($_GET['page'])) {
	if (in_array($_GET['page'].'.php', $pages)) {
		$page = $_GET['page'];
	}else{
		$page ="404";
	}
}else{
	$page ="home";
}

?>
<!DOCTYPE html>
<html lang="fr">
	<head>
    <!-- L'icon du site -->
    <link rel="icon" href="assets/img/hot-solid-24.png" type="image/x-icon">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">

    <title><?= ucfirst($page)?> -  Franck Collins</title>

    <!-- Css -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css"/>
    
    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link href='assets/css/boxicons.min.css' rel='stylesheet'>
    
    <!-- Boxicons JS -->
    <link href='https://unpkg.com/boxicons@2.0.7/dist/boxicons.js' rel='stylesheet'>
    <link href='assets/js/boxicons.js' rel='stylesheet'>

    <link rel="stylesheet" type="text/css" href="assets/css/style.css"/>
  </head>
	<body style="padding:0; margin:0;">
		<?php require 'config/header.php';?>
		<div class="container-fluid">
			<?php
			include 'pages/'.$page.'.php';?>
		</div>
	<!-- ======= Footer ======= -->
<?php require 'config/footer.php';?>