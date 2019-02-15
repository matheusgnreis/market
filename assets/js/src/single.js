$(document).ready(function () {
  //
  var apiPath = '/v1/applications/'
  var appId = $('#app-resume').data('id')
  //
  var elements = {
    plans: $('#application-plans'),
    comments: $('#application-comments'),
    description: $('#application-description')
  }
  /**
   * 
   * @param {*} application 
   */
  var initComponents = function (application) {
    //
    components.comments(application)
    //
    components.plans(application)
    //
    components.description(application)
  }

  /**
   * 
   */
  var components = {
    /**
     * 
     * @param {*} application 
     */
    comments: function (application) {
      //
      if (window.location.pathname.split('/')[1] === 'pt_br') {
        moment.locale('pt-br')
      }

      var commentsContainer = $('<div>', { class: 'container' })
      var commentsRow = $('<div>', { class: 'row' })
      var commentsCol = $('<div>', { class: 'col-12' })
      var mediaList = $('<div>', { class: 'media-list' })
      //
      var commentsList = $.map(application.comments, function (comment, key) {

        var media = $('<div>', { class: 'media' })
        var mediaBody = $('<div>', { class: 'media-body' })
        var commentsInfo = $('<div>', { class: 'small-1' })

        $('<strong>', { text: comment.name }).appendTo(commentsInfo)
        $('<time>', { class: 'ml-4 opacity-70 small-3', text: moment(comment.date_time).fromNow() }).appendTo(commentsInfo)

        //
        $(commentsInfo).appendTo(mediaBody)
        //
        $('<p>', { class: 'small-2 mb-0', text: comment.comment }).appendTo(mediaBody)
        //
        $(mediaBody).appendTo(media)

        return media

      })

      // button public a comment
      var publishCommentCol = $('<div>', { class: 'col-12 publish-comment-col' })
      var buttonComment = $('<a>', { class: 'btn btn-block btn-round btn-primary', id: 'publish-comment', text: 'Publicar um comentário' })
      buttonComment.appendTo(publishCommentCol)
      //
      mediaList.append(commentsList)
      commentsCol.append(mediaList)
      commentsRow.append(commentsCol)
      publishCommentCol.appendTo(commentsRow)
      commentsContainer.append(commentsRow)
      //
      elements.comments.html(commentsContainer)

    },
    /**
     * 
     * @param {*} application 
     */
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
    /**
     * 
     * @param {*} application 
     */
    description: function (application) {
      elements.description.html(marked(application.description))
    }
  }

  /**
   * 
   * @param {*} jqxhr 
   * @param {*} textStatus 
   * @param {*} error 
   */
  var requestFail = function (jqxhr, textStatus, error) {
    console.log(error)
  }

  /**
   * init
   */
  $.getJSON(apiPath + appId)
    .done(initComponents)
    .fail(requestFail)
})
