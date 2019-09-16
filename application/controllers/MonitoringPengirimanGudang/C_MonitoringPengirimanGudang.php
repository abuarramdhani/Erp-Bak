<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class C_MonitoringPengirimanGudang extends CI_Controller{
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
		$this->load->model('MonitoringPengirimanGudang/M_monitoringpengirimangudang');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		date_default_timezone_set('Asia/Jakarta');
		  
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
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function dashboard_gd()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
	
		$data_kirim = $this->M_monitoringpengirimangudang->SelectDashboard();
		$data['kirim'] = $data_kirim;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPengirimanGudang/V_dashboard_gd',$data);
		$this->load->view('V_Footer',$data);
	}

// fitur search MPM------------------------------------------------------------------------
	public function findShipment_gd()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPengirimanGudang/V_findShipment_gd',$data);
		$this->load->view('V_Footer',$data);
	}

	public function btn_search_gd()
	{

		// print_r($_POST);exit();
		$no_ship = $this->input->post('no_ship');

		$query = '';
		if ($no_ship !=  '' or $no_ship != null) {
			$query .= "where osh.shipment_header_id = '$no_ship'";
		}else{
			$query .= "";
		}

		$getFind = $this->M_monitoringpengirimangudang->FindShipment($query);
		$data['find'] = $getFind;

		$return = $this->load->view('MonitoringPengirimanGudang/V_findTable_gd',$data);
		
	}

	public function btn_edit_gd()
	{
		$no_ship = $this->input->post('no_ship');
		$query = '';
		if ($no_ship !=  '' or $no_ship != null) {
			$query .= "where osh.shipment_header_id = '$no_ship'";
		}else{
			$query .= "";
		}
		$getHeader = $this->M_monitoringpengirimangudang->FindShipment($query);
		$getLine = $this->M_monitoringpengirimangudang->editMPM($no_ship);
		$getProv = $this->M_monitoringpengirimangudang->getProvince();
		$getFinGo = $this->M_monitoringpengirimangudang->getFinishGood();
		// $getCity = $this->M_monitoringpengirimangudang->getCity();
		$jk = $this->M_monitoringpengirimangudang->getJK();
		$getTipe = $this->M_monitoringpengirimangudang->getUom();
		$getUnit = $this->M_monitoringpengirimangudang->getUnit();
		$content_id = $this->M_monitoringpengirimangudang->getContentId();
		$time = $this->M_monitoringpengirimangudang->timegudang($no_ship);
		$cabang = $this->M_monitoringpengirimangudang->getCabang();

		$data['cabang'] = $cabang;
		$data['time'] = $time;
		$data['unit'] = $getUnit;
		$data['uom'] = $getTipe;
		$data['content'] = $content_id;
		$data['fingo'] = $getFinGo;
		$data['kendaraan'] = $jk;
		$data['line'] = $getLine;
		$data['header'] = $getHeader;
		$data['prov'] = $getProv;


		$return = $this->load->view('MonitoringPengirimanGudang/V_findEdit_gd',$data);

	}

	public function saveEditMPMgd()
	{
		// print_r($_POST);
		$no_ship = $this->input->post('no_ship');
		$actual_loading = $this->input->post('actual_loading');
		$status = $this->input->post('statusgudang');

		// if (empty($status)) {
		// 	echo "<script> Swal.fire({
  // 									type: 'error',
  // 									title: 'Perhatian!',
 	// 								text: 'Harap lengkapi data',
		// 							}) </script>";
		// }
		
         // update header
        $insertActual = $this->M_monitoringpengirimangudang->insertActualTime($no_ship,$actual_loading, $status);

	}


	public function getRow() {
		$getTipe = $this->M_monitoringpengirimangudang->getUom();
		$getUnit = $this->M_monitoringpengirimangudang->getUnit();
		$content_id = $this->M_monitoringpengirimangudang->getContentId();

		$data['content_id'] = $content_id;
		$data['unit'] = $getUnit;
		$data['uom'] = $getTipe;

		echo json_encode($data);
	}

	public function shipment_history_gd()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$history = $this->M_monitoringpengirimangudang->history();
		$data['find'] = $history;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPengirimanGudang/V_findHistory_gd',$data);
		$this->load->view('V_Footer',$data);

	}

	public function export_gd()
{	
		
		$date = date('d-m-Y');
		
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
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REPORT SHIPMENT MARKETING");
        $objPHPExcel->getActiveSheet()->mergeCells('A1:J2');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "Date : ".$dateTarikFrom.' s/d '.$dateTarikTo);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', "No");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4', "No Shipment");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', "Jenis Kendaraan");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D4', "Estimasi Berangkat");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4', "Estimasi Loading");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4', "Actual Loading");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4', "Finish Good");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H4', "Cabang Tujuan");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I4', "Muatan");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J4', "Status Full");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K4', "Creation Date");
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(2);
        $objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
        foreach(range('B','K') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle($columnID.'4')->applyFromArray($style_col);
        }
        foreach(range('A','J') as $columnID) {
            $objPHPExcel->getActiveSheet()->getStyle($columnID)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
        $fetch = $this->M_monitoringpengirimangudang->history();
        $no = 1;
        $numrow = 5;
        foreach($fetch as $data){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['no_shipment']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data['jenis_kendaraan']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data['berangkat']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data['loading']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data['act_loading']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data['asal_gudang']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data['cabang']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $data['muatan']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $data['status']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $data['creation_date']);
            
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
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle('Report Shipment Marketing');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Report_Shipment_Marketing_Tanggal '.$date.'.xlsx"');
		ob_end_clean();
		ob_start();
		$objWriter->save('php://output');

}


}
?>