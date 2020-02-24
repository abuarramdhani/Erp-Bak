<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_FleetJenisKendaraan extends CI_Controller
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
		$this->load->model('GeneralAffair/MainMenu/M_fleetjeniskendaraan');
		$this->load->model('GeneralAffair/MainMenu/M_location');

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

		$data['Title'] = 'Jenis Kendaraan';
		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Jenis Kendaraan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$datamenu1 = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);

		$location = $this->M_location->getlocation($user_id);
		$lokasi = $location['0']['location_code'];
		$i = 0;
		if ($lokasi == '01') {
			foreach ($datamenu1 as $key) {
				$data['UserSubMenuOne'][$i] = array(
					'user_id' => $key['user_id'],
					'user_group_menu_name' => $key['user_group_menu_name'],
					'user_group_menu_id' => $key['user_group_menu_id'],
					'group_menu_list_id' => $key['group_menu_list_id'],
					'menu_sequence' => $key['menu_sequence'],
					'menu_id' => $key['menu_id'],
					'root_id' => $key['root_id'],
					'menu_title' => $key['menu_title'],
					'menu' => $key['menu'],
					'menu_link' => $key['menu_link'],
					'org_id' => $key['org_id'],
				);
				$i++;
			}
		}else{
			foreach ($datamenu1 as $key) {
				if ($key['menu_id'] !== '289' && $key['menu_id'] !== '290' && $key['menu_id'] !== '291' && $key['menu_id'] !== '296' && $key['menu_id'] !== '478') {
					$data['UserSubMenuOne'][$i] = array(
						'user_id' => $key['user_id'],
						'user_group_menu_name' => $key['user_group_menu_name'],
						'user_group_menu_id' => $key['user_group_menu_id'],
						'group_menu_list_id' => $key['group_menu_list_id'],
						'menu_sequence' => $key['menu_sequence'],
						'menu_id' => $key['menu_id'],
						'root_id' => $key['root_id'],
						'menu_title' => $key['menu_title'],
						'menu' => $key['menu'],
						'menu_link' => $key['menu_link'],
						'org_id' => $key['org_id'],
					);
					$i++;
				}
			}
		}

		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['kodesie'] = $this->session->kodesie;

		$data['FleetJenisKendaraan'] 		= $this->M_fleetjeniskendaraan->getFleetJenisKendaraan();
		$data['FleetJenisKendaraanDeleted']	= $this->M_fleetjeniskendaraan->getFleetJenisKendaraanDeleted();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		if ($lokasi == '01') {
			$this->load->view('GeneralAffair/FleetJenisKendaraan/V_index', $data);
		}else{
			$this->load->view('GeneralAffair/V_error', $data);
		}

		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Jenis Kendaraan';
		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Jenis Kendaraan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$datamenu1 = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);

		$location = $this->M_location->getlocation($user_id);
		$lokasi = $location['0']['location_code'];
		$i = 0;
		if ($lokasi == '01') {
			foreach ($datamenu1 as $key) {
				$data['UserSubMenuOne'][$i] = array(
					'user_id' => $key['user_id'],
					'user_group_menu_name' => $key['user_group_menu_name'],
					'user_group_menu_id' => $key['user_group_menu_id'],
					'group_menu_list_id' => $key['group_menu_list_id'],
					'menu_sequence' => $key['menu_sequence'],
					'menu_id' => $key['menu_id'],
					'root_id' => $key['root_id'],
					'menu_title' => $key['menu_title'],
					'menu' => $key['menu'],
					'menu_link' => $key['menu_link'],
					'org_id' => $key['org_id'],
				);
				$i++;
			}
		}else{
			foreach ($datamenu1 as $key) {
				if ($key['menu_id'] !== '289' && $key['menu_id'] !== '290' && $key['menu_id'] !== '291' && $key['menu_id'] !== '296' && $key['menu_id'] !== '478') {
					$data['UserSubMenuOne'][$i] = array(
						'user_id' => $key['user_id'],
						'user_group_menu_name' => $key['user_group_menu_name'],
						'user_group_menu_id' => $key['user_group_menu_id'],
						'group_menu_list_id' => $key['group_menu_list_id'],
						'menu_sequence' => $key['menu_sequence'],
						'menu_id' => $key['menu_id'],
						'root_id' => $key['root_id'],
						'menu_title' => $key['menu_title'],
						'menu' => $key['menu'],
						'menu_link' => $key['menu_link'],
						'org_id' => $key['org_id'],
					);
					$i++;
				}
			}
		}
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
			$jenisKendaraan 	= 	$this->input->post('txtJenisKendaraanHeader');

			$creation_date 		= 	date('Y-m-d H:i:s');
			$data = array(
				'jenis_kendaraan' 	=> $jenisKendaraan,
				'start_date' 		=> $creation_date,
				'end_date' 			=> '9999-12-12 00:00:00',
				'creation_date' 	=> $creation_date,
				'created_by' 		=> $this->session->userid
    		);
			$this->M_fleetjeniskendaraan->setFleetJenisKendaraan($data);
			$header_id = $this->db->insert_id();
			//insert to t_log
			$aksi = 'MANAGEMENT KENDARAAN';
			$detail = 'Create JEnis Kendaraan = '.$jenisKendaraan;
			$this->log_activity->activity_log($aksi, $detail);
			//

			redirect(site_url('GeneralAffair/FleetJenisKendaraan'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Jenis Kendaraan';
		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Jenis Kendaraan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$datamenu1 = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);

		$location = $this->M_location->getlocation($user_id);
		$lokasi = $location['0']['location_code'];
		$i = 0;
		if ($lokasi == '01') {
			foreach ($datamenu1 as $key) {
				$data['UserSubMenuOne'][$i] = array(
					'user_id' => $key['user_id'],
					'user_group_menu_name' => $key['user_group_menu_name'],
					'user_group_menu_id' => $key['user_group_menu_id'],
					'group_menu_list_id' => $key['group_menu_list_id'],
					'menu_sequence' => $key['menu_sequence'],
					'menu_id' => $key['menu_id'],
					'root_id' => $key['root_id'],
					'menu_title' => $key['menu_title'],
					'menu' => $key['menu'],
					'menu_link' => $key['menu_link'],
					'org_id' => $key['org_id'],
				);
				$i++;
			}
		}else{
			foreach ($datamenu1 as $key) {
				if ($key['menu_id'] !== '289' && $key['menu_id'] !== '290' && $key['menu_id'] !== '291' && $key['menu_id'] !== '296' && $key['menu_id'] !== '478') {
					$data['UserSubMenuOne'][$i] = array(
						'user_id' => $key['user_id'],
						'user_group_menu_name' => $key['user_group_menu_name'],
						'user_group_menu_id' => $key['user_group_menu_id'],
						'group_menu_list_id' => $key['group_menu_list_id'],
						'menu_sequence' => $key['menu_sequence'],
						'menu_id' => $key['menu_id'],
						'root_id' => $key['root_id'],
						'menu_title' => $key['menu_title'],
						'menu' => $key['menu'],
						'menu_link' => $key['menu_link'],
						'org_id' => $key['org_id'],
					);
					$i++;
				}
			}
		}
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['kodesie'] = $this->session->kodesie;

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

			$jenisKendaraan = 	$this->input->post('txtJenisKendaraanHeader', TRUE);
			$status_data 	=	$this->input->post('CheckAktif');
			$status_data_user 	=	$this->input->post('CheckAktifUser');
			// $waktu_dihapus 	=	$this->input->post('WaktuDihapus');


			$waktu_eksekusi = 	date('Y-m-d H:i:s');


			if ($status_data=='on' || $status_data_user=='on') {
				$waktu_dihapus = '9999-12-12 00:00:00';
			}else{
				$waktu_dihapus = $waktu_eksekusi;
			}
			$data = array(
				'jenis_kendaraan' 	=> $jenisKendaraan,
				'end_date' 			=> $waktu_dihapus,
				'last_updated' 		=> $waktu_eksekusi,
				'last_updated_by' 	=> $this->session->userid,
    			);
			$this->M_fleetjeniskendaraan->updateFleetJenisKendaraan($data, $plaintext_string);
			//insert to t_log
			$aksi = 'MANAGEMENT KENDARAAN';
			$detail = 'Update Jenis Kendaraan = '.$jenisKendaraan;
			$this->log_activity->activity_log($aksi, $detail);
			//

			redirect(site_url('GeneralAffair/FleetJenisKendaraan'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Jenis Kendaraan';
		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Jenis Kendaraan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$datamenu1 = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);

		$location = $this->M_location->getlocation($user_id);
		$lokasi = $location['0']['location_code'];
		$i = 0;
		if ($lokasi == '01') {
			foreach ($datamenu1 as $key) {
				$data['UserSubMenuOne'][$i] = array(
					'user_id' => $key['user_id'],
					'user_group_menu_name' => $key['user_group_menu_name'],
					'user_group_menu_id' => $key['user_group_menu_id'],
					'group_menu_list_id' => $key['group_menu_list_id'],
					'menu_sequence' => $key['menu_sequence'],
					'menu_id' => $key['menu_id'],
					'root_id' => $key['root_id'],
					'menu_title' => $key['menu_title'],
					'menu' => $key['menu'],
					'menu_link' => $key['menu_link'],
					'org_id' => $key['org_id'],
				);
				$i++;
			}
		}else{
			foreach ($datamenu1 as $key) {
				if ($key['menu_id'] !== '289' && $key['menu_id'] !== '290' && $key['menu_id'] !== '291' && $key['menu_id'] !== '296' && $key['menu_id'] !== '478') {
					$data['UserSubMenuOne'][$i] = array(
						'user_id' => $key['user_id'],
						'user_group_menu_name' => $key['user_group_menu_name'],
						'user_group_menu_id' => $key['user_group_menu_id'],
						'group_menu_list_id' => $key['group_menu_list_id'],
						'menu_sequence' => $key['menu_sequence'],
						'menu_id' => $key['menu_id'],
						'root_id' => $key['root_id'],
						'menu_title' => $key['menu_title'],
						'menu' => $key['menu'],
						'menu_link' => $key['menu_link'],
						'org_id' => $key['org_id'],
					);
					$i++;
				}
			}
		}
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
		//insert to t_log
		$aksi = 'MANAGEMENT KENDARAAN';
		$detail = 'Delete Jenis Kendaraan ID= '.$plaintext_string;
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect(site_url('GeneralAffair/FleetJenisKendaraan'));
    }



}

/* End of file C_FleetJenisKendaraan.php */
/* Location: ./application/controllers/GeneralAffair/MainMenu/C_FleetJenisKendaraan.php */
/* Generated automatically on 2017-08-05 13:18:43 */
