<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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

	    $data['editHitungPesangon'] = $this->M_pesangon->editHitungPesangon($id);
		$hari_terakhir = date('D', strtotime($data['editHitungPesangon'][0]['tglkeluar']));
		$data['hari_terakhir'] = $this->konversibulan->convertke_Hari_Indonesia($hari_terakhir);
		$hari_proses = date('D', strtotime($data['editHitungPesangon'][0]['proses_phk']));
		$data['hari_proses'] = $this->konversibulan->convertke_Hari_Indonesia($hari_proses);

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
		if (!empty($detailPekerja)) {
			$hariTerakhir 		= array_merge($detailPekerja, array('hari_terakhir'=>date('D', strtotime($detailPekerja[0]['metu']))));
			echo json_encode($hariTerakhir);
		}else{
			echo "Data Kosong";
		}
  	}

	public function add()
	{
		$noind 		     			=	$this->input->post('txtNoind');
		$jabatan_terakhir 			=	$this->input->post('txtJabatan');
		$masa_kerja_tahun 			=	$this->input->post('txtTahun');
		$masa_kerja_bulan 			=	$this->input->post('txtBulan');
		$masa_kerja_hari 			=	$this->input->post('txtHari');
		$pasal_pengali_pesangon 	=	$this->input->post('txtPasal');
		$jml_pesangon 				=	$this->input->post('txtPesangon');
		$jml_upmk 	   	    		=	$this->input->post('txtUPMK');
		$jml_cuti 	    			=	$this->input->post('txtCuti');
		$uang_ganti_kerugian 		=	$this->input->post('txtRugi');
		$hutang_koperasi 			=	$this->input->post('txtHutangKoperasi');
		$hutang_perusahaan 			=	$this->input->post('txtHutangPerusahaan');
		$lain_lain 					=	$this->input->post('txtLainLain');
		$no_rekening 				=	$this->input->post('txtNomorRekening');
		$nama_rekening 				=	$this->input->post('txtNamaRekening');
		$bank 						=	$this->input->post('txtBank');
		$approver1 					=	'Agus Nugroho';
		$approver2 					=	'Bambang Yudhosuseno';
		$created_by 				=	$this->session->user;
		$penerima 				    =	$this->input->post('txtPenerima');
		$pengirim 					=	$this->input->post('txtPengirim');
		$tgl_proses 				=	$this->input->post('txtProses');
		$akhir 						= date('Y-m-d', strtotime($tgl_proses));

		$inputHitungPesangon		= 	array
									(
										'noinduk'				    =>	$noind,
										'jabatan_terakhir'	    	=>	$jabatan_terakhir,
										'masa_kerja_tahun'  		=>  $masa_kerja_tahun,
										'masa_kerja_bulan'      	=>  $masa_kerja_bulan,
										'masa_kerja_hari' 	    	=>  $masa_kerja_hari,
										'pasal_pengali_pesangon' 	=>  $pasal_pengali_pesangon,
										'jml_pesangon' 	        	=>  $jml_pesangon,
										'jml_upmk' 	            	=>  $jml_upmk,
									    'jml_cuti'              	=>	$jml_cuti,
									    'uang_ganti_kerugian'		=>	$uang_ganti_kerugian,
									    'hutang_koperasi'			=>	$hutang_koperasi,
									    'hutang_perusahaan'			=>	$hutang_perusahaan,
									    'lain_lain'					=>	$lain_lain,
									    'no_rekening'				=>  $no_rekening,
									    'nama_rekening'				=>  $nama_rekening,
									    'bank'                  	=>  $bank,
									    'approver1'             	=>  $approver1,
									    'approver2'             	=>  $approver2,
									    'created_by'            	=>  $created_by,
									    'penerima'              	=>  $penerima,
									    'pengirim'              	=>  $pengirim,
									    'tgl_proses_phk'            =>  $akhir
									);

		$this->M_pesangon->inputHitungPesangon($inputHitungPesangon);
		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Add Data Pesangon Noind='.$noind;
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect('MasterPekerja/PerhitunganPesangon');

	}


	public function edit($id)
	{
		$id 	=	str_replace(array('-', '_', '~'), array('+', '/', '='),$id);
		$id 	=	$this->encrypt->decode($id);

		$jabatan_terakhir 			=	$this->input->post('txtJabatan');
		$potongan 					=	$this->input->post('txtPotongan');
		$hutang_koperasi 			=	$this->input->post('txtHutangKoperasi');
		$hutang_perusahaan 			=	$this->input->post('txtHutangPerusahaan');
		$lain_lain 					=	$this->input->post('txtLainLain');
		$no_rekening 				=	$this->input->post('txtNomorRekening');
		$nama_rekening 				=	$this->input->post('txtNamaRekening');
		$bank 						=	$this->input->post('txtBank');
		$edit_by                    =	$this->session->user;
		$edit_date                  =	date(' M,d,y');
		$tgl_proses					= 	$this->input->post('txtProses');
		$akhir 						= 	date('Y-m-d', strtotime($tgl_proses));

		$updateHitungPesangon			= 	array
										(

											'jabatan_terakhir'	=>	$jabatan_terakhir,
										    'potongan'			=>  $potongan,
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

			$data['dataPreview'] 	= $this->M_pesangon->cetak($id);
			echo json_encode($data);
		}

		public function previewcetak()
		{
			$id = $this->input->post('id_prev_sangu');
			$data['data'] 		= $this->M_pesangon->cetak($id);
			$data['penerima'] 	= $this->M_pesangon->penerima($id);
			$app1 = $this->input->post('Psg_approver1');
			$app2 = $this->input->post('Psg_approver2');
			$tgl = $this->input->post('psg_tglCetak');

			$data['approver1'] 	= $this->M_pesangon->getdataNama($app1);
	      	$data['approver2'] 	= $this->M_pesangon->getdataNama($app2);
			$data['tglCetak']	= explode('-', $tgl);

			if ($data['data'][0]['tgl_cetak_prev'] == null) {
				$updateDate = $this->M_pesangon->UpdateDate($id, $tgl);
			}

			$this->load->library('pdf');

			$pdf = $this->pdf->load();
			$pdf = new mPDF('','Legal',0,'',10,5,5,5,0,0);
			$filename = 'PerhitunganPesangon.pdf';


			$html = $this->load->view('MasterPekerja/PerhitunganPesangon/V_Cetak', $data, true);

			$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
			$pdf->WriteHTML($stylesheet1,1);
			$pdf->WriteHTML($html, 2);
		    $pdf->setTitle($filename);
			$pdf->Output($filename, 'I');
	   }

		 public function getPDF()
		 {
			 $id 	 				= $this->input->post('id_sangu');
			 //insert to t_log
	 		$aksi = 'MASTER PEKERJA';
	 		$detail = 'Cetak PDF Pesangon ID='.$id;
	 		$this->log_activity->activity_log($aksi, $detail);
	 		//
			 $data['personalia'] 	= $this->input->post('Wakil_Personalia');
			 $data['spsi'] 			= $this->input->post('Wakil_SPSI');
			 $data['saksi1'] 		= $this->input->post('Saksi_Janji1');
			 $data['saksi2'] 		= $this->input->post('Saksi_Janji2');

			 $data['pekerjaPHK'] 	= $this->M_pesangon->getPekerjaPHK($id);
			 $tgl_keluar 			= $data['pekerjaPHK'];
			 $alasan 				= $this->M_pesangon->getAlasanKeluar($tgl_keluar[0]['noind']);
			 $data['tgl_keluar'] 	= date("d", strtotime($tgl_keluar[0]['tanggal_keluar']));
			 $data['bln_keluar'] 	= date("m", strtotime($tgl_keluar[0]['tanggal_keluar']));
			 $data['thn_keluar'] 	= date("Y", strtotime($tgl_keluar[0]['tanggal_keluar']));

			 $propinsi = rtrim($tgl_keluar[0]['prop']);
			 if ($propinsi == 'DI YOGYAKARTA') {
			 	$prop = explode(' ', $tgl_keluar[0]['prop']);
				$data['provinsi'] = $prop[0].' '.ucwords(strtolower($prop[1]));
			}else {
				$data['provinsi'] = ucwords(strtolower($propinsi));
			}

			 $jenkel = trim($data['pekerjaPHK'][0]['jenkel']);
			 if ($jenkel == 'L') {
				 	$data['jenis'] = 'Sdr. ';
				}elseif ($jenkel == 'P') {
					$data['jenis'] = 'Sdri. ';
				}

		   $hari  = date('D');
			 $hariarr = array(
				 '',
				 'Senin' ,
				 'Selasa',
				 'Rabu'  ,
				 'Kamis' ,
				 'Jumat' ,
				 'Sabtu' ,
				 'Minggu',
			 );
			 if ($hari == 'Mon') {
				 	$data['hari'] = $hariarr[1];
				}elseif ($hari == 'Tue') {
					$data['hari'] = $hariarr[2];
				}elseif ($hari == 'Wed') {
					$data['hari'] = $hariarr[3];
				}elseif ($hari == 'Thu') {
					$data['hari'] = $hariarr[4];
				}elseif ($hari == 'Fri') {
					$data['hari'] = $hariarr[5];
				}elseif ($hari == 'Sat') {
					$data['hari'] = $hariarr[6];
				}elseif ($hari == 'Sun') {
					$data['hari'] = $hariarr[7];
				}

				$month = date('m');
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
				if ($month == '01') {
					$data['month'] = $bulan[1];
				}elseif ($month == '02') {
					$data['month'] = $bulan[2];
				}elseif ($month == '03') {
					$data['month'] = $bulan[3];
				}elseif ($month == '04') {
					$data['month'] = $bulan[4];
				}elseif ($month == '05') {
					$data['month'] = $bulan[5];
				}elseif ($month == '06') {
					$data['month'] = $bulan[6];
				}elseif ($month == '07') {
					$data['month'] = $bulan[7];
				}elseif ($month == '08') {
					$data['month'] = $bulan[8];
				}elseif ($month == '09') {
					$data['month'] = $bulan[9];
				}elseif ($month == '10') {
					$data['month'] = $bulan[10];
				}elseif ($month == '11') {
					$data['month'] = $bulan[11];
				}elseif ($month == '12') {
					$data['month'] = $bulan[12];
				}

				if ($data['bln_keluar'] == '01') {
					$data['bln_keluar'] = $bulan[1];
				}elseif ($data['bln_keluar'] == '02') {
					$data['bln_keluar'] = $bulan[2];
				}elseif ($data['bln_keluar'] == '03') {
					$data['bln_keluar'] = $bulan[3];
				}elseif ($data['bln_keluar'] == '04') {
					$data['bln_keluar'] = $bulan[4];
				}elseif ($data['bln_keluar'] == '05') {
					$data['bln_keluar'] = $bulan[5];
				}elseif ($data['bln_keluar'] == '06') {
					$data['bln_keluar'] = $bulan[6];
				}elseif ($data['bln_keluar'] == '07') {
					$data['bln_keluar'] = $bulan[7];
				}elseif ($data['bln_keluar'] == '08') {
					$data['bln_keluar'] = $bulan[8];
				}elseif ($data['bln_keluar'] == '09') {
					$data['bln_keluar'] = $bulan[9];
				}elseif ($data['bln_keluar'] == '10') {
					$data['bln_keluar'] = $bulan[10];
				}elseif ($data['bln_keluar'] == '11') {
					$data['bln_keluar'] = $bulan[11];
				}elseif ($data['bln_keluar'] == '12') {
					$data['bln_keluar'] = $bulan[12];
				}

 			 $this->load->library('pdf');

 			 $pdf = $this->pdf->load();
 			 $pdf = new mPDF('P','A4',0,'',10,10,10,10,0,0);
 			 $date = date('Y-m-d H:i:s');
			 if($alasan == "PUTUS HUBUNGAN KERJA KARENA USIA LANJUT"){
				 $filename = 'Perjanjian Bersama Usia Lanjut '.$date.'.pdf';
				 $html = $this->M_pesangon->getTemplateSurat('PESANGON - PERJANJIAN BERSAMA USIA LANJUT');
			 }elseif($alasan == 'PUTUS HUBUNGAN KERJA KARENA PENSIUN DIPERCEPAT'){
				 $filename = 'Perjanjian Bersama Usia Lanjut Dipercepat '.$date.'.pdf';
				 $html = $this->M_pesangon->getTemplateSurat('PESANGON - PERJANJIAN BERSAMA USIA LANJUT DIPERCEPAT');
			 }elseif($alasan == 'PUTUS HUBUNGAN KERJA KARENA NON USIA LANJUT'){
				 $filename = 'Perjanjian Bersama Non Usia Lanjut '.$date.'.pdf';
				 $html = $this->M_pesangon->getTemplateSurat('PESANGON - PERJANJIAN BERSAMA NON USIA LANJUT');
			 }else{
			 	$filename = 'Perjanjian Bersama meninggal dunia '.$date.'.pdf';
				 $html = $this->M_pesangon->getTemplateSurat('PESANGON - PERJANJIAN BERSAMA MENINGGAL DUNIA');
			 }
			 $alamat = ucwords(strtolower($data['pekerjaPHK'][0]['alamat'])).', '.ucwords(strtolower($data['pekerjaPHK'][0]['desa'])).', '.ucwords(strtolower($data['pekerjaPHK'][0]['kec'])).', '.ucwords(strtolower($data['pekerjaPHK'][0]['kab'])).', '.$data['provinsi'];
			 $html = str_replace("[nama_pekerja]", ucwords(strtolower($data['pekerjaPHK'][0]['nama'])), $html);
			 $html = str_replace("[noind_pekerja]", $data['pekerjaPHK'][0]['noind'], $html);
			 $html = str_replace("[seksi_pekerja]", ucwords(strtolower($data['pekerjaPHK'][0]['seksi'])), $html);
			 $html = str_replace("[unit_pekerja]", ucwords(strtolower($data['pekerjaPHK'][0]['unit'])), $html);
			 $html = str_replace("[dept_pekerja]", ucwords(strtolower($data['pekerjaPHK'][0]['dept'])), $html);
			 $html = str_replace("[hari]", $data['hari'], $html);
			 $html = str_replace("[tanggal]", date('d'), $html);
			 $html = str_replace("[bulan]", $data['month'], $html);
			 $html = str_replace("[tahun]", date('Y'), $html);
			 $html = str_replace("[nama_wakilperusahaan]", ucwords(strtolower($data['personalia'])), $html);
			 $html = str_replace("[nama_wakilserikatkerja]", ucwords(strtolower($data['spsi'])), $html);
			 $html = str_replace("[nama_wakilseksi1]", ucwords(strtolower($data['saksi1'])), $html);
			 $html = str_replace("[nama_wakilseksi2]", ucwords(strtolower($data['saksi2'])), $html);
			 $html = str_replace("[panggilan_pekerja]", $data['jenis'], $html);
			 $html = str_replace("[alamat_pekerja]", $alamat, $html);
			 $html = str_replace("[tanggal_akhir_hubungan_kerja]", $data['tgl_keluar']." ".$data['bln_keluar']." ".$data['thn_keluar'], $html);

 			 $stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
 			 $pdf->WriteHTML($stylesheet1,1);
 			 $pdf->WriteHTML($html, 2);
 	     	$pdf->setTitle($filename);
 			 $pdf->Output($filename, 'I');
		 }



}
