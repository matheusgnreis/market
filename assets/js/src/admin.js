/** 
 * 
 */
$(function () {

  var applicationPathEcomP = 'https://api.e-com.plus/v1/applications.json'
  var applicationPathMarket = '/v1/applications'

  var components = {
    /**
     * 
     */
    applications: function () {

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

  var lojApplications = function () {
    return $.ajax({
      type: 'GET',
      url: applicationPathEcomP,
      dataType: 'json',
      headers: {
        'X-Store-ID': storeId,
        'X-Access-Token': token,
        'X-My-Id': myId
      }
    })
  }

  lojApplications()
    .done(function (apps) {
      console.log(apps.result)
    })


})