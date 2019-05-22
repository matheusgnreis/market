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
  var appAdminSettings = {}

  var showToast = function (text) {
    var toast = document.getElementById('admin-toast');
    toast.className = 'show';
    toast.textContent = text
    setTimeout(function () { toast.className = toast.className.replace('show', ''); }, 3000);
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
            <td class='app-status-${(application.state !== 'inactive' ? 'active' : 'disable')}'><span>${(application.state === 'active' ? 'Ativo' : 'Inativo')}</span></td>
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

  var accordions = function (accordionsRoot, dataType, settingsType, settingsId, settingsTitle) {
    var accordion = `<div class="accordion accordion-arrow-right accordion-light" id="accordion-${settingsId}" data-type="${settingsType}" data-id="${settingsId}" style="margin-bottom: 1em;">
      <div class="card">
        <h5 class="card-title">
          <a data-toggle="collapse" href="#collapse-${settingsId}-1">${settingsTitle}</a>
        </h5>
        <div id="collapse-${settingsId}-1" class="collapse" data-parent="#accordion-${settingsId}">
          <div class="card-body-${settingsType}-${settingsId}" id="card-body-${settingsType}-${settingsId}"></div>
          <div class="accordion-actions">
          <button class="btn btn-sm btn-round btn-success account-action" data-app="${dataType}" data-type="${settingsType}" data-id="${settingsId}" data-title="${settingsTitle}" >Salvar</button>
          </div>
        </div>
      </div>
    </div>`
    $(accordion).appendTo(accordionsRoot)
    return `card-body-${settingsType}-${settingsId}`
  }

  // render brutusin forms
  var renderForms = function (application) {
    var updateObjEl = document.getElementById('application-basic-settings')
    var formHiddenDataEl = document.getElementById('application-advanced-settings')
    var appSettings = application.admin_settings
    var showAdvancedSettingsTab = false
    var showBasicSettingsTab = false
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
          var appHiddenData = (application.hasOwnProperty('hidden_data') && typeof application.hidden_data[key] !== 'undefined') ? application.hidden_data[key] : null
          console.log(appHiddenData)
          switch (setting.schema.type) {
            case 'array':
            case 'object':
              var accordionEl = accordions(formHiddenDataEl, 'hidden_data', 'advanced', key, setting.schema.title)
              bf['hidden_data'] = bf['hidden_data'] || []
              bf['hidden_data']['advanced'] = bf['hidden_data']['advanced'] || []
              bf['hidden_data']['advanced'][key] = bf['hidden_data']['advanced'][key] || []
              bf['hidden_data']['advanced'][key] = BrutusinForms.create(jsonShemaHeader([setting.schema]));
              bf['hidden_data']['advanced'][key].render(document.getElementById(accordionEl), [appHiddenData]);
              showAdvancedSettingsTab = true
              break;
            default:
              var accordionEl = accordions(formHiddenDataEl, 'hidden_data', 'basic', key, setting.schema.title)
              bf['hidden_data'] = bf['hidden_data'] || []
              bf['hidden_data']['basic'] = bf['hidden_data']['basic'] || []
              bf['hidden_data']['basic'][key] = bf['hidden_data']['basic'][key] || []
              bf['hidden_data']['basic'][key] = BrutusinForms.create(jsonShemaHeader(jsonShemaHeader(setting.schema)));
              bf['hidden_data']['basic'][key].render(document.getElementById(accordionEl), [appHiddenData]);
              showAdvancedSettingsTab = true
              break;
          }
        } else {
          // data
          var appData = (application.hasOwnProperty('data') && typeof application.data[key] !== 'undefined') ? application.data[key] : null
          switch (setting.schema.type) {
            case 'array':
            case 'object':
              var accordionEl = accordions(updateObjEl, 'data', 'advanced', key, setting.schema.title)
              bf['data'] = bf['data'] || []
              bf['data']['advanced'] = bf['data']['advanced'] || []
              bf['data']['advanced'][key] = bf['data']['advanced'][key] || []
              bf['data']['advanced'][key] = BrutusinForms.create(jsonShemaHeader([setting.schema]));
              bf['data']['advanced'][key].render(document.getElementById(accordionEl), [appData]);
              showBasicSettingsTab = true
              break;
            default:
              var accordionEl = accordions(updateObjEl, 'data', 'basic', key, setting.schema.title)
              bf['data'] = bf['data'] || []
              bf['data']['basic'] = bf['data']['basic'] || []
              bf['data']['basic'][key] = bf['data']['basic'][key] || []
              bf['data']['basic'][key] = BrutusinForms.create(jsonShemaHeader([setting.schema]));
              bf['data']['basic'][key].render(document.getElementById(accordionEl), (typeof appData !== 'boolean') ? [appData] : appData);
              showBasicSettingsTab = true
              break;
          }
        }
      }
    }

    if (showAdvancedSettingsTab === true) $('#tab-advanced').css({ 'display': 'block' })
    if (showBasicSettingsTab === true) $('#tab-basic').css({ 'display': 'block' })

    /* // basic settings data
    if (basicSettingsData !== null) {
      console.log(basicSettingsData)
      var accordionEl = accordions(updateObjEl, 'basic', 'basic', 'basic', 'Basico')
      bf['data'] = bf['data'] || []
      bf['data']['basic'] = bf['data']['basic'] || []
      bf['data']['basic'] = BrutusinForms.create(jsonShemaHeader(basicSettingsData));
      bf['data']['basic'].render(document.getElementById(accordionEl), application.data);
    }

    if (basicSettingsHidden !== null) {
      // basic settings hidden_data

      var accordionEl = accordions(formHiddenDataEl, 'data', 'basic', 'hidden_data', 'Basico')
      bf['hidden_data'] = bf['hidden_data'] || []
      bf['hidden_data']['basic'] = bf['hidden_data']['basic'] || []
      bf['hidden_data']['basic'] = BrutusinForms.create(jsonShemaHeader(basicSettingsHidden));
      bf['hidden_data']['basic'].render(document.getElementById(accordionEl), application.data);
    } */
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
            appAdminSettings = application.admin_settings
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

  // update application
  $(document).on('click', '.account-action', function (e) {

    var buttonData = $(this).data()
    var appId = $('.main-content').data('app-id')
    var subresource = buttonData.app
    var dataKey = buttonData.id
    var accordionTitle = buttonData.title
    var parseData = {}
    var formData = bf[buttonData.app][buttonData.type][buttonData.id].getData()
    parseData[dataKey] = (formData !== null) ? formData[0] : null
    var body = { ...setSchemaNull(dataKey), ...parseData }
    //
    patchApplication(appId, subresource, body)
      .done(showToast(accordionTitle + ' atualizado.'))
      .fail(function (xhr) {
        console.log('Request fail:', xhr)
      })
    e.preventDefault()
  })

  var patchApplication = function (appId, subresource, body) {
    return $.ajax({
      type: 'PATCH',
      url: ecomApiPath + 'applications/' + appId + '/' + subresource + '.json',
      dataType: 'json',
      contentType: 'application/json; charset=utf-8',
      headers: requestHeader,
      data: JSON.stringify(body)
    })
  }

  var setSchemaNull = function (chave) {
    var obj = {}
    for (const key in appAdminSettings) {
      if (appAdminSettings.hasOwnProperty(key)) {
        const element = appAdminSettings[key];
        obj[chave] = {}
      }
    }
    return obj
  }
});