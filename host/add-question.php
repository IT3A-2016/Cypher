<?php
  session_start();
  include_once '../db.php';

	$host_id=$_SESSION['host_id'];
  $quiz_id=$_GET['id'];

	if(!isset($host_id)){
		header('location: ../login');
	}

  $result=mysqli_query($connection, "SELECT * FROM host WHERE host_id='$host_id'");
	$row=mysqli_fetch_assoc($result);

  if(isset($_POST['add_question'])){
    $question=mysqli_real_escape_string($connection, $_POST['question']);
    $answer=mysqli_real_escape_string($connection, $_POST['answer']);
    $other_answer=mysqli_real_escape_string($connection, $_POST['other_answer']);
    $quiz_id=mysqli_real_escape_string($connection, $_POST['quiz_id']);

    $points=$_POST['points'];
    $duration=$_POST['duration'];

    $qstate=0; // 0 = not yet used; 1 = used

  	move_uploaded_file($_FILES['file']['tmp_name'], "uploads/" . $_FILES['file']['name']);

  	if($query=mysqli_query($connection, "INSERT INTO question (question_entry, question_image, question_state, answer_entry, answer_optional, points, duration, quiz_id, host_id) VALUES ('".$question."', '".$_FILES['file']['name']."', '".$qstate."', '".$answer."', '".$other_answer."', '".$points."', '".$duration."', '".$quiz_id."', '".$host_id."')")){
      header('location: competition?id='.$quiz_id);
    }
  }

?>
