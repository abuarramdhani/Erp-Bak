<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Monitoring extends CI_Controller {
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
        $this->load->model('MonitoringPendingTrx/M_monpentrx');
            
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

        $data['Title'] = 'Monitoring Pending Transactions';
        $data['Menu'] = 'Monitoring';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('MonitoringPendingTrx/V_Monitoring');
        $this->load->view('V_Footer',$data);
    }

    public function getSubinv(){
        $term = $this->input->get('term',TRUE);
        $term = strtoupper($term);
        $user = $this->session->user;
        $data = $this->M_monpentrx->getSubinv($term,$user);
        echo json_encode($data);
    }

    public function getLocator(){
        $term = $this->input->get('term',TRUE);
        $term = strtoupper($term);
        $subinv = $this->input->get('subinv',TRUE);
        $data = $this->M_monpentrx->getLocator($term,$subinv);
        echo json_encode($data);
    }

    public function checkLocator(){
        $subinv = $this->input->post('subinv');
        $data['loc'] = $this->M_monpentrx->checkLocator($subinv);
    }

    public function getDataMonitoring(){
        $subinv = $this->input->post('subinv');
        $loc = $this->input->post('loc');
        $loc2 = $this->input->post('loc2');

        $data['mon'] = $this->M_monpentrx->getDataMonitoring($subinv,$loc);
        $data['subinv'] = $subinv;
        $data['loc2'] = $loc2;

        $this->load->view('MonitoringPendingTrx/V_TblMonitoring', $data);
    }

    public function getDetailMonitoring(){
        $req = $this->input->post('req');

        $data['detail'] = $this->M_monpentrx->getDetailMonitoring($req);

        $this->load->view('MonitoringPendingTrx/V_TblDetail', $data);
    }
}
?>