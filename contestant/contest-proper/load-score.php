<?php
	session_start();
	include_once '../../db.php';

	$contestant_id=$_SESSION['contestant_id'];
  $quiz_id=$_GET['id'];

	if(!isset($contestant_id)){
		header('location: ../../login');
	}

	$result=mysqli_query($connection, "SELECT SUM(score) AS score FROM answer WHERE quiz_id='$quiz_id' AND contestant_id='$contestant_id'");

	$row=mysqli_fetch_assoc($result);

  if($row['score'] > 0){
    echo $row['score'];
  }
	else{
    echo "0";
  }

?>
