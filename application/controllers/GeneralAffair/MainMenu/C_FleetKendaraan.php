<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_FleetKendaraan extends CI_Controller
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
		$this->load->model('GeneralAffair/MainMenu/M_fleetkendaraan');
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

		$data['Title'] = 'Kendaraan';
		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Kendaraan';
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

		if ($lokasi == '01') {
			$data['FleetKendaraan'] 		= $this->M_fleetkendaraan->getFleetKendaraan();
		}else{
			$data['FleetKendaraan'] 		= $this->M_fleetkendaraan->getFleetKendaraanCabang($lokasi);
		}

		$data['FleetKendaraanDeleted']	= $this->M_fleetkendaraan->getFleetKendaraanDeleted();
		foreach ($data['FleetKendaraan'] as $row) {
			if(!file_exists(FCPATH."assets/upload/qrcodeGA/".$row['nomor_polisi'].".png")){
				$qr_image=$row['nomor_polisi'].'.png';
				$params['data'] = $row['nomor_polisi'];
				$params['level'] = 'H';
				$params['size'] = 8;
				$params['savename'] =FCPATH."assets/upload/qrcodeGA/".$qr_image;
				$this->ciqrcode->generate($params);
			}
		}
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/FleetKendaraan/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		date_default_timezone_set('Asia/Jakarta');
		$user_id = $this->session->userid;
		$lokasi = $this->session->kode_lokasi_kerja;

		$data['Title'] = 'Kendaraan';
		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Kendaraan';
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
		$data['FleetJenisKendaraan'] = $this->M_fleetkendaraan->getFleetJenisKendaraan();
		$data['FleetMerkKendaraan'] = $this->M_fleetkendaraan->getFleetMerkKendaraan();
		$data['FleetWarnaKendaraan'] = $this->M_fleetkendaraan->getFleetWarnaKendaraan();
		$data['FleetLokasiKerja'] = $this->M_fleetkendaraan->FleetLokasiKerja();

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('txtNomorPolisiHeader', 'NomorRangka', 'required');
		$this->form_validation->set_rules('txtNomorRangkaHeader', 'NomorPolisi', 'required');
		$this->form_validation->set_rules('cmbJenisKendaraanIdHeader', 'JenisKendaraanId', 'required');
		$this->form_validation->set_rules('cmbMerkKendaraanIdHeader', 'MerkKendaraanId', 'required');
		$this->form_validation->set_rules('cmbWarnaKendaraanIdHeader', 'WarnaKendaraanId', 'required');
		$this->form_validation->set_rules('cmbTahunPembuatan', 'TahunPembuatan', 'required');

		$data['user_login'] = $this->session->user;
		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('GeneralAffair/FleetKendaraan/V_create', $data);
			$this->load->view('V_Footer',$data);
		} else {

			$nomor_polisi 			=	$this->input->post('txtNomorPolisiHeader', TRUE);
			$nomor_polisi_pendek	=	str_replace(' ', '', $nomor_polisi);
			$kode_jenis_kendaraan	=	$this->input->post('cmbJenisKendaraanIdHeader', TRUE);
			$kode_merk_kendaraan	=	$this->input->post('cmbMerkKendaraanIdHeader', TRUE);
			$kode_warna_kendaraan	=	$this->input->post('cmbWarnaKendaraanIdHeader', TRUE);
			$tahun_pembuatan		=	$this->input->post('cmbTahunPembuatan', TRUE);
			$nomor_rangka			=	$this->input->post('txtNomorRangkaHeader', TRUE);
			$usable					=	$this->input->post('usable', TRUE);
			$pemilik_kendaraan		=	$this->input->post('kepemilikan_kendaraan', TRUE);
			$lokasikerja			=	$this->input->post('lokasi_kerja_k', TRUE);
			$pic	        		=	$this->input->post('pic_kendaraan', TRUE);
			$tag_number			    =	$this->input->post('TagNumber', TRUE);

			// $start_date 			= 	date('Y-m-d H:i:s', strtotime($this->input->post('txtStartDateHeader')));
			// $end_date 				=	date('Y-m-d H:i:s', strtotime($this->input->post('txtEndDateHeader')));


			$nama_STNK ="";
			$nama_BPKB ="";
			$nama_Kendaraan ="";

    		$this->load->library('upload');

    		if(!empty($_FILES['FotoSTNK']['name']))
    		{
    			$direktoriSTNK						= $_FILES['FotoSTNK']['name'];
    			$ekstensiSTNK						= pathinfo($direktoriSTNK,PATHINFO_EXTENSION);
    			$nama_STNK							= "GA-Kendaraan-STNK-".str_replace(' ', '_', date('Y-m-d H:i:s')).".".$ekstensiSTNK;



    			// $nama_STNK 							= filter_var($_FILES['FotoSTNK']['name'],  FILTER_SANITIZE_URL, FILTER_SANITIZE_EMAIL);

				$config['upload_path']          = './assets/upload/GA/Kendaraan';
				$config['allowed_types']        = 'jpg|png|gif|pdf|';
				// $config['allowed_types']        = '*';
				$config['max_size']				= 500;
	        	$config['file_name']		 	= $nama_STNK;
	        	$config['overwrite'] 			= TRUE;

	        	$this->upload->initialize($config);

	    		if ($this->upload->do_upload('FotoSTNK'))
	    		{
            		$this->upload->data();
        		}
        		else
        		{

        			$errorinfo = $this->upload->display_errors();
        		}
        	}
    		if(!empty($_FILES['FotoBPKB']['name']))
    		{
    			$direktoriBPKB						= $_FILES['FotoBPKB']['name'];
    			$ekstensiBPKB						= pathinfo($direktoriBPKB,PATHINFO_EXTENSION);
    			$nama_BPKB							= "GA-Kendaraan-BPKB-".str_replace(' ', '_', date('Y-m-d H:i:s')).".".$ekstensiBPKB;
    			// $nama_BPKB							= filter_var($_FILES['FotoBPKB']['name'],  FILTER_SANITIZE_URL, FILTER_SANITIZE_EMAIL);

				$config['upload_path']          = './assets/upload/GA/Kendaraan';
				$config['allowed_types']        = 'jpg|png|gif|pdf';
				// $config['allowed_types']        = '*';
				$config['max_size']				= 500;
	        	$config['file_name']		 	= $nama_BPKB;
	        	$config['overwrite'] 			= TRUE;


	        	$this->upload->initialize($config);

	    		if ($this->upload->do_upload('FotoBPKB'))
	    		{
            		$this->upload->data();
        		}
        		else
        		{

        			$errorinfo = $this->upload->display_errors();
        		}
        	}
    		if(!empty($_FILES['FotoKendaraan']['name']))
    		{
    			$direktoriKendaraan					= $_FILES['FotoKendaraan']['name'];
    			$ekstensiKendaraan					= pathinfo($direktoriKendaraan,PATHINFO_EXTENSION);
    			$nama_Kendaraan						= "GA-Kendaraan-Foto-".str_replace(' ', '_', date('Y-m-d H:i:s')).".".$ekstensiKendaraan;
    			// $nama_Kendaraan 					= filter_var($_FILES['fileFoto']['name'],  FILTER_SANITIZE_URL, FILTER_SANITIZE_EMAIL);

				$config['upload_path']          = './assets/upload/GA/Kendaraan';
				// $config['allowed_types']        = 'jpg|png|gif|';
				$config['allowed_types']        = '*';
				$config['max_size']				= 500;
	        	$config['file_name']		 	= $nama_Kendaraan;
	        	$config['overwrite'] 			= TRUE;


	        	$this->upload->initialize($config);

	    		if ($this->upload->do_upload('FotoKendaraan'))
	    		{
            		$this->upload->data();
        		}
        		else
        		{

        			$errorinfo = $this->upload->display_errors();
        		}
        	}
        	$user_ya = $this->session->user;
        	if ($user_ya == "B0647") {
        		$data = array(
					'nomor_polisi' 			=> strtoupper($nomor_polisi_pendek),
					'jenis_kendaraan_id' 	=> $kode_jenis_kendaraan,
					'merk_kendaraan_id' 	=> $kode_merk_kendaraan,
					'warna_kendaraan_id' 	=> $kode_warna_kendaraan,
					'tahun_pembuatan' 		=> $tahun_pembuatan,
					'nomor_rangka' 		=> $nomor_rangka,
					'foto_stnk' 			=> $nama_STNK,
					'foto_bpkb'				=> $nama_BPKB,
					'foto_kendaraan'		=> $nama_Kendaraan,
					'start_date' 			=> date('Y-m-d H:i:s'),
					'end_date'				=> '9999-12-12 00:00:00',
					'creation_date' 		=> date('Y-m-d H:i:s'),
					'created_by' 			=> $this->session->userid,
					'kode_lokasi_kerja'		=> $lokasikerja,
					'usable'				=> $usable,
					'hak_milik'				=> $pemilik_kendaraan,
					'pic_kendaraan'				=> $pic,
					'tag_number'				=> $tag_number,
    			);
        	}else{
        		$data = array(
					'nomor_polisi' 			=> strtoupper($nomor_polisi_pendek),
					'jenis_kendaraan_id' 	=> $kode_jenis_kendaraan,
					'merk_kendaraan_id' 	=> $kode_merk_kendaraan,
					'warna_kendaraan_id' 	=> $kode_warna_kendaraan,
					'tahun_pembuatan' 		=> $tahun_pembuatan,
					'nomor_rangka' 		=> $nomor_rangka,
					'foto_stnk' 			=> $nama_STNK,
					'foto_bpkb'				=> $nama_BPKB,
					'foto_kendaraan'		=> $nama_Kendaraan,
					'start_date' 			=> date('Y-m-d H:i:s'),
					'end_date'				=> '9999-12-12 00:00:00',
					'creation_date' 		=> date('Y-m-d H:i:s'),
					'created_by' 			=> $this->session->userid,
					'kode_lokasi_kerja'		=> $lokasi,
					'usable'				=> $usable,
					'hak_milik'				=> $pemilik_kendaraan,
					'pic_kendaraan'				=> $pic,
					'tag_number'				=> $tag_number,
    			);
        	}

    		// echo "<pre>";
    		// print_r($data);
    		// exit();
			$this->M_fleetkendaraan->setFleetKendaraan($data);
			$header_id = $this->db->insert_id();
			//insert to t_log
			$aksi = 'MANAGEMENT KENDARAAN';
			$detail = 'Create Fleet Kendaraan Nopol='.strtoupper($nomor_polisi_pendek);
			$this->log_activity->activity_log($aksi, $detail);
			//

			redirect(site_url('GeneralAffair/FleetKendaraan'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;
		date_default_timezone_set('Asia/Jakarta');

		$data['Title'] = 'Kendaraan';
		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Kendaraan';
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
		$data['FleetKendaraan'] = $this->M_fleetkendaraan->getFleetKendaraan($plaintext_string);

		// echo "<pre>";
		// print_r($data['FleetKendaraan']);
		// exit();

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */
		$data['FleetJenisKendaraan'] = $this->M_fleetkendaraan->getFleetJenisKendaraan();
		$data['FleetMerkKendaraan'] = $this->M_fleetkendaraan->getFleetMerkKendaraan();
		$data['FleetWarnaKendaraan'] = $this->M_fleetkendaraan->getFleetWarnaKendaraan();
		$data['FleetLokasiKerja'] = $this->M_fleetkendaraan->FleetLokasiKerja();

		// echo "<pre>";
		// print_r($data['FleetLokasiKerja']);
		// exit();

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('txtNomorPolisiHeader', 'NomorPolisi', 'required');
		$this->form_validation->set_rules('txtNomorRangkaHeader', 'NomorRangka', 'required');
		$this->form_validation->set_rules('cmbJenisKendaraanIdHeader', 'JenisKendaraanId', 'required');
		$this->form_validation->set_rules('cmbMerkKendaraanIdHeader', 'MerkKendaraanId', 'required');
		$this->form_validation->set_rules('cmbWarnaKendaraanIdHeader', 'WarnaKendaraanId', 'required');
		$this->form_validation->set_rules('cmbTahunPembuatan', 'TahunPembuatan', 'required');

		$data['user_login'] = $this->session->user;
		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('GeneralAffair/FleetKendaraan/V_update', $data);
			$this->load->view('V_Footer',$data);
		} else {

			$nomor_polisi 			=	$this->input->post('txtNomorPolisiHeader', TRUE);
			$nomor_polisi_pendek	=	str_replace(' ', '', $nomor_polisi);
			$kode_jenis_kendaraan	=	$this->input->post('cmbJenisKendaraanIdHeader', TRUE);
			$kode_merk_kendaraan	=	$this->input->post('cmbMerkKendaraanIdHeader', TRUE);
			$kode_warna_kendaraan	=	$this->input->post('cmbWarnaKendaraanIdHeader', TRUE);
			$tahun_pembuatan		=	$this->input->post('cmbTahunPembuatan', TRUE);
			$nomor_rangka		=	$this->input->post('txtNomorRangkaHeader', TRUE);
			$fileSTNKawal			=	$this->input->post('FotoSTNKawal');
			$fileBPKBawal			=	$this->input->post('FotoBPKBawal');
			$fileKendaraanawal		=	$this->input->post('FotoKendaraanawal');
			$statusdata				=	$this->input->post('CheckAktif');
			$status_data_user 	=	$this->input->post('CheckAktifUser');
			$WaktuDihapus 			=	$this->input->post('WaktuDihapus');
			$usable 			=	$this->input->post('usable');
			$hak_milik 			=	$this->input->post('kepemilikan_kendaraan');
			$pic_kendaraan 			=	$this->input->post('pic_kendaraan');
			$tag_number		=	$this->input->post('TagNumber', TRUE);

			// $tanggalNonaktif		=	$this->input->post('txtTanggalNonaktif');

			// $start_date 			= 	date('Y-m-d H:i:s', strtotime($this->input->post('txtStartDateHeader')));
			// $end_date 				=	date('Y-m-d H:i:s', strtotime($this->input->post('txtEndDateHeader')));

			$nama_STNK;
			$nama_BPKB;
			$nama_Kendaraan;

    		$this->load->library('upload');

    		if(!empty($_FILES['FotoSTNK']['name']))
    		{
    			$direktoriSTNK						= $_FILES['FotoSTNK']['name'];
    			$ekstensiSTNK						= pathinfo($direktoriSTNK,PATHINFO_EXTENSION);
    			$nama_STNK							= "GA-Kendaraan-STNK-".str_replace(' ', '_', date('Y-m-d H:i:s')).".".$ekstensiSTNK;



    			// $nama_STNK 							= filter_var($_FILES['FotoSTNK']['name'],  FILTER_SANITIZE_URL, FILTER_SANITIZE_EMAIL);

				$config['upload_path']          = './assets/upload/GA/Kendaraan';
				// $config['allowed_types']        = 'jpg|png|gif|';
				$config['allowed_types']        = '*';
				$config['max_size']				= 500;
	        	$config['file_name']		 	= $nama_STNK;
	        	$config['overwrite'] 			= TRUE;

	        	$this->upload->initialize($config);

	    		if ($this->upload->do_upload('FotoSTNK'))
	    		{
            		$this->upload->data();
            		$data = array('foto_stnk' => $nama_STNK);
            		$this->M_fleetkendaraan->updateFleetKendaraan($data, $plaintext_string);
        		}
        		else
        		{

        			$errorinfo = $this->upload->display_errors();
        		}
        	}
    		if(!empty($_FILES['FotoBPKB']['name']))
    		{
    			$direktoriBPKB						= $_FILES['FotoBPKB']['name'];
    			$ekstensiBPKB						= pathinfo($direktoriBPKB,PATHINFO_EXTENSION);
    			$nama_BPKB							= "GA-Kendaraan-BPKB-".str_replace(' ', '_', date('Y-m-d H:i:s')).".".$ekstensiBPKB;
    			// $nama_BPKB							= filter_var($_FILES['FotoBPKB']['name'],  FILTER_SANITIZE_URL, FILTER_SANITIZE_EMAIL);

				$config['upload_path']          = './assets/upload/GA/Kendaraan';
				// $config['allowed_types']        = 'jpg|png|gif|';
				$config['allowed_types']        = '*';
				$config['max_size']				= 500;
	        	$config['file_name']		 	= $nama_BPKB;
	        	$config['overwrite'] 			= TRUE;


	        	$this->upload->initialize($config);

	    		if ($this->upload->do_upload('FotoBPKB'))
	    		{
            		$this->upload->data();
            		$data = array('foto_bpkb' => $nama_BPKB);
            		$this->M_fleetkendaraan->updateFleetKendaraan($data, $plaintext_string);
        		}
        		else
        		{

        			$errorinfo = $this->upload->display_errors();
        		}
        	}
    		if(!empty($_FILES['FotoKendaraan']['name']))
    		{
    			$direktoriKendaraan					= $_FILES['FotoKendaraan']['name'];
    			$ekstensiKendaraan					= pathinfo($direktoriKendaraan,PATHINFO_EXTENSION);
    			$nama_Kendaraan						= "GA-Kendaraan-Foto-".str_replace(' ', '_', date('Y-m-d H:i:s')).".".$ekstensiKendaraan;
    			// $nama_Kendaraan 					= filter_var($_FILES['fileFoto']['name'],  FILTER_SANITIZE_URL, FILTER_SANITIZE_EMAIL);

				$config['upload_path']          = './assets/upload/GA/Kendaraan';
				// $config['allowed_types']        = 'jpg|png|gif|';
				$config['allowed_types']        = '*';
				$config['max_size']				= 500;
	        	$config['file_name']		 	= $nama_Kendaraan;
	        	$config['overwrite'] 			= TRUE;


	        	$this->upload->initialize($config);

	    		if ($this->upload->do_upload('FotoKendaraan'))
	    		{
            		$this->upload->data();
            		$data = array('foto_kendaraan' => $nama_Kendaraan);
            		$this->M_fleetkendaraan->updateFleetKendaraan($data, $plaintext_string);
        		}
        		else
        		{

        			$errorinfo = $this->upload->display_errors();
        		}
        	}

        	$waktu_eksekusi 	= 	date('Y-m-d H:i:s');

			if ($statusdata=='on' || $status_data_user=='on') {
				$waktu_dihapus = '9999-12-12 00:00:00';
			}else{
				$waktu_dihapus = $waktu_eksekusi;
			}

			$user_ya= $this->session->user;
			$lokasi = $this->input->post('lokasi_kerja_k',TRUE);
			if ($user_ya == "B0647") {
				$data = array(
					'nomor_polisi' 			=> strtoupper($nomor_polisi_pendek),
					'jenis_kendaraan_id' 	=> $kode_jenis_kendaraan,
					'merk_kendaraan_id' 	=> $kode_merk_kendaraan,
					'warna_kendaraan_id' 	=> $kode_warna_kendaraan,
					'tahun_pembuatan' 		=> $tahun_pembuatan,
					'nomor_rangka' 		    => $nomor_rangka,
					'kode_lokasi_kerja'		=> $lokasi,
					'end_date'				=> $waktu_dihapus,
					'last_updated'			=> date('Y-m-d H:i:s'),
					'last_updated_by'		=> $this->session->userid,
					'created_by' 			=> $this->session->userid,
					'usable' 				=> $usable,
					'hak_milik' 			=> $hak_milik,
					'pic_kendaraan' 		=> $pic_kendaraan,
					'tag_number' 		    => $tag_number,
	    		);
			}else{
	    		$data = array(
					'nomor_polisi' 			=> strtoupper($nomor_polisi_pendek),
					'jenis_kendaraan_id' 	=> $kode_jenis_kendaraan,
					'merk_kendaraan_id' 	=> $kode_merk_kendaraan,
					'warna_kendaraan_id' 	=> $kode_warna_kendaraan,
					'tahun_pembuatan' 		=> $tahun_pembuatan,
					'nomor_rangka' 		    => $nomor_rangka,
					'end_date'				=> $waktu_dihapus,
					'last_updated'			=> date('Y-m-d H:i:s'),
					'last_updated_by'		=> $this->session->userid,
					'created_by' 			=> $this->session->userid,
					'usable' 				=> $usable,
					'hak_milik' 			=> $hak_milik,
					'pic_kendaraan' 		=> $pic_kendaraan,
					'tag_number' 		    => $tag_number,
	    		);
			}

			$this->M_fleetkendaraan->updateFleetKendaraan($data, $plaintext_string);
			//insert to t_log
			$aksi = 'MANAGEMENT KENDARAAN';
			$detail = 'Update Fleet Kendaraan ID='.$plaintext_string;
			$this->log_activity->activity_log($aksi, $detail);
			//

			redirect(site_url('GeneralAffair/FleetKendaraan'));
			// bawah ini asli
			// $data = array(
			// 	'nomor_polisi' => $this->input->post('txtNomorPolisiHeader',TRUE),
			// 	'jenis_kendaraan_id' => $this->input->post('cmbJenisKendaraanIdHeader',TRUE),
			// 	'merk_kendaraan_id' => $this->input->post('cmbMerkKendaraanIdHeader',TRUE),
			// 	'warna_kendaraan_id' => $this->input->post('cmbWarnaKendaraanIdHeader',TRUE),
			// 	'tahun_pembuatan' => $this->input->post('txtTahunPembuatanHeader',TRUE),
			// 	'foto_stnk' => $this->input->post('txtFotoStnkHeader',TRUE),
			// 	'foto_bpkb' => $this->input->post('txtFotoBpkbHeader',TRUE),
			// 	'foto_kendaraan' => $this->input->post('txtFotoKendaraanHeader',TRUE),
			// 	'start_date' => $this->input->post('txtStartDateHeader',TRUE),
			// 	'end_date' => $this->input->post('txtEndDateHeader',TRUE),
			// 	'last_updated' => 'NOW()',
			// 	'last_updated_by' => $this->session->userid,
   //  			);
			// $this->M_fleetkendaraan->updateFleetKendaraan($data, $plaintext_string);

			// redirect(site_url('GeneralAffair/FleetKendaraan'));
		}
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Kendaraan';
		$data['Menu'] = 'Master';
		$data['SubMenuOne'] = 'Kendaraan';
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
		$data['FleetKendaraan'] = $this->M_fleetkendaraan->getFleetKendaraan($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('GeneralAffair/FleetKendaraan/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
    	date_default_timezone_set('Asia/Jakarta');

        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_fleetkendaraan->deleteFleetKendaraan($plaintext_string);
		//insert to t_log
		$aksi = 'MANAGEMENT KENDARAAN';
		$detail = 'Delete Fleet Kendaraan ID='.$plaintext_string;
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect(site_url('GeneralAffair/FleetKendaraan'));
    }


    public function export_qr($id=FALSE){
    	$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$data['FleetKendaraan'] 		= $this->M_fleetkendaraan->getFleetKendaraan($plaintext_string);
		//insert to t_log
		$aksi = 'MANAGEMENT KENDARAAN';
		$detail = 'Export PDF Fleet Kendaraan ID='.$plaintext_string;
		$this->log_activity->activity_log($aksi, $detail);
		//
		$this->load->library('pdf');

		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8', 'A4', 8, '', 5, 5, 5, 5, 0, 0, 'P');
		$filename = 'qr_code.pdf';
		$html = $this->load->view('GeneralAffair/FleetKendaraan/V_export_qr',$data, true);
		$pdf->WriteHTML($html);
		$pdf->Output($filename, 'I');
    }

    public function pic_kendaraan(){
    	$p = strtoupper($this->input->get('term'));

    	$data = $this->M_fleetkendaraan->pic_kendaraan($p);

    	echo json_encode($data);
    }

}


/* End of file C_FleetKendaraan.php */
/* Location: ./application/controllers/GeneralAffair/MainMenu/C_FleetKendaraan.php */
/* Generated automatically on 2017-08-05 13:23:25 */
