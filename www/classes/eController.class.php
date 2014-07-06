<?php
abstract class eController {
	/**
	*	Pagen Controller parrent class
	*	Pagen v1.0
	*
	*/
	public $args;
	private $modelPath;
	protected $url;
	protected $site_title;
	protected $lang;
	protected $ls_name;
	
	protected function run () {
		$this->loadModel ();
	}

	final public function __construct ($modelPath = '', $args = array ()) {
		$this->modelPath = $modelPath;
		$this->args = $args;
		$this->lang = config::$Lang;
		$this->url = "//$_SERVER[HTTP_HOST]";
		$this->site_title = config::TITLE;
		$this->ls_name = "//$_SERVER[SERVER_NAME]$_SERVER[REQUEST_URI]?lang";
	}

	final protected function loadModel ($modelPath = '') {
		if (empty($modelPath)) {
			$modelPath = $this->modelPath;
		}
		$modelPath = SITE.'models'.DIRSEP.$modelPath.EXT;
		if (is_file($modelPath)) {
			$eModel = dirname(__FILE__).DIRSEP.'eModel.class'.EXT;
			include_once ($eModel);
			include ($modelPath);
		}
	}
}
?>