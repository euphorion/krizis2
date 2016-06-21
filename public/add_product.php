<?php	require_once("../includes/session.php");?>
<?php	require_once("../includes/db_connection.php");?>
<?php	require_once("../includes/functions.php");?>
<?php 	require_once("../includes/validation_functions.php"); ?>
<?php 
	if (isset($_POST['submit'])) {

		$visible = (int)$_POST["visible"];
		$rus = mysql_prep($_POST["rus"]);
		$est = mysql_prep($_POST["est"]);
		$new_price = (float)($_POST["new_price"]);
		$old_price = (float)($_POST["old_price"]);
		$expires = (float)($_POST["expires"]);
		$shop_id = (int)($_POST["shop_id"]);
		$category_id = (int)($_POST["category_id"]);
		$visible = (int)($_POST["visible"]);
		$image = mysql_prep($_POST["image"]);
		
		$required_fields = array("rus", "est", "visible", "new_price", "expires", "shop_id", "category_id", "image");
		validate_presences($required_fields);
		
		$fields_with_max_lengths = array("rus" => 80, "est" => 80, "image" => 256);
		validate_max_lengths($fields_with_max_lengths);
		
		if (!empty($errors)) {
			$_SESSION["errors"] = $errors;
			redirect_to("add_product.php");
		}
		
		$query = "INSERT INTO products ";
		$query .= "(rus, est, visible, new_price, old_price, expires, shop_id, category_id, image) ";
		$query .= "VALUES ";
		$query .= "('{$rus}', '{$est}', {$visible}, {$new_price}, {$old_price}, {$expires}, {$shop_id}, {$category_id}, '{$image}')";
		$result = mysqli_query($connection, $query);
		if ($result) {
			$_SESSION["message"] = "Product created";
			redirect_to("manage_products.php");
		}
		else {
			$_SESSION["message"] = "Products creating failed";
			$_SESSION["message"] .= "br/" . $query;
		}
	}	
?>
<?php	include("../includes/admin_nav_sidebar.php");?>
<?php echo message(); ?>
<?php echo form_errors(); ?>
<h1 class="page-header">Добавить новый продукт</h1>
<form action="add_product.php" method="post">
	
	<div class="input-group">
		<label for="rus">Название:</label>
	  <input type="text" class="form-control" placeholder="Введите название на русском" name="rus">
	</div>	
	<div class="input-group">
		<label for="est">Название (эст.):</label>
	  <input type="text" class="form-control" placeholder="Введите название на эстонском" name="est">
	</div>
	<div class="input-group">
		<label for="new_price">Новая цена:</label>
	  <input type="text" class="form-control" placeholder="Введите новую цену" name="new_price">
	</div>
	<div class="input-group">
		<label for="old_price">Старая цена:</label>
	  <input type="text" class="form-control" placeholder="Введите старую цену" name="old_price">
	</div>
	<div class="input-group">
		<label for="expires">Действительно до:</label>
	  <input type="text" class="form-control" placeholder="Действительно до:" name="expires">
	</div>
	
	<div class="input-group">
		<label for="image">Изображение:</label>
	  <input type="text" class="form-control" placeholder="Введите расположение файла:" name="image">
	</div>
					
      <label for="category_id">Категория:</label>
      <select class="form-control" name="category_id">
		<?php $result = find_all_categories(); ?>
		<?php while($row = mysqli_fetch_assoc($result)) {
      		echo "<option value=\"" . $row["id"] . "\">" . $row["rus"] . "</option>";
		} 
		mysqli_free_result($result);
		?>
      </select>
      
      <label for="shop_id">Магазин:</label>
      <select class="form-control" name="shop_id">
		<?php $result = find_all_shops(); ?>
		<?php while($row = mysqli_fetch_assoc($result)) {
      		echo "<option value=\"" . $row["id"] . "\">" . $row["name"] . "</option>";
		} 
		mysqli_free_result($result);
		?>
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
	<button type="submit" class="btn btn-primary btn-md" name="submit">Создать продукт</button>
</form>

<?php include("../includes/admin_end.php"); ?>+