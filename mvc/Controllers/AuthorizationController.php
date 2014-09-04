<?php
	class AuthorizationController extends IController {
		public function indexAction(){
			$view = new View();
			return $view->render('authorization/index', ['helpers' => false]);

		}

		public function checkAction(){
			if(isset($_POST['authorization'])){
				$user = new Authorization();

				if($user->checkUser(trim($_POST['login']), trim($_POST['password']))){
					$this->headerLocation('index');
				}else{
					$this->headerLocation('authorization/message');
				}
			}
		}

		public function messageAction(){
			$view = new View();
			return $view->render('authorization/index', ['helpers' => false ,'message'=>true]);
		}

	}