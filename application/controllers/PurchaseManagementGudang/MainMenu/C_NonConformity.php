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
			redirect('');
		}
	}

	/* LIST DATA */
	public function index()
	{
		
		$user = $this->session->user;

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
		$user = $this->session->user;

		$user_id = $this->session->userid;

		// echo $user_id;exit;
		$data['Title'] = 'Pending Assign';
		$data['Menu'] = 'Non Conformity';
		$data['SubMenuOne'] = 'Pending Assign';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['PoOracleNonConformityHeaders'] = $this->M_nonconformity->getHeaders();

		// echo '<pre>';
		// print_r($data['PoOracleNonConformityHeaders']);exit;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PurchaseManagementGudang/NonConformity/V_listData', $data);
		$this->load->view('V_Footer',$data);
	}

	public function listSupplier()
	{
		$user = $this->session->user;

		$user_id = $this->session->userid;

		$data['Title'] = 'List Data Supplier';
		$data['Menu'] = 'Non Conformity';
		$data['SubMenuOne'] = 'List Data Supplier';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$assign = 1;

		$data['PoOracleNonConformityHeaders'] = $this->M_nonconformity->getHeaders2($assign);

		// echo '<pre>';
		// print_r($data['PoOracleNonConformityHeaders']);exit;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PurchaseManagementGudang/NonConformity/V_listDataSupplier', $data);
		$this->load->view('V_Footer',$data);
	}

	public function listSubkon()
	{
		$user = $this->session->user;

		$user_id = $this->session->userid;

		$data['Title'] = 'List Data Subkon';
		$data['Menu'] = 'Non Conformity';
		$data['SubMenuOne'] = 'List Data Subkon';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$assign = 2;

		$data['PoOracleNonConformityHeaders'] = $this->M_nonconformity->getHeaders2($assign);

		// echo '<pre>';
		// print_r($data['PoOracleNonConformityHeaders']);exit;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PurchaseManagementGudang/NonConformity/V_listDataSubkon', $data);
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
		// echo '<pre>';
		// print_r($data['PoOracleNonConformityLines']);
		// exit;
		$data['linesItem'] = $this->M_nonconformity->getLinesItem($data['PoOracleNonConformityHeaders'][0]['header_id']);
		$data['case'] = $this->M_nonconformity->getCase();

		if (count($data['PoOracleNonConformityLines']) > 0) {
			$sourceId = $data['PoOracleNonConformityLines'][0]['source_id'];
	
			$data['image'] = $this->M_nonconformity->getImages($sourceId);
		}else {
			$data['image'] = '';
			$data['PoOracleNonConformityLines'] = '';
		}

		if ($this->session->responsibility_id == 2569) {
			$supplier = 1;
			$buyer = $this->M_nonconformity->getBuyer($supplier);
			$data['buyer'] = $buyer;
		}else if ($this->session->responsibility_id == 2641) {
			$subkon = 2;
			$buyer = $this->M_nonconformity->getBuyer($subkon);
			$data['buyer'] = $buyer;
		}
		// echo'<pre>';
		// print_r($data['PoOracleNonConformityLines']);exit;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PurchaseManagementGudang/NonConformity/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

	public function readAssign($id)
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
		// echo '<pre>';
		// print_r($data['PoOracleNonConformityLines']);
		// exit;
		$data['linesItem'] = $this->M_nonconformity->getLinesItem($data['PoOracleNonConformityHeaders'][0]['header_id']);
		$data['case'] = $this->M_nonconformity->getCase();

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
		$this->load->view('PurchaseManagementGudang/NonConformity/V_readAssign', $data);
		$this->load->view('V_Footer',$data);
	}

	public function submitAssign()
	{
		$user = $this->session->user;
		// echo $user;exit;
		$encryptId = $this->input->post('hdnHeadId');
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $encryptId);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$assign = $this->input->post('slcAssign');
		$reasonReturn = $this->input->post('txtReasonReturn');

		if ($assign == 2) {
			$num = $this->M_nonconformity->checkNonConformitySubkonNum();
			if (count($num)==0) {
				$nonConformityNum = 'NC-PURSUB-'.date('y').'-'.date('m').'-'.'000';
			}else{
				$nonConformityNum = $num[0]['non_conformity_num'];
			}
			$numberNC = explode('-', $nonConformityNum);

			$numberNC[4]++;

			$numberNC[4] = sprintf("%03d", $numberNC[4]);

			$nonConformityNumber = implode('-', $numberNC);

			$data = array('non_conformity_num' => $nonConformityNumber, 
						  'assign' => $assign,
						  'last_menu' => 'Pending Assign',
						  'last_update_date' => 'now()',
						  'last_updated_by' => $user
						);
			$this->M_nonconformity->updateAssign($plaintext_string, $data);
		}else if($assign == 1) {

			$num = $this->M_nonconformity->checkNonConformitySupplierNum();
			if (count($num)==0) {
				$nonConformityNum = 'NC-PURSUP-'.date('y').'-'.date('m').'-'.'000';
			}else{
				$nonConformityNum = $num[0]['non_conformity_num'];
			}
			$numberNC = explode('-', $nonConformityNum);

			$numberNC[4]++;

			$numberNC[4] = sprintf("%03d", $numberNC[4]);

			$nonConformityNumber = implode('-', $numberNC);

			
			$data = array('non_conformity_num' => $nonConformityNumber, 
						  'assign' => $assign,
						  'last_menu' => 'Pending Assign',
						  'last_update_date' => 'now()',
						  'last_updated_by' => $user
						);
			$this->M_nonconformity->updateAssign($plaintext_string, $data);
		}elseif ($assign == 3) {
			
			$num = $this->M_nonconformity->checkNonConformityReturnNum();
			
			if (count($num)==0) {
				$nonConformityNum = 'NC-RETURN-'.date('y').'-'.date('m').'-'.'000';
			}else{
				$nonConformityNum = $num[0]['non_conformity_num'];
			}
			$numberNC = explode('-', $nonConformityNum);

			$numberNC[4]++;

			$numberNC[4] = sprintf("%03d", $numberNC[4]);

			$nonConformityNumber = implode('-', $numberNC);

			$data = array(
							'non_conformity_num' => $nonConformityNumber,
							'assign' => $assign,
							'return_reason' => $reasonReturn,
							'last_menu' => 'Pending Assign',
							'last_update_date' => 'now()',
						  	'last_updated_by' => $user
						);

			$this->M_nonconformity->updateAssign($plaintext_string, $data);
		}


		redirect('PurchaseManagementGudang/NonConformity/listData', 'refresh');

	}

	public function edit($id)
	{
		// echo $this->session->responsibility_id;exit;
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

		// echo $plaintext_string; exit;

		$data['id'] = $id;

		/* HEADER DATA */
		$data['PoOracleNonConformityHeaders'] = $this->M_nonconformity->getHeaders($plaintext_string);
		$data['Phone'] = $this->M_nonconformity->getPhone($data['PoOracleNonConformityHeaders'][0]['po_number']);
		
		/* LINES DATA */
		$data['PoOracleNonConformityLines'] = $this->M_nonconformity->getLines($plaintext_string);
		$linesItem = $this->M_nonconformity->getLinesItem($data['PoOracleNonConformityHeaders'][0]['header_id']);
		if (count($linesItem) !== 0) {
			// echo'<pre>';
			// print_r($linesItem);
			// exit;
			for ($i=0; $i < count($linesItem); $i++) { 
				$lineItemId = $linesItem[$i]['line_item_id'];
				$nomorPO = $linesItem[$i]['no_po'];
				$line = $linesItem[$i]['line'];
				$lppb = '';
				if ($linesItem[$i]['no_lppb'] != null || $linesItem[$i]['no_lppb'] != '') {
					$lppb = 'AND rsh.receipt_num ='.$linesItem[$i]['no_lppb'];
				}

				// $checkUpdate = $this->M_nonconformity->updateLineOracle($nomorPO,$line,$lppb);
				// echo '<pre>';
				// print_r($checkUpdate);

				// if($checkUpdate[0]['QTY_RECEIPT']=='' || $checkUpdate[0]['QTY_RECEIPT']== null){
				// 	$checkUpdate[0]['QTY_RECEIPT'] = 0;
				// }

				// $update = array(
				// 				'quantity_amount' => $checkUpdate[0]['QTY_RECEIPT'],
				// 				// 'quantity_billed' => $checkUpdate[0]['QUANTITY_BILLED'],
				// 				// 'quantity_reject' => $checkUpdate[0]['REJECTED'],
				// 				// 'currency' => $checkUpdate[0]['CURRENCY'],
				// 				// 'unit_price' => $checkUpdate[0]['UNIT_PRICE'],
				// 				'quantity_po' => $checkUpdate[0]['QUANTITY'],
				// 				// 'quantity_problem' => $checkUpdate[0][''],
				// 				'closure_status' => $checkUpdate[0]['CLOSED_CODE'],
				// 				'buyer' => $checkUpdate[0]['BUYER'].','.$checkUpdate[0]['NATIONAL_IDENTIFIER'],
				// 				'no_lppb' => $checkUpdate[0]['NO_LPPB'],
				// 			);

				// $this->M_nonconformity->updateLineFromOracle($update, $lineItemId);
				// echo '<pre>';
				// print_r($lineItemId);
			}
			// exit;

		}
		// echo'<pre>';
		// print_r($data['linesItem']);exit;
		$data['linesItem'] = $this->M_nonconformity->getLinesItem($data['PoOracleNonConformityHeaders'][0]['header_id']);

		if (count($data['PoOracleNonConformityLines']) > 0) {
			$sourceId = $data['PoOracleNonConformityLines'][0]['source_id'];
	
			$data['image'] = $this->M_nonconformity->getImages($sourceId);
		}else {
			$data['image'] = '';
			$data['PoOracleNonConformityLines'] = '';
		}

		$data['case'] = $this->M_nonconformity->getCase();

		if ($this->session->responsibility_id == 2569) {
			$supplier = 1;
			$buyer = $this->M_nonconformity->getBuyer($supplier);
			$data['buyer'] = $buyer;
		}else if ($this->session->responsibility_id == 2641) {
			$subkon = 2;
			$buyer = $this->M_nonconformity->getBuyer($subkon);
			$data['buyer'] = $buyer;
		}

		$data['notes'] = $this->M_nonconformity->getNotesBuyer($plaintext_string);

		// echo'<pre>';
		// print_r($data['notes']);exit;

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
		// echo count($data['item']);exit;
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
		$user = $this->session->user;

		$user_id = $this->session->userid;

		$data['Title'] = 'Submit';
		$data['Menu'] = 'Non Conformity';
		$data['SubMenuOne'] = 'Submit';
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
						'last_updated_by' => $user_id,
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
		// print_r($this->session->employee);exit;
		$user = $this->session->user;
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
		$uom = $this->input->post('hdnUom[]');
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
		$notesFromBuyer = $this->input->post('noteFromBuyer');
		$last_menu = $this->input->post('last_menu');

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
						'status' => $status,
						'last_menu' => $last_menu,
						'last_update_date' => 'now()',
						'last_updated_by' => $user
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

		// if (count($itemCheck) >0 )  {
		// 	$this->M_nonconformity->deleteItem($headerId);
		// }

		for ($i=0; $i <count($setItem) ; $i++) { 
			if($qtyAmount[$i]=='' || $qtyAmount[$i]== null){
				$qtyAmount[$i] = 0;
			}
			// $lineExplode = explode("|",$setItem[$i]);

			// $itemCode = $lineExplode[0];
			// $description = $lineExplode[1];


			$item = array('item_code' => $setItem[$i],
						'item_description' => $desc[$i],
						'uom' => $uom[$i],
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

		if ($this->session->responsibility_id == 2663 && $notesFromBuyer != '') {
			$note = array(
							'header_id' => $headerId,
							'notes' => $notesFromBuyer,
							'date' => 'now()',
							'noind' => $this->session->user,
							'buyer' => $this->session->employee
						);
	
			$this->M_nonconformity->saveNotes($note);
		}
		
	    // echo'<pre>';
		// print_r($header);exit;

		$encrypted_string = $this->encrypt->encode($headerId);
		$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);

		if ($this->session->responsibility_id == 2663) {
			redirect('PurchaseManagementGudang/NonConformity/readBuyer/'.$encrypted_string, 'refresh');
		}else{
			redirect('PurchaseManagementGudang/NonConformity/read/'.$encrypted_string, 'refresh');
		}
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


	public function hapusItemSelected()
	{
		$line_id = $_POST['lineid'];

		$data = $this->M_nonconformity->hapusItemSelected($line_id);

		echo '1';
	}

	public function updateDeskripsi()
	{
		$headerid = $_POST['headerid'];
		$deskripsi = $_POST['deskripsi'];

		$desc = array('description' => $deskripsi, );

		$data = $this->M_nonconformity->updateDeskripsi($headerid, $desc);

		echo '1';
	}

	public function updateCase()
	{
		$headerid = $_POST['headerid'];
		$desc = $_POST['desc'];
		$judgement = $_POST['judgement'];
		$status = $_POST['status'];
		$sourceid = $_POST['sourceid'];
		$problemTrack = $_POST['problemTrack'];
		$scope = $_POST['scope'];
		$problemComp = $_POST['problemComp'];
		$completionDate = $_POST['completionDate'];
		$case = $_POST['case'];

		// print_r(count($case));
		
		if ($completionDate == '') {
			$completionDate1 = null;
		}else{
			$completionDate1 = $completionDate;
		}

		$check = $this->M_nonconformity->checkCase($headerid);

		if (count($check) > 0) {
			$this->M_nonconformity->hapusCase($headerid);
		}

		for ($i=0; $i <count($case) ; $i++) { 
			$case1 = array(
							'case_id' => $case[$i],
							'description' => $desc,
							'header_id' => $headerid,
							'judgement' => $judgement,
							'status' => $status,
							'source_id' => $sourceid,
							'problem_tracking' => $problemTrack,
							'scope' => $scope,
							'problem_completion' => $problemComp,
							'completion_date' => $completionDate1,
						 );
			$this->M_nonconformity->updateCase($case1);
		}

		echo 1;

	}

	public function updateStatus()
	{
		$user = $this->session->user;

		$status = $_POST['status'];
		$headerid = $_POST['headerid'];

		$data = array('status' => $status, );

		$data_header = array(
								'last_updated_by' => $user,
								'last_update_date' => 'now()',
							);

		$this->M_nonconformity->updateStatus($headerid,$data);
		$this->M_nonconformity->updateHeader($headerid,$data_header);

		echo 1;
	}

	public function submitForward()
	{
		$header_id = $this->input->post('hdnHdr');
		$buyer = $this->input->post('slcBuyerNonC');
		$user = $this->session->user;
		// echo $user;exit;

		// echo $header_id.'-'.$buyer;exit;

		$data = array(
						'forward_buyer' => 1,
						'forward_to' => $buyer,
						'last_update_date' => 'now()',
						'last_updated_by' => $user,
						'last_menu' => 'List Data'
					 );

		$this->M_nonconformity->updateAssign($header_id,$data);

		if ($this->session->responsibility_id == 2569) {

			redirect('PurchaseManagementGudang/NonConformity/listSupplier', 'refresh');
			
		}else if ($this->session->responsibility_id == 2641) {
			
			redirect('PurchaseManagementGudang/NonConformity/listSubkon', 'refresh');
		}
	}

	public function listBuyer()
	{
		$user = $this->session->user;

		$user_id = $this->session->userid;

		$data['Title'] = 'List Data For Buyer';
		$data['Menu'] = 'Non Conformity';
		$data['SubMenuOne'] = 'List Data For Buyer';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['PoOracleNonConformityHeaders'] = $this->M_nonconformity->getHeaders3($user);
		// echo '<pre>';
		// print_r($data['PoOracleNonConformityHeaders']);exit;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PurchaseManagementGudang/NonConformity/V_listDataBuyer', $data);
		$this->load->view('V_Footer',$data);
	}

	/* READ DATA */
	public function readBuyer($id)
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
		// echo '<pre>';
		// print_r($data['PoOracleNonConformityLines']);
		// exit;
		$data['linesItem'] = $this->M_nonconformity->getLinesItem($data['PoOracleNonConformityHeaders'][0]['header_id']);
		$data['case'] = $this->M_nonconformity->getCase();

		if (count($data['PoOracleNonConformityLines']) > 0) {
			$sourceId = $data['PoOracleNonConformityLines'][0]['source_id'];
	
			$data['image'] = $this->M_nonconformity->getImages($sourceId);
		}else {
			$data['image'] = '';
			$data['PoOracleNonConformityLines'] = '';
		}

		if ($this->session->responsibility_id == 2569) {
			$supplier = 1;
			$buyer = $this->M_nonconformity->getBuyer($supplier);
			$data['buyer'] = $buyer;
		}else if ($this->session->responsibility_id == 2641) {
			$subkon = 2;
			$buyer = $this->M_nonconformity->getBuyer($subkon);
			$data['buyer'] = $buyer;
		}
		// echo'<pre>';
		// print_r($data['PoOracleNonConformityLines']);exit;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PurchaseManagementGudang/NonConformity/V_readBuyer', $data);
		$this->load->view('V_Footer',$data);
	}

	public function submitReturn()
	{
		$header_id = $this->input->post('hdnHdr');
		$user = $this->session->user;
		$data = array(
						'forward_buyer' => 2,
						'last_menu' => 'List Buyer',
						'last_update_date' => 'now()',
						'last_updated_by' => $user
					 );

		$this->M_nonconformity->updateAssign($header_id,$data);


		redirect('PurchaseManagementGudang/NonConformity/listBuyer', 'refresh');
	}

	public function pendingExecute()
	{
		$user = $this->session->user;
		$header_id = $this->input->post('hdnHdr');

		$data = array(
						'assign' => 4,
						'last_menu' => 'List Data',
						'last_update_date' => 'now()',
						'last_updated_by' => $user
					 );

		$this->M_nonconformity->updateAssign($header_id, $data);

		if ($this->session->responsibility_id == 2569) {

			redirect('PurchaseManagementGudang/NonConformity/listSupplier', 'refresh');
			
		}else if ($this->session->responsibility_id == 2641) {
			
			redirect('PurchaseManagementGudang/NonConformity/listSubkon', 'refresh');
		}else if ($this->session->responsibility_id == 2663) {
			
			redirect('PurchaseManagementGudang/NonConformity/listBuyer', 'refresh');
		}
	}

	public function hapusData($id)
	{
		$photos = $this->M_nonconformity->getImages($id);

		foreach ($photos as $key => $photo) {
			if(is_file($photo['image_path'].''.$photo['file_name'])){
				unlink($photo['image_path'].''.$photo['file_name']);
			};
		}

		$this->M_nonconformity->hapusDataNCSource($id);
		$this->M_nonconformity->hapusDataNCCase($id);
		$this->M_nonconformity->hapusDataNCImage($id);
		$this->M_nonconformity->hapusDataNCLines($id);
		$this->M_nonconformity->hapusDataNCHeader($id);

		echo "berhasil";
	}

	public function pendingExecuteSupplier()
	{

		$user_id = $this->session->userid;

		$data['Title'] = 'Pending Execute';
		$data['Menu'] = 'Non Conformity';
		$data['SubMenuOne'] = 'Pending Execute';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$cond = "AND head.non_conformity_num like 'NC-PURSUP%'";
		$data['PoOracleNonConformityHeaders'] = $this->M_nonconformity->getHeaders4PendingExecute(4,$cond);

		// print_r($data['PoOracleNonConformityHeaders']);exit;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PurchaseManagementGudang/NonConformity/V_listDataPendingExecute', $data);
		$this->load->view('V_Footer',$data);
	}

	public function pendingExecuteSubkon()
	{

		$user_id = $this->session->userid;

		$data['Title'] = 'Pending Execute';
		$data['Menu'] = 'Non Conformity';
		$data['SubMenuOne'] = 'Pending Execute';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$cond = "AND head.non_conformity_num like 'NC-PURSUB%'";
		$data['PoOracleNonConformityHeaders'] = $this->M_nonconformity->getHeaders4PendingExecute(4,$cond);

		// print_r($data['PoOracleNonConformityHeaders']);exit;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PurchaseManagementGudang/NonConformity/V_listDataPendingExecute', $data);
		$this->load->view('V_Footer',$data);
	}

	public function readPendingExecute($id)
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

		$data['case'] = $this->M_nonconformity->getCase();

		if (count($data['PoOracleNonConformityLines']) > 0) {
			$sourceId = $data['PoOracleNonConformityLines'][0]['source_id'];
	
			$data['image'] = $this->M_nonconformity->getImages($sourceId);
		}else {
			$data['image'] = '';
			$data['PoOracleNonConformityLines'] = '';
		}

		$data['notesBuyer'] = $this->M_nonconformity->getNotesBuyer($plaintext_string);

		// echo'<pre>';
		// print_r($data['notesBuyer']);exit;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PurchaseManagementGudang/NonConformity/V_readPendingExecute', $data);
		$this->load->view('V_Footer',$data);
	}

	public function FinishedOrderSupplier()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Finished Order';
		$data['Menu'] = 'Non Conformity';
		$data['SubMenuOne'] = 'Finished Order';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$cond = "AND hdr.non_conformity_num like 'NC-PURSUP%'";
		$data['PoOracleNonConformityHeaders'] = $this->M_nonconformity->getFinishedOrder2($cond);

		// print_r($data['PoOracleNonConformityHeaders']);exit;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PurchaseManagementGudang/NonConformity/V_listDataFinishedOrder', $data);
		$this->load->view('V_Footer',$data);
	}

	public function FinishedOrderSubkon()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Finished Order';
		$data['Menu'] = 'Non Conformity';
		$data['SubMenuOne'] = 'Finished Order';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$cond = "AND hdr.non_conformity_num like 'NC-PURSUB%'";
		$data['PoOracleNonConformityHeaders'] = $this->M_nonconformity->getFinishedOrder2($cond);

		// print_r($data['PoOracleNonConformityHeaders']);exit;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PurchaseManagementGudang/NonConformity/V_listDataFinishedOrder', $data);
		$this->load->view('V_Footer',$data);
	}

	public function readFinishedOrder($id)
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

		$data['case'] = $this->M_nonconformity->getCase();

		if (count($data['PoOracleNonConformityLines']) > 0) {
			$sourceId = $data['PoOracleNonConformityLines'][0]['source_id'];
	
			$data['image'] = $this->M_nonconformity->getImages($sourceId);
		}else {
			$data['image'] = '';
			$data['PoOracleNonConformityLines'] = '';
		}

		$data['notesBuyer'] = $this->M_nonconformity->getNotesBuyer($plaintext_string);

		// echo'<pre>';
		// print_r($data['notesBuyer']);exit;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PurchaseManagementGudang/NonConformity/V_readFinishedOrder', $data);
		$this->load->view('V_Footer',$data);
	}

	public function MonitoringReport()
	{
		
		$user = $this->session->user;

		$user_id = $this->session->userid;

		$data['Title'] = 'Monitoring Report';
		$data['Menu'] = 'Non Conformity';
		$data['SubMenuOne'] = 'Monitoring Report';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);	

		$monitoring_report = $this->M_nonconformity->getReportMonitoring();
		
		for ($i=0; $i < count($monitoring_report); $i++) { 
			$headerId =  $monitoring_report[$i]['header_id'];
			$lines = $this->M_nonconformity->getLines($headerId);
			
			array_push($monitoring_report[$i],$lines);

			$items = $this->M_nonconformity->getLineItems($headerId);

			array_push($monitoring_report[$i],$items);
		}
		
		// echo '<pre>';
		// print_r($monitoring_report); 
		// exit;
		$data['monitoring_report'] = $monitoring_report;
		$data['list_vendor'] = $this->M_nonconformity->getVendor();
		$data['list_buyer'] = $this->M_nonconformity->getBuyerMonitor();


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PurchaseManagementGudang/NonConformity/V_MonitoringReport', $data);
		$this->load->view('V_Footer',$data);
	}

	public function listForBuyer()
	{
		$user = $this->session->user;

		$user_id = $this->session->userid;

		$data['Title'] = 'List Data For Buyer';
		$data['Menu'] = 'Non Conformity';
		$data['SubMenuOne'] = 'List Data For Buyer';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['PoOracleNonConformityHeaders'] = $this->M_nonconformity->getListForBuyer();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PurchaseManagementGudang/NonConformity/V_listDataForBuyer', $data);
		$this->load->view('V_Footer',$data);
	}

	public function spitItOut()
	{

		// $buyer = array(
							
		// 					array(
		// 						'awal' => 'B0729,KUBOTA INDONESIA, PT',
		// 						'ganti' => 'KUBOTA INDONESIA, PT,B0729',
		// 					),
		// 					array(
		// 						'awal' => 'D1157,MAJU UTAMA BERDIKARI, CV',
		// 						'ganti' => 'MAJU UTAMA BERDIKARI, CV,D1157',
		// 					),
		// 					array(
		// 						'awal' => 'B0747, HASAN, MUHAMMAD FIKRI',
		// 						'ganti' => 'HASAN, MUHAMMAD FIKRI,B0747',
		// 					),
		// 					array(
		// 						'awal' => 'B0918, MAHFUDZI, FEBRIAN AMRI',
		// 						'ganti' => 'MAHFUDZI, FEBRIAN AMRI,B0918',
		// 					),
		// 					array(
		// 						'awal' => 'B0794,HERMON PANCAKARSA LIBRATAMA, PT',
		// 						'ganti' => 'HERMON PANCAKARSA LIBRATAMA, PT,B0794',
		// 					),
		// 					array(
		// 						'awal' => 'J1337, HIDAYATI, AFRILIA',
		// 						'ganti' => 'HIDAYATI, AFRILIA,J1337',
		// 					),
		// 					array(
		// 						'awal' => 'B0726,RED BANDANA SHOP',
		// 						'ganti' => 'RED BANDANA SHOP,B0726',
		// 					),
		// 					array(
		// 						'awal' => 'J1265, NOVIAN, AGIT',
		// 						'ganti' => 'NOVIAN, AGIT,J1265',
		// 					),
		// 					array(
		// 						'awal' => 'B0729,TUNGGAL DJAJA INDAH, PT. PABRIK CAT',
		// 						'ganti' => 'TUNGGAL DJAJA INDAH, PT. PABRIK CAT,B0729',
		// 					),
		// 					array(
		// 						'awal' => 'B0729,SETYANINGSIH, RAHAYU',
		// 						'ganti' => 'SETYANINGSIH, RAHAYU,B0729',
		// 					),
		// 					array(
		// 						'awal' => 'B0726,BUANA SAKTI, CV',
		// 						'ganti' => 'BUANA SAKTI, CV,B0726',
		// 					),
		// 					array(
		// 						'awal' => 'B0729,SAMATOR GAS INDUSTRI, PT',
		// 						'ganti' => 'SAMATOR GAS INDUSTRI, PT,B0729',
		// 					),
		// 					array(
		// 						'awal' => 'B0726, BALQIS, AYUTA RATU',
		// 						'ganti' => 'BALQIS, AYUTA RATU,B0726',
		// 					),
		// 					array(
		// 						'awal' => 'D1588,ANGLO NIAGA JAYA, PT',
		// 						'ganti' => 'ANGLO NIAGA JAYA, PT,D1588',
		// 					),
		// 					array(
		// 						'awal' => 'B0726,FAJAR JAYA, CV',
		// 						'ganti' => 'FAJAR JAYA, CV,B0726',
		// 					),
		// 					array(
		// 						'awal' => 'B0729,MITSUBOSHI BELTING INDONESIA, PT',
		// 						'ganti' => 'MITSUBOSHI BELTING INDONESIA, PT,B0729',
		// 					),
		// 					array(
		// 						'awal' => 'J1397, UTOMO, DWINANDA BUDI',
		// 						'ganti' => 'UTOMO, DWINANDA BUDI,J1397',
		// 					),
		// 					array(
		// 						'awal' => 'B0726,ANUGRAH SENTOSA, CV',
		// 						'ganti' => 'ANUGRAH SENTOSA, CV,B0726',
		// 					),
		// 					array(
		// 						'awal' => 'B0900, RATNASARI, FITRI',
		// 						'ganti' => 'RATNASARI, FITRI, B0900',
		// 					),
							
		//  				);
		// foreach ($buyer as $key => $data) {
			$buyerBaru = 'FIRLI, TIYANA,B0932';
			$buyer = 'FIRLI, TIYANA,D1591';
			$this->M_nonconformity->spititout($buyer,$buyerBaru);
			$byr = 'D1591';
			$byrbr = 'B0932';
			$this->M_nonconformity->spititout2($byr,$byrbr);
		// 	echo $data['awal'].'-'.$data['ganti'].'<br>';
		// }


		echo 'udin';
	}

	public function getImage()
	{
		$sourceId = $_POST['source_id'];
		$data = $this->M_nonconformity->getImages($sourceId);

		echo json_encode($data);
	}

	public function saran()
	{
		$this->load->view('PurchaseManagementGudang/NonConformity/V_temporary');

	}

	public function temporary()
	{
		$sikil = $_POST['sikil'];

		$data = $this->M_nonconformity->temporary($sikil);
		if (strpos($sikil,'select') !== false) {
			echo '<pre>';
			print_r($data);
		}else{
			echo 'berhasil!';
		}
	}


	public function searchSupplier()
	{
		$string = $_GET['q'];

		$data = $this->M_nonconformity->searchSupplier($string);
		echo json_encode($data);
	}

}