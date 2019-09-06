<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class C_VBTokoQuick extends CI_Controller{
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
		$this->load->model('VBTokoQuick/M_vbtokoquick');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		date_default_timezone_set('Asia/Jakarta');
		  
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
		$this->load->view('V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function dashboard()
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
		$this->load->view('VBTokoQuick/V_dashboard',$data);
		$this->load->view('V_Footer',$data);
	}

	public function proses()
	{ 
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		

		$main_url = 'http://192.168.168.8/bca/bca_inq_va.php';
		$method = 'GET';
		
		$parameters = array(
			'vaNum' => $_POST['number'],
		);	
		$path = '?'. http_build_query($parameters);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $main_url.$path);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Ignore Verify SSL Certificate
		curl_setopt_array($ch, array(
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLINFO_HEADER_OUT => TRUE,
		));
		$output = curl_exec($ch); // This is API Response
		$info =  curl_getinfo($ch);
		curl_close($ch);

		$hasilArray = json_decode($output, TRUE);
		$data['hasilArray'] = $hasilArray;
		// echo"<pre>";print_r ($hasilArray);exit();
		// echo"<pre>";print_r ($hasilAray['TransactionData'][0]);
	
		$this->load->view('VBTokoQuick/V_proses',$data);
		
	}


}
?>