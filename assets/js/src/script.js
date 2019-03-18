$(function () {
  var storeId = $('body').data('store')
  var storeSSO = $('body').data('sso')
  var itemId = $('#app-resume').data('id')
  var token = $('body').data('access')
  var myId = $('body').data('my-id')
  var windowSsoLogin
  //

  var installItem = function () {
    // if not sso login
    // request new
    if (storeSSO === '' || storeSSO === 0) {
      window.sessionStorage.setItem('installItem', itemId)
      openWindow()
    } else {
      // checks what item will install
      var itemType = $(this).data('type')

      switch (itemType) {
        // if item is a widget, we need just storeId
        // to register widget at market
        case 'widgets':
          // get widget data
          $.getJSON('/v1/widgets/' + itemId)
            .done(function (item) {
              // logic for item paid
              if (item.paid && item.paid === 1) {
                // todo ...
              }

              var widget = {
                store_id: storeId,
                app_id: item.app_id
              }

              $.ajax({
                type: 'POST',
                url: '/v1/installations',
                data: widget,
                dataType: 'json'
              })
                .done(function (resp) {
                  var msg = 'Widget instalado com sucesso. Você pode configurá-lo clicando abaixo.'
                  var link = 'https://app.e-com.plus/#/apps'
                  successAlert(msg, link)
                })
                .fail(function (xhr) {
                  console.log(xhr)
                })
            })
            .fail(function (xhr) {
              console.log(xhr)
            })

          break
        // if item is a application, we need to request login
        // at ecomplus api to the installation in store-id
        case 'apps':
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
                //application.module
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
                    var link = 'https://app.e-com.plus/#/apps'
                    successAlert(msg, link)
                  }
                }).fail(function (xhr) {
                  console.log(xhr)
                })
              })
          })
          break
        default: break
      }
    }
  }

  if (window.sessionStorage.getItem('installItem') !== null) {
    if (parseInt(window.sessionStorage.getItem('installItem')) === itemId) {
      // show modal
      installItem()
      // $('#modal-scope-installation').modal('show')
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
