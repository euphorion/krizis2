<?php	require_once("../includes/session.php");?>
<?php	require_once("../includes/db_connection.php");?>
<?php	require_once("../includes/functions.php");?>
<?php 	require_once("../includes/validation_functions.php"); ?>
<?php $selected_product = find_product_by_id($_GET["product"]); ?>
<?php 
	if (!$selected_product) {
		redirect_to("manage_products.php");
	}
	$id = $selected_product["id"];
		
	$query = "DELETE FROM products WHERE id = {$id} LIMIT 1";
	
	$result = mysqli_query($connection, $query);
	if ($result && mysqli_affected_rows($connection) == 1) {
		$_SESSION["message"] = "Product deleted";
		redirect_to("manage_products.php");
	}
	else {
		$_SESSION["message"] = "Product deleting failed";
		redirect_to("manage_products.php");
	}
?>