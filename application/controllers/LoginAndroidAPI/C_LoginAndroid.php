<?php defined('BASEPATH') OR exit('No direct script access allowed');


class C_LoginAndroid extends CI_Controller
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
        $this->load->model('M_Index');
        $this->load->model('SystemAdministration/MainMenu/M_user');

    }

    public function loginAndroid()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$password_md5 = md5($password);
		$log = $this->M_Index->login($username,$password_md5);

		if($log){
			$user = $this->M_Index->getDetail($username);

			foreach($user as $user_item){
				$iduser 			= $user_item->user_id;
				$password_default 	= $user_item->password_default;
				$kodesie			= $user_item->section_code;
				$employee_name 		= $user_item->employee_name;
				$kode_lokasi_kerja 	= $user_item->location_code;
			}
			$ses = array(
							'error' 			=> false,
							'userid' 			=> $iduser,
							'user' 				=> strtoupper($username),
							'employee'  		=> $employee_name,
							'kodesie' 			=> $kodesie,
							'kode_lokasi_kerja'	=> $kode_lokasi_kerja,
						);
			// $this->session->set_userdata($ses);

			// redirect($this->session->userdata('last_page'));


			//redirect('index');
		}else{
			$ses = array(
				'error' 			=> true,
				'userid' 			=> null,
				'user' 				=> null,
				'employee'  		=> null,
				'kodesie' 			=> null,
				'kode_lokasi_kerja'	=> null,
				);
			// $this->session->set_userdata($ses);
		}

		echo json_encode($ses);
	}
}
