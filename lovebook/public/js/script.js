$(document).ready(function() {
	// Divs com suporte do menu
	function divsHelpMenu() {
		let auxHelpSearch = true;
		let auxToolsUser = true;

		function fecharToolsUser() {
			if (auxToolsUser == false) {
				$('.tools-user').slideUp('fast', function() {
					auxToolsUser = true;
				});
			}
		}

		function abrirToolsUser() {
			if (auxToolsUser) {
				$('.tools-user').slideDown('fast', function() {
					auxToolsUser = false;
				});
			}
		}

		function fecharHelpSearch() {
			if (auxHelpSearch) {
				$('.help-search').slideUp('media', function() {
					auxHelpSearch = false;
				});
			} else {
				setTimeout(function() {
					fecharHelpSearch();
				}, 300)
			}
		}

		function abrirHelpSearch() {
			$('.help-search').slideDown('slow', function() {
				auxHelpSearch = true;
			});
		}


		$('body').on('mouseenter', '.container-user', () => {
			fecharHelpSearch();
			abrirToolsUser();
		});

		$('body').on('mouseleave', '.container-user', () => {
			fecharToolsUser();
		});

		$('body').on('click', '.container-user', () => {
			$('.tools-user').slideToggle('slow');
		});

		$('body').on('focus', '#busca', () => {
			fecharToolsUser();
			abrirHelpSearch();
		});

		$('body').on('click', '#busca', () => {
			abrirHelpSearch();
		});

		$('body').on('blur', '#busca', () => {
			fecharHelpSearch();
		});
	}
	divsHelpMenu();

	// Hamburguer
	function hamburguer() {
		$('body').on('click', '#hamburguer', () => {
			$('.menu').slideToggle('slow');
		})
	}
	hamburguer();


	function search() {
		$('body').on('keyup', '#busca', function(e) {
			let text = $(this).val();
			$.ajax({
				type: 'GET',
				url: '/search',
				data: {text: text},
				dataType: 'json',
				success: dados => {
					$('.search-content-autores').html('');
					$('.search-content-books').html('');

					const total = 7 // 5 books 2 autores

					let contadorBooks = 0;
					for (let indice in dados['books']) {
						let book = dados['books'][indice];

						$('.search-content-books').append(`
							<li class="list-book-item">
								<a href="/livros/livro?book=${book.diretorio}&autor=${book.diretorio_autor}" class="list-book-link group-list">${book.titulo}</a>	
							</li>
						`);

						contadorBooks++;
					}

					let numAutores = total - contadorBooks;
					for (let indice in dados['autores']) {
						let autor = dados['autores'][indice];
						
						if (indice < numAutores) {
							$('.search-content-autores').append(`
								<li class="list-book-item">
									<a href="/autores/autor?autor=${autor.diretorio}" class="list-book-link group-list">${autor.nome}</a>	
								</li>
							`);
						}
					}

				},

				error: () => {
					console.log('error');
				}
			});	

		});
	}

	search();


});