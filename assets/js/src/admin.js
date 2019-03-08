/** 
 * 
 */
$(function () {
  var myId = null
  var token = null
  var storeId = null
  var sso = null
  var ecomApiPath = 'https://api.e-com.plus/v1/'
  var applicationPathMarket = '/v1/applications'
  var bf = []
  /**
   * 
   */
  var components = {
    /**
     * 
     */
    applications: function (apps) {

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

  /**
   * 
   * @param {*} event 
   */
  var getAppData = function (appId) {
    return $.ajax({
      type: 'GET',
      url: applicationPathMarket + '/' + appId,
      dataType: 'json'
    })
  }

  var handleForm = function () {
    var formId = $(this).data('appId')
    var applicationId = $(this).data('application')
    console.log(applicationId)
    console.log()
    var formData = bf[formId].getData()
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
  }

  var updateApplication = function (id, data, subresource = '') {
    return $.ajax({
      type: 'PATCH',
      url: ecomApiPath + 'applications/' + id + subresource + '.json',
      dataType: 'json',
      contentType: 'application/json; charset=utf-8',
      headers: {
        'X-Store-ID': storeId,
        'X-Access-Token': token,
        'X-My-Id': myId
      },
      data: JSON.stringify(data)
    })
  }

  /**
   * 
   */
  var lojApplications = function () {
    var query = '?fields=_id,app_id,title,state,updated_at,data,hidden_data'
    return $.ajax({
      type: 'GET',
      url: ecomApiPath + 'applications.json' + query,
      dataType: 'json',
      headers: {
        'X-Store-ID': storeId,
        'X-Access-Token': token,
        'X-My-Id': myId
      }
    })
  }

  var changeApplicationState = function () {
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
      headers: {
        'X-Store-ID': storeId,
        'X-Access-Token': token,
        'X-My-Id': myId
      },
      data: JSON.stringify(dataChange)
    })
  }

  var init = function (callback) {
    storeId = window.localStorage.getItem('store_id') || storeId
    myId = window.localStorage.getItem('myId') || myId
    token = window.localStorage.getItem('sso_logged') || token
    sso = window.localStorage.getItem('sso_logged') || sso

    if (!storeId || !myId || !token || !sso) {
      window.location.href = '/'
    } else {
      console.log('user logged')
      return callback()
    }
  }

  /**
   * 
   */

  if ($('#admin-main').length) {
    init(function () {
      setTimeout(function () {
        console.log('body show')
        $('body').css({ display: 'block' })
        lojApplications()
          .done(function (apps) {
            components.applications(apps.result)
          })
      }, 2000)
    })
  }

  /**
   * hanndle all clicks
   */
  $(document).on('click', '.account-action', handleForm)

  /**
   * 
   */
  $(document).on('change', '.switch-input', changeApplicationState)

  //
})