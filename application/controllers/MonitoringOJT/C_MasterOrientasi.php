<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_MasterOrientasi extends CI_Controller 
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
		$this->load->library('upload');
		$this->load->library('General');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		
		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();
	}

	public function checkSession()
	{
		if(!($this->session->is_logged))
		{
			redirect('');
		}
	}

	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Header']			=	'Monitoring OJT - Quick ERP';
		$data['Title']			=	'Master Orientasi';
		$data['Menu'] 			= 	'Master Orientasi';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringOJT/V_MasterOrientasi_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	//	Pembuatan Orientasi Baru
	//	{
			public function OrientasiBaru_Save()
			{
				$this->checkSession();
				$user_id 	=	$this->session->userid;
				$user 		=	$this->session->user;


			}
	//	}

}
