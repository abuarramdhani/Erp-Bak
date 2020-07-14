<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_penerimaanAwal extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		  //$this->load->library('Database');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PenerimaanPO/M_penerimaanawal');
		$this->load->library('excel');
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
	}

	public function Index(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['action'] = 'MonitoringKomponen/MonitoringSeksi/check';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PenerimaanPO/V_PenerimaanAwal', $data);
		$this->load->view('V_Footer',$data);
	}
	
	public function checkSession(){
		if(!$this->session->is_logged){
			redirect();
		}
	}

	public function getListVendor(){		
		$key  = $this->input->post('term');	
		$data = $this->M_penerimaanawal->getListVendor($key);		
		echo json_encode($data); 
	}

	public function getListItem(){
		$key  = $this->input->post('term');
		$data = $this->M_penerimaanawal->getListItem($key); 
		echo json_encode($data);
	}

	public function loadVendor($PO){
		$data = $this->M_penerimaanawal->loadVendor($PO);
		echo json_encode($data);
	}

	public function loadSubinv($PO){
		$data = $this->M_penerimaanawal->Subinv($PO);
		if(!$data){
			$data[0]['SUB_INVENTORY']='-';
		}
		echo json_encode($data);
	}

	public function loadPoLine($PO){
		$data = $this->M_penerimaanawal->loadPoLine($PO);
		echo json_encode($data);
	}

	public function generateSJ(){
		$data = $this->M_penerimaanawal->generateSJ();
		echo json_encode($data);
	}

	public function insertDataAwal(){
		$po		   = $this->input->post('po');	
		$sj		   = $this->input->post('sj');	
		$vendor	   = $this->input->post('vendor');	
		$item	   = $this->input->post('item');	
		$desc	   = $this->input->post('desc');	
		$qtySJ	   = $this->input->post('qtySJ');	
		$rcptDate  = $this->input->post('rcptDate');	
		$spDate	   = $this->input->post('spDate');	
		$qtyActual = $this->input->post('qtyActual');	
		$qtyPO	   = $this->input->post('qtyPO');
		$qtyReceipt = $this->input->post('qtyReceipt');
		$keterangan = $this->input->post('keterangan');
		$status = $this->input->post('status');
		$data = $this->M_penerimaanawal->insertDataAwal($po,$sj,$vendor,$item,$desc,$qtySJ,$rcptDate,$spDate,$qtyActual,$qtyPO,$qtyReceipt,$keterangan,$status);

		echo json_encode($data);

	}

	public function cetakPDF(){
		
		$where = $this->input->get('id');
		$p_barang = $this->input->get('p-barang');
		$whs = $this->input->get('whs');
		$sj = $this->input->get('sj');

		$data = $this->M_penerimaanawal->selectGenerate($where,$sj);
			if($whs == '' || $whs == '-'){
				$whs = '<b style="color:white;">ADEXE</b>';
			}
			// echo "<pre>";
			// print_r($datalist);
			// exit();

			$this->load->library('pdf');
			$pdf = $this->pdf->load();
			$pdf = new mPDF('utf-8',array(80,110));
		
			$filename = 'Form-Pendaftaran-Resource.pdf';
			
			foreach ($data as $datalist) {
			
			$datalist['sad'] = '';
			$pdf->SetHTMLHeader('<table style="margin:-40px;width:100%;border: 1px solid black; padding: 0px">
				<tr>
					<td style="width:20%;border-right: 1px solid black;"><center><img style="width: 30px;" src='.base_url('assets/img/logo.png').'></center></td>
					<td style="width:40%;border-right: 1px solid black;"><center><p style="font-size:10px;"><b>WHS</b>: '.$whs.'</p></center></td>
					<td style="width:40%"><center><p style="font-size:10px;"><b>TGL </b>:'.$datalist['RECEIPT_DATE'].'</h1></center></td>
				</tr>
			</table>');
				$html = $this->load->view('PenerimaanPO/V_CreateForm', $datalist, true);
				$pdf->WriteHTML($html, 2);
			}
			$pdf->Output($filename, 'I');
	}

}



