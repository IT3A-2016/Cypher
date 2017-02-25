<?php
	session_start();
	include_once 'db.php';

  if(isset($_SESSION['host_id'])!=""){
		header('location: host/');
	}
  else if(isset($_SESSION['contestant_id'])!=""){
    header('location: contestant/');
  }

	$error=false;

	if(isset($_POST['signup'])){
    $email=mysqli_real_escape_string($connection, $_POST['email']);
		$username=mysqli_real_escape_string($connection, $_POST['username']);
    $password=mysqli_real_escape_string($connection, $_POST['password']);
		$confirm_password=mysqli_real_escape_string($connection, $_POST['confirm_password']);
    $school=mysqli_real_escape_string($connection, $_POST['school']);

		$email=stripslashes($email);
		$password=stripslashes($password);
		$confirm_password=stripslashes($confirm_password);
    $school=ucwords($school);

		$host_regdate=date("Y-m-d H:i:s");

		if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
			$error=true;
			$email_error="Please enter a valid email address.";
		}
		if(strlen($password)<6){
			$error=true;
			$password_error="Password must be minimum of 6 characters.";
		}
		if($password!=$confirm_password){
			$error=true;
			$confirm_password_error="Passwords do not match.";
		}
		if(!$error){
			if(mysqli_query($connection, "INSERT INTO host (host_email, host_username, host_pw, host_school, host_regdate) VALUES ('".$email."', '".$username."', '".sha1($password)."', '".$school."', '".$host_regdate."')")){
				header('location: login');
			}
			else{
				$note="Email already exists.";
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register | InterQuiz</title>
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <link rel="stylesheet" type="text/css" href="css/flexboxgrid.min.css" />
</head>
<body>
  <nav class="nav_all">
    <div class="logo">
      <a href="./"><img src="images/interquiz-logo-design-white.png" style="height:100%"/></a>
    </div>
  </nav>
  <div class="cont">
    <div class="title_all center-xs">
      <h1>SIGN UP</h1>
      <div class="short_line"></div>
    </div>
    <div class="body_content container-fluid">
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="row center-xs">
          <div class="col-sm-4">
            <input class="in_form" type="text" name="school" placeholder="School" required />
          </div>
        </div>
        <div class="row center-xs">
          <div class="col-sm-4">
            <input class="in_form" type="text" name="email" placeholder="Email Address" required />
          </div>
        </div>
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
          <div class="col-sm-4">
            <input class="in_form" type="password" name="confirm_password" placeholder="Confirm Password" required />
          </div>
        </div>
        <div class="note row center-xs">
          <div class="col-sm">
            <p>
              By clicking "Register", you agree to the <a href="#">Privacy Policy and Terms</a>.
            </p>
          </div>
        </div>
        <div class="row center-xs">
          <div class="col-sm-2">
            <input class="submit_btn" type="submit" name="signup" value="REGISTER" required />
          </div>
        </div>
      </form>
      <div class="note row center-xs">
        <div class="col-sm">
          <p>
            If you already have an account, log in <a href="login">here</a>.
          </p>
        </div>
      </div>
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
