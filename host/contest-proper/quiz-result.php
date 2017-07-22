<?php
	session_start();
	include_once '../../db.php';

	$host_id=$_SESSION['host_id'];
  $quiz_id=$_GET['id'];

	if(!isset($host_id)){
		header('location: ../../login');
	}

	$result=mysqli_query($connection, "SELECT * FROM host WHERE host_id='$host_id'");
	$row=mysqli_fetch_assoc($result);

  $query_quiz="SELECT * FROM quiz WHERE host_id='$host_id' AND quiz_id=" .$quiz_id;
	$result_quiz=mysqli_query($connection, $query_quiz);
  $row_quiz=mysqli_fetch_assoc($result_quiz);

?>

<!DOCTYPE html>
<html>
<head>
  <title>Result &mdash; InterQuiz</title>
  <link rel="stylesheet" type="text/css" href="../../css/dashboard.css" />
  <link rel="stylesheet" type="text/css" href="../../css/font-awesome.min.css" />
	<script src="../../js/jquery-3.1.1.js" type="text/javascript"></script>
	<script src="../../js/host.js" type="text/javascript"></script>
</head>
<body class="row">
	<!-- Side nav -->
	<div class="nav_dash col">
		<div class="heading">
			<div class="logo">
	      <img src="../../images/interquiz-logo-design.png" style="width:100%"/>
	    </div>
		</div>
		<div class="menu_side">
			<a class="link_sel" href="../"><i class="fa fa-paper-plane fa-fw fa-lg" aria-hidden="true"></i>OVERVIEW</a>
			<a href="../competitions"><i class="fa fa-pencil-square-o fa-fw fa-lg" aria-hidden="true"></i>COMPETITION</a>
			<a href="../settings"><i class="fa fa-cog fa-fw fa-lg" aria-hidden="true"></i>SETTINGS</a>
		</div>
		<span flex></span>
		<div class="footer">
			<a href="../../logout"><i class="fa fa-sign-out fa-fw fa-lg" aria-hidden="true"></i>LOG OUT</a>
		</div>
	</div>
	<!-- Main content -->
	<div class="main col">
		<div class="heading">
			<span class="head_title"><a href="../competitions">COMPETITION</a> > <a href="../competition?id=<?php echo $quiz_id; ?>"><?php echo $row_quiz['quiz_name']; ?></a> > <a href="./?id=<?php echo $quiz_id; ?>">Contest Proper</a></span>
			<span flex></span>
			<span class="head_sub"><i class="fa fa-user fa-fw" aria-hidden="true"></i><?php echo $row['host_username']; ?></span>
		</div>

		<div id="content_dash" class="content">
			<div class="section section_full">
				<div class="head_sec">
					<p>QUIZ COMPETITION RESULT</p>
				</div>
				<div class="body_sec">
          <div id="score_result">

          </div>
				</div>
			</div>
		</div>

		<span flex></span>

		<div class="footer">
			<span>Cypher &#169; <?php echo date("Y"); ?>. All rights reserved.</span>
		</div>
	</div>

	<script type="text/javascript">
		function getQueryVariable(variable){
			var query=window.location.search.substring(1);
			var vars=query.split("&");
			for(var i=0;i<vars.length;i++){
				var pair=vars[i].split("=");
				if(pair[0]==variable){
					return pair[1];
				}
			}
			return(false);
		}

		var qid=getQueryVariable("id");

		function load(){
			$.ajax({
				url: "score-tally?id="+qid,
				cache: false,
				success: function(data){
					$("#score_result").html(data);
				}
			});
		}

		load();
		setInterval(load, 2500);
	</script>
</body>
</html>
