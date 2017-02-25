<?php
	session_start();
	include_once '../db.php';

	if(!isset($_SESSION['admin_id'])){
		header('location: ./');
	}
	$admin_id=$_SESSION['admin_id'];
	$result=mysqli_query($connection, "SELECT * FROM admin WHERE host_id='$admin_id");

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
    <div class="title_all center-xs">
      <h1>ADMINISTRATOR</h1>
      <div class="short_line"></div>
    </div>
    <div class="body_content container-fluid">
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
