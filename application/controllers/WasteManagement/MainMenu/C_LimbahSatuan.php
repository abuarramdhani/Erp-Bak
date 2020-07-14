<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_LimbahSatuan extends CI_Controller
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
		$this->load->model('WasteManagement/MainMenu/M_limbahsatuan');

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

		$data['Title'] = 'Limbah Satuan';
		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = 'Satuan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['LimbahSatuan'] = $this->M_limbahsatuan->getLimbahSatuan();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/LimbahSatuan/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Limbah Satuan';
		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = 'Satuan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('txtLimbahSatuanHeader', 'satuan', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('WasteManagement/LimbahSatuan/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'limbah_satuan' => $this->input->post('txtLimbahSatuanHeader'),
    		);
			$this->M_limbahsatuan->setLimbahSatuan($data);
			$header_id = $this->db->insert_id();

			redirect(site_url('WasteManagement/LimbahSatuan'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Limbah Satuan';
		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = 'Satuan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['LimbahSatuan'] = $this->M_limbahsatuan->getLimbahSatuan($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('txtLimbahSatuanHeader', 'satuan', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('WasteManagement/LimbahSatuan/V_update', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'limbah_satuan' => $this->input->post('txtLimbahSatuanHeader',TRUE),
    			);
			$this->M_limbahsatuan->updateLimbahSatuan($data, $plaintext_string);

			redirect(site_url('WasteManagement/LimbahSatuan'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Limbah Satuan';
		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = 'Satuan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['LimbahSatuan'] = $this->M_limbahsatuan->getLimbahSatuan($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagement/LimbahSatuan/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_limbahsatuan->deleteLimbahSatuan($plaintext_string);

		redirect(site_url('WasteManagement/LimbahSatuan'));
    }



}

/* End of file C_LimbahSatuan.php */
/* Location: ./application/controllers/GeneralAffair/MainMenu/C_LimbahSatuan.php */
/* Generated automatically on 2017-11-13 08:50:52 */