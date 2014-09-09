<?php
	class BidController extends IController {

		private $_move_file_dir = '/var/www/html/helpdesk/files';

		private $_file_types = [
			'screen'=>['png', 'jpg', 'jpeg'],
			'file'=>['doc', 'docx']
		];

		private $_view, $_bid;

		private $_id;

		function __construct(){
			parent::__construct();
			$this->_view = new View();
			$this->_bid = new Bid();
		}

		public function updateAction(){
			$this->_id = (int)$this->getParams()['id'];
			if(isset($_POST['updateIdBid']) && $this->_id){
				$inputs = array_merge(
					['id'=>['content'=>$this->_id]],
					$this->_checkForm($_POST),
					(isset($_FILES['file'])&&!empty($_FILES['file']['name']))?$this->_checkFile($_FILES['file'])
						:['file'=>['val'=>false, 'content'=>null]],
					(isset($_FILES['screen'])&&!empty($_FILES['screen']['name']))?$this->_checkScreen($_FILES['screen'])
						:['screen'=>['val'=>false, 'content'=>null]]
				);

				foreach($inputs as $values){
					if($values['val'] === " class='req'"){
						return $this->_view->render("bid/index", $inputs);
					}
				}

				if($this->_bid->updateInputs($this->_id, $inputs)){
					if(!empty($_FILES['file']['name'])){
						$this->_saveFile($_FILES['file']);
					}

					if(!empty($_FILES['screen']['name'])){
						$this->_saveScreen($_FILES['screen']);
					}
					$this->headerLocation("bid/index/id/{$this->_id}");
				}else{
					$this->headerLocation('error');
				}
			}else{
				$this->headerLocation('error');
			}

		}

		public function indexAction(){
			$id_bid_inputs = $this->_bid->selectInputs((int)$this->getParams()['id']);
			if($id_bid_inputs){
				return $this->_view->render("bid/index", [
					'id'=>['content'=>$id_bid_inputs['id']],
					'name'=>['val' => false, 'content'=>$id_bid_inputs['name']],
					'description'=>['val' => false, 'content'=>$id_bid_inputs['description']],
					'applicant'=>['val'=>false, 'content'=>$id_bid_inputs['applicant']],
					'implementer'=>['val'=>false, 'content'=>$id_bid_inputs['implementer']],
					'priority'=>['val'=>false, 'content'=>$id_bid_inputs['priority']],
					'comment'=>['val'=>false, 'content'=>$id_bid_inputs['comment']],
					'date'=>['val'=>false, 'content'=>$id_bid_inputs['date']],
					'status'=>['val'=>false, 'content'=>$id_bid_inputs['status']]
				] );
			}else{
				$this->headerLocation('index');
			}

		}

		public function createAction(){
			return $this->_view->render('bid/create');
		}



		public function insertAction(){

			if(isset($_POST['saveBid'])){

				$inputs = array_merge(
					$this->_checkForm($_POST),
					(isset($_FILES['file'])&&!empty($_FILES['file']['name']))?$this->_checkFile($_FILES['file'])
						:['file'=>['val'=>false, 'content'=>null]],
					(isset($_FILES['screen'])&&!empty($_FILES['screen']['name']))?$this->_checkScreen($_FILES['screen'])
						:['screen'=>['val'=>false, 'content'=>null]]
				);

				foreach($inputs as $values){
					if($values['val'] === " class='req'"){
						return $this->_view->render('bid/create', $inputs);
					}
				}

				$this->_id = $this->_bid->insertInputs($inputs);

				if($this->_id){
					if(!empty($_FILES['file']['name'])){
						$this->_saveFile($_FILES['file']);
					}

					if(!empty($_FILES['screen']['name'])){
						$this->_saveScreen($_FILES['screen']);
					}
					$this->headerLocation("bid/index");
				}else{
					$this->headerLocation('error');
				}

			}else{
				$this->headerLocation('error');
			}
		}

		private function _saveFile($file){
			$link = "$this->_move_file_dir/file_doc";
			$files = scandir($link);

			foreach($files as $file){
				if(preg_match("/($this->_id)/", $file)){
					unlink("$link/$file");
				}
			}
			move_uploaded_file($file['tmp_name'], "$link/$this->_id".
				".".substr(strrchr($file['name'], '.'), 1));
		}

		private function _saveScreen($screen){
			$link = "$this->_move_file_dir/images";
			$files = scandir($link);

			foreach($files as $file){
				if(preg_match("/($this->_id)/", $file)){
					unlink("$link/$file");
				}
			}
			move_uploaded_file($screen['tmp_name'], "$link/$this->_id".
				".".substr(strrchr($screen['name'], '.'), 1));
		}

		private function _checkFile($file = null){
			return
				is_uploaded_file($file['tmp_name']) && $file['size'] < 20000000
				&& !is_null($file) && $file['error'] === 0 ?
					['file'=>['val' => false, 'content'=>$file['name']]] :
					['file'=>['val' => " class='req'"]];

		}

		private function _checkScreen($screen = null){
			return
				is_uploaded_file($screen['tmp_name']) && $screen['size'] < 20000000
				&& !is_null($screen) && $screen['error'] === 0
				&& in_array(substr(strrchr($screen['name'], '.'), 1), $this->_file_types['screen']) ?
					['screen'=>['val' => false, 'content'=>$screen['name']]] :
					['screen'=>['val' => " class='req'"]];

		}

		private function _checkForm($inputs){
			$inputs['name'] = isset($inputs['name']) ? $inputs['name']  : "";
			$inputs['description'] = isset($inputs['description']) ? $inputs['description']  : "";
			$inputs['status'] = isset($inputs['status']) ? $inputs['status']: 'open';
			$inputs['priority'] = isset($inputs['priority']) ? $inputs['priority']: 'low';
			$inputs['date'] = isset($inputs['date']) ? $inputs['date']: date("d-m-Y H:00");
			$inputs['comment'] = isset($inputs['comment']) ? $inputs['comment']  : "";
			$inputs['applicant'] = isset($inputs['applicant']) ? $inputs['applicant']  : "";
			$inputs['implementer'] = isset($inputs['comment']) ? $inputs['implementer']  : "";

			$mb_ucfirst = function ($str, $encoding='UTF-8'){
				$str = mb_ereg_replace('^[\ ]+', '', $str);
				$str = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding).
					mb_substr($str, 1, mb_strlen($str), $encoding);
				return $str;
			};

			$check_empty = function($var){
				return empty($var) ? " class='req'" : false;
			};

			$check_priority = function($var){
				$list_priority = ['low', 'average', 'high', 'critical'];
				return in_array($var, $list_priority) ? false: " class='req'";
			};

			$check_status = function($var){
				$list_status = ['open', 'in_work', 'close', 'canceled'];
				return in_array($var, $list_status) ? false: " class='req'";
			};

			$check_date = function($var){
				$req = '/(\d{1,2}-\d{1,2}-\d{4} \d{1,2}:\d{1,2})/';
				return preg_match($req, $var) ? false: " class='req'";
			};


			$name = call_user_func($mb_ucfirst, mb_strtolower(strip_tags(trim($inputs['name'])), 'utf-8'));
			$name_val = call_user_func($check_empty, $name);


			$description = call_user_func($mb_ucfirst,
				mb_strtolower(strip_tags(trim($inputs['description'])), 'utf-8'));
			$description_val = call_user_func($check_empty, $description);

			$priority = mb_strtolower(strip_tags(trim($inputs['priority'])), 'utf-8' );
			$priority_val = call_user_func($check_priority, $priority);

			$status = mb_strtolower(strip_tags(trim($inputs['status'])), 'utf-8');
			$status_val = call_user_func($check_status, $status);

			$applicant = call_user_func($mb_ucfirst,
				mb_strtolower(strip_tags(trim($inputs['applicant'])), 'utf-8'));
			$applicant_val = call_user_func($check_empty, $applicant);

			$implementer = call_user_func($mb_ucfirst,
				mb_strtolower(strip_tags(trim($inputs['implementer'])), 'utf-8'));
			$implementer_val = call_user_func($check_empty, $implementer);

			$date = strip_tags(trim($inputs['date']));
			$date_val = call_user_func($check_date, $date);

			$comment = call_user_func($mb_ucfirst,
				mb_strtolower(strip_tags(trim($inputs['comment'])), 'utf-8'));
			$comment_val = false;

			return [
				'name'=>['val' => $name_val, 'content'=>$name],
				'description'=>['val' => $description_val, 'content'=>$description],
				'applicant'=>['val'=>$applicant_val, 'content'=>$applicant],
				'implementer'=>['val'=>$implementer_val, 'content'=>$implementer],
				'priority'=>['val'=>$priority_val, 'content'=>$priority],
				'comment'=>['val'=>$comment_val, 'content'=>$comment],
				'date'=>['val'=>$date_val, 'content'=>$date],
				'status'=>['val'=>$status_val, 'content'=>$status]
			];


		}
	}