<?php
	session_start();
	include_once '../db.php';

	$host_id=$_SESSION['host_id'];

	if(!isset($host_id)){
		header('location: ../login');
	}

	$result=mysqli_query($connection, "SELECT * FROM host WHERE host_id='$host_id'");
	$row=mysqli_fetch_assoc($result);

	if(isset($_POST['update'])){
		$towncity=mysqli_real_escape_string($connection, $_POST['towncity']);
		$provincestate=mysqli_real_escape_string($connection, $_POST['provincestate']);
		$country=mysqli_real_escape_string($connection, $_POST['country']);

		$up="UPDATE host SET host_towncity='$towncity', host_provincestate='$provincestate', host_country='$country'";
		if(mysqli_query($connection, $up)){
			echo $note="";
		}
	}

	$ip=$_SERVER['REMOTE_ADDR'];

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
			<span><a href="edit-school-name">Edit school name</a> | <b><a href="edit-school-location">Edit school location</a></b> | <a href="change-password">Change password</a> | <a href="#">Delete account</a></span>
			<br />
			<span><a href="./"><em>&larr; Back to dashboard</a></em></span>
    </div>
    <div class="body_content_dash container-fluid">
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<p class="note">Please enter your school's location. All fields are required.</p>
				<div class="row">
					<div class="col-xs-6">
						<input class="in_form" type="text" name="towncity" placeholder="Town/city" value="<?php echo $row['host_towncity']; ?>" required />
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<input class="in_form" type="text" name="provincestate" placeholder="Province/state" value="<?php echo $row['host_provincestate']; ?>" required />
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<select class="in_form_drop" name="country">
							<option value="<?php echo $row['host_country']; ?>"><?php echo $row['host_country']; ?></option>
							<?php
							$country_result=mysqli_query($connection, "SELECT * FROM countries");
							while($row_country=mysqli_fetch_assoc($country_result)){
								echo '<option value="'; echo $row_country['country_name']; echo '">' .$row_country['country_name']; echo '</option>';
							}
							?>
						</select>
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
