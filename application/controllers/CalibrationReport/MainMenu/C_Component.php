<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Component extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('CalibrationReport/MainMenu/M_calibration');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->checkSession();
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
    }
	
	public function index()
	{
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['action'] = 'CalibrationReport/Calibration/newDocument';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CalibrationReport/MainMenu/V_Calibration', $data);
		$this->load->view('V_Footer',$data);
	}
	
	public function showDocument(){
		$data = $this->M_calibration->alldata();
		$output = array();
		$a=1;
		$i=0;
		
		foreach($data as $k => $value) {
			$output[] = array_values($value);
			$id = $output[$i][0];
			$kode = $output[$i][1];
			$nama = $output[$i][2];
			$act = "<a class='btn btn-xs bg-maroon btn-sm' title='View Data'  href='".site_url()."assets/upload/$id' target='blank'><i class='fa fa-search'></i></a>	
					<a class='btn btn-xs bg-navy btn-sm' title='Download Data'  href='".site_url()."C_Component/download/$id'><i class='fa fa-download'></i></a>
					<a class='btn btn-xs bg-purple btn-sm' title='Edit' href='".site_url()."C_Component/ediitdata/tampil/$id'><i class='fa fa-edit'></i></a>
					<a class='btn btn-xs bg-red btn-sm' title='Delete' href='".site_url()."C_Component/insert/delete/$id' onclick='return confirm()'><i class='fa fa-trash'></i></a>
			";
			array_shift($output[$i]);
			array_unshift($output[$i], "$a");
			array_push($output[$i], "$act");
				$a++;
			$i++;
		}
		echo json_encode(array('data' => $output));
	}
	
	public function newDocument(){
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['action'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CalibrationReport/MainMenu/V_Insert', $data);
		$this->load->view('V_Footer',$data);
	}
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect();
		}
	}
}
