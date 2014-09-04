<?php
	class BidController extends IController {

		public function createAction(){
			$view = new View();
			return $view->render('index/index');
		}


	}