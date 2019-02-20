/** 
 * 
 */
$(function () {

  var sideLinks = $('.sidebar__links li')
  var partnerId = $('main').data('id')
  // var partnerAuth = $('main').data('token')

  var section = function () {

  }

  /**
   * 
   */
  var components = {
    /**
     * 
     * @param {*} data 
     */
    myItems: function (data) {
      var myItemSection = $('#my-items')
      var itemRow = $('<div>', { class: 'row' })
      var itemContainer = $('<div>', { class: 'container container-overflow-x' }).hide()
      //
      var items = $.map(data.applications, function (application) {
        var col = $('<div>', { class: 'col-md-3 col-lg-3 card-item-account' })
        var content = $('<div>', { class: 'item-content' })
        var img = $('<div>', { class: 'item-media' }).append($('<img>', { src: application.icon }))
        //
        var itemResume = $('<div>', { class: 'item-resume', title: 'Editar item', 'data-app-id': application.app_id, 'data-toggle': 'offcanvas', 'data-target': '#my-item-form' })
        $(img).appendTo(content)
        $($('<span>', { text: application.title })).appendTo(itemResume)
        $($('<span>', { text: application.category })).appendTo(itemResume)
        $($('<span>', { text: moment(application.version_date).fromNow() })).appendTo(itemResume)
        $(itemResume).appendTo(content)
        $(content).appendTo(col)
        return col
      })

      // itemCol.append(items)
      itemRow.append(items)
      itemContainer.append(itemRow)
      //myItemSection.html(itemContainer)
      $(itemContainer).appendTo(myItemSection)
      itemContainer.fadeIn('slow')
      console.log("My Item setted up.")
    }
  }

  var initComponents = function (data) {
    components.myItems(data)
  }

  var currentSection = function () {
    var current = $('section.account-sections.current-section')
    return current[0].id
  }

  var destroyCurrentSection = function () {
    $('section.account-sections.current-section').removeClass('current-section')
  }

  var setSection = function (sectionId) {
    $('#' + sectionId).addClass('current-section')
  }

  sideLinks.on('click', function () {
    // currentSection()
    destroyCurrentSection()
    setSection($(this).data('section'))
  })

  var getPatnerData = function () {
    var options = {
      type: 'GET',
      url: '/v1/partners/' + partnerId,
    }

    $.getJSON(options)
      .done(setPatnerData)
      .fail(function (xhr) {
        console.log('Erro with Market Api Request.', xhr)
      })
  }

  var setPatnerData = function (partner) {
    console.log(partner)
    initComponents(partner)
  }

  var init = function () {
    getPatnerData()
  }

  init()
})