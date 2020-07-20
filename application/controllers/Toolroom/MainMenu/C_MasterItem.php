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
	public function Usable(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Master Item';
		$data['SubMenuOne'] = 'Usable';
		$data['SubMenuTwo'] = 'Toolkit';
		$data['Title'] = 'Usable Item';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['AllUsableItem'] = $this->M_master_item->getItemUsable();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Toolroom/MainMenu/MasterItem/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}
	
	function CreateUsableItem($message = NULL){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Master Item';
		$data['SubMenuOne'] = 'Usable';
		$data['SubMenuTwo'] = 'Toolkit';
		$data['Title'] = 'Create Usable Item';
		
		$data['message'] = $message;
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['AllUsableItem'] = $this->M_master_item->getItemUsable();
		$data['AllUsableItemGroup'] = $this->M_master_item->getGroupItemUsable();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Toolroom/MainMenu/MasterItem/V_Create',$data);
		$this->load->view('V_Footer',$data);
	}
	
	function saveCreateUsableItem(){
		$this->form_validation->set_rules('txtTool', 'toolname', 'required');
		$qty = $this->input->post('txtQuantity');
		if($qty == null){
			$qty = null;
		}
		$qty_min = $this->input->post('txtStockOpname');
		if($qty_min == null){
			$qty_min = null;
		}
		$group = $this->input->post('txtGroupItem');
		if($group == null){
			$group = null;
		}
		
		if ($this->form_validation->run() === FALSE)
		{
			redirect('Toolroom/MasterItem/Usable');
		}else{
			$id = strtoupper($this->input->post('txtBarcodeId'));
			$check = $this->M_master_item->check_item($id);
			if($check){
				$data = array(
					'item_name'		=> strtoupper($this->input->post('txtTool')),
					'item_qty'		=> $qty,
					'item_qty_min'	=> $qty_min,
					'item_desc'		=> $this->input->post('txtDesc'),
					'creation_date'	=>  $this->input->post('hdnDate'),
					'created_by'	=>  $this->input->post('hdnUser'),
					'item_group_id'	=>  $group
				);
				$this->M_master_item->updateUsableItem($data,$id);
			}else{
				$data = array(
					'item_id' 	=> $id,
					'item_name'		=> strtoupper($this->input->post('txtTool')),
					'item_qty'		=> $qty,
					'item_qty_min'	=> $qty_min,
					'item_desc'		=> $this->input->post('txtDesc'),
					'creation_date'	=>  $this->input->post('hdnDate'),
					'created_by'	=>  $this->input->post('hdnUser'),
					'item_group_id'	=>  $group
				);
				$this->M_master_item->saveUsableItem($data);
			}
			
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
		$data['SubMenuTwo'] = 'Toolkit';
		$data['Title'] = 'Import Usable Item';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['AllUsableItem'] = $this->M_master_item->getItemUsable();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Toolroom/MainMenu/MasterItem/V_Import',$data);
		$this->load->view('V_Footer',$data);
	}
	
	function importCreateUsableItem(){
		$this->load->library('upload');
		
		$config['upload_path'] = 'assets/upload/';
		$config['allowed_types'] = 'xlsx';
		$config['max_size']      = '100000';
		$config['overwrite']     = TRUE;
		$config['file_name']     = "master-item-Toolroom";

		$doc_name	= "master-item-Toolroom";

		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload('fileScan')){
			$error = array('error' => $this->upload->display_errors());
			print_r($error);
		}else{
			$inputFileName = 'assets/upload/master-item-Toolroom.xlsx';
        try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
			} catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            }
			$sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
			for ($row = 2; $row <= $highestRow; $row++){                  //  Read a row of data into an array                 
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                $check = $this->M_master_item->getItemUsable($rowData[0][0]);
				if($check){
					$data = array(
						"item_name"=> $rowData[0][1],
						"item_barcode"=> $rowData[0][2],
						"item_group_id"=> $rowData[0][3],
						"item_qty"=> $rowData[0][4],
						"item_qty_min"=> $rowData[0][5],
						"item_desc"=> $rowData[0][6],
						"last_update_date"=> date('Y-m-d H:i:s'),
						"last_updated_by"=> $this->session->userid
					);
					 
					$insert = $this->M_master_item->updateUsableItem($data,$rowData[0][0]);
				}else{
					$data = array(
						"item_id"=> $rowData[0][0],
						"item_name"=> $rowData[0][1],
						"item_barcode"=> $rowData[0][2],
						"item_group_id"=> $rowData[0][3],
						"item_qty"=> $rowData[0][4],
						"item_qty_min"=> $rowData[0][5],
						"item_desc"=> $rowData[0][6],
						"creation_date"=> date('Y-m-d H:i:s'),
						"created_by"=> $this->session->userid
					);
					 
					$insert = $this->M_master_item->saveUsableItem($data);
				}
            }
			unlink($inputFileName);
		}
		redirect('Toolroom/MasterItem/Usable');
	}
	
	function UpdateItemUsable($id){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Master Item';
		$data['SubMenuOne'] = 'Usable';
		$data['SubMenuTwo'] = 'Toolkit';
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
			$this->load->view('Toolroom/MainMenu/MasterItem/V_Update',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$qty = $this->input->post('txtQuantity');
			if($qty == null){
				$qty = null;
			}
			$qty_min = $this->input->post('txtStockOpname');
			if($qty_min == null){
				$qty_min = null;
			}
			$data = array(
					'item_name'		=> strtoupper($this->input->post('txtTool')),
					'item_qty'		=> $qty,
					'item_qty_min'		=> $qty_min,
					'item_desc'		=> $this->input->post('txtDesc'),
					'last_update_date'	=>  $this->input->post('hdnDate'),
					'last_updated_by'	=>  $this->input->post('hdnUser')
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
	
	//HALAMAN MASTER ITEM GROUP
	
	public function UsableGroup(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Master Item';
		$data['SubMenuOne'] = 'Usable';
		$data['SubMenuTwo'] = 'Group Toolkit';
		$data['Title'] = 'Usable Group Item';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['AllUsableItemGroup'] = $this->M_master_item->getGroupItemUsable();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Toolroom/MainMenu/MasterItemGroup/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function CreateUsableItemGroup(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Master Item';
		$data['SubMenuOne'] = 'Usable';
		$data['SubMenuTwo'] = 'Group Toolkit';
		$data['Title'] = 'Usable Group Item';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['AllUsableItemGroup'] = $this->M_master_item->getGroupItemUsable();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Toolroom/MainMenu/MasterItemGroup/V_Create',$data);
		$this->load->view('V_Footer',$data);
	}
	
	function saveCreateUsableItemGroup(){
		$this->form_validation->set_rules('txtGroupName', 'toolname', 'required');
		if ($this->form_validation->run() === FALSE)
		{
			redirect('Toolroom/MasterItem/UsableGroup');
		}else{
			$data = array(
					'item_group' 	=> $this->input->post('txtGroupName'),
					'item_group_desc'	=> $this->input->post('txtDesc'),
					'creation_date'	=>  $this->input->post('hdnDate'),
					'created_by'	=>  $this->input->post('hdnUser')
				);
				
			$this->M_master_item->saveUsableItemGroup($data);
			$message = '<div class="row"> <div class="col-md-12 " style="margin-top: 10px">
                           <div id="eror" class="alert alert-dismissible " role="alert" style="background-color:#3cbc81; text-align:center; color:white; "><b>Input Success!</b></div>
                      </div>';
			redirect('Toolroom/MasterItem/UsableGroup');
		}			
	}
	
	function RemoveGroupItemUsable($id){
		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		
		$this->M_master_item->deleteUsableItemGroup($plaintext_string);
		redirect('Toolroom/MasterItem/UsableGroup');
	}
	
	function UpdateGroupItemUsable($id){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Master Item';
		$data['SubMenuOne'] = 'Usable';
		$data['SubMenuTwo'] = 'Group Toolkit';
		$data['Title'] = 'Update Usable Item';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		
		$data['AllUsableItemGroup'] = $this->M_master_item->getGroupItemUsable($plaintext_string);
		$data['id'] = $id;
		
		$this->form_validation->set_rules('txtGroupName', 'toolname', 'required');
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('Toolroom/MainMenu/MasterItemGroup/V_Update',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$data = array(
					'item_group' 	=> $this->input->post('txtGroupName'),
					'item_group_desc' 	=> $this->input->post('txtDesc'),
					'last_update_date'	=>  $this->input->post('hdnDate'),
					'last_updated_by'	=>  $this->input->post('hdnUser')
				);
				
			$this->M_master_item->updateUsableGroupItem($data,$plaintext_string);
			redirect('Toolroom/MasterItem/UsableGroup');
		}
	}
	
	function ListGroupItemUsable($id){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		
		$data['Menu'] = 'Master Item';
		$data['SubMenuOne'] = 'Usable';
		$data['SubMenuTwo'] = 'Toolkit';
		$data['Title'] = 'Usable Item';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['AllUsableItem'] = $this->M_master_item->getListGroupItemUsable($plaintext_string);
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Toolroom/MainMenu/MasterItemGroup/V_View',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
}
