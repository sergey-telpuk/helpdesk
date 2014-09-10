<?php

class IndexController extends IController {
	private $_view;
	private $_db;

	public function __construct(){
		parent::__construct();
		$this->_view = new View();
		$this->_db = new Bid();
	}

	public function indexAction(){
		return $this->_view ->render('index/index', ['bids'=>$this->_db->selectBids()]);
	}

	public function outAction(){
		$this->sessionClear();
	}

} 