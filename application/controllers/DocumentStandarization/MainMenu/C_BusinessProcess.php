<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_BusinessProcess extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('Log_Activity');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('upload');
		$this->load->library('General');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('DocumentStandarization/MainMenu/M_businessprocess');
		$this->load->model('DocumentStandarization/MainMenu/M_general');

		$this->load->library('upload');

		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();

		define('direktoriUpload', './assets/upload/PengembanganSistem/StandarisasiDokumen/');
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	/* LIST DATA */
	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Business Process';
		$data['Menu'] = 'Upload Dokumen';
		$data['SubMenuOne'] = 'Business Process';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['BusinessProcess'] = $this->M_businessprocess->getBusinessProcess();

		$data['jumlahNotifikasi'] 	= 	0;

		$data['notifikasiRevisi']  		= 	$this->general->notifikasiRevisi('BP');
		if($data['notifikasiRevisi']!=null)
		{
			$data['jumlahNotifikasi'] += 1;
		}
		$data['notifikasiDokumenBaru']  =	$this->general->notifikasiDokumenBaru('BP');
		if($data['notifikasiDokumenBaru']!=null)
		{
			$data['jumlahNotifikasi'] += 1;
		}

		// echo $jumlahNotifikasi;
		// echo '<br/>';
		// echo '<pre>';
		// print_r($data['notifikasiRevisi']);
		// echo '</pre>';
		// echo '<br/>';
		// echo '<pre>';
		// print_r($data['notifikasiDokumenBaru']);
		// echo '</pre>';
		// exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/BusinessProcess/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Business Process';
		$data['Menu'] = 'Upload Dokumen';
		$data['SubMenuOne'] = 'Business Process';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);


		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('txtBpNameHeader', 'Nama Business Process', 'required');
		$this->form_validation->set_rules('txtNoKontrolHeader', 'Nomor Kontrol', 'required');
		$this->form_validation->set_rules('txtNoRevisiHeader', 'Nomor Revisi', 'required');
		$this->form_validation->set_rules('txtTanggalHeader', 'Tanggal Revisi', 'required');
		$this->form_validation->set_rules('txtJmlHalamanHeader', 'Jumlah Halaman', 'required');
		$this->form_validation->set_rules('cmbPekerjaDibuat', 'Pekerja Pembuat', 'required');
		// $this->form_validation->set_rules('cmbPekerjaDiperiksa1', 'Pekerja Pemeriksa 1', 'required');
		// $this->form_validation->set_rules('cmbPekerjaDiperiksa2', 'Pekerja Pemeriksa 2', 'required');
		$this->form_validation->set_rules('cmbPekerjaDiputuskan', 'Pekerja Pemberi Keputusan', 'required');

		if ($this->form_validation->run() === FALSE) {

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('DocumentStandarization/BusinessProcess/V_create', $data);
			$this->load->view('V_Footer',$data);
		} else {
			$namaBusinessProcess 	= 	strtoupper($this->input->post('txtBpNameHeader'));
			$nomorKontrol 			= 	strtoupper($this->input->post('txtNoKontrolHeader'));
			$nomorRevisi	  		= 	$this->input->post('txtNoRevisiHeader');
			$tanggalRevisi 			= 	$this->general->konversiTanggalkeDatabase(($this->input->post('txtTanggalHeader')),'tanggal');
			$jumlahHalaman 			= 	$this->input->post('txtJmlHalamanHeader');
			$info 					= 	$this->input->post('txaBpInfoHeader');
			$pekerjaDibuat 			= 	$this->input->post('cmbPekerjaDibuat');
			$pekerjaDiperiksa1 		= 	$this->input->post('cmbPekerjaDiperiksa1');
			$pekerjaDiperiksa2 		= 	$this->input->post('cmbPekerjaDiperiksa2');
			$pekerjaDiputuskan 		= 	$this->input->post('cmbPekerjaDiputuskan');
			$inputfile 				= 	'txtBpFileHeader';
			$namaDokumen			= 	str_replace(' ', '_', $nomorKontrol).'_-_'.$nomorRevisi.'_-_'.str_replace(' ','_',$namaBusinessProcess);
			$fileDokumen;
			$tanggalUpload;

			if($pekerjaDiperiksa1=='' OR $pekerjaDiperiksa1==NULL OR $pekerjaDiperiksa1==' ')
			{
				$pekerjaDiperiksa1=NULL;
			}

			if($pekerjaDiperiksa2=='' OR $pekerjaDiperiksa2==NULL OR $pekerjaDiperiksa2==' ')
			{
				$pekerjaDiperiksa2=NULL;
			}

			// echo 'sampai sini bisa';
			// exit();
			$fileDokumen 			= 	$this->general->uploadDokumen($inputfile, $namaDokumen, direktoriUpload);
			if(is_null($fileDokumen)==FALSE)
			{
				$tanggalUpload 		=  	$this->general->ambilWaktuEksekusi();
			}


			$data = array(
				'bp_name' 		=> $namaBusinessProcess,
				'bp_file' 		=> $fileDokumen,
				'no_kontrol' 	=> $nomorKontrol,
				'no_revisi' 	=> $nomorRevisi,
				'tanggal' 		=> $tanggalRevisi,
				'dibuat' 		=> $pekerjaDibuat,
				'diperiksa_1' 	=> $pekerjaDiperiksa1,
				'diperiksa_2' 	=> $pekerjaDiperiksa2,
				'diputuskan' 	=> $pekerjaDiputuskan,
				'jml_halaman' 	=> $jumlahHalaman,
				'bp_info' 		=> $info,
				'tgl_upload' 	=> $tanggalUpload,
				'tgl_insert' 	=> $this->general->ambilWaktuEksekusi(),
    		);

			$user_now 	= 	$this->session->user;

			$this->M_businessprocess->setBusinessProcess($data, $user);
			$header_id = $this->db->insert_id();
			//insert to sys.log_activity
			$aksi = 'DOC STANDARIZATION';
			$detail = "Set document BP id=$header_id";
			$this->log_activity->activity_log($aksi, $detail);
			//

			$this->M_general->inputNotifications('BP', $header_id, $user_now, $data, 'CREATE');

			redirect(site_url('DocumentStandarization/BP'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Business Process';
		$data['Menu'] = 'Upload Dokumen';
		$data['SubMenuOne'] = 'Business Process';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['BusinessProcess'] = $this->M_businessprocess->getBusinessProcess($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('txtBpNameHeader', 'Nama Business Process', 'required');
		$this->form_validation->set_rules('txtNoKontrolHeader', 'Nomor Kontrol', 'required');
		$this->form_validation->set_rules('txtNoRevisiHeader', 'Nomor Revisi', 'required');
		$this->form_validation->set_rules('txtTanggalHeader', 'Tanggal Revisi', 'required');
		$this->form_validation->set_rules('txtJmlHalamanHeader', 'Jumlah Halaman', 'required');
		$this->form_validation->set_rules('cmbPekerjaDibuat', 'Pekerja Pembuat', 'required');
		// $this->form_validation->set_rules('cmbPekerjaDiperiksa1', 'Pekerja Pemeriksa 1', 'required');
		$this->form_validation->set_rules('cmbPekerjaDiputuskan', 'Pekerja Pemberi Keputusan', 'required');

		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('DocumentStandarization/BusinessProcess/V_update', $data);
			$this->load->view('V_Footer',$data);
		}
		else
		{
			$namaBusinessProcess 	= 	strtoupper($this->input->post('txtBpNameHeader', TRUE));
			$nomorKontrol 			= 	strtoupper($this->input->post('txtNoKontrolHeader', TRUE));
			$nomorRevisi	  		= 	$this->input->post('txtNoRevisiHeader', TRUE);
			$tanggalRevisi 			= 	$this->general->konversiTanggalkeDatabase(($this->input->post('txtTanggalHeader', TRUE)),'tanggal');
			$jumlahHalaman 			= 	$this->input->post('txtJmlHalamanHeader', TRUE);
			$info 					= 	$this->input->post('txaBpInfoHeader', TRUE);
			$pekerjaDibuat 			= 	$this->input->post('cmbPekerjaDibuat', TRUE);
			$pekerjaDiperiksa1 		= 	$this->input->post('cmbPekerjaDiperiksa1', TRUE);
			$pekerjaDiperiksa2 		= 	$this->input->post('cmbPekerjaDiperiksa2', TRUE);
			$pekerjaDiputuskan 		= 	$this->input->post('cmbPekerjaDiputuskan', TRUE);
			$inputfile 				= 	'txtBpFileHeader';
			$fileDokumen			= 	$this->input->post('DokumenAwal', TRUE);
			$tanggalUpload			= 	$this->general->konversiTanggalkeDatabase(($this->input->post('WaktuUpload', TRUE)), 'datetime');
			$namaDokumen			= 	str_replace(' ', '_', $nomorKontrol).'_-_'.$nomorRevisi.'_-_'.str_replace(' ','_',$namaBusinessProcess);

			// Salin dari sini
			$revisiBaru 			= 	$this->input->post('checkboxRevisi');

			$nomorRevisiLama 		= 	$this->input->post('txtNoRevisiLamaHeader');
			$tanggalRevisiLama 		= 	$this->general->konversiTanggalkeDatabase(($this->input->post('txtTanggalLamaHeader')), 'tanggal');

			$angkaRevisiBaru 		= 	(int) $nomorRevisi;
			$angkaRevisiLama 		= 	(int) $nomorRevisiLama;

			if($fileDokumen=='')
			{
				$fileDokumen	=	NULL;
			}

			if($revisiBaru!=1)
			{
				$revisiBaru 		=	0;
			}

			if($revisiBaru==1 AND $angkaRevisiBaru>$angkaRevisiLama AND strtotime($tanggalRevisi)>strtotime($tanggalRevisiLama))
			{
				$kodeBusinessProcess 	= 	$plaintext_string;
				$dataLama 	= 	$this->M_businessprocess->ambilDataLama($kodeBusinessProcess);

				$doc_id 		= 	$dataLama[0]['bp_id'];
				$name 			= 	$dataLama[0]['bp_name'];
				$file 			= 	$dataLama[0]['bp_file'];
				$no_kontrol 	= 	$dataLama[0]['no_kontrol'];
				$no_revisi 		=	$dataLama[0]['no_revisi'];
				$tanggal 		= 	$dataLama[0]['tanggal'];
				$dibuat 		= 	$dataLama[0]['dibuat'];
				$diperiksa_1 	= 	$dataLama[0]['diperiksa_1'];
				$diperiksa_2 	= 	$dataLama[0]['diperiksa_2'];
				$diputuskan 	= 	$dataLama[0]['diputuskan'];
				$jml_halaman 	= 	$dataLama[0]['jml_halaman'];
				$info 			= 	$dataLama[0]['bp_info'];
				$tgl_upload 	= 	$dataLama[0]['tgl_upload'];
				$tgl_insert 	= 	$dataLama[0]['tgl_insert'];

				$jenis_doc 		= 	'BP';
				$tgl_update 	= 	$this->general->ambilWaktuEksekusi();

				if($diperiksa_1==NULL OR $diperiksa_1=='' OR $diperiksa_1==' ')
				{
					$diperiksa_1=NULL;
				}

				if($diperiksa_2==NULL OR $diperiksa_2=='' OR $diperiksa_2==' ')
				{
					$diperiksa_2=NULL;
				}

				if($info==NULL OR $info=='' OR $info==' ')
				{
					$info=NULL;
				}

				$recordLama 	= 	array(
											'doc_id'		=> 	$doc_id,
											'name' 			=> 	$name,
											'file' 			=> 	$file,
											'no_kontrol'	=>	$no_kontrol,
											'no_revisi'		=>	$no_revisi,
											'tanggal' 		=> 	$tanggal,
											'dibuat' 		=> 	$dibuat,
											'diperiksa_1' 	=>	$diperiksa_1,
											'diperiksa_2' 	=> 	$diperiksa_2,
											'diputuskan' 	=> 	$diputuskan,
											'jml_halaman' 	=> 	$jml_halaman,
											'info' 			=> 	$info,
											'tgl_upload' 	=> 	$tgl_upload,
											'tgl_insert' 	=> 	$tgl_insert,
											'jenis_doc' 	=> 	$jenis_doc,
											'tgl_update' 	=> 	$tgl_update
									);
				$this->M_businessprocess->inputDataLamakeHistory($recordLama);
			}
			// Salin sampai sini

			if($pekerjaDiperiksa1=='' OR $pekerjaDiperiksa1==NULL OR $pekerjaDiperiksa1==' ')
			{
				$pekerjaDiperiksa1=NULL;
			}

			if($pekerjaDiperiksa2=='' OR $pekerjaDiperiksa2==NULL OR $pekerjaDiperiksa2==' ')
			{
				$pekerjaDiperiksa2=NULL;
			}

			if($info=='' OR $info==NULL OR $info==' ')
			{
				$info=NULL;
			}

			// echo 'sampai sini bisa';
			// exit();
			$fileDokumen 			= 	$this->general->uploadDokumen($inputfile, $namaDokumen, direktoriUpload);
			if(!is_null($fileDokumen))
			{
				$tanggalUpload 		=  	$this->general->ambilWaktuEksekusi();

			}
			else
			{
				if(($revisiBaru==0 || $fileDokumen!=NULL) && $inputfile==NULL)
				{
					$fileDokumen = $this->general->cekFile($namaBusinessProcess, $nomorRevisi, $nomorKontrol, $fileDokumen, direktoriUpload);
				}
			}

			if($revisiBaru==0)
			{
				$data = array(
					'bp_name' 		=> $namaBusinessProcess,
					'bp_file' 		=> $fileDokumen,
					'no_kontrol' 	=> $nomorKontrol,
					'no_revisi' 	=> $nomorRevisi,
					'tanggal' 		=> $tanggalRevisi,
					'dibuat' 		=> $pekerjaDibuat,
					'diperiksa_1' 	=> $pekerjaDiperiksa1,
					'diperiksa_2' 	=> $pekerjaDiperiksa2,
					'diputuskan' 	=> $pekerjaDiputuskan,
					'jml_halaman' 	=> $jumlahHalaman,
					'bp_info' 		=> $info,
					'tgl_upload' 	=> $tanggalUpload,
	    		);
				$this->M_businessprocess->updateBusinessProcess($data, $plaintext_string);
	    	}
	    	elseif($revisiBaru==1)
	    	{
				$data = array(
					'bp_name' 				=> $namaBusinessProcess,
					'bp_file' 				=> $fileDokumen,
					'no_kontrol' 			=> $nomorKontrol,
					'no_revisi' 			=> $nomorRevisi,
					'tanggal' 				=> $tanggalRevisi,
					'dibuat' 				=> $pekerjaDibuat,
					'diperiksa_1' 			=> $pekerjaDiperiksa1,
					'diperiksa_2' 			=> $pekerjaDiperiksa2,
					'diputuskan' 			=> $pekerjaDiputuskan,
					'jml_halaman' 			=> $jumlahHalaman,
					'bp_info' 				=> $info,
					'update_revisi' 	=> $this->general->ambilWaktuEksekusi(),
					'tgl_upload' 			=> $tanggalUpload,
	    		);
				$this->M_businessprocess->updateBusinessProcess($data, $plaintext_string);
	    	}

			//insert to sys.log_activity
			$aksi = 'DOC STANDARIZATION';
			$detail = "Update document BP id=$plaintext_string";
			$this->log_activity->activity_log($aksi, $detail);
			//
			redirect(site_url('DocumentStandarization/BP'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Business Process';
		$data['Menu'] = 'Upload Dokumen';
		$data['SubMenuOne'] = 'Business Process';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);


		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['BusinessProcess'] = $this->M_businessprocess->getBusinessProcess($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/BusinessProcess/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_businessprocess->deleteBusinessProcess($plaintext_string);
		//insert to sys.log_activity
		$aksi = 'DOC STANDARIZATION';
		$detail = "Delete document BP id=$plaintext_string";
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect(site_url('DocumentStandarization/BP'));
    }



}

/* End of file C_BusinessProcess.php */
/* Location: ./application/controllers/DocumentStandarization/MainMenu/C_BusinessProcess.php */
/* Generated automatically on 2017-09-14 10:57:11 */
