<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_BelumFabrikasi extends CI_Controller
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
			redirect('');
		}
	}

	public function index()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Belum Approve Fabrikasi';
		$data['Menu'] = 'Belum Approve Fabrikasi';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPicklist/FABRIKASI/V_BelumFabrikasi');
		$this->load->view('V_Footer',$data);
	}

	function searchData(){
		$dept 		= $this->input->post('dept');
		$tanggal1 	= $this->input->post('tanggal1');
		$tanggal2 	= $this->input->post('tanggal2');

		$getdata = $this->M_pickfabrikasi->getdataBelum($dept, $tanggal1, $tanggal2);
		foreach ($getdata as $key => $get) {
			$cek = $this->M_pickfabrikasi->cekdeliver($get['PICKLIST']);
			$getdata[$key]['DELIVER'] = $cek[0]['DELIVER'];
		}
		$data['data'] = $getdata;
		
		$this->load->view('MonitoringPicklist/FABRIKASI/V_TblBelumFabrikasi', $data);
	}

	function searchData2(){
		$dept 		= $this->input->post('dept');
		$tanggal1 	= $this->input->post('tanggal1');
		$tanggal2 	= $this->input->post('tanggal2');

		$data['data'] = $this->M_pickfabrikasi->getdataBelum($dept, $tanggal1, $tanggal2);
		$jml = count($data['data']);
		echo json_encode($jml);
	}

	function approveData(){
		$picklist = $this->input->post('picklist');
		$nojob = $this->input->post('nojob');
		$user = $this->session->user;
		// echo "<pre>";print_r($nojob);exit();
		$cek2 = $this->M_pickfabrikasi->cekapprove2($nojob);
		if (empty($cek2)) {
			$this->M_pickfabrikasi->approveData($picklist, $nojob, $user);
		}
	}

	function approveData2(){
		$nojob 		= $this->input->post('nojob');
		$picklist 	= $this->input->post('picklist');
		$cek 		= $this->input->post('cek');
		$user 		= $this->session->user;
		// echo "<pre>";print_r($cek);exit();

		for ($i=0; $i < count($nojob); $i++) { 
			if ($cek[$i] == 'uncek') {
				$cek2 = $this->M_pickfabrikasi->cekapprove2($nojob[$i]);
				if (empty($cek2)) {
					$this->M_pickfabrikasi->approveData($picklist[$i], $nojob[$i], $user);
				}
			}
		}

	}

	function printBelumFabrikasi($picklist){
		$date = date('dMY');
		$getdata = $this->M_pickfabrikasi->getdataBelum2($picklist);
		// echo "<pre>";print_r($getdata);exit();

		ob_start();
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
    	$pdf = new mPDF('utf-8',array(82,112), 0, '', 3, 3, 3, 3, 0, 0);
		$filename 	= 'BelumFabrikasi-'.$date.'.pdf';

		$this->load->library('ciqrcode');

		if(!is_dir('./img'))
		{
			mkdir('./img', 0777, true);
			chmod('./img', 0777);
		}
		
		foreach ($getdata as  $get) {
			$params['data']		= $get['NO_PICKLIST'];
			$params['level']	= 'H';
			$params['size']		= 10;
			$params['black']	= array(255,255,255);
			$params['white']	= array(0,0,0);
			$params['savename'] = './img/'.($get['NO_PICKLIST']).'.png';
			$this->ciqrcode->generate($params);
		}

		$data['data'] = $getdata;
    	$html = $this->load->view('MonitoringPicklist/FABRIKASI/V_PdfBelumFabrikasi', $data,true);
    	ob_end_clean();
    	$pdf->WriteHTML($html);												
    	$pdf->Output($filename, 'I');
		
	}

	public function cetaksemua(){
		$date = date('dMY');
		$picklist = $this->input->post('picklist[]');
		$cek = $this->input->post('printsemua[]');

		ob_start();
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
    	$pdf = new mPDF('utf-8',array(82,112), 0, '', 3, 3, 3, 3, 0, 0);
		$filename 	= 'BelumFabrikasi-'.$date.'.pdf';

		$this->load->library('ciqrcode');

		if(!is_dir('./img'))
		{
			mkdir('./img', 0777, true);
			chmod('./img', 0777);
		}

		for ($i=0; $i < count($picklist) ; $i++) { 
			if ($cek[$i] == 'uncek') {
				$getdata = $this->M_pickfabrikasi->getdataBelum2($picklist[$i]);
				// echo "<pre>";print_r($getdata);exit();
				foreach ($getdata as  $get) {
					$params['data']		= $get['NO_PICKLIST'];
					$params['level']	= 'H';
					$params['size']		= 10;
					$params['black']	= array(255,255,255);
					$params['white']	= array(0,0,0);
					$params['savename'] = './img/'.($get['NO_PICKLIST']).'.png';
					$this->ciqrcode->generate($params);
				}
		
				$data['data'] = $getdata;
				$html = $this->load->view('MonitoringPicklist/FABRIKASI/V_PdfBelumFabrikasi', $data,true);
				ob_end_clean();
				$pdf->WriteHTML($html);	
			}
		}										
    	$pdf->Output($filename, 'I');
	}


}