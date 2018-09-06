(function($,event) {
  let $div_button = $('#template'),
      $div_item = $('div#addons-items'),
      page = window.location.hash;

  if (page != '') {
    var res = page.split("#template"),
        id = parseInt(res[1]),
        button =$div_button.find('a#' + id);
    showImage(button);
  }

  $div_button.on( 'click', select );

  function select(event) {
    let target = $(event.target),
        id_template = target[0].id,
        button = $div_button.find('a#' + id_template);
    showImage(button);
  }

  function showImage(button){
    $div_button.each(function() {
      let $this = $(this),
          buttonID = $this.find('a');
      //  console.log(buttonID);
      for (var i = 0; i < buttonID.length; i++) {
        if (buttonID[i]== button[0]) {
          $div_item.find('div#image-' + buttonID[i].id).attr('style', 'display: block;' );
        }else {
          $div_item.find('div#image-' + buttonID[i].id).attr('style', 'display:none;' );
        }
      }
    });
  }
})(jQuery);
