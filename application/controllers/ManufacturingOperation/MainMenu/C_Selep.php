<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Selep extends CI_Controller
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
		$this->load->model('ManufacturingOperation/MainMenu/M_selep');

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

		$data['Title'] = 'Selep';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Selep'] = $this->M_selep->getSelep();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperation/Selep/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Selep';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('txtSelepDateHeader', 'SelepDate', 'required');
		$this->form_validation->set_rules('txtComponentCodeHeader', 'ComponentCode', 'required');
		$this->form_validation->set_rules('txtComponentDescriptionHeader', 'ComponentDescription', 'required');
		$this->form_validation->set_rules('txtSelepQuantityHeader', 'SelepQuantity', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('ManufacturingOperation/Selep/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'selep_date' => $this->input->post('txtSelepDateHeader'),
				'component_code' => $this->input->post('txtComponentCodeHeader'),
				'component_description' => $this->input->post('txtComponentDescriptionHeader'),
				'selep_quantity' => $this->input->post('txtSelepQuantityHeader'),
				'job_id' => $this->input->post('txtJobIdHeader'),
				'created_by' => $this->session->userid,
    		);
			$this->M_selep->setSelep($data);
			$header_id = $this->db->insert_id();

			redirect(site_url('ManufacturingOperation/Selep'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Selep';
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
		$data['Selep'] = $this->M_selep->getSelep($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('txtSelepDateHeader', 'SelepDate', 'required');
		$this->form_validation->set_rules('txtComponentCodeHeader', 'ComponentCode', 'required');
		$this->form_validation->set_rules('txtComponentDescriptionHeader', 'ComponentDescription', 'required');
		$this->form_validation->set_rules('txtSelepQuantityHeader', 'SelepQuantity', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('ManufacturingOperation/Selep/V_update', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'selep_date' => $this->input->post('txtSelepDateHeader',TRUE),
				'component_code' => $this->input->post('txtComponentCodeHeader',TRUE),
				'component_description' => $this->input->post('txtComponentDescriptionHeader',TRUE),
				'selep_quantity' => $this->input->post('txtSelepQuantityHeader',TRUE),
				'job_id' => $this->input->post('txtJobIdHeader',TRUE),
				'last_updated_by' => $this->session->userid,
    			);
			$this->M_selep->updateSelep($data, $plaintext_string);

			redirect(site_url('ManufacturingOperation/Selep'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Selep';
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
		$data['Selep'] = $this->M_selep->getSelep($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperation/Selep/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_selep->deleteSelep($plaintext_string);

		redirect(site_url('ManufacturingOperation/Selep'));
    }



}

/* End of file C_Selep.php */
/* Location: ./application/controllers/ManufacturingOperation/MainMenu/C_Selep.php */
/* Generated automatically on 2017-12-20 14:52:40 */