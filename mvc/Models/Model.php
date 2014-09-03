<?php

	class Model {
		static private $_instance = null;
		static private $_dbh = null;

		private  function __construct(){
			try {
				self::$_dbh = new PDO('mysql:host=localhost;dbname=pricelist', $this->_user, $this->_password,
					array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

			} catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
		}
		private function __clone() {}

		public function getDbh(){
			return  self::$_dbh;
		}


		static  public  function getInstance(){
			if(self::$_instance instanceof self){
				return self::$_instance;
			}
			self::$_instance =  new Model();
			return  self::$_instance;
		}
	}