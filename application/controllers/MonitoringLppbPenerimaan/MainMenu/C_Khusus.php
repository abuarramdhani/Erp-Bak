<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Khusus extends CI_Controller
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
		$this->load->model('MonitoringLppbPenerimaan/MainMenu/M_khusus');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Khusus';
		$data['Menu'] = 'Khusus';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$detailio = $this->M_khusus->showIo();
		$data['lppb'] = $detailio;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringLppbPenerimaan/V_Khusus');
		$this->load->view('V_Footer',$data);
	}

	public function format_date($date)
	{
		$ss = explode("/",$date);
		return $ss[2]."-".$ss[1]."-".$ss[0];
	}

	// public function getdata(){
	// 	$user = $this->session->username;

	// 	$user_id = $this->session->userid;

	// 	$data['Title'] = 'Khusus';
	// 	$data['Menu'] = 'Khusus';
	// 	$data['SubMenuOne'] = '';
	// 	$data['SubMenuTwo'] = '';

	// 	$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
	// 	$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
	// 	$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		

	// 	$this->load->view('V_Header',$data);
	// 	$this->load->view('V_Sidemenu',$data);
	// 	$this->load->view('MonitoringLppbPenerimaan/V_Khusus');
	// 	$this->load->view('V_Footer',$data);


	// }

	public function search()
	{
		
		$noLpAw = $this->input->post('noLpAw');
		$noLpAk =$this->input->post('noLpAk');
		$tgAw = $this->input->post('tgAw');
		$tgAk =$this->input->post('tgAk');
		$io = $this->input->post('io');
		// print_r($_POST);exit();
		// print_r($io);
		
		$atr=NULL;
		$atr2=NULL;
		$atr3=NULL;
			
		if ($noLpAw != '' AND $noLpAk != ''){
			$atr = "and rsh.RECEIPT_NUM between nvl($noLpAw,rsh.RECEIPT_NUM) and nvl($noLpAk,rsh.RECEIPT_NUM)";
		}
		else{
			$atr ='';
		}
		
		if ($tgAw != '' AND $tgAk != ''){
			$formatedAw = $this->format_date($tgAw);
			$formatedAk = $this->format_date($tgAk);
			$tgAw = strtoupper(date('d-M-Y', strtotime($formatedAw)));
			$tgAk = strtoupper(date('d-M-Y', strtotime($formatedAk)));
			$atr2 = " and trunc(wkt.MINTIME) between nvl('$tgAw',wkt.MINTIME) and nvl('$tgAk',wkt.MINTIME)";
			
		}
		else{
			$atr2 ='';
		}
		

		if($io !=''){
			$atr3 = "and rsh.SHIP_TO_ORG_ID = '$io'";
		}
		else {
			$atr3 ='';
		}
		$data['value'] = $this->M_khusus->getSearch($atr,$atr2,$atr3);
		// echo "<pre>";print_r($data);exit();
		// echo"<pre>";print_r($data['value']);
		// exit();

		$this->load->view('MonitoringLppbPenerimaan/V_ResultKhusus',$data);	
	}
}