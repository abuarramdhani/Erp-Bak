<?php defined('BASEPATH') OR exit('No direct script access allowed');


class C_Login extends CI_Controller
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
        $this->load->model('InsertTagihanSubkont/M_insert');
        $this->load->model('SystemAdministration/MainMenu/M_user');
    }
   
	public function loginTagihanSubkon()
	{
		$username = $this->input->post('username');
		$login = $this->M_insert->loginTagihanSubkon($username);

		if($login){
			$session = array(
				'error' 			=> false,
			);
		}else{
			$session = array(
				'error' 			=> true,
				);
		}

		echo json_encode($session);
		}

		public function loginAndroidSubkon()
		{
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$password_md5 = md5($password);
			$log = $this->M_insert->loginSubkon($username,$password_md5);
	
			if($log){
				$user = $this->M_insert->getDetailSubkon($username);

				foreach($user as $user_item){
					$iduser 			= $user_item->user_id;
					$username 		= $user_item->username;
					$password			= $user_item->password;
					$vendor_name 		= $user_item->vendor_name;
				}
				$ses = array(
								'error' 			=> false,
								'userid' 			=> $iduser,
								'user' 				=> strtoupper($username),
								'password'  		=> $password,
								'vendor_name' 			=> $vendor_name,
							);
			}else{
				$ses = array(
					'error' 			=> true,
					'userid' 			=> null,
					'user' 				=> null,
					'employee'  		=> null,
					'kodesie' 			=> null,
					'kode_lokasi_kerja'	=> null,
					);
			}
	
			echo json_encode($ses);
		}

}
