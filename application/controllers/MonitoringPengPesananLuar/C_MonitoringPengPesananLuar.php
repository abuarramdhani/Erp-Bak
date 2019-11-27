<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class C_MonitoringPengPesananLuar extends CI_Controller{
	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        $this->load->helper(array('url','download')); 
          //load the login model
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('MonitoringPengPesananLuar/M_monitoringpengpesananluar');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		date_default_timezone_set('Asia/Jakarta');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
    }
    public function checkSession(){
		if($this->session->is_logged){
			
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
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function rekapPO()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$ambilDataya = $this->M_monitoringpengpesananluar->getData();

		$data['dsh'] = $ambilDataya;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPengPesananLuar/PurchaseOrder/V_RekapPurchaseOrderDsh',$data);
		$this->load->view('V_Footer',$data);
	}

	public function InputPurchaseOrder()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$getCustomer = $this->M_monitoringpengpesananluar->customer();
		$getItem = $this->M_monitoringpengpesananluar->item();
		$data['cust'] = $getCustomer;
		$data['item'] = $getItem;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPengPesananLuar/PurchaseOrder/V_InputPurchaseOrder',$data,array('error' => ' ' ));
		$this->load->view('V_Footer',$data);
	}

	public function getItem()
	{
		$kode_item = $this->input->post('kodeitem');
		$getDeskripsiUom = $this->M_monitoringpengpesananluar->deskripsiUom($kode_item);

		echo json_encode($getDeskripsiUom);
	}

	public function getItemApp()
	{
		$kode_item = $this->input->post('kodeitem');
		$getDeskripsiUom = $this->M_monitoringpengpesananluar->deskripsiUomApp($kode_item);

		echo json_encode($getDeskripsiUom);
	}

	public function getKode()
	{
		$getItem2 = $this->M_monitoringpengpesananluar->item();
		echo json_encode($getItem2);
	}

	public function TambahPengiriman($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$getDataHeader1 = $this->M_monitoringpengpesananluar->headerPengiriman($id);
		$getCustomer5 = $this->M_monitoringpengpesananluar->customer();
		$getItem5 = $this->M_monitoringpengpesananluar->item();
		$getEkspedisi2 = $this->M_monitoringpengpesananluar->ekspedisi();
		$getNomerPO1 = $this->M_monitoringpengpesananluar->getPO2();
		$count_pengiriman1 = $this->M_monitoringpengpesananluar->startCountingTmbh($id);
		$count_pengiriman = $this->M_monitoringpengpesananluar->startCounting($id);
		$entry = $count_pengiriman[0]['count'];
		// echo $entry;exit();
		$getDataLinee3 = $this->M_monitoringpengpesananluar->getDataLinePeng($id,$entry);
		//buat bikin judul di edit pengiriman

		$data['header'] = $getDataHeader1;
		$data['item'] = $getItem5;
		$data['cust'] = $getCustomer5;
		$data['ekspedisi'] = $getEkspedisi2;
		$data['po'] = $getNomerPO1;
		$data['lines'] = $getDataLinee3;
		$data['judul'] = $count_pengiriman1;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPengPesananLuar/Pengiriman/V_TambahPengiriman',$data);
		$this->load->view('V_Footer',$data);
	}

	public function submitPurchaseOrder()
	{
		$usrname = $this->session->user;
		$customer = $this->input->post('txtcustomer');
		$no_po = $this->input->post('txtNoPO');
		$issuedate = $this->input->post('txdIssue');
		$needbydate = $this->input->post('txdNbd');
		$judulFile = $_FILES['txfPdf']['name'];
		$judulFile2 = str_replace(' ', '_', $judulFile);
		$kode_item = $this->input->post('slcKodeItem[]');
		$deskripsi = $this->input->post('txtDeskripsi[]');
		$qty_order = $this->input->post('txnQtyOrder[]');
		$uom = $this->input->post('txtUom[]');

		$saveHeaderPO = $this->M_monitoringpengpesananluar->saveHeaderPo($customer,$no_po,$issuedate,$needbydate,$judulFile2,$usrname);
		$getId = $this->M_monitoringpengpesananluar->getID();
		$id_header = $getId[0]['id'];

		foreach ($deskripsi as $key => $value) {
		$saveLinePO = $this->M_monitoringpengpesananluar->saveLinePo($value,$value,$qty_order[$key],$uom[$key],$id_header,$usrname);
		}

		$config['upload_path']          = './assets/upload/MonitoringPengirimanPesananLuar';
		$config['allowed_types']        = 'pdf|jpg';
		
		$this->load->library('upload', $config);
 
		if ( ! $this->upload->do_upload('txfPdf')){
			$error = array('error' => $this->upload->display_errors());
			echo "File yang diupload harus berformat Pdf atau Jpg!";
		}else{
			$data = array('upload_data' => $this->upload->data());
			redirect('MonitoringPengirimanPesananLuar/RekapPurchaseOrder');
		}

	}

	public function rekapPengiriman()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$getData = $this->M_monitoringpengpesananluar->ambilDataPengiriman();
		$data['send'] = $getData;


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPengPesananLuar/Pengiriman/V_RekapPengiriman',$data);
		$this->load->view('V_Footer',$data);
	}

	public function inputPengiriman()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$getCustomer3 = $this->M_monitoringpengpesananluar->customer();
		$getItem3 = $this->M_monitoringpengpesananluar->item();
		$getEkspedisi = $this->M_monitoringpengpesananluar->ekspedisi();

		$data['item'] = $getItem3;
		$data['cust'] = $getCustomer3;
		$data['ekspedisi'] = $getEkspedisi;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPengPesananLuar/Pengiriman/V_InputPengiriman',$data);
		$this->load->view('V_Footer',$data);
	}

	public function ambilData() 

	{
		$no_po = $this->input->post('no_po');
		$ambilRekapPO = $this->M_monitoringpengpesananluar->ambilRekapPO($no_po);
		$id_rekap_po = $ambilRekapPO[0]['id_rekap_po'];
		$ambilDataAll = $this->M_monitoringpengpesananluar->ambilDataLines($id_rekap_po);
		// echo "<pre>"; print_r($ambilDataAll);exit();
		echo json_encode($ambilDataAll);

	}

	public function ambilDataEdit() 

	{
		$no_po = $this->input->post('no_po');
		$ambilRekapPO = $this->M_monitoringpengpesananluar->ambilRekapPO($no_po);
		$id_rekap_po = $ambilRekapPO[0]['id_rekap_po'];
		$ambilDataAll = $this->M_monitoringpengpesananluar->ambilDataLines($id_rekap_po);
		// echo "<pre>"; print_r($ambilDataAll);exit();
		echo json_encode($ambilDataAll);

	}

	public function download($judul){
   		$file = "assets/upload/MonitoringPengirimanPesananLuar/$judul";
   		force_download($file,NULL);
	}
	public function delete()
   	{
   		$id = $this->input->post('id_rekap_po');
   		$po = $this->input->post('no_po');
   		$cariPengiriman = $this->M_monitoringpengpesananluar->pengiriman($id);
   		
   		if ($cariPengiriman[0]['sum'] !== NULL) {
   		$deletePO = $this->M_monitoringpengpesananluar->deletePo($id);
   		$cari_id_peng = $this->M_monitoringpengpesananluar->cari_Id_Peng($po);
   		$id_peng = $cari_id_peng[0]['id'];
   		$deletePengiriman = $this->M_monitoringpengpesananluar->deletePeng($id_peng);
   		$updateStatusOpen = $this->M_monitoringpengpesananluar->insertStatusOpen($id);
   		echo "pake pengiriman";

   		} else if ($cariPengiriman[0]['sum'] == NULL) {
		$deletePO = $this->M_monitoringpengpesananluar->deletePo($id);
   			echo " GA pake pengiriman";
   		}

   	}
   	public function delete2()
   	{
   		$id = $this->input->post('id_rekap_pengiriman');
   		$cariId_PO = $this->M_monitoringpengpesananluar->cariIDPO($id);
   		$id_po = $cariId_PO[0]['id'];
   		$updateStatusOpen = $this->M_monitoringpengpesananluar->insertStatusOpen($id_po);
   		$deletePO = $this->M_monitoringpengpesananluar->deletePeng($id);
   	}

   	public function openModalPO()
   	{
   		$id = $this->input->post('id');
   		$tarikdataPo = $this->M_monitoringpengpesananluar->tarikdatamodal($id);
   		$data['mdl'] = $tarikdataPo;

   		if (!empty($data['mdl'])) {
				
			 $this->load->view('MonitoringPengPesananLuar/PurchaseOrder/V_mdlRekapPO',$data);
			}else{
			echo "<script> Swal.fire({
  									type: 'error',
  									title: 'Maaf...',
 									text: 'Data Kosong',
									}) </script>";
			echo "<script>$('#mdlDetailPo').modal('hide')</script>";
			}

   	}

   	public function edit($id)
   	{
   		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		// $id = $this->input->post('id');

		$getDataEdit = $this->M_monitoringpengpesananluar->editData($id);
		$getLineEdit = $this->M_monitoringpengpesananluar->dataLine($id);
		$getCustomer2 = $this->M_monitoringpengpesananluar->customer();
		$getItem2 = $this->M_monitoringpengpesananluar->item();

		$data['item'] = $getItem2;
		$data['cust'] = $getCustomer2;
		$data['edit'] = $getDataEdit;
		$data['line'] = $getLineEdit;

		// $this->load->view('MonitoringPengPesananLuar/V_EditPurchaseOrder',$data);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPengPesananLuar/PurchaseOrder/V_EditPurchaseOrder',$data,array('error' => ' ' ));
		$this->load->view('V_Footer',$data);

   	}

   	public function updatePurchaseOrder($id)
   	{
   		$usrname = $this->session->user;
		$customer = $this->input->post('txtcustomerUpd');
		$no_po = $this->input->post('txtNoPOUpd');
		$issuedate = $this->input->post('txdIssueUpd');
		$needbydate = $this->input->post('txdNbdUpd');
		$judulCdgn = $this->input->post('txhJudul');
		$judulFile = $_FILES['txfPdf2']['name'][0];
		$judulFile2 = str_replace(' ', '_', $judulFile);
		$kode_item = $this->input->post('slcKodeItemUpd[]');
		$deskripsi = $this->input->post('txtDeskripsiUpd[]');
		$qty_order = $this->input->post('txnQtyOrderUpd[]');
		$uom = $this->input->post('txtUomUpd[]');

		if (empty($_FILES['txfPdf2']['name'][0])) {
		// echo "judul file 0";
		$updateHeaderPO = $this->M_monitoringpengpesananluar->updateHeaderPo($customer,$no_po,$issuedate,$needbydate,$judulCdgn,$usrname, $id);
		} else if (!empty($_FILES['txfPdf2']['name'][0])){
		// echo "judul file != 0";
		$updateHeaderPO = $this->M_monitoringpengpesananluar->updateHeaderPo($customer,$no_po,$issuedate,$needbydate,$judulFile2,$usrname, $id);
		}
		// echo "<pre>";print_r($_POST);print_r($_FILES['txfPdf2']['name'][0]);exit();
		$deleteLines = $this->M_monitoringpengpesananluar->hapusLine($id);

		foreach ($deskripsi as $key => $value) {
		$saveLinePO = $this->M_monitoringpengpesananluar->insertLines($value,$value,$qty_order[$key],$uom[$key],$id,$usrname);
		}

		$config['upload_path']          = './assets/upload/MonitoringPengirimanPesananLuar';
		$config['allowed_types']        = 'pdf|jpg';
		
		$this->load->library('upload', $config);
 
		if ( ! $this->upload->do_upload('txfPdf')){
			$error = array('error' => $this->upload->display_errors());
			redirect('MonitoringPengirimanPesananLuar/RekapPurchaseOrder');
		}else{
			$data = array('upload_data' => $this->upload->data());
			redirect('MonitoringPengirimanPesananLuar/RekapPurchaseOrder');
		}

	}

	public function selectPO()
	{
		$id_cust = $this->input->post('id');
		$ambilNoPOdariId = $this->M_monitoringpengpesananluar->getPO($id_cust);
		echo json_encode($ambilNoPOdariId);
	}

	public function submitInputPengiriman()
	{
   		$usrname = $this->session->user;
		$customer = $this->input->post('customer');
		$no_po = $this->input->post('no_po');
		$no_so = $this->input->post('no_so');
		$no_dosp = $this->input->post('no_dosp');
		$keterangan = $this->input->post('keterangan');
		$ekspedisi = $this->input->post('ekspedisi');
		$delivery_date = $this->input->post('delivery_date');
		echo $delivery_date;
		//ARRAY BELOW
		$kodeitem = $this->input->post('kodeitem');
		$nama_item = $this->input->post('nama_item');
		$ordered = $this->input->post('ordered');
		$delivered = $this->input->post('delivered');
		$acc = $this->input->post('acc');
		$outpo = $this->input->post('outpo');
		$uom = $this->input->post('uom');


		$saveHeaderIp = $this->M_monitoringpengpesananluar->saveIP($delivery_date,$customer,$no_po,$no_so,$no_dosp,$keterangan,$ekspedisi,$usrname);
		$getIdHeader = $this->M_monitoringpengpesananluar->IdHeader();
		$idHeaderYa = $getIdHeader[0]['id'];

		$getNoRekap = $this->M_monitoringpengpesananluar->cariRekapPo($no_po);
		$idNomerRekap = $getNoRekap[0]['id'];
		$saveJudul = $this->M_monitoringpengpesananluar->saveJudul($idHeaderYa,$no_po,$customer);


		foreach ($kodeitem as $key => $value) {
			$saveLineIp = $this->M_monitoringpengpesananluar->saveLineIp($value,$nama_item[$key],$ordered[$key],$delivered[$key],$acc[$key],$outpo[$key],$uom[$key],$idHeaderYa,$idNomerRekap,$usrname);
			// $id_line_rp = $saveLineIp[0]['id_line_rp'];
			// print_r($saveLineIp[0]['id_line_rp']);
			// print_r($kodeitem);

			$insertActionDetail = $this->M_monitoringpengpesananluar->saveActionDetail($delivery_date,$value,$delivered[$key],$no_po,$idHeaderYa,$uom[$key],$ordered[$key],$nama_item[$key],$acc[$key],$outpo[$key],$no_so,$no_dosp,$keterangan,$ekspedisi,$saveLineIp[$key]['id_line_rp']);
		}

		$check_OutPO = $this->M_monitoringpengpesananluar->ambilSummary($idHeaderYa);
		// print_r($check_OutPO);

		if ($check_OutPO[0]['outstanding_qty'] == 0) {
			$saveStatus = $this->M_monitoringpengpesananluar->saveStatusPO($no_po);
			echo "berhasil";
		} else if ($check_OutPO[0]['outstanding_qty'] !== 0) {
			echo "gagal cek po";
		}

	}

	public function editInputPengiriman()
	{
		$id_rekap_pengiriman = $this->input->post('id_rekap_pengiriman');
		$no_po = $this->input->post('no_po');
		$id_cust = $this->input->post('customer');
		$no_dosp = $this->input->post('no_dosp');
		$no_soo = $this->input->post('no_so');
		$no_so = str_replace(' ', '', $no_soo);
		$keterangan = $this->input->post('keterangan');
		$id_ekspedisi = $this->input->post('id_ekspedisi');
		$delivery_date = $this->input->post('delivery_date');

		$kodeitem = $this->input->post('kodeitem');
		$nama_item = $this->input->post('nama_item');
		$ordered = $this->input->post('ordered');
		$delivered = $this->input->post('delivered');
		$acc = $this->input->post('acc');
		$outpo = $this->input->post('outpo');
		$uom = $this->input->post('uom');
		$id_line = $this->input->post('id_line');
		$id_action = $this->input->post('id_action');
		$entryy = $this->M_monitoringpengpesananluar->getEntry2($id_rekap_pengiriman);
		$entry = $entryy[0]['entry'];
		// echo "<pre>";print_r($_POST);
		// $lihat_entry = $this->M_monitoringpengpesananluar->

		$UpdateHeaderIp = $this->M_monitoringpengpesananluar->UpdateHeaderIp($no_dosp,$no_so,$keterangan,$id_ekspedisi,$delivery_date,$id_rekap_pengiriman);
		foreach ($kodeitem as $key => $value) {
			$UpdateLineIp = $this->M_monitoringpengpesananluar->UpdateLineIp($value,$nama_item[$key],$ordered[$key],$delivered[$key],$acc[$key],$outpo[$key],$uom[$key],$id_line[$key]);
			$insertActionDetail = $this->M_monitoringpengpesananluar->UpdateActionDetail($delivery_date,$value,$delivered[$key],$no_po,$id_rekap_pengiriman,$uom[$key],$ordered[$key],$nama_item[$key],$acc[$key],$outpo[$key],$no_so,$no_dosp,$keterangan,$id_ekspedisi,$entry,$id_action[$key],$id_line[$key]);
		}
		
		$check_OutPO = $this->M_monitoringpengpesananluar->ambilSummary($id_rekap_pengiriman);
		// print_r($check_OutPO);

		if ($check_OutPO[0]['outstanding_qty'] == 0) {
			$saveStatus = $this->M_monitoringpengpesananluar->saveStatusPO($no_po);
		} else if ($check_OutPO[0]['outstanding_qty'] !== 0) {
			echo "gagal cek po";
		}

		// $saveJudul = $this->M_monitoringpengpesananluar->saveJudul($id_rekap_pengiriman,$no_po,$id_cust);
	}

	public function tambahInputPengiriman()
	{
		$id_rekap_pengiriman = $this->input->post('id_rekap_pengiriman');
		$no_po = $this->input->post('no_po');
		$id_cust = $this->input->post('customer');
		$no_dosp = $this->input->post('no_dosp');
		$no_soo = $this->input->post('no_so');
		$no_so = str_replace(' ', '', $no_soo);
		$keterangan = $this->input->post('keterangan');
		$id_ekspedisi = $this->input->post('id_ekspedisi');
		$delivery_date = $this->input->post('delivery_date');

		$kodeitem = $this->input->post('kodeitem');
		$nama_item = $this->input->post('nama_item');
		$ordered = $this->input->post('ordered');
		$delivered = $this->input->post('delivered');
		$acc = $this->input->post('acc');
		$outpo = $this->input->post('outpo');
		$uom = $this->input->post('uom');
		$id_line = $this->input->post('id_line');
		$id_action = $this->input->post('id_action');
		$entryy = $this->M_monitoringpengpesananluar->getEntry($id_rekap_pengiriman);
		$entry = $entryy[0]['entry'];
		// echo "<pre>";print_r($_POST);
		// $lihat_entry = $this->M_monitoringpengpesananluar->

		$UpdateHeaderIp = $this->M_monitoringpengpesananluar->UpdateHeaderIp($no_dosp,$no_so,$keterangan,$id_ekspedisi,$delivery_date,$id_rekap_pengiriman);
		foreach ($kodeitem as $key => $value) {
			$UpdateLineIp = $this->M_monitoringpengpesananluar->UpdateLineIp($value,$nama_item[$key],$ordered[$key],$delivered[$key],$acc[$key],$outpo[$key],$uom[$key],$id_line[$key]);
			$insertActionDetail = $this->M_monitoringpengpesananluar->SaveActionDetail2($delivery_date,$value,$delivered[$key],$no_po,$id_rekap_pengiriman,$uom[$key],$ordered[$key],$nama_item[$key],$acc[$key],$outpo[$key],$no_so,$no_dosp,$keterangan,$id_ekspedisi,$id_line[$key],$entry);

			//$kodeitem, $delivered_qty, $no_po, $id_rekap_pengiriman, $uom, $ordered_qty, $nama_item, $accumulation, $outstanding_qty, $no_so, $no_dosp, $keterangan, $id_ekspedisi,$id_line_rp,$entry
		}
		
		$check_OutPO = $this->M_monitoringpengpesananluar->ambilSummary($id_rekap_pengiriman);
		// print_r($check_OutPO);

		if ($check_OutPO[0]['outstanding_qty'] == 0) {
			$saveStatus = $this->M_monitoringpengpesananluar->saveStatusPO($no_po);
		} else if ($check_OutPO[0]['outstanding_qty'] !== 0) {
			echo "gagal cek po";
		}

		$saveJudul = $this->M_monitoringpengpesananluar->saveJudul($id_rekap_pengiriman,$no_po,$id_cust);
	}

	public function history()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$getData = $this->M_monitoringpengpesananluar->ambilDataHistory();
		$data['send'] = $getData;


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPengPesananLuar/History/V_History',$data);
		$this->load->view('V_Footer',$data);
	}

	public function exportExcel()
	{
		$date = date('d-m-Y');
		$ichi = $this->input->post('txtFilterAwalTIS'); 
		$ni = $this->input->post('txtFilterAkhirTIS');
		$parameter = '';

		if ($ichi != '' OR $ni != NULL) {
			$parameter .= "AND dpo.tanggal_issued between '$ichi' and '$ni'";
		}
		
		$this->load->library('Excel');
		$objPHPExcel = new PHPExcel();
		$style_col = array(
          'font' => array('bold' => true),
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
          )
        );
        $style_row = array(
          'alignment' => array(
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
          )
        );
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REPORT Monitoring Purchase Order (MPPL)");
        $objPHPExcel->getActiveSheet()->mergeCells('A1:L2');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "Tanggal Issue : ".$ichi.' s/d '.$ni);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', "No");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4', "Customer");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', "Order Number");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D4', "Issue Date");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4', "Need By Date");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4', "Qty Order");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4', "Nama Item");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H4', "Kode Item");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I4', "UOM");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J4', "Open/Close");
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(2);
        $objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
        foreach(range('B','J') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle($columnID.'4')->applyFromArray($style_col);
        }
        foreach(range('A','I') as $columnID) {
            $objPHPExcel->getActiveSheet()->getStyle($columnID)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
        $fetch = $this->M_monitoringpengpesananluar->tarikdataExcel($parameter);
        $no = 1;
        $numrow = 5;
        foreach($fetch as $data){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['nama_customer']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data['no_po']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data['tanggal_issued']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data['need_by_date']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data['ordered_qty']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data['nama_item']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data['kode_item']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $data['uom']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $data['status']);
            
            $objPHPExcel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);

            
            $no++;
            $numrow++;
        }
        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle('Report Shipment Marketing');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Report_Purchase_Order_MPPL_'.$ichi.' s/d '.$ni.'.xlsx"');
		ob_end_clean();
		ob_start();
		$objWriter->save('php://output');

	}

	public function exportExcelPengiriman()
	{
		$date = date('d-m-Y');
		$ichi = $this->input->post('txtFilterAwalIp'); 
		$ni = $this->input->post('txtFilterAkhirIp');
		$parameter = '';

		if ($ichi != '' OR $ni != NULL) {
			$parameter .= "where a.delivery_date between '$ichi' and '$ni'";
		}
		
		$this->load->library('Excel');
		$objPHPExcel = new PHPExcel();
		$style_col = array(
          'font' => array('bold' => true),
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
          )
        );
        $style_row = array(
          'alignment' => array(
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
          )
        );
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REPORT Monitoring Pengiriman (MPPL)");
        $objPHPExcel->getActiveSheet()->mergeCells('A1:P2');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "Tanggal Issue : ".$ichi.' s/d '.$ni);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', "No");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4', "Customer");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', "No. PO");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D4', "Issue Date");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4', "Need By Date");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4', "Delivery Date");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4', "Nomor SO");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H4', "Nomor DOSP");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I4', "Pengiriman ke-");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J4', "Keterangan");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K4', "Nama Ekspedisi");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L4', "Kode Item");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M4', "Nama Item");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N4', "Ordered Qty");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O4', "UOM");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P4', "Outstanding Qty");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q4', "Accumulation");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R4', "Delivered Qty");

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(2);
        $objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
        foreach(range('B','R') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle($columnID.'4')->applyFromArray($style_col);
        }
        foreach(range('A','Q') as $columnID) {
            $objPHPExcel->getActiveSheet()->getStyle($columnID)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
        $fetch = $this->M_monitoringpengpesananluar->tarikdataExcelPeng($parameter);
        $no = 1;
        $numrow = 5;
        foreach($fetch as $data){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['nama_customer']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data['no_po']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data['tanggal_issued']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data['need_by_date']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data['delivery_date']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data['no_so']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data['no_dosp']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $data['entry']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $data['keterangan']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $data['nama_ekspedisi']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $data['kode_item']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $data['nama_item']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $data['ordered_qty']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, $data['uom']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, $data['outstanding_qty']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$numrow, $data['accumulation']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$numrow, $data['delivered_qty']);

            
            $objPHPExcel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('O'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('P'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('Q'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('R'.$numrow)->applyFromArray($style_row);


            
            $no++;
            $numrow++;
        }
        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle('Report Shipment Marketing');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Report_Pengiriman_MPPL_'.$ichi.' s/d '.$ni.'.xlsx"');
		ob_end_clean();
		ob_start();
		$objWriter->save('php://output');

	}

	public function openModalPengiriman()
	{
		$id_rekap_pengiriman = $this->input->post('id');
		$ambilDetailPengiriman = $this->M_monitoringpengpesananluar->getDataDetail($id_rekap_pengiriman);
		$judul_mdl = $this->M_monitoringpengpesananluar->startCountingDsh($id_rekap_pengiriman);
		$data['detail'] = $ambilDetailPengiriman;
		$data['judul'] = $judul_mdl;
		if (!empty($data['detail'])) {
				
			 $this->load->view('MonitoringPengPesananLuar/Pengiriman/V_mdlRekapPeng',$data);
			}else{
			echo "<script> Swal.fire({
  									type: 'error',
  									title: 'Maaf...',
 									text: 'Data Kosong',
									}) </script>";
			echo "<script>$('#mdlPengiriman').modal('hide')</script>";
			}
	}

	public function openHistoryPengiriman()
	{
		$id_rekap_pengiriman = $this->input->post('id');
		$ambilHistory = $this->M_monitoringpengpesananluar->getHistory($id_rekap_pengiriman);
		$data['hiss'] = $ambilHistory;

		if (!empty($data['hiss'])) {
			 $this->load->view('MonitoringPengPesananLuar/Pengiriman/V_mdlHistory',$data);
			}else{
			echo "<script> Swal.fire({
  									type: 'error',
  									title: 'Maaf...',
 									text: 'Data Kosong',
									}) </script>";
			echo "<script>$('#mdlPengiriman').modal('hide')</script>";
			}
	}

	public function editPeng($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$getDataHeader = $this->M_monitoringpengpesananluar->headerPengiriman($id);
		$getCustomer4 = $this->M_monitoringpengpesananluar->customer();
		$getItem4 = $this->M_monitoringpengpesananluar->item();
		$getEkspedisi1 = $this->M_monitoringpengpesananluar->ekspedisi();
		$getNomerPO = $this->M_monitoringpengpesananluar->getPO2();
		//buat bikin judul di edit pengiriman
		$count_pengiriman = $this->M_monitoringpengpesananluar->startCounting($id);
		$entry = $count_pengiriman[0]['count'];
		// echo $entry;exit();
		$getDataLinee2 = $this->M_monitoringpengpesananluar->getDataLinePeng($id,$entry);

		$data['header'] = $getDataHeader;
		$data['item'] = $getItem4;
		$data['cust'] = $getCustomer4;
		$data['ekspedisi'] = $getEkspedisi1;
		$data['po'] = $getNomerPO;
		$data['lines'] = $getDataLinee2;
		$data['judul'] = $count_pengiriman;


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPengPesananLuar/Pengiriman/V_EditPengiriman',$data);
		$this->load->view('V_Footer',$data);
	}

	public function editPeng2($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$getDataHeader = $this->M_monitoringpengpesananluar->headerPengiriman($id);
		$getCustomer4 = $this->M_monitoringpengpesananluar->customer();
		$getItem4 = $this->M_monitoringpengpesananluar->item();
		$getEkspedisi1 = $this->M_monitoringpengpesananluar->ekspedisi();
		$getNomerPO = $this->M_monitoringpengpesananluar->getPO2();
		//buat bikin judul di edit pengiriman
		$count_pengiriman = $this->M_monitoringpengpesananluar->startCounting($id);
		$entry = $count_pengiriman[0]['count'];
		// echo $entry;exit();
		$getDataLinee2 = $this->M_monitoringpengpesananluar->getDataLinePeng($id,$entry);

		$data['header'] = $getDataHeader;
		$data['item'] = $getItem4;
		$data['cust'] = $getCustomer4;
		$data['ekspedisi'] = $getEkspedisi1;
		$data['po'] = $getNomerPO;
		$data['lines'] = $getDataLinee2;
		$data['judul'] = $count_pengiriman;


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPengPesananLuar/Pengiriman/V_EditPengiriman2',$data);
		$this->load->view('V_Footer',$data);
	}

	public function setting_item()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$getListItem = $this->M_monitoringpengpesananluar->ambilListItem();
		/*$getCustomer5 = $this->M_monitoringpengpesananluar->customer();
		$getItem5 = $this->M_monitoringpengpesananluar->item();
		$getEkspedisi2 = $this->M_monitoringpengpesananluar->ekspedisi();
		$getNomerPO1 = $this->M_monitoringpengpesananluar->getPO2();
		$count_pengiriman1 = $this->M_monitoringpengpesananluar->startCountingTmbh($id);
		$count_pengiriman = $this->M_monitoringpengpesananluar->startCounting($id);
		$entry = $count_pengiriman[0]['count'];
		// echo $entry;exit();
		$getDataLinee3 = $this->M_monitoringpengpesananluar->getDataLinePeng($id,$entry);
		//buat bikin judul di edit pengiriman*/

		$data['settem'] = $getListItem;
		// $data['item'] = $getItem5;
		// $data['cust'] = $getCustomer5;
		// $data['ekspedisi'] = $getEkspedisi2;
		// $data['po'] = $getNomerPO1;
		// $data['lines'] = $getDataLinee3;
		// $data['judul'] = $count_pengiriman1;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPengPesananLuar/Setting/V_SettingItem',$data);
		$this->load->view('V_Footer',$data);
	}

	public function setting_ekspedisi()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$getLisEkspedisi = $this->M_monitoringpengpesananluar->ambilListEkspedisi();
		/*$getCustomer5 = $this->M_monitoringpengpesananluar->customer();
		$getItem5 = $this->M_monitoringpengpesananluar->item();
		$getEkspedisi2 = $this->M_monitoringpengpesananluar->ekspedisi();
		$getNomerPO1 = $this->M_monitoringpengpesananluar->getPO2();
		$count_pengiriman1 = $this->M_monitoringpengpesananluar->startCountingTmbh($id);
		$count_pengiriman = $this->M_monitoringpengpesananluar->startCounting($id);
		$entry = $count_pengiriman[0]['count'];
		// echo $entry;exit();
		$getDataLinee3 = $this->M_monitoringpengpesananluar->getDataLinePeng($id,$entry);
		//buat bikin judul di edit pengiriman*/

		$data['seteks'] = $getLisEkspedisi;
		// $data['item'] = $getItem5;
		// $data['cust'] = $getCustomer5;
		// $data['ekspedisi'] = $getEkspedisi2;
		// $data['po'] = $getNomerPO1;
		// $data['lines'] = $getDataLinee3;
		// $data['judul'] = $count_pengiriman1;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPengPesananLuar/Setting/V_SettingEkspedisi',$data);
		$this->load->view('V_Footer',$data);
	}

	public function setting_cust()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$getListCustomer = $this->M_monitoringpengpesananluar->ambilListCustomer();
		/*$getCustomer5 = $this->M_monitoringpengpesananluar->customer();
		$getItem5 = $this->M_monitoringpengpesananluar->item();
		$getEkspedisi2 = $this->M_monitoringpengpesananluar->ekspedisi();
		$getNomerPO1 = $this->M_monitoringpengpesananluar->getPO2();
		$count_pengiriman1 = $this->M_monitoringpengpesananluar->startCountingTmbh($id);
		$count_pengiriman = $this->M_monitoringpengpesananluar->startCounting($id);
		$entry = $count_pengiriman[0]['count'];
		// echo $entry;exit();
		$getDataLinee3 = $this->M_monitoringpengpesananluar->getDataLinePeng($id,$entry);
		//buat bikin judul di edit pengiriman*/

		$data['setcus'] = $getListCustomer;
		// $data['item'] = $getItem5;
		// $data['cust'] = $getCustomer5;
		// $data['ekspedisi'] = $getEkspedisi2;
		// $data['po'] = $getNomerPO1;
		// $data['lines'] = $getDataLinee3;
		// $data['judul'] = $count_pengiriman1;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPengPesananLuar/Setting/V_SettingCustomer',$data);
		$this->load->view('V_Footer',$data);
	}

	public function SaveItem()
	{
		$kode_item = $this->input->post('kodeitem');
		$nama_item = $this->input->post('namaitem');
		$uom = $this->input->post('uom');

		$saveSettingItem = $this->M_monitoringpengpesananluar->saveSetItem($kode_item,$nama_item,$uom);
	}

	public function SaveCustomer()
	{
		$nama_customer = $this->input->post('namacustomer');
		
		$saveSettingCustomer = $this->M_monitoringpengpesananluar->saveSetCustomer($nama_customer);
	}

	public function SaveEkspedisi()
	{
		$nama_ekspedisi = $this->input->post('namaekspedisi');

		$saveSettingEkspedisi = $this->M_monitoringpengpesananluar->saveSetEkspedisi($nama_ekspedisi);
	}

	public function deleteItem()
	{
		$id_kode_item = $this->input->post('id_kode_item');

		$hapusItem = $this->M_monitoringpengpesananluar->deleteItem($id_kode_item);
	}

	public function deleteEkspedisi()
	{
		$id_ekspedisi = $this->input->post('id_ekspedisi');

		$hapusEkspedisi = $this->M_monitoringpengpesananluar->deleteEkspedisi($id_ekspedisi);
	}

	public function deleteCustomer()
	{
		$id_customer = $this->input->post('id_customer');

		$hapusCustomer = $this->M_monitoringpengpesananluar->deleteCustomer($id_customer);
	}

	public function ModalItem()
	{
		$id_kode_item = $this->input->post('id_kode_item');
		$openDetail = $this->M_monitoringpengpesananluar->ambilDataItem($id_kode_item);
		$data['item'] = $openDetail;

		$this->load->view('MonitoringPengPesananLuar/Setting/V_mdlItem', $data);
	}

	public function ModalCustomer()
	{
		$id_customer = $this->input->post('id_customer');
		$openDetail = $this->M_monitoringpengpesananluar->ambilDataCustomer($id_customer);
		$data['customer'] = $openDetail;

		$this->load->view('MonitoringPengPesananLuar/Setting/V_mdlCustomer', $data);
	}

	public function ModalEkspedisi()
	{
		$id_ekspedisi = $this->input->post('id_ekspedisi');
		$openDetail = $this->M_monitoringpengpesananluar->ambilDataEkspedisi($id_ekspedisi);
		$data['ekspedisi'] = $openDetail;

		$this->load->view('MonitoringPengPesananLuar/Setting/V_mdlEkspedisi', $data);
	}

	public function UpdateItem()
	{
		$id_kode_item = $this->input->post('id_kode_item');
		$kode_item = strtoupper($this->input->post('kode_item'));
		$nama_item = strtoupper($this->input->post('nama_item'));
		$uom = strtoupper($this->input->post('uom'));

		// echo "<pre>";print_r($_POST);exit();

		$updateSetting = $this->M_monitoringpengpesananluar->UpdateItem($id_kode_item,$kode_item,$nama_item,$uom);

	}

	public function UpdateEkspedisi()
	{
		$id_ekspedisi = $this->input->post('id_ekspedisi');
		$nama_ekspedisi = strtoupper($this->input->post('nama_ekspedisi'));

		$updateSetting = $this->M_monitoringpengpesananluar->UpdateEkspedisi($id_ekspedisi,$nama_ekspedisi);
	}
	

	public function UpdateCustomer()
	{
		$id_customer = $this->input->post('id_customer');
		$nama_customer = strtoupper($this->input->post('nama_customer'));

		$updateSetting = $this->M_monitoringpengpesananluar->UpdateCustomer($id_customer,$nama_customer);
	}

}
?>