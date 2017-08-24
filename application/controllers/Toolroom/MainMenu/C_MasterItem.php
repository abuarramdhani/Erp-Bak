<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_MasterItem extends CI_Controller {

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
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
    }
	
	//HALAMAN INDEX
	public function Usable(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Master Item';
		$data['SubMenuOne'] = 'Usable';
		$data['SubMenuTwo'] = '';
		$data['Title'] = 'Usable Item';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['AllUsableItem'] = $this->M_master_item->getItemUsable();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ToolRoom/MainMenu/MasterItem/V_Index',$data);
		$this->load->view('V_Footer',$data);
		
	}
	
	function CreateUsableItem($message = NULL){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Master Item';
		$data['SubMenuOne'] = 'Usable';
		$data['SubMenuTwo'] = '';
		$data['Title'] = 'Create Usable Item';
		
		$data['message'] = $message;
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['AllUsableItem'] = $this->M_master_item->getItemUsable();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ToolRoom/MainMenu/MasterItem/V_Create',$data);
		$this->load->view('V_Footer',$data);
	}
	
	function saveCreateUsableItem(){
		$this->form_validation->set_rules('txtTool', 'toolname', 'required');
		if ($this->form_validation->run() === FALSE)
		{
			redirect('Toolroom/MasterItem/Usable');
		}else{
			$data = array(
					'item_barcode' 	=> $this->input->post('txtBarcodeId'),
					'item_name'		=> $this->input->post('txtTool'),
					'item_qty'		=> $this->input->post('txtQuantity'),
					'item_so'	=> $this->input->post('txtStockOpname'),
					'item_desc'	=> $this->input->post('txtDesc'),
					'creation_date'	=>  $this->input->post('hdnDate'),
					'created_by'	=>  $this->input->post('hdnUser')
				);
				
			$this->M_master_item->saveUsableItem($data);
			$message = '<div class="row"> <div class="col-md-12 " style="margin-top: 10px">
                           <div id="eror" class="alert alert-dismissible " role="alert" style="background-color:#3cbc81; text-align:center; color:white; "><b>Input Success!</b></div>
                      </div>';
			$this->CreateUsableItem($message);
		}			
	}
	
	function ImportUsableItem(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Master Item';
		$data['SubMenuOne'] = 'Usable';
		$data['SubMenuTwo'] = '';
		$data['Title'] = 'Import Usable Item';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['AllUsableItem'] = $this->M_master_item->getItemUsable();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ToolRoom/MainMenu/MasterItem/V_Import',$data);
		$this->load->view('V_Footer',$data);
	}
	
	function importCreateUsableItem(){
		$config['upload_path'] = 'assets/upload/';
        $config['allowed_types'] = 'csv|xls|xlsx';
        $config['max_size'] = '10000';
        $this->load->library('upload', $config);
 
        if (!$this->upload->do_upload('importfile')) { 
			echo $this->upload->display_errors();
		}
        else 
		{  
        }
	}
	
	function UpdateItemUsable($id){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Master Item';
		$data['SubMenuOne'] = 'Usable';
		$data['SubMenuTwo'] = '';
		$data['Title'] = 'Update Usable Item';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['AllUsableItem'] = $this->M_master_item->getItemUsable();
		
		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		
		$data['AllUsableItem'] = $this->M_master_item->getItemUsable($plaintext_string);
		$data['id'] = $id;
		
		$this->form_validation->set_rules('txtTool', 'toolname', 'required');
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('ToolRoom/MainMenu/MasterItem/V_Update',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$data = array(
					'item_barcode' 	=> $this->input->post('txtBarcodeId'),
					'item_name'		=> $this->input->post('txtTool'),
					'item_qty'		=> $this->input->post('txtQuantity'),
					'item_so'		=> $this->input->post('txtStockOpname'),
					'item_desc'		=> $this->input->post('txtDesc'),
					'creation_date'	=>  $this->input->post('hdnDate'),
					'created_by'	=>  $this->input->post('hdnUser')
				);
				
			$this->M_master_item->updateUsableItem($data,$plaintext_string);
			redirect('Toolroom/MasterItem/Usable');
		}
	}
	
	function RemoveItemUsable($id){
		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		
		$this->M_master_item->deleteUsableItem($plaintext_string);
		redirect('Toolroom/MasterItem/Usable');
	}
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
}
