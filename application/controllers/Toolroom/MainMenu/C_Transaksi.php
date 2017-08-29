<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Transaksi extends CI_Controller {

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
		$this->load->model('Toolroom/MainMenu/M_transaksi');
		$this->load->model('Toolroom/MainMenu/M_master_item');
        // $this->load->library(array('Excel/PHPExcel','Excel/PHPExcel/IOFactory'));
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
    }
	
	//HALAMAN TRANSAKSI PEMINJAMAN
	public function Keluar(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Transaction';
		$data['SubMenuOne'] = 'Peminjaman';
		$data['SubMenuTwo'] = '';
		$data['Title'] = 'Peminjaman';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['ListOutGroupTransaction'] = $this->M_transaksi->ListOutGroupTransaction();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ToolRoom/MainMenu/TransaksiPinjam/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function CreatePeminjaman(){
		$this->checkSession();
		$user_id = $this->session->userid;
		$this->clearNewItem();
		$data['Menu'] = 'Transaction';
		$data['SubMenuOne'] = 'Peminjaman';
		$data['SubMenuTwo'] = '';
		$data['Title'] = 'Peminjaman';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['itemOut'] = $this->M_transaksi->listOutITem($user_id);
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ToolRoom/MainMenu/TransaksiPinjam/V_Create',$data);
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
	
	public function removeNewItem(){
		$id = $this->input->post('id');
		$id_trs = $this->input->post('id_trans');
		$user = $this->input->post('user');
		$delete = $this->M_transaksi->deleteLog($id,$id_trs,$user);
		$this->showListOutItem();
	}
	
	public function clearNewItem($id=FALSE){
		if($id === FALSE){
			$id_trs = 0;
		}else{
			$id_trs = $id;
		}
		
		$user = $this->session->userid;
		$delete = $this->M_transaksi->deleteLogAll($id_trs,$user);
		$this->showListOutItem();
	}
	
	public function showListOutItem(){
		$user_id = $this->session->userid;
		$itemOut = $this->M_transaksi->listOutITem($user_id);
		foreach($itemOut as $itemOut_item){
			echo "
				<tr class='clone'>
					<td class='text-center'><span id='no'>1</span></td>
					<td class='text-center item_id'>".$itemOut_item['item_id']."</td>
					<td class='item_name'>".$itemOut_item['item_name']."</td>
					<td class='text-center sisa_stok'>".$itemOut_item['sisa_stok']."</td>
					<td><input type='number' class='form-control item_out' name='txtQtyPinjam' id='txtQtyPinjam' value='".$itemOut_item['item_qty']."' style='100%'></input></td>
					<td class='text-center'><a onClick='removeListOutItem(\"".$itemOut_item['item_id']."\",\"0\",\"".$this->session->userid."\")'><span class='fa fa-remove'></span></a></td>
				</tr>
			";
		}
	}
	
	public function showListOutItemUpdate($id){
		$user_id = $this->session->userid;
		$itemOut = $this->M_transaksi->listOutITemUpdate($user_id,$id);
		foreach($itemOut as $itemOut_item){
			echo "
				<tr class='clone'>
					<td class='text-center'><span id='no'>1</span></td>
					<td class='text-center item_id'>".$itemOut_item['item_id']."</td>
					<td class='item_name'>".$itemOut_item['item_name']."</td>
					<td class='text-center sisa_stok'>".$itemOut_item['sisa_stok']."</td>
					<td><input type='number' class='form-control item_out' name='txtQtyPinjam' id='txtQtyPinjam' value='".$itemOut_item['item_dipakai']."' style='100%'></input></td>
					<td class='text-center'><a onClick='removeListOutItem(\"".$itemOut_item['item_id']."\",\"0\",\"".$this->session->userid."\")'><span class='fa fa-remove'></span></a></td>
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
		$saveLending = $this->M_transaksi->insertLending($noind,$user,$date,$shift);
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
		if($item_out>1){
			for($i=0;$i<$item_out;$i++){
				$saveLendingList = $this->M_transaksi->insertLendingList($noind,$user,$date,$item_id,$item_name,$sisa_stok,'1',$id_transaction);
			}
		}else{
			$saveLendingList = $this->M_transaksi->insertLendingList($noind,$user,$date,$item_id,$item_name,$sisa_stok,$item_out,$id_transaction);
		}
		
		$this->clearNewItem();
	}
	
	public function UpdateNewLending(){
		$id = $this->input->post('id',true);
		$noind = $this->input->post('noind',true);
		$user = $this->input->post('user',true);
		$date = $this->input->post('date',true);
		$shift = $this->input->post('shift',true);
		$saveLending = $this->M_transaksi->updateLending($noind,$user,$date,$id,$shift);
		$removeTransactionList = $this->M_transaksi->removeTransactionList($id,$date);
		echo $id;
	}
	
	public function UpdateNewLendingList(){
		$noind = $this->input->post('noind',true);
		$user = $this->input->post('user',true);
		$date = $this->input->post('date',true);
		$item_id = $this->input->post('item_id',true);
		$item_name = $this->input->post('item_name',true);
		$sisa_stok = $this->input->post('sisa_stok',true);
		$item_out = $this->input->post('item_out',true);
		$id_transaction = $this->input->post('id',true);
		if($item_out>1){
			for($i=0;$i<$item_out;$i++){
				$saveLendingList = $this->M_transaksi->insertLendingList($noind,$user,$date,$item_id,$item_name,$sisa_stok,'1',$id_transaction);
			}
		}else{
			$saveLendingList = $this->M_transaksi->insertLendingList($noind,$user,$date,$item_id,$item_name,$sisa_stok,$item_out,$id_transaction);
		}
		
		$this->clearNewItem($id_transaction);
	}
	
	public function ListItemUsable($id,$date){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$date = date("Y-m-d H:i:s",strtotime(str_replace('%20',' ',$date)));
		
		$data['Menu'] = 'Transaction';
		$data['SubMenuOne'] = 'Peminjaman';
		$data['SubMenuTwo'] = '';
		$data['Title'] = 'Peminjaman';
			
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$this->clearNewItem($plaintext_string);
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['ListOutTransaction'] = $this->M_transaksi->ListOutTransaction($plaintext_string,$date);
		$data['list_id'] = $plaintext_string;
		$data['list_date'] = $date;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ToolRoom/MainMenu/TransaksiPinjam/V_List',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function RemoveItemUsable($id,$date){
		
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		
		$date = date("Y-m-d H:i:s",strtotime(str_replace('%20',' ',$date)));
		$removeTransactionList = $this->M_transaksi->removeTransactionList($plaintext_string,$date);
		$removeGroupTransaction = $this->M_transaksi->removeGroupTransaction($plaintext_string,$date);
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
		$data['Title'] = 'Peminjaman';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['ListOutTransaction'] = $this->M_transaksi->ListOutTransaction($plaintext_string,$date);
		$data['getShift'] = $this->M_transaksi->getShift($plaintext_string);
		$data['id_list'] = $plaintext_string;
		$data['noind_list'] = $getNoind->noind;
		$data['date_list'] = $date;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ToolRoom/MainMenu/TransaksiPinjam/V_Update',$data);
		$this->load->view('V_Footer',$data);
	}
	
	//HALAMAN TRANSAKSI PENGEMBALIAN
	public function Masuk(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Transaction';
		$data['SubMenuOne'] = 'Kembali';
		$data['SubMenuTwo'] = '';
		$data['Title'] = 'Pengembalian';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['ListOutTransaction'] = $this->M_transaksi->ListOutTransaction();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ToolRoom/MainMenu/TransaksiPengembalian/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}
	
	public function addNewPengembalianItem(){
		$id = $this->input->post('id',true);
		$date = date('Y-m-d H:i:s');
		$addItemLending = $this->M_transaksi->addItemLending($id,$date);
		$this->listOutItemToday();
	}
	
	public function listOutItemToday(){
		$ListOutTransaction = $this->M_transaksi->ListOutTransaction();
		foreach($ListOutTransaction as $ListOutTransaction_item){
			echo "
				<tr>
					<td class='text-center'>1</td>
					<td class='text-center'>".$ListOutTransaction_item['item_id']."</td>
					<td>".$ListOutTransaction_item['item_name']."</td>
					<td class='text-center'>".$ListOutTransaction_item['item_qty']."</td>
					<td class='text-center'>".$ListOutTransaction_item['item_sisa']."</td>
					<td class='text-center'>".$ListOutTransaction_item['item_dipakai']."</td>
				</tr>
			";
		}
	}
}
