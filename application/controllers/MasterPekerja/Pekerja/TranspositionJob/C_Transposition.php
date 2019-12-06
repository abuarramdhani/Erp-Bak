<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Transposition extends CI_Controller {


	public function __construct()
  	{
    	parent::__construct();

    	$this->load->library('General');
    	$this->load->library('KonversiBulan');

    	$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPekerja/Pekerja/TranspositionJob/M_transposition');

  		date_default_timezone_set('Asia/Jakarta');
  	}

  	public function checkSession(){
		if($this->session->is_logged){

		}else{
			redirect('');
		}
	}

	//HALAMAN INDEX
	public function index(){
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Transposisi Plotting Job';
		$data['Title'] = 'Transposisi Plotting Job';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

	    $data['noind'] = $this->M_transposition->getTpribadi();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Pekerja/TranspositionJob/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

  	public function change()
  	{
    	$noind = $this->input->post('noind');
    	$data = $this->M_transposition->getPekerjaan($noind);
 		$data['kerja'] = $this->M_transposition->getTpekerjaan($data[0]['kodesie']);
    	echo json_encode($data);
  	}

	public function save()
	{
		$user = $this->session->user;
		$noind = $this->input->post('noind');
		$pkj_lm = $this->input->post('pkj_lm');
		$kerja = explode(' - ', $pkj_lm);
		$pkj_now = $this->input->post('pkj_now');
		$date = $this->input->post('date');
		$date = explode(' ', $date);
		$bulan = $this->konversibulan->KonversiBulanInggrisKeAngka($date[1]);
		$tgl_berubah = $date[2].'-'.$bulan.'-'.$date[0];
		$today = date('Y-m-d');

		if ($tgl_berubah <= $today) {
			$save = array
			(
				'noind' 			=> $noind,
				'kdpekerjaan_lama' 	=> $kerja[0],
				'kdpekerjaan_baru' 	=> $pkj_now,
				'tgl_berlaku'		=> $tgl_berubah,
				'user' 				=> $user,
				'tgl_update' 		=> date('Y-m-d H:i:s'),
				'trans_tpribadi'	=> '1',
			);
			$this->M_transposition->saveMasterPekerja($save);
			$this->M_transposition->updatetpribadi($pkj_now, $kerja[0], $noind);

			$log = array
			(
				'wkt' 		=> 'now()',
				'menu' 		=> 'MASTER_PKJ->PEKERJA->TRANSPOSISI',
				'ket'		=> 'NOIND->'.$noind.' KD_PKJ->'.$kerja[0].' MENJADI '.$pkj_now,
				'noind'		=> $user,
				'jenis'		=> 'UPDATE->TPRIBADI->KD_PKJ',
				'program'	=> 'MPK',
			);
			$this->M_transposition->inTlog($log);
		}else if($tgl_berubah > $today){
			$save = array
			(
					'noind' 			=> $noind,
					'kdpekerjaan_lama' 	=> $kerja[0],
					'kdpekerjaan_baru' 	=> $pkj_now,
					'tgl_berlaku' 		=> $tgl_berubah,
					'user' 				=> $user,
					'tgl_update' 		=> date('Y-m-d H:i:s'),
					'trans_tpribadi'	=> '0',
			);
			$this->M_transposition->saveMasterPekerja($save);
		}
	}
}
?>
