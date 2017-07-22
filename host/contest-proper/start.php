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

  $query_quiz="SELECT * FROM quiz WHERE host_id='$host_id' AND quiz_id='$quiz_id'";
	$result_quiz=mysqli_query($connection, $query_quiz);
  $row_quiz=mysqli_fetch_assoc($result_quiz);

  $query_c="SELECT * FROM contestant WHERE host_id='$host_id' AND quiz_id='$quiz_id'";
  $result_c=mysqli_query($connection, $query_c);

  $query_que="SELECT * FROM question WHERE host_id='$host_id' AND quiz_id='$quiz_id' AND question_state=0 ORDER BY question_id LIMIT 1";
  $result_que=mysqli_query($connection, $query_que);
  $row_que=mysqli_fetch_assoc($result_que);

?>

<!DOCTYPE html>
<html>
<head>
  <title><?php echo $row_quiz['quiz_name']; ?> &mdash; InterQuiz</title>
  <link rel="stylesheet" type="text/css" href="../../css/dashboard.css" />
  <link rel="stylesheet" type="text/css" href="../../css/font-awesome.min.css" />
	<script src="../../js/jquery-3.1.1.js" type="text/javascript"></script>
	<script src="../../js/host.js" type="text/javascript"></script>
</head>
<body class="row">
	<!-- Main content -->
	<div class="main col">
		<div class="heading">
			<span class="head_title"><a href="../competitions">COMPETITION</a> > <a href="../competition?id=<?php echo $quiz_id; ?>"><?php echo $row_quiz['quiz_name']; ?></a> > <a href="./?id=<?php echo $quiz_id; ?>">Contest Proper</a></span>
			<span flex></span>
			<span class="head_sub"><i class="fa fa-user fa-fw" aria-hidden="true"></i><?php echo $row['host_username']; ?></span>
		</div>

		<div id="content_dash" class="content">
			<div class="section section_three_quarts" style="height:70vh;">
				<div class="head_sec">
					<p>QUESTION</p>
				</div>
				<div class="question_sec">
					<p id="image_h">
            <!--  -->
					</p>
          <p id="question_h">
            <!--  -->
					</p>
					<p id="qpoints"></p>
					<p id="redirect" class="note">
						<!--  -->
					</p>
          <button class="in_form submit_btn" name="show_question" onclick="loadQuestion(<?php echo $row_que['question_id']; ?>)">SHOW QUESTION</button>
          <button class="in_form submit_btn hide" name="show_answer" onclick="loadAnswer(<?php echo $row_que['question_id']; ?>)">SHOW ANSWER</button>
          <button class="in_form submit_btn hide" name="show_result" onclick="window.location.href='quiz-result?id=<?php echo $quiz_id; ?>'">SEE RESULTS</button>
				</div>
			</div>

      <div class="section section_quarts" style="height:70vh;">
        <div class="head_sec">
					<p>TIMER</p>
				</div>
        <div class="timer_sec flex col">
					<div id="timer_h">
            0
					</div>
          <p class="no_margin">second/s</p>
				</div>
      </div>
		</div>

		<span flex></span>

		<div class="footer">
			<span>Cypher &#169; <?php echo date("Y"); ?>. All rights reserved.</span>
		</div>
	</div>

	<script type="text/javascript">
    function disableF5(e){
      if((e.which || e.keyCode)==116 && (e.which || e.keyCode)==13){
        e.preventDefault();
      }
    };
    $(document).on("keydown", disableF5);

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

    function loadQuestion(queID){
      $.ajax({
        url: "load-question?id="+qid+"&que="+queID,
        cache: false,
        success: function(data){
          if(!data){
            $("#question_h").html("There are no available questions...");
            $("[name='show_result']").show();
          }
          else{
            $("#question_h").html(data);
          }
        }
      });
			$.ajax({
        url: "load-image?id="+qid+"&que="+queID,
        cache: false,
        success: function(data){
          $("#image_h").html(data);
        }
      });
			$.ajax({
        url: "load-points?id="+qid+"&que="+queID,
        cache: false,
        success: function(data){
          $("#qpoints").html("("+data+" points)").addClass("question_sec_sm");
        }
      });
      $.ajax({
        url: "load-duration?id="+qid+"&que="+queID,
        cache: false,
        success:
        function(counter){
          $("#timer_h").html(counter);
          var interval=setInterval(function(){
            counter--;
            if(counter>=0){
              $("#timer_h").html(counter);
            }
            if(counter==0){
              $.ajax({
                url: "update-question-state?id="+qid+"&que="+queID,
                cache: false,
                success: function(data){
                  clearInterval(interval);
                  $("[name='show_answer']").show();
                }
              });
            }
          }, 1000);
        }
      });
      $("[name='show_question']").hide();
    }

    function loadAnswer(queID){
      $.ajax({
        url: "load-answer?id="+qid+"&que="+queID,
        cache: false,
        success: function(data){
          $("#question_h").html(data);
        }
      });
      $("[name='show_answer']").hide();
			setTimeout(function(){
        $("#redirect").html("Loading...");
      }, 2000);
      setTimeout(function(){
				$.ajax({
	        url: "update-question-state-again?id="+qid+"&que="+queID,
	        cache: false,
	        success: function(data){
	          location.reload();
	        }
	      });
      }, 5000);
    }

	</script>
</body>
</html>
