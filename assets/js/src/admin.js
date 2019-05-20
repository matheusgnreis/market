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

  // render brutusin forms
  var renderForms = function (application) {
    var formDataEl = document.getElementById('application-basic-settings')
    var formHiddenDataEl = document.getElementById('application-advanced-settings')
    var appSettings = application.admin_settings
    var basicSettingsData = null
    var basicSettingsHidden = null
    var jsonShemaHeader = function (properties) {
      return {
        '$schema': 'http://json-schema.org/draft-07/schema#',
        'type': 'object',
        'properties': properties
      }
    }

    var BrutusinForms = brutusin["json-forms"];
    // percorre admin settings
    for (const key in appSettings) {
      if (appSettings.hasOwnProperty(key)) {
        const setting = appSettings[key]
        // hidden_data
        if (setting.hasOwnProperty('hide') && setting.hide === true) {
          switch (setting.schema.type) {
            case 'array':
            case 'object':
              bf['hidden_data'] = bf['hidden_data'] || []
              bf['hidden_data']['advanced'] = bf['hidden_data']['advanced'] || []
              bf['hidden_data']['advanced'][key] = bf['hidden_data']['advanced'][key] || []
              bf['hidden_data']['advanced'][key] = BrutusinForms.create(jsonShemaHeader([setting.schema]));
              bf['hidden_data']['advanced'][key].render(formHiddenDataEl, [application.hidden_data[key]]);
              break;
            default:
              // bf['hidden_data'] = bf['hidden_data'] || []
              // bf['hidden_data']['basic'] = bf['hidden_data']['basic'] || []
              // bf['hidden_data']['basic'][key] = bf['hidden_data']['basic'][key] || []
              // bf['hidden_data']['basic'][key] = BrutusinForms.create(jsonShemaHeader([setting.schema]));
              // bf['hidden_data']['basic'][key].render(formHiddenDataEl, [application.hidden_data[key]]);
              //
              basicSettingsHidden = basicSettingsHidden || []
              basicSettingsHidden[key] = basicSettingsHidden[key] || []
              basicSettingsHidden[key] = setting.schema
              break;
          }
        } else {
          // data
          switch (setting.schema.type) {
            case 'array':
            case 'object':
              bf['data'] = bf['data'] || []
              bf['data']['advanced'] = bf['data']['advanced'] || []
              bf['data']['advanced'][key] = bf['data']['advanced'][key] || []
              bf['data']['advanced'][key] = BrutusinForms.create(jsonShemaHeader([setting.schema]));
              bf['data']['advanced'][key].render(formDataEl, [application.data[key]]);
              break;
            default:
              // bf['data'] = bf['data'] || []
              // bf['data']['basic'] = bf['data']['basic'] || []
              // bf['data']['basic'][key] = bf['data']['basic'][key] || []
              // bf['data']['basic'][key] = BrutusinForms.create(jsonShemaHeader([setting.schema]));
              // bf['data']['basic'][key].render(formDataEl, application.data[key]);
              //
              basicSettingsData = basicSettingsData || []
              basicSettingsData[key] = basicSettingsData[key] || []
              basicSettingsData[key] = setting.schema
              break;
          }
        }
      }
    }

    // basic settings data
    if (basicSettingsData !== null) {
      bf['data'] = bf['data'] || []
      bf['data']['basic'] = bf['data']['basic'] || []
      bf['data']['basic'] = BrutusinForms.create(jsonShemaHeader(basicSettingsData));
      bf['data']['basic'].render(formDataEl, application.data);
    }

    if (basicSettingsHidden !== null) {
      // basic settings hidden_data
      console.log(basicSettingsHidden)
      console.log(typeof basicSettingsHidden)
      bf['hidden_data'] = bf['hidden_data'] || []
      bf['hidden_data']['basic'] = bf['hidden_data']['basic'] || []
      bf['hidden_data']['basic'] = BrutusinForms.create(jsonShemaHeader(basicSettingsHidden));
      bf['hidden_data']['basic'].render(formHiddenDataEl, application.hidden_data);
    }
  }

  // get single application
  var getAppApi = function (applicationId) {
    return $.ajax({
      type: 'GET',
      url: ecomApiPath + 'applications/' + applicationId + '.json',
      dataType: 'json',
      headers: requestHeader
    })
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