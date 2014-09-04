<?php

	set_include_path( implode(PATH_SEPARATOR, [
		'mvc/Controllers/frontController',
		'mvc/Controllers/errorController',
		'mvc/Controllers/sessionController',
		'mvc/Controllers',
		'mvc/Models',
		'mvc/Views',
		'config/'
	]));

	spl_autoload_register(function ($class) {
		$file = $class . '.php';
		try{

			if(!@include_once "$file")
				throw new Exception('No page');
		}catch (Exception $e){
//			header('Location: '.HOST.'/error');
			echo $e->getMessage();
			exit($e->getMessage());
		}
	});

	$app = FrontController::getInstance();

	$app->run();
	echo $app->getBody();

