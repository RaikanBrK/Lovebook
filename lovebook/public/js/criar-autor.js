$('body').on('change', '#image', function(e) {
	const dados = $(this).val().split('\\');
	const name = dados[dados.length - 1];

	$('#result').css('display', 'flex');
	$('#content-img .help-digit').html('');
	$('.title-img').html(name);
});

const autor = new Autor();
autor.autorNome($('#autor'));
autor.autorDateNascimento($('#data_nascimento'));
autor.autorDesc($('#desc'));
autor.autorSendImg($('#send'), $('#image'));