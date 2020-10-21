<?php defined('BASEPATH') or exit('No direct script access allowed');


class C_Insert extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('html');
        $this->load->library('form_validation');
        $this->load->model('TrackingActivity/M_insert');
    }

    public function print_json($value)
    {
        header('HTTP/1.1 200 OK');
        header('Content-Type: application/json');
        echo json_encode($value);
    }

    public function In()
    {
        $this->print_json($this->M_insert->insertData(array(
            'id' => $this->input->post('id'),
            'long' => $this->input->post('long'),
            'lat' => $this->input->post('lat')
        )));
    }
}
