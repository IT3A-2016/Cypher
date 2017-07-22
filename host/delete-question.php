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

  if(isset($_POST['delete_question'])){
    $del="DELETE FROM question WHERE question_id='$question_id'";

  	if(mysqli_query($connection, $del)){
      header('location: questions?id='.$quiz_id);
    }
  }

?>
