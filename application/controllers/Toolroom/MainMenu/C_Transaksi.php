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
		
		$data['Menu'] = 'Transaction';
		$data['SubMenuOne'] = 'Peminjaman';
		$data['SubMenuTwo'] = '';
		$data['Title'] = 'Peminjaman';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['itemOut'] = $this->M_transaksi->listOutITem();
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
		$id = $this->input->post('id');
		$getItem = $this->M_transaksi->checkStokItem($id);
		foreach($getItem as $getItem_item){
			if($getItem_item['stok']=="0"){
				echo "out";
			}else{
				$checkLog = $this->M_transaksi->checkLog($id);
				if(empty($checkLog)){
					$saveLog = $this->M_transaksi->saveLog($id,$getItem_item['item_name']);
				}else{
					$updateLog = $this->M_transaksi->updateLog($id);
				}	
				$this->showListOutItem();
			}
		}
	}
	
	public function removeNewItem(){
		$id = $this->input->post('id');
		$delete = $this->M_transaksi->deleteLog($id);
		$this->showListOutItem();
	}
	
	public function clearNewItem(){
		$delete = $this->M_transaksi->deleteLog();
		$this->showListOutItem();
	}
	
	public function showListOutItem(){
		$itemOut = $this->M_transaksi->listOutITem();
		foreach($itemOut as $itemOut_item){
			echo "
				<tr class='clone'>
					<td class='text-center'><span id='no'>1</span></td>
					<td class='text-center item_id'>".$itemOut_item['item_id']."</td>
					<td class='item_name'>".$itemOut_item['item_name']."</td>
					<td class='text-center sisa_stok'>".$itemOut_item['sisa_stok']."</td>
					<td><input type='number' class='form-control item_out' name='txtQtyPinjam' id='txtQtyPinjam' value='".$itemOut_item['item_qty']."' style='100%'></input></td>
					<td class='text-center'><a onClick='removeListOutItem(\"".$itemOut_item['item_id']."\")'><span class='fa fa-remove'></span></a></td>
				</tr>
			";
		}
	}
	
	public function getName(){
		$id = $this->input->post('id');
		$getName = $this->M_transaksi->getName($id);
		echo $getName->nama;
	}
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
	
	public function addNewLending(){
		$noind = $this->input->post('noind',true);
		$user = $this->input->post('user',true);
		$date = $this->input->post('date',true);
		$saveLending = $this->M_transaksi->insertLending($noind,$user,$date);
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
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['ListOutTransaction'] = $this->M_transaksi->ListOutTransaction($plaintext_string,$date);
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ToolRoom/MainMenu/TransaksiPinjam/V_List',$data);
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
