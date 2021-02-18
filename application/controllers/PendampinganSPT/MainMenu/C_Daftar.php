<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Daftar extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('parser');
        $this->load->model('PendampinganSPT/M_daftar');
    }

    public function index()
    {
        $content['BaseUrl'] = base_url();

        $data['BaseUrl']   = base_url();
        $data['Header']    = 'Daftar';
        $data['Title']     = 'Daftar Pendampingan SPT';
        $data['Link']      = 'PendampinganSPT/Daftar';
        $data['Content']   = $this->parser->parse('PendampinganSPT/MainMenu/V_ContentDaftar', $content, TRUE);
        $data['Copyright'] = '<strong>Copyright &copy; Quick 2015-' . date('Y') . '.</strong> All rights reserved.';
        $data['JSVersion'] = filemtime('assets/js/customPSPT.js');

        $this->parser->parse('PendampinganSPT/MainMenu/V_Template', $data);
    }

    public function getUserInformation()
    {
        if (!$this->input->is_ajax_request())
            redirect('PendampinganSPT/Daftar');

        $user_id = $this->input->post('userId');
        $result  = $this->M_daftar->selectUserInformation($user_id);

        echo json_encode($result);
    }

    public function addRegisteredUser()
    {
        if (!$this->input->is_ajax_request())
            redirect('PendampinganSPT/Daftar');

        $user_data = $this->input->post();
        $data = $this->M_daftar->selectRegisteredUser($user_data['nomor_induk']);

        if ($data) {
            header('HTTP/1.1 428');
            die(json_encode([
                'status' => 'already available',
                'registered_number' => $data[0]['nomor_pendaftaran']
            ]));
        } else {
            echo json_encode($this->M_daftar->insertRegisteredUser($user_data));
        }
    }
}
