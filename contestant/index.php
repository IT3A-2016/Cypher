<?php
	session_start();
	include_once '../db.php';

	$contestant_id=$_SESSION['contestant_id'];

	if(!isset($contestant_id)){
		header('location: ../login');
	}

	$result=mysqli_query($connection, "SELECT * FROM contestant c JOIN host h ON c.host_id=h.host_id WHERE c.contestant_id='$contestant_id'");
	$row=mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html>
<head>
  <title>Overview &mdash; InterQuiz</title>
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
			<a class="link_sel" href="./"><i class="fa fa-paper-plane fa-fw fa-lg" aria-hidden="true"></i>OVERVIEW</a>
			<a href="competition"><i class="fa fa-pencil-square-o fa-fw fa-lg" aria-hidden="true"></i>COMPETITION</a>
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
			<span class="head_sub"><i class="fa fa-user fa-fw" aria-hidden="true"></i><?php echo $row['contestant_username']; ?></span>
		</div>

		<div id="content_dash" class="content">
			<div class="section section_full">
				<div class="head_sec">
					<p>
						<?php
							echo $row['contestant_school'];
							if(!empty($row['contestant_school_acronym'])){
								echo " (" .$row['contestant_school_acronym']. ")";
							}
						?>
					</p>
					<span>REGISTERED BY <?php echo $row['host_school'];  ?></span>
				</div>

				<div class="body_sec row">
					<div class="section_half">
						<table class="no_margin">
							<tr>
								<td>School address</td>
								<td><b>
										<?php
											if(empty($row['contestant_towncity']) || empty($row['contestant_provincestate']) || empty($row['contestant_country'])){
												echo '<a class="def_link" href="settings">Set it up.</a>';
											}
											else{
												echo $row['contestant_towncity']. ', ' .$row['contestant_provincestate']. ', ' .$row['contestant_country'];
											}
										?>
								</b></td>
							</tr>
							<tr>
								<td>Date registered</td>
								<td><?php echo date_format(date_create($row['contestant_regdate']), "F d, Y, h:i A"); ?></td>
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
