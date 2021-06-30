<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Cetak extends CI_Controller {
    public function __construct(){
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');

        //load the login model
        $this->load->library('session');
        $this->load->model('M_Index');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('MonitoringHandlingSubkon/M_monhansub');
            
        $this->checkSession();
    }

    public function checkSession(){
        if($this->session->is_logged){      
        
        }else{
            redirect();
        }
    }

    public function Index(){
        $user = $this->session->username;
        $user_id = $this->session->userid;

        $data['Title'] = 'Cetak Kartu Identitas Subkon';
        $data['Menu'] = 'Cetak KIS';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('MonitoringHandlingSubkon/V_Cetak');
        $this->load->view('V_Footer',$data);
    }

    public function cetakKIS($subkon){
        if (!empty($subkon)) {
            $this->load->library('Pdf');
            $this->load->library('ciqrcode');

            $pdf        = $this->pdf->load();
            $pdf        = new mPDF('utf-8', array(105 , 150), 0, '', 3, 3, 3, 0, 0, 0);

            $kis_number = $this->M_monhansub->getNewNumber($subkon);

            // ------ GENERATE QRCODE ------
            if (!is_dir('./assets/img/kisQRCODE')) {
                mkdir('./assets/img/kisQRCODE', 0777, true);
                chmod('./assets/img/kisQRCODE', 0777);
            }

            $params['data']     = $kis_number[0]['KIS'];
            $params['level']    = 'H';
            $params['size']     = 4;
            $params['black']    = array(255,255,255);
            $params['white']    = array(0,0,0);
            $params['savename'] = './assets/img/kisQRCODE/'.$kis_number[0]['KIS'].'.png';

            $this->ciqrcode->generate($params);

            ob_end_clean() ;

            $data['subkon'] = $this->M_monhansub->getSubkon($subkon);
            $data['kis'] = $kis_number[0]['KIS'];

            $filename   = 'KIS_'.$subkon.'.pdf';
            $cetakKIS   = $this->load->view('MonitoringHandlingSubkon/V_Pdf_KIS', $data, true);

            $pdf->SetFillColor(0,255,0);
            $pdf->WriteHTML($cetakKIS);
            $pdf->Output($filename, 'I');
        } 
        else {
            echo json_encode(array(
                'success' => false,
                'message' => 'id is null'
            ));
        }
    }
}
?>