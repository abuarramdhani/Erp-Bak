<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_NotifikasiPembelian extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		  
		$this->load->model('EmailNotifikasiPembelian/M_notifikasipembelian');
	}
    
    public function index()
    {
        $data['ListReceiver'] = $this->M_notifikasipembelian->getListReceiver();

        foreach ($data['ListReceiver'] as $key => $value) {
            $data['item'] = $this->M_notifikasipembelian->getDataItem($value['REQUISITION_HEADER_ID'], $value['TO_PERSON_ID']);
        }
        
        // Load Email Library
        $this->load->library('PHPMailerAutoload');
        $mail = new PHPMailer();
        //clear address and bccs
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';

        // Set Connection SMTP Mail
        $mail->isSMTP();
        $mail->Host = 'm.quick.com';
        $mail->Port = 465;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPOptions = array(
                'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true)
                );
        $mail->Username = 'no-reply@quick.com';
        $mail->Password = "123456";
        $mail->WordWrap = 50;
        

        //Alamat Pengirim Email
        $mail->setFrom('system-oracle@quick.com ', 'ICT Auto Notification System');

        // Alamat Email Target

        foreach ($data['ListReceiver'] as $key => $value) {           
        $mail->ClearAddresses();
        $mail->ClearBCCs();
        $mail->addAddress($value['EMAIL_INTERNAL']);
        $mail->addBCC('nugroho@quick.com');
        $mail->addBCC('fahima_choirun_n@quick.com');
        //set content email
        $emailBody = '
        <style>
            .khusus, th.khusus, td.khusus {
                border: 1px solid black;
                border-collapse: collapse;
                            }
        </style>
        <div style="font-family: times new roman, new york, times, serif; font-size: 12pt; color: #000000">
        Kepada Yth.
        <br/>
        '.$value['FULL_NAME'].'
        <br/>
        ditempat.
        <br/>
        <br/>
        Menginformasikan permintaan pembelian Bapak/Ibu,
        <br/>

        <table style="width:auto;">
        <tr>
            <td><b>Nomor PP</b></td>
            <td style="width:auto"><b>: '.$value['NO_PP'].'</b></td>
        </tr>
        <tr>
            <td><b>Nomor PR</b></td>
            <td><b>: '.$value['NO_PR'].'</b></td>
        </tr>
        </table>

        <br/>
        Telah diterima dan diapprove Pembelian pada <b>'.date("d F Y", strtotime($value['ACTION_DATE'])).'</b>, dengan detail sebagai berikut:
        <br/>
        <br/>';

        $emailBody .= '
        <table class="khusus">
        <thead>
            <tr>
                <th style="width:20px"  class="khusus">NO</th>
                <th style="width:150px" class="khusus">KODE ITEM</th>
                <th style="width:300px" class="khusus">ITEM DESCRIPTION</th>
                <th style="width:50px"  class="khusus">QTY</th>
                <th style="width:50px"  class="khusus">UOM</th>
                <th style="width:100px" class="khusus">NEED BY DATE</th>
                <th style="width:280px" class="khusus">NOTE TO BUYER</th>
            </tr>
        </thead>
        <tbody>';

        $data['detail'] = $this->M_notifikasipembelian->getDataItem($value['REQUISITION_HEADER_ID'], $value['TO_PERSON_ID']);
        $no=1; foreach ($data['detail'] as $k) {
        $emailBody .=   '<tr>
                            <td class="khusus" align="center">'.$k['LINE_NUM'].'</td>
                            <td class="khusus" align="center">'.$k['KODE_ITEM'].'</td>
                            <td class="khusus" align="center">'.$k['ITEM_DESCRIPTION'].'</td>
                            <td class="khusus" align="center">'.$k['QTY'].'</td>
                            <td class="khusus" align="center">'.$k['UNIT_MEAS_LOOKUP_CODE'].'</td>
                            <td class="khusus" align="center">'.$k['NEED_BY_DATE'].'</td>
                            <td class="khusus" align="center">'.$k['NOTE_TO_AGENT'].'</td>
                        </tr>';
        $no++; }        
        $emailBody .= '</tbody></table>
        <br/>
        Demikian Terimakasih.
        <br/>
        <br/>
        -----
        <br/>
        <span style="font-size: x-small;"><em>Sent by ICT Auto Notification System</em></span><br/>
        <span style="font-size: x-small;"><em>VoIP: 12300</em></span><br/>
        <span style="font-size: x-small;"><em>MyGroup: 08112545922</em></span><br/>
        </div>';
         
        $mail->Subject = 'ERP - Notifikasi Approval PR PP '.$value['NO_PP'];
        $mail->Body = $emailBody;
        $mail->IsHTML(true);

        if ( $mail->send() == FALSE ) {
            echo 'Pesan gagal terkirim. Berikut detailnya ' . $mail->ErrorInfo.'<br><br>';
        } else {
            echo 'Pesan berhasil terkirim ke <b>'.$value['EMAIL_INTERNAL'].'</b><br>';
        }


   }
}

}