<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_MonitoringSalesOrder extends CI_CONTROLLER {
    public function __construct()
		{
            parent::__construct();

            $this->load->helper('form');
            $this->load->helper('url');
            $this->load->helper('html');
            $this->load->library('form_validation');
              //load the login model
            $this->load->library('session');
            $this->load->model('M_Index');
		    $this->load->model('MonitoringSalesOrder/M_monitoringsalesorder');
            $this->load->model('SystemAdministration/MainMenu/M_user');
              
            if($this->session->userdata('logged_in')!=TRUE) {
                $this->load->helper('url');
                $this->session->set_userdata('last_page', current_url());
                $this->session->set_userdata('Responsbility', 'some_value');
            }
        }
        
        public function checkSession(){
            if($this->session->is_logged){
                
            }else{
                redirect();
            }
        }

    public function index(){
        $this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        
        $this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringSalesOrder/V_Outstanding');
		$this->load->view('V_Footer',$data);
    }
    
    public function do_outstanding(){
        $data = $this->M_monitoringsalesorder->do_outstanding();
        echo json_encode($data);
    }

    public function do_done(){
        $user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        
        $data['do_done'] = $this->M_monitoringsalesorder->do_done();
        $this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('MonitoringSalesOrder/V_Done', $data);
		$this->load->view('V_Footer', $data);
    }

    public function do_detail($order_number){
        $user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['detail'] = $this->M_monitoringsalesorder->do_detail($order_number);
        $this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('MonitoringSalesOrder/V_DetailTransaksi', $data);
		$this->load->view('V_Footer', $data);
    }

    public function do_detail_done($order_number){
        $user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['detail'] = $this->M_monitoringsalesorder->do_detail_done($order_number);
        $this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('MonitoringSalesOrder/V_DetailTransaksi', $data);
		$this->load->view('V_Footer', $data);
        
    }

    public function do_print($order_number){
        $data['detail'] = $this->M_monitoringsalesorder->do_detail_done($order_number);
        $this->load->view('MonitoringSalesOrder/V_Print', $data);
    }

    public function fetch_count(){
        $data = $this->M_monitoringsalesorder->fetch_count();
        echo json_encode($data);
    }

    public function move_done(){
        $order_number = $_POST['order_number'];
        $data['detail'] = $this->M_monitoringsalesorder->select_item($order_number);
        
        foreach($data['detail'] as $key => $detail){
            $this->M_monitoringsalesorder->insert_done($detail['SO_HEADER_ID'],$detail['ORDER_NUMBER'],$detail['KODE_BARANG'],$detail['NAMA_BARANG'],$detail['QTY'],$detail['UOM'],$detail['LOKASI']);
        }
        echo 1;
    }
}
