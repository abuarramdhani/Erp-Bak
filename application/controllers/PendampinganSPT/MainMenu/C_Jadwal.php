<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Jadwal extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('parser');
        $this->load->model('PendampinganSPT/M_jadwal');
    }

    public function index()
    {
        $content['BaseUrl']         = base_url();
        $content['ScheduleSPTList'] = $this->M_jadwal->selectAllUserSchedule();

        $data['BaseUrl']   = base_url();
        $data['Header']    = 'Jadwal';
        $data['Title']     = 'Jadwal Pendampingan SPT';
        $data['Link']      = 'PendampinganSPT/Jadwal';
        $data['Content']   = $this->parser->parse('PendampinganSPT/MainMenu/V_ContentJadwal', $content, TRUE);
        $data['Copyright'] = '<strong>Copyright &copy; Quick 2015-'.date('Y').'.</strong> All rights reserved.';

        $this->parser->parse('PendampinganSPT/MainMenu/V_Template', $data);
    }

}