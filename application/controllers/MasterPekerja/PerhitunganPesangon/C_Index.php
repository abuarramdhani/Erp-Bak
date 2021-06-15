<?php
defined('BASEPATH') OR exit('No direct script access allowed');

set_time_limit(0);

class C_Index extends CI_Controller {


	public function __construct()
  	{
		parent::__construct();

		$this->load->library('Log_Activity');
		$this->load->library('KonversiBulan');
		$this->load->library('General');
		$this->load->library('encrypt');
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPekerja/PerhitunganPesangon/M_pesangon');

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

	public function checkSession()
	{
		if($this->session->is_logged){

		}else{
			redirect('');
		}
	}

	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Title']	= 'Perhitungan Pesangon';
		$data['Menu'] = 'Cetak';
		$data['SubMenuOne'] = 'Perhitungan Pesangon';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_pesangon->lihat();
		$data['tertanda'] = $this->M_pesangon->getTertandaKasbon();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/PerhitunganPesangon/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	function hitungMasaKerja($awal,$akhir){
		$tahun 	= 0;
		$tahun1 = 0;
		$bulan 	= 0;
		$bulan1 = 0;
		$hari 	= 0;
		$year_awal 	= intval(date('Y',strtotime($awal)));
		$month_awal	= intval(date('m',strtotime($awal)));
		$day_awal 	= intval(date('d',strtotime($awal)));
		$year_akhir = intval(date('Y',strtotime($akhir)));
		$month_akhir= intval(date('m',strtotime($akhir)));
		$day_akhir 	= intval(date('d',strtotime($akhir)));
		if ($day_akhir - $day_awal < 0) {
			if ($month_akhir == 3) {
				if ($year_akhir%4 == 0) {
					$hari = $day_akhir + 29 - $day_awal;
				}else{
					$hari = $day_akhir + 28 - $day_awal;
				}
			}else{
				if (in_array($month_akhir, array(5,7,10,12))) {
					$hari = $day_akhir + 30 - $day_awal;
				}else{
					$hari = $day_akhir + 31 - $day_awal;
				}
			}
			$bulan1 = $month_akhir - 1;
		}else{
			$hari = $day_akhir - $day_awal;
			$bulan1 = $month_akhir;
		}
		if ($bulan1 -  $month_awal < 0) {
			$bulan = $bulan1 + 12 - $month_awal;
			$tahun1 = $year_akhir - 1;
		}else{
			$bulan = $bulan1 - $month_awal;
			$tahun1 = $year_akhir;
		}
		if ($year_awal <= 1900) {
			$tahun = 0;
		}else{
			$tahun = $tahun1 - $year_awal;
		}
		return array(
			'tahun' => $tahun,
			'bulan' => $bulan,
			'hari' 	=> $hari
		);
	}

	public function getDetailPekerja()
	{
		$noind 	= $this->input->get('noind');
		$cuti 	= $this->input->get('cuti');

		$data = $this->M_pesangon->getDetailPekerja($noind);
		if (!empty($data)) {
			$data->masa_kerja = $this->hitungMasaKerja($data->diangkat,$data->tglkeluar);
			$data->sisa_cuti = $this->M_pesangon->getSisaCuti($noind);
			$data->banyak_gp = $this->M_pesangon->getSetupPesangon($data->masa_kerja['tahun']);
			// echo "<pre>";print_r($data);exit();
			echo json_encode($data);
		}else{
			echo "Data Kosong";
		}

	}

	public function create()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

	  	$data['Title']	= 'Perhitungan Pesangon';
	  	$data['Menu'] = 'Cetak';
	  	$data['SubMenuOne'] = 'Perhitungan Pesangon';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/PerhitunganPesangon/V_Create',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update($encrypt_id)
	{
		$id	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $encrypt_id);
		$id	=	$this->encrypt->decode($id);
		$this->checkSession();
		$user_id = $this->session->userid;

	  	$data['Title']	= 'Perhitungan Pesangon';
	  	$data['Menu'] = 'Cetak';
	  	$data['SubMenuOne'] = 'Perhitungan Pesangon';
		$data['SubMenuTwo'] = '';
		$data['id']			=	$encrypt_id;

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

	    $data['pesangon'] = $this->M_pesangon->getPesangonById($id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/PerhitunganPesangon/V_Update',$data);
		$this->load->view('V_Footer',$data);
	}

	public function daftar_pekerja_aktif(){
	  	$noind = $this->input->get('term');
	  	$data = $this->M_pesangon->getPekerjaAktif(strtoupper($noind));
	  	echo json_encode($data);
	}

 	public function detailPekerja()
	{
		$noind 				=	$this->input->post('noind');
		$cuti 				=	$this->input->post('cuti');
		
		$detailPekerja 		=	$this->M_pesangon->detailPekerja($noind,$cuti);
		echo json_encode($hariTerakhir);
  	}

	public function add()
	{
		// echo "<pre>";print_r($_POST);exit();
		$noind 		     	=	$this->input->post('txtNoind');
		$jabatan_terakhir 	=	$this->input->post('txtJabatan');
		$masa_kerja_tahun 	=	$this->input->post('txtTahun');
		$masa_kerja_bulan 	=	$this->input->post('txtBulan');
		$masa_kerja_hari 	=	$this->input->post('txtHari');
		$pengali_pesangon 	=	$this->input->post('txtPengaliUPesangon');
		$jml_pesangon 		=	$this->input->post('txtPesangon');
		$jml_upmk 	   	    =	$this->input->post('txtUPMK');
		$pengali_upmk 	   	=	$this->input->post('txtPengaliUPMK');
		$jml_cuti 	    	=	$this->input->post('txtCuti');
		$hutang_koperasi 	=	$this->input->post('txtHutangKoperasi');
		$hutang_perusahaan 	=	$this->input->post('txtHutangPerusahaan');
		$lain_lain 			=	$this->input->post('txtLainLain');
		$no_rekening 		=	$this->input->post('txtNomorRekening');
		$nama_rekening 		=	$this->input->post('txtNamaRekening');
		$bank 				=	$this->input->post('txtBank');
		$penerima 			=	$this->input->post('txtPenerima');
		$pengirim 			=	$this->input->post('txtPengirim');
		$tgl_proses 		=	$this->input->post('txtProses');
		$sebab_keluar 		=	$this->input->post('txtStatus');
		$dasar_hukum 		=	$this->input->post('txtHukum');
		$approver1 			=	'Agus Nugroho';
		$approver2 			=	'Bambang Yudhosuseno';
		$created_by 		=	$this->session->user;
		$akhir 				= 	date('Y-m-d', strtotime($tgl_proses));

		$inputHitungPesangon = 	array(
			'noinduk'				=>	$noind,
			'jabatan_terakhir'	    =>	$jabatan_terakhir,
			'masa_kerja_tahun'  	=>  $masa_kerja_tahun,
			'masa_kerja_bulan'      =>  $masa_kerja_bulan,
			'masa_kerja_hari' 	    =>  $masa_kerja_hari,
			'jml_pesangon' 	        =>  $jml_pesangon,
			'pengali_u_pesangon' 	=>  $pengali_pesangon,
			'jml_upmk' 	            =>  $jml_upmk,
			'pengali_upmk' 	        =>  $pengali_upmk,
		    'jml_cuti'              =>	$jml_cuti,
		    'hutang_koperasi'		=>	$hutang_koperasi,
		    'hutang_perusahaan'		=>	$hutang_perusahaan,
		    'lain_lain'				=>	$lain_lain,
		    'no_rekening'			=>  $no_rekening,
		    'nama_rekening'			=>  $nama_rekening,
		    'bank'                  =>  $bank,
		    'approver1'             =>  $approver1,
		    'approver2'             =>  $approver2,
		    'created_by'            =>  $created_by,
		    'penerima'              =>  $penerima,
		    'pengirim'              =>  $pengirim,
		    'tgl_proses_phk'        =>  $akhir,
		    'sebab_keluar'			=>	$sebab_keluar,
		    'dasar_hukum' 			=>	$dasar_hukum
		);

		$this->M_pesangon->inputHitungPesangon($inputHitungPesangon);
		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Add Data Pesangon Noind='.$noind;
		$this->log_activity->activity_log($aksi, $detail);
		
		redirect('MasterPekerja/PerhitunganPesangon');

	}


	public function edit($id)
	{
		$id 	=	str_replace(array('-', '_', '~'), array('+', '/', '='),$id);
		$id 	=	$this->encrypt->decode($id);
		 // echo "<pre>";print_r($_POST);exit();
		$jabatan_terakhir 			=	$this->input->post('txtJabatan');
		$hutang_koperasi 			=	$this->input->post('txtHutangKoperasi');
		$hutang_perusahaan 			=	$this->input->post('txtHutangPerusahaan');
		$lain_lain 					=	$this->input->post('txtLainLain');
		$no_rekening 				=	$this->input->post('txtNomorRekening');
		$nama_rekening 				=	$this->input->post('txtNamaRekening');
		$bank 						=	$this->input->post('txtBank');
		$edit_by                    =	$this->session->user;
		$edit_date                  =	date('Y-m-d');
		$tgl_proses					= 	$this->input->post('txtProses');
		$akhir 						= 	date('Y-m-d', strtotime($tgl_proses));

		$updateHitungPesangon = array(
			'jabatan_terakhir'	=>	$jabatan_terakhir,
		    'hutang_koperasi'	=>	$hutang_koperasi,
		    'hutang_perusahaan'	=>	$hutang_perusahaan,
		    'lain_lain'			=>	$lain_lain,
		    'no_rekening'		=>  $no_rekening,
		    'nama_rekening'		=>  $nama_rekening,
		    'bank'              =>  $bank,
		    'edit_by'           =>  $edit_by,
		    'edit_date'         =>  $edit_date,
		    'tgl_proses_phk'    =>  $akhir
		);
		$this->M_pesangon->update($id,$updateHitungPesangon);
		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Update Data Pesangon ID='.$id;
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect('MasterPekerja/PerhitunganPesangon');
	}

			public function delete($id)
		{
			$id	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
			$id	=	$this->encrypt->decode($id);
			$this->M_pesangon->delete($id);
			//insert to t_log
			$aksi = 'MASTER PEKERJA';
			$detail = 'Delete Data Pesangon ID='.$id;
			$this->log_activity->activity_log($aksi, $detail);
			//

			redirect('MasterPekerja/PerhitunganPesangon');

		}

		public function getDataPreview($encrypt_id)
		{
			$id	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $encrypt_id);
			$id	=	$this->encrypt->decode($id);

			$data = $this->M_pesangon->getPesangonById($id);
			echo json_encode($data);
		}

		public function previewcetak()
		{
			$id = $this->input->post('id_prev_sangu');
			$app1 = $this->input->post('Psg_approver1');
			$app2 = $this->input->post('Psg_approver2');
			$tgl = $this->input->post('psg_tglCetak');

			$data['data'] 		= $this->M_pesangon->getPesangonById($id);
			$data['penerima'] 	= $this->M_pesangon->penerima($id);
			$data['approver1'] 	= $this->M_pesangon->getdataNama($app1);
	      	$data['approver2'] 	= $this->M_pesangon->getdataNama($app2);
			$data['tglCetak']	= $tgl;

			if ($data['data']->tgl_cetak_prev == null) {
				$updateDate = $this->M_pesangon->UpdateDate($id, $tgl);
			}

			$this->load->library('pdf');

			$pdf = $this->pdf->load();
			$pdf = new mPDF('','Legal',0,'',10,5,5,5,0,0);
			$filename = 'PerhitunganPesangon.pdf';

			// $this->load->view('MasterPekerja/PerhitunganPesangon/V_Cetak', $data);
			$html = $this->load->view('MasterPekerja/PerhitunganPesangon/V_Cetak', $data, true);

			$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
			$pdf->WriteHTML($stylesheet1,1);
			$pdf->WriteHTML($html, 2);
		    $pdf->setTitle($filename);
			$pdf->Output($filename, 'I');
	   }

	public function getPDF()
	{
		$id = $this->input->post('id_sangu');
		 //insert to t_log
 		$aksi 	= 'MASTER PEKERJA';
 		$detail = 'Cetak PDF Pesangon ID='.$id;
 		$this->log_activity->activity_log($aksi, $detail);
 		
		$wakil_personalia	= $this->input->post('Wakil_Personalia');
		$wakil_spsi 		= $this->input->post('Wakil_SPSI');
		$saksi1			 	= $this->input->post('Saksi_Janji1');
		$saksi2			 	= $this->input->post('Saksi_Janji2');

		$pesangon 	= $this->M_pesangon->getPesangonById($id);
		if (empty($pesangon)) {
			exit("Data Perhitungan Pesangon Tidak Ditemukan");
		}
		// $data['pekerjaPHK'] 	= $this->M_pesangon->getPekerjaPHK($id);
		// $tgl_keluar 			= $data['pekerjaPHK'];
		// $alasan 				= $this->M_pesangon->getAlasanKeluar($tgl_keluar[0]['noind']);
		//  $data['tgl_keluar'] 	= date("d", strtotime($tgl_keluar[0]['tanggal_keluar']));
		//  $data['bln_keluar'] 	= date("m", strtotime($tgl_keluar[0]['tanggal_keluar']));
		//  $data['thn_keluar'] 	= date("Y", strtotime($tgl_keluar[0]['tanggal_keluar']));

		if ($pesangon->prop == 'DI YOGYAKARTA' || $pesangon->prop == "DKI JAKARTA") {
		 	$prop = explode(' ', $pesangon->prop);
			$pesangon->prop = $prop[0].' '.ucwords(strtolower($prop[1]));
		}else {
			$pesangon->prop = ucwords(strtolower($propinsi));
		}

		$jenkel = trim($pesangon->jenkel);
		if ($jenkel == 'L') {
		 	$jenis = 'Sdr. ';
		}elseif ($jenkel == 'P') {
			$jenis = 'Sdri. ';
		}else{
			$jenis = "Sdr/i.";
		}

		$hariarr = array(
			'Minggu',
			'Senin' ,
			'Selasa',
			'Rabu'  ,
			'Kamis' ,
			'Jumat' ,
			'Sabtu' ,
		);
	 	$hari  = $hariarr[date('w')];

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
		$month = $bulan[intval(date('m'))];
		$month_tglkeluar = $bulan[intval(date('m',strtotime($pesangon->tglkeluar)))];

		$this->load->library('pdf');

		$pdf = $this->pdf->load();
		$pdf = new mPDF('P','A4',0,'',10,10,10,10,0,0);
		$date = date('Y-m-d H:i:s');
		// echo $pesangon->sebab_keluar;exit();
		if($pesangon->sebab_keluar == "Pekerja memasuki usia pensiun"){
			$filename = 'Perjanjian Bersama Usia Lanjut '.$date.'.pdf';
			$html = $this->M_pesangon->getTemplateSurat('PESANGON - PERJANJIAN BERSAMA USIA LANJUT');
		}else{
			$filename = 'Perjanjian Bersama Non Usia Lanjut '.$date.'.pdf';
			$html = $this->M_pesangon->getTemplateSurat('PESANGON - PERJANJIAN BERSAMA NON USIA LANJUT');
		}
		$alamat = ucwords(strtolower($pesangon->alamat)).', '.ucwords(strtolower($pesangon->kel)).', '.ucwords(strtolower($pesangon->kec)).', '.ucwords(strtolower($pesangon->kab)).', '.$pesangon->prop;
		$html = str_replace("[nama_pekerja]", ucwords(strtolower($pesangon->nama)), $html);
		$html = str_replace("[noind_pekerja]", $pesangon->noind, $html);
		$html = str_replace("[seksi_pekerja]", ucwords(strtolower($pesangon->seksi)), $html);
		$html = str_replace("[unit_pekerja]", ucwords(strtolower($pesangon->unit)), $html);
		$html = str_replace("[dept_pekerja]", ucwords(strtolower($pesangon->dept)), $html);
		$html = str_replace("[hari]", $hari, $html);
		$html = str_replace("[tanggal]", date('d'), $html);
		$html = str_replace("[bulan]", $month, $html);
		$html = str_replace("[tahun]", date('Y'), $html);
		$html = str_replace("[nama_wakilperusahaan]", ucwords(strtolower($wakil_personalia)), $html);
		$html = str_replace("[nama_wakilserikatkerja]", ucwords(strtolower($wakil_spsi)), $html);
		$html = str_replace("[nama_wakilseksi1]", ucwords(strtolower($saksi1)), $html);
		$html = str_replace("[nama_wakilseksi2]", ucwords(strtolower($saksi2)), $html);
		$html = str_replace("[panggilan_pekerja]", $jenis, $html);
		$html = str_replace("[alamat_pekerja]", $alamat, $html);
		$html = str_replace("[dasar_hukum_phk]", $pesangon->dasar_hukum, $html);
		$html = str_replace("[isi_dasar_hukum_phk]", $pesangon->sebab_keluar, $html);
		$html = str_replace("[tanggal_akhir_hubungan_kerja]", date('d',strtotime($pesangon->tglkeluar))." ".$month_tglkeluar." ".date('Y',strtotime($pesangon->tglkeluar)), $html);
		$html = str_replace("font-size: 14px;", "font-size: 10pt;", $html);
		$html = str_replace("font-size: 18px;", "font-size: 10pt;", $html);
		$html = str_replace("font-size: 15px;", "font-size: 10pt;", $html);
		$html = str_replace("height: 15px;", "height: 10px;", $html);
		$html = "<div style='page-break-inside: avoid;'>$html</div>";
		$pdf->WriteHTML($html, 2);
     	$pdf->setTitle($filename);
		$pdf->Output($filename, 'I');
	}

}
