<?php defined('BASEPATH') or exit('No direct script access allowed');
class C_Undeliver extends CI_Controller
{
	
	function __construct()
		{
			parent::__construct();
			$this->load->helper('form');
	        $this->load->helper('url');
	        $this->load->helper('html');
	        $this->load->library('form_validation');
	        //load the login model
			$this->load->library('session');
			$this->load->model('RekapLppb/RekapLppbView/M_undeliver');
			$this->load->model('SystemAdministration/MainMenu/M_user');
			  
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
		        
		public function index(){
			$this->checkSession();
			$user_id = $this->session->userid;
            $data['Title'] = 'Undeliver';
			$data['Menu'] = 'Undeliver';
			$data['SubMenuOne'] = '';
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
    
            $data['bulan'] = date('M-Y');

			// $month = strtoupper(date("M"));
			// $year = strtoupper(date("Y"));
			// $data['monthnow'] = ".$month.";

			// $navbulan = array(
			// 	array("1","bln" => "DEC","mon" => "DEC-$year","selisih" => ""),
			// 	array("2","bln" => "NOP","mon" => "NOP-$year","selisih" => ""),
			// 	array("3","bln" => "OCT","mon" => "OCT-$year","selisih" => ""),
			// 	array("4","bln" => "SEP","mon" => "SEP-$year","selisih" => ""),
			// 	array("5","bln" => "AUG","mon" => "AUG-$year","selisih" => ""),
			// 	array("6","bln" => "JUL","mon" => "JUL-$year","selisih" => ""),
			// 	array("7","bln" => "JUN","mon" => "JUN-$year","selisih" => ""),
			// 	array("8","bln" => "MAY","mon" => "MAY-$year","selisih" => ""),
			// 	array("9","bln" => "APR","mon" => "APR-$year","selisih" => ""),
			// 	array("10","bln" => "MAR","mon" => "MAR-$year","selisih" => ""),
			// 	array("11","bln" => "FEB","mon" => "FEB-$year","selisih" => ""),
			// 	array("12","bln" => "JAN","mon" => "JAN-$year","selisih" => "")
			// );

			// for ($i=0; $i <count($navbulan) ; $i++) { 
			// 	$prmbulan = $navbulan[$i]['mon'];
			// 	$hasil = $this->M_monitoring->getSelisih($prmbulan);
			// 	if ($hasil != null) {
			// 		$navbulan[$i]['selisih'] = $hasil['0']['SELISIH'];
			// 	}
			// } 
			// $data['navbulan']= $navbulan;
			// $prmmonth = strtoupper(date("M-Y"));
			// $data['data'] = $this->M_monitoring->getDataRekap($prmmonth);
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('RekapLppb/RekapLppbView/V_Undeliver',$data);
			$this->load->view('V_Footer',$data);
	
		}

		public function searchData(){
            $bulan = $this->input->post('bulan');
            $prmmonth = strtoupper($bulan);
            $data['data'] = $this->M_undeliver->getDataRekap($prmmonth);
            // echo "<pre>"; print_r($bulan);exit();
			$this->load->view('RekapLppb/RekapLppbView/V_TblUndeliver', $data);
		}

}