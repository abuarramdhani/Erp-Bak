<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_NonConformity extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('upload');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PurchaseManagementGudang/MainMenu/M_nonconformity');

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	/* LIST DATA */
	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Non Conformity';
		$data['Menu'] = 'Purchase Management';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['PoOracleNonConformityHeaders'] = $this->M_nonconformity->getHeaders();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PurchaseManagementGudang/NonConformity/V_Index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function listData()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Non Conformity';
		$data['Menu'] = 'Purchase Management';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['PoOracleNonConformityHeaders'] = $this->M_nonconformity->getHeaders();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PurchaseManagementGudang/NonConformity/V_listData', $data);
		$this->load->view('V_Footer',$data);
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Non Conformity Data';
		$data['Menu'] = 'Purchase Management';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['PoOracleNonConformityHeaders'] = $this->M_nonconformity->getHeaders($plaintext_string);
		$data['Phone'] = $this->M_nonconformity->getPhone($data['PoOracleNonConformityHeaders'][0]['po_number']);
		
		/* LINES DATA */
		$data['PoOracleNonConformityLines'] = $this->M_nonconformity->getLines($plaintext_string);
		$data['linesItem'] = $this->M_nonconformity->getLinesItem($data['PoOracleNonConformityHeaders'][0]['header_id']);

		if (count($data['PoOracleNonConformityLines']) > 0) {
			$sourceId = $data['PoOracleNonConformityLines'][0]['source_id'];
	
			$data['image'] = $this->M_nonconformity->getImages($sourceId);
		}else {
			$data['image'] = '';
			$data['PoOracleNonConformityLines'] = '';
		}

		// echo'<pre>';
		// print_r($data['PoOracleNonConformityLines']);exit;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PurchaseManagementGudang/NonConformity/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

	public function edit($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Non Conformity Data';
		$data['Menu'] = 'Purchase Management';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['PoOracleNonConformityHeaders'] = $this->M_nonconformity->getHeaders($plaintext_string);
		$data['Phone'] = $this->M_nonconformity->getPhone($data['PoOracleNonConformityHeaders'][0]['po_number']);
		
		/* LINES DATA */
		$data['PoOracleNonConformityLines'] = $this->M_nonconformity->getLines($plaintext_string);
		$data['linesItem'] = $this->M_nonconformity->getLinesItem($data['PoOracleNonConformityHeaders'][0]['header_id']);
		// echo'<pre>';
		// print_r($data['linesItem']);exit;

		if (count($data['PoOracleNonConformityLines']) > 0) {
			$sourceId = $data['PoOracleNonConformityLines'][0]['source_id'];
	
			$data['image'] = $this->M_nonconformity->getImages($sourceId);
		}else {
			$data['image'] = '';
			$data['PoOracleNonConformityLines'] = '';
		}

		// echo'<pre>';
		// print_r($data['PoOracleNonConformityLines']);exit;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PurchaseManagementGudang/NonConformity/V_edit2', $data);
		$this->load->view('V_Footer',$data);
	}

	public function Judgement(){
		$line_id = $this->input->post('line_id');
		$header_id = $this->input->post('header');
		$judgement = array(
			'judgement_description' => $this->input->post('judgement'),
			'judgement'				=> $this->input->post('judgementType'),
			'status'				=> 'close',
			'last_update_date'		=> date('Y-m-d'),
			'last_updated_by'		=> $this->session->userid
		);
		$retr = $this->M_nonconformity->updateJudgement($line_id,$judgement);
		$checkLineStatus = $this->M_nonconformity->checkLineStatus($header_id);
		$count = 0;
		foreach ($checkLineStatus as $value) {
			if($value['status'] == 'close') {
				$count++;
			}
		}
		if ($count == count($checkLineStatus)) {
			$headStat = array(
				'status' => 'close',
				'last_update_date' => date('Y-m-d'),
				'last_updated_by' => $this->session->userid
			);
			$this->M_nonconformity->updateHeadStatus($header_id,$headStat);

			$this->load->library('email');
			$config['protocol'] = 'smtp';
			$config['smtp_host']='mail.quick.com';
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;
			$this->email->initialize($config);

			$this->email->from('system.non_conformity@quick.com','Non Conformity');
			$this->email->to('purchasing.sec8@quick.com');
			$this->email->subject('Non Conformity Closed Data');
			$this->email->message('Data Non Conformity was Closed - '.$header_id);
			
			if (!$this->email->send()) {
				$error = $this->email->print_debugger();
				echo $error;exit();
			}else{
				$this->email->send();
			}

			array_push($retr, 'close');
			echo json_encode($retr);
		}else{
			echo json_encode($retr);
		}
	}

	public function getLineItems(){
		$line_id = $this->input->post('id');
		$data = $this->M_nonconformity->getLineItems($line_id);
		//print_r($data);

		if ($data == NULL) {
			echo 0;
		}else{
			$no = 1;
			echo '	<table class="table table-striped table-bordered table-hover" style="font-size:12px;">
						<thead>
							<tr class="bg-primary">
								<th style="text-align:center; width:30px">No</th>
								<th style="text-align:center;">Item Code</th>
								<th style="text-align:center;">Item Description</th>
							</tr>
						</thead>
						<tbody>';
			foreach ($data as $dt) {
						echo '<tr><td>'.$no++.'</td>
							<td>'.$dt["item_code"].'</td>
								<td>'.$dt["item_description"].'</td></tr>';
			}
				echo '	</tbody>
					</table>';
		}
	}

	public function Remark(){
		$line_id = $this->input->post('line_id');
		$data 	= array(
			'remark' 				=> $this->input->post('remark'),
			'last_update_date'		=> date('Y-m-d'),
			'last_updated_by'		=> $this->session->userid
		);
		$remark = $this->M_nonconformity->updateRemark($line_id,$data);
		echo json_encode($remark);
	}

	public function ExportPDF($header_id,$line_id){
		$this->load->library('pdf');
		$pdf = $this->pdf->load();

		$pdf = new mPDF('utf-8', 'LEGAL', 0, '', 20, 15, 10, 15, 0, 0, 'P');
		$filename = 'NonConformity.pdf';
		$this->checkSession();
		$data['Title'] = 'NonConformity';
		$data['head'] = $this->M_nonconformity->getHeaders($header_id);
		$data['lines'] = $this->M_nonconformity->getLines($header_id);
		$data['item'] = $this->M_nonconformity->getLineItems($header_id);
		$sourceId = $data['lines'][0]['source_id'];
		$data['image'] = $this->M_nonconformity->getImages($sourceId);
		// echo '<pre>';
		// print_r($data['item']);exit;
		$stylesheet = file_get_contents(base_url('assets/plugins/bootstrap/3.3.6/css/bootstrap.css'));
		$html 		= $this->load->view('PurchaseManagementGudang/NonConformity/V_Download_PDF', $data, true);
		$html_2		= $this->load->view('PurchaseManagementGudang/NonConformity/V_Download_PDF_Page_2', $data, true);
		$html_3		= $this->load->view('PurchaseManagementGudang/NonConformity/V_Download_PDF_Page_3', $data, true);
		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html,2);
		$pdf->SetHTMLFooter('
			<table width="100%" style="padding-bottom: 20pt;vertical-align: bottom; font-family: serif; font-size: 10pt; color: grey; font-style: italic;">
				<tr>
					<td align="right">{PAGENO}/{nbpg}</td>
				</tr>
				<tr><td>&nbsp;</td>
				<tr><td>&nbsp;</td>
				</tr>
			</table>
		');
		$pdf->AddPage();
		$pdf->WriteHTML($html_2,2);
		$pdf->AddPage();
		$pdf->WriteHTML($html_3,2);
		$pdf->Output($filename, 'I');
	}

	public function insert()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Non Conformity';
		$data['Menu'] = 'Purchase Management';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['PoOracleNonConformityHeaders'] = $this->M_nonconformity->getHeaders();
		$data['case'] = $this->M_nonconformity->getCase();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PurchaseManagementGudang/NonConformity/V_Insert', $data);
		$this->load->view('V_Footer',$data);
	}

	public function submitSource()
	{
		$user_id = $this->session->user;

		$photo = $this->input->post('photo[]');
		$remark = $this->input->post('remark[]');
		$description = $this->input->post('txtDescription');

		// echo '<pre>';
		// print_r($remark);exit;

		$source = array('info' => $description,
						'created_by' => $user_id,
						'creation_date' => 'now()',
						'last_update_by' => $user_id,
						'last_update_date' => 'now()',
					);

		$sourceId = $this->M_nonconformity->saveSource($source);

		$num = $this->M_nonconformity->checkNonConformityNum();

		if (count($num)==0) {
			$nonConformityNum = 'NC-PUR-'.date('y').'-'.date('m').'-'.'000';
		}else {
			$nonConformityNum = $num[0]['non_conformity_num'];
		}
		$numberNC = explode('-', $nonConformityNum);

		$numberNC[4]++;

		$numberNC[4] = sprintf("%03d", $numberNC[4]);

		$nonConformityNumber = implode('-', $numberNC);
		

		$header = array('creation_date' => 'now()',
						'non_conformity_num' => $nonConformityNumber,

					 );

		$headerId = $this->M_nonconformity->simpanHeader($header);

		//////////////////////UPLOAD PHOTO////////////

		$number_of_files = sizeof($_FILES['photo']['tmp_name']);
	

 		$files = $_FILES['photo'];

   		$config = array('upload_path' => './assets/upload/NonConformity/',
						'allowed_types' => 'gif|jpg|jpeg|png',
						'overwrite' => false,         
    				);

		$path = ('./assets/upload/NonConformity/');
		
			for ($j=0; $j < $number_of_files; $j++) 
   				{ 
					$_FILES['photo']['name']			= $files['name'][$j];
					$_FILES['photo']['type'] 			= $files['type'][$j];
					$_FILES['photo']['tmp_name']		= $files['tmp_name'][$j];
					$_FILES['photo']['error'] 			= $files['error'][$j];
					$_FILES['photo']['size']			= $files['size'][$j];

					$this->upload->initialize($config);
				
					$this->upload->do_upload('photo');
					$media	= $this->upload->data();
					// print_r($media);
					$inputFileName 	= './assets/upload/NonConformity/'.$media['file_name'];
				
					if(is_file($inputFileName))
					{
					// echo('ada');
						chmod($inputFileName, 0777); ## this should change the permissions
					}else {
					// echo('nothing');
					}
					$replaceFileName = str_replace(' ','_',$files['name'][$j]);
					$upload = array (
						'source_id' => $sourceId[0]['lastval'],
						'image_path' => $path,
						'file_name' => $media['file_name'],
					);

					// echo"<pre>";
					// print_r($upload);

					$this->M_nonconformity->saveImage($upload);
				}

				//////////////////CASE///////////////////
		for ($i=0; $i < count($remark); $i++) { 
			
			$case = array(
						'source_id' => $sourceId[0]['lastval'],
						'case_id' => $remark[$i],
					);

			$this->M_nonconformity->saveCase($case);

			//////////////////////LINES//////////////////////////////
			$lines = array(
						'case_id' => $remark[$i],
						'header_id' => $headerId[0]['lastval'],
						'description' => $description,
						'source_id' => $sourceId[0]['lastval'],
					);
			$this->M_nonconformity->saveLine($lines);

			// print_r($lines);exit;
		}

		redirect('PurchaseManagementGudang/NonConformity', 'refresh');
	}

	public function searchItem()
	{
		$string = $_GET['q'];
		$data = $this->M_nonconformity->getItem(strtoupper($string));
		echo json_encode($data);
	}

	public function saveData()
	{
		$headerId = $this->input->post('txtHeaderId');
		$deliveryDate = $this->input->post('txtDeliveryDate');
		$packingList = $this->input->post('txtPackingList');
		$courierAgent = $this->input->post('txtCourierAgent');
		$verificator = $this->input->post('txtVerificator');
		$supplierName = $this->input->post('txtSupplierName');
		$personInCharge = $this->input->post('txtPersonInCharge');
		$phoneNumber = $this->input->post('txtPhoneNumber');
		$faxNumber = $this->input->post('txtFaxNumber');
		$supplierAddress = $this->input->post('txtSupplierAddress');
		$setItem = $this->input->post('hdnItem[]');
		$desc = $this->input->post('hdnDesc[]');
		$qtyAmount = $this->input->post('hdnQtyRecipt[]');
		$qtyBilled = $this->input->post('hdnQtyBilled[]');
		$qtyReject = $this->input->post('hdnQtyReject[]');
		$currency = $this->input->post('hdnCurrency[]');
		$unitPrice = $this->input->post('hdnUnitPrice[]');
		$qtyPo = $this->input->post('hdnQtyPo[]');
		$qtyProblem = $this->input->post('txtQtyProblem[]');
		$problemTracking = $this->input->post('txtProblemTracking');
		$scope = $this->input->post('slcScope');
		$problemCompletion = $this->input->post('txtProblemCompletion');
		$dateCompletion = $this->input->post('txtDate');
		$car = $this->input->post('slcCar');
		$status = $this->input->post('txtheaderStatusNonC');
		$statusCase = $this->input->post('slcCaseStatus');
		$po = $this->input->post('hdnPO[]');
		$linePO = $this->input->post('hdnLine[]');
		$statusLine = $this->input->post('hdnStatusLine[]');
		$buyer = $this->input->post('hdnBuyer[]');
		$noLppb = $this->input->post('hdnLppb[]');

		$header = 	array(
						// 'po_number' => $poNumber,
						'delivery_date' => $deliveryDate,
						'packing_list' => $packingList,
						'courier_agent' => $courierAgent,
						'verificator' => $verificator,
						// 'buyer' => $buyer,
						'supplier' => $supplierName,
						'supplier_address' => $supplierAddress,
						'person_in_charge' => $personInCharge,
						'status' => $status
				   );
		
				   if ($problemCompletion == '') {
					   $problemCompletion = null;
				   }

				   if ($problemTracking == '') {
					   $problemTracking = null;
				   }

				   if ($scope == '') {
					   $scope = null;
				   }

				   if ($dateCompletion == '') {
					   $dateCompletion = null;
				   }
		
		$this->M_nonconformity->updateHeader($headerId, $header);

		$lines = 	array(
						// 'po_number' => $poNumber,
						// 'judgement' => $setJudgement,
						// 'judgement_description' => $setJudgementDescription,
						// 'remark' => $setRemark,
						'problem_tracking' => $problemTracking,
						'scope' => $scope,
						'problem_completion' => $problemCompletion,
						'completion_date' => $dateCompletion,
						'judgement' => $car,
						'status' => $statusCase
					);
		
		$this->M_nonconformity->updateLines($headerId, $lines);

		
		$itemCheck = $this->M_nonconformity->getLinesItem($headerId);

		if (count($itemCheck) >0 )  {
			$this->M_nonconformity->deleteItem($headerId);
		}

		for ($i=0; $i <count($setItem) ; $i++) { 
			if($qtyAmount[$i]=='' || $qtyAmount[$i]== null){
				$qtyAmount[$i] = 0;
			}
			// $lineExplode = explode("|",$setItem[$i]);

			// $itemCode = $lineExplode[0];
			// $description = $lineExplode[1];


			$item = array('item_code' => $setItem[$i],
						'item_description' => $desc[$i],
						'header_id' =>$headerId,
						'quantity_amount' =>$qtyAmount[$i],
						'quantity_billed' =>$qtyBilled[$i],
						'quantity_reject' =>$qtyReject[$i],
						'currency' =>$currency[$i],
						'unit_price' =>$unitPrice[$i],
						'quantity_po' =>$qtyPo[$i],
						'quantity_problem' => $qtyProblem[$i],
						'no_po' => $po[$i],
						'line' => $linePO[$i],
						'closure_status' => $statusLine[$i],
						'buyer' => $buyer[$i],
						'no_lppb' => $noLppb[$i]
					);


			$this->M_nonconformity->setItem($item);

		}
		
	    // echo'<pre>';
		// print_r($header);exit;

		$encrypted_string = $this->encrypt->encode($headerId);
		$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);

		redirect('PurchaseManagementGudang/NonConformity/read/'.$encrypted_string, 'refresh');
	}

	public function getDetailPO()
	{
		$noPO = $_POST['poNumber'];

		$hasil = $this->M_nonconformity->getDetailPO($noPO);

		echo json_encode($hasil);
	}
	

	public function getLinesNew()
	{
		$poNum = $_POST['po'];

		$data['dataLines'] = $this->M_nonconformity->getLinesNew($poNum);

		$returnView = $this->load->view('PurchaseManagementGudang/NonConformity/V_AddLines',$data, TRUE);

		echo($returnView);



		// echo json_encode($data);
	}

	public function loginAndroid()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$password_md5 = md5($password);
		$log = $this->M_Index->login($username,$password_md5);

		if($log){
			$user = $this->M_Index->getDetail($username);
			
			foreach($user as $user_item){
				$iduser 			= $user_item->user_id;
				$password_default 	= $user_item->password_default;
				$kodesie			= $user_item->section_code;
				$employee_name 		= $user_item->employee_name; 
				$kode_lokasi_kerja 	= $user_item->location_code;
			}
			$ses = array(
							'error' 		=> false,
							'userid' 			=> $iduser,
							'user' 				=> strtoupper($username),
							'employee'  		=> $employee_name,
							'kodesie' 			=> $kodesie,
							'kode_lokasi_kerja'	=> $kode_lokasi_kerja,
						);
			// $this->session->set_userdata($ses);
			
			// redirect($this->session->userdata('last_page'));
			
			
			//redirect('index');
		}else{
			$ses = array(
				'error' 			=> true,
				'userid' 			=> null,
				'user' 				=> null,
				'employee'  		=> null,
				'kodesie' 			=> null,
				'kode_lokasi_kerja'	=> null,
				);
			// $this->session->set_userdata($ses);
		}

		echo json_encode($ses);
	}

	public function getCaseAndroid()
	{
		$case = $this->M_nonconformity->getCase();

		if (count($case) > 0) {
			$data['status'] = true;
        	$data['result'][] = $case;
		}else {
			$data['status'] = false;
    		$data['result'][] = "Data not Found";
		}

		print_r(json_encode($data));
	}

	public function submitSourceAndroid()
	{
		$user_id = $_POST['userid'];

		// $photo = $this->input->post('photo[]');
		// $remark = $this->input->post('remark[]');
		// $description = $this->input->post('txtDescription');
		$photo = $_FILES['file'];
		$description = $_POST['desc'];
		$remark = $_POST['tag'];

		$source = array('info' => $description,
						'created_by' => $user_id,
						'creation_date' => 'now()',
						'last_update_by' => $user_id,
						'last_update_date' => 'now()',
					);

		$sourceId = $this->M_nonconformity->saveSource($source);

		$num = $this->M_nonconformity->checkNonConformityNum();

		if (count($num)==0) {
			$nonConformityNum = 'NC-PUR-'.date('y').'-'.date('m').'-'.'000';
		}else {
			$nonConformityNum = $num[0]['non_conformity_num'];
		}
		$numberNC = explode('-', $nonConformityNum);

		$numberNC[4]++;

		$numberNC[4] = sprintf("%03d", $numberNC[4]);

		$nonConformityNumber = implode('-', $numberNC);
		

		$header = array('creation_date' => 'now()',
						'non_conformity_num' => $nonConformityNumber,

					 );

		$headerId = $this->M_nonconformity->simpanHeader($header);

		//////////////////////UPLOAD PHOTO////////////
		$path = ('./assets/upload/NonConformity/');
		for($j=0;$j<count($_FILES['file']['tmp_name']);$j++){

			$response['error'] = false;
			$response['message'] =  "number of files recieved is = ".count($_FILES['file']['name']);
			if(move_uploaded_file($_FILES['file']['tmp_name'][$j],$path.$_FILES['file']['name'][$j])){
				  $response['error'] = false;
			$response['message'] =  $response['message']. "moved sucessfully ::  ";

					$inputFileName 	= './assets/upload/NonConformity/'.$_FILES['file']['name'][$j];
				
					if(is_file($inputFileName))
					{
					// echo('ada');
						chmod($inputFileName, 0777); ## this should change the permissions
					}else {
					// echo('nothing');
					}
					$replaceFileName = str_replace(' ','_',$files['name'][$j]);
					$upload = array (
						'source_id' => $sourceId[0]['lastval'],
						'image_path' => $path,
						'file_name' => $_FILES['file']['name'][$j],
					);

					// echo"<pre>";
					// print_r($upload);

					$this->M_nonconformity->saveImage($upload);
			
			}else{
			$response['error'] = true;
			$response['message'] = $response['message'] ."cant move :::" .$path ;
	   
			}
		}

				//////////////////CASE///////////////////
		for ($i=0; $i < count($remark); $i++) { 
			
			$case = array(
						'source_id' => $sourceId[0]['lastval'],
						'case_id' => $remark[$i],
					);

			$this->M_nonconformity->saveCase($case);

			//////////////////////LINES//////////////////////////////
			$lines = array(
						'case_id' => $remark[$i],
						'header_id' => $headerId[0]['lastval'],
						'description' => $description,
						'source_id' => $sourceId[0]['lastval'],
					);
			$this->M_nonconformity->saveLine($lines);

			// print_r($lines);exit;
		}

		// redirect('PurchaseManagementGudang/NonConformity', 'refresh');
	}
}