<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_StandardOperatingProcedure extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('General');


		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('DocumentStandarization/MainMenu/M_standardoperatingprocedure');
		$this->load->model('DocumentStandarization/MainMenu/M_general');

		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();

		define('direktoriUpload', './assets/upload/IA/StandarisasiDokumen/');

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

		$data['Title'] = 'Standard Operating Procedure';
		$data['Menu'] = 'Dokumen';
		$data['SubMenuOne'] = 'SOP';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['StandardOperatingProcedure'] = $this->M_standardoperatingprocedure->getStandardOperatingProcedure();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/StandardOperatingProcedure/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Standard Operating Procedure';
		$data['Menu'] = 'Dokumen';
		$data['SubMenuOne'] = 'SOP';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('txtSopNameHeader', 'Nama Standard Operating Procedure', 'required');
		$this->form_validation->set_rules('txtNoDocHeader', 'Nomor Kontrol', 'required');
		$this->form_validation->set_rules('txtNoRevisiHeader', 'Nomor Revisi', 'required');
		$this->form_validation->set_rules('txtTanggalHeader', 'Tanggal Revisi', 'required');
		$this->form_validation->set_rules('txtJmlHalamanHeader', 'Jumlah Halaman', 'required');
		$this->form_validation->set_rules('cmbPekerjaDibuat', 'Pekerja Pembuat', 'required');
		$this->form_validation->set_rules('cmbPekerjaDiperiksa1', 'Pekerja Pemeriksa 1', 'required');
		// $this->form_validation->set_rules('cmbPekerjaDiperiksa2', 'Pekerja Pemeriksa 2', 'required');
		$this->form_validation->set_rules('cmbPekerjaDiputuskan', 'Pekerja Pemberi Keputusan', 'required');


		if ($this->form_validation->run() === FALSE) {
			$data['daftarContextDiagram'] 	= 	$this->M_general->ambilDaftarContextDiagram();

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('DocumentStandarization/StandardOperatingProcedure/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$namaSOP 				= 	$this->input->post('txtSopNameHeader');
			$ContextDiagram 		= 	$this->input->post('cmbContextDiagram');			
			$nomorKontrol 			= 	$this->input->post('txtNoDocHeader');
			$nomorRevisi	  		= 	$this->input->post('txtNoRevisiHeader');
			$tanggalRevisi 			= 	$this->general->konversiTanggalkeDatabase(($this->input->post('txtTanggalHeader')),'tanggal');
			$jumlahHalaman 			= 	$this->input->post('txtJmlHalamanHeader');
			$info 					= 	$this->input->post('txaSopInfoHeader');
			$pekerjaDibuat 			= 	$this->input->post('cmbPekerjaDibuat');
			$pekerjaDiperiksa1 		= 	$this->input->post('cmbPekerjaDiperiksa1');
			$pekerjaDiperiksa2 		= 	$this->input->post('cmbPekerjaDiperiksa2');
			$pekerjaDiputuskan 		= 	$this->input->post('cmbPekerjaDiputuskan');
			$tujuanSOP 				= 	$this->input->post('txaSopTujuanHeader');
			$ruanglingkupSOP 		= 	$this->input->post('txaSopRuangLingkupHeader');
			$referensiSOP 			= 	$this->input->post('txaSopReferensiHeader');
			$definisiSOP 			= 	$this->input->post('txaSopDefinisiHeader');
			$inputfile 				= 	'txtSopFileHeader';
			$namaDokumen			= 	str_replace(' ', '_', $nomorKontrol).'_-_'.$nomorRevisi.'_-_'.str_replace(' ','_',$namaSOP);
			$fileDokumen;
			$tanggalUpload;

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

			$BusinessProcess 	= 	$this->general->cekBusinessProcess($ContextDiagram);

			$data = array(
				'sop_name' 			=> $namaSOP,
				'sop_file' 			=> $fileDokumen,
				'no_kontrol' 		=> $nomorKontrol,
				'no_revisi' 		=> $nomorRevisi,
				'tanggal' 			=> $tanggalRevisi,
				'dibuat' 			=> $pekerjaDibuat,
				'diperiksa_1' 		=> $pekerjaDiperiksa1,
				'diperiksa_2' 		=> $pekerjaDiperiksa2,
				'diputuskan' 		=> $pekerjaDiputuskan,
				'jml_halaman' 		=> $jumlahHalaman,
				'sop_info' 			=> $info,
				'tgl_upload' 		=> $tanggalUpload,
				'tgl_insert' 		=> $this->general->ambilWaktuEksekusi(),
				'bp_id' 			=> $BusinessProcess,
				'cd_id' 			=> $ContextDiagram,
				'sop_tujuan' 		=> $tujuanSOP,
				'sop_ruang_lingkup'	=> $ruanglingkupSOP,
				'sop_referensi' 	=> $referensiSOP,
				'sop_definisi' 		=> $definisiSOP,
    		);
    		/*
    		echo '<pre>';
    		print_r($data);
    		echo "</pre>";
    		exit();
    		*/
			$this->M_standardoperatingprocedure->setStandardOperatingProcedure($data);
			$header_id = $this->db->insert_id();

			redirect(site_url('DocumentStandarization/SOP'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Standard Operating Procedure';
		$data['Menu'] = 'Dokumen';
		$data['SubMenuOne'] = 'SOP';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['StandardOperatingProcedure'] = $this->M_standardoperatingprocedure->getStandardOperatingProcedure($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('txtSopNameHeader', 'Nama Standard Operating Procedure', 'required');
		$this->form_validation->set_rules('txtNoDocHeader', 'Nomor Kontrol', 'required');
		$this->form_validation->set_rules('txtNoRevisiHeader', 'Nomor Revisi', 'required');
		$this->form_validation->set_rules('txtTanggalHeader', 'Tanggal Revisi', 'required');
		$this->form_validation->set_rules('txtJmlHalamanHeader', 'Jumlah Halaman', 'required');
		$this->form_validation->set_rules('cmbPekerjaDibuat', 'Pekerja Pembuat', 'required');
		$this->form_validation->set_rules('cmbPekerjaDiperiksa1', 'Pekerja Pemeriksa 1', 'required');
		// $this->form_validation->set_rules('cmbPekerjaDiperiksa2', 'Pekerja Pemeriksa 2', 'required');
		$this->form_validation->set_rules('cmbPekerjaDiputuskan', 'Pekerja Pemberi Keputusan', 'required');


		if ($this->form_validation->run() === FALSE) {
			$data['daftarContextDiagram'] 	= 	$this->M_general->ambilDaftarContextDiagram();

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('DocumentStandarization/StandardOperatingProcedure/V_update', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$namaSOP 				= 	$this->input->post('txtSopNameHeader', TRUE);
			$ContextDiagram 		= 	$this->input->post('cmbContextDiagram', TRUE);			
			$nomorKontrol 			= 	$this->input->post('txtNoDocHeader', TRUE);
			$nomorRevisi	  		= 	$this->input->post('txtNoRevisiHeader', TRUE);
			$tanggalRevisi 			= 	$this->general->konversiTanggalkeDatabase(($this->input->post('txtTanggalHeader')),'tanggal');
			$jumlahHalaman 			= 	$this->input->post('txtJmlHalamanHeader', TRUE);
			$info 					= 	$this->input->post('txaSopInfoHeader', TRUE);
			$pekerjaDibuat 			= 	$this->input->post('cmbPekerjaDibuat', TRUE);
			$pekerjaDiperiksa1 		= 	$this->input->post('cmbPekerjaDiperiksa1', TRUE);
			$pekerjaDiperiksa2 		= 	$this->input->post('cmbPekerjaDiperiksa2', TRUE);
			$pekerjaDiputuskan 		= 	$this->input->post('cmbPekerjaDiputuskan', TRUE);
			$tujuanSOP 				= 	$this->input->post('txaSopTujuanHeader', TRUE);
			$ruanglingkupSOP 		= 	$this->input->post('txaSopRuangLingkupHeader', TRUE);
			$referensiSOP 			= 	$this->input->post('txaSopReferensiHeader', TRUE);
			$definisiSOP 			= 	$this->input->post('txaSopDefinisiHeader', TRUE);
			$inputfile 				= 	'txtSopFileHeader';
			$namaDokumen			= 	str_replace(' ', '_', $nomorKontrol).'_-_'.$nomorRevisi.'_-_'.str_replace(' ','_',$namaSOP);
			$fileDokumen 			= 	$this->input->post('DokumenAwal', TRUE);
			$tanggalUpload 			= 	$this->general->konversiTanggalkeDatabase(($this->input->post('WaktuUpload', TRUE)),'datetime');

			if($pekerjaDiperiksa2=='' OR $pekerjaDiperiksa2==NULL OR $pekerjaDiperiksa2==' ')
			{
				$pekerjaDiperiksa2=NULL;
			}

			$fileDokumen 			= 	$this->general->uploadDokumen($inputfile, $namaDokumen, direktoriUpload);

			if(is_null($fileDokumen))
			{
				$fileDokumen			= 	$this->input->post('DokumenAwal', TRUE);

			}
			else
			{
				$tanggalUpload 		=  	$this->general->ambilWaktuEksekusi();
			}	

			$BusinessProcess 	= 	$this->general->cekBusinessProcess($ContextDiagram);

			$fileDokumen = $this->general->cekFile($namaSOP, $nomorRevisi, $nomorKontrol, $fileDokumen, direktoriUpload);

			$data = array(
				'sop_name' 			=> $namaSOP,
				'sop_file' 			=> $fileDokumen,
				'no_kontrol' 		=> $nomorKontrol,
				'no_revisi' 		=> $nomorRevisi,
				'tanggal' 			=> $tanggalRevisi,
				'dibuat' 			=> $pekerjaDibuat,
				'diperiksa_1' 		=> $pekerjaDiperiksa1,
				'diperiksa_2' 		=> $pekerjaDiperiksa2,
				'diputuskan' 		=> $pekerjaDiputuskan,
				'jml_halaman' 		=> $jumlahHalaman,
				'sop_info' 			=> $info,
				'tgl_upload'		=> $tanggalUpload,
				'bp_id' 			=> $BusinessProcess,
				'cd_id' 			=> $ContextDiagram,
				'sop_tujuan' 		=> $tujuanSOP,
				'sop_ruang_lingkup' => $ruanglingkupSOP,
				'sop_referensi' 	=> $referensiSOP,
				'sop_definisi' 		=> $definisiSOP,
    			);
    		
    		// echo '<pre>';
    		// print_r($data);
    		// echo "</pre>";
    		// exit();
    					
			$this->M_standardoperatingprocedure->updateStandardOperatingProcedure($data, $plaintext_string);

			redirect(site_url('DocumentStandarization/SOP'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Standard Operating Procedure';
		$data['Menu'] = 'Dokumen';
		$data['SubMenuOne'] = 'SOP';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['StandardOperatingProcedure'] = $this->M_standardoperatingprocedure->getStandardOperatingProcedure($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/StandardOperatingProcedure/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_standardoperatingprocedure->deleteStandardOperatingProcedure($plaintext_string);

		redirect(site_url('DocumentStandarization/SOP'));
    }



}

/* End of file C_StandardOperatingProcedure.php */
/* Location: ./application/controllers/OTHERS/MainMenu/C_StandardOperatingProcedure.php */
/* Generated automatically on 2017-09-14 11:01:16 */