(function($) {
  var $checkbox = $('.linked-check');
  // edit
  let id = $checkbox.prop('for');
  let price1 = parseFloat($checkbox.find('input#i-'+id).val());
  let coin = $("p#coin").find('span#coin')[0].innerText;
  changePrice("<span>"+coin+"</span>"+price1);


	$checkbox.on( 'click', deselectLinked );

	function deselectLinked() {
		var $this = $(this),
			selectedCheckboxID = $this.prop('for'),
			selectedCheckboxStatus = $("#"+selectedCheckboxID).prop('checked');
			showDescription(selectedCheckboxID);
      let price2 = parseFloat($checkbox.find('input#i-'+selectedCheckboxID).val());

			$checkbox.each(function() {
				var $this = $(this),
					checkboxID = $this.prop('for'),
					checkboxStatus = $("#"+checkboxID).prop('checked');

				if( checkboxID != selectedCheckboxID ) {
					deselect($("#"+checkboxID))
					hideDescription(checkboxID);
					//changePrice("<span>$</span>28.00");
				} else {
					changePrice("<span>"+coin+"</span>"+price2);
				}
			});
	}

  function deselect(checkbox) {
		checkbox.prop('checked', false);
	}

	function showDescription(container) {
		$(".license-text[data-license='"+container+"']").slideDown();
	}

	function hideDescription(container) {
		$(".license-text[data-license='"+container+"']").slideUp();
	}

	function changePrice(price) {
		$('.sidebar-item .price.large').html(price);
	}
})(jQuery);

// buy item click buy
$("#buy-item").click(function(event){
  console.log('click');
  let div = 'div#item-page',
      input = $(div).find('input.checkbox-plan'),
      div_id = 'div#addons-buy',
      $div_item = $('div#addons-items'),
      id_app = $(div_id).find('input#id-item').val(), // capture app id
      is_app = $(div_id).find('input#item-is-app').val(); // capture variable that checks whether it's app
  for (var i = 0; i < input.length; i++) {
    if (input[i].checked == true) { // check which plan is selected
      id_license = input[i].id; // (id plan is string) this is the id of the selected plane
    }
  }
  let value = parseFloat($(div).find('input#i-'+ id_license).val()),// this is the value of the selected plan
      id_plan = $(div).find('input#s-'+ id_license).val(),
      id_template;
  // if is_app = 1 app
  // else theme
  if (is_app != 1) { // treat theme purchase
    //If there is more than one template, capture template id.
    $div_item.each(function(){
      let divs = $(this).find('div');
      for (var i = 0; i < divs.length; i++) {
        if (divs[i].style.display == 'block' && divs[i].id.indexOf("image-") != -1) {
          id_template = parseInt(divs[i].id.split("image-")[1]);
        }
      }
    })
  }
  // send infos
  $("#addons-app-id").val(id_app); // app id
  $("#addons-app-id_plan").val(id_plan); // app plan
  $("#addons-app-value").val(value); // app plan
  $("#addons-app-is_app").val(is_app); // check app
  $("#addons-app-id_template").val(id_template); // template id
  $("#addons-buy-item").submit(); // send
});
