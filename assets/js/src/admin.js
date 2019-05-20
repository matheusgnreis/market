$(function () {
  //
  var ecomApiPath = 'https://api.e-com.plus/v1/'
  var bf = []
  var storeId = $('#admin-body').data('store')
  var my_id = $('#admin-body').data('my-id')
  var access_token = $('#admin-body').data('access')
  var requestHeader = {
    'X-Store-ID': storeId,
    'X-My-ID': my_id,
    'X-Access-Token': access_token
  }

  // table with resume of applications 
  var renderAplications = function (apps) {
    var myItemSection = $('#my-applications-list')
    var itemRow = $('<div>', { class: 'row' })
    var itemCol = $('<div>', { class: 'col' })
    var itemContainer = $('<div>', { class: 'container container-overflow-x' }).hide()
    //
    var tr = ''
    $.map(apps, function (application) {
      tr += `<tr>
            <td>${application.app_id}</td>
            <td>${application.title}</td>
            <td class='app-status-${(application.state ? 'active' : 'disable')}'><span>${(application.state === 'active' ? 'Ativo' : 'Inativo')}</span></td>
            <td>
              <div class='table-actions'>
                <ul>
                  <li><a href='/admin/applications/${application._id}/edit'>Editar </a></li>
                  <li><a href='/admin/applications/${application._id}/delete'>Excluir</a></li>
                </ul>
              </div>
            </td>
          </tr>`
    })
    let table = `<table class='table-hover' id='table-my-items-admin'>
      <thead>
        <tr>
          <th>#</th>
          <th>Titulo</th>
          <th>Status</th>
          <th>+</th>
        </tr>
      </thead>
      <tbody>
        ${tr}
      </tbody>
    </table>`

    itemCol.append(table)
    itemRow.append(itemCol)
    itemContainer.append(itemRow)
    $(itemContainer).appendTo(myItemSection)
    itemContainer.fadeIn('slow')
  }

  // get all store aplications
  var lojApplications = function () {
    var query = '?fields=_id,app_id,title,state,updated_at,data,hidden_data,icon'
    return $.ajax({
      type: 'GET',
      url: ecomApiPath + 'applications.json' + query,
      dataType: 'json',
      headers: requestHeader
    })
  }

  // handle page actions
  var adminActions = function () {
    switch ($('.main-content').data('action')) {
      case 'edit':
        var appId = $('.main-content').data('app-id')
        getAppApi(appId)
          .done(function (application) {
            renderForms(application)
          })
          .fail(function (e) {
            console.log('Ecomplus API Request fail', e)
          })
        console.log('Edit app:', appId)
        break;
      case 'showAll':
        lojApplications()
          .done(function (apps) {
            console.log('Render appplication list:', apps.result)
            renderAplications(apps.result)
          })
        break
      default:
        break;
    }

  }

  // init actions
  if ($('#admin-body').length) {
    adminActions()
  }
});