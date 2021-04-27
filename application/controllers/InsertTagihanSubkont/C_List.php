<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_List extends CI_Controller
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

        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('InsertTagihanSubkont/M_insert');

        $this->checkSession();
    }

    public function checkSession()
    {
        if ($this->session->is_logged) {
        } else {
            redirect('');
        }
    }

    public function index()
    {

        $user = $this->session->username;

        $user_id = $this->session->userid;

        $data['Title'] = 'List Tagihan Vendor';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $list_tagihan = $this->M_insert->ListTagihan();

        $data['list_tagihan'] = $list_tagihan;

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('InsertTagihanSubkont/V_List', $data);
        $this->load->view('V_Footer', $data);
    }
    public function DetailTagihan()
    {
        $nomor_tagihan = $_POST['tgh'];

        // echo $nomor_tagihan;
        $list_tagihan = $this->M_insert->ListTagihanbyNom($nomor_tagihan);
        $tbody = '';
        $no = 1;
        foreach ($list_tagihan as $key => $value) {

            $tbody .= '<tr>
            <td class="text-center">' . $no . '</td>
            <td class="text-center">' . $value['item_description_po'] . '</td>
            <td class="text-center">' . $value['item_description_job'] . '</td>
            <td class="text-center">' . $value['quantity_bersih'] . '</td>
            <td class="text-center">' . $value['uom_code'] . '</td>
            <td class="text-center">' . $value['transaction_date'] . '</td>
            <td class="text-center">Rp ' . number_format($value['total_price'], 0) . '</td>
            <td class="text-center">' . $value['po_num'] . '</td>
        </tr>';
            $no++;
        }

        $table = '
        <div class="panel-body">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead class="bg-teal">
                        <tr>
                            <th class="text-center" style="vertical-align:middle">No</th>
                            <th class="text-center" style="vertical-align:middle">Item PO</th>
                            <th class="text-center" style="vertical-align:middle">Item Job</th>
                            <th class="text-center" style="vertical-align:middle">Qty Bersih</th>
                            <th class="text-center" style="vertical-align:middle">Uom</th>
                            <th class="text-center" style="vertical-align:middle">Transaction Date</th>
                            <th class="text-center" style="vertical-align:middle">Total Price</th>
                            <th class="text-center" style="vertical-align:middle">PO Num</th>
                        </tr>
                    </thead>
                    </tbody>
                        ' . $tbody . '
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel-body">
            <form action="' . base_url('TagihanVendor/List/CetakTagihan') . '" method="post" target="_blank">
                <div class="col-md-12" style="text-align:right">
                    <input type="hidden" name="num_tagihan" value="' . $nomor_tagihan . '"/>
                    <button class="btn btn-danger">Cetak</button>
                </div>
            </form>
        </div>
        ';

        echo $table;
    }
    public function CetakTagihan()
    {
        $no_tgh = $_POST['num_tagihan'];
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
}
