<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class C_TambPot extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		$this->load->library('encrypt');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('UpahHlCm/M_prosesgaji');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
		date_default_timezone_set('Asia/Jakarta');
		$this->checkSession();
    }

    public function index(){
    	
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Tambahan / Potongan';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		

		$data['periodeGaji'] = $this->M_prosesgaji->getCutOffGaji();
		$angka = 0;
		foreach ($data['periodeGaji'] as $key) {
			$hasil = $this->M_prosesgaji->getTamPotAll($key['tanggal_awal'],$key['tanggal_akhir']);
			foreach ($hasil as $value) {
				$data['data'][$angka] = $value;
				$angka++;
			}
			
		}
		
		// echo "<pre>";print_r($data['data']);exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/ProsesGaji/V_indexTambahan',$data);
		$this->load->view('V_Footer',$data);
    }

    public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}

	public function noind_pekerja(){
		$text = $this->input->get('term');
		$data = $this->M_prosesgaji->getPekerjaPotTam($text);
		echo json_encode($data);
	}

	public function add_data(){
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Tambahan / Potongan';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['periodeGaji'] = $this->M_prosesgaji->getCutOffGajiPotTam();
		$data['hasil'] = array();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/ProsesGaji/V_addTambahan',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Simpan(){
		// echo "<pre>";print_r($_POST);exit();
		$periode = $this->input->post('slc-hlcm-tampot-periode');
		$prd = explode(" - ", $periode);
		$noind = $this->input->post('slc-hlcm-tampot-noind');
		//tambahan
		$tam_gp = $this->input->post('txt-hlcm-tam-gp');
		$tam_lembur = $this->input->post('txt-hlcm-tam-lembur');
		$tam_um = $this->input->post('txt-hlcm-tam-um');
		if (!isset($tam_gp) or empty($tam_gp)) {
			$tam_gp = "0";
		}
		if (!isset($tam_lembur) or empty($tam_lembur)) {
			$tam_lembur = "0";
		}
		if (!isset($tam_um) or empty($tam_um)) {
			$tam_um = "0";
		}
		//potongan
		$pot_gp = $this->input->post('txt-hlcm-pot-gp');
		$pot_lembur = $this->input->post('txt-hlcm-pot-lembur');
		$pot_um = $this->input->post('txt-hlcm-pot-um');
		if (!isset($pot_gp) or empty($pot_gp)) {
			$pot_gp = "0";
		}
		if (!isset($pot_lembur) or empty($pot_lembur)) {
			$pot_lembur = "0";
		}
		if (!isset($pot_um) or empty($pot_um)) {
			$pot_um = "0";
		}


		if (!empty($noind)) {

			$nominal = $this->M_prosesgaji->ambilNominalGajiPotTam($noind);
			// print_r($nominal);exit();
			$nominalgpokok = $nominal->nominal;
			$nominalumakan = $nominal->uang_makan;
			$nominallembur = round($nominalgpokok/7);
			
			$data_tambahan = array(
				'noind' 	=> $noind,
				'gp' 		=> floatval($tam_gp),
				'lembur' 	=> floatval($tam_lembur),
				'um'		=> floatval($tam_um),
				'nominal_gp' => floatval($tam_gp)*$nominalgpokok,
				'nominal_um' => floatval($tam_um)*$nominalumakan,
				'nominal_lembur' => round(floatval($tam_lembur)*$nominallembur,'0'),
				'tgl_awal_periode' => $prd['0'],
				'tgl_akhir_periode' => $prd['1'],
				'created_by' => $this->session->user,
				'gp_perhari' => $nominalgpokok,
				'um_perhari' => $nominalumakan,
				'lembur_perjam' => $nominallembur
			);
			$this->M_prosesgaji->insertPotTam('hlcm.hlcm_tambahan',$data_tambahan);
			

			$data_potongan = array(
				'noind' 	=> $noind,
				'gp' 		=> floatval($pot_gp),
				'lembur' 	=> floatval($pot_lembur),
				'um'		=> floatval($pot_um),
				'nominal_gp' => floatval($pot_gp)*$nominalgpokok,
				'nominal_um' => floatval($pot_um)*$nominalumakan,
				'nominal_lembur' => round(floatval($pot_lembur)*$nominallembur,'0'),
				'tgl_awal_periode' => $prd['0'],
				'tgl_akhir_periode' => $prd['1'],
				'created_by' => $this->session->user,
				'gp_perhari' => $nominalgpokok,
				'um_perhari' => $nominalumakan,
				'lembur_perjam' => $nominallembur
			);
			$this->M_prosesgaji->insertPotTam('hlcm.hlcm_potongan',$data_potongan);

			$this->M_prosesgaji->insertHistoryPotTam($prd['0'],$prd['1'],$noind,$this->session->user,'1');
		}else{
			$pekerja = $this->M_prosesgaji->getPekerjaPotTam("");
			if (!empty($pekerja)) {
				foreach ($pekerja as $key) {
					$noind = $key['noind'];
					$nominal = $this->M_prosesgaji->ambilNominalGajiPotTam($noind);
					$nominalgpokok = $nominal['nominal'];
					$nominalumakan = $nominal['uang_makan'];
					$nominallembur = round($nominalgpokok/7);
					
					$data_tambahan = array(
						'noind' 	=> $noind,
						'gp' 		=> floatval($tam_gp),
						'lembur' 	=> floatval($tam_lembur),
						'um'		=> floatval($tam_um),
						'nominal_gp' => floatval($tam_gp)*$nominalgpokok,
						'nominal_um' => floatval($tam_um)*$nominalumakan,
						'nominal_lembur' => round(floatval($tam_lembur)*$nominallembur,'0'),
						'tgl_awal_periode' => $prd['0'],
						'tgl_akhir_periode' => $prd['1'],
						'created_by' => $this->session->user,
						'gp_perhari' => $nominalgpokok,
						'um_perhari' => $nominalumakan,
						'lembur_perjam' => $nominallembur
					);
					$this->M_prosesgaji->insertPotTam('hlcm.hlcm_tambahan',$data_tambahan);
					
					$data_potongan = array(
						'noind' 	=> $noind,
						'gp' 		=> floatval($pot_gp),
						'lembur' 	=> floatval($pot_lembur),
						'um'		=> floatval($pot_um),
						'nominal_gp' => floatval($pot_gp)*$nominalgpokok,
						'nominal_um' => floatval($pot_um)*$nominalumakan,
						'nominal_lembur' =>  round(floatval($pot_lembur)*$nominallembur,'0'),
						'tgl_awal_periode' => $prd['0'],
						'tgl_akhir_periode' => $prd['1'],
						'created_by' => $this->session->user,
						'gp_perhari' => $nominalgpokok,
						'um_perhari' => $nominalumakan,
						'lembur_perjam' => $nominallembur
					);
					$this->M_prosesgaji->insertPotTam('hlcm.hlcm_potongan',$data_potongan);
					
					$this->M_prosesgaji->insertHistoryPotTam($prd['0'],$prd['1'],$noind,$this->session->user,'1');
				}
			}
		}
		redirect(site_url("HitungHlcm/TambahanPotongan"));
	}

	public function History(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Tambahan / Potongan';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_prosesgaji->getHistoryTamPot();
		
		// echo "<pre>";print_r($data['data']);exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/ProsesGaji/V_history',$data);
		$this->load->view('V_Footer',$data);
	}

	public function detailHistory(){
		$periode = $this->input->post('periode');
		$noind = $this->input->post('noind');
		$prd = explode(" - ", $periode);
		$data = $this->M_prosesgaji->getDetailHistoryTamPot($noind,$prd['0'],$prd['1']);
		$angka = 0;
		foreach ($data as $key) {
			$data[$angka]['pnominal_gp'] 		= number_format($key['pnominal_gp'],0,'.','.');
			$data[$angka]['pgp_perhari'] 		= number_format($key['pgp_perhari'],0,'.','.');
			$data[$angka]['pnominal_um'] 		= number_format($key['pnominal_um'],0,'.','.');
			$data[$angka]['pum_perhari'] 		= number_format($key['pum_perhari'],0,'.','.');
			$data[$angka]['pnominal_lembur'] 	= number_format($key['pnominal_lembur'],0,'.','.');
			$data[$angka]['plembur_perjam'] 	= number_format($key['plembur_perjam'],0,'.','.');
			$data[$angka]['tnominal_gp'] 		= number_format($key['tnominal_gp'],0,'.','.');
			$data[$angka]['tgp_perhari'] 		= number_format($key['tgp_perhari'],0,'.','.');
			$data[$angka]['tnominal_um'] 		= number_format($key['tnominal_um'],0,'.','.');
			$data[$angka]['tum_perhari'] 		= number_format($key['tum_perhari'],0,'.','.');
			$data[$angka]['tnominal_lembur'] 	= number_format($key['tnominal_lembur'],0,'.','.');
			$data[$angka]['tlembur_perjam'] 	= number_format($key['tlembur_perjam'],0,'.','.');
			$angka++;
		}
		echo json_encode($data);
	}

	public function lihatdata(){
		$periode = $this->input->post('periode');
		$prd = explode(" - ", $periode);
		$noind = $this->input->post('noind');
		if (isset($noind) and !empty($noind)) {
			$data = $this->M_prosesgaji->getTamPotAll($prd['0'],$prd['1'],$noind);
		}else{
			$data = $this->M_prosesgaji->getTamPotAll($prd['0'],$prd['1']);
		}
		
		echo json_encode($data);
	}

	public function editdata($link){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $link);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$data_decoded = explode("--", $plaintext_string);
		$tgl_awal = $data_decoded['0'];
		$tgl_akhir = $data_decoded['1'];
		$noind = $data_decoded['2'];
		
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Tambahan / Potongan';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['periodeGaji'] = $this->M_prosesgaji->getCutOffGajiPotTam();
		$data['data'] = $this->M_prosesgaji->getTamPotAll($tgl_awal,$tgl_akhir,$noind);
		$data['link'] = $link;
		// echo "<pre>";print_r($data);exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/ProsesGaji/V_editTambahan',$data);
		$this->load->view('V_Footer',$data);
	}

	public function updatedata($link){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $link);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$data_decoded = explode("--", $plaintext_string);
		$tgl_awal = $data_decoded['0'];
		$tgl_akhir = $data_decoded['1'];
		$noind = $data_decoded['2'];
		//tambahan
		$tam_gp = $this->input->post('txt-hlcm-tam-gp');
		$tam_lembur = $this->input->post('txt-hlcm-tam-lembur');
		$tam_um = $this->input->post('txt-hlcm-tam-um');
		if (!isset($tam_gp) or empty($tam_gp)) {
			$tam_gp = "0";
		}
		if (!isset($tam_lembur) or empty($tam_lembur)) {
			$tam_lembur = "0";
		}
		if (!isset($tam_um) or empty($tam_um)) {
			$tam_um = "0";
		}
		//potongan
		$pot_gp = $this->input->post('txt-hlcm-pot-gp');
		$pot_lembur = $this->input->post('txt-hlcm-pot-lembur');
		$pot_um = $this->input->post('txt-hlcm-pot-um');
		if (!isset($pot_gp) or empty($pot_gp)) {
			$pot_gp = "0";
		}
		if (!isset($pot_lembur) or empty($pot_lembur)) {
			$pot_lembur = "0";
		}
		if (!isset($pot_um) or empty($pot_um)) {
			$pot_um = "0";
		}
		// echo "<pre>";print_r($_POST);exit();
		$nominal = $this->M_prosesgaji->getNominalFromTamPot($tgl_awal,$tgl_akhir,$noind);
		$nominalgpokok = $nominal->gp_perhari;
		$nominalumakan = $nominal->um_perhari;
		$nominallembur = $nominal->lembur_perjam;

		$this->M_prosesgaji->insertHistoryPotTam($tgl_awal,$tgl_akhir,$noind,$this->session->user,'2');

		$this->M_prosesgaji->updateTamPot($tgl_awal,$tgl_akhir,$noind,$data,'potongan',$pot_gp,$pot_um,$pot_lembur);
		$this->M_prosesgaji->updateTamPot($tgl_awal,$tgl_akhir,$noind,$data,'tambahan',$tam_gp,$tam_um,$tam_lembur);
		
		$this->M_prosesgaji->insertHistoryPotTam($tgl_awal,$tgl_akhir,$noind,$this->session->user,'3');

		redirect(site_url('HitungHlcm/TambahanPotongan'));
	}

	public function hapusdata($data){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $data);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$data_decoded = explode("--", $plaintext_string);
		$tgl_awal = $data_decoded['0'];
		$tgl_akhir = $data_decoded['1'];
		$noind = $data_decoded['2'];
		$this->M_prosesgaji->insertHistoryPotTam($tgl_awal,$tgl_akhir,$noind,$this->session->user,'4');
		$this->M_prosesgaji->deleteTamPot($tgl_awal,$tgl_akhir,$noind);

		redirect(site_url('HitungHlcm/TambahanPotongan'));
	}
}
?>