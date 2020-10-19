$('body').on('click', '.cartao a', function(e) {
	e.preventDefault();
	let id = $(this).closest('.cartao').attr('data-id');
	
	$('#confirmacao').slideDown('slow');

	$('.send').attr('data-id', id);
});

$('body').on('click', '.cancel', function(e) {
	$('#confirmacao').slideUp('slow');	
});

$('body').on('click', '.send', function(e) {
	let id = $(this).attr('data-id');
	window.location = '/dashboard/remove_book_adm?id=' + id;
});