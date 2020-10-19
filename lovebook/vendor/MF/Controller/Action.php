<?php 

namespace MF\Controller;

abstract class Action {
	protected $view;

	public function __construct() {
		date_default_timezone_set('America/Sao_Paulo');
		$this->view = new \stdClass();
	}

	public function __set($attr, $value) {
		$this->$attr = $value;
	}

	public function __get($attr) {
		return $this->$attr;
	}

	public function startSession() {
		if (!isset($_SESSION)) {
			session_start();
		}
	}

	protected function verificaNoAuth() {
		if (!isset($_SESSION)) {
			session_start();
		}
		return !(isset($_SESSION['user']['auth']) && isset($_SESSION['user']['auth']['id']));
	} 

	protected function redNoAccount() {
		if (!isset($_SESSION)) {
			session_start();
		}

		if (isset($_SESSION['user']['auth']) && isset($_SESSION['user']['auth']['id'])) {
			return true;
		} else {
			header('location: /login');
			die();
		}

	} 

	protected function verificaNoAdm() {
		if (!isset($_SESSION)) {
			session_start();
		}
		return !(isset($_SESSION['adm']) && isset($_SESSION['adm']['id']));
	}

	protected function redNoAdm() {
		if (!isset($_SESSION)) {
			session_start();
		}

		if (isset($_SESSION['adm']) && isset($_SESSION['adm']['id']) ) {
			return true;
		} else {
			header('location: /login_adm');
			die();
		}
	}


	protected function render($view, $layout = 'layout') {
		$this->view->page = $view;

		if (file_exists("../App/Views/".$layout.".phtml")) {
			require_once("../App/Views/".$layout.".phtml");
		} else {
			$this->content();
		}
	}

	protected function content() {
		$classAtual = get_class($this);
		$classAtual = str_replace('App\\Controllers\\', '', $classAtual);
		$classAtual = str_replace('Controller', '', $classAtual);
	
		require_once('../App/Views/'.$classAtual.'/'.$this->view->page.'.phtml');
	}
}



?>