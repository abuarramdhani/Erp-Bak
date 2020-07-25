<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class C_trackinglppb extends CI_Controller{

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
		$this->load->model('TrackingLppb/M_trackinglppb');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		  
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
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		// $data['vendor_name'] = $this->M_trackinglppb->getVendorName();
		$data['inventory'] = $this->M_trackinglppb->getInventory();
		$data['opsi'] = $this->M_trackinglppb->getOpsiGudang();


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('TrackingLppb/V_searchlppb',$data);
		$this->load->view('V_Footer',$data);
	}

	public function btn_search(){
		// print_r($_POST);
		$nama_vendor = $this->input->post('nama_vendor');
		$nomor_lppb = $this->input->post('nomor_lppb');
		$dateFrom = $this->input->post('dateFrom');
		$dateTo = $this->input->post('dateTo');
		$nomor_po = $this->input->post('nomor_po');
		$inventory = $this->input->post('inventory');
		$opsigdg = $this->input->post('opsigdg');

		$parameter = '';

		// if ($nama_vendor != '' OR $nama_vendor != NULL) {
		// 	if ($parameter=='') {$parameter.='AND (';} else{$parameter.=' AND ';}
		// 	$parameter .= "pov.vendor_name LIKE '%$nama_vendor%'";
		// }

		// if ($nomor_lppb != '' OR $nomor_lppb != NULL) {
		// 	if ($parameter=='') {$parameter.='AND (';} else{$parameter.=' AND ';}
		// 	$parameter .= "rsh.receipt_num LIKE '$nomor_lppb'"; 
		// }

		// if ($dateFrom != '' OR $dateFrom != NULL) {
		// 	if ($parameter=='') {$parameter.='AND (';} else{$parameter.=' AND ';}
		// 	$parameter .= "trunc(klb.create_date) BETWEEN to_date('$dateFrom','dd/mm/yyyy') and to_date('$dateTo', 'dd/mm/yyyy')";
		// }

		// if ($nomor_po != '' OR $nomor_po != NULL) {
		// 	if ($parameter=='') {$parameter.='AND (';} else{$parameter.=' AND ';}
		// 	$parameter .= "poh.segment1 LIKE '$nomor_po'";
		// }

		// if ($inventory != '' OR $inventory != NULL) {
		// 	if ($parameter=='') {$parameter.='AND (';} else{$parameter.=' AND ';}
		// 	$parameter .= "klbd.io_id LIKE '$inventory'";
		// }
		// if ($opsigdg != '' OR $opsigdg != NULL) {
		// 	if ($parameter=='') {$parameter.='AND (';} else{$parameter.=' AND ';}
		// 	$parameter .= "kls.section_id = '$opsigdg'";
		// }

		// if ($parameter!='') {$parameter.=') ';}	

		$tabel = $this->M_trackinglppb->monitoringLppb($nama_vendor,$nomor_lppb,$dateFrom,$dateTo,$nomor_po,$inventory,$opsigdg);	

		$data['lppb'] = $tabel;
		$return = $this->load->view('TrackingLppb/V_table',$data,TRUE);
		
		echo ($return);
	}

	public function detail()
	{
		
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$batch_detail_id = $this->input->post('batch_detail_id');
		$section_id = $this->input->post('section_id');
		$data['lppb'] = $this->M_trackinglppb->detail($batch_detail_id,$section_id);
		// echo "<pre>";print_r($data);
		// $data['historylppb'] = $this->M_trackinglppb->historylppb($batch_number);

		// $this->load->view('V_Header',$data);
		// $this->load->view('V_Sidemenu',$data);
		return $this->load->view('TrackingLppb/V_detail.php',$data);
		// $this->load->view('V_Footer',$data);
	}

	public function exportExcelTrackingLppb()
	{	
		
		$nama_vendor = $this->input->post('nama_vendor');
		$nomor_lppb = $this->input->post('nomor_lppb');
		$dateFrom = $this->input->post('dateFrom');
		$dateTo = $this->input->post('dateTo');
		$nomor_po = $this->input->post('nomor_po');
		$inventory = $this->input->post('inventory');
		$opsigdg = $this->input->post('opsigdg');
		$date = date('d-m-Y H:i:s');

		$parameter = '';

			if ($nama_vendor != '' OR $nama_vendor != NULL) {
				if ($parameter=='') {$parameter.='AND (';} else{$parameter.=' AND ';}
				$parameter .= "pov.vendor_name LIKE '%$nama_vendor%'";
			}

			if ($nomor_lppb != '' OR $nomor_lppb != NULL) {
				if ($parameter=='') {$parameter.='AND (';} else{$parameter.=' AND ';}
				$parameter .= "rsh.receipt_num LIKE '$nomor_lppb'"; 
			}

			if ($dateFrom != '' OR $dateFrom != NULL) {
				if ($parameter=='') {$parameter.='AND (';} else{$parameter.=' AND ';}
				$parameter .= "trunc(klb.create_date) BETWEEN to_date('$dateFrom','dd/mm/yyyy') and to_date('$dateTo', 'dd/mm/yyyy')";
			}

			if ($nomor_po != '' OR $nomor_po != NULL) {
				if ($parameter=='') {$parameter.='AND (';} else{$parameter.=' AND ';}
				$parameter .= "poh.segment1 LIKE '$nomor_po'";
			}

			if ($inventory != '' OR $inventory != NULL) {
				if ($parameter=='') {$parameter.='AND (';} else{$parameter.=' AND ';}
				$parameter .= "klbd.io_id LIKE '$inventory'";
			}
			if ($opsigdg != '' OR $opsigdg != NULL) {
				if ($parameter=='') {$parameter.='AND (';} else{$parameter.=' AND ';}
				$parameter .= "kls.section_id = '$opsigdg'";
			}

			if ($parameter!='') {$parameter.=') ';}	

		$this->load->library('Excel');

		$objPHPExcel = new PHPExcel();
		$style_col = array(
          'font' => array('bold' => true),
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
          )
        );

        $style_row = array(
          'alignment' => array(
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
          )
        );

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REPORT TRACKING LPPB");
        $objPHPExcel->getActiveSheet()->mergeCells('A1:J2');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "Date : ".$dateTarikFrom.' s/d '.$dateTarikTo);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', "No");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4', "Gudang");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', "Invetory Organization");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D4', "No. LPPB");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4', "Nama Vendor");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4', "Tanggal LPPB");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4', "No. PO");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H4', "Batch Number");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I4', "Gudang Input");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J4', "Gudang Kirim");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K4', "Akuntansi Terima");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L4', "Status Detail");

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(2);
        $objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);

        foreach(range('B','L') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle($columnID.'4')->applyFromArray($style_col);
        }

        foreach(range('A','J') as $columnID) {
            $objPHPExcel->getActiveSheet()->getStyle($columnID)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }

        $fetch = $this->M_trackinglppb->monitoringLppb($parameter);

        $no = 1;
        $numrow = 5;
        foreach($fetch as $data){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['SECTION_NAME']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data['ORGANIZATION_CODE']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data['LPPB_NUMBER']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data['VENDOR_NAME']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data['CREATE_DATE']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data['PO_NUMBER']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data['SOURCE']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $data['CREATE_DATE']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $data['GUDANG_KIRIM']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $data['AKUNTANSI_TERIMA']);
           	if ($data['STATUS'] == 0) {
				$status = "New/Draf";
			}elseif ($data['STATUS'] == 1) {
				$status = "Admin Edit";
			}elseif ($data['STATUS'] == 2) {
				$status = "Submitted to Kasie Gudang";
			}elseif ($data['STATUS'] == 3) {
				$status = "Approved by Kasie Gudang";
			}elseif ($data['STATUS'] == 4) {
				$status = "Rejected by Kasie Gudang";
			}elseif ($data['STATUS'] == 5) {
				$status = "Submitted to Akuntansi";
			}elseif ($data['STATUS'] == 6) {
				$status = "Approved by Akuntansi";
			}elseif ($data['STATUS'] == 7) {
				$status = "Rejected by Akuntansi";
			} 
            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $status);
            
            $objPHPExcel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
            
            $no++;
            $numrow++;
        }

        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);

		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle('Report Tracking LPPB');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Report_Tracking_Invoice '.$date.'.xlsx"');
		$objWriter->save("php://output");

	}

	public function searchVendor()
	{
		$namaVendor = $_GET['q'];

		$data = $this->M_trackinglppb->searchVendor(strtoupper($namaVendor));

		echo json_encode($data);
	}
	

}