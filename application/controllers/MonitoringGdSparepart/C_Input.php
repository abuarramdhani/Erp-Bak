<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Input extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MonitoringGdSparepart/M_input');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Input';
		$data['Menu'] = 'Input';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringGdSparepart/V_Input');
		$this->load->view('V_Footer',$data);
	}

	public function input()
	{
		$noDokumen = $this->input->post('noDokumen');
		$jenis_dokumen = $this->input->post('jenis_dokumen');
		$atr=NULL;
			

		if ($jenis_dokumen == 'IO') {
			$atr = "and mmt.SHIPMENT_NUMBER = '$noDokumen'";
			$data['input'] = $this->M_input->getInput($atr);
		} else if ($jenis_dokumen == 'KIB'){
			$atr = "and kk.KIBCODE = '$noDokumen'";
			$data['input'] = $this->M_input->getInputKIB($atr);
		} else if ($jenis_dokumen == 'LPPB'){
			$atr = "and RSH.RECEIPT_NUM ='$noDokumen'";
			$data['input'] = $this->M_input->getInputLPPB($atr);
		} else {
			$atr = '';
		}


		foreach ($data['input'] as $key => $k) {
			$data['input'][$key]['JENIS_DOKUMEN'] = $jenis_dokumen;
		}
		
		return $this->load->view('MonitoringGdSparepart/V_TableInput', $data);
	}

	public function getSave(){
		$NO_DOCUMENT	= $this->input->post('no_document');
		$JENIS_DOKUMEN	= $this->input->post('jenis_dokumen');
		$ITEM			= $this->input->post('item');
		$DESCRIPTION	= $this->input->post('desc');
		$UOM			= $this->input->post('uom');
		$QTY			= $this->input->post('qty');
		$CREATION_DATE	= $this->input->post('creation_date');
		$STATUS			= $this->input->post('status');
		$PIC			= $this->input->post('pic');

		foreach($ITEM as $key => $no){
			$this->M_input->save($NO_DOCUMENT[$key],$JENIS_DOKUMEN[$key],$no,$DESCRIPTION[$key],$UOM[$key],$QTY[$key],$CREATION_DATE[$key],$STATUS[$key],$PIC);
		}
		// echo "<pre>";
		// print_r ($save);
		// exit();
		redirect(base_url('MonitoringGdSparepart/Input/'));
	}

}