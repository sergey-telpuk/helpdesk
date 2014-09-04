<?php

	class FrontController extends Config{
		static private $_instance = null;
		private $_controller, $_action, $_content ,$_body, $_params = [];

		private function __construct(){
			$this->getConfig();

			$request = $_SERVER["REQUEST_URI"];

			$router  = explode("/", trim($request, '/'));

			if(($key = array_search(DIR_PROJECT, $router)) !== false)
			{
				unset($router[$key]);
			}

			$this->setController(!empty($router[1]) ? ucfirst(strtolower($router[1]))."Controller" :
				"IndexController");



			$this->setAction(!empty($router[2]) ? strtolower($router[2]).'Action' : "indexAction");

			$this->_checkSession($this->getController());

			if( !empty($router[3]) ){
				$paramsSlice = array_slice($router, 3);
				$params = array();

				foreach($paramsSlice as $key => $value){
					if( $key % 2 === 0){
						if(empty($paramsSlice[$key+1])){
							$params[$value] = '';
							continue;
						}
						$params[$value] = $paramsSlice[$key+1];
					}
				}
				$this->setParams($params);

			}
		}

		private function __clone(){}

		protected function getConfig(){
			$this->_setConfigBd(require_once "config_bd.php");
			$this->_setConfigUrl(require_once "config_url.php");
		}

		private  function _checkSession($controller){
			$sessionControllers = new SessionController();

			foreach($sessionControllers->getControllers() as $key => $valueCntr){
				if($controller === $valueCntr){
					if(!isset($_SESSION['id'])){
						header("Location: http://".HOST."/".DIR_PROJECT."/authorization/index");
						exit;
					}
				}
			}

		}

		public function getParams(){
			return $this->_params;
		}
		public function getAction(){
			return $this->_action;
		}
		public function getController(){
			return $this->_controller;
		}
		public function getContent(){
			return $this->_content;
		}
		public function setContent( $content){
			$this->_content = $content;
		}
		public function getBody(){
			return $this->_content;
		}
		public function setParams($params){
			$this->_params = $params;
		}
		public function setAction($action){
			$this->_action = $action;
		}
		public function setController($controller){
			$this->_controller = $controller;
		}
		public function setBody($body){
			$this->_body = $body;
		}

		public function run(){
			if(class_exists($this->getController())){
				$class = new ReflectionClass($this->getController());

				if( $class->hasMethod($this->getAction()) ){

					$controller = $class->newInstance();

					$method = $class->getMethod($this->getAction());

					$this->setContent($method->invoke($controller));

				}else{
					$error = new ErrorController();
					$this->setContent($error->indexAction());
				}
			}else{
				$error = new ErrorController();
				$this->setContent($error->indexAction());
			}


		}

		static public function getInstance(){
			if(self::$_instance instanceof self){
				return self::$_instance;
			}
			self::$_instance = new FrontController();
			return  self::$_instance;
		}



	}