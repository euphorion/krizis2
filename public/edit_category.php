<?php	require_once("../includes/session.php");?>
<?php	require_once("../includes/db_connection.php");?>
<?php	require_once("../includes/functions.php");?>
<?php 	require_once("../includes/validation_functions.php"); ?>
<?php $selected_category = find_selected_category(); ?>
<?php 
	if (isset($_POST['submit'])) {

		$visible = (int)$_POST["visible"];
		$position = (int)$_POST["position"];
		$rus = mysql_prep($_POST["rus"]);
		$est = mysql_prep($_POST["est"]);
		$id = (int)$selected_category["id"];
		
		$required_fields = array("rus", "est", "visible", "position");
		validate_presences($required_fields);
		
		$fields_with_max_lengths = array("rus" => 80, "est" => 80);
		validate_max_lengths($fields_with_max_lengths);
		
		if (!empty($errors)) {
			$_SESSION["errors"] = $errors;
			redirect_to("edit_category.php?category={$id}");
		}
		
		$query = "UPDATE categories SET ";
		$query .= "rus = '{$rus}', ";
		$query .= "est = '{$est}', ";
		$query .= "position = {$position}, ";
		$query .= "visible = {$visible} ";
		$query .= "WHERE id = {$id} ";
		$query .= "LIMIT 1";
		
		$result = mysqli_query($connection, $query);
		if ($result && mysqli_affected_rows($connection) == 1) {
			$_SESSION["message"] = "Category updated";
			redirect_to("manage_categories.php");
		}
		else {
			$_SESSION["message"] = "Category updating failed";
		}
	}	
?>
<?php	include("../includes/admin_nav_sidebar.php");?>
<?php echo message(); ?>
<?php echo form_errors(); ?>
<h1 class="page-header">Изменить категорию</h1>
<form action="edit_category.php?category=<?php echo $selected_category["id"]; ?>" method="post">
	
	<div class="input-group">
		<label for="rus">Название:</label>
	  <input type="text" class="form-control" placeholder="Введите название на русском" name="rus" value="<?php echo $selected_category["rus"];?>">
	</div>	
	<div class="input-group">
		<label for="est">Название (эст.):</label>
	  <input type="text" class="form-control" placeholder="Введите название на эстонском" name="est" value="<?php echo $selected_category["est"];?>">
	</div>	
	<div class="radio">
	<label class="radio">
	  <input type="radio" name="visible" value="1" <?php if ($selected_category["visible"]) echo "checked"; ?>>Показывается на странице
	</label>
	</div>
	<div class="radio">
	<label class="radio">
	  <input type="radio" name="visible" value="0" <?php if (!$selected_category["visible"]) echo "checked"; ?>>Не показывается на странице
	</label>	
	</div>
      <label for="position">Добавить после:</label>
      <select class="form-control" name="position">
		<?php $result = find_all_categories(); ?>
      	<?php $subject_count = mysqli_num_rows($result); ?>
      	<?php for ($count = 1; $count < ($subject_count+1); $count++) {
      		echo "<option value=\"$count\"";
      		if ($count == $selected_category["visible"]) echo " selected";
      		echo ">{$count}</option>";
		} ?>
      </select>
	<br />
	<button type="submit" class="btn btn-primary btn-md" name="submit">Изменить категорию</button>
</form>

<?php
	mysqli_free_result($result);
?>   

<?php include("../includes/admin_end.php"); ?>