class Usuario {
	constructor() {
	}

	userNome(nome) {
		const content = $(nome);
		console.log(nome);

		content.keyup(function(e) {
			let input = $(e.target);
			let group = input.closest('.form-group');
			let help = group.find('.help-digit');

			let num = input.val().length;

			if (num < 3) {
				help.html(`Digite mais ${3 - num} letras`);
				content.removeClass('is-valid');
				content.addClass('is-invalid');
			} else {
				content.removeClass('is-invalid');
				content.addClass('is-valid');
				help.html('');
			}
		});

		content.keypress(function(e) {
			if (e.keyCode == 32) {
				e.preventDefault();
			}
		});

		content.blur(function(e) {
			let input = $(e.target);
			let group = input.closest('.form-group');
			let help = group.find('.help-digit');
			help.html('');
		});
	}

	userCpf(cpf) {
		const content = $(cpf);

		content.keyup(function(e) {
			let input = $(e.target);
			let group = input.closest('.form-group');
			let help = group.find('.help-digit');

			let num = input.val().length;

			if (num < 14) {
				help.html(`Digite mais ${14 - num} letras`);
				content.removeClass('is-valid');
				content.addClass('is-invalid');
			} else {
				content.removeClass('is-invalid');
				content.addClass('is-valid');
				help.html('');
			}
		});

		content.blur(function(e) {
			let input = $(e.target);
			let group = input.closest('.form-group');
			let help = group.find('.help-digit');
			help.html('');
		});
	}


	userNumero(numero) {
		const content = $(numero);

		content.blur(function(e) {
			let input = $(e.target);
			let group = input.closest('.form-group');
			let help = group.find('.help-digit');

			let num = input.val().length;

			if (num < 14) {
				help.html(`Digite mais ${14 - num} letras`);
				content.removeClass('is-valid');
				content.addClass('is-invalid');
			} else {
				content.removeClass('is-invalid');
				content.addClass('is-valid');
				help.html('');
			}
		});

		content.blur(function(e) {
			let input = $(e.target);
			let group = input.closest('.form-group');
			let help = group.find('.help-digit');
			help.html('');
		});
	}

	userSenha(senha) {
		const content = $(senha);

		content.keyup(function(e) {
			let input = $(e.target);
			let group = input.closest('.form-group');
			let help = group.find('.help-digit');

			let num = input.val().length;

			if (num < 8) {
				help.html(`Digite mais ${8 - num} letras`);
				content.removeClass('is-valid');
				content.addClass('is-invalid');
			} else {
				content.removeClass('is-invalid');
				content.addClass('is-valid');
				help.html('');
			}
		});

		content.blur(function(e) {
			let input = $(e.target);
			let group = input.closest('.form-group');
			let help = group.find('.help-digit');
			help.html('');
		});
	}

	userConfirmSenha(confirmSenha, senha) {
		const content = $(confirmSenha);

		content.keyup(function(e) {
			let input = $(e.target);
			let group = input.closest('.form-group');
			let help = group.find('.help-digit');

			let num = input.val().length;

			if (num < 8) {
				help.html(`Digite mais ${8 - num} letras`);
				
			} else {
				
				help.html('');
			}
		});

		content.blur(function(e) {
			let input = $(e.target);
			let group = input.closest('.form-group');
			let help = group.find('.help-digit');

			console.log(confirmSenha.val(), senha.val());
			if (confirmSenha.val() == senha.val()) {
				help.html('');
				content.removeClass('is-invalid');
				content.addClass('is-valid');
			} else {
				content.removeClass('is-valid');
				content.addClass('is-invalid');
				help.html('As senha não coincidem');
			}
		});
	}
}