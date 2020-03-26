<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_MasterUnitGroupDetail extends CI_Controller {

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
		$this->load->model('JurnalPenilaian/M_unitgroupdetail');
		$this->load->model('JurnalPenilaian/M_unitgroup');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
    }
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}

	//HALAMAN INDEX
	public function index(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Master Distribution';
		$data['SubMenuOne'] = 'Master Unit Group Detail';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['number'] = 1;
		$data['no'] = 1;
		$data['GetUnitGroupDetail'] = $this->M_unitgroupdetail->GetUnitGroupDetail();
		$data['GetUnitGroup'] 		= $this->M_unitgroup->GetUnitGroup();
		$idUnitDetail				= $this->input->post('txtIdUnitDetail');
		// echo "<pre>";
		// var_dump($_POST);
		// print_r($data);
		// echo "</pre>";
		// exit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/MasterDistribution/MasterUserGroupDetail/V_Index',$data);
		$this->load->view('V_Footer',$data);
		
	}
	// HALAMAN CREATE
	public function create($idUnitGroup){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Create';
		$data['SubMenuOne'] = 'Master Unit Group Detail';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['GetUnitGroupCreate']=$this->M_unitgroupdetail->GetUnitGroupCreate($idUnitGroup);
		$data['GetSectionGroup']=$this->M_unitgroupdetail->GetSectionGroup();
		$data['number'] = 1;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/MasterDistribution/MasterUserGroupDetail/V_Create',$data);
		$this->load->view('V_Footer',$data);	
	}

	// ADD 
	public function add()
	{
		$date		= $this->input->post('txtDate');
		$IDUnit		= $this->input->post('txtIDUnitGroup');
		$NameUnit		= $this->input->post('txtUnitGroup');
		$unit = array();
		for ($i=0; $i < count($IDUnit); $i++) {
			$kd = explode("*",$this->input->post('txtUnitDetail'.$i));
			$kode[] 		= $kd[0];
			$unit[] 		= $kd[1];
			$b = implode(',', $kode[$i]);
			$a = implode(',', $unit[$i]);

			echo $a."<br>";
			// $dataInsert = array(
			// 	'id_unit_group' => $IDUnit[$i],
			// 	'unit'			=> $a,
			// 	'tberlaku'		=> $date,
			// 	'ttberlaku'		=> '9999-12-31',
			// 	'unit_group'	=> $NameUnit[$i],
			// 	'kodesie'		=> $b,
			// );
		// echo "<pre>";
		// print_r($dataInsert);
		// echo "</pre>";
		// exit();
			// $insertId = $this->M_unitgroupdetail->AddMaster($dataInsert);
		}

		// redirect('PenilaianKinerja/MasterUnitGroupDetail');
	}
	
	// DELETE
	public function delete($idUnitDetail)
	{	
		$this->M_unitgroupdetail->DeleteUnitGroupDetail($idUnitDetail);
		redirect('PenilaianKinerja/MasterUnitGroupDetail');
	}

	// VIEW
	public function view($idUnitDetail)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Create Penilaian';
		$data['SubMenuOne'] = 'Master Unit Group Detail';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['GetUnitGroupDetail'] = $this->M_unitgroupdetail->GetUnitGroupDetail($idUnitDetail);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/MasterDistribution/MasterUserGroupDetail/V_View',$data);
		$this->load->view('V_Footer',$data);	
	}

	// VIEW EDIT
	public function edit($idUnitDetail)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Create Penilaian';
		$data['SubMenuOne'] = 'Master Unit Group Detail';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['GetUnitGroupDetail'] = $this->M_unitgroupdetail->GetUnitGroupDetail($idUnitDetail);
		$data['GetUnitGroup']=$this->M_unitgroupdetail->GetUnitGroup();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('JurnalPenilaian/MasterDistribution/MasterUserGroupDetail/V_Edit',$data);
		$this->load->view('V_Footer',$data);	
	}

	// SAVE EDIT
	public function update($idUnitDetail)
	{	
		$idUnitDetail= $this->input->post('txtIdUnitDetail');
		$date		= $this->input->post('txtDate');
		$IDUnit		= $this->input->post('txtIDUnitGroup');
		$unit 		= $this->input->post('txtUnitDetail');

		$this->M_unitgroupdetail->Update($idUnitDetail,$date,$IDUnit,$unit);
		redirect('PenilaianKinerja/MasterUnitGroupDetail');
	}
//----------------------------------- JAVASCRIPT RELATED --------------------//
//----------------------------------- JAVASCRIPT RELATED --------------------//
	


}
