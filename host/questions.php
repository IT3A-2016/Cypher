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

  $query_quiz="SELECT * FROM quiz WHERE host_id='$host_id' AND quiz_id=" .$quiz_id;
	$result_quiz=mysqli_query($connection, $query_quiz);
  $row_quiz=mysqli_fetch_assoc($result_quiz);

  $query_que="SELECT * FROM question WHERE host_id='$host_id' AND quiz_id=" .$quiz_id;
  $result_que=mysqli_query($connection, $query_que);

	$count_que=mysqli_query($connection, "SELECT COUNT(*) as qcount FROM question WHERE host_id='$host_id' AND quiz_id=" .$quiz_id);
	$row_count_que=mysqli_fetch_assoc($count_que);

?>

<!DOCTYPE html>
<html>
<head>
  <title>Questions &mdash; InterQuiz</title>
  <link rel="stylesheet" type="text/css" href="../css/dashboard.css" />
  <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css" />
	<script src="../js/jquery-3.1.1.js" type="text/javascript"></script>
	<script src="../js/host.js" type="text/javascript"></script>
</head>
<body class="row">
	<!-- Side nav -->
	<div class="nav_dash col">
		<div class="heading">
			<div class="logo">
	      <img src="../images/interquiz-logo-design.png" style="width:100%"/>
	    </div>
		</div>
		<div class="menu_side">
			<a class="link_sel" href="./"><i class="fa fa-paper-plane fa-fw fa-lg" aria-hidden="true"></i>OVERVIEW</a>
			<a href="competitions"><i class="fa fa-pencil-square-o fa-fw fa-lg" aria-hidden="true"></i>COMPETITION</a>
			<a href="settings"><i class="fa fa-cog fa-fw fa-lg" aria-hidden="true"></i>SETTINGS</a>
		</div>
		<span flex></span>
		<div class="footer">
			<a href="../logout"><i class="fa fa-sign-out fa-fw fa-lg" aria-hidden="true"></i>LOG OUT</a>
		</div>
	</div>
	<!-- Main content -->
	<div class="main col">
		<div class="heading">
			<span class="head_title"><a href="competitions">COMPETITION</a> > <a href="competition?id=<?php echo $quiz_id; ?>"><?php echo $row_quiz['quiz_name']; ?></a> > Questions</span>
			<span flex></span>
			<span class="head_sub"><i class="fa fa-user fa-fw" aria-hidden="true"></i><?php echo $row['host_username']; ?></span>
		</div>

		<div id="content_dash" class="content">
      <div class="section section_full">
        <div class="head_sec">
          <p><?php echo $row_count_que['qcount']; ?> QUESTIONNAIRE/S</p>
        </div>
        <div class="body_sec">
          <?php
            echo "<table id='question_tbl' class='designed_tbl'>
              <thead>
                <tr>
									<th>Question</th>
                  <th>Image</th>
                  <th>Answer</th>
                  <th>Other Possible Answer</th>
                  <th>Points</th>
                  <th>Time Duration</th>
                  <th>Actions</th>
                </tr>
              </thead>";
              while($row_que=mysqli_fetch_assoc($result_que)){
                echo "<tr id='qrow".$row_que['question_id']."'>
                  <td id='qentry".$row_que['question_id']."'>" .$row_que['question_entry']. "</td>
									<td id='qentry".$row_que['question_id']."'>";
										if(!empty($row_que['question_image'])){
											echo "<img src='uploads/" .$row_que['question_image']. "' style='width:120px;' />";
										}
									echo "</td>
                  <td id='aentry".$row_que['question_id']."'>" .$row_que['answer_entry']. "</td>
                  <td id='aoptional".$row_que['question_id']."'>" .$row_que['answer_optional']. "</td>
                  <td id='qpoints".$row_que['question_id']."'>" .$row_que['points']. "</td>
                  <td id='qduration".$row_que['question_id']."'>" .$row_que['duration']. "</td>
                  <td>
                    <a id='qedit".$row_que['question_id']."' class='note' href='#' title='Edit' onclick='question.edit(".$row_que['question_id'].")'><i class='fa fa-pencil fa-fw fa-lg' aria-hidden='true'></i></a>
                    <a id='qdelete".$row_que['question_id']."' class='note error' href='#' title='Delete' onclick='question.delete(".$row_que['question_id'].")'><i class='fa fa-trash fa-fw fa-lg' aria-hidden='true'></i></a>
										<div id='delete_question".$row_que['question_id']."' class='hide'>
											<form id='qdelete_form".$row_que['question_id']."' action='delete-question?qid=".$row_que['question_id']."' method='post' style='display:inline-block;'>
												<input type='hidden' name='quiz_id' value='".$quiz_id."' / />
												<input class='mini_btn no' type='submit' name='delete_question' value='DELETE' required />
											</form>
											<button id='qdelete_cancel".$row_que['question_id']."' class='mini_btn yes'>CANCEL</button>
										</div>
										<div id='edit_question".$row_que['question_id']."' class='hide'>
											<form id='qedit_form".$row_que['question_id']."' method='post' style='display:inline-block;'>
												<input type='hidden' name='quiz_id".$row_que['question_id']."' value='".$quiz_id."' / />
												<input class='mini_btn yes' type='button' name='edit_question' value='SAVE' onclick='question.save(".$row_que['question_id'].")' />
											</form>
											<button id='qedit_cancel".$row_que['question_id']."' class='mini_btn no'>CANCEL</button>
										</div>
                  </td>
                </tr>";
              }
            echo "</table>";
          ?>
        </div>
      </div>
		</div>

		<span flex></span>

		<div class="footer">
			<span>Cypher &#169; <?php echo date("Y"); ?>. All rights reserved.</span>
		</div>
	</div>
</body>
</html>
