<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_StockControlNew extends CI_Controller {

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

		$this->load->model('StockControl/M_stock_control_new');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
	}

	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect();
		}
	}
	
	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Title'] = 'List Stock Control';
		$data['Menu'] = 'Stock Control';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['alert'] = $this->session->flashdata('alert');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('StockControl/StockControlNew/V_Index');
		$this->load->view('V_Footer',$data);
	}

	public function monitoring()
	{
		$data['area'] = $this->M_stock_control_new->area_list();
		$data['subassy'] = $this->M_stock_control_new->subassy_list();

		$data['from'] = date('Y-m-d 00:00:00');
		$data['to'] = date('Y-m-d 23:59:59', strtotime('+ 5 day'));
		
		$data['stock_on_date'] = $this->M_stock_control_new->qty_plan($data['from'],$data['to']);

		$this->load->view('StockControl/StockControlNew/V_Monitoring',$data);
		$this->load->view('StockControl/StockControlNew/V_table',$data);
		$this->load->view('StockControl/StockControlNew/V_foot',$data);
	}

	public function getData()
	{
		$area = $this->input->post('txt_area');
		$subassy = $this->input->post('txt_subassy');
		$from = $this->input->post('txt_date_from');
		$to = $this->input->post('txt_date_to');

		if ($area == 'All' || $area == '' ) {
			$area = "area";
		}
		else{
			$area = "'".$area."'";
		}

		if ($subassy == 'All' || $subassy == '') {
			$subassy = "subassy_desc";
		}
		else{
			$subassy = "'".$subassy."'";
		}

		$from = date('Y-m-d 00:00:00', strtotime($from));
		$to = date('Y-m-d 23:59:59', strtotime($to));

		$data['stock_on_date'] = $this->M_stock_control_new->qty_plan($from,$to);
		$data['production_list'] = $this->M_stock_control_new->production_list_filter($area,$subassy);
		foreach ($data['production_list'] as $pl) {
			foreach ($data['stock_on_date'] as $sod) {
				$data['data_'.$pl['master_data_id'].'_'.$sod['plan_id']] = $this->M_stock_control_new->transaction_list($pl['master_data_id'],$sod['plan_id']);
			}
		}

		$this->load->view('StockControl/StockControlNew/V_table',$data);
	}

	public function saveTransaction()
	{
		$qty = $this->input->post("qtySO");
		$master_id = $this->input->post("master_id");
		$plan_id = $this->input->post("plan_id");

		$master_data = $this->M_stock_control_new->select_master_data($master_id);
		$plan_data = $this->M_stock_control_new->select_plan_data($plan_id);

		foreach ($master_data as $md) {
			$qty_needed = $md['qty_component_needed'];
		}
		foreach ($plan_data as $pd) {
			$qty_plan = $pd['qty_plan'];
		}

		$check_transaction = $this->M_stock_control_new->check_transaction($master_id,$plan_id);
		if ($check_transaction == '0') {
			if ($qty < ($qty_needed*$qty_plan)) {
				$status = "KURANG";
			}
			elseif ($qty >= ($qty_needed*$qty_plan)) {
				$status = "LENGKAP";
			}
			$this->M_stock_control_new->insert_data($qty,$master_id,$plan_id,$status);
		}
		else{
			if ($qty < ($qty_needed*$qty_plan)) {
				$status = "KURANG";
			}
			elseif ($qty >= ($qty_needed*$qty_plan)) {
				$status = "DILENGKAPI";
			}
			$this->M_stock_control_new->update_data($qty,$master_id,$plan_id,$status);
		}

		$this->getData();
	}
}
