<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Rekap extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('UpahHlCm/M_cetakdata');
		$this->load->model('UpahHlCm/M_prosesgaji');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
    }
	
	//HALAMAN INDEX
	public function index(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/MenuCetak/V_Rekap',$data);
		$this->load->view('V_Footer',$data);
		
	}
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
	
	public function cetakpdf()
	{
		$this->load->library('pdf');

		$data['periode'] = $this->input->post('periode');
		$periodew = explode(' - ', $data['periode']);
		$tanggalawal = date('Y-m-d',strtotime($periodew[0]));
		$tanggalakhir = date('Y-m-d',strtotime($periodew[1]));

		$tgl = date('F-Y',strtotime($tanggalawal));
		$noind = "";

		$data['kom'] = $this->M_prosesgaji->prosesHitung($tanggalawal,$tanggalakhir,$noind);
		$data['nom'] = $this->M_prosesgaji->ambilNominalGaji();
		$data['rekap'] = $this->M_cetakdata->ambildataRekap();

		// echo "<pre>";
		// print_r($data['rekap']);
		// exit();

		$submit = $this->input->post('txtSubmit');
		if ($submit == 'Cetak Pdf') {
			$pdf = $this->pdf->load();
			$pdf = new mPDF('utf-8', 'F4', 8, '', 12, 15, 15, 15, 10, 20);
			$filename = 'Rekap-'.$tgl.'.pdf';

			$html = $this->load->view('UpahHlCm/MenuCetak/V_cetakRekap', $data, true);

			$pdf->WriteHTML($html, 2);
			$pdf->Output($filename, 'D');
		}else{
			$kom 	= $data['kom'];
			$nom 	= $data['nom'];
			$rekap 	= $data['rekap'];
			$this->load->library('excel');
			$worksheet = $this->excel->getActiveSheet();

			$period = explode(' - ', $data['periode']);

			$worksheet->setCellValue('A1','PEMBAYARAN UPAH PEKERJA HARIAN KHS PUSAT & KHS TUKSONO');
			$worksheet->mergeCells('A1:H1');
			$worksheet->setCellValue('A2','PERIODE TANGGAL : '.date('d F Y',strtotime($period[0]))." - ".date('d F Y',strtotime($period[1])));
			$worksheet->mergeCells('A2:H2');
			$worksheet->setCellValue('A3','NO');
			$worksheet->setCellValue('B3','TGL TERIMA');
			$worksheet->setCellValue('C3','NO REKENING');
			$worksheet->setCellValue('D3','NAMA');
			$worksheet->setCellValue('E3','TERIMA');
			$worksheet->setCellValue('F3','NAMA PENERIMA REKENING');
			$worksheet->setCellValue('G3','BANK');
			$worksheet->setCellValue('H3','KETERANGAN');

			$worksheet->setCellValue('A4','TUKSONO');
			$worksheet->mergeCells('A4:H4');
			$row = 5;
			$total_semua = "";
			$no = 1;
			foreach ($kom as $key) {
				if ($key['lokasi_kerja'] == '02') {
					$gpokok  = $key['gpokok'];
					$um		 = $key['um'];
					$lembur  = $key['lembur'];
					for ($i=0; $i < 8; $i++) { 
						if ($key['lokasi_kerja']==$nom[$i]['lokasi_kerja'] and $key['kdpekerjaan']==$nom[$i]['kode_pekerjaan']) {
							$nomgpokok = $nom[$i]['nominal'];
						}
						if ($key['lokasi_kerja']==$nom[$i]['lokasi_kerja']) {
							$nomum = $nom[$i]['uang_makan'];
						}
					}
					$gajipokok = $gpokok*$nomgpokok;
					$gajium    = $um*$nomum;
					$gajilembur= $lembur*($nomgpokok/7);
					$total 	   = $gajipokok+$gajilembur+$gajium;
					$total_semua = $total_semua+$total;

					$worksheet->setCellValueByColumnAndRow(0,$row,$no);
					$worksheet->setCellValueByColumnAndRow(3,$row,$key['nama']);
					$this->excel->getActiveSheet()->setCellValueExplicit('E'.$row,number_format($total,'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
					foreach ($rekap as $val) {
						if ($key['noind'] == $val['noind']) {
							$this->excel->getActiveSheet()->setCellValueExplicit('C'.$row,$val['no_rekening'],PHPExcel_Cell_DataType::TYPE_STRING);
							$worksheet->setCellValueByColumnAndRow(5,$row,$val['atas_nama']);
							$worksheet->setCellValueByColumnAndRow(6,$row,$val['bank']);
						}
					}
					$row++;
					$no++;
					$coorCell = $this->excel->getActiveSheet()->getCellByColumnAndRow(0,$row);
					$coorCellSave1 =$coorCell->getCoordinate();
					$coorCell = $this->excel->getActiveSheet()->getCellByColumnAndRow(7,$row);
					$coorCellSave2 =$coorCell->getCoordinate();
				}
			}

			$worksheet->setCellValue($coorCellSave1,'PUSAT');
			$worksheet->mergeCells($coorCellSave1.':'.$coorCellSave2);
			$this->excel->getActiveSheet()->duplicateStyleArray(
			array(
				'fill' =>array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'startcolor' => array(
						'argb' => '00ccffcc')
				)
			),$coorCellSave1.':'.$coorCellSave2);
			$row++;

			foreach ($kom as $key) {
				if ($key['lokasi_kerja'] == '01') {
					$gpokok  = $key['gpokok'];
					$um		 = $key['um'];
					$lembur  = $key['lembur'];
					for ($i=0; $i < 8; $i++) { 
						if ($key['lokasi_kerja']==$nom[$i]['lokasi_kerja'] and $key['kdpekerjaan']==$nom[$i]['kode_pekerjaan']) {
							$nomgpokok = $nom[$i]['nominal'];
						}
						if ($key['lokasi_kerja']==$nom[$i]['lokasi_kerja']) {
							$nomum = $nom[$i]['uang_makan'];
						}
					}
					$gajipokok = $gpokok*$nomgpokok;
					$gajium    = $um*$nomum;
					$gajilembur= $lembur*($nomgpokok/7);
					$total 	   = $gajipokok+$gajilembur+$gajium;
					$total_semua = $total_semua+$total;

					$worksheet->setCellValueByColumnAndRow(0,$row,$no);
					$worksheet->setCellValueByColumnAndRow(3,$row,$key['nama']);
					$this->excel->getActiveSheet()->setCellValueExplicit('E'.$row,number_format($total,'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
					foreach ($rekap as $val) {
						if ($key['noind'] == $val['noind']) {
							$this->excel->getActiveSheet()->setCellValueExplicit('C'.$row,$val['no_rekening'],PHPExcel_Cell_DataType::TYPE_STRING);
							$worksheet->setCellValueByColumnAndRow(5,$row,$val['atas_nama']);
							$worksheet->setCellValueByColumnAndRow(6,$row,$val['bank']);
						}
					}

					$coorCell = $this->excel->getActiveSheet()->getCellByColumnAndRow(7,$row);
					$coorCellSave2 =$coorCell->getCoordinate();
					$coorCell = $this->excel->getActiveSheet()->getCellByColumnAndRow(3,$row);
					$coorCellSave9 =$coorCell->getCoordinate();
					$coorCell = $this->excel->getActiveSheet()->getCellByColumnAndRow(5,$row);
					$coorCellSave10 =$coorCell->getCoordinate();
					$row++;
					$no++;
					$coorCell = $this->excel->getActiveSheet()->getCellByColumnAndRow(3,($row+1));
					$coorCellSave3 =$coorCell->getCoordinate();
					$coorCell = $this->excel->getActiveSheet()->getCellByColumnAndRow(4,($row+1));
					$coorCellSave4 =$coorCell->getCoordinate();
					$coorCell = $this->excel->getActiveSheet()->getCellByColumnAndRow(6,($row+1));
					$coorCellSave5 =$coorCell->getCoordinate();
					$coorCell = $this->excel->getActiveSheet()->getCellByColumnAndRow(6,($row+5));
					$coorCellSave6 =$coorCell->getCoordinate();
					$coorCell = $this->excel->getActiveSheet()->getCellByColumnAndRow(6,($row+6));
					$coorCellSave7 =$coorCell->getCoordinate();
					$coorCell = $this->excel->getActiveSheet()->getCellByColumnAndRow(7,($row+6));
					$coorCellSave8 =$coorCell->getCoordinate();
				}
			}

			$worksheet->setCellValue($coorCellSave3,'TOTAL');
			$worksheet->setCellValue($coorCellSave4,number_format($total_semua,'0',',','.'));
			$ttd  = date('d');
				$month=date('m');
				if ($month=='01') {
					$ttd .= " Januari ";
				}elseif ($month=='02') {
					$ttd .= " Februari ";
				}elseif ($month=='03') {
					$ttd .= " Maret ";
				}elseif ($month=='04') {
					$ttd .= " April ";
				}elseif ($month=='05') {
					$ttd .= " Mei ";
				}elseif ($month=='06') {
					$ttd .= " Juni ";
				}elseif ($month=='07') {
					$ttd .= " Juli ";
				}elseif ($month=='08') {
					$ttd .= " Agustus ";
				}elseif ($month=='09') {
					$ttd .= " September ";
				}elseif ($month=='10') {
					$ttd .= " Oktober ";
				}elseif ($month=='11') {
					$ttd .= " November ";
				}elseif ($month=='12') {
					$ttd .= " Desember ";
				};
				$ttd .= date('Y');
			$worksheet->setCellValue($coorCellSave5,'Yogyakarta, '.$ttd);
			$worksheet->setCellValue($coorCellSave6,'Eko Prasetyo Adhi');
			$worksheet->setCellValue($coorCellSave7,'Kepala Seksi Civil Maintenance');
			$worksheet->getStyle($coorCellSave6)->getFont()->setUnderline(true);

			$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth('20');
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth('30');
			$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth('20');
			$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
			$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
			$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth('20');

			$this->excel->getActiveSheet()->duplicateStyleArray(
			array(
				'fill' =>array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'startcolor' => array(
						'argb' => '00ccffcc')
				)
			),'A3:H4');

			$this->excel->getActiveSheet()->duplicateStyleArray(
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				)
			),'A1:'.$coorCellSave8);

			$this->excel->getActiveSheet()->duplicateStyleArray(
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				)
			),'D5:'.$coorCellSave9);

			$this->excel->getActiveSheet()->duplicateStyleArray(
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				)
			),'F5:'.$coorCellSave10);

			$this->excel->getActiveSheet()->duplicateStyleArray(
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				)
			),'H5:'.$coorCellSave2);

			$this->excel->getActiveSheet()->duplicateStyleArray(
			array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN)
				)
			),'A3:'.$coorCellSave2);

			$this->excel->getActiveSheet()->duplicateStyleArray(
			array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN)
				)
			),$coorCellSave3.':'.$coorCellSave4);

			

			$this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_WorkSheet_PageSetup::PAPERSIZE_A4);
			$this->excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
			$filename ='Rekap-'.$tgl.'.xls';
			header('Content-Type: aplication/vnd.ms-excel');
			header('Content-Disposition:attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');
			$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
			$writer->save('php://output');
		}
	}
}
