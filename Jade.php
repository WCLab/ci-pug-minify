<?php

/**
 * @author kylekatarnls
 * @author wpdesigns
 */

class Jade {

	protected $CI;
	protected $jade;
	protected $views_path;
	protected $ext;

	public function __construct(array $options = NULL) {

		if(is_null($options)) {
			$options = defined('static::SETTINGS') ? ((array) static::SETTINGS) : array();
		}
	   
		if(isset($options["extension"])){
			$this->ext = $options["extension"];
			unset($options['extension']);
		}else{
			$this->ext = ".jade";
		}

	   if(isset($options['views_path'])) {
			$this->views_path = $options['views_path'];
			unset($options['views_path']);
		} else {
			$this->views_path = APPPATH . 'views';
		}

		if(isset($options['cache'])) {
			if($options['cache'] === TRUE) {
				$options['cache'] = APPPATH . 'cache/jade';
			}
			if(! file_exists($options['cache']) && ! mkdir($options['cache'], 0777, TRUE)) {
				throw new Exception("Cache folder does not exists and cannot be created.", 1);
			}
		}
		$this->CI =& get_instance();
		$this->jade = new Pug\Pug($options);

		if (array_key_exists("environment", $options)) {
			if(in_array($options["environment"], array("production","test","development")))
				$options["environment"] = $options["environment"];
			else
				throw new Exception("Enviroment not valid");
		}else{
			$options["environment"] = "development";
		}

		$this->jade->setCustomOption('environment', $options["environment"]);

		$options["assetDirectory"] = array_key_exists("assetDirectory", $options) ? $options["assetDirectory"] : "dev";
		$options["outputDirectory"] = array_key_exists("outputDirectory", $options) ? $options["outputDirectory"] : "static";
		
		$this->jade->setCustomOptions(array(
			'assetDirectory' => $options["assetDirectory"],
			'outputDirectory' => $options["outputDirectory"]
		));

		$minify = new Pug\Keyword\Minify($this->jade);
		$this->jade->addKeyword('minify',$minify);



	}

	public function view($view, $data = array(), $return = false) {
		
		if (is_array($view) or $view === true) {
			$view = null;
			$data = array();
		}

		
		if(! $this->jade) {
			$this->settings();
		}


		$views_path = str_replace("\\", "/", $this->views_path . DIRECTORY_SEPARATOR);

		$views = array(
			"original" => $view.$this->ext,
			"method" => $this->CI->router->method.$this->ext,
			"module" => $this->CI->router->class.DIRECTORY_SEPARATOR.$this->CI->router->method.$this->ext
		);


		if (is_null($view)){

			if (file_exists($this->views_path.DIRECTORY_SEPARATOR.$views['method'])) {
				$view = $this->views_path.DIRECTORY_SEPARATOR.$views['method'];
			}

			elseif(file_exists($this->views_path.DIRECTORY_SEPARATOR.$views['module'])){
				$view = $this->views_path.DIRECTORY_SEPARATOR.$views['module'];
			}

			else{
				show_error("Unable to load the requested file: {$views['method']}","500");
			}
		}else{
			if (is_string($view)) {
				if (file_exists($this->views_path.DIRECTORY_SEPARATOR.$views['original'])) {
					$view = $this->views_path.DIRECTORY_SEPARATOR.$views['original'];
				}else{
					show_error("Unable to load the requested file: {$views['original']}","500");
				}
			}
		}
	 
		$data = array_merge($this->CI->load->get_vars(), $data);

		if ($return == FALSE){
			$this->CI->output->append_output($this->jade->render($view, $data));
		}

		return $this->jade->render($view, $data);

	}

}
