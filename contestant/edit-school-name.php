<?php
	session_start();
	include_once '../db.php';

	$contestant_id=$_SESSION['contestant_id'];

	if(!isset($contestant_id)){
		header('location: ../login');
	}

	$result=mysqli_query($connection, "SELECT * FROM contestant WHERE contestant_id='$contestant_id'");
	$row=mysqli_fetch_assoc($result);

	$school=mysqli_real_escape_string($connection, $_POST['school']);
	$school_acronym=mysqli_real_escape_string($connection, $_POST['school_acronym']);

	$up="UPDATE contestant SET contestant_school='$school', contestant_school_acronym='$school_acronym' WHERE contestant_id='$contestant_id'";

	mysqli_query($connection, $up);

?>
