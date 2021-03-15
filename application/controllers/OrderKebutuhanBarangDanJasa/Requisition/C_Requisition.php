<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Requisition extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('form_validation');
		$this->load->library('upload');
		$this->load->library('encrypt');
		//load the login model
		$this->load->library('session');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('OrderKebutuhanBarangDanJasa/Requisition/M_requisition');
		$this->load->model('OrderKebutuhanBarangDanJasa/Approver/M_approver');


		if ($this->session->userdata('logged_in') != TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}

		if ($this->session->is_logged == FALSE) {
			redirect();
		}

		date_default_timezone_set("Asia/Bangkok");
	}

	public function index()
	{
		$user_id = $this->session->userid;

		$data['Menu'] = '';
		$data['SubMenuOne'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('OrderKebutuhanBarangDanJasa/V_Index', $data);
		$this->load->view('V_Footer', $data);
	}

	public function searchItem()
	{
		$string = $_GET['q'];
		$data = $this->M_requisition->getItem(strtoupper($string));

		echo json_encode($data);
	}

	public function Input()
	{
		// print_r($this->session);exit;
		$user_id = $this->session->userid;

		$noind = $this->session->user;


		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = 'Order Baru';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['pengorder'] = $this->M_requisition->getPersonId($noind);

		// echo '<pre>';
		// print_r($data['UserMenu']);exit;

		if ($this->session->responsibility_id == 2678) { //set admin atau bukan
			// if ($this->session->responsibility_id == 2683) { //set admin atau bukan dev
			$data['requester'] = $this->M_requisition->getRequsterAdmin($noind);
		} else {
			$data['requester'] = $data['pengorder'];
		}

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('OrderKebutuhanBarangDanJasa/Requisition/V_Input3', $data);
		$this->load->view('V_Footer', $data);
	}

	public function createOrder()
	{
		$noind = $this->session->user;

		$creator = $this->input->post('txtOKBOrderCreatorId');
		$requster = $this->input->post('txtOKBOrderRequesterId');
		$itemCode = $this->input->post('slcOKBinputCode[]');
		$description = $this->input->post('txtOKBinputDescription[]');
		$quantity = $this->input->post('txtOKBinputQty[]');
		$uom = $this->input->post('slcOKBuom[]');
		$nbd = $this->input->post('txtOKBnbd[]');
		$orderReason = $this->input->post('txtOKBinputReason[]');
		$orderNote = $this->input->post('txtOKBinputNote[]');
		$destination = $this->input->post('hdnDestinationOKB[]');
		$organization = $this->input->post('organizationOKB[]');
		$location = $this->input->post('locationOKB[]');
		$subinventory = $this->input->post('subinventoyOKB[]');
		$urgentFlag = $this->input->post('hdnUrgentFlagOKB[]');
		$urgentReason = $this->input->post('txtOKBinputUrgentReason[]');
		$statusOrder = $this->input->post('txtOKBHdnStatusOrder');
		$cutoff = $this->input->post('cutoff[]');

		$statusPage = $this->input->post('btnOKBSubmit');

		$itemkodDanNamaBarang = $this->input->post('hdnItemCodeOKB[]');

		$emailBatch = array();
		for ($i = 0; $i < count($itemCode); $i++) {

			if ($subinventory[$i] == '') {
				$subinventory[$i] = null;
			}
			if ($urgentReason[$i] == '') {
				$urgentReason[$i] = null;
			}

			$line = array(
				'CREATE_BY' => $creator,
				'INVENTORY_ITEM_ID' => $itemCode[$i],
				'QUANTITY' => str_replace(',', '', $quantity[$i]),
				'UOM' => $uom[$i],
				'ORDER_PURPOSE' => $orderReason[$i],
				'NOTE_TO_PENGELOLA' => $orderNote[$i],
				'ORDER_STATUS_ID' => 2,
				'URGENT_FLAG' => $urgentFlag[$i],
				'URGENT_REASON' => $urgentReason[$i],
				'DESTINATION_TYPE_CODE' => $destination[$i],
				'DESTINATION_ORGANIZATION_ID' => $organization[$i],
				'DELIVER_TO_LOCATION_ID' => $location[$i],
				'DESTINATION_SUBINVENTORY' => $subinventory[$i],
				'ITEM_DESCRIPTION' => $description[$i],
				'REQUESTER' => $requster,
				'IS_SUSULAN' => $statusOrder,
			);

			$email = array(
				'CREATE_BY' => $creator,
				'INVENTORY_ITEM_ID' => $itemCode[$i],
				'QUANTITY' => $quantity[$i],
				'UOM' => $uom[$i],
				'ORDER_PURPOSE' => $orderReason[$i],
				'NOTE_TO_PENGELOLA' => $orderNote[$i],
				'ORDER_STATUS_ID' => 2,
				'URGENT_FLAG' => $urgentFlag[$i],
				'URGENT_REASON' => $urgentReason[$i],
				'DESTINATION_TYPE_CODE' => $destination[$i],
				'DESTINATION_ORGANIZATION_ID' => $organization[$i],
				'DELIVER_TO_LOCATION_ID' => $location[$i],
				'DESTINATION_SUBINVENTORY' => $subinventory[$i],
				'ITEM_DESCRIPTION' => $description[$i],
				'REQUESTER' => $requster,
				'IS_SUSULAN' => $statusOrder,
				'KODEITEM' => $itemkodDanNamaBarang[$i]
			);

			$order_id = $this->M_requisition->saveLine($line, date("Y-m-d", strtotime($nbd[$i])), date("Y-m-d", strtotime($cutoff[$i])));

			// if ($urgentFlag[$i] == 'Y') {
			// 	$setApprover = $this->M_requisition->setApproverItemUrgent($creator, $itemCode[$i]);
			// } else {
			// 	if ($statusOrder == 'Y') {
			// 		$setApprover = $this->M_requisition->setApproverItemUrgent($creator, $itemCode[$i]);
			// 	} else {
			// 		$setApprover = $this->M_requisition->setApproverItem($creator, $itemCode[$i]);
			// 	}
			// }
			if ($statusOrder == 'Y') {
				$setApprover = $this->M_requisition->setApproverItemUrgent($creator, $itemCode[$i]);
			} else {
				if ($urgentFlag[$i] == 'Y') {
					$setApprover = $this->M_requisition->setApproverItemUrgent($creator, $itemCode[$i]);
				} else {
					$setApprover = $this->M_requisition->setApproverItem($creator, $itemCode[$i]);
				}
			}

			foreach ($setApprover as $key => $set) {

				$approver = array(
					'ORDER_ID' => $order_id[0]['ORDER_ID'],
					'APPROVER_ID' => $set['APPROVER'],
					'APPROVER_TYPE' => $set['APPROVER_LEVEL'],
				);


				$this->M_requisition->ApproveOrder($approver);
			}

			// if ($creator != $requster) {
			// 	if ($urgentFlag[$i] == 'Y' || $statusOrder == 'Y') {

			// 		$setApproverRequester = $this->M_requisition->setApproverItemUrgent($requster, $itemCode[$i]);
			// 	} else {

			// 		$setApproverRequester = $this->M_requisition->setApproverItem($requster, $itemCode[$i]);
			// 	}

			// 	foreach ($setApproverRequester as $key => $set) {

			// 		$approverRequester = array(
			// 			'ORDER_ID' => $order_id[0]['ORDER_ID'],
			// 			'APPROVER_ID' => $set['APPROVER'],
			// 			'APPROVER_TYPE' => $set['APPROVER_LEVEL'],
			// 		);


			// 		$this->M_requisition->ApproveOrder($approverRequester);
			// 	}
			// }

			// upload files
			$x = $i + 1;
			$number_of_files = sizeof($_FILES['fileOKBAttachment' . $x]['tmp_name']);

			$files = $_FILES['fileOKBAttachment' . $x];

			$config = array(
				'upload_path' => './assets/upload/Okebaja/',
				'allowed_types' => '*',
				'overwrite' => false,
			);

			$path = ('./assets/upload/Okebaja/');
			// print_r($files);exit;

			for ($j = 0; $j < $number_of_files; $j++) {
				$new_filename = $order_id[0]['ORDER_ID'] . '-' . $files['name'][$j];
				$_FILES['fileOKBAttachment' . $x]['name']		= $new_filename;
				$_FILES['fileOKBAttachment' . $x]['type']		= $files['type'][$j];
				$_FILES['fileOKBAttachment' . $x]['tmp_name']	= $files['tmp_name'][$j];
				$_FILES['fileOKBAttachment' . $x]['error']	= $files['error'][$j];
				$_FILES['fileOKBAttachment' . $x]['size']		= $files['size'][$j];

				$this->upload->initialize($config);

				$this->upload->do_upload('fileOKBAttachment' . $x);

				$media	= $this->upload->data();
				$inputFileName 	= './assets/upload/Okebaja/' . $media['file_name'];
				if (is_file($inputFileName)) {
					// echo('ada');
					chmod($inputFileName, 0777); ## this should change the permissions
				} else {
					// echo('nothing');
				}
				$replaceFileName = str_replace(' ', '_', $media['file_name']);
				$upload = array(
					'ORDER_ID' => $order_id[0]['ORDER_ID'],
					'ADDRESS' => $path,
					'FILE_NAME' => $replaceFileName,
					'ACTIVE_FLAG' => 'Y'
				);
				$this->M_requisition->uploadFiles($upload);
			}

			if (!isset($emailBatch[$setApprover[0]['APPROVER_NOIND']])) {
				$emailBatch[$setApprover[0]['APPROVER_NOIND']] = array();
			}

			array_push($emailBatch[$setApprover[0]['APPROVER_NOIND']], $email);
		}

		// foreach ($emailBatch as $key => $pesan) {
		// 	$noindemail = $key;
		// 	$normal = array();
		// 	$urgent = array();
		// 	$susulan = array();

		// 	$nApprover = $this->M_requisition->getNamaUser($key);
		// 	$namaApprover = $nApprover[0]['nama'];

		// 	$encrypt = $this->encrypt->encode($key);
		// 	$encrypt = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypt);

		// 	$link = "<a href='" . base_url("OrderKebutuhanBarangDanJasa/directEmail/$encrypt/") . "'>Disini</a>";

		// 	if ($nApprover[0]['jenkel'][0] == 'L') {
		// 		$jklApprover = 'Bapak ';
		// 	} else {
		// 		$jklApprover = 'Ibu ';
		// 	};

		// 	$cond = "WHERE ppf.NATIONAL_IDENTIFIER = '$key'";

		// 	$getNoindFromOracle = $this->M_requisition->getNoind($cond);

		// 	$allOrder = $this->M_approver->getListDataOrder();

		// 	foreach ($allOrder as $key => $order) {
		// 		$checkOrder = $this->M_approver->checkOrder($order['ORDER_ID']);
		// 		if (isset($checkOrder[0])) {
		// 			if ($checkOrder[0]['APPROVER_ID'] == $getNoindFromOracle[0]['PERSON_ID']) {
		// 				$orderSiapTampil = $this->M_approver->getOrderToApprove($order['ORDER_ID']);
		// 				if ($orderSiapTampil[0]['ORDER_CLASS'] != '2') {
		// 					if ($orderSiapTampil[0]['URGENT_FLAG'] == 'N' && $orderSiapTampil[0]['IS_SUSULAN'] == 'N') {
		// 						array_push($normal, $orderSiapTampil[0]);
		// 					} elseif ($orderSiapTampil[0]['URGENT_FLAG'] == 'Y' && $orderSiapTampil[0]['IS_SUSULAN'] == 'N') {
		// 						array_push($urgent, $orderSiapTampil[0]);
		// 					} elseif ($orderSiapTampil[0]['IS_SUSULAN'] == 'Y') {
		// 						array_push($susulan, $orderSiapTampil[0]);
		// 					}
		// 				}
		// 			}
		// 		}
		// 	}

		// 	$create = $pesan[0]['CREATE_BY'];
		// 	// $getNoindFromOracle = $this->M_requisition->getNoind($create);
		// 	$nCreator = $this->M_requisition->getNamaUser($noind);
		// 	$namaCreator = $nCreator[0]['nama'];

		// 	if ($nCreator[0]['jenkel'][0] == 'L') {
		// 		$jklCreator = 'Bapak ';
		// 	} else {
		// 		$jklCreator = 'Ibu ';
		// 	};

		// 	$subject = '[PRE-LAUNCH]Persetujuan Order Kebutuhan Barang Dan jasa';
		// 	$body = "<b>Yth. $jklApprover $namaApprover</b>,<br><br>";
		// 	$body .= "$jklCreator $namaCreator meminta approval Anda terkait order barang-barang berikut : <br><br>";
		// 	$body .= "	<table border='1' style=' border-collapse: collapse;'>
		// 					<thead>
		// 						<tr>
		// 							<th>Kode Barang</th>
		// 							<th>Deskripsi Barang</th>
		// 							<th>Quantity</th>
		// 							<th>UOM</th>
		// 							<th>Status Order</th>
		// 							<th>Alasan Pengadaan</th>
		// 							<th>Alasan Urgensi</th>
		// 						</tr>
		// 					</thead>
		// 					<tbody>";
		// 	for ($i = 0; $i < count($pesan); $i++) {
		// 		if ($pesan[$i]['URGENT_FLAG'] == 'Y' && $pesan[$i]['IS_SUSULAN'] == 'N') {
		// 			$statusOrder = 'Urgent';
		// 			$bgColor = '#d73925';
		// 		} else if ($pesan[$i]['URGENT_FLAG'] == 'N' && $pesan[$i]['IS_SUSULAN'] == 'N') {
		// 			$statusOrder = 'Reguler';
		// 			$bgColor = '#009551';
		// 		} elseif ($pesan[$i]['IS_SUSULAN'] == 'Y') {
		// 			$statusOrder = 'Emergency';
		// 			$bgColor = '#da8c10';
		// 		}

		// 		if ($pesan[$i]['URGENT_REASON'] == '') {
		// 			$urgentReason = '-';
		// 		} else {
		// 			$urgentReason = $pesan[$i]['URGENT_REASON'];
		// 		}

		// 		$emailSendDate = date("d-M-Y");
		// 		$pukul = date("h:i:sa");

		// 		$kodeBarang = $pesan[$i]['KODEITEM'];
		// 		$deskripsi = $pesan[$i]['ITEM_DESCRIPTION'];
		// 		$qty = $pesan[$i]['QUANTITY'];
		// 		$uom = $pesan[$i]['UOM'];
		// 		$alasanPengadaan = $pesan[$i]['ORDER_PURPOSE'];

		// 		$body .= "<tr>
		// 								<td>$kodeBarang</td>
		// 								<td>$deskripsi</td>
		// 								<td>$qty</td>
		// 								<td>$uom</td>
		// 								<td style='background-color:$bgColor;'>$statusOrder</td>
		// 								<td>$alasanPengadaan</td>
		// 								<td>$urgentReason</td>
		// 							</tr>";
		// 	}
		// 	$body .= "</body>";
		// 	$body .= "</table> <br><br>";
		// 	$body .= "<b>INFO :</b><br>";
		// 	$body .= "Terdapat <b>" . count($normal) . " order reguler, " . count($susulan) . " order emergency, dan " . count($urgent) . " order urgent</b> menunggu keputusan Anda!<br>";
		// 	$body .= "Apabila Anda ingin mengambil tindakan terhadap Order tersebut, Anda dapat klik link <b>$link</b> <br><br>";
		// 	$body .= "Demikian yang dapat kami sampaikan. Atas perhatian dan kerjasamanya kami ucapkan terima kasih. <br><br>";
		// 	$body .= "<span style='font-size:10px;'>*Email ini dikirimkan secara otomatis oleh aplikasi <b>Order Kebutuhan Barang Dan Jasa</b> pada $emailSendDate pukul $pukul<br>";
		// 	$body .= "*Apabila Anda menemukan kendala atau kesulitan maka dapat menghubungi Call Center ICT <b>12300 extensi 1. </span>";



		// 	$this->EmailAlert($noindemail, $subject, $body);
		// 	// echo $key;
		// }

		if ($statusPage == 0) {
			redirect('OrderKebutuhanBarangDanJasa/Requisition/Input', 'refresh');
		} elseif ($statusPage == 1) {
			redirect('OrderKebutuhanBarangDanJasa/Requisition/InputExcel', 'refresh');
		}
	}

	public function listDataAdmin()
	{
		$user_id = $this->session->userid;

		$noind = $this->session->user;

		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = 'List Order';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['pengorder'] = $this->M_requisition->getPengorder($noind);

		$where = 'AND ooh.order_status_id = ooh.order_status_id';

		if (isset($_POST['filter'])) {
			$filter = $this->input->post('filter');
			if ($filter == 'wipapproveatasan') {
				$where = 'AND ooh.order_status_id = 2';
			} else if ($filter == 'wipreleasepuller') {
				$where = 'AND ooh.order_status_id = 3';
			} else if ($filter == 'wipapprovepembelian') {
				$where = 'AND ooh.order_status_id = 6';
			} else if ($filter == 'fullapprove') {
				$where = 'AND ooh.order_status_id = 7';
			} else if ($filter == 'rejectbypembelian') {
				$where = 'AND ooh.order_status_id = 8';
			} else if ($filter == 'rejectbyatasan') {
				$where = 'AND ooh.order_status_id = 4';
			} else {
				$where = 'AND ooh.order_status_id = ooh.order_status_id';
			}

			$data['listOrder'] = $this->M_requisition->getListDataOrder2($noind, $where);

			$this->load->view('OrderKebutuhanBarangDanJasa/Requisition/V_TableListDataAdmin', $data);
		} else {

			$data['listOrder'] = $this->M_requisition->getListDataOrder2($noind, $where);

			$this->load->view('V_Header', $data);
			$this->load->view('V_Sidemenu', $data);
			$this->load->view('OrderKebutuhanBarangDanJasa/Requisition/V_Listdataadmin', $data);
			$this->load->view('V_Footer', $data);
		}
	}

	public function listData()
	{
		$user_id = $this->session->userid;

		$noind = $this->session->user;

		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = 'List Order';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['pengorder'] = $this->M_requisition->getPengorder($noind);

		$where = 'AND ooh.order_status_id = ooh.order_status_id';

		if (isset($_POST['filter'])) {
			$filter = $this->input->post('filter');
			if ($filter == 'wipapproveatasan') {
				$where = 'AND ooh.order_status_id = 2';
			} else if ($filter == 'wipreleasepuller') {
				$where = 'AND ooh.order_status_id = 3';
			} else if ($filter == 'wipapprovepembelian') {
				$where = 'AND ooh.order_status_id = 6';
			} else if ($filter == 'fullapprove') {
				$where = 'AND ooh.order_status_id = 7';
			} else if ($filter == 'rejectbypembelian') {
				$where = 'AND ooh.order_status_id = 8';
			} else if ($filter == 'rejectbyatasan') {
				$where = 'AND ooh.order_status_id = 4';
			} else {
				$where = 'AND ooh.order_status_id = ooh.order_status_id';
			}

			$data['listOrder'] = $this->M_requisition->getListDataOrder2($noind, $where);

			$this->load->view('OrderKebutuhanBarangDanJasa/Requisition/V_TableListDataAdmin', $data);
		} else {
			$data['listOrder'] = $this->M_requisition->getListDataOrder2($noind, $where);

			$this->load->view('V_Header', $data);
			$this->load->view('V_Sidemenu', $data);
			$this->load->view('OrderKebutuhanBarangDanJasa/Requisition/V_Listdata', $data);
			$this->load->view('V_Footer', $data);
		}
	}

	public function getDestination()
	{
		$itemkode = $_POST['itemkode'];

		$data = $this->M_requisition->getDestination($itemkode);

		echo json_encode($data);
	}

	public function getOrganization()
	{
		$itemkode = $_POST['itemkode'];

		$data = $this->M_requisition->getOrganization($itemkode);

		echo json_encode($data);
	}

	public function getLocation()
	{
		$data = $this->M_requisition->getLocation();

		echo json_encode($data);
	}

	public function getSubinventory()
	{
		$organization = $_POST['organization'];

		$data = $this->M_requisition->getSubinventory($organization);

		echo json_encode($data);
	}

	public function getHistoryOrder()
	{
		$order_id = $this->input->post('orderid');
		$data	  = $this->M_requisition->getHistoryOrder($order_id);

		echo json_encode($data);
	}

	public function SetupApprover()
	{
		// print_r($this->session);exit;
		$user_id = $this->session->userid;

		$noind = $this->session->user;

		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = 'Setup User';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['pengorder'] = $this->M_requisition->getPersonId($noind);
		$person_id = $data['pengorder'][0]['PERSON_ID'];

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		if ($this->session->responsibility_id == 2678) {
			$data['activeRequestor'] = $this->M_requisition->getRequestor($person_id);

			$this->load->view('OrderKebutuhanBarangDanJasa/Requisition/V_SetupRequestor', $data);
		} else {
			$levelUnit = "AND oah.APPROVER_LEVEL = '5'";
			$levelDepartment = "AND oah.APPROVER_LEVEL = '8'";

			$data['approverUnit'] = $this->M_requisition->getApprover($person_id, $levelUnit);
			$data['approverDepartment'] = $this->M_requisition->getApprover($person_id, $levelDepartment);

			$this->load->view('OrderKebutuhanBarangDanJasa/Requisition/V_SetupApprover', $data);
		}
		$this->load->view('V_Footer', $data);
	}

	public function searchAtasan()
	{
		$string = $_GET['q'];
		$data = $this->M_requisition->getAtasan(strtoupper($string));

		echo json_encode($data);
	}

	public function setAtasan()
	{
		$noind = $this->session->user;
		$pengorder = $this->M_requisition->getPersonId($noind);

		// print_r($pengorder);exit;

		$unit = $this->input->post('slcAtasanUnitOKB');
		$department = $this->input->post('slcAtasanDepartmentOKB');

		$atasanUnit = array(
			'PERSON_ID' => $pengorder[0]['PERSON_ID'],
			'APPROVER_LEVEL' => 5,
			'APPROVER' => $unit,
		);
		$this->M_requisition->setAtasan($atasanUnit);

		$atasanDepartment = array(
			'PERSON_ID' => $pengorder[0]['PERSON_ID'],
			'APPROVER_LEVEL' => 8,
			'APPROVER' => $department,
		);
		$this->M_requisition->setAtasan($atasanDepartment);

		$atasanDireksi = array(
			'PERSON_ID' => $pengorder[0]['PERSON_ID'],
			'APPROVER_LEVEL' => 9,
			'APPROVER' => 6355,
		);
		$this->M_requisition->setAtasan($atasanDireksi);

		redirect('OrderKebutuhanBarangDanJasa/Requisition/SetupApprover', 'refresh');
	}
	public function SetupUser()
	{
		$user_id = $this->session->userid;

		$noind = $this->session->user;

		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = 'Setup User';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['pengorder'] = $this->M_requisition->getPersonId($noind);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('OrderKebutuhanBarangDanJasa/Requisition/V_SetupUser', $data);
		$this->load->view('V_Footer', $data);
	}

	public function setUser()
	{
		$kasie = $this->input->post('slcAtasanOKB[]');
		$unit1 = $this->input->post('slcAtasanUnit1OKB[]');
		$unit2 = $this->input->post('slcAtasanUnit2OKB[]');
		$department = $this->input->post('slcAtasanDepartmentOKB[]');

		for ($i = 0; $i < count($kasie); $i++) {
			$atasanUnit = array(
				'PERSON_ID' => $kasie[$i],
				'APPROVER_LEVEL' => 5,
				'APPROVER' => $unit1[$i],
			);
			$this->M_requisition->setAtasan($atasanUnit);
			if ($unit2[$i] != '') {
				$atasanUnit2 = array(
					'PERSON_ID' => $kasie[$i],
					'APPROVER_LEVEL' => 5,
					'APPROVER' => $unit2[$i],
				);
				$this->M_requisition->setAtasan($atasanUnit2);
			}

			$atasanPengelola = array(
				'PERSON_ID' => $kasie[$i],
				'APPROVER_LEVEL' => 7,
			);
			$this->M_requisition->setAtasan($atasanPengelola);

			$atasanDepartment = array(
				'PERSON_ID' => $kasie[$i],
				'APPROVER_LEVEL' => 8,
				'APPROVER' => $department[$i],
			);
			$this->M_requisition->setAtasan($atasanDepartment);

			$atasanUrgent = array(
				'PERSON_ID' => $kasie[$i],
				'APPROVER_LEVEL' => 9,
				'APPROVER' => 1513,
			);
			$this->M_requisition->setAtasan($atasanUrgent);

			$atasanDireksi = array(
				'PERSON_ID' => $kasie[$i],
				'APPROVER_LEVEL' => 10,
				'APPROVER' => 6355,
			);
			$this->M_requisition->setAtasan($atasanDireksi);
		}
		redirect('OrderKebutuhanBarangDanJasa/Requisition/SetupUser', 'refresh');
	}

	public function SetActiveApprover()
	{
		$approver = $_POST['approver'];
		$person_id = $_POST['person_id'];

		$this->M_requisition->setDeactiveApprover($approver, $person_id);
		$this->M_requisition->setActiveApprover($approver, $person_id);

		echo 1;
	}

	public function SetRequestor()
	{
		$person_id = $_POST['person_id'];
		$requestor = $_POST['requestor'];

		$this->M_requisition->removeRequestor($person_id);
		$data = array(
			'PERSON_ID' => $person_id,
			'APPROVER_LEVEL' => '3',
			'APPROVER' => $requestor,
		);
		$this->M_requisition->setRequestor($data);

		echo 1;
	}

	public function InfoOrderPR()
	{
		$order_id = $_POST['order_id'];

		$data['info'] = $this->M_requisition->getInfoOrderPR($order_id);

		$returnTable = $this->load->view('OrderKebutuhanBarangDanJasa/Requisition/V_TableInfoPR', $data, true);

		echo ($returnTable);
	}

	public function CancelOrder()
	{
		$order_id = $_POST['order_id'];

		$this->M_requisition->CancelOrder($order_id);

		echo 1;
	}

	public function EmailAlert($noind, $subject, $body)
	{
		//email
		// echo $noind;exit;
		$getEmail = $this->M_approver->getEmail($noind);
		// echo 
		// $emailUser = 'bondan_surya_n@quick.com';

		//send Email

		if ($getEmail) {
			$emailUser = $getEmail[0]['EMAIL_INTERNAL'];
			$this->load->library('PHPMailerAutoload');
			$mail = new PHPMailer();
			$mail->SMTPDebug = 0;
			$mail->Debugoutput = 'html';

			// set smtp
			$mail->isSMTP();
			$mail->Host = 'm.quick.com';
			$mail->Port = 465;
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'ssl';
			$mail->SMTPOptions = array(
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
				)
			);
			$mail->Username = 'no-reply';
			$mail->Password = '123456';
			$mail->WordWrap = 50;

			// set email content
			$mail->setFrom('no-reply@quick.com', 'ERP OKEBAJA');
			$mail->addAddress($emailUser);
			$mail->Subject = $subject;
			$mail->msgHTML($body);

			if (!$mail->send()) {
				echo "Mailer Error: " . $mail->ErrorInfo;
				exit();
			} else {
				// echo "Message sent!";
			}
		}
	}

	public function InputExcel()
	{
		$user_id = $this->session->userid;

		$noind = $this->session->user;

		$data['Menu'] = 'Order';
		$data['SubMenuOne'] = 'Input Order Via Excel';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['pengorder'] = $this->M_requisition->getPersonId($noind);

		if ($this->session->responsibility_id == 2678) { //set admin atau bukan
			$data['requester'] = $this->M_requisition->getRequsterAdmin($noind);
		} else {
			$data['requester'] = $data['pengorder'];
		}

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('OrderKebutuhanBarangDanJasa/Requisition/V_ImportOrder', $data);
		$this->load->view('V_Footer', $data);
	}

	public function downloadAttachment()
	{
		$this->load->helper('download');

		$attachment_id = $this->input->get('id-attachment');
		$path	  = './assets/upload/Okebaja/';
		$filename = $this->M_requisition->getAttachment($attachment_id)['FILE_NAME'];

		force_download($path . $filename, NULL);
	}
}
