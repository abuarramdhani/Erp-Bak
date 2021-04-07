<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_RequestPPC extends CI_Controller
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
        
        $data['view'] = 'PPC';

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MiscellaneousMng/V_Request', $data);
		$this->load->view('V_Footer',$data);
	}
	// detail ppc ada di C_RequestAskanit
	
	public function submitPPC(){
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
			$cek = $this->M_request->getdataPPC('where id_item = '.$id_item[$i].'');
			if (empty($cek)) {
				$this->M_request->savePPC($id_item[$i], $action[$i], $note[$i], $pic, $tgl);
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

		redirect(base_url("MiscellaneousPPC/Request"));
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