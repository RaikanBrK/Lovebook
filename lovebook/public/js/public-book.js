$('body').on('change', '#image', function(e) {
	const dados = $(this).val().split('\\');
	const name = dados[dados.length - 1];

	$('#result').css('display', 'flex');
	$('.title-img').html(name);
	$('#content-img .help-digit').html('');
	$('#content-img .fa-image').removeClass('focus_erro_img');
});


const book = new Book();
book.bookTitle($('#titulo'));
book.bookDateLancamento($('#data_lancamento'));
book.bookPreco($('#preco'));
book.bookPaginas($('#paginas'));
book.bookDesc($('#desc'));
book.bookSendImg($('#send'), $('#image'));