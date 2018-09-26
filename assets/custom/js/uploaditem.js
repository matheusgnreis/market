(function ($) {

  let btn_send_item = $('#send-app');
  let btn_add_plan = $('#add-plan');
  let btn_rmv_plan = $('#rm-plan');
  let input_item_type = $('#type');
  let input_slug = $('#slug');
  let form_plans = $('#form_plans_clone');
  let form_plans_clone = form_plans.html();
  let form_files = $('#files');
  let form_upload_files = $('#upload-img');
  let form_item = $('#item_form');
  let checkbox_item_is = $('.label-check.item_is');
  let checkbox_auth = $('.label-check-auth');

  define_item_type();

  btn_send_item.unbind('click').on('click', send_item);
  btn_add_plan.unbind('click').on('click', add_plan);
  btn_rmv_plan.on('click', rmv_plan);
  input_item_type.on('click', define_item_type);
  input_slug.unbind('keyup').on('keyup', check_slug);
  checkbox_item_is.on('click', deselect_linked);
  checkbox_auth.on('click', check_authentication);
  form_files.unbind('change').on('change', create_img_thumb);
  form_upload_files.unbind('submit').on('submit', form_pictures);

  function send_item(event) {
    event.preventDefault();
    if (!form_is_valid(form_item)) return false;

    switch (item_is()) {
      case 'apps':
        create_plan();
        create_form_scope();
        create_app();
        break;
      case 'themes':
        create_theme();
        break;
      default: break;
    }
  }

  function request(url, data, type = 'POST', process_data = false, content_type = true) {
    let jqXHR = $.ajax({
      type: type,
      url: url,
      data: data,
      dataType: 'json',
      processData: process_data,
      contentType: content_type === true ? 'application/x-www-form-urlencoded' : content_type,
      erro: function (e) {
        throw new Error('Failed api request.');
      },
      async: false
    });
    return jqXHR.responseText;
  }

  function form_is_valid(form) {
    erros = 0;
    form.find('input[required=true]').each(function () {
      $(this).removeClass('is_not_valid');
      if (!$(this).val()) {
        erros++;
        console.log('O campo ' + $(this).attr('id') + ' é obrigatório!');
        input = $(this).attr('id');
        $('#' + input).addClass('is_not_valid');
      }
    });

    if (erros > 0) send_alert('Erro, verifique os campos obrigatórios.');

    return erros > 0 ? false : true;
  }

  function form_pictures(event) {

    let aid = $('#aid').val();
    let url = '/ws/' +
      item_is() +
      '/media/' +
      aid;

    let formData = new FormData(this);

    $.ajax({
      url: url,
      type: 'POST',
      data: formData,
      success: function (data) {
        response = JSON.parse(data);
        console.log(response);
        if (response.erro) {
          send_alert('Erro: image upload failed.');
          return false;
        } else if (response.status == 201) {
          send_alert(item_is() + ' enviado com sucesso.', 's');
          send_alert('upload completo.', 's');
          clean_forms();
          window.location.href = '/account/edit';
          return true;
        }
      },
      cache: false,
      contentType: false,
      processData: false
    });

    event.preventDefault();
  }

  function item_is() {
    if ($("#item_is_app").is(':checked')) {
      $('#category_theme').attr('name', '');
      $('#category_apps').attr('name', 'category');
      return 'apps';
    } else if ($("#item_is_theme").is(':checked')) {
      $('#category_apps').attr('name', '');
      $('#category_theme').attr('name', 'category');
      return 'themes';
    }
  }

  function create_app() {
    let data = form_item.serialize();
    url = '/ws/apps';
    response = JSON.parse(request(url, data, 'POST', false, true));

    if (response.erro) {
      send_alert('Erro, verifique os campos obrigatórios.');
      return;
    }

    $('#aid').val(response.app.id);
    form_upload_files.submit();

  }

  function create_theme() {
    console.log(this);
    let data = form_item.serialize();
    url = '/ws/themes';
    response = JSON.parse(request(url, data, 'POST', false, true));

    if (response.erro) {
      send_alert('Erro, verifique os campos obrigatórios.');
      return;
    }

    $('#aid').val(response.app.id);
    form_upload_files.submit();
  }

  function add_plan() {
    let i = $('.plan_clone').length;
    let elementos = form_plans_clone.replace(/\[[0\]]\]/g, '[' + i++ + ']');  //substitui o valor dos index e incrementa++
    form_plans.append(elementos);
    event.preventDefault();
    return false;
  }

  function rmv_plan() {
    let el = $('.plan_clone');
    let i = --el.length;
    if (i != 0) {
      el[i].remove();
    }
    event.preventDefault();
  }

  function create_plan() {

    let data = form_plans.serializeArray();
    response = request('/ws/format/plans', data, 'post', true);
    if (response) {
      $('#plans_json').val(response);
      $('#paid').val(1)
      $('#value_plan_basic').val($("[name='plan_value[0]']").val());
    } else {
      $('#paid').val(0)
    }

  }

  function create_form_scope() {
    let data = $('#form-scope').serializeArray();
    let resp = request('/ws/format/scope', data, 'post', true);
    $('#auth_scope').val(resp);
  }

  function define_item_type() {

    id = input_item_type.val();
    let el_module_type = $('#module-type');
    let el_load_events = $('#load_events-el');

    if (id == 'module_package') {
      el_module_type.show();
      el_load_events.hide();
    } else if (id == 'dashboard' || id == 'storefront') {
      el_load_events.show();
      el_module_type.hide();
      $('#scripturl_el').show();
    } else {
      el_load_events.hide();
      el_module_type.hide();
      $('#scripturl_el').hide();
    }
  }

  function enable_fields(id) {
    //receives the (input) to verify that it is application or theme and
    //to display the necessarios fields to fill the application or theme
    if (id == 'item_is_app') { // if app
      $('input#inp-item_is_app').val(1);
      $('div#enable-app').attr('style', 'display:block;');
      $('div#enable-theme').attr('style', 'display:none;');
      $('#plans-section').attr('style', 'display:block;');
      $('#value-license-section').attr('style', 'display:none;');

    } else if (id == 'item_is_theme') { // if theme
      $('div#enable-app').attr('style', 'display:none;');
      $('div#enable-theme').attr('style', 'display:block;');
      $('input#inp-item_is_app').val(0);

      $('div#button_template').attr('style', 'display:block;');
      $('#plans-section').attr('style', 'display:none;');
      $('#value-license-section').attr('style', 'display:block;');
    } else {
      $('div#enable-app').attr('style', 'display:none;');
      $('div#enable-theme').attr('style', 'display:none;');
    }
  }

  function deselect_linked() {
    console.log(item_is());
    let $this = $(this);
    let selectedCheckboxID = $this.prop('for');
    //let selectedCheckboxStatus = $("#" + selectedCheckboxID).prop('checked');

    enable_fields(selectedCheckboxID);

    checkbox_item_is.each(function () {
      var $this = $(this),
        checkboxID = $this.prop('for'),
        checkboxStatus = $("#" + checkboxID).prop('checked');

      if (checkboxID != selectedCheckboxID) {
        deselect_checkbox($("#" + checkboxID))
      }
    });
  }

  function deselect_checkbox(checkbox) {
    /*
    this function is used to select only one check box for application or theme
    as well as hide the selection of application or theme categories
    */
    // with the checkbox received as value, set the property (checked) as false
    checkbox.prop('checked', false);
    //receive value to verify that the application or theme
    //and in the opposite condition to that value, hides the (select)
    //of their respective categories and redefines the value (num)

    let is_app = parseInt($('form#item_form').find('input#inp-item_is_app').val());

    if (is_app != 1) { // if value is the opposite value of the app
      for (var i = 0; i > 1; i--) {
        $("div#cat-app-" + i).attr('style', 'display:none;');
      }
    } else if (is_app != 0) { //if value is the opposite value of the Theme
      for (var i = 0; i > 1; i--) {
        $("div#cat-theme-" + i).attr('style', 'display:none;');
      }
    }
  }

  function check_authentication() {
    let $this = $(this);
    let selectedCheckboxID = $this.prop('for');
    enable_authentication(selectedCheckboxID);
  }

  function check_slug(event) {

    $('#slug-sugg').html('');

    let s = $(this).val();
    let sugg = '';
    let response = JSON.parse(request('/ws/apps/slug/' + s, null, 'get'));

    if (response.status > 302) {
      for (let i = 0; i < response.suggestions.length; i++) {
        console.log(response.suggestions[i]);
        sugg += i < response.suggestions.length ? '<a class="slug-sugges">' + response.suggestions[i] + '</a>' + ', ' : '<a class="slug-sugges">' + response.suggestions[i] + '</a>';
      }

      $('#slug-sugg').html('<span> Slug em uso, sugestões: ' + sugg + '</span>');
    }
    event.preventDefault()
  }

  function enable_authentication(id) {
    if (id == 'yes-id') {
      $('input#authentication').val(1);
      $('#auth_callback_el').show();
      $("#no-id").prop('checked', false);

    }
    else if (id == 'no-id') {
      $('input#authentication').val(0);
      $('#auth_callback_el').hide();
      $("#yes-id").prop('checked', false);

    }
  }

  function send_alert(message, type = 'e') {
    $('body').xmalert({
      x: 'right',
      y: 'top',
      xOffset: 30,
      yOffset: 30,
      alertSpacing: 40,
      lifetime: 6000,
      fadeDelay: 0.3,
      template: type === 'e' ? 'messageError' : 'messageSuccess',
      title: type === 'e' ? 'Erro:' : 'Sucesso',
      paragraph: message
    });
  }

  function GenericInputFileCleaner(selector) {
    selector = $(selector);
    selector.replaceWith(selector.val('').clone(true));
  }

  function create_img_thumb() {

    let fileInput = $(this)[0].files;
    let filesLenght = $(fileInput).length
    let valid = /(\.jpg|\.png|\.gif)$/i;
    let name = $(this).get(0).files["0"].name;

    $('#upload-count').text(0);
    $("#upload-queue").html();

    if (!valid.test(name)) {
      erroAlert('Formato inválido.');
      GenericInputFileCleaner(this);
      return;
    }

    if (filesLenght > 6) {
      erroAlert('Máximo 6 imagens.');
      GenericInputFileCleaner(this);
      return;
    }

    $('#upload-count').text(filesLenght);

    if (typeof (FileReader) != "undefined") {

      var image_holder = $("#upload-queue");
      image_holder.empty();

      for (let i = 0; i < filesLenght; i++) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $("<img />", {
            "src": e.target.result,
            "id": "thumb_" + i,
            "class": "thumb-image"
          }).appendTo(image_holder);
        }
        reader.readAsDataURL($(this)[0].files[i]);
      }
      //image_holder.show();

    } else {
      alert("Este navegador nao suporta FileReader.");
    }
  }

  function clean_forms() {
    $('form').each(function (index, element) {
      $(element).find('input').val('');
    });
  }

})(jQuery);