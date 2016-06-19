<?php 
	$dbhost = "localhost";
	$dbuser = "krizis2_cms";
	$dbpass = "vesna15";
	$dbname = "krizis";
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

	if (mysqli_connect_errno()){
		die("Database connection failed: " .
		mysqli_connect_error() .
		" (" . mysqli_connect_errno() . ")"
		);
	}

	mysqli_query($connection, "SET NAMES utf8");
?>

<?php 
	$query = "SELECT * from categories";
	$result = mysqli_query($connection, $query);
	if (!$result) {
		die("Database query failed!");
	}
	$categories = array();
	while($row = mysqli_fetch_assoc($result)) {
		$categories[$row["id"]] = $row["title_rus"];
	}	
	mysqli_free_result($result);
?>

<?php 
	$query = "SELECT * from shops";
	$result = mysqli_query($connection, $query);
	if (!$result) {
		die("Database query failed!");
	}
	$shops = array();
	while($row = mysqli_fetch_assoc($result)) {
		$shops[$row["id"]] = $row["name"];
	}	
	mysqli_free_result($result);
?>

<?php 
	$query = "SELECT * from products";
	$result = mysqli_query($connection, $query);
	if (!$result) {
		die("Database query failed!");
	}
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
    <link rel="icon"  href="http://example.com/favicon.png">

    <title>Сад Скидок</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/viewport-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/layout3-bootstrap.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

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
					<li><a href="#est">Est</a></li>
					<li class="active"><a href="#rus">Rus</a></li>
				</ul>

			<form class="navbar-form navbar-right">
			<div class="btn-group" data-toggle="buttons">
	         <?php foreach ($shops as $shop) {?>
            <label class="btn btn-primary active">
            	<input type="checkbox" autocomplete="off"><?php echo htmlentities($shop);?>
            </label>	
            <?php }?>				
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
          	
          	<?php
          	
          	while($row = mysqli_fetch_assoc($result)) {		?>
			
            <div class="col-xs-6 col-lg-4">
              <h3><?php echo htmlentities($row["title_rus"]);?></h3>
              <img src=<?php echo htmlentities($row["image"]);?> width="80%"/>
				<div class="wrapper">
					<div class="old-price">
					  <h3><?php echo htmlentities($row["old_price"]);?></h4>
					</div>
					<div class="new-price">
						<p>Цена</p>
					  <h3><?php echo htmlentities($row["new_price"]);?></h3>
					</div>
					  <div class="expires">
						<p>До</p>
						<h3><?php echo htmlentities($row["expires"]);?></h3>
					  </div>	
					  <p class="shop">(<?php echo htmlentities($shops[$row["shop_id"]]);?>)</p>		
				</div>              
             </div><!--/.col-xs-6.col-lg-4-->
             <?php 
             }
   			?>
          </div><!--/row-->
        </div><!--/.col-xs-12.col-sm-9-->

        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
          <div class="list-group">
	         <?php foreach ($categories as $category) {?>
            <a href="#" class="list-group-item"><?php echo htmlentities($category);?></a>
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
