/** 
 * 
 */
$(function () {
  var myId = '5b1abe30a4d4531b8fe40726'
  var token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiI1YjFhYmUzMGE0ZDQ1MzFiOGZlNDA3MjYiLCJjb2QiOjkyODY2NzAyLCJleHAiOjE1NTE0NjQwNTIwNTJ9.AmpJMTjJkz0xYupYFZi1WFmkeeJ7EoRH2vRlCE_7BzA'
  var storeId = 1011
  var applicationPathEcomP = 'https://api.e-com.plus/v1/applications.json'
  var applicationPathMarket = '/v1/applications'
  var btnTrigger = $('a.btn.btn-lg.btn-primary.account-action')
  var bf = null
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
          $('<input>', { type: 'checkbox', class: 'switch-input', checked: app.state === 'active' ? true : false }).appendTo(switcher)
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
              bf = brutusin['json-forms'].create(json.json_body)

              let datas = []

              if (app.data || app.hidden_data) {
                datas.data = app.data
                datas.hidden_data = app.hidden_data
              }

              bf.render(editBody, datas)
              // if not has json_body removes acordion body
              if (!json.json_body) {
                editBody.remove()
                console.log(editBody)
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
    console.log(bf.getData())
  }

  /**
   * 
   */
  var lojApplications = function () {
    var query = '?fields=_id,app_id,title,state,updated_at,data,hidden_data'
    return $.ajax({
      type: 'GET',
      url: applicationPathEcomP + query,
      dataType: 'json',
      headers: {
        'X-Store-ID': storeId,
        'X-Access-Token': token,
        'X-My-Id': myId
      }
    })
  }

  /**
   * 
   */
  lojApplications()
    .done(function (apps) {
      components.applications(apps.result)
    })

  /**
   * hanndle all clicks
   */
  $(document).on('click', '.account-action', handleForm)
})