$(function () {
  var ecomApiPath = 'https://api.e-com.plus/v1/'
  var applicationPathMarket = '/v1/applications'
  var requestHeader = {}
  var bf = []
  var session = {}

  // creates components of page
  var components = {
    /**
     * 
     */
    applications: function (apps) {

      var getAppData = function (appId) {
        return $.ajax({
          type: 'GET',
          url: applicationPathMarket + '/' + appId,
          dataType: 'json'
        })
      }

      if (apps) {
        $.map(apps, function (app) {

          var card = $('<div>', { class: 'card' })
          var cardTitle = $('<h6>', { class: 'card-title' })

          //
          var cardLink = $('<a>', { class: 'd-flex align-items-center', 'data-toggle': 'collapse', href: '#collapse-app-' + app._id })
          $('<strong>', { class: 'mr-auto', text: app.title }).appendTo(cardLink)
          cardLink.appendTo(cardTitle)

          var switcher = $('<div>', { class: 'switch' })
          $('<input>', { type: 'checkbox', class: 'switch-input', checked: app.state === 'active' ? true : false, id: app._id }).appendTo(switcher)
          $('<label>', { class: 'switch-label', text: 'Ativo' }).appendTo(switcher)

          var appState = $('<div>', { class: 'app-state' })
          $('<span>', { text: 'Status' }).appendTo(appState)
          switcher.appendTo(appState)

          //
          var collapse = $('<div>', { id: 'collapse-app-' + app._id, class: 'collapse', 'data-parent': '#accordion-apps' })
          var cardBody = $('<div>', { class: 'card-body', id: 'card-body-' + app.app_id })
          appState.appendTo(collapse)
          cardBody.appendTo(collapse)
          // card body

          cardTitle.appendTo(card)
          collapse.appendTo(card)
          card.appendTo('#accordion-apps')
          //
          var editBody = document.getElementById('card-body-' + app.app_id)

          $('#accordion-apps').hide()
          //
          getAppData(app.app_id)
            .done(function (json) {
              bf[app.app_id] = brutusin['json-forms'].create(json.json_body)

              let datas = []

              if (app.data || app.hidden_data) {
                datas.data = app.data
                datas.hidden_data = app.hidden_data
              }

              bf[app.app_id].render(editBody, datas)
              // if not has json_body removes acordion body
              if (!json.json_body) {
                editBody.remove()
                console.log(editBody)
              } else {
                var btn = $('<p>').append($('<a>', { class: 'btn btn-sm btn-round btn-success account-action', text: 'Alterar', 'data-app-id': app.app_id, 'data-application': app._id }))
                btn.appendTo(cardBody)
              }
              $('#accordion-apps').slideDown()
            })
            .fail(function (xhr) {
              console.log(xhr)
            })
        })
      }
    },
    /**
     * 
     */
    evaluations: function () {

    },
    /**
     * 
     */
    settings: function () {

    }
  }

  // update application data/hidden_data
  $(document).on('click', '.account-action', function () {
    var formId = $(this).data('appId')
    var applicationId = $(this).data('application')
    var formData = bf[formId].getData()

    var updateApplication = function (id, data, subresource = '') {
      return $.ajax({
        type: 'PATCH',
        url: ecomApiPath + 'applications/' + id + subresource + '.json',
        dataType: 'json',
        contentType: 'application/json; charset=utf-8',
        headers: requestHeader,
        data: JSON.stringify(data)
      })
    }

    if (formData.data) {
      updateApplication(applicationId, formData.data, '/data')
        .done(function (resp) {
          console.log(resp)
        })
        .fail(function (fail) {
          console.log(fail)
        })
    }

    if (formData.hidden_data) {
      updateApplication(applicationId, formData.hidden_data, '/hidden_data')
        .done(function (resp) {
          console.log(resp)
        })
        .fail(function (fail) {
          console.log(fail)
        })
    }
  })

  // changes application status
  $(document).on('change', '.switch-input', function () {
    var resourceId = $(this)[0].id
    var state = $(this)[0].checked === true ? 'active' : 'inactive'
    var status = $(this)[0].checked === true ? 'active' : 'waiting'
    var dataChange = {
      state: state,
      status: status
    }
    return $.ajax({
      type: 'PATCH',
      url: ecomApiPath + 'applications/' + resourceId + '.json',
      dataType: 'json',
      contentType: 'application/json; charset=utf-8',
      headers: requestHeader,
      data: JSON.stringify(dataChange)
    })
  })

  var lojApplications = function () {
    var query = '?fields=_id,app_id,title,state,updated_at,data,hidden_data'
    return $.ajax({
      type: 'GET',
      url: ecomApiPath + 'applications.json' + query,
      dataType: 'json',
      headers: requestHeader
    })
  }

  // validates user login at ecp api,
  // before render spa
  var login = function (callback) {
    var my_id = window.sessionStorage.getItem('my_id') || undefined
    var access_token = window.sessionStorage.getItem('access_token') || undefined
    var storeId = window.sessionStorage.getItem('store_id') || $('body').data('store-id')

    if ((typeof my_id === 'undefined' || typeof access_token === 'undefined' || typeof storeId === 'undefined')) {

      // show modal to confirm login
      $('#modal-login-admin').modal('show')

      // listen btn click of login-form
      $('#btn-admin-login').on('click', function () {
        var username = $('[name="username"]').val()
        var password = $('[name="password"]').val()

        if (username && password) {
          var authFail = function (jqXHR, textStatus, err) {
            if (jqXHR.status !== 403) {
              // unexpected status
              console.error(err)
            }
          }

          $.ajax({
            url: 'https://api.e-com.plus/v1/_login.json?username',
            method: 'POST',
            dataType: 'json',
            contentType: 'application/json; charset=UTF-8',
            headers: {
              // random store ID
              'X-Store-ID': $('body').data('store-id')
            },
            data: JSON.stringify({
              'username': username,
              'pass_md5_hash': md5(password)
            })
          })

            .done(function (json) {
              console.log('Logged')
              // keep store ID
              var storeId = json.store_id
              window.localStorage.setItem('store_id', storeId)

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
                .done(function (json) {
                  // store authentication on browser session
                  // loss data when browser tab is closed
                  window.sessionStorage.setItem('my_id', json.my_id)
                  window.sessionStorage.setItem('access_token', json.access_token)
                  window.sessionStorage.setItem('expires', json.expires)
                  window.sessionStorage.setItem('username', username)

                  // reload page
                  window.location.reload()
                })
                .fail(authFail)
            })
            .fail(authFail)
        }
      })

      // if modal is dismissed go to /
      // $('#modal-login-admin').on('hidden.bs.modal', function (e) {
      //   window.location.href = '/'
      // })

    } else {

      requestHeader = {
        'X-Store-ID': storeId,
        'X-My-ID': my_id,
        'X-Access-Token': access_token
      }
      
      session = {
        my_id: my_id,
        access_token: access_token,
        storeId: storeId
      }
      // validate login
      // load components
      lojApplications()
        .done(function (apps) {
          components.applications(apps.result)
        })
    }
  }

  var init = function () {
    login()
  }

  //
  if ($('#admin-body').length) {
    init()
  }
})

function md5(d) { result = M(V(Y(X(d), 8 * d.length))); return result.toLowerCase() }; function M(d) { for (var _, m = "0123456789ABCDEF", f = "", r = 0; r < d.length; r++)_ = d.charCodeAt(r), f += m.charAt(_ >>> 4 & 15) + m.charAt(15 & _); return f } function X(d) { for (var _ = Array(d.length >> 2), m = 0; m < _.length; m++)_[m] = 0; for (m = 0; m < 8 * d.length; m += 8)_[m >> 5] |= (255 & d.charCodeAt(m / 8)) << m % 32; return _ } function V(d) { for (var _ = "", m = 0; m < 32 * d.length; m += 8)_ += String.fromCharCode(d[m >> 5] >>> m % 32 & 255); return _ } function Y(d, _) { d[_ >> 5] |= 128 << _ % 32, d[14 + (_ + 64 >>> 9 << 4)] = _; for (var m = 1732584193, f = -271733879, r = -1732584194, i = 271733878, n = 0; n < d.length; n += 16) { var h = m, t = f, g = r, e = i; f = md5_ii(f = md5_ii(f = md5_ii(f = md5_ii(f = md5_hh(f = md5_hh(f = md5_hh(f = md5_hh(f = md5_gg(f = md5_gg(f = md5_gg(f = md5_gg(f = md5_ff(f = md5_ff(f = md5_ff(f = md5_ff(f, r = md5_ff(r, i = md5_ff(i, m = md5_ff(m, f, r, i, d[n + 0], 7, -680876936), f, r, d[n + 1], 12, -389564586), m, f, d[n + 2], 17, 606105819), i, m, d[n + 3], 22, -1044525330), r = md5_ff(r, i = md5_ff(i, m = md5_ff(m, f, r, i, d[n + 4], 7, -176418897), f, r, d[n + 5], 12, 1200080426), m, f, d[n + 6], 17, -1473231341), i, m, d[n + 7], 22, -45705983), r = md5_ff(r, i = md5_ff(i, m = md5_ff(m, f, r, i, d[n + 8], 7, 1770035416), f, r, d[n + 9], 12, -1958414417), m, f, d[n + 10], 17, -42063), i, m, d[n + 11], 22, -1990404162), r = md5_ff(r, i = md5_ff(i, m = md5_ff(m, f, r, i, d[n + 12], 7, 1804603682), f, r, d[n + 13], 12, -40341101), m, f, d[n + 14], 17, -1502002290), i, m, d[n + 15], 22, 1236535329), r = md5_gg(r, i = md5_gg(i, m = md5_gg(m, f, r, i, d[n + 1], 5, -165796510), f, r, d[n + 6], 9, -1069501632), m, f, d[n + 11], 14, 643717713), i, m, d[n + 0], 20, -373897302), r = md5_gg(r, i = md5_gg(i, m = md5_gg(m, f, r, i, d[n + 5], 5, -701558691), f, r, d[n + 10], 9, 38016083), m, f, d[n + 15], 14, -660478335), i, m, d[n + 4], 20, -405537848), r = md5_gg(r, i = md5_gg(i, m = md5_gg(m, f, r, i, d[n + 9], 5, 568446438), f, r, d[n + 14], 9, -1019803690), m, f, d[n + 3], 14, -187363961), i, m, d[n + 8], 20, 1163531501), r = md5_gg(r, i = md5_gg(i, m = md5_gg(m, f, r, i, d[n + 13], 5, -1444681467), f, r, d[n + 2], 9, -51403784), m, f, d[n + 7], 14, 1735328473), i, m, d[n + 12], 20, -1926607734), r = md5_hh(r, i = md5_hh(i, m = md5_hh(m, f, r, i, d[n + 5], 4, -378558), f, r, d[n + 8], 11, -2022574463), m, f, d[n + 11], 16, 1839030562), i, m, d[n + 14], 23, -35309556), r = md5_hh(r, i = md5_hh(i, m = md5_hh(m, f, r, i, d[n + 1], 4, -1530992060), f, r, d[n + 4], 11, 1272893353), m, f, d[n + 7], 16, -155497632), i, m, d[n + 10], 23, -1094730640), r = md5_hh(r, i = md5_hh(i, m = md5_hh(m, f, r, i, d[n + 13], 4, 681279174), f, r, d[n + 0], 11, -358537222), m, f, d[n + 3], 16, -722521979), i, m, d[n + 6], 23, 76029189), r = md5_hh(r, i = md5_hh(i, m = md5_hh(m, f, r, i, d[n + 9], 4, -640364487), f, r, d[n + 12], 11, -421815835), m, f, d[n + 15], 16, 530742520), i, m, d[n + 2], 23, -995338651), r = md5_ii(r, i = md5_ii(i, m = md5_ii(m, f, r, i, d[n + 0], 6, -198630844), f, r, d[n + 7], 10, 1126891415), m, f, d[n + 14], 15, -1416354905), i, m, d[n + 5], 21, -57434055), r = md5_ii(r, i = md5_ii(i, m = md5_ii(m, f, r, i, d[n + 12], 6, 1700485571), f, r, d[n + 3], 10, -1894986606), m, f, d[n + 10], 15, -1051523), i, m, d[n + 1], 21, -2054922799), r = md5_ii(r, i = md5_ii(i, m = md5_ii(m, f, r, i, d[n + 8], 6, 1873313359), f, r, d[n + 15], 10, -30611744), m, f, d[n + 6], 15, -1560198380), i, m, d[n + 13], 21, 1309151649), r = md5_ii(r, i = md5_ii(i, m = md5_ii(m, f, r, i, d[n + 4], 6, -145523070), f, r, d[n + 11], 10, -1120210379), m, f, d[n + 2], 15, 718787259), i, m, d[n + 9], 21, -343485551), m = safe_add(m, h), f = safe_add(f, t), r = safe_add(r, g), i = safe_add(i, e) } return Array(m, f, r, i) } function md5_cmn(d, _, m, f, r, i) { return safe_add(bit_rol(safe_add(safe_add(_, d), safe_add(f, i)), r), m) } function md5_ff(d, _, m, f, r, i, n) { return md5_cmn(_ & m | ~_ & f, d, _, r, i, n) } function md5_gg(d, _, m, f, r, i, n) { return md5_cmn(_ & f | m & ~f, d, _, r, i, n) } function md5_hh(d, _, m, f, r, i, n) { return md5_cmn(_ ^ m ^ f, d, _, r, i, n) } function md5_ii(d, _, m, f, r, i, n) { return md5_cmn(m ^ (_ | ~f), d, _, r, i, n) } function safe_add(d, _) { var m = (65535 & d) + (65535 & _); return (d >> 16) + (_ >> 16) + (m >> 16) << 16 | 65535 & m } function bit_rol(d, _) { return d << _ | d >>> 32 - _ } 