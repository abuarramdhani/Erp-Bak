<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');

class C_PekerjaCutoff extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('session');
		$this->load->library('General');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPresensi/ReffGaji/M_pekerjacutoff');
		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();
	}

	public function checkSession()
	{
		if(!($this->session->is_logged))
		{
			redirect('');
		}
	}

	public function index(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Pekerja Cutoff';
		$data['Menu'] 			= 	'Reff Gaji';
		$data['SubMenuOne'] 	= 	'Pekerja Cutoff';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['user'] = $this->session->user;
		$data['data'] = $this->M_pekerjacutoff->getPeriodeCutoff();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/ReffGaji/PekerjaCutoff/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function d($periode){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Pekerja Cutoff';
		$data['Menu'] 			= 	'Reff Gaji';
		$data['SubMenuOne'] 	= 	'Pekerja Cutoff';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['user'] = $this->session->user;
		$data['data'] = $this->M_pekerjacutoff->getCutoffDetail($periode);
		$data['periode'] = $periode;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/ReffGaji/PekerjaCutoff/V_detail',$data);
		$this->load->view('V_Footer',$data);
	}

	public function pekerja($noind = FALSE){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Pekerja Cutoff';
		$data['Menu'] 			= 	'Reff Gaji';
		$data['SubMenuOne'] 	= 	'Pekerja Cutoff';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['user'] = $this->session->user;
		if ($noind !== FALSE) {
			$data['data'] = $this->M_pekerjacutoff->getCutoffDetailPekerja($noind);
			$data['pekerja'] = $this->M_pekerjacutoff->getDetailPekerja($noind);
		}
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/ReffGaji/PekerjaCutoff/V_pekerja',$data);
		$this->load->view('V_Footer',$data);
	}

	public function search(){
		$key = $this->input->get('term');
		$data = $this->M_pekerjacutoff->getPekerja($key);
		echo json_encode($data);
	}

	public function pekerjaDetail(){
		$noind = $this->input->geT('noind');
		$detail = $this->M_pekerjacutoff->getCutoffDetailPekerja($noind);
		$pekerja = $this->M_pekerjacutoff->getDetailPekerja($noind);
		$data = array(
			'data' => $detail,
			'pekerja' => $pekerja['0']
		);
		echo json_encode($data);
	}

	public function pdf($key,$value){
		if ($key == "p") {
			$data['data'] = $this->M_pekerjacutoff->getCutoffDetail($value);
			$data['periode'] = $value;

			$pdf = $this->pdf->load();
			$pdf = new mPDF('utf-8', 'A4', 8, '', 12, 15, 15, 15, 10, 20);
			$filename = 'Pekerja Cutoff periode '.$value.'.pdf';
			// $this->load->view('MasterPresensi/ReffGaji/PekerjaCutoff/V_pcetak', $data);
			$html = $this->load->view('MasterPresensi/ReffGaji/PekerjaCutoff/V_pcetak', $data, true);
			$pdf->SetHTMLFooter("<i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-MasterPresensi oleh ".$this->session->user." pada tgl. ".date('d/m/Y H:i:s').". Halaman {PAGENO} dari {nb}</i>");
			$pdf->WriteHTML($html, 2);
			$pdf->Output($filename, 'I');
		}elseif ($key == "n") {
			$data['data'] = $this->M_pekerjacutoff->getCutoffDetailPekerja($value);
			$data['pekerja'] = $this->M_pekerjacutoff->getDetailPekerja($value);

			$pdf = $this->pdf->load();
			$pdf = new mPDF('utf-8', 'A4', 8, '', 10, 10, 10, 10, 10, 20);
			$filename = 'Pekerja Cutoff noind '.$value.'.pdf';
			// $this->load->view('MasterPresensi/ReffGaji/PekerjaCutoff/V_ncetak', $data);
			$html = $this->load->view('MasterPresensi/ReffGaji/PekerjaCutoff/V_ncetak', $data, true);
			$pdf->SetHTMLFooter("<i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-MasterPresensi oleh ".$this->session->user." pada tgl. ".date('d/m/Y H:i:s').". Halaman {PAGENO} dari {nb}</i>");
			$pdf->WriteHTML($html, 2);
			$pdf->Output($filename, 'I');
		}else{
			redirect(base_url('MasterPresensi/ReffGaji/PekerjaCutoffReffGaji'));
		}
	}

	public function xls($key,$value){
		if ($key == "p" and !empty($value)) {
			$data = $this->M_pekerjacutoff->getCutoffDetail($value);
			$periode = $value;
			$prd = explode("-", $periode);

			$this->load->library('excel');
			$worksheet = $this->excel->getActiveSheet();

			$worksheet->setCellValue('A1','Pekerja dibayar Cutoff');
			$worksheet->mergeCells('A1:D1');
			$worksheet->setCellValue('A2',$prd['1'].$prd['0']);
			$worksheet->mergeCells('A2:D2');

			$worksheet->setCellValue('A4','No.');
			$worksheet->setCellValue('B4','No. Induk');
			$worksheet->setCellValue('C4','Nama');
			$worksheet->setCellValue('D4','Seksi');

			$nomor = 1;
			if(!empty($data)){				
				foreach ($data as $key) {
					$worksheet->setCellValue('A'.($nomor + 4),$nomor);
					$worksheet->setCellValue('B'.($nomor + 4),$key['noind']);
					$worksheet->setCellValue('C'.($nomor + 4),$key['nama']);
					$worksheet->setCellValue('D'.($nomor + 4),$key['seksi']);
					$nomor++;
				}
			}else{
				$worksheet->setCellValue('A5','Tidak Ditemukan Data untuk Nomor Induk '.$pekerja['0']['noind'].' di Data Pekerja Cut Off');
				$worksheet->mergeCells('A5:D5');
			}

			$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					)
				),'A1:A2');
			$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'fill' =>array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
							'argb' => '00ccffcc')
					)
				),'A4:D4');
			$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN)
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					)
				),'A4:D'.($nomor + 3));
			$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					)
				),'C5:D'.($nomor + 3));

			$worksheet->getColumnDimension('A')->setWidth('5');
			$worksheet->getColumnDimension('B')->setWidth('10');
			$worksheet->getColumnDimension('C')->setWidth('20');
			$worksheet->getColumnDimension('D')->setWidth('30');
			$worksheet->getStyle('C5:D'.($nomor + 3))->getAlignment()->setWrapText(true);

			$filename ='Pekerja_CutOff-periode-'.$prd['1'].$prd['0'].'.xls';
			header('Content-Type: aplication/vnd.ms-excel');
			header('Content-Disposition:attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');
			$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
			$writer->save('php://output');
		}elseif ($key == "n" and !empty($value)) {
			$data = $this->M_pekerjacutoff->getCutoffDetailPekerja($value);
			$pekerja = $this->M_pekerjacutoff->getDetailPekerja($value);
			
			$this->load->library('excel');
			$worksheet = $this->excel->getActiveSheet();

			$worksheet->setCellValue('A1','Pekerja dibayar Cutoff');
			$worksheet->mergeCells('A1:D1');

			$worksheet->setCellValue('A3','No. Induk');
			$worksheet->setCellValue('B3',$pekerja['0']['noind']);
			$worksheet->setCellValue('A4','Nama');
			$worksheet->setCellValue('B4',$pekerja['0']['nama']);
			$worksheet->setCellValue('A5','Seksi / Unit');
			$worksheet->setCellValue('B5',$pekerja['0']['seksi']);
			$worksheet->mergeCells('B3:D3');
			$worksheet->mergeCells('B4:D4');
			$worksheet->mergeCells('B5:D5');

			$worksheet->setCellValue('A7','No.');
			$worksheet->setCellValue('B7','Periode');
			$worksheet->mergeCells('B7:D7');

			$nomor = 1;
			if(!empty($data)){
				foreach ($data as $key) {
					$worksheet->setCellValue('A'.($nomor + 7),$nomor);
					$worksheet->setCellValue('B'.($nomor + 7),$key['periode']);
					$worksheet->mergeCells('B'.($nomor + 7).':D'.($nomor + 7));
					$nomor++;
				}
			}else{
				$worksheet->setCellValue('A8','Tidak Ditemukan Data untuk Nomor Induk '.$pekerja['0']['noind'].' di Data Pekerja Cut Off');
				$worksheet->mergeCells('A8:D8');
			}

			$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					)
				),'A1:A1');
			$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'fill' =>array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
							'argb' => '00ccffcc')
					)
				),'A7:D7');
			$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					),
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN)
					)
				),'A7:D'.($nomor + 6));
			$filename ='Pekerja_CutOff-noind-'.$pekerja['0']['noind'].'.xls';
			header('Content-Type: aplication/vnd.ms-excel');
			header('Content-Disposition:attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');
			$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
			$writer->save('php://output');
		}else{
			redirect(base_url('MasterPresensi/ReffGaji/PekerjaCutoffReffGaji'));
		}
	}
}
?>