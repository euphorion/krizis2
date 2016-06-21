<?php	require_once("../includes/session.php");?>
<?php	require_once("../includes/db_connection.php");?>
<?php	require_once("../includes/functions.php");?>
<?php 	require_once("../includes/validation_functions.php"); ?>
<?php	include("../includes/admin_nav_sidebar.php");?>

<?php 		
	$query = "SELECT * from products ";
	$query .= "ORDER BY id ASC";
	$result = mysqli_query($connection, $query);
	confirm_query($result);
?>

<?php echo message(); ?>
<?php echo form_errors(); ?>
<h1 class="page-header">Управление продуктами</h1>


          <h2 class="sub-header">Все продукты</h2>
		  <div class="btn-group">
		    <a href="add_product.php" class="btn btn-primary" role="button">Добавить</a>
		  </div>          
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Название</th>
                  <th>Название (эст.)</th>
                  <th>Новая цена</th>
                  <th>Старая цена</th>
                  <th>Действительно до</th>
                  <th>Магазин</th>
                  <th>Изображение</th>
                  <th>Категория</th>
                  <th>Показывается на странице</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
              	
          	<?php
          	while($row = mysqli_fetch_assoc($result)) {		?>
	            <tr>
	            	<td><?php echo $row["id"];?></td>
	            	<td><?php echo $row["rus"];?></td>
	            	<td><?php echo $row["est"];?></td>
	            	<td><?php echo $row["new_price"];?></td>
	            	<td><?php echo $row["old_price"];?></td>
	            	<td><?php echo $row["expires"];?></td>
	            	<td><?php echo $row["shop_id"];?></td>
	            	<td><?php echo $row["image"];?></td>
	            	<td><?php echo $row["category_id"];?></td>
	            	<td><?php echo $row["visible"];?></td>
	            	<td>
					  <div class="btn-group">
					    <a href="edit_product.php?product=<?php echo urlencode($row["id"]);?>" class="btn btn-primary" role="button">Изменить</a>
					    <a href="delete_product.php?product=<?php echo urlencode($row["id"]);?>" class="btn btn-primary" role="button">Удалить</a>
					  </div>	            		
	            	</td>

                </tr>
            <?php } ?>
<?php
	mysqli_free_result($result);
?>             
              </tbody>
            </table>
            
          </div>


<?php include("../includes/admin_end.php"); ?>