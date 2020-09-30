<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_ItemIntransit extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MonitoringGdSparepart/M_monitoring');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Monitoring Item Intransit';
		$data['Menu'] = 'Monitoring Item Intransit';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringGdSparepart/V_ItemIntransit', $data);
		$this->load->view('V_Footer',$data);
    }
    
    public function searchdata(){
        $param = $this->input->post('param');

        if ($param == 'from') {
            $tujuan = "AND ms.from_subinventory = 'SP-YSP'";
        }else {
            $tujuan = "AND ms.to_subinventory = 'SP-YSP'";
        }

        $data['data'] = $this->M_monitoring->getDataItemIntransit($tujuan);
        // echo "<pre>";print_r($data['data']);exit();
        $this->load->view('MonitoringGdSparepart/V_TblItem', $data);


    }
}