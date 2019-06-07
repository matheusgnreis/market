$(function () {

  var emailField = $('#form_email')
  var passwdField = $('#form_password')
  var submitButton = $('.button-submit')

  // verifiy if fields has valid value
  var verifyFields = function () {
    // remove invalid class
    // from input before check
    emailField.removeClass('is-invalid')
    passwdField.removeClass('is-invalid')
    $('.form-group-erro').hide()

    // valid is true by default
    var valid = true

    // check if e-mail is inválid
    if (emailField.val() <= 0 || !IsEmail(emailField.val())) {
      emailField.addClass('is-invalid')
      valid = false
    } else {
      emailField.addClass('is-valid')
    }

    // check if password is invalid
    if (passwdField.val() <= 0) {
      passwdField.addClass('is-invalid')
      valid = false
    } else {
      passwdField.addClass('is-valid')
    }

    return valid
  }

  // on button submit click
  submitButton.on('click', function () {
    if (verifyFields()) {
      var requestOptions = {
        type: 'POST',
        url: '/login',
        data: {
          user_email: emailField.val(),
          user_password: passwdField.val()
        },
        dataType: 'json'
      }
      $.ajax(requestOptions)
        .done(function (resp) {
          console.log(resp)
          if (resp.login !== true) {
            $('.form-group-erro').show()
          } else {
            window.location.href = window.location.origin + '/partners'
          }
        })
        .fail(function (xhr) {
          console.log('Request login fail.', xhr)
        })
    }
  })

});

function IsEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}