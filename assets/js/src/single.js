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

  var path_login = 'https://api.e-com.plus/v1/_login.json?username'
  var path_send_app = 'https://api.e-com.plus/v1/applications.json'
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
   * Check if has sso login setted up and install application on store_id
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