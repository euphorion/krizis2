<?php	require_once("../includes/session.php");?>
<?php	require_once("../includes/db_connection.php");?>
<?php	require_once("../includes/functions.php");?>
<?php confirm_logged_in();?> ?>
<?php 	require_once("../includes/validation_functions.php"); ?>
<?php 
	if (isset($_POST['submit'])) {

		$visible = (int)$_POST["visible"];
		$position = (int)$_POST["position"];
		$rus = mysql_prep($_POST["name"]);
		
		$required_fields = array("name", "visible", "position");
		validate_presences($required_fields);
		
		$fields_with_max_lengths = array("name" => 80);
		validate_max_lengths($fields_with_max_lengths);
		
		if (!empty($errors)) {
			$_SESSION["errors"] = $errors;
			redirect_to("add_shop.php");
		}
		
		$query = "INSERT INTO shops (name, visible, position) VALUES ('{$name}', {$visible}, {$position})";
		$result = mysqli_query($connection, $query);
		if ($result) {
			$_SESSION["message"] = "Shop created";
			redirect_to("manage_shops.php");
		}
		else {
			$_SESSION["message"] = "Shop creating failed";
		}
	}	
?>
<?php	include("../includes/admin_nav_sidebar.php");?>
<?php echo message(); ?>
<?php echo form_errors(); ?>
<h1 class="page-header">Добавить новый магазин</h1>
<form action="add_shop.php" method="post">
	
	<div class="input-group">
		<label for="name">Название:</label>
	  <input type="text" class="form-control" placeholder="Введите название" name="name">
	</div>	
	<div class="radio">
	<label class="radio">
	  <input type="radio" name="visible" checked="true" value="1">Показывается на странице
	</label>
	</div>
	<div class="radio">
	<label class="radio">
	  <input type="radio" name="visible" value="0">Не показывается на странице
	</label>	
	</div>
      <label for="position">Порядковый номер:</label>
      <select class="form-control" name="position">
		<?php $result = find_all_shops(); ?>
      	<?php $subject_count = mysqli_num_rows($result); ?>
      	<?php for ($count = 1; $count <= ($subject_count+1); $count++) {
      		echo "<option value=\"$count\">{$count}</option>";
		} ?>
      </select>
	<br />
	<button type="submit" class="btn btn-primary btn-md" name="submit">Создать магазин</button>
</form>

<?php
	mysqli_free_result($result);
?>   

<?php include("../includes/admin_end.php"); ?>