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
        $this->load->model('BarangRepairSubkon/M_brgrepair');
            
        $this->checkSession();
    }

    public function checkSession(){
		if($this->session->is_logged){		
        
        }else{
			redirect();
		}
    }
    
    public function index(){
        $user = $this->session->username;
        $user_id = $this->session->userid;

        $data['Title'] = 'Monitoring Barang Repair Subkon';
        $data['Menu'] = 'Monitoring';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('BarangRepairSubkon/V_Monitoring');
        $this->load->view('V_Footer',$data);
    }

    public function getSubkon(){
        $term = strtoupper($this->input->post('term'));
        $data = $this->M_brgrepair->getSubkon($term);
        echo json_encode($data);
    }

    public function getMonBrgRepair(){
        $data['open'] = $this->M_brgrepair->getBrgRepair('OPEN');
        $data['closed'] = $this->M_brgrepair->getBrgRepair('CLOSED');

        $this->load->view('BarangRepairSubkon/V_TblMonitoring', $data);
    }

    public function search(){
        $periode = $this->input->post('periode');
        $subkon = $this->input->post('subkon');
        // echo "<pre>";print_r($periode);exit();

        $data['open'] = $this->M_brgrepair->getBrgRepairSearch($periode, $subkon, 'OPEN');
        $data['closed'] = $this->M_brgrepair->getBrgRepairSearch($periode, $subkon, 'CLOSED');

        $this->load->view('BarangRepairSubkon/V_TblMonitoring', $data);
    }

}

?>