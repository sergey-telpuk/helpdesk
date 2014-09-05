<?php

	abstract class IController{
		protected $_params = [];
		protected $_body;

		public function __construct(){
			$fc = FrontController::getInstance();
			$this->_params = $fc->getParams();
		}

		public function headerLocation($url = ""){
			header("Location: http://".HOST."/".DIR_PROJECT."/{$url}");
			exit;
		}

		public function getParams(){
			return $this->_params;
		}

		public function getSessionElements($element){
			return $_SESSION[$element];
		}

		public function getSession(){
			return $_SESSION;
		}

		public function setSession($session_var = []){
			$_SESSION = $session_var;
		}

		public function sessionClear(){
			session_destroy();
			$this->headerLocation();
		}
	}