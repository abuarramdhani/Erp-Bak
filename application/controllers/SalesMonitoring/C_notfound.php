<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_notfound extends CI_Controller {

	function __construct() 
	{
		parent::__construct();
		$this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		  //$this->load->library('Database');
		$this->load->model('SalesMonitoring/M_notfound');
    }
	
	public function index()
	{
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SalesMonitoring/V_notfound');
		$this->load->view('V_Footer',$data);
	}
}