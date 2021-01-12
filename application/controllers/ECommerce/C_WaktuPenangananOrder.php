<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class C_WaktuPenangananOrder extends CI_Controller
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
        // $this->load->library('Database');
        
        $this->load->model('M_Index');
        $this->load->model('ECommerce/M_waktupenangananorder');
        $this->load->model('SystemAdministration/MainMenu/M_user');
          
        if($this->session->userdata('logged_in')!=TRUE) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
                  //redirect('');
            $this->session->set_userdata('Responsbility', 'some_value');
        }
          //$this->load->model('CustomerRelationship/M_Index');
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
        $this->load->view('ECommerce/V_WaktuPenangananOrder',$data);
        $this->load->view('V_Footer',$data);
    }

    public function getItemByDate(){
        $this->checkSession();
        $user_id = $this->session->userid;
        //$data['user'] = $usr;
        $data['Menu'] = 'Dashboard';
        $data['SubMenuOne'] = '';
        
        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $dateFrom   = $this->input->post('dateBegin');
        $data['dateFrom'] = $dateFrom;

        $dateTo     = $this->input->post('dateEnd');
        $data['dateTo'] = $dateTo;

        $datenewf = str_replace('/', '-', $dateFrom);  
        $newDateFrom = date("Y-m-d", strtotime($datenewf));

        $datenewt = str_replace('/', '-', $dateTo);  
        $newDateTo = date("Y-m-d", strtotime($datenewt));  

        $search_date = $this->M_waktupenangananorder->getRange($newDateFrom,$newDateTo);

        // echo "<pre>";print_r($search_date);exit();

        $i=0;
        foreach ($search_date as $key => $value) {
          $no_order =  $value['comment_post_id'];

          $dataoracle = $this->M_waktupenangananorder->getDataOracle($no_order);

          if($dataoracle != null){
            $search_date[$i]['SHIPPING_INSTRUCTIONS'] =  $dataoracle[0]['SHIPPING_INSTRUCTIONS'];
            $search_date[$i]['NO_RECEIPT'] =  $dataoracle[0]['NO_RECEIPT'];
            $search_date[$i]['TGL_RECEIPT'] =  $dataoracle[0]['TGL_RECEIPT'];
            $search_date[$i]['NOMOR_SO'] =  $dataoracle[0]['NOMOR_SO'];
            $search_date[$i]['NOMOR_DO'] =  $dataoracle[0]['NOMOR_DO'];
            $search_date[$i]['TGL_DO'] =  $dataoracle[0]['TGL_DO'];
            $search_date[$i]['NOMOR_INVOICE'] =  $dataoracle[0]['NOMOR_INVOICE'];
            $search_date[$i]['TGL_RECEIPT'] =  $dataoracle[0]['TGL_RECEIPT'];
            $search_date[$i]['GUDANG_TRANSACT'] =  $dataoracle[0]['GUDANG_TRANSACT'];
          } else {
            $search_date[$i]['SHIPPING_INSTRUCTIONS'] = " ";
            $search_date[$i]['NO_RECEIPT'] =  " ";
            $search_date[$i]['TGL_RECEIPT'] =  " ";
            $search_date[$i]['NOMOR_SO'] =  " ";
            $search_date[$i]['NOMOR_DO'] =  " ";
            $search_date[$i]['TGL_DO'] =  " ";
            $search_date[$i]['NOMOR_INVOICE'] =  " ";
            $search_date[$i]['TGL_RECEIPT'] =  " ";
            $search_date[$i]['GUDANG_TRANSACT'] =  " ";
          }

          if($value['date_proccess'] != null && $value['date_resi'] != null){
            // echo "<pre>";
            // print_r($value['date_proccess']);
            // print_r($value['date_resi']);
            // exit();
            $coba = str_replace(';', ':', $value['date_resi']);
            $date1 = date_create($value['date_proccess']);
            $date2 = date_create($coba);
            $diff  = date_diff($date1, $date2);
            // echo $diff->format("%d Hari %h Jam %i Menit %s Detik");
            $search_date[$i]['RANGE'] = $diff->format("%d Hari %h Jam %i Menit %s Detik");
          } else {
            $search_date[$i]['RANGE'] = " ";
          }

          $i++;

        }
        // echo "<pre>";print_r($search_date);exit();

        

        $data['search_date'] = $search_date;

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('ECommerce/V_tableDataOrder',$data);
        $this->load->view('V_Footer',$data);
    }

    public function exportExcel(){
        $this->load->library('Excel');

        $dateFrom   = $this->input->post('dateBegin');
        $data['dateFrom'] = $dateFrom;

        $dateTo     = $this->input->post('dateEnd');
        $data['dateTo'] = $dateTo;

        $datenewf = str_replace('/', '-', $dateFrom);  
        $newDateFrom = date("Y-m-d", strtotime($datenewf));

        $datenewt = str_replace('/', '-', $dateTo);  
        $newDateTo = date("Y-m-d", strtotime($datenewt)); 

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

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "Data Waktu Penanganan Proses Order");
        $objPHPExcel->getActiveSheet()->mergeCells('A1:M2');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', "No");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4', "Shipping Instructions");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', "Order Diterima");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D4', "Nomor Receipt");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4', "Tanggal Receipt");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4', "Nomor SO");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4', "Nomor DO");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H4', "Tanggal DO");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I4', "Nomor Invoice");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J4', "Tanggal Invoice");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K4', "Gudang Transact");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L4', "Pengiriman");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M4', "Lama Proses Penanganan Order");

        foreach(range('A','M') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle($columnID.'4')->applyFromArray($style_col);
        }

        foreach(range('A','M') as $columnID) {
            $objPHPExcel->getActiveSheet()->getStyle($columnID)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
        
         $search_date = $this->M_waktupenangananorder->getRange($newDateFrom,$newDateTo);

        // echo "<pre>";print_r($search_date);exit();

        $i=0;
        foreach ($search_date as $key => $value) {
          $no_order =  $value['comment_post_id'];

          $dataoracle = $this->M_waktupenangananorder->getDataOracle($no_order);

          if($dataoracle != null){
            $search_date[$i]['SHIPPING_INSTRUCTIONS'] =  $dataoracle[0]['SHIPPING_INSTRUCTIONS'];
            $search_date[$i]['NO_RECEIPT'] =  $dataoracle[0]['NO_RECEIPT'];
            $search_date[$i]['TGL_RECEIPT'] =  $dataoracle[0]['TGL_RECEIPT'];
            $search_date[$i]['NOMOR_SO'] =  $dataoracle[0]['NOMOR_SO'];
            $search_date[$i]['NOMOR_DO'] =  $dataoracle[0]['NOMOR_DO'];
            $search_date[$i]['TGL_DO'] =  $dataoracle[0]['TGL_DO'];
            $search_date[$i]['NOMOR_INVOICE'] =  $dataoracle[0]['NOMOR_INVOICE'];
            $search_date[$i]['TGL_RECEIPT'] =  $dataoracle[0]['TGL_RECEIPT'];
            $search_date[$i]['GUDANG_TRANSACT'] =  $dataoracle[0]['GUDANG_TRANSACT'];
          } else {
            $search_date[$i]['SHIPPING_INSTRUCTIONS'] = " ";
            $search_date[$i]['NO_RECEIPT'] =  " ";
            $search_date[$i]['TGL_RECEIPT'] =  " ";
            $search_date[$i]['NOMOR_SO'] =  " ";
            $search_date[$i]['NOMOR_DO'] =  " ";
            $search_date[$i]['TGL_DO'] =  " ";
            $search_date[$i]['NOMOR_INVOICE'] =  " ";
            $search_date[$i]['TGL_RECEIPT'] =  " ";
            $search_date[$i]['GUDANG_TRANSACT'] =  " ";
          }

          if($value['date_proccess'] != null && $value['date_resi'] != null){
            // echo "<pre>";
            // print_r($value['date_proccess']);
            // print_r($value['date_resi']);
            // exit();
            $coba = str_replace(';', ':', $value['date_resi']);
            $date1 = date_create($value['date_proccess']);
            $date2 = date_create($coba);
            $diff  = date_diff($date1, $date2);
            // echo $diff->format("%d Hari %h Jam %i Menit %s Detik");
            $search_date[$i]['RANGE'] = $diff->format("%d Hari %h Jam %i Menit %s Detik");
          } else {
            $search_date[$i]['RANGE'] = " ";
          }

          $i++;

        }
        // echo "<pre>";print_r($search_date);exit();

        

        $data['search_date'] = $search_date;

        // echo "<pre>";print_r($search_date);exit();
        
        $no = 1;
        $numrow = 5;
        foreach($search_date as $data){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['SHIPPING_INSTRUCTIONS']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data['date_proccess']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data['NO_RECEIPT']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data['TGL_RECEIPT']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data['NOMOR_SO']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data['NOMOR_DO']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data['TGL_DO']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $data['NOMOR_INVOICE']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $data['TGL_RECEIPT']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $data['GUDANG_TRANSACT']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $data['comment_content2']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $data['RANGE']);
         
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
            $objPHPExcel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);
             
            $no++;
            $numrow++;
        }
        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('Admin Digital E-Commerce');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Data_Waktu_Penanganan_Proses_Order '.$newDateFrom.' to '.$newDateTo.'.xlsx"');
        $objWriter->save("php://output");
    }
}