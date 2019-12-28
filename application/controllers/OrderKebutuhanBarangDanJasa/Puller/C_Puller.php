<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Puller extends CI_Controller {
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('OrderKebutuhanBarangDanJasa/Requisition/M_requisition');
		$this->load->model('OrderKebutuhanBarangDanJasa/Approver/M_approver');
		$this->load->model('OrderKebutuhanBarangDanJasa/Puller/M_puller');
        	  
		 if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
         }
        if($this->session->is_logged == FALSE){
            redirect();
        }
    }

    public function index()
	{   
		$user_id = $this->session->userid;
		
		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
     
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('OrderKebutuhanBarangDanJasa/V_Index',$data);
        $this->load->view('V_Footer',$data);
    }

    public function ListOrder()
	{   
        $user_id = $this->session->userid;
        $noind = $this->session->user;
		
		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = 'List Order';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['approver'] = $this->M_requisition->getPersonId($noind);
        $person_id = $data['approver'][0]['PERSON_ID'];

        $data['listOrder'] = $this->M_puller->getOrderToPulled();
     
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('OrderKebutuhanBarangDanJasa/Puller/V_ListOrderPuller',$data);
        $this->load->view('V_Footer',$data);
    }

    public function ListOrderNormal()
	{   
        $user_id = $this->session->userid;
        $noind = $this->session->user;
		
		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = 'List Normal Order';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['approver'] = $this->M_requisition->getPersonId($noind);
        $person_id = $data['approver'][0]['PERSON_ID'];

        $and = "AND ooh.URGENT_FLAG ='N' AND ooh.IS_SUSULAN ='N'";

        $data['listOrder'] = $this->M_puller->getOrderToPulled($and);

        $data['panelStatOrder'] = 'panel-success';
        $data['statOrder'] = 'Normal';
     
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('OrderKebutuhanBarangDanJasa/Puller/V_ListOrderPuller',$data);
        $this->load->view('V_Footer',$data);
    }

    public function ListOrderSusulan()
	{   
        $user_id = $this->session->userid;
        $noind = $this->session->user;
		
		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = 'List Susulan Order';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['approver'] = $this->M_requisition->getPersonId($noind);
        $person_id = $data['approver'][0]['PERSON_ID'];

        $and = "AND ooh.IS_SUSULAN ='Y'";

        $data['listOrder'] = $this->M_puller->getOrderToPulled($and);

        $data['panelStatOrder'] = 'panel-warning';
        $data['statOrder'] = 'Susulan';
     
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('OrderKebutuhanBarangDanJasa/Puller/V_ListOrderPuller',$data);
        $this->load->view('V_Footer',$data);
    }

    public function ListOrderUrgent()
	{   
        $user_id = $this->session->userid;
        $noind = $this->session->user;
		
		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = 'List Urgent Order';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['approver'] = $this->M_requisition->getPersonId($noind);
        $person_id = $data['approver'][0]['PERSON_ID'];

        $and = "AND ooh.URGENT_FLAG ='Y' AND ooh.IS_SUSULAN ='N'";

        $data['listOrder'] = $this->M_puller->getOrderToPulled($and);

        $data['panelStatOrder'] = 'panel-danger';
        $data['statOrder'] = 'Urgent';
     
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('OrderKebutuhanBarangDanJasa/Puller/V_ListOrderPuller',$data);
        $this->load->view('V_Footer',$data);
    }

    public function ReleaseOrder()
    {
        $noind = $this->session->user;

        $data['approver'] = $this->M_requisition->getPersonId($noind);
        $person_id = $data['approver'][0]['PERSON_ID'];

        $order_id = $_POST['order_id'];

        $pre_req = array(
                            'CREATED_BY' => $person_id,
                        );

        $pre_req_id = $this->M_puller->releaseOrder($pre_req);

        for ($i=0; $i < count($order_id); $i++) { 
            
            $order = array(
                            'PRE_REQ_ID' => $pre_req_id[0]['PRE_REQ_ID'],
                         );
            
            $this->M_puller->updateOrder($order_id[$i],$order);
        }
        

        echo 1;
    }

    public function ReleasedOrder()
    {
        $user_id = $this->session->userid;
        $noind = $this->session->user;
		
		$data['Menu'] = 'Released Order';
		$data['SubMenuOne'] = 'List Released Order';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['approver'] = $this->M_requisition->getPersonId($noind);
        $person_id = $data['approver'][0]['PERSON_ID'];

        $data['listOrder'] = $this->M_puller->getReleasedOrder($person_id);
        // echo '<pre>';
        // print_r($data['listOrder']);exit;
     
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('OrderKebutuhanBarangDanJasa/Puller/V_ReleasedOrderPuller',$data);
        $this->load->view('V_Footer',$data);
    }

    public function ShowDetailReleasedOrder()
    {
        $pre_req_id = $_POST['pre_req_id'];
        $data['listOrder'] = $this->M_puller->getDetailReleasedOrder($pre_req_id);
        $returnTable = $this->load->view('OrderKebutuhanBarangDanJasa/Puller/V_ReleasedOrderTable',$data, true);

        echo($returnTable);
    }
    
}
