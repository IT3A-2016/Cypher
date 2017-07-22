<?php
	session_start();
	include_once '../db.php';

	$host_id=$_SESSION['host_id'];

	if(!isset($host_id)){
		header('location: ../login');
	}

	$result=mysqli_query($connection, "SELECT * FROM host WHERE host_id='$host_id'");
	$row=mysqli_fetch_assoc($result);

	$towncity=mysqli_real_escape_string($connection, $_POST['towncity']);
	$provincestate=mysqli_real_escape_string($connection, $_POST['provincestate']);
	$country=mysqli_real_escape_string($connection, $_POST['country']);

	$up="UPDATE host SET host_towncity='$towncity', host_provincestate='$provincestate', host_country='$country' WHERE host_id='$host_id'";

	mysqli_query($connection, $up);

?>
