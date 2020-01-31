<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Index extends CI_Controller {


	public function __construct()
  {
    parent::__construct();

	$this->load->library('General');
	$this->load->library('Log_Activity');

    $this->load->model('M_Index');
	$this->load->model('SystemAdministration/MainMenu/M_user');
	$this->load->model('MasterPekerja/Pekerja/PekerjaKeluar/M_pekerjakeluar');

  	if($this->session->userdata('logged_in')!=TRUE) {
  		$this->load->helper('url');
  		// $this->load->helper('terbilang_helper');
  		$this->session->set_userdata('last_page', current_url());
  			  //redirect('index');
  		$this->session->set_userdata('Responsbility', 'some_value');
  	}
  	date_default_timezone_set('Asia/Jakarta');
  	$this->checkSession();
  }

	//HALAMAN INDEX
	public function index(){
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Pekerja/PekerjaKeluar/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function checkSession(){
		if($this->session->is_logged){

		}else{
			redirect('');
		}
	}

	public function data_pekerja()
	{
		$keluar 	= $this->input->get('rd_keluar');
		$pekerja 	= strtoupper($this->input->get('term'));
		$data 		= $this->M_pekerjakeluar->getPekerja($pekerja,$keluar);

		echo json_encode($data);
	}

	public function data_pekerjaan()
	{
		$pekerja 	    = strtoupper($this->input->get('term'));
		$kd_pekerjaan = $this->input->get('kd_pekerjaan');
		$data = $this->M_pekerjakeluar->getkdPekerja($pekerja,$kd_pekerjaan);
		echo json_encode($data);
	}

	public function viewEdit()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$noind 					    = $this->input->post('slc_Pekerja');
		$keluar 				    = $this->input->post('rd_keluar');
		$internal_mail 			= $this->input->post('txt_internalmail');
		/*
		$telkomsel_mygroup 	= $this->input->post('txt_telkomsel_mygroup');
		$external_mail 			= $this->input->post('txt_external_mail');
		$pidgin_account 		= $this->input->post('txt_pidgin_account');
		*/

		$pekerja 	        	= $this->M_pekerjakeluar->dataPekerja($noind,$keluar);
		$kontak 		        = $this->M_pekerjakeluar->kontakPekerja($noind);
		$pekerjaan          =$this->M_pekerjakeluar->getPekerjaan($noind);

		if ($pekerja != null) {
			$kodesie 		= $pekerja[0]['kodesie'];
			$seksi 			= $this->M_pekerjakeluar->dataSeksi($kodesie);

			$check = '';
			if ($pekerja[0]['status_diangkat'] =="t") {
				$check = 'checked';
			}

			$data['check'] = $check;

			if ( $kontak == null )
			{
			$data['data'] 	= array(
									'photo' 	          => $pekerja[0]['photo'],
									'noind' 	          => $pekerja[0]['noind'],
									'nama' 		          => $pekerja[0]['nama'],
									'templahir'         => $pekerja[0]['templahir'],
									'tgllahir' 	        => $pekerja[0]['tgllahir'],
									'nik' 		          => $pekerja[0]['nik'],
									'alamat' 	          => $pekerja[0]['alamat'],
									'desa' 		          => $pekerja[0]['desa'],
									'kec' 		          => $pekerja[0]['kec'],
									'kab' 		          => $pekerja[0]['kab'],
									'prop' 		          => $pekerja[0]['prop'],
									'kodepos' 	        => $pekerja[0]['kodepos'],
									'telepon' 	        => $pekerja[0]['telepon'],
									'nohp' 	   	        => $pekerja[0]['nohp'],
									'diangkat' 	        => $pekerja[0]['diangkat'],
									'masukkerja'        => $pekerja[0]['masukkerja'],
									'lmkontrak'         => $pekerja[0]['lmkontrak'],
									'akhkontrak'        => $pekerja[0]['akhkontrak'],
									'jabatan' 	        => $pekerja[0]['jabatanref'],

									'pekerjaan'         => $pekerjaan[0]['pekerjaan'],
									'kd_pekerjaan'      =>  $pekerjaan[0]['kd_pekerjaan'],

									'seksi' 	          => $seksi[0]['seksi'],
									'unit' 		          => $seksi[0]['unit'],
									'bidang' 	          => $seksi[0]['bidang'],
									'dept' 		          => $seksi[0]['dept'],

									/*'internal_mail' 	  => '',
									'telkomsel_mygroup' => '',
									'external_mail' 	  => '',
									'pidgin_account' 	  => '',
									*/

									'tglkeluar'         => $pekerja[0]['tglkeluar'],
									'sebabklr'          => $pekerja[0]['sebabklr'],
									'uk_baju'           => $pekerja[0]['uk_baju'],
									'uk_celana'         => $pekerja[0]['uk_celana'],
									'uk_sepatu'         => $pekerja[0]['uk_sepatu'],
									'status_diangkat'   => $pekerja[0]['status_diangkat'],
									'email'             => $pekerja[0]['email'],
									'email_internal'    => $pekerja[0]['email_internal'],
									'telkomsel_mygroup' => $pekerja[0]['telkomsel_mygroup'],
									'pidgin_account'    => $pekerja[0]['pidgin_account']

								);
		}else{
		$data['data'] 	= array(
									'photo' 	          => $pekerja[0]['photo'],
									'noind' 	          => $pekerja[0]['noind'],
									'nama' 		          => $pekerja[0]['nama'],
									'templahir'         => $pekerja[0]['templahir'],
									'tgllahir' 	        => $pekerja[0]['tgllahir'],
									'nik' 		          => $pekerja[0]['nik'],
									'alamat' 	          => $pekerja[0]['alamat'],
									'desa' 		          => $pekerja[0]['desa'],
									'kec' 		          => $pekerja[0]['kec'],
									'kab' 		          => $pekerja[0]['kab'],
									'prop' 		          => $pekerja[0]['prop'],
									'kodepos' 	        => $pekerja[0]['kodepos'],
									'telepon' 	        => $pekerja[0]['telepon'],
									'nohp' 		          => $pekerja[0]['nohp'],
									'diangkat' 	        => $pekerja[0]['diangkat'],
									'masukkerja'        => $pekerja[0]['masukkerja'],
									'lmkontrak'         => $pekerja[0]['lmkontrak'],
									'akhkontrak'        => $pekerja[0]['akhkontrak'],
									'jabatan' 	        => $pekerja[0]['jabatanref'],

									'pekerjaan'         => $pekerjaan[0]['pekerjaan'],
									'kd_pekerjaan'      =>  $pekerjaan[0]['kd_pekerjaan'],

									'seksi' 	          => $seksi[0]['seksi'],
									'unit' 		          => $seksi[0]['unit'],
									'bidang' 	          => $seksi[0]['bidang'],
									'dept' 		          => $seksi[0]['dept'],

									/*'internal_mail' 	  => $kontak[0]['internal_mail'],
									'telkomsel_mygroup' => $kontak[0]['telkomsel_mygroup'],
									'external_mail' 	  => $kontak[0]['external_mail'],
									'pidgin_account' 	  => $kontak[0]['pidgin_account'],
									*/

									'tglkeluar'         => $pekerja[0]['tglkeluar'],
									'sebabklr' 	        => $pekerja[0]['sebabklr'],
									'uk_baju' 	        => $pekerja[0]['uk_baju'],
									'uk_celana'         => $pekerja[0]['uk_celana'],
									'uk_sepatu'         => $pekerja[0]['uk_sepatu'],
									'status_diangkat'   => $pekerja[0]['status_diangkat'],
									'email'             => $pekerja[0]['email'],
									'email_internal'    => $pekerja[0]['email_internal'],
									'telkomsel_mygroup' => $pekerja[0]['telkomsel_mygroup'],
									'pidgin_account'    => $pekerja[0]['pidgin_account']
								);
		}


			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['SubMenuTwo'] = '';

			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MasterPekerja/Pekerja/PekerjaKeluar/V_Edit',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['SubMenuTwo'] = '';

			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MasterPekerja/Pekerja/PekerjaKeluar/V_Index',$data);
			$this->load->view('V_Footer',$data);

			print "<script type='text/javascript'>alert('Data yang Anda masukan tidak ditemukan. Mohon coba kembali');</script>";


	}
}

	public function updateData()
	{
		$user_id 	= $this->session->userid;
		$noind		= $this->input->post('txt_noindukLama');
		$prop 		= $this->input->post('slc_provinsi_pekerja');
		$kab 		= $this->input->post('slc_kabupaten_pekerja');
		$kec 		= $this->input->post('slc_kecamatan_pekerja');
		$desa 		= $this->input->post('slc_desa_pekerja');
		$ambil_prov = $this->M_pekerjakeluar->ambilProv($prop);
		$ambil_kab 	= $this->M_pekerjakeluar->ambilKab($kab);
		$ambil_kec 	= $this->M_pekerjakeluar->ambilKec($kec);
		$ambil_desa = $this->M_pekerjakeluar->ambilDesa($desa);

		if ( $ambil_prov != null )
		{
			$data 	 	= array(
								'noind' 	=> $this->input->post('txt_noinduk'),
								'nama' 		=> $this->input->post('txt_namaPekerja'),
								'templahir' => $this->input->post('txt_kotaLahir'),
								'tgllahir' 	=> $this->input->post('txt_tanggalLahir'),
								'nik' 		=> $this->input->post('txt_nikPekerja'),
								'alamat' 	=> $this->input->post('txt_alamatPekerja'),
								'desa' 		=> $ambil_desa[0]['nama'],
								'kec' 		=> $ambil_kec[0]['nama'],
								'kab' 		=> $ambil_kab[0]['nama'],
								'prop' 		=> $ambil_prov[0]['nama'],
								'kodepos' 	=> $this->input->post('txt_kodePosPekerja'),
								'telepon' 	=> $this->input->post('txt_teleponPekerja'),
								'nohp' 		=> $this->input->post('txt_nohpPekerja'),
								'diangkat' 	=> $this->input->post('txt_tglDiangkat'),
								'masukkerja'=> $this->input->post('txt_tglMasukKerja'),
								'lmkontrak' => $this->input->post('txt_lamaKontrak'),
								'akhkontrak'=> $this->input->post('txt_akhirKontrak'),
								'jabatan' 	=> $this->input->post('txt_jabatanPekerja'),
								'tglkeluar' => $this->input->post('txt_tglkeluar'),
								'sebabklr' 	=> $this->input->post('txt_sebabkeluar'),
								'uk_baju' 	=> $this->input->post('txt_ukuranbaju'),
								'uk_celana' => $this->input->post('txt_ukurancelana'),
								'uk_sepatu' => $this->input->post('txt_ukuransepatu'),
  								'kd_pkj' => $this->input->post('txt_pekerjaanPekerja'),
								'status_diangkat'=>$this->input->post('rd_diangkat'),
								'email_internal' 	=> $this->input->post('txt_internalmail'),
								'telkomsel_mygroup' => $this->input->post('txt_telkomselmygroup'),
								'email' 	=> $this->input->post('txt_externalmail'),
								'pidgin_account' 	=> $this->input->post('txt_pidginaccount')
							);

			/*$mail 		= array(
								'internal_mail' 	=> $this->input->post('txt_internalmail'),
								'telkomsel_mygroup' => $this->input->post('txt_telkomselmygroup'),
								'external_mail' 	=> $this->input->post('txt_externalmail'),
								'pidgin_account' 	=> $this->input->post('txt_pidginaccount'),

								);*/

		$this->M_pekerjakeluar->updateDataPekerja($data,$noind);
		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Update Data Pekerja Keluar Noind = '.$noind;
		$this->log_activity->activity_log($aksi, $detail);
		//
		/*$this->M_pekerjakeluar->updateDataPekerjaa($mail,$noind);*/
		$history 	= array(
							'noind' 		=> $this->input->post('txt_noindukLama'),
							'aktifitas' 	=> 'UPDATE',
							'date_time' 	=> date('Y-m-d H:i:s'),
							'last_updated_by'=> $this->session->user,
						);
		$this->M_pekerjakeluar->historyUpdatePekerja($history);
		$tlog 	= array(
							'wkt'			=> date('Y-m-d H:i:s'),
							'menu'			=> 'MASTER PEKERJA -> EDIT DATA PEKERJA',
							'ket'			=> 'NO IND->'.$this->input->post('txt_noindukLama'),
							'noind'			=> $this->session->user,
							'jenis' 		=> 'EDIT -> DATA PEKERJA',
							'program'		=> 'ERP',
							'noind_baru'	=> 'NULL',

						);
		$this->M_pekerjakeluar->historyTlog($tlog);
		print "<script type='text/javascript'>alert('Data telah berhasil diubah. Mohon cek kembali');</script>";
		if (print "<script type='text/javascript'>alert('Data telah berhasil diubah. Mohon cek kembali');</script>" != null)
			{
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['SubMenuTwo'] = '';

			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MasterPekerja/Pekerja/PekerjaKeluar/V_Index',$data);
			$this->load->view('V_Footer',$data);
			};

		}else {
			$data 	 	= array(
								'noind' 	=> $this->input->post('txt_noinduk'),
								'nama' 		=> $this->input->post('txt_namaPekerja'),
								'templahir' => $this->input->post('txt_kotaLahir'),
								'tgllahir' 	=> $this->input->post('txt_tanggalLahir'),
								'nik' 		=> $this->input->post('txt_nikPekerja'),
								'alamat' 	=> $this->input->post('txt_alamatPekerja'),
								'kodepos' 	=> $this->input->post('txt_kodePosPekerja'),
								'telepon' 	=> $this->input->post('txt_teleponPekerja'),
								'nohp' 		=> $this->input->post('txt_nohpPekerja'),
								'diangkat' 	=> $this->input->post('txt_tglDiangkat'),
								'masukkerja'=> $this->input->post('txt_tglMasukKerja'),
								'lmkontrak' => $this->input->post('txt_lamaKontrak'),
								'akhkontrak'=> $this->input->post('txt_akhirKontrak'),
								'jabatan' 	=> $this->input->post('txt_jabatanPekerja'),
								'tglkeluar' => $this->input->post('txt_tglkeluar'),
								'sebabklr' 	=> $this->input->post('txt_sebabkeluar'),
								'uk_baju' 	=> $this->input->post('txt_ukuranbaju'),
								'uk_celana' => $this->input->post('txt_ukurancelana'),
								'uk_sepatu' => $this->input->post('txt_ukuransepatu'),
								'kd_pkj' => $this->input->post('txt_pekerjaanPekerja'),
								'status_diangkat'=>$this->input->post('rd_diangkat'),
								'email_internal' 	=> $this->input->post('txt_internalmail'),
								'telkomsel_mygroup' => $this->input->post('txt_telkomselmygroup'),
								'email' 	=> $this->input->post('txt_externalmail'),
								'pidgin_account' 	=> $this->input->post('txt_pidginaccount')
							);

			/*$mail 		= array(
								'internal_mail' 	=> $this->input->post('txt_internalmail'),
								'telkomsel_mygroup' => $this->input->post('txt_telkomselmygroup'),
								'external_mail' 	=> $this->input->post('txt_externalmail'),
								'pidgin_account' 	=> $this->input->post('txt_pidginaccount'),

								);*/

		$this->M_pekerjakeluar->updateDataPekerja($data,$noind);
		/*$this->M_pekerjakeluar->updateDataPekerjaa($mail,$noind);*/
		$history 	= array(
							'noind' 		=> $this->input->post('txt_noindukLama'),
							'aktifitas' 	=> 'UPDATE',
							'date_time' 	=> date('Y-m-d H:i:s'),
							'last_updated_by'=> $this->session->user,
						);
		$this->M_pekerjakeluar->historyUpdatePekerja($history);
		$tlog 	= array(
							'wkt'			=> date('Y-m-d H:i:s'),
							'menu'			=> 'MASTER PEKERJA -> EDIT DATA PEKERJA',
							'ket'			=> 'NO IND->'.$this->input->post('txt_noindukLama'),
							'noind'			=> $this->session->user,
							'jenis' 		=> 'EDIT -> DATA PEKERJA',
							'program'		=> 'ERP',
							'noind_baru'	=> 'NULL',

						);
		$this->M_pekerjakeluar->historyTlog($tlog);
		print "<script type='text/javascript'>alert('Data telah berhasil diubah. Mohon cek kembali');</script>";
		if (print "<script type='text/javascript'>alert('Data telah berhasil diubah. Mohon cek kembali');</script>" != null)
			{
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['SubMenuTwo'] = '';

			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MasterPekerja/Pekerja/PekerjaKeluar/V_Index',$data);
			$this->load->view('V_Footer',$data);
			};
		}
	}

	public function provinsiPekerja(){

		$provinsi 	= $this->input->get('term');
		$data 		= $this->M_pekerjakeluar->getProvinsi($provinsi);

		echo json_encode($data);
	}

	public function kabupatenPekerja(){

		$id_prov 	= $this->input->get('prov');
		$kabupaten 	= strtoupper($this->input->get('term'));
		$data 		= $this->M_pekerjakeluar->getKabupaten($kabupaten,$id_prov);

		echo json_encode($data);
	}

	public function kecamatanPekerja(){

		$id_kab 	= $this->input->get('kab');
		$kecamatan 	= strtoupper($this->input->get('term'));
		$data 		= $this->M_pekerjakeluar->getKecamatan($kecamatan,$id_kab);

		echo json_encode($data);
	}

	public function desaPekerja(){

		$id_kec 	= $this->input->get('kec');
		$desa 		= strtoupper($this->input->get('term'));
		$data 		= $this->M_pekerjakeluar->getDesa($desa,$id_kec);

		echo json_encode($data);
	}
};
