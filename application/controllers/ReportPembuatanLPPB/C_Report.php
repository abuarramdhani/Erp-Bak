<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Report extends CI_Controller {
    public function __construct(){
		parent::__construct();
	
        $this->load->helper('form');
        $this->load->helper('url');
		$this->load->helper('html');
        $this->load->library('form_validation');
        
        $this->load->library('session');
        $this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('ReportPembuatanLPPB/M_lppb');
        
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
    
    public function index(){
		$this->checkSession();
		$user_id = $this->session->userid;
		$user = $this->session->user;
		
		$data['Menu'] = 'Report';
		$data['SubMenuOne'] = '';
		$data['Title'] = 'Report Pembuatan LPPB';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ReportPembuatanLPPB/V_Report', $data);
		$this->load->view('V_Footer',$data);
    }
    
    public function getDataLppb(){
        $tanggal = $this->input->post('tanggal');
        $lokasi = $this->input->post('lokasi');
        $io = $this->input->post('io');

        $data['tanggal'] = $tanggal;
        $data['lokasi'] = $lokasi;
        if($io != 'ALL'){		
            $org_code = $this->M_lppb->getOrgCode($io);
            $data['io'] = $org_code[0]['ORGANIZATION_CODE'];
		}else{
			$data['io'] = $io;
		}

        $data['lppb'] = $this->M_lppb->getDataLppb($tanggal,$lokasi,$io);
        // print_r($data['lppb']); exit();

        $this->load->view('ReportPembuatanLPPB/V_TblLppb', $data);
    }

    public function exportDataRPL(){
        $tanggal = $this->input->post('tanggal[]');
        $lokasi = $this->input->post('lokasi[]');
        $io = $this->input->post('io[]');
        $shipment_line_id = $this->input->post('shipment_line_id[]');
        $org_code = $this->input->post('org_code[]');
        $no_lppb = $this->input->post('no_lppb[]');
        $kode_item = $this->input->post('kode_item[]');
        $item = $this->input->post('item[]');
        $tgl_shipment = $this->input->post('tgl_shipment[]');
        $tgl_receive = $this->input->post('tgl_receive[]');
        $tgl_transfer = $this->input->post('tgl_transfer[]');
        $tgl_inspect = $this->input->post('tgl_inspect[]');
        $tgl_deliver = $this->input->post('tgl_deliver[]');

        $tanggal = $tanggal[0];
        $lokasi = $lokasi[0];
        $io = $io[0];
        // echo "<pre>"; print_r($lokasi); exit();

        $dataRPL = array();
		for ($i=0; $i < count($shipment_line_id) ; $i++) { 
			$array = array(
                'org_code' => $org_code[$i],
                'no_lppb' => $no_lppb[$i],
                'kode_item' => $kode_item[$i],
                'item' => $item[$i],
                'tgl_shipment' => $tgl_shipment[$i],
                'tgl_receive' => $tgl_receive[$i],
                'tgl_transfer' => $tgl_transfer[$i],
                'tgl_inspect' => $tgl_inspect[$i],
                'tgl_deliver' => $tgl_deliver[$i]
			);
			array_push($dataRPL, $array);
        }
        // echo "<pre>"; print_r($dataRPL); exit();

        include APPPATH.'third_party/Excel/PHPExcel.php';
        $excel = new PHPExcel();
        $excel->getProperties()->setCreator('CV. KHS')
	                 ->setLastModifiedBy('Quick')
	                 ->setTitle("ReportPembuatanLPPB")
	                 ->setSubject("CV. KHS")
	                 ->setDescription("Report Pembuatan LPPB")
                     ->setKeywords("LPPB");

        // style excel
        $style_title = array(
			'font' => array(
				'bold' => true,
				'size' => 17
			), 
			'alignment' => array(
				'horizontal' 	=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical' 		=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
		);
		$style_col = array(
			'font' => array('bold' => true), 
			'alignment' => array(
				'horizontal'	=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical' 		=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'wrap'			=> true
			),
			'borders' => array(
				'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom'=> array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
        );
        $style_row = array(
			'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 
                'wrap'	 => true
			),
			'borders' => array(
                'top' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
                'right' 	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
                'bottom'	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
                'left'	=> array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
        );

        // title
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "REPORT PEMBUATAN LPPB");
        $excel->setActiveSheetIndex(0)->setCellValue('A2', "PERIODE : $tanggal"); 
        $excel->setActiveSheetIndex(0)->setCellValue('A3', "LOKASI : $lokasi"); 
        $excel->setActiveSheetIndex(0)->setCellValue('A4', "IO : $io"); 
		$excel->getActiveSheet()->mergeCells('A1:J1'); 
        $excel->getActiveSheet()->mergeCells('A2:J2');
        $excel->getActiveSheet()->mergeCells('A3:J3'); 
		$excel->getActiveSheet()->mergeCells('A4:J4');
		$excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_title);
        $excel->getActiveSheet()->getStyle('A2')->applyFromArray($style_title);
        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_title);
        $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_title);

        // header
		$excel->setActiveSheetIndex(0)->setCellValue('A6', "NO.");
		$excel->setActiveSheetIndex(0)->setCellValue('B6', "IO");
		$excel->setActiveSheetIndex(0)->setCellValue('C6', "NO LPPB");
		$excel->setActiveSheetIndex(0)->setCellValue('D6', "KODE ITEM");
		$excel->setActiveSheetIndex(0)->setCellValue('E6', "ITEM");
        $excel->setActiveSheetIndex(0)->setCellValue('F6', "TANGGAL DAN JAM SHIPMENT");
        $excel->setActiveSheetIndex(0)->setCellValue('G6', "TANGGAL DAN JAM RECEIVE");
        $excel->setActiveSheetIndex(0)->setCellValue('H6', "TANGGAL DAN JAM TRANSFER");
        $excel->setActiveSheetIndex(0)->setCellValue('I6', "TANGGAL DAN JAM INSPECT");
        $excel->setActiveSheetIndex(0)->setCellValue('J6', "TANGGAL DAN JAM DELIVER");

        // style header
		$excel->getActiveSheet()->getStyle('A6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G6')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('H6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('I6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('J6')->applyFromArray($style_col);

        $no=1;
        $numrow = 7;
        for ($i=0; $i < sizeof($dataRPL); $i++) {
            $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $dataRPL[$i]['org_code']);
            $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $dataRPL[$i]['no_lppb']);
            $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $dataRPL[$i]['kode_item']);
            $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $dataRPL[$i]['item']);
            $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $dataRPL[$i]['tgl_shipment']);
            $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $dataRPL[$i]['tgl_receive']);
            $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $dataRPL[$i]['tgl_transfer']);
            $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $dataRPL[$i]['tgl_inspect']);
            $excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $dataRPL[$i]['tgl_deliver']);
            
            $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);

            $no++;
            $numrow++; 
        }

        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(10); 
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(10); 
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("ReportPembuatanLPPB");
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="ReportPembuatanLPPB_'.$tanggal.'_'.$lokasi.'_'.$io.'.xlsx"'); 
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }


}