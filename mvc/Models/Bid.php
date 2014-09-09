<?php
	class Bid{
		private $_dbh;

		public function __construct(){
			$bd = Model::getInstance();
			$this->_dbh = $bd->getDbh();
		}

		public function insertInputs($inputs){
			try{
				$sql = "INSERT INTO bid
								(
									name,
									applicant,
									implementer,
									description,
									status,
									priority,
									date,
									comment
								) VALUES(
									:name,
									:applicant,
									:implementer,
									:description,
									:status,
									:priority,
									:date,
									:comment)";
				$sth = $this->_dbh->prepare($sql);
				$sth->execute([
					':name' => $inputs['name']['content'],
					':applicant' => $inputs['applicant']['content'],
					':implementer'=>$inputs['implementer']['content'],
					':description'=>$inputs['description']['content'],
					':status'=>$inputs['status']['content'],
					':priority'=>$inputs['priority']['content'],
					':date'=>$inputs['date']['content'],
					':comment'=>$inputs['comment']['content']
				]);
			}catch (PDOException $e){
				return false;
			}

			return $this->_dbh->lastInsertId();

		}
	}