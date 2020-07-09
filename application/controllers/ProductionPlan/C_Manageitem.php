<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Manageitem extends CI_Controller
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
		$this->load->model('ProductionPlan/M_productionplan');

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

		$data['Title'] = 'Management Item';
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$datainserttampil = $this->M_productionplan->datainserttampil();

		// echo "<pre>";print_r($datainserttampil);exit();
		$arraybody = array();
		$arrayhandlebar = array();
		$arraydos = array();
		foreach ($datainserttampil as $tampil) {
			if ($tampil['jenis'] == 'Body') {
				array_push($arraybody, $tampil);
			} else if ($tampil['jenis'] == 'Handle Bar') {
				array_push($arrayhandlebar, $tampil);
			} else if ($tampil['jenis'] == 'Dos') {
				array_push($arraydos, $tampil);
			}

	
		}

		// echo "<pre>";print_r($arraydos);exit();

		$data['arraybody'] =$arraybody;
		$data['arrayhandlebar'] =$arrayhandlebar;
		$data['arraydos'] =$arraydos;



		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ProductionPlan/V_ManageItem');
		$this->load->view('V_Footer',$data);
	}

	public function format_date($date)
	{
		$ss = explode("/",$date);
		return $ss[2]."-".$ss[1]."-".$ss[0];
	}
		function getName()
	{
		$kodeitem  = $this->input->post('kodeitem');
		$desc = $this->M_productionplan->getnamekomp($kodeitem);
		// echo "<pre>";print_r($desc);exit();
		if ($desc== null) {

		echo json_encode('-');
		
		} else if ($desc!=null) {

    	echo json_encode($desc[0]['DESCRIPTION']);
			
		}
	}
	public function Insertitem()
	{
		$priority=$this->input->post('priority');
		$codekomp=$this->input->post('codekomp');
		$namekomp=$this->input->post('namekomp');
		$jeniskomp=$this->input->post('jeniskomp');

		// echo "<pre>";
		// print_r($priority);
		// print_r($codekomp);
		// print_r($namekomp);
		// print_r($jeniskomp);exit();

		// $this->M_productionplan->insertitem($priority,$codekomp,$namekomp,$jeniskomp);

		$datainserttampil = $this->M_productionplan->datainserttampil();

		// echo "<pre>";print_r($datainserttampil);exit();
		$arraybody = array();
		$arrayhandlebar = array();
		$arraydos = array();
		foreach ($datainserttampil as $tampil) {
			if ($tampil['jenis'] == 'Body') {
				array_push($arraybody, $tampil);
			} else if ($tampil['jenis'] == 'Handle Bar') {
				array_push($arrayhandlebar, $tampil);
			} else if ($tampil['jenis'] == 'Dos') {
				array_push($arraydos, $tampil);
			}

	
		}

		// echo "<pre>";print_r($arraydos);exit();

		$data['arraybody'] =$arraybody;
		$data['arrayhandlebar'] =$arrayhandlebar;
		$data['arraydos'] =$arraydos;


		$this->load->view('ProductionPlan/V_ItemBody', $data);

		$this->load->view('ProductionPlan/V_ItemHandleBar', $data);
		
		$this->load->view('ProductionPlan/V_ItemDos', $data);
	}

}