<?php  
	
namespace App;
use MF\Init\Bootstrap;

class Route extends Bootstrap {

	protected function initRoutes() {
		$routes['home'] = array(
			"route" => "/",
			"controller" => "IndexController",
			"action" => "index"
		);

		$routes['books'] = array(
			"route" => "/livros",
			"controller" => "IndexController",
			"action" => "books"
		);

		$routes['book'] = array(
			"route" => "/livros/livro",
			"controller" => "IndexController",
			"action" => "booksPay"
		);

		$routes['autores'] = array(
			"route" => "/autores",
			"controller" => "IndexController",
			"action" => "autores"
		);

		$routes['autor'] = array(
			"route" => "/autores/autor",
			"controller" => "IndexController",
			"action" => "autor"
		);

		$routes['configuracoes'] = array(
			"route" => "/configuracoes",
			"controller" => "IndexController",
			"action" => "configuracoes"
		);

		$routes['updateDadosAccount'] = array(
			"route" => "/updateDadosAccount",
			"controller" => "IndexController",
			"action" => "updateDadosAccount"
		);

		$routes['myBooks'] = array(
			"route" => "/meus_livros",
			"controller" => "IndexController",
			"action" => "myBooks"
		);

		$routes['myFavoritos'] = array(
			"route" => "/meus_favoritos",
			"controller" => "IndexController",
			"action" => "myFavoritos"
		);

		$routes['search'] = array(
			"route" => "/search",
			"controller" => "IndexController",
			"action" => "search"
		);

		$routes['login'] = array(
			"route" => "/login",
			"controller" => "AuthController",
			"action" => "login"
		);

		$routes['cadastro'] = array(
			"route" => "/cadastro",
			"controller" => "AuthController",
			"action" => "cadastro"
		);

		$routes['criarCadastroUser'] = array(
			"route" => "/criarCadastroUser",
			"controller" => "AuthController",
			"action" => "criarCadastroUser"
		);

		$routes['logarUserAccount'] = array(
			"route" => "/logarUserAccount",
			"controller" => "AuthController",
			"action" => "logarUserAccount"
		);

		$routes['loginUserAdministrador'] = array(
			"route" => "/login_adm",
			"controller" => "AuthController",
			"action" => "loginUserAdministrador"
		);

		$routes['loginAdminitrador'] = array(
			"route" => "/login_adminitrador",
			"controller" => "AuthController",
			"action" => "loginAdminitrador"
		);

		$routes['loggout'] = array(
			"route" => "/loggout",
			"controller" => "AuthController",
			"action" => "loggout"
		);

		$routes['loggout_adm'] = array(
			"route" => "/loggout_adm",
			"controller" => "AuthController",
			"action" => "loggout_adm"
		);

		$routes['dashboard'] = array(
			"route" => "/dashboard",
			"controller" => "AdminController",
			"action" => "dashboard"
		);

		$routes['listBooks'] = array(
			"route" => "/dashboard/lista_livros",
			"controller" => "AdminController",
			"action" => "listBooks"
		);

		$routes['public_book'] = array(
			"route" => "/dashboard/publicar_livro",
			"controller" => "AdminController",
			"action" => "public_book"
		);

		$routes['publicBookAdm'] = array(
			"route" => "/dashboard/public_book_adm",
			"controller" => "AdminController",
			"action" => "publicBookAdm"
		);

		$routes['editBook'] = array(
			"route" => "/dashboard/editar_livro",
			"controller" => "AdminController",
			"action" => "editBook"
		);

		$routes['alterBook'] = array(
			"route" => "/dashboard/editando_livro",
			"controller" => "AdminController",
			"action" => "alterBook"
		);

		$routes['alterBookAdm'] = array(
			"route" => "/dashboard/alter_book_adm",
			"controller" => "AdminController",
			"action" => "alterBookAdm"
		);

		$routes['removeBook'] = array(
			"route" => "/dashboard/remover_livro",
			"controller" => "AdminController",
			"action" => "removeBook"
		);

		$routes['removeBookAdm'] = array(
			"route" => "/dashboard/remove_book_adm",
			"controller" => "AdminController",
			"action" => "removeBookAdm"
		);

		$routes['listaAutores'] = array(
			"route" => "/dashboard/lista_autores",
			"controller" => "AdminController",
			"action" => "listaAutores"
		);

		$routes['criarAutor'] = array(
			"route" => "/dashboard/criar_autor",
			"controller" => "AdminController",
			"action" => "criarAutor"
		);

		$routes['createAutorAdm'] = array(
			"route" => "/dashboard/create_autor_adm",
			"controller" => "AdminController",
			"action" => "createAutorAdm"
		);

		$routes['editarAutor'] = array(
			"route" => "/dashboard/editar_autor",
			"controller" => "AdminController",
			"action" => "editarAutor"
		);

		$routes['editAutor'] = array(
			"route" => "/dashboard/editando_autor",
			"controller" => "AdminController",
			"action" => "editAutor"
		);

		$routes['editandoAutorAdm'] = array(
			"route" => "/dashboard/editando_autor_adm",
			"controller" => "AdminController",
			"action" => "editandoAutorAdm"
		);	

		$routes['removeAutor'] = array(
			"route" => "/dashboard/remover_autor",
			"controller" => "AdminController",
			"action" => "removeAutor"
		);

		$routes['removeAutorAdm'] = array(
			"route" => "/dashboard/remove_autor_adm",
			"controller" => "AdminController",
			"action" => "removeAutorAdm"
		);

		$routes['criarAdministrador'] = array(
			"route" => "/dashboard/criar_administrador",
			"controller" => "AdminController",
			"action" => "criarAdministrador"
		);

		$routes['createAdm'] = array(
			"route" => "/dashboard/createAdm",
			"controller" => "AdminController",
			"action" => "createAdm"
		);

		$routes['listaAdministradores'] = array(
			"route" => "/dashboard/lista_administradores",
			"controller" => "AdminController",
			"action" => "listaAdministradores"
		);

		$routes['removerAdministrador'] = array(
			"route" => "/dashboard/remover_administrador",
			"controller" => "AdminController",
			"action" => "removerAdministrador"
		);

		$routes['removerAdministradorAdm'] = array(
			"route" => "/dashboard/remover_administrador_adm",
			"controller" => "AdminController",
			"action" => "removerAdministradorAdm"
		);

		$routes['editarConta'] = array(
			"route" => "/dashboard/editar_conta",
			"controller" => "AdminController",
			"action" => "editarConta"
		);

		$routes['editAccountAdm'] = array(
			"route" => "/dashboard/editAccountAdm",
			"controller" => "AdminController",
			"action" => "editAccountAdm"
		);	

		$routes['favoritar'] = array(
			"route" => "/favoritarBook",
			"controller" => "IndexController",
			"action" => "favoritarBook"
		);

		$routes['removerFavoritoBook'] = array(
			"route" => "/removerFavoritoBook",
			"controller" => "IndexController",
			"action" => "removerFavoritoBook"
		);

		$routes['payBook'] = array(
			"route" => "/payBook",
			"controller" => "IndexController",
			"action" => "payBook"
		);

		$this->setRoutes($routes);
	}
}
?>