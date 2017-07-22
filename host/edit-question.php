<?php
	session_start();
	include_once '../db.php';

  $host_id=$_SESSION['host_id'];
  $question_id=$_GET['qid'];
  $quiz_id=$_POST['quiz_id'];

	if(!isset($host_id)){
		header('location: ../login');
	}

	$result=mysqli_query($connection, "SELECT * FROM host WHERE host_id='$host_id'");
	$row=mysqli_fetch_assoc($result);

  $question=mysqli_real_escape_string($connection, $_POST['question']);
  $answer=mysqli_real_escape_string($connection, $_POST['answer']);
  $optional=mysqli_real_escape_string($connection, $_POST['optional']);
  $points=mysqli_real_escape_string($connection, $_POST['points']);
  $duration=mysqli_real_escape_string($connection, $_POST['duration']);

  $up="UPDATE question SET question_entry='$question', answer_entry='$answer', answer_optional='$optional', points='$points', duration='$duration' WHERE question_id='$question_id'";

	mysqli_query($connection, $up);

?>
