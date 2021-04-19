<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class C_Insert extends CI_Controller
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
        $this->load->model('InsertTagihanSubkont/M_insert');
    }
    public function index()
    {
        $this->M_insert->delettagihan();
        $tagihan = $this->M_insert->getdatatagihan();
        for ($i = 0; $i < sizeof($tagihan); $i++) {
            $this->M_insert->InsertTagihan($tagihan[$i]);
        }
    }
}
