<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Report extends CI_Controller {

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
		$this->load->model('Toolroom/Report/M_report');
		$this->load->library('excel');
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
	public function Transaction($msg=false){
		if($msg==null){
			$msg = "";
		}
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Report';
		$data['SubMenuOne'] = 'Report Transaction';
		$data['SubMenuTwo'] = '';
		$data['Title'] = 'Report Transaction';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['msg'] = $msg;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Toolroom/Report/V_Report_Transaction',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function SearchReportTransaction(){
		$periode = $this->input->post('txtPeriode',true);
		$shift = $this->input->post('txsShift',true);
		
		$str_dt = $periode;
		$str_end = $periode;
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Report';
		$data['SubMenuOne'] = 'Report Transaction';
		$data['SubMenuTwo'] = '';
		$data['Title'] = 'Report Transaction';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['RecordTransaction'] = $this->M_report->SearchTransaction($shift,$str_dt,$str_end);
		if(empty($data['RecordTransaction'])){
			redirect('Toolroom/Report/Transaction/null');
		}
		$data['periode'] = str_replace(" ","",$periode);
		$data['shift'] = $shift;
		$data['msg'] = "";
		$data['str_dt'] = $str_dt;
		$data['str_end'] = $str_end;
		$data['shift'] = $shift;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Toolroom/Report/V_Report_Transaction',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function ExportExcelTransaction($shift){
		$periode = $this->input->get('periode',true);
		$str_dt = $periode;
		$str_end = $periode;
		$data['RecordTransaction'] = $this->M_report->SearchTransaction($shift,$str_dt,$str_end);
		$data['periode'] = str_replace(" ","",$periode);
		$data['shift'] = $shift;
		$this->load->view('Toolroom/Report/Excel/V_Excel_Transaction',$data);
	}
	
	
		public function Stok($msg=false){
		if($msg==null){
			$msg = "";
		}
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Report';
		$data['SubMenuOne'] = 'Report Stock';
		$data['SubMenuTwo'] = '';
		$data['Title'] = 'Report Stok';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['msg'] = "";
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Toolroom/Report/V_Report_Stok',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function SearchReportStok(){
		$periode = $this->input->post('txtPeriode',true);
		$shift = $this->input->post('txsShift',true);
		
		$str_dt = $periode;
		$str_end = $periode;
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Report';
		$data['SubMenuOne'] = 'Report Stock';
		$data['SubMenuTwo'] = '';
		$data['Title'] = 'Report Stok';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['RecordStok'] = $this->M_report->SearchStok($shift,$str_dt,$str_end);
		$data['str_dt'] = $str_dt;
		$data['str_end'] = $str_end;
		$data['shift'] = $shift;
		if(empty($data['RecordStok'])){
			redirect('Toolroom/Report/Stok/null');
		}
		$data['periode'] = str_replace(" ","",$periode);
		$data['shift'] = $shift;
		$data['msg'] = "";
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Toolroom/Report/V_Report_Stok',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function ExportExcelStok($shift){
		$periode = $this->input->get('periode',true);
		$str_dt = $periode;
		$str_end = $periode;
		$data['RecordStok'] = $this->M_report->SearchStok($shift,$str_dt,$str_end);
		$data['periode'] = str_replace(" ","",$periode);
		$data['shift'] = $shift;
		$this->load->view('Toolroom/Report/Excel/V_Excel_Stok',$data);
	}
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
}
