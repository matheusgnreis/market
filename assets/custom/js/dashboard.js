(function () {
	// altera foto perfil
	$('#upload-picture').on('change', function () {

		let dataForm = new FormData(this);
		console.log(dataForm);
		$.ajax({
			type: "POST",
			url: "/ws/partner/profile/picture",
			data: dataForm,
			//dataType: "",
			contentType: false,       // The content type used when sending data to the server.
			processData: false,
			success: function (response) {
				if (response.erros) {
					erroAlert(response.erros.message);
				} else {
					successAlert('Foto de perfil atualiza com sucesso!');
				}
			}
		});

	});

	// altera senha
	$('#addons-button-save').on('click', function () {
		let pass, pass_conf, err = false;

		pass = $('#new_pwd');
		pass_conf = $('#new_pwd2');

		if (!pass.val() || pass.val() == 'undefined') {
			erroAlert('Senha inválida.')
		} else if (!pass_conf.val() && pass_conf.val() == 'undefined') {
			erroAlert('Confirmação da senha inválida.')
		} else if (pass.val() != pass_conf.val()) {
			erroAlert('Senhas não conferem.')
		}

		if (err == false) {
			$.ajax({
				type: "POST",
				url: "/ws/login/pass",
				data: {
					u: $('#data_user').val(),
					p: pass.val()
				},
				success: function (response) {
					console.log(response);
				}
			});
		}

		event.preventDefault();
	});

	// envia app
	$().on('', function(){

	});

})();

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

function successAlert(message){
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