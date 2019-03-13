$(function () {
  var apiPath = '/v1/widgets/'
  var widgetId = $('#app-resume').data('id')
  var components = {
    plans: function (application) {
      var plansContainer = $('<div>', { class: 'container' }).append($('<h2>', { text: 'Preços' }))

      var plansRow = $.map(application.plans_json, function (plan, key) {
        //
        var row = $('<a>', { class: 'row no-gutters pricing-4 app-prices' })
        //
        var planDescription = $('<div>', { class: 'col-9 col-sm-9 col-md-9 plan-description' })
        //
        $('<h5>', { text: plan.title }).appendTo(planDescription)
        $('<p>', { text: plan.description }).appendTo(planDescription)
        //$(planDescription).text(plan.description)
        //
        var planPrice = $('<div>', { class: 'col-3 col-sm-3 col-md-3 plan-price' })

        $('<h3>', { text: plan.value }).appendTo(planPrice)
        $('<p>', { text: plan.currency }).appendTo(planPrice)

        //
        row.append(planDescription)
        row.append(planPrice)

        return row
      })
      //
      plansContainer.append(plansRow)
      elements.plans.html(plansContainer)
    },
    description: function (application) {
      $('#application-description').html(marked(application.description))
    }
  }

  var initComponents = function (widget) {
    components.description(widget)
  }

  var init = function () {
    $.getJSON(apiPath + widgetId)
      .done(initComponents)
      .fail(function (e) {
        console.log(e)
      })
  }

  if ($('#widget-single').length) {
    init()
  }
})
