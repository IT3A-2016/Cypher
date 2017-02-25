<?php
	session_start();
	include_once '../db.php';

	$host_id=$_SESSION['host_id'];

	if(!isset($host_id)){
		header('location: ../login');
	}

	$result=mysqli_query($connection, "SELECT * FROM host WHERE host_id='$host_id'");
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
      <h1><?php echo $row['host_school']; ?></h1>
			<span>HOST SCHOOL</span>
    </div>
    <div class="body_content_dash container-fluid">
			<div class="row">
				<div class="col-xs-6">
					<div class="sub_head_dash">
						<span>CONTESTANT</span>
					</div>
					<ul>
						<li><a href="#">Register contestant</a></li>
						<li><a href="#">View contestants' details</a></li>
						<li><a href="#">Edit contestants' details</a></li>
						<li><a href="#">Remove contestant</a></li>
					</ul>
				</div>
				<div class="col-xs-6">
					<div class="sub_head_dash">
						<span>COMPETITION PROPER</span>
					</div>
					<ul>
						<li><a href="#">Create new quiz</a></li>
						<li><a href="#">View upcoming competitions</a></li>
						<li><a href="#">View closed competitions</a></li>
						<li><a href="#">Show competition results</a></li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
					<div class="sub_head_dash">
						<span>COMPETITION SETTING</span>
					</div>
					<ul>
						<li><a href="#">Set difficulty</a></li>
						<li><a href="#">Set points and time duration for each difficulty</a></li>
					</ul>
				</div>
				<div class="col-xs-6">
					<div class="sub_head_dash">
						<span>ACCOUNT SETTING</span>
					</div>
					<ul>
						<li><a href="edit-school-name">Edit school name</a></li>
						<li><a href="edit-school-location">Edit school location</a></li>
						<li><a href="change-password">Change password</a></li>
						<li><a href="#">Delete account</a></li>
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
