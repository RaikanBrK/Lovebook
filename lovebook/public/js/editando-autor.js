$('body').on('change', '#image', function(e) {
	const dados = $(this).val().split('\\');
	const name = dados[dados.length - 1];

	$('#result').css('display', 'flex');
	$('.title-img').html(name);
	
	$('.img-autor').hide();
	$('.fa-image').show();
});

const autor = new Autor();
autor.autorNome($('#autor'));
autor.autorDateNascimento($('#data_nascimento'));
autor.autorDesc($('#desc'));