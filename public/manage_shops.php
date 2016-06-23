<?php	require_once("../includes/session.php");?>
<?php	require_once("../includes/db_connection.php");?>
<?php	require_once("../includes/functions.php");?>
<?php confirm_logged_in();?> ?>
<?php 	require_once("../includes/validation_functions.php"); ?>
<?php	include("../includes/admin_nav_sidebar.php");?>

<?php 		
	$query = "SELECT * from shops ";
	$query .= "ORDER BY position ASC";
	$result = mysqli_query($connection, $query);
	confirm_query($result);
?>

<?php echo message(); ?>
<?php echo form_errors(); ?>
<h1 class="page-header">Управление магазинами</h1>


          <h2 class="sub-header">Магазины</h2>
		  <div class="btn-group">
		    <a href="add_shop.php" class="btn btn-primary" role="button">Добавить</a>
		  </div>          
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Название</th>
                  <th>Показывается на странице</th>
                  <th>Позиция</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
              	
          	<?php
          	while($row = mysqli_fetch_assoc($result)) {		?>
	            <tr>
	            	<td><?php echo $row["id"];?></td>
	            	<td><?php echo htmlentities($row["name"]);?></td>
	            	<td><?php echo $row["visible"];?></td>
	            	<td><?php echo $row["position"];?></td>
	            	<td>
					  <div class="btn-group">
					    <a href="edit_shop.php?shop=<?php echo urlencode($row["id"]);?>" class="btn btn-primary" role="button">Изменить</a>
					    <a href="delete_shop.php?shop=<?php echo urlencode($row["id"]);?>" class="btn btn-primary" role="button">Удалить</a>
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