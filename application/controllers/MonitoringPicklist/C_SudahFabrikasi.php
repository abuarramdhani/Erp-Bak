<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_SudahFabrikasi extends CI_Controller
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
		$this->load->model('MonitoringPicklist/M_pickfabrikasi');

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

		$data['Title'] = 'Sudah Approve Fabrikasi';
		$data['Menu'] = 'Sudah Approve Fabrikasi';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPicklist/FABRIKASI/V_SudahFabrikasi');
		$this->load->view('V_Footer',$data);
	}

	function searchData(){
		$dept 	= $this->input->post('dept');
		$tanggal 	= $this->input->post('tanggal');
		$tgl = explode('/', $tanggal);
		$data['tgl'] = $tgl[0].'-'.$tgl[1].'-'.$tgl[2];
		// echo "<pre>";print_r($tgl);exit();

		$data['data'] = $this->M_pickfabrikasi->getdataSudah($dept, $tanggal);
		
		$this->load->view('MonitoringPicklist/FABRIKASI/V_TblSudahFabrikasi', $data);
	}

	function recallData(){
		$nojob = $this->input->post('nojob');
		$picklist = $this->input->post('picklist');
		
		$cek = $this->M_pickfabrikasi->cekapprove($nojob, $picklist);
		// echo "<pre>";print_r($cek);exit();
		if (empty($cek)) {
			$this->M_pickfabrikasi->recallData($picklist, $nojob);
		}
	}

	function printFabrikasi($picklist, $dept, $tgl){
		$date = date('dMY');
		$getdata = $this->M_pickfabrikasi->getdataSudah2($dept, $tgl, $picklist);
		// echo "<pre>";print_r($get);exit();

		ob_start();
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
    	$pdf = new mPDF('utf-8',array(100,100), 0, '', 13, 13, 0, 5, 0, 0);
		$filename 	= 'picklist-'.$date.'.pdf';
		// $tglNama = date("d/m/Y");

		$this->load->library('ciqrcode');

		if(!is_dir('./img'))
		{
			mkdir('./img', 0777, true);
			chmod('./img', 0777);
		}
		
		foreach ($getdata as  $get) {
			$params['data']		= $get['PICKLIST'];
			$params['level']	= 'H';
			$params['size']		= 10;
			$params['black']	= array(255,255,255);
			$params['white']	= array(0,0,0);
			$params['savename'] = './img/'.($get['PICKLIST']).'.png';
			$this->ciqrcode->generate($params);
		}

		$data['data'] = $getdata;
    	$html = $this->load->view('MonitoringPicklist/FABRIKASI/V_Pdffabrikasi', $data, true);
    	ob_end_clean();
    	$pdf->WriteHTML($html);												
    	$pdf->Output($filename, 'I');
		
	}


}