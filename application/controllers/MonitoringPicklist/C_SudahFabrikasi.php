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
			redirect('');
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
		$tanggal1 	= $this->input->post('tanggal1');
		$tanggal2 	= $this->input->post('tanggal2');
		// $tgl = explode('/', $tanggal1);
		// $data['tgl'] = $tgl[0].'-'.$tgl[1].'-'.$tgl[2];
		// echo "<pre>";print_r($tgl);exit();

		$getdata = $this->M_pickfabrikasi->getdataSudah($dept, $tanggal1, $tanggal2);
		foreach ($getdata as $key => $get) {
			$cek = $this->M_pickfabrikasi->cekdeliver($get['PICKLIST']);
			$getdata[$key]['DELIVER'] = $cek[0]['DELIVER'];
		}
		$datanya = $this->sortbyTanggalPelayanan($getdata);
		// echo "<pre>";print_r($datanya);exit();
		$data['data'] = $datanya;
		
		$this->load->view('MonitoringPicklist/FABRIKASI/V_TblSudahFabrikasi', $data);
	}
	
	public function sortbyTanggalPelayanan($getdata){
		// $pelayanan = $this->M_pickfabrikasi->cariReqPelayanan();
		// $datanya = $nojob = $datanya2 = array();
		// foreach ($pelayanan as $key => $value) {
		// 	foreach ($getdata as $key2 => $get) {
		// 		if ($get['JOB_NO'] == $value['JOB_NUMBER']) {
		// 			$getdata[$key2]['TGL_PELAYANAN'] = $value['TANGGAL_PELAYANAN'];
		// 			$shift = $this->M_pickfabrikasi->getShift2($value['SHIFT']);
		// 			$getdata[$key2]['SHIFT'] = $shift[0]['DESCRIPTION'];
		// 			array_push($datanya, $getdata[$key2]);
		// 			array_push($nojob, $get['JOB_NO']);
		// 		}
		// 	}
		// }
		
		$datanya = $nojob = $datanya2 = $picklist = array();
		foreach ($getdata as $key2 => $get) {
			$cari_plyn = $this->M_pickfabrikasi->cariReqPelayanan2($get['JOB_NO']);
			if (!empty($cari_plyn)) {
				foreach ($cari_plyn as $key3 => $value) {
					if ($value['JOB_NUMBER'] == $get['PICKLIST'] || ($value['JOB_NUMBER'] == $get['JOB_NO'] && !in_array($get['PICKLIST'], $picklist))) {
						$getdata[$key2]['TGL_PELAYANAN'] = $value['TANGGAL_PELAYANAN'];
						$shift = $this->M_pickfabrikasi->getShift2($value['SHIFT']);
						$getdata[$key2]['SHIFT'] = $shift[0]['DESCRIPTION'];
						array_push($datanya, $getdata[$key2]);
						array_push($nojob, $get['JOB_NO']);
						array_push($picklist, $get['PICKLIST']);
					}
				}
			}
		}
		foreach ($getdata as $key => $val) {
			if (!in_array($val['JOB_NO'], $nojob)) {
				$getdata[$key]['TGL_PELAYANAN'] = $getdata[$key]['SHIFT'] = '';
				array_push($datanya2, $getdata[$key]);
			}
		}
		
		foreach ($datanya as $key => $value) {
			array_push($datanya2, $datanya[$key]);
		}
		// echo "<pre>";print_r($datanya);exit();
		return $datanya2;
	}

	function recallData(){
		$nojob = $this->input->post('nojob');
		$picklist = $this->input->post('picklist');
		
		$cek = $this->M_pickfabrikasi->cekapprove($nojob, $picklist);
		// echo "<pre>";print_r($cek);exit();
		if (empty($cek)) {
			$this->M_pickfabrikasi->recallData($picklist, $nojob);
			$cek2 = $this->M_pickfabrikasi->cariReqPelayanan2($picklist);
			if (!empty($cek2)) {
				$this->M_pickfabrikasi->recallpermintaan($picklist);
			}else {
				$this->M_pickfabrikasi->recallpermintaan($nojob);
			}
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