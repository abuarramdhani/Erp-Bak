
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_ContextDiagram extends CI_Controller
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
		$this->load->model('DocumentStandarization/MainMenu/M_contextdiagram');
		$this->load->model('DocumentStandarization/MainMenu/M_general');

		$this->load->library('upload');

		$this->checkSession();

		define('direktoriUpload', './assets/upload/PengembanganSistem/StandarisasiDokumen/');

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

		$data['Title'] = 'Context Diagram';
		$data['Menu'] = 'Upload Dokumen';
		$data['SubMenuOne'] = 'Context Diagram';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['ContextDiagram'] = $this->M_contextdiagram->getContextDiagram();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/ContextDiagram/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Context Diagram';
		$data['Menu'] = 'Upload Dokumen';
		$data['SubMenuOne'] = 'Context Diagram';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('txtCdNameHeader', 'Nama Context Diagram', 'required');
		$this->form_validation->set_rules('cmbBusinessProcess', 'Business Process', 'required');
		$this->form_validation->set_rules('txtNoKontrolHeader', 'Nomor Kontrol', 'required');
		$this->form_validation->set_rules('txtNoRevisiHeader', 'Nomor Revisi', 'required');
		$this->form_validation->set_rules('txtTanggalHeader', 'Tanggal Revisi', 'required');
		$this->form_validation->set_rules('txtJmlHalamanHeader', 'Jumlah Halaman', 'required');
		$this->form_validation->set_rules('cmbPekerjaDibuat', 'Pekerja Pembuat', 'required');
		// $this->form_validation->set_rules('cmbPekerjaDiperiksa1', 'Pekerja Pemeriksa 1', 'required');
		$this->form_validation->set_rules('cmbPekerjaDiputuskan', 'Pekerja Pemberi Keputusan', 'required');

		if ($this->form_validation->run() === FALSE)
		{
			$data['daftarBusinessProcess'] 	= 	$this->M_general->ambilDaftarBusinessProcess();

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('DocumentStandarization/ContextDiagram/V_create', $data);
			$this->load->view('V_Footer',$data);
		} else {
			$namaContextDiagram		= 	strtoupper($this->input->post('txtCdNameHeader'));
			$BusinessProcess 		= 	$this->input->post('cmbBusinessProcess');
			$nomorKontrol 			= 	strtoupper($this->input->post('txtNoKontrolHeader'));
			$nomorRevisi 			= 	$this->input->post('txtNoRevisiHeader');
			$tanggalRevisi 			= 	$this->general->konversiTanggalkeDatabase($this->input->post('txtTanggalHeader'), 'tanggal');
			$jumlahHalaman 			= 	$this->input->post('txtJmlHalamanHeader');
			$pekerjaPembuat 		= 	$this->input->post('cmbPekerjaDibuat');
			$pekerjaPemeriksa1 		= 	$this->input->post('cmbPekerjaDiperiksa1');
			$pekerjaPemeriksa2 		= 	$this->input->post('cmbPekerjaDiperiksa2');
			$pekerjaPemberiKeputusan=	$this->input->post('cmbPekerjaDiputuskan');
			$info 					= 	$this->input->post('txaCdInfoHeader');
			$inputfile 				= 	'txtCdFileHeader';
			$namaDokumen			= 	str_replace(' ', '_', $nomorKontrol).'_-_'.$nomorRevisi.'_-_'.str_replace(' ','_',$namaContextDiagram);
			$fileDokumen;
			$tanggalUpload;

			if($pekerjaPemeriksa1=='' OR $pekerjaPemeriksa1==NULL OR $pekerjaPemeriksa1==' ')
			{
				$pekerjaPemeriksa1=NULL;
			}

			if($pekerjaPemeriksa2=='' OR $pekerjaPemeriksa2==NULL OR $pekerjaPemeriksa2==' ')
			{
				$pekerjaPemeriksa2=NULL;
			}

			$fileDokumen 			= 	$this->general->uploadDokumen($inputfile, $namaDokumen, direktoriUpload);
			if(is_null($fileDokumen)==FALSE)
			{
				$tanggalUpload 		=  	$this->general->ambilWaktuEksekusi();
			}
			$data = array(
				'cd_name' 			=> $namaContextDiagram,
				'cd_file' 			=> $fileDokumen,
				'no_kontrol' 		=> $nomorKontrol,
				'no_revisi' 		=> $nomorRevisi,
				'tanggal' 			=> $tanggalRevisi,
				'dibuat' 			=> $pekerjaPembuat,
				'diperiksa_1' 		=> $pekerjaPemeriksa1,
				'diperiksa_2' 		=> $pekerjaPemeriksa2,
				'diputuskan' 		=> $pekerjaPemberiKeputusan,
				'jml_halaman'		=> $jumlahHalaman,
				'cd_info' 			=> $info,
				'tgl_upload' 		=> $tanggalUpload,
				'tgl_insert'		=> $this->general->ambilWaktuEksekusi(),
				'bp_id' 			=> $BusinessProcess,
    		);
			$this->M_contextdiagram->setContextDiagram($data);
			$header_id = $this->db->insert_id();
			//insert to sys.log_activity
			$aksi = 'DOC STANDARIZATION';
			$detail = "Set Context Diagram id=$header_id";
			$this->log_activity->activity_log($aksi, $detail);
			//

			redirect(site_url('DocumentStandarization/CD'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Context Diagram';
		$data['Menu'] = 'Upload Dokumen';
		$data['SubMenuOne'] = 'Context Diagram';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['ContextDiagram'] = $this->M_contextdiagram->getContextDiagram($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('txtCdNameHeader', 'Nama Context Diagram', 'required');
		$this->form_validation->set_rules('cmbBusinessProcess', 'Business Process', 'required');
		$this->form_validation->set_rules('txtNoKontrolHeader', 'Nomor Kontrol', 'required');
		$this->form_validation->set_rules('txtNoRevisiHeader', 'Nomor Revisi', 'required');
		$this->form_validation->set_rules('txtTanggalHeader', 'Tanggal Revisi', 'required');
		$this->form_validation->set_rules('txtJmlHalamanHeader', 'Jumlah Halaman', 'required');
		$this->form_validation->set_rules('cmbPekerjaDibuat', 'Pekerja Pembuat', 'required');
		// $this->form_validation->set_rules('cmbPekerjaDiperiksa1', 'Pekerja Pemeriksa 1', 'required');
		$this->form_validation->set_rules('cmbPekerjaDiputuskan', 'Pekerja Pemberi Keputusan', 'required');


		if ($this->form_validation->run() === FALSE) {
			$data['daftarBusinessProcess'] 	= 	$this->M_general->ambilDaftarBusinessProcess();

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('DocumentStandarization/ContextDiagram/V_update', $data);
			$this->load->view('V_Footer',$data);
		} else {

			$namaContextDiagram		= 	strtoupper($this->input->post('txtCdNameHeader', TRUE));
			$BusinessProcess 		= 	$this->input->post('cmbBusinessProcess', TRUE);
			$nomorKontrol 			= 	strtoupper($this->input->post('txtNoKontrolHeader', TRUE));
			$nomorRevisi 			= 	$this->input->post('txtNoRevisiHeader', TRUE);
			$tanggalRevisi 			= 	$this->general->konversiTanggalkeDatabase($this->input->post('txtTanggalHeader', TRUE), 'tanggal');
			$jumlahHalaman 			= 	$this->input->post('txtJmlHalamanHeader', TRUE);
			$pekerjaPembuat 		= 	$this->input->post('cmbPekerjaDibuat', TRUE);
			$pekerjaPemeriksa1 		= 	$this->input->post('cmbPekerjaDiperiksa1', TRUE);
			$pekerjaPemeriksa2 		= 	$this->input->post('cmbPekerjaDiperiksa2', TRUE);
			$pekerjaPemberiKeputusan=	$this->input->post('cmbPekerjaDiputuskan', TRUE);
			$info 					= 	$this->input->post('txaCdInfoHeader', TRUE);
			$inputfile 				= 	'txtCdFileHeader';
			$fileDokumen			= 	$this->input->post('DokumenAwal', TRUE);
			$tanggalUpload			= 	$this->general->konversiTanggalkeDatabase(($this->input->post('WaktuUpload', TRUE)), 'datetime');
			$namaDokumen			= 	str_replace(' ', '_', $nomorKontrol).'_-_'.$nomorRevisi.'_-_'.str_replace(' ','_',$namaContextDiagram);

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
				$revisiBaru 		= 	0;
			}

			if($revisiBaru==1 AND $angkaRevisiBaru>$angkaRevisiLama AND strtotime($tanggalRevisi)>strtotime($tanggalRevisiLama))
			{
				$kodeContextDiagram 	= 	$plaintext_string;
				$dataLama 	= 	$this->M_contextdiagram->ambilDataLama($kodeContextDiagram);

				$doc_id 		= 	$dataLama[0]['cd_id'];
				$name 			= 	$dataLama[0]['cd_name'];
				$file 			= 	$dataLama[0]['cd_file'];
				$no_kontrol 	= 	$dataLama[0]['no_kontrol'];
				$no_revisi 		=	$dataLama[0]['no_revisi'];
				$tanggal 		= 	$dataLama[0]['tanggal'];
				$dibuat 		= 	$dataLama[0]['dibuat'];
				$diperiksa_1 	= 	$dataLama[0]['diperiksa_1'];
				$diperiksa_2 	= 	$dataLama[0]['diperiksa_2'];
				$diputuskan 	= 	$dataLama[0]['diputuskan'];
				$jml_halaman 	= 	$dataLama[0]['jml_halaman'];
				$info 			= 	$dataLama[0]['cd_info'];
				$tgl_upload 	= 	$dataLama[0]['tgl_upload'];
				$tgl_insert 	= 	$dataLama[0]['tgl_insert'];

				$jenis_doc 		= 	'CD';
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
				$this->M_contextdiagram->inputDataLamakeHistory($recordLama);
			}
			// Salin sampai sini


			if($pekerjaPemeriksa1=='' OR $pekerjaPemeriksa1==NULL OR $pekerjaPemeriksa1==' ')
			{
				$pekerjaPemeriksa1=NULL;
			}

			if($pekerjaPemeriksa2=='' OR $pekerjaPemeriksa2==NULL OR $pekerjaPemeriksa2==' ')
			{
				$pekerjaPemeriksa2=NULL;
			}

			$fileDokumen 			= 	$this->general->uploadDokumen($inputfile, $namaDokumen, direktoriUpload);

			if(is_null($fileDokumen))
			{
				if(($revisiBaru==0 || $fileDokumen!=NULL) && $inputfile==NULL)
				{
					$fileDokumen = $this->general->cekFile($namaContextDiagram, $nomorRevisi, $nomorKontrol, $fileDokumen, direktoriUpload);
				}
			}
			else
			{
				$tanggalUpload 		=  	$this->general->ambilWaktuEksekusi();
			}



			if($revisiBaru==0)
			{
				$data = array(
					'cd_name' 		=> $namaContextDiagram,
					'cd_file' 		=> $fileDokumen,
					'no_kontrol' 	=> $nomorKontrol,
					'no_revisi' 	=> $nomorRevisi,
					'tanggal' 		=> $tanggalRevisi,
					'dibuat' 		=> $pekerjaPembuat,
					'diperiksa_1' 	=> $pekerjaPemeriksa1,
					'diperiksa_2' 	=> $pekerjaPemeriksa2,
					'diputuskan' 	=> $pekerjaPemberiKeputusan,
					'jml_halaman' 	=> $jumlahHalaman,
					'cd_info' 		=> $info,
					'tgl_upload' 	=> $tanggalUpload,
					'bp_id' 		=> $BusinessProcess,
	    			);
				$this->M_contextdiagram->updateContextDiagram($data, $plaintext_string);
			}
			elseif ($revisiBaru==1)
			{
				$data = array(
					'cd_name' 		=> $namaContextDiagram,
					'cd_file' 		=> $fileDokumen,
					'no_kontrol' 	=> $nomorKontrol,
					'no_revisi' 	=> $nomorRevisi,
					'tanggal' 		=> $tanggalRevisi,
					'dibuat' 		=> $pekerjaPembuat,
					'diperiksa_1' 	=> $pekerjaPemeriksa1,
					'diperiksa_2' 	=> $pekerjaPemeriksa2,
					'diputuskan' 	=> $pekerjaPemberiKeputusan,
					'jml_halaman' 	=> $jumlahHalaman,
					'cd_info' 		=> $info,
					'tgl_upload' 	=> $tanggalUpload,
					'bp_id' 		=> $BusinessProcess,
					'update_revisi' => $this->general->ambilWaktuEksekusi(),
	    			);
				$this->M_contextdiagram->updateContextDiagram($data, $plaintext_string);
			}
			//insert to sys.log_activity
			$aksi = 'DOC STANDARIZATION';
			$detail = "Update Context Diagram id=$plaintext_string";
			$this->log_activity->activity_log($aksi, $detail);
			//
			redirect(site_url('DocumentStandarization/CD'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Context Diagram';
		$data['Menu'] = 'Upload Dokumen';
		$data['SubMenuOne'] = 'Context Diagram';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['ContextDiagram'] = $this->M_contextdiagram->getContextDiagram($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/ContextDiagram/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_contextdiagram->deleteContextDiagram($plaintext_string);
		//insert to sys.log_activity
		$aksi = 'DOC STANDARIZATION';
		$detail = "Delete Context Diagram id=$plaintext_string";
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect(site_url('DocumentStandarization/CD'));
    }



}

/* End of file C_ContextDiagram.php */
/* Location: ./application/controllers/OTHERS/MainMenu/C_ContextDiagram.php */
/* Generated automatically on 2017-09-14 11:00:26 */
