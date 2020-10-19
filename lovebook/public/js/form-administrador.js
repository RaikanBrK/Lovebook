class Administrador {
	constructor() {
	}

	admNome(nome) {
		const content = $(nome);

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

		content.blur(function(e) {
			let input = $(e.target);
			let group = input.closest('.form-group');
			let help = group.find('.help-digit');
			help.html('');
		});
	}

	admSenha(senha) {
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

	admConfirmSenha(confirmSenha, senha) {
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