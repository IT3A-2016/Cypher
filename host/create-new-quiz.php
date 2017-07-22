<?php
	session_start();
	include_once '../db.php';

	$host_id=$_SESSION['host_id'];

	if(!isset($host_id)){
		header('location: ../login');
	}

	$result=mysqli_query($connection, "SELECT * FROM host WHERE host_id='$host_id'");
	$row=mysqli_fetch_assoc($result);

  $quiz_name=mysqli_real_escape_string($connection, $_POST['quiz_name']);
	$quiz_code=quizCode();
  $quiz_creation=date("Y-m-d H:i:s");

  mysqli_query($connection, "INSERT INTO quiz (quiz_name, quiz_code, quiz_creation, host_id) VALUES ('".$quiz_name."', '".$quiz_code."', '".$quiz_creation."', '".$host_id."')");

  function quizCode($length=7){
    $char='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $char_length=strlen($char);
    $random_string='';
    for($i=0;$i<$length;$i++) {
      $random_string.=$char[rand(0, $char_length-1)];
    }
    return $random_string;
  }
?>
