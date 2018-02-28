<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_ItemPlan extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('Excel');
        $this->load->library('upload');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('ProductionPlanning/MainMenu/M_itemplan');
        $this->load->model('ProductionPlanning/MainMenu/M_dataplan');
		$this->load->model('ProductionPlanning/MainMenu/M_storagemonitoring');
    }
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
	
	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['itemData']		= $this->M_itemplan->getItemData();
		$data['no']				= 1;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ProductionPlanning/MainMenu/ItemPlan/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

    public function Create($message=false)
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        
        $data['UserMenu']       = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        
        $data['message'] = $message;
        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('ProductionPlanning/MainMenu/ItemPlan/V_Create',$data);
        $this->load->view('V_Footer',$data);
    }

    public function CreateUpload()
    {
    	$user_id 	= $this->session->userid;
		$fileName 	= time().'-'.$_FILES['itemData']['name'];
        $config['upload_path'] 		= 'assets/upload/ProductionPlanning/data-plan';
        $config['file_name']		= $fileName;
        $config['allowed_types']	= 'xls|xlsx|csv';
        $config['max_size']			= 2048;
        $this->upload->initialize($config);

        if(! $this->upload->do_upload('itemData') ){
        	$error = $this->upload->display_errors();
        	$message =	'<div class="row">
		 					<div class="col-md-10 col-md-offset-1 col-sm-12">
		 						<div id="messUpPP" class="modal fade modal-danger" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		 							<div class="modal-dialog modal-lg" role="document">
		 								<div class="modal-content">
		 									<div class="modal-body">
		 										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		 											<span aria-hidden="true">&times;</span>
		 										</button>';
		 										$message .= $error;
		 										$message .= '
		 									</div>
		 								</div>
			 						</div>
			 					</div>
				 			</div>
            		    </div>
            		    <script type="text/javascript">
							$("#messUpPP").modal("show");
						</script>';
			$this->Create($message);
        }else{
        	$media	= $this->upload->data();
        	$inputFileName 	= 'assets/upload/ProductionPlanning/data-plan/'.$media['file_name'];
        	$subInv = $this->M_dataplan->getSection();

        	try{
        		$inputFileType  = PHPExcel_IOFactory::identify($inputFileName);
                $objReader      = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel    = $objReader->load($inputFileName);
            }catch(Exception $e){
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            }

            $sheet          = $objPHPExcel->getSheet(0);
            $highestRow     = $sheet->getHighestRow();
            $highestColumn  = $sheet->getHighestColumn();
            $errStock       = 0;
            $delCheckPoint  = 0;
            $errSection     = '';
            $errEmpty = '';

            for ($row = 7; $row <= $highestRow; $row++){
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                if ($rowData[0][0] != null) {
                    $secID = 0;
                    $secCheckPoint = 0;
                    foreach ($subInv as $si) {
                        if ($secCheckPoint == 0 && strtoupper(preg_replace('/\s+/', '', $si['section_name'])) == strtoupper(preg_replace('/\s+/', '', $rowData[0][3]))) {
                            $secID = $si['section_id'];
                            $secCheckPoint = 1;
                        }
                    }
                    $datPoint = "1";
                    if (!empty($rowData[0][5])) {
                        $stgId = $this->M_storagemonitoring->getStoragePP($rowData[0][5]);
                    }elseif (empty($rowData[0][5]) && !empty($rowData[0][6])) {
                        $stgId = $this->M_storagemonitoring->getStoragePP($rowData[0][6]);
                    }

                    if (empty($stgId)) {
                        $stgIdVal = null;
                    }else{
                        $stgIdVal = $stgId[0]['storage_id'];
                    }
                    
                    $dataIns = array(
                        'item_code'         => $rowData[0][1],
                        'item_description'  => $rowData[0][2],
                        'section_id'        => $secID,
                        'from_inventory'    => $rowData[0][4],
                        'to_inventory'      => $rowData[0][5],
                        'completion'        => $rowData[0][6],
                        'created_by'        => $user_id,
                        'created_date'      => date('Y-m-d H:i:s'),
                        'storage_id'        => $stgIdVal
                    );
                    if ($secCheckPoint == 0) {
                        $errSection .= 'Nama Seksi Ada yang tidak sesuai. '.strtoupper(preg_replace('/\s+/', '', $rowData[0][3])).'<br>';
                        $errStock++;
                    }else{
                        $errSection .= '';
                    }
                    if (empty($rowData[0][1]) || empty($rowData[0][3]) || $secID == 0) {
                        $errStock++;
                        $errEmpty .= 'Data pada baris ke-'.$row.' ada yang kosong.'.'<br>';
                    }else{
                        $errEmpty .= '';
                    }
                }else{
                    $datPoint = null;
                }
                if ($datPoint !=null && $errStock == 0) {
                    $this->M_itemplan->setItemPlan($dataIns,$delCheckPoint);
                    $delCheckPoint = 1;
                }
            }

            unlink($inputFileName);
            if ($errStock > 0) {
                $message = '<div class="row">
                            <div class="col-md-10 col-md-offset-1 col-sm-12">
                                <div id="messUpPP" class="modal fade modal-danger" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>';
                                                $message .= $errStock.'<br>';
                                                $message .= $errSection;
                                                $message .= $errEmpty;
                                                $message .= '
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $("#messUpPP").modal("show");
                        </script>';
            }else{
                $message = '<div class="row">
                            <div class="col-md-10 col-md-offset-1 col-sm-12">
                                <div id="messUpPP" class="modal fade modal-success" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                UPLOAD COMPLETE!
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $("#messUpPP").modal("show");
                        </script>';
            }
            $this->Create($message);
        }
    }

    public function DownloadSample()
    {
        $section = $this->M_dataplan->getSection();
        $this->load->library('Excel');
        $objPHPExcel = new PHPExcel();
        $worksheet = $objPHPExcel->getActiveSheet();
        $styleThead = array(
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => 'FFFFFF'),
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $styleNotice = array(
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => 'ff0000'),
            )
        );
        $styleBorder = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $aligncenter = array(
               'alignment' => array(
                  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                  'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, ));

        // ----------------- Set format table -----------------
            $worksheet->getColumnDimension('A')->setWidth(8);
            $worksheet->getColumnDimension('B')->setWidth(20);
            $worksheet->getColumnDimension('C')->setWidth(45);
            $worksheet->getColumnDimension('D')->setWidth(24);
            $worksheet->getColumnDimension('E')->setWidth(32);
            $worksheet->getColumnDimension('F')->setWidth(34);
            $worksheet->getColumnDimension('G')->setWidth(16);
            $worksheet->getColumnDimension('H')->setWidth(2);
            $worksheet->getColumnDimension('I')->setWidth(5);
            $worksheet->getColumnDimension('J')->setWidth(20);

            $worksheet->getStyle('A1:G1')->applyFromArray($styleThead);
            $worksheet  ->getStyle('A1:G1')
                        ->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('337ab7');
            $worksheet->getStyle('A1:G6')->applyFromArray($styleBorder);
            $worksheet->getStyle('I9:J9')->applyFromArray($styleThead);
            $worksheet  ->getStyle('I9:J9')
                        ->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('337ab7');

        // ----------------- STATIC DATA -----------------
            $worksheet->setCellValue('A1', 'NO');
            $worksheet->setCellValue('B1', 'KODE ITEM');
            $worksheet->setCellValue('C1', 'DESKRIPSI ITEM');
            $worksheet->setCellValue('D1', 'FABRIKASI (DEP. CLASS)');
            $worksheet->setCellValue('E1', 'GUDANG ASAL (SUBINVENTORY)');
            $worksheet->setCellValue('F1', 'GUDANG TUJUAN (SUBINVENTORY)');
            $worksheet->setCellValue('G1', 'COMPLETION');

            $worksheet->setCellValue('A2', '1');
            $worksheet->setCellValue('B2', 'ACA1AAA001AY-0');
            $worksheet->setCellValue('C2', 'FRONTSIDE FRAME ASSY');
            $worksheet->setCellValue('D2', 'PERAKITAN C');
            $worksheet->setCellValue('G2', 'INT-PRK');

            $worksheet->setCellValue('A3', '2');
            $worksheet->setCellValue('B3', 'ACA1AAA091AY-0');
            $worksheet->setCellValue('C3', 'UPPERSIDE SUPPORT PLATE (L)');
            $worksheet->setCellValue('D3', 'SHEET METAL');
            $worksheet->setCellValue('F3', 'KOM1-DM');

            $worksheet->setCellValue('A4', '3');
            $worksheet->setCellValue('B4', 'ACA1BA0021AY-0');
            $worksheet->setCellValue('C4', 'GEAR CASE (L), ZENA');
            $worksheet->setCellValue('D4', 'MACHINING A');
            $worksheet->setCellValue('E4', 'INT-UPL');
            $worksheet->setCellValue('F4', 'KOM1-DM');
            $worksheet->setCellValue('I4', 'BARIS SAMPLE INI TIDAK PERLU DIHAPUS');

            $worksheet->setCellValue('A5', '4');
            $worksheet->setCellValue('B5', 'ACA1B00001AY-0');
            $worksheet->setCellValue('C5', 'GEAR TRANSMISSION ASSY');
            $worksheet->setCellValue('D5', 'PERAKITAN A');
            $worksheet->setCellValue('G5', 'INT-PRK');
            $worksheet->setCellValue('I5', 'CUKUP TAMBAHKAN DATA YANG INGIN DIINPUT DI BARIS KE-7 DAN SETERUSNYA');

            $worksheet->setCellValue('A6', '(NOT NULL - WAJIB DIISI)');
            $worksheet->setCellValue('B6', '(BERISI KODE ITEM - CHARACTER)');
            $worksheet->setCellValue('C6', '(BERISI DESKRIPSI DARI  ITEM DENGAN KODE ITEM YANG DIINPUTKAN - CHARACTER)');
            $worksheet->setCellValue('D6', '(NOT NULL - BERISI NAMA DEPARTEMEN)');
            $worksheet->setCellValue('E6', '(BOLEH NULL - BERISI GUDANG ASAL)');
            $worksheet->setCellValue('F6', '(BOLEH NULL - BERISI GUDANG TUJUAN)');
            $worksheet->setCellValue('G6', '(BOLEH NULL - BERISI COMPLETION)');
            $worksheet->setCellValue('I6', 'PENDATAAN DATA DIMULAI DARI BARIS KE 7');

            $worksheet->setCellValue('I8', 'PENULISAN NAMA SEKSI YANG BENAR');
            $worksheet->setCellValue('I9', 'NO');
            $worksheet->setCellValue('J9', 'NAMA SEKSI');

            $worksheet->getStyle('A6:G6')->getAlignment()->setWrapText(true);
            $worksheet->getStyle('A1:G6')->applyFromArray($aligncenter);
            $worksheet->getStyle('A6:G6')->applyFromArray($styleNotice);
            $worksheet->getStyle('I4:I6')->applyFromArray($styleNotice);
        // ----------------- DYNAMIC DATA -----------------
            $no = 1;
            $highestRow = $worksheet->getHighestRow()+1;
            foreach ($section as $sc) {
                $worksheet->getStyle('I'.$highestRow.':J'.$highestRow)->applyFromArray($styleBorder);
                $worksheet->setCellValue('I'.$highestRow, $no++);
                $worksheet->setCellValue('J'.$highestRow, $sc['section_name']);
                $highestRow++;
            }

        // ----------------- Final Process -----------------
        $worksheet->setTitle('Item_Data_Plan');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Item_Data_Plan_'.time().'.xls"');
        $objWriter->save("php://output");
    }
}