<?php	require_once("../includes/session.php");?>
<?php	require_once("../includes/db_connection.php");?>
<?php	require_once("../includes/functions.php");?>
<?php 	require_once("../includes/validation_functions.php"); ?>
<?php $selected_category = find_category_by_id($_GET["category"]); ?>
<?php 
	if (!$selected_category) {
		redirect_to("manage_categories.php");
	}
	$id = $selected_category["id"];
		
	$query = "DELETE FROM categories WHERE id = {$id} LIMIT 1";
	
	$result = mysqli_query($connection, $query);
	if ($result && mysqli_affected_rows($connection) == 1) {
		$_SESSION["message"] = "Category deleted";
		redirect_to("manage_categories.php");
	}
	else {
		$_SESSION["message"] = "Category deleting failed";
		redirect_to("manage_categories.php");
	}
?>