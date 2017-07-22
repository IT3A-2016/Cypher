<?php
	session_start();
	include_once '../../db.php';

	$host_id=$_SESSION['host_id'];
  $quiz_id=$_GET['id'];

	if(!isset($host_id)){
		header('location: ../../login');
	}

	$result=mysqli_query($connection, "SELECT * FROM host WHERE host_id='$host_id'");
	$row=mysqli_fetch_assoc($result);

  // $query_quiz="SELECT * FROM quiz WHERE host_id='$host_id' AND quiz_id=" .$quiz_id;
	// $result_quiz=mysqli_query($connection, $query_quiz);
  // $row_quiz=mysqli_fetch_assoc($result_quiz);

  $quiz_start=date("Y-m-d H:i:s");

  $up="UPDATE quiz SET quiz_start='$quiz_start' WHERE quiz_start='0000-00-00 00:00:00' AND quiz_id='$quiz_id'";

  mysqli_query($connection, $up);

  header('location: start?id='.$quiz_id);

?>
