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
		public function selectInputs($id){
			try{
				$sql = "SELECT
							id,
							name,
							applicant,
							implementer,
							description,
							status,
							priority,
							date,
							comment,
							date_insert
						FROM bid
						WHERE id = :id";
				$sth = $this->_dbh->prepare($sql);
				$sth->execute([
					':id' => $id
				]);

				return $sth->fetch(PDO::FETCH_ASSOC);

			}catch (PDOException $e){
				return false;
			}

		}

		public function updateInputs($id, $inputs){
			try{
				$sql = "UPDATE bid SET
							name = :name,
							applicant = :applicant,
							implementer = :implementer,
							description = :description,
							status = :status,
							priority = :priority,
							date = :date,
							comment = :comment
						WHERE id = :id";
				$sth = $this->_dbh->prepare($sql);
				$sth->execute([
					':name' => $inputs['name']['content'],
					':applicant' => $inputs['applicant']['content'],
					':implementer'=>$inputs['implementer']['content'],
					':description'=>$inputs['description']['content'],
					':status'=>$inputs['status']['content'],
					':priority'=>$inputs['priority']['content'],
					':date'=>$inputs['date']['content'],
					':comment'=>$inputs['comment']['content'],
					':id' => $id
				]);

				return true;

			}catch (PDOException $e){
				return false;
			}

		}

		public function selectImplementer(){
			try{
				$sql = "SELECT
							id,
							name
						FROM
							implementer ORDER BY id ASC";
				$sth = $this->_dbh->query($sql);

				return $sth->fetchAll(PDO::FETCH_ASSOC);

			}catch (PDOException $e){
				return false;
			}
		}


		public function selectBids(){
			try{
				$sql = "SELECT
							id,
							name,
							status,
							priority
						FROM
							bid ORDER BY id DESC ";
				$sth = $this->_dbh->query($sql);

				return $sth->fetchAll(PDO::FETCH_ASSOC);

			}catch (PDOException $e){
				return false;
			}
		}

	}