class Autor {
	constructor() {
	}

	autorNome(nome) {
		const content = $(nome);

		content.keyup(function(e) {
			let input = $(e.target);
			let group = input.closest('.form-group');
			let help = group.find('.help-digit');

			let num = input.val().length;

			if (num < 6) {
				help.html(`Digite mais ${6 - num} letras`);
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

	autorDateNascimento(date) {
		const content = $(date);

		content.change(function(e) {
			let input = $(e.target);
			let group = input.closest('.form-group');
			let help = group.find('.help-digit');

			let time = new Date(content.val()).getTime();
			let timeAtual = new Date().getTime();

			if (time > timeAtual) {
				help.html(`Não utilize datas futuras`);
				content.removeClass('is-valid');
				content.addClass('is-invalid');
			} else {
				content.removeClass('is-invalid');
				content.addClass('is-valid');
				help.html('');
			}
		});
	}

	autorDesc($desc) {
		const content = $(desc);

		content.keyup(function(e) {
			let input = $(e.target);
			let group = input.closest('.form-group');
			let help = group.find('.help-digit');

			let num = input.val().length;	

			if (num < 20) {
				help.html(`Faltam ${20 - num} letras`);
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

	autorSendImg(button, img) {
		button.click(function(e) {
			if (img.val() == '') {
				$('#content-img .help-digit').html('Selecione uma imagem');
				e.preventDefault();
			}
		});
	}
}