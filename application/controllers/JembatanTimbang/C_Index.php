<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Index extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('session');
        $this->load->library('ciqrcode');
        $this->load->library('encrypt');
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('JembatanTimbang/M_index');
        $this->load->model('SystemAdministration/MainMenu/M_user');

        if ($this->session->userdata('logged_in')!=true) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
        }
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
        $this->checkSession();
        $user_id = $this->session->userid;

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        // $data['show'] = $this->M_outpart->getAllIn();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('JembatanTimbang/V_Index', $data);
        $this->load->view('V_Footer', $data);
    }

    public function Cetak()
    {
        $this->checkSession();
        $user_id             = $this->session->userid;
        $data['username']    = $this->session->user;
        $passwordArr         = $this->db->get_where('sys.sys_user', ['user_id' => $user_id])->row_array();
        $data['password']    = $passwordArr['user_password'];

        $data['Menu'] = 'Transaction Dashboard';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
        // $berat = explode(",",$this->input->post('berat1'));

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('JembatanTimbang/V_Cetak', $data);
        $this->load->view('V_Footer', $data);
    }

    // public function GeneratePDF($id)
    // {
    //     //data trial
    //     $data['get'] = $this->M_index->getDataTiketpdf($id);
    //
    //     $data['nama_petugas'] = $this->session->employee;
    //     $data['username']    = $this->session->user;
    //
    //     // e10adc3949ba59abbe56e057f20f883e
    //     // http://192.168.168.190/jti/out/drivers and tickets
    //
    //     $this->load->library('Pdf');
    //     $this->load->library('ciqrcode');
    //
    //     $pdf 		= $this->pdf->load();
    //     $pdf 		= new mPDF('utf-8',array(240 , 140), 0, '', 3, 3, 3, 0, 0, 0);
    //
    //     // new mPDF('utf-8', 'A4-L', 0, '', 3, 3, 3, 3, 3, 3);
    //
    //     // ------ GENERATE QRCODE ------
    //     if (!is_dir('./assets/img/jti')) {
    //         mkdir('./assets/img/jti', 0777, true);
    //         chmod('./assets/img/jti', 0777);
    //     }
    //
    //     $temp_filename = array();
    //     foreach ($data['get'] as $jti) {
    //         $params['data']		= $jti['nobuktitimbang'];
    //         $params['level']	= 'H';
    //         $params['size']		= 4;
    //         $config['black']	= array(224,255,255);
    //         $config['white']	= array(70,130,180);
    //         $params['savename'] = './assets/img/jti/'.$jti['nobuktitimbang'].'.png';
    //         $this->ciqrcode->generate($params);
    //         array_push($temp_filename, $params['savename']);
    //     }
    //     ob_end_clean() ;
    //     $filename 	= 'Bukti_Timbang'.date('d-M-Y').'.pdf';
    //     $aku 				= $this->load->view('JembatanTimbang/pdf/V_Pdf', $data, true);
    //     $pdf->WriteHTML($aku);
    //     $pdf->Output($filename, 'I');
    // }
    //
    //
    // public function GenerateTiketPDF($id)
    // {
    //     //data trial
    //     $data['get'] = $this->M_index->getDataTiketpdf($id);
    //
    //     $data['nama_petugas'] = $this->session->employee;
    //     $data['username']    = $this->session->user;
    //
    //     $this->load->library('Pdf');
    //     $this->load->library('ciqrcode');
    //
    //     $pdf 		= $this->pdf->load();
    //     // $height = sizeof($jti['notiket'])*1;
    //     $pdf 		= new mPDF('utf-8',array(100, 210), 0, '', 3, 3, 3, 3, 3, 3);
    //
    //
    //     // ------ GENERATE QRCODE ------
    //     if (!is_dir('./assets/img/jti/tiket')) {
    //         mkdir('./assets/img/jti/tiket', 0777, true);
    //         chmod('./assets/img/jti/tiket', 0777);
    //     }
    //
    //     $temp_filename = array();
    //     foreach ($data['get'] as $jti) {
    //         $params['data']		= $jti['notiket'];
    //         $params['level']	= 'H';
    //         $params['size']		= 4;
    //         $config['black']	= array(224,255,255);
    //         $config['white']	= array(70,130,180);
    //         $params['savename'] = './assets/img/jti/tiket/'.$jti['notiket'].'.png';
    //         $this->ciqrcode->generate($params);
    //         array_push($temp_filename, $params['savename']);
    //     }
    //     ob_end_clean() ;
    //     $filename 	= 'Tiket_Jembatan_Timbang'.date('d-M-Y').'.pdf';
    //     $aku 				= $this->load->view('JembatanTimbang/pdf/V_TiketPdf', $data, true);
    //     $pdf->WriteHTML($aku);
    //     $pdf->Output($filename, 'I');
    // }
    //
    // // ajax area
    // public function getdataBarangdanitem()
    // {
    //     $id = $this->input->post('nomerSPB');
    //     $cek = $this->M_index->getSubInv($id);
    //     if (empty($Cek)) {
    //         echo "Data is Empty";
    //     } else {
    //         // $data['spb'] = $this->M_index->getData($id);
    //         // echo "<pre>";
    //         // print_r($data);
    //         // exit();
    //         $this->load->view('JembatanTimbang/Ajax/V_Ajax', $data);
    //     }
    // }
    //
    // // TRIAL
    //
    // public function getDataTiket()
    // {
    //     $id = $this->input->post('code');
    //     echo json_encode($this->M_index->getDataTiket($id));
    // }
    //
    // public function updataJTI($id)
    // {
    //     // trial No Bukti Timbang
    //     $time = date('y-m-d');
    //     $lastNumber = $this->M_index->getLatestNumber($id);
    //     if (empty($lastNumber[0]['last_number'])) {
    //         $newNumber = '01-BTI-'.$time;
    //     } else {
    //         $newNumber = $lastNumber[0]['last_number']+1;
    //     if (strlen($newNumber) < 2) {
    //         $newNumber = str_pad($newNumber, 2, "0", STR_PAD_LEFT);
    //     }
    //         $newNumber = $newNumber.'-BTI-'.$time;
    //     }
    //
    //     // $berat = explode(",",$this->input->post('berat1'));
    //     // echo "<pre>";
    //     // print_r($berat);
    //     // die;
    //
    //     $data = [
    //       'namadriver'		  => $this->input->post('nama'),
    //       'vendor' 			    => $this->input->post('vendor'),
    //       'nodokumen' 			=> $this->input->post('nodokumen'),
    //       'notiket'					=> $this->input->post('noTiket'),
    //       'nomorpolisi'			=> $this->input->post('noPolisi'),
    //       'jeniskendaraan' 	=> $this->input->post('jenKen'),
    //       'tanggaltimbang' 	=> $this->input->post('tglTim'),
    //       'keperluan' 		  => $this->input->post('keperluan'),
    //       'berat1' 				  => $this->input->post('berat1'),
    //       'nobuktitimbang'  => $newNumber
    //   ];
    //
    //     //trial query
    //     $this->M_index->updateJTI($data, $id);
    //     echo json_encode($id);
    // }
}
