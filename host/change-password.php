<?php
	session_start();
	include_once '../db.php';

	$host_id=$_SESSION['host_id'];

	if(!isset($host_id)){
		header('location: ../login');
	}

	$error=false;

	$result=mysqli_query($connection, "SELECT * FROM host WHERE host_id='$host_id'");
	$row=mysqli_fetch_assoc($result);

	$re_pw=mysqli_real_escape_string($connection, $_POST['re_pw']);
	$new_pw=mysqli_real_escape_string($connection, $_POST['new_pw']);
	$confirm_pw=mysqli_real_escape_string($connection, $_POST['confirm_pw']);

	$old_pw=$row['host_pw'];
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
		$up="UPDATE host SET host_pw='".sha1($new_pw)."'";
		if(mysqli_query($connection, $up)){
			echo $note="";
		}
	}

?>
