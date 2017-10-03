
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
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('General');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('DocumentStandarization/MainMenu/M_contextdiagram');
		$this->load->model('DocumentStandarization/MainMenu/M_general');

		$this->load->library('upload');

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

		$data['Title'] = 'Context Diagram';
		$data['Menu'] = 'Dokumen';
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
		$data['Menu'] = 'Dokumen';
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
		$this->form_validation->set_rules('cmbPekerjaDiperiksa1', 'Pekerja Pemeriksa 1', 'required');
		$this->form_validation->set_rules('cmbPekerjaDiputuskan', 'Pekerja Pemberi Keputusan', 'required');

		if ($this->form_validation->run() === FALSE) 
		{
			$data['daftarBusinessProcess'] 	= 	$this->M_general->ambilDaftarBusinessProcess();

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('DocumentStandarization/ContextDiagram/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$namaContextDiagram		= 	$this->input->post('txtCdNameHeader');
			$BusinessProcess 		= 	$this->input->post('cmbBusinessProcess');
			$nomorKontrol 			= 	$this->input->post('txtNoKontrolHeader');
			$nomorRevisi 			= 	$this->input->post('txtNoRevisiHeader');
			$tanggalRevisi 			= 	$this->general->konversiTanggalkeDatabase($this->input->post('txtTanggalHeader'), 'tanggal');
			$jumlahHalaman 			= 	$this->input->post('txtJmlHalamanHeader');
			$pekerjaPembuat 		= 	$this->input->post('cmbPekerjaDibuat');
			$pekerjaPemeriksa1 		= 	$this->input->post('cmbPekerjaDiperiksa1');
			$pekerjaPemeriksa2 		= 	$this->input->post('cmbPekerjaDiperiksa2');
			$pekerjaPemberiKeputusan=	$this->input->post('cmbPekerjaDiputuskan');
			$info 					= 	$this->input->post('txaCdInfoHeader');
			$inputfile 				= 	'txtCdFileHeader';
			$namaDokumen			= 	str_replace(' ', '_', $nomorKontrol).'_-_'.'Rev.'.'_'.$nomorRevisi.'_-_'.str_replace(' ','_',$namaContextDiagram);
			$fileDokumen;
			$tanggalUpload;

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

			redirect(site_url('DocumentStandarization/CD'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Context Diagram';
		$data['Menu'] = 'Dokumen';
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
		$this->form_validation->set_rules('cmbPekerjaDiperiksa1', 'Pekerja Pemeriksa 1', 'required');
		$this->form_validation->set_rules('cmbPekerjaDiputuskan', 'Pekerja Pemberi Keputusan', 'required');


		if ($this->form_validation->run() === FALSE) {
			$data['daftarBusinessProcess'] 	= 	$this->M_general->ambilDaftarBusinessProcess();
			
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('DocumentStandarization/ContextDiagram/V_update', $data);
			$this->load->view('V_Footer',$data);	
		} else {

			$namaContextDiagram		= 	$this->input->post('txtCdNameHeader', TRUE);
			$BusinessProcess 		= 	$this->input->post('cmbBusinessProcess', TRUE);
			$nomorKontrol 			= 	$this->input->post('txtNoKontrolHeader', TRUE);
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
			$namaDokumen			= 	str_replace(' ', '_', $nomorKontrol).'_-_'.'Rev.'.'_'.$nomorRevisi.'_-_'.str_replace(' ','_',$namaContextDiagram);

			if($pekerjaPemeriksa2=='' OR $pekerjaPemeriksa2==NULL OR $pekerjaPemeriksa2==' ')
			{
				$pekerjaPemeriksa2=NULL;
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

			$fileDokumen = $this->general->cekFile($namaContextDiagram, $nomorRevisi, $nomorKontrol, $fileDokumen, direktoriUpload);

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

			redirect(site_url('DocumentStandarization/CD'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Context Diagram';
		$data['Menu'] = 'Dokumen';
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

		redirect(site_url('DocumentStandarization/CD'));
    }



}

/* End of file C_ContextDiagram.php */
/* Location: ./application/controllers/OTHERS/MainMenu/C_ContextDiagram.php */
/* Generated automatically on 2017-09-14 11:00:26 */