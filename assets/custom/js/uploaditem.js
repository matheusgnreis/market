var num = 1; // variable for total value of categories added
    num_plan = 1, // variable for total value of plans
    num_faqs = 0, // variable for total value of faqs
    max_faqs = 10,
    max_plan_app = 10,
    max_plan_theme = 2,
    num_temple = 1,
    max_temple = 3;

$("form#upload_form").submit(function(event){
  console.log('Sim');
  let $form = $('form#upload_form'),
      name_app = $form.find('input#item_name').val(), // not null
      num_version = $form.find('input#item_numversion').val(),
      description = $form.find('textarea#item_description').val(),// not null
      script_url = $form.find('input#item_scripturl').val(),
      github = $form.find('input#item_github').val(),
      website = $form.find('input#item_website').val(),
      video = $form.find('input#item_linkvideo').val(),
      is_app = $form.find('input#inp-item_is_app').val(),
      linkdoc = $form.find('input#item_linkdoc').val();
      type_app = $form.find('select#type-app').val(),
      module_app = $form.find('select#module-type').val();
      authentication = $form.find('input#authentication').val(),
      // plans
      //num_categories =  num
      // create a string to send in json format
      categories_str = '{"total":' + num + ',"categories": [';
      for (var i = 1; i <= num; i++) { // create string json format
        categories_str += '{"id":'+ parseInt($form.find('select#category-'+is_app+'-'+i).val()) + '}' ;
        if (i != num ) {
          categories_str += ",";
        }
      }
      categories_str += "]}";
      // treat plans
      plans_str = '{"total_plans":'+ num_plan + ',"plans": [';
      var price_item;
      var name_plan;

      for (var i = 1; i <= num_plan  ; i++) {
        price_item = parseFloat($('input#item_value-'+i).val());
        name_plan = $('input#name_plan-'+i).val();

        if (isNaN(price_item)) {
          price_item = 0;
        }

        if (name_plan == '') {
          name_plan = 'Plan '+ i;
        }

      plans_str += '{"id":' + i + ',"name":"' + name_plan
        + '","value":' + price_item
        + ',"desc":"' +  $('input#desc_plan-'+i).val()
        + '"}';

        if (i != num_plan) {
          plans_str += ",";
        }
      }
      plans_str += "]}";
      console.log(plans_str);
      //treat faqs
      fqs_str = '{"total_faqs":'+ num_faqs + ',"faqs": [';

      for (var i = 1; i <= num_faqs; i++) {
          fqs_str += '{"id":' + i
          + ',"question":"' + $('input#question-'+i).val()
          + '","answer":"' + $('input#answer-'+i).val() + '"'
          +'}';

          if (i != num_faqs) {
            fqs_str += ",";
          }
      }

      fqs_str += "]}";
      //question
      //answer

    // if fields are empty
  if (name_app == '' || num_version == '' || description == '') {
    alert('Error');
    $form.find("#cat-required").css( "color", "red");
    $form.find("#name-required").css( "color", "red");
    $form.find("#version-required").css( "color", "red");
    $form.find("#desc-required").css( "color", "red");

  }else {
    if (is_app == 1 ) { // app
      $("#uploaditem-is_app").val(is_app);
      $("#uploaditem-name_app").val(name_app);
      $("#uploaditem-category").val(categories_str);
      $("#uploaditem-item_numversion").val(num_version);
      $("#uploaditem-item_description").val(description);
      $("#uploaditem-item_scripturl").val(script_url);
      $("#uploaditem-item_github").val(github);
      $("#uploaditem-item_website").val(website);
      $("#uploaditem-item_linkvideo").val(video);
      $("#uploaditem-item_type_app").val(type_app);
      $("#uploaditem-item_module_app").val(module_app);
      $("#uploaditem-item_authetication").val(authentication);
      $('#uploaditem-plans').val(plans_str);
      $('#uploaditem-faqs').val(fqs_str);

     $("#addons-uploaditem").submit();//
    } else if (is_app == 0 ) { // theme
      $("#uploaditem-is_app").val(is_app);
      $("#uploaditem-name_app").val(name_app);
      $("#uploaditem-category").val(categories_str);
      $("#uploaditem-item_numversion").val(num_version);
      $("#uploaditem-item_description").val(description);
      $("#uploaditem-item_linkdoc").val(linkdoc);
      $("#uploaditem-item_linkvideo").val(video);
      $('#uploaditem-plans').val(plans_str);
      $('#uploaditem-faqs').val(fqs_str);
      $('#uploaditem-n_temp').val(num_temple);
     $("#addons-uploaditem").submit();//
    }
  }
  event.preventDefault();
});

//click the button add category
$("#add-category").click(function(event){
  let is_app = parseInt($('form#upload_form').find('input#inp-item_is_app').val());
  // check it's an app or theme
  if (is_app == 1) { // if app
    let max_categories =  parseInt($('input#total_cat_app').val());
    // maximum number of categories that can be added
    if (num < max_categories) { // if maximum number not reached
      num += 1;
    }
    for (var i = 1; i <= num; i++) { // displays (select) categories up to the value added
      $("div#cat-app-"+i).attr('style','display:block;');
    }
  } else if(is_app == 0 ){ // if Theme
    let max_categories =  parseInt($('input#total_cat_theme').val());
    if (num < max_categories) { //if maximum number not reached
      num += 1;
    }
    for (var i = 1; i <= num; i++) { // displays (select) categories up to the value added
      $("div#cat-theme-"+i).attr('style','display:block;');
    }
  }

  event.preventDefault();
});
// click the button remove category
$("#rm-category").click(function(event){
  let is_app = parseInt($('form#upload_form').find('input#inp-item_is_app').val());
  // can not hide all
  if (num > 1) {
  num -= 1;
  }
  // check it's an app or theme
  if (is_app == 1) {
    $("div#cat-app-"+(num+1)).attr('style','display:none;');
  }else if (is_app == 0) {
    $("div#cat-theme-"+(num+1)).attr('style','display:none;');
  }
  event.preventDefault();
});

//click the button add plan
$("#add-plan").click(function(event){

  let is_app = parseInt($('form#upload_form').find('input#inp-item_is_app').val());
  // check it's an app or theme
  if (is_app == 1) { // if app
    // maximum number of categories that can be added
    if (num_plan < max_plan_app) { // if maximum number not reached
      num_plan += 1;
    }
    for (var i = 1; i <= num_plan; i++) { // displays (select) categories up to the value added
      $("div#plan-"+i).attr('style','display:block;');
    }
  } else if(is_app == 0 ){ // if Theme

    if (num_plan < max_plan_theme) { //if maximum number not reached
      num_plan += 1;
    }
    for (var i = 1; i <= num_plan; i++) { // displays (select) categories up to the value added
      $("div#plan-"+i).attr('style','display:block;');
    }
  }
  event.preventDefault();
});
//
$("#rm-plan").click(function(event){
  // maximum number of faqs that can be added
  if (num_plan > 1) { // if maximum number not reached
    $("div#plan-"+num_plan).attr('style','display:none;');
    num_plan -= 1;
  }

event.preventDefault();
});

//click the button add faq
$("#add-faq").click(function(event){

    // maximum number of faqs that can be added
    if (num_faqs < max_faqs) { // if maximum number not reached
      num_faqs += 1;
    }
    for (var i = 1; i <= num_faqs; i++) { // displays (select) categories up to the value added
      $("div#faq-"+i).attr('style','display:block;');
    }

  event.preventDefault();
});
//click the button add faq
$("#rm-faq").click(function(event){

    // maximum number of faqs that can be added
    if (num_faqs >= 0) { // if maximum number not reached
      $("div#faq-"+num_faqs).attr('style','display:none;');
      num_faqs -= 1;
    }

  event.preventDefault();
});
// TODO:
//click the button add templete
$("#add-temp").click(function(event){

    // maximum number of templeate that can be added
    if (num_temple < max_temple) { // if maximum number not reached
      num_temple += 1;
    }
    for (var i = 1; i <= num_temple; i++) { // displays (select) categories up to the value added
      $("div#tem"+num_temple).attr('style','display:block;');
      $("div#img"+num_temple).attr('style','display:block;');

      $("input#tem"+num_temple).attr('type','file');
      $("input#img"+num_temple).attr('type','file');
    }

  event.preventDefault();
});

//click the button add faq
$("#rm-temp").click(function(event){

    // maximum number of faqs that can be added
    if (num_temple > 1) { // if maximum number not reached
      $("div#tem"+num_temple).attr('style','display:none;');
      $("div#img"+num_temple).attr('style','display:none;');

      $("input#tem"+num_temple).attr('type','hidden');
      $("input#img"+num_temple).attr('type','hidden');
      num_temple -= 1;
    }

  event.preventDefault();
});

(function($) {

  let select = $('select#type-app');
      // capture (select) to enable module_type
	var $checkbox = $('.label-check'),
      // capture (checkbox) to enable app or theme
      $checkboxauth = $('.label-check-auth');
      // capture (checkbox) to check whether the application needs authentication or not

  // function treat to enable module_type
  enableSelect(select.val());
  // function treat click in (select) to treat enable module_type
  select.on('click',selectType);
  //  function treat click (checkbox) to enable app or app
	$checkbox.on( 'click', deselectLinked );
   // function treat click (checkbox) to authentication
  $checkboxauth.on( 'click', checkAuth);

  function checkAuth() {
    var $this = $(this),
    selectedCheckboxID = $this.prop('for'),
    selectedCheckboxStatus = $("#"+selectedCheckboxID).prop('checked');
    // function send yes or no
    authentication(selectedCheckboxID);
    $checkboxauth.each(function() {
      var $this = $(this),
        checkboxID = $this.prop('for'),
        checkboxStatus = $("#"+checkboxID).prop('checked');
      if( checkboxID != selectedCheckboxID ) {
        deselect($("#"+checkboxID))
      } else {

      }
    });

  }

  function authentication(id){
  if (id == 'yes-id') {
    $('input#authentication').val(1);
  }
  else if (id == 'no-id') {
    $('input#authentication').val(0);
  }
}

	function deselectLinked() {
      var $this = $(this),
			selectedCheckboxID = $this.prop('for'),
			selectedCheckboxStatus = $("#"+selectedCheckboxID).prop('checked');
      //$('input#inv-'+selectedCheckboxID).attr('value','true');
    	//showDescription(selectedCheckboxID);
      enable(selectedCheckboxID);

			$checkbox.each(function() {
				var $this = $(this),
					checkboxID = $this.prop('for'),
					checkboxStatus = $("#"+checkboxID).prop('checked');

				if( checkboxID != selectedCheckboxID ) {
					deselect($("#"+checkboxID))
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
        $("div#cat-app-"+i).attr('style','display:none;');
      }
    }else if (is_app != 0) { //if value is the opposite value of the Theme
      for (var i = num; i > 1; i--) {
        $("div#cat-theme-"+i).attr('style','display:none;');
      }
    }

    for (var i = num_plan; i > 1; i--) {
      $("div#plan-"+i).attr('style','display:none;');
    }

    for (var i = num_faqs; i > 0; i--) {
      $("div#faq-"+i).attr('style','display:none;');
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
      $('div#enable-app').attr('style','display:block;');
      $('div#enable-theme').attr('style','display:none;');
      enable_img();
    }else if (id == 'item_is_theme') { // if theme
      $('div#enable-app').attr('style','display:none;');
      $('div#enable-theme').attr('style','display:block;');
      $('input#inp-item_is_app').val(0);

      for (var i = 2; i <= 6; i++) {
        $('div#img'+i).attr('style','display:none;');
      }
        $('input#tem1').attr('type','file');
        $('div#tem1').attr('style','display:block;');

      for (var i = 2; i <= 3; i++) {
        $('input#tem'+i).attr('type','hidden');
        $('div#tem'+i).attr('style','display:none;');
      }
      $('div#button_template').attr('style','display:block;');

    }else {
      $('div#enable-app').attr('style','display:none;');
      $('div#enable-theme').attr('style','display:none;');
    }
	}
  function enable_img() {

    for (var i = 1; i <= 6; i++) {
      $('div#img'+i).attr('style','display:block;');
      $('input#img'+i).attr('type','file');
    }

    for (var i = 1; i <= 3; i++) {
      $('input#tem'+i).attr('type','hidden');
      $('div#tem'+i).attr('style','display:none;');
    }
    $('div#button_template').attr('style','display:none;');
  }
  // function selected type app
  function selectType() {
    let $this = $(this);
    enableSelect($this.val());
  }
  // function enable select module type
  function enableSelect(id) {

    let div = $('select#module-type'),
        lable = $('label#module-type'),
        divi = $('div#tem1'),
        input = $('input#tem1');

    if (id == 3) {
      div.prop('disabled', false);
      div.attr('style','display:block;');
      lable.attr('style','display:block;');
      divi.attr('style','display:block;');
      input.attr('type','file');

    }else {
      div.prop('disabled', true);
      div.attr('style','display:none;');
      lable.attr('style','display:none;');
      divi.attr('style','display:none;');
      input.attr('type','hidden');

    }

  }

})(jQuery);
