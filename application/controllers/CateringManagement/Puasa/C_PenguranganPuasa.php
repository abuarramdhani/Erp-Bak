<?php
Defined('BASEPATH') or exit('No direct script accsess allowed');
/**
 * 
 */
class C_PenguranganPuasa extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('file');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('CateringManagement/Puasa/M_penguranganpuasa');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Pengurangan Puasa';
		$data['Menu'] = 'Puasa';
		$data['SubMenuOne'] = 'Pengurangan Puasa';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['Pekerja'] = $this->M_penguranganpuasa->getPekerjaKHSAll();
		// $data['Pekerja'] = $this->M_penguranganpuasa->getPekerjaKHSIslam();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Puasa/PenguranganPuasa/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Read($date=FALSE){
		$user_id = $this->session->userid;

		$data['Title'] = 'Pengurangan Puasa';
		$data['Menu'] = 'Puasa';
		$data['SubMenuOne'] = 'Pengurangan Puasa';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		if ($date!==FALSE) {
			$periode_text = str_replace(array('-','_','~'), array('+','/','='), $date);
			$periode_text = $this->encrypt->decode($periode_text);
			$tanggal = $periode_text;
			$noind = $this->input->post('txtNoindPuasaEdit');
			$status = $this->input->post('radioStatusPuasa');
			// print_r($_POST);exit();
			if (isset($status)) {
				$tanggaledit = $this->input->post('txtTanggalPuasaEdit');
				$tanggalUpdate = explode(" - ", $tanggaledit);
				$this->M_penguranganpuasa->updatePuasaByTanggalNoind($tanggalUpdate,$noind,$status);
			}else{
				$tanggaledit = $this->input->post('txtTanggalPuasaDelete');
				$tanggalDetele = explode(" - ", $tanggaledit);
				$this->M_penguranganpuasa->deletePuasaByTanggalNoind($tanggalDetele,$noind);
			}
		}else{
			$noind = $this->input->post('txtNoindPenguranganPuasa');
			$tanggal = $this->input->post('txtBulanTransferPuasa');
		}

		$data['Pekerja'] = $this->M_penguranganpuasa->getPekerjaHKSAllByNoind($noind);
		// $data['Pekerja'] = $this->M_penguranganpuasa->getPekerjaHKSIslamByNoind($noind);
		$data['Tanggal'] = $tanggal;
		$data['noind'] = $noind;
		$encrypted_date = $this->encrypt->encode($tanggal);
		$encrypted_date = str_replace(array('+','/','='), array('-','_','~'), $encrypted_date);
		$data['encrypted_date'] = $encrypted_date;
		$tgl = explode(" - ", $tanggal);
		$puasa = $this->M_penguranganpuasa->getPuasaPekerja($noind,$tgl['0'],$tgl['1']);
		$angka = 0;
		$banyak = 1;
		$statussebelum = "";
		$tanggalsebelum = "";
		$tglsebelum = 0;
		$blnsebelum = 0;
		$arrPuasa = array();
		$bulan = array(
			"",
			"Januari",
			"Februari",
			"Maret",
			"April",
			"Mei",
			"Juni",
			"Juli",
			"Agustus",
			"September",
			"Oktober",
			"November",
			"Desember"
		);
		$akhirBulan = array (
			'',
			'31',
			'28',
			'31',
			'30',
			'31',
			'30',
			'31',
			'31',
			'30',
			'31',
			'30',
			'31'
		);
		foreach ($puasa as $val) {
			$tglnow = explode("-", $val['tanggal']);
			if ($statussebelum == $val['status'] and ((intval($tglnow['2'])-$tglsebelum) == 1 or (intval($tglnow['2']) == 1 and $tglsebelum == $akhirBulan[$blnsebelum])) and $banyak !== intval($val['banyak'])) {
			}else{
				if ($angka == 0) {
					$arrPuasa[$angka]['tanggal'] = $tglnow['2']." ".$bulan[intval($tglnow['1'])]." ".$tglnow['0'];
					$arrPuasa[$angka]['status'] = $val['status'];
					
				}elseif ($banyak == $val['banyak']) {
					if ($statussebelum == $val['status'] and (intval($tglnow['2'])-$tglsebelum) == 1) {
						$arrPuasa[$angka-1]['tanggal'] = $arrPuasa[$angka-1]['tanggal']." - ".$tglnow['2']." ".$bulan[intval($tglnow['1'])]." ".$tglnow['0'];
						
					}else{
						$arrPuasa[$angka]['tanggal'] = $tglnow['2']." ".$bulan[intval($tglnow['1'])]." ".$tglnow['0'];
						$arrPuasa[$angka]['status'] = $val['status'];
						
					}
				}else{
					if($arrPuasa[$angka-1]['tanggal'] !== $tanggals and $arrPuasa[$angka-1]['status'] == $statussebelum) {
						$arrPuasa[$angka-1]['tanggal'] = $arrPuasa[$angka-1]['tanggal']." - ".$tanggals;
						$arrPuasa[$angka]['tanggal'] = $tglnow['2']." ".$bulan[intval($tglnow['1'])]." ".$tglnow['0'];
						$arrPuasa[$angka]['status'] = $val['status'];
						
					}else{
						$arrPuasa[$angka]['tanggal'] = $tglnow['2']." ".$bulan[intval($tglnow['1'])]." ".$tglnow['0'];
						$arrPuasa[$angka]['status'] = $val['status'];
						
					}
				}
				$angka++;
			}
			// echo $banyak." <> ".$val['banyak'];
			$statussebelum = $val['status'];
			$tanggalsebelum = $val['tanggal'];
			$tanggals = $tglnow['2']." ".$bulan[intval($tglnow['1'])]." ".$tglnow['0'];
			$tglsebelum = intval($tglnow['2']);
			$blnsebelum = intval($tglnow['1']);
			$banyak++;
		}
		
		
		// echo "<pre>";print_r($arrPuasa);exit();

		$data['puasa'] = $arrPuasa;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Puasa/PenguranganPuasa/V_read',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Edit(){

	}
}
?>