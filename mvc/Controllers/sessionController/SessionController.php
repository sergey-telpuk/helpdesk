<?php
	class SessionController{
		private $_controllers;

		public function __construct(){
			$this->setControllers(require_once "config_session.php");
		}

		private function setControllers($controllers){
			$this->_controllers = $controllers;
		}

		public function getControllers(){
			return $this->_controllers;
		}


	}