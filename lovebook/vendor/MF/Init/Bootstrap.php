<?php 

namespace MF\Init;

abstract class Bootstrap {
	private $routes = [];

	abstract protected function initRoutes(); 

	public function __construct() {
		$this->initRoutes();
		$this->run($this->getUrl());
	}

	public function getRoutes() {
		return $this->routes;
	}

	public function setRoutes(array $routes) {
		$this->routes = $routes;
	}

	protected function getUrl() {
		return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	}

	protected function routeDinamico($route) {
		$route = str_replace('{', '', $route);
		$route = str_replace('}', '', $route);
		return trim($route);
	}

	protected function run($url) {
		foreach ($this->getRoutes() as $key => $route) {
			if ($route['route'] == $url) {	
				
				$class = "App\\Controllers\\".ucfirst($route['controller']);
				$controller = new $class;

				$action = $route['action'];

				$controller->$action();
			}
		}
	}
}


?>