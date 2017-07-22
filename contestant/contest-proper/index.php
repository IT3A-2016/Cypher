<?php
	session_start();
	include_once '../../db.php';

	$contestant_id=$_SESSION['contestant_id'];
	$quiz_id=$_GET['id'];
  $quiz_code=$_GET['qcode'];

	if(!isset($contestant_id)){
		header('location: ../../login');
	}

	$result=mysqli_query($connection, "SELECT * FROM contestant WHERE contestant_id='$contestant_id'");
	$row=mysqli_fetch_assoc($result);

	$result_quiz=mysqli_query($connection, "SELECT * FROM quiz q JOIN contestant c ON q.quiz_id=c.quiz_id WHERE contestant_id='$contestant_id'");
	$row_quiz=mysqli_fetch_assoc($result_quiz);

  if($quiz_code!=$row_quiz['quiz_code']){
    header('location: ../competition');
  }

?>

<!DOCTYPE html>
<html>
<head>
  <title>Competition &mdash; InterQuiz</title>
  <link rel="stylesheet" type="text/css" href="../../css/dashboard.css" />
  <link rel="stylesheet" type="text/css" href="../../css/font-awesome.min.css" />
	<script src="../../js/jquery-3.1.1.js" type="text/javascript"></script>
	<script src="../../js/contestant.js" type="text/javascript"></script>
</head>
<body class="row">
	<!-- Main content -->
	<div class="main col">
		<div class="heading">
			<span class="head_title">CONTEST PROPER</span>
			<span flex></span>
			<span class="head_sub"><i class="fa fa-user fa-fw" aria-hidden="true"></i><?php echo $row['contestant_username']; ?></span>
		</div>

		<div id="content_dash" class="content">
			<div class="section section_three_quarts" style="height:40vh;">
				<div class="head_sec">
					<p>QUESTION</p>
				</div>
				<div class="row question_sec">
					<div class="section_half">
						<div id="image_c">
	            <!--  -->
						</div>
					</div>
					<div class="section_half">
						<div id="question_c">
	            <!--  -->
						</div>
						<p id="qpoints"></p>
					</div>
					<!-- <button class="in_form submit_btn hide" name="show_score">SHOW SCORE</button> -->
				</div>
			</div>

      <div class="section section_quarts" style="height:40vh;">
        <div class="head_sec">
					<p>TIMER</p>
				</div>
        <div class="timer_sec flex col">
					<div id="timer_c">
            0
					</div>
          <p class="no_margin">second/s</p>
				</div>
      </div>

			<div class="section section_three_quarts" style="height:30vh;">
        <div class="head_sec">
					<p>ANSWER</p>
				</div>
        <div class="body_sec">
					<form action="" method="post">
						<input class="in_form" type="text" name="answer" placeholder="Answer" />
						<input class="in_form submit_btn" type="button" name="submit_answer" value="SUBMIT" disabled />
					</form>
				</div>
      </div>

			<div class="section section_quarts" style="height:30vh;">
        <div class="head_sec">
					<p>SCORE</p>
				</div>
        <div class="body_sec">
					<h2 id="score_c">0</h2>
					<p><i class="note">Correct answer:</i> <span id="correct_ans_c"></span></p>
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
			if((e.which || e.keyCode)==116){
				e.preventDefault();
			}
			if((e.which || e.keyCode)==13){
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

		function loadQuestion(){
			$.ajax({
	      url: "load-question?id="+qid,
	      cache: false,
	      success: function(data){
	        $("#question_c").html(data);
	      }
	    });
			$.ajax({
	      url: "load-image?id="+qid,
	      cache: false,
	      success: function(data){
	        $("#image_c").html(data);
	      }
	    });
			$.ajax({
        url: "load-points?id="+qid,
        cache: false,
        success: function(data){
					if(data){
						  $("#qpoints").html("("+data+" points)").addClass("question_sec_sm");
					}
        }
      });
	    $.ajax({
	      url: "load-duration?id="+qid,
	      cache: false,
	      success:
	      function(counter){
	        $("#timer_c").html(counter);
	        var interval=setInterval(function(){
	          counter--;
	          if(counter>=0){
	            $("#timer_c").html(counter);
	          }
	          if(counter==0){
	            clearInterval(interval);
							$("#question_c").empty();
							$("[name='submit_answer']").prop("disabled", true);
							setTimeout(function(){
				        location.reload();
				      }, 2000);
	          }
	        }, 1000);
	      }
	    });
		}

		function loadScore(){
			$.ajax({
	      url: "load-score?id="+qid,
	      cache: false,
	      success: function(data){
	        $("#score_c").html(data);
	      }
	    });
		}

		function loadCorrectAns(){
			$.ajax({
	      url: "correct-answer?id="+qid,
	      cache: false,
	      success: function(data){
	        $("#correct_ans_c").html(data);
	      }
	    });
		}

		var winterval=setInterval(function(){
			if(!$("#question_c").text().trim().length){
				loadQuestion();
				$("[name='submit_answer']").prop("disabled", true);
    	}
			else{
				clearInterval(winterval);
				$("[name='submit_answer']").prop("disabled", false);
			}
			loadScore();
			loadCorrectAns();
		}, 500);

		$("[name='submit_answer']").click(function(){
			var answer1=$("[name='answer']").val();
			if(answer1==''){
				alert("No answer!");
			}
			else{
				$.post("contestant-answer?id="+qid, {
		      answer: answer1
		    }, function(){
					$("#qpoints").empty();
		      $("[name='submit_answer']").prop("disabled", true);
					$("form")[0].reset();
		    });
			}
		});

	</script>
</body>
</html>
