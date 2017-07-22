// Script for host dashboard

$(function(){

  $("[name='update_school_name']").click(function(){
    var school1=$("[name='school']").val();
    var school_acronym1=$("[name='school_acronym']").val();
    $.post("../host/edit-school-name", {
      school: school1,
      school_acronym: school_acronym1
    }, function(){
      $("#edit_school_name #note").html("<b>Changes in your account are saved.</b>").fadeIn(400).delay(4000).fadeOut(400);
    });
  });

  $("[name='update_school_location']").click(function(){
    var towncity1=$("[name='towncity']").val();
    var provincestate1=$("[name='provincestate']").val();
    var country1=$("[name='country']").val();
    $.post("../host/edit-school-location", {
      towncity: towncity1,
      provincestate: provincestate1,
      country: country1
    }, function(){
      $("#edit_school_location #note").html("<b>Changes in your account are saved.</b>").fadeIn(400).delay(4000).fadeOut(400);
    });
  });

  $("#create_quiz_btn").click(function(){
    $("#create_quiz").show();
    $("#no_comp_notice").hide();
  });

  $("[name='create_quiz_in']").click(function(){
    var quiz_name1=$("[name='quiz_name']").val();
    if(quiz_name1==''){
      $("#create_quiz_form #note").html("<b>Please enter a valid quiz name!</b>").fadeIn(400).delay(4000).fadeOut(400).addClass("error");
    }
    else{
      $.post("../host/create-new-quiz", {
        quiz_name: quiz_name1
      }, function(){
        $("#create_quiz_form #note").html("<b>Successfully created!</b>").fadeIn(400).delay(4000).fadeOut(400);
        setTimeout(function(){
          location.reload();
        }, 1000);
      });
    }
  });

  $("[name='reg_contestant']").click(function(){
    var school1=$("[name='school']").val();
    var username1=$("[name='username']").val();
    var password1=$("[name='password']").val();
    var quiz_id1=$("[name='quiz_id']").val();
    var prefix=$("#prefix").html();
    if(school1=='' || username1=='' || password1==''){
      $("#reg_contestant #note").html("<b>Please fill up all the blank fields!</b>").fadeIn(400).delay(4000).fadeOut(400).addClass("error");
    }
    else{
      $.post("../host/register-contestant", {
        school: school1,
        username: prefix + username1,
        password: password1,
        quiz_id: quiz_id1
      }, function(data){
        $("#reg_contestant #note").html("<b>Contestant registered!</b>").fadeIn(400).delay(4000).fadeOut(400);
        $("#reg_contestant")[0].reset();
      });
    }
  });

  // $("[name='add_question']").click(function(){
  //   var question1=$("[name='question']").val();
  //   var file1=$("[name='file']").val();
  //   var answer1=$("[name='answer']").val();
  //   var other_answer1=$("[name='other_answer']").val();
  //   var points1=$("[name='points']").val();
  //   var duration1=$("[name='duration']").val();
  //   var quiz_id1=$("[name='quiz_id']").val();
  //   if(question1==''){
  //     $("#add_question_form #note").html("<b>Please enter a valid question!</b>").fadeIn(400).delay(4000).fadeOut(400).addClass("error");
  //   }
  //   else if(answer1==''){
  //     $("#add_question_form #note").html("<b>Please enter a valid answer!</b>").fadeIn(400).delay(4000).fadeOut(400).addClass("error");
  //   }
  //   else if(points1=='' || points1<1){
  //     $("#add_question_form #note").html("<b>Please enter valid points!</b>").fadeIn(400).delay(4000).fadeOut(400).addClass("error");
  //   }
  //   else if(duration1=='' || duration1<5){
  //     $("#add_question_form #note").html("<b>Please enter a valid time duration!</b>").fadeIn(400).delay(4000).fadeOut(400).addClass("error");
  //   }
  //   else{
  //     $.post("../host/add-question", {
  //       question: question1,
  //       file: file1,
  //       answer: answer1,
  //       other_answer: other_answer1,
  //       points: points1,
  //       duration: duration1,
  //       quiz_id: quiz_id1
  //     }, function(data){
  //       $("#add_question_form #note").html("<b>The question is added!</b>").fadeIn(400).delay(4000).fadeOut(400);
  //       $("#add_question_form")[0].reset();
  //     });
  //   }
  // });

  $("#edit_quiz_name").click(function(){
    $("#update_quiz_name").toggle();
  });

  $("[name='update_quiz_name']").click(function(){
    var quiz_name1=$("[name='quiz_name']").val();
    var quiz_id1=$("[name='quiz_id']").val();
    $.post("../host/edit-quiz-name", {
      quiz_name: quiz_name1,
      quiz_id: quiz_id1
    }, function(){
      $("#update_quiz_name_form #note").html("<b>The quiz name was changed!</b>").fadeIn(400).delay(4000).fadeOut(400);
      setTimeout(function(){
        location.reload();
      }, 1000);
    });
  });

  $("#del_quiz").click(function(){
    $("#del_quiz_confirm").show();
  });

  $("[name='del_quiz_cancel']").click(function(){
    $("#del_quiz_confirm").hide();
  });

  window.contestant={
    remove: function(cid){
      $("#cedit"+cid).hide();
      $("#cremove"+cid).hide();
      $("#remove_contestant"+cid).show().css('display', 'inline-block');
      $("#cremove_cancel"+cid).click(function(){
        $("#remove_contestant"+cid).hide();
        $("#cedit"+cid).show();
        $("#cremove"+cid).show();
      });
    },
    edit: function(cid){
      var school=$("#cschool"+cid).html();
      $("#cedit"+cid).hide();
      $("#cremove"+cid).hide();
      $("#cedit_form"+cid).show();
      $("#cedit_cancel"+cid).show();
      $("#edit_contestant"+cid).show().css('display', 'inline-block');
      $("#cschool"+cid).html("<input class='in_form no_margin' type='text' name='school"+cid+"' value='"+school+"' required />");
      $("#cedit_cancel"+cid).click(function(){
        $("#edit_contestant"+cid).hide();
        $("#cschool"+cid).html(school);
        $("#cedit"+cid).show();
        $("#cremove"+cid).show();
      });
    },
    save: function(cid){
      var school1=$("[name='school"+cid+"']").val();
      var quiz_id1=$("[name='quiz_id"+cid+"']").val();
      $.post("../host/edit-contestant?cid="+cid, {
        school: school1,
        quiz_id: quiz_id1
      }, function(){
        $("#cedit"+cid).show();
        $("#cremove"+cid).show();
        $("#cedit_form"+cid).hide();
        $("#cedit_cancel"+cid).hide();
        $("#cschool"+cid).html(school1);
      });
    }
  };

  window.question={
    delete: function(qid){
      $("#qedit"+qid).hide();
      $("#qdelete"+qid).hide();
      $("#delete_question"+qid).show().css('display', 'inline-block');
      $("#qdelete_cancel"+qid).click(function(){
        $("#delete_question"+qid).hide();
        $("#qedit"+qid).show();
        $("#qdelete"+qid).show();
      });
    },
    edit: function(qid){
      var question=$("#qentry"+qid).html();
      var answer=$("#aentry"+qid).html();
      var optional=$("#aoptional"+qid).html();
      var points=$("#qpoints"+qid).html();
      var duration=$("#qduration"+qid).html();
      $("#qedit"+qid).hide();
      $("#qdelete"+qid).hide();
      $("#qedit_form"+qid).show();
      $("#qedit_cancel"+qid).show();
      $("#edit_question"+qid).show().css('display', 'inline-block');
      $("#qentry"+qid).html("<input class='in_form no_margin' type='text' name='question"+qid+"' value='"+question+"' required />");
      $("#aentry"+qid).html("<input class='in_form no_margin' type='text' name='answer"+qid+"' value='"+answer+"' required />");
      $("#aoptional"+qid).html("<input class='in_form no_margin' type='text' name='optional"+qid+"' value='"+optional+"' required />");
      $("#qpoints"+qid).html("<input class='in_form no_margin' type='number' min='1' name='points"+qid+"' value='"+points+"' required />");
      $("#qduration"+qid).html("<input class='in_form no_margin' type='number' min='5' name='duration"+qid+"' value='"+duration+"' required />");
      $("#qedit_cancel"+qid).click(function(){
        $("#edit_question"+qid).hide();
        $("#qentry"+qid).html(question);
        $("#aentry"+qid).html(answer);
        $("#aoptional"+qid).html(optional);
        $("#qpoints"+qid).html(points);
        $("#qduration"+qid).html(duration);
        $("#qedit"+qid).show();
        $("#qdelete"+qid).show();
      });
    },
    save: function(qid){
      var question1=$("[name='question"+qid+"']").val();
      var answer1=$("[name='answer"+qid+"']").val();
      var optional1=$("[name='optional"+qid+"']").val();
      var points1=$("[name='points"+qid+"']").val();
      var duration1=$("[name='duration"+qid+"']").val();
      var quiz_id1=$("[name='quiz_id"+qid+"']").val();
      $.post("../host/edit-question?qid="+qid, {
        question: question1,
        answer: answer1,
        optional: optional1,
        points: points1,
        duration: duration1,
        quiz_id: quiz_id1
      }, function(){
        $("#qedit"+qid).show();
        $("#qdelete"+qid).show();
        $("#qedit_form"+qid).hide();
        $("#qedit_cancel"+qid).hide();
        $("#qentry"+qid).html(question1);
        $("#aentry"+qid).html(answer1);
        $("#aoptional"+qid).html(optional1);
        $("#qpoints"+qid).html(points1);
        $("#qduration"+qid).html(duration1);
      });
    }
  };


});
