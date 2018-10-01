(function (event) {

  $('#bt-create-pass').click(function () {
    form_popup();
  });
  //
  $('form.addons-partner-create-pass').submit(function (event) {
    let $form = $(this),
      email = $form.find('#email_register').val();
    if (email != '' && email != 'undefined') {
      $("#addons-email-user").val(email);
      let btnVla = $('#btn-verify').text();
      $.ajax({
        type: "POST",
        url: "/ws/login/verify",
        data: {
          user_email: email
        },
        dataType: "json",
        beforeSend: function () {
          $('#error').hide();
          $('#btn-verify').text('...');
        },
        success: function (response) {
          if (response.erro) {
            console.log(response.erro)
            $('#btn-verify').text(btnVla);
            $('#error').html('<span>' + response.erro + '</span>').show();
          } else {
            let url = '/' + $('html')[0].lang + '/register-password?u=' + response.user
            $('#btn-verify').text('working..');
            setTimeout(window.location.href = url, 2000);

          }
        }
      });
    }
    else {
      $("#email-send").css("color", "red");
    }

    event.preventDefault();

  });

  $('form#addons-form-password').submit(function (event) {

    let pass, pass_conf, err = false;

    pass = $('#new_pwd');
    pass_conf = $('#new_pwd2');
    $('#error').hide();
    $("div#addons-form-pass").find("span.pass-p").css("color", "#2b373a");
    $("div#addons-form-pass").find("span.rp-pass-p").css("color", "#2b373a");

    if (!pass.val() || pass.val() == 'undefined') {
      $("div#addons-form-pass").find("span.pass-p").css("color", "red");
      $('#error').html('<span>Preencha o campo senha.</span>').show();
      err = true;
    } else if (!pass_conf.val() && pass_conf.val() == 'undefined') {
      $("div#addons-form-pass").find("span.rp-pass-p").css("color", "red");
      $('#error').html('<span>Preencha o campo confirmação de senha</span>').show();
      err = true;
    } else if (pass.val() != pass_conf.val()) {
      $("div#addons-form-pass").find("span.pass-p").css("color", "red");
      $("div#addons-form-pass").find("span.rp-pass-p").css("color", "red");
      $('#error').html('<span>Senhas não conferem.</span>').show();
      err = true;
    }

    if (err == false) {
      $.ajax({
        type: "POST",
        url: "/ws/login/pass",
        data: {
          u: $('#addons-register-id').val(),
          p: pass.val()
        },
        success: function (response) {
          console.log(response);
          if(response.success){
            $('body').xmalert({
              x: 'right',
              y: 'top',
              xOffset: 30,
              yOffset: 30,
              alertSpacing: 40,
              lifetime: 6000,
              fadeDelay: 0.3,
              autoClose: false,
              template: 'messageSuccess',
              title: 'Sucess:',
              paragraph: 'Senha alterada com sucesso! <button class="btn" style="padding: 10px;margin: 0 5px;border-radius: 8px;color: white;background-color: #56d8b4;font-weight: 700;"><a href="/">Login?</a></button>',
            });
          }
        }
      });
    }

    event.preventDefault();
  });

})(jQuery);


function form_popup() {
  //enable form send email for create password
  $('#create-password').attr('class', 'form-popup');
  $('#account-options').hide();
  //$('#account-options').removeClass('active');
  //$('#create-password').addClass('active') 
}

$('a#button-create-account').click(function (event) {
  window.open("https://docs.google.com/forms/d/e/1FAIpQLSfd8uUsMG6N_rSFi2blGuk3Rfqi_BPp6fxschkmkdhEBVDsyw/viewform", "_blank");
  window.location.href = "/";
})(jQuery);
