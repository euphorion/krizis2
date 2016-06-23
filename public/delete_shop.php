<?php	require_once("../includes/session.php");?>
<?php	require_once("../includes/db_connection.php");?>
<?php	require_once("../includes/functions.php");?>
<?php confirm_logged_in();?> ?>
<?php 	require_once("../includes/validation_functions.php"); ?>
<?php $selected_shop = find_shop_by_id($_GET["shop"]); ?>
<?php 
	if (!$selected_shop) {
		redirect_to("manage_shops.php");
	}
	$id = $selected_shop["id"];
		
	$query = "DELETE FROM shops WHERE id = {$id} LIMIT 1";
	
	$result = mysqli_query($connection, $query);
	if ($result && mysqli_affected_rows($connection) == 1) {
		$_SESSION["message"] = "Shop deleted";
		redirect_to("manage_shops.php");
	}
	else {
		$_SESSION["message"] = "Shop deleting failed";
		redirect_to("manage_shops.php");
	}
?>