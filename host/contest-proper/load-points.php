<?php
	session_start();
	include_once '../../db.php';

	$host_id=$_SESSION['host_id'];
  $quiz_id=$_GET['id'];
	$que_id=$_GET['que'];

	if(!isset($host_id)){
		header('location: ../../login');
	}

	$result=mysqli_query($connection, "SELECT * FROM question WHERE question_id='$que_id' AND host_id='$host_id' AND quiz_id='$quiz_id' ORDER BY question_id LIMIT 1");

	$row=mysqli_fetch_assoc($result);

	echo $row['points'];

?>
