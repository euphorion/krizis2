<?php	require_once("../includes/session.php");?>
<?php	require_once("../includes/db_connection.php");?>
<?php	require_once("../includes/functions.php");?>
<?php confirm_logged_in();?> ?>
<?php 	require_once("../includes/validation_functions.php"); ?>
<?php
	if (isset($_GET["shop"])) {
		$selected_shop = $_GET["shop"];
	}
	else {
		$_SESSION["errors"] = "Please select the shop to import";
		redirect_to("admin.php");
	}
?>
<?php
	switch ($selected_shop) {
		case "Maxima": redirect_to("import_maxima.php"); break;
		case "Prisma": redirect_to("import_prisma.php"); break;
		case "Selver": redirect_to("import_selver.php"); break;
		default: 	$_SESSION["errors"] = "Shop import script not registered";
					redirect_to("admin.php");
	}
?>