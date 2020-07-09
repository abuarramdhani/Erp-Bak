<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_QualityControl extends CI_Controller
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

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('ManufacturingOperation/MainMenu/M_qualitycontrol');

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

		$data['Title'] = 'Quality Control';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['QualityControl'] = $this->M_qualitycontrol->getQualityControl();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperation/QualityControl/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Quality Control';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('txtCheckingDateHeader', 'CheckingDate', 'required');
		$this->form_validation->set_rules('txtPrintCodeHeader', 'PrintCode', 'required');
		$this->form_validation->set_rules('txtCheckingQuantityHeader', 'CheckingQuantity', 'required');
		$this->form_validation->set_rules('txtScrapQuantityHeader', 'ScrapQuantity', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('ManufacturingOperation/QualityControl/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'checking_date' => $this->input->post('txtCheckingDateHeader'),
				'print_code' => $this->input->post('txtPrintCodeHeader'),
				'checking_quantity' => $this->input->post('txtCheckingQuantityHeader'),
				'scrap_quantity' => $this->input->post('txtScrapQuantityHeader'),
				'created_by' => $this->session->userid,
    		);
			$this->M_qualitycontrol->setQualityControl($data);
			$header_id = $this->db->insert_id();

			redirect(site_url('ManufacturingOperation/QualityControl'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Quality Control';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['QualityControl'] = $this->M_qualitycontrol->getQualityControl($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('txtCheckingDateHeader', 'CheckingDate', 'required');
		$this->form_validation->set_rules('txtPrintCodeHeader', 'PrintCode', 'required');
		$this->form_validation->set_rules('txtCheckingQuantityHeader', 'CheckingQuantity', 'required');
		$this->form_validation->set_rules('txtScrapQuantityHeader', 'ScrapQuantity', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('ManufacturingOperation/QualityControl/V_update', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'checking_date' => $this->input->post('txtCheckingDateHeader',TRUE),
				'print_code' => $this->input->post('txtPrintCodeHeader',TRUE),
				'checking_quantity' => $this->input->post('txtCheckingQuantityHeader',TRUE),
				'scrap_quantity' => $this->input->post('txtScrapQuantityHeader',TRUE),
				'last_updated_by' => $this->session->userid,
    			);
			$this->M_qualitycontrol->updateQualityControl($data, $plaintext_string);

			redirect(site_url('ManufacturingOperation/QualityControl'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Quality Control';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['QualityControl'] = $this->M_qualitycontrol->getQualityControl($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperation/QualityControl/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_qualitycontrol->deleteQualityControl($plaintext_string);

		redirect(site_url('ManufacturingOperation/QualityControl'));
    }



}

/* End of file C_QualityControl.php */
/* Location: ./application/controllers/ManufacturingOperation/MainMenu/C_QualityControl.php */
/* Generated automatically on 2017-12-20 14:51:22 */