<?php
	class Authorization{
		private $_dbh;

		public function __construct(){
			$bd = Model::getInstance();
			$this->_dbh = $bd->getDbh();
		}

		public function checkUser($login, $password){
			$sql = "SELECT id, level_access FROM users WHERE login = :login AND password = :password";

			$sth = $this->_dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			$sth->execute(array(':login' => $login, ':password' => $password));

			$user = $sth->fetch();

			if(empty($user)){
				return false;
			}

			$_SESSION['id'] = trim($user['id']);
			$_SESSION['level_access'] = trim($user['level_access']);

			return true;

		}

	}