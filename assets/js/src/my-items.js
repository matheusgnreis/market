$(function () {

  var typeOfItem = $('[name="itemType"]')
  var modulePackage = $('[name="type"]')
  var authTrigger = $('[name="authentication"]')

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

  // enable scope of authentication
  // when application is required
  var enableScope = function () {
    if (parseInt($(this).val()) === 1) {
      $('#autentication_callback-element').css('display', 'block')
    } else {
      $('#autentication_callback-element').css('display', 'none')
    }
  }

  /**
   * 
   */
  typeOfItem.on('change', setItemType)
  modulePackage.on('change', enableModules)
  authTrigger.on('change', enableScope)
});