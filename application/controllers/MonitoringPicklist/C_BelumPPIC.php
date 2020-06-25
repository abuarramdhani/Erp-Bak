<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_BelumPPIC extends CI_Controller
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
		$this->load->model('MonitoringPicklist/M_picklistppic');

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

		$data['Title'] = 'Belum Approve';
		$data['Menu'] = 'Belum Approve';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPicklist/PPIC/V_BelumPPIC');
		$this->load->view('V_Footer',$data);
	}

	function getdept()
	{
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_picklistppic->getDept($term);
		echo json_encode($data);
	}

	function searchData(){
		$dept 		= $this->input->post('dept');
		$tanggal1 	= $this->input->post('tanggal1');
		$tanggal2 	= $this->input->post('tanggal2');

		$getdata = $this->M_picklistppic->getDataBelum($dept, $tanggal1, $tanggal2);
		foreach ($getdata as $key => $get) {
			$cek = $this->M_picklistppic->cekdeliver($get['PICKLIST']);
			$getdata[$key]['DELIVER'] = $cek[0]['DELIVER'];
		}
		$data['data'] = $getdata;
		// echo "<pre>";print_r($getdata);exit();
		
		$this->load->view('MonitoringPicklist/PPIC/V_TblBelumPPIC', $data);
	}

	function approveData(){
		$nojob = $this->input->post('nojob');
		$picklist = $this->input->post('picklist');
		$user = $this->session->user;
		// echo "<pre>";print_r($user);exit();

		$this->M_picklistppic->approvePPIC($picklist, $nojob, $user);
	}

	function approveData2(){
		$nojob 		= $this->input->post('nojob');
		$picklist 	= $this->input->post('picklist');
		$cek 		= $this->input->post('cek');
		$user 		= $this->session->user;
		// echo "<pre>";print_r($cek);exit();
		for ($i=0; $i < count($nojob); $i++) { 
			if ($cek[$i] == 'uncek') {
				$cek2 = $this->M_picklistppic->cekapprove2($nojob[$i]);
				if (empty($cek2)) {
					$this->M_picklistppic->approvePPIC($picklist[$i], $nojob[$i], $user);
				}
			}
		}

	}

}