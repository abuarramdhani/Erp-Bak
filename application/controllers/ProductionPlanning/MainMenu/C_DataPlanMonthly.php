<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_DataPlanMonthly extends CI_Controller {

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
		$this->load->model('ProductionPlanning/MainMenu/M_dataplan');
		$this->load->model('ProductionPlanning/Settings/GroupSection/M_groupsection');
    }
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
	
	public function index($message=FALSE)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['plan']			= $this->M_dataplan->getMonthlyPlan();
		$data['no']				= 1;
		$data['message'] 		= $message;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ProductionPlanning/MainMenu/DataPlan/Monthly/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Create($message=FALSE)
	{
		$this->checkSession();
		$user_id  = $this->session->userid;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['section'] 		= $this->M_dataplan->getSection($user_id);
		$data['message'] 		= $message;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ProductionPlanning/MainMenu/DataPlan/Monthly/V_Create',$data);
		$this->load->view('V_Footer',$data);
	}

	public function CreateSubmit()
	{
		$this->checkSession();
		$user_id  = $this->session->userid;

		$fileName 				= time().'-'.$_FILES['planData']['name'];
	    $config['upload_path']	= 'assets/upload/ProductionPlanning/data-plan';
	    $config['file_name']	= $fileName;
	    $config['allowed_types']= 'xls|xlsx|csv';
	    $config['max_size']		= 2048;
	    $this->upload->initialize($config);

        if(! $this->upload->do_upload('planData') ){
        	$error = $this->upload->display_errors();
       		$msg =	'<div class="row">
	 					<div class="col-md-10 col-md-offset-1 col-sm-12">
	 						<div id="messUpPP" class="modal fade modal-danger" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	 							<div class="modal-dialog modal-lg" role="document">
	 								<div class="modal-content">
	 									<div class="modal-body">
	 										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	 											<span aria-hidden="true">&times;</span>
	 										</button>';
	 										$msg .= $error;
		 									$msg .= '
		 								</div>
		 							</div>
			 					</div>
		 					</div>
			 			</div>
           		    </div>
            		<script type="text/javascript">
						$("#messUpPP").modal("show");
					</script>';
			$this->Create($msg);
	    }else{
	        $media			= $this->upload->data();
	        $inputFileName 	= 'assets/upload/ProductionPlanning/data-plan/'.$media['file_name'];
    		$section 		= $this->M_dataplan->getSection();

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

            for ($row = 4; $row <= $highestRow; $row++){
            	$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
            	if ($rowData[0][0] != null) {
            		$datPoint = "1";
        			$secCheckPoint = 0;
            		foreach ($section as $sc) {
            			if ($secCheckPoint == 0 && strtoupper(preg_replace('/\s+/', '', $sc['section_name'])) == strtoupper(preg_replace('/\s+/', '', $rowData[0][1]))) {
            				$section_id = $sc['section_id'];
            				$secCheckPoint = 1;
            			}
            		}

            		$value = array(
						'section_id'			=> $section_id,
						'plan_time'				=> date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($rowData[0][2])),
						'monthly_plan_quantity' => $rowData[0][3],
						'created_by'			=> $user_id,
						'created_date'			=> date("Y-m-d H:i:s")
					);

					if ($secCheckPoint == 0) {
						$sectionError = 'Nama Seksi Ada yang tidak sesuai. '.strtoupper(preg_replace('/\s+/', '', $rowData[0][1]));
        				$errStock++;
					}else{
						$sectionError = '';
					}

                    if (!is_numeric($rowData[0][3])) {
                        $errStock++;
                        $qtyError = 'Quantity pada baris ke-'.$row.' tidak Numeric.';
                    }else{
                        $qtyError = '';
                    }
                    if (empty($rowData[0][1])||empty($rowData[0][2]) || empty($rowData[0][3])) {
                        $errStock++;
                        $emptyError = 'Data pada baris ke-'.$row.' kosong.';
                    }else{
                        $emptyError = '';
                    }
                }else{
                    $datPoint = null;
                }

                if ($datPoint !=null && $errStock == 0) {
                	$this->M_dataplan->insertDataPlan($value, 'pp.pp_monthly_plans');
                }
            }

        	unlink($inputFileName);
        	if ($errStock > 0) {
        		$msg =	'<div class="row">
	 					<div class="col-md-10 col-md-offset-1 col-sm-12">
	 						<div id="messUpPP" class="modal fade modal-danger" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	 							<div class="modal-dialog modal-lg" role="document">
	 								<div class="modal-content">
	 									<div class="modal-body">
	 										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	 											<span aria-hidden="true">&times;</span>
	 										</button>';
	 										$msg .= $sectionError.'<br>';
	 										$msg .= $qtyError.'<br>';
	 										$msg .= $errStock.'<br>';
	 										$msg .= '
		 								</div>
		 							</div>
			 					</div>
		 					</div>
			 			</div>
           		    </div>
            		<script type="text/javascript">
						$("#messUpPP").modal("show");
					</script>';
        		$this->Create($msg);
        	}else{
            	$msg =	'<div class="row">
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
        		$this->index($msg);
        	}
        }
	}

	public function Edit($id)
	{
		$this->checkSession();
		$user_id  = $this->session->userid;
		$this->form_validation->set_rules('planQTY', 'required');
		if ($this->form_validation->run() === FALSE){
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['SubMenuTwo'] = '';

			$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['plan']			= $this->M_dataplan->getMonthlyPlan($id);

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('ProductionPlanning/MainMenu/DataPlan/Monthly/V_Edit',$data);
			$this->load->view('V_Footer',$data);
		}else{
			$section 	= $this->input->post('sectionName');
			$planTime 	= date('Y-m-d', strtotime($this->input->post('planTime')));
			$value = array(
				'plan_time'				=> $planTime,
				'monthly_plan_quantity' => $this->input->post('planQTY'),
				'last_updated_by'		=> $user_id,
				'last_updated_date'		=> date("Y-m-d H:i:s")
			);

			$this->M_dataplan->update('pp.pp_monthly_plans','monthly_plan_id',$value,$id);
			redirect(base_url('ProductionPlanning/DataPlanMonthly'));
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
		$worksheet->getColumnDimension('B')->setWidth(24);
		$worksheet->getColumnDimension('C')->setWidth(24);
		$worksheet->getColumnDimension('D')->setWidth(32);
		$worksheet->getColumnDimension('E')->setWidth(5);
		$worksheet->getColumnDimension('F')->setWidth(5);
		$worksheet->getColumnDimension('G')->setWidth(24);

		$worksheet->getStyle('A1:D1')->applyFromArray($styleThead);
		$worksheet	->getStyle('A1:D1')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('337ab7');
		$worksheet->getStyle('A1:D3')->applyFromArray($styleBorder);
		$worksheet->getStyle('F6:G6')->applyFromArray($styleThead);
		$worksheet	->getStyle('F6:G6')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('337ab7');

		// ----------------- STATIC DATA -----------------
		$worksheet->setCellValue('A1', 'NO');
		$worksheet->setCellValue('B1', 'NAMA SEKSI');
		$worksheet->setCellValue('C1', 'BULAN');
		$worksheet->setCellValue('D1', 'TOTAL PROD BULANAN');
		$worksheet->setCellValue('F1', 'BARIS SAMPLE INI TIDAK PERLU DIHAPUS');
		$worksheet->setCellValue('A2', '1');
		$worksheet->setCellValue('B2', 'PERAKITAN A');
		$worksheet->setCellValue('C2', '10/2017');
		$worksheet->setCellValue('D2', '50000');
		$worksheet->setCellValue('F2', 'CUKUP TAMBAHKAN DATA YANG INGIN DIINPUT DI BARIS KE-4 DAN SETERUSNYA');
		$worksheet->setCellValue('A3', '(NOT NULL - WAJIB DIISI)');
		$worksheet->setCellValue('B3', '(BERISI NAMA SEKSI-NOT NULL)');
		$worksheet->setCellValue('C3', '(BERISI BULAN PLANNING - NOT NULL - FORMAT: MM/YYYY)');
		$worksheet->setCellValue('D3', '(BERISI NUMBER TOTAL PRODUKSI BULAN TERSEBUT - NOT NULL)');
		$worksheet->setCellValue('F3', 'PENDATAAN DATA DIMULAI DARI BARIS KE 4');
		$worksheet->setCellValue('F5', 'PENULISAN NAMA SEKSI YANG BENAR');
		$worksheet->setCellValue('F6', 'NO');
		$worksheet->setCellValue('G6', 'NAMA SEKSI');

        $worksheet->getStyle('A3:D3')->getAlignment()->setWrapText(true);
        $worksheet->getStyle('A1:D3')->applyFromArray($aligncenter);
        $worksheet->getStyle('A3:D3')->applyFromArray($styleNotice);
        $worksheet->getStyle('F1:F3')->applyFromArray($styleNotice);
		// ----------------- DYNAMIC DATA -----------------
		$no = 1;
		$highestRow = $worksheet->getHighestRow()+1;
		foreach ($section as $sc) {
			$worksheet->getStyle('F'.$highestRow.':G'.$highestRow)->applyFromArray($styleBorder);
			$worksheet->setCellValue('F'.$highestRow, $no++);
			$worksheet->setCellValue('G'.$highestRow, $sc['section_name']);
			$highestRow++;
		}

		// ----------------- Final Process -----------------
		$worksheet->setTitle('Monthly_Planning');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Monthly_Planning_'.time().'.xls"');
		$objWriter->save("php://output");
	}
}