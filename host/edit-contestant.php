<?php
	session_start();
	include_once '../db.php';

  $host_id=$_SESSION['host_id'];
  $contestant_id=$_GET['cid'];
  $quiz_id=$_POST['quiz_id'];

	if(!isset($host_id)){
		header('location: ../login');
	}

	$result=mysqli_query($connection, "SELECT * FROM host WHERE host_id='$host_id'");
	$row=mysqli_fetch_assoc($result);

  $school=mysqli_real_escape_string($connection, $_POST['school']);

  $up="UPDATE contestant SET contestant_school='$school' WHERE contestant_id='$contestant_id'";

	mysqli_query($connection, $up);

?>
