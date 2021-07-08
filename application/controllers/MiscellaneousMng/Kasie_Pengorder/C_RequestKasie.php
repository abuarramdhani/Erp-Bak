<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_RequestKasie extends CI_Controller
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
        
        $data['view'] = 'Kasie';

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MiscellaneousMng/V_Request', $data);
		$this->load->view('V_Footer',$data);
	}
	
	public function getCostCenter(){
		$term = $this->input->get('term',TRUE);
		$ket = $this->input->get('ket',TRUE);
		$term = strtoupper($term);
		$data = $this->M_request->getCost_Center($term, $ket);
		// echo "<pre>";print_r($data);exit();
		echo json_encode($data);
	}
	
	public function getKasieApprove(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_request->assign_kasie($term);
		// echo "<pre>";print_r($data);exit();
		echo json_encode($data);
	}
	
	public function getAssignApprove(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_request->assign_order($term);
		// echo "<pre>";print_r($data);exit();
		echo json_encode($data);
	}

	public function getAssignPPC(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_request->assign_ppc($term);
		// echo "<pre>";print_r($data);exit();
		echo json_encode($data);
	}
	
	public function getAssignCabang(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_request->assign_cabang($term);
		// echo "<pre>";print_r($data);exit();
		echo json_encode($data);
	}
	
	public function getIO(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_request->getOrgAssign($term);
		// echo "<pre>";print_r($data);exit();
		echo json_encode($data);
	}
	
	public function getUOM(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_request->getUOM($term);
		// echo "<pre>";print_r($data);exit();
		echo json_encode($data);
	}
	
	public function getSubinv(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_request->getSubinv($term);
		// echo "<pre>";print_r($data);exit();
		echo json_encode($data);
	}
	
	public function getLokator(){
		$gudang	 = $this->input->post('sub');
        $lokator = $this->M_request->getLokator($gudang);
		echo '<option></option>';
		foreach ($lokator as $data_lokator) {
			echo '<option value="'.$data_lokator['SEGMENT1'].'">'.$data_lokator['SEGMENT1'].'</option>';
		}
	}
	
	public function getNoSerial(){
		$term = $this->input->get('term',TRUE);
		$subinv = $this->input->get('subinv',TRUE);
		$item = $this->input->get('item',TRUE);
		$term = strtoupper($term);
		$data = $this->M_request->getNoserial($term, $subinv, $item);
		// echo "<pre>";print_r($data);exit();
		echo json_encode($data);
	}

	public function cekSerialReceipt(){
		$item = $this->input->post('item');
		$serial = $this->input->post('serial');
		$subinv = $this->input->post('subinv');
		$ket = '';
		for ($i=0; $i < count($serial) ; $i++) { 
			$data = $this->M_request->getNoserial($serial[$i], $subinv, $item);
			if (empty($data)) {
				$ket = $ket;
			}else {
				$ket .= empty($ket) ? $serial[$i] : $ket.', '.$serial[$i];
			}
		}
		// echo "<pre>";print_r($serial);exit();
		echo $ket;
	}

	public function getItem(){
		$term = $this->input->get('term',TRUE);
		$sub  = $this->input->get('sub',TRUE);
		$lok  = $this->input->get('lok',TRUE);
		$term = strtoupper($term);
		$data = $this->M_request->getItem("AND (msib.segment1 like '%$term%' OR msib.description like '%$term%')", $sub, $lok);
		// echo "<pre>";print_r($data);exit();
		echo json_encode($data);
    }
    
	public function getDescription(){
		$term 	= $this->input->post('item', TRUE);
		$sub 	= $this->input->post('sub',TRUE);
		$lok 	= $this->input->post('lok',TRUE);
		$term 	= strtoupper($term);
		$data 	= $this->M_request->getItem("AND msib.segment1 = '$term'", $sub, $lok);
		$hasil 	= array($data[0]['DESCRIPTION'], $data[0]['ONHAND'], $data[0]['PRIMARY_UOM_CODE'], $data[0]['SECONDARY_UOM_CODE'], $data[0]['INVENTORY_ITEM_ID'], $data[0]['SERIAL_NUMBER_CONTROL_CODE']);
		// $hasil  = array($hasil, $hasil);
		echo json_encode($hasil);
	}
	
    public function viewrequest(){
        $ket 	= $this->input->post('ket');
        $apk 	= $this->input->post('apk');
        $name 	= $this->input->post('name');
        $batas 	= $this->input->post('bts');
        $data['jenisket'] = $ket;
        $data['iniket'] = $name;
		$data['data'] 	= $this->getdata($ket, $name, $batas, $apk);
		$data['warna'] 	= $this->input->post('warna');
		if ($name == 'approveAskanit' || $name == 'approvePPC' || $name == 'approveCabang' || $name == 'approveKasie') {
			$data['linkdetail'] = 'MiscellaneousAskanit/Request/'; // link tampil detail -> C_RequestAskanit
		}elseif ($name == 'approveCosting') {
			$data['linkdetail'] = 'MiscellaneousCosting/Request/'; // link tampil detail -> C_RequestCosting
		}elseif ($name == 'approveKadep') {
			$data['linkdetail'] = 'MiscellaneousKadep/Request/'; // link tampil detail -> C_RequestKadep
		}elseif ($name == 'siapinputCosting' || $name == 'finishedCosting') {
			$data['linkdetail'] = 'MiscellaneousCosting/Input/'; // link tampil detail -> C_InputCosting
		}elseif ($name == 'approveAkuntansi') {
			$data['linkdetail'] = 'MiscellaneousAkt/Request/'; // link tampil detail -> C_RequestAkt
		} else {
			$data['linkdetail'] = 'MiscellaneousKasie/Request/'; // link tampil detail -> C_RequestKasie
		}
		$this->load->view('MiscellaneousMng/V_TblRequest', $data);
	}
	
	public function getdata($ket, $name, $batas, $apk){
		$user 	= $this->session->user;
		if ($apk == 'askanit') { //hanya menampilkan data yang assign_approve nya ke user login -> resp. misc kepala seksi utama
			$query = "where assign_approve = '$user'";
		}elseif ($apk == 'ppc') { //hanya menampilkan data yang assign_ppc nya ke user login -> resp. misc seksi ppc
			$query = "where assign_ppc = '$user'";
		}elseif ($apk == 'cabang') { //hanya menampilkan data yang assign_cabang nya ke user login -> resp. misc kepala cabang
			$query = "where assign_cabang = '$user'";
		}elseif ($name == 'approveKasie') { //hanya menampilkan data yang assign_kasie nya ke user login -> resp. misc kepala seksi
			$query = "where assign_kasie = '$user'";
		}else { // tampilkan semua data
			$query = '';
		}
		$getdata = $this->M_request->cekheader($query);
		// echo "<pre>";print_r($getdata);exit();
		$datanya = array();
		foreach ($getdata as $key => $val) {
			$seksi	= $this->M_request->getseksi($user);
			$status = $this->getStatus($val['id'], 'status'); // cari status
			$data_reject = $status[0];
			$bts_status = $this->batasStatus($val['status']);
			if ($ket == 'finished') { //tabel finished
				if ($status[1] == $status[3]) { // jml item request == jml item yg direject -> reject semua
					$getdata[$key]['status']= 'REJECTED';
					$getdata[$key]['tgl_input']= '-';
					if ($name == 'finishedKasie' || $name == 'finishedSeksi_Lain') { // kalau seksi login = seksi data, simpan datanya
						$seksi[0]['seksi'] == $val['seksi'] ? array_push($datanya, $getdata[$key]) : '';
					}else {
						array_push($datanya, $getdata[$key]);
					}
				}else {
					if ($bts_status == 8) { // data sudah diinput oracle dari menu siap input misc. costing
						if ($status[3] == 0) { // data approve semua
							$getdata[$key]['status']= 'APPROVED';
						}else { // data ada yg approve, ada yg reject
							$jml_input = $status[1] - $status[3];
							$getdata[$key]['status']= $jml_input.' ITEM FINISHED INPUT';
						}
						$inputcosting = $this->M_request->getdataCostingInput("where id_item in (".$status[2].")");
						$getdata[$key]['tgl_input']= $inputcosting[0]['tgl_approve'];
						if ($name == 'finishedKasie' || $name == 'finishedSeksi_Lain') { // kalau seksi login = seksi data, simpan datanya
							$seksi[0]['seksi'] == $val['seksi'] ? array_push($datanya, $getdata[$key]) : '';
						}else {
							array_push($datanya, $getdata[$key]);
						}
					}
				}
			}elseif ($status[1] > $status[3] ) { // ket bukan finished & jml item request > jml item yg direject
				$getdata[$key]['ket_approval'] = $this->ketReject($data_reject);
				if ($ket == 'approve' || $ket == 'siapinput' || $ket == 'approvemanual') {
					if ($bts_status == $batas) { //batas liat di customMSC bagian viewrequest(ket,aplikasi,warna tabel, name tabel,batas)
						if ($ket == 'approve') {
							$getdata[$key]['status']= 'Menunggu Approval Anda';
						}elseif ($ket == 'siapinput') {
							$getdata[$key]['status']= 'Siap Input';
						}
						array_push($datanya, $getdata[$key]);
					}
				}elseif ($ket == 'onprocess') {
					if ($bts_status != $batas && $bts_status < 8) {
						if ($name == 'onprocessKasie' || $name == 'onprocessSeksi_Lain') {
							$seksi[0]['seksi'] == $val['seksi'] ? array_push($datanya, $getdata[$key]) : '';
						}else {
							array_push($datanya, $getdata[$key]);
						}
					}
				}else {
					if ($bts_status < 8) {
						array_push($datanya, $getdata[$key]);
					}
				}
			}
		}
		// echo "<pre>";print_r($datanya);
		// exit();
		return $datanya;
	}

	public function batasStatus($status){
		if ($status == 'Proses Approve Ka. Seksi Gudang') {
			$bts = 0;
		}elseif ($status == 'Proses Approve Ka. Cabang / Showroom') {
			$bts = 1;
		}elseif ($status == 'Proses Approve Ka. Seksi Utama / Aska / Ka. Unit') {
			$bts = 2;
		}elseif ($status == 'Proses Approve Seksi PPC') {
			$bts = 3;
		}elseif ($status == 'Proses Approve WaKa / Ka. Department') {
			$bts = 4;
		}elseif ($status == 'Proses Approve Ka. Seksi Akt Biaya') {
			$bts = 5;
		}elseif ($status == 'Proses Approve Seksi Akuntansi') {
			$bts = 6;
		}elseif ($status == 'Siap Input Ka. Seksi Akt Biaya') {
			$bts = 7;
		}elseif ($status == 'Finished') {
			$bts = 8;
		}
		return $bts;
	}

	public function cariReject($data){
		$reject = array();
		foreach ($data as $key => $val) {
			if ($val['action'] == 'Reject') {
				$reject[] = array($val['pic'], $val['id_item']);
			}
		}
		return $reject;
	}

	public function getStatus($id, $cari){
		$data = $this->M_request->cekitemrequest("where id_header = $id order by id_item asc");
		$id_item = '';
		foreach ($data as $key => $val) {
			$id_item = $key == 0 ? $val['id_item'] : $id_item.', '.$val['id_item'];
		}
		$history = $reject = array();
		$kasie = $this->M_request->getdataKasie("where id_item in ($id_item)"); // cek approve kepala seksi (khusus order dari seksi lain)
			$rjc = $this->cariReject($kasie); // cari data reject
			!empty($rjc) ? $reject[] = array(count($rjc), 'Kepala Seksi') : ''; // kalau $rjc tdk kosong, simpan datanya di $reject
			!empty($kasie) ? $history[] = array('Approve Kepala Seksi', $kasie[0]) : ''; // simpan data approve cabang di $history -> untuk tbl history di detail

		$cabang = $this->M_request->getdataCabang("where id_item in ($id_item)"); // cek approve cabang (khusus IO Cabang)
			$rjc = $this->cariReject($cabang); // cari data reject
			!empty($rjc) ? $reject[] = array(count($rjc), 'Ka. Cabang / Showroom') : ''; // kalau $rjc tdk kosong, simpan datanya di $reject
			!empty($cabang) ? $history[] = array('Approve Ka. Cabang / Showroom', $cabang[0]) : ''; // simpan data approve cabang di $history -> untuk tbl history di detail

		$askanit = $this->M_request->getdataAskanit("where id_item in ($id_item)"); // cek approve askanit
			$rjc = $this->cariReject($askanit); // cari data reject
			!empty($rjc) ? $reject[] = array(count($rjc), 'Ka. Seksi Utama / Aska / Ka. Unit') : ''; // kalau $rjc tdk kosong, simpan datanya di $reject
			!empty($askanit) ? $history[] = array('Approve Ka. Seksi Utama / Aska / Ka. Unit', $askanit[0]) : ''; // simpan data approve askanit di $history -> untuk tbl history di detail

		$ppc = $this->M_request->getdataPPC("where id_item in ($id_item)");
			$rjc = $this->cariReject($ppc);
			!empty($rjc) ? $reject[] = array(count($rjc), 'Seksi PPC') : '';
			!empty($ppc) ? $history[] = array('Approve Seksi PPC', $ppc[0]) : '';

		$kadep = $this->M_request->getdataKadep("where id_item in ($id_item)");
			$rjc = $this->cariReject($kadep);
			!empty($rjc) ? $reject[] = array(count($rjc), 'WaKa / Ka. Department') : '';
			!empty($kadep) ? $history[] = array('Approve WaKa / Ka. Department', $kadep[0]) : '';

		$costing = $this->M_request->getdataCosting("where id_item in ($id_item)");
			$rjc = $this->cariReject($costing);
			!empty($rjc) ? $reject[] = array(count($rjc), 'Ka. Seksi Akt Biaya') : '';
			!empty($costing) ? $history[] = array('Approve Ka. Seksi Akt Biaya', $costing[0]) : '';

		$akt = $this->M_request->getdataAkt("where id_item in ($id_item)");
			$rjc = $this->cariReject($akt);
			!empty($rjc) ? $reject[] = array(count($rjc), 'Seksi Akuntansi') : '';
			!empty($akt) ? $history[] = array('Approve Seksi Akuntansi', $akt[0]) : '';

		$inputcosting = $this->M_request->getdataCostingInput("where id_item in ($id_item)");
			$rjc = $this->cariReject($inputcosting);
			!empty($rjc) ? $reject[] = array(count($rjc), 'Ka. Seksi Akt Biaya') : '';
			!empty($inputcosting) ? $history[] = array('Finished', $inputcosting[0]) : '';

		$item_reject = 0;
		for ($r=0; $r < count($reject) ; $r++) { 
			$item_reject += $reject[$r][0];
		}
		if ($cari == 'status') {
			return array($reject, count($data), $id_item, $item_reject);
		}else {
			return $history; // data tabel history detail
		}
	}

	public function ketReject($data_reject){ 
		$reject = '';
		foreach ($data_reject as $key => $dr) {
			$reject = $key == 0 ? $dr[0].' Item ditolak '.$dr[1] : $reject.', '.$dr[0].' Item ditolak '.$dr[1];
		}
		return $reject;
	}

	public function modalTambahReq(){
		$data['ket'] = 'kasie';
		$data['data'] = $this->M_request->getOrgAssign();
		$this->load->view('MiscellaneousMng/V_ModalTambahReq', $data);
	}
    
    public function tambahrequest(){
		$user = $this->session->user;
		$user_id = $this->session->userid;

		$data['Title'] = '';
		$data['Menu'] = 'Request Miscellaneous';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        
        $getdata 		= $this->M_request->cekrequesttemp("where pic = '$user' order by nomor desc"); //data temporary item yang direquest tp belum di submit
		$iio 			= $this->input->post('io');
		$data['ioo'] 	= !empty($iio) ? $iio : $getdata[0]['io'];
		$data['alasan'] = $this->M_request->getAlasan();
		$data['subinvv'] = $this->M_request->getSubinv($data['ioo']);
		$data['data']	= array();
		foreach ($getdata as $key => $value) {
			if ($value['io'] == $data['ioo']) {
				array_push($data['data'], $value);
			}
		}
		$data['ket'] = 'kasie';
		// $data['dataioo'] = $this->M_request->getOrgAssign();
		
		// echo "<pre>";print_r($data['data']);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MiscellaneousMng/V_NewRequest', $data);
		$this->load->view('V_Footer',$data);
    }

    public function addRequest(){
        $user       = $this->session->user;
        $item       = $this->input->post('item');
        $qty       	= $this->input->post('qty');
		$onhand     = $this->input->post('onhand');
		$no_serial  = $this->input->post('no_serial[]');
		$noserial	= '';
		for ($i=0; $i < count($no_serial) ; $i++) { 
			$noserial .= $i == 0 ? $no_serial[$i] : '; '.$no_serial[$i];
		}
		// echo "<pre>";print_r($noserial);exit();
        $attach     = $user.'-'.strtotime(date('Y-m-d H:i:s')).'.pdf';

        $cekid = $this->M_request->cekrequesttemp("where pic = '$user' order by nomor desc");
        $id = !empty($cekid) ? $cekid[0]['nomor'] + 1 : 1;
        $datanya = array(
            'jenis'      	=> $this->input->post('order'),
            'ket_cost'   	=> $this->input->post('ket_cost'),
            'cost_center'	=> $this->input->post('cost_center'),
            'item'       	=> $item,
            'description'	=> $this->input->post('deskripsi'),
            'qty'        	=> $this->input->post('qty'),
            'onhand'     	=> $this->input->post('onhand'),
            'ket_uom'    	=> $this->input->post('uom'),
            'first_uom'  	=> $this->input->post('first_uom'),
            'secondary_uom' => $this->input->post('second_uom'),
            'inventory'  	=> $this->input->post('inventory'),
            'locator'    	=> $this->input->post('locator'),
            'no_serial'  	=> $noserial,
            'alasan'     	=> $this->input->post('alasan'),
            'desc_alasan'	=> $this->input->post('desc_alasan'),
            'attachment' 	=> $attach,
            'pic'        	=> $user,
            'nomor' 	 	=> $id,
            'inv_item_id' 	=> $this->input->post('inv_item'),
            'io' 			=> $this->input->post('ini_io'),
        );

        if (!empty($item)) {
			$cek = $this->M_request->cekrequesttemp("where item = '$item' and pic = '$user' order by nomor asc");
			if (empty($cek)) {
				$save = $this->M_request->saveTemp($datanya); // save data temporary
		
				if(!is_dir('./assets/upload/Miscellaneous/Temp'))
				{
					mkdir('./assets/upload/Miscellaneous/Temp', 0777, true);
					chmod('./assets/upload/Miscellaneous/Temp', 0777);
				}
				$filename = './assets/upload/Miscellaneous/Temp/'.$attach.'';
				move_uploaded_file($_FILES['file_pdf']['tmp_name'],$filename); // save file di folder temporary
			}
		}
        $this->tambahrequest();
        // echo "<pre>";print_r($_FILES);exit();
	}
	
	public function deleteTemp(){
		$item 	= $this->input->post('item');
		$nomor 	= $this->input->post('nomor');
		$pic 	= $this->input->post('pic');
		$attachment = $this->input->post('attachment');
		$this->M_request->deleteTemp("where item =  '$item' and nomor = '$nomor' and pic = '$pic'");
		$filename = './assets/upload/Miscellaneous/Temp/'.$attachment.'';
		unlink($filename);
	}
	
	public function edit_attachment(){
		$attachment = $this->input->post('attachment');
		$view = '<input type="file" id="file_edit" name="file_edit" class="form-control" accept=".pdf">
				<input type="hidden" id="attach_name" name="attach_name" value="'.$attachment.'">';
		echo $view;
	}

	public function SaveEditAttach(){
		$attachment = $this->input->post('attach_name');
		if (!empty($_FILES['file_edit']['name'])) {
			$filename = './assets/upload/Miscellaneous/Temp/'.$attachment.'';
			move_uploaded_file($_FILES['file_edit']['tmp_name'],$filename); // save file di folder temporary
		}
        $this->tambahrequest();
	}
	
	public function delete_attachment(){
		$attachment = $this->input->post('attachment');
		$filename = './assets/upload/Miscellaneous/Temp/'.$attachment.'';
		unlink($filename);
	}
	
	public function SaveRequest(){
		$jenis 			= $this->input->post('jenis2[]');
		$ket_cost 		= $this->input->post('ket_cost2[]');
		$cost_center 	= $this->input->post('cost_center2[]');
		$inv_item 		= $this->input->post('inv_item2[]');
		$item 			= $this->input->post('item2[]');
		$desc 			= $this->input->post('desc2[]');
		$qty 			= $this->input->post('qty2[]');
		$onhand 		= $this->input->post('onhand2[]');
		$ket_uom 		= $this->input->post('ket_uom2[]');
		$first_uom 		= $this->input->post('first_uom2[]');
		$secondary_uom 	= $this->input->post('secondary_uom2[]');
		$inventory 		= $this->input->post('inventory2[]');
		$locator 		= $this->input->post('locator2[]');
		$no_serial 		= $this->input->post('no_serial2[]');
		$alasan 		= $this->input->post('alasan2[]');
		$desc_alasan 	= $this->input->post('desc_alasan2[]');
		$attachment 	= $this->input->post('attachment2[]');
		$io 			= $this->input->post('io2');
		$pic 			= $this->input->post('pic2[]');
		$assign_order 	= $this->input->post('assign_order');
		$assign_ppc 	= $this->input->post('assign_ppc');
		$assign_cabang 	= $this->input->post('assign_cabang');
		$seksi			= $this->M_request->getseksi($pic[0]);

		$ionya = substr($io[0], 0,1);
		if ($ionya == 'A' || $ionya == 'B' || $ionya == 'G' || $ionya == 'H' || $ionya == 'J' || $ionya == 'K' || $ionya == 'M' || $ionya == 'S' || $ionya == 'U') {
			$status = 'Proses Approve Ka. Cabang / Showroom';
		}else {
			$status = 'Proses Approve Ka. Seksi Utama / Aska / Ka. Unit';
		}

		if (!empty($item)) {
			// $cekheader = $this->M_request->cekheader("where no_dokumen like '%".date('mY')."%'");
			$cekheader = $this->M_request->cekheader("");
			$idheader = !empty($cekheader) ? $cekheader[0]['id'] + 1 : 1;
			if (!empty($cekheader)) {
				$no = explode("/", $cekheader[0]['no_dokumen']);
				$no = sprintf("%03d", ($no[0] + 1));
				$nodoc = $no.'/MISC/'.date('mY');  
			}else {
				$nodoc = '001/MISC/'.date('mY').'';
			}

			$dataheader = array(
						'id' 			=> $idheader,
						'no_dokumen' 	=> $nodoc,
						'io' 			=> $io[0],
						'tgl_request' 	=> date("Y-m-d H:i:s"),
						'pic' 			=> $pic[0],
						'seksi' 		=> $seksi[0]['seksi'],
						'assign_approve'=> $assign_order,
						'assign_ppc'	=> $assign_ppc,
						'status'		=> $status,
						'assign_cabang' => $assign_cabang
			);
			$saveheader = $this->M_request->saveHeader($dataheader);

			for ($i=0; $i < count($item) ; $i++) { 
				$cekitem = $this->M_request->cekitemrequest('order by id_item desc');
				$iditem = !empty($cekitem) ? $cekitem[0]['id_item'] + 1 : 1;
				$saveitem = $this->M_request->saveItem($idheader, $iditem, $jenis[$i], strtoupper($ket_cost[$i]), $cost_center[$i], $inv_item[$i], $item[$i], $desc[$i],
							$qty[$i], $onhand[$i], $ket_uom[$i], $first_uom[$i], $secondary_uom[$i], $inventory[$i], $locator[$i], strtoupper($no_serial[$i]), $alasan[$i],
							$desc_alasan[$i], $attachment[$i]);
			}
			
			if(!is_dir('./assets/upload/Miscellaneous/Attachment'))
			{
				mkdir('./assets/upload/Miscellaneous/Attachment', 0777, true);
				chmod('./assets/upload/Miscellaneous/Attachment', 0777);
			}

			// hapus data temporary
			$this->M_request->deleteTemp("where pic = '".$pic[0]."'");
			$dir    = './assets/upload/Miscellaneous/Temp';
			$files1 = scandir($dir);
			for($i = 0;$i < count($files1);$i++){ 
				$filename = './assets/upload/Miscellaneous/Temp/'.$files1[$i].'';
				if(stripos($files1[$i], $pic[0]) !== FALSE && file_exists($filename)){ // cari file yg mau dipindah, (nama file seperti nama pic)
					$tujuan = './assets/upload/Miscellaneous/Attachment/'.$files1[$i].'';
					if (copy($filename, $tujuan)) { // pindah file ke directory /attachment
						unlink($filename); // hapus file di directory /temp
					}
				}
			}
		}
		redirect(base_url("MiscellaneousKasie/Request"));
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
		$data['tgl'] 		= $this->input->post('tgl_transact'.$no.'');
		$data['status'] 	= $this->input->post('status'.$no.'');
		$data['requester'] 	= $this->input->post('pic'.$no.'');
		$nama_pic			= $this->M_request->getUser($data['requester']);
		$data['nama_req'] 	= $nama_pic[0]['nama'];
		$data['ket']		= $no;
		
		if(stripos($no, 'Kasie') !== FALSE){
			$data['linkket'] = 'MiscellaneousKasie/Request'; // link back ke miscellaneous kepala seksi
		}elseif(stripos($no, 'Cabang') !== FALSE){
			$data['linkket'] = 'MiscellaneousCabang/Request'; // link back ke miscellaneous kepala cabang
		}elseif(stripos($no, 'Askanit') !== FALSE){
			$data['linkket'] = 'MiscellaneousAskanit/Request'; // link back ke misc kepala seksi utama
		}elseif(stripos($no, 'PPC') !== FALSE){
			$data['linkket'] = 'MiscellaneousPPC/Request'; // link back ke misc seksi ppc
		}elseif(stripos($no, 'Kadep') !== FALSE){
			$data['linkket'] = 'MiscellaneousKadep/Request'; // link back ke misc kepala department
		}elseif(stripos($no, 'Costing') !== FALSE){
			$data['linkket'] = 'MiscellaneousCosting/Request'; // link back ke misc costing
		}elseif(stripos($no, 'Akuntansi') !== FALSE){
			$data['linkket'] = 'MiscellaneousAkt/Request'; // link back ke misc akuntansi
		}elseif(stripos($no, 'Seksi_Lain') !== FALSE){
			$data['linkket'] = 'MiscellaneousSeksiLain/Request'; // link back ke miscellaneous seksi lain
		}

		$getdata = $this->M_request->cekitemrequest("where id_header = $id_head order by id_item asc");
		foreach ($getdata as $key => $val) {
			$getdata[$key]['status'] = $this->getStatus2($val['id_item']); // status reject/approve tiap item
		}
		$data['data'] = $getdata;
		// echo "<pre>";print_r($getdata);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MiscellaneousMng/V_DetailRequest', $data);
		$this->load->view('V_Footer',$data);
	}

	
	public function getStatus2($id){
		$reject = '';
		$cari = $this->M_request->cariReject($id);
		// echo "<pre>";print_r($cari);exit();
		if ($cari[0]['pic'] != '') {
			$pic = $this->M_request->getUser($cari[0]['pic']);
			$reject = 'Reject by '.$pic[0]['nama'];
		}
		return $reject;
	}

	public function modalHistory(){
		$id 				= $this->input->post('id');
		$data['history'] 	= $this->getStatus($id, 'history');
		// echo "<pre>";print_r($history);exit();
		$this->load->view('MiscellaneousMng/V_ModalHistory', $data);
	}
	
	public function modalNotes(){
		$id 		= $this->input->post('id_item');
		$datanya 	= array();
		$kasie 		= $this->M_request->getdataKasie("where id_item = $id"); // cek data kepala seksi
		!empty($kasie) ? $datanya[] = array(''.$kasie[0]['action'].' Kepala Seksi', $kasie[0]) : ''; // datanya ada = simpan notesnya
		$cabang 	= $this->M_request->getdataCabang("where id_item = $id"); // cek data kepala cabang
		!empty($cabang) ? $datanya[] = array(''.$cabang[0]['action'].' Ka. Cabang / Showroom', $cabang[0]) : ''; // datanya ada = simpan notesnya
		$askanit 	= $this->M_request->getdataAskanit("where id_item = $id"); // cek data askanit
		!empty($askanit) ? $datanya[] = array(''.$askanit[0]['action'].' Ka. Seksi Utama / Aska / Ka. Unit', $askanit[0]) : ''; // datanya ada = simpan notesnya
		$ppc 		= $this->M_request->getdataPPC("where id_item = $id");
		!empty($ppc) ? $datanya[] = array(''.$ppc[0]['action'].' Seksi PPC', $ppc[0]) : '';
		$kadep 		= $this->M_request->getdataKadep("where id_item = $id");
		!empty($kadep) ? $datanya[] = array(''.$kadep[0]['action'].' WaKa / Ka. Department', $kadep[0]) : '';
		$costing 	= $this->M_request->getdataCosting("where id_item = $id");
		!empty($costing) ? $datanya[] = array(''.$costing[0]['action'].' Ka. Seksi Akt Biaya', $costing[0]) : '';
		$akt 		= $this->M_request->getdataAkt("where id_item = $id");
		!empty($akt) ? $datanya[] = array(''.$akt[0]['action'].' Seksi Akuntansi', $akt[0]) : '';
		$inputcosting = $this->M_request->getdataCostingInput("where id_item = $id");
		!empty($inputcosting) ? $datanya[] = array('Finish '.$inputcosting[0]['action'].'', $inputcosting[0]) : '';

		$data['data'] = $datanya;
		// echo "<pre>";print_r($id);exit();
		$this->load->view('MiscellaneousMng/V_ModalNotes', $data);
		
	}


	public function submitKasie(){$id_header 	= $this->input->post('id_header');
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

		for ($i=0; $i < count($id_item); $i++) { 
			$cek = $this->M_request->getdataKasie('where id_item = '.$id_item[$i].'');
			if (empty($cek)) {
				$act = empty($action[$i]) ? 'Approve' : $action[$i];
				$this->M_request->saveKasie($id_item[$i], $act, $note[$i], $pic, $tgl);
			}
		}

		$this->M_request->updateHeader('Proses Approve Ka. Seksi Utama / Aska / Ka. Unit', $id_header);

		redirect(base_url("MiscellaneousKasie/Request"));
	}

	public function layout_request(){
        include APPPATH.'third_party/Excel/PHPExcel.php';
		$excel = new PHPExcel();
		$excel->getProperties()->setCreator('CV. KHS')
					->setLastModifiedBy('Quick')
					->setTitle("Miscellaneous")
					->setSubject("CV. KHS")
					->setDescription("Miscellaneous")
                    ->setKeywords("MSC");
        $excel->setActiveSheetIndex(0)->setCellValue('A1', "JENIS");
        $excel->setActiveSheetIndex(0)->setCellValue('A2', "ISSUE / RECEIPT");
        $excel->setActiveSheetIndex(0)->setCellValue('B1', "KETERANGAN COST CENTER");
        $excel->setActiveSheetIndex(0)->setCellValue('B2', "Seksi / Resource");
        $excel->setActiveSheetIndex(0)->setCellValue('C1', "COST CENTER");
        $excel->setActiveSheetIndex(0)->setCellValue('D1', "KODE ITEM");
        $excel->setActiveSheetIndex(0)->setCellValue('E1', "QTY");
        $excel->setActiveSheetIndex(0)->setCellValue('F1', "SUBINVENTORY");
        $excel->setActiveSheetIndex(0)->setCellValue('G1', "LOCATOR");
        $excel->setActiveSheetIndex(0)->setCellValue('H1', "NO. SERIAL");
		$excel->setActiveSheetIndex(0)->setCellValue('H2', "*jika lebih dari satu gunakan semicolon (; ) dan spasi untuk pemisah, contoh : AAA; BBB");
        $excel->setActiveSheetIndex(0)->setCellValue('I1', "ALASAN");
        $excel->setActiveSheetIndex(0)->setCellValue('J1', "DESKRIPSI ALASAN");
		for($col = 'A'; $col !== 'K'; $col++) { // autowidth
			$excel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Import");
		$excel->setActiveSheetIndex();
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Layout-Miscellaneous.xlsx"'); 
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
	}

	public function import_request(){
		require_once APPPATH.'third_party/Excel/PHPExcel.php';
		require_once APPPATH.'third_party/Excel/PHPExcel/IOFactory.php';
		 
        // load excel
        $file = $_FILES['file_request']['tmp_name'];
        $load = PHPExcel_IOFactory::load($file);
        $sheets = $load->getActiveSheet()->toArray(null,true,true,true);
		$ket	= $this->input->post('ket');
		$io 	= $this->input->post('io');
        $user	= $this->session->user;

		foreach ($sheets as $key => $row) {
			if ($key != 1) {
				$attach = $user.'-'.strtotime(date('Y-m-d H:i:s')).$key.'.pdf';
				$item = $this->M_request->getItem("AND msib.segment1 = '".$row['D']."'", $row['F'], $row['G']);
				$cekid = $this->M_request->cekrequesttemp("where pic = '$user' order by nomor desc");
				$id = !empty($cekid) ? $cekid[0]['nomor'] + 1 : 1;
				
				$datanya = array(
					'jenis'      	=> $row['A'],
					'ket_cost'   	=> $row['B'],
					'cost_center'	=> $row['C'],
					'item'       	=> $row['D'],
					'description'	=> $item[0]['DESCRIPTION'],
					'qty'        	=> $row['E'],
					'onhand'     	=> $item[0]['ONHAND'],
					'ket_uom'    	=> empty($item[0]['SECONDARY_UOM_CODE']) ? 'Single Uom' : 'Dual Uom',
					'first_uom'  	=> $item[0]['PRIMARY_UOM_CODE'],
					'secondary_uom' => $item[0]['SECONDARY_UOM_CODE'],
					'inventory'  	=> $row['F'],
					'locator'    	=> $row['G'],
					'no_serial'  	=> $row['H'],
					'alasan'     	=> $row['I'],
					'desc_alasan'	=> $row['J'],
					'attachment' 	=> $attach,
					'pic'        	=> $user,
					'nomor' 	 	=> $id,
					'inv_item_id' 	=> $item[0]['INVENTORY_ITEM_ID'],
					'io' 			=> $io,
				);
				// echo "<pre>";print_r($datanya);exit();
				$save = $this->M_request->saveTemp($datanya); // save data temporary
			}
		}

		if ($ket == 'kasie') {
			redirect(base_url('MiscellaneousKasie/Request/tambahrequest'));
		}else {
			redirect(base_url('MiscellaneousSeksiLain/Request/tambahrequest'));
		}
	}
	

}