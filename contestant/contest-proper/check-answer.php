<?php
	session_start();
	include_once '../../db.php';

	$contestant_id=$_SESSION['contestant_id'];
  $quiz_id=$_GET['id'];

	if(!isset($contestant_id)){
		header('location: ../../login');
	}

	// $result_q=mysqli_query($connection, "SELECT * FROM question WHERE quiz_id='$quiz_id' AND question_state=3 ORDER BY question_id LIMIT 1");
  // $row_q=mysqli_fetch_assoc($result_q);
  //
  // $result_a=mysqli_query($connection, "SELECT * FROM answer WHERE quiz_id='$quiz_id' AND contestant_id='$contestant_id'");
  // $row_a=mysqli_fetch_assoc($result_a);

  $result=mysqli_query($connection, "SELECT * FROM question q JOIN answer a ON q.question_id=a.question_id WHERE q.quiz_id='$quiz_id' AND a.contestant_id='$contestant_id'");
  $row=mysqli_fetch_assoc($result);

	if(($row['q.answer_entry'] == $row['a.answer']) || ($row['q.answer_optional'] == $row['a.answer']) && $row['q.question_state'] == 3){
    echo "Your answer is correct!";
  }
  else if(($row['q.answer_entry'] != $row['a.answer']) || ($row['q.answer_optional'] != $row['a.answer']) && $row['q.question_state'] == 3){
    echo "Sorry, but your answer is wrong.";
  }

?>
