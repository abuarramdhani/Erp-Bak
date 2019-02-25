<?php 

Defined('BASEPATH') or exit('No direct script access allowed');

class C_Report extends CI_Controller
{
	
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
		$this->load->model('PNBPAdministrator/M_report');
		  
		$this->checkSession();
	}

	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}

	public function index(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Report Data';
		$data['Menu'] = 'Report';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['periode'] = $this->M_report->getPeriode();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PNBPAdministrator/Report/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getPekerja(){
		$noind = $this->input->get('term');
		$prd = $this->input->get('periode');
		$data = $this->M_report->getPekerjaHasHasil($noind,$prd);
		echo json_encode($data);
	}

	public function getData(){
		$noind = $this->input->post('noind');
		$periode = $this->input->post('periode');

		$data = $this->M_report->getData($noind,$periode);
		$label = $this->M_report->getLabel();
		$array = array();
		$i = 0;
		$j = 0;
		$kelompok = "";

		$warna = array('rgba(255,23,68,1)','rgba(3,163,244,1)','rgba(118,255,3,1)','rgba(255,235,3,1)','rgba(255,235,59,1)','rgba(121,85,72,1)','rgba(124,77,255,1)');
		$warna2 = array('rgba(255,23,68,0.1)','rgba(3,163,244,0.1)','rgba(118,255,3,0.1)','rgba(255,235,3,0.1)','rgba(255,235,59,0.1)','rgba(121,85,72,0.1)','rgba(124,77,255,0.1)');

		foreach ($data as $key) {
			if ($key['kelompok'] !== $kelompok) {
				if ($kelompok == "") {
					$i = 0;
				}else{
					$i++;
				}
				
				$array[$i]['label'] = $key['kelompok'];
				$array[$i]['borderColor'] = $warna[$i];
				$array[$i]['backgroundColor'] = $warna2[$i];
				$array[$i]['pointBackgroundColor'] = $warna[$i] ;
				$j = 0;
				foreach ($label as $lbl) {
					if (!isset($array[$i]['notes'][$j]) or empty($array[$i]['notes'][$j])) {
						$array[$i]['data'][$j] = "0";
					}
					if ($lbl['nama_aspek'] == $key['nama_aspek']) {
						$aspek = explode(" ", $key['nama_aspek']);
						$array[$i]['notes'][$j] = $aspek;
						$array[$i]['data'][$j] = number_format($key['nilai'],2);
					}
					$j++;
				}
				
			}else{
				$j = 0;
				foreach ($label as $lbl) {
					if (!isset($array[$i]['notes'][$j]) or empty($array[$i]['notes'][$j])) {
						$array[$i]['data'][$j] = "0";
					}
					if ($lbl['nama_aspek'] == $key['nama_aspek']) {
						$aspek = explode(" ", $key['nama_aspek']);
						$array[$i]['notes'][$j] = $aspek;
						$array[$i]['data'][$j] = number_format($key['nilai'],2);
					}
					$j++;
				}
			}
			$kelompok = $key['kelompok'];
		}

		echo json_encode($array);
	}

	public function getData1(){
		$noind = $this->input->post('noind');
		$periode = $this->input->post('periode');

		$data = $this->M_report->getDataKecil1($noind,$periode);
		$label = $this->M_report->getLabel();
		$array = array();
		$i = 0;
		$j = 0;
		$kelompok = "";

		$warna = array('rgba(255,23,68,1)','rgba(3,163,244,1)','rgba(118,255,3,1)','rgba(255,235,3,1)','rgba(255,235,59,1)','rgba(121,85,72,1)','rgba(124,77,255,1)');
		$warna2 = array('rgba(255,23,68,0.1)','rgba(3,163,244,0.1)','rgba(118,255,3,0.1)','rgba(255,235,3,0.1)','rgba(255,235,59,0.1)','rgba(121,85,72,0.1)','rgba(124,77,255,0.1)');

		foreach ($data as $key) {
			if ($key['kelompok'] !== $kelompok) {
				if ($kelompok == "") {
					$i = 0;
				}else{
					$i++;
				}
				
				$array[$i]['label'] = $key['kelompok'];
				$array[$i]['borderColor'] = $warna[$i];
				$array[$i]['backgroundColor'] = $warna2[$i];
				$array[$i]['pointBackgroundColor'] = $warna[$i] ;
				$j = 0;
				foreach ($label as $lbl) {
					if (!isset($array[$i]['notes'][$j]) or empty($array[$i]['notes'][$j])) {
						$array[$i]['data'][$j] = "0";
					}
					if ($lbl['nama_aspek'] == $key['nama_aspek']) {
						$aspek = explode(" ", $key['nama_aspek']);
						$array[$i]['notes'][$j] = $aspek;
						$array[$i]['data'][$j] = number_format($key['nilai'],2);
					}
					$j++;
				}
				
			}else{
				$j = 0;
				foreach ($label as $lbl) {
					if (!isset($array[$i]['notes'][$j]) or empty($array[$i]['notes'][$j])) {
						$array[$i]['data'][$j] = "0";
					}
					if ($lbl['nama_aspek'] == $key['nama_aspek']) {
						$aspek = explode(" ", $key['nama_aspek']);
						$array[$i]['notes'][$j] = $aspek;
						$array[$i]['data'][$j] = number_format($key['nilai'],2);
					}
					$j++;
				}
			}
			$kelompok = $key['kelompok'];
		}

		echo json_encode($array);
	}

	public function getData2(){
		$noind = $this->input->post('noind');
		$periode = $this->input->post('periode');

		$data = $this->M_report->getDataKecil2($noind,$periode);
		$label = $this->M_report->getLabel();
		$array = array();
		$i = 0;
		$j = 0;
		$kelompok = "";

		$warna = array('rgba(118,255,3,1)','rgba(255,235,3,1)','rgba(255,235,59,1)','rgba(121,85,72,1)','rgba(124,77,255,1)','rgba(255,23,68,1)','rgba(3,163,244,1)');
		$warna2 = array('rgba(118,255,3,0.1)','rgba(255,235,3,0.1)','rgba(255,235,59,0.1)','rgba(121,85,72,0.1)','rgba(124,77,255,0.1)','rgba(255,23,68,0.1)','rgba(3,163,244,0.1)');

		foreach ($data as $key) {
			if ($key['kelompok'] !== $kelompok) {
				if ($kelompok == "") {
					$i = 0;
				}else{
					$i++;
				}
				
				$array[$i]['label'] = $key['kelompok'];
				$array[$i]['borderColor'] = $warna[$i];
				$array[$i]['backgroundColor'] = $warna2[$i];
				$array[$i]['pointBackgroundColor'] = $warna[$i] ;
				$j = 0;
				foreach ($label as $lbl) {
					if (!isset($array[$i]['notes'][$j]) or empty($array[$i]['notes'][$j])) {
						$array[$i]['data'][$j] = "0";
					}
					if ($lbl['nama_aspek'] == $key['nama_aspek']) {
						$aspek = explode(" ", $key['nama_aspek']);
						$array[$i]['notes'][$j] = $aspek;
						$array[$i]['data'][$j] = number_format($key['nilai'],2);
					}
					$j++;
				}
				
			}else{
				$j = 0;
				foreach ($label as $lbl) {
					if (!isset($array[$i]['notes'][$j]) or empty($array[$i]['notes'][$j])) {
						$array[$i]['data'][$j] = "0";
					}
					if ($lbl['nama_aspek'] == $key['nama_aspek']) {
						$aspek = explode(" ", $key['nama_aspek']);
						$array[$i]['notes'][$j] = $aspek;
						$array[$i]['data'][$j] = number_format($key['nilai'],2);
					}
					$j++;
				}
			}
			$kelompok = $key['kelompok'];
		}

		echo json_encode($array);
	}

	public function getNama(){
		$noind = $this->input->post('noind');
		$periode = $this->input->post('periode');

		$data = $this->M_report->getDemografi($noind,$periode);
		echo json_encode($data);
	}
}

?>