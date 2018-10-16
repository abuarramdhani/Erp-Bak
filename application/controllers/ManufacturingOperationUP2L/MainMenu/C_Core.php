<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Core extends CI_Controller
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
		$this->load->model('ManufacturingOperationUP2L/MainMenu/M_core');
		$this->load->model('ManufacturingOperationUP2L/Ajax/M_ajax');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Core';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Core'] = $this->M_core->getCore();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperationUP2L/Core/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Core';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['employee']		= $this->M_ajax->getEmployee();
		
		// echo "<pre>";
		// print_r($data);
		// exit();
		
		$this->form_validation->set_rules('component_code', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('ManufacturingOperationUP2L/Core/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {

			$employee 		= $this->input->post('txt_employee[]');
			$employee_id = '';
			foreach ($employee as $val) {
				$employee = explode('|', $val);
				$no_induk = $employee[0];
				$nama = $employee[1];
				$employee_id = ','+$no_induk;

			}

			$component 		= $this->input->post('component_code');
			$component_code = explode('|', $component);

			$data = array(
				'component_code'		=> $component_code[0],
				'component_description' => $this->input->post('component_description'),
				'production_date'		=> date('Y-m-d H:i:s', strtotime($this->input->post('production_date'))),
				'core_quantity'			=> $this->input->post('core_quantity'),
				'print_code'			=> $this->input->post('print_code'),
				'employee_id'			=> $employee_id,
				'created_by'			=> $user_id,
				'created_date'			=> date('Y-m-d H:i:s')
    		);

			$this->M_core->setCore($data);
			$header_id = $this->db->insert_id();

			$emp = $this->input->post('txt_employee[]');
			$produksi = $this->input->post('txt_produksi[]');
			$lembur = $this->input->post('txt_lembur[]');
			$presensi = $this->input->post('txt_presensi[]');
			$ott = $this->input->post('txt_ott[]');

		

			$i = 0;
			foreach ($emp as $val) {
				
				$employee = explode('|', $val);
				$no_induk = $employee[0];
				$nama = $employee[1];
				$date = date('m-d-Y');
				$data =  array(
						'no_induk' => $no_induk,
						'category_produksi' => 'Core',
						'id_produksi' => $header_id,
						'presensi' => $presensi[$i],
						'produksi' => $produksi[$i],
						'nilai_ott' => $ott[$i],
						'lembur' => $lembur[$i],
						'created_date' =>  $date
						);

				
				$this->M_core->setAbsensi($data);
				$i++;
			}


			redirect(site_url('ManufacturingOperationUP2L/Core'));
		}
	}

	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Core';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id']			= $id;
		$data['employee']	= $this->M_ajax->getEmployee();



		$data['Core'] = $this->M_core->getCore($plaintext_string);

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('ManufacturingOperationUP2L/Core/V_update', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$employee 		= $this->input->post('employee_id');
			$employee_id 	= implode(',', $employee);
			$component 		= $this->input->post('component_code');
			$component_code = explode('|', $component);

			$data = array(
				'component_code'		=> $component_code[0],
				'component_description' => $this->input->post('component_description'),
				'production_date'		=> date('Y-m-d H:i:s', strtotime($this->input->post('production_date'))),
				'core_quantity'			=> $this->input->post('core_quantity'),
				'print_code'			=> $this->input->post('print_code'),
				'employee_id'			=> $employee_id,
				'last_updated_by'		=> $user_id,
				'last_updated_date'		=> date('Y-m-d H:i:s')
    			);
			
			$this->M_core->updateCore($data, $plaintext_string);

			redirect(site_url('ManufacturingOperationUP2L/Core'));
		}
	}

	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Core';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;
		$data['Core'] = $this->M_core->getCore($plaintext_string);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManufacturingOperationUP2L/Core/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_core->deleteCore($plaintext_string);

		redirect(site_url('ManufacturingOperationUP2L/Core'));
    }



}