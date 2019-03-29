<?php defined('BASEPATH') OR exit('No direct script access allowed');
class C_TarikData extends CI_Controller
{
	
public function __construct()
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
			 $this->load->model('OpnameResource/M_opnameresource');
			if($this->session->userdata('logged_in')!=TRUE) {
				$this->load->helper('url');
				$this->session->set_userdata('last_page', current_url());
				$this->session->set_userdata('Responsbility', 'some_value');
			}
		}

	public function checkSession(){
		if($this->session->is_logged){
			}else{
				redirect();
			}
	}

	public function index()
		{
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringICT/V_Dashboard',$data);
		$this->load->view('V_Footer',$data);

		}

	public function TarikData()
		{
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['selectDoc'] = $this->M_opnameresource->getDataSelect();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('OpnameResource/MainMenu/TarikData/V_Index',$data);
		$this->load->view('V_Footer',$data);

		}


	public function Export()
	{
		$type = $this->input->post('typeexport');
		$no_doc = $this->input->post('slcNoDoc');
		if ($type == 'excel') {
			$this->Excel($no_doc);
		}elseif ($type == 'pdf') {
			$this->Pdf($no_doc);
		}
		
	}


	private function Excel($no_doc)
	{
		$this->load->library('Excel');
		$getData = $this->M_opnameresource->getData($no_doc);
		$arrayFilter = array();
		$arrayNama = array('NO MESIN','TAG NUMBER', 'RESOURCE CODE','COST CENTER', 'RUANG');
		foreach ($getData as $key => $value) {
			// for ($i=1; $i < 6; $i++) { 
			// 	if ($value['CHECK'.$i.'_RO'] == ) {
			// 		# code...
			// 	}
			// }
			$data['NO_DOCUMENT_RO'] = $value['NO_DOCUMENT_RO'];
			$data['NO_DOCUMENT_RO'] = $value['NO_DOCUMENT_RO'];
			if ($value['CHECK1_RO'] =='' &&
			  	$value['CHECK2_RO'] =='' &&
			    $value['CHECK3_RO'] =='' &&
				$value['CHECK4_RO'] =='' &&
				$value['CHECK5_RO'] =='' ) {
				$new = $value;
				$new['NO_MESIN_RO'] = ($value['NO_MESIN_RO'] == 'null') ? '' : $value['NO_MESIN_RO'];
				$new['RESOURCE_RO'] = ($value['RESOURCE_RO'] == 'null') ? '<i> (Bukan Resource) <i/>' : $value['RESOURCE_RO'];
				$new['KET'] = 'BELUM DIVERIFIKASI';
				$new['HASIL'] = 'NOT OK';
				$arrayFilter[] = $new;
					
			}else{
				$arrayGakNormal =array();
				if ($value['CHECK1_RO'] =='N' ||
				  	$value['CHECK2_RO'] =='N' ||
				    $value['CHECK3_RO'] =='N' ||
					$value['CHECK4_RO'] =='N' ||
					$value['CHECK5_RO'] =='N' ) {

					for ($i=1; $i < 6; $i++) { 
						if ($value['CHECK'.$i.'_RO'] == 'N') {
							array_push($arrayGakNormal, $arrayNama[($i-1)].' TIDAK SESUAI');
						}
					}

					$GakNormal = implode(',', $arrayGakNormal);
					$new['NO_MESIN_RO'] = ($value['NO_MESIN_RO'] == 'null') ? '' : $value['NO_MESIN_RO'];
					$new['RESOURCE_RO'] = ($value['RESOURCE_RO'] == 'null') ? '<i> (Bukan Resource) <i/>' : $value['RESOURCE_RO'];
					$new = $value;
					$new['KET'] = $GakNormal;
					$new['HASIL'] = 'NOT OK';
					$arrayFilter[] = $new;
				
				}else{
					$new = $value;
					$new['NO_MESIN_RO'] = ($value['NO_MESIN_RO'] == 'null') ? '' : $value['NO_MESIN_RO'];
					$new['RESOURCE_RO'] = ($value['RESOURCE_RO'] == 'null') ? '<i> (Bukan Resource) <i/>' : $value['RESOURCE_RO'];
					$new['HASIL'] = 'OK';
					$new['KET'] = '';
					$arrayFilter[] = $new;
				}

			}
		}

		// echo "<pre>";
		// print_r($getData);
		// // echo count($getData);
		// // echo count($arrayFilter);
		// exit();


		//mulai
            $object = new PHPExcel();
            $object->getProperties()->setCreator("Quick")
                ->setLastModifiedBy("Quick");

            $object->getActiveSheet()->getPageSetup()
                ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
            $object->getActiveSheet()->getPageSetup()
                ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);

            //font style
            $Font10Reg      = array('font'  => array( 'size' => 10,'bold'  => false,'name' => 'Arial'));
            $Font10Bold     = array('font'  => array( 'size' => 10,'bold'  => true,'name' => 'Arial'));

			//align
            $aligncenter = array(
               'alignment' => array(
                  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                  'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, ));
            $alignleft = array(
               'alignment' => array(
                  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                  'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, ));
            $alignright = array(
               'alignment' => array(
                  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                  'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, ));


            //width
            $object->getActiveSheet()->getColumnDimension('A')->setWidth(8);
            $object->getActiveSheet()->getColumnDimension('B')->setWidth(19);
            $object->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $object->getActiveSheet()->getColumnDimension('D')->setWidth(18);
            $object->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('F')->setWidth(25);
            $object->getActiveSheet()->getColumnDimension('G')->setWidth(20);

            //height
            $object->getActiveSheet()->getRowDimension('1')->setRowHeight(12);

            $object->getActiveSheet()->setTitle('Opname Resource');
            $object->setActiveSheetIndex(0);

            //isi
            $row = 1;
	            $object->setActiveSheetIndex(0)
	                    ->setCellValue('A'.$row,'NO')
	                    ->setCellValue('B'.$row,'TAG_NUMBER_RO')
	                    ->setCellValue('C'.$row,'NO_MESIN_RO')
	                    ->setCellValue('D'.$row,'RESOURCE_RO')
	                    ->setCellValue('E'.$row,'COST_CENTER_RO')
	                    ->setCellValue('F'.$row,'RUANG_RO')
	                    ->setCellValue('G'.$row,'KETERANGAN');
	                    $row++;
	            $no =1;
	            foreach ($arrayFilter as $key => $value) {
	            $object->setActiveSheetIndex(0)
		            	->setCellValue('A'.$row,$no++)
	                    ->setCellValue('B'.$row,$value['TAG_NUMBER_RO'])
	                    ->setCellValue('C'.$row,$value['NO_MESIN_RO'])
	                    ->setCellValue('D'.$row,$value['RESOURCE_RO'])
	                    ->setCellValue('E'.$row,"'".$value['COST_CENTER_RO'])
	                    ->setCellValue('F'.$row,$value['RUANG_RO'])
	                    ->setCellValue('G'.$row,$value['KET']);
	            $row++;
	            }
	            $object->getActiveSheet()->getStyle('A1:N1')->applyFromArray($Font10Bold);
	            $object->getActiveSheet()->getStyle('A'.$row.':N'.$row)->applyFromArray($Font10Reg);

            // wraptext dan set print area
            $object->getActiveSheet()->getStyle('A1:E'.$object->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
            // $object->getActiveSheet()->getPageSetup()->setPrintArea('A1:L'.$object->getActiveSheet()->getHighestRow());

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="OpnameResource - .xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
            ob_clean();
            $objWriter->save('php://output');
	}

	private function Pdf($no_doc)
	{
		$this->load->library('Pdf');
			$pdf 				= $this->pdf->load();
			$pdf = new mPDF('utf-8', 'A4', 0, '', 5, 5, 62, 42, 5, 5, 'P');
			// $pdf 				= new mPDF('utf-8','A5-L', 0, '', 2, 2, 18.5, 21, 2, 2);
			$filename			= 'ResourceOpname'.time().'.pdf';
			$getData = $this->M_opnameresource->getData($no_doc);
				$arrayFilter = array();
				$arrayNama = array('NO MESIN','TAG NUMBER', 'RESOURCE CODE','COST CENTER', 'RUANG');
				foreach ($getData as $key => $value) {
					// for ($i=1; $i < 6; $i++) { 
					// 	if ($value['CHECK'.$i.'_RO'] == ) {
					// 		# code...
					// 	}
					// }
					$data['NO_DOCUMENT_RO'] = $value['NO_DOCUMENT_RO'];
					$data['NO_DOCUMENT_RO'] = $value['NO_DOCUMENT_RO'];
					if ($value['CHECK1_RO'] =='' &&
					  	$value['CHECK2_RO'] =='' &&
					    $value['CHECK3_RO'] =='' &&
						$value['CHECK4_RO'] =='' &&
						$value['CHECK5_RO'] =='' ) {
						$new = $value;
						$new['NO_MESIN_RO'] = ($value['NO_MESIN_RO'] == 'null') ? '' : $value['NO_MESIN_RO'];
						$new['RESOURCE_RO'] = ($value['RESOURCE_RO'] == 'null') ? '<i> (Bukan Resource) <i/>' : $value['RESOURCE_RO'];
						$new['KET'] = 'BELUM DIVERIFIKASI';
						$new['HASIL'] = 'NOT OK';
						$arrayFilter[] = $new;
							
					}else{
						$arrayGakNormal =array();
						if ($value['CHECK1_RO'] =='N' ||
						  	$value['CHECK2_RO'] =='N' ||
						    $value['CHECK3_RO'] =='N' ||
							$value['CHECK4_RO'] =='N' ||
							$value['CHECK5_RO'] =='N' ) {

							for ($i=1; $i < 6; $i++) { 
								if ($value['CHECK'.$i.'_RO'] == 'N') {
									array_push($arrayGakNormal, $arrayNama[($i-1)].' TIDAK SESUAI');
								}
							}

							$GakNormal = implode(',', $arrayGakNormal);
							$new['NO_MESIN_RO'] = ($value['NO_MESIN_RO'] == 'null') ? '' : $value['NO_MESIN_RO'];
							$new['RESOURCE_RO'] = ($value['RESOURCE_RO'] == 'null') ? '<i> (Bukan Resource) <i/>' : $value['RESOURCE_RO'];
							$new = $value;
							$new['KET'] = $GakNormal;
							$new['HASIL'] = 'NOT OK';
							$arrayFilter[] = $new;
						
						}else{
							$new = $value;
							$new['NO_MESIN_RO'] = ($value['NO_MESIN_RO'] == 'null') ? '' : $value['NO_MESIN_RO'];
							$new['RESOURCE_RO'] = ($value['RESOURCE_RO'] == 'null') ? '<i> (Bukan Resource) <i/>' : $value['RESOURCE_RO'];
							$new['HASIL'] = 'OK';
							$new['KET'] = '';
							$arrayFilter[] = $new;
						}

					}
				}

			$data['dataFilter'] = $arrayFilter;

			// echo "<pre>";
			// print_r($arrayFilter);
			// exit();

			$head		= array();
			$jobNo		= array();
			$gudang		= array();
			$line		= array();
			$data['dataall'] = $dataall;
			$head = $this->load->view('OpnameResource/MainMenu/TarikData/V_Header', $data, TRUE);
			$line = $this->load->view('OpnameResource/MainMenu/TarikData/V_Body', $data, true);
			$foot = $this->load->view('OpnameResource/MainMenu/TarikData/V_Footer', $data, TRUE);
			$pdf->SetHTMLHeader($head);
			$pdf->SetHTMLFooter($foot);
			$pdf->WriteHTML($line,0);
			$pdf->Output($filename, 'I');
	}
}