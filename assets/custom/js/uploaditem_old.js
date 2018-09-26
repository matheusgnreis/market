let form_plans_clone = $('#form_plans_clone').html();

$("#send-app").on('click', function (event) {
  create();
  event.preventDefault();
});

//click the button add plan
$("#add-plan").on('click', function (event) {

  //var elm_html = $('#form_plans_clone').html();   //faz uma cópia dos elementos a serem clonados.
  var i = $('.plan_clone').length;
  var elementos = form_plans_clone.replace(/\[[0\]]\]/g, '[' + i++ + ']');  //substitui o valor dos index e incrementa++
  $('#form_plans_clone').append(elementos);  //exibe o clone.

  event.preventDefault();
  return false;
});
//
$("#rm-plan").click(function (event) {
  let el = $('.plan_clone');
  let i = --el.length;
  if (i != 0) {
    el[i].remove();
  }
  event.preventDefault();
});

$('#type').on('change', function () {
  if ($(this).val() == 'dashboard' || $(this).val() == 'storefront') {
    $('#scripturl_el').show();
  } else {
    $('#scripturl_el').hide();
  }
})

$('#files').on('change', function (event) {
  event.preventDefault();

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

});

(function ($) {

  let select = $('select#type');
  // capture (select) to enable module_type
  var $checkbox = $('.label-check'),
    // capture (checkbox) to enable app or theme
    $checkboxauth = $('.label-check-auth');
  // capture (checkbox) to check whether the application needs authentication or not

  // function treat to enable module_type
  enableSelect(select.val());
  // function treat click in (select) to treat enable module_type
  select.on('click', selectType);
  //  function treat click (checkbox) to enable app or app
  $checkbox.on('click', deselectLinked);
  // function treat click (checkbox) to authentication
  $checkboxauth.on('click', checkAuth);

  function checkAuth() {
    var $this = $(this),
      selectedCheckboxID = $this.prop('for'),
      selectedCheckboxStatus = $("#" + selectedCheckboxID).prop('checked');
    // function send yes or no
    authentication(selectedCheckboxID);
    $checkboxauth.each(function () {
      var $this = $(this),
        checkboxID = $this.prop('for'),
        checkboxStatus = $("#" + checkboxID).prop('checked');
      if (checkboxID != selectedCheckboxID) {
        deselect($("#" + checkboxID))
      } else {

      }
    });

  }

  function authentication(id) {
    if (id == 'yes-id') {
      $('input#authentication').val(1);
      $('#auth_callback_el').show();
    }
    else if (id == 'no-id') {
      $('input#authentication').val(0);
      $('#auth_callback_el').hide();
    }
  }

  function deselectLinked() {
    var $this = $(this),
      selectedCheckboxID = $this.prop('for'),
      selectedCheckboxStatus = $("#" + selectedCheckboxID).prop('checked');
    //$('input#inv-'+selectedCheckboxID).attr('value','true');
    //showDescription(selectedCheckboxID);
    enable(selectedCheckboxID);

    $checkbox.each(function () {
      var $this = $(this),
        checkboxID = $this.prop('for'),
        checkboxStatus = $("#" + checkboxID).prop('checked');

      if (checkboxID != selectedCheckboxID) {
        deselect($("#" + checkboxID))
        //desable(checkboxID);
        //hideDescription(checkboxID);
        //changePrice("<span>$</span>28.00");
      } else {
        //changePrice("<span>$</span>56.00");
      }
    });
  }

  function deselect(checkbox) {
    /*
    this function is used to select only one check box for application or theme
    as well as hide the selection of application or theme categories
    */
    // with the checkbox received as value, set the property (checked) as false
    checkbox.prop('checked', false);
    //receive value to verify that the application or theme
    //and in the opposite condition to that value, hides the (select)
    //of their respective categories and redefines the value (num)

    let is_app = parseInt($('form#upload_form').find('input#inp-item_is_app').val());

    if (is_app != 1) { // if value is the opposite value of the app
      for (var i = num; i > 1; i--) {
        $("div#cat-app-" + i).attr('style', 'display:none;');
      }
    } else if (is_app != 0) { //if value is the opposite value of the Theme
      for (var i = num; i > 1; i--) {
        $("div#cat-theme-" + i).attr('style', 'display:none;');
      }
    }

    for (var i = num_plan; i > 1; i--) {
      $("div#plan-" + i).attr('style', 'display:none;');
    }

    for (var i = num_faqs; i > 0; i--) {
      $("div#faq-" + i).attr('style', 'display:none;');
    }

    num = 1; // reset num
    num_plan = 1; //
    num_faqs = 0; //
  }
  //function to enable application or theme fields
  function enable(id) {
    //receives the (input) to verify that it is application or theme and
    //to display the necessarios fields to fill the application or theme
    if (id == 'item_is_app') { // if app
      $('input#inp-item_is_app').val(1);
      $('div#enable-app').attr('style', 'display:block;');
      $('div#enable-theme').attr('style', 'display:none;');
      enable_img();
    } else if (id == 'item_is_theme') { // if theme
      $('div#enable-app').attr('style', 'display:none;');
      $('div#enable-theme').attr('style', 'display:block;');
      $('input#inp-item_is_app').val(0);

      for (var i = 2; i <= 6; i++) {
        $('div#img' + i).attr('style', 'display:none;');
      }
      $('input#tem1').attr('type', 'file');
      $('div#tem1').attr('style', 'display:block;');

      for (var i = 2; i <= 3; i++) {
        $('input#tem' + i).attr('type', 'hidden');
        $('div#tem' + i).attr('style', 'display:none;');
      }
      $('div#button_template').attr('style', 'display:block;');

    } else {
      $('div#enable-app').attr('style', 'display:none;');
      $('div#enable-theme').attr('style', 'display:none;');
    }
  }
  function enable_img() {

    for (var i = 1; i <= 6; i++) {
      $('div#img' + i).attr('style', 'display:block;');
      $('input#img' + i).attr('type', 'file');
    }

    for (var i = 1; i <= 3; i++) {
      $('input#tem' + i).attr('type', 'hidden');
      $('div#tem' + i).attr('style', 'display:none;');
    }
    $('div#button_template').attr('style', 'display:none;');
  }
  // function selected type app
  function selectType() {
    let $this = $(this);
    enableSelect($this.val());
  }
  // function enable select module type
  function enableSelect(id) {
    console.log(id)
/*     let div = $('#module-type'),
      lable = $('label#module-type'),
      divi = $('div#tem1'),
      input = $('input#tem1');

    if (id == 'module_package') {
      div.show()
    } else {
      div.hide()
    } */

    let el_module_type = $('#module-type');
    let el_load_events = $('#load_events-el');

    if(id == 'module_package'){
      el_module_type.show();
      el_load_events.hide();
    }else if(id == 'dashboard' || id == 'storefront'){
      el_load_events.show();
      el_module_type.hide();
    }else{
      el_load_events.hide();
      el_module_type.hide();
    }



  }

})(jQuery);


function erroAlert(message) {
  $('body').xmalert({
    x: 'right',
    y: 'top',
    xOffset: 30,
    yOffset: 30,
    alertSpacing: 40,
    fadeDelay: 0.3,
    template: 'messageError',
    title: 'Erro:',
    paragraph: message
  });
}

function successAlert(message) {
  $('body').xmalert({
    x: 'right',
    y: 'top',
    xOffset: 30,
    yOffset: 30,
    alertSpacing: 40,
    lifetime: 6000,
    fadeDelay: 0.3,
    template: 'messageSuccess',
    title: 'Sucess:',
    paragraph: message,
  });
}

function GenericInputFileCleaner(selector) {
  selector = $(selector);
  selector.replaceWith(selector.val('').clone(true));
}

function create() {

  let isApp, isTheme;

  if ($("#item_is_app").is(':checked')) {
    isApp = true;
    $('#category_theme').attr('name', '');
  } else if ($("#item_is_app").is(':checked')) {
    isTheme = true;
    $('#category_apps').attr('name', '');
  }

  form_plans();

  let data = $('#upload_form').serialize();

  $.ajax({
    type: "POST",
    url: "/ws/apps",
    data: data,
    success: function (response) {
      if (201 == response.status) {
        console.log(response)
        $('#aid').val(response.id);
        $('#upload-img').submit();
      }
    }
  });
}

function form_plans() {
  let form = $('#form_plans_clone');
  let data = form.serializeArray();
  console.log(data)
  $.ajax({
    type: "POST",
    url: "/ws/format/plans",
    data: data,
    //dataType: "json",
    success: function (response) {
      if(response){
        $('#plans_json').val(response);
        $('#paid').val(1)
        $('#value_plan_basic').val($('name="plan_value[0]"').val());
      }else{
        $('#paid').val(0)        
      }
      
    }
  });
}

function form_pictures(aid) {

  var formData = new FormData($('#upload-files'));
  console.log($('#upload-files'))
  $.ajax({
    url: '/ws/apps/media/' + aid,
    type: 'POST',
    data: formData,
    success: function (data) {
      console.log(data)
    },
    cache: false,
    contentType: false,
    processData: false,
    xhr: function () {  // Custom XMLHttpRequest
      var myXhr = $.ajaxSettings.xhr();
      if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
        myXhr.upload.addEventListener('progress', function () {
          /* faz alguma coisa durante o progresso do upload */
        }, false);
      }
      return myXhr;
    }
  });
}

$('#upload-img').on('submit', function (event) {
  var formData = new FormData(this);

  let aid = $('#aid').val();
  $.ajax({
    url: '/ws/apps/media/' + aid,
    type: 'POST',
    dataType: 'json',
    data: formData,
    success: function (data) {
      if (201 == data.status) {

      }
    },
    cache: false,
    contentType: false,
    processData: false,
    xhr: function () {  // Custom XMLHttpRequest
      var myXhr = $.ajaxSettings.xhr();
      if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
        myXhr.upload.addEventListener('progress', function () {

        }, false);
      }
      return myXhr;
    }
  });
  event.preventDefault();
});

$('#slug').keyup(function (e) {
  let s = $(this).val();
  let sugg = '';
  $.ajax({
    type: "GET",
    url: "/ws/apps/slug/"+s,
    success: function (response) {
      console.log(response)
      if(response.status > 302){
        for (let i = 0; i < response.suggestions.length; i++) {
          console.log(response.suggestions[i]);
          sugg += i < response.suggestions.length ? '<a class="slug-sugges">'+response.suggestions[i]+'</a>'+ ', ' : '<a class="slug-sugges">'+response.suggestions[i]+'</a>';
        }

        $('#slug-sugg').html('<span> Slug em uso, sugestões: '+sugg+'</span>')
      }
    }
  });
});

$(function () {
  $('a.slug-sugges').on('click',function(){
    console.log($(this))
    console.log($(this).val())
    console.log($(this).text())
    })
});

$('#btn-auth').on('click', function(){
  let data = $('#form-scope').serializeArray();
  $.ajax({
    type: "POST",
    url: "/ws/format/scope",
    data: data,
    //dataType: "json",
    success: function (response) {
      $('#auth_scope').val(response);
    }
  });

/*   let last = data[0]['name'];
  let obj = [];
  for (let i = 0; i < data.length; i++) {
    console.log(data[i])
    if(last === data[i]['name']){
      obj[last] = data[i]['value'];
      last = data[i]['name'];    
    }else{
      last = data[i]['name']; 
      obj[last] = data[i]['value'];
    }
  }

  console.log(obj); */

});