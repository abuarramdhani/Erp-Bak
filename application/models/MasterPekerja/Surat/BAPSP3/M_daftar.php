<?php defined('BASEPATH') OR die('No direct script access allowed');

class M_Daftar extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->erp = $this->load->database('default', true);
    }
}