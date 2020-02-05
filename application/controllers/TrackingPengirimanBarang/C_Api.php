<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class C_Api extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('TrackingPengirimanBarang/M_api');
	}


	public function checkSession(){
		if($this->session->TrackingPengirimanBarang_logged_in){
		}else{
			$data = array(
				'ok' => false,
				'msg' => "Anda belum login",
				'data' => []
			  );
			header('Content-Type: Application/json');
			echo json_encode($data);
			exit();
		}
	}

  	public function index()
	{
		$this->load->view('TrackingPengirimanBarang/V_indexApi');
	}

	public function login()
	{
		header("Access-Control-Allow-Origin: *");
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$result = $this->M_api->login($username,md5($password));
		if($result){
			$this->session->set_userdata('TrackingPengirimanBarang_logged_in', TRUE);
			$data = array(
				'ok' => true,
				'msg' => "Berhasil login",
				'data' => $result,
			);
		} else {
			$data = array(
				'ok' => false,
				'msg' => "Silahkan cek kembali data yang anda masukan",
				'data' => []
			  );
		}
		
		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($data));
	}

	public function logout()
	{
		$data = array(
			'ok' => true,
			'msg' => "Berhasil Logout",
			'data' => []
		);
		$this->session->set_userdata('TrackingPengirimanBarang_logged_in', FALSE);
		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($data));
	}


	
	public function detailSPB()
	{
		$this->checkSession();
		header("Access-Control-Allow-Origin: *");
		$noSPB = $this->input->post('no_spb');
		
		if (empty($noSPB)) {
			header('Content-Type: Application/json');
			echo json_encode(array(
			  'ok' => false,
			  'msg' => 'parameter tidak boleh kosong',
			  'data' => []
			));die();
		  }

		$result = $this->M_api->detailSPB($noSPB);
		
		$data = array(
			'ok' => true,
			'data' => $result,
			'msg' => "Berhasil",
			);
		
		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($data));
	}

	
	public function detailConfirmationTPB()
	{
		$this->checkSession();
		header("Access-Control-Allow-Origin: *");
		$noSPB = $this->input->post('no_spb');
		if (empty($noSPB)) {
			header('Content-Type: Application/json');
			echo json_encode(array(
			  'ok' => false,
			  'msg' => 'parameter tidak boleh kosong',
			  'data' => []
			));die();
		  }

		$result = $this->M_api->detailConfirmationTPB($noSPB);
		$data = array(
			'ok' => true,
			'data' => $result,
			'msg' => "Berhasil",
			);
		
		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($data));
	}

	public function editPass()
	{
		$this->checkSession();
		header("Access-Control-Allow-Origin: *");
		$username  = $this->input->post('username');
		$last_pass = $this->input->post('last_pass');
		$new_pass  = $this->input->post('new_pass');

		$md5LastPass = md5($last_pass);
		$md5NewPass = md5($new_pass);

		$result = $this->M_api->editPass($username);
		
		if ($md5LastPass != $result[0]['password']) {
			header('Content-Type: Application/json');
			$data = array(
				'ok' => false,
				'msg' => "Password lama anda salah",
				'data' => []
				);

			echo json_encode($data);
			die();
		  }
		 
		//update password
		$this->M_api->editPassUpdate($username,$md5NewPass);  

		$result = $this->M_api->editPass($username);  
		$data = array(
			'ok' => true,
			'msg' => "Berhasil merubah password",
			'data' => $result,
			);
		
		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($data));
	}

	public function endTPB()
	{
		$this->checkSession();
		header("Access-Control-Allow-Origin: *");
	  
		$noSPB 		= $this->input->post('no_spb');
		$status		= $this->input->post('status');
		$penerima 	= $this->input->post('penerima');

		if (empty($noSPB) || empty($status)) {
			header('Content-Type: Application/json');
			$data = array(
			  'ok' => false,
			  'msg' => "Data tidak boleh kosong",
			  'data' => []
			);
			echo json_encode($data);die();
		  }

		$this->M_api->endTPB($noSPB,$status,$penerima);
		$result = $this->M_api->endTPBGetSPB($noSPB);
		$data = array(
			'ok' => true,
			'msg' => "Berhasil",
			'data' => $result,
			);
		
		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($data));
	}

	public function finishConfirmTPB()
	{
		$this->checkSession();
		header("Access-Control-Allow-Origin: *");
	  
		$noSPB 				 = $this->input->post('no_spb');
		$line_id 			 = $this->input->post('line_id');
		$confirmation_status = $this->input->post('confirmation_status');
		$note 				 = $this->input->post('note');
		$confirmed_by 		 = $this->input->post('confirmed_by');

		if (empty($noSPB) || empty($line_id)) {
			header('Content-Type: Application/json');
			$data = array(
				'ok' => false,
				'msg' => "parameter tidak boleh kosong",
				'data' => []
			);
			echo json_encode($data);die();
			}

		$this->M_api->finishConfirmTPBUpdate($noSPB,$line_id,$confirmation_status,$note,$confirmed_by);
		$result = $this->M_api->finishConfirmTPB($noSPB,$line_id);
		$data = array(
			'ok' => true,
			'msg' => "Berhasil",
			'data' => $result,
			);
		
		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($data));
	}


	public function getConfirmationTPB()
	{
		$this->checkSession();
		header("Access-Control-Allow-Origin: *");
	  
		$noSPB  = $this->input->post('no_spb');

		$result = $this->M_api->getConfirmationTPB($noSPB);
		$data = array(
			'ok' => true,
			'data' => $result,
			'msg' => "Berhasil",
			);
		
		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($data));
	}

	public function getInterorgTPB()
	{
		$this->checkSession();
		header("Access-Control-Allow-Origin: *");
	  
		$noSPB  = $this->input->post('no_spb');

		$result = $this->M_api->getInterorgTPB($noSPB);
		$data = array(
			'ok' => true,
			'data' => $result[0]['ATTRIBUTE3'],
			'msg' => "Berhasil",
			);
		
		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($data));
	}


	public function getKendaraan()
	{
		$this->checkSession();
		header("Access-Control-Allow-Origin: *");

		$result = $this->M_api->getKendaraan();
		$data = array(
			'ok' => true,
			'data' => $result,
			'msg' => "Berhasil",
			);
		
		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($data));
	}

	
	public function getListTPB()
	{
		$this->checkSession();
		header("Access-Control-Allow-Origin: *");
	  
		$nama_pekerja = $this->input->post('nama_pekerja');

		$result = $this->M_api->getListTPB($nama_pekerja);
		$data = array(
			'ok' => true,
			'msg' => "Berhasil",
			'data' => $result,
			);
		
		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($data));
	}

	public function getSPB()
	{
		$this->checkSession();
		header("Access-Control-Allow-Origin: *");
	  
		$noSPB  = $this->input->post('no_spb');

		$result = $this->M_api->getSPB($noSPB);
		$data = array(
			'ok' => true,
			'data' => $result[0]['REQUEST_NUMBER'],
			'msg' => "Berhasil",
			);
		
		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($data));
	}

	public function insertTPB()
	{
		$this->checkSession();
		header("Access-Control-Allow-Origin: *");
	  
		$noSPB 		  = $this->input->post('no_spb');
		$nama_pekerja = $this->input->post('nama_pekerja');
		$kendaraan 	  = $this->input->post('kendaraan');
		$status 	  = $this->input->post('status');

		if (empty($noSPB) || empty($nama_pekerja) || empty($status) || empty($kendaraan)) {
			header('Content-Type: Application/json');
			$data = array(
			  'ok' => false,
			  'data' => [],
			  'msg' => "Data yang dimasukan harus lengkap"
			);
			echo json_encode($data);
			die();
		  }

		$cekSPB = $this->M_api->insertTPBGet($noSPB);
		if ($cekSPB != null) {
			header('Content-Type: Application/json');
			$data = array(
			  'ok' => false,
			  'data' => $cekSPB,
			  'msg' => "no spb telah digunakan"
			);
			echo json_encode($data);
			die();
		  }


		$this->M_api->insertTPB($noSPB,$nama_pekerja,$kendaraan,$status);
		$result = $this->M_api->insertTPBGet($noSPB);
		$data = array(
			'ok' => true,
			'data' => $result,
			'msg' => "Berhasil",
			);
		
		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($data));
	}

	
	public function startTPB()
	{
		$this->checkSession();
		header("Access-Control-Allow-Origin: *");
	  
		$noSPB 		= $this->input->post('no_spb');
		$kendaraan  = $this->input->post('kendaraan');
		$status 	= $this->input->post('status');

		if (empty($noSPB) || empty($status) || empty($kendaraan)) {
			header('Content-Type: Application/json');
			$data = array(
				'ok' => false,
				'msg' => "Data tidak boleh kosong",
				'data' => []
			);
			echo json_encode($data);
			die();
		  }

		$this->M_api->startTPB($noSPB,$kendaraan,$status);

		$result = $this->M_api->startTPBGet($noSPB);
		$data = array(
			'ok' => true,
			'msg' => "Berhasil",
			'data' => $result,
			);
		
		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($data));
	}

	public function showPosition()
	{
		$this->checkSession();
		header("Access-Control-Allow-Origin: *");

		$id_login = $this->input->post('id_login');

		if (empty($id_login)) {
			header('Content-Type: Application/json');
			die();
		  }

		$result = $this->M_api->showPosition($id_login);
		
		if (count($result) != 0) {
			$data = array(
			   'ok' => true,
			   'data' => $result,
			   'msg' => "Berhasil",
				);
		  }else {
			$data = array(
			  'ok' => false,
			  'data' => [],
			  'msg' => 'Posisi tidak ditemukan'
			);
		  }
		
		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($data));
	}
	
	public function setPosition()
	{
		$this->checkSession();
		header("Access-Control-Allow-Origin: *");
		
		$id_login = $this->input->post('id_login');
		$lat 	  = $this->input->post('lat');
		$long 	  = $this->input->post('long');
	  
		if (empty($id_login) || empty($lat) || empty($long)) {
		  header('Content-Type: Application/json');
		  die();
		}

		$resultSelect = $this->M_api->setPositionGet($id_login);
		
		if ($resultSelect[0]['jumlah'] == 0) {
			try {
				$this->M_api->setPositionInsert($id_login,$lat,$long);
				$data = array(
				  'ok' => true,
				  'data' => [],
				  'msg' => 'Berhasil Update'
				);
			} catch (Exception $e) {
				$data = array(
					'ok' => false,
					'data' => [],
					'msg' => $e
				);
			}
		  } else {
			try {
				$this->M_api->setPositionUpdate($id_login,$lat,$long);
				$data = array(
				  'ok' => true,
				  'data' => [],
				  'msg' => 'Berhasil Update'
				);
			} catch (Exception $e) {
				$data = array(
					'ok' => false,
					'data' => [],
					'msg' => $e
				);
			}
		  }
		
		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($data));
	}

}
?>
