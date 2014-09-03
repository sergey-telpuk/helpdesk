<?php

class IndexController extends IController {
	public function indexAction(){
		$view = new View();
		return $view->render('index/index');
	}

} 