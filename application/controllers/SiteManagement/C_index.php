<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class C_index extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		  
          $this->load->helper('form');
          $this->load->helper('url');
          $this->load->helper('html');
          $this->load->library('form_validation');
          //load the login model
		  $this->load->library('session');
		  //$this->load->library('Database');
		  $this->load->model('M_Index');
		  $this->load->model('SystemAdministration/MainMenu/M_user');
		  $this->load->model('SiteManagement/MainMenu/M_order');
		  $this->load->model('SiteManagement/MainMenu/M_ordermobile');
	}

		public function login(){

		//$this->load->model('M_index');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$password_md5 = md5($password);
		$log = $this->M_Index->login($username,$password_md5);

		if($log){

		$response["error"] = FALSE;
        echo json_encode($response);
		}else{
			
		$response["error"] = TRUE;
        $response["error_msg"] = "Username / Password salah";
        echo json_encode($response);
		}
	}

	public function getlist(){
		$data['order'] = $this->M_order->listOrder();
		print json_encode($data['order']);
	}

	public function scan(){
		$tgl_terima = $this->input->post('tgl_terima');
		$no_order = $this->input->post('no_order');

		$rows = $this->M_ordermobile->check($no_order);
		if ($rows == 0) {
			echo "gagal";
		}else{
			$update = $this->M_ordermobile->Update($tgl_terima, $no_order);
			echo "success";
		}
	}

	public function scanKendaraanUmum()
	{
		$nopol = $this->input->post('nopol');
		// $nopol = 'BE1234AB';
		$data['kendaraan'] = $this->M_ordermobile->dataKenaraan($nopol);
		// print_r($data['kendaraan'][0]['nomor_polisi']);exit();
		$respon = array();
		array_push($respon, array(
                    'nopol' => $data['kendaraan'][0]['nomor_polisi'],
                    'jenis' => $data['kendaraan'][0]['jenis_kendaraan'],
                    'merk' => $data['kendaraan'][0]['merk_kendaraan'])
                );
		echo json_encode(
                array("result"=>$respon)
            );
	}

	public function inputScanKendaraanUmum(){
		date_default_timezone_set("Asia/Jakarta");
		$noind = $this->input->post('noind');	
		$nopol = $this->input->post('nopol');	
		$merk = $this->input->post('merk');	
		$jenis = $this->input->post('jenis');	
		$pj = $this->input->post('pj');	
		$km = $this->input->post('km');	
		$stat_km = $this->input->post('stat_km');	
		$stat_pergi = $this->input->post('stat_pergi');
		$kendaraan_id = $this->M_ordermobile->kend_id($merk);
		$kendaraan_id = $kendaraan_id[0]['merk_kendaraan_id'];
		$user_id = $this->M_ordermobile->user_id($noind);
		$user_id = $user_id[0]['user_id'];
		$spdl_id = $this->M_ordermobile->spdl_id($noind);
		$spdl_id = $spdl_id[0]['spdl_id'];
		$tgl = date('Y-m-d');
		$wkt = date('H:i:s');
		$transfer = '0';
		$kategori_kend = '0';

		$input_history = array(
				'kendaraan_id'	=> 	$kendaraan_id,
				'nomor_polisi'	=>	$nopol,
				'tanggal'		=>	$tgl,
				'waktu'			=>	$wkt,
				'kategori_kend'	=>	$kategori_kend,
				'noind'			=>	$noind,
				'status_'		=>	$stat_pergi,
				'spdl_id'		=>	$spdl_id,
				'transfer'		=>	$transfer,
				'user_id'		=>	$user_id,
				'keterangan'	=>	$pj,
				'kilometer'		=>	$km,
			);
		$simpan = $this->M_ordermobile->simpan($input_history);

		if ($simpan) {
			$response["error"] = TRUE;
        	$response["error_msg"] = "Berhasil Simpan";
        	echo json_encode($response);
		}else{
			$response["error"] = TRUE;
        	$response["error_msg"] = "Gagal";
        	echo json_encode($response);
		}

		// $response["error"] = TRUE;
		// $response["error_msg"] = $kendaraan_id.'+'.$nopol.'+'.$tgl.'+'.$wkt.'+'.$kategori_kend.'+'.$noind.'+'.$stat_pergi.'+'.$spdl_id.'+'.$transfer.'+'.$user_id.'+'.$pj.'+'.$km;
		// echo json_encode($response);

	}

	public function riwayat($tgl)
	{
		$data['riwayat'] = $this->M_ordermobile->riwayat($tgl);
		echo json_encode($data['riwayat']);
	}
}