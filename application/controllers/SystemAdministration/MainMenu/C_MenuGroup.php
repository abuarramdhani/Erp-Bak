<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_MenuGroup extends CI_Controller {

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
		  $this->load->model('SystemAdministration/MainMenu/M_menugroup');
		  $this->load->model('SystemAdministration/MainMenu/M_menu');
		  //$this->load->model('Setting/M_usermenu');
		  //$this->load->library('encryption');
		  $this->checkSession();
    }
	
	public function checkSession()
	{
		if($this->session->is_logged){
			//redirect('Home');
		}else{
			redirect('index');
		}
	}
	
	public function index()
	{
		
		//Data utama yang diperlukan untuk memanggil sebuah halaman
		$user = $this->session->username;
		//$data['HeaderMenu'] = $this->M_index->getSideMenuHeader($user);
		//$data['SubMenu'] = $this->M_index->getSideMenuSubHeader($user);
		$user_id = $this->session->userid;
		
		$data['Title'] = 'List Menu Group';
		$data['Menu'] = 'Menu';
		$data['SubMenuOne'] = 'Menu Group';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		//$data['SubMenuOne'] = 'user';
		
		//Variabel tambahan pada halaman index (data seluruh user)
		$data['MenuGroup'] = $this->M_menugroup->getMenuGroup();
		
		//Load halaman
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('SystemAdministration/MainMenu/MenuGroup/V_Index',$data);
		$this->load->view('V_Footer',$data);

	}
	
	public function CreateMenuGroup()
	{
		
		//Data utama yang diperlukan untuk memanggil sebuah halaman
		$user_id = $this->session->userid;
		
		$data['Title'] = 'Create Menu Group';
		$data['Menu'] = 'Menu';
		$data['SubMenuOne'] = 'Menu Group';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['Responsibility'] = $this->M_responsibility->getResponsibility();
		$data['Menu'] = $this->M_menu->getMenu();

		$this->form_validation->set_rules('txtMenuGroupName', 'menugroup', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{
				//$this->load->view('templates/header', $data);
				//Load halaman
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('SystemAdministration/MainMenu/MenuGroup/V_create',$data);
				$this->load->view('V_Footer',$data);
				//$this->load->view('templates/footer');

		}
		else
		{	
				$data = array(
					'menu_group_name' 	=> $this->input->post('txtMenuGroupName'),
					'creation_date'	=>  $this->input->post('hdnDate'),
					'created_by'	=>  $this->input->post('hdnUser')
				);
				
				$this->M_menugroup->setMenuGroup($data);
				$insert_id = $this->db->insert_id();
				
				$menu_id = $this->input->post('slcMenu');
				
				foreach($menu_id as $i=>$loop){
					$data_menu[$i] = array(
						'menu_id' 		=> $menu_id[$i],
						'menu_group_id' 	=> $insert_id,
						'creation_date' 	=> $this->input->post('hdnDate'),
						'created_by' 		=> $this->input->post('hdnUser')
					);
					$this->M_menugroup->setMenuGroupList($data_menu[$i]);
				}
				
				redirect('SystemAdministration/MenuGroup');
		}
		
		
		
		
	}
	
	public function UpdateMenuGroup($id)
	{	$user_id = $this->session->userid;
		
		$data['Title'] = 'Update Menu Group';
		$data['Menu'] = 'Menu';
		$data['SubMenuOne'] = 'Menu Group';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['Responsibility'] = $this->M_responsibility->getResponsibility();
		
		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		
		$data['MenuGroup'] = $this->M_menugroup->getMenuGroup($plaintext_string);
		$data['MenuGroupList'] = $this->M_menugroup->getMenuGroupList($plaintext_string);
		
		$data['Menu'] = $this->M_menu->getMenu();
		$data['id'] = $id;
		
		$this->form_validation->set_rules('txtMenuGroupName', 'menugroup', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{
				//$this->load->view('templates/header', $data);
				
				//Load halaman
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('SystemAdministration/MainMenu/MenuGroup/V_update',$data);
				$this->load->view('V_Footer',$data);

		}
		else
		{	
			$menu_id = $this->input->post('slcMenu');
			$menu_group_list_id = $this->input->post('hdnMenuGroupListId');
			
			foreach($menu_id as $i=>$loop){
				$data_menu[$i] = array(
					'menu_id' 		=> $menu_id[$i],
					'menu_group_id' 	=> $plaintext_string,
					'last_update_date' 	=> $this->input->post('hdnDate'),
					'last_updated_by' 	=> $this->input->post('hdnUser'),
					'creation_date' 	=> $this->input->post('hdnDate'),
					'created_by' 		=> $this->input->post('hdnUser')
				);
				
				if(count($menu_id) > 0){
					if($menu_group_list_id[$i]==0){
						unset($data_menu[$i]['last_update_date']);
						unset($data_menu[$i]['last_updated_by']);
						$this->M_menugroup->setMenuGroupList($data_menu[$i]);
					}else{
						unset($data_menu[$i]['creation_date']);
						unset($data_menu[$i]['created_by']);
						$MenuGroupList = $this->M_menugroup->getMenuGroupList($plaintext_string,$menu_group_list_id[$i]);
						if($data_menu[$i]['menu_id']!=$MenuGroupList[0]['menu_id']){
							$this->M_menugroup->updateMenuGroupList($data_menu[$i],$menu_group_list_id[$i]);
						}
					}
				}
			}
			 // print_r($data_menu);
			// print_r($MenuGroupList[0]['menu_id']);
			redirect('SystemAdministration/MenuGroup');
		}
			
		
	}
	
	
}
