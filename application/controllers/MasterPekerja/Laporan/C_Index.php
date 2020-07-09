<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Index extends CI_Controller {


	public function __construct()
    {
        parent::__construct();

		$this->load->library('Log_Activity');
        $this->load->library('General');

        $this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPekerja/Laporan/M_kecelakaan');

		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->load->helper('terbilang_helper');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		date_default_timezone_set('Asia/Jakarta');
		$this->checkSession();
    }

	//HALAMAN INDEX
	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['dataRekap'] = $this->M_kecelakaan->tampilRecord();



		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Laporan/V_cobaRecord',$data);
		$this->load->view('V_Footer',$data);
	}


	public function checkSession()
	{
		if($this->session->is_logged){

		}else{
			redirect('');
		}
	}

	public function data_pekerja()
	{
		$pekerja = strtoupper($this->input->get('term'));
		$data = $this->M_kecelakaan->getPekerja($pekerja);

		echo json_encode($data);
	}

	public function data_perusahaan()
	{
		$a = $this->input->get('q');
		$data = $this->M_kecelakaan->getPerusahaan($a);

		echo json_encode($data);
	}

	public function inputPerusahaan()
	{

		$user_id = $this->session->userid;

		$this->form_validation->set_rules('txt_namaPerusahaan', 'Nama Perusahaan', 'required');
		$this->form_validation->set_rules('txt_kodeMitraPerusahaan', 'Kode Mitra Perusahaan', 'required');
		$this->form_validation->set_rules('txt_alamatPerusahaan', 'Alamat Perusahaan', 'required');
		$this->form_validation->set_rules('txt_desaPerusahaan', 'Desa Perusahaan', 'required');
		$this->form_validation->set_rules('txt_kecamatanPerusahaan', 'Kecamatan Perusahaan', 'required');
		$this->form_validation->set_rules('txt_kotaPerusahaan', 'Kota Perusahaan', 'required');
		$this->form_validation->set_rules('txt_noTelpPerusahaan', 'No Telp Perusahaan', 'required');
		$this->form_validation->set_rules('txt_namaKontakPersonilPerusahaan', 'Nama Kontak Personil Perusahaan', 'required');

		if ( $this->form_validation->run() === FALSE )
		{
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['SubMenuTwo'] = '';

			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MasterPekerja/Laporan/V_TambahPerusahaan',$data);
			$this->load->view('V_Footer',$data);
		}
		else
		{
			$nama 			=	$this->input->post('txt_namaPerusahaan', TRUE);
			$kode_mitra		=	$this->input->post('txt_kodeMitraPerusahaan', TRUE);
			$alamat 		=	strtoupper($this->input->post('txt_alamatPerusahaan', TRUE));
			$desa 			=	strtoupper($this->input->post('txt_desaPerusahaan', TRUE));
			$kecamatan 		=	strtoupper($this->input->post('txt_kecamatanPerusahaan', TRUE));
			$kota 			=	strtoupper($this->input->post('txt_kotaPerusahaan', TRUE));
			$no_telp 		=	$this->input->post('txt_noTelpPerusahaan', TRUE);
			$kontak_personil=	$this->input->post('txt_namaKontakPersonilPerusahaan', TRUE);
			$keterangan		= 	$this->input->post('txt_keteranganPerusahaan', TRUE);

			$insert_perusahaan 		=	array
										(
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

			$id_perusahaan 			=	$this->M_kecelakaan->insert_perusahaan($insert_perusahaan);
			//insert to t_log
			$aksi = 'MASTER PEKERJA';
			$detail = 'Add Setting Kecelakaan Kerja ID='.$id_perusahaan;
			$this->log_activity->activity_log($aksi, $detail);
			//
			$history 				=	array
										(
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
			$this->M_kecelakaan->kk_perusahaan_history($history);

			redirect('MasterPekerja/SettingKecelakaanKerja');
		}
	}

	public function editPerusahaan($id_perusahaan)
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$id_perusahaan_decode 	=	$this->general->dekripsi($id_perusahaan);
		$data['edit'] = $this->M_kecelakaan->infoPerusahaan($id_perusahaan_decode);


		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Laporan/V_EditPerusahaan',$data);
		$this->load->view('V_Footer',$data);
	}
	public function updatePerusahaan($id)
	{
		$user_id = $this->session->userid;

			$nama 			=	$this->input->post('txt_namaPerusahaan', TRUE);
			$kode_mitra		=	$this->input->post('txt_kodeMitraPerusahaan', TRUE);
			$alamat 		=	strtoupper($this->input->post('txt_alamatPerusahaan', TRUE));
			$desa 			=	strtoupper($this->input->post('txt_desaPerusahaan', TRUE));
			$kecamatan 		=	strtoupper($this->input->post('txt_kecamatanPerusahaan', TRUE));
			$kota 			=	strtoupper($this->input->post('txt_kotaPerusahaan', TRUE));
			$no_telp 		=	$this->input->post('txt_noTelpPerusahaan', TRUE);
			$kontak_personil=	$this->input->post('txt_namaKontakPersonilPerusahaan', TRUE);
			$keterangan		= 	$this->input->post('txt_keteranganPerusahaan', TRUE);

			$update_perusahaan 		=	array
										(
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
			// $this->M_kecelakaan->update_perusahaan($update_perusahaan,$id);
			$id_perusahaan 			=	$this->M_kecelakaan->update_perusahaan($update_perusahaan,$id);
			//insert to t_log
			$aksi = 'MASTER PEKERJA';
			$detail = 'Update Setting Perusahaan ID='.$id_perusahaan;
			$this->log_activity->activity_log($aksi, $detail);
			//
			$history 				=	array
										(
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
											'update_timestamp'	=>	date('Y-m-d H:i:s'),
											'update_user'		=>	$this->session->user,
											'history_type'		=>	'UPDATE',
										);
			$this->M_kecelakaan->kk_perusahaan_history($history);

			redirect('MasterPekerja/SettingKecelakaanKerja');
	}

	public function dataPerusahaan()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data_Perusahan'] = $this->M_kecelakaan->tampilPerusahaan();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Laporan/V_DataPerusahaan',$data);
		$this->load->view('V_Footer',$data);
	}

	public function deletePerusahaan($id)
	{
		$id_a = $this->general->dekripsi($id);
		$delete 	=	$this->M_kecelakaan->tampilPerusahaan($id_a);
		foreach ($delete as $del)
		{
			$delete_data 	=	array
								(
									'id_perusahaan'		=>	$id_a,
									'nama_perusahaan'	=>	strtoupper($this->input->post('txt_namaPerusahaan', TRUE)),
									'kode_mitra'		=>	$this->input->post('txt_kodeMitraPerusahaan', TRUE),
									'alamat'			=>	$this->input->post('txt_alamatPerusahaan', TRUE),
									'desa'				=>	$this->input->post('txt_desaPerusahaan', TRUE),
									'kecamatan'			=>	$this->input->post('txt_kecamatanPerusahaan', TRUE),
									'kota'				=>	$this->input->post('txt_kotaPerusahaan', TRUE),
									'no_telp'			=>	$this->input->post('txt_noTelpPerusahaan', TRUE),
									'contact_person'	=>	strtoupper($this->input->post('txt_namaKontakPersonilPerusahaan', TRUE)),
									'keterangan'		=>	strtoupper($this->input->post('txt_keteranganPerusahaan', TRUE)),
									'delete_timestamp'	=>	date('Y-m-d H:i:s'),
									'delete_user'		=>	$this->session->user,
									'history_type'		=>	'DELETE',
								);
			$this->M_kecelakaan->kk_perusahaan_history($delete_data);
		}
		$this->M_kecelakaan->deletePerusahaan($id_a);
		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Delete Setting Kecelakaan Kerja ID'.$id_a;
		$this->log_activity->activity_log($aksi, $detail);
		//
		redirect('MasterPekerja/SettingKecelakaanKerja');//ini redirect ke halaman apa, misal kayak gitu
	}

	public function simpanFaskes()
	{
		$namafaskes			= 	$this->input->post('it_namafaskes', TRUE);
		$jenisfaskes		= 	$this->input->post('rd_jenisFaskes', TRUE);
		$alamatfaskes		= 	strtoupper($this->input->post('it_alamatFaskes', TRUE));

		$data_faskes	= 	array(
									'nama' => $namafaskes,
									'jenis_faskes' => $jenisfaskes,
									'alamat' => $alamatfaskes,
							);
		$simpan_faskes = $this->M_kecelakaan->simpanfaskes($data_faskes);
		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Add Fasilitas Kesehatan Nama = '.$namafaskes;
		$this->log_activity->activity_log($aksi, $detail);
		//
	}

	public function input()
	{

		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data_kecelakaan = $this->M_kecelakaan->kk_kecelakaan_detail();
			$i = 1;
			foreach ($data_kecelakaan as $key => $value) {
				if ($value['id_kecelakaan'] == '1') {
					$desc_kecelakaan[1][] = $value;
				}elseif ($value['id_kecelakaan'] == '2') {
					$desc_kecelakaan[2][] = $value;
				}elseif ($value['id_kecelakaan'] == '3') {
					$desc_kecelakaan[3][] = $value;
				}else{
					$desc_kecelakaan[4][] = $value;
				}

			}
			$data['kk_kecelakaan_detail'] = $desc_kecelakaan;
			// echo "<pre>";
			// print_r($desc_kecelakaan);
			// exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Laporan/V_TambahData',$data);
		$this->load->view('V_Footer',$data);
	}

	public function inputTahap1()
	{
			$user_id = $this->session->userid;

			$namafaskes			= 	$this->input->post('it_namafaskes', TRUE);
			$jenisfaskes		= 	$this->input->post('rd_jenisFaskes', TRUE);
			$alamatfaskes		= 	strtoupper($this->input->post('it_alamatFaskes', TRUE));

			$datafaskes 		= 	$this->M_kecelakaan->ambilIdFaskes($namafaskes,$jenisfaskes,$alamatfaskes);
			if ($datafaskes != NULL ) {
				$id 	 		= 	$datafaskes[0]['id_faskes'];
				$id_faskes 		= 	$id;
			}else{
				$this->simpanfaskes();
				$datafaskesbaru	= 	$this->M_kecelakaan->ambilIdFaskes($namafaskes,$jenisfaskes,$alamatfaskes);
				$id_faskes 		=	$datafaskesbaru[0]['id_faskes'];
			}
			// echo $id_faskes;
			// exit();

			$noinduk			=	$this->input->post('cmbNoindukPekerja', TRUE);
			$dataPribadi 		= 	$this->M_kecelakaan->ambilDataPribadi($noinduk);
			$nama 				= 	$dataPribadi[0]['nama'];
			$kodesie			=	$dataPribadi[0]['kodesie'];
			$kodejabatan		=	$dataPribadi[0]['kd_jabatan'];
			$kodemitra 			=	$this->input->post('cmbCabangPerusahaan', TRUE);
			$upah 				=	$this->input->post('slc_upahDiterima', TRUE);
			$jmlupah			=	$this->input->post('it_jumlahUpah', TRUE);
			$tempatkecelakaan	=	$this->input->post('it_tempatKecelakaan', TRUE);
			$alamatkecelakaan	=	$this->input->post('it_alamatKecelakaan', TRUE);
			$desakecelakaan		= 	$this->input->post('it_alamatDesaKecelakaan', TRUE);
			$kecamatankecelakaa	= 	$this->input->post('it_alamatKecamatanKecelakaan', TRUE);
			$kotakecelakaan		= 	$this->input->post('it_alamatKotaKecelakaan', TRUE);
			$tglkecelakaan		=	$this->input->post('KecelakaanKerja-daterangepickersingledatewithtime', TRUE);
			$kejadian 			= 	$this->input->post('bagaimanaTerjadiKecelakaan', TRUE);
			$penyebab			= 	$this->input->post('sebutkanBagianMesin', TRUE);
			$akibat 			= 	$this->input->post('rd_akibat', TRUE);
			$akibatdetail		= 	$this->input->post('it_bagianTubuhLuka', TRUE);
			$keadaan 			=	$this->input->post('rd_keadaan',TRUE);
			$keteranganlain		= 	$this->input->post('txtarea_keteranganLain', TRUE);

			// echo "<pre>";
			// print_r($keteranganlain);
			// exit();

			$simpan_tahap_1		= array(
										'noind'				=> $noinduk,
										'nama'				=> $nama,
										'kodesie'			=> $kodesie,
										'kdjab'				=> $kodejabatan,
										'upah_status'		=> $upah,
										'upah_nominal'		=> $jmlupah,
										'lokasi_kk'			=> $tempatkecelakaan,
										'alamat_kk'			=> strtoupper($alamatkecelakaan),
										'desa'				=> strtoupper($desakecelakaan),
										'kecamatan'			=> strtoupper($kecamatankecelakaa),
										'kokab'				=> strtoupper($kotakecelakaan),
										'tgl_kk'			=> $tglkecelakaan,
										'kejadian'			=> $kejadian,
										'penyebab'			=> $penyebab,
										'akibat_diderita'	=> $akibat,
										'akibat_detail'		=> $akibatdetail,
										'id_faskes'			=> $id_faskes,
										'keadaan_penderita'	=> $keadaan,
										'keterangan_lain'	=> $keteranganlain,
										'create_timestamp'	=> date('Y-m-d H:i:s'),
										'create_user'		=> $this->session->user,
										// 'id_approval'		=> '',
										'kode_mitra'		=> $kodemitra,
									);

			$id_lkk1 = $this->M_kecelakaan->simpanLaporanTahap1($simpan_tahap_1);
			$history = array(
										'id_lkk_1'			=> $id_lkk1,
										'noind'				=> $noinduk,
										'nama'				=> $nama,
										'kodesie'			=> $kodesie,
										'kdjab'				=> $kodejabatan,
										'upah_status'		=> $upah,
										'upah_nominal'		=> $jmlupah,
										'lokasi_kk'			=> $tempatkecelakaan,
										'alamat_kk'			=> strtoupper($alamatkecelakaan),
										'desa'				=> strtoupper($desakecelakaan),
										'kecamatan'			=> strtoupper($kecamatankecelakaa),
										'kokab'				=> strtoupper($kotakecelakaan),
										'tgl_kk'			=> $tglkecelakaan,
										'kejadian'			=> $kejadian,
										'penyebab'			=> $penyebab,
										'akibat_diderita'	=> $akibat,
										'akibat_detail'		=> $akibatdetail,
										'id_faskes'			=> $id_faskes,
										'keadaan_penderita'	=> $keadaan,
										'keterangan_lain'	=> $keteranganlain,
										// 'id_approval'		=> '',
										'create_timestamp'	=> date('Y-m-d H:i:s'),
										'create_user'		=> $this->session->user,
										'history_type'		=> 'Create',
										'kode_mitra'		=> $kodemitra,
						);
			$this->M_kecelakaan->simpanHistoryTahap1($history);

			//insert to t_log
			$aksi = 'MASTER PEKERJA';
			$detail = 'Add Record Kecelakaan Kerja ID='.$id_lkk1;
			$this->log_activity->activity_log($aksi, $detail);
			//

			$desc1 = $this->input->post('desc1');
			$desc2 = $this->input->post('desc2');
			$desc3 = $this->input->post('desc3');
			$desc4 = $this->input->post('desc4');
			$count_desc1 = count($desc1);
			$count_desc2 = count($desc2);
			$count_desc3 = count($desc3);
			$count_desc4 = count($desc4);
			// echo "<pre>";
			for ($a=1; $a < 5; $a++) {
				$name = 'count_desc'.$a;
				for($i=0;$i<$$name;$i++){
					$name2 = 'desc'.$a;
					$var = $$name2;
					$arraySimpan = array(
											'id_laporan_tahap_1' => $id_lkk1,
											'id_kecelakaan' => $a,
											'id_kecelakaan_detail' =>  $var[$i],
											'create_timestamp' => date('Y-m-d H:i:s'),
											'create_user'	=> $this->session->user,
										);
					// print_r($arraySimpan);
					$simpan_desc = $this->M_kecelakaan->simpanDeskripsi($arraySimpan);
					$historyKec 	= array(
									'id_laporan_kecelakaan' => $simpan_desc,
									'id_laporan_tahap_1' 	=> $id_lkk1,
									'id_kecelakaan' 		=> $a,
									'id_kecelakaan_detail' 	=> $var[$i],
									'create_timestamp' 		=> date('Y-m-d H:i:s'),
									'create_user' 			=> $this->session->user,
									'history_type'			=> 'CREATE',
								);
					$this->M_kecelakaan->historyKecelakaanDetail($historyKec);
				}
			}
			redirect('MasterPekerja/KecelakaanKerja');
	}

	public function editTahap1($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		//view edit tahap 1
		$data['data1']	= $this->M_kecelakaan->getLKK1($id);
		$data_kecelakaan = $this->M_kecelakaan->kk_kecelakaan_detail();
			$i = 1;
			foreach ($data_kecelakaan as $key => $value) {
				if ($value['id_kecelakaan'] == '1') {
					$desc_kecelakaan[1][] = $value;
				}elseif ($value['id_kecelakaan'] == '2') {
					$desc_kecelakaan[2][] = $value;
				}elseif ($value['id_kecelakaan'] == '3') {
					$desc_kecelakaan[3][] = $value;
				}else{
					$desc_kecelakaan[4][] = $value;
				}

			}
		$data['kk_kecelakaan_detail'] = $desc_kecelakaan;
		$idfaskes = $data['data1'][0]['id_faskes'];
		$data['faskes'] = $this->M_kecelakaan->faskesAll($idfaskes);
		$data['kec'] 	= $this->M_kecelakaan->kk_kecelakaan_detail_view($id);
		// echo "<pre>";
		// print_r($data['kec']);
		// exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Laporan/V_EditTahap1',$data);
		$this->load->view('V_Footer',$data);
	}

	public function updateTahap1($id)
	{
		$user_id = $this->session->userid;

		$namafaskes			= 	$this->input->post('it_namafaskes', TRUE);
		$jenisfaskes		= 	$this->input->post('rd_jenisFaskes', TRUE);
		$alamatfaskes		= 	strtoupper($this->input->post('it_alamatFaskes', TRUE));

		$datafaskes 		= 	$this->M_kecelakaan->ambilIdFaskes($namafaskes,$jenisfaskes,$alamatfaskes);
		if ($datafaskes != NULL ) {
			$idfas 	 		= 	$datafaskes[0]['id_faskes'];
			$id_faskes 		= 	$idfas;
		}else{
			$this->simpanfaskes();
			$datafaskesbaru	= 	$this->M_kecelakaan->ambilIdFaskes($namafaskes,$jenisfaskes,$alamatfaskes);
			$id_faskes 		=	$datafaskesbaru[0]['id_faskes'];
		}

		$noinduk			=	$this->input->post('kk-it_pekerja', TRUE);
		$dataPribadi 		= 	$this->M_kecelakaan->ambilDataPribadi($noinduk);
		$nama 				= 	$dataPribadi[0]['nama'];
		$kodesie			=	$dataPribadi[0]['kodesie'];
		$kodejabatan		=	$dataPribadi[0]['kd_jabatan'];
		$kodemitra 			=	$this->input->post('itCabangPerusahaan', TRUE);
		$upah 				=	$this->input->post('slc_upahDiterima', TRUE);
		$jmlupah			=	$this->input->post('it_jumlahUpah', TRUE);
		$tempatkecelakaan	=	$this->input->post('it_tempatKecelakaan', TRUE);
		$alamatkecelakaan	=	$this->input->post('it_alamatKecelakaan', TRUE);
		$desakecelakaan		= 	$this->input->post('it_alamatDesaKecelakaan', TRUE);
		$kecamatankecelakaa	= 	$this->input->post('it_alamatKecamatanKecelakaan', TRUE);
		$kotakecelakaan		= 	$this->input->post('it_alamatKotaKecelakaan', TRUE);
		$tglkecelakaan		=	$this->input->post('KecelakaanKerja-daterangepickersingledatewithtime', TRUE);
		$kejadian 			= 	$this->input->post('bagaimanaTerjadiKecelakaan', TRUE);
		$penyebab			= 	$this->input->post('sebutkanBagianMesin', TRUE);
		$akibat 			= 	$this->input->post('rd_akibat', TRUE);
		$akibatdetail		= 	$this->input->post('it_bagianTubuhLuka', TRUE);
		$keadaan 			=	$this->input->post('rd_keadaan',TRUE);
		$keteranganlain		= 	$this->input->post('txtarea_keteranganLain', TRUE);

		$updateThp1 	= array(
								'upah_status' 		=> $upah,
								'upah_nominal' 		=> $jmlupah,
								'lokasi_kk' 		=> $tempatkecelakaan,
								'alamat_kk' 		=> strtoupper($alamatkecelakaan),
								'desa' 				=> strtoupper($desakecelakaan),
								'kecamatan' 		=> strtoupper($kecamatankecelakaa),
								'kokab' 			=> strtoupper($kotakecelakaan),
								'tgl_kk' 			=> $tglkecelakaan,
								'kejadian' 			=> $kejadian,
								'penyebab' 			=> $penyebab,
								'akibat_diderita' 	=> $akibat,
								'akibat_detail' 	=> $akibatdetail,
								'id_faskes' 		=> $id_faskes,
								'keadaan_penderita' => $keadaan,
								'keterangan_lain' 	=> $keteranganlain,
								'last_update_timestamp' => date('Y-m-d H:i:s'),
								'last_update_user' 	=> $this->session->user,
							);
		$this->M_kecelakaan->updateTahap1($id,$updateThp1);//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Update Tahap 1 Kecelakaan Kerja ID='.$id;
		$this->log_activity->activity_log($aksi, $detail);
		//
		$history   		= array(
								'id_lkk_1'			=> $id,
								'noind'				=> $noinduk,
								'nama'				=> $nama,
								'kodesie'			=> $kodesie,
								'kdjab'				=> $kodejabatan,
								'upah_status'		=> $upah,
								'upah_nominal'		=> $jmlupah,
								'lokasi_kk'			=> $tempatkecelakaan,
								'alamat_kk'			=> strtoupper($alamatkecelakaan),
								'desa'				=> strtoupper($desakecelakaan),
								'kecamatan'			=> strtoupper($kecamatankecelakaa),
								'kokab'				=> strtoupper($kotakecelakaan),
								'tgl_kk'			=> $tglkecelakaan,
								'kejadian'			=> $kejadian,
								'penyebab'			=> $penyebab,
								'akibat_diderita'	=> $akibat,
								'akibat_detail'		=> $akibatdetail,
								'id_faskes'			=> $id_faskes,
								'keadaan_penderita'	=> $keadaan,
								'keterangan_lain'	=> $keteranganlain,
								// 'id_approval'		=> '',
								'update_timestamp'	=> date('Y-m-d H:i:s'),
								'update_user'		=> $this->session->user,
								'history_type'		=> 'UPDATE',
								'kode_mitra'		=> $kodemitra,
							);
		$this->M_kecelakaan->simpanHistoryTahap1($history);


		$this->M_kecelakaan->deleteKecelakaanDetailLama($id);
		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Delete Kecelakaan Kerja ID='.$id;
		$this->log_activity->activity_log($aksi, $detail);
		//

		$desc1 = $this->input->post('desc1');
		$desc2 = $this->input->post('desc2');
		$desc3 = $this->input->post('desc3');
		$desc4 = $this->input->post('desc4');
		$count_desc1 = count($desc1);
		$count_desc2 = count($desc2);
		$count_desc3 = count($desc3);
		$count_desc4 = count($desc4);
		// echo "<pre>";
		for ($a=1; $a < 5; $a++) {
			$name = 'count_desc'.$a;
			for($i=0;$i<$$name;$i++){
				$name2 = 'desc'.$a;
				$var = $$name2;
				$arraySimpan = array(
									'id_laporan_tahap_1' 	=> $id,
									'id_kecelakaan' 		=> $a,
									'id_kecelakaan_detail' 	=> $var[$i],
									'create_timestamp' 		=> date('Y-m-d H:i:s'),
									'create_user' 			=> $this->session->user,
									);
				// print_r($arraySimpan);
				$simpan_desc = $this->M_kecelakaan->simpanDeskripsi($arraySimpan);
				$historyKec 	= array(
									'id_laporan_kecelakaan' => $simpan_desc,
									'id_laporan_tahap_1' 	=> $id,
									'id_kecelakaan' 		=> $a,
									'id_kecelakaan_detail' 	=> $var[$i],
									'update_timestamp' 		=> date('Y-m-d H:i:s'),
									'update_user' 			=> $this->session->user,
									'history_type'			=> 'UPDATE',
								);
				$this->M_kecelakaan->historyKecelakaanDetail($historyKec);
			}
		}

		redirect('MasterPekerja/KecelakaanKerja');
	}

	public function printKecelakaan($id)
	{

		// $data['id'] = $id;

		$this->load->library('pdf');
		$dataLKK1 			= 	$this->M_kecelakaan->getLKK1($id);
		$noind 				= 	$dataLKK1[0]['noind'];
		$nomor 				= 	$this->M_kecelakaan->getNomorBPJS($noind);
		$kode_mitra			= 	$dataLKK1[0]['kode_mitra'];
		$id_tempat 			= 	$dataLKK1[0]['lokasi_kk'];
		$id_faskes			= 	$dataLKK1[0]['id_faskes'];
		$id_upah 			= 	$dataLKK1[0]['upah_status'];
		$upah 				= 	$this->M_kecelakaan->upahKet($id_upah);
		$faskes 			=	$this->M_kecelakaan->faskesAll($id_faskes);
		$tempat_kecelakaan 	= 	$this->M_kecelakaan->tempatKecelakaan($id_tempat);
		$dataPerusahaan		= 	$this->M_kecelakaan->getPerusahaanByKode($kode_mitra);
		$dataPribadi 		= 	$this->M_kecelakaan->ambilDataPribadi($noind);
		$kodesie			=	$dataPribadi[0]['kodesie'];
		$unit 				=	$this->M_kecelakaan->unitPekerja($kodesie);

		for ($i=1; $i < 5; $i++) {
			$laporankec 	= 	$this->M_kecelakaan->ambilLaporanKecelakaan($id,$i);
			if ($i == 1) {
				$kece1 = $laporankec;

			}
			if ($i == 2) {
				$kece2 = $laporankec;
				$jml2  = count($kece2);
				for ($p=0; $p < $jml2; $p++) {
					$idkece2 = $kece2[$p]['id_kecelakaan_detail'];
					// echo $idkece2;
				}
			}
			if ($i == 3) {
				$kece3 = $laporankec;
				$jml3  = count($kece3);
				for ($p=0; $p < $jml3; $p++) {
					$idkece3 = $kece3[$p]['id_kecelakaan_detail'];
					// echo $idkece3;
				}
			}
			if ($i == 4) {
				$kece4 = $laporankec;
				$jml4  = count($kece4);
				for ($p=0; $p < $jml4; $p++) {
					$idkece4 = $kece4[$p]['id_kecelakaan_detail'];
					// echo $idkece4;
				}
			}
		}

		$data['data']		=	array(
										'nama_perusahaan' 	=> $dataPerusahaan[0]['nama_perusahaan'],
										'kode_mitra'		=> $dataPerusahaan[0]['kode_mitra'],
										'alamat_perusahaan'	=> $dataPerusahaan[0]['alamat'],
										'desa_perusahaan'	=> $dataPerusahaan[0]['desa'],
										'kec_perusahaan'	=> $dataPerusahaan[0]['kecamatan'],
										'kota_perusahaan'	=> $dataPerusahaan[0]['kota'],
										'no_telp_perusahaan'=> $dataPerusahaan[0]['no_telp'],
										'nama_kontak_p'		=> $dataPerusahaan[0]['contact_person'],
										'nama_peserta'		=> $dataLKK1[0]['nama'],
										'nomor_peserta'		=> $nomor[0]['no_peserta'],
										'jenkel_peserta'	=> $dataPribadi[0]['jenkel'],
										'tgl_lahir'			=> $dataPribadi[0]['tgllahir'],
										'alamat_peserta'	=> $dataPribadi[0]['alamat'],
										'desa_peserta'		=> $dataPribadi[0]['desa'],
										'kec_peserta'		=> $dataPribadi[0]['kec'],
										'kota_peserta'		=> $dataPribadi[0]['kab'],
										'kode_pos'			=> $dataPribadi[0]['kodepos'],
										// 'no_hp_peserta'		=> $dataPribadi[0]['nohp'],
										'no_telp_peserta'	=> $dataPribadi[0]['nohp'],
										'jabatan_peserta'	=> $dataPribadi[0]['jabatan'],
										'unit_peserta'		=> $unit[0]['unit'],
										'upah_status'		=> $upah[0]['upah_status'],
										'upah_nominal'		=> ltrim($dataLKK1[0]['upah_nominal'], 'Rp '),
										'terbilang'			=> number_to_words($dataLKK1[0]['upah_nominal']),
										'tempat_kecelakaan'	=> $tempat_kecelakaan[0]['lokasi_kejadian'],
										'alamat_kecelakaan'	=> $dataLKK1[0]['alamat_kk'],
										'desa_kecelakaan'	=> $dataLKK1[0]['desa'],
										'kec_kecelakaan'	=> $dataLKK1[0]['kecamatan'],
										'kota_kecelakaan'	=> $dataLKK1[0]['kokab'],
										'tgl_kecelakaan'	=> $dataLKK1[0]['tgl_kk'],
										'kece1'				=> $kece1,
										'kece2'				=> $kece2,
										'kece3'				=> $kece3,
										'kece4'				=> $kece4,
										'kejadian'			=> $dataLKK1[0]['kejadian'],
										'penyebab'			=> $dataLKK1[0]['penyebab'],
										'akibat'			=> $dataLKK1[0]['akibat_diderita'],
										'akibat_detail'		=> $dataLKK1[0]['akibat_detail'],
										'nama_faskes'		=> $faskes[0]['nama'],
										'jenis_faskes'		=> $faskes[0]['jenis_faskes'],
										'alamat_faskes'		=> $faskes[0]['alamat'],
										'keadaan_penderita'	=> $dataLKK1[0]['keadaan_penderita'],
										'keterangan_lain'	=> $dataLKK1[0]['keterangan_lain'],
								);
		// echo "<pre>";
		// print_r($dataLKK1_all['data']['nama_perusahaan']);
		// echo "</pre>";
		// exit();


		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8', 'A4', 8, '', 5, 5, 10, 15, 0, 0, 'P');
		$filename = 'kecelakaan-kerja-tahap-1/'.str_replace('/','-', $noind).'.pdf';

		$html = $this->load->view('MasterPekerja/Laporan/V_Pdf', $data, true);
		// $stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
		// $pdf->WriteHTML($stylesheet1,1);
		$pdf->WriteHTML($html, 0);
    	$pdf->setTitle($filename);
		$pdf->Output($filename, 'I');

		// $this->load->view('MasterPekerja/Laporan/V_Pdf', $dataLKK1_all);
	}

	public function getAlamatKK()
	{
		$kode_mitra = $this->input->post('cmbCabangPerusahaan');
		$data 		= $this->M_kecelakaan->ambilAlamatPerusahaan($kode_mitra);
		$dataAlamat = array(
							'alamat' 	=> $data[0]['alamat'],
							'desa' 		=> $data[0]['desa'],
							'kecamatan' => $data[0]['kecamatan'],
							'kota' 		=> $data[0]['kota'],
						);
		echo json_encode($dataAlamat);
	}

	public function nextKecelakaan($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$cek 	 = $this->M_kecelakaan->getLKK1($id);
		$idTahap2= $cek[0]['id_lkk_2'];

		if ($idTahap2 != null) {
			print "<script type='text/javascript'>alert('Data Tahap 2 telah ada. Mohon pilih menu EDIT untuk mengubahnya. Terima kasih.');</script>";
			$this->index();
		} else{
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['SubMenuTwo'] = '';

			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

			$data['data']		= 	$this->M_kecelakaan->getLKK1($id);
			$data['kk4']		= 	$this->M_kecelakaan->kk4();
			$data['biaya']		= 	$this->M_kecelakaan->biayaKategori();
			$data['id'] 		= 	array(
										'lkk_1' => $id,
									);
			// echo "<pre>";
			// print_r($data_biaya);
			// exit();


			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MasterPekerja/Laporan/V_TambahDataT2',$data);
			$this->load->view('V_Footer',$data);
		}
	}

	public function inputDataTahap2()
	{
		$user_id = $this->session->userid;
		$id_lkk1_s  = $this->input->post('txt_id_lkk1');
		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Add Data Tahap 2 Kecelakaan Kerja ID='.$id_lkk2;
		$this->log_activity->activity_log($aksi, $detail);
		//
		$noind 		= $this->input->post('txt_noindPekerja');
		$pekerja 	= $this->M_kecelakaan->ambilDataPribadi($noind);
		$nama 		= $pekerja[0]['nama'];
		$kodesie 	= $pekerja[0]['kodesie'];
		$kd_jabatan = $pekerja[0]['kd_jabatan'];
		$tgl_kk 	= $this->input->post('txt_tgl_kecelakaan');
		$status_kk 	= $this->input->post('rd_disampaikan');
		if ($status_kk == "Belum disampaikan") {
			$tgl_lkk1 = null;
		} else if ($status_kk == "Sudah disampaikan") {
			$tgl_lkk1 = $this->input->post('txt_tgl_kirim_tahap1');
		};
		$pengajuan 	= $this->input->post('rd_pengajuan');
		$penerima 	= $this->input->post('rd_penerima');
		$ketdokter	= $this->input->post('rd_terlampir');
		$tglkk4 	= $this->input->post('txt_tgl_kk4');
		$santunan 	= $this->input->post('txt_santunan');
		$pnama 		= $this->input->post('txt_pnama');
		$pnik 		= $this->input->post('txt_pnik');
		$phubungan	= $this->input->post('rd_hubungan');
		$palamat	= $this->input->post('txt_palamat');
		$pdesa 		= $this->input->post('txt_pdesa');
		$pkec 		= $this->input->post('txt_pkec');
		$pkab 		= $this->input->post('txt_pkab');
		$pkodepos	= $this->input->post('txt_pkodepos');
		$pnotelp	= $this->input->post('txt_pnotelp');
		$pnorek 	= $this->input->post('txt_prekening');
		$pnmbank 	= $this->input->post('txt_pnamabank');
		$pketlain 	= $this->input->post('txtarea_keteranganlain');
		if ($this->input->post('txt_jml_stmb1') != null)
		{
			if ($santunan != null or $santunan != "") {
				$tahap2 	= array(
									'noind' 					=> $noind,
									'nama' 						=> $nama,
									'kodesie' 					=> $kodesie,
									'kd_jabatan' 				=> $kd_jabatan,
									'tgl_kk' 					=> $tgl_kk,
									'status_lkk_1' 				=> $status_kk,
									'tgl_lkk_1' 				=> $tgl_lkk1,
									'pengajuan_pembiayaan' 		=> $pengajuan,
									'penerima_pembiayaan' 		=> $penerima,
									'keterangan_dokter' 		=> $ketdokter,
									'tgl_kk4' 					=> $tglkk4,
									'santunan' 					=> $santunan,
									'penerima_nama'				=> strtoupper($pnama),
									'penerima_nik' 				=> $pnik,
									'penerima_status_hubungan' 	=> $phubungan,
									'alamat' 					=> strtoupper($palamat),
									'no_telp' 					=> $pnotelp,
									'desa' 						=> strtoupper($pdesa),
									'kecamatan' 				=> strtoupper($pkec),
									'kota' 						=> strtoupper($pkab),
									'kode_pos' 					=> $pkodepos,
									'no_rekening' 				=> $pnorek,
									'nama_bank' 				=> strtoupper($pnmbank),
									'keterangan_lain' 			=> $pketlain,
									'create_timestamp' 			=> date('Y-m-d H:i:s'),
									'create_user' 				=> $this->session->user,
								);
				$id_lkk2 	= $this->M_kecelakaan->simpanTahap2($tahap2);
				$history 	= array(
									'id_lkk_2'					=> $id_lkk2,
									'noind' 					=> $noind,
									'nama' 						=> $nama,
									'kodesie' 					=> $kodesie,
									'kd_jabatan' 				=> $kd_jabatan,
									'tgl_kk' 					=> $tgl_kk,
									'status_lkk_1' 				=> $status_kk,
									'tgl_lkk_1' 				=> $tgl_lkk1,
									'pengajuan_pembiayaan' 		=> $pengajuan,
									'penerima_pembiayaan' 		=> $penerima,
									'keterangan_dokter' 		=> $ketdokter,
									'tgl_kk4' 					=> $tglkk4,
									'santunan' 					=> $santunan,
									'penerima_nama'				=> strtoupper($pnama),
									'penerima_nik' 				=> $pnik,
									'penerima_status_hubungan' 	=> $phubungan,
									'alamat' 					=> strtoupper($palamat),
									'no_telp' 					=> $pnotelp,
									'desa' 						=> strtoupper($pdesa),
									'kecamatan' 				=> strtoupper($pkec),
									'kota' 						=> strtoupper($pkab),
									'kode_pos' 					=> $pkodepos,
									'no_rekening' 				=> $pnorek,
									'nama_bank' 				=> strtoupper($pnmbank),
									'keterangan_lain' 			=> $pketlain,
									'create_timestamp' 			=> date('Y-m-d H:i:s'),
									'create_user' 				=> $this->session->user,
									'history_type'				=> 'CREATE',
								);
				$this->M_kecelakaan->simpanHistoryTahap2($history);


				$indeks = 0;
				for ($i=1; $i < 6; $i++) {

					$nominal = $this->input->post('txt_biaya'.$indeks);
					if ($nominal == "") {
						$nominal = "-";
					}
					$biayasimpan = array(
										'id_lkk_2' 			=> $id_lkk2,
										'id_biaya_kategori' => $i,
										'nominal'			=> $nominal,
										'create_timestamp' 	=> date('Y-m-d H:i:s'),
										'create_user'		=> $this->session->user,
									);

					$id_biaya_kk = $this->M_kecelakaan->simpanKKBiaya($biayasimpan);
					// echo "<pre>";
					// print_r($biayasimpan);
					$biaya_history = array(
										'id_biaya_kk'		=> $id_biaya_kk,
										'id_lkk_2' 			=> $id_lkk2,
										'id_biaya_kategori' => $i,
										'nominal'			=> $nominal,
										'create_timestamp' 	=> date('Y-m-d H:i:s'),
										'create_user'		=> $this->session->user,
										'history_type'		=> 'CREATE',
									);
					$this->M_kecelakaan->simpanhistoryBiaya($biaya_history);

					$indeks++;

				}



				for ($a=1; $a < 3; $a++) {
				$periode_awal 	= $this->input->post('txt_periode_awal'.$a);
				$periode_akhir 	= $this->input->post('txt_periode_akhir'.$a);
				$nominal 		= $this->input->post('txt_jml_stmb'.$a);
				$arraystmb 	= array(
									'id_lkk_2' 			=> $id_lkk2,
									'periode_awal' 		=> $periode_awal,
									'periode_akhir' 	=> $periode_akhir,
									'nominal' 			=> $nominal,
									'create_timestamp' 	=> date('Y-m-d H:i:s'),
									'create_user' 		=> $this->session->user,
								);
				$id_pengajuan_stmb = $this->M_kecelakaan->simpanSTMB($arraystmb);
				$historystmb 	= array(
									'id_pengajuan_stmb' => $id_pengajuan_stmb,
									'id_lkk_2' 			=> $id_lkk2,
									'periode_awal' 		=> $periode_awal,
									'periode_akhir' 	=> $periode_akhir,
									'nominal' 			=> $nominal,
									'create_timestamp' 	=> date('Y-m-d H:i:s'),
									'create_user' 		=> $this->session->user,
									'history_type'		=> 'CREATE',
								);
				$this->M_kecelakaan->simpanHistorySTMB($historystmb);
				}



					$ket = $this->input->post('ket');
					$jml = count($ket);
					for ($f=0; $f < $jml; $f++) {
						$dataKK4 = array (
										'id_lkk_2' 			=> $id_lkk2,
										'id_ket_kk4' 		=> $ket[$f],
										'create_timestamp' 	=> date('Y-m-d H:i:s'),
										'create_user' 		=> $this->session->user,
									);
						// echo "<pre>";
						// print_r($dataKK4);
						$id_kk4 = $this->M_kecelakaan->simpanKK4($dataKK4);
						$history_kk4 = array (
										'id_laporan_keterangan' => $id_kk4,
										'id_lkk_2' 			=> $id_lkk2,
										'id_ket_kk4' 		=> $ket[$f],
										'create_timestamp' 	=> date('Y-m-d H:i:s'),
										'create_user' 		=> $this->session->user,
										'history_type' 		=> 'CREATE',
									);
						$this->M_kecelakaan->simpanHistoryKK4($history_kk4);
					}

					$dataUpdateT1 = array(
										'id_lkk_2' => $id_lkk2,
									);
					$this->M_kecelakaan->updateT1wIdT2($dataUpdateT1,$id_lkk1_s);
					redirect('MasterPekerja/KecelakaanKerja');
			}else {
				print "<script type='text/javascript'>alert('Jangan kosongi nominal Santunan !');</script>";
				$this->nextKecelakaan($id_lkk1_s);
			}

		}else {
			print "<script type='text/javascript'>alert('Jangan kosongi nominal STMB !');</script>";
			$this->nextKecelakaan($id_lkk1_s);

		}
	}

	public function editTahap2($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$ambil 	 = 	$this->M_kecelakaan->getLKK1($id);
		$id2 	 = 	$ambil[0]['id_lkk_2'];

		if ($id2 != null ) {
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['SubMenuTwo'] = '';

			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

			//tampil view
			$data['data1']		= 	$this->M_kecelakaan->getLKK1($id);
			$data['kk4']		= 	$this->M_kecelakaan->kk4();
			$data['biaya']		= 	$this->M_kecelakaan->biayaKategori();
			//tampil data update
			$data['data']		= 	$this->M_kecelakaan->getLKK2($id2);
			$data['kbiaya'] 	= 	$this->M_kecelakaan->ambilBiaya($id2);
			$data['stmb']		= 	$this->M_kecelakaan->ambilSTMB($id2);
			$data['ukk4']		= 	$this->M_kecelakaan->ambilKK4($id2);

			// echo "<pre>";
			// print_r($data['kbiaya']);
			// exit();

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MasterPekerja/Laporan/V_TampilTahap2',$data);
			$this->load->view('V_Footer',$data);

		} else{
			print "<script type='text/javascript'>alert('Data Tahap 2 tidak ditemukan. Mohon pilih menu INSERT untuk menambahkan data terlebih dahulu. Terima kasih.');</script>";

			$this->index();
		}
	}

	public function updateTahap2($id)
	{
		$user_id = $this->session->userid;
		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Update Data Tahap 2 Kecelakaan Kerja ID='.$id;
		$this->log_activity->activity_log($aksi, $detail);
		//
		$noind 		= $this->input->post('txt_noindPekerja');
		$pekerja 	= $this->M_kecelakaan->ambilDataPribadi($noind);
		$nama 		= $pekerja[0]['nama'];
		$kodesie 	= $pekerja[0]['kodesie'];
		$kd_jabatan = $pekerja[0]['kd_jabatan'];
		$tgl_kk 	= $this->input->post('txt_tgl_kecelakaan');
		$status_kk 	= $this->input->post('rd_disampaikan');
		if ($status_kk == "Belum disampaikan") {
			$tgl_lkk1 = null;
		} else if ($status_kk == "Sudah disampaikan") {
			$tgl_lkk1 = $this->input->post('txt_tgl_kirim_tahap1');
		};
		$pengajuan 	= $this->input->post('rd_pengajuan');
		$penerima 	= $this->input->post('rd_penerima');
		$ketdokter	= $this->input->post('rd_terlampir');
		$tglkk4 	= $this->input->post('txt_tgl_kk4');
		$santunan 	= $this->input->post('txt_santunan');
		$pnama 		= $this->input->post('txt_pnama');
		$pnik 		= $this->input->post('txt_pnik');
		$phubungan	= $this->input->post('rd_hubungan');
		$palamat	= $this->input->post('txt_palamat');
		$pdesa 		= $this->input->post('txt_pdesa');
		$pkec 		= $this->input->post('txt_pkec');
		$pkab 		= $this->input->post('txt_pkab');
		$pkodepos	= $this->input->post('txt_pkodepos');
		$pnotelp	= $this->input->post('txt_pnotelp');
		$pnorek 	= $this->input->post('txt_prekening');
		$pnmbank 	= $this->input->post('txt_pnamabank');
		$pketlain 	= $this->input->post('txtarea_keteranganlain');

		$tahap2 	= array(
							'status_lkk_1' 				=> $status_kk,
							'tgl_lkk_1' 				=> $tgl_lkk1,
							'pengajuan_pembiayaan' 		=> $pengajuan,
							'penerima_pembiayaan' 		=> $penerima,
							'keterangan_dokter' 		=> $ketdokter,
							'tgl_kk4' 					=> $tglkk4,
							'santunan' 					=> $santunan,
							'penerima_nama'				=> strtoupper($pnama),
							'penerima_nik' 				=> $pnik,
							'penerima_status_hubungan' 	=> $phubungan,
							'alamat' 					=> $palamat,
							'no_telp' 					=> $pnotelp,
							'desa' 						=> strtoupper($pdesa),
							'kecamatan' 				=> strtoupper($pkec),
							'kota' 						=> strtoupper($pkab),
							'kode_pos' 					=> $pkodepos,
							'no_rekening' 				=> $pnorek,
							'nama_bank' 				=> strtoupper($pnmbank),
							'keterangan_lain' 			=> $pketlain,
							'last_update_timestamp' 	=> date('Y-m-d H:i:s'),
							'last_update_user' 			=> $this->session->user,
						);
		$this->M_kecelakaan->updateTahap2($tahap2,$id);
		$history 	= array(
							'id_lkk_2'					=> $id,
							'noind' 					=> $noind,
							'nama' 						=> strtoupper($nama),
							'kodesie' 					=> $kodesie,
							'kd_jabatan' 				=> $kd_jabatan,
							'tgl_kk' 					=> $tgl_kk,
							'status_lkk_1' 				=> $status_kk,
							'tgl_lkk_1' 				=> $tgl_lkk1,
							'pengajuan_pembiayaan' 		=> $pengajuan,
							'penerima_pembiayaan' 		=> $penerima,
							'keterangan_dokter' 		=> $ketdokter,
							'tgl_kk4' 					=> $tglkk4,
							'santunan' 					=> $santunan,
							'penerima_nama'				=> strtoupper($pnama),
							'penerima_nik' 				=> $pnik,
							'penerima_status_hubungan' 	=> $phubungan,
							'alamat' 					=> $palamat,
							'no_telp' 					=> $pnotelp,
							'desa' 						=> strtoupper($pdesa),
							'kecamatan' 				=> strtoupper($pkec),
							'kota' 						=> strtoupper($pkab),
							'kode_pos' 					=> $pkodepos,
							'no_rekening' 				=> $pnorek,
							'nama_bank' 				=> strtoupper($pnmbank),
							'keterangan_lain' 			=> $pketlain,
							'update_timestamp' 			=> date('Y-m-d H:i:s'),
							'update_user' 				=> $this->session->user,
							'history_type'				=> 'UPDATE',
						);
		$this->M_kecelakaan->simpanHistoryTahap2($history);


		$indeks = 0;
		$data_biaya_kk = $this->M_kecelakaan->ambilIdBiaya($id);
		for ($i=1; $i < 6; $i++) {

			$nominal = $this->input->post('txt_biaya'.$indeks);
			if ($nominal == "") {
				$nominal = "-";
			}
			$biayasimpan = array(
								'nominal'				=> $nominal,
								'last_update_timestamp'	=> date('Y-m-d H:i:s'),
								'last_update_user'		=> $this->session->user,
							);

			$this->M_kecelakaan->updateKKBiaya($biayasimpan,$id,$i);
			// echo $nominal;
			// print_r($biayasimpan);

			$id_biaya_kk = $data_biaya_kk[$indeks]['id_biaya_kk'];
			$biaya_history = array(
								'id_biaya_kk'		=> $id_biaya_kk,
								'id_lkk_2' 			=> $id,
								'id_biaya_kategori' => $i,
								'nominal'			=> $nominal,
								'update_timestamp' 	=> date('Y-m-d H:i:s'),
								'update_user'		=> $this->session->user,
								'history_type'		=> 'UPDATE',
							);
			$this->M_kecelakaan->simpanhistoryBiaya($biaya_history);

			$indeks++;

			}



			$yu = 0;
			$data_pengajuan_stmb = $this->M_kecelakaan->ambilIdSTMB($id);
			for ($a=1; $a < 3; $a++) {
			$id_pengajuan_stmb = $data_pengajuan_stmb[$yu]['id_pengajuan_stmb'];
			$periode_awal 	= $this->input->post('txt_periode_awal'.$a);
			$periode_akhir 	= $this->input->post('txt_periode_akhir'.$a);
			$nominalstmb 		= $this->input->post('txt_jml_stmb'.$a);
			$arraystmb 	= array(
								'periode_awal' 		=> $periode_awal,
								'periode_akhir' 	=> $periode_akhir,
								'nominal' 			=> $nominalstmb,
								'last_update_timestamp' => date('Y-m-d H:i:s'),
								'last_update_user' 		=> $this->session->user,
							);
			$this->M_kecelakaan->updateSTMB($arraystmb,$id,$id_pengajuan_stmb);
			// echo "<pre>";
			// print_r($arraystmb);
			// // print_r ($data_pengajuan_stmb);
			// // exit();
			// echo $id_pengajuan_stmb;
			$historystmb 	= array(
								'id_pengajuan_stmb' => $id_pengajuan_stmb,
								'id_lkk_2' 			=> $id,
								'periode_awal' 		=> $periode_awal,
								'periode_akhir' 	=> $periode_akhir,
								'nominal' 			=> $nominalstmb,
								'update_timestamp' 	=> date('Y-m-d H:i:s'),
								'update_user' 		=> $this->session->user,
								'history_type'		=> 'UPDATE',
							);
			$this->M_kecelakaan->simpanHistorySTMB($historystmb);
			// echo "<pre>";
			// print_r($historystmb);
			$yu++;
			}


			$data_kk4 = $this->M_kecelakaan->ambilDataKK4($id);
			$idatas   = $data_kk4[0]['id_laporan_keterangan'];
			$this->M_kecelakaan->resetIDkk4($idatas);
			$jmlkk4   = count($data_kk4);
			for ($ey=0; $ey < $jmlkk4; $ey++) {
				$idketkk4 	= $data_kk4[$ey]['id_ket_kk4'];
				$idkk4lama 	= $this->M_kecelakaan->deleteKK4lama($id,$idketkk4);

			}
			$ket = $this->input->post('ket');
			$jml = count($ket);
			for ($f=0; $f < $jml; $f++) {
				$dataKK4 = array (
								'id_lkk_2' 			=> $id,
								'id_ket_kk4' 		=> $ket[$f],
								'create_timestamp' 	=> date('Y-m-d H:i:s'),
								'create_user' 		=> $this->session->user,
							);

				$id_kk4 = $this->M_kecelakaan->simpanKK4($dataKK4);
				$history_kk4 = array (
								'id_laporan_keterangan' => $id_kk4,
								'id_lkk_2' 			=> $id,
								'id_ket_kk4' 		=> $ket[$f],
								'update_timestamp' 	=> date('Y-m-d H:i:s'),
								'update_user' 		=> $this->session->user,
								'history_type' 		=> 'UPDATE',
							);
				$this->M_kecelakaan->simpanHistoryKK4($history_kk4);
			}


			redirect('MasterPekerja/KecelakaanKerja');
	}

	public function printTahap2($id)
	{
		$lkk1 	 = 	$this->M_kecelakaan->getLKK1($id);
		$id2 	 = 	$lkk1[0]['id_lkk_2'];
		if ($id2 != null ) {
			//insert to t_log
			$aksi = 'MASTER PEKERJA';
			$detail = 'Export PDF Data Tahap 2 Kecelakaan Kerja ID='.$id;
			$this->log_activity->activity_log($aksi, $detail);
			//
			$this->load->library('pdf');
			$kode_mitra		= $lkk1[0]['kode_mitra'];
			$noind 			= $lkk1[0]['noind'];
			$dataPribadi 	= $this->M_kecelakaan->ambilDataPribadi($noind);
			$kodesie		= $dataPribadi[0]['kodesie'];
			$unit 			= $this->M_kecelakaan->unitPekerja($kodesie);
			$nomor 			= $this->M_kecelakaan->getNomorBPJS($noind);
			$dataPerusahaan	= $this->M_kecelakaan->getPerusahaanByKode($kode_mitra);
			$lkk2 			= $this->M_kecelakaan->getLKK2($id2);
			$data['stmb'] 	= $this->M_kecelakaan->ambilSTMB($id2);
			$data['kk4']  	= $this->M_kecelakaan->ambilKK4($id2);
			$data['biaya'] 	= $this->M_kecelakaan->ambilBiaya($id2);

			// echo "<pre>";
			// print_r($data['kk4']);

			// echo "<pre>";
			// print_r($ukk);
			// exit();

			$data['data'] = array(
								'nama_perusahaan' 	=> $dataPerusahaan[0]['nama_perusahaan'],
								'kode_mitra'		=> $dataPerusahaan[0]['kode_mitra'],
								'alamat_perusahaan'	=> $dataPerusahaan[0]['alamat'],
								'desa_perusahaan'	=> $dataPerusahaan[0]['desa'],
								'kec_perusahaan'	=> $dataPerusahaan[0]['kecamatan'],
								'kota_perusahaan'	=> $dataPerusahaan[0]['kota'],
								'no_telp_perusahaan'=> $dataPerusahaan[0]['no_telp'],
								'nama_kontak_p'		=> $dataPerusahaan[0]['contact_person'],
								'nama_peserta'		=> $lkk1[0]['nama'],
								'nomor_peserta'		=> $nomor[0]['no_peserta'],
								'jenkel_peserta'	=> $dataPribadi[0]['jenkel'],
								'tgl_lahir'			=> $dataPribadi[0]['tgllahir'],
								'alamat_peserta'	=> $dataPribadi[0]['alamat'],
								'desa_peserta'		=> $dataPribadi[0]['desa'],
								'kec_peserta'		=> $dataPribadi[0]['kec'],
								'kota_peserta'		=> $dataPribadi[0]['kab'],
								'kode_pos1'			=> $dataPribadi[0]['kodepos'],
								'no_telp_peserta'	=> $dataPribadi[0]['nohp'],
								'jabatan_peserta'	=> $dataPribadi[0]['jabatan'],
								'unit_peserta'		=> $unit[0]['unit'],
								'tgl_kk'			=> $lkk2[0]['tgl_kk'],
								'disampaikan'		=> $lkk2[0]['status_lkk_1'],
								'tgl_sampai'		=> $lkk2[0]['tgl_lkk_1'],
								'pengajuan'			=> $lkk2[0]['pengajuan_pembiayaan'],
								'penerima'			=> $lkk2[0]['penerima_pembiayaan'],
								'keterangan_dokter'	=> $lkk2[0]['keterangan_dokter'],
								'tgl_kk4'			=> $lkk2[0]['tgl_kk4'],
								'santunan'			=> $lkk2[0]['santunan'],
								'p_nama'			=> $lkk2[0]['penerima_nama'],
								'p_nik'				=> $lkk2[0]['penerima_nik'],
								'p_status'			=> $lkk2[0]['penerima_status_hubungan'],
								'p_alamat'			=> $lkk2[0]['alamat'],
								'no_telp'			=> $lkk2[0]['no_telp'],
								'desa'				=> $lkk2[0]['desa'],
								'kecamatan'			=> $lkk2[0]['kecamatan'],
								'kota'				=> $lkk2[0]['kota'],
								'kode_pos'			=> $lkk2[0]['kode_pos'],
								'no_rekening'		=> $lkk2[0]['no_rekening'],
								'nama_bank'			=> $lkk2[0]['nama_bank'],
								'ket_lain'			=> $lkk2[0]['keterangan_lain'],
							);

			$pdf = $this->pdf->load();
			$pdf = new mPDF('utf-8', 'Legal', 8, '', 5, 5, 10, 15, 0, 0, 'P');
			$filename = 'kecelakaan-kerja-tahap-2/'.str_replace('/','-', $noind).'.pdf';

			$html = $this->load->view('MasterPekerja/Laporan/V_Pdf_thp2', $data, true);
			$pdf->WriteHTML($stylesheet1,1);
			$pdf->WriteHTML($html, 0);
      $pdf->setTitle($filename);
			$pdf->Output($filename, 'I');
		}else{
			print "<script type='text/javascript'>alert('Data Tahap 2 tidak ditemukan. Mohon pilih menu INSERT untuk menambahkan data terlebih dahulu. Terima kasih.');</script>";

			$this->index();
		}
	}

}
