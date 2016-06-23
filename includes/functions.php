<?php
	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed!");
		}		
	}

	function find_all_shops($public=false) {
		global $connection;
		$query = "SELECT * from shops ";
		if ($public) 
			$query .= "WHERE visible = true ";
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
	
	function find_all_products($public = false) {
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM products ";
		if ($public) 
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
	
	function find_shop_by_id($id, $public=false) {
		global $connection;
		$safe_id = mysqli_real_escape_string($connection, $id);
		$query = "SELECT * from shops ";
		$query .= "WHERE id = {$safe_id} ";
		if ($public)
			$query .= "AND visible = 1 ";
		$query .= "LIMIT 1";
		$result = mysqli_query($connection, $query);
		confirm_query($query);
		if ($shop = mysqli_fetch_assoc($result)) {
			return $shop;
		}
		else {
			return null;
		}
	}
	
	function find_selected_shop($public=false) {
		if (isset($_GET["shop"])) {
			return find_shop_by_id($_GET["shop"]);
		}		
	}
	
	function find_admin_by_id($id) {
		global $connection;
		$safe_id = mysqli_real_escape_string($connection, $id);
		$query = "SELECT * from admins ";
		$query .= "WHERE id = {$safe_id} ";
		$query .= "LIMIT 1";
		$result = mysqli_query($connection, $query);
		confirm_query($query);
		if ($admin = mysqli_fetch_assoc($result)) {
			return $admin;
		}
		else {
			return null;
		}
	}
	
	function find_admin_by_username($username) {
		global $connection;
		$safe_username = mysqli_real_escape_string($connection, $username);
		$query = "SELECT * from admins ";
		$query .= "WHERE username = '{$safe_username}' ";
		$query .= "LIMIT 1";
		$result = mysqli_query($connection, $query);
		confirm_query($query);
		if ($admin = mysqli_fetch_assoc($result)) {
			return $admin;
		}
		else {
			return null;
		}
	}
	
	function find_selected_admin() {
		if (isset($_GET["admin"])) {
			return find_admin_by_id($_GET["admin"]);
		}		
	}		
	
	function generate_salt($length) {
		$unique_random_string = md5(uniqid(mt_rand(), true));
		$base64_string = base64_encode($unique_random_string);
		$modified_base64_string = str_replace('+', '.', $base64_string);
		$salt = substr($modified_base64_string, 0, $length);
		
		return $salt;
	}
	
	function password_encrypt($password) {
		$format = "$2y$10$";
		$salt_length = 22;
		$salt = generate_salt($salt_length);
		$format_and_salt = $format . $salt;
		$hash = crypt($password, $format_and_salt);
		return $hash;		
	}		
	
	function password_check($password, $existing_hash) {
		$hash = crypt($password, $existing_hash);
		if ($hash === $existing_hash) {
			return true;
		}
		else {
			return false;
		}
	}
	
	function attempt_login($username, $password) {
		$admin = find_admin_by_username($username);
		if ( !$admin ) return false;
		$existing_hash = $admin["hashed_password"];
		if (password_check($password, $existing_hash)) {
			return $admin;
		}
		else {
			return false;
		}
	}
	
	function logged_in() {
		return isset($_SESSION["admin_id"]);
	}
	function confirm_logged_in() {
		if (!logged_in()) {
			redirect_to("login.php");
		}
	}	
?>