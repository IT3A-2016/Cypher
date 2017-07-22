<?php
	session_start();
	include_once '../db.php';

	$contestant_id=$_SESSION['contestant_id'];

  $error=false;

	if(!isset($contestant_id)){
		header('location: ../login');
	}

	$result=mysqli_query($connection, "SELECT * FROM contestant WHERE contestant_id='$contestant_id'");
	$row=mysqli_fetch_assoc($result);

	$result_quiz=mysqli_query($connection, "SELECT * FROM quiz q JOIN contestant c ON q.quiz_id=c.quiz_id WHERE contestant_id='$contestant_id'");
	$row_quiz=mysqli_fetch_assoc($result_quiz);

	if(isset($_POST['join_quiz'])){
		$quiz_code=mysqli_real_escape_string($connection, $_POST['quiz_code']);

		if($quiz_code!=$row_quiz['quiz_code']){
			echo $note="";
		}
		else{
			$query="INSERT INTO joined (code, contestant_id, quiz_id, host_id) VALUES ('".$quiz_code."', '".$contestant_id."', '".$row['quiz_id']."', '".$row['host_id']."')";
			mysqli_query($connection, $query);

			header("location: contest-proper/?qcode=".$quiz_code."&id=".$row['quiz_id']);
		}
	}

	$result_join=mysqli_query($connection, "SELECT * FROM joined WHERE contestant_id='$contestant_id'");
	$row_join=mysqli_fetch_assoc($result_join);

	if(isset($row_join['code'])){
		header('location: contest-proper/?qcode='.$row_join['code']."&id=".$row['quiz_id']);
	}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Competition &mdash; InterQuiz</title>
  <link rel="stylesheet" type="text/css" href="../css/dashboard.css" />
  <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css" />
	<script src="../js/jquery-3.1.1.js" type="text/javascript"></script>
	<script src="../js/contestant.js" type="text/javascript"></script>
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
			<a href="./"><i class="fa fa-paper-plane fa-fw fa-lg" aria-hidden="true"></i>OVERVIEW</a>
			<a class="link_sel" href="competition"><i class="fa fa-pencil-square-o fa-fw fa-lg" aria-hidden="true"></i>COMPETITION</a>
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
			<span class="head_title">COMPETITION</span>
			<span flex></span>
			<span class="head_sub"><i class="fa fa-user fa-fw" aria-hidden="true"></i><?php echo $row['contestant_username']; ?></span>
		</div>

		<div id="content_dash" class="content">
			<div class="section section_full">
				<div class="head_sec">
					<p><?php echo $row_quiz['quiz_name']; ?></p>
				</div>
				<div class="body_sec">
					<div class="section_half">
						<p><b><?php echo date("l, F d, Y"); ?></b></p>
						<form action="" method="post">
							<p>Please enter the quiz code provided by the host to join the quiz competition.</p>
							<div>
								<input class="in_form" type="text" name="quiz_code" placeholder="Quiz code" required />
							</div>
							<div class="note error">
								<?php if(isset($note)){ echo $note="Invalid quiz code!"; } ?>
							</div>
							<div>
								<input class="in_form submit_btn" type="submit" name="join_quiz" value="JOIN" required />
							</div>
						</form>
					</div>
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
