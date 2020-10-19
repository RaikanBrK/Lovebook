class Book {
	constructor() {
	}

	bookTitle(title) {
		const content = $(title);

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

	bookDateLancamento(date) {
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

	bookPreco(preco) {
		const content = $(preco);

		content.keyup(function(e) {
			let input = $(e.target);
			let group = input.closest('.form-group');
			let help = group.find('.help-digit');

			let num = input.val();			

			if (num < 5) {
				help.html(`min: 5, max: 3000`);
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

	bookPaginas(paginas) {
		const content = $(paginas);

		content.keyup(function(e) {
			let input = $(e.target);
			let group = input.closest('.form-group');
			let help = group.find('.help-digit');

			let num = input.val();

			if (num < 20) {
				help.html(`Mínimo 20 páginas`);
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

	bookDesc($desc) {
		const content = $(desc);

		content.keyup(function(e) {
			let input = $(e.target);
			let group = input.closest('.form-group');
			let help = group.find('.help-digit');

			let num = input.val().length;	

			if (num < 30) {
				help.html(`Faltam ${30 - num} letras`);
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


	bookSendImg(button, img) {
		button.click(function(e) {
			if (img.val() == '') {
				$('#content-img .help-digit').html('Selecione uma imagem');
				e.preventDefault();
			}
		});
	}

}