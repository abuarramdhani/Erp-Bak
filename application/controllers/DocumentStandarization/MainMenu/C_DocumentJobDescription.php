<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_DocumentJobDescription extends CI_Controller
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

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('DocumentStandarization/MainMenu/M_jobdeskdocument');
		$this->load->model('DocumentStandarization/MainMenu/M_general');

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

		$data['Title'] = 'Dokumen Job Description';
		$data['Menu'] = 'Job Description';
		$data['SubMenuOne'] = 'Dokumen Job Description';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['JobDescription'] 		= 	$this->M_jobdeskdocument->ambilJobDescription();
		$data['DocumentJobDescription']	=	$this->M_jobdeskdocument->ambilDokumenJobDescription();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/DocumentJobDescription/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Dokumen Job Description';
		$data['Menu'] = 'Job Description';
		$data['SubMenuOne'] = 'Dokumen Job Description';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('cmbDepartemen', 'Departemen', 'required');
		$this->form_validation->set_rules('cmbJD', 'Job Description', 'required');

		if ($this->form_validation->run() === FALSE) {
			$data['ambilDepartemen'] 	= 	$this->M_general->ambilDepartemen();

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('DocumentStandarization/DocumentJobDescription/V_create', $data);
			$this->load->view('V_Footer',$data);
		} else {
			$jobdescID 					= 	$this->input->post('cmbJD');
			$dokumenJobDescription 		= 	$this->input->post('cmbDokumenJobDescription');

			foreach ($dokumenJobDescription as $dokumenJD)
			{
				$data 	= 	array(
						'jd_id' 		=> 	$jobdescID,
						'document_id' 	=> 	$dokumenJD
					);
				$this->M_jobdeskdocument->setJobdeskDocument($data);
				//insert to sys.log_activity
				$aksi = 'DOC STANDARIZATION';
				$detail = "Set Jobdesk id=$jobdescID";
				$this->log_activity->activity_log($aksi, $detail);
				//
			}

			redirect(site_url('DocumentStandarization/DocumentJobDescription'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Dokumen Job Description';
		$data['Menu'] = 'Job Description';
		$data['SubMenuOne'] = 'Dokumen Job Description';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['JobDescription'] 			= $this->M_jobdeskdocument->ambilJobDescription($plaintext_string);
		$data['DocumentJobDescription'] 	= $this->M_jobdeskdocument->ambilDokumenJobDescription($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('cmbDepartemen', 'Departemen', 'required');
		$this->form_validation->set_rules('cmbJD', 'Job Description', 'required');


		if ($this->form_validation->run() === FALSE) {
			$data['ambilDepartemen'] 	= 	$this->M_general->ambilDepartemen();

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('DocumentStandarization/DocumentJobDescription/V_update', $data);
			$this->load->view('V_Footer',$data);
		} else {
			$jobdescID 					= 	$this->input->post('cmbJD');

			$dokumenJobDescription			= $this->input->post('cmbDokumenJobDescription'); // inputan
			$detailIDDokumenJobDescription 	= $this->input->post('hdndetailDokumenJobDesc'); //value detail hidden

			$jumlahIndexDetailIDDokumenJD	= 	count($detailIDDokumenJobDescription);
			for ($i=0; $i < $jumlahIndexDetailIDDokumenJD; $i++)
			{
				$detailIDDokumenJobDescription[$i] 	= 	$this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $detailIDDokumenJobDescription[$i]));
			}

			$detailIDDokumenJD 	= 	implode(', ', array_filter($detailIDDokumenJobDescription));

			// Langkah update
			// 1. Hapus yang tidak ada (data sebelumnya yang sudah tidak dipakai)
			$this->M_jobdeskdocument->deleteUnusedDocumentJD($jobdescID, $detailIDDokumenJD);

			// 2. Update data yang sudah ada
			foreach ($dokumenJobDescription as $i => $loop)
			{
				if($detailIDDokumenJobDescription[$i] != NULL OR $detailIDDokumenJobDescription[$i] != '')
				{
					$dataUpdate[$i] = array(
						'document_id' 	=> 	$dokumenJobDescription[$i]
					);
					$this->M_jobdeskdocument->updateExistDocumentJD($dataUpdate[$i], $detailIDDokumenJobDescription[$i]);
				}
				elseif($detailIDDokumenJobDescription[$i] == NULL OR $detailIDDokumenJobDescription == '')
				{
			// 3. Inputkan data baru yang belum ada sebelumnya di database
					$dataInsert[$i] = array(
						'jd_id' 		=> 	$jobdescID,
						'document_id' 	=> 	$dokumenJobDescription[$i]
					);
					$this->M_jobdeskdocument->setJobdeskDocument($dataInsert[$i]);
				}
			}
			//insert to sys.log_activity
			$aksi = 'DOC STANDARIZATION';
			$detail = "Update Jobdesk id=$jobdescID";
			$this->log_activity->activity_log($aksi, $detail);
			//

			redirect(site_url('DocumentStandarization/DocumentJobDescription'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Dokumen Job Description';
		$data['Menu'] = 'Job Description';
		$data['SubMenuOne'] = 'Dokumen Job Description';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['JobDescription'] 			= $this->M_jobdeskdocument->ambilJobDescription($plaintext_string);
		$data['DocumentJobDescription'] 	= $this->M_jobdeskdocument->ambilDokumenJobDescription($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/DocumentJobDescription/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_jobdeskdocument->deleteJobdeskDocument($plaintext_string);
		//insert to sys.log_activity
		$aksi = 'DOC STANDARIZATION';
		$detail = "Delete Jobdesk id=$plaintext_string";
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect(site_url('DocumentStandarization/DocumentJobDescription'));
    }



}

/* End of file C_JobdeskDocument.php */
/* Location: ./application/controllers/OTHERS/MainMenu/C_JobdeskDocument.php */
/* Generated automatically on 2017-09-14 11:03:46 */
