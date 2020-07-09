<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Lppb extends CI_Controller {

   function __construct() {
        parent::__construct();
		$this->load->helper('form');
	    $this->load->helper('url');
	    $this->load->helper('html');
		$this->load->helper('download');
	    $this->load->library('form_validation');
		$this->load->library('Excel');
	    //load the login model
		$this->load->library('session');
		$this->load->library('csvimport');
		//$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('AccountPayables/M_lppb');

			  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			//redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
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
		$data['supplier'] = $this->M_lppb->getSupplier();
		$data['inventory'] = $this->M_lppb->getInventory();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AccountPayables/Lppb/V_Index',$data);
		$this->load->view('V_Footer',$data);
		
	}	

	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect();
		}
	}

	public function search()
	{
		
		$this->checkSession();
		$user_id = $this->session->userid;
		//$data['user'] = $usr;
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['supplier'] = $this->M_lppb->getSupplier();
		$data['inventory'] = $this->M_lppb->getInventory();

		$data['sup'] = $this->input->post('slcSupplier');
		$data['date'] = $this->input->post('txtReceiptDate');
		$invArray = $this->input->post('slcInventory[]');
		$data['po_num'] = $this->input->post('txtPonum');

		if ($invArray != '' || $invArray != NULL) {
			$data['inven'] = implode(", ", $invArray);
		}else{
			$data['inven'] = '';
		}
		
		
		list($tglawal,$tglakhir) = explode('-', $data['date']);

		if ($data['sup'] == '' || $data['sup'] == NULL) {
			$sqlSupplier = '';
		} else {
			$sqlSupplier = 'AND POV.VENDOR_ID = '.$data['sup'];
		};

		if ($data['inven'] == '' || $data['inven'] == NULL) {
			$sqlInventory = "AND ((MP.ORGANIZATION_ID IN (101, 102, 124, 122, 286)) OR (MP.ORGANIZATION_CODE LIKE 'Y%'))";
		} else {
			$sqlInventory = "AND MP.ORGANIZATION_ID IN (".$data['inven'].")";
		};

		if ($data['po_num'] == '' || $data['po_num'] == NULL) {
			$sqlPo = '';
		} else {
			$sqlPo = 'AND POH.SEGMENT1 = '.$data['po_num'];
		};

		$sortTerima = 'ORDER BY TERIMA';
		
		$data['lppb'] = $this->M_lppb->getLppbdata($tglawal, $tglakhir, $sqlSupplier, $sqlInventory, $sqlPo, $sortTerima);
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AccountPayables/Lppb/V_Search',$data);
		$this->load->view('V_Footer',$data);
		
	}

	public function export()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$tglReceipt = $this->input->post('hdnTanggalrange');

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("ICT")->setTitle("checklppb");

		$objset = $objPHPExcel->setActiveSheetIndex(0);
		$objget = $objPHPExcel->getActiveSheet();
		$objget->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$objget->setTitle('checklppb');
		$objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
		$objset->setCellValue("A1", "Tgl. Receipt : ".$tglReceipt);
		$objPHPExcel->getActiveSheet()->mergeCells('A2:I2');
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$objget->getStyle("A2")->applyFromArray(
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				),
				'font' => array(
					'color' => array('rgb' => '000000'),
					'bold'  => true,
				)
			)
		);
		$objset->setCellValue("A2", 'KHS LPPB Belum Bayar');

		$objget->getStyle("A3:I3")->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '949494')
				),
				'font' => array(
					'color' => array('rgb' => '000000'),
					'bold'  => true,
					'size'	=> '11px',
				)
			)
		);

		$cols = array("A", "B", "C", "D", "E", "F", "G", "H", "I");
		$val = array("NO", "VENDOR NAME", "INVENTORY", "RECEIPT NO", "RECEIPT DATE", "PO NUMBER", "TERMS PO", "TERIMA", "TGL TERIMA");

		for ($a=0;$a<9; $a++) {
			$objset->setCellValue($cols[$a].'3', $val[$a]);
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(3);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(33);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(13);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				),
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				)
			);
			$objPHPExcel->getActiveSheet()->getStyle($cols[$a].'3')->applyFromArray($style);
		}

		$baris  = 4;
		$no = 0;
		$lNumber = $this->input->post('lastNum');
		for ($x = 1; $x <= $lNumber; $x++) {
			$no++;
			$vendor = $this->input->post('hdnVendor'.$no);
			$inventory = $this->input->post('hdnInven'.$no);
			$receipt_num = $this->input->post('hdnReceiptn'.$no);
			$receipt_date = $this->input->post('hdnReceiptd'.$no);
			$po_num = $this->input->post('hdnPonum'.$no);
			$terms_po = $this->input->post('hdnTerm'.$no);
			$terima = $this->input->post('chkTerima'.$no);
			$tangterima = $this->input->post('hdnTerimadate'.$no);
			if ($tangterima == '') {
				if ($terima == 'YA') {
					$tgl_terima = date('d/M/Y');
				}else{
					$tgl_terima = '';
				};
			}else{
				if ($terima == 'YA') {
					$tgl_terima = $tangterima;
				}else{
					$tgl_terima = '';
				};
			};
			$this->M_lppb->addTerima($vendor, $inventory, $receipt_num, $receipt_date, $po_num, $terms_po, $terima, $tgl_terima);
			$objset->setCellValue("A".$baris, $no);
			$objset->setCellValue("B".$baris, $vendor);
			$objset->setCellValue("C".$baris, $inventory);
			$objset->setCellValue("D".$baris, $receipt_num);
			$objset->setCellValue("E".$baris, $receipt_date);
			$objset->setCellValue("F".$baris, $po_num);
			$objset->setCellValue("G".$baris, $terms_po);
			$objset->setCellValue("H".$baris, $terima);
			$objset->setCellValue("I".$baris, $tgl_terima);
			$border = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				),
				'font' => array(
					'size'  => '10px',
				)
			);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$baris.':I'.$baris)->applyFromArray($border);
			$baris++;
		}

		$objPHPExcel->getActiveSheet()->setTitle('checklppb');
		$objPHPExcel->setActiveSheetIndex(0);

		$filename = "checklppb.xls";

		header("Content-Type: application/vnd.ms-excel");   
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save('php://output');
	}

	public function savelppb()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$no = 0;
		$lNumber = $this->input->post('lastNum');
		for ($x = 1; $x <= $lNumber; $x++) {
			$no++;
			$vendor = $this->input->post('hdnVendor'.$no);
			$inventory = $this->input->post('hdnInven'.$no);
			$receipt_num = $this->input->post('hdnReceiptn'.$no);
			$receipt_date = $this->input->post('hdnReceiptd'.$no);
			$po_num = $this->input->post('hdnPonum'.$no);
			$terms_po = $this->input->post('hdnTerm'.$no);
			$terima = $this->input->post('chkTerima'.$no);
			$tangterima = $this->input->post('hdnTerimadate'.$no);
			if ($tangterima == '') {
				if ($terima == 'YA') {
					$tgl_terima = date('d/M/Y');
				}else{
					$tgl_terima = '';
				};
			}else{
				if ($terima == 'YA') {
					$tgl_terima = $tangterima;
				}else{
					$tgl_terima = '';
				};
			};
			$this->M_lppb->addTerima($vendor, $inventory, $receipt_num, $receipt_date, $po_num, $terms_po, $terima, $tgl_terima);
		}
	}

// FOR TESTING PURPOSE ONLY[start]
	public function testChamber()
	{	
		$receipt = '3157';
		$po = '17006590';
		$query = $this->M_lppb->countAPLPPB($receipt, $po);
		print_r($query);
	}
// FOR TESTING PURPOSE ONLY[end]

}