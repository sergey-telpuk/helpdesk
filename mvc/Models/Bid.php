<?php
class Bid{
	private $_dbh;

	public function __construct(){
		$bd = Model::getInstance();
		$this->_dbh = $bd->getDbh();
	}

	public function insertInputs($inputs){

		$sql = "SELECT id, level_access FROM users WHERE login = :login AND password = :password";

		$sth = $this->_dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute(array(':login' => $login, ':password' => $password));

		return true;

	}
}