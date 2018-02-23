<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_CreditLimit extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('AccountReceivables/CreditLimit/M_creditlimit');
		  
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

	public function newData()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		//$data['customer'] = $this->M_creditlimit->customer();
		$data['branch'] = $this->M_creditlimit->branch();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPEIA/CreditLimit/V_Index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function Branch()
	{
		$orgID = $this->input->post('data_name');
		$Customer = $this->M_creditlimit->customer($orgID);
		
		echo '
			<option value=""></option>
			<option value="muach" disabled >-- PILIH SALAH SATU --</option>
		';
			foreach ($Customer as $c) {
				echo '<option value="'.$c['PARTY_NAME'].'">'.strtoupper($c['PARTY_NAME']).'</option>';
			}
	}

	public function Cust()
	{
		$PartyName = $this->input->post('data_name');
		$CustAccountID = $this->M_creditlimit->CustAccountID($PartyName);

		foreach ($CustAccountID as $c) {
			echo $c['CUST_ACCOUNT_ID'];
		}

	}

	public function Account()
	{
		$PartyName = $this->input->post('data_name');
		$AccountNumber = $this->M_creditlimit->AccountNumber($PartyName);

		foreach ($AccountNumber as $a) {
			echo $a['ACCOUNT_NUMBER'];
		}
	}

	public function PartyID()
	{
		$PartyName = $this->input->post('data_name');
		$AccountNumber = $this->M_creditlimit->PartyID($PartyName);

		foreach ($AccountNumber as $a) {
			echo $a['PARTY_ID'];
		}
	}

	public function PartyNumber()
	{
		$PartyName = $this->input->post('data_name');
		$AccountNumber = $this->M_creditlimit->PartyNumber($PartyName);

		foreach ($AccountNumber as $a) {
			echo $a['PARTY_NUMBER'];
		}
	}

	public function saveData()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		//-------post-------------
		$creator = $this->input->post('userCreate');
		$CustName = $this->input->post('CustomerName');
		$Branch = $this->input->post('Branch');
		$CustID = $this->input->post('CustAccountID');
		$CustType = $this->input->post('CustType');
		$AccountNumber = $this->input->post('AccountNumber');
		$PartyID = $this->input->post('PartyID');
		$PartyNumber = $this->input->post('PartyNumber');
		$OverallCL = $this->input->post('OverallCreditLimit');
		$Expired = $this->input->post('Expired');

		$save = $this->M_creditlimit->saveNew($creator,$CustName,$Branch,$CustID,$CustType,$AccountNumber,$OverallCL,$Expired,$PartyID,$PartyNumber);

		redirect(base_url('AccountReceivables/CreditLimit'));
	}

	public function Edit($id,$ORGid)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['customer'] = $this->M_creditlimit->customerItem($ORGid);
		$data['branch'] = $this->M_creditlimit->branch();
		$data['data'] = $this->M_creditlimit->search($id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AccountReceivables/CreditLimit/V_edit', $data);
		$this->load->view('V_Footer',$data);
	}

	public function EditSave()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		//-------post-------------
		$editor = $this->input->post('editor');
		$lineID = $this->input->post('lineID');
		$CustName = $this->input->post('CustomerName');
		$Branch = $this->input->post('Branch');
		$CustID = $this->input->post('CustAccountID');
		$CustType = $this->input->post('CustType');
		$AccountNumber = $this->input->post('AccountNumber');
		$PartyID = $this->input->post('PartyID');
		$PartyNumber = $this->input->post('PartyNumber');
		$OverallCL = $this->input->post('OverallCreditLimit');
		$Expired = $this->input->post('Expired');

		$save = $this->M_creditlimit->saveEdit($editor,$lineID,$CustName,$Branch,$CustID,$CustType,$AccountNumber,$OverallCL,$Expired,$PartyID,$PartyNumber);

		redirect(base_url('AccountReceivables/CreditLimit'));
	}

	public function Delete($id)
	{
		$delete = $this->M_creditlimit->DeleteCL($id);

		redirect(base_url('AccountReceivables/CreditLimit'));
	}

}