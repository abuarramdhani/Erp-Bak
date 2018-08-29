<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_FleetPicKendaraan extends CI_Controller
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
		$this->load->model('GeneralAffair/MainMenu/M_fleetpickendaraan');
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

		$lokasi = $this->session->kode_lokasi_kerja;

		$data['Title'] = 'PIC Kendaraan';
		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'PIC Kendaraan';
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
				if ($key['menu_id'] !== '289' && $key['menu_id'] !== '290' && $key['menu_id'] !== '291' && $key['menu_id'] !== '296') {
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
			$data['PICKendaraan'] 	= $this->M_fleetpickendaraan->getFleetPicKendaraan();
		}else{
			$data['PICKendaraan'] 	= $this->M_fleetpickendaraan->getFleetPicKendaraanCabang($lokasi);
		}
		
		$data['PICKendaraanDel']= $this->M_fleetpickendaraan->getFleetPicKendaraanDeleted();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/FleetPicKendaraan/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		date_default_timezone_set('Asia/Jakarta');
		$user_id = $this->session->userid;

		$lokasi = $this->session->kode_lokasi_kerja;

		$data['Title'] = 'PIC Kendaraan';
		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'PIC Kendaraan';
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
				if ($key['menu_id'] !== '289' && $key['menu_id'] !== '290' && $key['menu_id'] !== '291' && $key['menu_id'] !== '296') {
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

		$data['FleetKendaraan'] = $this->M_fleetpickendaraan->getFleetKendaraan($query_lokasi);
		$data['DaftarNama']		= $this->M_fleetpickendaraan->getDaftarNama();
		$data['DaftarSeksi'] 	= $this->M_fleetpickendaraan->getDaftarSeksi();


		/* LINES DROPDOWN DATA */
		$this->form_validation->set_rules('cmbKendaraanIdHeader', 'Kendaraan', 'required');
		// $this->form_validation->set_rules('cmbPekerjaHeader', 'Pekerja', 'required');
		// $this->form_validation->set_rules('masaAktifPIC', 'Masa Aktif PIC', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('GeneralAffair/FleetPicKendaraan/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$pilihanPIC 		= 	$this->input->post('OpsiPIC');
			$kodeKendaraan		= 	$this->input->post('cmbKendaraanIdHeader');
			$masaAktifPIC 		= 	$this->input->post('masaAktifPIC');

			$kode_seksi = NULL;
			$kode_pekerja = NULL;

			$dari;
			$sampai;

			if($pilihanPIC=='Seksi')
			{
				$kode_seksi 	= 	$this->input->post('cmbSeksi');
			}
			elseif ($pilihanPIC == 'Pekerja') 
			{
				$kode_pekerja 	= 	$this->input->post('cmbPekerja');
			}

			if(isset($masaAktifPIC))
			{
				$MasaAktifPIC 		=	explode(' - ', $masaAktifPIC);
				$dari 		=	date('Y-m-d', strtotime($MasaAktifPIC[0]));
				$sampai 	= 	date('Y-m-d', strtotime($MasaAktifPIC[1]));
			}

			$data = array(
				'kendaraan_id' 		=> $kodeKendaraan,
				'dari_periode' 		=> $dari,
				'sampai_periode' 	=> $sampai,
				'start_date' 		=> date('Y-m-d H:i:s'),
				'end_date'			=> '9999-12-12 00:00:00',
				'creation_date' 	=> date('Y-m-d H:i:s'),
				'created_by' 		=> $this->session->userid,
				'employee_id'		=> $kode_pekerja,
				'pic_kodesie'		=> $kode_seksi,
				'kode_lokasi_kerja' => $lokasi,
    		);
			$this->M_fleetpickendaraan->setFleetPicKendaraan($data);
			$header_id = $this->db->insert_id();

			redirect(site_url('GeneralAffair/FleetPicKendaraan'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;
		$lokasi = $this->session->kode_lokasi_kerja;

		$data['Title'] = 'PIC Kendaraan';
		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'PIC Kendaraan';
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
				if ($key['menu_id'] !== '289' && $key['menu_id'] !== '290' && $key['menu_id'] !== '291' && $key['menu_id'] !== '296') {
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
		$data['FleetPicKendaraan'] = $this->M_fleetpickendaraan->getFleetPicKendaraan($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */
		if ($lokasi == '01') {
			$query_lokasi = "";
		}else{
			$query_lokasi = " and kdrn.kode_lokasi_kerja='$lokasi'";
		}

		$data['FleetKendaraan'] = $this->M_fleetpickendaraan->getFleetKendaraan($query_lokasi);
		$data['DaftarNama']		= $this->M_fleetpickendaraan->getDaftarNama();
		$data['DaftarSeksi'] 	= $this->M_fleetpickendaraan->getDaftarSeksi();


		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('cmbKendaraanIdHeader', 'Kendaraan', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('GeneralAffair/FleetPicKendaraan/V_update', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$pilihanPIC 		= 	$this->input->post('OpsiPIC', TRUE);
			$kodeKendaraan		= 	$this->input->post('cmbKendaraanIdHeader', TRUE);
			$masaAktifPIC 		= 	$this->input->post('masaAktifPIC', TRUE);

			$kode_seksi = NULL;
			$kode_pekerja = NULL;

			$dari;
			$sampai;

			if($pilihanPIC=='Seksi')
			{
				$kode_seksi 	= 	$this->input->post('cmbSeksi');
			}
			elseif ($pilihanPIC == 'Pekerja') 
			{
				$kode_pekerja 	= 	$this->input->post('cmbPekerja');
			}

			if(isset($masaAktifPIC))
			{
				$MasaAktifPIC 		=	explode(' - ', $masaAktifPIC);
				$dari 		=	date('Y-m-d', strtotime($MasaAktifPIC[0]));
				$sampai 	= 	date('Y-m-d', strtotime($MasaAktifPIC[1]));
			}

			$waktu_dihapus 	=	$this->input->post('WaktuDihapus');
			$status_data_user 	=	$this->input->post('CheckAktifUser');
			$status_data 	= 	$this->input->post('CheckAktif');



			$waktu_eksekusi = 	date('Y-m-d H:i:s');

			if ($status_data=='on' || $status_data_user=='on') {
				$waktu_dihapus = '9999-12-12 00:00:00';
			}else{
				$waktu_dihapus = $waktu_eksekusi;
			}

			$data = array(
				'kendaraan_id' 		=> $kodeKendaraan,
				'dari_periode' 		=> $dari,
				'sampai_periode' 	=> $sampai,
				'end_date' 			=> $waktu_dihapus,
				'last_updated' 		=> $waktu_eksekusi,
				'last_updated_by'	=> $this->session->userid,
				'employee_id'		=> $kode_pekerja,
				'pic_kodesie'		=> $kode_seksi
    			);
			$this->M_fleetpickendaraan->updateFleetPicKendaraan($data, $plaintext_string);

			redirect(site_url('GeneralAffair/FleetPicKendaraan'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'PIC Kendaraan';
		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'PIC Kendaraan';
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
				if ($key['menu_id'] !== '289' && $key['menu_id'] !== '290' && $key['menu_id'] !== '291' && $key['menu_id'] !== '296') {
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
		$data['FleetPicKendaraan'] = $this->M_fleetpickendaraan->getFleetPicKendaraan($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/FleetPicKendaraan/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_fleetpickendaraan->deleteFleetPicKendaraan($plaintext_string);

		redirect(site_url('GeneralAffair/FleetPicKendaraan'));
    }



}

/* End of file C_FleetPicKendaraan.php */
/* Location: ./application/controllers/GeneralAffair/MainMenu/C_FleetPicKendaraan.php */
/* Generated automatically on 2017-08-05 13:32:47 */