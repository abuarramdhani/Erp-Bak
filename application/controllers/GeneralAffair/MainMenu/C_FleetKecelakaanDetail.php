<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_FleetKecelakaanDetail extends CI_Controller
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
		$this->load->model('GeneralAffair/MainMenu/M_fleetkecelakaandetail');
		$this->load->model('GeneralAffair/MainMenu/M_location');
		
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

		$data['Title'] = 'Fleet Kecelakaan Detail';
		$data['Menu'] = 'General Affair';
		$data['SubMenuOne'] = '';
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

		$data['FleetKecelakaanDetail'] = $this->M_fleetkecelakaandetail->getFleetKecelakaanDetail();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/FleetKecelakaanDetail/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Fleet Kecelakaan Detail';
		$data['Menu'] = 'General Affair';
		$data['SubMenuOne'] = '';
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

		$this->form_validation->set_rules('txtKecelakaanIdHeader', 'KecelakaanId', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('GeneralAffair/FleetKecelakaanDetail/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'kecelakaan_id' => $this->input->post('txtKecelakaanIdHeader'),
				'kerusakan' => $this->input->post('txtKerusakanHeader'),
				'start_date' => $this->input->post('txtStartDateHeader'),
				'end_date' => $this->input->post('txtEndDateHeader'),
				'creation_date' => 'NOW()',
				'created_by' => $this->session->userid,
    		);
			$this->M_fleetkecelakaandetail->setFleetKecelakaanDetail($data);
			$header_id = $this->db->insert_id();

			redirect(site_url('GeneralAffair/FleetKecelakaanDetail'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Fleet Kecelakaan Detail';
		$data['Menu'] = 'General Affair';
		$data['SubMenuOne'] = '';
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
		$data['FleetKecelakaanDetail'] = $this->M_fleetkecelakaandetail->getFleetKecelakaanDetail($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('txtKecelakaanIdHeader', 'KecelakaanId', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('GeneralAffair/FleetKecelakaanDetail/V_update', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'kecelakaan_id' => $this->input->post('txtKecelakaanIdHeader',TRUE),
				'kerusakan' => $this->input->post('txtKerusakanHeader',TRUE),
				'start_date' => $this->input->post('txtStartDateHeader',TRUE),
				'end_date' => $this->input->post('txtEndDateHeader',TRUE),
				'last_updated' => 'NOW()',
				'last_updated_by' => $this->session->userid,
    			);
			$this->M_fleetkecelakaandetail->updateFleetKecelakaanDetail($data, $plaintext_string);

			redirect(site_url('GeneralAffair/FleetKecelakaanDetail'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Fleet Kecelakaan Detail';
		$data['Menu'] = 'General Affair';
		$data['SubMenuOne'] = '';
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
		$data['FleetKecelakaanDetail'] = $this->M_fleetkecelakaandetail->getFleetKecelakaanDetail($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/FleetKecelakaanDetail/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_fleetkecelakaandetail->deleteFleetKecelakaanDetail($plaintext_string);

		redirect(site_url('GeneralAffair/FleetKecelakaanDetail'));
    }



}

/* End of file C_FleetKecelakaanDetail.php */
/* Location: ./application/controllers/GeneralAffair/MainMenu/C_FleetKecelakaanDetail.php */
/* Generated automatically on 2017-08-05 14:11:34 */