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
  <title>Register &mdash; InterQuiz</title>
  <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
  <div class="cont">
    <div class="body_content">
			<div class="logo_all">
	      <a href="./"><img src="images/interquiz-logo-design.png" style="height:100%"/></a>
	    </div>
			<div class="note row center error">
				<?php
					if(isset($note)){ echo "<p>" .$note. "</p>"; }
					if(isset($email_error)){ echo "<p>" .$email_error. "</p>"; }
					if(isset($password_error)){ echo "<p>" .$password_error. "</p>"; }
					if(isset($confirm_password_error)){ echo "<p>" .$confirm_password_error. "</p>"; }
				?>
			</div>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="row">
					<input class="in_form" type="text" name="school" placeholder="School" required />
        </div>
        <div class="row">
					<input class="in_form" type="text" name="email" placeholder="Email Address" required />
				</div>
        <div class="row">
					<input class="in_form" type="text" name="username" placeholder="Username" required />
				</div>
        <div class="row">
					<input class="in_form" type="password" name="password" placeholder="Password" required />
				</div>
        <div class="row">
					<input class="in_form" type="password" name="confirm_password" placeholder="Confirm Password" required />
				</div>
        <div class="note row center">
          <div class="col-sm">
            <p>
              By clicking "Register", you agree to the <a href="#">Privacy Policy and Terms</a>.
            </p>
          </div>
        </div>
        <div class="row">
					<input class="in_form submit_btn" type="submit" name="signup" value="REGISTER" required />
				</div>
      </form>
      <div class="note row center">
        <p>
          If you already have an account, log in <a href="login">here</a>.
        </p>
      </div>
    </div>

	  <footer>
	    <div class="footer_left">
				<span>Cypher &#169; <?php echo date("Y"); ?>. All rights reserved.</span>
			</div>
			<span flex></span>
      <div class="footer_right">
        <ul>
          <li><a class="footer_menu" href="#">About</a></li>
          <li><a class="footer_menu" href="#">Privacy Policy and Terms</a></li>
          <li><a class="footer_menu" href="#">Contact</a></li>
          <li><a class="footer_menu" href="#">Help</a></li>
        </ul>
      </div>
	  </footer>
	</div>
</body>
</html>
