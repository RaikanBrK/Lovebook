$(document).ready(function() {

	function hideMenu(desc, icon) {
		desc.slideUp('slow');

		icon.removeClass('animation-arrow-down');
		icon.addClass('animation-arrow-up');

		desc.removeClass('show');
	}

	function showMenu(desc, icon) {
		desc.slideDown('slow');

		icon.removeClass('animation-arrow-up');
		icon.addClass('animation-arrow-down');

		desc.addClass('show');
	}

	$('body').on('click', '.item-dashboard', function(e) {
		const desc = $(this).parent().find('.item-list-desc');
		const icon = $(this).find('.fa-caret-right');
		const idAtivo = $(this).closest('.itens-list-dashboard').attr('data-id');

		if (desc.hasClass('show')) {
			hideMenu(desc, icon);
		} else {			
			showMenu(desc, icon);
		}


		if ($('.show').length > 1) {
			for (var i = 0; i < $('.show').length; i++) {
				let dashboard = $($('.show')[i]).closest('.itens-list-dashboard');

				let descD = dashboard.find('.item-list-desc');
				let iconD = dashboard.find('.fa-caret-right');
				let id = dashboard.attr('data-id');
				
				if (idAtivo != id) {
					hideMenu(descD, iconD);
				}
			}
		}
	});


	$('body').on('click', '#hamburguer', function(e) {
		const element = $(this);

		$('.collection-dashboard');

		if (element.hasClass('show')) {

			$('.collection-dashboard').css('width', '100%');

			$('.title-collection-item').hide('slow');
			element.removeClass('show');

		} else {
			$('.title-collection-item').show('slow');
			element.addClass('show');

			$('.collection-dashboard').css('width', '0');
		}
	});

	if ($('.notificationDashboard').length > 0) {
		setTimeout(() => {
			$('.notificationDashboard').slideUp('slow');
		}, 8000)
	}
});