<?php
	session_start();
	include_once '../../db.php';

	$contestant_id=$_SESSION['contestant_id'];
  $quiz_id=$_GET['id'];
  $answer=mysqli_real_escape_string($connection, $_POST['answer']);

	if(!isset($contestant_id)){
		header('location: ../../login');
	}

	$result=mysqli_query($connection, "SELECT * FROM question WHERE quiz_id='$quiz_id' AND question_state=1 ORDER BY question_id LIMIT 1");

  $row=mysqli_fetch_assoc($result);

  $question_id=$row['question_id'];
  $points=$row['points'];

	if(strcasecmp($answer, $row['answer_entry'])==0 || strcasecmp($answer, $row['answer_optional'])==0){
    mysqli_query($connection, "INSERT INTO answer (answer, score, question_id, contestant_id, quiz_id) VALUES ('".$answer."', '".$points."', '".$question_id."', '".$contestant_id."', '".$quiz_id."')");
  }
  else{
    mysqli_query($connection, "INSERT INTO answer (answer, score, question_id, contestant_id, quiz_id) VALUES ('".$answer."', '0', '".$question_id."', '".$contestant_id."', '".$quiz_id."')");
  }

?>
