<?php 

namespace App\Controllers;
use MF\Controller\Action;
use MF\Model\Container;
use App\Controllers\RenderBook;
use App\Controllers\RenderAutores;
use App\Controllers\RegrasUsuarios;

class IndexController extends Action {

	public function index() {
		$this->redNoAccount();

		$this->view->css = ['index', 'renderBook', 'autor'];

		$book = Container::getModel('Books');
		$autor = Container::getModel('Autores');
		
		$this->view->newBooks = $book->getBookLimit();
		$this->view->booksDestaque = $book->getBooksDestaques();
		$this->view->renderBook = new RenderBook();

		$this->view->autores = $autor->getAutores();
		$this->view->autoresDestaque = $autor->getAutoresDestaques();
		$this->view->renderAutores = new RenderAutores();

		$this->render('index');
	}

	public function books() {
		$this->redNoAccount();
		$this->view->css = ['renderBook'];
		$this->view->title = 'Lista de livros';

		$book = Container::getModel('Books');

		$this->view->newBooks = $book->getBookLimit(30);
		$this->view->renderBook = new RenderBook();
		$this->render('livros');
	}

	public function booksPay() {
		$this->redNoAccount();

		if (!isset($_GET['book']) && !isset($_GET['autor'])) {
			header('location: /livros');
		}

		$this->view->css = ['renderBook', 'books-pay'];
		$this->view->js = ['books-pay'];
		$this->view->title = 'Comprar livro';

		$book = Container::getModel('Books');

		$book->__set('titulo', RenderBook::convert_url($_GET['book']));
		$diretorio = RenderBook::convert_url($_GET['autor']);
		$this->view->book = $book->getBookFromBookAndAutor($diretorio);
		$this->view->book['diretorio_autor'] = $diretorio;
		
		if (!isset($this->view->book['id'])) {
			header('location: /livros');
		}

		$this->view->books = $book->getBookFromIdAutorException($this->view->book['id_autor'], $this->view->book['id'], 0, 3);

		$value = '';
		for ($i = 0; $i < count($this->view->books); $i++) { 
			$livro = $this->view->books[$i];

			if ($i != 0) {
				$value .= ',';
			}
			$value .= $livro['id'];
		}

		$this->view->other = $book->getBookRecomends($value);

		$favoritos = Container::getModel('Favoritos');

		$favoritos->__set('id_usuario', $_SESSION['user']['auth']['id']);
		$favoritos->__set('id_book', $this->view->book['id']);
		$favoritos->__set('id_autor', $this->view->book['id_autor']);
		$favorito = $favoritos->verificarFavorito();

		$this->view->favorito = count($favorito) > 0;
		$this->view->renderBook = new RenderBook();

		$pays = Container::getModel('Pay');
		$pays->__set('id_usuario', $_SESSION['user']['auth']['id']);
		$pays->__set('id_book', $this->view->book['id']);
		$pays->__set('id_autor', $this->view->book['id_autor']);
		$pay = $pays->verificarPay();
		
		$this->view->pay = count($pay) > 0;

		$this->render('booksPay');
	}

	public function autores() {
		$this->redNoAccount();

		$this->view->css = ['autor', 'editar-autor'];
		$this->view->title = 'Lista de autores';

		$autor = Container::getModel('Autores');
		$this->view->autores = $autor->getAutores(20, 0);
		$this->view->renderAutores = new RenderAutores();

		$this->render('listaAutores');
	}

	public function autor() {
		$this->redNoAccount();

		if (!isset($_GET['autor'])) {
			header('location: /autores');
		}

		$this->view->css = ['autores', 'renderBook'];

		$autor = Container::getModel('Autores');
		$autor->__set('nome', RenderAutores::convert_url_autor($_GET['autor']));		
		$this->view->autor = $autor->getAutorFromName();

		if (!isset($this->view->autor['id'])) {
			header('location: /autores');
		}			

		$book = Container::getModel('Books');
		$this->view->books = $book->getBookFromIdAutor($this->view->autor['id']);
		$this->view->renderBook = new RenderBook();

		$this->view->title = 'Autor '. $this->view->autor['nome'];

		$this->render('autor');
	}

	public function configuracoes() {
		$this->redNoAccount();

		$this->view->css = ['configuracoes'];
		$this->view->js = ['form-autenticacao', 'configuracoes', 'mask', 'scriptAuth'];

		$usuarios = Container::getModel('usuarios');
		$usuarios->__set('id', $_SESSION['user']['auth']['id']);

		$this->view->user = $usuarios->getUserFromId();
		$this->render('configuracoes');
	}

	public function updateDadosAccount() {
		$this->redNoAccount();
		$regras = new RegrasUsuarios();

		$alterSenha = isset($_POST['change-senha']);

		if (
			$regras->validarString($_POST['nome']) &&
			$regras->validarSobrenome($_POST['sobrenome']) &&
			$regras->validarString($_POST['usuario']) &&
			$regras->validarEmail($_POST['email']) &&
			$regras->validarCpf($_POST['cpf']) &&
			$regras->validarCep($_POST['cep']) &&
			$regras->validarNumero($_POST['numero'])
		) {
			$nome = trim($_POST['nome']);
			$sobrenome = trim($_POST['sobrenome']);
			$usuario = '@' . trim($_POST['usuario']);
			$email = trim($_POST['email']);
			$cpf = trim($_POST['cpf']);
			$cep = trim($_POST['cep']);
			$numero = trim($_POST['numero']);
			$senha = base64_encode(trim($_POST['senha']));
			$newSenha = base64_encode(trim($_POST['newSenha']));

			$usuarios = Container::getModel('Usuarios');
			$usuarios->__set('id', $_SESSION['user']['auth']['id']);
			$usuarios->__set('nome', $nome);
			$usuarios->__set('sobrenome', $sobrenome);
			$usuarios->__set('usuario', $usuario);
			$usuarios->__set('email', $email);
			$usuarios->__set('cpf', $cpf);
			$usuarios->__set('cep', $cep);
			$usuarios->__set('numero', $numero);
			$usuarios->updateDateAccount();

			$_SESSION['lovebook']['auth']['status'] = true;
			if ($alterSenha) {

				if ($usuarios->verificarAlteracaoSenha($senha) && $regras->validarSenha($newSenha)) {
					$usuarios->__set('senha', $newSenha);
					$usuarios->updateSenhaAccount();
				} else {
					$_SESSION['lovebook']['auth']['status'] = false;
					$_SESSION['lovebook']['auth']['error']['mensagem'] = 'Seus dados foram alterados com sucesso. Mas sua senha não foi alterada!';
				}
			}

			header('location: /configuracoes');
		} else {
			$_SESSION['lovebook']['auth']['status'] = false;
			header('location: /configuracoes');
		}
	}

	public function favoritarBook() {
		$this->redNoAccount();
		$books = Container::getModel('Books');
		$books->__set('titulo', RenderBook::convert_url($_GET['book']));
		$book = $books->getBookFromBookAndAutor(RenderAutores::convert_url_autor($_GET['autor']));

		$favorito = Container::getModel('Favoritos');
		$favorito->__set('id_usuario', $_SESSION['user']['auth']['id']);
		$favorito->__set('id_book', $book['id']);
		$favorito->__set('id_autor', $book['id_autor']);
		$favorito->setFavorito();
	}

	public function removerFavoritoBook() {
		$this->redNoAccount();
		$books = Container::getModel('Books');
		$books->__set('titulo', RenderBook::convert_url($_GET['book']));
		$book = $books->getBookFromBookAndAutor(RenderAutores::convert_url_autor($_GET['autor']));

		$favorito = Container::getModel('Favoritos');
		$favorito->__set('id_usuario', $_SESSION['user']['auth']['id']);
		$favorito->__set('id_book', $book['id']);
		$favorito->__set('id_autor', $book['id_autor']);
		$favorito->removeFavorito();
	}

	public function payBook() {
		$this->redNoAccount();

		$books = Container::getModel('Books');
		$books->__set('titulo', RenderBook::convert_url($_GET['book']));
		$book = $books->getBookFromBookAndAutor(RenderAutores::convert_url_autor($_GET['autor']));

		$pay = Container::getModel('Pay');
		$pay->__set('id_usuario', $_SESSION['user']['auth']['id']);
		$pay->__set('id_book', $book['id']);
		$pay->__set('id_autor', $book['id_autor']);
		$pay->pay();

		$_SESSION['user']['notification']['msg'] = 'Compra bem sucedida';
		header('location: /livros/livro?book='.$_GET['book'].'&autor='.$_GET['autor']);
	}

	public function myBooks() {
		$this->redNoAccount();

		$this->view->css = ['my-books', 'renderBook'];

		$book = Container::getModel('Books');
		$book->__set('id', $_SESSION['user']['auth']['id']);
		$this->view->books = $book->getBooksPay();
		$this->view->renderBook = new RenderBook();

		$this->render('myBooks');
	}

	public function myFavoritos() {
		$this->redNoAccount();

		$this->view->css = ['my-favoritos', 'renderBook'];

		$book = Container::getModel('Books');
		$book->__set('id', $_SESSION['user']['auth']['id']);
		$this->view->books = $book->getBookFavoritos();
		$this->view->renderBook = new RenderBook();

		$this->render('myFavoritos');
	}

	public function search() {
		$this->redNoAccount();

		$book = Container::getModel('Books');
		$autor = Container::getModel('Autores');
		
		$books = $book->searchBook($_GET['text']);

		foreach ($books as $key => $book) {
			$book->diretorio = RenderBook::convert_to_url($book->titulo);
			$book->diretorio_autor = RenderBook::convert_to_url($book->autor);
		}

		$autores = $autor->searchAutores($_GET['text']);

		foreach ($autores as $key => $autor) {
			$autor->diretorio = RenderAutores::convert_to_url($autor->nome);
		}

		$retorno['books'] = $books;
		
		$retorno['autores'] = $autores;	
		echo json_encode($retorno);
	}

} 
	
?>