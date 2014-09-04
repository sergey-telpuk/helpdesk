<?php
	abstract class Config{
		protected  abstract  function getConfig();

		protected  function _setConfigBd($config_bd = []){
			define('TYPE_BD', $config_bd['type_bd']);
			define('HOST_DB', $config_bd['host']);
			define('DB_NAME', $config_bd['db_name']);
			define('USER', $config_bd['user']);
			define('PASSWORD', $config_bd['password']);
		}

		protected  function _setConfigUrl($config_url){
			define('HOST', $config_url['host']);
			define('DIR_PROJECT', $config_url['dir_project']);
		}
	}