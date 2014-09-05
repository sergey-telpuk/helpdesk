<?php
	class BidController extends IController {

		public function createAction(){
			$view = new View();
			return $view->render('bid/create');
		}

		public function insertAction(){
			if(isset($_POST['saveBid'])){
				$inputs = $this->_checkForm($_POST);
				foreach($inputs as $values){
					if($values['val'] === " class='req'"){
						$view = new View();
						return $view->render('bid/create', $inputs);
					}
				}
			}else{
				$this->headerLocation('index');
			}
		}

		private function _checkForm($inputs){
			$mb_ucfirst = function ($str, $encoding='UTF-8'){
				$str = mb_ereg_replace('^[\ ]+', '', $str);
				$str = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding).
					mb_substr($str, 1, mb_strlen($str), $encoding);
				return $str;
			};

			$check_empty = function($var){
				return empty($var) ? " class='req'" : false;
			};

			$name = call_user_func($mb_ucfirst, mb_strtolower(strip_tags(trim($inputs['name'])), 'utf-8'));
			$name_val = call_user_func($check_empty, $name);


			$description = call_user_func($mb_ucfirst,
				mb_strtolower(strip_tags(trim($inputs['description'])), 'utf-8'));
			$description_val = call_user_func($check_empty, $description);

			$priority = strip_tags(trim($inputs['priority']));

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
				'priority'=>['val'=>false, 'name'=>$priority]
			];


		}
	}