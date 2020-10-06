<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Approve extends CI_Controller
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
        $this->load->model('CARVP/M_car');

        $this->checkSession();
    }
    public function checkSession()
    {
        if ($this->session->is_logged) {
        } else {
            redirect('index');
        }
    }

    public function index()
    {
        $user = $this->session->username;

        $user_id = $this->session->userid;

        $data['Title'] = 'Approval';
        $data['Menu'] = '';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $noind = $this->session->user;

        // $list_supplier = $this->M_car->ListtoApprove($noind);
        $carr = $this->M_car->Listcar();
        $w = 0;
        foreach ($carr as $supplier) {
            $carr[$w]['DETAIL'] = $this->M_car->ListbyCAR($supplier['CAR_NUM']);
            $carr[$w]['NO_CAR'] = $carr[$w]['DETAIL'][0]['CAR_NUM'];
            $carr[$w]['SUPPLIER_NAME'] = $carr[$w]['DETAIL'][0]['SUPPLIER_NAME'];
            $carr[$w]['APPROVE_DATE'] = $carr[$w]['DETAIL'][0]['APPROVE_DATE'];
            if ($carr[$w]['DETAIL'][0]['ACTIVE_FLAG'] == 'A') {
                $carr[$w]['DELIVERY_STATUS'] = 'Success';
            } else if ($carr[$w]['DETAIL'][0]['ACTIVE_FLAG'] == 'F') {
                $carr[$w]['DELIVERY_STATUS'] = 'Failed';
            } else {
                $carr[$w]['DELIVERY_STATUS'] = '-';
            }
            $carr[$w]['CREATED_DATE'] = $carr[$w]['DETAIL'][0]['CREATED_DATE'];
            $carr[$w]['ACTIVE_FLAG'] = $carr[$w]['DETAIL'][0]['ACTIVE_FLAG'];
            $carr[$w]['APPROVE_TO'] = $carr[$w]['DETAIL'][0]['APPROVE_TO'];



            $w++;
        }

        // echo "<pre>";
        // print_r($carr);
        // exit();


        $data['car'] = $carr;
        $data['noind'] = $noind;


        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('CARVP/V_Approve');
        $this->load->view('V_Footer', $data);
    }

    public function format_date($date)
    {
        $ss = explode("/", $date);
        return $ss[2] . "-" . $ss[1] . "-" . $ss[0];
    }

    public function updateApprove()
    {

        $no_car = $this->input->post('no_car');
        date_default_timezone_set('Asia/Jakarta');
        $approve_date = date('d-m-Y');

        // generate file pdf
        ob_start();

        $list_supplier = $this->M_car->ListsupplierbyNoCAR($no_car);
        $w = 0;
        foreach ($list_supplier as $supplier) {
            $list_supplier[$w]['DETAIL'] = $this->M_car->ListbyCAR($supplier['CAR_NUM']);
            $periode = $this->M_car->getPeriode($supplier['CAR_NUM']);
            $list_supplier[$w]['PERIODE'] = $periode[0]['CREATED_DATE'];
            $po_num = $this->M_car->getPO($supplier['CAR_NUM']);
            $attendance = $this->M_car->getAttendance($po_num[0]['PO_NUMBER']);
            $list_supplier[$w]['ATTENDANCE'] = $attendance[0]['VENDOR_CONTACT'];
            $list_supplier[$w]['PO'] = $po_num;
            $list_supplier[$w]['CAR_TYPE'] = $list_supplier[$w]['DETAIL'][0]['CAR_TYPE'];
            $list_supplier[$w]['NC_SCOPE'] = $list_supplier[$w]['DETAIL'][0]['NC_SCOPE'];
            if ($list_supplier[$w]['DETAIL'][0]['APPROVE_DATE'] == null) {
                $list_supplier[$w]['APPROVER'] = null;
            } else {
                $nama = $this->M_car->getNamaApprover($list_supplier[$w]['DETAIL'][0]['APPROVE_TO']);
                $list_supplier[$w]['APPROVER'] = $nama[0]['nama'];
            }

            $w++;
        }

        $data['car'] = $list_supplier;

        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf = new mPDF('utf-8', array(210, 297), 0, '', 3, 3, 30, 3, 3, 3); //----- A5-L
        $filename = '' . $no_car . '.pdf';
        $pdf_dir = './assets/upload/CARVP/';
        $html = $this->load->view('CARVP/V_PdfCar', $data, true);        //-----> Fungsi Cetak PDF
        $head1 = $this->load->view('CARVP/V_PdfCarHeader1', $data, true);        //-----> Fungsi Cetak PDF
        $head2 = $this->load->view('CARVP/V_PdfCarHeader2', $data, true);        //-----> Fungsi Cetak PDF
        $html2 = $this->load->view('CARVP/V_PdfCar2', $data, true);        //-----> Fungsi Cetak PDF

        ob_end_clean();
        $pdf->setHTMlHeader($head1);
        $pdf->WriteHTML($html);
        $pdf->setHTMlHeader($head2);
        $pdf->WriteHTML($html2);
        $pdf->Output($pdf_dir . $filename, 'F');

        // Send Email ------------
        $this->load->library('PHPMailerAutoload');
        $mail = new PHPMailer();
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';

        $mail->isSMTP();
        $mail->Host = 'quick.co.id';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $mail->Username = 'cpar@quick.co.id';
        $mail->Password = 'U!^7SZQX17Vw';
        $mail->WordWrap = 50;

        $mail->setFrom('cpar@quick.co.id');

        $alamat = 'quick.sec8@gmail.com,riskiviolin@gmail.com,';
        $e = explode(',', $alamat);
        $email = array();
        for ($i = 0; $i < sizeof($e); $i++) {
            if ($e[$i] != null || $e[$i] != "") {
                array_push($email, $e[$i]);
            }
        }

        foreach ($email as $toE) {
            $mail->addAddress($toE);
        }
        // $mail->addAddress('riskiviolin@gmail.com');
        $mail->addAttachment($pdf_dir . $filename);
        $mail->Subject = 'NEED FEEDBACK - [' . $list_supplier[0]['SUPPLIER_NAME'] . '] Corrective Action Request (CAR) No. ' . $list_supplier[0]['CAR_NUM'] . '';
        $mail->msgHTML('Dengan hormat,<br><br>

        Berikut kami kirimkan CAR terkait ' . $list_supplier[0]['NC_SCOPE'] . '  yang bermasalah mohon untuk  membalas CAR dengan mengisi kolom Rootcause (analisa masalah) dan kolom Corrective Action (perbaikan yang akan dilakukan). Dokumen pada lampiran.<br>
        Vendor berkewajiban untuk memberikan konfirmasi dan mengirimkan balasan CAR dalam kurun waktu 7 hari sejak email dikirim oleh CV. KHS dan mengirimkan balasan ke cpar@quick.co.id (atau dengan "reply" email ini)<br><br>
        
        Demikian informasi ini kami sampaikan.<br><br>
        
        
        Terima kasih,<br>
        Rani<br>
        Adm. Sistem Pembelian<br>
        CV. Karya Hidup Sentosa<br>
        Telp. +62-274-512095 ext 225<br>
        Fax. +62-274-563523');

        if (!$mail->send()) {
            echo 'Pesan Tidak Terkirim!';
            $flag = 'F';
            $this->M_car->UpdateApprove($flag, $no_car, $approve_date);
        } else {
            echo 'Pesan Terkirim ke Vendor';
            $flag = 'A';
            $this->M_car->UpdateApprove($flag, $no_car, $approve_date);
        }
    }
    public function DetailCAR()
    {
        $no_car = $this->input->post('no_car');

        $datatoView = $this->M_car->dataToEdit($no_car);

        $data['datatoview'] = $datatoView;

        // echo "<pre>";
        // print_r($datatoView);
        // exit();
        $this->load->view('CARVP/V_mdl_Detail', $data);
    }
}
