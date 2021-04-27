<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class C_Data extends CI_Controller
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
    public function getData()
    {
        $param = $this->input->post('vendor');
        $this->print_json($this->M_insert->getData($param));
    }
    public function print_json($value)
    {
        header('HTTP/1.1 200 OK');
        header('Content-Type: application/json');
        echo json_encode($value);
    }
    public function cetakanTagihan($no_tg)
    {
        $no_tgh = str_replace("__", "/", $no_tg);
        $no_tgh = str_replace("%20", " ", $no_tgh);

        $list_tagihan = $this->M_insert->ListTagihanbyNom($no_tgh);
        $alamat_vendor = $this->M_insert->getVendorName($list_tagihan[0]['vendor_name']);
        // echo $no_tgh;

        // echo "<pre>";
        // print_r($list_tagihan);
        // exit();

        ob_start();

        $data['list_tagihan'] = $list_tagihan;
        $data['alamat_vendor'] = $alamat_vendor;

        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf = new mPDF('utf-8', array(210, 148), 0, '', 3, 3, 40, 3, 3, 3); //----- A5-L
        $filename = 'SuratTagihan' . $no_tgh . '.pdf';
        $html = $this->load->view('InsertTagihanSubkont/V_PdfContent', $data, true);
        $foot = $this->load->view('InsertTagihanSubkont/V_PdfFooter', $data, true);
        $head = $this->load->view('InsertTagihanSubkont/V_PdfHeader', $data, true);

        ob_end_clean();

        $pdf->SetHTMLHeader($head);
        $pdf->SetHTMLFooter($foot);
        $pdf->WriteHTML($html);
        $pdf->Output($filename, 'I');
    }
    public function ListData()
    {
        $param = $this->input->post('vendor');
        $this->print_json($this->M_insert->getNomorTagihan($param));
    }
}
