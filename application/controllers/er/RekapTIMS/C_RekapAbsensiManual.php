<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class C_RekapAbsensiManual extends CI_Controller 
	{
		public function __construct()
	    {
	        parent::__construct();
			  
	        $this->load->helper('form');
	        $this->load->helper('url');
	        $this->load->helper('html');
	        $this->load->library('form_validation');
			$this->load->library('session');
			$this->load->library('General');
			$this->load->model('M_Index');
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('er/RekapTIMS/M_rekapabsensimanual');
			  
			if($this->session->userdata('logged_in')!=TRUE) 
			{
				$this->load->helper('url');
				$this->session->set_userdata('last_page', current_url());
				// $this->session->set_userdata('Responsibility', 'some_value');
			}
	    }
		
		public function checkSession()
		{
			if($this->session->is_logged)
			{
			}
			else
			{
				redirect();
			}
		}

		public function index()
		{
			$this->checkSession();
			$user_id = $this->session->userid;
			
			$data 	=	$this->general->loadHeaderandSidemenu('Rekap Absensi Manual - Quick ERP', 'Rekap Absensi Manual');

			$this->form_validation->set_rules('txtTanggalRekap', 'Tanggal Rekap', 'required');

			if($this->form_validation->run() === FALSE)
			{
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('er/RekapTIMS/RekapAbsensiManual/V_index',$data);
				$this->load->view('V_Footer',$data);
			}
			else
			{
				$tanggalRekap 	=	$this->input->post('txtTanggalRekap');

				$tanggalRekap 	=	explode(' - ', $tanggalRekap);

				$tanggalAwalRekap 	=	$tanggalRekap[0];
				$tanggalAkhirRekap 	=	$tanggalRekap[1];
				
				$data['rekapAbsensiManual'] 	=	$this->M_rekapabsensimanual->rekapAbsensiManual($tanggalAwalRekap, $tanggalAkhirRekap);

				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('er/RekapTIMS/RekapAbsensiManual/V_index',$data);
				$this->load->view('V_Footer',$data);
			}
			
		}
	}
