<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_RequestAskanit extends CI_Controller
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
		$data['Menu'] = 'Request Miscellaneous';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        
        $data['view'] = 'Askanit';

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MiscellaneousMng/V_Request', $data);
		$this->load->view('V_Footer',$data);
	}

	
	public function DetailMiscellaneous($no){ // detail askanit, seksi ppc, dan kepala cabang
		$user = $this->session->user;
		$user_id = $this->session->userid;

		$data['Title'] = '';
		$data['Menu'] = 'Request Miscellaneous';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$id_head			= $this->input->post('idheader'.$no.'');
		$data['id_header']	= $id_head;
		$data['no_dokumen'] = $this->input->post('nodoc'.$no.'');
		$data['io'] 		= $this->input->post('io'.$no.'');
		$data['tgl'] 		= $this->input->post('tgl_transact'.$no.'');
		$data['status'] 	= $this->input->post('status'.$no.'');
		$data['requester'] 	= $this->input->post('pic'.$no.'');
		$nama_pic			= $this->M_request->getUser($data['requester']);
		$data['nama_req'] 	= $nama_pic[0]['nama'];
		$data['ket']		= $no;
		
		if(stripos($no, 'Cabang') !== FALSE){ // link untuk submit kepala cabang / showroom
			$data['linkket'] = 'MiscellaneousCabang/Request/submitCabang';
		}elseif(stripos($no, 'Askanit') !== FALSE){ // link untuk submit askanit/ kepala seksi utama
			$data['linkket'] = 'MiscellaneousAskanit/Request/submitAskanit';
		}elseif(stripos($no, 'PPC') !== FALSE){ // link untuk submit seksi ppc
			$data['linkket'] = 'MiscellaneousPPC/Request/submitPPC';
		}elseif(stripos($no, 'Kasie') !== FALSE){ // link untuk submit kepala seksi
			$data['linkket'] = 'MiscellaneousKasie/Request/submitKasie';
		}
		$getdata = $this->M_request->cekitemrequest("where id_header = $id_head order by id_item asc");
		foreach ($getdata as $key => $val) {
			$getdata[$key]['status'] = $this->getStatus2($val['id_item']); // status reject/approve per item
		}
		$data['data'] = $getdata;
		// echo "<pre>";print_r($getdata);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MiscellaneousMng/V_DetailAskanit', $data);
		$this->load->view('V_Footer',$data);
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

	
	public function submitAskanit(){
		$id_header 	= $this->input->post('id_header');
		$id_item 	= $this->input->post('id_item[]');
		$kode_item 	= $this->input->post('kode_item[]');
		$qty 		= $this->input->post('qty[]');
		$uom 		= $this->input->post('uom[]');
		$no_serial 	= $this->input->post('no_serial[]');
		$action 	= $this->input->post('action[]');
		$note 		= $this->input->post('note[]');
		$io 		= $this->input->post('io');
		$pic 		= $this->session->user;
		$tgl 		= date('Y-m-d H:i:s');

		$cost = array();
		$serial = 0; // ket serial awal berarti bukan item serial
		for ($i=0; $i < count($id_item); $i++) { 
			$cek = $this->M_request->getdataAskanit('where id_item = '.$id_item[$i].'');
			if (empty($cek)) {
				$act = empty($action[$i]) ? 'Approve' : $action[$i];
				$this->M_request->saveAskanit($id_item[$i], $act, $note[$i], $pic, $tgl);
				$cost[] = $this->cariItemCost($io, $kode_item[$i], $qty[$i]);
				if ($uom[$i] == 'UNT' && !empty($no_serial[$i])) {
					$serial = 1;
					// $noseri = explode($no_serial[$i]);
					// for ($n=0; $n < count($noseri) ; $n++) { 
					// 	$cek_serial = $this->M_request->cekserialnumber($noseri[$n]);
					// 	$serial = !empty($cek_serial) ? 1 : $serial; // ganti $serial jadi 1 kalau ada item serial
					// }
				}
			}
		}
		
		$ionya = substr($io, 0,1);
		if ($ionya == 'A' || $ionya == 'B' || $ionya == 'G' || $ionya == 'H' || $ionya == 'J' || $ionya == 'K' || $ionya == 'M' || $ionya == 'S' || $ionya == 'U') {
			// jika IO cabang, maka tidak melewati approve PPC
			$jumlah_cost = array_sum($cost);
			if ($serial == 1) { // barang unit berserial number
					$this->M_request->updateHeader('Proses Approve WaKa / Ka. Department', $id_header);
			}else {
				if ($jumlah_cost > 10000000) { // jumlah cost > 10juta
					$this->M_request->updateHeader('Proses Approve WaKa / Ka. Department', $id_header);
				}else {
					$this->M_request->updateHeader('Proses Approve Ka. Seksi Akt Biaya', $id_header);
				}
			}
		}else {
			//bukan IO cabang
			$this->M_request->updateHeader('Proses Approve Seksi PPC', $id_header);
		}


		redirect(base_url("MiscellaneousAskanit/Request"));
	}
	
	public function cariItemCost($io, $item, $qty){
		if ($io != 'OPM' && $io != 'IPM' && $io !== 'OPT') {
			$item_cost = $this->M_request->getItemCostODM($item);
			return !empty($item_cost) ? $item_cost[0]['ITEM_COST'] * $qty : '';
		}else {
			$item_cost = $this->M_request->getItemCostOPM($item);
			return !empty($item_cost) ? $item_cost[0]['ITEM_COST'] * $qty : '';
		}
	}

}