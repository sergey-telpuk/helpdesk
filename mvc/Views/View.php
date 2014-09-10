<?php
	class View{
		private $_helpers_menu = '';
		private $_content = '';

		public function render($file, $data = null){
			ob_start();
			require_once dirname(__FILE__)."/controller/{$file}.phtml";
			$this->_content = ob_get_clean();

			if(!isset($data['helpers'])){
				ob_start();
				require_once dirname(__FILE__)."/layout/helpers/helper_menu.phtml";
				$this->_helpers_menu = ob_get_clean();
			}

			ob_start();
			require_once dirname (__FILE__) . "/layout/index.phtml";
			return ob_get_clean();
		}
	}