function getParamUrl() {
	let url = window.location.search.replace('?', '').split('&');

	let dados = {};
	url.forEach(item => {
		let content = item.split('=');
		dados[content[0]] = content[1];
	})
	return dados;
}


const dados = getParamUrl();


$('body').on('click', '#comprar', function(e) {
	$('#confirm').fadeIn('slow');
});

$('body').on('click', '.cancel', function(e) {
	$('#confirm').fadeOut('slow');
});


$('body').on('click', '.fa-heart', function(e) {
	let id = $(this).attr('id');

	validHeart(this, id);
});

$('body').on('click', '#favoritando .content-info-book-result', function(e) {
	let element = $(this).closest('#favoritando').find('.fa-heart');
	let id = element.attr('id');

	validHeart(element, id);
});

function validHeart(elemet, id) {
	if (id == 'heart-f') {
		$(elemet).before('<i class="fas fa-heart" id="heart-rf" title="Remover favorito"></i>');

		$.ajax({
			type: 'GET',
			url: '/favoritarBook',
			data: {book: dados['book'], autor: dados['autor']},
			dataType: 'html',
			success: dados => {
			},

			error: () => {
			}
		});	


		elemet.remove();
	} else {
		$(elemet).before('<i class="far fa-heart" id="heart-f" title="Favoritar"></i>');

		$.ajax({
			type: 'GET',
			url: '/removerFavoritoBook',
			data: {book: dados['book'], autor: dados['autor']},
			dataType: 'html',
			success: dados => {
			},

			error: () => {
			}
		});

		elemet.remove();
	}
}