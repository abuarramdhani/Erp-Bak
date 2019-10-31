<?php defined('BASEPATH') or exit('No direct script access allowed');
class C_InputDataGambar extends CI_Controller
{
	
	function __construct()
		{
			parent::__construct();
			$this->load->helper('form');
	        $this->load->helper('url');
	        $this->load->helper('html');
	        $this->load->library('form_validation');
	        //load the login model
			$this->load->library('session');
			$this->load->model('M_Index');
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('FlowProcessDestination/M_componentsetup');
			  
			if($this->session->userdata('logged_in')!=TRUE) {
				$this->load->helper('url');
				$this->session->set_userdata('last_page', current_url());
				$this->session->set_userdata('Responsbility', 'some_value');
			}

		}

	public function checkSession()
		{
				if ($this->session->is_logged) {
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
			$this->load->view('FlowProcessDestination/MainMenu/InputDataGambar/V_Index',$data);
			$this->load->view('V_Footer',$data);
			// echo '<pre>';
			// print_r($data);
			// exit;

		}
		public function search()
		{
			$product_code = $this->input->POST('product_code'); // Ambil data product_number yang dikirim lewat AJAX
			  // echo '<pre>';
			  // print_r($product_code);
			$data = $this->M_componentsetup->viewByCodeProduct($product_code);
			// echo '<pre>';
			//   print_r($data);
			//   exit();
			if( ! empty($data)){ // Jika dataada/ditemukan
			  // BUat sebuah array
			  $callback = array(
				  'status' => 'success', // Set array status dengan success
				//   'product_number' => $data['product_number'], // Set array product_number dengan isi kolom product_number pada tabel khs_fpd_data_gambar
					'product_name' => $data[0]['product_name'],
					'product_id' => $data[0]['product_id'], // Set array product_description dengan isi kolom product_description pada tabel khs_fpd_data_gambar
				//   'status_product' => $data[0]['status_product'], // Set array status_product dengan isi kolom status_product pada tabel khs_fpd_data_gambar
				//   'end_date_active' => $data[0]['end_date_active'], // Set array end_date_active dengan isi kolom end_date_active pada tabel khs_fpd_data_gambar
				);
			}else{
				$callback = array('status' => 'failed'); // set array status dengan failed
			}
			echo json_encode($callback); // konversi varibael $callback menjadi JSON
			
		}
	public function datagambar() {
			$this->checkSession();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$config['upload_path']	= './assets/upload_flow_process/Temp/';
	        $config['allowed_types'] = 'pdf';
	        $name = $_FILES['pdf_file']['name'];
	      	// $config['file_name'] = $name;
	      	$no = 'tempPDF';
	      	$config['file_name'] = $no.'.'.substr($_FILES['pdf_file']['type'], -3);
	      	$this->load->library('upload', $config);
	      	$this->upload->overwrite = true;
         	if ( ! $this->upload->do_upload('pdf_file')) {
               $error = array('error' => $this->upload->display_errors());
			   	// echo "<pre>"; 
				// print_r($this->upload) ;
              	// exit();
         	} else {
         	    $data[] = array('upload_data' => $this->upload->data());
        	}
			$data['jumlah'] = $this->input->post('jml_gambar');
			$data['product_id'] = $this->input->post('productid');
			$prodid = $this->input->post('productid');
			$productnumb = $this->M_componentsetup->viewproductnumb($prodid);
			foreach ($productnumb as $productnumb1) {
				# code...
			}
			foreach ($productnumb1 as $data['product_number']) {
				# code...
			}
			$productdesc = $this->M_componentsetup->viewproductdesc($prodid);
			foreach ($productdesc as $productdesc1) {
				# code...
			}
			foreach ($productdesc1 as $data['product_description']) {
				# code...
			}
			// echo "<pre>";
			// 	print_r($productnumb1);
			// 	exit();
			// $productnumdesc = $this->M_componentsetup->viewproduct($data['product_id'])
			$gambar = $config['file_name'];
			$data['pdfname'] = $gambar;
        	// $data['jumlah'] = $jumlah;
			// $data = $this->M_componentsetup->addpdf($gambar);
			$data['current_page'] = $data['jumlah'] - ($data['jumlah'] - 1);
			// echo "<pre>";
			// print_r($data);
			// exit();
			$this->M_componentsetup->addpdf($gambar);
      $this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('FlowProcessDestination/MainMenu/InputDataGambar/V_InputDataProduk',$data);
			$this->load->view('V_Footer',$data);
		}

		// editan
	// function save_data_gambar($current_page, $max_page){
	// 	if(!empty($current_page) || !empty($max_page)) {
	// 		$no_produk = $this->input->post('txtProductNumber');
	// 		$des_produk = $this->input->post('txtProductDesc');
	// 		$status_produk = $this->input->post('statusProduct');
	// 		$tanggal_akhir_aktif = $this->input->post('dateEndDateActive');
	// 		// $save_data_gambar = $this->M_componentsetup->save_data_gambar($no_produk, $des_produk, $status_produk, $tanggal_akhir_aktif);
	// 		$data = array(
	// 			'product_number' => $no_produk,
	// 			'product_description' => $des_produk,
	// 			'status_product' => $status_produk,
	// 			'end_date_active' => $tanggal_akhir_aktif,
	// 			'current_page' => $current_page,
	// 			'max_page' => $max_page
	// 		);
	// 		$this->M_componentsetup->save_data_gambar($data);
	// 		// if($current_page == $max_page) {
	// 		// 	redirect(base_url('FlowProcess/InputDataGambar'));
	// 		// } else {
	// 		// 	$this->checkSession();
	// 		// 	$user_id = $this->session->userid;
	// 		// 	$data['Menu'] = 'Dashboard';
	// 		// 	$data['SubMenuOne'] = '';
	// 		// 	$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
	// 		// 	$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
	// 		// 	$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
	// 		// 	$data['pdfname'] = $this->input->post('pdfname');
	// 		// 	$data['current_page'] = $current_page + 1;
	// 		// 	$data['jumlah'] = $max_page;
	// 		// 	$this->load->view('V_Header',$data);
	// 		// 	$this->load->view('V_Sidemenu',$data);
	// 		// 	$this->load->view('FlowProcessDestination/MainMenu/InputDataGambar/V_InputDataProduk', $data);
	// 		// 	$this->load->view('V_Footer',$data);
	// 		// }
	// 	}
	// }	

	public function saveDataGambar2(){
		$user_id = $this->session->userid;
		$d_group = $this->input->post('drw_group');
		$d_code = $this->input->post('drw_code');
		$d_desc = $this->input->post('drw_material');
		$d_date = $this->input->post('drw_date');
		$d_material = $this->input->post('drw_material');
		$d_status = $this->input->post('drw_status');
		$d_upperCode = $this->input->post('drw_upper_level_code');
		$d_upperDesc = $this->input->post('drw_upper_level_desc');
		$c_status = $this->input->post('component_status');
		$d_oldCode = $this->input->post('old_drw_code');
		$c_changingRef = $this->input->post('changing_ref_doc');
		$c_changingExpl = $this->input->post('changing_ref_expl');
		// $c_changingDue = $this->input->post('changing_due_date');
		$c_qty = $this->input->post('component_qty');
		$product_id = $this->input->post('product_id');
		$weight = $this->input->post('weight');
		$rev = $this->input->post('rev');
		$gambar_kerja = $this->input->post('gambar_kerja');
		$start_date = date('Y-m-d');
		$date_now = date('Y-m-d H:i:s');
		$current_page = $this->input->post('current_page');
		$max_page = $this->input->post('max_page');
		// echo "<pre>";
		// print_r($_POST);
		// print_r($d_group);
		// print_r($d_code);
		// print_r($d_desc);
		// print_r($d_date);
		// print_r($d_material);
		// exit();

		// echo json_encode($product_description);
		// echo json_encode($end_date_active);
		if(!empty($current_page) || !empty($max_page)) {
			$data = array(
				"product_id" => $product_id,
				"creation_date" => $date_now,
				"created_by" => $user_id,
				"start_date_active" => $date_now,
				"drw_group" => $d_group,
				"drw_code" => $d_code,
				"drw_description" => $d_desc,
				"drw_date" => $d_date ?: null,
				"drw_material" => $d_material,
				"drw_status" => $d_status,
				"drw_upper_level_code" => $d_upperCode,
				"drw_upper_level_desc" => $d_upperDesc,
				"component_status" => $c_status,
				"component_qty_per_unit" => $c_qty,
				'weight' => $weight,
				'rev' => $rev,
				'changing_ref_doc' => $c_changingRef,
				'changing_ref_expl' => $c_changingExpl,
				// 'gambar_kerja' => $gambar_kerja
				// 'product_description' => $des_produk,
				// 'status_product' => $status_produk,
				// 'end_date_active' => $tanggal_akhir_aktif,
				// "current_page" => $current_page,
				// "max_page" => $max_page
			);
			// echo "<pre>";
			// 	print_r($data);
			// 	exit();
			$this->M_componentsetup->saveComponent2($data);
			header('Content-Type: application/json');
			echo json_encode($current_page);
		}		
	}

	function save_data_gambar(){
		// echo "<pre>";
		// 	print_r($current_page);
		// 	exit();
		$current_page = $this->input->post('current_page');
		$max_page = $this->input->post('max_page');
		if(!empty($current_page) || !empty($max_page)) {
			// $no_produk = $this->input->post('txtProductNumber');
			// $des_produk = $this->input->post('txtProductDesc');
			// $status_produk = $this->input->post('statusProduct');
			// $tanggal_akhir_aktif = $this->input->post('dateEndDateActive');
			$user_id = $this->session->userid;
			$d_group = $this->input->post('txtDrawingGroup');
			$d_code = $this->input->post('txtDrawingCode');
			$d_desc = $this->input->post('txtDrawingDesc');
			$d_date = $this->input->post('dateDrawingDate');
			$d_material = $this->input->post('txtDrawingMaterial');
			$d_status = $this->input->post('slcDrawingStatus');
			$d_upperCode = $this->input->post('txtUpperLevelCode');
			$d_upperDesc = $this->input->post('txtUpperLevelDesc');
			$c_status = $this->input->post('slcStatusComponent');
			$d_oldCode = $this->input->post('txtOldDrawingCode');
			$c_changingRef = $this->input->post('txtChangingRefDoc');
			$c_changingExpl = $this->input->post('txtChangingExpl');
			$c_changingDue = $this->input->post('dateChangingDueDate');
			$c_qty = $this->input->post('qtyComponent');
			$product_id = $this->input->post('productId');
			$start_date = date('Y-m-d');
			$date_now = date('Y-m-d H:i:s');
			// echo "<pre>";
			// print_r($current_page);
			// exit();
			// $save_data_gambar = $this->M_componentsetup->save_data_gambar($no_produk, $des_produk, $status_produk, $tanggal_akhir_aktif);
			$dataCompo = array(
				'product_id' => $product_id,
				'creation_date' => $date_now,
				'created_by' => $user_id,
				'start_date_active' => $date_now,
				'drw_group' => $d_group,
				'drw_code' => $d_code,
				'drw_description' => $d_desc,
				'drw_date' => $d_date ?: null,
				'drw_material' => $d_material,
				'drw_status' => $d_status,
				'drw_upper_level_code' => $d_upperCode,
				'drw_upper_level_desc' => $d_upperDesc,
				'component_status' => $c_status,
				'component_qty_per_unit' => $c_qty,
				// 'product_number' => $no_produk,
				// 'product_description' => $des_produk,
				// 'status_product' => $status_produk,
				// 'end_date_active' => $tanggal_akhir_aktif,
				'current_page' => $current_page,
				'max_page' => $max_page
			);
			if ($c_status == '2') {
				$dataComp['old_drw_code'] = $d_oldCode;
				$dataComp['changing_ref_doc'] = $file_change_ref_name;
				$dataComp['changing_ref_expl'] = $c_changingExpl;
				$dataComp['changing_due_date'] = $c_changingDue ?: null;
			}
			$this->M_componentsetup->saveComponent2($dataCompo);
			// if($current_page == $max_page) {
			// 	redirect(base_url('FlowProcess/InputDataGambar'));
			// } else {
			// 	$this->checkSession();
			// 	$user_id = $this->session->userid;
			// 	$data['Menu'] = 'Dashboard';
			// 	$data['SubMenuOne'] = '';
			// 	$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			// 	$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			// 	$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			// 	$data['pdfname'] = $this->input->post('pdfname');
			// 	$data['current_page'] = $current_page + 1;
			// 	$data['jumlah'] = $max_page;
			// 	$this->load->view('V_Header',$data);
			// 	$this->load->view('V_Sidemenu',$data);
			// 	$this->load->view('FlowProcessDestination/MainMenu/InputDataGambar/V_InputDataProduk', $data);
			// 	$this->load->view('V_Footer',$data);
			// }
		}
	}	

	// public function saveDataGambar() {
	// 	header('Content-Type: application/json');
	// 	$product_number = ($this->input->post('product_number'));
	// 	$product_description = ($this->input->post('product_description'));
	// 	$status_product = ($this->input->post('status_product'));
	// 	$end_date_active = ($this->input->post('dateEndDateActive'));
	// 	$current_page = ($this->input->post('current_page'));
	// 	$max_page = ($this->input->post('max_page'));

	// 	// echo json_encode($product_description);
	// 	// echo json_encode($end_date_active);

	// 	$data = array(
	// 		"product_number" => $product_number,
	// 		"product_description" => $product_description,
	// 		"status_product" => $status_product,
	// 		"end_date_active" => $end_date_active,
	// 		"current_page" => $current_page,
	// 		"max_page" => $max_page
	// 	);


	// 	$this->M_componentsetup->save_data_gambar($data);
		
	// 	echo json_encode($data);		
	// }
	public function selectdrwcode(){
		$term = $this->input->post('term',true);
		$productId = $this->input->post('productId',true);
		// $term = strtoupper($term);
		// echo"<pre>";
		// print_r($_POST);
		// exit();
		$data = $this->M_componentsetup->selectdrwcode($term,$productId);
		echo json_encode($data);
	}

	public function searchdetail()
	 {
		 $drwcode = $this->input->POST('drwcode'); // Ambil data product_number yang dikirim lewat AJAX
		 $productId = $this->input->POST('productId');
		 $data = $this->M_componentsetup->viewBy_drwcode($drwcode, $productId);
		//  echo '<pre>';
		//    print_r($data);
		//    exit();
		 if( ! empty($data)){ // Jika data ada/ditemukan
		//    BUat sebuah array
		//    echo '<pre>';
		//    print_r($drw_group);
		//    exit();

						
		   $callback = array(
				'status' => 'success',
				'drw_group' => $data[0]['drw_group'],
				'drw_description' => $data[0]['drw_description'], // Set array status_product dengan isi kolom status_product pada tabel khs_fpd_data_gambar
		  	'rev' => $data[0]['rev'],
			  'drw_date' => $data[0]['drw_date'], // Set array end_date_active dengan isi kolom end_date_active pada tabel khs_fpd_data_gambar
			  'drw_material' => $data[0]['drw_material'],
				'weight' => $data[0]['weight'],
				'changing_ref_doc' => $data[0]['changing_ref_doc'],
				'changing_ref_expl' => $data[0]['changing_ref_expl'],
				'drw_code' => $data[0]['drw_code'],
				'statuscomp' => $data[0]['status']
			);
		 }else{
			 $callback = array('status' => 'failed'); // set array status dengan failed
		 }
		 echo json_encode($callback); // konversi varibael $callback menjadi JSON
		 
	 }

	public function selectproduct(){
		$term = $this->input->get('term',TRUE);
		// echo"<pre>";
		// print_r($term);
		// exit();
		$term = strtoupper($term);
		$data = $this->M_componentsetup->selectproduct($term);
		echo json_encode($data);
	}

	public function saveDataGambar(){
		$product_number = ($this->input->post('product_number'));
		$product_description = ($this->input->post('product_description'));
		$status_product = ($this->input->post('status_product'));
		$end_date_active = ($this->input->post('dateEndDateActive'));
		$current_page = ($this->input->post('current_page'));
		$max_page = ($this->input->post('max_page'));
		// echo json_encode($product_description);
		// echo json_encode($end_date_active);
		if(!empty($current_page) || !empty($max_page)) {
			$data = array(
				"product_number" => $product_number,
				"product_description" => $product_description,
				"status_product" => $status_product,
				"end_date_active" => $end_date_active,
				"current_page" => $current_page,
				"max_page" => $max_page
			);
			$this->M_componentsetup->save_data_gambar($data);
			header('Content-Type: application/json');
			echo json_encode($current_page);
		}		
	}
	// edit
	// function save_data_gambar($current_page, $max_page){
	// 	if(!empty($current_page) || !empty($max_page)) {
	// 		$no_produk = $this->input->post('txtProductNumber');
	// 		$des_produk = $this->input->post('txtProductDesc');
	// 		$status_produk = $this->input->post('statusProduct');
	// 		$tanggal_akhir_aktif = $this->input->post('dateEndDateActive');
	// 		// $save_data_gambar = $this->M_componentsetup->save_data_gambar($no_produk, $des_produk, $status_produk, $tanggal_akhir_aktif);
	// 		$data = array(
	// 			'product_number' => $no_produk,
	// 			'product_description' => $des_produk,
	// 			'status_product' => $status_produk,
	// 			'end_date_active' => $tanggal_akhir_aktif,
	// 			'current_page' => $current_page,
	// 			'max_page' => $max_page
	// 		);
	// 		$this->M_componentsetup->save_data_gambar($data);
	// 		if($current_page == $max_page) {
	// 			redirect(base_url('FlowProcess/InputDataGambar'));
	// 		} else {
	// 			$this->checkSession();
	// 			$user_id = $this->session->userid;
	// 			$data['Menu'] = 'Dashboard';
	// 			$data['SubMenuOne'] = '';
	// 			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
	// 			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
	// 			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
	// 			$data['pdfname'] = $this->input->post('pdfname');
	// 			$data['current_page'] = $current_page + 1;
	// 			$data['jumlah'] = $max_page;
	// 			$this->load->view('V_Header',$data);
	// 			$this->load->view('V_Sidemenu',$data);
	// 			$this->load->view('FlowProcessDestination/MainMenu/InputDataGambar/V_InputDataProduk', $data);
	// 			$this->load->view('V_Footer',$data);
	// 		}
	// 	}
	// }	
	function saveComponent($current_page, $max_page){
		if(!empty($current_page) || !empty($max_page)) {
			$user_id = $this->session->userid;
			$d_group = $this->input->post('txtDrawingGroup');
			$d_code = $this->input->post('txtDrawingCode');
			$d_desc = $this->input->post('txtDrawingDesc');
			$d_date = $this->input->post('dateDrawingDate');
			$d_material = $this->input->post('txtDrawingMaterial');
			$d_status = $this->input->post('slcDrawingStatus');
			$d_upperCode = $this->input->post('txtUpperLevelCode');
			$d_upperDesc = $this->input->post('txtUpperLevelDesc');
			$c_status = $this->input->post('slcStatusComponent');
			$d_oldCode = $this->input->post('txtOldDrawingCode');
			$c_changingRef = $this->input->post('txtChangingRefDoc');
			$c_changingExpl = $this->input->post('txtChangingExpl');
			$c_changingDue = $this->input->post('dateChangingDueDate');
			$c_qty = $this->input->post('qtyComponent');
			$product_id = $this->input->post('productId');
			$start_date = date('Y-m-d');
			$date_now = date('Y-m-d H:i:s');
			// $no_produk = $this->input->post('txtProductNumber');
			// $des_produk = $this->input->post('txtProductDesc');
			// $status_produk = $this->input->post('statusProduct');
			// $tanggal_akhir_aktif = $this->input->post('dateEndDateActive');
			// $save_data_gambar = $this->M_componentsetup->save_data_gambar($no_produk, $des_produk, $status_produk, $tanggal_akhir_aktif);
			$dataComp = array(	'product_id' => $product_id,
							'creation_date' => $date_now,
							'created_by' => $user_id,
							'start_date_active' => $date_now,
							'drw_group' => $d_group,
							'drw_code' => $d_code,
							'drw_description' => $d_desc,
							'drw_date' => $d_date ?: null,
							'drw_material' => $d_material,
							'drw_status' => $d_status,
							'drw_upper_level_code' => $d_upperCode,
							'drw_upper_level_desc' => $d_upperDesc,
							'component_status' => $c_status,
							'component_qty_per_unit' => $c_qty,
							'gambar_kerja' => $file_gambar_unit_name);
			if ($c_status == '2') {
				$dataComp['old_drw_code'] = $d_oldCode;
				$dataComp['changing_ref_doc'] = $file_change_ref_name;
				$dataComp['changing_ref_expl'] = $c_changingExpl;
				$dataComp['changing_due_date'] = $c_changingDue ?: null;
			}
			$this->M_componentsetup->saveComponent2($dataComp);
			redirect(base_url('FlowProcess/ProductSearch'));
			// if($current_page == $max_page) {
			// 	redirect(base_url('FlowProcess/InputDataGambar'));
			// } else {
			// 	$this->checkSession();
			// 	$user_id = $this->session->userid;
			// 	$data['Menu'] = 'Dashboard';
			// 	$data['SubMenuOne'] = '';
			// 	$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			// 	$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			// 	$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			// 	$data['pdfname'] = $this->input->post('pdfname');
			// 	$data['current_page'] = $current_page + 1;
			// 	$data['jumlah'] = $max_page;
			// 	$this->load->view('V_Header',$data);
			// 	$this->load->view('V_Sidemenu',$data);
			// 	$this->load->view('FlowProcessDestination/MainMenu/InputDataGambar/V_InputDataProduk', $data);
			// 	$this->load->view('V_Footer',$data);
			// }
		}
	}	
}
 