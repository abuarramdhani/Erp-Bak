<?php defined('BASEPATH') or exit('No direct script access allowed');
class C_MonitoringAll extends CI_Controller
{
	
	function __construct()
		{
			parent::__construct();
			$this->load->helper('form');
	        $this->load->helper('url');
	        $this->load->helper('html');
	        $this->load->library('form_validation');
			$this->load->library('session');
			$this->load->model('M_Index');
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('MonitoringICT/MainMenu/MonitoringAll/M_monitoringall');
			  
			if($this->session->userdata('logged_in')!=TRUE) {
				$this->load->helper('url');
				$this->session->set_userdata('last_page', current_url());
				$this->session->set_userdata('Responsbility', 'some_value');
			}
		}

	public function checkSession()
		{
			if($this->session->is_logged){
				}else{
					redirect();
				}
		}

	public function index()
		{
			$this->checkSession();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$MonitoringPeriod = $this->M_monitoringall->getPeriodeMonitoring();
			$x = 0;
				$color  = array('box-primary' ,'box-success' ,'box-primary');
				$color2  = array('bg-primary' ,'bg-green' ,'bg-purple');
			foreach ($MonitoringPeriod as $MP) {
				$ResultMonitoring = $this->M_monitoringall->getHasil($MP['periode_monitoring_id']);
				$y = 0;
				foreach ($ResultMonitoring as $RM) {
					if ($RM['hasil_monitoring_id']) {
						$ResultMonitoring[$y]['aspek_hasil'] = $this->M_monitoringall->getDetailHasil($RM['hasil_monitoring_id']);
					}
						$ResultMonitoring[$y]['pic']         = $this->M_monitoringall->getPIC($RM['perangkat_id']);
					$y++;
				}
				$MonitoringPeriod[$x]['detail_period'] = $ResultMonitoring;
				$MonitoringPeriod[$x]['cls_tbl'] = $color[$x];
				$MonitoringPeriod[$x]['cls_tbl2'] = $color2[$x];
				$x++;
			}
			// echo "<pre>";
			// print_r($MonitoringPeriod);
			// echo "</pre>";
			// exit();
			$data['DataMonitoring'] = $MonitoringPeriod;
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MonitoringICT/MainMenu/MonitoringAll/V_MonitoringAll',$data);
			$this->load->view('V_Footer',$data);
		}
}