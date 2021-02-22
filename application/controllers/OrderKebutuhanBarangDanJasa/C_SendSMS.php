<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_SendSMS extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('OrderKebutuhanBarangDanJasa/M_sendsms');
        $this->load->model('OrderKebutuhanBarangDanJasa/Approver/M_approver');
        $this->load->model('OrderKebutuhanBarangDanJasa/Pengelola/M_pengelola');
        $this->load->model('OrderKebutuhanBarangDanJasa/Puller/M_puller');
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

        if(count($newData) < 1){
            echo "Semua Approver telah approve order pada Aplikasi APPROVER-OKEBAJA.";
        } else {
            foreach ($newData as $approver) {
                $pesan = "Selamat Pagi ". $approver['SAPAAN'] ." ".$approver['FULL_NAME'].",\rAnda masih memiliki ".$approver['UNAPPROVED_ORDER']." order yang belum di approve pada aplikasi APPROVER-OKEBAJA. Silahkan buka http://erp.quick.com/ melalui jaringan CV.KHS untuk approve order.\r-- Dikirim oleh ERP Okebaja (No-Reply) --";
                $pesan = rawurlencode($pesan);
                $url   = 'http://192.168.168.122:80/sendsms?username=ict&password=quick1953&phonenumber='.$approver['NOMOR_MYGROUP'].'&message='.$pesan.'&[port=gsm-1.2&][report=1&][timeout=20]';
                // print_r($url);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                
                // grab URL and pass it to the browser
                curl_exec($ch);
                sleep(20);
            }
                // die;
                // close cURL resource, and free up system resources
                curl_close($ch);
        }
    }

    public function pengelola()
    {
        set_time_limit(3600);
        $pengelola = $this->M_sendsms->getDataPengelola();
        
        $newData = [];
        foreach ($pengelola as $key => $value) {
            $unapproved_order = $this->M_pengelola->getUnapprovedOrderCount($value['NATIONAL_IDENTIFIER'], 'ALL');
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

        if(count($newData) < 1){
            echo "Semua Pengelola telah approve order pada Aplikasi PENGELOLA-OKEBAJA.";
        } else {
            foreach ($newData as $pengelola) {
                $pesan = "Selamat Pagi ". $pengelola['SAPAAN'] ." ".$pengelola['FULL_NAME'].",\rAnda masih memiliki ".$pengelola['UNAPPROVED_ORDER']." order yang belum di approve pada aplikasi PENGELOLA-OKEBAJA. Silahkan buka http://erp.quick.com/ melalui jaringan CV.KHS untuk approve order.\r-- Dikirim oleh ERP Okebaja (No-Reply) --";
                $pesan = rawurlencode($pesan);
                $url   = 'http://192.168.168.122:80/sendsms?username=ict&password=quick1953&phonenumber='.$pengelola['NOMOR_MYGROUP'].'&message='.$pesan.'&[port=gsm-1.2&][report=1&][timeout=20]';
                // print_r($url);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                
                // grab URL and pass it to the browser
                curl_exec($ch);
                sleep(20);
            }
                // die;
                // close cURL resource, and free up system resources
                curl_close($ch);
        }
    }

    public function puller()
    {
        set_time_limit(3600);
        $puller = $this->M_sendsms->getDataPuller();
        
        $newData = [];
        foreach ($puller as $key => $value) {
            $unapproved_order = $this->M_puller->getUnapprovedOrderCount($value['NATIONAL_IDENTIFIER'], 'ALL');
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

        if(count($newData) < 1){
            echo "Semua Puller telah approve order pada Aplikasi PULLER-OKEBAJA.";
        } else {
            foreach ($newData as $puller) {
                $pesan = "Selamat Pagi ". $puller['SAPAAN'] ." ".$puller['FULL_NAME'].",\rAnda masih memiliki ".$puller['UNAPPROVED_ORDER']." order yang belum di approve pada aplikasi PULLER-OKEBAJA. Silahkan buka http://erp.quick.com/ melalui jaringan CV.KHS untuk approve order.\r-- Dikirim oleh ERP Okebaja (No-Reply) --";
                $pesan = rawurlencode($pesan);
                $url   = 'http://192.168.168.122:80/sendsms?username=ict&password=quick1953&phonenumber='.$puller['NOMOR_MYGROUP'].'&message='.$pesan.'&[port=gsm-1.2&][report=1&][timeout=20]';
                // print_r($url);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                
                // grab URL and pass it to the browser
                curl_exec($ch);
                sleep(20);
            }
                // die;
                // close cURL resource, and free up system resources
                curl_close($ch);
        }
    }
}