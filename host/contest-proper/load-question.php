<?php
	session_start();
	include_once '../../db.php';

	$host_id=$_SESSION['host_id'];
  $quiz_id=$_GET['id'];
	$que_id=$_GET['que'];

	if(!isset($host_id)){
		header('location: ../../login');
	}

  $query="SELECT * FROM question WHERE question_id='$que_id' AND host_id='$host_id' AND quiz_id='$quiz_id' AND question_state=0 ORDER BY question_id LIMIT 1";

	$result=mysqli_query($connection, $query);
	$row=mysqli_fetch_assoc($result);

	echo $row['question_entry'];

	$up="UPDATE question SET question_state=1 WHERE question_id='$que_id' AND host_id='$host_id' AND quiz_id='$quiz_id' AND question_state=0 ORDER BY question_id LIMIT 1";

	mysqli_query($connection, $up);

?>
