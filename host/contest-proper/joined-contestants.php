<?php
	session_start();
	include_once '../../db.php';

	$host_id=$_SESSION['host_id'];
  $quiz_id=$_GET['id'];

	if(!isset($host_id)){
		header('location: ../../login');
	}

	$result=mysqli_query($connection, "SELECT * FROM joined j JOIN contestant c ON j.contestant_id=c.contestant_id WHERE j.host_id='$host_id' AND j.quiz_id='$quiz_id' ORDER BY j.joined_id DESC");

  echo "<table class='designed_tbl'>
    <thead>
      <tr>
        <th style='width: 25%;'>Username</th>
        <th>School Name</th>
      </tr>
    </thead>";

	while($row=mysqli_fetch_assoc($result)){
    echo "<tr>
      <td style='width: 25%;'>" .$row['contestant_username']. "</td>
      <td>" .$row['contestant_school']. "</td>
    </tr>";
  }

  echo "</table>";

?>
