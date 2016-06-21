<?php 
	define("DB_SERVER", "localhost");
	define("DB_USER", "krizis2_cms");
	define("DB_PASS", "vesna15");
	define("DB_NAME", "krizis");
	$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	if (mysqli_connect_errno()){
		die("Database connection failed: " .
		mysqli_connect_error() .
		" (" . mysqli_connect_errno() . ")"
		);
	}

	mysqli_query($connection, "SET NAMES utf8");
?>