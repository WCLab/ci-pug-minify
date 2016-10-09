<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Loader extends CI_Loader {

	function __construct(){
		parent::__construct();
	}

	public function get_vars(){
		return $this->_ci_cached_vars;
	}

}

/* End of file mY_Loader.php */
/* Location: ./application/controllers/mY_Loader.php */