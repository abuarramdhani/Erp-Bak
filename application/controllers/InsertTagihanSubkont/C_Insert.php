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
    public function InsertReadyTagihan()
    {
        // echo "hallo world";
        $id = $_POST['id'];
        $no_tagihan = $_POST['no_tagihan'];
        $username = $_POST['created_by'];


        $tagihan = $this->M_insert->getDatabyId($id);

        // echo "<pre>";
        // print_r($tagihan);
        // exit();

        for ($t = 0; $t < sizeof($tagihan); $t++) {
            $list_tagihan = $this->M_insert->ListTagihanbyTID($tagihan[$t]['transaction_id']);
            if ($list_tagihan != null) {
                $response['success'] = false;
                $response['message'] = 'Sudah Di Insert';
                $this->print_json($response);
            } else {
                $data = array(
                    'nomor_tagihan' => $no_tagihan,
                    'quantity_bersih' => $tagihan[$t]['quantity_bersih'],
                    'uom_code' => $tagihan[$t]['uom_code'],
                    'item_description_po' => $tagihan[$t]['item_description_po'],
                    'item_description_job' => $tagihan[$t]['item_description_job'],
                    'receipt_num' => $tagihan[$t]['receipt_num'],
                    'po_unit_price' => $tagihan[$t]['po_unit_price'],
                    'total_price' => $tagihan[$t]['total_price'],
                    'vendor_name' => $tagihan[$t]['vendor_name'],
                    'transaction_id' => $tagihan[$t]['transaction_id'],
                    'po_num' => $tagihan[$t]['po_num'],
                    'creation_by' => $username,
                    'last_update_by' => $username,
                    'shipment_num' =>  $tagihan[$t]['shipment_num'],
                    'quantity_receive' =>  $tagihan[$t]['quantity_receive']
                );
                $transaction_date =  $tagihan[$t]['transaction_date'];
                $created_date = date("Y-m-d");
                $this->print_json($this->M_insert->InsertToPSUBTagihan($data, $transaction_date, $created_date));
            }
        }
    }
    public function print_json($value)
    {
        header('HTTP/1.1 200 OK');
        header('Content-Type: application/json');
        echo json_encode($value);
    }
}
