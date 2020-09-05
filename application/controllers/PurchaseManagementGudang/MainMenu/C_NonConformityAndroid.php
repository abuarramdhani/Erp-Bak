<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_NonConformityAndroid extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('ciqrcode');
		$this->load->library('encrypt');
		$this->load->library('upload');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PurchaseManagementGudang/MainMenu/M_nonconformity');

		// $this->checkSession();
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
							'error' 			=> false,
							'userid' 			=> $iduser,
							'user' 				=> strtoupper($username),
							'employee'  		=> $employee_name,
							'kodesie' 			=> $kodesie,
							'kode_lokasi_kerja'	=> $kode_lokasi_kerja,
						);
			// $this->session->set_userdata($ses);
			
			// redirect($this->session->userdata('last_page'));
			
			
			//redirect('');
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
        	$data['result'] = $case;
		}else {
			$data['status'] = false;
    		$data['result'] = "Data not Found";
		}

		print_r(json_encode($data));
	}

	public function submitSourceAndroid()
	{
		$user_id = preg_replace("/[^A-Za-z0-9 ]/", '',$_POST['userid']);

		// $photo = $this->input->post('photo[]');
		// $remark = $this->input->post('remark[]');
		// $description = $this->input->post('txtDescription');
		$photo = $_FILES['file'];
		$description = preg_replace("/[^A-Za-z0-9 ]/", '', $_POST['desc']);
		$remark = $_POST['tag'];
		
		// echo'<pre>';
		// print_r($photo);exit;
        
        // $response['error'] = false;
        // $response['message'] =  count($remark);
        // echo json_encode($response);
        // exit;
        // echo '<pre>';

		$source = array(
						'info' => $description,
						'created_by' => $user_id,
						'creation_date' => 'now()',
						'last_update_by' => $user_id,
						'last_update_date' => 'now()',
                    );
                    
        // print_r($source);exit;

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
						'created_by' => $user_id,
						'creation_date' => 'now()',
						'last_update_by' => $user_id,
						'last_update_date' => 'now()',

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
					$replaceFileName = str_replace(' ','_',$_FILES['file']['name'][$j]);
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
        echo json_encode($response);
	}

	public function listRevision()
	{
		$assign = 3;
		$list = $this->M_nonconformity->getHeaders2($assign);

		if (count($list) > 0) {
			$data['status'] = true;
        	$data['result'] = $list;
		}else {
			$data['status'] = false;
    		$data['result'] = "Data not Found";
		}

		print_r(json_encode($data));
	}

	public function listExecute()
	{
		$assign = 4;
		$list = $this->M_nonconformity->getHeaders4($assign);

		if (count($list) > 0) {
			$data['status'] = true;
        	$data['result'] = $list;
		}else {
			$data['status'] = false;
    		$data['result'] = "Data not Found";
		}

		print_r(json_encode($data));
	}

	public function listFinish()
	{
		$list = $this->M_nonconformity->getFinishedOrder();
		if (count($list) > 0) {
			$data['status'] = true;
        	$data['result'] = $list;
		}else {
			$data['status'] = false;
    		$data['result'] = "Data not Found";
		}

		print_r(json_encode($data));
	}

	public function read($id)
	{
		$data['PoOracleNonConformityHeaders'] = $this->M_nonconformity->getHeaders($id);
		$data['Phone'] = $this->M_nonconformity->getPhone($data['PoOracleNonConformityHeaders'][0]['po_number']);
		
		/* LINES DATA */
		$data['PoOracleNonConformityLines'] = $this->M_nonconformity->getLines($id);
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

		// echo '<pre>';
		// print_r($data);
		// exit;

		print_r(json_encode($data));
	}

	public function deleteGambar()
	{
		$gambar = $_POST['gambar_id'];
		$file = $this->M_nonconformity->searchGambar($gambar);
		if(is_file($file[0]['image_path'].''.$file[0]['file_name'])){
			unlink($file[0]['image_path'].''.$file[0]['file_name']);
		};
		$this->M_nonconformity->deleteGambar($gambar);

		$data="1";
		echo $data;

	}

	public function update()
	{
		$header_id = preg_replace("/[^A-Za-z0-9 ]/", '',$_POST['header_id']);
		$source_id = preg_replace("/[^A-Za-z0-9 ]/", '',$_POST['source_id']);
		$user_id = preg_replace("/[^A-Za-z0-9 ]/", '',$_POST['userid']);

		// $photo = $_FILES['file'];
		$description = preg_replace("/[^A-Za-z0-9 ]/", '', $_POST['desc']);
		$remark = $_POST['tag'];
		
		// echo'<pre>';
		// print_r($photo);exit;

		// echo count($photo);exit;
        

		$source = array(
						'info' => $description,
						'created_by' => $user_id,
						'creation_date' => 'now()',
						'last_update_by' => $user_id,
						'last_update_date' => 'now()',
                    );
                    
        // print_r($source);exit;

		$this->M_nonconformity->updateSource($source_id, $source);
		// exit;
		// $sourceId = $this->M_nonconformity->saveSource($source);

		$num = $this->M_nonconformity->checkNonConformityNum();
		// print_r($num);exit;

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
						'assign' => null
					 );
					//  print_r($header);
					 $this->M_nonconformity->updateHeader($header_id, $header);
					//  exit;
		// $headerId = $this->M_nonconformity->simpanHeader($header);
		if (isset($_FILES['file'])) {
			//////////////////////UPLOAD PHOTO////////////
			$path = ('192.168.168.127/assets/upload/NonConformity/');
			for($j=0;$j<count($_FILES['file']['tmp_name']);$j++){
				// echo '<pre>';
				// echo $_FILES['file']['tmp_name'][$j];
				$response['error'] = false;
				$response['message'] =  "number of files recieved is = ".count($_FILES['file']['name']);
				// print_r($response)
				// echo $path.$_FILES['file']['name'][$j];
				if(move_uploaded_file($_FILES['file']['tmp_name'][$j],$path.$_FILES['file']['name'][$j])){
					  	$response['error'] = false;
						$response['message'] =  $response['message']. "moved sucessfully ::  ";
	
						$inputFileName 	= '192.168.168.127/assets/upload/NonConformity/'.$_FILES['file']['name'][$j];
					
						if(is_file($inputFileName))
						{
						// echo('ada');
							chmod($inputFileName, 0777); ## this should change the permissions
						}else {
						// echo('nothing');
						}
						$replaceFileName = str_replace(' ','_',$_FILES['file']['name'][$j]);
						$upload = array (
							'source_id' => $source_id,
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
		}else{
			$response['error'] = false;
			$response['message'] = "Ok";
		}
		
		$this->M_nonconformity->deleteCase($source_id);
		$this->M_nonconformity->deleteLine($header_id);

        //////////////////CASE///////////////////
		for ($i=0; $i < count($remark); $i++) { 
            
            $case = array(
						'source_id' => $source_id,
						'case_id' => $remark[$i],
					);

                    $this->M_nonconformity->saveCase($case);

			//////////////////////LINES//////////////////////////////
			$lines = array(
						'case_id' => $remark[$i],
						'header_id' => $header_id,
						'description' => $description,
						'source_id' => $source_id,
					);
                    $this->M_nonconformity->saveLine($lines);
                    
                    // print_r($lines);exit;
		}
        
		// redirect('PurchaseManagementGudang/NonConformity', 'refresh');
		
        echo json_encode($response);
	}

	public function updateStatus()
	{
		$headerid = $_POST['header_id'];
		$status = array('status' => 1,);

		$this->M_nonconformity->updateStatus($headerid, $status);

		$response['error'] = false;
		$response['message'] = "Ok";
		echo json_encode($response);
	}
}