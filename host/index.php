<?php
	session_start();
	include_once '../db.php';

	$host_id=$_SESSION['host_id'];

	if(!isset($host_id)){
		header('location: ../login');
	}

	$result=mysqli_query($connection, "SELECT * FROM host WHERE host_id='$host_id'");
	$row=mysqli_fetch_assoc($result);

	$count_result=mysqli_query($connection, "SELECT COUNT(*) quiz_count FROM quiz WHERE host_id='$host_id'");
	$count_quiz=mysqli_fetch_assoc($count_result);

?>

<!DOCTYPE html>
<html>
<head>
  <title>Overview &mdash; InterQuiz</title>
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
			<span class="head_title">OVERVIEW</span>
			<span flex></span>
			<span class="head_sub"><i class="fa fa-user fa-fw" aria-hidden="true"></i><?php echo $row['host_username']; ?></span>
		</div>

		<div id="content_dash" class="content">
			<div class="section section_full">
				<div class="head_sec">
					<p>
						<?php
							echo $row['host_school'];
							if(!empty($row['host_school_acronym'])){
								echo " (" .$row['host_school_acronym']. ")";
							}
						?>
					</p>
					<span>HOST SCHOOL</span>
				</div>

				<div class="body_sec row">
					<div class="section_half">
						<table class="no_margin">
							<tr>
								<td>School address</td>
								<td><b>
										<?php
											if(empty($row['host_towncity']) || empty($row['host_provincestate']) || empty($row['host_country'])){
												echo '<a class="def_link" href="settings">Set it up.</a>';
											}
											else{
												echo $row['host_towncity']. ', ' .$row['host_provincestate']. ', ' .$row['host_country'];
											}
										?>
								</b></td>
							</tr>
							<tr>
								<td>Date registered</td>
								<td><?php echo date_format(date_create($row['host_regdate']), "F d, Y, h:i A"); ?></td>
							</tr>
						</table>
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
