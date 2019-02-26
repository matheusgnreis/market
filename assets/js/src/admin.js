/** 
 * 
 */
$(function () {

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
          var cardLink = $('<a>', { class: 'd-flex align-items-center', 'data-toggle': 'collapse', href: '#collapse-app-' + index })
          $('<strong>', { class: 'mr-auto', text: app.title }).appendTo(cardLink)
          $('<span>', { class: 'small text-lighter', text: app.state }).appendTo(cardLink)

          cardLink.appendTo(cardTitle)
          //
          var collapse = $('<div>', { id: 'collapse-app-' + index, class: 'collapse', 'data-parent': '#accordion-apps' })
          var cardBody = $('<div>', { class: 'card-body', id: 'card-body-' + app.app_id })

          cardBody.appendTo(collapse)
          // card body

          cardTitle.appendTo(card)
          collapse.appendTo(card)
          card.appendTo('#accordion-apps')

          $.when(getAppData(app.app_id))
            .done(function (json) {
              var BrutusinForms = brutusin['json-forms']
              bf = brutusin['json-forms'].create(json.json_body)
              var editBody = document.getElementById('card-body-' + app.app_id)
              let datas = []

              if (app.data || data.hidden_data) {
                datas.data = app.data
                datas.hidden_data = app.hidden_data
              }
              console.log(typeof datas)
              bf.render(editBody, datas)

              var btn = $('<p>').append($('<a>', { class: 'btn btn-lg btn-primary account-action', text: 'Alterar', 'data-app-id': app.app_id }))
              btn.appendTo(cardBody)
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