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
        $carr = $this->M_car->Listcarr();
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

        $this->M_car->UpdateApprove($no_car, $approve_date);

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
                $list_supplier[$w]['KET'] = null;
            } else {
                $nama = $this->M_car->getNamaApprover($list_supplier[$w]['DETAIL'][0]['APPROVE_TO']);
                $list_supplier[$w]['APPROVER'] = $nama[0]['nama'];
                $list_supplier[$w]['KET'] = 'This form has been approved by the system / Form ini sudah melalui Approval by sistem';
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

        $alamat = $this->M_car->getEmailVendor($po_num[0]['PO_NUMBER']);

        $sites = $this->M_car->M_car->getSitesVendor($po_num[0]['PO_NUMBER']);

        // echo "<pre>";
        // print_r($alamat);
        // exit();

        foreach ($alamat as $al) {
            $e = explode(', ', $al['EMAIL']);
            $email = array();
            for ($i = 0; $i < sizeof($e); $i++) {
                $e2 = explode(' / ', $e[$i]);
                for ($a = 0; $a < sizeof($e2); $a++) {
                    if ($e2[$a] != null || $e2[$a] != "") {
                        array_push($email, $e2[$a]);
                    }
                }
            }
        }
        // $alamat = 'riskiviolin@gmail.com,';
        // $e = explode(',', $alamat);
        // $email = array();
        // for ($i = 0; $i < sizeof($e); $i++) {
        //     if ($e[$i] != null || $e[$i] != "") {
        //         array_push($email, $e[$i]);
        //     }
        // }

        // echo "<pre>";
        // print_r($email);
        // exit();


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

        foreach ($email as $toE) {
            $mail->addAddress($toE);
        }
        $mail->AddBCC('quick.sec8@gmail.com');

        $mail->addAttachment($pdf_dir . $filename);
        $mail->Subject = 'NEED FEEDBACK - [' . $list_supplier[0]['SUPPLIER_NAME'] . '] Corrective Action Request (CAR) No. ' . $list_supplier[0]['CAR_NUM'] . '';
        if ($sites[0]['SITE'] == 'IMPOR') {
            $mail->msgHTML('Dear Sir/Madam <br><br>


            Here we are send CAR (Corrective Action Request) regarding to the delivery problem, please reply by filling in the Rootcause column (problem analysis) and the Corrective Action column (improvements to be made). Once you finish it please put your company stamp and sign it then send it back to by replying this email.<br>
            We are waiting for confirmation. <br><br>
            
            
            *) For your information,<br>
            that there will be a maximum of 3x reminders within 1 week after this email is received. Reminder will be done by email (and/or phone) by CV. KHS, and carried out periodically,<br>
            if until the third reminder there is still no feedback / reply to the CAR, then a warning letter will be issued by CV. KHS if within 14 days the CAR has not been replied to.<br><br>
            
            
            Thus, we convey this information, attached is the CAR in question.<br>
            Please process immediately.<br><br><br>
            
            
            
            
            Regards,<br>
            Ikhwan<br>
            Adm. Purchasing System<br>
            CV. Karya Hidup Sentosa<br>
            Tel. +62-274-512095 ext 225<br>
            Fax. +62-274-563523<br>');
        } else {
            $mail->msgHTML('Dengan hormat,<br><br>

            Berikut kami kirimkan CAR terkait ' . $list_supplier[0]['NC_SCOPE'] . '  yang bermasalah, mohon untuk membalas CAR dengan mengisi kolom Rootcause (analisa masalah) dan kolom Corrective Action (perbaikan yang akan dilakukan). Dokumen pada lampiran.<br>
            Vendor berkewajiban untuk memberikan konfirmasi dan mengirimkan balasan CAR dalam kurun waktu 7 hari sejak email dikirim oleh CV. KHS dan mengirimkan balasan ke cpar@quick.co.id (atau dengan "reply" email ini)<br><br>
    
            Demikian informasi ini kami sampaikan.<br><br>
    
    
            Terima kasih,<br>
            Ikhwan<br>
            Adm. Sistem Pembelian<br>
            CV. Karya Hidup Sentosa<br>
            Telp. +62-274-512095 ext 225<br>
            Fax. +62-274-563523');
        }

        if (!$mail->send()) {
            echo 'Pesan Tidak Terkirim!';
            $flag = 'F';
            $this->M_car->UpdateFlag($flag, $no_car);
        } else {
            unlink($pdf_dir . $filename);
            echo 'Pesan Terkirim ke Vendor';
            $flag = 'A';
            $this->M_car->UpdateFlag($flag, $no_car);
        }
    }
    public function updateReject()
    {
        $alasan = $this->input->post('alasan');
        $no_car = $this->input->post('no_car');
        $flag = 'R';
        $this->M_car->UpdateFlagReject($flag, $alasan, $no_car);
    }
    public function kirimUlangCAR()
    {
        $no_car = $this->input->post('no_car');

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
                $list_supplier[$w]['KET'] = null;
            } else {
                $nama = $this->M_car->getNamaApprover($list_supplier[$w]['DETAIL'][0]['APPROVE_TO']);
                $list_supplier[$w]['APPROVER'] = $nama[0]['nama'];
                $list_supplier[$w]['KET'] = 'Form ini sudah melalui Approval by sistem.';
            }

            $w++;
        }

        $alamat = $this->M_car->getEmailVendor($po_num[0]['PO_NUMBER']);


        // echo "<pre>";
        // print_r($alamat);
        // exit();

        foreach ($alamat as $al) {
            $e = explode(', ', $al['EMAIL']);
            $email = array();
            for ($i = 0; $i < sizeof($e); $i++) {
                $e2 = explode(' / ', $e[$i]);
                for ($a = 0; $a < sizeof($e2); $a++) {
                    if ($e2[$a] != null || $e2[$a] != "") {
                        array_push($email, $e2[$a]);
                    }
                }
            }
        }
        $filename = '' . $no_car . '.pdf';
        $pdf_dir = './assets/upload/CARVP/';

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

        foreach ($email as $toE) {
            $mail->addAddress($toE);
        }
        $mail->AddBCC('quick.sec8@gmail.com');
        $mail->addAttachment($pdf_dir . $filename);
        $mail->Subject = 'NEED FEEDBACK - [' . $list_supplier[0]['SUPPLIER_NAME'] . '] Corrective Action Request (CAR) No. ' . $list_supplier[0]['CAR_NUM'] . '';
        $mail->msgHTML('Dengan hormat,<br><br>

        Berikut kami kirimkan CAR terkait ' . $list_supplier[0]['NC_SCOPE'] . '  yang bermasalah, mohon untuk membalas CAR dengan mengisi kolom Rootcause (analisa masalah) dan kolom Corrective Action (perbaikan yang akan dilakukan). Dokumen pada lampiran.<br>
        Vendor berkewajiban untuk memberikan konfirmasi dan mengirimkan balasan CAR dalam kurun waktu 7 hari sejak email dikirim oleh CV. KHS dan mengirimkan balasan ke cpar@quick.co.id (atau dengan "reply" email ini)<br><br>
        
        Demikian informasi ini kami sampaikan.<br><br>
        
        
        Terima kasih,<br>
        Ikhwan<br>
        Adm. Sistem Pembelian<br>
        CV. Karya Hidup Sentosa<br>
        Telp. +62-274-512095 ext 225<br>
        Fax. +62-274-563523');

        if (!$mail->send()) {
            echo 'Pesan Tidak Terkirim!';
            $flag = 'F';
            $this->M_car->UpdateFlag($flag, $no_car);
        } else {
            unlink($pdf_dir . $filename);
            echo 'Pesan Terkirim ke Vendor';
            $flag = 'A';
            $this->M_car->UpdateFlag($flag, $no_car);
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
