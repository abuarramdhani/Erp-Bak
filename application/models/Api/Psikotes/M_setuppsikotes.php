<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 
 */
class M_setuppsikotes extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia', true);
	}

	
}