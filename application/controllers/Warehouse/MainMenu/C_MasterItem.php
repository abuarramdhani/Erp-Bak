<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_MasterItem extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('Warehouse/MainMenu/M_master_item');
		$this->load->model('Warehouse/MainMenu/M_masteritemconsumable');
		$this->load->library(array('Excel/PHPExcel','Excel/PHPExcel/IOFactory'));
		date_default_timezone_set("Asia/Bangkok");
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
    }
	
	//HALAMAN MASTER ITEM
	public function Usable(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Master Item';
		$data['SubMenuOne'] = 'Usable';
		$data['SubMenuTwo'] = 'Toolkit';
		$data['Title'] = 'Usable Item';
		$data['admin'] = $this->M_master_item->admin_check();

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['AllUsableItem'] = $this->M_master_item->getItemUsable();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Warehouse/MainMenu/MasterItem/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}
	
	function CreateUsableItem($message = NULL){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Master Item';
		$data['SubMenuOne'] = 'Usable';
		$data['SubMenuTwo'] = 'Toolkit';
		$data['Title'] = 'Create Usable Item';
		$data['admin'] = $this->M_master_item->admin_check();

		$data['message'] = $message;
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['AllUsableItem'] = $this->M_master_item->getItemUsable();
		$data['AllUsableItemGroup'] = $this->M_master_item->getGroupItemUsable();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Warehouse/MainMenu/MasterItem/V_Create',$data);
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
		
		// echo "<pre>";
		// var_dump($_POST);
		// exit();

		if ($this->form_validation->run() === FALSE)
		{
			redirect('Warehouse/MasterItem/Usable');
		}else{
			$id = strtoupper($this->input->post('idCount'));
			$check = $this->M_master_item->check_item($id);
			if($check){
				$data = array(
					'item_name'		=> strtoupper($this->input->post('txtTool')),
					'item_qty'		=> $qty,
					'item_qty_min'	=> $qty_min,
					'item_desc'		=> $this->input->post('txtDesc'),
					'creation_date'	=>  $this->input->post('hdnDate'),
					'created_by'	=>  $this->input->post('hdnUser'),
					'item_group_id'	=>  $group,
					'item_id' 		=> $this->input->post('txtBarcodeId'),
					'merk' 			=> $this->input->post('txtItemMerk')
				);

				$this->M_master_item->updateUsableItem($data,$id);
				redirect('Warehouse/MasterItem/Usable', 'refresh');
			}else{
				$data = array(
					'item_id' 	=> strtoupper($this->input->post('txtBarcodeId')),
					'item_name'		=> strtoupper($this->input->post('txtTool')),
					'item_qty'		=> $qty,
					'item_qty_min'	=> $qty_min,
					'item_desc'		=> $this->input->post('txtDesc'),
					'creation_date'	=>  $this->input->post('hdnDate'),
					'created_by'	=>  $this->input->post('hdnUser'),
					'item_group_id'	=>  $group,
					'merk' 			=> $this->input->post('txtItemMerk')
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
		$this->load->view('Warehouse/MainMenu/MasterItem/V_Import',$data);
		$this->load->view('V_Footer',$data);
	}
	
	function importCreateUsableItem(){
		$this->load->library('upload');
		
		$config['upload_path'] = 'assets/upload/';
		$config['allowed_types'] = 'xlsx';
		$config['max_size']      = '100000';
		$config['overwrite']     = TRUE;
		$config['file_name']     = "master-item-Warehouse";

		$doc_name	= "master-item-Warehouse";

		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload('fileScan')){
			$error = array('error' => $this->upload->display_errors());
			print_r($error);
		}else{
			$inputFileName = 'assets/upload/master-item-Warehouse.xlsx';
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
		redirect('Warehouse/MasterItem/Usable');
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
			$this->load->view('Warehouse/MainMenu/MasterItem/V_Update',$data);
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
			redirect('Warehouse/MasterItem/Usable');
		}
	}
	
	function RemoveItemUsable($id){
		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		
		$this->M_master_item->deleteUsableItem($plaintext_string);
		redirect('Warehouse/MasterItem/Usable');
	}
	
	//HALAMAN MASTER ITEM GROUP
	
	public function UsableGroup(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Master Item';
		$data['SubMenuOne'] = 'Usable';
		$data['SubMenuTwo'] = 'Group Toolkit';
		$data['Title'] = 'Usable Group Item';
		$data['admin'] = $this->M_master_item->admin_check();

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['AllUsableItemGroup'] = $this->M_master_item->getGroupItemUsable();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Warehouse/MainMenu/MasterItemGroup/V_Index',$data);
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
		$this->load->view('Warehouse/MainMenu/MasterItemGroup/V_Create',$data);
		$this->load->view('V_Footer',$data);
	}
	
	function saveCreateUsableItemGroup(){
		$this->form_validation->set_rules('txtGroupName', 'toolname', 'required');
		if ($this->form_validation->run() === FALSE)
		{
			redirect('Warehouse/MasterItem/UsableGroup');
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
			redirect('Warehouse/MasterItem/UsableGroup');
		}			
	}
	
	function RemoveGroupItemUsable($id){
		$plaintext_string=str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		
		$this->M_master_item->deleteUsableItemGroup($plaintext_string);
		redirect('Warehouse/MasterItem/UsableGroup');
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
			$this->load->view('Warehouse/MainMenu/MasterItemGroup/V_Update',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$data = array(
					'item_group' 	=> $this->input->post('txtGroupName'),
					'item_group_desc' 	=> $this->input->post('txtDesc'),
					'last_update_date'	=>  $this->input->post('hdnDate'),
					'last_updated_by'	=>  $this->input->post('hdnUser')
				);
				
			$this->M_master_item->updateUsableGroupItem($data,$plaintext_string);
			redirect('Warehouse/MasterItem/UsableGroup');
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
		$this->load->view('Warehouse/MainMenu/MasterItemGroup/V_View',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}

	public function Consumable()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Master Item Consumable';
		$data['Menu'] = 'Consumable';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		$data['admin'] = $this->M_master_item->admin_check();
		
		$data['UserMenu']		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['MasterItemConsumable'] = $this->M_masteritemconsumable->getMasterItemConsumable();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Warehouse/MainMenu/MasterItemConsumable/V_Index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function ConsumableCreate()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Master Item Consumable';
		$data['Menu'] = 'Consumable';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->form_validation->set_rules('txtItemCodeHeader', 'itemcode', 'required');
		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('Warehouse/MainMenu/MasterItemConsumable/V_create', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'item_name'		=> $this->input->post('txtItemNameHeader'),
				'item_qty'		=> $this->input->post('txtItemQtyHeader'),
				'item_qty_min'	=> $this->input->post('txtItemQtyMinHeader'),
				'item_desc'		=> $this->input->post('txaItemDescHeader'),
				'item_barcode'	=> '',
				'merk'			=> $this->input->post('txtItemMerk'),
				'creation_date' => 'NOW()',
				'created_by'	=> $this->session->userid,
				'item_code'		=> $this->input->post('txtItemCodeHeader'),
    		);
			$this->M_masteritemconsumable->setMasterItemConsumable($data);
			$header_id = $this->db->insert_id();

			redirect(site_url('Warehouse/MasterItem/Consumable'));
		}
	}

	public function ConsumableUpdate($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Master Item Consumable';
		$data['Menu'] = 'Consumable';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$data['id'] = $id;
		$data['MasterItemConsumable'] = $this->M_masteritemconsumable->getMasterItemConsumable($plaintext_string);

		$this->form_validation->set_rules('txtItemCodeHeader', 'itemcode', 'required');
		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('Warehouse/MainMenu/MasterItemConsumable/V_update', $data);
			$this->load->view('V_Footer',$data);	
		} else {
			$data = array(
				'item_name' => $this->input->post('txtItemNameHeader',TRUE),
				'item_qty' => $this->input->post('txtItemQtyHeader',TRUE),
				'item_qty_min' => $this->input->post('txtItemQtyMinHeader',TRUE),
				'item_desc' => $this->input->post('txaItemDescHeader',TRUE),
				'item_barcode' => $this->input->post('txtItemBarcodeHeader',TRUE),
				'last_update_date' => 'NOW()',
				'last_updated_by' => $this->session->userid,
				'item_code' => $this->input->post('txtItemCodeHeader',TRUE),
    			);
			$this->M_masteritemconsumable->updateMasterItemConsumable($data, $plaintext_string);

			redirect(site_url('Warehouse/MasterItem/Consumable'));
		}
	}

    public function ConsumableDelete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_masteritemconsumable->deleteMasterItemConsumable($plaintext_string);

		redirect(site_url('Warehouse/MasterItem/Consumable'));
    }
}
