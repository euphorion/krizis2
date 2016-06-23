<?php	require_once("../includes/session.php");?>
<?php	require_once("../includes/db_connection.php");?>
<?php	require_once("../includes/functions.php");?>
<?php confirm_logged_in();?> ?>
<?php 	require_once("../includes/validation_functions.php"); ?>
<?php $selected_admin = find_selected_admin(); ?>
<?php 
	if (isset($_POST['submit'])) {


		$username = mysql_prep($_POST["username"]);
		if ($_POST["password"] != $_POST["password2"]) {
			$_SESSION["errors"][] = "Пароли должны быть одинаковые";
			redirect_to("add_admin.php");
		}		
		
		$hashed_password = password_encrypt($_POST["password"]);
		$id = (int)$selected_admin["id"];
		
		$required_fields = array("username");
		validate_presences($required_fields);
		
		$fields_with_max_lengths = array("username" => 80);
		validate_max_lengths($fields_with_max_lengths);
				
		if (!empty($errors)) {
			$_SESSION["errors"] .= $errors;
			redirect_to("edit_admin.php?admin={$id}");
		}
		
		$query = "UPDATE admins SET ";
		$query .= "username = '{$username}', ";
		$query .= "hashed_password = '{$hashed_password}' ";
		$query .= "WHERE id = {$id} ";
		$query .= "LIMIT 1";
		
		$result = mysqli_query($connection, $query);
		if ($result && mysqli_affected_rows($connection) == 1) {
			$_SESSION["message"] = "Admin updated";
			redirect_to("manage_admins.php");
		}
		else {
			$_SESSION["message"] = "Admin updating failed";
		}
	}	
?>
<?php	include("../includes/admin_nav_sidebar.php");?>
<?php echo message(); ?>
<?php echo form_errors(); ?>
<h1 class="page-header">Изменить администратора</h1>
<form action="edit_admin.php?admin=<?php echo $selected_admin["id"]; ?>" method="post">
	
	<div class="input-group">
		<label for="username">Имя пользователя:</label>
	  <input type="text" class="form-control" placeholder="Введите имя пользователя" name="username" value="<?php echo $selected_admin["username"];?>">
	</div>	
	<div class="input-group">
		<label for="password">Пароль:</label>
	  <input type="password" class="form-control" placeholder="Введите пароль" name="password">
	</div>	
	<div class="input-group">
		<label for="password2">Повторите пароль:</label>
	  <input type="password" class="form-control" placeholder="Повторите пароль" name="password2">
	</div>		

	<button type="submit" class="btn btn-primary btn-md" name="submit">Изменить администратора</button>
</form>

<?php include("../includes/admin_end.php"); ?>