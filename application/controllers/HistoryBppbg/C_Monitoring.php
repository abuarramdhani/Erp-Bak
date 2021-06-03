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
        $this->load->model('HistoryBppbg/M_bppbg');
            
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

        $data['Title'] = 'Monitoring Bppbg';
        $data['Menu'] = 'Monitoring';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('HistoryBppbg/V_Monitoring');
        $this->load->view('V_Footer',$data);
    }

    public function search(){
        $term = $this->input->get('term',TRUE);
        $term = strtoupper($term);
        $data = $this->M_bppbg->search($term);
        echo json_encode($data);
    }

    public function getData(){
        $bppbg = $this->input->post('bppbg');
        // echo "<pre>";print_r($bppbg);exit();

        $data['bppbg'] = $this->M_bppbg->getData($bppbg);
        // echo "<pre>";print_r($data['bppbg']);exit();

        $this->load->view('HistoryBppbg/V_TblView', $data);
    }

    public function getSubinv(){
        $term = $this->input->get('term',TRUE);
        $term = strtoupper($term);
        $data = $this->M_bppbg->getSubinv($term);
        echo json_encode($data);
    }

    public function getItem(){
        $term = $this->input->get('term',TRUE);
        $term = strtoupper($term);
        $data = $this->M_bppbg->getItem($term);
        echo json_encode($data);
    }

    public function getDataMonitoring(){
        $subinv = $this->input->post('subinv');
        $item = $this->input->post('item');
        $status = $this->input->post('status');        

        $data['mon'] = $this->M_bppbg->getDataMonitoring($subinv,$item,$status);

        $this->load->view('HistoryBppbg/V_TblMonitoring', $data);
    }
}
?>