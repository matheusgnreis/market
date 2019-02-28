/** 
 * 
 */
$(function () {
  var myId = '5b1abe30a4d4531b8fe40726'
  var token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiI1YjFhYmUzMGE0ZDQ1MzFiOGZlNDA3MjYiLCJjb2QiOjkyODY2NzAyLCJleHAiOjE1NTEzNjY2ODYxNDV9.4Zcu4nfuDWGYWggZ5iwJfEW2KCdKHkmzfpI4qWMik_4'
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
        $.map(apps, function (app, index) {

          var card = $('<div>', { class: 'card' })
          var cardTitle = $('<h6>', { class: 'card-title' })

          //
          var cardLink = $('<a>', { class: 'd-flex align-items-center', 'data-toggle': 'collapse', href: '#collapse-app-' + app._id })
          $('<strong>', { class: 'mr-auto', text: app.title }).appendTo(cardLink)

          var switcher = $('<div>', { class: 'switch' })
          $('<input>', { type: 'checkbox', class: 'switch-input', checked: app.state === 'active' ? true : false }).appendTo(switcher)
          $('<label>', { class: 'switch-label', text: 'Ativo' }).appendTo(switcher)
          var span = $('<span>', { class: 'small text-lighter' })
          switcher.appendTo(span)
          span.appendTo(cardLink)
          cardLink.appendTo(cardTitle)
          //
          var collapse = $('<div>', { id: 'collapse-app-' + app._id, class: 'collapse', 'data-parent': '#accordion-apps' })
          var cardBody = $('<div>', { class: 'card-body', id: 'card-body-' + app.app_id })

          cardBody.appendTo(collapse)
          // card body

          cardTitle.appendTo(card)
          collapse.appendTo(card)
          card.appendTo('#accordion-apps')
          //
          var editBody = document.getElementById('card-body-' + app.app_id)
          $('#accordion-apps').hide()
          //
          $.when(getAppData(app.app_id))
            .done(function (json) {
              bf = brutusin['json-forms'].create(json.json_body)
              //var editBody = document.getElementById('card-body-' + app.app_id)
              let datas = []

              if (app.data || data.hidden_data) {
                datas.data = app.data
                datas.hidden_data = app.hidden_data
              }

              bf.render(editBody, datas)

              var btn = $('<p>').append($('<a>', { class: 'btn btn-lg btn-primary account-action', text: 'Alterar', 'data-app-id': app.app_id }))
              btn.appendTo(cardBody)
              $('#accordion-apps').slideDown()
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

  var listSettings = function (data) {

    var ul = $('<ul>', { class: 'settings-ul' })

    for (var key in data) {
      if (data.hasOwnProperty(key)) {
        switch (typeof data[key]) {
          case 'number':
          case 'string':
          case 'boolean':
            var li = $('<li>', { class: 'settings-list' })
            $('<span>', { class: 'span-key', text: key }).appendTo(li)
            $('<span>', { class: 'span-value', text: data[key] }).appendTo(li)
            li.appendTo(ul)
            break;
          case 'object':
            $(listSettings(data[key])).appendTo(ul)
            break
          default:
            break;
        }
      }
    }

    return ul

  }
  /**
   * 
   * @param {*} event 
   */
  var getAppData = function (appId) {
    return $.ajax({
      type: 'GET',
      url: applicationPathMarket + '/' + appId,
      data: 'data',
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