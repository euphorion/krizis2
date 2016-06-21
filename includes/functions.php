<?php
	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed!");
		}		
	}

	function find_all_shops() {
		global $connection;
		$query = "SELECT * from shops ";
		$query .= "ORDER BY position ASC";
		$result = mysqli_query($connection, $query);
		confirm_query($result);
		return $result;
	}

	function find_visible_categories() {
		global $connection;
		$query = "SELECT * from categories ";
		$query .= "WHERE visible = 1 ";
		$query .= "ORDER BY position ASC";
		$result = mysqli_query($connection, $query);
		confirm_query($result);
		$categories = array();
		while($row = mysqli_fetch_assoc($result)) {
			$categories[$row["id"]] = $row[$_SESSION["lang"]];
		}	
		mysqli_free_result($result);
		return $categories;		
	}
	
	function find_all_categories() {
		global $connection;
		$query = "SELECT * from categories ";
		$query .= "ORDER BY position ASC";
		$result = mysqli_query($connection, $query);
		confirm_query($result);
		return $result;		
	}	
	
	function find_all_products() {
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM products ";
		$query .= "WHERE visible = 1 ";
		if ($_SESSION["category"] != CATEGORY_ALL)
			$query .= "AND category_id = {$_SESSION["category"]} ";
		$query .= "ORDER BY id ASC";
		$result = mysqli_query($connection, $query);
		confirm_query($result);	
		return $result; 	
	}
	
	function redirect_to($new_location) {
		header("Location: " . $new_location);
		exit;
	}
	
	function mysql_prep($string) {
		global $connection;
		return mysqli_real_escape_string($connection, $string);
	}
	
	function form_errors() {
		$output = "";
		if (!empty($_SESSION["errors"])) {
		  $output .= "<div class=\"error\">";
		  $output .= "Please fix the following errors:";
		  $output .= "<ul>";
		  foreach ($_SESSION["errors"] as $key => $error) {
		    $output .= "<li>";
				$output .= htmlentities($error);
				$output .= "</li>";
		  }
		  $output .= "</ul>";
		  $output .= "</div>";
		}
		$_SESSION["errors"] = null;
		return $output;
	}	
	
	function find_category_by_id($id, $public=false) {
		global $connection;
		$safe_id = mysqli_real_escape_string($connection, $id);
		$query = "SELECT * from categories ";
		$query .= "WHERE id = {$safe_id} ";
		if ($public)
			$query .= "AND visible = 1 ";
		$query .= "LIMIT 1";
		$result = mysqli_query($connection, $query);
		confirm_query($query);
		if ($category = mysqli_fetch_assoc($result)) {
			return $category;
		}
		else {
			return null;
		}
	}
	
	function find_selected_category($public=false) {
		if (isset($_GET["category"])) {
			return find_category_by_id($_GET["category"]);
		}		
	}
	
	function find_product_by_id($id, $public=false) {
		global $connection;
		$safe_id = mysqli_real_escape_string($connection, $id);
		$query = "SELECT * from products ";
		$query .= "WHERE id = {$safe_id} ";
		if ($public)
			$query .= "AND visible = 1 ";
		$query .= "LIMIT 1";
		$result = mysqli_query($connection, $query);
		confirm_query($query);
		if ($product = mysqli_fetch_assoc($result)) {
			return $product;
		}
		else {
			return null;
		}
	}
	
	function find_selected_product($public=false) {
		if (isset($_GET["product"])) {
			return find_product_by_id($_GET["product"]);
		}		
	}	
?>