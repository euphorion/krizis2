<?php	require_once("../includes/session.php");?>
<?php	require_once("../includes/db_connection.php");?>
<?php	require_once("../includes/functions.php");?>
<?php confirm_logged_in();?> ?>
<?php 	require_once("../includes/validation_functions.php"); ?>
<?php $selected_admin = find_admin_by_id($_GET["admin"]); ?>
<?php 
	if (!$selected_admin) {
		redirect_to("manage_admins.php");
	}
	$id = $selected_admin["id"];
		
	$query = "DELETE FROM admins WHERE id = {$id} LIMIT 1";
	
	$result = mysqli_query($connection, $query);
	if ($result && mysqli_affected_rows($connection) == 1) {
		$_SESSION["message"] = "Admin deleted";
		redirect_to("manage_admins.php");
	}
	else {
		$_SESSION["message"] = "Admin deleting failed";
		redirect_to("manage_admins.php");
	}
?>