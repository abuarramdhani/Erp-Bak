<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MasterJobDescription extends CI_Controller
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
		$this->load->model('DocumentStandarization/MainMenu/M_jobdesk');
		$this->load->model('DocumentStandarization/MainMenu/M_general');

		$this->checkSession();
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

		$data['Title'] = 'Master Job Description';
		$data['Menu'] = 'Job Description';
		$data['SubMenuOne'] = 'Master Job Description';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Jobdesk'] = $this->M_jobdesk->getJobdesk();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/MasterJobDescription/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Master Job Description';
		$data['Menu'] = 'Job Description';
		$data['SubMenuOne'] = 'Master Job Description';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('txtJdNameHeader', 'Nama Job Description', 'required');
		$this->form_validation->set_rules('txaJdDetailHeader', 'Detail Job Description', 'required');
		$this->form_validation->set_rules('cmbDepartemen', 'Departemen', 'required');

		if ($this->form_validation->run() === FALSE) {
			$data['ambilDepartemen'] 	= 	$this->M_general->ambilDepartemen();

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('DocumentStandarization/MasterJobDescription/V_create', $data);
			$this->load->view('V_Footer',$data);
		} else {

			$namaJobDescription 	= 	strtoupper($this->input->post('txtJdNameHeader'));
			$detailJobDescription 	= 	$this->input->post('txaJdDetailHeader');
			$kodeDepartemen 		=	$this->input->post('cmbDepartemen');
			$kodeBidang				= 	$this->input->post('cmbBidang');
			$kodeUnit				= 	$this->input->post('cmbUnit');
			$kodeSeksi 				= 	$this->input->post('cmbSeksi');

			$kodesie;

			if($kodeSeksi=='' OR $kodeSeksi==' ' OR $kodeSeksi==NULL)
			{
				if($kodeUnit=='' OR $kodeUnit==' ' OR $kodeUnit==NULL)
				{
					if($kodeBidang=='' OR $kodeUnit==' ' OR $kodeBidang=NULL)
					{
						$kodesie 	= 	$kodeDepartemen;
					}
					else
					{
						$kodesie 	= 	$kodeBidang;
					}
				}
				else
				{
					$kodesie 		= 	$kodeUnit;
				}
			}
			else
			{
				$kodesie 			= 	$kodeSeksi;
			}

			$data = array(
				'jd_name' 	=> $namaJobDescription,
				'jd_detail' => $detailJobDescription,
				'kodesie' 	=> $kodesie,
    		);
			$this->M_jobdesk->setJobdesk($data);
			$header_id = $this->db->insert_id();
			//insert to sys.log_activity
			$aksi = 'DOC STANDARIZATION';
			$detail = "Set Master Jobdesk id=$header_id";
			$this->log_activity->activity_log($aksi, $detail);
			//

			redirect(site_url('DocumentStandarization/MasterJobDescription'));
		}
	}


	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Master Job Description';
		$data['Menu'] = 'Job Description';
		$data['SubMenuOne'] = 'Master Job Description';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['Jobdesk'] = $this->M_jobdesk->getJobdesk($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('txtJdNameHeader', 'Nama Job Description', 'required');
		$this->form_validation->set_rules('txaJdDetailHeader', 'Detail Job Description', 'required');
		$this->form_validation->set_rules('cmbDepartemen', 'Departemen', 'required');

		if ($this->form_validation->run() === FALSE) {
			$data['ambilDepartemen'] 	= 	$this->M_general->ambilDepartemen();

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('DocumentStandarization/MasterJobDescription/V_update', $data);
			$this->load->view('V_Footer',$data);
		} else {
			$namaJobDescription 	= 	strtoupper($this->input->post('txtJdNameHeader', TRUE));
			$detailJobDescription 	= 	$this->input->post('txaJdDetailHeader', TRUE);
			$kodeDepartemen 		=	$this->input->post('cmbDepartemen', TRUE);
			$kodeBidang				= 	$this->input->post('cmbBidang', TRUE);
			$kodeUnit				= 	$this->input->post('cmbUnit', TRUE);
			$kodeSeksi 				= 	$this->input->post('cmbSeksi', TRUE);

			$kodesie;

			if($kodeSeksi=='' OR $kodeSeksi==' ' OR $kodeSeksi==NULL)
			{
				if($kodeUnit=='' OR $kodeUnit==' ' OR $kodeUnit==NULL)
				{
					if($kodeBidang=='' OR $kodeUnit==' ' OR $kodeBidang=NULL)
					{
						$kodesie 	= 	$kodeDepartemen;
					}
					else
					{
						$kodesie 	= 	$kodeBidang;
					}
				}
				else
				{
					$kodesie 		= 	$kodeUnit;
				}
			}
			else
			{
				$kodesie 			= 	$kodeSeksi;
			}

			$data = array(
				'jd_name' 	=> $namaJobDescription,
				'jd_detail' => $detailJobDescription,
				'kodesie' 	=> $kodesie,
    		);
			$this->M_jobdesk->updateJobdesk($data, $plaintext_string);
			//insert to sys.log_activity
			$aksi = 'DOC STANDARIZATION';
			$detail = "Update Master Jobdesk id=$plaintext_string";
			$this->log_activity->activity_log($aksi, $detail);
			//

			redirect(site_url('DocumentStandarization/MasterJobDescription'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Master Job Description';
		$data['Menu'] = 'Job Description';
		$data['SubMenuOne'] = 'Master Job Description';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['Jobdesk'] = $this->M_jobdesk->getJobdesk($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('DocumentStandarization/MasterJobDescription/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_jobdesk->deleteJobdesk($plaintext_string);
		//insert to sys.log_activity
		$aksi = 'DOC STANDARIZATION';
		$detail = "Delete Master Jobdesk id=$plaintext_string";
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect(site_url('DocumentStandarization/MasterJobDescription'));
    }



}

/* End of file C_Jobdesk.php */
/* Location: ./application/controllers/OTHERS/MainMenu/C_Jobdesk.php */
/* Generated automatically on 2017-09-14 11:03:22 */
