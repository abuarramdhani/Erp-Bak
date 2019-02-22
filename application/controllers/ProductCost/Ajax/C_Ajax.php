<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Ajax extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('url');
        $this->load->helper('html');
		$this->load->library('session');
		$this->load->model('ProductCost/M_bppbgaccount');
		$this->load->model('ProductCost/M_ajax');
    }

    public function getBppbgAccount()
    {
    	$using_category_code	= $this->input->post('using_category_code');
    	$account_number			= $this->input->post('account_number');
    	$cost_center			= $this->input->post('cost_center');
    	$limit					= $this->input->post('limit');

    	if (empty($using_category_code)) { $using_category_code = FALSE; }
    	if (empty($account_number)) { $account_number = FALSE; }
    	if (empty($cost_center)) { $cost_center = FALSE; }
    	if (empty($limit)) { $limit = FALSE; }

    	$data['no'] = 1;
    	$data['account'] = $this->M_bppbgaccount->getAccount(FALSE,$using_category_code,$account_number,$cost_center,$limit);

		$this->load->view('ProductCost/MainMenu/BppbgAccount/V_TableAccount',$data);
    }

    public function checkingAccount()
    {
    	$value	= $this->input->post('value');
    	$field	= strtoupper($this->input->post('field'));

    	$data = $this->M_ajax->checkBppbgAccount($field,$value);
    	echo $data;
    }
}