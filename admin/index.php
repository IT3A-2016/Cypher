<?php
	session_start();
	include_once '../db.php';

	if(isset($_SESSION['admin_id'])!=""){
		header('location: dashboard');
	}

	if(isset($_POST['login'])){
    $username=mysqli_real_escape_string($connection, $_POST['username']);
    $password=mysqli_real_escape_string($connection, $_POST['password']);
    $result=mysqli_query($connection, "SELECT * FROM admin WHERE admin_username='".$username."' AND admin_pw='".$password."'");

		if($row=mysqli_fetch_array($result)){
			$_SESSION['admin_id']=$row['admin_id'];

			header('location: dashboard');
		}
		else{
			$note='';
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Log In | InterQuiz</title>
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
      <h1>SIGN IN</h1>
      <div class="short_line"></div>
    </div>
    <div class="body_content container-fluid">
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="row center-xs">
          <div class="col-sm-4">
            <input class="in_form" type="text" name="username" placeholder="Username" required />
          </div>
        </div>
        <div class="row center-xs">
          <div class="col-sm-4">
            <input class="in_form" type="password" name="password" placeholder="Password" required />
          </div>
        </div>
        <div class="row center-xs">
          <div class="col-sm-2">
            <input class="submit_btn" type="submit" name="login" value="LOG IN" required />
          </div>
        </div>
      </form>
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
