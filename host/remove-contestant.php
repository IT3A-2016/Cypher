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

  if(isset($_POST['remove_contestant'])){
    $del="DELETE FROM contestant WHERE contestant_id='$contestant_id'";

  	if(mysqli_query($connection, $del)){
      header('location: contestants?id='.$quiz_id);
    }
  }

?>
