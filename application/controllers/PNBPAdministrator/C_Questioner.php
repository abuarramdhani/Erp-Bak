<?php 

Defined('BASEPATH') or exit('No direct script access allowed');

class C_Questioner extends CI_Controller
{
	
	public function __construct()
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
		$this->load->model('PNBPAdministrator/M_questioner');
		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title'] = 'Demografi';
		$data['Menu'] = 'Questioner';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$cek = $this->M_questioner->gethasilPeriodeIni($user);
		if ($cek == 0) {
			$data['data'] = $this->M_questioner->getWorker($user);
			$data['suku'] = $this->M_questioner->getSuku();
			$data['pendidikan'] = $this->M_questioner->getPendidikan();

			$data['periode'] = $this->M_questioner->getPeriodePengisian();
		}else{
			$data['ada'] = '1';
		}

		$this->form_validation->set_rules('txtNoindUser', 'Noind', 'required');
		$this->form_validation->set_rules('txtNamaUser', 'Nama', 'required');
		$this->form_validation->set_rules('txtSeksiUser', 'Seksi', 'required');
		$this->form_validation->set_rules('txtKodesie', 'Kodesie', 'required');
		$this->form_validation->set_rules('txtDepartmentUser', 'Departemen', 'required');
		$this->form_validation->set_rules('txtMasaKerja', 'MasaKerja', 'required');
		$this->form_validation->set_rules('txtJenKel', 'JenisKelamin', 'required');
		$this->form_validation->set_rules('txtUsia', 'Usia', 'required');
		$this->form_validation->set_rules('txtSuku', 'Suku', 'required');
		$this->form_validation->set_rules('txtJabatanUser', 'Jabatan', 'required');
		$this->form_validation->set_rules('txtPendidikanAkhir', 'Pendidikan', 'required');

		if ($this->form_validation->run() === FALSE) {
			
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('PNBPAdministrator/Questioner/V_index.php',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$noind = $this->input->post('txtNoindUser');
			$nama = $this->input->post('txtNamaUser');
			$seksi = $this->input->post('txtSeksiUser');
			$kodesie = $this->input->post('txtKodesie');
			$departemen = $this->input->post('txtDepartmentUser');
			$masakerja = $this->input->post('txtMasaKerja');
			$jenkel = $this->input->post('txtJenKel');
			$usia = $this->input->post('txtUsia');
			$suku = $this->input->post('txtSuku');
			$jabatan = $this->input->post('txtJabatanUser');
			$pendidikan = $this->input->post('txtPendidikanAkhir');
			$id_periode = $data['periode']['0']['id_periode'];

			$cek = $this->M_questioner->checkDemografi($noind,$id_periode);
			$arrInsert = array(
				'noind'					=> $noind,
				'nama'					=> $nama,
				'kodesie'				=> $kodesie,
				'masa_kerja'			=> $masakerja,
				'jk'					=> $jenkel,
				'usia'					=> $usia,
				'suku'					=> $suku,
				'status_kerja'			=> $jabatan,
				'pendidikan_terakhir'	=> $pendidikan,
				'id_periode' 			=> $id_periode,
				'created_date'			=> date('Y-m-d H:i:s')
			);
			if ($cek > 0) {
				$this->M_questioner->updateDemografi($arrInsert,$noind,$id_periode);
			}else{
				$this->M_questioner->insertDemografi($arrInsert);
			}
			
			$arrayKelompok = $this->M_questioner->getKelompokNext('0');
			$encrypted_id_kelompok = $this->encrypt->encode($arrayKelompok['0']['id_kelompok']);
            $encrypted_id_kelompok = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_id_kelompok);
			
			redirect(site_url('PNBP/Questioner/Quest/'.$encrypted_id_kelompok));
		}
		
	}

	public function Quest($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		// echo $plaintext_string;exit();
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title'] = 'Questioner';
		$data['Menu'] = 'Questioner';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		if (isset($_POST) and !empty($_POST)) {
			foreach ($_POST['question'] as $key) {
				$key['noind'] = $user;
				$pilihanNilai = explode(" - ", $key['pilihan']);
				$key['pilihan'] = $pilihanNilai['0'];
				$key['nilai'] = $pilihanNilai['1'];
				$key['created_date'] = date('Y-m-d H:i:s');
				$cek = $this->M_questioner->getHasil($key['id_pernyataan'],$key['id_periode'],$user);
				if ($cek > 0) {
					$this->M_questioner->updateHasil($key,$key['id_pernyataan'],$key['id_periode'],$user);
				}else{
					$this->M_questioner->insertHasil($key);
				}
			}
		}

		if ($plaintext_string !== "selesai") {
			$kelompok_aktif = "";
			$id_kelompok_next = "";
			$kelompokNext = $this->M_questioner->getKelompokNext($plaintext_string);
			$kelompokAktif = $this->M_questioner->getKelompokAktif($plaintext_string);
			if (isset($kelompokNext) and !empty($kelompokNext)) {
				foreach ($kelompokNext as $key) {
					$id_kelompok_next = $key['id_kelompok'];
				}
			}else{
				$id_kelompok_next = "selesai";
			}

			foreach ($kelompokAktif as $key) {
				$kelompok_aktif = $key['kelompok'];
			}

			$data['kelompok'] = $kelompok_aktif;
			$data['id_kelompok'] = $id_kelompok_next;
			$data['question'] = $this->M_questioner->getQuestioner($plaintext_string);

			
		}else{
			$data['selesai'] = 'selesai';
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PNBPAdministrator/Questioner/V_quest.php',$data);
		$this->load->view('V_Footer',$data);	
			
	}

	public function Save(){
		$noind = $this->session->user;
		$hasil = $this->M_questioner->getHasilSementara($noind);
		$this->M_questioner->updateDemografiStatusIsi($noind);
		foreach ($hasil as $key) {
			$cek = $this->M_questioner->getPerbandinganHasil($key['noind'],$key['id_pernyataan'],$key['id_periode']);
			if ($cek == 0) {
				$this->M_questioner->saveHasil($key);
			}
		}
		
		$user_id = $this->session->userid;
		$data['Title'] = 'Questioner';
		$data['Menu'] = 'Questioner';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PNBPAdministrator/Questioner/V_quest.php',$data);
		$this->load->view('V_Footer',$data);
	}
}

?>