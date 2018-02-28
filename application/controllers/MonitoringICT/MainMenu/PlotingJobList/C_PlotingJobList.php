<?php defined('BASEPATH') OR exit('No direct script access allowed');
class C_PlotingJobList extends CI_Controller
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
			$this->load->model('MonitoringICT/MainMenu/PlotingJobList/M_plotingjobList');
			  
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
			$JobList = $this->M_plotingjobList->getJobList();
				$x = 0;
				foreach ($JobList as $JL) {
								$JobList[$x]['pic'] = $this->M_plotingjobList->getPIC($JL['perangkat_id']);
								$x++;
							}		
			// print_r($JobList);
			// exit();	
			$data['dataJoblist'] = $JobList;
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MonitoringICT/MainMenu/PlotingJobList/V_PlotingJobList',$data);
			$this->load->view('V_Footer',$data);
		}

	public function indexEdit($id)
		{
			$this->checkSession();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['pic'] = $this->M_plotingjobList->getPICAll(); 
			$data['period'] = $this->M_plotingjobList->getPeriod(); 
			$JobList = $this->M_plotingjobList->getJobList($id);
				$x = 0;
				foreach ($JobList as $JL) {
								$JobList[$x]['pic'] = $this->M_plotingjobList->getPIC($JL['perangkat_id']);
								$x++;
							}	
			$data['dataJoblist'] = $JobList;
			$data['id_perangkat'] = $id;
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MonitoringICT/MainMenu/PlotingJobList/V_EditPloting',$data);
			$this->load->view('V_Footer',$data);
		}

	public function saveEdit()
		{
			$perangkat_id = $this->input->post('idPerangkat');
			$periode      = $this->input->post('slcPeriod');
			$pic 		  = $this->input->post('slcPic[]');
			$PicNew = array();
			if ($pic != null) {
				foreach ($pic as $key) {
					$data = array('employee_id' => $key, 
								  'perangkat_id' => $perangkat_id,
								  'periode_monitoring_id' => $periode );
					$checkJob = $this->M_plotingjobList->getPlotExits($data);
					if ($checkJob == 0){
						$checkExist = $this->M_plotingjobList->getExist($key,$perangkat_id);
						if ($checkExist == 0) {
							$ins = $this->M_plotingjobList->InsertNew($data);
							$PicNew[] = $ins;
						}else{
							$upd = $this->M_plotingjobList->UpdateJob($key,$perangkat_id,$data);
							foreach ($upd as $value) {
								$PicNew[] = $value['ploting_id'];
							}
						}
					}else{
						$getIdPlot = $this->M_plotingjobList->getIdPlot($data);
						foreach ($getIdPlot as $idPlot) {
							$PicNew[] = $idPlot['ploting_id'];
						}
					}
				}
				$PicNew = implode(',', $PicNew);
				$this->M_plotingjobList->delPlot($PicNew,$perangkat_id);
			}else {
				$this->M_plotingjobList->delPlot2($perangkat_id);
			}
		$this->index();
		} 
}