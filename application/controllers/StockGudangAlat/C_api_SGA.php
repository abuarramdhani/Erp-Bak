<?php defined('BASEPATH') OR exit('No direct script access allowed');


class C_api_SGA extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('html');
        $this->load->library('form_validation');
        $this->load->model('StockGudangAlat/M_stockgudangalat');
    }

    // private function checkSession()
    // {
    //     $this->M_Users->checkSession(strtoupper(trim($this->security->xss_clean($this->input->post('noind')))), 'out');
    // }

    public function print_json($value)
    {
        header('HTTP/1.1 200 OK');
        header('Content-Type: application/json');
        echo json_encode($value);
    }

    public function checkNumericId($id)
    {
        if(!is_numeric($id)) {
            header('HTTP/1.1 200 OK');
            header('Content-Type: application/json');
            echo json_encode(array(
                'success' => false,
                'message' => "the id must be integer only (your current request id is '$id')."
            ));
            die;
        }
    }

    public function getAll()
    {
        $this->print_json($this->M_stockgudangalat->getAll());
    }

    public function get($id)
    {
        $this->checkNumericId($id);
        $this->print_json($this->M_stockgudangalat->get($id));
    }

    public function edit()
    {
        // $this->checkNumericId($id);
        $this->print_json($this->M_stockgudangalat->edit(array(
          'tag' => $this->input->post('tag'),
          'jenis' => $this->input->post('jenis'),
          'no_bon' => $this->input->post('no_bon'),
          'subinv' => $this->input->post('subinv'),
          'spesifikasi_barang' => $this->input->post('spesifikasi_barang'),
          'qty' => $this->input->post('qty')
        )));
    }

    public function remove()
    {
        // $this->checkNumericId($id);
        $this->print_json($this->M_stockgudangalat->Remove([
          'SPESIFIKASI' => $this->input->post('SPESIFIKASI'),
          'JENIS' => $this->input->post('JENIS'),
          'SUB_INV' => $this->input->post('SUB_INV'),
          'TAG' => $this->input->post('TAG'),
          'QTY' => $this->input->post('QTY')
        ]));
    }
}
