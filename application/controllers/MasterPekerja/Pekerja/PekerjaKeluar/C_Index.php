<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Index extends CI_Controller {

 
	public function __construct()
    {
        parent::__construct();
		  
        $this->load->library('General');
        
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

	public function viewEdit()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$noind 			= $this->input->post('slc_Pekerja');
		$keluar 		= $this->input->post('rd_keluar');
		$pekerja 		= $this->M_pekerjakeluar->dataPekerja($noind,$keluar);
		if ($pekerja != null) {
			$kodesie 		= $pekerja[0]['kodesie'];
			$seksi 			= $this->M_pekerjakeluar->dataSeksi($kodesie);

			$data['data'] 	= array(
									'photo' 	=> $pekerja[0]['photo'],
									'noind' 	=> $pekerja[0]['noind'],
									'nama' 		=> $pekerja[0]['nama'],
									'templahir' => $pekerja[0]['templahir'],
									'tgllahir' 	=> $pekerja[0]['tgllahir'],
									'nik' 		=> $pekerja[0]['nik'],
									'alamat' 	=> $pekerja[0]['alamat'],
									'desa' 		=> $pekerja[0]['desa'],
									'kec' 		=> $pekerja[0]['kec'],
									'kab' 		=> $pekerja[0]['kab'],
									'prop' 		=> $pekerja[0]['prop'],
									'kodepos' 	=> $pekerja[0]['kodepos'],
									'telepon' 	=> $pekerja[0]['telepon'],
									'nohp' 		=> $pekerja[0]['nohp'],
									'diangkat' 	=> $pekerja[0]['diangkat'],
									'masukkerja'=> $pekerja[0]['masukkerja'],
									'lmkontrak' => $pekerja[0]['lmkontrak'],
									'akhkontrak'=> $pekerja[0]['akhkontrak'],
									'jabatan' 	=> $pekerja[0]['jabatan'],
									'seksi' 	=> $seksi[0]['seksi'],
									'unit' 		=> $seksi[0]['unit'],
									'bidang' 	=> $seksi[0]['bidang'],
									'dept' 		=> $seksi[0]['dept'],
									'tglkeluar' => $pekerja[0]['tglkeluar'],
									'sebabklr' 	=> $pekerja[0]['sebabklr'],
								);
			
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
							);
		// echo "<pre>";
		// print_r($data);
		// exit();
		$this->M_pekerjakeluar->updateDataPekerja($data,$noind);
		$history 	= array(
							'noind' 		=> $this->input->post('txt_noindukLama'),
							'aktifitas' 	=> 'UPDATE',
							'date_time' 	=> date('Y-m-d H:i:s'),
							'last_updated_by'=> $this->session->user,
						);
		$this->M_pekerjakeluar->historyUpdatePekerja($history);
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
							);
		// echo "<pre>";
		// print_r($data);
		// exit();
		$this->M_pekerjakeluar->updateDataPekerja($data,$noind);
		$history 	= array(
							'noind' 		=> $this->input->post('txt_noindukLama'),
							'aktifitas' 	=> 'UPDATE',
							'date_time' 	=> date('Y-m-d H:i:s'),
							'last_update_by'=> $this->session->user,
						);
		$this->M_pekerjakeluar->historyUpdatePekerja($history);
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