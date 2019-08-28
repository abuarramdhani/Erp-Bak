<?php defined('BASEPATH') or exit('No direct script access allowed');
class C_Summary extends CI_Controller
{
	
	function __construct()
		{
			parent::__construct();
			$this->load->helper('form');
	        $this->load->helper('url');
	        $this->load->helper('html');
			$this->load->library('form_validation');
			$this->load->library('csvimport');
	        //load the login model
			$this->load->library('session');
			$this->load->model('M_Index');
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('PerhitunganLoadingODM/M_PerhitunganLoadingODM');
			$this->load->model('PerhitunganLoadingODM/M_summary');
			  
			if($this->session->userdata('logged_in')!=TRUE) {
				$this->load->helper('url');
				$this->session->set_userdata('last_page', current_url());
				$this->session->set_userdata('Responsbility', 'some_value');
			}

        }
        public function checkSession()
		{
				if ($this->session->is_logged) {
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

			$this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('PerhitunganLoadingODM/MainMenu/Summary/V_Summary',$data);
			$this->load->view('V_Footer',$data);
			// echo '<pre>';
			// print_r($data);
			// exit;

		}
	public function viewData()
	{
		$deptclass = $this->input->post('dept_class');
		$deptcode = $this->input->post('dept_code');
		// $monthPeriode = date('M-y', strtotime($this->input->post('monthPeriode')));
		$monthPeriode = date('y-M', strtotime($this->input->post('month_Periode')));
		$monthPeriode1 = explode('-', $monthPeriode);
		$year = $monthPeriode1[0];
		$month = $monthPeriode1[1];
		$monthPeriode2 = implode('-', [$month, $year]);
		// echo"<pre>";print_r($monthPeriode2);exit();
		//$datadt = $this->M_view->searchdata($available_op,$hari_kerja,$input_parameter,$deptclass,$deptcode,$monthPeriode);
		$data = array('dataform' =>  $this->M_summary->viewdata($deptclass,$deptcode,$monthPeriode2),
						'deptclass' => $deptclass,
						'deptcode' => $deptcode,
						'monthPeriode' => $monthPeriode2); 
		// echo"<pre>"; print_r($data); exit();
		$this->load->view('PerhitunganLoadingODM/MainMenu/Summary/V_Result',$data);
	}
}