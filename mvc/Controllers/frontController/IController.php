<?php

abstract class IController{
	protected $_params = [];
	protected $_body;

	public function __construct(){
		$fc = FrontController::getInstance();
		$this->_params = $fc->getParams();
	}

	public function getParams(){
		return $this->_params;
	}
}