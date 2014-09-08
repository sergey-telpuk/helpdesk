<?php
	class BidController extends IController {

		private $_file_types = [
			'screen'=>['png', 'jpg', 'jpeg'],
			'file'=>['doc', 'docx']
		];

		private $_move_file_dir = '/var/www/html/helpdesk/files';

		public function createAction(){
			$view = new View();
			return $view->render('bid/create');
		}

		public function insertAction(){

			if(isset($_POST['saveBid'])){

				if(	isset($_FILES['file'])){
					$this->_checkFile($_FILES['file']);
				}

				if(isset($_FILES['screen'])){
					$this->_checkScreen($_FILES['screen']);
				}

				$inputs = $this->_checkForm($_POST);

				foreach($inputs as $values){
					if($values['val'] === " class='req'"){
						$view = new View();
						return $view->render('bid/create', $inputs);
					}
				}

				$bid = new Bid();

				//$bid


			}else{
				$this->headerLocation('index');
			}
		}

		private function _checkFile($file = null){
			if(is_uploaded_file($file['tmp_name'])){
				if(!is_null($file) && $file['error'] === 0){
					if( in_array(substr(strrchr($file['name'], '.'), 1), $this->_file_types['file'])
						&& $file['size'] < 20000000 ){
						move_uploaded_file($file['tmp_name'], "$this->_move_file_dir/{$file['name']}");
					}
				}
			}
		}

		private function _checkScreen($screen = null){
			if(is_uploaded_file($screen['tmp_name'])){
				if(!is_null($screen) && $screen['error'] === 0){
					if( in_array(substr(strrchr($screen['name'], '.'), 1), $this->_file_types['screen'])
						&& $screen['size'] < 20000000 ){
						move_uploaded_file($screen['tmp_name'], "$this->_move_file_dir/{$screen['name']}");
					}
				}
			}
		}

		private function _checkForm($inputs){
			$inputs['status'] = isset($inputs['status']) ? $inputs['status']: 'open';
			$inputs['priority'] = isset($inputs['priority']) ? $inputs['priority']: 'low';

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

			return [
				'name'=>['val' => $name_val, 'name'=>$name],
				'description'=>['val' => $description_val, 'name'=>$description],
				'applicant'=>['val'=>$applicant_val, 'name'=>$applicant],
				'implementer'=>['val'=>$implementer_val, 'name'=>$implementer],
				'priority'=>['val'=>$priority_val, 'name'=>$priority],
				'status'=>['val'=>$status_val, 'name'=>$status]
			];


		}
	}