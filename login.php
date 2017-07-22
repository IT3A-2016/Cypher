<?php
	session_start();
	include_once 'db.php';

	if(isset($_SESSION['host_id'])!=""){
		header('location: host/');
	}
  else if(isset($_SESSION['contestant_id'])!=""){
    header('location: contestant/');
  }

	if(isset($_POST['login'])){
    $username=mysqli_real_escape_string($connection, $_POST['username']);
    $password=mysqli_real_escape_string($connection, $_POST['password']);
    $result_host=mysqli_query($connection, "SELECT * FROM host WHERE host_username='".$username."' AND host_pw='".sha1($password)."'");
		$result_contestant=mysqli_query($connection, "SELECT * FROM contestant WHERE contestant_username='".$username."' AND contestant_pw='".sha1($password)."'");

		if($row=mysqli_fetch_array($result_host)){
			$_SESSION['host_id']=$row['host_id'];

			header('location: host/');
		}
    else if($row=mysqli_fetch_array($result_contestant)){
			$_SESSION['contestant_id']=$row['contestant_id'];

			header('location: contestant/');
		}
		else{
			$note="Your username and password do not match.";
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Log In &mdash; InterQuiz</title>
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
				?>
			</div>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="row">
          <input class="in_form" type="text" name="username" placeholder="Username" required />
        </div>
        <div class="row">
					<input class="in_form" type="password" name="password" placeholder="Password" required />
				</div>
        <div class="row">
					<input class="in_form submit_btn" type="submit" name="login" value="LOG IN" required />
				</div>
      </form>
      <div class="note row center">
        <p>
          Don't have an account? <a href="register">Create.</a>
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
