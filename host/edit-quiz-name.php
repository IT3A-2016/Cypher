<?php
	session_start();
	include_once '../db.php';

	$host_id=$_SESSION['host_id'];

	if(!isset($host_id)){
		header('location: ../login');
	}

	$result=mysqli_query($connection, "SELECT * FROM host WHERE host_id='$host_id'");
	$row=mysqli_fetch_assoc($result);

	$quiz_name=mysqli_real_escape_string($connection, $_POST['quiz_name']);
  $quiz_id=$_POST['quiz_id'];

	$up="UPDATE quiz SET quiz_name='$quiz_name' WHERE quiz_id='$quiz_id' AND host_id='$host_id'";

	mysqli_query($connection, $up);

?>
