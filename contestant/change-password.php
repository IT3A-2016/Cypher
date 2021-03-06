<?php
	session_start();
	include_once '../db.php';

	$contestant_id=$_SESSION['contestant_id'];

	if(!isset($contestant_id)){
		header('location: ../login');
	}

	$error=false;

	$result=mysqli_query($connection, "SELECT * FROM contestant WHERE contestant_id='$contestant_id'");
	$row=mysqli_fetch_assoc($result);

	if(isset($_POST['update'])){
		$re_pw=mysqli_real_escape_string($connection, $_POST['re_pw']);
		$new_pw=mysqli_real_escape_string($connection, $_POST['new_pw']);
		$confirm_pw=mysqli_real_escape_string($connection, $_POST['confirm_pw']);

		$old_pw=$row['contestant_pw'];
		$re_pw=sha1($_POST['re_pw']);

		if($old_pw!=$re_pw){
			$error=true;
			$error_note="The password you have entered doesn't match from your current password.";
		}
		if($new_pw!=$confirm_pw){
			$error=true;
			$error_note="New password and confirm new password do not match.";
		}
		if(strlen($new_pw)<6){
			$error=true;
			$error_note="Password must be minimum of 6 characters.";
		}

		if(!$error){
			$up="UPDATE contestant SET contestant_pw='".sha1($new_pw)."'";
			if(mysqli_query($connection, $up)){
				echo $note="";
			}
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
      <a href="./"><img src="../images/interquiz-logo-design-white.png" style="height:100%"/></a>
    </div>
  </nav>
  <div class="cont">
    <div class="title_dashboard start-xs">
      <h2>ACCOUNT SETTING</h2>
			<span><a href="edit-school-name">Edit school name</a> | <a href="edit-school-location">Edit school location</a> | <b><a href="change-password">Change password</a></b> | <a href="#">Delete account</a></span>
			<br />
			<span><a href="./"><em>&larr; Back to dashboard</a></em></span>
    </div>
    <div class="body_content_dash container-fluid">
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<p class="note">All fields are required.</p>
				<div class="row">
					<div class="col-xs-6">
						<input class="in_form" type="password" name="re_pw" placeholder="Current password" required />
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<input class="in_form" type="password" name="new_pw" placeholder="New password" required />
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<input class="in_form" type="password" name="confirm_pw" placeholder="Confirm new password" required />
					</div>
				</div>
				<p class="note">
					<?php
						if(isset($note)){ echo $note="Your password has successfully changed."; }
						if(isset($error_note)){ echo $error_note; }
					?>
				</p>
				<div class="row">
					<div class="col-sm-3">
						<input class="submit_btn" type="submit" name="update" value="SAVE CHANGES" required />
					</div>
				</div>
			</form>
      <a href="logout">Log out</a>
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
