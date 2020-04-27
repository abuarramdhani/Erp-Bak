<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_UpdateJamIstirahat extends CI_Controller {


	public function __construct()
    {
        parent::__construct();

        $this->load->library('General');
        $this->load->library('encrypt');
        $this->load->library('Log_Activity');
        $this->load->model('M_Index');
        $this->load->library('session');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPresensi/ShiftPekerja/M_UpdateJamIstirahat');


		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->load->helper('terbilang_helper');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		date_default_timezone_set('Asia/Jakarta');
		$this->checkSession();
    }
	public function checkSession()
	{
		if($this->session->is_logged){

		}else{
			redirect('');
		}
	}
    public function index()
    {
    	$this->checkSession();
    	$user_id = $this->session->userid;

    	$data['Title']	= 'Update Jam Istirahat';
    	$data['Menu'] = 'Shift Pekerja';
    	$data['SubMenuOne'] = 'Update Jam Istirahat';
    	$data['SubMenuTwo'] = '';

    	$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    	$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
    	$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);


        
    	$data['shift'] = $this->M_UpdateJamIstirahat->shift();

     //    $tanggal = $this->input->post('txtTanggalShift');
     //    $shiftpekerja = $this->input->post('txtShift');
    
     //    $data['data'] = $this->M_UpdateJamIstirahat->tampil($tanggal,$shiftpekerja);

    	$this->load->view('V_Header',$data);
    	$this->load->view('V_Sidemenu',$data);
    	$this->load->view('MasterPresensi/ShiftPekerja/V_Index',$data);
    	$this->load->view('V_Footer',$data);



    }

     public function tampil()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Title']  = 'Update Jam Istirahat';
        $data['Menu'] = 'Shift Pekerja';
        $data['SubMenuOne'] = 'Update Jam Istirahat';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['tanggal'] = $this->input->post('txtTanggalShift');
        $data['shiftpekerja'] = $this->input->post('txtShift');
        $data['shift'] = $this->M_UpdateJamIstirahat->shift();

        $data['data'] = $this->M_UpdateJamIstirahat->tampil($data['tanggal'],$data['shiftpekerja']);
        // echo "<pre>";
        // print_r($data['data']);
        // die;

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('MasterPresensi/ShiftPekerja/V_tampil',$data);
        $this->load->view('V_Footer',$data);
    }

     public function Update()
    {
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Title']  = 'Update Jam Istirahat';
        $data['Menu'] = 'Shift Pekerja';
        $data['SubMenuOne'] = 'Update Jam Istirahat';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

 
        $tanggal = $this->input->post('tanggalTampil');
        $tanggal_format = date('Y-m-d', strtotime($tanggal));
        $shift = $this->input->post('shiftTampil');
        $cari_shift = $this->M_UpdateJamIstirahat->CariKdShift($shift);
        $ist_mulai = date('H:i:s', strtotime($this->input->post('txtIstirahatMulai')));
        $ist_selesai = date('H:i:s', strtotime($this->input->post('txtIstirahatSelesai')));
        $data['update'] = $this->M_UpdateJamIstirahat->update($tanggal_format,$cari_shift,$ist_mulai,$ist_selesai);
        $data['data'] = $this->M_UpdateJamIstirahat->tampil($tanggal_format,$shift);
        $data['tanggal'] = $tanggal;
        $data['shiftpekerja'] = $shift;
        $data['shift'] = $this->M_UpdateJamIstirahat->shift();
 
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('MasterPresensi/ShiftPekerja/V_tampil',$data);
        $this->load->view('V_Footer',$data);




    }






}
?>