<?php
	session_start();
	include_once '../db.php';

	$host_id=$_SESSION['host_id'];

	if(!isset($host_id)){
		header('location: ../login');
	}

	$result=mysqli_query($connection, "SELECT * FROM host WHERE host_id='$host_id'");
	$row=mysqli_fetch_assoc($result);

	$username=mysqli_real_escape_string($connection, $_POST['username']);
  $password=mysqli_real_escape_string($connection, $_POST['password']);
	$school=mysqli_real_escape_string($connection, $_POST['school']);
  $quiz_id=mysqli_real_escape_string($connection, $_POST['quiz_id']);

	$password=stripslashes($password);

	$contestant_regdate=date("Y-m-d H:i:s");

	$query=mysqli_query($connection, "INSERT INTO contestant (contestant_username, contestant_pw, contestant_school, contestant_regdate, quiz_id, host_id) VALUES ('".$username."', '".sha1($password)."', '".$school."', '".$contestant_regdate."', '".$quiz_id."', '".$host_id."')");

?>
