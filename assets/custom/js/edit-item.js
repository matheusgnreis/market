(function ($) {

  let navigation = $('.item-navigation');

  navigation.on('click', navigation_to);

  set_app_events();
  verify_auth();

  function navigation_to(event) {
    var to = $(this)[0].rel;
    console.log(to);
    $('.wrapper').each(function (index, element) {
      $(this).removeClass('active');
    });
    $('#' + to).addClass('active');
  }

  function set_app_events() {
    let input_load_events = $('#load_events option');
    let data = $('#input_load_events').val();
    if(!data)return;
    data = data.split(',');

    let user_scope = data.map(function (x) {
      return x.replace(/\\|\[|\]|"|/g, '');
    });

    $(input_load_events).each(function (index, element) {
      if (user_scope.includes($(element)[0].value)) {
        $(this).attr('selected', true);
      }
    }, user_scope);
  }

  function verify_auth(){
    
    let el = $("[name='authentication']").val()
    console.log(el);
    if(el == 1){
      $('#auth_resp').show();
    }else{
      $('#auth_resp').hide();
    }

  }

})(jQuery);