<?php
	session_start();
	include_once '../../db.php';

	$contestant_id=$_SESSION['contestant_id'];
  $quiz_id=$_GET['id'];

	if(!isset($contestant_id)){
		header('location: ../../login');
	}

	$result=mysqli_query($connection, "SELECT * FROM question WHERE quiz_id='$quiz_id' AND question_state=1 ORDER BY question_id LIMIT 1");

	$row=mysqli_fetch_assoc($result);

	echo $row['points'];

?>
