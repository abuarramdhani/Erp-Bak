<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Monitoring1 extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
    }

    public function index()
    {
        $this->load->view('ProductionPlanning/MainMenu/V_Monitoring1');
    }
}