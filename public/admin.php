<?php	require_once("../includes/session.php");?>
<?php	require_once("../includes/functions.php");?>
<?php confirm_logged_in();?> ?>
<?php	require_once("../includes/db_connection.php");?>

<?php	include("../includes/admin_nav_sidebar.php");?>

<?php 
	$result = find_all_shops(false);
?>

          <h1 class="page-header">Dashboard</h1>

          <div class="row placeholders">
          		         <?php while ($shop = mysqli_fetch_assoc($result)) {?>
            <div class="col-xs-6 col-sm-3 placeholder">
              <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
              <h4><?php echo "{$shop["name"]}";?></h4>
			  <a href="import_products.php?shop=<?php echo $shop["name"]; ?>" class="btn btn-primary" role="button">Импортировать</a>
            </div>
            <?php }?>	
      </div>
<?php
	mysqli_free_result($result);
?>
          <h2 class="sub-header">Все продукты</h2>
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
                </tr>
              </thead>
              <tbody>
 <?php 
	$query = "SELECT * from products";
	$result = mysqli_query($connection, $query);
	confirm_query($result);
?>             	
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

                </tr>
            <?php } ?>
<?php
	mysqli_free_result($result);
?>             
              </tbody>
            </table>
          </div>

<?php include("../includes/admin_end.php"); ?>
