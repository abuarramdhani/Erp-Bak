<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Standarisasi extends CI_Controller
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
		$this->load->library('Excel');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('StandarisasiItemPembelian/M_standarisasi');
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

	public function UpdateData()
	{
        $this->checkSession();
		$user = $this->session->username;
		
		$user_id = $this->session->userid;

		$data['Menu'] = 'Update Data Item';
		$data['SubMenuOne'] = 'Standarisasi';

		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['ListData'] = $this->M_standarisasi->Listdata();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('StandarisasiItemPembelian/Standarisasi/V_UpdateData');
		
		$this->load->view('V_Footer',$data);
	}

	public function ListData()
	{
        $this->checkSession();
        $user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Menu'] = 'List Standarisasi Item';
		$data['SubMenuOne'] = 'Standarisasi';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['ListData'] = $this->M_standarisasi->Listdata();


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('StandarisasiItemPembelian/Standarisasi/V_ListData',$data);
		$this->load->view('V_Footer',$data);
	}

	public function searchItem()
	{
		$string = $_GET['q'];
		$data = $this->M_standarisasi->getItem(strtoupper($string));
		echo json_encode($data);
	}

	public function saveData()
	{
		$noind = $this->session->user;
		$user = $this->M_standarisasi->getPersonId($noind);
		$itemCode = $this->input->post('slcItemSIP');
		$spesifikasi = $this->input->post('spesifikasiSIP');
		$model = $this->input->post('modelSIP');
		$merk = $this->input->post('merkSIP');
		$origin = $this->input->post('originSIP');
		$madeIn = $this->input->post('madeinSIP');
		$supplierItem = $this->input->post('suppItemSIP');
		$catatan = $this->input->post('catatanSIP');
		$cutOff = $this->input->post('cutOffSIP');
		$pembayaran = $this->input->post('pembayaranSIP');
		$kelompokBarang = $this->input->post('kelompokBarangSIP');
		$jenisKonf = $this->input->post('jenisKonfSIP');
		$katalog = $this->input->post('katalogSIP');
		$levelValiditas = $this->input->post('levelValiditasSIP');
		$importLokal = $this->input->post('importLokalSIP');

		$data = array(
						'INVENTORY_ITEM_ID' => $itemCode,
						'DESKRIPSI_SPESIFIKASI' => $spesifikasi,
						'MODEL' => $model,
						'MERK' => $merk,
						'ORIGIN' => $origin,
						'MADE_IN' => $madeIn,
						'SUPPLIER_ITEM' => $supplierItem,
						'CATATAN' => $catatan,
						'LAST_UPDATE_BY' => $user[0]['PERSON_ID'],
						'CUT_OFF_PEMBELIAN' => $cutOff,
						'PEMBAYARAN' => $pembayaran,
						'KELOMPOK_BARANG' => $kelompokBarang,
						'JENIS_KONFIRMASI' => $jenisKonf,
						'KATALOG' => $katalog,
						'LEVEL_VALIDITAS' => $levelValiditas,
						'IMPORT_LOCAL' => $importLokal,
					);

		$this->M_standarisasi->saveData($data);

		redirect('StandarisasiItemPembelian/Standarisasi/ListData','refresh');
	}

	public function saveDataImport()
	{
		$noind = $this->session->user;
		$user = $this->M_standarisasi->getPersonId($noind);
		$itemCode = $this->input->post('slcItemSIP[]');
		$spesifikasi = $this->input->post('spesifikasiSIP[]');
		$model = $this->input->post('modelSIP[]');
		$merk = $this->input->post('merkSIP[]');
		$origin = $this->input->post('originSIP[]');
		$madeIn = $this->input->post('madeinSIP[]');
		$supplierItem = $this->input->post('suppItemSIP[]');
		$catatan = $this->input->post('catatanSIP[]');
		$cutOff = $this->input->post('cutOffSIP[]');
		$pembayaran = $this->input->post('pembayaranSIP[]');
		$kelompokBarang = $this->input->post('kelompokBarangSIP[]');
		$jenisKonf = $this->input->post('jenisKonfSIP[]');
		$katalog = $this->input->post('katalogSIP[]');
		$levelValiditas = $this->input->post('levelValiditasSIP[]');
		$importLokal = $this->input->post('importLokalSIP[]');

		// echo count($itemCode).'<br>'; 
		// print_r($itemCode);
		// exit;

		for ($i=0; $i < count($itemCode); $i++) { 
	
			$data = array(
							'INVENTORY_ITEM_ID' => $itemCode[$i],
							'DESKRIPSI_SPESIFIKASI' => $spesifikasi[$i],
							'MODEL' => $model[$i],
							'MERK' => $merk[$i],
							'ORIGIN' => $origin[$i],
							'MADE_IN' => $madeIn[$i],
							'SUPPLIER_ITEM' => $supplierItem[$i],
							'CATATAN' => $catatan[$i],
							'LAST_UPDATE_BY' => $user[0]['PERSON_ID'],
							'CUT_OFF_PEMBELIAN' => $cutOff[$i],
							'PEMBAYARAN' => $pembayaran[$i],
							'KELOMPOK_BARANG' => $kelompokBarang[$i],
							'JENIS_KONFIRMASI' => $jenisKonf[$i],
							'KATALOG' => $katalog[$i],
							'LEVEL_VALIDITAS' => $levelValiditas[$i],
							'IMPORT_LOCAL' => $importLokal[$i],
						);

			$checkItem = $this->M_standarisasi->checkItem($itemCode[$i]);

			if ($checkItem) {
				$this->M_standarisasi->UpdateItem($itemCode[$i],$data);
			}else{
				$this->M_standarisasi->saveData($data);
			}
	
		}


		redirect('StandarisasiItemPembelian/Standarisasi/ListData','refresh');
	}

	public function UploadCsv()
	{
		$this->checkSession();
        $user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Menu'] = '';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
        $this->load->view('StandarisasiItemPembelian/Standarisasi/V_Upload');
		$this->load->view('V_Footer',$data);
	}

	public function UploadProcess()
	{
		$fileName 	= $_FILES['userfile']['name'];
		$config['upload_path'] 		= ('./assets/upload/StandarisasiItem/');
		$config['file_name']		= $fileName;
		$config['allowed_types']	= 'csv';
		$config['max_size']			= 20480;
		$this->upload->initialize($config);

		if(! $this->upload->do_upload('userfile') ){
			$error = $this->upload->display_errors();
			$message = '<div class="row">'.$error.'</div>';
						echo $message;
		}else{
			$media	= $this->upload->data();
			$inputFileName 	= './assets/upload/StandarisasiItem/'.$media['file_name'];
			// print_r($inputFileName);
			// exit();
			
			if(is_file($inputFileName))
			{
				// echo('ada');
				chmod($inputFileName, 0777); ## this should change the permissions
			}else {
				// echo('nothing');
			}

			// try{
				$inputFileType  = PHPExcel_IOFactory::identify($inputFileName);
				$objReader = new PHPExcel_Reader_CSV();
				$objReader->setInputEncoding('CP1252');
				$objReader->setDelimiter(',');
				$objReader->setEnclosure('');
				// $objReader->setLineEnding("\r\n");
				$objReader->setSheetIndex(0);
				// $objReader	  = PHPExcel_IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFileName);
			// }catch(Exception $e){
			// 	die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			// }

			$sheet		  	= $objPHPExcel->getSheet(0);
			$highestRow	 	= $sheet->getHighestRow();
			$highestColumn  = $sheet->getHighestColumn();
			$errStock	   	= 0;
			$delCheckPoint  = 0;
			$errSection	 	= '';
			$errEmpty 		= '';
			$data['AllData'] = $highestRow;
			$data['success'] = 0;
			$data['failed'] = 0;
			$data['itemNotExist'] = NULL;
			$itemNotExis=array();

			$data['items'] = array();
			// $items = array();
			for ($row=2; $row <= $highestRow ; $row++) { 
				$itemCode = $sheet->getCell('A'.$row);
				$cutOff = $sheet->getCell('B'.$row);
				$pembayaran = $sheet->getCell('C'.$row);
				$spesifikasi = $sheet->getCell('D'.$row);
				$model = $sheet->getCell('E'.$row);
				$merk = $sheet->getCell('F'.$row);
				$origin = $sheet->getCell('G'.$row);
				$madeIn = $sheet->getCell('H'.$row);
				$suppItem = $sheet->getCell('I'.$row);
				$catatan = $sheet->getCell('J'.$row);
				$kelompokBarang = $sheet->getCell('K'.$row);
				$jenisKonf = $sheet->getCell('L'.$row);
				$katalog = $sheet->getCell('M'.$row);
				$levelValiditas = $sheet->getCell('N'.$row);
				$importLokal = $sheet->getCell('O'.$row);

				$detail = $this->M_standarisasi->getItem($itemCode);

				$item = array(
								'item_code' => $itemCode,
								'inventory_item_id' => $detail[0]['INVENTORY_ITEM_ID'],
								'deskripsi' => $detail[0]['DESCRIPTION'],
								'uom' => $detail[0]['PRIMARY_UOM_CODE'],
								'category' => $detail[0]['CATEGORY'],
								'buyer' => $detail[0]['BUYER'],
								'spesifikasi' => $spesifikasi,
								'model' => $model,
								'merk' => $merk,
								'origin' => $origin,
								'made_in' => $madeIn,
								'supplier_item' => $suppItem,
								'catatan' => $catatan,
								'cut_off_pembelian' => $cutOff,
								'pembayaran' => $pembayaran,
								'kelompok_barang' => $kelompokBarang,
								'jenis_konfirmasi' => $jenisKonf,
								'katalog' => $katalog,
								'level_validitas' => $levelValiditas,
								'import_local' => $importLokal,
							);

				array_push($data['items'],$item);
			}

			$returnTable = $this->load->view('StandarisasiItemPembelian/Standarisasi/V_TableImport',$data, true);

        	echo($returnTable);
		}

	}

	public function UpdateItem()
	{
		$noind = $this->session->user;
		$user = $this->M_standarisasi->getPersonId($noind);
		$inventory_item_id = $_POST['inventory_item_id'];
		$spesifikasi = $_POST['spesifikasi'];
		$model = $_POST['model'];
		$merk = $_POST['merk'];
		$origin = $_POST['origin'];
		$made_in = $_POST['made_in'];
		$supplier_item = $_POST['supplier_item'];
		$catatan = $_POST['catatan'];
		$cutOff = $_POST['cutoff'];
		$pembayaran = $_POST['pembayaran'];
		$kelompokBarang = $_POST['kelompokBarang'];
		$jenisKonf = $_POST['jenisKonf'];
		$katalog = $_POST['katalog'];
		$levelValiditas = $_POST['levelValiditas'];
		$importLokal = $_POST['importLokal'];


		$item = array(
						'DESKRIPSI_SPESIFIKASI' => $spesifikasi,
						'MODEL' => $model,
						'MERK' => $merk,
						'ORIGIN' => $origin,
						'MADE_IN' => $made_in,
						'SUPPLIER_ITEM' => $supplier_item,
						'CATATAN' => $catatan,
						'LAST_UPDATE_BY' => $user[0]['PERSON_ID'],
						'CUT_OFF_PEMBELIAN' => $cutOff,
						'PEMBAYARAN' => $pembayaran,
						'KELOMPOK_BARANG' => $kelompokBarang,
						'JENIS_KONFIRMASI' => $jenisKonf,
						'KATALOG' => $katalog,
						'LEVEL_VALIDITAS' => $levelValiditas,
						'IMPORT_LOCAL' => $importLokal,
					 );
		
		$this->M_standarisasi->UpdateItem($inventory_item_id,$item);

		echo 1;
	}

	public function ExportCSV()
	{
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(17);


		$objset = $objPHPExcel->setActiveSheetIndex(0);
		$objset->mergeCells('A1:A2');
		$objset->mergeCells('B1:B2');
		$objset->mergeCells('C1:C2');
		$objset->mergeCells('D1:D2');
		$objset->mergeCells('E1:E2');
		$objset->mergeCells('F1:F2');
		$objset->mergeCells('G1:G2');
		$objset->mergeCells('H1:L1');
		$objset->mergeCells('M1:M2');
		$objset->mergeCells('N1:N2');
		$objset->mergeCells('O1:O2');
		$objset->mergeCells('P1:P2');
		$objset->mergeCells('Q1:R1');
		$objset->mergeCells('S1:S2');
		$objset->mergeCells('T1:T2');
		// $objset->mergeCells('U1:U2');

		// $objPHPExcel->getActiveSheet()->getStyle('A1:V2')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1:V2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A1:V2')->getAlignment()->setWrapText(true); 
		$objPHPExcel->getActiveSheet()->getStyle('A1:T2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('0080ff');
		$objPHPExcel->getActiveSheet()->getStyle('A1:T2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$objset->setCellValue("A1", 'No');
		$objset->setCellValue("B1", 'ITEM CODE');
		$objset->setCellValue("C1", 'ITEM DESCRIPTION');	
		$objset->setCellValue("D1", 'PRIMARY UOM');	
		$objset->setCellValue("E1", 'BUYER');
		$objset->setCellValue("F1", 'CUT OFF ORDER');
		$objset->setCellValue("G1", 'PEMBAYARAN');
		// $objset->setCellValue("H1", 'STANDAR ITEM BELI / KODE-DESKRIPSI ITEM YANG TERTERA DI PO');	
		$objset->setCellValue("H1", 'DESKRIPSI SPESIFIKASI');	
		$objset->setCellValue("I1", 'MODEL');
		$objset->setCellValue("J1", 'MERK');
		$objset->setCellValue("K1", 'ORIGIN');
		$objset->setCellValue("L1", 'MADE IN');
		$objset->setCellValue("M1", 'SUPPLIER ITEM');
		$objset->setCellValue("N1", 'CATATAN');
		$objset->setCellValue("O1", 'KELOMPOK BARANG');
		$objset->setCellValue("P1", 'KATEGORI BARANG');
		// $objset->setCellValue("Q1", 'REFERENSI');
		$objset->setCellValue("Q1", 'JENIS KONF.');
		$objset->setCellValue("R1", 'KATALOG');
		$objset->setCellValue("S1", 'LEVEL VALIDITAS DATA');
		$objset->setCellValue("T1", 'IMPORT / LOKAL');


		$row = 2;

		$listData = $this->M_standarisasi->Listdata();

		$no = 0;
		for ($i=0; $i < count($listData); $i++) { $no++;
		

			$objset->setCellValue("A".$row, $no);
			$objset->setCellValue("B".$row, $listData[$i]['ITEM_CODE']);
			$objset->setCellValue("C".$row, $listData[$i]['DESCRIPTION']);	
			$objset->setCellValue("D".$row, $listData[$i]['PRIMARY_UOM_CODE']);	
			$objset->setCellValue("E".$row, $listData[$i]['BUYER']);
			$objset->setCellValue("F".$row, $listData[$i]['CUT_OFF_PEMBELIAN']);
			$objset->setCellValue("G".$row, $listData[$i]['PEMBAYARAN']);
			$objset->setCellValue("H".$row, $listData[$i]['DESKRIPSI_SPESIFIKASI']);	
			$objset->setCellValue("I".$row, $listData[$i]['MODEL']);	
			$objset->setCellValue("J".$row, $listData[$i]['MERK']);	
			$objset->setCellValue("K".$row, $listData[$i]['ORIGIN']);	
			$objset->setCellValue("L".$row, $listData[$i]['MADE_IN']);	
			$objset->setCellValue("M".$row, $listData[$i]['SUPPLIER_ITEM']);	
			$objset->setCellValue("N".$row, $listData[$i]['CATATAN']);
			$objset->setCellValue("O".$row, $listData[$i]['KELOMPOK_BARANG']);
			$objset->setCellValue("P".$row, $listData[$i]['CATEGORY']);
			$objset->setCellValue("Q".$row, $listData[$i]['JENIS_KONFIRMASI']);
			$objset->setCellValue("R".$row, $listData[$i]['KATALOG']);
			$objset->setCellValue("S".$row, $listData[$i]['LEVEL_VALIDITAS']);
			$objset->setCellValue("T".$row, $listData[$i]['IMPORT_LOCAL']);

			$row++;
		}
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle('ITEM');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="[export]standarisasi_item_pembelian_'.date('d:M:Y').'.csv"');
		$objWriter->save("php://output");
	}

	public function DeleteItem()
	{
		$inv_id = $_POST['inv_id'];

		$this->M_standarisasi->deleteItem($inv_id);

		echo 1;
	}
	

} ?>