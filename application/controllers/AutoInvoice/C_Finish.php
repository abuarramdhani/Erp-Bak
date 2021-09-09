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

        $data['path'] = explode('/', $_SERVER['PATH_INFO']);

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('AutoInvoice/V_Finish', $data);
        $this->load->view('V_Footer', $data);
    }
    
    public function ListFinishKasie()
    {

        $DoFinish = $this->M_autoinvoice->DoFinish();

        for ($i = 0; $i < sizeof($DoFinish); $i++) {
            $InvoiceToCetak = $this->M_autoinvoice->InvoiceToCetak($DoFinish[$i]['CETAK_INVOICE_REQ_ID']);
            $RDOToCetak = $this->M_autoinvoice->RDOToCetak($DoFinish[$i]['CETAK_RDO_REQ_ID']);
            if ($InvoiceToCetak != null) {
                $DoFinish[$i]['AMMOUNT_INVOICE'] = $InvoiceToCetak[0]['CS_TOTAL'];
            } else {
                $DoFinish[$i]['AMMOUNT_INVOICE'] = 0;
            }
            if ($RDOToCetak != null) {
                $DoFinish[$i]['AMMOUNT_RDO'] = $RDOToCetak[0]['NETTO'];
            } else {
                $DoFinish[$i]['AMMOUNT_RDO'] = 0;
            }
        }


        $path = explode('/', $_SERVER['PATH_INFO']);

        // echo "<pre>";
        // print_r($DoFinish);
        // exit();

        $data['DoFinish'] = $DoFinish;

        $data['path'] = $path;

        echo json_encode($data);
    }
    public function ListFinish()
    {

        $DoFinish = $this->M_autoinvoice->DoFinish();

        for ($i = 0; $i < sizeof($DoFinish); $i++) {
            $InvoiceToCetak = $this->M_autoinvoice->InvoiceToCetak($DoFinish[$i]['CETAK_INVOICE_REQ_ID']);
            $RDOToCetak = $this->M_autoinvoice->RDOToCetak($DoFinish[$i]['CETAK_RDO_REQ_ID']);
            if ($InvoiceToCetak != null) {
                $DoFinish[$i]['AMMOUNT_INVOICE'] = $InvoiceToCetak[0]['CS_TOTAL'];
            } else {
                $DoFinish[$i]['AMMOUNT_INVOICE'] = 0;
            }
            if ($RDOToCetak != null) {
                $DoFinish[$i]['AMMOUNT_RDO'] = $RDOToCetak[0]['NETTO'];
            } else {
                $DoFinish[$i]['AMMOUNT_RDO'] = 0;
            }
        }


        $path = explode('/', $_SERVER['PATH_INFO']);

        // echo "<pre>";
        // print_r($DoFinish);
        // exit();

        $data['DoFinish'] = $DoFinish;

        $data['path'] = $path;

        $this->load->view('AutoInvoice/V_ListFinish', $data);
    }
    public function CetakInvoice($i)
    {
        $InvoiceToCetak = $this->M_autoinvoice->InvoiceToCetak($i);

        for ($i = 0; $i < sizeof($InvoiceToCetak); $i++) {
            $approver = $this->M_autoinvoice->getApprover($InvoiceToCetak[0]['DO_NUM']);

            $approver_name = $this->M_autoinvoice->getnameApprover($approver[0]['APPROVED_BY']);

            $InvoiceToCetak[$i]['APPROVER'] = $approver_name[0]['nama'];
        }

        $data['Invoice'] = $InvoiceToCetak;

        // echo "<pre>";
        // print_r($InvoiceToCetak);
        // exit();

        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf = new mPDF('utf-8', array(210, 154), 0, '', 5, 2, 20, 3, 3, 3); //---r,l,t,b
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

        for ($i = 0; $i < sizeof($RDOToCetak); $i++) {
            $approver = $this->M_autoinvoice->getApprover2($RDOToCetak[0]['REQUEST_ID']);

            $approver_name = $this->M_autoinvoice->getnameApprover($approver[0]['APPROVED_BY']);

            $RDOToCetak[$i]['APPROVER'] = $approver_name[0]['nama'];
        }

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
    public function UpdateFlagFinish()
    {
        $wdd = $_POST['wdd'];
        $flag = $_POST['flag'];
        $approver = $this->session->user;

        for ($i = 0; $i < sizeof($wdd); $i++) {
            $this->M_autoinvoice->UpdateFlagFinish($wdd[$i], $flag, $approver);
        }

        // echo "<pre>";
        // print_r($wdd);
        // print_r($flag);
        // exit();
    }
}
