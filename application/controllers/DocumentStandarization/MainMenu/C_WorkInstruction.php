<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_WorkInstruction extends CI_Controller
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
		$this->load->library('General');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('DocumentStandarization/MainMenu/M_workinstruction');

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

		$data['Title'] = 'Work Instruction';
		$data['Menu'] = 'Upload Dokumen';
		$data['SubMenuOne'] = 'Work Instruction';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['WorkInstruction'] = $this->M_workinstruction->getWorkInstruction();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/WorkInstruction/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Work Instruction';
		$data['Menu'] = 'Upload Dokumen';
		$data['SubMenuOne'] = 'Work Instruction';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('txtWiNameHeader', 'Nama Work Instruction', 'required');
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
			$this->load->view('DocumentStandarization/WorkInstruction/V_create', $data);
			$this->load->view('V_Footer',$data);
		} else {
			$namaWI 				= 	strtoupper($this->input->post('txtWiNameHeader'));
			$SOP 					= 	$this->input->post('cmbSOP');
			$nomorKontrol 			= 	strtoupper($this->input->post('txtNoDocHeader'));
			$nomorRevisi	  		= 	$this->input->post('txtNoRevisiHeader');
			$tanggalRevisi 			= 	$this->general->konversiTanggalkeDatabase(($this->input->post('txtTanggalHeader')),'tanggal');
			$jumlahHalaman 			= 	$this->input->post('txtJmlHalamanHeader');
			$info 					= 	$this->input->post('txaWiInfoHeader');
			$pekerjaDibuat 			= 	$this->input->post('cmbPekerjaDibuat');
			$pekerjaDiperiksa1 		= 	$this->input->post('cmbPekerjaDiperiksa1');
			$pekerjaDiperiksa2 		= 	$this->input->post('cmbPekerjaDiperiksa2');
			$pekerjaDiputuskan 		= 	$this->input->post('cmbPekerjaDiputuskan');
			$inputfile 				= 	'txtWiFileHeader';
			$namaDokumen			= 	str_replace(' ', '_', $nomorKontrol).'_-_'.$nomorRevisi.'_-_'.str_replace(' ','_',$namaWI);
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

			if($revisiBaru==0)
			{
				$fileDokumen = $this->general->cekFile($namaWI, $nomorRevisi, $nomorKontrol, $fileDokumen, direktoriUpload);
			}

				$data = array(
					'wi_name' 		=> $namaWI,
					'wi_file' 		=> $fileDokumen,
					'no_kontrol' 	=> $nomorKontrol,
					'no_revisi' 	=> $nomorRevisi,
					'tanggal' 		=> $tanggalRevisi,
					'dibuat' 		=> $pekerjaDibuat,
					'diperiksa_1' 	=> $pekerjaDiperiksa1,
					'diperiksa_2' 	=> $pekerjaDiperiksa2,
					'diputuskan' 	=> $pekerjaDiputuskan,
					'jml_halaman' 	=> $jumlahHalaman,
					'wi_info' 		=> $info,
					'tgl_upload' 	=> $tanggalUpload,
					'tgl_insert' 	=> $this->general->ambilWaktuEksekusi(),
					'bp_id' 		=> $BusinessProcess,
					'cd_id' 		=> $ContextDiagram,
					'sop_id' 		=> $SOP,
	    		);

			$this->M_workinstruction->setWorkInstruction($data);
			$header_id = $this->db->insert_id();
			//insert to sys.log_activity
			$aksi = 'DOC STANDARIZATION';
			$detail = "Set WI id=$header_id";
			$this->log_activity->activity_log($aksi, $detail);
			//

			redirect(site_url('DocumentStandarization/WI'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Work Instruction';
		$data['Menu'] = 'Upload Dokumen';
		$data['SubMenuOne'] = 'Work Instruction';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['WorkInstruction'] = $this->M_workinstruction->getWorkInstruction($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('txtWiNameHeader', 'Nama Work Instruction', 'required');
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
			$this->load->view('DocumentStandarization/WorkInstruction/V_update', $data);
			$this->load->view('V_Footer',$data);
		} else {
			$namaWI 				= 	strtoupper($this->input->post('txtWiNameHeader', TRUE));
			$SOP 					= 	$this->input->post('cmbSOP', TRUE);
			$nomorKontrol 			= 	strtoupper($this->input->post('txtNoDocHeader', TRUE));
			$nomorRevisi	  		= 	$this->input->post('txtNoRevisiHeader', TRUE);
			$tanggalRevisi 			= 	$this->general->konversiTanggalkeDatabase(($this->input->post('txtTanggalHeader', TRUE)),'tanggal');
			$jumlahHalaman 			= 	$this->input->post('txtJmlHalamanHeader', TRUE);
			$info 					= 	$this->input->post('txaWiInfoHeader', TRUE);
			$pekerjaDibuat 			= 	$this->input->post('cmbPekerjaDibuat', TRUE);
			$pekerjaDiperiksa1 		= 	$this->input->post('cmbPekerjaDiperiksa1', TRUE);
			$pekerjaDiperiksa2 		= 	$this->input->post('cmbPekerjaDiperiksa2', TRUE);
			$pekerjaDiputuskan 		= 	$this->input->post('cmbPekerjaDiputuskan', TRUE);
			$inputfile 				= 	'txtWiFileHeader';
			$namaDokumen			= 	str_replace(' ', '_', $nomorKontrol).'_-_'.$nomorRevisi.'_-_'.str_replace(' ','_',$namaWI);
			$fileDokumen 			= 	$this->input->post('DokumenAwal', TRUE);
			$tanggalUpload 			= 	$this->general->konversiTanggalkeDatabase(($this->input->post('WaktuUpload', TRUE)),'datetime');

			// Salin dari sini
			$revisiBaru 			= 	$this->input->post('checkboxRevisi');

			$nomorRevisiLama 		= 	$this->input->post('txtNoRevisiLamaHeader');
			$tanggalRevisiLama 		= 	$this->general->konversiTanggalkeDatabase(($this->input->post('txtTanggalLamaHeader')), 'tanggal');

			$angkaRevisiBaru 		= 	(int) $nomorRevisi;
			$angkaRevisiLama 		= 	(int) $nomorRevisiLama;

			if($revisiBaru!=1)
			{
				$revisiBaru 		=	0;
			}

			if($revisiBaru==1 AND $angkaRevisiBaru>$angkaRevisiLama AND strtotime($tanggalRevisi)>strtotime($tanggalRevisiLama))
			{
				$kodeWorkInstruction 	= 	$plaintext_string;
				$dataLama 	= 	$this->M_workinstruction->ambilDataLama($kodeWorkInstruction);

				$doc_id 		= 	$dataLama[0]['wi_id'];
				$name 			= 	$dataLama[0]['wi_name'];
				$file 			= 	$dataLama[0]['wi_file'];
				$no_kontrol 	= 	$dataLama[0]['no_kontrol'];
				$no_revisi 		=	$dataLama[0]['no_revisi'];
				$tanggal 		= 	$dataLama[0]['tanggal'];
				$dibuat 		= 	$dataLama[0]['dibuat'];
				$diperiksa_1 	= 	$dataLama[0]['diperiksa_1'];
				$diperiksa_2 	= 	$dataLama[0]['diperiksa_2'];
				$diputuskan 	= 	$dataLama[0]['diputuskan'];
				$jml_halaman 	= 	$dataLama[0]['jml_halaman'];
				$info 			= 	$dataLama[0]['wi_info'];
				$tgl_upload 	= 	$dataLama[0]['tgl_upload'];
				$tgl_insert 	= 	$dataLama[0]['tgl_insert'];

				$jenis_doc 		= 	'WI';
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
				$this->M_workinstruction->inputDataLamakeHistory($recordLama);
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
			if(is_null($fileDokumen))
			{
				if(($revisiBaru==0 || $fileDokumen!=NULL) && $inputfile==NULL)
				{
					$fileDokumen = $this->general->cekFile($namaBusinessProcess, $nomorRevisi, $nomorKontrol, $fileDokumen, direktoriUpload);
				}
			}
			else
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

			if($revisiBaru==0)
			{
				$data = array(
					'wi_name' 		=> $namaWI,
					'wi_file' 		=> $fileDokumen,
					'no_kontrol' 	=> $nomorKontrol,
					'no_revisi' 	=> $nomorRevisi,
					'tanggal' 		=> $tanggalRevisi,
					'dibuat' 		=> $pekerjaDibuat,
					'diperiksa_1' 	=> $pekerjaDiperiksa1,
					'diperiksa_2' 	=> $pekerjaDiperiksa2,
					'diputuskan' 	=> $pekerjaDiputuskan,
					'jml_halaman' 	=> $jumlahHalaman,
					'wi_info' 		=> $info,
					'tgl_upload' 	=> $tanggalUpload,
					'tgl_insert' 	=> $this->general->ambilWaktuEksekusi(),
					'bp_id' 		=> $BusinessProcess,
					'cd_id' 		=> $ContextDiagram,
					'sop_id' 		=> $SOP,
	    		);
	    	}
	    	elseif($revisiBaru==1)
	    	{
				$data = array(
					'wi_name' 		=> $namaWI,
					'wi_file' 		=> $fileDokumen,
					'no_kontrol' 	=> $nomorKontrol,
					'no_revisi' 	=> $nomorRevisi,
					'tanggal' 		=> $tanggalRevisi,
					'dibuat' 		=> $pekerjaDibuat,
					'diperiksa_1' 	=> $pekerjaDiperiksa1,
					'diperiksa_2' 	=> $pekerjaDiperiksa2,
					'diputuskan' 	=> $pekerjaDiputuskan,
					'jml_halaman' 	=> $jumlahHalaman,
					'wi_info' 		=> $info,
					'tgl_upload' 	=> $tanggalUpload,
					'tgl_insert' 	=> $this->general->ambilWaktuEksekusi(),
					'bp_id' 		=> $BusinessProcess,
					'cd_id' 		=> $ContextDiagram,
					'sop_id' 		=> $SOP,
					'update_revisi'	=> $this->general->ambilWaktuEksekusi(),
	    		);
	    	}
			$this->M_workinstruction->updateWorkInstruction($data, $plaintext_string);
			//insert to sys.log_activity
			$aksi = 'DOC STANDARIZATION';
			$detail = "Update WI id=$plaintext_string";
			$this->log_activity->activity_log($aksi, $detail);
			//

			redirect(site_url('DocumentStandarization/WI'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Work Instruction';
		$data['Menu'] = 'Upload Dokumen';
		$data['SubMenuOne'] = 'Work Instruction';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['WorkInstruction'] = $this->M_workinstruction->getWorkInstruction($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/WorkInstruction/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_workinstruction->deleteWorkInstruction($plaintext_string);
		//insert to sys.log_activity
		$aksi = 'DOC STANDARIZATION';
		$detail = "Delete WI id=$plaintext_string";
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect(site_url('DocumentStandarization/WI'));
    }



}

/* End of file C_WorkInstruction.php */
/* Location: ./application/controllers/OTHERS/MainMenu/C_WorkInstruction.php */
/* Generated automatically on 2017-09-14 11:01:40 */
