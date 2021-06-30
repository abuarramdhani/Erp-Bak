<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_RequestCosting extends CI_Controller
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
        
        $data['view'] = 'Costing';

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MiscellaneousMng/V_Request', $data);
		$this->load->view('V_Footer',$data);
	}
	
	public function getTypeTransact(){
		$term = $this->input->get('term',TRUE);
		// $term = strtoupper($term);
		$data = $this->M_request->getTypeTransact($term);
		echo json_encode($data);
	}

	public function getAkunCOA2(){
		$term = $this->input->get('term',TRUE);
		// $term = strtoupper($term);
		$data = $this->M_request->getAkunCOA2($term);
		echo json_encode($data);
	}

	public function getAkunCOA(){
		$term = $this->input->get('term',TRUE);
		$cost = $this->input->get('cost',TRUE);
		$term = strtoupper($term);
		$data = $this->M_request->getAkunCOA($term, $cost);
		// echo "<pre>";print_r($data);exit();
		echo json_encode($data);
	}
	
	public function getDescriptionCOA(){
		$akun = $this->input->post('akun',TRUE);
		$cost = $this->input->post('cost',TRUE);
		$data = $this->M_request->getAkunCOA($akun, $cost);
		// echo "<pre>";print_r($cost);exit();
		$hasil = array($data[0]['DESC_AKUN'], $data[0]['DESC_CC']);
		echo json_encode($hasil);
	}
	
	public function DetailMiscellaneous($no){
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
		$branch 			= $this->M_request->getBranchIO($data['io']); // cari branch berdasarkan io -> untuk COA
		$data['branch'] 	= !empty($branch) ? $branch[0]['BRANCH'] : '';
		$data['tgl'] 		= $this->input->post('tgl_transact'.$no.'');
		$data['status'] 	= $this->input->post('status'.$no.'');
		$data['requester'] 	= $this->input->post('pic'.$no.'');
		$nama_pic			= $this->M_request->getUser($data['requester']);
		$data['nama_req'] 	= $nama_pic[0]['nama'];
		$data['ket']		= $no;
		$getdata = $this->M_request->cekitemrequest("where id_header = $id_head order by id_item asc");
		foreach ($getdata as $key => $val) {
			$getdata[$key]['status'] = $this->getStatus2($val['id_item']); // status approve/reject per item
			$getdata[$key]['coaa'] = $this->buatCOAyuk($val['kode_item'], $val['cost_center']);
			$getdata[$key]['item_cost'] = $this->cariItemCost($data['io'], $val['kode_item'], $val['qty']);
		}
		$data['data'] = $getdata;
		$data['linkket'] = 'MiscellaneousCosting/Request/submitCosting';

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MiscellaneousMng/V_DetailCosting', $data);
		$this->load->view('V_Footer',$data);
	}

	public function buatCOAyuk($item, $cost){
		//urutan COA
		//company(1) - branch - account(isi manual) - cost center - product(sementara manual) - region(000) - future(000)
		$kode = substr($item,0,3);
		if ($kode == 'AAA' || $kode == 'AAB' || $kode == 'AAC' || $kode == 'AGC' || $kode == 'ADA' || $kode == 'AFA') {
			$kode = $kode;
		}else {
			$kode = '000';
		}
		$coa = '-'.$cost.'-'.$kode.'-000-000';
		return $coa;
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
	
	public function getStatus2($id){
		$reject = '';
		$cari = $this->M_request->cariReject($id);
		// echo "<pre>";print_r($cari);exit();
		if ($cari[0]['pic'] != '') {
			$reject = 'Reject|'.$cari[0]['note'];
		}
		return $reject;
	}
	
	public function submitCosting(){
		$id_header 	= $this->input->post('id_header');
		$id_item 	= $this->input->post('id_item[]');
		$action 	= $this->input->post('action[]');
		$note 		= $this->input->post('note[]');
		$tipe_transaksi = $this->input->post('type_transaksi[]');
		$coa 		= $this->input->post('coa[]');
		$desc_biaya = $this->input->post('desc_biaya[]');
		$desc_cc 	= $this->input->post('desc_cc[]');
		$total_cost = $this->input->post('total_cost[]');
		$produk 	= $this->input->post('produk[]');
		$status 	= $this->input->post('status[]');
		$pic 		= $this->session->user;
		$tgl 		= date('Y-m-d H:i:s');
		$i = 0;
		for ($x=0; $x < count($id_item); $x++) { 
			if (empty($status[$x])) {
				$cek = $this->M_request->getdataCosting('where id_item = '.$id_item[$x].'');
				if (empty($cek)) {
					$this->M_request->saveCosting($id_item[$x], $action[$i], $note[$i], $tipe_transaksi[$i], $coa[$i], $desc_biaya[$i], $desc_cc[$i], $total_cost[$i], $pic, $tgl, $produk[$i]);
				}
				$i++;
			}
		}
		$this->M_request->updateHeader('Proses Approve Seksi Akuntansi', $id_header);

		redirect(base_url("MiscellaneousCosting/Request"));
	}

	public function modalApproveManual(){
		$data['id'] 	= $this->input->post('id_header');
		$data['nodoc'] 	= $this->input->post('nodoc');
		$data['io'] 	= $this->input->post('io');
		$data['tgl_transact'] = $this->input->post('tgl_transact');
		$data['status'] = $this->input->post('status');
		$data['pic'] 	= $this->input->post('pic');
		$data['ket'] 	= $this->input->post('ket');
		$this->load->view('MiscellaneousMng/V_ModalApproveManual', $data);
	}

	public function ApproveManual(){ 
		// approve manual digunakan untuk menggantikan approve kadep, jika kadep tidak bisa approve
		$id_head			= $this->input->post('id');
		$data['id_header']	= $id_head;
		$data['no_dokumen'] = $this->input->post('nodoc');
		$data['requester'] 	= $this->input->post('pic');
		$nama_pic			= $this->M_request->getUser($data['requester']);
		$data['nama_req'] 	= $nama_pic[0]['nama'];
		// echo "<pre>";print_r($nama_pic);exit();
		
		if(!is_dir('./assets/upload/Miscellaneous/Approve_Manual'))
		{
			mkdir('./assets/upload/Miscellaneous/Approve_Manual', 0777, true);
			chmod('./assets/upload/Miscellaneous/Approve_Manual', 0777);
		}
		$filename = './assets/upload/Miscellaneous/Approve_Manual/'.$id_head.'-'.$data['requester'].'.png';
		move_uploaded_file($_FILES['app_manual']['tmp_name'],$filename); // save file di folder approve manual

		$user = $this->session->user;
		$user_id = $this->session->userid;

		$data['Title'] = '';
		$data['Menu'] = 'Request Miscellaneous';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['io'] 		= $this->input->post('io');
		$data['tgl'] 		= $this->input->post('tgl_transact');
		$data['status'] 	= $this->input->post('status');
		$data['ket']		= $this->input->post('ket');
		// echo "<pre>";print_r($data['ket']);exit();
		$getdata = $this->M_request->cekitemrequest("where id_header = $id_head order by id_item asc");
		foreach ($getdata as $key => $val) {
			$getdata[$key]['status'] = $this->getStatus2($val['id_item']); // status approve/reject per item
		}
		$data['data'] = $getdata;
		$data['linkket'] = 'MiscellaneousCosting/Request/submitCosting';
		

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MiscellaneousMng/V_DetailKadep', $data);
		$this->load->view('V_Footer',$data);
	}

	public function pdf_miscellaneous(){
		$no_dokumen 	= $this->input->post('no_dokumen');
		$io 			= $this->input->post('io');
		$tgl_request 	= $this->input->post('tgl_request');
		$requester 		= $this->input->post('requester');
		$nama_req 		= $this->input->post('nama_req');
		$issue_receipt 	= $this->input->post('issue_receipt[]');
		$kode_item 		= $this->input->post('kode_item[]');
		$deskripsi_item = $this->input->post('deskripsi_item[]');
		$qty 			= $this->input->post('qty[]');
		$uom 			= $this->input->post('uom[]');
		$inventory 		= $this->input->post('inventory[]');
		$locator 		= $this->input->post('locator[]');
		$no_serial 		= $this->input->post('no_serial[]');
		$alasan 		= $this->input->post('alasan[]');
		$desk_alasan 	= $this->input->post('deskripsi_alasan[]');
		$status	 		= $this->input->post('status[]');
		$id_item	 	= $this->input->post('id_item[]');

		$data['header'] = array('no_dokumen' => $no_dokumen,
								'io' => $io);
		$datanya = array();
		for ($i=0; $i < count($kode_item) ; $i++) { 
			$array = array('issue_receipt' 		=> $issue_receipt[$i],
							'kode_item' 		=> $kode_item[$i],
							'deskripsi_item' 	=> $deskripsi_item[$i],
							'qty' 				=> $qty[$i],
							'uom' 				=> $uom[$i],
							'inventory' 		=> $inventory[$i],
							'locator' 			=> $locator[$i],
							'no_serial' 		=> $no_serial[$i],
							'alasan' 			=> $alasan[$i],
							'deskripsi_alasan' 	=> $desk_alasan[$i],
							'status' 			=> $status[$i],
						);
			array_push($datanya, $array);
			$cari_approve = $this->M_request->approver_misc($id_item[$i]);
			$approver[] = $cari_approve[0];
		}
		$data['data'] = $datanya;
		// echo "<pre>";print_r($approver);exit();
		$pic_askanit = $pic_ppc = $pic_kadep = $pic_costing = $pic_akt = $pic_input = $pic_kasie = $pic_cabang = '';
		$tgl_askanit = $tgl_ppc = $tgl_kadep = $tgl_costing = $tgl_akt = $tgl_input = $tgl_kasie = $tgl_cabang = '';
		for ($a=0; $a < count($approver); $a++) { 
			$pic_kasie 		= !empty($approver[$a]['pic_kasie']) ? $approver[$a]['pic_kasie'] : $pic_kasie;
			$tgl_kasie 		= !empty($approver[$a]['tgl_kasie']) ? $approver[$a]['tgl_kasie'] : $tgl_kasie;
			$pic_cabang 	= !empty($approver[$a]['pic_cabang']) ? $approver[$a]['pic_cabang'] : $pic_cabang;
			$tgl_cabang 	= !empty($approver[$a]['tgl_cabang']) ? $approver[$a]['tgl_cabang'] : $tgl_cabang;
			$pic_askanit 	= !empty($approver[$a]['pic_askanit']) ? $approver[$a]['pic_askanit'] : $pic_askanit;
			$tgl_askanit 	= !empty($approver[$a]['tgl_askanit']) ? $approver[$a]['tgl_askanit'] : $tgl_askanit;
			$pic_ppc 		= !empty($approver[$a]['pic_ppc']) ? $approver[$a]['pic_ppc'] : $pic_ppc;
			$tgl_ppc 		= !empty($approver[$a]['tgl_ppc']) ? $approver[$a]['tgl_ppc'] : $tgl_ppc;
			$pic_kadep 		= !empty($approver[$a]['pic_kadep']) ? $approver[$a]['pic_kadep'] : $pic_kadep;
			$tgl_kadep 		= !empty($approver[$a]['tgl_kadep']) ? $approver[$a]['tgl_kadep'] : $tgl_kadep;
			$pic_costing 	= !empty($approver[$a]['pic_costing']) ? $approver[$a]['pic_costing'] : $pic_costing;
			$tgl_costing 	= !empty($approver[$a]['tgl_costing']) ? $approver[$a]['tgl_costing'] : $tgl_costing;
			$pic_akt 		= !empty($approver[$a]['pic_akt']) ? $approver[$a]['pic_akt'] : $pic_akt;
			$tgl_akt 		= !empty($approver[$a]['tgl_akt']) ? $approver[$a]['tgl_akt'] : $tgl_akt;
			$pic_input 		= !empty($approver[$a]['pic_input']) ? $approver[$a]['pic_input'] : $pic_input;
			$tgl_input 		= !empty($approver[$a]['tgl_input']) ? $approver[$a]['tgl_input'] : $tgl_input;
		}
		if (!empty($pic_kasie)) {
			$pic_seksi = $pic_kasie.' - '.$this->cariPIC($pic_kasie);
			$tgl_seksi = $tgl_kasie;
		}elseif (!empty($pic_cabang)) {
			$pic_seksi = $pic_cabang.' - '.$this->cariPIC($pic_cabang);
			$tgl_seksi = $tgl_cabang;
		}else {
			$pic_seksi = $requester.' - '.$nama_req;
			$tgl_seksi = $tgl_request;
		}
		$data['approver'] = array('pic_seksi' 	=> $pic_seksi,
								'tgl_seksi' 	=> $tgl_seksi,
								'pic_askanit' 	=> $pic_askanit.' - '.$this->cariPIC($pic_askanit),
								'tgl_askanit' 	=> $tgl_askanit,	
								'pic_ppc'		=> $pic_ppc.' - '.$this->cariPIC($pic_ppc),
								'tgl_ppc' 		=> $tgl_ppc,	
								'pic_kadep' 	=> $pic_kadep.' - '.$this->cariPIC($pic_kadep),
								'tgl_kadep' 	=> $tgl_kadep,	
								'pic_costing' 	=> $pic_costing.' - '.$this->cariPIC($pic_costing),
								'tgl_costing' 	=> $tgl_costing,	
								'pic_akt' 		=> $pic_akt.' - '.$this->cariPIC($pic_akt),
								'tgl_akt' 		=> $tgl_akt,	
								'pic_input' 	=> $pic_input.' - '.$this->cariPIC($pic_input),
								'tgl_input' 	=> $tgl_input,								
							);
		
		ob_start();
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8','f4-L', 0, '', 5, 5, 30, 65, 5, 5);
		$filename 	= 'Miscellaneous.pdf';
		$head = $this->load->view('MiscellaneousMng/V_HeaderPdf', $data, true);
		$html = $this->load->view('MiscellaneousMng/V_BodyPdf', $data, true);
		$foot = $this->load->view('MiscellaneousMng/V_FooterPdf', $data, true);
		ob_end_clean();
		$pdf->SetHTMLHeader($head);	
		$pdf->SetHTMLFooter($foot);		
		$pdf->WriteHTML($html);			
		$pdf->Output($filename, 'I');
	}

	public function cariPIC($noind){
		$nama = '';
		if (!empty($noind)) {
			$cari = $this->M_request->getUser($noind);
			$nama = $cari[0]['nama'];
		}
		return $nama;
	}

	public function deleteItem(){
		$id_item 		= $this->input->post('id_item');
		$del_item 		= $this->M_request->deleteItem($id_item);
		$del_kasie		= $this->M_request->deleteKasie($id_item);
		$del_cabang		= $this->M_request->deleteCabang($id_item);
		$del_askanit 	= $this->M_request->deleteAskanit($id_item);
		$del_ppc 		= $this->M_request->deletePPC($id_item);
		$del_kadep 		= $this->M_request->deleteKadep($id_item);
		$del_costing 	= $this->M_request->deleteCosting($id_item);
		$del_akt 		= $this->M_request->deleteAkt($id_item);
		$del_input 		= $this->M_request->deleteInput($id_item);
	}

}
