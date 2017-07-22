<?php
	session_start();
	include_once '../../db.php';

	$host_id=$_SESSION['host_id'];
  $quiz_id=$_GET['id'];

	if(!isset($host_id)){
		header('location: ../../login');
	}
  
  $query_a="SELECT *, SUM(a.score) AS ttlscore FROM answer a JOIN contestant c ON a.contestant_id=c.contestant_id WHERE a.quiz_id='$quiz_id' GROUP BY a.contestant_id ORDER BY ttlscore DESC";
  $result_a=mysqli_query($connection, $query_a);

  echo "<table class='designed_tbl'>
    <thead>
      <tr>
        <th style='width: 75%;'>School</th>
        <th>Total score</th>
      </tr>
    </thead>";

  while($row_a=mysqli_fetch_assoc($result_a)){
    echo "<tr>
      <td>".$row_a['contestant_school']."</td>
      <td>".$row_a['ttlscore']."</td>
    </tr>";
  }

  echo "</table>";

?>
