<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_FleetMaintenanceKendaraan extends CI_Controller
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
		$this->load->model('GeneralAffair/MainMenu/M_fleetmaintenancekendaraan');
		$this->load->model('GeneralAffair/MainMenu/M_location');

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

		$data['Title'] = 'Maintenance Kendaraan';
		$data['Menu'] = 'Proses';
		$data['SubMenuOne'] = 'Maintenance Kendaraan';
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

		if ($lokasi == '01') {
			$data['FleetMaintenanceKendaraan'] 			= $this->M_fleetmaintenancekendaraan->getFleetMaintenanceKendaraan();
		}else{
			$data['FleetMaintenanceKendaraan'] 			= $this->M_fleetmaintenancekendaraan->getFleetMaintenanceKendaraanCabang($lokasi);
		}

		$data['FleetMaintenanceKendaraanDeleted'] 	= $this->M_fleetmaintenancekendaraan->getFleetMaintenanceKendaraanDeleted();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/FleetMaintenanceKendaraan/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;
		$lokasi = $this->session->kode_lokasi_kerja;

		$data['Title'] = 'Maintenance Kendaraan';
		$data['Menu'] = 'Proses';
		$data['SubMenuOne'] = 'Maintenance Kendaraan';
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
		if ($lokasi == '01') {
			$query_lokasi = "";
		}else{
			$query_lokasi = " and kdrn.kode_lokasi_kerja='$lokasi'";
		}
		$data['FleetKendaraan'] = $this->M_fleetmaintenancekendaraan->getFleetKendaraan($query_lokasi);
		$data['FleetMaintenanceKategori'] = $this->M_fleetmaintenancekendaraan->getFleetMaintenanceKategori();
		$data['FleetBengkel'] = $this->M_fleetmaintenancekendaraan->selectBengkel();
		$data['jenisMaintenance'] = $this->M_fleetmaintenancekendaraan->selectJenisMaintenance();

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('cmbKendaraanIdHeader', 'KendaraanId', 'required');
		$this->form_validation->set_rules('txtTanggalMaintenanceHeader', 'TanggalMaintenance', 'required');
		$this->form_validation->set_rules('cmbMaintenanceKategoriIdHeader', 'MaintenanceKategoriId', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('GeneralAffair/FleetMaintenanceKendaraan/V_create', $data);
			$this->load->view('V_Footer',$data);
		} else {
			$kendaraan 				= 	$this->input->post('cmbKendaraanIdHeader');
			$tanggal_maintenance	=	date('Y-m-d H:i:s', strtotime($this->input->post('txtTanggalMaintenanceHeader')));
			$kilometer_maintenance	= 	$this->input->post('txtKilometerMaintenanceHeader');
			$alasan 				= 	$this->input->post('txaAlasanHeader');
			$kategori_maintenance 	= 	$this->input->post('cmbMaintenanceKategoriIdHeader');
			$bengkel 				= 	$this->input->post('cmbBengkelHeader');

			$waktu_eksekusi 		= 	date('Y-m-d H:i:s');

			if (empty($bengkel)) {
				$data = array(
					'kendaraan_id' 				=> $kendaraan,
					'tanggal_maintenance' 		=> $tanggal_maintenance,
					'kilometer_maintenance' 	=> $kilometer_maintenance,
					'maintenance_kategori_id' 	=> $kategori_maintenance,
					'start_date' 				=> $waktu_eksekusi,
					'end_date' 					=> '9999-12-12 00:00:00',
					'creation_date' 			=> $waktu_eksekusi,
					'created_by' 				=> $this->session->userid,
					'alasan' 					=> $alasan,
					'kode_lokasi_kerja'			=> $lokasi,
	    		);
			}else{
					$data = array(
					'kendaraan_id' 				=> $kendaraan,
					'tanggal_maintenance' 		=> $tanggal_maintenance,
					'kilometer_maintenance' 	=> $kilometer_maintenance,
					'maintenance_kategori_id' 	=> $kategori_maintenance,
					'start_date' 				=> $waktu_eksekusi,
					'end_date' 					=> '9999-12-12 00:00:00',
					'creation_date' 			=> $waktu_eksekusi,
					'created_by' 				=> $this->session->userid,
					'alasan' 					=> $alasan,
					'id_bengkel'				=> $bengkel,
					'kode_lokasi_kerja'			=> $lokasi,
	    		);
			}


			$this->M_fleetmaintenancekendaraan->setFleetMaintenanceKendaraan($data);
			$header_id = $this->db->insert_id();

			$line1_jenis_maintenance = $this->input->post('txtJenisMaintenanceLine1');
			$line1_biaya = $this->input->post('txtBiayaLine1');
			$line1_jumlah = $this->input->post('txtJumlahLine1');

			foreach ($line1_jenis_maintenance as $i => $loop) {
				if($line1_jenis_maintenance[$i] != '' && $line1_biaya[$i] != '') {
					$data_line1[$i] = array(
						'maintenance_kendaraan_id' 		=> $header_id,
						'jenis_maintenance' 			=> $line1_jenis_maintenance[$i],
						'biaya' 						=> str_replace(array('Rp','.'), '', $line1_biaya[$i]),
						'jumlah_item' 					=> $line1_jumlah[$i],
						'start_date' 					=> $waktu_eksekusi,
						'end_date' 						=> '9999-12-12 00:00:00',
						'creation_date' 				=> $waktu_eksekusi,
						'created_by' 					=> $this->session->userid,

					);
					$this->M_fleetmaintenancekendaraan->setFleetMaintenanceKendaraanDetail($data_line1[$i]);
				}
			}
			//insert to t_log
			$aksi = 'MANAGEMENT KENDARAAN';
			$detail = 'Create Fleet Maintenance Kendaraan ID='.$header_id;
			$this->log_activity->activity_log($aksi, $detail);
			//
			redirect(site_url('GeneralAffair/FleetMaintenanceKendaraan'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;
		$lokasi = $this->session->kode_lokasi_kerja;

		$data['Title'] = 'Maintenance Kendaraan';
		$data['Menu'] = 'Proses';
		$data['SubMenuOne'] = 'Maintenance Kendaraan';
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
		$data['FleetMaintenanceKendaraan'] = $this->M_fleetmaintenancekendaraan->getFleetMaintenanceKendaraan($plaintext_string);

		/* LINES DATA */
		$data['FleetMaintenanceKendaraanDetail'] = $this->M_fleetmaintenancekendaraan->getFleetMaintenanceKendaraanDetail($plaintext_string);

		/* HEADER DROPDOWN DATA */
		if ($lokasi == '01') {
			$query_lokasi = "";
		}else{
			$query_lokasi = " and kdrn.kode_lokasi_kerja='$lokasi'";
		}
		$data['FleetKendaraan'] = $this->M_fleetmaintenancekendaraan->getFleetKendaraan($query_lokasi);
		$data['FleetMaintenanceKategori'] = $this->M_fleetmaintenancekendaraan->getFleetMaintenanceKategori();
		$data['FleetBengkel'] = $this->M_fleetmaintenancekendaraan->selectBengkel();
		$data['jenisMaintenance'] = $this->M_fleetmaintenancekendaraan->selectJenisMaintenance();

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('cmbKendaraanIdHeader', 'KendaraanId', 'required');
		$this->form_validation->set_rules('txtTanggalMaintenanceHeader', 'TanggalMaintenance', 'required');
		$this->form_validation->set_rules('cmbMaintenanceKategoriIdHeader', 'MaintenanceKategoriId', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('GeneralAffair/FleetMaintenanceKendaraan/V_update', $data);
			$this->load->view('V_Footer',$data);
		} else {
			$waktu_dihapus 	=	$this->input->post('WaktuDihapus');
			$status_data 	= 	$this->input->post('CheckAktif');
			$waktu_eksekusi = 	date('Y-m-d H:i:s');
			if($waktu_dihapus=='12-12-9999 00:00:00' && $status_data==NULL)
			{
				$waktu_dihapus = $waktu_eksekusi;
			}
			elseif($waktu_dihapus!='12-12-9999 00:00:00' && $status_data=='on')
			{
				$waktu_dihapus = '9999-12-12 00:00:00';
			}

			$data = array(
				'kendaraan_id' 				=> $this->input->post('cmbKendaraanIdHeader',TRUE),
				'tanggal_maintenance' 		=> date('Y-m-d H:i:s',strtotime($this->input->post('txtTanggalMaintenanceHeader',TRUE))),
				'kilometer_maintenance' 	=> $this->input->post('txtKilometerMaintenanceHeader',TRUE),
				'maintenance_kategori_id' 	=> $this->input->post('cmbMaintenanceKategoriIdHeader',TRUE),
				'end_date'					=> $waktu_dihapus,
				'last_updated' 				=> $waktu_eksekusi,
				'last_updated_by' 			=> $this->session->userid,
				'alasan'		 			=> $this->input->post('txaAlasanHeader',TRUE),
				'id_bengkel'				=> $this->input->post('cmbBengkelHeader', TRUE),
    			);
			$this->M_fleetmaintenancekendaraan->updateFleetMaintenanceKendaraan($data, $plaintext_string);

			$line1_jenis_maintenance = $this->input->post('txtJenisMaintenanceLine1');
			$line1_biaya = $this->input->post('txtBiayaLine1');
			$line1_jumlah = $this->input->post('txtJumlahLine1');
			$maintenance_kendaraan_detail_id = $this->input->post('hdnMaintenanceKendaraanDetailId');

			foreach ($line1_jenis_maintenance as $i => $loop) {
				/* if hidden lines id is not null, then update data */
				if($maintenance_kendaraan_detail_id[$i] != null) {
					$data_line1[$i] = array(
						'maintenance_kendaraan_id' 	=> $plaintext_string,
						'jenis_maintenance' 		=> $line1_jenis_maintenance[$i],
						'jumlah_item' 				=> $line1_jumlah[$i],
						'biaya' 					=> str_replace(array('Rp','.'), '', $line1_biaya[$i]),
						'last_updated' 				=> $waktu_eksekusi,
						'last_updated_by' 			=> $this->session->userid,
						'creation_date' 			=> $waktu_eksekusi,
						'created_by' 				=> $this->session->userid,

					);
					unset($data_line1[$i]['creation_date']);
					unset($data_line1[$i]['created_by']);
					$lineId[$i] = str_replace(array('-', '_', '~'), array('+', '/', '='), $maintenance_kendaraan_detail_id[$i]);
					$lineId[$i] = $this->encrypt->decode($lineId[$i]);
					$this->M_fleetmaintenancekendaraan->updateFleetMaintenanceKendaraanDetail($data_line1[$i], $lineId[$i]);
				} else {
					if($line1_jenis_maintenance[$i] != '' && $line1_biaya[$i] != '') {
						$data_line1[$i] = array(
						'maintenance_kendaraan_id' 	=> $plaintext_string,
						'jenis_maintenance' 		=> $line1_jenis_maintenance[$i],
						'jumlah_item' 				=> $line1_jumlah[$i],
						'biaya' 					=> str_replace(array('Rp','.'), '', $line1_biaya[$i]),
						'start_date' 				=> $waktu_eksekusi,
						'end_date' 					=> '9999-12-12 00:00:00',
						'last_updated' 				=> $waktu_eksekusi,
						'last_updated_by' 			=> $this->session->userid,
						'creation_date' 			=> $waktu_eksekusi,
						'created_by' 				=> $this->session->userid,

						);
						unset($data_line1[$i]['last_updated']);
						unset($data_line1[$i]['last_updated_by']);
						$this->M_fleetmaintenancekendaraan->setFleetMaintenanceKendaraanDetail($data_line1[$i]);
					}
				}
			}
			//insert to t_log
			$aksi = 'MANAGEMENT KENDARAAN';
			$detail = 'Update Fleet Maintenance Kendaraan ID='.$plaintext_string;
			$this->log_activity->activity_log($aksi, $detail);
			//
			redirect(site_url('GeneralAffair/FleetMaintenanceKendaraan'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Maintenance Kendaraan';
		$data['Menu'] = 'Proses';
		$data['SubMenuOne'] = 'Maintenance Kendaraan';
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
		$data['FleetMaintenanceKendaraan'] 			= $this->M_fleetmaintenancekendaraan->getFleetMaintenanceKendaraan($plaintext_string);

		/* LINES DATA */
		$data['FleetMaintenanceKendaraanDetail'] 	= $this->M_fleetmaintenancekendaraan->getFleetMaintenanceKendaraanDetail($plaintext_string);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/FleetMaintenanceKendaraan/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_fleetmaintenancekendaraan->deleteFleetMaintenanceKendaraan($plaintext_string);
		//insert to t_log
		$aksi = 'MANAGEMENT KENDARAAN';
		$detail = 'Delete Fleet Maintenance Kendaraan ID='.$plaintext_string;
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect(site_url('GeneralAffair/FleetMaintenanceKendaraan'));
    }

	public function deleteBarisDetail($id)
	{
		// $id = $this->input->post('id');
		$lineId = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$lineId = $this->encrypt->decode($lineId);

		$this->M_fleetmaintenancekendaraan->deleteFleetMaintenanceKendaraanDetail($lineId);
		//insert to t_log
		$aksi = 'MANAGEMENT KENDARAAN';
		$detail = 'Delete Baris Detail Fleet Maintenance Kendaraan ID='.$lineId;
		$this->log_activity->activity_log($aksi, $detail);
		//

		echo json_encode('true');
	}

}

/* End of file C_FleetMaintenanceKendaraan.php */
/* Location: ./application/controllers/GeneralAffair/MainMenu/C_FleetMaintenanceKendaraan.php */
/* Generated automatically on 2017-08-05 13:43:03 */
