$(function () {

  var typeOfItem = $('[name="itemType"]')
  var modulePackage = $('[name="type"]')
  var authTrigger = $('[name="authentication"]')
  var paidRadio = $('[name="paid"]')
  var buttonSubmit = $('#submit-form')
  var itemForm = $('#form-item')
  var uploadScreenshotEl = $('#screenshot')

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
      $('#load_events-element').css('display', 'block')
    } else {
      $('#load_events-element').css('display', 'none')
    }
  }

  // enable scope of authentication
  // when application is required
  var enableScope = function () {
    if (parseInt($(this).val()) === 1) {
      $('#autentication_callback-element').css('display', 'block')
    } else {
      $('#autentication_callback-element').css('display', 'none')
    }
  }

  // enable plans form 
  // if application is pain
  var enablePlans = function () {
    if (parseInt($(this).val()) === 1) {
      $('#plans-element').css('display', 'block')
    } else {
      $('#plans-element').css('display', 'none')
    }
  }

  // append new input on plans form
  var appendPlansInput = function () {

  }

  // destroy plan input
  var destroyPlansInput = function () {

  }

  // verify if required input has value
  var verifyForm = function () {
    itemForm.find('select, textarea, input').each(function () {
      if (!$(this).prop('required')) {

      } else {
        if (!$(this).val()) {
          console.log($(this).attr('name'))
          $(this).addClass('is-invalid')
        }
      }
    })
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
          }).appendTo(imageHolder)
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
  /**
   * handle events
   */
  typeOfItem.on('change', setItemType)
  modulePackage.on('change', enableModules)
  modulePackage.on('change', enableLoadEvents)
  authTrigger.on('change', enableScope)
  paidRadio.on('change', enablePlans)
  buttonSubmit.on('click', verifyForm)
  uploadScreenshotEl.on('change', updateUploadQueue)
});