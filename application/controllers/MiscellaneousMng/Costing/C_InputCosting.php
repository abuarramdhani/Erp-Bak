<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_InputCosting extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('PHPMailerAutoload');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MiscellaneousMng/M_request');
		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = '';
		$data['Menu'] = 'Request Siap Input';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        
		$data['view'] = 'inputCosting';

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MiscellaneousMng/V_Request', $data);
		$this->load->view('V_Footer',$data);
		}
		
	public function DetailMiscellaneous($no){
		$user = $this->session->user;
		$user_id = $this->session->userid;

		$data['Title'] = '';
		$data['Menu'] = 'Request Siap Input';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$id_head			= $this->input->post('idheader'.$no.'');
		$data['id_header']	= $id_head;
		$data['no_dokumen'] = $this->input->post('nodoc'.$no.'');
		$data['io'] 		= $this->input->post('io'.$no.'');
		$branch 			= $this->M_request->getBranchIO($data['io']); //cari branch berdasarkan io -> untuk COA
		$data['branch'] 	= !empty($branch) ? $branch[0]['BRANCH'] : '';
		$data['tgl'] 		= $this->input->post('tgl_transact'.$no.'');
		$data['status'] 	= $this->input->post('status'.$no.'');
		$data['requester'] 	= $this->input->post('pic'.$no.'');
		$nama_pic			= $this->M_request->getUser($data['requester']);
		$data['nama_req'] 	= $nama_pic[0]['nama'];
		$data['ket']		= $no;
		$getdata = $this->M_request->cekitemrequest("where id_header = $id_head order by id_item asc");
		foreach ($getdata as $key => $val) {
			// status :
			// tabel siap input = kalau reject ambil data notenya, kalau approve notenya kosong
			// tabel finished = kalau reject ambil data pic reject, kalau approve notenya kosong
			$status = stripos($no, 'siapinputCosting') !== FALSE ? $this->getStatus2($val['id_item']) : $this->getStatus3($val['id_item']);
			$getdata[$key]['status'] = $status; //status approve/reject per item
			if ($status == '') { // tidak reject
				$getdata[$key]['coaa'] 	= $this->buatCOAyuk($val['kode_item'], $val['cost_center']);
			}
		}
		$data['data'] = $getdata;
		
		$data['linkket'] = 'MiscellaneousCosting/Input'; //link back
		if (stripos($no, 'siapinputCosting') !== FALSE) {
			$tujuan = 'V_DetailSiapInput';
		}elseif( stripos($no, 'finishedCosting') !== FALSE) {
			$tujuan = 'V_DetailCosting';
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MiscellaneousMng/'.$tujuan.'', $data);
		$this->load->view('V_Footer',$data);
	}
	
	public function buatCOAyuk($item, $cost){
		//urutan COA
		//company(1) - branch - account(isi manual) - cost center - product - region(000) - future(000)
		$kode = substr($item,0,3);
		if ($kode == 'AAA' || $kode == 'AAB' || $kode == 'AAC' || $kode == 'AGC' || $kode == 'ADA' || $kode == 'AFA') {
			$kode = $kode;
		}else {
			$kode = '000';
		}
		$coa = '-'.$cost.'-'.$kode.'-000-000';
		return $coa;
	}
	
	public function getStatus2($id){
		$reject = '';
		$cari = $this->M_request->cariReject($id);
		// echo "<pre>";print_r($cari);exit();
		if ($cari[0]['pic'] != '') {
			$reject = 'Reject|'.$cari[0]['note'];
		}
		return $reject;
	}

	
	public function getStatus3($id){
		$reject = '';
		$cari = $this->M_request->cariReject($id);
		// echo "<pre>";print_r($cari);exit();
		if ($cari[0]['pic'] != '') {
			$pic = $this->M_request->getUser($cari[0]['pic']);
			$reject = 'Reject by '.$pic[0]['nama'];
		}
		return $reject;
	}
	
	public function inputCosting(){
		$id_header 		= $this->input->post('id_header');
		$no_dokumen	 	= $this->input->post('no_dokumen');
		$io	 			= $this->input->post('io');
		$inv_id 		= $this->input->post('inv_id[]');
		$uom 			= $this->input->post('uom[]');
		$qty 			= $this->input->post('qty[]');
		$locator 		= $this->input->post('locator[]');
		$inventory 		= $this->input->post('inventory[]');
		$tipe_transaksi = $this->input->post('tipe_transaksi[]');
		$branch 		= $this->input->post('branch[]');
		$account 		= $this->input->post('account[]');
		$cost_center 	= $this->input->post('cost_center[]');
		$jenis 			= $this->input->post('jenis[]');
		$id_item 		= $this->input->post('id_item[]');
		$action 		= $this->input->post('action[]');
		$reference 		= $this->input->post('referensi[]');
		$status 		= $this->input->post('status[]');
		$no_serial 		= $this->input->post('no_serial[]');
		$pic 			= $this->session->user;
		$tgl 			= date('Y-m-d H:i:s');
		$user_id 		= 5182;
		// echo "<pre>";print_r($reference);exit();
		$ket = 0;
		for ($x=0; $x < count($inv_id); $x++) { 
			if ($action[$x] == 'Input Oracle') {
				$org_id = $this->M_request->getOrgID($io);
				$org_id = $org_id ? $org_id[0]['ORGANIZATION_ID'] : 'NULL';
				$lokator_id = $this->M_request->getLokatorID($locator[$x]);
				$lokator_id = $lokator_id ? $lokator_id[0]['INVENTORY_LOCATION_ID'] : 'NULL';
				$type_transact_id = $this->M_request->getTypeTransact($tipe_transaksi[$x]);
				$type_transact_id = $type_transact_id[0]['TRANSACTION_TYPE_ID'];

				$quantity = $jenis[$x] == 'ISSUE' ? $qty[$x]*-1 : $qty[$x];
				$this->M_request->InputOracle($uom[$x], $lokator_id, $user_id, $inv_id[$x], $inventory[$x], $org_id, $no_dokumen, $quantity, $type_transact_id, strtoupper($reference[$x]), $branch[$x], $account[$x], $cost_center[$x]);
				$insertMSNI = $this->insertMSNI($no_dokumen, $inv_id[$x], $no_serial[$x]);
				
				$this->M_request->runApi($user_id);
				$ket = 1;
			}
		}

		// if ($ket == 1) {
		// 	$this->M_request->runApi($user_id);
		// }

		for ($i=0; $i < count($id_item); $i++) { 
			$cek = $this->M_request->getdataCostingInput('where id_item = '.$id_item[$i].'');
			if (empty($cek)) {
				$this->M_request->saveCostingInput($id_item[$i], $action[$i], $reference[$i], $pic, $tgl);
			}
		}
		$this->M_request->updateHeader('Finished', $id_header);

		redirect(base_url("MiscellaneousCosting/Input"));
	}

	public function insertMSNI($no_dokumen, $inv_id,$no_serial){
		$cek_mti = $this->M_request->cekMTI($no_dokumen, $inv_id);
		if (empty($cek_mti[0]['TRANSACTION_INTERFACE_ID'])) {
			$this->insertMSNI($no_dokumen, $inv_id,$no_serial);
		}else {
			$mti_id = $cek_mti[0]['TRANSACTION_INTERFACE_ID'];
			$serial = explode('; ', $no_serial);
			for ($s=0; $s < count($serial) ; $s++) { 
				$this->M_request->InputSerial($mti_id, $serial[$s]);
			}
		}
	}


    
}