<?php
	session_start();
	include_once '../../db.php';

	$host_id=$_SESSION['host_id'];
  $quiz_id=$_GET['id'];
	$que_id=$_GET['que'];

	if(!isset($host_id)){
		header('location: ../../login');
	}

	$up="UPDATE question SET question_state=2 WHERE question_id='$que_id' AND host_id='$host_id' AND quiz_id='$quiz_id' AND question_state=1 ORDER BY question_id LIMIT 1";

	mysqli_query($connection, $up);

?>
