<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_FleetPicKendaraan extends CI_Controller
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
		$this->load->model('GeneralAffair/MainMenu/M_fleetpickendaraan');

		date_default_timezone_set('Asia/Jakarta');

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

		$data['Title'] = 'PIC Kendaraan';
		$data['Menu'] = 'General Affair';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['PICKendaraan'] 	= $this->M_fleetpickendaraan->getFleetPicKendaraan();
		$data['PICKendaraanDel']= $this->M_fleetpickendaraan->getFleetPicKendaraanDeleted();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/FleetPicKendaraan/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		date_default_timezone_set('Asia/Jakarta');
		$user_id = $this->session->userid;

		$data['Title'] = 'PIC Kendaraan';
		$data['Menu'] = 'General Affair';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */
		$data['FleetKendaraan'] = $this->M_fleetpickendaraan->getFleetKendaraan();
		$data['DaftarNama']		= $this->M_fleetpickendaraan->getDaftarNama();


		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('cmbKendaraanIdHeader', 'Kendaraan', 'required');
		$this->form_validation->set_rules('cmbPekerjaHeader', 'Pekerja', 'required');
		$this->form_validation->set_rules('masaAktifPIC', 'Masa Aktif PIC', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('GeneralAffair/FleetPicKendaraan/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$kodeKendaraan		= 	$this->input->post('cmbKendaraanIdHeader');
			$idPekerja			=	$this->input->post('cmbPekerjaHeader');
			$masaAktifPIC 		= 	$this->input->post('masaAktifPIC');

			$MasaAktifPIC 		=	explode(' - ', $masaAktifPIC);

			$dari 		=	date('Y-m-d H:i:s', strtotime($MasaAktifPIC[0]));
			$sampai 	= 	date('Y-m-d H:i:s', strtotime($MasaAktifPIC[1]));

			$data = array(
				'kendaraan_id' 		=> $kodeKendaraan,
				'dari_periode' 		=> $dari,
				'sampai_periode' 	=> $sampai,
				'start_date' 		=> date('Y-m-d H:i:s'),
				'end_date'			=> '9999-12-12 00:00:00',
				'creation_date' 	=> date('Y-m-d H:i:s'),
				'created_by' 		=> $this->session->userid,
				'employee_id'		=> $idPekerja
    		);
			$this->M_fleetpickendaraan->setFleetPicKendaraan($data);
			$header_id = $this->db->insert_id();

			redirect(site_url('GeneralAffair/FleetPicKendaraan'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Fleet Pic Kendaraan';
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
		$data['FleetPicKendaraan'] = $this->M_fleetpickendaraan->getFleetPicKendaraan($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */
		$data['FleetKendaraan'] = $this->M_fleetpickendaraan->getFleetKendaraan();

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('cmbKendaraanIdHeader', 'KendaraanId', 'required');
		$this->form_validation->set_rules('txtDariPeriodeHeader', 'DariPeriode', 'required');
		$this->form_validation->set_rules('txtSampaiPeriodeHeader', 'SampaiPeriode', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('GeneralAffair/FleetPicKendaraan/V_update', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'kendaraan_id' => $this->input->post('cmbKendaraanIdHeader',TRUE),
				'dari_periode' => $this->input->post('txtDariPeriodeHeader',TRUE),
				'sampai_periode' => $this->input->post('txtSampaiPeriodeHeader',TRUE),
				'start_date' => $this->input->post('txtStartDateHeader',TRUE),
				'end_date' => $this->input->post('txtEndDateHeader',TRUE),
				'last_updated' => 'NOW()',
				'last_updated_by' => $this->session->userid,
    			);
			$this->M_fleetpickendaraan->updateFleetPicKendaraan($data, $plaintext_string);

			redirect(site_url('GeneralAffair/FleetPicKendaraan'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Fleet Pic Kendaraan';
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
		$data['FleetPicKendaraan'] = $this->M_fleetpickendaraan->getFleetPicKendaraan($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/FleetPicKendaraan/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_fleetpickendaraan->deleteFleetPicKendaraan($plaintext_string);

		redirect(site_url('GeneralAffair/FleetPicKendaraan'));
    }



}

/* End of file C_FleetPicKendaraan.php */
/* Location: ./application/controllers/GeneralAffair/MainMenu/C_FleetPicKendaraan.php */
/* Generated automatically on 2017-08-05 13:32:47 */