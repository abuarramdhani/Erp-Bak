<?php
Defined('BASEPATH') or exit('No Direct Sekrip Akses Allowed');
/**
 *
 */
class C_Cetak extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('file');

		$this->load->library('Log_Activity');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('ManagementAdmin/M_cetak');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index(){
		$user_id = $this->session->userid;

		$data['Title'] = 'Management Admin';
		$data['Menu'] = 'Manual';
		$data['SubMenuOne'] = 'Cetak';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManagementAdmin/Manual/V_cetak',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Cetak(){
		$semua = $this->input->post('txtSemuaPekerjaCetak');
		$pekerja = $this->input->post('txtPekerjaCetak');
		$periode = $this->input->post('txtPeriodeCetak');
		//insert to t_log
		$aksi = 'MANAGEMENT ADMIN';
		$detail = 'Cetak Excel Periode='.$periode;
		$this->log_activity->activity_log($aksi, $detail);
		//
		if (isset($semua) and !empty($semua) and $semua == '1') {
			$data = $this->M_cetak->getCetakSemua($periode);
		}else{
			$pkj = "";
			foreach ($pekerja as $key) {
				if ($pkj == "") {
					$pkj = "'".$key."'";
				}else{
					$pkj = $pkj.",'".$key."'";
				}
			}
			$data = $this->M_cetak->getCetakSebagian($pkj,$periode);
		}

		$this->load->library('excel');

		$this->excel->getActiveSheet()->setCellValue('B3','No Induk');
		$this->excel->getActiveSheet()->setCellValue('C3','Pekerjaan');
		$this->excel->getActiveSheet()->setCellValue('D3','Dokumen');
		$this->excel->getActiveSheet()->setCellValue('E3','Target');
		$this->excel->getActiveSheet()->setCellValue('F3','Lama Kerja');
		$this->excel->getActiveSheet()->setCellValue('G3','Alasan');
		$row = 4;
		foreach ($data as $val) {
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,$row,$val['nama_pekerja']);
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2,$row,$val['pekerjaan']);
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(3,$row,$val['jml_dokument']);
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(4,$row,$val['total_target']);
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(5,$row,$val['total_waktu']);
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(6,$row,$val['alasan']);

			$coorCellAkhir1 = $this->excel->getActiveSheet()->getCellByColumnAndRow(1,$row);
			$coorCellAkhir2 = $this->excel->getActiveSheet()->getCellByColumnAndRow(2,$row);
			$coorCellAkhir3 = $this->excel->getActiveSheet()->getCellByColumnAndRow(3,$row);
			$coorCellAkhir4 = $this->excel->getActiveSheet()->getCellByColumnAndRow(4,$row);
			$coorCellAkhir5 = $this->excel->getActiveSheet()->getCellByColumnAndRow(5,$row);
			$coorCellAkhir6 = $this->excel->getActiveSheet()->getCellByColumnAndRow(6,$row);
			$row++;
		}

		$coorCellSimpanAkhir1 = $coorCellAkhir1->getCoordinate();
		$coorCellSimpanAkhir2 = $coorCellAkhir2->getCoordinate();
		$coorCellSimpanAkhir3 = $coorCellAkhir3->getCoordinate();
		$coorCellSimpanAkhir4 = $coorCellAkhir4->getCoordinate();
		$coorCellSimpanAkhir5 = $coorCellAkhir5->getCoordinate();
		$coorCellSimpanAkhir6 = $coorCellAkhir6->getCoordinate();

		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth('20');
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth('10');
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth('10');
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth('10');
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth('30');
		$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					)
				),'B3:G3'
		);
		$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'alignment' => array(
						'wrap' => true,
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
					)
				),'B4:'.$coorCellSimpanAkhir2
		);
		$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
					)
				),'D4:'.$coorCellSimpanAkhir5
		);
		$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'alignment' => array(
						'wrap' => true,
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
					)
				),'G4:'.$coorCellSimpanAkhir6
		);
		$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN)
					)
				),'B3:'.$coorCellSimpanAkhir6
		);

		$filename ='Daftar Pending '.$periode.'.xls';
		header('Content-Type: aplication/vnd.ms-excel');
		header('Content-Disposition:attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
		$writer->save('php://output');
	}

}
?>
