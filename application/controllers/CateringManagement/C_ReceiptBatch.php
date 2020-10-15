<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_ReceiptBatch extends CI_Controller {

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
		$this->load->model('CateringManagement/M_receiptbatch');
		// $this->load->model('CateringManagement/M_receipt');
		$this->load->model('SystemAdministration/MainMenu/M_user');

		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
    }

	public function index()
	{

		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Catering Receipt';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Receipt'] = $this->M_receiptbatch->GetReceipt();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/ReceiptBatch/V_Index',$data);
		$this->load->view('V_Footer',$data);

	}

	public function Create()
	{

		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Catering Receipt';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Catering'] = $this->M_receiptbatch->GetCatering();
		$data['Type'] = $this->M_receiptbatch->GetOrderType();
		$data['FineType'] = $this->M_receiptbatch->GetFineType();
		$data['LatestId'] = $this->M_receiptbatch->GetLatestId();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/ReceiptBatch/V_Create',$data);
		$this->load->view('V_Footer',$data);

	}

	public function getQtyPerDeptBatch(){
		$tipe = $this->input->get('tipe');
		$catering = $this->input->get('catering');
		$location = $this->input->get('location');
		$date = $this->input->get('date');

		if ($tipe == '1') {
			$jenis_pesanan = '1';
		}elseif ($tipe == '2') {
			$jenis_pesanan = '0';
		}

		$lokasi = intval($location).'';
		$tgl = explode(" - ", $date);
		$tgl_awl = explode("-", $tgl['0']);
		$tgl_awal = $tgl_awl['2'].'-'.$tgl_awl['1'].'-'.$tgl_awl['0'];
		$tgl_akh = explode("-", $tgl['1']);
		$tgl_akhir = $tgl_akh['2'].'-'.$tgl_akh['1'].'-'.$tgl_akh['0'];

		$katering = $this->M_receiptbatch->getCateringKode($catering);

		$data = $this->M_receiptbatch->getDeptQty($tgl_awal,$tgl_akhir,$lokasi,$jenis_pesanan,$katering);
		if (!empty($data)) {
			echo json_encode($data);
		}else{
			// echo "$tgl_awal,$tgl_akhir,$lokasi,$jenis_pesanan,$katering";
		}
	}

	public function Details($id)
	{

		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Catering Receipt';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Receipt'] = $this->M_receiptbatch->GetReceiptDetails($id);
		$data['ReceiptFine'] = $this->M_receiptbatch->GetReceiptFineForEdit($id);
		$data['ReceiptQty'] = $this->M_receiptbatch->GetReceiptQty($id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/ReceiptBatch/V_Details',$data);
		$this->load->view('V_Footer',$data);

	}

	public function Edit($id)
	{

		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Catering Receipt';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Receipt'] = $this->M_receiptbatch->GetReceiptForEdit($id);
		$data['ReceiptFine'] = $this->M_receiptbatch->GetReceiptFineForEdit($id);
		$data['Catering'] = $this->M_receiptbatch->GetCatering();
		$data['FineType'] = $this->M_receiptbatch->GetFineType();
		$data['Type'] = $this->M_receiptbatch->GetOrderType();
		$data['ReceiptQty'] = $this->M_receiptbatch->GetReceiptQty($id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/ReceiptBatch/V_Edit',$data);
		$this->load->view('V_Footer',$data);

	}

	public function PrintReceipt($id){
		$this->load->library('pdf');
		$pdf = $this->pdf->load();

		$pdf = new mPDF('utf-8', array(215,120), 0, '', 0, 0, 0, 0);

		$filename = 'Catering-Receipt-'.$id.'.pdf';
		$this->checkSession();

		$data['Receipt'] = $this->M_receiptbatch->GetReceiptDetails($id);
		$data['ReceiptFine'] = $this->M_receiptbatch->GetReceiptFineForEdit($id);
		$data['ReceiptQty'] = $this->M_receiptbatch->GetReceiptQty($id);

		$stylesheet = file_get_contents(base_url('assets/plugins/bootstrap/3.3.6/css/bootstrap.css'));
		$html = $this->load->view('CateringManagement/ReceiptBatch/V_Print', $data, true);

		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html,2);
		$pdf->Output($filename, 'I');

	}

	public function add()
	{
		$id 		= $this->input->post('TxtID');
		$no 		= $this->input->post('TxtNo');

		$date 	= 	date('Y-m-d', strtotime($this->input->post('TxtReceiptDate')));

		$place 		= $this->input->post('TxtPlace');
		$from 		= $this->input->post('TxtFrom');
		$signer		= $this->input->post('TxtSigner');
		$ordertype	= $this->input->post('TxtOrderType');
		$catering	= $this->input->post('TxtCatering');
		$menu		= $this->input->post('TxtMenu');

		$Doubledate = $this->input->post('TxtOrderDate');
		$ex_Doubledate = explode(' ', $Doubledate);
		$startdate 	= date('Y-m-d',strtotime($ex_Doubledate[0]));
		$enddate 	= date('Y-m-d',strtotime($ex_Doubledate[2]));

		$bonus 		= $this->input->post('TxtBonus');
		$orderqty 	= $this->input->post('TxtOrderQty');
		$orderprice	= $this->input->post('TxtSinglePrice');
		$fine 		= $this->input->post('TxtFine');
		$pph 		= $this->input->post('TxtPPH');
		$payment	= $this->input->post('TxtTotal');
		$lokasi 	= $this->input->post('slcLocation');

		$this->M_receiptbatch->AddReceipt($id,$no,$date,$place,$from,$signer,$ordertype,$catering,$startdate,$enddate,$orderqty,$orderprice,$fine,$pph,$payment,$menu,$bonus,$lokasi);

		$finedate = $this->input->post('TxtFineDate');

		$fineqty = $this->input->post('TxtFineQty');
		$fineprice = $this->input->post('TxtFinePrice');
		$finetype = $this->input->post('TxtFineType');
		$finedesc = $this->input->post('TxtFineDesc');
		$finenominal = $this->input->post('TxtFineNominal');

		$qty[] = array (
			'receipt_id' => $id,
			'dept' => 'KEUANGAN',
			'qty' => $this->input->post('txtDeptQty1')
		);
		$qty[] = array (
			'receipt_id' => $id,
			'dept' => 'PEMASARAN',
			'qty' => $this->input->post('txtDeptQty2')
		);
		$qty[] = array (
			'receipt_id' => $id,
			'dept' => 'PRODUKSI',
			'qty' => $this->input->post('txtDeptQty3')
		);
		$qty[] = array (
			'receipt_id' => $id,
			'dept' => 'PERSONALIA',
			'qty' => $this->input->post('txtDeptQty4')
		);

		foreach ($qty as $qt) {
			$this->M_receiptbatch->addReceiptQty($qt);
		}

		$i=0;
		foreach($finedate as $loop){
			$finedate[$i] 	= 	date('Y-m-d', strtotime($finedate[$i]));
			$data_fine[$i] = array(
				'receipt_id' 			=> $this->input->post('TxtID'),
				'receipt_fine_date' 	=> $finedate[$i],
				'receipt_fine_qty'		=> $fineqty[$i],
				'receipt_fine_price'	=> $fineprice[$i],
				'fine_type_percentage'	=> $finetype[$i],
				'fine_description'		=> $finedesc[$i],
				'fine_nominal'			=> $finenominal[$i]
			);
			if( !empty($finedate[$i]) && !empty($fineqty[$i]) && !empty($fineprice[$i]) && !empty($finetype[$i]) ){
				$this->M_receiptbatch->AddReceiptFine($data_fine[$i]);
			}
			$i++;
		}
		redirect('CateringManagement/ReceiptBatch');
	}

	public function update()
	{
		$id			= $this->input->post('TxtID');
		$no 		= $this->input->post('TxtNo');

		$date 	= 	date('Y-m-d', strtotime($this->input->post('TxtReceiptDate', TRUE)));

		$place 		= $this->input->post('TxtPlace');
		$from 		= $this->input->post('TxtFrom');
		$signer		= $this->input->post('TxtSigner');
		$ordertype	= $this->input->post('TxtOrderType');
		$catering	= $this->input->post('TxtCatering');
		$menu		= $this->input->post('TxtMenu');

		$Doubledate = $this->input->post('TxtOrderDate');
		$ex_Doubledate = explode(' ', $Doubledate);
		$startdate 	= date('Y-m-d',strtotime($ex_Doubledate[0]));
		$enddate 	= date('Y-m-d', strtotime($ex_Doubledate[2]));

		$bonus 		= $this->input->post('TxtBonus');
		$orderqty 	= $this->input->post('TxtOrderQty');
		$orderprice	= $this->input->post('TxtSinglePrice');
		$fine 		= $this->input->post('TxtFine');
		$pph 		= $this->input->post('TxtPPH');
		$payment	= $this->input->post('TxtTotal');

		$this->M_receiptbatch->UpdateReceipt($id,$no,$date,$place,$from,$signer,$ordertype,$catering,$startdate,$enddate,$orderqty,$orderprice,$fine,$pph,$payment,$menu,$bonus);

		$this->M_receiptbatch->DeleteReceiptFine($id);

		$finedate = $this->input->post('TxtFineDate');

		$fineqty = $this->input->post('TxtFineQty');
		$fineprice = $this->input->post('TxtFinePrice');
		$finetype = $this->input->post('TxtFineType');
		$finedesc = $this->input->post('TxtFineDesc');
		$finenominal = $this->input->post('TxtFineNominal');

		$qty[] = array (
			'receipt_id' => $id,
			'dept' => 'KEUANGAN',
			'qty' => $this->input->post('txtDeptQty1')
		);
		$qty[] = array (
			'receipt_id' => $id,
			'dept' => 'PEMASARAN',
			'qty' => $this->input->post('txtDeptQty2')
		);
		$qty[] = array (
			'receipt_id' => $id,
			'dept' => 'PRODUKSI',
			'qty' => $this->input->post('txtDeptQty3')
		);
		$qty[] = array (
			'receipt_id' => $id,
			'dept' => 'PERSONALIA',
			'qty' => $this->input->post('txtDeptQty4')
		);

		foreach ($qty as $qt) {
			$this->M_receiptbatch->updateReceiptQty($qt,$id);
		}

		$i=0;
		foreach($finedate as $loop){

			$finedate[$i] 	= 	date('Y-m-d', strtotime($finedate[$i]));
			$data_fine[$i] = array(
				'receipt_id' 		=> $this->input->post('TxtID'),
				'receipt_fine_date' 	=> $finedate[$i],
				'receipt_fine_qty'	=> $fineqty[$i],
				'receipt_fine_price'	=> $fineprice[$i],
				'fine_type_percentage'	=> $finetype[$i],
				'fine_description'	=> $finedesc[$i],
				'fine_nominal'		=> $finenominal[$i]
			);
			if( !empty($finedate[$i]) && !empty($fineqty[$i]) && !empty($fineprice[$i]) && !empty($finetype[$i]) ){
				$this->M_receiptbatch->AddReceiptFine($data_fine[$i]);
			}
			$i++;
		}

		redirect('CateringManagement/ReceiptBatch/Details/'.$id);
	}

	public function delete($id)
	{
		$this->M_receiptbatch->DeleteReceipt($id);
		$this->M_receiptbatch->DeleteReceiptQty($id);
		$this->M_receiptbatch->DeleteReceiptFine($id);
		redirect('CateringManagement/Receipt');

	}

	public function checkpph(){
		$id 	= $this->input->post('id');

		$cater_data = $this->M_receiptbatch->GetPphStatus($id);
			foreach($cater_data as $cater){
				echo $cater['pph_value'];
			}
	}

	public function checkfine(){
		$id 	= $this->input->post('id');

		$fine_data = $this->M_receiptbatch->GetFineValue($id);
			foreach($fine_data as $fine){
				echo $fine['percentage'];
			}
	}

	public function checkSession(){
		if($this->session->is_logged){

		}else{
			redirect('');
		}
	}

}

?>