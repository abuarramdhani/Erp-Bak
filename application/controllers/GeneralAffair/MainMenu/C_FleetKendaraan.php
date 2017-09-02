<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_FleetKendaraan extends CI_Controller
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
		$this->load->model('GeneralAffair/MainMenu/M_fleetkendaraan');

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

		$data['Title'] = 'Kendaraan';
		$data['Menu'] = 'General Affair';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['FleetKendaraan'] 		= $this->M_fleetkendaraan->getFleetKendaraan();
		$data['FleetKendaraanDeleted']	= $this->M_fleetkendaraan->getFleetKendaraanDeleted();

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

		$data['Title'] = 'Kendaraan';
		$data['Menu'] = 'General Affair';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */
		$data['FleetJenisKendaraan'] = $this->M_fleetkendaraan->getFleetJenisKendaraan();
		$data['FleetMerkKendaraan'] = $this->M_fleetkendaraan->getFleetMerkKendaraan();
		$data['FleetWarnaKendaraan'] = $this->M_fleetkendaraan->getFleetWarnaKendaraan();

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('txtNomorPolisiHeader', 'NomorPolisi', 'required');
		$this->form_validation->set_rules('cmbJenisKendaraanIdHeader', 'JenisKendaraanId', 'required');
		$this->form_validation->set_rules('cmbMerkKendaraanIdHeader', 'MerkKendaraanId', 'required');
		$this->form_validation->set_rules('cmbWarnaKendaraanIdHeader', 'WarnaKendaraanId', 'required');
		$this->form_validation->set_rules('cmbTahunPembuatan', 'TahunPembuatan', 'required');

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
				$config['allowed_types']        = 'jpg|png|gif|';
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
				$config['allowed_types']        = 'jpg|png|gif|';
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
				$config['allowed_types']        = 'jpg|png|gif|';
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

    		$data = array(
				'nomor_polisi' 			=> strtoupper($nomor_polisi_pendek),
				'jenis_kendaraan_id' 	=> $kode_jenis_kendaraan,
				'merk_kendaraan_id' 	=> $kode_merk_kendaraan,
				'warna_kendaraan_id' 	=> $kode_warna_kendaraan,
				'tahun_pembuatan' 		=> $tahun_pembuatan,
				'foto_stnk' 			=> $nama_STNK,
				'foto_bpkb'				=> $nama_BPKB,
				'foto_kendaraan'		=> $nama_Kendaraan,				
				'start_date' 			=> date('Y-m-d H:i:s'),
				'end_date'				=> '9999-12-12 00:00:00',
				'creation_date' 		=> date('Y-m-d H:i:s'),
				'created_by' 			=> $this->session->userid
    		);


			$this->M_fleetkendaraan->setFleetKendaraan($data);
			$header_id = $this->db->insert_id();

			redirect(site_url('GeneralAffair/FleetKendaraan'));
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;
		date_default_timezone_set('Asia/Jakarta');

		$data['Title'] = 'Kendaraan';
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
		$data['FleetKendaraan'] = $this->M_fleetkendaraan->getFleetKendaraan($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */
		$data['FleetJenisKendaraan'] = $this->M_fleetkendaraan->getFleetJenisKendaraan();
		$data['FleetMerkKendaraan'] = $this->M_fleetkendaraan->getFleetMerkKendaraan();
		$data['FleetWarnaKendaraan'] = $this->M_fleetkendaraan->getFleetWarnaKendaraan();

		/* LINES DROPDOWN DATA */

		$this->form_validation->set_rules('txtNomorPolisiHeader', 'NomorPolisi', 'required');
		$this->form_validation->set_rules('cmbJenisKendaraanIdHeader', 'JenisKendaraanId', 'required');
		$this->form_validation->set_rules('cmbMerkKendaraanIdHeader', 'MerkKendaraanId', 'required');
		$this->form_validation->set_rules('cmbWarnaKendaraanIdHeader', 'WarnaKendaraanId', 'required');
		$this->form_validation->set_rules('cmbTahunPembuatan', 'TahunPembuatan', 'required');

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
			$fileSTNKawal			=	$this->input->post('FotoSTNKawal');
			$fileBPKBawal			=	$this->input->post('FotoBPKBawal');
			$fileKendaraanawal		=	$this->input->post('FotoKendaraanawal');
			$statusdata				=	$this->input->post('CheckAktif');
			$WaktuDihapus 			=	$this->input->post('WaktuDihapus');

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
				$config['allowed_types']        = 'jpg|png|gif|';
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
				$config['allowed_types']        = 'jpg|png|gif|';
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
				$config['allowed_types']        = 'jpg|png|gif|';
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

        	if($statusdata=='on' && $WaktuDihapus!='12-12-9999 00:00:00')
        	{
        		$WaktuDihapus 	=	'9999-12-12 00:00:00';
        	}
        	elseif($statusdata=='' && $WaktuDihapus=='12-12-9999 00:00:00')
        	{
        		$WaktuDihapus 	=	date('Y-m-d H:i:s');
        	}
        	else{
        		$WaktuDihapus 	=	date('Y-m-d H:i:s', strtotime($WaktuDihapus));
        	}
    		$data = array(
				'nomor_polisi' 			=> strtoupper($nomor_polisi_pendek),
				'jenis_kendaraan_id' 	=> $kode_jenis_kendaraan,
				'merk_kendaraan_id' 	=> $kode_merk_kendaraan,
				'warna_kendaraan_id' 	=> $kode_warna_kendaraan,
				'tahun_pembuatan' 		=> $tahun_pembuatan,
				'end_date'				=> $WaktuDihapus,
				'last_updated'			=> date('Y-m-d H:i:s'),
				'last_updated_by'		=> $this->session->userid,
				'created_by' 			=> $this->session->userid
    		);


			$this->M_fleetkendaraan->updateFleetKendaraan($data, $plaintext_string);

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

		redirect(site_url('GeneralAffair/FleetKendaraan'));
    }


 
}

/* End of file C_FleetKendaraan.php */
/* Location: ./application/controllers/GeneralAffair/MainMenu/C_FleetKendaraan.php */
/* Generated automatically on 2017-08-05 13:23:25 */