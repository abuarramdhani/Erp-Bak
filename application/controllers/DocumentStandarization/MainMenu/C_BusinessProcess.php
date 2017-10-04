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

		$data['Title'] = 'Business Process';
		$data['Menu'] = 'Dokumen';
		$data['SubMenuOne'] = 'Business Process';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['BusinessProcess'] = $this->M_businessprocess->getBusinessProcess();

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
		$data['Menu'] = 'Dokumen';
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
		$this->form_validation->set_rules('cmbPekerjaDiperiksa1', 'Pekerja Pemeriksa 1', 'required');
		// $this->form_validation->set_rules('cmbPekerjaDiperiksa2', 'Pekerja Pemeriksa 2', 'required');
		$this->form_validation->set_rules('cmbPekerjaDiputuskan', 'Pekerja Pemberi Keputusan', 'required');




		if ($this->form_validation->run() === FALSE) {

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('DocumentStandarization/BusinessProcess/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$namaBusinessProcess 	= 	$this->input->post('txtBpNameHeader');
			$nomorKontrol 			= 	$this->input->post('txtNoKontrolHeader');
			$nomorRevisi	  		= 	$this->input->post('txtNoRevisiHeader');
			$tanggalRevisi 			= 	$this->general->konversiTanggalkeDatabase(($this->input->post('txtTanggalHeader')),'tanggal');
			$jumlahHalaman 			= 	$this->input->post('txtJmlHalamanHeader');
			$info 					= 	$this->input->post('txaBpInfoHeader');
			$pekerjaDibuat 			= 	$this->input->post('cmbPekerjaDibuat');
			$pekerjaDiperiksa1 		= 	$this->input->post('cmbPekerjaDiperiksa1');
			$pekerjaDiperiksa2 		= 	$this->input->post('cmbPekerjaDiperiksa2');
			$pekerjaDiputuskan 		= 	$this->input->post('cmbPekerjaDiputuskan');
			$inputfile 				= 	'txtBpFileHeader';
			$namaDokumen			= 	str_replace(' ', '_', $nomorKontrol).'_-_'.'Rev.'.'_'.$nomorRevisi.'_-_'.str_replace(' ','_',$namaBusinessProcess);
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
			$this->M_businessprocess->setBusinessProcess($data);
			$header_id = $this->db->insert_id();

			redirect(site_url('DocumentStandarization/BP'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Business Process';
		$data['Menu'] = 'Dokumen';
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
		$this->form_validation->set_rules('cmbPekerjaDiperiksa1', 'Pekerja Pemeriksa 1', 'required');
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
			$namaBusinessProcess 	= 	$this->input->post('txtBpNameHeader', TRUE);
			$nomorKontrol 			= 	$this->input->post('txtNoKontrolHeader', TRUE);
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
			$namaDokumen			= 	str_replace(' ', '_', $nomorKontrol).'_-_'.'Rev.'.'_'.$nomorRevisi.'_-_'.str_replace(' ','_',$namaBusinessProcess);


			if($pekerjaDiperiksa2=='' OR $pekerjaDiperiksa2==NULL OR $pekerjaDiperiksa2==' ')
			{
				$pekerjaDiperiksa2=NULL;
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
				$fileDokumen			= 	$this->input->post('DokumenAwal', TRUE);
			}

			$fileDokumen = $this->general->cekFile($namaBusinessProcess, $nomorRevisi, $nomorKontrol, $fileDokumen, direktoriUpload);
			
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

			redirect(site_url('DocumentStandarization/BP'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Business Process';
		$data['Menu'] = 'Dokumen';
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

		redirect(site_url('DocumentStandarization/BP'));
    }



}

/* End of file C_BusinessProcess.php */
/* Location: ./application/controllers/DocumentStandarization/MainMenu/C_BusinessProcess.php */
/* Generated automatically on 2017-09-14 10:57:11 */