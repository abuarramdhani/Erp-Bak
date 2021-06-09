<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Jadwal extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('parser');
        $this->load->model('PendampinganSPT/M_daftar');
        $this->load->model('PendampinganSPT/M_jadwal');
    }

    public function updateSchedule()
    {
        echo '<pre>';

        $this->M_jadwal->updateTableColumn();
        $this->M_jadwal->createSeq2021RegisterNumber();

        $registered_number_2020 = $this->M_jadwal->selectRegisteredNumber(2020);
        $new_registered_number_2020 = array_map(function ($v) {
            $register_number = explode('-', $v->nomor_pendaftaran);
            $location = $register_number[0];
            $id = sprintf('%03d', $v->id);

            $v->nomor_pendaftaran = "$location-20-$id";

            return $v;
        }, $registered_number_2020);

        print_r($new_registered_number_2020);

        $this->M_jadwal->update_batch($new_registered_number_2020);

        $registered_number_2021 = $this->M_jadwal->selectRegisteredNumber(2021);
        $new_registered_number_2021 = array_map(function ($v) {
            $register_number = explode('-', $v->nomor_pendaftaran);
            $location = $register_number[0];
            $id = sprintf('%03d', $this->M_daftar->selectNextRegisterNumberSeq());

            $v->nomor_pendaftaran = "$location-21-$id";

            return $v;
        }, $registered_number_2021);

        print_r($new_registered_number_2021);

        $this->M_jadwal->update_batch($new_registered_number_2021);
    }

    public function index()
    {
        $content['BaseUrl']         = base_url();
        $content['ScheduleSPTList'] = $this->M_jadwal->selectAllUserSchedule(date("y"));

        $data['BaseUrl']   = base_url();
        $data['Header']    = 'Jadwal';
        $data['Title']     = 'Jadwal Pendampingan SPT';
        $data['Link']      = 'PendampinganSPT/Jadwal';
        $data['Content']   = $this->parser->parse('PendampinganSPT/MainMenu/V_ContentJadwal', $content, TRUE);
        $data['Copyright'] = '<strong>Copyright &copy; Quick 2015-' . date('Y') . '.</strong> All rights reserved.';

        $this->parser->parse('PendampinganSPT/MainMenu/V_Template', $data);
    }
}
