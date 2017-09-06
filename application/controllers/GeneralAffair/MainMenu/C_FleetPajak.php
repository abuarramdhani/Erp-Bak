<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_FleetPajak extends CI_Controller
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
		$this->load->model('GeneralAffair/MainMenu/M_fleetpajak');

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

		$data['Title'] = 'Pajak';
		$data['Menu'] = 'Proses';
		$data['SubMenuOne'] = 'Pajak';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['FleetPajak'] 		= $this->M_fleetpajak->getFleetPajak();
		$data['FleetPajakDeleted']	= $this->M_fleetpajak->getFleetPajakDeleted();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/FleetPajak/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Pajak';
		$data['Menu'] = 'Proses';
		$data['SubMenuOne'] = 'Pajak';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */
		$data['FleetKendaraan'] = $this->M_fleetpajak->getFleetKendaraan();

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('cmbKendaraanIdHeader', 'Kendaraan', 'required');
		$this->form_validation->set_rules('txtTanggalPajak', 'Tanggal Pajak', 'required');
		$this->form_validation->set_rules('txtPeriodePajak', 'Periode Pajak', 'required');
		$this->form_validation->set_rules('txtBiaya', 'Biaya', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('GeneralAffair/FleetPajak/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$kendaraan 			= 	$this->input->post('cmbKendaraanIdHeader');
			$tanggalPajak 		= 	$this->input->post('txtTanggalPajak');
			$periodePajak 		= 	$this->input->post('txtPeriodePajak');
			$biaya 				= 	$this->input->post('txtBiaya');

			$tanggalPajak 		= 	date('Y-m-d', strtotime($tanggalPajak));
			$periodePajak 		= 	explode(' - ', $periodePajak);
			$periodeawalPajak 	= 	date('Y-m-d',strtotime($periodePajak[0]));
			$periodeakhirPajak 	=	date('Y-m-d', strtotime($periodePajak[1]));

			$biaya 				= 	str_replace(array('.','Rp'), '', $biaya);

			$tanggal_eksekusi 	= 	date('Y-m-d H:i:s');

			// echo $kendaraan.'<br/>';
			// echo $tanggalPajak.'<br/>';
			// echo $periodeawalPajak.'<br/>';
			// echo $periodeakhirPajak.'<br/>';
			// echo $biaya.'<br/>';
			// echo $tanggal_eksekusi.'<br/>';


			$data = array(
				'kendaraan_id' 			=> $kendaraan,
				'tanggal_pajak'			=> $tanggalPajak,
				'periode_awal_pajak' 	=> $periodeawalPajak,
				'periode_akhir_pajak' 	=> $periodeakhirPajak,
				'biaya' 				=> $biaya,
				'start_date' 			=> $tanggal_eksekusi,
				'end_date' 				=> '9999-12-12 00:00:00',
				'creation_date' 		=> $tanggal_eksekusi,
				'created_by' 			=> $this->session->userid,
    		);
			$this->M_fleetpajak->setFleetPajak($data);
			$header_id = $this->db->insert_id();

			redirect(site_url('GeneralAffair/FleetPajak'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Pajak';
		$data['Menu'] = 'Proses';
		$data['SubMenuOne'] = 'Pajak';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['FleetPajak'] = $this->M_fleetpajak->getFleetPajak($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */
		$data['FleetKendaraan'] = $this->M_fleetpajak->getFleetKendaraan();

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('cmbKendaraanIdHeader', 'Kendaraan', 'required');
		$this->form_validation->set_rules('txtTanggalPajak', 'Tanggal Pajak', 'required');
		$this->form_validation->set_rules('txtPeriodePajak', 'Periode Pajak', 'required');
		$this->form_validation->set_rules('txtBiaya', 'Biaya', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('GeneralAffair/FleetPajak/V_update', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$kendaraan 			= 	$this->input->post('cmbKendaraanIdHeader', TRUE);
			$tanggalPajak 		= 	$this->input->post('txtTanggalPajak', TRUE);
			$periodePajak 		= 	$this->input->post('txtPeriodePajak', TRUE);
			$biaya 				= 	$this->input->post('txtBiaya', TRUE);
			$waktu_dihapus 		=	$this->input->post('WaktuDihapus');
			$status_data 		= 	$this->input->post('CheckAktif');

			$tanggalPajak 		= 	date('Y-m-d', strtotime($tanggalPajak));
			$periodePajak 		=	explode(' - ', $periodePajak);
			$biaya 				=	str_replace(array('Rp','.'), '', $biaya);

			$periodeawalPajak 	=	date('Y-m-d',strtotime($periodePajak[0]));
			$periodeakhirPajak 	=	date('Y-m-d',strtotime($periodePajak[1]));

			$waktu_eksekusi 	= 	date('Y-m-d H:i:s');

			if($waktu_dihapus=='12-12-9999 00:00:00' && $status_data==NULL)
			{
				$waktu_dihapus = $waktu_eksekusi;
			}
			elseif($waktu_dihapus!='12-12-9999 00:00:00' && $status_data=='on')
			{
				$waktu_dihapus = '9999-12-12 00:00:00';
			}			

			$data = array(
				'kendaraan_id' 			=> $kendaraan,
				'periode_awal_pajak' 	=> $periodeawalPajak,
				'periode_akhir_pajak' 	=> $periodeakhirPajak,
				'biaya' 				=> $biaya,
				'end_date' 				=> $waktu_dihapus,
				'last_updated' 			=> $waktu_eksekusi,
				'last_updated_by' 		=> $this->session->userid,
				'tanggal_pajak'			=> $tanggalPajak
    			);
			$this->M_fleetpajak->updateFleetPajak($data, $plaintext_string);

			redirect(site_url('GeneralAffair/FleetPajak'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Pajak';
		$data['Menu'] = 'Proses';
		$data['SubMenuOne'] = 'Pajak';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['FleetPajak'] = $this->M_fleetpajak->getFleetPajak($plaintext_string);

		/* LINES DATA */
 
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/FleetPajak/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_fleetpajak->deleteFleetPajak($plaintext_string);

		redirect(site_url('GeneralAffair/FleetPajak'));
    }



}

/* End of file C_FleetPajak.php */
/* Location: ./application/controllers/GeneralAffair/MainMenu/C_FleetPajak.php */
/* Generated automatically on 2017-08-05 13:29:59 */