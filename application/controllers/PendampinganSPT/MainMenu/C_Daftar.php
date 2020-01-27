<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Daftar extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PendampinganSPT/M_daftar');
    }

	public function index()
	{
        $user_id = $this->session->userid;
        $resp_id = $this->session->responsibility_id;
        
        $this->load->view('PendampinganSPT/MainMenu/V_Daftar');
    }

    public function getUserInformation()
    {
        $user_id = $this->input->post('userId');
        $result  = $this->M_daftar->selectUserInformation($user_id);
        echo json_encode($result);
    }

    public function addRegisteredUser()
    {
        $user_data = $this->input->post();
        $data = $this->M_daftar->selectRegisteredUser($user_data['nomor_induk']);
        $data ?
            $result = ['status' => 'Already Available', 'registered_number' => $data[0]['nomor_pendaftaran'] ] :
            $result = $this->M_daftar->insertRegisteredUser($user_data);
        
        echo json_encode($result);
    }

}
