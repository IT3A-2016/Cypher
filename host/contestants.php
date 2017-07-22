<?php
	session_start();
	include_once '../db.php';

	$host_id=$_SESSION['host_id'];
  $quiz_id=$_GET['id'];

	if(!isset($host_id)){
		header('location: ../login');
	}

	$result=mysqli_query($connection, "SELECT * FROM host WHERE host_id='$host_id'");
	$row=mysqli_fetch_assoc($result);

  $query_quiz="SELECT * FROM quiz WHERE host_id='$host_id' AND quiz_id=" .$quiz_id;
	$result_quiz=mysqli_query($connection, $query_quiz);
  $row_quiz=mysqli_fetch_assoc($result_quiz);

  $query_c="SELECT * FROM contestant WHERE host_id='$host_id' AND quiz_id=" .$quiz_id;
  $result_c=mysqli_query($connection, $query_c);

	$count_c=mysqli_query($connection, "SELECT COUNT(*) as ccount FROM contestant WHERE host_id='$host_id' AND quiz_id=" .$quiz_id);
	$row_count_c=mysqli_fetch_assoc($count_c);

?>

<!DOCTYPE html>
<html>
<head>
  <title>Contestants &mdash; InterQuiz</title>
  <link rel="stylesheet" type="text/css" href="../css/dashboard.css" />
  <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css" />
	<script src="../js/jquery-3.1.1.js" type="text/javascript"></script>
	<script src="../js/host.js" type="text/javascript"></script>
</head>
<body class="row">
	<!-- Side nav -->
	<div class="nav_dash col">
		<div class="heading">
			<div class="logo">
	      <img src="../images/interquiz-logo-design.png" style="width:100%"/>
	    </div>
		</div>
		<div class="menu_side">
			<a class="link_sel" href="./"><i class="fa fa-paper-plane fa-fw fa-lg" aria-hidden="true"></i>OVERVIEW</a>
			<a href="competitions"><i class="fa fa-pencil-square-o fa-fw fa-lg" aria-hidden="true"></i>COMPETITION</a>
			<a href="settings"><i class="fa fa-cog fa-fw fa-lg" aria-hidden="true"></i>SETTINGS</a>
		</div>
		<span flex></span>
		<div class="footer">
			<a href="../logout"><i class="fa fa-sign-out fa-fw fa-lg" aria-hidden="true"></i>LOG OUT</a>
		</div>
	</div>
	<!-- Main content -->
	<div class="main col">
		<div class="heading">
			<span class="head_title"><a href="competitions">COMPETITION</a> > <a href="competition?id=<?php echo $quiz_id; ?>"><?php echo $row_quiz['quiz_name']; ?></a> > Contestants</span>
			<span flex></span>
			<span class="head_sub"><i class="fa fa-user fa-fw" aria-hidden="true"></i><?php echo $row['host_username']; ?></span>
		</div>

		<div id="content_dash" class="content">
      <div class="section section_full">
        <div class="head_sec">
          <p><?php echo $row_count_c['ccount']; ?> REGISTERED CONTESTANT/S</p>
        </div>
        <div class="body_sec">
          <?php
            echo "<table id='contestant_tbl' class='designed_tbl'>
              <thead>
                <tr>
                  <th>School Name</th>
                  <th>Username</th>
                  <th>Actions</th>
                </tr>
              </thead>";
              while($row_c=mysqli_fetch_assoc($result_c)){
                echo "<tr id='crow".$row_c['contestant_id']."'>
                  <td id='cschool".$row_c['contestant_id']."'>" .$row_c['contestant_school']. "</td>
                  <td id='cusername".$row_c['contestant_id']."'>" .$row_c['contestant_username']. "</td>
                  <td>
                    <a id='cedit".$row_c['contestant_id']."' class='note' href='#' title='Edit' onclick='contestant.edit(".$row_c['contestant_id'].")'><i class='fa fa-pencil fa-fw fa-lg' aria-hidden='true'></i></a>
                    <a id='cremove".$row_c['contestant_id']."' class='note error' href='#' title='Remove' onclick='contestant.remove(".$row_c['contestant_id'].")'><i class='fa fa-minus-circle fa-fw fa-lg' aria-hidden='true'></i></a>
										<div id='remove_contestant".$row_c['contestant_id']."' class='hide'>
											<form id='cremove_form".$row_c['contestant_id']."' action='remove-contestant?cid=".$row_c['contestant_id']."' method='post' style='display:inline-block;'>
												<input type='hidden' name='quiz_id' value='".$quiz_id."' / />
												<input class='mini_btn no' type='submit' name='remove_contestant' value='REMOVE' required />
											</form>
											<button id='cremove_cancel".$row_c['contestant_id']."' class='mini_btn yes'>CANCEL</button>
										</div>
										<div id='edit_contestant".$row_c['contestant_id']."' class='hide'>
											<form id='cedit_form".$row_c['contestant_id']."' method='post' style='display:inline-block;'>
												<input type='hidden' name='quiz_id".$row_c['contestant_id']."' value='".$quiz_id."' / />
												<input class='mini_btn yes' type='button' name='edit_contestant' value='SAVE' onclick='contestant.save(".$row_c['contestant_id'].")' />
											</form>
											<button id='cedit_cancel".$row_c['contestant_id']."' class='mini_btn no'>CANCEL</button>
										</div>
                  </td>
                </tr>";
              }
            echo "</table>";
          ?>
        </div>
      </div>
		</div>

		<span flex></span>

		<div class="footer">
			<span>Cypher &#169; <?php echo date("Y"); ?>. All rights reserved.</span>
		</div>
	</div>
</body>
</html>
