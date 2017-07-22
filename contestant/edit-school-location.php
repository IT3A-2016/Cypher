<?php
	session_start();
	include_once '../db.php';

	$contestant_id=$_SESSION['contestant_id'];

	if(!isset($contestant_id)){
		header('location: ../login');
	}

	$result=mysqli_query($connection, "SELECT * FROM contestant WHERE contestant_id='$contestant_id'");
	$row=mysqli_fetch_assoc($result);

	$towncity=mysqli_real_escape_string($connection, $_POST['towncity']);
	$provincestate=mysqli_real_escape_string($connection, $_POST['provincestate']);
	$country=mysqli_real_escape_string($connection, $_POST['country']);

	$up="UPDATE contestant SET contestant_towncity='$towncity', contestant_provincestate='$provincestate', contestant_country='$country' WHERE contestant_id='$contestant_id'";

	mysqli_query($connection, $up);

?>
