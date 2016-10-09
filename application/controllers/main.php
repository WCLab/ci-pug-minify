<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$pug = array(
			'cache' => true,
			'phpSingleLine' => true,
			'keepBaseName' => false,
			'singleQuote' => false,
			'indentSize' => 2,
			'indentChar' => ' ',
			// 'enviroment' => "development",
			"assetDirectory" => "dev",
			"outputDirectory" => "public",
		);

		$this->load->library('pug',$pug);
	}

	public function index(){
		$this->pug->view("test");
	}

}

/* End of file main.php */
/* Location: ./application/controllers/main.php */