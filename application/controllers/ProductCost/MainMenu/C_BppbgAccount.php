<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_BppbgAccount extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('url');
        $this->load->helper('html');
		$this->load->library('session');
        $this->load->library('upload');
		$this->load->library('Excel');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('ProductCost/M_bppbgaccount');
		$this->load->model('ProductCost/M_bppbgcategory');
		$this->load->model('ProductCost/M_ajax');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
    }
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
	
	public function index($conflict=NULL, $success=NULL)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Product Cost';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu']		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['account']		= $this->M_bppbgaccount->getAccount();
		$data['no']				= 1;

		if ($conflict!=NULL && $success!=NULL) {
			$message = '
                    <div class="modal fade" id="uploadMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="text-center">
                                		<div class="row">
	                                    	<div class="col-md-12">
		                                        <h2 class="modal-title" id="myModalLabel"><b>Insert Status!</b></h2>
		                                    </div>
	                                    </div>
                                		<div class="row">
	                                    	<div class="col-md-5 col-md-offset-1 bg-success"><h1>';
	                                    	$message .= $success;
	                                    	$message .= ' Success</h1></div>
	                                    	<div class="col-md-5 bg-danger"><h1>';
	                                    	$message .= $conflict;
	                                    	$message .= ' Conflict</h1></div>
                                    	</div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $("#uploadMessage").modal("show");
                        });
                    </script>';
		}else{
			$message = 'firman';
		}

		$data['message'] = $message;
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ProductCost/MainMenu/BppbgAccount/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title']	= 'Create Bppbg Account';
		$data['Menu']	= 'Product Cost';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['costcenter']		= $this->M_bppbgaccount->getCostCenter();
		$data['accountnumber']	= $this->M_bppbgaccount->getAccountNumber();
		$data['category']		= $this->M_bppbgcategory->getBppbgCategory();
		
		$this->form_validation->set_rules('check', 'check', 'required');
		if (empty($_FILES['fileAccount']['name']))
		{
			$this->form_validation->set_rules('fileAccount', 'Document', 'required');
		}

		if ($this->form_validation->run() === FALSE) {
            $data['errmessage'] = '';
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('ProductCost/MainMenu/BppbgAccount/V_create', $data);
			$this->load->view('V_Footer',$data);
		} else {
			$fileName 					= time().$_FILES['fileAccount']['name'];
	        $config['upload_path']		= 'assets/upload/ProductCost';
	        $config['file_name']		= $fileName;
	        $config['allowed_types']	= 'xls|xlsx|csv';
	        $config['max_size']			= 10000;

	        $this->upload->initialize($config);
	        if(! $this->upload->do_upload('fileAccount') ){
	            $errorinfo = $this->upload->display_errors();
	          	$message = '<div class="row">
	          					<div class="col-md-6 col-md-offset-3" style="margin-top: 20px">
	          						<div id="eror" class="alert alert-dismissible" role="alert" style="background-color:#c53838; text-align:center; color:white; ">
	          							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	          								<span aria-hidden="true">&times;</span>
	          							</button>';
	                                    $message .= $errorinfo;
	          							$message .= '
	          						</div>
	          					</div>
	                      	</div>';
	            $data['errmessage'] = $message;
	            $this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('ProductCost/MainMenu/BppbgAccount/V_create', $data);
				$this->load->view('V_Footer',$data);
	        }else{
	        	$media 			= $this->upload->data();
	        	$inputFileName 	= 'assets/upload/ProductCost/'.$media['file_name'];

	        	try{
	                $inputFileType 	= PHPExcel_IOFactory::identify($inputFileName);
	                $objReader 		= PHPExcel_IOFactory::createReader($inputFileType);
	                $objPHPExcel 	= $objReader->load($inputFileName);
	            }catch(Exception $e){
	            	die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
	            }

	            $sheet 			= $objPHPExcel->getSheet(0);
	            $highestRow 	= $sheet->getHighestRow();
	            $highestColumn 	= $sheet->getHighestColumn();
	            $dataConflict	= 0;
	            $dataSuccess	= 0;

	            for ($row = 4; $row <= $highestRow; $row++){
	            	$checkConflict=0;
	            	$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

	            	if ($rowData[0][0] != null) {
						$NEXTVAL = $this->M_bppbgaccount->getNextVal();

						$ACCOUNT_ID 			= $NEXTVAL[0]['NEXTVAL'];
						$USING_CATEGORY_CODE 	= $rowData[0][1];
						$USING_CATEGORY 		= $rowData[0][2];
						$COST_CENTER 			= strval($rowData[0][3]);
						$ACCOUNT_NUMBER 		= $rowData[0][5];
						$ACCOUNT_ATTRIBUTE 		= $rowData[0][6];
						
				    	$check_USING_CATEGORY_CODE 	= $this->M_ajax->checkBppbgAccount('USING_CATEGORY_CODE', $USING_CATEGORY_CODE);
				    	$check_COST_CENTER 			= $this->M_ajax->checkBppbgAccount('COST_CENTER', $COST_CENTER);
				    	$check_ACCOUNT_NUMBER 		= $this->M_ajax->checkBppbgAccount('ACCOUNT_NUMBER', $ACCOUNT_NUMBER);
				    	if ($check_USING_CATEGORY_CODE != 0 && $check_COST_CENTER != 0 && $check_ACCOUNT_NUMBER != 0) {
				    		$checkConflict++;
				    		$dataConflict++;
				    	}
	                }

	                if ($checkConflict == 0) {
	                	$dataSuccess++;
                		$this->M_bppbgaccount->setAccount($ACCOUNT_ID, $USING_CATEGORY_CODE, $USING_CATEGORY, $COST_CENTER, $ACCOUNT_NUMBER, $ACCOUNT_ATTRIBUTE);
	                }
	            }
	            unlink($inputFileName);

				redirect(site_url('ProductCost/BppbgAccount/index/'.$dataConflict.'/'.$dataSuccess));
			}
		}
	}

	public function edit($id)
	{
		$user_id = $this->session->userid;

		$data['Title']	= 'Edit Bppbg Account';
		$data['Menu']	= 'Product Cost';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['account']		= $this->M_bppbgaccount->getAccount($id);
		$data['costcenter']		= $this->M_bppbgaccount->getCostCenter();
		$data['accountnumber']	= $this->M_bppbgaccount->getAccountNumber();
		$data['category']		= $this->M_bppbgcategory->getBppbgCategory();
		$data['id']				= $id;
		
		$this->form_validation->set_rules('using_category_code', 'using_category_code', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('ProductCost/MainMenu/BppbgAccount/V_edit', $data);
			$this->load->view('V_Footer',$data);	
		} else {

			$b = $this->input->post('using_category_code');
			$c = $this->input->post('using_category');
			$d = $this->input->post('cost_center');
			$f = $this->input->post('account_number');
			$g = $this->input->post('account_attribute');

			$this->M_bppbgaccount->updateAccount($id,$b,$c,$d,$f,$g);

			redirect(site_url('ProductCost/BppbgAccount/'));
		}
	}

	public function delete($id)
	{
		$this->M_bppbgaccount->deleteAccount($id);
		redirect(site_url('ProductCost/BppbgAccount/'));
	}

	public function DownloadTemplate()
	{
		$this->load->library('Excel');
		$objPHPExcel = new PHPExcel();
		$worksheet = $objPHPExcel->getActiveSheet();
		$worksheet->setTitle('Data_Bppbg_Account');
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
		$leftCenter = array(
               'alignment' => array(
                  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                  'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, ));

		// ----------------- Set format table -----------------
			$worksheet->getColumnDimension('A')->setWidth(8);
			$worksheet->getColumnDimension('B')->setWidth(24);
			$worksheet->getColumnDimension('C')->setWidth(32);
			$worksheet->getColumnDimension('D')->setWidth(15);
			$worksheet->getColumnDimension('E')->setWidth(32);
			$worksheet->getColumnDimension('F')->setWidth(15);
			$worksheet->getColumnDimension('G')->setWidth(32);

			$worksheet->getStyle('A1:G1')->applyFromArray($styleThead);
			$worksheet	->getStyle('A1:G1')
						->getFill()
						->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
						->getStartColor()
						->setARGB('337ab7');
			$worksheet->getStyle('A1:G3')->applyFromArray($styleBorder);
		// ----------------- STATIC DATA -----------------
			$worksheet->setCellValue('A1', 'NO');
			$worksheet->setCellValue('B1', 'CATEGORY CODE');
			$worksheet->setCellValue('C1', 'CATEGORY DESCRIPTION');
			$worksheet->setCellValue('D1', 'COST CENTER');
			$worksheet->setCellValue('E1', 'COST CENTER DESCRIPTION');
			$worksheet->setCellValue('F1', 'ACCOUNT NUMBER');
			$worksheet->setCellValue('G1', 'ACCOUNT ATTRIBUTE');
			$worksheet->setCellValue('I1', 'BARIS SAMPLE INI TIDAK PERLU DIHAPUS');

			$worksheet->setCellValue('A2', '1');
			$worksheet->setCellValue('B2', 'PROM');
			$worksheet->setCellValue('C2', 'BARANG PROMOSI');
			$worksheet->setCellValue('D2', '3K01');
			$worksheet->setCellValue('E2', 'SALES ALAT PERTANIAN');
			$worksheet->setCellValue('F2', '523207');
			$worksheet->setCellValue('G2', 'PROM_KAOS DAN SOUV');
			$worksheet->setCellValue('I2', 'CUKUP TAMBAHKAN DATA YANG INGIN DIINPUT DI BARIS KE-4 DAN SETERUSNYA');

			$worksheet->setCellValue('A3', '(NOT NULL - WAJIB DIISI)');
			$worksheet->setCellValue('B3', '(BERISI CATEGORY CODE - NOT NULL)');
			$worksheet->setCellValue('C3', '(BERISI CATEGORY DESCRIPTION - NOT NULL)');
			$worksheet->setCellValue('D3', '(BERISI COST CENTER - NOT NULL)');
			$worksheet->setCellValue('E3', '(BERISI COST CENTER DESCRIPTION - NOT NULL)');
			$worksheet->setCellValue('F3', '(BERISI ACCOUNT NUMBER - NOT NULL)');
			$worksheet->setCellValue('G3', '(BERISI ACCOUNT ATTRIBUTE)');
			$worksheet->setCellValue('I3', 'PENDATAAN DATA DIMULAI DARI BARIS KE 4');

	        $worksheet->getStyle('A3:G3')->getAlignment()->setWrapText(true);
	        $worksheet->getStyle('A1:G3')->applyFromArray($aligncenter);
	        $worksheet->getStyle('A3:G3')->applyFromArray($styleNotice);
	        $worksheet->getStyle('I1:I3')->applyFromArray($styleNotice);
		// ----------------- DYNAMIC DATA -----------------
			// ----------------- CATEGORY -----------------
				$category		= $this->M_bppbgcategory->getBppbgCategory();
				$objWorkSheet = $objPHPExcel->createSheet(1);
				$objWorkSheet->setTitle("CATEGORY");

				$objWorkSheet->getStyle('A1:D1')->applyFromArray($styleThead);
				$objWorkSheet	->getStyle('A1:D1')
							->getFill()
							->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
							->getStartColor()
							->setARGB('337ab7');
				$objWorkSheet->getColumnDimension('A')->setWidth(8);
				$objWorkSheet->getColumnDimension('B')->setWidth(24);
				$objWorkSheet->getColumnDimension('C')->setWidth(45);
				$objWorkSheet->getColumnDimension('D')->setWidth(85);
				$objWorkSheet->setCellValue('A1', 'NO');
				$objWorkSheet->setCellValue('B1', 'CATEGORY CODE');
				$objWorkSheet->setCellValue('C1', 'CATEGORY DESCRIPTION');
				$objWorkSheet->setCellValue('D1', 'GENERAL DESCRIPTION');

				$no = 1;
				$highestRow = $objWorkSheet->getHighestRow()+1;
				foreach ($category as $ctgr) {
					$objWorkSheet->getStyle('A'.$highestRow.':D'.$highestRow)->applyFromArray($styleBorder);
					$objWorkSheet->setCellValue('A'.$highestRow, $no++);
					$objWorkSheet->setCellValue('B'.$highestRow, $ctgr['USING_CATEGORY_CODE']);
					$objWorkSheet->setCellValue('C'.$highestRow, $ctgr['USING_CATEGORY_DESCRIPTION']);
					$objWorkSheet->setCellValue('D'.$highestRow, $ctgr['GENERAL_DESCRIPTION']);
					$objWorkSheet->getStyle('D'.$highestRow)->getAlignment()->setWrapText(true);
					$objWorkSheet->getStyle('A'.$highestRow.':D'.$highestRow)->applyFromArray($leftCenter);
					$highestRow++;
				}

			// ----------------- COST CENTER -----------------
				$costcenter		= $this->M_bppbgaccount->getCostCenter();
				$objWorkSheet = $objPHPExcel->createSheet(2);
				$objWorkSheet->setTitle("COST_CENTER");

				$objWorkSheet->getStyle('A1:C1')->applyFromArray($styleThead);
				$objWorkSheet	->getStyle('A1:C1')
							->getFill()
							->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
							->getStartColor()
							->setARGB('337ab7');
				$objWorkSheet->getColumnDimension('A')->setWidth(8);
				$objWorkSheet->getColumnDimension('B')->setWidth(18);
				$objWorkSheet->getColumnDimension('C')->setWidth(55);
				$objWorkSheet->setCellValue('A1', 'NO');
				$objWorkSheet->setCellValue('B1', 'COST CENTER');
				$objWorkSheet->setCellValue('C1', 'COST CENTER DESCRIPTION');

				$no = 1;
				$highestRow = $objWorkSheet->getHighestRow()+1;
				foreach ($costcenter as $cc) {
					$objWorkSheet->getStyle('A'.$highestRow.':C'.$highestRow)->applyFromArray($styleBorder);
					$objWorkSheet->setCellValue('A'.$highestRow, $no++);
					$objWorkSheet->setCellValue('B'.$highestRow, $cc['COST_CENTER']);
					$objWorkSheet->setCellValue('C'.$highestRow, $cc['COST_CENTER_DESCRIPTION']);
					$objWorkSheet->getStyle('C'.$highestRow)->getAlignment()->setWrapText(true);
					$objWorkSheet->getStyle('A'.$highestRow.':C'.$highestRow)->applyFromArray($leftCenter);
					$highestRow++;
				}

			// ----------------- ACCOUNT NUMBER -----------------
				$accountnumber	= $this->M_bppbgaccount->getAccountNumber();
				$objWorkSheet = $objPHPExcel->createSheet(3);
				$objWorkSheet->setTitle("ACCOUNT_NUMBER");

				$objWorkSheet->getStyle('A1:C1')->applyFromArray($styleThead);
				$objWorkSheet	->getStyle('A1:C1')
							->getFill()
							->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
							->getStartColor()
							->setARGB('337ab7');
				$objWorkSheet->getColumnDimension('A')->setWidth(8);
				$objWorkSheet->getColumnDimension('B')->setWidth(24);
				$objWorkSheet->getColumnDimension('C')->setWidth(35);
				$objWorkSheet->setCellValue('A1', 'NO');
				$objWorkSheet->setCellValue('B1', 'ACCOUNT NUMBER');
				$objWorkSheet->setCellValue('C1', 'ACCOUNT NUMBER DESCRIPTION');

				$no = 1;
				$highestRow = $objWorkSheet->getHighestRow()+1;
				foreach ($accountnumber as $an) {
					$objWorkSheet->getStyle('A'.$highestRow.':C'.$highestRow)->applyFromArray($styleBorder);
					$objWorkSheet->setCellValue('A'.$highestRow, $no++);
					$objWorkSheet->setCellValue('B'.$highestRow, $an['ACCOUNT_NUMBER']);
					$objWorkSheet->setCellValue('C'.$highestRow, $an['ACCOUNT_NUMBER_DESCRIPTION']);
					$objWorkSheet->getStyle('C'.$highestRow)->getAlignment()->setWrapText(true);
					$objWorkSheet->getStyle('A'.$highestRow.':C'.$highestRow)->applyFromArray($leftCenter);
					$highestRow++;
				}

		// ----------------- Final Process -----------------
			$objPHPExcel->setActiveSheetIndex(0);
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="BPPBP_ACCOUNT_'.time().'.xls"');
			$objWriter->save("php://output");
	}
}