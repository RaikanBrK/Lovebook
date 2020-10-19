$('body').on('click', '.autor a', function(e) {
	e.preventDefault();
	let id = $(this).closest('.autor').attr('data-id');
	
	window.location = '/dashboard/editando_autor?id=' + id;
});
