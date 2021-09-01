<?php 
Defined("BASEPATH") or exit("No Direct Script Access Allowed");

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

/**
 * 
 */
class C_DataVaksinasi extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('encryption');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('Covid/DataVaksinasi/M_datavaksinasi');
		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();
	}

	public function checkSession()
	{
		if(!($this->session->is_logged)) redirect('');
	}

	public function index()
	{
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Monitoring Data Vaksinasi';
		$data['Header']			=	'Monitoring Data Vaksinasi';
		$data['Menu'] 			= 	'Data Vaksinasi';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_datavaksinasi->getData();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Covid/DataVaksinasi/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Tambah()
	{
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Tambah Data Vaksinasi';
		$data['Header']			=	'Tambah Data Vaksinasi';
		$data['Menu'] 			= 	'Data Vaksinasi';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['kelompok'] = $this->M_datavaksinasi->getKelompok();
		$data['jenis'] = $this->M_datavaksinasi->getJenis();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Covid/DataVaksinasi/V_Tambah',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getPekerjaBykey()
	{
		$key = $this->input->get('key');

		$data = $this->M_datavaksinasi->getPekerjaBykey($key);

		echo json_encode($data);
	}

	public function getPesertaByNoindKey()
	{
		$noind = $this->input->get('noind');
		$key = $this->input->get('key');
		
		$data = $this->M_datavaksinasi->getPesertaByNoindKey($noind,$key);

		echo json_encode($data);
	}

	public function DetailKelompok()
	{
		$id = $this->input->get('id');

		$data = $this->M_datavaksinasi->getKelompokById($id);

		echo json_encode($data);
	}

	public function uploadAttachment($prefix,$fieldname)
	{
	    $this->load->library('upload');

		if(!empty($_FILES[$fieldname]['name']))
		{
			$name		= $_FILES[$fieldname]['name'];
			$ekstensi	= pathinfo($name,PATHINFO_EXTENSION);
			$nama 		= $prefix.time().uniqid().".".$ekstensi;

			$config['upload_path']  = './assets/upload/pemutihan_data_pekerja/attachment/';
			$config['allowed_types']= 'jpg|png|jpeg';
			$config['max_size']		= 500;
        	$config['file_name']	= $nama;
        	$config['overwrite'] 	= TRUE;

        	$this->upload->initialize($config);

    		if ($this->upload->do_upload($fieldname)){
        		$this->upload->data();
        		return $nama;
    		}else{
    			$errorinfo = $this->upload->display_errors();
    		}
    	}
    	return null;
	}

	public function Simpan()
	{
		$noind 		= $this->input->post('slc-CVD-DataVaksinasi-Pekerja');
		$nik 		= $this->input->post('txt-CVD-DataVaksinasi-Peserta-NIK');
		$nama 		= $this->input->post('txt-CVD-DataVaksinasi-Peserta-Nama');
	    $kelompok 	= $this->input->post('slc-CVD-DataVaksinasi-Kelompok');
	    $tanggal 	= $this->input->post('txt-CVD-DataVaksinasi-Tanggal');
	    $jenis 		= $this->input->post('txt-CVD-DataVaksinasi-Jenis');
	    $lokasi 	= $this->input->post('txt-CVD-DataVaksinasi-Lokasi');
	    $vaksin_ke 	= $this->input->post('slc-CVD-DataVaksinasi-Ke');
	    $user 		= $this->session->user;
 
	    $kartu_filename = $this->uploadAttachment('kartu_vaksin_','fl-CVD-DataVaksinasi-Kartu'); 
	    $sertifikat_filename = $this->uploadAttachment('sertifikat_vaksin_','fl-CVD-DataVaksinasi-Sertifikat');

	    $data = array(
	    	'noind'						=> $noind,
		    'nama'						=> $nama,
		    'nik'						=> $nik, 
		    'kelompok_vaksin'			=> $kelompok,
		    'tanggal_vaksin'			=> $tanggal,
		    'jenis_vaksin'				=> $jenis,
		    'lokasi_vaksin'				=> $lokasi,
		    'vaksin_ke'					=> $vaksin_ke,
		    'path_kartu_vaksin'			=> $kartu_filename,
		    'path_sertifikat_vaksin'	=> $sertifikat_filename,
		    'user_input'				=> $user
	    );

	    $id = $this->M_datavaksinasi->insertDataVaksinasi($data);

	    $log = array(
	    	'wkt' 		=> date('Y-m-d H:i:s'),
	    	'menu'		=> 'TIM COVID 19 -> DATA VAKSINASI',
	    	'ket'		=> "id: ".$id." data: ".$noind."/".$nama."/".$nik."/".$kelompok,
	    	'noind'		=> $user,
	    	'jenis'		=> 'INSERT DATA VAKSINASI',
	    	'program'	=> 'ERP'
	    );
	    $this->M_datavaksinasi->insertLog($log);
	    echo "success";
	}

	public function Hapus($encrypted_id)
	{
		$id = str_replace(array('-', '_', '~'), array('+', '/', '='), $encrypted_id);
		$id = $this->encryption->decrypt($id);
		$user = $this->session->user;
		$this->M_datavaksinasi->deleteDataVaksinasiById($id);
		$log = array(
	    	'wkt' 		=> date('Y-m-d H:i:s'),
	    	'menu'		=> 'TIM COVID 19 -> DATA VAKSINASI',
	    	'ket'		=> "id: ".$id,
	    	'noind'		=> $user,
	    	'jenis'		=> 'DELETE DATA VAKSINASI',
	    	'program'	=> 'ERP'
	    );
	    $this->M_datavaksinasi->insertLog($log);
		echo "success";
	}
}