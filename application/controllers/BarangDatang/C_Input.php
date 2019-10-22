<?php defined('BASEPATH') or exit('No direct script access allowed');
class C_Input extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('form_validation');
		//load the login model
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('BarangDatang/M_input');
			
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}

	}

	public function checkSession()
	{
		if ($this->session->is_logged) {
		}else{
			redirect();
		}
	}

	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$id = 1;
		generateID:
		$num = str_pad($id, 4, "0", STR_PAD_LEFT);
		$no_id_ok = 'T'.date('ymd').$num;
		$checkID_ok = $this->M_input->CheckIDOK($no_id_ok);
		if($checkID_ok == 0){
			$data['id_ok'] = $no_id_ok;
			$id = 1;
		}
		else{
			$id++;
			goto generateID;
		}

		$idrev = 1;
		generateIDREV:
		$numrev = str_pad($idrev, 4, "0", STR_PAD_LEFT);
		$no_id_not_ok = 'F'.date('ymd').$numrev;
		$checkID_not_ok =  $this->M_input->CheckIDNotOK($no_id_not_ok);
		if($checkID_not_ok == 0){
			$data['id_not_ok'] = $no_id_not_ok;
			$idrev = 1;
		}
		else{
			$idrev++;
			goto generateIDREV;
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('BarangDatang/V_Input',$data);
		$this->load->view('V_Footer',$data);

	}

	public function SearchSupplier(){
		$term = $this->input->get('activity');
		$data = $this->M_input->getsupplier($term);
		$callback = $data[0]['VENDOR_NAME'];
		echo $callback;
	}
	public function GetIdSupplier(){
		$vendor= $this->input->post('sup');
		$data=$this->M_input->GetIdSupplier($vendor);
		if( ! empty($data)){ 
			$callback = array(
			 'status' => 'success', 
			 'VENDOR_ID' =>$data[0]['VENDOR_ID']
		 );
		}else{
			$callback = array('status' => 'failed'); 
		}
		echo json_encode($callback);
	}

	public function SearchingAjax()
	{
		$activity = $this->input->get('activity');
		$data['Activity'] = $this->M_input->getTable($activity);
		$this->load->view('BarangDatang/V_Search', $data);
	}

	public function gudangbd()
	{
		$term = $this->input->GET('term');
		$gudang = $this->M_input->getGudang($term);
		echo json_encode($gudang);
	}
	
	public function itembd()
	{
		$kode = $this->input->GET('term');
		$item = $this->M_input->item($kode);
		echo json_encode($item);
	}

	public function ClearRevBD(){
		echo'<table name="tbl2" id="tbl2" class="table table-striped table-bordered table-hover text-left" style="font-size:12px;">
			<thead>
				<tr class="bg-primary">
					<td width="20%"><b>No SJ </b></td>
					<td width="35%"><b>Item</b></td>
					<td width="15%"><b>QTY</b></td>
					<td width="30%"><b>Catatan</b></td>
				</tr>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><input class="form-control" Placeholder="No. Surat jalan" type="text" name="linenosj[]" value="" ></td>
					<td>
						<select class="form-control" Placeholder="Item" type="text" id="itembd" name="lineitem[]" value="" ><option></option></select>
					</td>
					<td><input class="form-control" Placeholder="Qty" type="number" name="lineqty[]" value=""></td>
					<td><input class="form-control" Placeholder="Catatan" id="" type="text" name="linenote[]" value=""></td>
				</tr>
			</tbody>
		</table>';
	}

	public function saveData (){
		$note = $this->input->post('note');
		$supplier = $this->input->post('txtSupplier');
		$tanggal = $this->input->post('dateDatang');
		$tanggaldatang['tanggal'] = $this->input->post('dateDatang');
		$tanggaldatang['waktu'] = $this->input->post('timeDatang');
		$tanggal_datang= implode(' ', $tanggaldatang);
		$nosj = $this->input->post('txtNoSJ');
		$nopo = $this->input->post('txtNoPo');
		$no_id = $this->input->post('txtID');
		
		$varItem = $this->input->post('txtitem');
		$varItemDescription = $this->input->post('txtitem_description');
		$varsubinv = $this->input->post('txtsubinv');
		$varQty = $this->input->post('txtqty');
		$varItemId = $this->input->post('txtitemid');
		$varID = $this->input->post('txtCheck');
		$row = sizeOf($varItem);
		$hasilcek= null;
		$kosong = null;
		if (empty($varID)) {
			$kosong = "kosong";
		}
		if ($kosong == 'kosong') {
			$this->session->set_flashdata('response',"No item to insert!");
			redirect (base_url('BarangDatang/InputBarangDatang'));
		}

		for($i=0;$i<$row;$i++){
			$varid1 = null;
			$Item = $varItem[$i];
			$ItemDescription = $varItemDescription[$i];
			$subinv = $varsubinv[$i];
			$Qty = $varQty[$i];
			$item_id = $varItemId[$i];	
			echo "<pre>"; 
			if(!isset($_POST['txtCheck'][$i])){
			}else if ($_POST['txtCheck'][$i] == 'add'){
				$insert = $this->M_input->insertItemOk($nopo,$nosj,$Item,$ItemDescription,$Qty,$subinv,$item_id,$tanggal_datang,$note,$supplier,$no_id);
			}else{}
		} 
		$this->session->set_flashdata('return',"Saved");
		redirect (base_url('BarangDatang/InputBarangDatang'));
	}

	public function saveDataUnknown (){
		$linenosj = $this->input->post('linenosj');
		$lineitem = $this->input->post('lineitem');
		$lineqty = $this->input->post('lineqty');
		$linenote = $this->input->post('linenote');
		$tanggal = $this->input->post('dateDatang');
		$tanggaldatang['tanggal'] = $this->input->post('dateDatang');
		$tanggaldatang['waktu'] = $this->input->post('timeDatang');
		$tanggal_datang= implode(' ', $tanggaldatang);
		$no_id = $this->input->post('txtID');
		$count = sizeOf($lineitem);
		$hasilcek= null;
		$kosong = null;

		if (empty($lineqty[0])  &&  empty($tanggal)) {$kosong = "kosong";}
		if ($kosong == 'kosong') {
			$this->session->set_flashdata('response',"No item to insert!");
			redirect (base_url('BarangDatang/InputBarangDatang'));
		}
		
		if (!empty($lineqty[0])) {
			for($i=0;$i<$count;$i++){
				if (empty($lineitem[0])) {
					$lineitem11 = null;
					$lineitem1 = null;
					$lnitemdesc = $linenote[$i];
					$lnitemcode = null;
					$lnitemid = null;
					$lnnote = null;
				}else{
					$lineitem11 = $lineitem[$i];
					$lineitem1 = explode("^" , $lineitem11);
					$lnitemcode = $lineitem1[0];
					$lnitemdesc = $lineitem1[1];
					$lnitemid = $lineitem1[2];
					$lnnote = $linenote[$i];
				}
				$lnqty = $lineqty[$i];
				$lnnosj = $linenosj[$i];
				if(strlen($lnqty) > 0){
					$insert = $this->M_input->insertItemRev($lnnosj,$lnitemcode,$lnitemdesc,$lnitemid,$lnqty,$lnitemid,$linenote,$tanggal_datang,$lnnote,$no_id);
				}
			}
		$this->session->set_flashdata('return',"Saved");
		redirect (base_url('BarangDatang/InputBarangDatang'));
		}
	}


}