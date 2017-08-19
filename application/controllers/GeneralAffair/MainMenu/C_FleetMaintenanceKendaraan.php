<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_FleetMaintenanceKendaraan extends CI_Controller
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
		$this->load->model('GeneralAffair/MainMenu/M_fleetmaintenancekendaraan');

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

		$data['Title'] = 'Fleet Maintenance Kendaraan';
		$data['Menu'] = 'General Affair';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['FleetMaintenanceKendaraan'] = $this->M_fleetmaintenancekendaraan->getFleetMaintenanceKendaraan();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/FleetMaintenanceKendaraan/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Fleet Maintenance Kendaraan';
		$data['Menu'] = 'General Affair';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */
		$data['FleetKendaraan'] = $this->M_fleetmaintenancekendaraan->getFleetKendaraan();
		$data['FleetMaintenanceKategori'] = $this->M_fleetmaintenancekendaraan->getFleetMaintenanceKategori();

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
			$data = array(
				'kendaraan_id' => $this->input->post('cmbKendaraanIdHeader'),
				'tanggal_maintenance' => $this->input->post('txtTanggalMaintenanceHeader'),
				'kilometer_maintenance' => $this->input->post('txtKilometerMaintenanceHeader'),
				'maintenance_kategori_id' => $this->input->post('cmbMaintenanceKategoriIdHeader'),
				'start_date' => $this->input->post('txtStartDateHeader'),
				'end_date' => $this->input->post('txtEndDateHeader'),
				'creation_date' => 'NOW()',
				'created_by' => $this->session->userid,
				'alasan' => $this->input->post('txaAlasanHeader'),
    		);
			$this->M_fleetmaintenancekendaraan->setFleetMaintenanceKendaraan($data);
			$header_id = $this->db->insert_id();

			$line1_jenis_maintenance = $this->input->post('txtJenisMaintenanceLine1');
			$line1_biaya = $this->input->post('txtBiayaLine1');
			$line1_start_date = $this->input->post('txtStartDateLine1');
			$line1_end_date = $this->input->post('txtEndDateLine1');

			foreach ($line1_jenis_maintenance as $i => $loop) {
				if($line1_jenis_maintenance[$i] != '' && $line1_biaya[$i] != '' && $line1_start_date[$i] != '' && $line1_end_date[$i] != '') {
					$data_line1[$i] = array(
						'maintenance_kendaraan_id' => $header_id,
						'jenis_maintenance' => $line1_jenis_maintenance[$i],
						'biaya' => $line1_biaya[$i],
						'start_date' => $line1_start_date[$i],
						'end_date' => $line1_end_date[$i],
						'creation_date' => 'now()',
						'created_by' => $this->session->userid,
						
					);
					$this->M_fleetmaintenancekendaraan->setFleetMaintenanceKendaraanDetail($data_line1[$i]);
				}
			}

			redirect(site_url('GeneralAffair/FleetMaintenanceKendaraan'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Fleet Maintenance Kendaraan';
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
		$data['FleetMaintenanceKendaraan'] = $this->M_fleetmaintenancekendaraan->getFleetMaintenanceKendaraan($plaintext_string);

		/* LINES DATA */
		$data['FleetMaintenanceKendaraanDetail'] = $this->M_fleetmaintenancekendaraan->getFleetMaintenanceKendaraanDetail($plaintext_string);

		/* HEADER DROPDOWN DATA */
		$data['FleetKendaraan'] = $this->M_fleetmaintenancekendaraan->getFleetKendaraan();
		$data['FleetMaintenanceKategori'] = $this->M_fleetmaintenancekendaraan->getFleetMaintenanceKategori();

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
			$data = array(
				'kendaraan_id' => $this->input->post('cmbKendaraanIdHeader',TRUE),
				'tanggal_maintenance' => $this->input->post('txtTanggalMaintenanceHeader',TRUE),
				'kilometer_maintenance' => $this->input->post('txtKilometerMaintenanceHeader',TRUE),
				'maintenance_kategori_id' => $this->input->post('cmbMaintenanceKategoriIdHeader',TRUE),
				'start_date' => $this->input->post('txtStartDateHeader',TRUE),
				'end_date' => $this->input->post('txtEndDateHeader',TRUE),
				'last_updated' => 'NOW()',
				'last_updated_by' => $this->session->userid,
				'alasan' => $this->input->post('txaAlasanHeader',TRUE),
    			);
			$this->M_fleetmaintenancekendaraan->updateFleetMaintenanceKendaraan($data, $plaintext_string);

			$line1_jenis_maintenance = $this->input->post('txtJenisMaintenanceLine1');
			$line1_biaya = $this->input->post('txtBiayaLine1');
			$line1_start_date = $this->input->post('txtStartDateLine1');
			$line1_end_date = $this->input->post('txtEndDateLine1');
			$maintenance_kendaraan_detail_id = $this->input->post('hdnMaintenanceKendaraanDetailId');

			foreach ($line1_jenis_maintenance as $i => $loop) {
				/* if hidden lines id is not null, then update data */
				if($maintenance_kendaraan_detail_id[$i] != null) {
					$data_line1[$i] = array(
						'maintenance_kendaraan_id' => $plaintext_string,
						'jenis_maintenance' => $line1_jenis_maintenance[$i],
						'biaya' => $line1_biaya[$i],
						'start_date' => $line1_start_date[$i],
						'end_date' => $line1_end_date[$i],
						'last_updated' => 'now()',
						'last_updated_by' => $this->session->userid,
						'creation_date' => 'now()',
						'created_by' => $this->session->userid,
						
					);
					unset($data_line1[$i]['creation_date']);
					unset($data_line1[$i]['created_by']);
					$lineId[$i] = str_replace(array('-', '_', '~'), array('+', '/', '='), $maintenance_kendaraan_detail_id[$i]);
					$lineId[$i] = $this->encrypt->decode($lineId[$i]);
					$this->M_fleetmaintenancekendaraan->updateFleetMaintenanceKendaraanDetail($data_line1[$i], $lineId[$i]);
				} else {
					if($line1_jenis_maintenance[$i] != '' && $line1_biaya[$i] != '' && $line1_start_date[$i] != '' && $line1_end_date[$i] != '') {
						$data_line1[$i] = array(
							'maintenance_kendaraan_id' => $plaintext_string,
						'jenis_maintenance' => $line1_jenis_maintenance[$i],
						'biaya' => $line1_biaya[$i],
						'start_date' => $line1_start_date[$i],
						'end_date' => $line1_end_date[$i],
						'last_updated' => 'now()',
						'last_updated_by' => $this->session->userid,
						'creation_date' => 'now()',
						'created_by' => $this->session->userid,
						
						);
						unset($data_line1[$i]['last_updated']);
						unset($data_line1[$i]['last_updated_by']);
						$this->M_fleetmaintenancekendaraan->setFleetMaintenanceKendaraanDetail($data_line1[$i]);
					}
				}
			}

			redirect(site_url('GeneralAffair/FleetMaintenanceKendaraan'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Fleet Maintenance Kendaraan';
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
		$data['FleetMaintenanceKendaraan'] = $this->M_fleetmaintenancekendaraan->getFleetMaintenanceKendaraan($plaintext_string);

		/* LINES DATA */
		$data['FleetMaintenanceKendaraanDetail'] = $this->M_fleetmaintenancekendaraan->getFleetMaintenanceKendaraanDetail($plaintext_string);

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

		redirect(site_url('GeneralAffair/FleetMaintenanceKendaraan'));
    }

	public function deleteFleetMaintenanceKendaraanDetail($id)
	{
		$lineId = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$lineId = $this->encrypt->decode($lineId);

		$this->M_fleetmaintenancekendaraan->deleteFleetMaintenanceKendaraanDetail($lineId);
	}



}

/* End of file C_FleetMaintenanceKendaraan.php */
/* Location: ./application/controllers/GeneralAffair/MainMenu/C_FleetMaintenanceKendaraan.php */
/* Generated automatically on 2017-08-05 13:43:03 */