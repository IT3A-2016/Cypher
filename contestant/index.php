<?php
	session_start();
	include_once '../db.php';

	$contestant_id=$_SESSION['contestant_id'];

	if(!isset($contestant_id)){
		header('location: ../login');
	}

	$result=mysqli_query($connection, "SELECT * FROM contestant c JOIN host h JOIN quiz q WHERE c.contestant_id=(SELECT contestant_id FROM contestant c JOIN quiz q WHERE c.quiz_id=q.quiz_id) AND c.host_id=h.host_id");
	$row=mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html>
<head>
  <title>Dashboard | InterQuiz</title>
  <link rel="stylesheet" type="text/css" href="../css/style.css" />
  <link rel="stylesheet" type="text/css" href="../css/flexboxgrid.min.css" />
</head>
<body>
  <nav class="nav_all">
    <div class="logo">
      <a href="../"><img src="../images/interquiz-logo-design-white.png" style="height:100%"/></a>
    </div>
  </nav>
  <div class="cont">
		<div class="title_dashboard start-xs">
      <h1><?php echo $row['contestant_school']; ?></h1>
			<p>Registered by <b><?php echo $row['host_school']; ?></b></p>
			<p>For <b><?php echo $row['quiz_name']; ?></b></p>
    </div>
    <div class="body_content_dash container-fluid">
			<div class="row">
				<div class="col-xs-6">
					<div class="sub_head_dash">
						<span>COMPETITION PROPER</span>
					</div>
					<ul>
						<li><a href="#">Join competition</a></li>
						<li><a href="#">Show competition result</a></li>
					</ul>
				</div>
				<div class="col-xs-6">
					<div class="sub_head_dash">
						<span>ACCOUNT SETTING</span>
					</div>
					<ul>
						<li><a href="edit-school-name">Edit school name</a></li>
						<li><a href="#">Edit school location</a></li>
						<li><a href="#">Change password</a></li>
						<li><a href="#">Delete account</a></li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
					<div class="sub_head_dash">
						<span>PARTICIPANT SETTING</span>
					</div>
					<ul>
						<li><a href="#">View participants</a></li>
						<li><a href="#">Edit participant's name</a></li>
					</ul>
				</div>
			</div>
      <a href="../logout">Log out</a>
    </div>
  </div>
  <footer>
    <div class="row between-xs">
      <div class="col-xs-6 start-md">
        <p>Cypher &#169; <?php echo date("Y"); ?>. All rights reserved.</p>
      </div>
      <div class="footer_right col-xs-6 end-md">
        <ul>
          <li><a class="footer_menu" href="#">About</a></li>
          <li><a class="footer_menu" href="#">Privacy Policy and Terms</a></li>
          <li><a class="footer_menu" href="#">Contact</a></li>
          <li><a class="footer_menu" href="#">Help</a></li>
        </ul>
      </div>
    </div>
  </footer>
</body>
</html>
