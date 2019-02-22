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

	public function scanKendaraan()
	{
		$nopol = $this->input->post('nopol');
		$nopol = strtoupper($nopol);
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
		$nopol = strtoupper($nopol);	
		$merk = $this->input->post('merk');	
		$jenis = $this->input->post('jenis');	
		$pj = $this->input->post('pj');	
		$km = $this->input->post('km');	
		$stat_km = $this->input->post('stat_km');	
		$stat_pergi = $this->input->post('stat_pergi');
		$kendaraan_id = $this->M_ordermobile->kend_id($nopol);
		$kendaraan_id = $kendaraan_id[0]['kendaraan_id'];
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
				'transfer'		=>	$transfer,
				'user_id'		=>	$user_id,
				'keterangan'	=>	$pj,
				'kilometer'		=>	$km,
				'stt_odometer'	=>	$stat_km,
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

	public function inputScanKendaraanDinas(){
		date_default_timezone_set("Asia/Jakarta");
		$noind = $this->input->post('noind');	
		$nopol = $this->input->post('nopol');	
		$nopol = strtoupper($nopol);
		$merk = $this->input->post('merk');	
		$jenis = $this->input->post('jenis');	
		$pj = $this->input->post('pj');	
		$km = $this->input->post('km');	
		$stat_km = $this->input->post('stat_km');	
		$stat_pergi = $this->input->post('stat_pergi');
		$kendaraan_id = $this->M_ordermobile->kend_id($nopol);
		$kendaraan_id = $kendaraan_id[0]['kendaraan_id'];
		$user_id = $this->M_ordermobile->user_id($noind);
		$user_id = $user_id[0]['user_id'];
		// $spdl_id = $this->M_ordermobile->spdl_id($noind);
		// $spdl_id = $spdl_id[0]['spdl_id'];
		$tgl = date('Y-m-d');
		$wkt = date('H:i:s');
		$transfer = '0';
		$kategori_kend = '0';

		$a = array();
		$terverifikasi = '';
		// $pj = '2271';
		// $pj = '2271, 8327';
		// $noind = 'B0689';

		if (strpos($pj, ',') !== FALSE) {
			$pj_ver = explode(",", $pj);
			for ($i=0; $i < count($pj_ver); $i++) {
				$cek = $this->M_ordermobile->verify_spdl($pj_ver[$i]);
				$cek = $cek[0]['spdl_id'];
				array_push($a, $cek);
			}
			if (in_array('null', $a)) {
				// echo "string";
				// print_r($a);
				$terverifikasi = 'tidak';
			}else{
				$terverifikasi = 'ya';
			}

		}else{
			$cek = $this->M_ordermobile->verify_spdl($pj);
			$cek = $cek[0]['spdl_id'];
			if ($cek !== 'null') {
				$terverifikasi = 'ya';
			}else{
				$terverifikasi = 'tidak';
			}
		}
		// echo $terverifikasi;
		// exit();
		if ($terverifikasi == 'ya') {
			if (strpos($pj, ',') !== FALSE) {
				$pj = explode(",", $pj);
				for ($i=0; $i < count($pj); $i++) { 
					$noind_spdl = $this->M_ordermobile->getNoind($pj[$i]);
					$noind_spdl = $noind_spdl[0]['noinduk'];
					$input_history = array(
						'kendaraan_id'	=> 	$kendaraan_id,
						'nomor_polisi'	=>	$nopol,
						'tanggal'		=>	$tgl,
						'waktu'			=>	$wkt,
						'spdl_id'		=>	$pj[$i],
						'kategori_kend'	=>	$kategori_kend,
						'noind'			=>	$noind_spdl,
						'status_'		=>	$stat_pergi,
						'transfer'		=>	$transfer,
						'user_id'		=>	$user_id,
						// 'keterangan'	=>	$pj[$i],
						'kilometer'		=>	$km,
						'stt_odometer'	=>	$stat_km,
					);
				$simpan = $this->M_ordermobile->simpan($input_history);
				}
				if ($simpan) {
					$response["error"] = TRUE;
		        	$response["error_msg"] = "Berhasil Simpan";
		        	echo json_encode($response);
				}else{
					$response["error"] = TRUE;
		        	$response["error_msg"] = "Gagal";
		        	echo json_encode($response);
				}
			}else{
				$noind_spdl = $this->M_ordermobile->getNoind($pj);
				$noind_spdl = $noind_spdl[0]['noinduk'];
				$input_history = array(
						'kendaraan_id'	=> 	$kendaraan_id,
						'nomor_polisi'	=>	$nopol,
						'tanggal'		=>	$tgl,
						'waktu'			=>	$wkt,
						'kategori_kend'	=>	$kategori_kend,
						'noind'			=>	$noind_spdl,
						'status_'		=>	$stat_pergi,
						'transfer'		=>	$transfer,
						'user_id'		=>	$user_id,
						'spdl_id'	    =>	$pj,
						'kilometer'		=>	$km,
						'stt_odometer'	=>	$stat_km,
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
			}
		}else{
			$response["error"] = TRUE;
        	$response["error_msg"] = "Gagal";
        	echo json_encode($response);
		}

		// $response["error"] = TRUE;
		// $response["error_msg"] = $kendaraan_id.'+'.$nopol.'+'.$tgl.'+'.$wkt.'+'.$kategori_kend.'+'.$noind.'+'.$stat_pergi.'+'.$spdl_id.'+'.$transfer.'+'.$user_id.'+'.$pj.'+'.$km.'+'.$stat_km;
		// echo json_encode($response);

	}

	public function riwayatDinas($tgl)
	{
		$data['riwayat'] = $this->M_ordermobile->riwayatDinas($tgl);
		echo json_encode($data['riwayat']);
	}

	public function getAllemployee()
	{
		$data['pekerja'] = $this->M_ordermobile->getAllpekerja();
		echo json_encode($data['pekerja']);
	}
}