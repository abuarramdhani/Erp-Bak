
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_FleetServiceKendaraan extends CI_Controller
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
		$this->load->library('ciqrcode');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('GeneralAffair/MainMenu/M_fleetservicekendaraan');
		$this->load->model('GeneralAffair/MainMenu/M_location');

    	$this->load->helper('download');
		date_default_timezone_set('Asia/Jakarta');

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
		$lokasi = $this->session->kode_lokasi_kerja;

		$data['Title'] = 'Service Kendaraan';
		$data['Menu'] = 'Proses';
		$data['SubMenuOne'] = 'Service Kendaraan';
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

		// echo $lokasi;
		// exit();

		$data['FleetService'] 		= $this->M_fleetservicekendaraan->getFleetService();


		$data['FleetServiceDeleted']	= $this->M_fleetservicekendaraan->getFleetServiceKendaraanDeleted();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/FleetServiceKendaraan/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function ambilMerkKendaraan()
	{
		$p 		= 	$this->input->get('term');
		$data 	=	$this->M_fleetservicekendaraan->ambilMerkKendaraan($p);

		echo json_encode($data);
	}

	public function ambilJenisService()
	{
		$p 		= 	$this->input->get('term');
		$data 	=	$this->M_fleetservicekendaraan->ambilJenisService($p);

		echo json_encode($data);
	}

	public function before_create()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;
		$lokasi = $this->session->kode_lokasi_kerja;

		$data['Title'] = 'Service Kendaraan';
		$data['Menu'] = 'Proses';
		$data['SubMenuOne'] = 'Service Kendaraan';
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

		// echo $lokasi;
		// exit();
		$merk 			= $this->input->post('txtMerkKendaraan');
		$jenis_service 	= $this->input->post('jenis_service');
		$jarak_awal		= $this->input->post('jarak_awal');
		$kelipatan_jarak = $this->input->post('kelipatan_jarak');
		$lama_awal 		 = $this->input->post('lama_awal');
		$kelipatan_waktu = $this->input->post('kelipatan_waktu');
		$batas 			 = $this->input->post('batas_lama');

		$ru_merk = array(
					'merk_kendaraan_id' => $merk,
				);
		$ru_jenis = array(
					'jenis_service_id' => $jenis_service,
				);
		$data_merk = $this->M_fleetservicekendaraan->ambildatamerk($ru_merk);
		$data_jenis_service = $this->M_fleetservicekendaraan->ambildatajenisservice($ru_jenis);
		$nama_merk = $data_merk[0]['merk_kendaraan'];
		$jenis = $data_jenis_service[0]['jenis_service'];
		$data['item']  = array(
							'merk' 				=> $nama_merk,
							'jenis_service' 	=> $jenis,
							'jarak_awal' 		=> $jarak_awal,
							'kelipatan_jarak' 	=> $kelipatan_jarak,
							'lama_awal' 		=> $lama_awal,
							'kelipatan_waktu'	=> $kelipatan_waktu,
							'batas' 			=> $batas,
						);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/FleetServiceKendaraan/V_b_create', $data);
		$this->load->view('V_Footer',$data);
	}
	/* NEW DATA */
	public function create()
	{
		date_default_timezone_set('Asia/Jakarta');
		$user_id = $this->session->userid;
		$lokasi = $this->session->kode_lokasi_kerja;

		$data['Title'] = 'Service Kendaraan';
		$data['Menu'] = 'Proses';
		$data['SubMenuOne'] = 'Service Kendaraan';
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


		/* LINES DROPDOWN DATA */

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('GeneralAffair/FleetServiceKendaraan/V_create', $data);
			$this->load->view('V_Footer',$data);
		}

	public function saveDataService(){

		$jarak 		=	$this->input->post('jarak[]');
		$waktu 		=	$this->input->post('waktu[]');
		$status		=	$this->input->post('status_service[]');
		$merk 		=	$this->input->post('txtMerkKendaraan');
		$jenis 		=	$this->input->post('jenis_service');

		$ru_merk = array(
					'merk_kendaraan' => $merk,
				);
		$ru_jenis = array(
					'jenis_service' => $jenis,
				);
		$data_merk = $this->M_fleetservicekendaraan->ambildatamerk($ru_merk);
		$data_jenis_service = $this->M_fleetservicekendaraan->ambildatajenisservice($ru_jenis);
		$id_merk = $data_merk[0]['merk_kendaraan_id'];
		$id_jenis = $data_jenis_service[0]['jenis_service_id'];

		$jml 		= count($jarak);

		for ($i=0; $i < $jml; $i++) {
			$ru_where = array(
							'merk_kendaraan_id' => $id_merk,
							'jenis_service_id' => $id_jenis,
							'kilometer' => $jarak[$i],
							'bulan' => $waktu[$i],
						);
			$data_simpan = array(
							'merk_kendaraan_id' => $id_merk,
							'jenis_service_id' => $id_jenis,
							'kilometer' => $jarak[$i],
							'bulan' => $waktu[$i],
							'service' => $status[$i],
							'start_date' => date('Y-m-d H:i:s'),
							'end_date'	=> '9999-12-12 00:00:00',
							'creation_date'	=> date('Y-m-d H:i:s'),
							'created_by'	=> $this->session->userid,
						);
			$ru_data = array(
							'end_date'	=> date('Y-m-d H:i:s'),
							'last_updated'	=> date('Y-m-d H:i:s'),
							'last_updated_by'	=> $this->session->userid,
						);
			$cek 	= $this->M_fleetservicekendaraan->cekAda($ru_where);
			if (empty($cek)) {

				$this->M_fleetservicekendaraan->setFleetServiceKendaraan($data_simpan);
			}else{

				$this->M_fleetservicekendaraan->updateFleetServiceWhenInsert($ru_where,$ru_data);
				$this->M_fleetservicekendaraan->setFleetServiceKendaraan($data_simpan);
			}

		}
		//insert to t_log
		$aksi = 'MANAGEMENT KENDARAAN';
		$detail = 'Create Service Kendaraan MerkID='.$id_merk.' Jenis Servise ID='.$id_jenis;
		$this->log_activity->activity_log($aksi, $detail);
		//
		redirect(site_url('GeneralAffair/FleetServiceKendaraan'));
	}



}

/* End of file C_FleetKendaraan.php */
/* Location: ./application/controllers/GeneralAffair/MainMenu/C_FleetKendaraan.php */
/* Generated automatically on 2017-08-05 13:23:25 */
