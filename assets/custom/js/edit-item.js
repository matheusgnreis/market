(function ($) {

  let navigation = $('.item-navigation');
  let btn_auth = $('.label-check-auth');
  let btn_save_edit = $('#btn_save_edit');
  let btn_plan = $('.close-btn .svg-plus');

  set_app_events();
  verify_auth();

  btn_auth.on('click', verify_auth);
  navigation.on('click', navigation_to);
  btn_plan.on('click', delete_plan);

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
    $("[name='authentication']").each(function(i, e){
      console.log($(e)[0].checked)
      console.log($(e)[0].id)
      if($(e)[0].checked){
        if($(this)[0].id == 'yes-id'){
          $('#auth_resp').show();
        }else if($(this)[0].id == 'no-id'){
          $('#auth_resp').hide();
        }
      }
    })
  }

  function delete_plan(){
    console.log($(this)[0].id);
    console.log(JSON.parse($('#my_plans').val()));
  }

})(jQuery);