<?php
	session_start();
	if(isset($_SESSION['host_id'])){
		session_destroy();
		unset($_SESSION['host_id']);
		header('location: ./');
	}
  else if(isset($_SESSION['contestant_id'])){
		session_destroy();
		unset($_SESSION['contestant_id']);
		header('location: ./');
	}
	else if(isset($_SESSION['admin_id'])){
		session_destroy();
		unset($_SESSION['admin_id']);
		header('location: admin/');
	}
?>
