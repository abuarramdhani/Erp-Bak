<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Index extends CI_Controller {

	function __construct()
	{
		parent::__construct();
    $this->load->helper('form');
    $this->load->helper('url');
    $this->load->helper('html');
    $this->load->model('ProgressPPPR/M_progress');
		
	}

	public function index()
	{
    $this->load->view('ProgressPPPR/V_Head');
    $this->load->view('ProgressPPPR/V_Progress');
    $this->load->view('ProgressPPPR/V_Foot');
  }

	
}

