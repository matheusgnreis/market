/** 
 * 
 */
$(function () {

  var myId = '5b1abe30a4d4531b8fe40726'
  var token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiI1YjFhYmUzMGE0ZDQ1MzFiOGZlNDA3MjYiLCJjb2QiOjkyODY2NzAyLCJleHAiOjE1NTExMzU5NjYwODZ9.yJwHRV8cWFHQ_tjDTVrUI3T4jWdGeCiMMrwQFtu2lHk'
  var storeId = 1011
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