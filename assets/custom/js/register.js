(function(event) {

$('#bt-create-pass').click(function() {
  form_popup();
});
//
$('form.addons-partner-create-pass').submit(function(event){
  let $form = $(this),
    email = $form.find('#email_register').val();
    if (email != '' && email != 'undefined') {
      $("#addons-email-user").val(email);
      $("#addons-create-pass").submit();
    }
    else {
      alert("Error E-mail!")
      $("#email-send").css( "color", "red");
    }

    event.preventDefault();

});

//
$('form#addons-form-password').submit(function(event){
  let $div = $("div#addons-form-pass"),
      pass = md5($div.find("input.addons-pass").val()),
      legth_pass = $div.find("input.addons-pass").val().length;
      rp_pass = md5($div.find("input.addons-rp-pass").val()),
      test = $div.find("input.addons-pass").val();
  if(pass != rp_pass || pass == md5('undefined') || pass == md5('') || (legth_pass < 6)){
    //If the confirmation password and password are different, activate "span"
    $div.find("span.pass-p").css( "color", "red");
    $div.find("span.rp-pass-p").css( "color", "red");
    alert('Error Password');
  }
  else {
    $div.find("span.pass-p").css( "color", "black");
    $div.find("span.rp-pass-p").css( "color", "black");
    // TODO: send password save bd
    $('#addons-register-pass').val(pass);
    information = "\n id: " + $('#addons-register-id').val() +
            "\n e-mail: " + $('#addons-register-user').val() + "\n Confirm ? ";
    decision = confirm("Your informations " + information );

    if (decision){ // click ok
    $('form#addons-register').submit();
    } else {
      // click cancel
    location.reload();
    }
  }
  event.preventDefault();
});

})(jQuery);


function form_popup() {
  //enable form send email for create password
  $('#create-password').attr('class', 'form-popup');
}

$('a#button-create-account').click(function(event) {
  window.open("https://docs.google.com/forms/d/e/1FAIpQLSfd8uUsMG6N_rSFi2blGuk3Rfqi_BPp6fxschkmkdhEBVDsyw/viewform","_blank");
  window.location.href = "/index";
})(jQuery);
