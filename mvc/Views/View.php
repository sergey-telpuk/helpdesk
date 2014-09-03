<?php
class View{
	public function render($file, $data = null){
		ob_start();
			require_once dirname(__FILE__)."/controller/{$file}.phtml";
		$content = ob_get_clean();

		ob_start();
			require_once dirname (__FILE__) . "/layout/index.phtml";
		return ob_get_clean();
	}
}