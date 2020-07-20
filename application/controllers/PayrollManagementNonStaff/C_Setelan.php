<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Setelan extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('Log_Activity');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PayrollManagementNonStaff/M_setelan');

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

		$data['Title'] = 'Setelan';
		$data['Menu'] = 'Setting';
		$data['SubMenuOne'] = 'Parameter';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Setelan'] = $this->M_setelan->getSetelan();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/Setelan/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Setelan';
		$data['Menu'] = 'Setting';
		$data['SubMenuOne'] = 'Parameter';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['Setelan'] = $this->M_setelan->getSetelan($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('txtSetelanValueHeader', 'SetelanValue', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('PayrollManagementNonStaff/Setelan/V_update', $data);
			$this->load->view('V_Footer',$data);
		} else {
			$data = array(
				'setelan_value' => $this->input->post('txtSetelanValueHeader',TRUE),
				'setelan_info' => $this->input->post('txtSetelanInfoHeader',TRUE),
    			);
			$this->M_setelan->updateSetelan($data, $plaintext_string);
			//insert to sys.log_activity
			$aksi = 'Payroll Management NStaf';
			$detail = "Update setelan value=".$this->input->post('txtSetelanValueHeader')." Info=".$this->input->post('txtSetelanInfoHeader');
			$this->log_activity->activity_log($aksi, $detail);
			//

			redirect(site_url('PayrollManagementNonStaff/Setelan'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Setelan';
		$data['Menu'] = 'Setting';
		$data['SubMenuOne'] = 'Parameter';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['Setelan'] = $this->M_setelan->getSetelan($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/Setelan/V_read', $data);
		$this->load->view('V_Footer',$data);
	}



}

/* End of file C_Setelan.php */
/* Location: ./application/controllers/PayrollManagement/MainMenu/C_Setelan.php */
/* Generated automatically on 2017-04-10 13:41:11 */
