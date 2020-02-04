<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Index extends CI_Controller {


	public function __construct()
    {
        parent::__construct();

        $this->load->library('General');
        $this->load->library('encrypt');
        $this->load->library('Log_Activity');
        $this->load->model('M_Index');
        $this->load->library('session');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPresensi/SetupReffJamLembur/M_reffjamlembur');


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

    	$data['Title']	= 'Setup Reff Jam Lembur ';
    	$data['Menu'] = 'Setup  ';
    	$data['SubMenuOne'] = 'Reff Jam Lembur';
    	$data['SubMenuTwo'] = '';

    	$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    	$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
    	$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    	$data['data'] = $this->M_reffjamlembur->lihat();

    	$this->load->view('V_Header',$data);
    	$this->load->view('V_Sidemenu',$data);
    	$this->load->view('MasterPresensi/SetupReffJamLembur/V_Index',$data);
    	$this->load->view('V_Footer',$data);



    }


        public function create()
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        $user = $this->session->user;

        $data['Title']   = 'Input Reff Jam Lembur ';
        $data['Menu'] = 'Setup  ';
        $data['SubMenuOne'] = 'Reff Jam Lembur';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);


       $this->form_validation->set_rules('required');

        if ($this->form_validation->run() === FALSE) {
           $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('MasterPresensi/SetupReffJamLembur/V_Create',$data);
            $this->load->view('V_Footer',$data);
        }else{

        $keterangan                        =   $this->input->post('txtketerangan');
        $jenis_hari                        =   $this->input->post('txtjenishari');
        $hari                              =   $this->input->post('txthari');
        $urutan                            =   $this->input->post('txturutan');
        $jml_jam                           =   $this->input->post('txtjumlahjam');
        $pengali                           =   $this->input->post('txtpengali');




        $input          =   array
                                        (
                                            'keterangan'             =>    $keterangan,
                                            'jenis_hari'             =>    $jenis_hari,
                                            'hari'             =>    $hari,
                                            'urutan'             =>    $urutan,
                                            'jml_jam'             =>    $jml_jam,
                                            'pengali'             =>    $pengali



                                        );

                                        //echo "<pre>";print_r($input);exit();

            $this->M_reffjamlembur->input($input);
            //insert to t_log
            $aksi = 'MASTER PRESENSI';
            $detail = "Create reff jam lembur keterangan= $keterangan, jenis hari = $jenis_hari, hari = $hari";
            $this->log_activity->activity_log($aksi, $detail);
            //
        redirect('MasterPresensi/SetupReffJamLembur');
        }


     	}

        public function read($id)
    {

        $this->checkSession();
        $user_id = $this->session->userid;
        $user = $this->session->user;

        $data['Title']   = 'Lihat Data Reff Jam Lembur ';
        $data['Menu'] = 'Setup  ';
        $data['SubMenuOne'] = 'Reff Jam Lembur';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $id =   str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
        $id =   $this->encrypt->decode($id);
        $data['data'] = $this->M_reffjamlembur->GetReffJamLembur($id);
     //echo "<pre>";print_r($data['data']);exit();

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('MasterPresensi/SetupReffJamLembur/V_Read',$data);
        $this->load->view('V_Footer',$data);
    }

    public function delete($id)
        {
            $id =   str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
            $id =   $this->encrypt->decode($id);

            $this->checkSession();
        $user_id = $this->session->userid;
        $user = $this->session->user;
            $this->M_reffjamlembur->delete($id);
            //insert to t_log
            $aksi = 'MASTER PRESENSI';
            $detail = "Delete reff jam lembur ID = $id";
            $this->log_activity->activity_log($aksi, $detail);
            //

            redirect('MasterPresensi/SetupReffJamLembur');

        }

    public function update($encrypt_id)

    {

        $id =   str_replace(array('-', '_', '~'), array('+', '/', '='), $encrypt_id);
            $id =   $this->encrypt->decode($id);


        $this->checkSession();
        $user_id = $this->session->userid;
        $user = $this->session->user;


        $data['Title']   = 'Edit Reff Jam Lembur ';
        $data['Menu'] = 'Setup  ';
        $data['SubMenuOne'] = 'Reff Jam Lembur';
        $data['SubMenuTwo'] = '';
        $data['id']         =$encrypt_id;

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['edit'] = $this->M_reffjamlembur->GetReffJamLembur($id);





        $this->form_validation->set_rules('required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('MasterPresensi/SetupReffJamLembur/V_Update.php',$data);
            $this->load->view('V_Footer',$data);
        }else{



         $keterangan                        =   $this->input->post('txtketerangan');

        $jenis_hari                        =   $this->input->post('txtjenishari');
        $hari                              =   $this->input->post('txthari');
        $urutan                            =   $this->input->post('txturutan');
        $jml_jam                           =   $this->input->post('txtjumlahjam');
        $pengali                           =   $this->input->post('txtpengali');



        $data           =   array
                                        (
                                           'keterangan'             =>    $keterangan,
                                            'jenis_hari'             =>    $jenis_hari,
                                            'hari'             =>    $hari,
                                            'urutan'             =>    $urutan,
                                            'jml_jam'             =>    $jml_jam,
                                            'pengali'             =>    $pengali



                                        );

                                        //echo "<pre>";print_r($data);exit();


            $this->M_reffjamlembur->update($id,$data);
            //insert to t_log
            $aksi = 'MASTER PRESENSI';
            $detail = "Update reff jam lembur ID = $id";
            $this->log_activity->activity_log($aksi, $detail);
            //




        redirect('MasterPresensi/SetupReffJamLembur');
        }

    }



}
