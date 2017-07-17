<?php
class C_Report extends CI_Controller {
    public function __construct()
    {
            parent::__construct();
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('AccountPayables/Report/M_report');
			$this->load->helper('form');
			$this->load->library('form_validation');
			$this->load->library('session');
			$this->load->helper('url');
			$this->load->library('Excel');
			$this->checkSession();
    }

	public function checkSession()
	{
		if($this->session->is_logged){

		}else{
			redirect('index');
		}
	}

	public function reportInvoiceFaktur()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['title'] = 'Report Invoice Tanpa Faktur';
		$data['Menu'] = 'Invoice';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('AccountPayables/Report/ReportInvoiceTanpaFaktur/V_report_invoice_tanpa_faktur', $data);
		$this->load->view('V_Footer',$data);
	}

	public function exportInvoiceFaktur()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$startDate = $this->input->post('tanggal_awal', true);
		$endDate = $this->input->post('tanggal_akhir', true);
		$status = $this->input->post('invoice_status', true);
		$vendor = $this->input->post('supplier', true);

		$dataInvoice = $this->M_report->getInvoiceFaktur($startDate, $endDate, $vendor, $status);

		if($vendor == '') $vendor = 'All';
		if($status == 1){
			$attribute = 'All';
		} else if($status == 2){
			$attribute = 'Dengan';
		} else if($status == 3){
			$attribute = 'Tanpa';
		}

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("ICT")->setTitle("Invoice Tanpa Faktur");

		$objset = $objPHPExcel->setActiveSheetIndex(0);
		$objget = $objPHPExcel->getActiveSheet();
		$objget->setTitle('Invoice Tanpa Faktur');
		$objget->getStyle("A1:H1")->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '949494')
				),
				'font' => array(
					'color' => array('rgb' => '000000'),
					'bold'  => true,
				)
			)
		);

		$cols = array("A", "B", "C", "D", "E", "F", "G", "H");
		$val = array("Vendor Name", "Invoice Type", "Invoice Date", "Invoice Number", "Payment Date", "DPP", "PPN", "Total");

		for ($a=0;$a<8; $a++) {
			$objset->setCellValue($cols[$a].'1', $val[$a]);
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(45);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(37);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(13);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(13);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(13);
			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);
			$objPHPExcel->getActiveSheet()->getStyle($cols[$a].'1')->applyFromArray($style);
		}

		$baris  = 2;
		foreach ($dataInvoice as $frow) {
			$objset->setCellValue("A".$baris, $frow['VENDOR_NAME']);
			$objset->setCellValue("B".$baris, $frow['TYPE_INVOICE']);
			$objset->setCellValue("C".$baris, $frow['INVOICE_DATE']);
			$objset->setCellValue("D".$baris, $frow['INVOICE_NUM']);
			$objset->setCellValue("E".$baris, $frow['PAYMENT_DATE']);
			$objset->setCellValue("F".$baris, $frow['DPP']);
			$objset->setCellValue("G".$baris, $frow['PPN']);
			$objset->setCellValue("H".$baris, $frow['TOTAL']);
			$baris++;
		}

		$objPHPExcel->getActiveSheet()->setTitle('Invoice Tanpa Faktur');
		$objPHPExcel->setActiveSheetIndex(0);

		$filename = "Invoice_".$attribute."_Faktur_".$startDate."_".$endDate."_".$vendor.".xls";

		header("Content-Type: application/vnd.ms-excel");   
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save('php://output');
	}
}
?>