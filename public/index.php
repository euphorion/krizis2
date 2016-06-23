<?php	require_once("../includes/defaults.php");?>
<?php	require_once("../includes/db_connection.php");?>
<?php	require_once("../includes/functions.php");?>
<?php session_start();?>
<?php 
	if (isset($_GET["category"])) {
		$_SESSION["category"] = $_GET["category"];
	}
	else if (isset($_SESSION["category"])) {
		
	}
	else {
		$_SESSION["category"] = CATEGORY_ALL;
	}
?>
<?php
	if (isset($_GET["lang"])) {
		$_SESSION["lang"] = $_GET["lang"];
	}
	else if(isset($_SESSION["lang"])) {

	} else {
		$_SESSION["lang"] = "rus";
	}
?>
<?php
	if (isset($_GET["Selver"])) {
		$_SESSION["Selver"] = $_GET["Selver"];
	}
	else if (isset($_SESSION["Selver"])) {
		
	}
	else {
		$_SESSION["Selver"] = 1;
	}
?>
<?php
	if (isset($_GET["Prisma"])) {
		$_SESSION["Prisma"] = $_GET["Prisma"];
	}
	else if (isset($_SESSION["Prisma"])) {
		
	}
	else {
		$_SESSION["Prisma"] = 1;
	}
?>
<?php
	if (isset($_GET["Maxima"])) {
		$_SESSION["Maxima"] = $_GET["Maxima"];
	}
	else if (isset($_SESSION["Maxima"])) {
		
	}
	else {
		$_SESSION["Maxima"] = 1;
	}
?>
<?php $categories = find_visible_categories(); ?>

<?php 
	$result = find_all_products();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon"  href="images/favicon.png">

    <title>Сад Скидок</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/viewport-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/layout3-bootstrap.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
  	<div class="navbar navbar-default navbar-fixed-top">
  		<div class="container">
  			<div class="navbar-header">
  				<button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
  					<span class="sr-only">Toggle navigation</span>
  					<span class="icon-bar"></span>
  					<span class="icon-bar"></span>
  					<span class="icon-bar"></span>
  				</button>
  				<a href="#" class="navbar-brand">Сад Cкидок</a>
  			</div>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li <?php if($_SESSION['lang'] == 'est'){ echo "class=\"active\"";}?>><a href="index.php?lang=est">Est</a></li>
					<li <?php if($_SESSION['lang'] == 'rus'){ echo "class=\"active\"";}?>><a href="index.php?lang=rus">Rus</a></li>
				</ul>

			<form class="navbar-form navbar-right">
			<div class="btn-group" data-toggle="buttons">         
            <label class="btn btn-primary <?php if ($_SESSION["Selver"]) { echo "active"; }?>">
            	<input type="checkbox" autocomplete="off">Selver
            </label>	
            <label class="btn btn-primary <?php if ($_SESSION["Prisma"]) { echo "active"; }?>">
            	<input type="checkbox" autocomplete="off">Prisma
            </label>
            <label class="btn btn-primary <?php if ($_SESSION["Maxima"]) { echo "active"; }?>">
            	<input type="checkbox" autocomplete="off">Maxima
            </label>                        
			</div>			
			<div class="input-group">
		  		<input type="search" placeholder="Поиск" class="form-control" />
		  		<span class="glyphicon glyphicon-search input-group-addon btn-success btn"></span>
		  	</div>
		  </form>				
			</div>
		  </div>
  	</div>

    <div class="container">

      <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-12 col-sm-9">
          <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Включить навигацию</button>
          </p>
          <div class="jumbotron">
 			<img src="images/hello-bootstrap.png" width="100%">
          </div>
          <div class="row">
          	

		         	
          	<?php while($row = mysqli_fetch_assoc($result)) {		?>
			
            <div class="col-xs-6 col-lg-4">
              <h3><?php echo htmlentities($row[$_SESSION["lang"]]);?></h3>
              <img src=<?php echo htmlentities($row["image"]);?> width="80%"/>
				<div class="wrapper">
					<div class="old-price">
					  <h3><?php echo htmlentities($row["old_price"]);?></h3>
					</div>
					<div class="new-price">
						<p>Цена</p>
					  <h3><?php echo htmlentities($row["new_price"]);?></h3>
					</div>
					  <div class="expires">
						<p>До</p>
						<h3><?php echo htmlentities($row["expires"]);?></h3>
					  </div>	
		          	<?php
						$query = "SELECT * from shops";
						$query .= " WHERE id=" . $row["shop_id"];
						$query .= " LIMIT 1";
						$shops = mysqli_query($connection, $query);
						confirm_query($shops);		
						$shop = mysqli_fetch_assoc($shops); ?>			  
					  	<p class="shop">(<?php echo htmlentities($shop["name"]);?>)</p>		
				</div>              
             </div><!--/.col-xs-6.col-lg-4-->
             <?php 
             }
   			?>
          </div><!--/row-->
        </div><!--/.col-xs-12.col-sm-9-->

        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
          <div class="list-group">
           	<a href="index.php?category=<?php echo CATEGORY_ALL; ?>" class="list-group-item <?php if(CATEGORY_ALL == $_SESSION["category"]){ echo "active ";}?>">
           		<?php switch($_SESSION['lang']){
           			case "rus": echo "Все категории"; break; 
           			case "est": echo "Kõik kategooriad"; break; 
				}?></a>
           	
	         <?php foreach ($categories as $category_id => $category_name) {?>
            <a href="index.php?category=<?php echo urlencode($category_id);?>" class="list-group-item <?php if($category_id == $_SESSION["category"]){ echo "active ";}?>"><?php echo htmlentities($category_name);?></a>
            <?php }?>
          </div>
        </div><!--/.sidebar-offcanvas-->
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; 2016 The Crazy Group</p>
      </footer>

    </div><!--/.container-->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="bootstrap/js/viewport-bug-workaround.js"></script>
    <script src="bootstrap/js/offcanvas.js"></script>
    
<?php
	mysqli_free_result($result);
?> 
  </body>
</html>

<?php
	mysqli_close($connection);
?>
