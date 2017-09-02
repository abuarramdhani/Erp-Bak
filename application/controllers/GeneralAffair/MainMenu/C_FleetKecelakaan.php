<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_FleetKecelakaan extends CI_Controller
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
		$this->load->model('GeneralAffair/MainMenu/M_fleetkecelakaan');

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

		$data['Title'] = 'Fleet Kecelakaan';
		$data['Menu'] = 'General Affair';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['FleetKecelakaan'] = $this->M_fleetkecelakaan->getFleetKecelakaan();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/FleetKecelakaan/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Fleet Kecelakaan';
		$data['Menu'] = 'General Affair';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */
		$data['FleetKendaraan'] = $this->M_fleetkecelakaan->getFleetKendaraan();
		$data['EmployeeAll'] = $this->M_fleetkecelakaan->getEmployeeAll();

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('cmbKendaraanIdHeader', 'KendaraanId', 'required');
		$this->form_validation->set_rules('txtTanggalKecelakaanHeader', 'TanggalKecelakaan', 'required');
		$this->form_validation->set_rules('txaSebabHeader', 'Sebab', 'required');
		$this->form_validation->set_rules('txtBiayaPerusahaanHeader', 'BiayaPerusahaan', 'required');
		$this->form_validation->set_rules('txtBiayaPekerjaHeader', 'BiayaPekerja', 'required');
		$this->form_validation->set_rules('cmbPekerjaHeader', 'Pekerja', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('GeneralAffair/FleetKecelakaan/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'kendaraan_id' => $this->input->post('cmbKendaraanIdHeader'),
				'tanggal_kecelakaan' => $this->input->post('txtTanggalKecelakaanHeader'),
				'sebab' => $this->input->post('txaSebabHeader'),
				'biaya_perusahaan' => $this->input->post('txtBiayaPerusahaanHeader'),
				'biaya_pekerja' => $this->input->post('txtBiayaPekerjaHeader'),
				'pekerja' => $this->input->post('cmbPekerjaHeader'),
				'start_date' => $this->input->post('txtStartDateHeader'),
				'end_date' => $this->input->post('txtEndDateHeader'),
				'creation_date' => 'NOW()',
				'created_by' => $this->session->userid,
    		);
			$this->M_fleetkecelakaan->setFleetKecelakaan($data);
			$header_id = $this->db->insert_id();

			$line1_kerusakan = $this->input->post('txtKerusakanLine1');
			$line1_start_date = $this->input->post('txtStartDateLine1');
			$line1_end_date = $this->input->post('txtEndDateLine1');

			foreach ($line1_kerusakan as $i => $loop) {
				if($line1_kerusakan[$i] != '' && $line1_start_date[$i] != '' && $line1_end_date[$i] != '') {
					$data_line1[$i] = array(
						'kecelakaan_id' => $header_id,
						'kerusakan' => $line1_kerusakan[$i],
						'start_date' => $line1_start_date[$i],
						'end_date' => $line1_end_date[$i],
						'creation_date' => 'now()',
						'created_by' => $this->session->userid,
						
					);
					$this->M_fleetkecelakaan->setFleetKecelakaanDetail($data_line1[$i]);
				}
			}

			redirect(site_url('GeneralAffair/FleetKecelakaan'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Fleet Kecelakaan';
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
		$data['FleetKecelakaan'] = $this->M_fleetkecelakaan->getFleetKecelakaan($plaintext_string);

		/* LINES DATA */
		$data['FleetKecelakaanDetail'] = $this->M_fleetkecelakaan->getFleetKecelakaanDetail($plaintext_string);

		/* HEADER DROPDOWN DATA */
		$data['FleetKendaraan'] = $this->M_fleetkecelakaan->getFleetKendaraan();
		$data['EmployeeAll'] = $this->M_fleetkecelakaan->getEmployeeAll();

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('cmbKendaraanIdHeader', 'KendaraanId', 'required');
		$this->form_validation->set_rules('txtTanggalKecelakaanHeader', 'TanggalKecelakaan', 'required');
		$this->form_validation->set_rules('txaSebabHeader', 'Sebab', 'required');
		$this->form_validation->set_rules('txtBiayaPerusahaanHeader', 'BiayaPerusahaan', 'required');
		$this->form_validation->set_rules('txtBiayaPekerjaHeader', 'BiayaPekerja', 'required');
		$this->form_validation->set_rules('cmbPekerjaHeader', 'Pekerja', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('GeneralAffair/FleetKecelakaan/V_update', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'kendaraan_id' => $this->input->post('cmbKendaraanIdHeader',TRUE),
				'tanggal_kecelakaan' => $this->input->post('txtTanggalKecelakaanHeader',TRUE),
				'sebab' => $this->input->post('txaSebabHeader',TRUE),
				'biaya_perusahaan' => $this->input->post('txtBiayaPerusahaanHeader',TRUE),
				'biaya_pekerja' => $this->input->post('txtBiayaPekerjaHeader',TRUE),
				'pekerja' => $this->input->post('cmbPekerjaHeader',TRUE),
				'start_date' => $this->input->post('txtStartDateHeader',TRUE),
				'end_date' => $this->input->post('txtEndDateHeader',TRUE),
				'last_updated' => 'NOW()',
				'last_updated_by' => $this->session->userid,
    			);
			$this->M_fleetkecelakaan->updateFleetKecelakaan($data, $plaintext_string);

			$line1_kerusakan = $this->input->post('txtKerusakanLine1');
			$line1_start_date = $this->input->post('txtStartDateLine1');
			$line1_end_date = $this->input->post('txtEndDateLine1');
			$kecelakaan_detail_id = $this->input->post('hdnKecelakaanDetailId');

			foreach ($line1_kerusakan as $i => $loop) {
				/* if hidden lines id is not null, then update data */
				if($kecelakaan_detail_id[$i] != null) {
					$data_line1[$i] = array(
						'kecelakaan_id' => $plaintext_string,
						'kerusakan' => $line1_kerusakan[$i],
						'start_date' => $line1_start_date[$i],
						'end_date' => $line1_end_date[$i],
						'last_updated' => 'now()',
						'last_updated_by' => $this->session->userid,
						'creation_date' => 'now()',
						'created_by' => $this->session->userid,
						
					);
					unset($data_line1[$i]['creation_date']);
					unset($data_line1[$i]['created_by']);
					$lineId[$i] = str_replace(array('-', '_', '~'), array('+', '/', '='), $kecelakaan_detail_id[$i]);
					$lineId[$i] = $this->encrypt->decode($lineId[$i]);
					$this->M_fleetkecelakaan->updateFleetKecelakaanDetail($data_line1[$i], $lineId[$i]);
				} else {
					if($line1_kerusakan[$i] != '' && $line1_start_date[$i] != '' && $line1_end_date[$i] != '') {
						$data_line1[$i] = array(
							'kecelakaan_id' => $plaintext_string,
						'kerusakan' => $line1_kerusakan[$i],
						'start_date' => $line1_start_date[$i],
						'end_date' => $line1_end_date[$i],
						'last_updated' => 'now()',
						'last_updated_by' => $this->session->userid,
						'creation_date' => 'now()',
						'created_by' => $this->session->userid,
						
						);
						unset($data_line1[$i]['last_updated']);
						unset($data_line1[$i]['last_updated_by']);
						$this->M_fleetkecelakaan->setFleetKecelakaanDetail($data_line1[$i]);
					}
				}
			}

			redirect(site_url('GeneralAffair/FleetKecelakaan'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Fleet Kecelakaan';
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
		$data['FleetKecelakaan'] = $this->M_fleetkecelakaan->getFleetKecelakaan($plaintext_string);

		/* LINES DATA */
		$data['FleetKecelakaanDetail'] = $this->M_fleetkecelakaan->getFleetKecelakaanDetail($plaintext_string);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/FleetKecelakaan/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_fleetkecelakaan->deleteFleetKecelakaan($plaintext_string);

		redirect(site_url('GeneralAffair/FleetKecelakaan'));
    }

	public function deleteFleetKecelakaanDetail($id)
	{
		$lineId = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$lineId = $this->encrypt->decode($lineId);

		$this->M_fleetkecelakaan->deleteFleetKecelakaanDetail($lineId);
	}



}

/* End of file C_FleetKecelakaan.php */
/* Location: ./application/controllers/GeneralAffair/MainMenu/C_FleetKecelakaan.php */
/* Generated automatically on 2017-08-05 13:58:40 */