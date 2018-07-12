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
}