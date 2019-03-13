$(function () {
  var storeId = $('body').data('store')
  var storeUser = $('body').data('user')
  var storeSSO = $('body').data('sso')
  var itemId = $('#app-resume').data('id')
  var token
  var myId

  // handle installations, widget or application
  $('.request-install').on('click', function (e) {
    // if not sso login
    // request new
    if (storeSSO === '' || storeSSO === 0) {
      window.open('/session/create', 'Auth', 'width=795, height=590')
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
          // set username in form
          // to request authentication in ecp api
          $('[name="username"]').val(storeUser)
          // open form
          $('#modal-confirm-installation').modal('show')

          // listen click in login button
          $('#btn-ecom-login').on('click', function (e) {
            // if click, request login in api
            $.ajax({
              type: 'POST',
              url: 'https://api.e-com.plus/v1/_login.json?username',
              headers: {
                'X-Store-ID': storeId
              },
              data: JSON.stringify({
                username: $('#username').val(),
                pass_md5_hash: md_5($('#password').val())
              }),
              contentType: 'application/json',
              dataType: 'json'
            })
              .done(function (json) {
                // keep store ID
                var storeId = json.store_id
                // authenticate
                $.ajax({
                  url: 'https://api.e-com.plus/v1/_authenticate.json',
                  method: 'POST',
                  dataType: 'json',
                  contentType: 'application/json; charset=UTF-8',
                  headers: {
                    'X-Store-ID': storeId
                  },
                  data: JSON.stringify({
                    '_id': json._id,
                    'api_key': json.api_key
                  })
                })
                  .done(function (resp) {
                    // set access_token and myId
                    token = resp.access_token
                    myId = resp.my_id
                    // hide login
                    $('#modal-confirm-installation').modal('hide')
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
                  })
                  .fail(function (xhr) {
                    console.log(xhr)
                  })
              })
              .fail(function (xhr) {
                console.log(xhr)
              })
          })
          break
        default: break
      }
    }
  })

  var successAlert = function (msg, linkTo) {
    var modalBody = $('#modal-success-body')

    var content = $('<p>', { class: 'lead', text: msg })
    var link = $('<a>', { class: 'link-to', href: linkTo })
    var btn = $('<button>', { class: 'btn btn-block btn-round btn-primary', text: 'Configurar' })

    btn.appendTo(link)
    link.appendTo(content)
    modalBody.html(content)

    $('#modal-install-success').modal('show')
  }
})

function md_5(d) { result = M(V(Y(X(d), 8 * d.length))); return result.toLowerCase() }; function M(d) { for (var _, m = "0123456789ABCDEF", f = "", r = 0; r < d.length; r++)_ = d.charCodeAt(r), f += m.charAt(_ >>> 4 & 15) + m.charAt(15 & _); return f } function X(d) { for (var _ = Array(d.length >> 2), m = 0; m < _.length; m++)_[m] = 0; for (m = 0; m < 8 * d.length; m += 8)_[m >> 5] |= (255 & d.charCodeAt(m / 8)) << m % 32; return _ } function V(d) { for (var _ = "", m = 0; m < 32 * d.length; m += 8)_ += String.fromCharCode(d[m >> 5] >>> m % 32 & 255); return _ } function Y(d, _) { d[_ >> 5] |= 128 << _ % 32, d[14 + (_ + 64 >>> 9 << 4)] = _; for (var m = 1732584193, f = -271733879, r = -1732584194, i = 271733878, n = 0; n < d.length; n += 16) { var h = m, t = f, g = r, e = i; f = md5_ii(f = md5_ii(f = md5_ii(f = md5_ii(f = md5_hh(f = md5_hh(f = md5_hh(f = md5_hh(f = md5_gg(f = md5_gg(f = md5_gg(f = md5_gg(f = md5_ff(f = md5_ff(f = md5_ff(f = md5_ff(f, r = md5_ff(r, i = md5_ff(i, m = md5_ff(m, f, r, i, d[n + 0], 7, -680876936), f, r, d[n + 1], 12, -389564586), m, f, d[n + 2], 17, 606105819), i, m, d[n + 3], 22, -1044525330), r = md5_ff(r, i = md5_ff(i, m = md5_ff(m, f, r, i, d[n + 4], 7, -176418897), f, r, d[n + 5], 12, 1200080426), m, f, d[n + 6], 17, -1473231341), i, m, d[n + 7], 22, -45705983), r = md5_ff(r, i = md5_ff(i, m = md5_ff(m, f, r, i, d[n + 8], 7, 1770035416), f, r, d[n + 9], 12, -1958414417), m, f, d[n + 10], 17, -42063), i, m, d[n + 11], 22, -1990404162), r = md5_ff(r, i = md5_ff(i, m = md5_ff(m, f, r, i, d[n + 12], 7, 1804603682), f, r, d[n + 13], 12, -40341101), m, f, d[n + 14], 17, -1502002290), i, m, d[n + 15], 22, 1236535329), r = md5_gg(r, i = md5_gg(i, m = md5_gg(m, f, r, i, d[n + 1], 5, -165796510), f, r, d[n + 6], 9, -1069501632), m, f, d[n + 11], 14, 643717713), i, m, d[n + 0], 20, -373897302), r = md5_gg(r, i = md5_gg(i, m = md5_gg(m, f, r, i, d[n + 5], 5, -701558691), f, r, d[n + 10], 9, 38016083), m, f, d[n + 15], 14, -660478335), i, m, d[n + 4], 20, -405537848), r = md5_gg(r, i = md5_gg(i, m = md5_gg(m, f, r, i, d[n + 9], 5, 568446438), f, r, d[n + 14], 9, -1019803690), m, f, d[n + 3], 14, -187363961), i, m, d[n + 8], 20, 1163531501), r = md5_gg(r, i = md5_gg(i, m = md5_gg(m, f, r, i, d[n + 13], 5, -1444681467), f, r, d[n + 2], 9, -51403784), m, f, d[n + 7], 14, 1735328473), i, m, d[n + 12], 20, -1926607734), r = md5_hh(r, i = md5_hh(i, m = md5_hh(m, f, r, i, d[n + 5], 4, -378558), f, r, d[n + 8], 11, -2022574463), m, f, d[n + 11], 16, 1839030562), i, m, d[n + 14], 23, -35309556), r = md5_hh(r, i = md5_hh(i, m = md5_hh(m, f, r, i, d[n + 1], 4, -1530992060), f, r, d[n + 4], 11, 1272893353), m, f, d[n + 7], 16, -155497632), i, m, d[n + 10], 23, -1094730640), r = md5_hh(r, i = md5_hh(i, m = md5_hh(m, f, r, i, d[n + 13], 4, 681279174), f, r, d[n + 0], 11, -358537222), m, f, d[n + 3], 16, -722521979), i, m, d[n + 6], 23, 76029189), r = md5_hh(r, i = md5_hh(i, m = md5_hh(m, f, r, i, d[n + 9], 4, -640364487), f, r, d[n + 12], 11, -421815835), m, f, d[n + 15], 16, 530742520), i, m, d[n + 2], 23, -995338651), r = md5_ii(r, i = md5_ii(i, m = md5_ii(m, f, r, i, d[n + 0], 6, -198630844), f, r, d[n + 7], 10, 1126891415), m, f, d[n + 14], 15, -1416354905), i, m, d[n + 5], 21, -57434055), r = md5_ii(r, i = md5_ii(i, m = md5_ii(m, f, r, i, d[n + 12], 6, 1700485571), f, r, d[n + 3], 10, -1894986606), m, f, d[n + 10], 15, -1051523), i, m, d[n + 1], 21, -2054922799), r = md5_ii(r, i = md5_ii(i, m = md5_ii(m, f, r, i, d[n + 8], 6, 1873313359), f, r, d[n + 15], 10, -30611744), m, f, d[n + 6], 15, -1560198380), i, m, d[n + 13], 21, 1309151649), r = md5_ii(r, i = md5_ii(i, m = md5_ii(m, f, r, i, d[n + 4], 6, -145523070), f, r, d[n + 11], 10, -1120210379), m, f, d[n + 2], 15, 718787259), i, m, d[n + 9], 21, -343485551), m = safe_add(m, h), f = safe_add(f, t), r = safe_add(r, g), i = safe_add(i, e) } return Array(m, f, r, i) } function md5_cmn(d, _, m, f, r, i) { return safe_add(bit_rol(safe_add(safe_add(_, d), safe_add(f, i)), r), m) } function md5_ff(d, _, m, f, r, i, n) { return md5_cmn(_ & m | ~_ & f, d, _, r, i, n) } function md5_gg(d, _, m, f, r, i, n) { return md5_cmn(_ & f | m & ~f, d, _, r, i, n) } function md5_hh(d, _, m, f, r, i, n) { return md5_cmn(_ ^ m ^ f, d, _, r, i, n) } function md5_ii(d, _, m, f, r, i, n) { return md5_cmn(m ^ (_ | ~f), d, _, r, i, n) } function safe_add(d, _) { var m = (65535 & d) + (65535 & _); return (d >> 16) + (_ >> 16) + (m >> 16) << 16 | 65535 & m } function bit_rol(d, _) { return d << _ | d >>> 32 - _ }