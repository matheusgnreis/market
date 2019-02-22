$(document).ready(function () {
  //
  var apiPath = '/v1/applications/'
  var appId = $('#app-resume').data('id')
  var btnInstall = $('.request-install')
  var btnLogin = $('#btn-ecom-login')
  var btnConfirmeInstallation = $('#btn-confirmation')
  var appData
  var token
  var myId

  //

  var path_login = 'https://api.e-com.plus/v1/_login.json?username';
  var path_send_app = 'https://api.e-com.plus/v1/applications.json';
  //
  var elements = {
    plans: $('#application-plans'),
    comments: $('#application-comments'),
    description: $('#application-description')
  }

  /**
   * 
   * @param {*} application 
   */
  var initComponents = function (application) {
    //
    components.comments(application)
    //
    components.plans(application)
    //
    components.description(application)
    //
    components.scope(application)

    // set current application data global
    appData = application

    // check if application had
    // installation request
    hasApplicationToInstall()
  }

  /**
   * 
   */
  var components = {
    /**
     * 
     * @param {*} application 
     */
    comments: function (application) {
      //
      if (window.location.pathname.split('/')[1] === 'pt_br') {
        moment.locale('pt-br')
      }

      var commentsContainer = $('<div>', { class: 'container' })
      var commentsRow = $('<div>', { class: 'row' })
      var commentsCol = $('<div>', { class: 'col-12' })
      var mediaList = $('<div>', { class: 'media-list' })
      //
      var commentsList = $.map(application.comments, function (comment, key) {

        var media = $('<div>', { class: 'media' })
        var mediaBody = $('<div>', { class: 'media-body' })
        var commentsInfo = $('<div>', { class: 'small-1' })

        $('<strong>', { text: comment.name }).appendTo(commentsInfo)
        $('<time>', { class: 'ml-4 opacity-70 small-3', text: moment(comment.date_time).fromNow() }).appendTo(commentsInfo)

        //
        $(commentsInfo).appendTo(mediaBody)
        //
        $('<p>', { class: 'small-2 mb-0', text: comment.comment }).appendTo(mediaBody)
        //
        $(mediaBody).appendTo(media)

        return media

      })

      // button public a comment
      var publishCommentCol = $('<div>', { class: 'col-12 publish-comment-col' })
      var buttonComment = $('<a>', { class: 'btn btn-block btn-round btn-primary', id: 'publish-comment', text: 'Publicar um comentário' })
      buttonComment.appendTo(publishCommentCol)
      //
      mediaList.append(commentsList)
      commentsCol.append(mediaList)
      commentsRow.append(commentsCol)
      publishCommentCol.appendTo(commentsRow)
      commentsContainer.append(commentsRow)
      //
      elements.comments.html(commentsContainer)

    },
    /**
     * 
     * @param {*} application 
     */
    plans: function (application) {
      var plansContainer = $('<div>', { class: 'container' }).append($('<h2>', { text: 'Preços' }))

      var plansRow = $.map(application.plans_json, function (plan, key) {
        //
        var row = $('<a>', { class: 'row no-gutters pricing-4 app-prices' })
        //
        var planDescription = $('<div>', { class: 'col-9 col-sm-9 col-md-9 plan-description' })
        //
        $('<h5>', { text: plan.title }).appendTo(planDescription)
        $('<p>', { text: plan.description }).appendTo(planDescription)
        //$(planDescription).text(plan.description)
        //
        var planPrice = $('<div>', { class: 'col-3 col-sm-3 col-md-3 plan-price' })

        $('<h3>', { text: plan.value }).appendTo(planPrice)
        $('<p>', { text: plan.currency }).appendTo(planPrice)

        //
        row.append(planDescription)
        row.append(planPrice)

        return row
      })
      //
      plansContainer.append(plansRow)
      elements.plans.html(plansContainer)
    },
    /**
     * 
     * @param {*} application 
     */
    description: function (application) {
      elements.description.html(marked(application.description))
    },
    /**
     * 
     */
    scope: function (application) {
      if (application.auth_scope) {
        //
        var ulScope = $('<ul>', { class: 'scope-ul' })

        //
        for (const key in application.auth_scope) {

          var liScope = $('<li>', { class: 'scope-li' })
          var method = ''
          //
          $('<span>', { text: key }).appendTo(liScope)
          //
          application.auth_scope[key].sort()
          //
          for (var index = 0; index < application.auth_scope[key].length; index++) {
            //
            method += (index > 0) ? ', ' : ''
            method += translateMethod(application.auth_scope[key][index])
            //
          }
          $('<span>', { text: method }).appendTo(liScope)
          //
          liScope.appendTo(ulScope)
        }
        //
        $('#scope-list').append(ulScope)
      }
    }
  }

  var translateMethod = function (method) {
    switch (method) {
      case 'GET':
        return 'visualizar'
      case 'POST':
        return 'criar'
      case 'PUT':
        return 'alterar'
      case 'PATCH':
        return 'atualizar'
      case 'DELETE':
        return 'excluir'
      default:
        return ''
    }
  }

  var apiLogin = function () {
    return $.ajax({
      type: 'POST',
      url: path_login,
      headers: {
        'X-Store-ID': getCookie(document.cookie)['store_id']
      },
      data: JSON.stringify({
        username: $('#username').val(),
        pass_md5_hash: md_5($('#password').val())
      }),
      contentType: 'application/json',
      dataType: 'json'
    })
  }

  var apiAuthentication = function (json) {
    // keep store ID
    var storeId = json.store_id
    // authenticate
    return $.ajax({
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
  }
  /**
   * Check if has sso login setted up and install appplication on store_id
   */
  var installApplication = function () {
    var cookie = getCookie(document.cookie)

    if (!cookie['sso_logged']) {
      // save current in cookie
      // to send back at end of login process
      setCookie('prev_page', window.location.href, 1)

      // define if application must
      // install after go back to this page
      setCookie('installApp', appId)

      // redirect to request sso
      window.location.href = '/session/create'
    } else {
      console.log(cookie)
      $('[name="username"]').val(cookie['username'])
      $('#modal-confirm-installation').modal('show')
    }
  }

  var requestLogin = function () {
    //

    apiLogin()
      .done(function (json) {
        apiAuthentication(json)
          .done(function (resp) {
            token = resp.access_token
            myId = resp.my_id
            $('#modal-confirm-installation').modal('hide')
            $('#modal-scope-installation').modal('show')
          })
      })
    /*   
    $.when(apiLogin(), apiAuthentication())
      .done(function (login, authenticate) {
        console.log(login)
        console.log(authenticate)
      })
      .fail(requestFail) */
  }

  var confirmeInstallation = function () {
    console.log('Installing Application..', appId)
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
      url: path_send_app,
      headers: {
        'X-Store-ID': getCookie(document.cookie)['store_id'],
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
            var url = appData.redirect_uri + '?x_store_id=' + getCookie(document.cookie)['store_id']
            window.open(url, '_blank', 'location=yes,width=900,scrollbars=yes,status=yes')
          }
        }, 1000)
        $('#modal-scope-installation').modal('hide')
      }
    }).fail(requestFail)
  }

  var hasApplicationToInstall = function () {
    var cookie = getCookie(document.cookie)

    if (cookie['installApp'] && (parseInt(cookie['installApp']) === appId)) {
      // request installation
      installApplication()
      // delete cookie
      deleteCookie('installApp')
    }
  }

  /**
   * 
   * @param {*} jqxhr 
   * @param {*} textStatus 
   * @param {*} error 
   */
  var requestFail = function (jqxhr, textStatus, error) {
    console.log(error)
  }

  btnInstall.on('click', installApplication)
  btnLogin.on('click', requestLogin)
  btnConfirmeInstallation.on('click', confirmeInstallation)
  /**
   * init
   */
  if (typeof appId === 'number' && isNaN(appId) === false) {
    $.getJSON(apiPath + appId)
      .done(initComponents)
      .fail(requestFail)
  }
})

function getCookie(cookie) {
  return cookie
    .trim()
    .split(';')
    .map(function (line) { return line.split(','); })
    .reduce(function (props, line) {
      var name = line[0].slice(0, line[0].search('='));
      var value = line[0].slice(line[0].search('='));
      props[name.trim()] = value.replace('=', '');
      return props;
    }, {})
}

function setCookie(name, value, days) {
  var expires = "";
  if (days) {
    var date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    expires = "; expires=" + date.toUTCString();
  }
  document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function deleteCookie(name) {
  document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

function md_5(d) { result = M(V(Y(X(d), 8 * d.length))); return result.toLowerCase() }; function M(d) { for (var _, m = "0123456789ABCDEF", f = "", r = 0; r < d.length; r++)_ = d.charCodeAt(r), f += m.charAt(_ >>> 4 & 15) + m.charAt(15 & _); return f } function X(d) { for (var _ = Array(d.length >> 2), m = 0; m < _.length; m++)_[m] = 0; for (m = 0; m < 8 * d.length; m += 8)_[m >> 5] |= (255 & d.charCodeAt(m / 8)) << m % 32; return _ } function V(d) { for (var _ = "", m = 0; m < 32 * d.length; m += 8)_ += String.fromCharCode(d[m >> 5] >>> m % 32 & 255); return _ } function Y(d, _) { d[_ >> 5] |= 128 << _ % 32, d[14 + (_ + 64 >>> 9 << 4)] = _; for (var m = 1732584193, f = -271733879, r = -1732584194, i = 271733878, n = 0; n < d.length; n += 16) { var h = m, t = f, g = r, e = i; f = md5_ii(f = md5_ii(f = md5_ii(f = md5_ii(f = md5_hh(f = md5_hh(f = md5_hh(f = md5_hh(f = md5_gg(f = md5_gg(f = md5_gg(f = md5_gg(f = md5_ff(f = md5_ff(f = md5_ff(f = md5_ff(f, r = md5_ff(r, i = md5_ff(i, m = md5_ff(m, f, r, i, d[n + 0], 7, -680876936), f, r, d[n + 1], 12, -389564586), m, f, d[n + 2], 17, 606105819), i, m, d[n + 3], 22, -1044525330), r = md5_ff(r, i = md5_ff(i, m = md5_ff(m, f, r, i, d[n + 4], 7, -176418897), f, r, d[n + 5], 12, 1200080426), m, f, d[n + 6], 17, -1473231341), i, m, d[n + 7], 22, -45705983), r = md5_ff(r, i = md5_ff(i, m = md5_ff(m, f, r, i, d[n + 8], 7, 1770035416), f, r, d[n + 9], 12, -1958414417), m, f, d[n + 10], 17, -42063), i, m, d[n + 11], 22, -1990404162), r = md5_ff(r, i = md5_ff(i, m = md5_ff(m, f, r, i, d[n + 12], 7, 1804603682), f, r, d[n + 13], 12, -40341101), m, f, d[n + 14], 17, -1502002290), i, m, d[n + 15], 22, 1236535329), r = md5_gg(r, i = md5_gg(i, m = md5_gg(m, f, r, i, d[n + 1], 5, -165796510), f, r, d[n + 6], 9, -1069501632), m, f, d[n + 11], 14, 643717713), i, m, d[n + 0], 20, -373897302), r = md5_gg(r, i = md5_gg(i, m = md5_gg(m, f, r, i, d[n + 5], 5, -701558691), f, r, d[n + 10], 9, 38016083), m, f, d[n + 15], 14, -660478335), i, m, d[n + 4], 20, -405537848), r = md5_gg(r, i = md5_gg(i, m = md5_gg(m, f, r, i, d[n + 9], 5, 568446438), f, r, d[n + 14], 9, -1019803690), m, f, d[n + 3], 14, -187363961), i, m, d[n + 8], 20, 1163531501), r = md5_gg(r, i = md5_gg(i, m = md5_gg(m, f, r, i, d[n + 13], 5, -1444681467), f, r, d[n + 2], 9, -51403784), m, f, d[n + 7], 14, 1735328473), i, m, d[n + 12], 20, -1926607734), r = md5_hh(r, i = md5_hh(i, m = md5_hh(m, f, r, i, d[n + 5], 4, -378558), f, r, d[n + 8], 11, -2022574463), m, f, d[n + 11], 16, 1839030562), i, m, d[n + 14], 23, -35309556), r = md5_hh(r, i = md5_hh(i, m = md5_hh(m, f, r, i, d[n + 1], 4, -1530992060), f, r, d[n + 4], 11, 1272893353), m, f, d[n + 7], 16, -155497632), i, m, d[n + 10], 23, -1094730640), r = md5_hh(r, i = md5_hh(i, m = md5_hh(m, f, r, i, d[n + 13], 4, 681279174), f, r, d[n + 0], 11, -358537222), m, f, d[n + 3], 16, -722521979), i, m, d[n + 6], 23, 76029189), r = md5_hh(r, i = md5_hh(i, m = md5_hh(m, f, r, i, d[n + 9], 4, -640364487), f, r, d[n + 12], 11, -421815835), m, f, d[n + 15], 16, 530742520), i, m, d[n + 2], 23, -995338651), r = md5_ii(r, i = md5_ii(i, m = md5_ii(m, f, r, i, d[n + 0], 6, -198630844), f, r, d[n + 7], 10, 1126891415), m, f, d[n + 14], 15, -1416354905), i, m, d[n + 5], 21, -57434055), r = md5_ii(r, i = md5_ii(i, m = md5_ii(m, f, r, i, d[n + 12], 6, 1700485571), f, r, d[n + 3], 10, -1894986606), m, f, d[n + 10], 15, -1051523), i, m, d[n + 1], 21, -2054922799), r = md5_ii(r, i = md5_ii(i, m = md5_ii(m, f, r, i, d[n + 8], 6, 1873313359), f, r, d[n + 15], 10, -30611744), m, f, d[n + 6], 15, -1560198380), i, m, d[n + 13], 21, 1309151649), r = md5_ii(r, i = md5_ii(i, m = md5_ii(m, f, r, i, d[n + 4], 6, -145523070), f, r, d[n + 11], 10, -1120210379), m, f, d[n + 2], 15, 718787259), i, m, d[n + 9], 21, -343485551), m = safe_add(m, h), f = safe_add(f, t), r = safe_add(r, g), i = safe_add(i, e) } return Array(m, f, r, i) } function md5_cmn(d, _, m, f, r, i) { return safe_add(bit_rol(safe_add(safe_add(_, d), safe_add(f, i)), r), m) } function md5_ff(d, _, m, f, r, i, n) { return md5_cmn(_ & m | ~_ & f, d, _, r, i, n) } function md5_gg(d, _, m, f, r, i, n) { return md5_cmn(_ & f | m & ~f, d, _, r, i, n) } function md5_hh(d, _, m, f, r, i, n) { return md5_cmn(_ ^ m ^ f, d, _, r, i, n) } function md5_ii(d, _, m, f, r, i, n) { return md5_cmn(m ^ (_ | ~f), d, _, r, i, n) } function safe_add(d, _) { var m = (65535 & d) + (65535 & _); return (d >> 16) + (_ >> 16) + (m >> 16) << 16 | 65535 & m } function bit_rol(d, _) { return d << _ | d >>> 32 - _ }