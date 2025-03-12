<?php
    session_start();
	$dbuser = 'mysql';
	$dbpass = 'mysql';
	$dbserver = 'localhost';
	$dbname = 'book';
	$mysql = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) 
    or die ('Ошибка ' . mysqli_error($mysql));
    unset($_SESSION['logged_user']);
    header('Location: index.php');
    mysqli_close($mysql);
?>