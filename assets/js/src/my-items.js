$(function () {

  var typeOfItem = $('[name="itemType"]')
  var modulePackage = $('[name="type"]')
  var authTrigger = $('[name="authentication"]')
  var paidRadio = $('[name="paid"]')
  var buttonSubmit = $('#submit-form')
  var itemForm = $('#form-item')
  var uploadScreenshotEl = $('#screenshot')
  var slugInput = $('[name="slug"]')
  var plansForm = $('#form-plans')
  var addPlanButton = $('#add-plan')
  var buttonSubmitScope = $('#submit-scope')
  var scopeForm = $('#form-scope')
  var iconFile = $('#iconFile')
  var screenshotFiles = $('#screenshot')
  var applicationDataInput = $('[name="app_data"]')
  var applicationHiddenDataInput = $('[name="hidden_data"]')
  var buttonSaveAppData = $('#save-data-app')
  var appData
  var appHiddenData

  // globals
  var iconFileUpload
  var screenshotFilesUpload
  var appId

  // set localStorage to plan
  var storagePlans = window.localStorage.getItem('plans')
  storagePlans = JSON.parse(storagePlans)
  if (storagePlans == null) {
    storagePlans = []
  }

  // enable forms input
  var setItemType = function () {
    console.log($(this).val())
  }

  // enable modules when
  // appType is type of module_package
  var enableModules = function () {
    if ($(this).val() === 'module_package') {
      $('#module_type').css('display', 'block')
    } else {
      $('#module_type').css('display', 'none')
    }
  }

  // enable load events
  var enableLoadEvents = function () {
    if ($(this).val() === 'dashboard' || $(this).val() === 'storefront') {
      $('#load_events').prop('disabled', false)
    } else {
      $('#load_events').prop('disabled', true)
    }
  }

  // enable scope of authentication
  // when application is required
  var enableScope = function () {
    if (parseInt($(this).val()) === 1) {
      $('[name="auth_callback_uri"]').prop('disabled', false)
      $('#btn-scope').prop('disabled', false)
      $('[name="redirect_uri"]').attr('required', true)
    } else {
      $('[name="auth_callback_uri"]').prop('disabled', true)
      $('#btn-scope').prop('disabled', true)
      $('[name="redirect_uri"]').removeAttr('required')
    }
  }

  //
  var setScope = function () {
    $('#auth_scope').val(JSON.stringify(scopeForm.serializeObject()))
    console.log(JSON.stringify(scopeForm.serializeObject()))
  }

  // enable plans form 
  // if application is pain
  var enablePlans = function () {
    if (parseInt($(this).val()) === 1) {
      $('#btn-plans').prop('disabled', false)
    } else {
      $('#btn-plans').prop('disabled', true)
    }
  }

  // append new input on plans form
  var appendPlans = function () {
    var inputs = verifyForm(plansForm)
    console.log($('[name="title"]').val())
    if (inputs.length <= 0) {
      var plan = JSON.stringify({
        id: $('[name="id"]').val(),
        title: $('[name="title"]').val(),
        value: $('[name="value"]').val(),
        frequency: $('[name="frequency"]').val()
      })
      storagePlans.push(plan)
      window.localStorage.setItem('plans', JSON.stringify(storagePlans))
      // incrment input id
      $('[name="id"]').val(parseInt($('[name="id"]').val()) + 1)

      // set value at plans_json
      $('#plans_json').val(JSON.stringify(storagePlans))

      // clean form
      clearForm(plansForm)
    }
  }

  // destroy plan input
  var removePlans = function () {

  }

  // verify if required input has value
  var verifyForm = function (form) {
    var hasInputRequiredNotInformed = []
    form.find('select, textarea, input').each(function () {
      if ($(this).prop('required')) {
        $(this).removeClass('is-invalid')
        if (!$(this).val()) {
          console.log($(this).attr('name'))
          $(this).addClass('is-invalid')
          $(this).focus()
          hasInputRequiredNotInformed.push($(this).attr('name'))
        }
      }
    })
    return hasInputRequiredNotInformed
  }

  var sendItemForm = function () {

    // verify if has any required input empty on form
    var inputRequired = verifyForm(itemForm)
    // if not has
    if (inputRequired.length <= 0) {
      switch (typeOfItem.val()) {
        case 'app':

          // upload icon to get url
          uploadIcon()
            .done(function (upload) {

              // set icon path at input
              $('[name="icon"]').val(upload['0'].name)

              // send post to create a app
              var formData = itemForm.serializeArray()
              request('POST', '/v1/applications', formData)
                .done(function (response) {
                  appId = response.app_id
                  uploadScreenshots()
                    .done(function () {
                      clearForm(itemForm)
                      clearForm(plansForm)
                      clearForm(scopeForm)
                      $('#upload-queue').empty()
                    })
                    .fail(function (xhr) {
                      console.log('Screenshot upload failed.', xhr)
                    })
                })
                .fail(function (xhr) {
                  console.log('Erro with market api request! ', xhr)
                  if (xhr.status >= 400) {
                    $.map(xhr.responseJSON.erros, function (erro, key) {
                      $('#popup-erros-content').append($('<div>', { text: erro.property + ' ' + erro.user_message }))
                    })
                    $('#popup-erros').addClass('show')
                  }
                  //
                })
            })
            .fail(function (xhr) {
              console.log('Icon upload failed.', xhr)
            })
          break;
        case 'theme':
          break;
        default:
          break;
      }
    }
  }

  // update upload queue
  var updateUploadQueue = function () {
    let fileInput = $(this)[0].files
    let filesLenght = $(fileInput).length
    let valid = /(\.jpg|\.png|\.gif)$/i
    let name = $(this).get(0).files['0'].name

    $('#upload-count').text(0)
    $('#upload-queue').html()

    if (!valid.test(name)) {
      console.log('Formato inválido.')
      cleanInputFile(this)
      return
    }

    if (filesLenght > 6) {
      console.log('Máximo 6 imagens.')
      cleanInputFile(this)
      return
    }

    if (typeof (FileReader) != 'undefined') {

      var imageHolder = $('#upload-queue')
      //imageHolder.empty()

      for (let i = 0; i < filesLenght; i++) {
        var reader = new FileReader()
        reader.onload = function (e) {
          $('<img/>', {
            'src': e.target.result,
            'id': 'thumb_' + i,
            'class': 'thumb-image'
          }).fadeIn().appendTo(imageHolder)
        }
        reader.readAsDataURL($(this)[0].files[i])
      }
      //imageHolder.show()

    } else {
      console.log('Navegador não suporta o preview das screenshots.')
    }
  }

  var cleanInputFile = function (selector) {
    selector = $(selector)
    selector.replaceWith(selector.val('').clone(true))
  }

  var checkSlug = function () {
    var slug = $(this).val()
    setTimeout(function () {
      if (slugInput.val() === slug) {
        $.ajax({
          type: 'GET',
          url: '/v1/applications',
          data: 'slug=' + slug,
          beforeSend: function () {
            console.log('Checando', slug)
          },
          success: function (data) {
            if (data.result.length) {
              console.log(data)
              slugInput.addClass('is-invalid')
              slugInput.removeClass('is-valid')
            } else {
              slugInput.addClass('is-valid')
              slugInput.removeClass('is-invalid')
            }
          }
        })
      }
    }, 1000)
  }

  var uploadIcon = function () {
    var options = {
      url: '/uploads?type=icon',
      data: iconFileUpload,
      processData: false,
      contentType: false,
      method: 'POST'
    }
    return $.ajax(options)
  }

  //
  var uploadScreenshots = function () {
    var options = {
      url: '/uploads?type=screenshots&item=app&item_id=' + appId,
      data: screenshotFilesUpload,
      processData: false,
      contentType: false,
      method: 'POST'
    }
    return $.ajax(options)
  }

  // request api
  var request = function (method, resource, data) {
    var options = {
      type: method,
      url: resource,
      dataType: 'json'
    }
    if (method != 'GET') {
      options.data = data
    }
    return $.ajax(options)
  }

  var clearForm = function (form) {
    form.each(function (index, element) {
      $(element).find('input, textarea, select').val('')
    })
  }

  var appDataToJson = function () {
    try {
      appData = JSON.parse($(this).val())
      var editor = new JsonEditor('#json-data-parse', appData)
      editor.load(appData)
    } catch (ex) {
      return ex
    }
  }

  var appHiddenDataToJson = function () {
    try {
      appHiddenData = JSON.parse($(this).val())
      console.log(appHiddenData)
      var editor = new JsonEditor('#json-hidden-data-parse', appHiddenData)
      editor.load(appHiddenData)
    } catch (ex) {
      return ex
    }

  }

  var setAppData = function () {
    try {
      var data = {}

      if (appData) {
        data.data = appData
        console.log(data)
      }

      if (appHiddenData) {
        data.hidden_data = appHiddenData
        console.log(data)
      }

      if (data) {
        $('[name="json_body"]').val(JSON.stringify(data))
      }
    } catch (error) {
      console.log('Erro com o Json Schema' + error)
    }
  }

  $.fn.serializeObject = function () {
    var o = {}
    var a = this.serializeArray()
    $.each(a, function () {
      if (o[this.name.replace('[]', '')]) {
        if (!o[this.name.replace('[]', '')].push) {
          o[this.name.replace('[]', '')] = [o[this.name.replace('[]', '')]]
        }
        o[this.name.replace('[]', '')].push(this.value || '')
      } else {
        o[this.name.replace('[]', '')] = this.value || ''
      }
    })
    return o
  }
  /**
   * handle events
   */
  typeOfItem.on('change', setItemType)
  modulePackage.on('change', enableModules)
  modulePackage.on('change', enableLoadEvents)
  authTrigger.on('change', enableScope)
  paidRadio.on('change', enablePlans)
  buttonSubmit.on('click', sendItemForm)
  uploadScreenshotEl.on('change', updateUploadQueue)
  slugInput.on('keyup', checkSlug)
  addPlanButton.on('click', appendPlans)
  buttonSubmitScope.on('click', setScope)

  //
  iconFile.on('change', function (event) {
    iconFileUpload = new FormData()
    iconFileUpload.append('files', event.target.files[0])
  })
  //
  screenshotFiles.on('change', function (event) {
    screenshotFilesUpload = new FormData()
    for (var i = 0; i < event.target.files.length; i++) {
      var file = event.target.files[i];
      screenshotFilesUpload.append('files[]', file, file.name);
    }
    console.log(screenshotFilesUpload);
  })

  // data app change 
  applicationDataInput.on('change', appDataToJson)
  applicationHiddenDataInput.on('change', appHiddenDataToJson)
  buttonSaveAppData.on('click', setAppData)
});