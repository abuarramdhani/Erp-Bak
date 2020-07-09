<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_ReportGroup extends CI_Controller {

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
		  $this->load->library('encrypt');
		  $this->load->model('M_index');
		  $this->load->model('SystemAdministration/MainMenu/M_user');
		  $this->load->model('SystemAdministration/MainMenu/M_responsibility');
		  $this->load->model('SystemAdministration/MainMenu/M_reportgroup');
		  $this->load->model('SystemAdministration/MainMenu/M_report');
		  //$this->load->model('Setting/M_usermenu');
		  //$this->load->library('encryption');
		  $this->checkSession();
    }
	
	public function checkSession()
	{
		if($this->session->is_logged){
			//redirect('Home');
		}else{
			redirect('');
		}
	}
	
	public function index()
	{
		
		//Data utama yang diperlukan untuk memanggil sebuah halaman
		$user = $this->session->username;
		//$data['HeaderMenu'] = $this->M_index->getSideMenuHeader($user);
		//$data['SubMenu'] = $this->M_index->getSideMenuSubHeader($user);
		$user_id = $this->session->userid;
		
		$data['Title'] = 'List Report Group';
		$data['Menu'] = 'Report';
		$data['SubMenuOne'] = 'Report Group';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		//$data['SubMenuOne'] = 'user';
		
		//Variabel tambahan pada halaman index (data seluruh user)
		$data['ReportGroup'] = $this->M_reportgroup->getReportGroup();
		
		//Load halaman
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SystemAdministration/MainMenu/ReportGroup/V_Index',$data);
		$this->load->view('V_Footer',$data);

	}
	
	public function CreateReportGroup()
	{
		
		//Data utama yang diperlukan untuk memanggil sebuah halaman
		$user_id = $this->session->userid;
		
		$data['Title'] = 'Create Report Group';
		$data['Menu'] = 'Report';
		$data['SubMenuOne'] = 'Report Group';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['Responsibility'] = $this->M_responsibility->getResponsibility();
		$data['Report'] = $this->M_report->getReport();

		$this->form_validation->set_rules('txtReportGroupName', 'reportgroup', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{
				//$this->load->view('templates/header', $data);
				//Load halaman
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('SystemAdministration/MainMenu/ReportGroup/V_create',$data);
				$this->load->view('V_Footer',$data);
				//$this->load->view('templates/footer');

		}
		else
		{	
				$data = array(
					'report_group_name' 	=> $this->input->post('txtReportGroupName'),
					'creation_date'	=>  $this->input->post('hdnDate'),
					'created_by'	=>  $this->input->post('hdnUser')
				);
				
				$this->M_reportgroup->setReportGroup($data);
				$insert_id = $this->db->insert_id();
				
				$report_id = $this->input->post('slcReport');
				
				foreach($report_id as $i=>$loop){
					$data_report[$i] = array(
						'report_id' 		=> $report_id[$i],
						'report_group_id' 	=> $insert_id,
						'creation_date' 	=> $this->input->post('hdnDate'),
						'created_by' 		=> $this->input->post('hdnUser')
					);
					$this->M_reportgroup->setReportGroupList($data_report[$i]);
				}
				
				redirect('SystemAdministration/ReportGroup');
		}
		
		
		
		
	}
	
	public function UpdateReportGroup($id)
	{	$user_id = $this->session->userid;
		
		$data['Title'] = 'Update Report Group';
		$data['Menu'] = 'Report';
		$data['SubMenuOne'] = 'Report Group';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['Responsibility'] = $this->M_responsibility->getResponsibility();
		
		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		
		$data['ReportGroup'] = $this->M_reportgroup->getReportGroup($plaintext_string);
		$data['ReportGroupList'] = $this->M_reportgroup->getReportGroupList($plaintext_string);
		
		$data['Report'] = $this->M_report->getReport();
		$data['id'] = $id;
		
		$this->form_validation->set_rules('txtReportGroupName', 'reportgroup', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{
				//$this->load->view('templates/header', $data);
				
				//Load halaman
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('SystemAdministration/MainMenu/ReportGroup/V_update',$data);
				$this->load->view('V_Footer',$data);

		}
		else
		{	
			$report_id = $this->input->post('slcReport');
			$report_group_list_id = $this->input->post('hdnReportGroupListId');
			
			foreach($report_id as $i=>$loop){
				$data_report[$i] = array(
					'report_id' 		=> $report_id[$i],
					'report_group_id' 	=> $plaintext_string,
					'last_update_date' 	=> $this->input->post('hdnDate'),
					'last_updated_by' 	=> $this->input->post('hdnUser'),
					'creation_date' 	=> $this->input->post('hdnDate'),
					'created_by' 		=> $this->input->post('hdnUser')
				);
				
				if(count($report_id) > 0){
					if($report_group_list_id[$i]==0){
						unset($data_report[$i]['last_update_date']);
						unset($data_report[$i]['last_updated_by']);
						$this->M_reportgroup->setReportGroupList($data_report[$i]);
					}else{
						unset($data_report[$i]['creation_date']);
						unset($data_report[$i]['created_by']);
						$ReportGroupList = $this->M_reportgroup->getReportGroupList($plaintext_string,$report_group_list_id[$i]);
						if($data_report[$i]['report_id']!=$ReportGroupList[0]['report_id']){
							$this->M_reportgroup->updateReportGroupList($data_report[$i],$report_group_list_id[$i]);
						}
					}
				}
			}
			 // print_r($data_report);
			// print_r($ReportGroupList[0]['report_id']);
			redirect('SystemAdministration/ReportGroup');
		}
			
		
	}
	
	
}
