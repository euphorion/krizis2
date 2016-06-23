<?php	require_once("../includes/session.php");?>
<?php	require_once("../includes/db_connection.php");?>
<?php confirm_logged_in();?> ?>
<?php	require_once("../includes/functions.php");?>
<?php 	require_once("../includes/validation_functions.php"); ?>
<?php 
	if (isset($_POST['submit'])) {

		$username = mysql_prep($_POST["username"]);
		if ($_POST["password"] != $_POST["password2"]) {
			$_SESSION["errors"][] = "Пароли должны быть одинаковые";
			redirect_to("add_admin.php");
		}		
		
		$hashed_password = password_encrypt($_POST["password"]);
		
		$required_fields = array("username");
		validate_presences($required_fields);
		
		$fields_with_max_lengths = array("username" => 80);
		validate_max_lengths($fields_with_max_lengths);
		
		if (!empty($errors)) {
			$_SESSION["errors"] = $errors;
			redirect_to("add_admin.php");
		}
		
		$query = "INSERT INTO admins (username, hashed_password) VALUES ('{$username}', '{$hashed_password}')";
		$result = mysqli_query($connection, $query);
		if ($result) {
			$_SESSION["message"] = "Admin created";
			redirect_to("manage_admins.php");
		}
		else {
			$_SESSION["message"] = "Admin creating failed";
		}
	}	
?>
<?php	include("../includes/admin_nav_sidebar.php");?>
<?php echo message(); ?>
<?php echo form_errors(); ?>
<h1 class="page-header">Добавить нового администратора</h1>
<form action="add_admin.php" method="post">
	
	<div class="input-group">
		<label for="username">Имя пользователя:</label>
	  <input type="text" class="form-control" placeholder="Введите имя" name="username">
	</div>	
	<div class="input-group">
		<label for="password">Пароль:</label>
	  <input type="password" class="form-control" placeholder="Введите пароль" name="password">
	</div>	
	<div class="input-group">
		<label for="password2">Повторите пароль:</label>
	  <input type="password" class="form-control" placeholder="Повторите пароль" name="password2">
	</div>		

	<button type="submit" class="btn btn-primary btn-md" name="submit">Создать администратора</button>
</form>

<?php include("../includes/admin_end.php"); ?>