<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_FleetKendaraan extends CI_Controller
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
		$this->load->model('GeneralAffair/MainMenu/M_fleetkendaraan');

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

		$data['Title'] = 'Fleet Kendaraan';
		$data['Menu'] = 'General Affair';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['FleetKendaraan'] = $this->M_fleetkendaraan->getFleetKendaraan();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/FleetKendaraan/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Fleet Kendaraan';
		$data['Menu'] = 'General Affair';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */
		$data['FleetJenisKendaraan'] = $this->M_fleetkendaraan->getFleetJenisKendaraan();
		$data['FleetMerkKendaraan'] = $this->M_fleetkendaraan->getFleetMerkKendaraan();
		$data['FleetWarnaKendaraan'] = $this->M_fleetkendaraan->getFleetWarnaKendaraan();

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('txtNomorPolisiHeader', 'NomorPolisi', 'required');
		$this->form_validation->set_rules('cmbJenisKendaraanIdHeader', 'JenisKendaraanId', 'required');
		$this->form_validation->set_rules('cmbMerkKendaraanIdHeader', 'MerkKendaraanId', 'required');
		$this->form_validation->set_rules('cmbWarnaKendaraanIdHeader', 'WarnaKendaraanId', 'required');
		$this->form_validation->set_rules('txtTahunPembuatanHeader', 'TahunPembuatan', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('GeneralAffair/FleetKendaraan/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'nomor_polisi' => $this->input->post('txtNomorPolisiHeader'),
				'jenis_kendaraan_id' => $this->input->post('cmbJenisKendaraanIdHeader'),
				'merk_kendaraan_id' => $this->input->post('cmbMerkKendaraanIdHeader'),
				'warna_kendaraan_id' => $this->input->post('cmbWarnaKendaraanIdHeader'),
				'tahun_pembuatan' => $this->input->post('txtTahunPembuatanHeader'),
				'foto_stnk' => $this->input->post('txtFotoStnkHeader'),
				'foto_bpkb' => $this->input->post('txtFotoBpkbHeader'),
				'foto_kendaraan' => $this->input->post('txtFotoKendaraanHeader'),
				'start_date' => $this->input->post('txtStartDateHeader'),
				'end_date' => $this->input->post('txtEndDateHeader'),
				'creation_date' => 'NOW()',
				'created_by' => $this->session->userid,
    		);
			$this->M_fleetkendaraan->setFleetKendaraan($data);
			$header_id = $this->db->insert_id();

			redirect(site_url('GeneralAffair/FleetKendaraan'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Fleet Kendaraan';
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
		$data['FleetKendaraan'] = $this->M_fleetkendaraan->getFleetKendaraan($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */
		$data['FleetJenisKendaraan'] = $this->M_fleetkendaraan->getFleetJenisKendaraan();
		$data['FleetMerkKendaraan'] = $this->M_fleetkendaraan->getFleetMerkKendaraan();
		$data['FleetWarnaKendaraan'] = $this->M_fleetkendaraan->getFleetWarnaKendaraan();

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('txtNomorPolisiHeader', 'NomorPolisi', 'required');
		$this->form_validation->set_rules('cmbJenisKendaraanIdHeader', 'JenisKendaraanId', 'required');
		$this->form_validation->set_rules('cmbMerkKendaraanIdHeader', 'MerkKendaraanId', 'required');
		$this->form_validation->set_rules('cmbWarnaKendaraanIdHeader', 'WarnaKendaraanId', 'required');
		$this->form_validation->set_rules('txtTahunPembuatanHeader', 'TahunPembuatan', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('GeneralAffair/FleetKendaraan/V_update', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'nomor_polisi' => $this->input->post('txtNomorPolisiHeader',TRUE),
				'jenis_kendaraan_id' => $this->input->post('cmbJenisKendaraanIdHeader',TRUE),
				'merk_kendaraan_id' => $this->input->post('cmbMerkKendaraanIdHeader',TRUE),
				'warna_kendaraan_id' => $this->input->post('cmbWarnaKendaraanIdHeader',TRUE),
				'tahun_pembuatan' => $this->input->post('txtTahunPembuatanHeader',TRUE),
				'foto_stnk' => $this->input->post('txtFotoStnkHeader',TRUE),
				'foto_bpkb' => $this->input->post('txtFotoBpkbHeader',TRUE),
				'foto_kendaraan' => $this->input->post('txtFotoKendaraanHeader',TRUE),
				'start_date' => $this->input->post('txtStartDateHeader',TRUE),
				'end_date' => $this->input->post('txtEndDateHeader',TRUE),
				'last_updated' => 'NOW()',
				'last_updated_by' => $this->session->userid,
    			);
			$this->M_fleetkendaraan->updateFleetKendaraan($data, $plaintext_string);

			redirect(site_url('GeneralAffair/FleetKendaraan'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Fleet Kendaraan';
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
		$data['FleetKendaraan'] = $this->M_fleetkendaraan->getFleetKendaraan($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/FleetKendaraan/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_fleetkendaraan->deleteFleetKendaraan($plaintext_string);

		redirect(site_url('GeneralAffair/FleetKendaraan'));
    }



}

/* End of file C_FleetKendaraan.php */
/* Location: ./application/controllers/GeneralAffair/MainMenu/C_FleetKendaraan.php */
/* Generated automatically on 2017-08-05 13:23:25 */