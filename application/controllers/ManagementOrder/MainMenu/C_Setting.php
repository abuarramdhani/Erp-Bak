<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_Setting extends CI_Controller {
	
	function __construct()
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
		$this->load->model('ManagementOrder/M_setting');
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
			redirect();
		}
	}
	/***********************************************************
						SETTING MANAGEMENT ORDER 
	************************************************************/
	public function Taging()
	{
		
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Setup Order';
		$data['SubMenuTwo'] = 'Taging';
		$data['action'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['taging'] = $this->M_setting->selectTags();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManagementOrder/Setting/V_Taging', $data);
		$this->load->view('V_Footer',$data);
	}
	
	function saveTag(){
		$tag = $this->input->post('tag',true);
		$this->M_setting->saveTag($tag);
		$this->selectTag();
	}
	
	function updateTag(){
		$id = $this->input->post('id',true);
		$tag = $this->input->post('tag',true);
		$this->M_setting->updateTag($id,$tag);
		$this->selectTag();
	}
	
	function selectTag(){
		$select = $this->M_setting->selectTags();
		$no = 0;
		foreach($select as $row){
			$no++;
			echo "
				<tr>
					<td>".$no."</td>
					<td>".$row['tags']."</td>
					<td>
						<a class='btn btn-xs bg-maroon' onclick='removeTag(\"".site_url()."\",\"".$row['id']."\")'><span class='fa fa-remove'></span></a>
						<a class='btn btn-xs btn-warning' onclick='editTag(\"".$row['tags']."\",\"".$row['id']."\",\"".site_url()."\")'><span class='fa fa-edit'></span></a>
					</td>
				</tr>
			";
		}
	}
	
	function removeTag(){
		$tag = $this->input->post('tag',true);
		$this->M_setting->deleteTag($tag);
		$this->selectTag();
	}
	
	
	/***********************************************************
						SETTING PENJADWALAN
	************************************************************/
	
	public function ClassificationGroup()
	{
		
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Setup Scheduler';
		$data['SubMenuTwo'] = 'Classification Group';
		$data['Title'] = 'Setup Classification Group';
		$data['action'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['ClassificationGroup'] = $this->M_setting->select_class_group();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManagementOrder/Setting/ClassificationGroup/V_Index', $data);
		$this->load->view('V_Footer',$data);
	}
	
	function CreateClassificationGroup(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Setup Scheduler';
		$data['SubMenuTwo'] = 'Classification Group';
		$data['Title'] = 'Setup Classification Group';
		$data['action'] = site_url('ManagementOrder/Setting/SaveClassificationGroup');
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['classification'] = $this->M_setting->selectClass();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManagementOrder/Setting/ClassificationGroup/V_Create', $data);
		$this->load->view('V_Footer',$data);
	}
	
	function SaveClassificationGroup(){
		$date = $this->input->post('hdnDate');
		$user = $this->input->post('hdnUser');
		$cl_group = $this->input->post('txtClassificationGroup');
		
		$check_cl = $this->M_setting->check_class_group($cl_group);
		if(empty($check_cl)){
			    $data = array(
					'classification_group' 	=> $cl_group,
					'creation_date'	=>  $date,
					'created_by'	=>  $user
				);
				
				$this->M_setting->save_class_group($data);
				$insert_id = $this->db->insert_id();
				
				
				$menu_id = $this->input->post('slcMenu');
				$menu_sequence = $this->input->post('txtMenuSequence');
				$menu_prompt = $this->input->post('txtMenuPrompt');
				
				foreach($menu_id as $i=>$loop){
					$data_menu[$i] = array(
						'classification_id' 		=> $menu_id[$i],
						'classification_sequence' 			=> $menu_sequence[$i],
						'prompt' 					=> $menu_prompt[$i],
						'classification_level' 				=> 1,
						'classification_group_id' 	=> $insert_id,
						'created_date' 				=> $this->input->post('hdnDate'),
						'creation_by' 				=> $this->input->post('hdnUser')
					);
					$this->M_setting->saveClassificationGroupList($data_menu[$i]);
				}
		}else{
			"session_duplicate_class";
		}
		
		redirect('ManagementOrder/Setting/ClassificationGroup');
	}
	
	public function UpdateClassificationGroup($id,$grup_list_id= "")
	{	$user_id = $this->session->userid;
		
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Setup Scheduler';
		$data['SubMenuTwo'] = 'Classification Group';
		$data['Title'] = 'Setup Classification Group';
		$data['action'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		// $data['Responsibility'] = $this->M_responsibility->getResponsibility();
		
		
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		
		$plaintext_string2 = str_replace(array('-', '_', '~'), array('+', '/', '='), $grup_list_id);
		$plaintext_string2 = $this->encrypt->decode($plaintext_string2);
		
		if($grup_list_id== ""){
			// $root_id = NULL;
			
			$data['MenuGroup'] = $this->M_setting->getClassificationGroup($plaintext_string);
			$data['MenuGroupList'] = $this->M_setting->getClassificationGroupList($plaintext_string);
		}else{
			// $root_id = $plaintext_string2;
			
			$data['MenuGroup'] = $this->M_setting->getClassificationGroupList(FALSE,$plaintext_string2);
			$data['MenuGroupList'] = $this->M_setting->getClassificationGroupListSub($plaintext_string2);
		}
		$data['Class'] = $this->M_setting->selectClass();
		$data['id'] = $id;
		$data['grup_list_id'] = $grup_list_id;
		
		$this->form_validation->set_rules('txtMenuGroupName', 'menugroup', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('ManagementOrder/Setting/ClassificationGroup/V_update',$data);
				$this->load->view('V_Footer',$data);
		}
		else
		{	
			$menu_id = $this->input->post('slcMenu');
			$menu_group_list_id = $this->input->post('hdnMenuGroupListId');
			
			$menu_id = $this->input->post('slcMenu');
			$menu_sequence = $this->input->post('txtMenuSequence');
			$menu_prompt = $this->input->post('txtMenuPrompt');
			$menu_level = $this->input->post('txtMenuLevel');
			
			foreach($menu_id as $i=>$loop){
				$data_menu[$i] = array(
					'classification_id' 			=> empty($menu_id[$i]) ? NULL : $menu_id[$i],
					'classification_sequence' 	=> $menu_sequence[$i],
					'prompt' 			=> empty($menu_prompt[$i]) ? NULL : $menu_prompt[$i],
					'classification_level' 		=> $menu_level[$i],
					'classification_group_id' 	=> $plaintext_string,
					'last_update_date' 	=> $this->input->post('hdnDate'),
					'last_updated_by' 	=> $this->input->post('hdnUser'),
					'created_date' 	=> $this->input->post('hdnDate'),
					'creation_by' 		=> $this->input->post('hdnUser')
				);
				
				if(count($menu_sequence) > 0){
					if($menu_group_list_id[$i]==0){
						unset($data_menu[$i]['last_update_date']);
						unset($data_menu[$i]['last_updated_by']);
						$this->M_setting->setMenuGroupList($data_menu[$i]);
					}else{
						unset($data_menu[$i]['creation_date']);
						unset($data_menu[$i]['created_by']);
						$this->M_setting->updateMenuGroupList($data_menu[$i],$menu_group_list_id[$i]);
					}
				}
			}
			redirect('ManagementOrder/Setting/ClassificationGroup');
		}
	}
	
	public function Classification()
	{
		
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Setup';
		$data['SubMenuOne'] = 'Setup Scheduler';
		$data['SubMenuTwo'] = 'Classification';
		$data['Title'] = 'Setup Classification';
		$data['action'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['data'] = $this->M_setting->selectClass();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManagementOrder/Setting/Classification/V_Index', $data);
		$this->load->view('V_Footer',$data);
	}
	
	function saveClass(){
		$date = date("Y-m-d H:i:s");
		$user = $this->session->userid;
		$class_ = $this->input->post('class_',true);
		$this->M_setting->saveClass($class_,$date,$user);
		$this->selectClass();
	}
	
	function updateClass(){
		$id = $this->input->post('id',true);
		$class_ = $this->input->post('class_',true);
		$user_id = $this->session->userid;
		$date = date("Y-m-d H:i:s");
		$this->M_setting->updateClass($id,$class_,$user_id,$date);
		$this->selectClass();
	}
	
	function removeClass(){
		$class_ = $this->input->post('class_',true);
		$this->M_setting->deleteClass($class_);
		$this->selectClass();
	}	
	function selectClass(){
		$select = $this->M_setting->selectClass();
		$no = 0;
		foreach($select as $row){
			$no++;
			echo "
				<tr>
					<td>".$no."</td>
					<td>".$row['classification']."</td>
					<td>
						<a class='btn btn-xs bg-maroon' onclick='removeClass(\"".site_url()."\",\"".$row['id']."\")'><span class='fa fa-remove'></span></a>
						<a class='btn btn-xs btn-warning' onclick='editClass(\"".$row['classification']."\",\"".$row['id']."\",\"".site_url()."\")'><span class='fa fa-edit'></span></a>
					</td>
				</tr>
			";
		}
	}
	
}
