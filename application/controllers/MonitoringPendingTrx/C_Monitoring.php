<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Monitoring extends CI_Controller {
    public function __construct(){
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');

        //load the login model
        $this->load->library('session');
        $this->load->model('M_Index');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('MonitoringPendingTrx/M_monpentrx');
            
        $this->checkSession();
    }

    public function checkSession(){
        if($this->session->is_logged){      
        
        }else{
            redirect();
        }
    }

    public function Index(){
        $user = $this->session->username;
        $user_id = $this->session->userid;

        $data['Title'] = 'Monitoring Pending Transactions';
        $data['Menu'] = 'Monitoring';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('MonitoringPendingTrx/V_Monitoring');
        $this->load->view('V_Footer',$data);
    }

    public function getSubinv(){
        $term = $this->input->get('term',TRUE);
        $term = strtoupper($term);
        $user = $this->session->user;
        $data = $this->M_monpentrx->getSubinv($term,$user);
        echo json_encode($data);
    }

    public function getLocator(){
        $term = $this->input->get('term',TRUE);
        $term = strtoupper($term);
        $subinv = $this->input->get('subinv',TRUE);
        $data = $this->M_monpentrx->getLocator($term,$subinv);
        echo json_encode($data);
    }

    public function checkLocator(){
        $subinv = $this->input->post('subinv');
        $data['loc'] = $this->M_monpentrx->checkLocator($subinv);
    }

    public function getDataMonitoring(){
        $subinv = $this->input->post('subinv');
        $loc = $this->input->post('loc');
        $loc2 = $this->input->post('loc2');

        $data['mon'] = $this->M_monpentrx->getDataMonitoring($subinv,$loc);
        $data['subinv'] = $subinv;
        $data['loc2'] = $loc2;

        $this->load->view('MonitoringPendingTrx/V_TblMonitoring', $data);
    }

    public function getDetailMonitoring(){
        $req = $this->input->post('req');

        $data['detail'] = $this->M_monpentrx->getDetailMonitoring($req);

        $this->load->view('MonitoringPendingTrx/V_TblDetail', $data);
    }

    public function getDataPersen(){
        $subinv = $this->input->post('subinv');
        $loc = $this->input->post('loc');
        $loc2 = $this->input->post('loc2');

        $data['dari'] = $this->M_monpentrx->getRekapDari($subinv,$loc);
        $data['ke'] = $this->M_monpentrx->getRekapKe($subinv,$loc);
        $data['subinv'] = $subinv;
        $data['loc2'] = $loc2;

        $this->load->view('MonitoringPendingTrx/V_PercentageBar', $data);
    }

    public function exportData(){
        $from_subinv = $this->input->post('expFSubinv');
        $to_subinv = $this->input->post('expTSubinv');
        $to_loc = $this->input->post('expLSubinv');

        $data = $this->M_monpentrx->exportData($from_subinv,$to_subinv,$to_loc);

        include APPPATH.'third_party/Excel/PHPExcel.php';

        $excel = new PHPExcel();
        $excel->getProperties()->setCreator('CV. Karya Hidup Sentosa')
                    ->setLastModifiedBy('Quick ERP')
                    ->setTitle("Monitoring Pending Transactions")
                    ->setSubject("CV. Karya Hidup Sentosa")
                    ->setDescription("Monitoring Pending Transactions")
                    ->setKeywords("MPT");
        
        $style_title = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font' => array(
                'bold' => true,
                'size' => 20
            )
        );

        $style1 = array(
            'font' => array(
                'bold' => true,
                'wrap' => true,
            ), 
            'alignment' => array(
                'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );

        $style2 = array(
            'alignment' => array(
                'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'left' => array(
                'style'  => PHPExcel_Style_Border::BORDER_THIN
            )            
        );

        //TITLE
        $excel->setActiveSheetIndex(0)->setCellValue('A1', "MONITORING PENDING TRANSACTIONS");
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "FROM SUBINVENTORY");
        $excel->setActiveSheetIndex(0)->setCellValue('E3', "TO SUBINVENTORY");
        $excel->setActiveSheetIndex(0)->setCellValue('E4', "TO LOCATOR");
        $excel->setActiveSheetIndex(0)->setCellValue('C3', $from_subinv);
        $excel->setActiveSheetIndex(0)->setCellValue('F3', $to_subinv);
        $excel->setActiveSheetIndex(0)->setCellValue('F4', $to_loc);
        $excel->getActiveSheet()->mergeCells('A1:K1'); 
        $excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_title);
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style1);
        $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style1);
        $excel->getActiveSheet()->getStyle('E4')->applyFromArray($style1);

        $excel->setActiveSheetIndex(0)->setCellValue('A6', "NO.");
        $excel->setActiveSheetIndex(0)->setCellValue('B6', "DOCUMENT NUMBER");
        $excel->setActiveSheetIndex(0)->setCellValue('C6', "FROM LOCATOR");
        $excel->setActiveSheetIndex(0)->setCellValue('D6', "TO ORG");
        $excel->setActiveSheetIndex(0)->setCellValue('E6', "ITEM CODE");
        $excel->setActiveSheetIndex(0)->setCellValue('F6', "DESCRIPTION");
        $excel->setActiveSheetIndex(0)->setCellValue('G6', "QUANTITY");
        $excel->setActiveSheetIndex(0)->setCellValue('H6', "QUANTITY ALLOCATED");
        $excel->setActiveSheetIndex(0)->setCellValue('I6', "QUANTITY TRANSACT");
        $excel->setActiveSheetIndex(0)->setCellValue('J6', "UOM");
        $excel->setActiveSheetIndex(0)->setCellValue('K6', "JENIS");
        $excel->getActiveSheet()->getStyle('A6')->applyFromArray($style1);
        $excel->getActiveSheet()->getStyle('B6')->applyFromArray($style1);
        $excel->getActiveSheet()->getStyle('C6')->applyFromArray($style1);
        $excel->getActiveSheet()->getStyle('D6')->applyFromArray($style1);
        $excel->getActiveSheet()->getStyle('E6')->applyFromArray($style1);
        $excel->getActiveSheet()->getStyle('F6')->applyFromArray($style1);
        $excel->getActiveSheet()->getStyle('G6')->applyFromArray($style1);
        $excel->getActiveSheet()->getStyle('H6')->applyFromArray($style1);
        $excel->getActiveSheet()->getStyle('I6')->applyFromArray($style1);
        $excel->getActiveSheet()->getStyle('J6')->applyFromArray($style1);
        $excel->getActiveSheet()->getStyle('K6')->applyFromArray($style1);

        $no=1;
        $numrow = 7;
        foreach ($data as $val) {
            // echo "<pre>";print_r($val['ITEM']);exit();
            $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $val['REQUEST_NUMBER']);
            $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $val['FROM_LOCATOR']);
            $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $val['TO_ORGANIZATION']);
            $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $val['ITEM_CODE']);
            $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $val['DESCRIPTION']);
            $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $val['QUANTITY']);
            $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $val['QUANTITY_DETAILED']);
            $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $val['QUANTITY_DELIVERED']);
            $excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $val['UOM_CODE']);
            $excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $val['JENIS']);
            $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style2);
            $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style2);
            $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style2);
            $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style2);
            $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style2);
            $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style2);
            $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style2);
            $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style2);
            $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style2);
            $excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style2);
            $excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style2);
        $numrow++;
        $no++; 
        }
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(25); 
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(15); 
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(70);
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(5);
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(5);
        $excel->getActiveSheet()->getColumnDimension('I')->setWidth(5);
        $excel->getActiveSheet()->getColumnDimension('J')->setWidth(5);
        $excel->getActiveSheet()->getColumnDimension('K')->setWidth(5);
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Monitoring Pending Transactions");
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Monitoring Pending Transactions.xlsx"'); 
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }
}
?>