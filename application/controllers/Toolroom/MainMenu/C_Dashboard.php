<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Dashboard extends CI_Controller {

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
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('Toolroom/MainMenu/M_master_item');
		 $this->load->library(array('Excel/PHPExcel','Excel/PHPExcel/IOFactory'));
		 date_default_timezone_set("Asia/Bangkok");
        // $this->load->library(array('Excel/PHPExcel','Excel/PHPExcel/IOFactory'));
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
    }
	
	//HALAMAN MASTER ITEM
	public function index(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		$data['Title'] = 'Minimal Stock Item';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Toolroom/MainMenu/Dashboard/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function send_email($to, $subject, $message) {
		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'mail.gmx.com',
			'smtp_port' => 587,
			'smtp_user' => 'myself@gmx.com',
			'smtp_pass' => 'PASSWORD',
			'smtp_crypto' => 'tls',
			'smtp_timeout' => '20',
			'mailtype'  => 'html', 
			'charset'   => 'iso-8859-1'
		);
		$config['newline'] = "\r\n";
		$config['crlf'] = "\r\n";
		$this->CI->load->library('email', $config);
		$this->CI->email->from('myself@gmx.com', 'Admin');
		$this->CI->email->to($to);
		$this->CI->email->subject($subject);
		$this->CI->email->message($message);

		//$this->email->send();
		if ( ! $this->CI->email->send()) {
			return false;
		}
		return true;
	}
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
}
