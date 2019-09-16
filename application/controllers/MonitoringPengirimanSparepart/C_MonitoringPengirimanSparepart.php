<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class C_MonitoringPengirimanSparepart extends CI_Controller{
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
		$this->load->model('MonitoringPengirimanSparepart/M_monitoringpengirimansparepart');
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

	public function dashboard_sp()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
	
		$data_kirim = $this->M_monitoringpengirimansparepart->SelectDashboard();
		$data['kirim'] = $data_kirim;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPengirimanSparepart/V_dashboard_sp',$data);
		$this->load->view('V_Footer',$data);
	}

// fitur search MPM------------------------------------------------------------------------
	public function findShipment_sp()
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
		$this->load->view('MonitoringPengirimanSparepart/V_findShipment_sp',$data);
		$this->load->view('V_Footer',$data);
	}

	public function btn_search_sp()
	{

		// print_r($_POST);exit();
		$no_ship = $this->input->post('no_ship');

		$query = '';
		if ($no_ship !=  '' or $no_ship != null) {
			$query .= "where osh.shipment_header_id = '$no_ship'";
		}else{
			$query .= "";
		}

		$getFind = $this->M_monitoringpengirimansparepart->FindShipment($query);
		$data['find'] = $getFind;

		$return = $this->load->view('MonitoringPengirimanSparepart/V_findTable_sp',$data);
		
	}

	public function btn_edit_sp()
	{
		$no_ship = $this->input->post('no_ship');
		$query = '';
		if ($no_ship !=  '' or $no_ship != null) {
			$query .= "where osh.shipment_header_id = '$no_ship'";
		}else{
			$query .= "";
		}
		$getHeader = $this->M_monitoringpengirimansparepart->FindShipment($query);
		$getLine = $this->M_monitoringpengirimansparepart->editMPM($no_ship);
		$getCabang = $this->M_monitoringpengirimansparepart->getCabang();
		$getFinGo = $this->M_monitoringpengirimansparepart->getFinishGood();
		$jk = $this->M_monitoringpengirimansparepart->getJK();
		$getTipe = $this->M_monitoringpengirimansparepart->getUom();
		$content_id = $this->M_monitoringpengirimansparepart->getContentId();
		$getUnit = $this->M_monitoringpengirimansparepart->getUnit();

		$data['unit'] = $getUnit;
		$data['uom'] = $getTipe;
		$data['content'] = $content_id;
		$data['fingo'] = $getFinGo;
		$data['cabang'] = $getCabang;
		$data['kendaraan'] = $jk;
		$data['line'] = $getLine;
		$data['header'] = $getHeader;

		// echo "<pre>";print_r($data);exit();

		$return = $this->load->view('MonitoringPengirimanSparepart/V_findEdit_sp',$data);

	}
	public function getRowsp() {
		$getTipe = $this->M_monitoringpengirimansparepart->getUom();
		$getUnit = $this->M_monitoringpengirimansparepart->getUnitSp();
		$content_id = $this->M_monitoringpengirimansparepart->getSparepart();

		$data['content_id'] = $content_id;
		$data['unit'] = $getUnit;
		$data['uom'] = $getTipe;

		echo json_encode($data);
	}

	public function saveEditMPMsp()
	{
		$no_ship = $this->input->post('no_ship');
		$usrname = $this->session->user;
		$estimasi = $this->input->post('estimasi');
		$estimasi_loading = $this->input->post('estimasi_loading');
		$finish_good = $this->input->post('finish_good');
		$status = $this->input->post('status');
		$kendaraan = $this->input->post('jk');
		$unit = $this->input->post('unit'); //sparepart 
		$jumlah = $this->input->post('jumlah');
		$tipe = $this->input->post('tipe');
		$content = $this->input->post('content');
		$cabang = $this->input->post('cabang');
		
         // update header
        $updateMPM1 = $this->M_monitoringpengirimansparepart->updateMPM($estimasi,$estimasi_loading,$finish_good,$status,$cabang,$kendaraan,$usrname,$no_ship);
        // update line
        $deleteLine = $this->M_monitoringpengirimansparepart->deleteMPM($no_ship);
        
        foreach ($content as $key => $value) {
		$updateMPM2 = $this->M_monitoringpengirimansparepart->UpdatebyInsertMPM($no_ship,$value,$jumlah[$key],$tipe[$key],$unit[$key],$usrname);
		}

	}

	public function shipment_history_sp()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$history = $this->M_monitoringpengirimansparepart->history();
		$data['find'] = $history;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringPengirimanSparepart/V_findHistory_sp',$data);
		$this->load->view('V_Footer',$data);

	}

	public function export_sp()
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
        $fetch = $this->M_monitoringpengirimansparepart->history();
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