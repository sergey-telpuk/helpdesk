<?php
	class Bid{
		private $_dbh;

		public function __construct(){
			$bd = Model::getInstance();
			$this->_dbh = $bd->getDbh();
		}

		public function insertInputs($inputs){

			print_r($inputs);
			$sql = "INSERT INTO bid
								(
									name,
									applicant,
									implementer,
									status,
									priority,
									date,
									file,
									screen,
									comment
								) VALUES(
									:name,
									:applicant,
									:implementer,
									:status,
									:priority,
									:date,
									:file,
									:screen,
									:comment)";
			$sth = $this->_dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			$sth->execute([
				':name' => $inputs['name']['content'],
				':applicant' => $inputs['applicant']['content'],
				':implementer'=>$inputs['implementer']['content'],
				':status'=>$inputs['status']['content'],
				':priority'=>$inputs['priority']['content'],
				':date'=>$inputs['date']['content'],
				':file'=>$inputs['file']['content'],
				':screen'=>$inputs['screen']['content'],
				':comment'=>$inputs['comment']['content']
			]);


		}
	}