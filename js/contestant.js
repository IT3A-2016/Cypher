// Script for contestant dashboard

$(function(){

  $("[name='update_school_name']").click(function(){
    var school1=$("[name='school']").val();
    var school_acronym1=$("[name='school_acronym']").val();
    $.post("../contestant/edit-school-name", {
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
    $.post("../contestant/edit-school-location", {
      towncity: towncity1,
      provincestate: provincestate1,
      country: country1
    }, function(){
      $("#edit_school_location #note").html("<b>Changes in your account are saved.</b>").fadeIn(400).delay(4000).fadeOut(400);
    });
  });

});
