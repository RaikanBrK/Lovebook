<?php 

namespace App\Controllers;
use MF\Controller\Action;
use MF\Model\Container;
use App\Controllers\CreateImagem;
use App\Controllers\RegrasLivro;
use App\Controllers\RegrasAutores;
use App\Controllers\RegrasAdministradores;
use App\Controllers\RenderBook;
use App\Controllers\RenderAutores;
use App\Controllers\RenderAdministradores;


class AdminController extends Action {

	public function dashboard() {
		$this->redNoAdm();
		$this->view->css = ['renderBook'];
		$this->view->title = 'Dashboard';

		$book = Container::getModel('Books');

		$this->view->newBooks = $book->getBookLimit(4);
		$this->view->renderBook = new RenderBook();
		

		$this->render('dashboard', 'layoutDashboard');
	}

	public function listBooks() {
		$this->redNoAdm();
		$this->view->css = ['renderBook'];
		$this->view->title = 'Lista de livros';

		$book = Container::getModel('Books');

		$this->view->newBooks = $book->getBookLimit(20);
		$this->view->renderBook = new RenderBook();
		

		$this->render('listBooks', 'layoutDashboard');
	}
		
	public function public_book() {
		$this->redNoAdm();
		$this->view->css = ['public-book'];
		$this->view->js = ['form-book', 'public-book'];
		$this->view->title = 'Publicar Livro';

		$autores = Container::getModel('Autores');
		$this->view->autores = $autores->getAllAutores();


		$this->render('public_book', 'layoutDashboard');
	}

	public function publicBookAdm() {
		$this->redNoAdm();

		$livros = new RegrasLivro();

		if (
			$livros->validarTitulo($_POST['titulo']) &&
			$livros->validarAutor($_POST['autor']) &&
			$livros->validarDateLancamento($_POST['data_lancamento']) &&
			$livros->validarPreco($_POST['preco']) &&
			$livros->validarPaginas($_POST['paginas']) && 
			$livros->validarDesc($_POST['desc'])
		) {

			$book = Container::getModel('Books');

			$book->__set('titulo', $_POST['titulo']);
			$book->__set('id_autor', $_POST['autor']);

			if ($book->validBookAutorTitle()) {
				
				$book->__set('data_lancamento', $_POST['data_lancamento']);
				$book->__set('preco', $_POST['preco']);
				$book->__set('paginas', $_POST['paginas']);
				$book->__set('desc_book', $_POST['desc']);
				$id = $book->createBook();

				$createImagem = new CreateImagem();
				$createImagem->__set('id', $id);
				$createImagem->__set('path', 'imagens/books/');
				$createImagem->__set('input', 'image');

				$createImagem->excluindoPossiveisArquivosClone();
				$createImagem->__set('formatosPermitidos', ["png", "jpeg", "jpg"]);
				$createImagem->__set('files', $_FILES);

				$createImagem->arquivoTemporario();
				$imagem = $createImagem->criarImagem();
				$book->__set('id', $id);
				$book->__set('img', $imagem);
				$book->updateImg();


				$_SESSION['adm']['notification']['msg'] = 'Livro publicado com sucesso';
			} else {
				$_SESSION['adm']['notification']['msg'] = 'Livro já registrado no site';
			}

		} else {
			$_SESSION['adm']['notification']['msg'] = 'Algo deu errado... Verifique os dados e tente novamente';
		}

		header('location: /dashboard/publicar_livro');
	}

	public function editBook() {
		$this->redNoAdm();

		$this->view->css = ['renderBook'];
		$this->view->js = ['edit-book'];
		$this->view->title = 'Editar Livro';

		$book = Container::getModel('Books');

		$this->view->newBooks = $book->getBookLimit(12);
		$this->view->renderBook = new RenderBook();

		$this->render('edit_book', 'layoutDashboard');
	}

	public function alterBook() {
		$this->redNoAdm();

		$this->view->css = ['alter-book'];
		$this->view->js = ['form-book', 'alter-book'];
		$this->view->title = 'Editando Livro';

		$book = Container::getModel('Books');

		if (!isset($_GET['id'])) {
			header('location: /dashboard/editar_livro');
		}

		$book->__set('id', $_GET['id']);

		$autores = Container::getModel('Autores');
		$this->view->autores = $autores->getAllAutores();

		$this->view->book = $book->getBookFromId();

		if (!isset($this->view->book['id'])) {
			header('location: /dashboard/editar_livro');
		}

		$this->render('alterBook', 'layoutDashboard');
	}

	public function alterBookAdm() {
		$this->redNoAdm();

		$livros = new RegrasLivro();
		$query = '?id='.$_GET['id'];

		if (
			$livros->validarTitulo($_POST['titulo']) &&
			$livros->validarAutor($_POST['autor']) &&
			$livros->validarDateLancamento($_POST['data_lancamento']) &&
			$livros->validarPreco($_POST['preco']) &&
			$livros->validarPaginas($_POST['paginas']) && 
			$livros->validarDesc($_POST['desc'])
		) {

			$book = Container::getModel('Books');

			if (isset($_FILES['image']) && $_FILES['image']['error'] != 4) {
				$createImagem = new CreateImagem();
				$createImagem->__set('id', $_GET['id']);
				$createImagem->__set('path', 'imagens/books/');
				$createImagem->__set('input', 'image');

				$createImagem->excluindoPossiveisArquivosClone();
				$createImagem->__set('formatosPermitidos', ["png", "jpeg", "jpg"]);
				$createImagem->__set('files', $_FILES);

				$createImagem->arquivoTemporario();
				$imagem = $createImagem->criarImagem();
			} else {
				$imagem = '';
			}
		
			$book->__set('titulo', $_POST['titulo']);
			$book->__set('id_autor', $_POST['autor']);
			$book->__set('id', $_GET['id']);

			if ($book->validBookAutorTitle()) {
					
				$book->__set('img', $imagem);
				$book->__set('paginas', $_POST['paginas']);
				$book->__set('desc_book', $_POST['desc']);
				$book->__set('data_lancamento', $_POST['data_lancamento']);
				$book->__set('preco', $_POST['preco']);
				
				$book->updateBook();

				header('location: /dashboard/editar_livro');
				$_SESSION['adm']['notification']['msg'] = 'Livro editado com sucesso';

			} else {
				$_SESSION['adm']['notification']['msg'] = 'Livro já registrado no site';
				header('location: /dashboard/editando_livro'.$query);
			}
			
		} else {
			$_SESSION['adm']['notification']['msg'] = 'Algo deu errado... Verifique os dados e tente novamente';
			header('location: /dashboard/editando_livro'.$query);
		}
	}

	public function removeBook() {
		$this->redNoAdm();

		$this->view->css = ['remover-book' ,'renderBook'];
		$this->view->js = ['remover-book'];
		$this->view->title = 'Remover Livro';

		$book = Container::getModel('Books');

		$this->view->newBooks = $book->getBookLimit(12);
		$this->view->renderBook = new RenderBook();

		$this->view->book = $book->getBookFromId();
		$this->render('removeBook', 'layoutDashboard');
	}

	public function removeBookAdm() {
		$this->redNoAdm();

		$createImagem = new CreateImagem();
		$createImagem->__set('path', 'imagens/books/');
		$createImagem->excluindoImagem([$_GET['id']]);

		$favoritos = Container::getModel('Favoritos');
		$favoritos->__set('id_book', $_GET['id']);
		$favoritos->removeFavoritoFromBook();

		$pays = Container::getModel('Pay');
		$pays->__set('id_book', $_GET['id']);
		$pays->removePayFromBook();

		$book = Container::getModel('Books');
		$book->__set('id', $_GET['id']);
		$book->removeBookFromId();

		$_SESSION['adm']['notification']['msg'] = 'Livro removido com sucesso';
		header('location: /dashboard/remover_livro');
	}

	public function listaAutores() {
		$this->redNoAdm();

		$this->view->css = ['autor', 'editar-autor'];
		$this->view->title = 'Lista de autores';

		$autor = Container::getModel('Autores');
		$this->view->autores = $autor->getAutores(16, 0);
		$this->view->renderAutores = new RenderAutores();

		$this->render('listaAutores', 'layoutDashboard');
	}

	public function criarAutor() {
		$this->redNoAdm();

		$this->view->css = ['criar-autor'];
		$this->view->js = ['form-autor', 'criar-autor'];
		$this->view->title = 'Criar Autor';

		$this->render('criarAutor', 'layoutDashboard');
	}

	public function createAutorAdm() {
		$this->redNoAdm();

		$civil = isset($_POST['esCivil']) ? $_POST['esCivil'] : '';

		$autor = Container::getModel('Autores');

		$regrasAutor = new RegrasAutores();
		if (
			$regrasAutor->validarString($_POST['autor']) &&
			$regrasAutor->validarEstadoCivil($civil) &&
			$regrasAutor->validarDateNascimento($_POST['data_nascimento']) &&
			$regrasAutor->validarDesc($_POST['desc'])
		) {
			$autor->__set('nome', trim($_POST['autor']));
			$autor->__set('desc_autor', trim($_POST['desc']));
			$autor->__set('estado_civil', trim($civil));
			$autor->__set('data_nascimento', trim($_POST['data_nascimento']));
			$num = $autor->validarAutor();

			if (count($num) == 0) {
				if (isset($_FILES['image']) && $_FILES['image']['error'] != 4) {

					$id = $autor->createAutor();

					$createImagem = new CreateImagem();
					$createImagem->__set('id', $id);
					$createImagem->__set('path', 'imagens/autores/');
					$createImagem->__set('input', 'image');

					$createImagem->excluindoPossiveisArquivosClone();
					$createImagem->__set('formatosPermitidos', ["png", "jpeg", "jpg"]);
					$createImagem->__set('files', $_FILES);

					$createImagem->arquivoTemporario();
					$imagem = $createImagem->criarImagem();
					$autor->__set('id', $id);
					$autor->__set('img', $imagem);
					$autor->updateImg();

					$_SESSION['adm']['notification']['msg'] = 'Autor criado com sucesso';
				} else {
					$_SESSION['adm']['notification']['msg'] = 'Imagem inválida';
				}
			} else {
				$_SESSION['adm']['notification']['msg'] = 'Nome já existente';
			}

		} else {
			$_SESSION['adm']['notification']['msg'] = 'Algo deu errado... Verifique seus dados e tente novamente';
		}

		header('location: /dashboard/criar_autor');	
	}

	public function editarAutor() {
		$this->redNoAdm();

		$this->view->css = ['autor', 'editar-autor'];
		$this->view->js = ['editar-autor'];
		$this->view->title = 'Editar Autor';

		$autor = Container::getModel('Autores');
		$this->view->autores = $autor->getAutores(16, 0);
		$this->view->renderAutores = new RenderAutores();

		$this->render('editarAutor', 'layoutDashboard');
	}
	
	public function editAutor() {
		$this->redNoAdm();

		$this->view->css = ['editando-autor'];
		$this->view->js = ['form-autor', 'editando-autor'];
		$this->view->title = 'Editando Autor';

		if (!isset($_GET['id'])) {
			header('location: /dashboard/editar_autor');
		}
		
		$autores = Container::getModel('Autores');
		$autores->__set('id', $_GET['id']);
		$this->view->autor = $autores->getAutorFromId();

		if (!isset($this->view->autor['id'])) {
			header('location: /dashboard/editar_autor');
		}

		$this->render('editAutor', 'layoutDashboard');
	}

	public function editandoAutorAdm() {
		$this->redNoAdm();

		$civil = isset($_POST['esCivil']) ? $_POST['esCivil'] : '';
		$autor = Container::getModel('Autores');

		$regrasAutor = new RegrasAutores();
		if (
			$regrasAutor->validarString($_POST['autor']) &&
			$regrasAutor->validarEstadoCivil($civil) &&
			$regrasAutor->validarDateNascimento($_POST['data_nascimento']) &&
			$regrasAutor->validarDesc($_POST['desc'])
		) {
			$autor->__set('id', $_GET['id']);
			$autor->__set('nome', trim($_POST['autor']));
			$autor->__set('desc_autor', trim($_POST['desc']));
			$autor->__set('estado_civil', trim($civil));
			$autor->__set('data_nascimento', trim($_POST['data_nascimento']));
			$num = $autor->validarAutorEdit();

			if (count($num) == 0) {

				if (isset($_FILES['image']) && $_FILES['image']['error'] != 4) {
					$createImagem = new CreateImagem();
					$createImagem->__set('id', $_GET['id']);
					$createImagem->__set('path', 'imagens/autores/');
					$createImagem->__set('input', 'image');

					$createImagem->excluindoPossiveisArquivosClone();
					$createImagem->__set('formatosPermitidos', ["png", "jpeg", "jpg"]);
					$createImagem->__set('files', $_FILES);

					$createImagem->arquivoTemporario();
					$imagem = $createImagem->criarImagem();
				} else {
					$imagem = '';
				}

				$autor->__set('img', $imagem);
				$autor->updateAutor();

				$_SESSION['adm']['notification']['msg'] = 'Autor editado com sucesso';
				header('location: /dashboard/editar_autor');
				
			} else {
				$_SESSION['adm']['notification']['msg'] = 'Nome já existente';
				header('location: /dashboard/editando_autor?id='. $_GET['id']);
			}
		} else {
			$_SESSION['adm']['notification']['msg'] = 'Algo deu errado... Verifique seus dados e tente novamente';
			header('location: /dashboard/editando_autor?id='. $_GET['id']);
		}
	}

	public function removeAutor() {
		$this->redNoAdm();

		$this->view->css = ['autor', 'remover-autor'];
		$this->view->js = ['remover-autor'];
		$this->view->title = 'Remover Autor';

		$autor = Container::getModel('Autores');
		$this->view->autores = $autor->getAutores(16, 0);
		$this->view->renderAutores = new RenderAutores();

		$this->render('removeAutor', 'layoutDashboard');
	}

	public function removeAutorAdm() {
		$this->redNoAdm();
		$id = $_GET['id'];

		$favoritos = Container::getModel('Favoritos');
		$favoritos->__set('id_autor', $id);
		$favoritos->removeFavoritossAssocFromAutor();

		$pays = Container::getModel('Pay');
		$pays->__set('id_autor', $id);
		$pays->removePayAssocFromAutor();

		$createImagem = new CreateImagem();
		$createImagem->__set('path', 'imagens/autores/');
		$createImagem->excluindoImagem([$id]);

		$book = Container::getModel('Books');
		$book->__set('id_autor', $id);
		$ids = $book->livrosAssocFromAutor($id);

		$list = [];
		foreach ($ids as $key => $id_book) {
			array_push($list, $id_book['id']);
		}

		$createImagem->__set('path', 'imagens/books/');
		$createImagem->excluindoImagem($list);
		$book->removeLivrosAssocFromAutor($id);

		$autores = Container::getModel('Autores');
		$autores->__set('id', $id);
		$autores->removeBooksFromAutor();
		$autores->removeAutor();

		$_SESSION['adm']['notification']['msg'] = 'Autor removido com sucesso';
		header('location: /dashboard/remover_autor');
	}

	public function criarAdministrador() {
		$this->redNoAdm();

		$this->view->js = ['form-administrador', 'criar-administrador'];
		$this->view->title = 'Criar Administrador';

		$this->render('criarAdministrador', 'layoutDashboard');
	}

	public function createAdm() {
		$this->redNoAdm();

		$regrasAdm = new RegrasAdministradores();

		if (
			$regrasAdm->validarString($_POST['nome']) &&
			$regrasAdm->validarSobrenome($_POST['sobrenome']) &&
			$regrasAdm->validarString($_POST['usuario']) &&
			$regrasAdm->validarEmail($_POST['email']) &&
			$regrasAdm->compararSenhas($_POST['senha'], $_POST['confirmSenha']) &&
			$regrasAdm->validarSenha($_POST['senha']) 
		) {
			$adm = Container::getModel('Administradores');

			$nome = trim($_POST['nome']);
			$sobrenome = trim($_POST['sobrenome']);
			$usuario = '#' . trim($_POST['usuario']);
			$email = trim($_POST['email']);
			$senha = base64_encode(trim($_POST['senha']));

			$adm->__set('nome', $nome);
			$adm->__set('sobrenome', $sobrenome);
			$adm->__set('usuario', $usuario);
			$adm->__set('email', $email);
			$adm->__set('senha', $senha);

			$valid = $adm->validarAdmExist();

			if (count($valid) == 0) {
				$adm->createAdministrador();
				$_SESSION['adm']['notification']['msg'] = 'Administrador criado com sucesso!';
			} else {
				$_SESSION['adm']['notification']['msg'] = 'Dados inválidos. Email ou usuário já existente';
			}
			
		} else {
			$_SESSION['adm']['notification']['msg'] = 'Algo deu errado... Verifique seus dados e tente novamente';
		}
		header('location: /dashboard/criar_administrador');
	}

	public function listaAdministradores() {
		$this->redNoAdm();

		$this->view->css = ['list-administradores'];
		$this->view->title = 'Lista de administrador';

		$adm = Container::getModel('Administradores');
		$this->view->adm = $adm->getAllAdministradores();
		$this->view->renderAdm = new RenderAdministradores();

		$this->render('listAdministradores', 'layoutDashboard');
	}

	public function removerAdministrador() {
		$this->redNoAdm();

		$this->view->css = ['list-administradores', 'remover-adm'];
		$this->view->js = ['remover-adm'];
		$this->view->title = 'Remover Administrador';

		$adm = Container::getModel('Administradores');
		$this->view->adm = $adm->getAllAdministradores();
		$this->view->renderAdm = new RenderAdministradores();


		$this->render('removerAdministrador', 'layoutDashboard');
	}

	public function removerAdministradorAdm() {
		$this->redNoAdm();

		$adm = Container::getModel('Administradores');
		$qtd = $adm->verificarQtdAdm();

		if ($qtd['num_adm'] > 1) {
			$adm->__set('id', $_GET['id']);
			$adm->excluirAdm();

			$_SESSION['adm']['notification']['msg'] = 'Administrador removido com sucesso';

		} else {
			$_SESSION['adm']['notification']['msg'] = 'O site deve ter ao menos 1 administrador';
		}

		header('location: /dashboard/remover_administrador');
	}

	public function editarConta() {
		$this->redNoAdm();

		$this->view->css = [];
		$this->view->js = ['form-administrador', 'edit-adm'];
		$this->view->title = 'Editar conta';

		$adm = Container::getModel('Administradores');
		$adm->__set('id', $_SESSION['adm']['id']);

		$this->view->adm = $adm->getAdmFromId();

		$this->render('editAdm', 'layoutDashboard');
	}

	public function editAccountAdm() {
		$this->redNoAdm();

		$regrasAdm = new RegrasAdministradores();

		if (
			$regrasAdm->validarString($_POST['nome']) &&
			$regrasAdm->validarSobrenome($_POST['sobrenome']) &&
			$regrasAdm->validarString($_POST['usuario']) &&
			$regrasAdm->validarEmail($_POST['email']) &&
			$regrasAdm->compararSenhas($_POST['senha'], $_POST['confirmSenha']) &&
			$regrasAdm->validarSenha($_POST['senha']) 
		) {
			$adm = Container::getModel('Administradores');

			$nome = trim($_POST['nome']);
			$sobrenome = trim($_POST['sobrenome']);
			$usuario = '#' . trim($_POST['usuario']);
			$email = trim($_POST['email']);
			$senha = base64_encode(trim($_POST['senha']));

			$adm->__set('id', $_SESSION['adm']['id']);
			$adm->__set('nome', $nome);
			$adm->__set('sobrenome', $sobrenome);
			$adm->__set('usuario', $usuario);
			$adm->__set('email', $email);
			$adm->__set('senha', $senha);

			$valid = $adm->validarAdmExistWithId();

			if (count($valid) == 0) {
				
				$adm->updateAdm();
				$_SESSION['adm']['notification']['msg'] = 'Administrador editado com sucesso!';
			} else {
				$_SESSION['adm']['notification']['msg'] = 'Dados inválidos. Email ou usuário já existente';
			}
			
		} else {
			$_SESSION['adm']['notification']['msg'] = 'Algo deu errado... Verifique seus dados e tente novamente';
		}
		header('location: /dashboard/editar_conta');
	}

} 
	
?>