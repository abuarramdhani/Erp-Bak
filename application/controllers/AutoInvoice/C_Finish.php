<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Finish extends CI_Controller
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
        $this->load->model('AutoInvoice/M_autoinvoice');

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

        $data['Title'] = 'DO Finish Invoice';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('AutoInvoice/V_Finish', $data);
        $this->load->view('V_Footer', $data);
    }
    public function ListFinish()
    {

        $DoFinish = $this->M_autoinvoice->DoFinish();

        // echo "<pre>";
        // print_r($DoFinish);
        // exit();

        $data['DoFinish'] = $DoFinish;

        $this->load->view('AutoInvoice/V_ListFinish', $data);
    }
    public function CetakInvoice($i)
    {
        $InvoiceToCetak = $this->M_autoinvoice->InvoiceToCetak($i);

        // echo "<pre>";
        // print_r($InvoiceToCetak);
        // exit();

        $data['Invoice'] = $InvoiceToCetak;

        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf = new mPDF('utf-8', array(210, 148), 0, '', 5, 2, 20, 3, 3, 3); //---r,l,t,b
        $filename = $i . '.pdf';

        $html = $this->load->view('AutoInvoice/V_PdfInvoice', $data, true);
        $foot = $this->load->view('AutoInvoice/V_PdfInvoiceF', $data, true);


        ob_end_clean();

        $pdf->WriteHTML($html);
        $pdf->SetHTMLFooter($foot);
        $pdf->Output($filename, 'I');
    }
    public function CetakRDO($i)
    {
        $RDOToCetak = $this->M_autoinvoice->RDOToCetak($i);

        // echo "<pre>";
        // print_r($RDOToCetak);
        // exit();

        $data['RDO'] = $RDOToCetak;

        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf = new mPDF('utf-8', array(210, 297), 0, '', 3, 3, 20, 3, 3, 3); //---r,l,t,b
        $filename = $i . '.pdf';

        $html = $this->load->view('AutoInvoice/V_PdfRDO', $data, true);
        $foot = $this->load->view('AutoInvoice/V_PdfRDOF', $data, true);


        ob_end_clean();

        $pdf->WriteHTML($html);
        $pdf->SetHTMLFooter($foot);
        $pdf->Output($filename, 'I');
    }
}
