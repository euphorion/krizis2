<?php	require_once("../includes/session.php");?>
<?php	require_once("../includes/db_connection.php");?>
<?php	require_once("../includes/functions.php");?>
<?php confirm_logged_in();?> ?>
<?php 	require_once("../includes/validation_functions.php"); ?>
<?php $selected_product = find_selected_product(); ?>
<?php 
	if (isset($_POST['submit'])) {

		$id = (int)$selected_product["id"];
		$rus = mysql_prep($_POST["rus"]);
		$est = mysql_prep($_POST["est"]);
		$new_price = (float)$_POST["new_price"];
		$old_price = (float)$_POST["old_price"];
		$expires = (float)$_POST["expires"];
		$shop_id = (int)$_POST["shop_id"];
		$category_id = (int)$_POST["category_id"];
		$image = mysql_prep($_POST["image"]);
		$visible = (int)$_POST["visible"];
		
		$required_fields = array("rus", "est", "visible", "new_price", "expires", "shop_id", "category_id", "image");
		validate_presences($required_fields);
		
		$fields_with_max_lengths = array("rus" => 80, "est" => 80, "image" => 256);
		validate_max_lengths($fields_with_max_lengths);
		
		if (!empty($errors)) {
			$_SESSION["errors"] = $errors;
			redirect_to("edit_product.php?product={$id}");
		}
		
		$query = "UPDATE products SET ";
		$query .= "rus = '{$rus}', ";
		$query .= "est = '{$est}', ";
		$query .= "image = '{$image}', ";
		$query .= "new_price = {$new_price}, ";
		$query .= "old_price = {$old_price}, ";
		$query .= "expires = {$expires}, ";
		$query .= "category_id = {$category_id}, ";
		$query .= "shop_id = {$shop_id}, ";
		$query .= "visible = {$visible} ";
		$query .= "WHERE id = {$id} ";
		$query .= "LIMIT 1";
		
		$result = mysqli_query($connection, $query);
		if ($result && mysqli_affected_rows($connection) == 1) {
			$_SESSION["message"] = "Product updated";
			redirect_to("manage_products.php");
		}
		else {
			$_SESSION["message"] = "Product updating failed";
		}
	}	
?>
<?php	include("../includes/admin_nav_sidebar.php");?>
<?php echo message(); ?>
<?php echo form_errors(); ?>
<h1 class="page-header">Изменить продукт</h1>
<form action="edit_product.php?product=<?php echo $selected_product["id"]; ?>" method="post">
	
	<div class="input-group">
		<label for="rus">Название:</label>
	  <input type="text" class="form-control" placeholder="Введите название на русском" name="rus" value="<?php echo $selected_product["rus"];?>">
	</div>	
	<div class="input-group">
		<label for="est">Название (эст.):</label>
	  <input type="text" class="form-control" placeholder="Введите название на эстонском" name="est" value="<?php echo $selected_product["est"];?>">
	</div>
	<div class="input-group">
		<label for="new_price">Новая цена:</label>
	  <input type="text" class="form-control" placeholder="Введите новую цену" name="new_price" value="<?php echo $selected_product["new_price"];?>">
	</div>
	<div class="input-group">
		<label for="old_price">Старая цена:</label>
	  <input type="text" class="form-control" placeholder="Введите старую цену" name="old_price" value="<?php echo $selected_product["old_price"];?>">
	</div>
	<div class="input-group">
		<label for="expires">Действительно до:</label>
	  <input type="text" class="form-control" placeholder="Действительно до:" name="expires" value="<?php echo $selected_product["expires"];?>">
	</div>
	
	<div class="input-group">
		<label for="image">Изображение:</label>
	  <input type="text" class="form-control" placeholder="Введите расположение файла:" name="image" value="<?php echo $selected_product["image"];?>">
	</div>
	
      <label for="category_id">Категория:</label>
      <select class="form-control" name="category_id">
		<?php $result = find_all_categories(); ?>
		<?php while($row = mysqli_fetch_assoc($result)) {
      		echo "<option value=\"" . $row['id'] . "\"";
      		if ($row['id'] == $selected_product['category_id']) echo " selected";
      		echo ">" . $row['rus'] . "</option>";
		} ?>
      </select>
      
      
      <label for="shop_id">Магазин:</label>
      <select class="form-control" name="shop_id">
		<?php $result = find_all_shops(); ?>
		<?php while($row = mysqli_fetch_assoc($result)) {
      		echo "<option value=\"" . $row['id'] . "\"";
      		if ($row['id'] == $selected_product["shop_id"]) echo " selected";
      		echo ">" . $row['name']  . "</option>";
		} ?>
      </select>
 
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
	      
	<br />
	<button type="submit" class="btn btn-primary btn-md" name="submit">Изменить продукт</button>
</form>

<?php
	mysqli_free_result($result);
?>   

<?php include("../includes/admin_end.php"); ?>