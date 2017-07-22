<?php
  session_start();
  include_once '../db.php';

  $host_id=$_SESSION['host_id'];/=

  if(!isset($host_id)){
		header('location: ../login');
	}

  

?>
