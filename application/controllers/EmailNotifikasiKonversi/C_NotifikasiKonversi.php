<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_NotifikasiKonversi extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		  
		$this->load->model('EmailNotifikasiKonversi/M_notifikasikonversi');
	}
    
    public function index()
    {
        $data['ConversionValue'] = $this->M_notifikasikonversi->getConversionValue();
        
        // Load Email Library
        $this->load->library('PHPMailerAutoload');
        $mail = new PHPMailer();
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

        $mail->setFrom('system-oracle@quick.com ', 'System Oracle');

        // Alamat Email Target
        $mail->addAddress('nugroho@quick.com');
        $mail->addAddress('maya_kristiana@quick.com');
        // $mail->addAddress('trial_marfin@quick.com');

        $emailBody = '
        <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }    
        </style>
        <table><tr><th>Conversion Type</th><th>Conversion</th><th>Conversion Rate</th></tr>';        
        // Set Email Content
        foreach ($data['ConversionValue'] as $key => $value) {
            if ( $value['CONVERSION_RATE'] != NULL ) {
                $emailBody .= '<tr><td>'.$value['USER_CONVERSION_TYPE'].'</td><td>'.$value['CONVERSION'].'</td><td>'.$value['CONVERSION_RATE'].'</td></tr>';
            } else {
                $emailBody .= '<tr><td>'.$value['USER_CONVERSION_TYPE'].'</td><td>'.$value['CONVERSION'].'</td><td>Belum Diset</td></tr>';
            }
        }
        $emailBody .= '</table>';
         
        $mail->Subject = 'Data Conversion Rate '.strtoupper(date('d-M-y'));
        $mail->Body = $emailBody;
        $mail->IsHTML(true);

        if ( $mail->send() == FALSE ) {
            echo 'Ke-'.$key.'pesan gagal terkirim. Berikut detailnya ' . $mail->ErrorInfo.'<br><br>';
        } else {
            echo 'Ke-'.$key.'pesan telah terkirim.<br>';   
        }
    }

}