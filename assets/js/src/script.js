
/*
|--------------------------------------------------------------------------
| Custom Javascript code
|--------------------------------------------------------------------------
|
| Now that you configured your website, you can write additional Javascript
| code inside the following function. You might want to add more plugins and
| initialize them in this file.
|
*/

$(function () {
  $.ajax({
    type: "GET",
    url: "/teste.md",
    success: function (response) {
      $('#tab-home-1').html(marked(response));
    }
  });
});
