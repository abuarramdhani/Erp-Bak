<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Section extends CI_Controller
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
		$this->load->model('ProductionPlanning/Settings/M_section');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Section';
		$data['Menu'] = 'Production Planning';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Section'] = $this->M_section->getSection();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ProductionPlanning/Settings/Section/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Section';
		$data['Menu'] = 'Production Planning';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['locator'] = $this->M_section->getLocatorName();

		$this->form_validation->set_rules('txtSectionNameHeader', 'SectionName', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('ProductionPlanning/Settings/Section/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$locator = $this->input->post('LocatorId');
			$a = explode(' | ', $locator);
			$locator_id = $a[0];
			$locator_name = $a[1];
			if (empty($locator_id)) {
				$locator_id = NULL;
			}
			if (empty($locator_name)) {
				$locator_name = NULL;
			}

			$org_id = $this->input->post('OrganizationId');
			if ($org_id == '0') {
				$org_id = NULL;
			}

			$department_class_code = $this->input->post('DepartementClass');
			if (empty($department_class_code)) {
				$department_class_code = NULL;
			}

			$routing_class = $this->input->post('RoutingClass');
			if (empty($routing_class)) {
				$routing_class = NULL;
			}
			$data = array(
				'section_name'			=> $this->input->post('txtSectionNameHeader',TRUE),
				'locator_id' 			=> $locator_id,
				'locator_name' 			=> $locator_name,
				'org_id' 				=> $org_id,
				'department_class_code' => $department_class_code,
				'routing_class' 		=> $routing_class
    		);

			$this->M_section->setSection($data);
			$header_id = $this->db->insert_id();

			redirect(site_url('ProductionPlanning/Setting/Section'));
		}
	}

	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Section';
		$data['Menu'] = 'Production Planning';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		$data['Section'] = $this->M_section->getSection($plaintext_string);
		$data['locator'] = $this->M_section->getLocatorName();

		$this->form_validation->set_rules('txtSectionNameHeader', 'SectionName', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('ProductionPlanning/Settings/Section/V_update', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$locator = $this->input->post('LocatorId');
			$a = explode(' | ', $locator);
			$locator_id = $a[0];
			$locator_name = $a[1];
			if (empty($locator_id)) {
				$locator_id = NULL;
			}
			if (empty($locator_name)) {
				$locator_name = NULL;
			}

			$org_id = $this->input->post('OrganizationId');
			if ($org_id == '0') {
				$org_id = NULL;
			}

			$department_class_code = $this->input->post('DepartementClass');
			if (empty($department_class_code)) {
				$department_class_code = NULL;
			}

			$routing_class = $this->input->post('RoutingClass');
			if (empty($routing_class)) {
				$routing_class = NULL;
			}
			$data = array(
				'section_name'			=> $this->input->post('txtSectionNameHeader',TRUE),
				'locator_id' 			=> $locator_id,
				'locator_name' 			=> $locator_name,
				'org_id' 				=> $org_id,
				'department_class_code' => $department_class_code,
				'routing_class' 		=> $routing_class
    			);
			$this->M_section->updateSection($data, $plaintext_string);

			redirect(site_url('ProductionPlanning/Setting/Section'));
		}
	}

    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_section->deleteSection($plaintext_string);

		redirect(site_url('ProductionPlanning/Setting/Section'));
    }
}
