<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_FleetJenisKendaraan extends CI_Controller
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
		$this->load->model('GeneralAffair/MainMenu/M_fleetjeniskendaraan');

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

		$data['Title'] = 'Fleet Jenis Kendaraan';
		$data['Menu'] = 'General Affair';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['FleetJenisKendaraan'] = $this->M_fleetjeniskendaraan->getFleetJenisKendaraan();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/FleetJenisKendaraan/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Fleet Jenis Kendaraan';
		$data['Menu'] = 'General Affair';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('txtJenisKendaraanHeader', 'JenisKendaraan', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('GeneralAffair/FleetJenisKendaraan/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'jenis_kendaraan' => $this->input->post('txtJenisKendaraanHeader'),
				'start_date' => $this->input->post('txtStartDateHeader'),
				'end_date' => $this->input->post('txtEndDateHeader'),
				'creation_date' => 'NOW()',
				'created_by' => $this->session->userid,
    		);
			$this->M_fleetjeniskendaraan->setFleetJenisKendaraan($data);
			$header_id = $this->db->insert_id();

			redirect(site_url('GeneralAffair/FleetJenisKendaraan'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Fleet Jenis Kendaraan';
		$data['Menu'] = 'General Affair';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['FleetJenisKendaraan'] = $this->M_fleetjeniskendaraan->getFleetJenisKendaraan($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('txtJenisKendaraanHeader', 'JenisKendaraan', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('GeneralAffair/FleetJenisKendaraan/V_update', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'jenis_kendaraan' => $this->input->post('txtJenisKendaraanHeader',TRUE),
				'start_date' => $this->input->post('txtStartDateHeader',TRUE),
				'end_date' => $this->input->post('txtEndDateHeader',TRUE),
				'last_updated' => 'NOW()',
				'last_updated_by' => $this->session->userid,
    			);
			$this->M_fleetjeniskendaraan->updateFleetJenisKendaraan($data, $plaintext_string);

			redirect(site_url('GeneralAffair/FleetJenisKendaraan'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Fleet Jenis Kendaraan';
		$data['Menu'] = 'General Affair';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['FleetJenisKendaraan'] = $this->M_fleetjeniskendaraan->getFleetJenisKendaraan($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/FleetJenisKendaraan/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_fleetjeniskendaraan->deleteFleetJenisKendaraan($plaintext_string);

		redirect(site_url('GeneralAffair/FleetJenisKendaraan'));
    }



}

/* End of file C_FleetJenisKendaraan.php */
/* Location: ./application/controllers/GeneralAffair/MainMenu/C_FleetJenisKendaraan.php */
/* Generated automatically on 2017-08-05 13:18:43 */