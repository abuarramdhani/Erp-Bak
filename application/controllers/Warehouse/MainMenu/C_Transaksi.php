<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Transaksi extends CI_Controller {

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
		$this->load->model('Warehouse/MainMenu/M_transaksi');
		$this->load->model('Warehouse/MainMenu/M_master_item');
		date_default_timezone_set("Asia/Bangkok");
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
	}
	
	public function Time_(){
		echo date('Y-m-d H:i:s');
	}
	//HALAMAN TRANSAKSI PEMINJAMAN
	public function Keluar(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Transaction';
		$data['SubMenuOne'] = 'Peminjaman';
		$data['SubMenuTwo'] = '';
		$data['Title'] = 'Peminjaman  Usable';
		$data['admin'] = $this->M_transaksi->admin_check();

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['ListOutGroupTransaction'] = $this->M_transaksi->ListOutGroupTransaction();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Warehouse/MainMenu/TransaksiPinjam/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function KeluarConsumable(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Transaction';
		$data['SubMenuOne'] = 'Peminjaman';
		$data['SubMenuTwo'] = '';
		$data['Title'] = 'Permintaan  Consumable';
		$data['admin'] = $this->M_transaksi->admin_check();

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['ListOutGroupTransaction'] = $this->M_transaksi->ListOutGroupTransactionConsumable();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Warehouse/MainMenu/TransaksiConsumablePinjam/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function CreatePeminjaman(){
		$this->checkSession();
		$user_id = $this->session->userid;
		$this->clearNewItem();
		$data['Menu'] = 'Transaction';
		$data['SubMenuOne'] = 'Peminjaman';
		$data['SubMenuTwo'] = '';
		$data['Title'] = 'Create Peminjaman Usable';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['itemOut'] = $this->M_transaksi->listOutITem($user_id);
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Warehouse/MainMenu/TransaksiPinjam/V_Create',$data);
		$this->load->view('V_Footer',$data);
	}

	public function CreatePeminjamanConsumable(){
		$this->checkSession();
		$user_id = $this->session->userid;
		$this->clearNewItem();
		$data['Menu'] = 'Transaction';
		$data['SubMenuOne'] = 'Peminjaman';
		$data['SubMenuTwo'] = '';
		$data['Title'] = 'Create Permintaan Consumable';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['itemOut'] = $this->M_transaksi->listOutITemConsumable($user_id);
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Warehouse/MainMenu/TransaksiConsumablePinjam/V_Create',$data);
		$this->load->view('V_Footer',$data);
	}

	public function ReportUsable(){
		$this->checkSession();
		$user_id = $this->session->userid;
		$this->clearNewItem();
		$data['Menu'] = 'Transaction';
		$data['SubMenuOne'] = 'Peminjaman';
		$data['SubMenuTwo'] = '';
		$data['Title'] = 'Create Report Usable';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Warehouse/MainMenu/ReportCreate/V_Usable',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function ReportConsumable(){
		$this->checkSession();
		$user_id = $this->session->userid;
		$this->clearNewItem();
		$data['Menu'] = 'Transaction';
		$data['SubMenuOne'] = 'Peminjaman';
		$data['SubMenuTwo'] = '';
		$data['Title'] = 'Create Report Consumable';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['itemOut'] = $this->M_transaksi->listOutITemConsumable($user_id);
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Warehouse/MainMenu/ReportCreate/V_Consumable',$data);
		$this->load->view('V_Footer',$data);
	}	

	public function getNoind(){
		$q = strtoupper($this->input->post('term',true));
		$getNoind = $this->M_transaksi->getNoind($q);
		echo json_encode($getNoind);
	}
	
	public function getItem(){
		$q = strtoupper($this->input->post('term',true));
		$getItem = $this->M_transaksi->getItem($q);
		echo json_encode($getItem);
	}

	public function getItemConsumable(){
		$q = strtoupper($this->input->post('term',true));
		$getItem = $this->M_transaksi->getItemConsumable($q);
		echo json_encode($getItem);
	}

	public function addNewItem(){
		$id = $this->input->post('id',true);
		$user = $this->input->post('user',true);
		$type = $this->input->post('type',true);
		$getItem = $this->M_transaksi->checkStokItem($id);
		if(!empty($getItem)){
			foreach($getItem as $getItem_item){
				if($getItem_item['stok']=="0"){
					echo "out";
				}else{
					$checkLog = $this->M_transaksi->checkLog($id,$user,$type);
					if(empty($checkLog)){
						$saveLog = $this->M_transaksi->saveLog($id,$getItem_item['item_name'],$user,$type);
					}else{
						$updateLog = $this->M_transaksi->updateLog($id,$user,$type);
					}	
					if($type!=0){
						$this->showListOutItemUpdate($type);
					}else{
						$this->showListOutItem();
					}
				}
			}
		}else{
			echo "null";
		}
	}

	public function addNewItemConsumable(){
		$id = $this->input->post('id',true);
		$user = $this->input->post('user',true);
		$type = $this->input->post('type',true);
		$getItem = $this->M_transaksi->checkStokItemConsumable($id);
		if(!empty($getItem)){
			foreach($getItem as $getItem_item){
				if($getItem_item['stok']=="0"){
					echo "out";
				}else{
					$checkLog = $this->M_transaksi->checkLog($id,$user,$type);
					if(empty($checkLog)){
						$saveLog = $this->M_transaksi->saveLogConsumable($getItem_item['item_code'],$getItem_item['item_name'],$user,$type);
					}else{
						$updateLog = $this->M_transaksi->updateLogConsumable($getItem_item['item_code'],$user,$type);
					}	
					if($type!=0){
						$this->showListOutItemUpdateConsumable($type);
					}else{
						$this->showListOutItemConsumable();
					}
				}
			}
		}else{
			echo "null";
		}
	}
	
	public function removeNewItem(){
		$id = $this->input->post('id');
		$id_trs = $this->input->post('id_trans');
		$user = $this->input->post('user');
		if($id_trs == 0){
			$delete = $this->M_transaksi->deleteLog($id,$id_trs,$user);
			$this->showListOutItem();
		}else{
			$delete = $this->M_transaksi->deleteLog($id,$id_trs,$user);
			$deletelist = $this->M_transaksi->deleteList($id,$id_trs,$user);
			$this->showListOutItemUpdate($id_trs);
		}
	}
	
	public function clearNewItem($id=FALSE){
		if($id === FALSE){
			$id_trs = 0;
		}else{
			$id_trs = $id;
		}
		
		$user = $this->session->user;
		$delete = $this->M_transaksi->deleteLogAll($id_trs,$user);
		$this->showListOutItem();
	}

	public function removeNewItemConsumable(){
		$id = $this->input->post('id');
		$id_trs = $this->input->post('id_trans');
		$user = $this->input->post('user');
		if($id_trs == 0){
			$delete = $this->M_transaksi->deleteLogConsumable($id,$id_trs,$user);
			$this->showListOutItem();
		}else{
			$delete = $this->M_transaksi->deleteLogConsumable($id,$id_trs,$user);
			$deletelist = $this->M_transaksi->deleteListConsumable($id,$id_trs,$user);
			$this->showListOutItemUpdate($id_trs);
		}
	}
	
	public function clearNewItemConsumable($id=FALSE){
		if($id === FALSE){
			$id_trs = 0;
		}else{
			$id_trs = $id;
		}
		
		$user = $this->session->user;
		$delete = $this->M_transaksi->deleteLogAllConsumable($id_trs,$user);
		$this->showListOutItemConsumable();
	}
	
	public function showListOutItem(){
		$user_id = $this->session->user;
		$itemOut = $this->M_transaksi->listOutITem($user_id);
		print_r($itemOut);
		foreach($itemOut as $itemOut_item){
			echo "
			<tr class='clone'>
				<td class='text-center'><span id='no'>1</span></td>
				<td class='text-center item_id'>".$itemOut_item['item_id']."</td>
				<td class='item_name'>".$itemOut_item['item_name']."</td>
				<td class='text-center sisa_stok'>".$itemOut_item['sisa_stok']."</td>
				<td><input type='number' class='form-control item_out' name='txtQtyPinjam' id='txtQtyPinjam' value='".$itemOut_item['item_qty']."' style='100%'></input></td>
				<td class='text-center'><a onClick='removeListOutItemWh(\"".$itemOut_item['item_id']."\",\"0\",\"".$this->session->user."\")'><span class='fa fa-remove'></span></a></td>
			</tr>
			";
		}
	}
	
	public function showListOutItemUpdate($id){
		$user_id = $this->session->user;
		$itemOut = $this->M_transaksi->listOutITemUpdate($user_id,$id);
		print_r($itemOut);
		foreach($itemOut as $itemOut_item){
			echo "
			<tr class='clone'>
				<td class='text-center'><span id='no'>1</span></td>
				<td class='text-center list_id' style='display:none;'>".$itemOut_item['transaction_list_id']."</td>
				<td class='text-center item_id'>".$itemOut_item['item_id']."</td>
				<td class='item_name'>".$itemOut_item['item_name']."</td>
				<td class='text-center sisa_stok'>".$itemOut_item['sisa_stok']."</td>
				<td><input type='number' class='form-control item_out' name='txtQtyPinjam' id='txtQtyPinjam' value='".$itemOut_item['item_dipakai']."' style='100%'></input></td>
				<td class='text-center'><a onClick='removeListOutItemWh(\"".$itemOut_item['item_id']."\",\"0\",\"".$this->session->user."\")'><span class='fa fa-remove'></span></a></td>
			</tr>
			";
		}
	}

	public function showListOutItemConsumable(){
		$user_id = $this->session->user;
		$itemOut = $this->M_transaksi->listOutITemConsumable($user_id);
		print_r($itemOut);
		foreach($itemOut as $itemOut_item){
			echo "
			<tr class='clone'>
				<td class='text-center'><span id='no'>1</span></td>
				<td class='text-center item_id'>".$itemOut_item['item_code']."</td>
				<td class='item_name'>".$itemOut_item['item_name']."</td>
				<td class='text-center sisa_stok'>".$itemOut_item['sisa_stok']."</td>
				<td><input type='number' class='form-control item_out' name='txtQtyPinjam' id='txtQtyPinjam' value='".$itemOut_item['item_qty']."' style='100%'></input></td>
				<td class='text-center'><a onClick='removeListOutItemWhConsumable(\"".$itemOut_item['item_code']."\",\"0\",\"".$this->session->user."\")'><span class='fa fa-remove'></span></a></td>
			</tr>
			";
		}
	}
	
	public function showListOutItemUpdateConsumable($id){
		$user_id = $this->session->user;
		$itemOut = $this->M_transaksi->listOutITemUpdateConsumable($user_id,$id);
		print_r($itemOut);
		foreach($itemOut as $itemOut_item){
			echo "
			<tr class='clone'>
				<td class='text-center'><span id='no'>1</span></td>
				<td class='text-center list_id' style='display:none;'>".$itemOut_item['transaction_list_id']."</td>
				<td class='text-center item_id'>".$itemOut_item['item_code']."</td>
				<td class='item_name'>".$itemOut_item['item_name']."</td>
				<td class='text-center sisa_stok'>".$itemOut_item['sisa_stok']."</td>
				<td><input type='number' class='form-control item_out' name='txtQtyPinjam' id='txtQtyPinjam' value='".$itemOut_item['item_dipakai']."' style='100%'></input></td>
				<td class='text-center'><a onClick='removeListOutItemWhConsumable(\"".$itemOut_item['item_code']."\",\"0\",\"".$this->session->user."\")'><span class='fa fa-remove'></span></a></td>
			</tr>
			";
		}
	}
	
	public function getName(){
		$id = $this->input->post('id',true);;
		$getName = $this->M_transaksi->getName($id);
		if(empty($getName)){
			echo "null";
		}else{
			echo $getName->nama;
		}			
	}
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
	
	public function addNewLending(){
		$shift = $this->input->post('shift',true);
		$noind = $this->input->post('noind',true);
		$user = $this->input->post('user',true);
		$date = $this->input->post('date',true);
		$name = $this->input->post('name',true);
		$getToolman = $this->M_transaksi->getToolman($user);
		$toolman = $getToolman->employee_name;
		$saveLending = $this->M_transaksi->insertLending($noind,$user,$date,$shift,$name,$toolman);
		$insert_id = $this->db->insert_id();
		echo $insert_id;
	}

	public function addNewLendingConsumable(){
		$shift = $this->input->post('shift',true);
		$noind = $this->input->post('noind',true);
		$user = $this->input->post('user',true);
		$date = $this->input->post('date',true);
		$name = $this->input->post('name',true);
		$getToolman = $this->M_transaksi->getToolman($user);
		$toolman = $getToolman->employee_name;
		$saveLending = $this->M_transaksi->insertLendingConsumable($noind,$user,$date,$shift,$name,$toolman);
		$insert_id = $this->db->insert_id();
		echo $insert_id;
	}
	
	public function addNewLendingList(){
		$noind = $this->input->post('noind',true);
		$user = $this->input->post('user',true);
		$date = $this->input->post('date',true);
		$item_id = $this->input->post('item_id',true);
		$item_name = $this->input->post('item_name',true);
		$sisa_stok = $this->input->post('sisa_stok',true);
		$item_out = $this->input->post('item_out',true);
		$id_transaction = $this->input->post('id_transaction',true);
		$saveLendingList = $this->M_transaksi->insertLendingList($noind,$user,$date,$item_id,$item_name,$sisa_stok,$item_out,$id_transaction,$tanggal);

		$this->clearNewItem();
	}

	public function addNewLendingListConsumable(){
		$noind = $this->input->post('noind',true);
		$user = $this->input->post('user',true);
		$date = $this->input->post('date',true);
		$item_id = $this->input->post('item_id',true);
		$item_name = $this->input->post('item_name',true);
		$sisa_stok = $this->input->post('sisa_stok',true);
		$item_out = $this->input->post('item_out',true);
		$id_transaction = $this->input->post('id_transaction',true);
		$saveLendingList = $this->M_transaksi->insertLendingList($noind,$user,$date,$item_id,$item_name,$sisa_stok,$item_out,$id_transaction);
		$this->clearNewItem();
	}
	
	public function UpdateNewLending(){
		$id = $this->input->post('id',true);
		$noind = $this->input->post('noind',true);
		$user = $this->input->post('user',true);
		$date = $this->input->post('date',true);
		$shift = $this->input->post('shift',true);
		$saveLending = $this->M_transaksi->updateLending($noind,$user,$date,$id,$shift);
		echo $id;
	}

	public function UpdateNewLendingConsumable(){
		$id = $this->input->post('id',true);
		$noind = $this->input->post('noind',true);
		$user = $this->input->post('user',true);
		$date = $this->input->post('date',true);
		$shift = $this->input->post('shift',true);
		$saveLending = $this->M_transaksi->updateLending($noind,$user,$date,$id,$shift);
		echo $id;
	}
	
	public function UpdateNewLendingList(){
		$noind = $this->input->post('noind',true);
		$user = $this->input->post('user',true);
		$date = $this->input->post('date',true);
		$item_id = $this->input->post('item_id',true);
		$item_name = $this->input->post('item_name',true);
		$sisa_stok = $this->input->post('sisa_stok',true);
		$item_out = $this->input->post('txtQtyPinjam',true);
		$id_transaction = $this->input->post('id',true);
		$list_id = $this->input->post('list_id',true);
		$this->M_transaksi->updateLendingList($id_transaction,$item_out);
		$this->clearNewItem($id_transaction);
	}
	
	public function ListItemUsable($id,$date){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$date = date("Y-m-d H:i:s",strtotime(str_replace('%20',' ',$date)));
		
		$data['Menu'] = 'Transaction';
		$data['SubMenuOne'] = 'Peminjaman';
		$data['SubMenuTwo'] = '';
		$data['Title'] = 'Peminjaman Usable';

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$this->clearNewItem($plaintext_string);
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['ListOutTransaction'] = $this->M_transaksi->ListOutTransactionDetail($plaintext_string);
		$data['list_id'] = $plaintext_string;
		$data['list_date'] = $date;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Warehouse/MainMenu/TransaksiPinjam/V_List',$data);
		$this->load->view('V_Footer',$data);
	}

	public function ListItemConsumable($id,$date){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$date = date("Y-m-d H:i:s",strtotime(str_replace('%20',' ',$date)));
		
		$data['Menu'] = 'Transaction';
		$data['SubMenuOne'] = 'Peminjaman';
		$data['SubMenuTwo'] = '';
		$data['Title'] = 'Permintaan Consumable';

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$this->clearNewItem($plaintext_string);
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['ListOutTransaction'] = $this->M_transaksi->ListOutTransactionConsumable($plaintext_string,$date);
		$data['list_id'] = $plaintext_string;
		$data['list_date'] = $date;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Warehouse/MainMenu/TransaksiConsumablePinjam/V_List',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function RemoveItemUsable($id,$date){
		
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		
		$date = date("Y-m-d H:i:s",strtotime(str_replace('%20',' ',$date)));
		$removeTransactionList = $this->M_transaksi->removeTransactionList($plaintext_string,$date);
		$removeGroupTransaction = $this->M_transaksi->removeGroupTransaction($plaintext_string,$date);
		redirect('Warehouse/Transaksi/Keluar');
	}

	public function RemoveItemConsumable($id,$date){
		
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		
		$date = date("Y-m-d H:i:s",strtotime(str_replace('%20',' ',$date)));
		$removeTransactionList = $this->M_transaksi->removeTransactionList($plaintext_string,$date);
		$removeGroupTransaction = $this->M_transaksi->removeGroupTransaction($plaintext_string,$date);
		redirect('Warehouse/Transaksi/Keluar/Consumable');
	}
	
	public function UpdateItemUsable($id,$date){
		
		$this->checkSession();
		$user_id = $this->session->userid;
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$date = date("Y-m-d H:i:s",strtotime(str_replace('%20',' ',$date)));
		
		$this->clearNewItem($plaintext_string);
		$getNoind = $this->M_transaksi->getNoindTransaction($plaintext_string);
		
		$data['Menu'] = 'Transaction';
		$data['SubMenuOne'] = 'Peminjaman';
		$data['SubMenuTwo'] = '';
		$data['Title'] = 'Update Peminjaman Usable';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['ListOutTransaction'] = $this->M_transaksi->ListOutTransaction($plaintext_string,$date);
		$data['getShift'] = $this->M_transaksi->getShift($plaintext_string);
		$data['id_list'] = $plaintext_string;
		$data['noind_list'] = $getNoind->noind;
		$data['name_list'] = $getNoind->name;
		$data['date_list'] = $date;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Warehouse/MainMenu/TransaksiPinjam/V_Update',$data);
		$this->load->view('V_Footer',$data);
	}

	public function UpdateItemConsumable($id,$date){
		
		$this->checkSession();
		$user_id = $this->session->userid;
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$date = date("Y-m-d H:i:s",strtotime(str_replace('%20',' ',$date)));
		
		$this->clearNewItem($plaintext_string);
		$getNoind = $this->M_transaksi->getNoindTransaction($plaintext_string);
		
		$data['Menu'] = 'Transaction';
		$data['SubMenuOne'] = 'Peminjaman';
		$data['SubMenuTwo'] = '';
		$data['Title'] = 'Update Permintaan Consumable';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['ListOutTransaction'] = $this->M_transaksi->ListOutTransactionConsumable($plaintext_string,$date);
		$data['getShift'] = $this->M_transaksi->getShift($plaintext_string);
		$data['id_list'] = $plaintext_string;
		$data['noind_list'] = $getNoind->noind;
		$data['name_list'] = $getNoind->name;
		$data['date_list'] = $date;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('Warehouse/MainMenu/TransaksiConsumablePinjam/V_Update',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function getItemUpdate(){
		$id = $this->input->post('id',true);
		$no = $this->input->post('no',true);
		$getItem = $this->M_transaksi->checkStokItem($id);
		if(empty($getItem)){
			echo "null";
		}else{
			foreach($getItem as $getItem_item){
				if($getItem_item['stok'] == "0"){
					echo "out";
				}else{
					echo "<tr class='clone'>
					<td class='text-center'><span id='no_mor'>".$no."</span></td>
					<td class='text-center item_id'>".$getItem_item['item_id']."</td>
					<td class='item_name'>".$getItem_item['item_name']."</td>
					<td class='text-center sisa_stok'>".$getItem_item['stok']."</td>
					<td><input type='number' class='form-control item_out' name='txtQtyPinjam' id='txtQtyPinjam' value='1' style='100%'></input></td>
					<td class='text-center'><a onClick='removeListOutItemWh(\"".$getItem_item['item_id']."\",\"0\",\"".$this->session->user."\")'><span class='fa fa-remove'></span></a></td>
				</tr>";
			}
		}
	}
}

public function getItemUpdateConsumable(){
	$id = $this->input->post('id',true);
	$no = $this->input->post('no',true);
	$getItem = $this->M_transaksi->checkStokItemConsumable($id);
	if(empty($getItem)){
		echo "null";
	}else{
		foreach($getItem as $getItem_item){
			if($getItem_item['stok'] == "0"){
				echo "out";
			}else{
				echo "<tr class='clone'>
				<td class='text-center'><span id='no_mor'>".$no."</span></td>
				<td class='text-center item_id'>".$getItem_item['item_code']."</td>
				<td class='item_name'>".$getItem_item['item_name']."</td>
				<td class='text-center sisa_stok'>".$getItem_item['stok']."</td>
				<td><input type='number' class='form-control item_out' name='txtQtyPinjam' id='txtQtyPinjam' value='1' style='100%'></input></td>
				<td class='text-center'><a onClick='removeListOutItemWh(\"".$getItem_item['item_code']."\",\"0\",\"".$this->session->user."\")'><span class='fa fa-remove'></span></a></td>
			</tr>";
		}
	}
}
}

	//HALAMAN TRANSAKSI PENGEMBALIAN
public function Masuk(){
	$this->checkSession();
	$user_id = $this->session->userid;

	$data['Menu'] = 'Transaction';
	$data['SubMenuOne'] = 'Kembali';
	$data['SubMenuTwo'] = '';
	$data['Title'] = 'Pengembalian';
	$data['admin'] = $this->M_transaksi->admin_check();
	
	$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
	$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
	$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
	// $data['ListOutTransaction'] = $this->M_transaksi->ListOutTransaction();
	$this->load->view('V_Header',$data);
	$this->load->view('V_Sidemenu',$data);
	$this->load->view('Warehouse/MainMenu/TransaksiPengembalian/V_Index',$data);
	$this->load->view('V_Footer',$data);
}

public function addNewPengembalianItem(){
	$barcode = $this->input->post('barcode',true);
	$txtQtyKembali = $this->input->post('txtQtyKembali',true);
	$induk = $this->input->post('induk',true);
	$id = $this->input->post('id',true);
	$date = $this->input->post('date',true);

	$getItem = $this->M_transaksi->checkStokItem($barcode);
	if(!empty($getItem)){
		// if($date == null){
		// 	$all = "";
		// }else{
		// 	$all = "date_trunc('day', date_lend)='$date' 
		// 	and";
		// }

		// $datenow = date('Y-m-d H:i:s');
		// $addItemLending = $this->M_transaksi->addItemLending($id,$trans,$date,$datenow,$all,$txtQtyKembali);
		
		$result = $this->M_transaksi->getItemTransactionList($id,$barcode);

		
		$item_return = $txtQtyKembali;

		$data =  array(	
			'transaction_id' => $result[0]['transaction_id'],
			'item_id' => $result[0]['item_id'],
			'status' => $result[0]['status'],
			'date_return' => $date,
			'returned_by' => $result[0]['returned_by'],
			'item_awl' => $result[0]['item_awl'],
			'item_akh' => $result[0]['item_akh'],
			'item_qty_return' => $item_return
			);

		$this->M_transaksi->insertTransactionList($data);
		
		$after = $this->M_transaksi->ListOutTransaction($induk);
		$item = 0;
		
		foreach ($after as $value) {
			$item += $value['qty_kembali'];
		}

		if($after[0]['awal'] == $item){
			$this->M_transaksi->updateStatus($id,$barcode);
			$this->M_transaksi->updateStatusKembali($after[0]['transaction_list_id']);

		}

		print_r($result);


		// $this->listOutItemToday($trans);

	}else{
		echo "null";
	}
}

public function CheckBarcodekembali(){
	$id = $this->input->post('barcode',true);
	$trans = $this->input->post('trans',true);
	$date = $this->input->post('date',true);
	$getItem = $this->M_transaksi->checkStokItem($id);
	if(!empty($getItem)){
		if($date == null){
			$all = "";
		}else{
			$all = "date_trunc('day', date_lend)='$date' 
			and";
		}
	}else{
		echo "null";
	}
}

public function listOutItemToday($id){
	$ListOutTransaction = $this->M_transaksi->ListOutTransaction($id);
	foreach($ListOutTransaction as $ListOutTransaction_item){
		if($ListOutTransaction_item['status']=='1'){
			echo "<tr><td colspan='7' style='text-align:center'>tidak ada data</td></tr>";
		}else{
			if ($ListOutTransaction_item['item_dipakai'] != 0) {
				echo "
				<tr>
					<td class='text-center'>1</td>
					<td class='text-center'>".$ListOutTransaction_item['item_id']."</td>
					<td>".$ListOutTransaction_item['item_name']."</td>
					<td class='text-center'>".$ListOutTransaction_item['item_qty']."</td>
					<td class='text-center'>".$ListOutTransaction_item['item_dipakai']."</td>
					<td class='text-center'>".$ListOutTransaction_item['item_qty_return']."</td>
				</tr>
				";
			}
		}
	}
}

public function getPinjamanUser(){
	$id = $this->input->post('id');
	$html = "";
	$ListOutTransaction = $this->M_transaksi->ListOutTransaction($id);
	if(!empty($ListOutTransaction)){
		$no = 0;

		foreach($ListOutTransaction as $ListOutTransaction_item){
				// if ($ListOutTransaction_item['item_dipakai'] != 0) {
			$no++;

			$html .= "<tr id='barcode".$ListOutTransaction_item['item_id']."'><input type='hidden' name='biksu' value='".$ListOutTransaction_item['id_transaction']."'><td class='text-center'>".$no."</td><td class='text-center'>".$ListOutTransaction_item['tgl_transaksi']."</td><td class='text-center'>".$ListOutTransaction_item['item_id']."</td><td>".$ListOutTransaction_item['item_name']."</td><td class='text-center'>".$ListOutTransaction_item['qty_pinjam']."</td><td class='text-center'>".$ListOutTransaction_item['qty_kembali']."</td></tr>";
				// }
		}
	}
	
	echo $html;
}



public function createLaporan1(){	
	$tanggal1 = $this->input->post('tanggal_awal');
	$tanggal2 = $this->input->post('tanggal_akhir');

	$tanggal1 = date_format(date_create($tanggal1),"Y-m-d");
	$tanggal2 = date_format(date_create($tanggal2),"Y-m-d");

		// echo "<pre>";
		// print_r($tanggal1);
		// exit();

	$pinjam = $this->input->post('pinjam');


	$noind = $this->input->post('noind');

	if($noind == ""){
		$section = $this->M_transaksi->getReportUsable($pinjam);
	}else{
		$section = $this->M_transaksi->getReportUsable($pinjam,$noind);
	}


		// echo "<pre>";
		// print_r($section);
		// exit();

	$this->load->library('Excel');

	$objPHPExcel = new PHPExcel();
	$worksheet = $objPHPExcel->getActiveSheet();

	$styleThead = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			),
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
	$styleNotice = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'ff0000'),
			)
		);
	$styleBorder = array(
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
	$aligncenter = array(
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, ));

		// ----------------- Set format table -----------------
	if($pinjam == "PINJAM"){
	$worksheet->getColumnDimension('A')->setWidth(10);
	$worksheet->getColumnDimension('B')->setWidth(20);
	$worksheet->getColumnDimension('C')->setWidth(10);
	$worksheet->getColumnDimension('D')->setWidth(30);
	$worksheet->getColumnDimension('E')->setWidth(20);
	$worksheet->getColumnDimension('F')->setWidth(15);
	$worksheet->getColumnDimension('G')->setWidth(10);
	$worksheet->getColumnDimension('H')->setWidth(10);
	$worksheet->getColumnDimension('I')->setWidth(30);
	$worksheet->getColumnDimension('J')->setWidth(30);
	$worksheet->getColumnDimension('K')->setWidth(40);

	}else{
	$worksheet->getColumnDimension('A')->setWidth(10);
	$worksheet->getColumnDimension('B')->setWidth(20);
	$worksheet->getColumnDimension('C')->setWidth(20);
	$worksheet->getColumnDimension('D')->setWidth(10);
	$worksheet->getColumnDimension('E')->setWidth(20);
	$worksheet->getColumnDimension('F')->setWidth(15);
	$worksheet->getColumnDimension('G')->setWidth(25);
	$worksheet->getColumnDimension('H')->setWidth(10);
	$worksheet->getColumnDimension('I')->setWidth(10);
	$worksheet->getColumnDimension('J')->setWidth(10);
	$worksheet->getColumnDimension('K')->setWidth(30);
	$worksheet->getColumnDimension('L')->setWidth(30);
	$worksheet->getColumnDimension('M')->setWidth(40);

	}

	


		// ----------------- STATIC DATA -----------------
	if($pinjam == "PINJAM"){
		$worksheet->setCellValue('B1', 'LAPORAN PEMINJAMAN USABLE : '.date('F').' dari '.$tanggal1.' s/d '.$tanggal2);
	}else{
		$worksheet->setCellValue('B1', 'LAPORAN PENGEMBALIAN USABLE : '.date('F').' dari '.$tanggal1.' s/d '.$tanggal2);
	}
	


	if($pinjam == "PINJAM"){
		$worksheet->setCellValue('A4', 'NO');
		$worksheet->setCellValue('B4', 'Tanggal Transaksi');
		$worksheet->setCellValue('C4', 'Item Code');
		$worksheet->setCellValue('D4', 'Item');
		$worksheet->setCellValue('E4', 'Merk');
		$worksheet->setCellValue('F4', 'Stok Awal');
		
		$worksheet->setCellValue('G4', 'Qty Pinjam');

		$worksheet->setCellValue('H4', 'Shift');
		$worksheet->setCellValue('I4', 'Nama');
		$worksheet->setCellValue('J4', 'Toolman');
		$worksheet->setCellValue('K4', 'Deskripsi');
	}else{
		$worksheet->setCellValue('A4', 'NO');
		$worksheet->setCellValue('B4', 'Tanggal Transaksi');
		$worksheet->setCellValue('C4', 'Tanggal Kembali');
		$worksheet->setCellValue('D4', 'Item Code');
		$worksheet->setCellValue('E4', 'Item');
		$worksheet->setCellValue('F4', 'Merk');
		$worksheet->setCellValue('G4', 'Keterangan');
		$worksheet->setCellValue('H4', 'Stok Awal');
		$worksheet->setCellValue('I4', 'Qty Kembali');	
		$worksheet->setCellValue('J4', 'Shift');
		$worksheet->setCellValue('K4', 'Nama');
		$worksheet->setCellValue('L4', 'Toolman');
		$worksheet->setCellValue('M4', 'Deskripsi');
		
	}

	$worksheet->getStyle('A4:M4')->getAlignment()->setWrapText(true);
	$worksheet->getStyle('A4:K4')->applyFromArray($aligncenter);
	$worksheet->getStyle('A3:D3')->applyFromArray($styleNotice);
	$worksheet->getStyle('F1:F3')->applyFromArray($styleNotice);

	$worksheet->getStyle('A')->applyFromArray($aligncenter);
	$worksheet->getStyle('B')->applyFromArray($aligncenter);
	$worksheet->getStyle('C')->applyFromArray($aligncenter);
	$worksheet->getStyle('D')->applyFromArray($aligncenter);
	$worksheet->getStyle('E')->applyFromArray($aligncenter);
	$worksheet->getStyle('F')->applyFromArray($aligncenter);
	$worksheet->getStyle('G')->applyFromArray($aligncenter);
	$worksheet->getStyle('H')->applyFromArray($aligncenter);
	$worksheet->getStyle('I')->applyFromArray($aligncenter);
	$worksheet->getStyle('J')->applyFromArray($aligncenter);
	$worksheet->getStyle('K')->applyFromArray($aligncenter);
	$worksheet->getStyle('L')->applyFromArray($aligncenter);
	$worksheet->getStyle('M')->applyFromArray($aligncenter);
		// ----------------- DYNAMIC DATA -----------------
	

	$no = 1;
	$highestRow = $worksheet->getHighestRow()+2;

		// echo "<pre>";
		// print_r($section);
		// print_r($tanggal1);
		// print_r($tanggal2);
		// exit();
	foreach ($section as $sc) {
			// $worksheet->getStyle('F'.$highestRow.':G'.$highestRow)->applyFromArray($styleBorder);
		if($pinjam == "PINJAM"){

			$tgl_transaksi = date_format(date_create($sc['tgl_transaksi']),'Y-m-d');

			if($tgl_transaksi >= $tanggal1 && $tgl_transaksi <= $tanggal2){
				$worksheet->setCellValue('A'.$highestRow,$no);	
				$worksheet->setCellValue('B'.$highestRow,$sc['tgl_transaksi']);



				$worksheet->setCellValue('C'.$highestRow,$sc['item_id']);
				$worksheet->setCellValue('D'.$highestRow,$sc['item_name']);
				$worksheet->setCellValue('E'.$highestRow,$sc['merk']);
				$worksheet->setCellValue('F'.$highestRow,$sc['item_qty']);

				$worksheet->setCellValue('G'.$highestRow,$sc['qty_pinjam']);



				$worksheet->setCellValue('H'.$highestRow,$sc['shift']);
				$worksheet->setCellValue('I'.$highestRow,$sc['name']);
				$worksheet->setCellValue('J'.$highestRow,$sc['toolman']);
				$worksheet->setCellValue('K'.$highestRow,$sc['item_desc']);

				$highestRow++;
				$no++;
			}


		}else{
			$tgl_transaksi = date_format(date_create($sc['tgl_transaksi']),'Y-m-d');

			if(($tgl_transaksi > $tanggal1 && $tgl_transaksi < $tanggal2) || $tgl_transaksi == $tanggal1 || $tgl_transaksi == $tanggal2){
				
				// if($sc['qty_kembali'] != 0){



					$worksheet->setCellValue('A'.$highestRow,$no);

					if($sc['status_kembali'] == 1){
						$worksheet->setCellValue('C'.$highestRow,$sc['tgl_transaksi']);	
						$worksheet->setCellValue('B'.$highestRow,$sc['creation_date']);
					}else{
						$worksheet->setCellValue('B'.$highestRow,$sc['tgl_transaksi']);		
					}

					$worksheet->setCellValue('D'.$highestRow,$sc['item_id']);
					$worksheet->setCellValue('E'.$highestRow,$sc['item_name']);
					$worksheet->setCellValue('F'.$highestRow,$sc['merk']);


					if($sc['qty_kembali'] > 0 && $sc['status_kembali'] == 1){
						$worksheet->setCellValue('G'.$highestRow,'DIKEMBALIKAN SEMUA');
					}else if($sc['qty_kembali'] > 0 && $sc['status_kembali'] == 0){
						$worksheet->setCellValue('G'.$highestRow,'DIKEMBALIKAN '.$sc['qty_kembali'].' BUAH');
					}else{
						$worksheet->setCellValue('G'.$highestRow,'PINJAM');
					}

					$worksheet->setCellValue('H'.$highestRow,$sc['item_qty']);

					$worksheet->setCellValue('I'.$highestRow,$sc['qty_kembali']);	

					$worksheet->setCellValue('J'.$highestRow,$sc['shift']);
					$worksheet->setCellValue('K'.$highestRow,$sc['name']);
					$worksheet->setCellValue('L'.$highestRow,$sc['toolman']);
					$worksheet->setCellValue('M'.$highestRow,$sc['item_desc']);
					


					$highestRow++;
					$no++;
				// }
			}
		}
	}

			// $worksheet->setCellValue('F'.$highestRow, $no++);
			// $worksheet->setCellValue('G'.$highestRow, $sc['print_code']);



		// ----------------- Final Process -----------------

	if($pinjam == "PINJAM"){
		$worksheet->setTitle('Laporan Peminjaman Usable');
	}else{
		$worksheet->setTitle('Laporan Pengembalian Usable');
	}
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	
	if($pinjam == "PINJAM"){
		header('Content-Disposition: attachment;filename="Laporan_Peminjaman_Usable_'.time().'.xls"');
	}else{
		header('Content-Disposition: attachment;filename="Laporan_Pengembalian_Usable_'.time().'.xls"');
	}
	$objWriter->save("php://output");
}

public function createLaporan2(){	
	$tanggal1 = $this->input->post('tanggal_awal');
	$tanggal2 = $this->input->post('tanggal_akhir');


	$tanggal1 = date_format(date_create($tanggal1),"Y-m-d");
	$tanggal2 = date_format(date_create($tanggal2),"Y-m-d");

		// echo "<pre>";
		// print_r($section);
		// exit();


	$noind = $this->input->post('noind');

	if($noind == ""){
		$section = $this->M_transaksi->getReportConsumable();
	}else{
		$section = $this->M_transaksi->getReportConsumable($noind);
	}



	$this->load->library('Excel');

	$objPHPExcel = new PHPExcel();
	$worksheet = $objPHPExcel->getActiveSheet();

	$styleThead = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			),
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
	$styleNotice = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'ff0000'),
			)
		);
	$styleBorder = array(
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
	$aligncenter = array(
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, ));

		// ----------------- Set format table -----------------
	$worksheet->getColumnDimension('A')->setWidth(10);
	$worksheet->getColumnDimension('B')->setWidth(20);
	$worksheet->getColumnDimension('C')->setWidth(10);
	$worksheet->getColumnDimension('D')->setWidth(30);
	$worksheet->getColumnDimension('E')->setWidth(20);
	$worksheet->getColumnDimension('F')->setWidth(15);
	$worksheet->getColumnDimension('G')->setWidth(10);
	$worksheet->getColumnDimension('H')->setWidth(10);
	$worksheet->getColumnDimension('I')->setWidth(30);
	$worksheet->getColumnDimension('J')->setWidth(30);
	$worksheet->getColumnDimension('K')->setWidth(40);


		// ----------------- STATIC DATA -----------------
	$worksheet->setCellValue('B1', 'LAPORAN PEMINJAMAN USABLE : '.date('F').' dari '.$tanggal1.' s/d '.$tanggal2);



	$worksheet->setCellValue('A4', 'NO');
	$worksheet->setCellValue('B4', 'Tanggal Transaksi');
	$worksheet->setCellValue('C4', 'Item Code');
	$worksheet->setCellValue('D4', 'Item');
	$worksheet->setCellValue('E4', 'Merk');
	$worksheet->setCellValue('F4', 'Stok Awal');
	$worksheet->setCellValue('G4', 'Qty Minta');
	$worksheet->setCellValue('H4', 'Shift');
	$worksheet->setCellValue('I4', 'Nama');
	$worksheet->setCellValue('J4', 'Toolman');
	$worksheet->setCellValue('K4', 'Deskripsi');



	$worksheet->setCellValue('G4', 'Qty Minta');	




	$worksheet->getStyle('A4:H4')->getAlignment()->setWrapText(true);
	$worksheet->getStyle('A4:H4')->applyFromArray($aligncenter);
	$worksheet->getStyle('A3:D3')->applyFromArray($styleNotice);
	$worksheet->getStyle('F1:F3')->applyFromArray($styleNotice);
		// ----------------- DYNAMIC DATA -----------------
	

	$no = 1;
	$highestRow = $worksheet->getHighestRow()+2;

		// echo "<pre>";
		// print_r($section);
		// exit();


	foreach ($section as $sc) {
			// $worksheet->getStyle('F'.$highestRow.':G'.$highestRow)->applyFromArray($styleBorder);
		$tgl_transaksi = date_format(date_create($sc['tgl_transaksi']),'Y-m-d');

		if(($tgl_transaksi > $tanggal1 && $tgl_transaksi < $tanggal2) || $tgl_transaksi == $tanggal1 || $tgl_transaksi == $tanggal2){
			
			$worksheet->setCellValue('A'.$highestRow,$no);
			$worksheet->setCellValue('B'.$highestRow,$sc['tgl_transaksi']);
			$worksheet->setCellValue('C'.$highestRow,$sc['item_code']);
			$worksheet->setCellValue('D'.$highestRow,$sc['item_name']);
			$worksheet->setCellValue('E'.$highestRow,$sc['merk']);
			$worksheet->setCellValue('F'.$highestRow,$sc['item_akh']);
			$worksheet->setCellValue('G'.$highestRow,$sc['qty_pinjam']);
			$worksheet->setCellValue('H'.$highestRow,$sc['shift']);
			$worksheet->setCellValue('I'.$highestRow,$sc['name']);
			$worksheet->setCellValue('J'.$highestRow,$sc['toolman']);
			$worksheet->setCellValue('K'.$highestRow,$sc['item_desc']);

			$highestRow++;
			$no++;
		}
	}
			// $worksheet->setCellValue('F'.$highestRow, $no++);
			// $worksheet->setCellValue('G'.$highestRow, $sc['print_code']);



		// ----------------- Final Process -----------------
	$worksheet->setTitle('Monthly_Planning');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Laporan_Peminjaman_Usable_'.time().'.xls"');
	$objWriter->save("php://output");
}

}