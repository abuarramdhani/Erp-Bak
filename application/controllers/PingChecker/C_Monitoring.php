<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Monitoring extends CI_Controller {

    function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
        $this->load->helper('html');
		$this->load->model('SystemAdministration/MainMenu/M_user');        
		$this->load->model('PingChecker/M_index');

		date_default_timezone_set("Asia/Bangkok");
    }

    public function checkSession()
	{
		if($this->session->is_logged){
			
		}else{
			redirect();
		}
	}
    
    public function Penanganan()
    {
        $this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Monitoring';
		$data['SubMenuOne'] = 'Input Penanganan';

		$user = $this->session->user;

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['ip'] = $this->M_index->getDataIPDown();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PingChecker/V_Penanganan',$data);
		$this->load->view('V_Footer',$data);
    }

    public function saveData()
    {
        $ip = $this->input->post('slcIPIPM');
        $action = $this->input->post('actionIPM');
        $ticket = $this->input->post('ticketIPM');
        $noind = $this->session->user;

        $data = array(
                        'creation_date' => 'now()',
                        'ip' => $ip,
                        'action' => $action,
                        'no_ticket' => $ticket,
                        'action_by' => $noind,
                     );
        
        $this->M_index->setStatus($data);

		redirect('PingChecker/Monitoring/Penanganan', 'refresh');

    }
}