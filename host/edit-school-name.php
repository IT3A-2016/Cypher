<?php
	session_start();
	include_once '../db.php';

	$host_id=$_SESSION['host_id'];

	if(!isset($host_id)){
		header('location: ../login');
	}

	$result=mysqli_query($connection, "SELECT * FROM host WHERE host_id='$host_id'");
	$row=mysqli_fetch_assoc($result);

	$school=mysqli_real_escape_string($connection, $_POST['school']);
	$school_acronym=mysqli_real_escape_string($connection, $_POST['school_acronym']);

	$up="UPDATE host SET host_school='$school', host_school_acronym='$school_acronym' WHERE host_id='$host_id'";

	mysqli_query($connection, $up);

?>
