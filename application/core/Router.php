<?php  

namespace application\core;


class Router 
{

	protected $routes = [];
	protected $params = [];

	function __construct()
	{	
		$arr = require 'application/config/routes.php';
		//debug($arr); 

		foreach ($arr as $key => $val) {
			$this->add($key, $val);
			
		}
		//debug($this->routes);
	}

	// добавление маршрута
	public function add($route, $params) 
	{
		$route = '#^'.$route.'$#';
		
		$this->routes[$route] = $params;
		//echo '<pre>', print_r($params), '</pre>';

	}
	// проверка маршрута, ест ли такой марш
	public function match() 
	{
		// получаем текущий url
		$url = trim($_SERVER['REQUEST_URI'], '/');

		//debug($url);
		foreach ($this->routes as $route => $params) {
			if (preg_match($route, $url, $matches)) {
				$this->params = $params;
				return true;
				
			}
		}
		return false;
	}
	// запуск маршрута
	public function run() 
	{
		//echo 'run';


		if ($this->match()) {
			$path = 'application\controllers\\'.ucfirst($this->params['controller']).'Controller';

			if (class_exists($path)) {
				$action = $this->params['action'].'Action';

				if (method_exists($path, $action)) {
					$controller = new $path($this->params);
					$controller->$action(); 
				}
				else {
					echo 'Not found action '.$action;
				}
			}
			else {
				echo 'Not found '.$path;
			}

			//echo $controller;
			// echo '<p>Controller: <b>'.$this->params['controller'].'</b></p>';
			// echo '<p>Action: <b>'.$this->params['action'].'</b></p>';
		}
		else {
			//echo 'Not found';
		}
		
	}


}