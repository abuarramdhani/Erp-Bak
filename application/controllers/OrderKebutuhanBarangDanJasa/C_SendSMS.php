<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_SendSMS extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('OrderKebutuhanBarangDanJasa/M_sendsms');
        $this->load->model('OrderKebutuhanBarangDanJasa/Approver/M_approver');
    }
    public function index()
    {
        set_time_limit(3600);
        $approvers = $this->M_sendsms->getDataApprover();
        
        $newData = [];
        foreach ($approvers as $key => $value) {
            $unapproved_order = $this->M_approver->getUnapprovedOrderCount($value['NATIONAL_IDENTIFIER'], 'ALL');
            $sub_data = [];
            $sub_data['NATIONAL_IDENTIFIER'] = $value['NATIONAL_IDENTIFIER'];
            $sub_data['FULL_NAME']           = $value['FULL_NAME'];
            $sub_data['EMAIL_INTERNAL']      = $value['EMAIL_INTERNAL'];
            $sub_data['NOMOR_MYGROUP']       = $value['NOMOR_MYGROUP'];
            $sub_data['UNAPPROVED_ORDER']    = $unapproved_order;
            $sub_data['SAPAAN']              = 'Bpk/Ibu';
            if($value['SEX'] == 'M'){
                $sub_data['SAPAAN']          = 'Bapak';
            } else if($value['SEX'] == 'F') { 
                $sub_data['SAPAAN']          = 'Ibu';
            }
            if($unapproved_order > 0){
                $newData[] = $sub_data;
            }
        }

        foreach ($newData as $approver) {
            $pesan = "Selamat Pagi ". $approver['SAPAAN'] ." ".$approver['FULL_NAME'].",\rAnda masih memiliki ".$approver['UNAPPROVED_ORDER']." order yang belum di approve pada aplikasi Order Kebutuhan Barang dan Jasa. Silahkan buka http://erp.quick.com/ melalui jaringan CV.KHS untuk approve order.\r--Dikirim oleh ERP--";
            $pesan = rawurlencode($pesan);
            $url   = 'http://192.168.20.5:80/sendsms?username=admin&password=admin&phonenumber=08112669449&message='.$pesan.'&[port=gsm-1.1&][report=no&][timeout=60]';
            // print_r($url);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            
            // grab URL and pass it to the browser
            curl_exec($ch);
        }
            // die;
            // close cURL resource, and free up system resources
            curl_close($ch);
    }
}