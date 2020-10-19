$('body').on('click', 'tbody > tr', function(e) {
	let id = $(this).closest('tbody > tr').attr('data-id');

	$('#confirmacao').slideDown('slow');

	$('.send').attr('data-id', id);
});

$('body').on('click', '.cancel', function(e) {
	$('#confirmacao').slideUp('slow');	
});

$('body').on('click', '.send', function(e) {
	let id = $(this).attr('data-id');
	window.location = '/dashboard/remover_administrador_adm?id=' + id;
});
