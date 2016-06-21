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
	$title_rus = "Персики";
	$title_est = "Virsikud";
	$new_price = 2.49;
	$old_price = 3.99;
	$expires = 05.09;
	$image = "images/product2.jpg";
	$visible = 1;
	$category_id = 3; 
	$shop_id = 2;
	$id = 2;
	
	$query = "UPDATE products SET ";
	$query .= "title_rus = '{$title_rus}', ";
	$query .= "title_est = '{$title_est}', ";
	$query .= "image = '{$image}', ";
	$query .= "new_price = {$new_price}, ";
	$query .= "old_price = {$old_price}, ";
	$query .= "expires = {$expires}, ";
	$query .= "visible = {$visible}, ";
	$query .= "category_id = {$category_id}, ";
	$query .= "shop_id = {$shop_id} ";
	$query .= "WHERE id = {$id}";
	echo $query . "</br>";
	$result = mysqli_query($connection, $query);
	if ($result && mysqli_affected_rows($connection)==1) {
		//redirect(somepage.php);	
		echo "Success!";
	}
	else {
		//$message = "Database query failed";
		die("Database query failed! " . mysqli_errno($connection));
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
