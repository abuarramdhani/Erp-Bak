<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_FleetCetakSpk extends CI_Controller
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
		$this->load->model('GeneralAffair/MainMenu/M_fleetcetakspk');
		$this->load->model('GeneralAffair/MainMenu/M_fleetmaintenancekendaraan');
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
		$lokasi = $this->session->kode_lokasi_kerja;

		$data['Title'] = 'Fleet Cetak Spk';
		$data['Menu'] = 'Proses';
		$data['SubMenuOne'] = 'Cetak SPK';
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

		if ($lokasi == '01') {
			$data['FleetCetakSpk'] = $this->M_fleetcetakspk->getFleetCetakSpk();
		}else{
			$data['FleetCetakSpk'] = $this->M_fleetcetakspk->getFleetCetakSpkCabang($lokasi);
		}

		$data['today'] = date('d-m-Y');

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/FleetCetakSpk/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;
		$lokasi = $this->session->kode_lokasi_kerja;

		$data['Title'] = 'Fleet Cetak Spk';
		$data['Menu'] = 'Proses';
		$data['SubMenuOne'] = 'Cetak SPK';
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
		$data['FleetKendaraan'] = $this->M_fleetcetakspk->getFleetKendaraan($query_lokasi);
		$data['FleetMaintenanceKategori'] = $this->M_fleetcetakspk->getFleetMaintenanceKategori();
		$data['FleetBengkel'] = $this->M_fleetcetakspk->getFleetBengkel();
		$data['jenisMaintenance'] = $this->M_fleetmaintenancekendaraan->selectJenisMaintenance();

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('cmbKendaraanIdHeader', 'kendaraan', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('GeneralAffair/FleetCetakSpk/V_create', $data);
			$this->load->view('V_Footer',$data);
		} else {
			$dataMain = array(
				'kendaraan_id' => $this->input->post('cmbKendaraanIdHeader'),
				'tanggal_maintenance' => date('Y-m-d H:i:s',strtotime($this->input->post('txtTanggalMaintenanceHeader',TRUE))),
				'maintenance_kategori_id' => $this->input->post('cmbMaintenanceKategoriIdHeader'),
				'start_date' => date('Y-m-d h:i:s'),
				'end_date' => date('Y-m-d h:i:s'),
				'creation_date' => date('Y-m-d h:i:s'),
				'creation_by' => $this->session->userid,
				'id_bengkel' => $this->input->post('cmbIdBengkelHeader'),
				'no_surat' => $this->input->post('txtNoSuratHeader'),
				'kode_lokasi_kerja' => $lokasi
    		);
			$this->M_fleetcetakspk->setFleetCetakSpk($dataMain);
			$header_id = $this->db->insert_id();

			$JenisMaintnce = $this->input->post('txtJenisMaintenanceSPK');
			foreach ($JenisMaintnce as $JMSPK => $key) {
				$jenis_maintenance = $this->input->post('txtJenisMaintenanceSPK');
				$lines = array(
						'surat_id' => $header_id,
						'jenis_maintenance' => 	$jenis_maintenance[$JMSPK],
						'start_date' => date('Y-m-d h:i:s'),
						'end_date' => date('Y-m-d h:i:s'),
						'create_date' => date('Y-m-d h:i:s'),
						'create_by' => $this->session->userid,
				);

				$this->M_fleetcetakspk->setFleetCetakSpkDetail($lines);
			}

			$data['isi'] = $dataMain;
			$data['tabel'] = $JenisMaintnce;
			//insert to t_log
			$aksi = 'MANAGEMENT KENDARAAN';
			$detail = 'Proses_Cetak SPK ID '.$header_id;
			$this->log_activity->activity_log($aksi, $detail);
			//

			// echo "<pre>";print_r($data['tabel']);print_r($data['jenisMaintenance']);exit();

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('GeneralAffair/FleetCetakSpk/V_createmaintenance', $data);
			$this->load->view('V_Footer',$data);
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;
		$lokasi = $this->session->kode_lokasi_kerja;

		$data['Title'] = 'Fleet Cetak Spk';
		$data['Menu'] = 'Proses';
		$data['SubMenuOne'] = 'Cetak SPK';
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
		$data['FleetCetakSpk'] = $this->M_fleetcetakspk->getFleetCetakSpk($plaintext_string);
		$data['FleetCetakSpkDetail'] = $this->M_fleetcetakspk->getFleetCetakSpkDetail($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */
		if ($lokasi == '01') {
			$query_lokasi = "";
		}else{
			$query_lokasi = " and kdrn.kode_lokasi_kerja='$lokasi'";
		}
		$data['FleetKendaraan'] = $this->M_fleetcetakspk->getFleetKendaraan();
		$data['FleetMaintenanceKategori'] = $this->M_fleetcetakspk->getFleetMaintenanceKategori();
		$data['FleetBengkel'] = $this->M_fleetcetakspk->getFleetBengkel();

		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('cmbKendaraanIdHeader', 'kendaraan', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('GeneralAffair/FleetCetakSpk/V_update', $data);
			$this->load->view('V_Footer',$data);
		} else {
			$data = array(
				'kendaraan_id' => $this->input->post('cmbKendaraanIdHeader',TRUE),
				'tanggal_maintenance' => date('Y-m-d H:i:s',strtotime($this->input->post('txtTanggalMaintenanceHeader',TRUE))),
				'maintenance_kategori_id' => $this->input->post('cmbMaintenanceKategoriIdHeader',TRUE),
				'last_update' => date('Y-m-d h:i:s'),
				'last_update_by' => $this->session->userid,
				'id_bengkel' => $this->input->post('cmbIdBengkelHeader',TRUE),
				'no_surat' => $this->input->post('txtNoSuratHeader',TRUE),
    			);
			$this->M_fleetcetakspk->updateFleetCetakSpk($data, $plaintext_string);

			$JenisMaintnce = $this->input->post('txtJenisMaintenanceSPK');
			foreach ($JenisMaintnce as $JMSPK => $key) {
				$id_SPKDetail = $this->input->post('FleetSPKIdDetail');
				$jenis_maintenance = $this->input->post('txtJenisMaintenanceSPK');
					if ($id_SPKDetail[$JMSPK]==null || $id_SPKDetail[$JMSPK]=='') {
						$lines = array(
							'surat_id' => $plaintext_string,
							'jenis_maintenance' => 	$jenis_maintenance[$JMSPK],
							'start_date' => date('Y-m-d h:i:s'),
							'end_date' => date('Y-m-d h:i:s'),
							'create_date' => date('Y-m-d h:i:s'),
							'create_by' => $this->session->userid,
						);
						$this->M_fleetcetakspk->setFleetCetakSpkDetail($lines);
					}else{
						$id_lines = str_replace(array('-', '_', '~'), array('+', '/', '='), $id_SPKDetail[$JMSPK]);
						$id_lines = $this->encrypt->decode($id_lines);
						$lines = array(
							'jenis_maintenance' => 	$jenis_maintenance[$JMSPK],
							'last_update' => date('Y-m-d h:i:s'),
							'last_update_by' => $this->session->userid,
						);
						$this->M_fleetcetakspk->updateFleetCetakSpkDetail($lines, $id_lines);
					}
			}
			//insert to t_log
			$aksi = 'MANAGEMENT KENDARAAN';
			$detail = 'Proses_Update SPK ID '.$plaintext_string;
			$this->log_activity->activity_log($aksi, $detail);
			//

			redirect(site_url('GeneralAffair/FleetCetakSpk'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Fleet Cetak Spk';
		$data['Menu'] = 'Proses';
		$data['SubMenuOne'] = 'Cetak SPK';
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
		$data['FleetCetakSpk'] = $this->M_fleetcetakspk->getFleetCetakSpk($plaintext_string);
		$data['FleetCetakSpkDetail'] = $this->M_fleetcetakspk->getFleetCetakSpkDetail($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/FleetCetakSpk/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_fleetcetakspk->deleteFleetCetakSpk($plaintext_string);
		$this->M_fleetcetakspk->deleteAllFleetSPKMaintenance($plaintext_string);
		//insert to t_log
		$aksi = 'MANAGEMENT KENDARAAN';
		$detail = 'Proses_Delete SPK ID '.$plaintext_string;
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect(site_url('GeneralAffair/FleetCetakSpk'));
    }

    public function deleteSPKDetail($id)
	{
		$lineId = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$lineId = $this->encrypt->decode($lineId);

		$this->M_fleetcetakspk->deleteFleetCetakSpkDetail($lineId);
		//insert to t_log
		$aksi = 'MANAGEMENT KENDARAAN';
		$detail = 'Proses_Delete SPK_Detail ID '.$lineId;
		$this->log_activity->activity_log($aksi, $detail);
		//

		echo json_encode('true');
	}

    public function cetakFleetSPK($id)
	{
		$this->load->library('pdf');

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['FleetHeaderCetakSpk'] 			= $this->M_fleetcetakspk->getFleetCetakSpk($plaintext_string);

		$data['FleetHeaderCetakSpk'] = $data['FleetHeaderCetakSpk'][0];
		$tgl = $data['FleetHeaderCetakSpk']['tanggal_maintenance'];
		$tanggal = explode('-', $tgl);
		$data['tanggal'] = $tanggal;
		$data['FleetLineSpkDetail'] 	= $this->M_fleetcetakspk->getFleetSPKDetailMaintenance($plaintext_string);
		//insert to t_log
		$aksi = 'MANAGEMENT KENDARAAN';
		$detail = 'Proses_Cetak SPK ID '.$plaintext_string;
		$this->log_activity->activity_log($aksi, $detail);
		//

		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8', 'A4', 8, '', 5, 5, 10, 15, 0, 0, 'P');
		$filename = 'Cetak_Maintenance_Kendaraan.pdf';

		$stylesheet = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
		$html = $this->load->view('GeneralAffair/FleetCetakSpk/V_cetakPDF', $data, true);

		$pdf->WriteHTML($stylesheet, 1);
		$pdf->WriteHTML($html, 2);
		$pdf->setTitle($filename);
		$pdf->Output($filename, 'I');
	}

}

/* End of file C_FleetCetakSpk.php */
/* Location: ./application/controllers/GeneralAffair/MainMenu/C_FleetCetakSpk.php */
/* Generated automatically on 2018-04-11 10:41:51 */
