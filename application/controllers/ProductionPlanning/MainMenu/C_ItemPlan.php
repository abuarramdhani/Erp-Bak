<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_ItemPlan extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('Excel');
        $this->load->library('upload');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('ProductionPlanning/MainMenu/M_itemplan');
    }
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
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
		
		$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['itemData']		= $this->M_itemplan->getItemData();
		$data['no']				= 1;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ProductionPlanning/MainMenu/ItemPlan/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

    public function Create()
    {
        $this->form_validation->set_rules('txtServiceNumber', 'Service Number', 'required');
        $this->checkSession();
        $user_id = $this->session->userid;
        
        
        $data['UserMenu']       = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        
        if ($this->form_validation->run() === FALSE)
        {
            $data['Menu'] = 'Dashboard';
            $data['SubMenuOne'] = '';
            $data['SubMenuTwo'] = '';
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('ProductionPlanning/MainMenu/ItemPlan/V_Create',$data);
            $this->load->view('V_Footer',$data);
        }else{}
    }

    public function DownloadSample()
    {
        $this->load->helper('download');
        force_download('assets/upload/ProductionPlanning/item-data-plan.xls', NULL);
    }
}