<?php defined('BASEPATH')OR die('No direct script access allowed');
class C_Report extends CI_Controller
{

	function __construct()
		{
			parent::__construct();
			date_default_timezone_set("Asia/Jakarta");
			$this->load->helper('form');
	        $this->load->helper('url');
	        $this->load->helper('html');
			$this->load->library('Log_Activity');
	        $this->load->library('form_validation');
	        $this->load->library('Excel');
	          //load the login model
			$this->load->library('session');
			$this->load->model('M_Index');
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('SystemIntegration/M_report');

			if($this->session->userdata('logged_in')!=TRUE) {
				$this->load->helper('url');
				$this->session->set_userdata('last_page', current_url());
				$this->session->set_userdata('Responsbility', 'some_value');
			}

		}

	public function checkSession()
		{
			if ($this->session->is_logged) {
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


			$start = $this->input->post('start');
			$end   = $this->input->post('end');
			if (empty($start)) {
				$start = date('Y-m-10');
				$end   = date("Y-m-10",strtotime("+1 month"));
			}
			// echo $end; exit();

			$getpekerja = $this->M_report->getpekerja($this->session->kodesie, $start, $end);
			$getseksi = $this->M_report->getseksi($this->session->kodesie, $start, $end);


			$data['start'] = $start;
			$data['end'] = $end;

			$data['complexTextAreaCKEditor']	=	FALSE;

			$getMember = $this->M_report->getMember($this->session->kodesie);
			$sectionName = $getMember[0]['seksi'];
			$data['seksi'] = $sectionName;

			// $getpekerja = $this->M_report->getpekerja($this->session->kodesie);
			// print_r($getseksi); exit();
			// print_r($getpekerja); exit();
			$data['data_seksi'] = $getseksi;
			$data['data_pekerja'] = $getpekerja;
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('SystemIntegration/MainMenu/Report/V_Index',$data);
			$this->load->view('V_Footer',$data);
			$this->load->view('SystemIntegration/MainMenu/Report/V_Chart',$data);

		}

	public function exportKaizen()
		{
			//insert to t_log
			$aksi = 'KAIZEN GENERATOR';
			$detail = 'Mengakses Menu Export Kaizen';
			$this->log_activity->activity_log($aksi, $detail);
			//
			$this->checkSession();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['complexTextAreaCKEditor']	=	FALSE;
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('SystemIntegration/MainMenu/Report/V_ExportKaizen',$data);
			$this->load->view('V_Footer',$data);

		}

	public function findexport()
		{
			//insert to t_log
			$aksi = 'KAIZEN GENERATOR';
			$detail = 'Find Export Kaizen';
			$this->log_activity->activity_log($aksi, $detail);
			//
			$this->checkSession();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$this->input->post('txtStartDate');
			$this->input->post('txtEndDate');

			$start = date("Y-m-d", strtotime($this->input->post('txtStartDate')));
			$end   = date("Y-m-d", strtotime($this->input->post('txtEndDate')));
			$data['find'] = $this->M_report->getKaizenExport($start, $end);
			$data['start'] = $start;
			$data['end'] = $end;

			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('SystemIntegration/MainMenu/Report/V_ExportKaizen',$data);
			$this->load->view('V_Footer',$data);
		}

	// public function export()
	// {
	// 	$start = date("Y-m-d", strtotime($this->input->post('txtStartDate')));
	// 	$end   = date("Y-m-d", strtotime($this->input->post('txtEndDate')));

	// 	// $realisasi=$this->input->post('txtRealisasi');
	// 	$data = $this->M_report->getKaizenExport($start, $end);

	// 	$objPHPExcel = new PHPExcel();

	// 	$objPHPExcel->getProperties()->setCreator("CV. KHS")->setTitle("QUICK");

	// 	$objset = $objPHPExcel->setActiveSheetIndex(0);
	// 	$objget = $objPHPExcel->getActiveSheet();
	// 	$objget->setTitle('Sample Sheet');
	// 	$objget->getStyle("A1:I1")->applyFromArray(
	// 		array(
	// 			'fill' => array(
	// 				'type' => PHPExcel_Style_Fill::FILL_SOLID,
	// 				'color' => array('rgb' => '92d050')
	// 			),
	// 			'font' => array(
	// 				'color' => array('rgb' => '000000'),
	// 				'bold'  => true,
	// 			)
	// 		)
	// 	);

	// 	$cols = array("A", "B", "C", "D", "E", "F", "G", "H", "I");
	// 	$val = array("No", "No Kaizen" , "Judul", "Kondisi Awal", "Kondisi Setelah Kaizen", "Pertimbangan", "PIC", "Departemen" , "Tanggal Lapor");

	// 	for ($a=0;$a<9; $a++) {
	// 		$objset->setCellValue($cols[$a].'1', $val[$a]);

	// 		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
	// 		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
	// 		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
	// 		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
	// 		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
	// 		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
	// 		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
	// 		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
	// 		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

	// 		$style = array(
	// 			'alignment' => array(
	// 				'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	// 			)
	// 		);
	// 		$objPHPExcel->getActiveSheet()->getStyle($cols[$a].'1')->applyFromArray($style);
	// 	}

	// 	$baris  = 2;
	// 	$no = 1;
	// 	foreach ($data as $frow) {
	// 		$objset->setCellValue("A".$baris, $no);
	// 		$objset->setCellValue("B".$baris, $frow['no_kaizen']);
	// 		$objset->setCellValue("C".$baris, $frow['judul']);
	// 		$objset->setCellValue("D".$baris, strip_tags($frow['kondisi_awal']));
	// 		$objset->setCellValue("E".$baris, strip_tags($frow['usulan_kaizen']));
	// 		$objset->setCellValue("F".$baris, $frow['pertimbangan']);
	// 		$objset->setCellValue("G".$baris, $frow['pencetus']);
	// 		$objset->setCellValue("H".$baris, $frow['department_name']);
	// 		$objset->setCellValue("I".$baris, '');

	// 		$no++;
	// 		$baris++;
	// 	}

	// 	$objPHPExcel->getActiveSheet()->setTitle('Data Export');

	// 	$objPHPExcel->setActiveSheetIndex(0);
	// 	$filename = urlencode("Kaizen.xls");

	// 	header('Content-Type: application/vnd.ms-excel');
	// 	header('Content-Disposition: attachment;filename="'.$filename.'"');
	// 	header('Cache-Control: max-age=0');

	// 	$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
	// 	$objWriter->save('php://output');
	// }

	public function exportExcelKaizen(){
		//insert to t_log
		$aksi = 'KAIZEN GENERATOR';
		$detail = 'Export Excel Kaizen';
		$this->log_activity->activity_log($aksi, $detail);
		//

		$this->load->library('Excel');
		$tglAwal = $this->input->post('txtStartDate');
		$tglAkhir= $this->input->post('txtEndDate');
		$start = date("Y-m-d", strtotime($this->input->post('txtStartDate')));
		$end   = date("Y-m-d", strtotime($this->input->post('txtEndDate')));
		// $action_status = $this->input->post('')

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

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "REPORT REKAP KAIZEN");
        $objPHPExcel->getActiveSheet()->mergeCells('A1:J2');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "Date : ".$dateTarikFrom.' s/d '.$dateTarikTo);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', "No");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4', "Nomor Kaizen");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', "Judul Kaizen");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D4', "Kondisi Awal Kaizen");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4', "Kondisi Akhir Kaizen");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4', "Pencetus Kaizen");

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(2);
        $objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);

        foreach(range('B','F') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle($columnID.'4')->applyFromArray($style_col);
        }

        foreach(range('A','B') as $columnID) {
            $objPHPExcel->getActiveSheet()->getStyle($columnID)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }

        $fetch = $this->M_report->getKaizenExport($start,$end);

        $no = 1;
        $numrow = 5;
        foreach($fetch as $data){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['no_kaizen']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data['judul']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data['kondisi_awal']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data['kondisi_akhir']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data['pencetus']);

            $objPHPExcel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);

            $no++;
            $numrow++;
        }

        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);

		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle('Report Rekap Kaizen');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Report_Rekap_Kaizen.xlsx"');
		$objWriter->save("php://output");

	}
}
