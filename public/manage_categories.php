<?php	require_once("../includes/session.php");?>
<?php	require_once("../includes/db_connection.php");?>
<?php	require_once("../includes/functions.php");?>
<?php 	require_once("../includes/validation_functions.php"); ?>
<?php	include("../includes/admin_nav_sidebar.php");?>

<?php 		
	$query = "SELECT * from categories ";
	$query .= "ORDER BY id ASC";
	$result = mysqli_query($connection, $query);
	confirm_query($result);
?>

<?php echo message(); ?>
<?php echo form_errors(); ?>
<h1 class="page-header">Управление категориями</h1>


          <h2 class="sub-header">Все категории</h2>
		  <div class="btn-group">
		    <a href="add_category.php" class="btn btn-primary" role="button">Добавить</a>
		  </div>          
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Название</th>
                  <th>Название (эст.)</th>
                  <th>Показывается на странице</th>
                  <th>Позиция</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
              	
          	<?php
          	while($row = mysqli_fetch_assoc($result)) {		?>
	            <tr>
	            	<td><?php $row["id"];?></td>
	            	<td><?php echo htmlentities($row["rus"]);?></td>
	            	<td><?php echo htmlentities($row["est"]);?></td>
	            	<td><?php echo $row["visible"];?></td>
	            	<td><?php echo $row["position"];?></td>
	            	<td>
					  <div class="btn-group">
					    <a href="edit_category.php?category=<?php echo urlencode($row["id"]);?>" class="btn btn-primary" role="button">Изменить</a>
					    <a href="delete_category.php?category=<?php echo urlencode($row["id"]);?>" class="btn btn-primary" role="button">Удалить</a>
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