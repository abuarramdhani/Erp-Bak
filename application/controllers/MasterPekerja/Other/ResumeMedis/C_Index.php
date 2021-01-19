<?php defined('BASEPATH') or die('No direct script access allowed');

class C_Index extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->library('Log_Activity');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('General');

		$this->load->model('M_Index');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPekerja/Other/ResumeMedis/M_resume_medis');

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if (!$this->session->is_logged) redirect('');
	}

	/* LIST DATA */
	public function index()
	{
		$this->checkSession();
		$user = $this->session->username;

		$user_id = $this->session->userid;


		$data['Title'] = 'Resume Medis';
		$data['Menu'] = 'Lain-lain';
		$data['SubMenuOne'] = 'Resume Medis';
		$data['SubMenuTwo'] = 'Data Resume Medis';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['data'] = $this->M_resume_medis->getDataResumeMedis();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('MasterPekerja/Other/ResumeMedis/V_Index', $data);
		$this->load->view('V_Footer', $data);
	}

	public function addResumeMedis()
	{
		$this->checkSession();
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Resume Medis';
		$data['Menu'] = 'Lain-lain';
		$data['SubMenuOne'] = 'Resume Medis';
		$data['SubMenuTwo'] = 'Data Resume Medis';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		// $data['data_perusahaan'] = $this->M_resume_medis->getDataPerusahaan();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('MasterPekerja/Other/ResumeMedis/V_AddData', $data);
		$this->load->view('V_Footer', $data);
	}

	public function dataPerusahaan()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Title'] = 'Pengaturan';
		$data['Menu'] = 'Lain-lain';
		$data['SubMenuOne'] = 'Resume Medis';
		$data['SubMenuTwo'] = 'Pengaturan';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['data_perusahaan'] = $this->M_resume_medis->getDataPerusahaan();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('MasterPekerja/Other/ResumeMedis/V_DataPerusahaan', $data);
		$this->load->view('V_Footer', $data);
	}

	public function addPerusahaan()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Pengaturan';
		$data['Menu'] = 'Lain-lain';
		$data['SubMenuOne'] = 'Resume Medis';
		$data['SubMenuTwo'] = 'Pengaturan';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$perusahaan = $this->M_resume_medis;
		$validation = $this->form_validation;
		$validation->set_rules($perusahaan->rulesPerusahaan());

		if ($validation->run()) {
			$nama 			=	$this->input->post('txt_namaPerusahaan', TRUE);
			$kode_mitra		=	$this->input->post('txt_kodeMitraPerusahaan', TRUE);
			$alamat 		=	 $this->input->post('txt_alamatPerusahaan', TRUE);
			$desa 			=	 $this->input->post('txt_desaPerusahaan', TRUE);
			$kecamatan 		=	 $this->input->post('txt_kecamatanPerusahaan', TRUE);
			$kota 			=	 $this->input->post('txt_kotaPerusahaan', TRUE);
			$no_telp 		=	$this->input->post('txt_noTelpPerusahaan', TRUE);
			$kontak_personil =	$this->input->post('txt_namaKontakPersonilPerusahaan', TRUE);
			$keterangan		= 	$this->input->post('txt_keteranganPerusahaan', TRUE);

			$insert_perusahaan 		=	array(
				'nama_perusahaan'	=>	strtoupper($nama),
				'kode_mitra'		=>	$kode_mitra,
				'alamat'			=>	$alamat,
				'desa'				=>	$desa,
				'kecamatan'			=>	$kecamatan,
				'kota'				=>	$kota,
				'no_telp'			=>	$no_telp,
				'contact_person'	=>	strtoupper($kontak_personil),
				'keterangan'		=>	strtoupper($keterangan),
				'create_timestamp'	=>	date('Y-m-d H:i:s'),
				'create_user'		=>	$this->session->user,
			);

			$id_perusahaan 			=	$this->M_resume_medis->savePerusahaan($insert_perusahaan);
			//insert to t_log
			$aksi = 'MASTER PEKERJA';
			$detail = 'Add Setting Kecelakaan Kerja ID=' . $id_perusahaan;
			$this->log_activity->activity_log($aksi, $detail);
			//
			$history 				=	array(
				'id_perusahaan'		=>	$id_perusahaan,
				'nama_perusahaan'	=>	strtoupper($nama),
				'kode_mitra'		=>	$kode_mitra,
				'alamat'			=>	$alamat,
				'desa'				=>	$desa,
				'kecamatan'			=>	$kecamatan,
				'kota'				=>	$kota,
				'no_telp'			=>	$no_telp,
				'contact_person'	=>	strtoupper($kontak_personil),
				'keterangan'		=>	strtoupper($keterangan),
				'create_timestamp'	=>	date('Y-m-d H:i:s'),
				'create_user'		=>	$this->session->user,
				'history_type'		=>	'CREATE',
			);
			$this->M_resume_medis->kk_perusahaan_history($history);

			redirect('MasterPekerja/SettingResumeMedis');
		}

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('MasterPekerja/Other/ResumeMedis/V_AddPerusahaan');
		$this->load->view('V_Footer', $data);
	}

	public function editPerusahaan($id_perusahaan = null)
	{
		$id_dekrip_perusahaan = $this->general->dekripsi($id_perusahaan);

		$user_id = $this->session->userid;

		$data['Title'] = 'Resume Medis';
		$data['Menu'] = 'Lain-lain';
		$data['SubMenuOne'] = 'Pengaturan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		if (!isset($id_dekrip_perusahaan)) redirect("MasterPekerja/Other/ResumeMedis/V_DataPerusahaan");

		$perusahaan = $this->M_resume_medis;
		$validation = $this->form_validation;
		$validation->set_rules($perusahaan->rulesPerusahaan());

		if ($validation->run()) {
			$nama 			= strtoupper($this->input->post('txt_namaPerusahaan', TRUE));
			$kode_mitra		=	$this->input->post('txt_kodeMitraPerusahaan', TRUE);
			$alamat 		=	$this->input->post('txt_alamatPerusahaan', TRUE);
			$desa 			=	$this->input->post('txt_desaPerusahaan', TRUE);
			$kecamatan 		=	$this->input->post('txt_kecamatanPerusahaan', TRUE);
			$kota 			=	$this->input->post('txt_kotaPerusahaan', TRUE);
			$no_telp 		=	$this->input->post('txt_noTelpPerusahaan', TRUE);
			$kontak_personil =	$this->input->post('txt_namaKontakPersonilPerusahaan', TRUE);
			$keterangan		= 	$this->input->post('txt_keteranganPerusahaan', TRUE);

			$update_perusahaan 		=	array(
				'nama_perusahaan'	=>	strtoupper($nama),
				'kode_mitra'		=>	$kode_mitra,
				'alamat'			=>	$alamat,
				'desa'				=>	$desa,
				'kecamatan'			=>	$kecamatan,
				'kota'				=>	$kota,
				'no_telp'			=>	$no_telp,
				'contact_person'	=>	strtoupper($kontak_personil),
				'keterangan'		=>	strtoupper($keterangan),
				'last_update_timestamp'	=>	date('Y-m-d H:i:s'),
				'last_update_user'		=>	$this->session->user,
			);
			$this->M_resume_medis->updatePerusahaan($update_perusahaan, $id_dekrip_perusahaan);

			//insert to t_logz
			$aksi = 'MASTER PEKERJA';
			$detail = 'Update Setting Perusahaan ID=' . $id_dekrip_perusahaan;
			$this->log_activity->activity_log($aksi, $detail);
			//
			$history 				=	array(
				'id_perusahaan'		=>	$id_dekrip_perusahaan,
				'nama_perusahaan'	=>	strtoupper($nama),
				'kode_mitra'		=>	$kode_mitra,
				'alamat'			=>	$alamat,
				'desa'				=>	$desa,
				'kecamatan'			=>	$kecamatan,
				'kota'				=>	$kota,
				'no_telp'			=>	$no_telp,
				'contact_person'	=>	strtoupper($kontak_personil),
				'keterangan'		=>	strtoupper($keterangan),
				'update_timestamp'	=>	date('Y-m-d H:i:s'),
				'update_user'		=>	$this->session->user,
				'history_type'		=>	'UPDATE',
			);

			$this->M_resume_medis->kk_perusahaan_history($history);

			$this->session->set_flashdata('success', 'Berhasil disimpan');
			redirect('MasterPekerja/SettingResumeMedis');
		}

		$data["edit_perusahaan"] = $perusahaan->getDataPerusahaanById($id_dekrip_perusahaan);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view("MasterPekerja/Other/ResumeMedis/V_EditPerusahaan", $data);
		$this->load->view('V_Footer', $data);
	}

	public function deletePerusahaan($id_perusahaan = null)
	{
		$id_dekrip_perusahaan = $this->general->dekripsi($id_perusahaan);

		if (!isset($id_dekrip_perusahaan)) show_404();
		if ($this->M_resume_medis->deletePerusahaan($id_dekrip_perusahaan)) {
			redirect(base_url("MasterPekerja/SettingResumeMedis"));
		}
	}

	public function deleteResumeMedis($id_rm = null)
	{
		$id_dekrip_rm = $this->general->dekripsi($id_rm);
		$getNoind = $this->M_resume_medis->getNoindResMedisById($id_dekrip_rm);
		$noind = $getNoind[0]['noind'];

		if (!isset($id_dekrip_rm)) show_404();
		if ($this->M_resume_medis->deleteResumeMedis($id_dekrip_rm)) {
			$logInsert = array(
				'wkt' => 	date('Y-m-d H:i:s'),
				'menu' => 'ERP->MasterPekerja->LainLain->ResumeMedis',
				'ket' => "Delete Resume Medis->$noind",
				'noind' => $this->session->user,
				'jenis' => 'Delete->RESUME MEDIS',
				'program' => 'RESUME MEDIS',
				'noind_baru' => null
			);

			$this->M_resume_medis->insertTlog($logInsert);
			redirect(base_url("MasterPekerja/ResumeMedis"));
		}
	}

	public function data_pekerja()
	{
		$id = strtoupper($this->input->get('term'));
		$data = $this->M_resume_medis->getDataPekerjaByid($id);

		echo json_encode($data);
	}

	public function data_perusahaan()
	{
		$a = $this->input->get('q');
		$data = $this->M_resume_medis->getPerusahaan($a);

		echo json_encode($data);
	}

	public function inputResumeMedis()
	{
		$user_id = $this->session->userid;

		$noind = $this->input->post('slcPekerja', TRUE);
		$kode_mitra = $this->input->post('slcCabang', TRUE);
		$tgl_laka = $this->input->post('datepicker_laka', TRUE);
		$tgl_periksa = $this->input->post('datepicker_periksa', TRUE);

		$dataPribadi = $this->M_resume_medis->getDataPekerjaRow($noind);
		$no_peserta = $this->M_resume_medis->getNoPeserta($noind);

		$nama = $dataPribadi[0]['nama'];
		$jenkel = $dataPribadi[0]['jenkel'];
		$templahir = $dataPribadi[0]['templahir'];
		$tgllahir = $dataPribadi[0]['tgllahir'];
		$alamat = $dataPribadi[0]['alamat'];
		$desa = $dataPribadi[0]['desa'];
		$kec = $dataPribadi[0]['kec'];
		$kab = $dataPribadi[0]['kab'];
		$prop = $dataPribadi[0]['prop'];
		$kodepos = $dataPribadi[0]['kodepos'];
		$nohp = $dataPribadi[0]['nohp'];
		$kodesie = $dataPribadi[0]['kodesie'];
		$kd_jabatan = $dataPribadi[0]['kd_jabatan'];
		$jabatan = $dataPribadi[0]['jabatan'];
		$seksi = $dataPribadi[0]['seksi'];
		$no_peserta = $no_peserta[0]['no_peserta'];

		$dataResumeMedis = array(
			'noind' => $noind,
			'nama' => $nama,
			'jenkel' => $jenkel,
			'templahir' => $templahir,
			'tgllahir' => $tgllahir,
			'alamat' => $alamat,
			'desa' => $desa,
			'kec' => $kec,
			'kab' => $kab,
			'prop' => $prop,
			'kodepos' => $kodepos,
			'nohp' => $nohp,
			'kodesie' => $kodesie,
			'seksi' => $seksi,
			'kd_jabatan' => $kd_jabatan,
			'jabatan' => $jabatan,
			'no_peserta' => $no_peserta,
			'tgl_laka' => $tgl_laka,
			'tgl_periksa' => $tgl_periksa,
			'create_timestamp' => date('Y-m-d H:i:s'),
			'create_user' => $this->session->user,
			'kd_mitra' => $kode_mitra
		);


		$this->M_resume_medis->saveDataResumeMedis($dataResumeMedis);

		$logInsert = array(
			'wkt' => 	date('Y-m-d H:i:s'),
			'menu' => 'ERP->MasterPekerja->LainLain->ResumeMedis',
			'ket' => "Insert Resume Medis->$noind",
			'noind' => $this->session->user,
			'jenis' => 'Insert->RESUME MEDIS',
			'program' => 'RESUME MEDIS',
			'noind_baru' => null
		);

		$this->M_resume_medis->insertTlog($logInsert);

		redirect('MasterPekerja/ResumeMedis');
	}

	public function editResumeMedis($id_rm)
	{
		$id_dekrip_rm = $this->general->dekripsi($id_rm);

		$user_id = $this->session->userid;

		$data['Title'] = 'Resume Medis';
		$data['Menu'] = 'Lain-lain';
		$data['SubMenuOne'] = 'Resume Medis';
		$data['SubMenuTwo'] = 'Data Resume Medis';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$resMed = $this->M_resume_medis->getDataResumeMedisById($id_dekrip_rm);
		$kdMitra = $resMed[0]['kd_mitra'];

		$data['data_resumeMedis'] = $resMed;
		$data["data_perusahaan"] = $this->M_resume_medis->getPerusaanByid($kdMitra);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view("MasterPekerja/Other/ResumeMedis/V_EditData", $data);
		$this->load->view('V_Footer', $data);
	}

	public function updateResumeMedis($id)
	{
		$id_dekrip = $this->general->dekripsi($id);

		$user_id = $this->session->userid;

		$noind = $this->input->post('slcPekerja', TRUE);
		$kode_mitra = $this->input->post('slcCabang', TRUE);
		$tgl_laka = $this->input->post('datepicker_laka', TRUE);
		$tgl_periksa = $this->input->post('datepicker_periksa', TRUE);

		$dataPribadi = $this->M_resume_medis->getDataPekerjaRow($noind);
		$no_peserta = $this->M_resume_medis->getNoPeserta($noind);

		$nama = $dataPribadi[0]['nama'];
		$jenkel = $dataPribadi[0]['jenkel'];
		$templahir = $dataPribadi[0]['templahir'];
		$tgllahir = $dataPribadi[0]['tgllahir'];
		$alamat = $dataPribadi[0]['alamat'];
		$desa = $dataPribadi[0]['desa'];
		$kec = $dataPribadi[0]['kec'];
		$kab = $dataPribadi[0]['kab'];
		$prop = $dataPribadi[0]['prop'];
		$kodepos = $dataPribadi[0]['kodepos'];
		$nohp = $dataPribadi[0]['nohp'];
		$kodesie = $dataPribadi[0]['kodesie'];
		$kd_jabatan = $dataPribadi[0]['kd_jabatan'];
		$jabatan = $dataPribadi[0]['jabatan'];
		$seksi = $dataPribadi[0]['seksi'];
		$no_peserta = $no_peserta[0]['no_peserta'];

		$dataResumeMedis = array(
			'noind' => $noind,
			'nama' => $nama,
			'jenkel' => $jenkel,
			'templahir' => $templahir,
			'tgllahir' => $tgllahir,
			'alamat' => $alamat,
			'desa' => $desa,
			'kec' => $kec,
			'kab' => $kab,
			'prop' => $prop,
			'kodepos' => $kodepos,
			'nohp' => $nohp,
			'kodesie' => $kodesie,
			'seksi' => $seksi,
			'kd_jabatan' => $kd_jabatan,
			'jabatan' => $jabatan,
			'no_peserta' => $no_peserta,
			'tgl_laka' => $tgl_laka,
			'tgl_periksa' => $tgl_periksa,
			'last_update_timestamp' => date('Y-m-d H:i:s'),
			'last_update_user' => $this->session->user,
			'kd_mitra' => $kode_mitra
		);


		$this->M_resume_medis->updateDataResumeMedis($id_dekrip, $dataResumeMedis);

		$logInsert = array(
			'wkt' => 	date('Y-m-d H:i:s'),
			'menu' => 'ERP->MasterPekerja->LainLain->ResumeMedis',
			'ket' => "Update Resume Medis->$noind",
			'noind' => $this->session->user,
			'jenis' => 'Update->RESUME MEDIS',
			'program' => 'RESUME MEDIS',
			'noind_baru' => null
		);

		$this->M_resume_medis->insertTlog($logInsert);

		redirect('MasterPekerja/ResumeMedis');
	}


	public function cetakResumeMedis($id)
	{
		$id_dekripsi = $this->general->dekripsi($id);

		$data = $this->M_resume_medis->cetakResumeMedis($id_dekripsi);
		$noind = $data[0]['noind'];
		$lahir = $data[0]['tgllahir'];
		$bulanLahir = $this->M_resume_medis->tgl_indo1($lahir);

		$logInsert = array(
			'wkt' => 	date('Y-m-d H:i:s'),
			'menu' => 'ERP->MasterPekerja->LainLain->ResumeMedis',
			'ket' => "Cetak Resume Medis->$noind",
			'noind' => $this->session->user,
			'jenis' => 'Cetak->RESUME MEDIS',
			'program' => 'RESUME MEDIS',
			'noind_baru' => null
		);

		$this->M_resume_medis->insertTlog($logInsert);

		$this->load->library('pdf');

		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf8', "A4", 11, '', 10, 10, 10, 10, 0, 0);
		$filename = $noind . ' - Resume_Medis.pdf';

		$html = $this->load->view('MasterPekerja/Other/ResumeMedis/V_CetakResumeMedis', [
			'data' => $data,
			'lahir' => $bulanLahir
		], true);

		$pdf->WriteHTML($html);
		$pdf->text_input_as_HTML = true;
		$pdf->SetHTMLHeader($filename);
		$pdf->setTitle($filename);
		$pdf->Output($filename, 'D');
	}
}
