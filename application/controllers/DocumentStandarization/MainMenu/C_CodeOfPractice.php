<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_CodeOfPractice extends CI_Controller
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
		$this->load->library('encryption');
		$this->load->library('General');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('DocumentStandarization/MainMenu/M_codeofpractice');
		$this->load->model('DocumentStandarization/MainMenu/M_general');

		date_default_timezone_set('Asia/Jakarta');

		define('direktoriUpload', './assets/upload/PengembanganSistem/StandarisasiDokumen/');

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	/* LIST DATA */
	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Code Of Practice';
		$data['Menu'] = 'Upload Dokumen';
		$data['SubMenuOne'] = 'Code of Practice';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['CodeOfPractice'] = $this->M_codeofpractice->getCodeOfPractice();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/CodeOfPractice/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Code Of Practice';
		$data['Menu'] = 'Upload Dokumen';
		$data['SubMenuOne'] = 'Code of Practice';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('txtCopNameHeader', 'Nama Code of Practice', 'required');
		$this->form_validation->set_rules('txtNoDocHeader', 'Nomor Kontrol', 'required');
		$this->form_validation->set_rules('txtNoRevisiHeader', 'Nomor Revisi', 'required');
		$this->form_validation->set_rules('txtTanggalHeader', 'Tanggal Revisi', 'required');
		$this->form_validation->set_rules('txtJmlHalamanHeader', 'Jumlah Halaman', 'required');
		$this->form_validation->set_rules('cmbPekerjaDibuat', 'Pekerja Pembuat', 'required');
		// $this->form_validation->set_rules('cmbPekerjaDiperiksa1', 'Pekerja Pemeriksa 1', 'required');
		// $this->form_validation->set_rules('cmbPekerjaDiperiksa2', 'Pekerja Pemeriksa 2', 'required');
		$this->form_validation->set_rules('cmbPekerjaDiputuskan', 'Pekerja Pemberi Keputusan', 'required');


		if ($this->form_validation->run() === FALSE) {
			$data['daftarSOP'] 		= 	$this->M_general->ambilDaftarStandardOperatingProcedure();

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('DocumentStandarization/CodeOfPractice/V_create', $data);
			$this->load->view('V_Footer',$data);
		} else {
			$namaCOP 				= 	strtoupper($this->input->post('txtCopNameHeader'));
			$SOP 					= 	$this->input->post('cmbSOP');
			$nomorKontrol 			= 	strtoupper($this->input->post('txtNoDocHeader'));
			$nomorRevisi	  		= 	$this->input->post('txtNoRevisiHeader');
			$tanggalRevisi 			= 	$this->general->konversiTanggalkeDatabase(($this->input->post('txtTanggalHeader')),'tanggal');
			$jumlahHalaman 			= 	$this->input->post('txtJmlHalamanHeader');
			$info 					= 	$this->input->post('txaCopInfoHeader');
			$pekerjaDibuat 			= 	$this->input->post('cmbPekerjaDibuat');
			$pekerjaDiperiksa1 		= 	$this->input->post('cmbPekerjaDiperiksa1');
			$pekerjaDiperiksa2 		= 	$this->input->post('cmbPekerjaDiperiksa2');
			$pekerjaDiputuskan 		= 	$this->input->post('cmbPekerjaDiputuskan');
			$inputfile 				= 	'txtCopFileHeader';
			$namaDokumen			= 	str_replace(' ', '_', $nomorKontrol).'_-_'.$nomorRevisi.'_-_'.str_replace(' ','_',$namaCOP);
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

			if($SOP=='' OR $SOP==NULL OR $SOP==' ')
			{
				$SOP=NULL;
			}

			// echo 'sampai sini bisa';
			// exit();
			$fileDokumen 			= 	$this->general->uploadDokumen($inputfile, $namaDokumen, direktoriUpload);
			if(is_null($fileDokumen)==FALSE)
			{
				$tanggalUpload 		=  	$this->general->ambilWaktuEksekusi();
			}

			$ContextDiagram;
			$BusinessProcess;
			if($SOP=='' OR $SOP==NULL OR $SOP==' ')
			{
				$ContextDiagram=NULL;
				$BusinessProcess=NULL;
			}
			else
			{
				$ContextDiagram 	= 	$this->general->cekContextDiagram($SOP);
				$BusinessProcess 	= 	$this->general->cekBusinessProcess($ContextDiagram);
			}
			$data = array(
				'cop_name' 			=> $namaCOP,
				'cop_file' 			=> $fileDokumen,
				'no_kontrol' 		=> $nomorKontrol,
				'no_revisi' 		=> $nomorRevisi,
				'tanggal' 			=> $tanggalRevisi,
				'dibuat' 			=> $pekerjaDibuat,
				'diperiksa_1' 		=> $pekerjaDiperiksa1,
				'diperiksa_2' 		=> $pekerjaDiperiksa2,
				'diputuskan' 		=> $pekerjaDiputuskan,
				'jml_halaman'	 	=> $jumlahHalaman,
				'cop_info' 			=> $info,
				'tgl_upload' 		=> $tanggalUpload,
				'tgl_insert' 		=> $this->general->ambilWaktuEksekusi(),
				'bp_id' 			=> $BusinessProcess,
				'cd_id' 			=> $ContextDiagram,
				'sop_id' 			=> $SOP,
    		);
			$this->M_codeofpractice->setCodeOfPractice($data);
			$header_id = $this->db->insert_id();
			//insert to sys.log_activity
			$aksi = 'DOC STANDARIZATION';
			$detail = "Set document COP id=$header_id";
			$this->log_activity->activity_log($aksi, $detail);
			//

			redirect(site_url('DocumentStandarization/COP'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Code Of Practice';
		$data['Menu'] = 'Upload Dokumen';
		$data['SubMenuOne'] = 'Code of Practice';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['CodeOfPractice'] = $this->M_codeofpractice->getCodeOfPractice($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('txtCopNameHeader', 'Nama Code of Practice', 'required');
		$this->form_validation->set_rules('txtNoDocHeader', 'Nomor Kontrol', 'required');
		$this->form_validation->set_rules('txtNoRevisiHeader', 'Nomor Revisi', 'required');
		$this->form_validation->set_rules('txtTanggalHeader', 'Tanggal Revisi', 'required');
		$this->form_validation->set_rules('txtJmlHalamanHeader', 'Jumlah Halaman', 'required');
		$this->form_validation->set_rules('cmbPekerjaDibuat', 'Pekerja Pembuat', 'required');
		// $this->form_validation->set_rules('cmbPekerjaDiperiksa1', 'Pekerja Pemeriksa 1', 'required');
		// $this->form_validation->set_rules('cmbPekerjaDiperiksa2', 'Pekerja Pemeriksa 2', 'required');
		$this->form_validation->set_rules('cmbPekerjaDiputuskan', 'Pekerja Pemberi Keputusan', 'required');


		if ($this->form_validation->run() === FALSE) {

			$data['daftarSOP'] 		= 	$this->M_general->ambilDaftarStandardOperatingProcedure();

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('DocumentStandarization/CodeOfPractice/V_update', $data);
			$this->load->view('V_Footer',$data);
		} else {
			$namaCOP 				= 	strtoupper($this->input->post('txtCopNameHeader'));
			$SOP 					= 	$this->input->post('cmbSOP');
			$nomorKontrol 			= 	strtoupper($this->input->post('txtNoDocHeader'));
			$nomorRevisi	  		= 	$this->input->post('txtNoRevisiHeader');
			$tanggalRevisi 			= 	$this->general->konversiTanggalkeDatabase(($this->input->post('txtTanggalHeader')),'tanggal');
			$jumlahHalaman 			= 	$this->input->post('txtJmlHalamanHeader');
			$info 					= 	$this->input->post('txaCopInfoHeader');
			$pekerjaDibuat 			= 	$this->input->post('cmbPekerjaDibuat');
			$pekerjaDiperiksa1 		= 	$this->input->post('cmbPekerjaDiperiksa1');
			$pekerjaDiperiksa2 		= 	$this->input->post('cmbPekerjaDiperiksa2');
			$pekerjaDiputuskan 		= 	$this->input->post('cmbPekerjaDiputuskan');
			$inputfile 				= 	'txtCopFileHeader';
			$namaDokumen			= 	str_replace(' ', '_', $nomorKontrol).'_-_'.$nomorRevisi.'_-_'.str_replace(' ','_',$namaCOP);
			$fileDokumen			= 	$this->input->post('DokumenAwal', TRUE);
			$tanggalUpload			= 	$this->general->konversiTanggalkeDatabase(($this->input->post('WaktuUpload', TRUE)), 'datetime');

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
				$dataLama 	= 	$this->M_codeofpractice->ambilDataLama($kodeBusinessProcess);

				$doc_id 		= 	$dataLama[0]['cop_id'];
				$name 			= 	$dataLama[0]['cop_name'];
				$file 			= 	$dataLama[0]['cop_file'];
				$no_kontrol 	= 	$dataLama[0]['no_kontrol'];
				$no_revisi 		=	$dataLama[0]['no_revisi'];
				$tanggal 		= 	$dataLama[0]['tanggal'];
				$dibuat 		= 	$dataLama[0]['dibuat'];
				$diperiksa_1 	= 	$dataLama[0]['diperiksa_1'];
				$diperiksa_2 	= 	$dataLama[0]['diperiksa_2'];
				$diputuskan 	= 	$dataLama[0]['diputuskan'];
				$jml_halaman 	= 	$dataLama[0]['jml_halaman'];
				$info 			= 	$dataLama[0]['cop_info'];
				$tgl_upload 	= 	$dataLama[0]['tgl_upload'];
				$tgl_insert 	= 	$dataLama[0]['tgl_insert'];

				$jenis_doc 		= 	'COP';
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
				$this->M_codeofpractice->inputDataLamakeHistory($recordLama);
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

			if($SOP=='' OR $SOP==NULL OR $SOP==' ')
			{
				$SOP=NULL;
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
			$ContextDiagram;
			$BusinessProcess;
			if($SOP=='' OR $SOP==NULL OR $SOP==' ')
			{
				$ContextDiagram=NULL;
				$BusinessProcess=NULL;
			}
			else
			{
				$ContextDiagram 	= 	$this->general->cekContextDiagram($SOP);
				$BusinessProcess 	= 	$this->general->cekBusinessProcess($ContextDiagram);
			}

			$data = array(
				'cop_name' 		=> $namaCOP,
				'cop_file' 		=> $fileDokumen,
				'no_kontrol' 	=> $nomorKontrol,
				'no_revisi' 	=> $nomorRevisi,
				'tanggal' 		=> $tanggalRevisi,
				'dibuat' 		=> $pekerjaDibuat,
				'diperiksa_1' 	=> $pekerjaDiperiksa1,
				'diperiksa_2' 	=> $pekerjaDiperiksa2,
				'diputuskan' 	=> $pekerjaDiputuskan,
				'jml_halaman' 	=> $jumlahHalaman,
				'cop_info' 		=> $info,
				'tgl_upload' 	=> $tanggalUpload,
				'bp_id' 		=> $BusinessProcess,
				'cd_id' 		=> $ContextDiagram,
				'sop_id' 		=> $SOP,
    			);
			echo '<pre>';
			print_r($data);
			echo '</pre>';
			$this->M_codeofpractice->updateCodeOfPractice($data, $plaintext_string);
			//insert to sys.log_activity
			$aksi = 'DOC STANDARIZATION';
			$detail = "Update document COP id=$plaintext_string";
			$this->log_activity->activity_log($aksi, $detail);
			//

			redirect(site_url('DocumentStandarization/COP'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Code Of Practice';
		$data['Menu'] = 'Upload Dokumen';
		$data['SubMenuOne'] = 'Code of Practice';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['CodeOfPractice'] = $this->M_codeofpractice->getCodeOfPractice($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/CodeOfPractice/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_codeofpractice->deleteCodeOfPractice($plaintext_string);
		//insert to sys.log_activity
		$aksi = 'DOC STANDARIZATION';
		$detail = "Delete document COP id=$plaintext_string";
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect(site_url('DocumentStandarization/COP'));
    }



}

/* End of file C_CodeOfPractice.php */
/* Location: ./application/controllers/OTHERS/MainMenu/C_CodeOfPractice.php */
/* Generated automatically on 2017-09-14 11:02:21 */
