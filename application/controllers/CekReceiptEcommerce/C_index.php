<?php

class C_index extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('CekReceiptEcommerce/M_index');
        $this->load->library('form_validation');

        if ($this->session->userdata('logged_in') != TRUE) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
        }

        date_default_timezone_set("Asia/Bangkok");
    }

    public function index()
    {
        $this->checkSession();

        $user_id = $this->session->userid;
        $user = $this->session->userdata('user');

        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

        $data['receipt'] = $this->M_index->getData();

        $this->load->view('V_Header', $data);
        $this->load->view('V_Sidemenu', $data);
        $this->load->view('CekReceiptEcommerce/V_index', $data);
        $this->load->view('V_Footer', $data);
    }

    public function exportExcel()
    {
        $this->checkSession();
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

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "Cek Receipt E-Commerce");
        $objPHPExcel->getActiveSheet()->mergeCells('A1:K2');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', "No");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4', "Customer Number");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', "Customer Name");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D4', "Receipt Number");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4', "Receipt Date");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4', "Amount");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4', "Status");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H4', "Applied Amount");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I4', "Unapplied Ammount");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J4', "Receipt Method");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K4', "Comment");

        foreach(range('A','K') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle($columnID.'4')->applyFromArray($style_col);
        }

        $receipt = $this->M_index->getData();
        $data['receipt'] = $receipt;

        $no = 1;
        $numrow = 5;
        foreach($receipt as $data){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['CUSTOMER_NUMBER']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data['NAMA_CUSTOMER']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data['RECEIPT_NUMBER']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data['RECEIPT_DATE']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data['AMOUNT']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data['STATUS']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data['APPLIED_AMOUNT']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $data['UNAPPLIED_AMOUNT']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $data['RECEIPT_METHOD']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $data['COMMENTS']);
         
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
             
            $no++;
            $numrow++;
        }
        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);

        $objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle('Cek Receipt E-Commerce');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Daftar-Receipt-E-Commerce.xlsx"');
		$objWriter->save("php://output");
    }

    public function checkSession()
    {
        if ($this->session->is_logged) { } else {
            redirect();
        }
    }
}
