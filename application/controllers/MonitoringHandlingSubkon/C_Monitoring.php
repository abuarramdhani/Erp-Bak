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

        $data['Title'] = 'Monitoring Handling Subkon';
        $data['Menu'] = 'Monitoring';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('MonitoringHandlingSubkon/V_Monitoring');
        $this->load->view('V_Footer',$data);
    }

    public function getSubkon(){
        $term = $this->input->get('term',TRUE);
        $term = strtoupper($term);
        $data = $this->M_monhansub->getSubkon($term);
        echo json_encode($data);
    }

    public function getHandling(){
        $term = $this->input->get('term',TRUE);
        $term = strtoupper($term);
        $data = $this->M_monhansub->getHandling($term);
        echo json_encode($data);
    }

    public function getDataMonitoring(){
        $subkon = $this->input->post('subkon');
        $subname = $this->input->post('subname');
        $handling = $this->input->post('handling');
        $date = $this->input->post('date');
        $status = $this->input->post('status');

        $data['mon'] = $this->M_monhansub->getDataMonitoring($subkon,$handling,$date,$status);
        $data['pic'] = $this->M_monhansub->getDataPIC();
        $data['subname'] = $subname;

        $this->load->view('MonitoringHandlingSubkon/V_TblMonitoring', $data);
    }
}
?>