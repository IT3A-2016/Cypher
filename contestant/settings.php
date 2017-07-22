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

?>

<!DOCTYPE html>
<html>
<head>
  <title>Settings &mdash; InterQuiz</title>
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
			<a href="competition"><i class="fa fa-pencil-square-o fa-fw fa-lg" aria-hidden="true"></i>COMPETITION</a>
			<a class="link_sel" href="settings"><i class="fa fa-cog fa-fw fa-lg" aria-hidden="true"></i>SETTINGS</a>
		</div>
		<span flex></span>

		<div class="footer">
			<a href="../logout"><i class="fa fa-sign-out fa-fw fa-lg" aria-hidden="true"></i>LOG OUT</a>
		</div>
	</div>
	<!-- Main content -->
	<div class="main col">
		<div class="heading">
			<span class="head_title">SETTINGS</span>
			<span flex></span>
			<span class="head_sub"><i class="fa fa-user fa-fw" aria-hidden="true"></i><?php echo $row['contestant_username']; ?></span>
		</div>
		<!-- Edit school name section -->
		<div id="content_dash" class="content">
      <div class="section section_half">
        <div class="head_sec">
					<p>EDIT SCHOOL NAME</p>
				</div>
        <form id="edit_school_name" action="" method="post">
          <p class="note">All fields are required.</p>
          <div>
            <input class="in_form" type="text" name="school" placeholder="School name" value="<?php echo $row['contestant_school']; ?>" required />
          </div>
          <div class="form_md">
            <input class="in_form" type="text" name="school_acronym" placeholder="School acronym" value="<?php echo $row['contestant_school_acronym']; ?>" required />
          </div>
          <div id="note" class="note">
						<!--  -->
          </div>
          <div>
            <input class="in_form submit_btn" type="button" name="update_school_name" value="SAVE CHANGES" required />
          </div>
        </form>
      </div>
			<!-- Edit school location section -->
      <div class="section section_half">
        <div class="head_sec">
					<p>EDIT SCHOOL LOCATION</p>
				</div>
        <form id="edit_school_location" action="" method="post">
  				<p class="note">Please enter your school's location. All fields are required.</p>
  				<div>
						<input class="in_form" name="towncity" placeholder="Town/city" value="<?php echo $row['contestant_towncity']; ?>" required />
  				</div>
  				<div>
						<input class="in_form" type="text" name="provincestate" placeholder="Province/state" value="<?php echo $row['contestant_provincestate']; ?>" required />
  				</div>
  				<div>
						<select class="in_form" name="country">
							<option value="<?php echo $row['contestant_country']; ?>"><?php echo $row['contestant_country']; ?></option>
  							<?php
  							$country_result=mysqli_query($connection, "SELECT * FROM countries");
  							while($row_country=mysqli_fetch_assoc($country_result)){
  								echo '<option value="'; echo $row_country['country_name']; echo '">' .$row_country['country_name']; echo '</option>';
  							}
  							?>
						</select>
  				</div>
					<div id="note" class="note">
						<!--  -->
          </div>
  				<div>
						<input class="in_form submit_btn" type="button" name="update_school_location" value="SAVE CHANGES" required />
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
