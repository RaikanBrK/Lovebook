<?php 

namespace App\Controllers;
use MF\Controller\Action;
use MF\Model\Container;
use App\Controllers\RegrasUsuarios;

class AuthController extends Action {

	public function login() {
		$this->view->css = ['login'];
		$this->view->controller = true;
		
		$this->render('login', 'layoutAuth');
	}

	public function cadastro() {
		$this->view->css = ['cadastro'];
		$this->view->js = ['form-autenticacao', 'mask', 'cadastro'];
		$this->view->controller = false;
		
		$this->render('cadastro', 'layoutAuth');
	}

	public function criarCadastroUser() {
		$this->startSession();
		$regras = new RegrasUsuarios();

		if (
			$regras->validarString($_POST['nome']) &&
			$regras->validarSobrenome($_POST['sobrenome']) &&
			$regras->validarString($_POST['usuario']) &&
			$regras->validarEmail($_POST['email']) &&
			$regras->validarCpf($_POST['cpf']) &&
			$regras->validarCep($_POST['cep']) &&
			$regras->validarNumero($_POST['numero']) &&
			$regras->compararSenhas($_POST['senha'], $_POST['confirmSenha']) &&
			$regras->validarSenha($_POST['senha'])	
		) {
			$nome = trim($_POST['nome']);
			$sobrenome = trim($_POST['sobrenome']);
			$usuario = '@' . trim($_POST['usuario']);
			$email = trim($_POST['email']);
			$cpf = trim($_POST['cpf']);
			$cep = trim($_POST['cep']);
			$numero = trim($_POST['numero']);
			$senha = base64_encode(trim($_POST['senha']));
			$confirmSenha = trim($_POST['confirmSenha']);

			$usuarios = Container::getModel('Usuarios');
			$usuarios->__set('nome', $nome);
			$usuarios->__set('sobrenome', $sobrenome);
			$usuarios->__set('usuario', $usuario);
			$usuarios->__set('email', $email);
			$usuarios->__set('cpf', $cpf);
			$usuarios->__set('cep', $cep);
			$usuarios->__set('numero', $numero);
			$usuarios->__set('senha', $senha);
			$usuarios->__set('confirmSenha', $confirmSenha);
			
			if ($usuarios->createUser()) {
				$_SESSION['lovebook']['auth']['status'] = true;
			} else {
				$_SESSION['lovebook']['auth']['status'] = false;
				$_SESSION['lovebook']['auth']['error']['mensagem'] = 'Já  existe um usuário registrado com os dados fornecidos.';
			}

			header('location: /cadastro');
		} else {
			$_SESSION['lovebook']['auth']['status'] = false;
			header('location: /cadastro');
		}
	}

	public function logarUserAccount() {
		$usuarios = Container::getModel('Usuarios');
		$usuarios->__set('usuario', $_POST['usuario']);
		$usuarios->__set('senha', base64_encode($_POST['senha']));
		$user = $usuarios->logarUserAccount();
		
		$this->startSession();

		if (count($user) != 0 && isset($user['id'])) {
			$_SESSION['user']['auth']['id'] = $user['id'];

			unset($_SESSION['lovebook']['auth']);
			header('location: /');

		} else {
			$_SESSION['lovebook']['auth']['status'] = false;
			header('location: /login');
		}
	}

	public function loginUserAdministrador() {
		$this->view->css = ['login_administrativo'];
		
		$this->render('loginAdministrativo', 'layoutAuthAdm');
	}

	public function loginAdminitrador() {
		$this->startSession();
		$adm = Container::getModel('Administradores');
		$adm->__set('usuario', $_POST['usuario']);
		$adm->__set('senha', base64_encode($_POST['senha']));
		$user_adm = $adm->loginAdministrativo();

		if (count($user_adm) == 0) {
			$_SESSION['auth']['notification']['msg'] = 'Erro ao realizar o login';
			header('location: /login_adm');
		} else {
			$_SESSION['adm']['id'] = $user_adm[0]['id'];
			header('location: /dashboard');
		}
	}

	public function loggout() {
		$this->startSession();
		unset($_SESSION['user']);
		header('location: /login');
	}

	public function loggout_adm() {
		$this->startSession();
		unset($_SESSION['adm']);
		header('location: /login_adm');
	}
} 
	
?>