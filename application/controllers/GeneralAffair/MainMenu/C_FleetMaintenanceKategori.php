<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_FleetMaintenanceKategori extends CI_Controller
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
		$this->load->model('GeneralAffair/MainMenu/M_fleetmaintenancekategori');

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

		$data['Title'] = 'Kategori Maintenance';
		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Kategori Maintenance';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['kodesie'] = $this->session->kodesie;		

		$data['FleetMaintenanceKategori'] 			= $this->M_fleetmaintenancekategori->getFleetMaintenanceKategori();
		$data['FleetMaintenanceKategoriDeleted']	= $this->M_fleetmaintenancekategori->getFleetMaintenanceKategoriDeleted();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/FleetMaintenanceKategori/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Kategori Maintenance';
		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Kategori Maintenance';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('txtKategoriMaintenanceHeader', 'KategoriMaintenance', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('GeneralAffair/FleetMaintenanceKategori/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {

			$kategoriMaintenance 	= 	$this->input->post('txtKategoriMaintenanceHeader');
			$waktu_eksekusi			= 	date('Y-m-d H:i:s');

			$data = array(
				'maintenance_kategori' 	=> ucwords(strtolower($kategoriMaintenance)),
				'start_date' 			=> $waktu_eksekusi,
				'end_date' 				=> '9999-12-12 00:00:00',
				'creation_date' 		=> $waktu_eksekusi,
				'created_by' 			=> $this->session->userid,
    		);
			$this->M_fleetmaintenancekategori->setFleetMaintenanceKategori($data);
			$header_id = $this->db->insert_id();

			redirect(site_url('GeneralAffair/FleetMaintenanceKategori'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Kategori Maintenance';
		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Kategori Maintenance';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['kodesie'] = $this->session->kodesie;		

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['FleetMaintenanceKategori'] = $this->M_fleetmaintenancekategori->getFleetMaintenanceKategori($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('txtKategoriMaintenanceHeader', 'Kategori Maintenance', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('GeneralAffair/FleetMaintenanceKategori/V_update', $data);
			$this->load->view('V_Footer',$data);	
		} else {

			$kategoriMaintenance 	= 	$this->input->post('txtKategoriMaintenanceHeader', TRUE);
			$tanggal_eksekusi 		= 	date('Y-m-d H:i:s');
			$status_data_user 	=	$this->input->post('CheckAktifUser');
			$status_data 			= 	$this->input->post('CheckAktif');

			$waktu_dihapus 		=	$this->input->post('WaktuDihapus');

			$waktu_eksekusi 	= 	date('Y-m-d H:i:s');

			if ($status_data=='on' || $status_data_user=='on') {
				$waktu_dihapus = '9999-12-12 00:00:00';
			}else{
				$waktu_dihapus = $waktu_eksekusi;
			}

			$data = array(
				'maintenance_kategori' 	=> $kategoriMaintenance,
				'end_date' 				=> $waktu_dihapus,
				'last_updated'	 		=> $tanggal_eksekusi,
				'last_updated_by' 		=> $this->session->userid,
    			);
			$this->M_fleetmaintenancekategori->updateFleetMaintenanceKategori($data, $plaintext_string);

			redirect(site_url('GeneralAffair/FleetMaintenanceKategori'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Kategori Maintenance';
		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Kategori Maintenance';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['FleetMaintenanceKategori'] = $this->M_fleetmaintenancekategori->getFleetMaintenanceKategori($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/FleetMaintenanceKategori/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_fleetmaintenancekategori->deleteFleetMaintenanceKategori($plaintext_string);

		redirect(site_url('GeneralAffair/FleetMaintenanceKategori'));
    }



}

/* End of file C_FleetMaintenanceKategori.php */
/* Location: ./application/controllers/GeneralAffair/MainMenu/C_FleetMaintenanceKategori.php */
/* Generated automatically on 2017-08-05 13:33:39 */