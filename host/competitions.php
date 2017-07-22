<?php
	session_start();
	include_once '../db.php';

	$host_id=$_SESSION['host_id'];

	if(!isset($host_id)){
		header('location: ../login');
	}

	$result=mysqli_query($connection, "SELECT * FROM host WHERE host_id='$host_id'");
	$row=mysqli_fetch_assoc($result);

	$query_quiz="SELECT * FROM quiz WHERE host_id='$host_id' ORDER BY quiz_id DESC";
	$result_quiz=mysqli_query($connection, $query_quiz);

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
			<span class="head_title">COMPETITION</span>
			<span flex></span>
			<span class="head_sub"><i class="fa fa-user fa-fw" aria-hidden="true"></i><?php echo $row['host_username'] ?></span>
		</div>

		<div id="content_dash_comp" class="content">
			<?php
				if(mysqli_num_rows($result_quiz)>0){
					echo "<div class='section_full note end'>
						<a id='create_quiz_btn' href='#'>Add competition</a>
					</div>";
					echo '<div id="create_quiz" class="section section_half hide">
					  <div class="head_sec">
					    <p>CREATE QUIZ COMPETITION</p>
					  </div>
					  <form id="create_quiz_form" action="" method="post">
					    <div>
					      <input class="in_form" type="text" name="quiz_name" placeholder="Quiz name" required />
					    </div>
					    <div id="note" class="note">
					      <!--  -->
					    </div>
					    <div>
					      <input class="in_form submit_btn" type="button" name="create_quiz_in" value="CREATE" required />
					    </div>
					  </form>
					</div>';
					while($row_quiz=mysqli_fetch_assoc($result_quiz)){

						$count_query=mysqli_query($connection, "SELECT COUNT(*) as count FROM contestant WHERE contestant.quiz_id=".$row_quiz['quiz_id']);

						$count=mysqli_fetch_assoc($count_query)['count'];

						echo "<a href='competition?id=".$row_quiz['quiz_id']."' class='section section_half'>
							<div class='head_sec'>
								<p>" .$row_quiz['quiz_name']. "</p>
							</div>
							<div class='body_sec'>
								<p>Quiz code: <b>" .$row_quiz['quiz_code']. "</b></p>
								<p>"
									.$count. " registered contestants
								</p>
							</div>
						</a>";
					}
				}
				else{
					echo "<p id='no_comp_notice' class='note'>
						There are no competitions to show. <a id='create_quiz_btn' href='#'>Click here</a> to create.
					</p>";
					echo '<div id="create_quiz" class="section section_half hide">
					  <div class="head_sec">
					    <p>CREATE QUIZ COMPETITION</p>
					  </div>
					  <form id="create_quiz_form" action="" method="post">
					    <div>
					      <input class="in_form" type="text" name="quiz_name" placeholder="Quiz name" required />
					    </div>
					    <div id="note" class="note">
					      <!--  -->
					    </div>
					    <div>
					      <input class="in_form submit_btn" type="button" name="create_quiz_in" value="CREATE" required />
					    </div>
					  </form>
					</div>';
				}
			?>

		</div>
		<span flex></span>
		<div class="footer">
			<span>Cypher &#169; <?php echo date("Y"); ?>. All rights reserved.</span>
		</div>
	</div>
</body>
</html>
