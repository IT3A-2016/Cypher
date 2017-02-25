<?php
	session_start();
	include_once '../db.php';

	$contestant_id=$_SESSION['contestant_id'];

	if(!isset($contestant_id)){
		header('location: ../login');
	}

	$result=mysqli_query($connection, "SELECT * FROM contestant WHERE contestant_id='$contestant_id'");
	$row=mysqli_fetch_assoc($result);

	if(isset($_POST['update'])){
		$school=mysqli_real_escape_string($connection, $_POST['school']);
		$school_acronym=mysqli_real_escape_string($connection, $_POST['school_acronym']);

		$up="UPDATE contestant SET contestant_school='$school', contestant_school_acronym='$school_acronym'";
		if(mysqli_query($connection, $up)){
			echo $note="";
		}
	}

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
      <h2>ACCOUNT SETTING</h2>
			<span><b><a href="edit-school-name">Edit school name</a></b> | <a href="edit-school-location">Edit school location</a> | <a href="change-password">Change password</a> | <a href="#">Delete account</a></span>
			<br />
			<span><a href="./"><em>&larr; Back to dashboard</a></em></span>
    </div>
    <div class="body_content_dash container-fluid">
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<p class="note">All fields are required.</p>
				<div class="row">
					<div class="col-xs-6">
						<input class="in_form" type="text" name="school" placeholder="School name" value="<?php echo $row['contestant_school']; ?>" required />
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<input class="in_form" type="text" name="school_acronym" placeholder="School acronym" value="<?php echo $row['contestant_school_acronym']; ?>" required />
					</div>
				</div>
				<p class="note">
					<?php if(isset($note)){ echo $note="Changes in your account are saved."; } ?>
				</p>
				<div class="row">
					<div class="col-sm-3">
						<input class="submit_btn" type="submit" name="update" value="SAVE CHANGES" required />
					</div>
				</div>
			</form>
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
