<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_FleetRekapPajak extends CI_Controller
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
		$this->load->model('GeneralAffair/MainMenu/M_fleetrekappajak');
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

		$data['Title'] = 'Rekap Pajak Kendaraan';
		$data['Menu'] = 'Rekapitulasi';
		$data['SubMenuOne'] = 'Grafik Pajak';
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

		$data['dropdownTahun'] 	= 	$this->M_fleetrekappajak->dropdownTahun();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);

		$this->load->view('GeneralAffair/FleetRekapPajak/V_index');

		$this->load->view('V_Footer',$data);
	}

	public function RekapPajak()
	{
		// $tahun 	= $this->input->post('value');

		$tahun 		= $this->input->post('cmbPeriode');

		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Rekap Pajak Kendaraan';
		$data['Menu'] = 'Rekapitulasi';
		$data['SubMenuOne'] = 'Grafik Pajak';
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

		$data['dropdownTahun'] 	= 	$this->M_fleetrekappajak->dropdownTahun();

		$data['tahun'] 				= $tahun;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);

		$this->load->view('GeneralAffair/FleetRekapPajak/V_proses', $data);

		$this->load->view('V_Footer',$data);


		// echo json_encode($data);
	}

	public function ambilData()
	{
		$lokasi = 	$this->session->kode_lokasi_kerja;
		$tahun 	= 	$this->input->post('tahun');

		if ($lokasi == '01') {
			$data['totalPajak'] 		= $this->M_fleetrekappajak->rekapTotalPajak($tahun); 		
			$data['frekuensiPajak'] 	= $this->M_fleetrekappajak->rekapFrekuensiPajak($tahun);
		}else{
			$data['totalPajak'] 		= $this->M_fleetrekappajak->rekapTotalPajakCabang($tahun,$lokasi); 		
			$data['frekuensiPajak'] 	= $this->M_fleetrekappajak->rekapFrekuensiPajakCabang($tahun,$lokasi);
		}

		echo json_encode($data);
	}
}