$('body').on('click', '.cartao a', function(e) {
	e.preventDefault();
	let id = $(this).closest('.cartao').attr('data-id');
	
	window.location = '/dashboard/editando_livro?id=' + id;
});