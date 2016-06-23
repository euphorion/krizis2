<?php	require_once("../includes/session.php");?>
<?php	require_once("../includes/db_connection.php");?>
<?php	require_once("../includes/functions.php");?>
<?php confirm_logged_in();?> ?>
<?php 	require_once("../includes/validation_functions.php"); ?>
<?php $selected_shop = find_selected_shop(); ?>
<?php 
	if (isset($_POST['submit'])) {

		$visible = (int)$_POST["visible"];
		$position = (int)$_POST["position"];
		$name = mysql_prep($_POST["name"]);
		$id = (int)$selected_shop["id"];
		
		$required_fields = array("name", "visible", "position");
		validate_presences($required_fields);
		
		$fields_with_max_lengths = array("name" => 80);
		validate_max_lengths($fields_with_max_lengths);
		
		if (!empty($errors)) {
			$_SESSION["errors"] = $errors;
			redirect_to("edit_shop.php?shop={$id}");
		}
		
		$query = "UPDATE shops SET ";
		$query .= "name = '{$name}', ";
		$query .= "position = {$position}, ";
		$query .= "visible = {$visible} ";
		$query .= "WHERE id = {$id} ";
		$query .= "LIMIT 1";
		
		$result = mysqli_query($connection, $query);
		if ($result && mysqli_affected_rows($connection) == 1) {
			$_SESSION["message"] = "Shop updated";
			redirect_to("manage_shops.php");
		}
		else {
			$_SESSION["message"] = "Shop updating failed";
		}
	}	
?>
<?php	include("../includes/admin_nav_sidebar.php");?>
<?php echo message(); ?>
<?php echo form_errors(); ?>
<h1 class="page-header">Изменить магазин</h1>
<form action="edit_shop.php?shop=<?php echo $selected_shop["id"]; ?>" method="post">
	
	<div class="input-group">
		<label for="name">Название:</label>
	  <input type="text" class="form-control" placeholder="Введите название" name="name" value="<?php echo $selected_shop["name"];?>">
	</div>	
	<div class="radio">
	<label class="radio">
	  <input type="radio" name="visible" value="1" <?php if ($selected_shop["visible"]) echo "checked"; ?>>Показывается на странице
	</label>
	</div>
	<div class="radio">
	<label class="radio">
	  <input type="radio" name="visible" value="0" <?php if (!$selected_shop["visible"]) echo "checked"; ?>>Не показывается на странице
	</label>	
	</div>
      <label for="position">Порядковый номер:</label>
      <select class="form-control" name="position">
		<?php $result = find_all_shops(); ?>
      	<?php $shop_count = mysqli_num_rows($result); ?>
      	<?php for ($count = 1; $count <= ($shop_count+1); $count++) {
      		echo "<option value=\"$count\"";
      		if ($count == $selected_shop["visible"]) echo " selected";
      		echo ">{$count}</option>";
		} ?>
      </select>
	<br />
	<button type="submit" class="btn btn-primary btn-md" name="submit">Изменить магазин</button>
</form>

<?php
	mysqli_free_result($result);
?>   

<?php include("../includes/admin_end.php"); ?>