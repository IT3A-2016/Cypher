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

  $prefix=$row['host_username']. '' .$_GET['id']. '_';

	$quiz_creation=date_create($row_quiz['quiz_creation']);

?>

<!DOCTYPE html>
<html>
<head>
  <title>Competition &mdash; InterQuiz</title>
  <link rel="stylesheet" type="text/css" href="../css/dashboard.css" />
  <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css" />
	<script src="../js/jquery-3.1.1.js" type="text/javascript"></script>
	<script src="../js/host.js" type="text/javascript"></script>
</head>
<body class="row">
	<div class="nav_dash col">
		<div class="heading">
			<div class="logo">
	      <img src="../images/interquiz-logo-design.png" style="width:100%"/>
	    </div>
		</div>
		<div class="menu_side">
			<a href="./"><i class="fa fa-paper-plane fa-fw fa-lg" aria-hidden="true"></i>OVERVIEW</a>
			<a class="link_sel" href="competitions"><i class="fa fa-pencil-square-o fa-fw fa-lg" aria-hidden="true"></i>COMPETITION</a>
			<a href="settings"><i class="fa fa-cog fa-fw fa-lg" aria-hidden="true"></i>SETTINGS</a>
		</div>
		<span flex></span>
		<div class="footer">
			<a href="../logout"><i class="fa fa-sign-out fa-fw fa-lg" aria-hidden="true"></i>LOG OUT</a>
		</div>
	</div>

	<div class="main col">
		<div class="heading">
			<span class="head_title"><a href="competitions">COMPETITION</a> > <?php echo $row_quiz['quiz_name']; ?></span>
			<span flex></span>
			<span class="head_sub"><i class="fa fa-user fa-fw" aria-hidden="true"></i><?php echo $row['host_username'] ?></span>
		</div>

		<div id="content_dash_comp" class="content">
			<div class="section section_full">
				<div class="head_sec">
					<p>INFO</p>
				</div>
				<div class="body_sec row">
					<div class="section_half">
						<table class="no_margin">
							<tr>
								<td>Quiz name</td>
								<td><b> <?php echo $row_quiz['quiz_name']; ?> </b><a id="edit_quiz_name" class='note' href='#' title='Edit'><i class='fa fa-pencil fa-fw fa-lg' aria-hidden='true'></i></a></td>
							</tr>
							<tr>
								<td>Quiz code</td>
								<td><b> <?php echo $row_quiz['quiz_code']; ?> </b></td>
							</tr>
							<tr>
								<td>Date created</td>
								<td><?php echo date_format($quiz_creation, "F d, Y"); ?></td>
							</tr>
							<tr>
								<td>Time created</td>
								<td><?php echo date_format($quiz_creation, "h:i A"); ?></td>
							</tr>
						</table>

						<div>
							<button class="in_form submit_btn" name="start_quiz" onclick="window.location.href='contest-proper/?id=<?php echo $quiz_id; ?>'">CONTEST PROPER</button>
	          </div>
					</div>

					<div class="section_half">
						<div id="update_quiz_name" class="hide">
							<form id="update_quiz_name_form" action="" method="post">
								<div>
						      <input class="in_form" type="text" name="quiz_name" placeholder="Quiz name" value="<?php echo $row_quiz['quiz_name']; ?>" required />
						    </div>
						    <div id="note" class="note">
						      <!--  -->
						    </div>
								<input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>" />
						    <div>
						      <input class="in_form submit_btn" type="button" name="update_quiz_name" value="UPDATE" required />
						    </div>
							</form>
						</div>
						<p>
							<b><a id="del_quiz" class="error no_deco" href="#">Delete quiz</a></b>
							<div id="del_quiz_confirm" class="hide">
								<p>
									Deleting the quiz competition will also delete all the contestants' accounts and questionnaires you have created for this competition. Are you sure?
								</p>
								<form action="delete-quiz" method="post" style="display:inline-block;">
									<input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>" />
									<input class="mini_btn yes" type="submit" name="delete_quiz" value="YES" required />
								</form>
								<button class="mini_btn no" name="del_quiz_cancel">CANCEL</button>
							</div>
						</p>
					</div>

				</div>
			</div>

      <div class="section section_half">
        <div class="head_sec">
          <p class="flex">
						REGISTER CONTESTANTS
						<span flex></span>
						<a class="note" href="contestants?id=<?php echo $quiz_id; ?>" title="View Contestants"><i class="fa fa-th-list fa-fw fa-lg" aria-hidden="true"></i></a>
					</p>
        </div>
        <form id="reg_contestant" action="" method="post">
          <p class="note">All fields are required.</p>
          <div>
            <input class="in_form" type="text" name="school" placeholder="School name" required />
          </div>
          <div class="form_md">
            <span class="note">
              Username prefix:
              <b><span id="prefix"><?php echo $prefix; ?></span></b>
            </span>
            <input class="in_form" type="text" name="username" placeholder="Username" required />
          </div>
          <div class="form_md">
            <input class="in_form" type="password" name="password" placeholder="Password" required />
          </div>
					<input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>" />
          <div id="note" class="note">
						<!--  -->
          </div>
          <div>
            <input class="in_form submit_btn" type="button" name="reg_contestant" value="REGISTER" required />
          </div>
        </form>
      </div>

			<div class="section section_half">
				<div class="head_sec">
					<p class="flex">
						ADD QUESTIONS
						<span flex></span>
						<a class="note" href="questions?id=<?php echo $quiz_id; ?>" title="View Questions"><i class="fa fa-th-list fa-fw fa-lg" aria-hidden="true"></i></a>
					</p>
				</div>
				<form id="add_question_form" action="add-question" method="post" enctype="multipart/form-data">
					<p class="note">Other possible answer is optional.</p>
					<div>
						<input class="in_form" type="text" name="question" placeholder="Question" required />
					</div>
					<div>
						<input class="in_file" type="file" name="file" accept="image/*" />
					</div>
					<div>
						<input class="in_form" type="text" name="answer" placeholder="Correct answer" required />
					</div>
					<div>
						<input class="in_form" type="text" name="other_answer" placeholder="Other possible answer" />
					</div>
					<div>
						<input class="in_form" type="number" name="points" min="1" placeholder="Points" required />
					</div>
					<div>
						<input class="in_form" type="number" name="duration" min="5" placeholder="Time duration in seconds" required />
					</div>
					<input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>" />
					<div id="note" class="note">
						<!--  -->
          </div>
          <div>
            <input class="in_form submit_btn" type="submit" name="add_question" value="SUBMIT" required />
          </div>
				</form>
			</div>

		</div>

		<span flex></span>

		<div class="footer">
			<span>Cypher &#169; <?php echo date("Y"); ?>. All rights reserved.</span>
		</div>
	</div>
</body>
</html>
