<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Index extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
  {
      parent::__construct();

      $this->load->helper('form');
      $this->load->helper('url');
      $this->load->helper('html');
			$this->load->library('Log_Activity');
      $this->load->library('form_validation');
          //load the login model
		  $this->load->library('session');
		  //$this->load->library('Database');
		  $this->load->model('M_Index');
		  $this->load->model('SystemAdministration/MainMenu/M_user');

		  if($this->session->userdata('logged_in')!=TRUE) {
		  $this->load->helper('url');
		  $this->session->set_userdata('last_page', current_url());
		  //redirect('index');
    }
		  //$this->load->model('CustomerRelationship/M_Index');
  }

	public function index()
	{
		if($this->session->is_logged){
			$this->session->set_userdata('responsbility', 'Dashboard');

			//$usr = "D1178";
			$user_id = $this->session->userid;
			//$data['user'] = $usr;
			$data['Menu'] = 'dashboard';

			if(base_url('')=='http://182.23.18.195/'){
				$data['UserResponsibility'] = $this->M_user->getUserResponsibilityInternet($user_id);
			}else{
				$data['UserResponsibility'] = $this->M_user->getUserResponsibility($user_id);
			}

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('V_Index',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$this->session->set_userdata('responsbility', 'Login');
			if($this->session->gagal){
				$data['error'] = "Login error, please enter correct username and password";
				$aksi = 'Login';
				$detail = 'Gagal Login';
				$this->log_activity->activity_log($aksi, $detail);

			}else{
				$data['error'] = "";
			}
			$this->load->view('V_Login',$data);
			$this->session->unset_userdata('gagal');
		}
	}

	public function Responsibility($responsibility_id)
	{
		if($this->session->is_logged){
			//$usr = "D1178";
			$user_id = $this->session->userid;
			//$data['user'] = $usr;
			//$data['Menu'] = 'dashboard';

			$UserResponsibility = $this->M_user->getUserResponsibility($user_id,$responsibility_id);
			foreach($UserResponsibility as $UserResponsibility_item){
				$aksi = 'Akses Responsibility';
				$detail = $UserResponsibility_item['user_group_menu_name'];

				$this->log_activity->activity_log($aksi, $detail);

				$this->session->set_userdata('responsibility', $UserResponsibility_item['user_group_menu_name']);
				// if(empty($UserResponsibility_item['user_group_menu_id'])){
					// $UserResponsibility_item['user_group_menu_id'] = 0;
				// }
				$this->session->set_userdata('responsibility_id', $UserResponsibility_item['user_group_menu_id']);
				$this->session->set_userdata('module_link', $UserResponsibility_item['module_link']);
				$this->session->set_userdata('org_id', $UserResponsibility_item['org_id']);
			}
			//$this->session->set_userdata('responsbility', 'a');
			//print_r($UserResponsibility);
			redirect($this->session->module_link);
			// $this->load->view('V_Header',$data);
			// $this->load->view('V_Sidemenu',$data);
			// $this->load->view('V_Index',$data);
			// $this->load->view('V_Footer',$data);
		}else{
			if($this->session->gagal){
				$data['error'] = "Login error, please enter correct username and password";
			}else{
				$data['error'] = "";
			}

			$this->session->set_userdata('responsbility', 'Login');
			$this->load->view('V_Login',$data);
			$this->session->unset_userdata('gagal');
		}
	}

	public function BackToLogin()
	{
		$this->load->view('V_Login');
	}

	public function home()
	{
		$this->checkSession();
		//$usr = "D1178";
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'dashboard';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CustomerRelationship/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function checkSession(){
		if($this->session->is_logged){

		}else{
			redirect('');
		}
	}

	public function login(){

		//$this->load->model('M_index');
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
							'is_logged' 		=> 1,
							'userid' 			=> $iduser,
							'user' 				=> strtoupper($username),
							'employee'  		=> $employee_name,
							'kodesie' 			=> $kodesie,
							'kode_lokasi_kerja'	=> $kode_lokasi_kerja,
						);

			$isDefaultPass = $this->M_Index->getPassword($username);
			$ses['pass_is_default'] = $isDefaultPass;

			$this->session->set_userdata($ses);

			$aksi = 'Login';
			$detail = 'Login';
			$this->log_activity->activity_log($aksi, $detail);

			redirect($this->session->userdata('last_page'));
		}else{
			$ses = array(
							'gagal' => 1,
						);
			$this->session->set_userdata($ses);
			if(isset($this->session->last_page)){
				redirect($this->session->last_page);
			}else{
				redirect('');
			}

		}

	}

	public function ChangePassword()
	{	$this->checkSession();
		//$usr = "D1178";
		$user_id = $this->session->userid;

		$data['UserData'] = $this->M_user->getUser($user_id);
		$data['id'] = $user_id;

		foreach($data['UserData'] as $user){
			$password = $user['user_password'];
		}

		$this->form_validation->set_rules('txtPasswordNow', 'username', 'required');
		// $this->form_validation->set_rules('txtPassword', 'username', 'required');

		if ($this->form_validation->run() === FALSE)
		{
				$data['error'] = '';
				$this->load->view('V_ChangePassword',$data);

		}
		else
		{
			if($password == md5($this->input->post('txtPasswordNow'))){
				if($this->input->post('txtPassword')!='' and $this->input->post('txtPasswordCheck')!=''){
					$aksi = 'Change Password';
					$detail = 'Change Password';
					$this->log_activity->activity_log($aksi, $detail);

					$data = array(
						'user_password'	=> md5($this->input->post('txtPassword')),
						'creation_date'=>  $this->input->post('hdnDate'),
						'created_by'=>  $this->input->post('hdnUser')
						);
				}
				else{
					$data['error'] = 'New Password Empty';
					$this->load->view('V_ChangePassword',$data);
				}
				$this->M_user->updateUser($data,$user_id);
				//print_r($data);
				redirect(base_url('logout'));
			}else{
				$aksi = 'Error Change Password';
				$detail = 'Error Change Password';
				$this->log_activity->activity_log($aksi, $detail);

				$data['error'] = 'Password Wrong';
				$this->load->view('V_ChangePassword',$data);
			}

		}

	}

	public function logout(){
		$aksi = 'Log Out';
		$detail = 'Log Out ERP';

		$this->log_activity->activity_log($aksi, $detail);


		$this->session->unset_userdata('is_logged');
		if($this->session->gagal){
			$this->session->unset_userdata('gagal');
		}

		//variabel session spl (surat perintah lembur) HR awal
		if ($this->session->spl_validasi_asska) {
			$this->session->unset_userdata('spl_validasi_asska');
		}
		if ($this->session->spl_validasi_kasie) {
			$this->session->unset_userdata('spl_validasi_kasie');
		}
		//variabel session spl (surat perintah lembur) HR akhir

		redirect('index');
	}

	public function getLog()
	{
		$menu = $_POST['menu1'];

		$aksi = 'Akses Menu';
		$detail = 'Mengakses Menu '.$menu;

		$this->log_activity->activity_log($aksi, $detail);

	}

}
