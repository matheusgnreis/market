$(function () {
  var storeId = $('body').data('store')
  var storeSSO = $('body').data('sso')
  var itemId = $('#main-single').data('id')
  var token = $('body').data('access')
  var myId = $('body').data('my-id')
  //

  if ($('body').data('sso')) {
    if ($('body').data('sso') !== '' && $('body').data('sso') === 1) {
      $("#btn-login-logista").attr("href", "/admin");
      $("#btn-login-logista").text('Painel Lojista');
    }
  }

  var installItem = function () {
    // if not sso login
    // request new
    if (storeSSO === '' || storeSSO === 0) {
      console.log(storeSSO)
      window.sessionStorage.setItem('installItem', $('#btn-install').data('id'))
      openWindow()
    } else {
      // show application scope
      $('#modal-scope-installation').modal('show')
      // listen click in confirmation btn
      $('#btn-confirmation').on('click', function (e) {
        $.getJSON('/v1/applications/' + itemId)
          .done(function (appData) {
            console.log('Installing Application..', itemId)
            // remove aditional data of application market data
            // to sent for ecomplus application resource
            var application = {}

            application.app_id = appData.app_id
            application.state = 'active'
            application.title = appData.title
            application.slug = appData.slug
            application.paid = appData.paid
            application.version = appData.version
            application.version_date = new Date(appData.version_date).toISOString()
            application.type = appData.type
            application.modules = appData.module || {}
            application.admin_settings = appData.json_body || {}
            application.load_events = appData.load_events
            application.script_uri = appData.script_uri
            application.github = appData.github
            application.status = 'active'
            application.authentication = appData.authentication
            application.auth_callback_uri = appData.auth_callback_uri
            application.auth_scope = appData.auth_scope

            //
            /* application.module
            application.data
            application.hidden_data */
            $.ajax({
              type: 'POST',
              url: 'https://api.e-com.plus/v1/applications.json',
              headers: {
                'X-Store-ID': storeId,
                'X-Access-Token': token,
                'X-My-Id': myId
              },
              data: JSON.stringify(application),
              contentType: 'application/json',
              dataType: 'json'
            }).done(function (json) {
              if (json._id) {
                setTimeout(function () {
                  if (typeof appData.redirect_uri !== 'undefined' && appData.redirect_uri !== null) {
                    var url = appData.redirect_uri + '?x_store_id=' + storeId
                    window.open(url, '_blank', 'location=yes,width=900,scrollbars=yes,status=yes')
                  }
                }, 1000)
                // hide modal
                $('#modal-scope-installation').modal('hide')
                // show modal of configuration
                var msg = 'Aplicativo instalado com sucesso. Você pode configurá-lo clicando abaixo.'
                var link = '/admin/applications/' + json._id + '/edit'
                successAlert(msg, link)
              }
            }).fail(function (xhr) {
              console.log(xhr)
            })
          })
      })
    }
  }

  if (window.sessionStorage.getItem('installItem') !== null) {
    if (parseInt(window.sessionStorage.getItem('installItem')) === $('#btn-install').data('id')) {
      // show modal
      installItem()
       $('#modal-scope-installation').modal('show')
      // remove item
      window.sessionStorage.removeItem('installItem')
    }
  }

  // handle installations, widget or application
  $('.request-install').on('click', installItem)

  var successAlert = function (msg, linkTo) {
    var modalBody = $('#modal-success-body')

    var content = $('<p>', { class: 'lead', text: msg })
    var link = $('<a>', { class: 'link-to', href: linkTo })
    var btn = $('<button>', { class: 'btn btn-block btn-round btn-primary', text: 'Configurar' })

    btn.appendTo(link)
    link.appendTo(content)
    modalBody.html(content)

    setTimeout(function () {
      $('#modal-install-success').modal('show')
    }, 2000)
  }

  function openWindow() {
    windowSsoLogin = window.open('/session/create', 'Auth', 'width=600, height=590')
  }
})
