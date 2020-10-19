$(document).ready(function() {
	const nome = document.querySelector('#nome');
	const sobrenome = document.querySelector('#sobrenome');
	const usuario = document.querySelector('#usuario');
	const email = document.querySelector('#email');
	const cpf = document.querySelector('#cpf');
	const cep = document.querySelector('#cep');
	const numero = document.querySelector('#numero');
	const senha = document.querySelector('#senha');	
	const confirmSenha = document.querySelector('#confirmSenha');	

	
	function maskTelefone(input) {

		input.addEventListener('keypress', function(e) {
			let text = input.value;

			if ( (e.keyCode >= 48 && e.keyCode <= 57) && text.length < 15) {

				if (text.length == 0) {
					text += '(';
				}

				if (text.length == 3) {
					text += ') ';
				}

				if (text.length == 9) {
					text += '-';
				}

				if (text.length == 14) {
					let arrayText = text.split('-');
					let parte1 = arrayText[0];
					let parte2 = arrayText[1];

					let numFlutuante = parte2.substring(0, 1);
					let parteFinal = parte2.substring(1);

					text = `${parte1}${numFlutuante}-${parteFinal}`;
				}

				input.value = text;
			} else {
				e.preventDefault();
			}
		});

		input.addEventListener('keyup', function(e) {
			let text = input.value
			if(e.keyCode == 8 ) {

				if (text.length == 5) {
					text = text.slice(0, 3);
				}

				if (text.length == 14) {
					let arrayText = text.split('-');
					let parte1 = arrayText[0];
					let parte2 = arrayText[1];

					let numFlutuante = parte1.substring(parte1.length, parte1.length - 1);
					parte1 = parte1.slice(0, parte1.length - 1);

					text = `${parte1}-${numFlutuante}${parte2}`;
				}
				
				input.value = text;
			}
		})
	}

	function mashCep(input) {
		input.addEventListener('keypress', function(e) {
			let text = input.value;
			if ( (e.keyCode >= 48 && e.keyCode <= 57) && text.length < 9) {

				if (text.length == 5) {
					text += '-';
				}

				input.value = text;
			} else {
				e.preventDefault();
			}
		});
	}

	function mashCpf(input) {
		input.addEventListener('keypress', function(e) {
			let text = input.value;
			if ( (e.keyCode >= 48 && e.keyCode <= 57) && text.length < 14) {

				if (text.length == 3) {
					text += '.';
				}

				if (text.length == 7) {
					text += '.';
				}

				if (text.length == 11) {
					text += '-';
				}				

				input.value = text;
			} else {
				e.preventDefault();
			}
		});
	}


	maskTelefone(numero);
	mashCep(cep);
	mashCpf(cpf);

});	