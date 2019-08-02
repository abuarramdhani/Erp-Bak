<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_List extends CI_Controller {

	public function __construct()
    {
    	parent::__construct();

    	$this->load->helper('url');
    	$this->load->helper('html');
    	$this->load->library('session');

    	$this->load->model('M_Index');
    	$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('SystemAdministration/MainMenu/M_module');
    	$this->load->model('SystemAdministration/MainMenu/Android/M_list');
    }
	
	public function index()
	{
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		$data['Title']		= 'Mobile Approval';
		
		$data['UserMenu']		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['android'] = $this->M_list->getDataAndroid();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SystemAdministration/MainMenu/Android/List/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function delete($id)
	{
		$data['id'] = $id;
		$this->M_list->delete($id);
		redirect('SystemAdministration/Android/List');
	}

	public function edit($id)
	{
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		$data['Title']		= 'Mobile Approval';
		
		$data['UserMenu']		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['android'] = $this->M_list->getDataAndroidById($id);

			


		$noind = RTRIM($data['android'][0]['info_2']);
		// $this->akhirKontrak($data['android'][0]['info_1']);
		// $nama1 = 'NUGROHO';
		// print_r($data['android'][0]['info_2']);exit();
		// echo($nama.'<br>'.$nama1);exit;
		// $id = 'B0720';
		$data['akhirKontrak'] =  $this->M_list->getAkhirKontrak($noind);
		// print_r($data['akhirKontrak']); exit;
		$data['id'] = $id;
		// $data['nama'] =  $this->M_list->getAkhirKontrak($nama);
		// $data['akhir_kontrak'] = $this->M_list->getAkhirKontrak($id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SystemAdministration/MainMenu/Android/List/V_Edit',$data);
		$this->load->view('V_Footer',$data);
		
	}

	public function listPekerja(){
		$id = $this->input->post('andro_employee');
		$keyword 			=	strtoupper($this->input->get('term'));
		$list = $this->M_list->listPekerja($id, $keyword);
		echo json_encode($list);
	}

	public function back(){
		redirect('SystemAdministration/Android/List');
	}

	public function updateData($id){
		// $data = ['info_1' => $this->input->post('andro-employee')];
		$data = ['info_1' => $this->input->post('andro-employee'),
				 'validation' => $this->input->post('andro-status'),
				 'valid_until' => $this->input->post('valid-until')	
				 ];
		// print_r($data);exit();

		$this->M_list->updateData($id,$data);
		redirect('SystemAdministration/Android/List');
	}

	public function akhirKontrak($noind){
		
	// $data['noind'] =  $this->M_list->getAkhirKontrak($noind);
	// echo "<pre>";  print_r($data);exit(); echo "</pre>";
	// redirect('SystemAdministration/Android/List');
	}

	public function login(){
		
		$this->load->model('M_index');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$password_md5 = md5($password);
		$log = $this->M_Index->login($username,$password_md5);

		if($log){
			$detail = $this->M_list->getDetail($username);
			echo $detail[0]['employee_name'];
		}else{
			echo "0";
			
		}
	}

	public function loginAndroid(){
		
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
			$this->session->set_userdata($ses);
			
			echo $employee_name;
			
		}else{
			echo "0";
		}
	}

	
}