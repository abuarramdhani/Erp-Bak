<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Slide extends CI_Controller
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
        $this->load->model('UpdateCov/M_update');
    }


    public function index()
    {
    }

    public function Name($a)
    {
        $f =  $this->M_update->dataSlideShow($a);
        $data['f'] = $f;
        $this->load->view('UpdateCov/V_Head', $data);
        $this->load->view('UpdateCov/V_Slide', $data);
        $this->load->view('UpdateCov/V_Foot', $data);
    }
}
