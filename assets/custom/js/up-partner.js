
// update partners
$("#addons-button-save").click(function(event){
  let div = "div.form-box-item";
  let id = $(div).find("input.addons-up-id").val();
  let pass = md5($(div).find("input.addons-up-pass").val());
  let rp_pass = md5($(div).find("input.addons-up-rp-pass").val());


  if(pass != rp_pass){
    //If the confirmation password and password are different, activate "span"
    $(div).find("span.pass").css( "color", "red");
    $(div).find("span.rp-pass").css( "color", "red");
  }
  else {
    $(div).find("span.pass").css( "color", "black");
    $(div).find("span.rp-pass").css( "color", "black");
  }

  $("#addons-up-id").val(id);
  $("#addons-up-pass").val(pass);
  $("#addons-up-rp-pass").val(rp_pass);
  // just accept "submit" if the passwords is "ok"
  if(pass == rp_pass){
  $("#addons-up-partner").submit();
  }
  event.preventDefault();
});
