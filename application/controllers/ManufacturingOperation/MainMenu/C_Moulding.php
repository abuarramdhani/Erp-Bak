<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Moulding extends CI_Controller
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
		$this->load->model('ManufacturingOperation/MainMenu/M_moulding');

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

		$data['Title'] = 'Moulding';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Moulding'] = $this->M_moulding->getMoulding();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperation/Moulding/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Moulding';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('txtComponentCodeHeader', 'ComponentCode', 'required');
		$this->form_validation->set_rules('txtProductionDateHeader', 'ProductionDate', 'required');
		$this->form_validation->set_rules('txtMouldingQuantityHeader', 'MouldingQuantity', 'required');
		$this->form_validation->set_rules('txtScrapQuantityHeader', 'ScrapQuantity', 'required');
		$this->form_validation->set_rules('txtScrapTypeHeader', 'ScrapType', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('ManufacturingOperation/Moulding/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'component_code' => $this->input->post('txtComponentCodeHeader'),
				'component_description' => $this->input->post('txtComponentDescriptionHeader'),
				'production_date' => $this->input->post('txtProductionDateHeader'),
				'moulding_quantity' => $this->input->post('txtMouldingQuantityHeader'),
				'job_id' => $this->input->post('txtJobIdHeader'),
				'scrap_quantity' => $this->input->post('txtScrapQuantityHeader'),
				'scrap_type' => $this->input->post('txtScrapTypeHeader'),
				'created_by' => $this->session->userid,
    		);
			$this->M_moulding->setMoulding($data);
			$header_id = $this->db->insert_id();

			redirect(site_url('ManufacturingOperation/Moulding'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Moulding';
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
		$data['Moulding'] = $this->M_moulding->getMoulding($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('txtComponentCodeHeader', 'ComponentCode', 'required');
		$this->form_validation->set_rules('txtProductionDateHeader', 'ProductionDate', 'required');
		$this->form_validation->set_rules('txtMouldingQuantityHeader', 'MouldingQuantity', 'required');
		$this->form_validation->set_rules('txtScrapQuantityHeader', 'ScrapQuantity', 'required');
		$this->form_validation->set_rules('txtScrapTypeHeader', 'ScrapType', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('ManufacturingOperation/Moulding/V_update', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'component_code' => $this->input->post('txtComponentCodeHeader',TRUE),
				'component_description' => $this->input->post('txtComponentDescriptionHeader',TRUE),
				'production_date' => $this->input->post('txtProductionDateHeader',TRUE),
				'moulding_quantity' => $this->input->post('txtMouldingQuantityHeader',TRUE),
				'job_id' => $this->input->post('txtJobIdHeader',TRUE),
				'scrap_quantity' => $this->input->post('txtScrapQuantityHeader',TRUE),
				'scrap_type' => $this->input->post('txtScrapTypeHeader',TRUE),
				'last_updated_by' => $this->session->userid,
    			);
			$this->M_moulding->updateMoulding($data, $plaintext_string);

			redirect(site_url('ManufacturingOperation/Moulding'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Moulding';
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
		$data['Moulding'] = $this->M_moulding->getMoulding($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperation/Moulding/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_moulding->deleteMoulding($plaintext_string);

		redirect(site_url('ManufacturingOperation/Moulding'));
    }



}

/* End of file C_Moulding.php */
/* Location: ./application/controllers/ManufacturingOperation/MainMenu/C_Moulding.php */
/* Generated automatically on 2017-12-20 14:49:32 */