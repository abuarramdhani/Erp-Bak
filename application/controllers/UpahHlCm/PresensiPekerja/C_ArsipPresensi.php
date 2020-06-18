<?php
defined('BASEPATH') or exit('No Direct Script Access Allowed');
/**
 *
 */
date_default_timezone_set('Asia/Jakarta');

class C_ArsipPresensi extends CI_Controller
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
		$this->load->model('UpahHlCm/M_presensipekerja');
		$this->load->model('UpahHlCm/M_cetakdata');

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

		$data['Title'] = 'Arsip';
		$data['Menu'] = 'Presensi Pekerja';
		$data['SubMenuOne'] = 'Arsip';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_presensipekerja->getArsipPresensi();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/PresensiPekerja/V_indexArsip',$data);
		$this->load->view('V_Footer',$data);
	}

	public function detail_arsip(){
		$id_encrypted = $this->input->get('data');
		$method = $this->input->get('method');
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id_encrypted);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$id = $plaintext_string;
		$data_array = $this->M_presensipekerja->getArsipPresensiDetail($id);

		if ($data_array->asal == "Rekap Presensi") {
			if ($method == "view") {
				$RekapPresensi = json_decode($data_array->isi,true);
				$data['RekapPresensi'] = $RekapPresensi['RekapPresensi'];
				$data['periode'] = $RekapPresensi['periode'];

				$user_id = $this->session->userid;

				$data['Title'] = 'Arsip';
				$data['Menu'] = 'Presensi Pekerja';
				$data['SubMenuOne'] = 'Arsip';
				$data['SubMenuTwo'] = '';

				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('UpahHlCm/PresensiPekerja/V_cetakRekapPresensiArsipPresensi',$data);
				$this->load->view('V_Footer',$data);
			}elseif ($method == "pdf") {
				$RekapPresensi = json_decode($data_array->isi,true);
				$data['RekapPresensi'] = $RekapPresensi['RekapPresensi'];
				$data['periode'] = $RekapPresensi['periode'];
				$data['awal'] = $data_array->tgl_awal_periode;
				$data['akhir'] = $data_array->tgl_akhir_periode;

				$pdf = $this->pdf->load();
				$pdf = new mPDF('utf-8', 'A4', 8, '', 12, 15, 15, 15, 10, 5);
				$filename = 'Arsip-RekapPresensi-'.$data_array->awal.'-'.$data_array->akhir.'.pdf';
				// $this->load->view('UpahHlCm/PresensiPekerja/V_cetakRekapPresensi', $data);
				$html = $this->load->view('UpahHlCm/PresensiPekerja/V_cetakRekapPresensi', $data, true);
				$pdf->SetHTMLFooter("<i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-HLCM pada oleh ".$this->session->user." tgl. ".date('d/m/Y H:i:s').". Halaman {PAGENO} dari {nb}</i>");
				$pdf->WriteHTML($html, 2);
				$pdf->Output($filename, 'I');
			}else{
				$RekapPresensi = json_decode($data_array->isi,true);
				$data['RekapPresensi'] = $RekapPresensi['RekapPresensi'];
				$data['periode'] = $RekapPresensi['periode'];
				$data['awal'] = $data_array->tgl_awal_periode;
				$data['akhir'] = $data_array->tgl_akhir_periode;

				$this->load->library('excel');
				$worksheet = $this->excel->getActiveSheet();

				$period = explode(' - ', $data['periode']);

				$worksheet->setCellValue('A1','REKAP PRESENSI');
				$worksheet->mergeCells('A1:N1');
				$worksheet->setCellValue('A2','PERIODE TANGGAL : '.date('d F Y',strtotime($period[0]))." - ".date('d F Y',strtotime($period[1])));
				$worksheet->mergeCells('A2:M2');
				$worksheet->setCellValue('A3','NO');
				$worksheet->setCellValue('B3','NO INDUK');
				$worksheet->setCellValue('C3','NAMA');
				$worksheet->setCellValue('D3','STATUS');
				$worksheet->setCellValue('E3','GAJI');
				$worksheet->setCellValue('I3','TAMBAHAN');
				$worksheet->setCellValue('L3','POTONGAN');
				$worksheet->setCellValue('E4','Gaji Pokok');
				$worksheet->setCellValue('F4','Lembur');
				$worksheet->setCellValue('G4','Uang Makan');
				$worksheet->setCellValue('H4','Uang Makan Puasa');
				$worksheet->setCellValue('I4','Gaji Pokok');
				$worksheet->setCellValue('J4','Lembur');
				$worksheet->setCellValue('K4','Uang Makan');
				$worksheet->setCellValue('L4','Gaji Pokok');
				$worksheet->setCellValue('M4','Lembur');
				$worksheet->setCellValue('N4','Uang Makan');

				$worksheet->mergeCells('A3:A4');
				$worksheet->mergeCells('B3:B4');
				$worksheet->mergeCells('C3:C4');
				$worksheet->mergeCells('D3:D4');
				$worksheet->mergeCells('E3:H3');
				$worksheet->mergeCells('I3:K3');
				$worksheet->mergeCells('L3:N3');

				if (isset($data['RekapPresensi']) and !empty($data['RekapPresensi'])) {
					$nomor = 1;
					foreach ($data['RekapPresensi'] as $key) {
						$worksheet->setCellValue('A'.($nomor + 4),$nomor);
						$worksheet->setCellValue('B'.($nomor + 4),$key['noind']);
						$worksheet->setCellValue('C'.($nomor + 4),$key['nama']);
						$worksheet->setCellValue('D'.($nomor + 4),$key['pekerjaan']);
						$worksheet->setCellValue('E'.($nomor + 4),$key['gp_gaji']);
						$worksheet->setCellValue('F'.($nomor + 4),$key['lembur_gaji']);
						$worksheet->setCellValue('G'.($nomor + 4),$key['um_gaji']);
						$worksheet->setCellValue('H'.($nomor + 4),$key['ump_gaji']);
						$worksheet->setCellValue('I'.($nomor + 4),$key['gp_tambahan']);
						$worksheet->setCellValue('J'.($nomor + 4),$key['lembur_tambahan']);
						$worksheet->setCellValue('K'.($nomor + 4),$key['um_tambahan']);
						$worksheet->setCellValue('L'.($nomor + 4),$key['gp_potongan']);
						$worksheet->setCellValue('M'.($nomor + 4),$key['lembur_potongan']);
						$worksheet->setCellValue('N'.($nomor + 4),$key['um_potongan']);
						$worksheet->getStyle("E".($nomor + 4))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
						$worksheet->getStyle("F".($nomor + 4))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
						$worksheet->getStyle("G".($nomor + 4))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
						$worksheet->getStyle("H".($nomor + 4))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
						$worksheet->getStyle("I".($nomor + 4))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
						$worksheet->getStyle("J".($nomor + 4))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
						$worksheet->getStyle("K".($nomor + 4))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
						$worksheet->getStyle("L".($nomor + 4))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
						$worksheet->getStyle("M".($nomor + 4))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
						$worksheet->getStyle("N".($nomor + 4))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
						$allignment = array(
							'alignment' => array(
						       'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						       'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							   )
							);

						$worksheet->getStyle('B'.($nomor + 4))->applyFromArray($allignment);

						$nomor++;

						
					}
				}

				$worksheet->getColumnDimension('A')->setWidth('5');
				$worksheet->getColumnDimension('B')->setWidth('15');
				$worksheet->getColumnDimension('C')->setWidth('20');
				$worksheet->getColumnDimension('D')->setWidth('10');
				$worksheet->getColumnDimension('E')->setWidth('10');
				$worksheet->getColumnDimension('F')->setWidth('10');
				$worksheet->getColumnDimension('G')->setWidth('10');
				$worksheet->getColumnDimension('H')->setWidth('10');
				$worksheet->getColumnDimension('I')->setWidth('10');
				$worksheet->getColumnDimension('J')->setWidth('10');
				$worksheet->getColumnDimension('K')->setWidth('10');
				$worksheet->getColumnDimension('L')->setWidth('10');
				$worksheet->getColumnDimension('M')->setWidth('10');
				$worksheet->getColumnDimension('N')->setWidth('10');
				$worksheet->getStyle('E4:N4')->getAlignment()->setWrapText(true);
				$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					)
				),'A1:N1');
				$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'fill' =>array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
							'argb' => '00ccffcc')
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					),
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN)
					)
				),'A3:N4');
				$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN)
					)
				),'A5:N'.($nomor + 3));

				$filename ='Arsip-RekapPresensi-'.$data['awal'].'_'.$data['akhir'].'.xls';
				header('Content-Type: aplication/vnd.ms-excel');
				header('Content-Disposition:attachment;filename="'.$filename.'"');
				header('Cache-Control: max-age=0');
				$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
				$writer->save('php://output');
			}
		}else{
			if ($method == "view") {
				$user_id = $this->session->userid;

				$data['Title'] = 'Arsip';
				$data['Menu'] = 'Presensi Pekerja';
				$data['SubMenuOne'] = 'Arsip';
				$data['SubMenuTwo'] = '';

				$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
				$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
				$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

				$data['data'] = json_decode($data_array->isi, true);
				$data['awal'] = $data_array->tgl_awal_periode;
				$data['akhir'] = $data_array->tgl_akhir_periode;
				$data['create_by'] = $data_array->created_by;
				$data['create_date'] = $data_array->created_date;
				$data['jenis_tampilan'] = $data_array->jenis_tampilan;
				$data['jenis_presensi'] = $data_array->jenis_presensi;
				$data['pekerja_keluar'] = $data_array->pekerja_keluar;
				$data['off_awal'] = $data_array->tgl_awal_pekerja_keluar;
				$data['off_akhir'] = $data_array->tgl_akhir_pekerja_keluar;
				$data['keterangan'] = $data_array->keterangan;
				$this->load->view('V_Header',$data);
				$this->load->view('V_Sidemenu',$data);
				$this->load->view('UpahHlCm/PresensiPekerja/V_cetakDetailPresensiArsipPresensi',$data);
				$this->load->view('V_Footer',$data);
			}elseif ($method == "pdf") {
				$data['data'] = json_decode($data_array->isi, true);
				$data['awal'] = $data_array->tgl_awal_periode;
				$data['akhir'] = $data_array->tgl_akhir_periode;
				$data['create_by'] = $data_array->created_by;
				$data['create_date'] = $data_array->created_date;
				$data['jenis_tampilan'] = $data_array->jenis_tampilan;
				$data['jenis_presensi'] = $data_array->jenis_presensi;
				$data['pekerja_keluar'] = $data_array->pekerja_keluar;
				$data['off_awal'] = $data_array->tgl_awal_pekerja_keluar;
				$data['off_akhir'] = $data_array->tgl_akhir_pekerja_keluar;
				$data['keterangan'] = $data_array->keterangan;
				$this->load->library('pdf');
				$pdf = $this->pdf->load();
				$pdf = new mPDF('utf-8', 'A4-L', 8, '', 6, 5, 5, 5, 5, 5);
				$filename = 'Arsip-DetailPresensi_'.$data['awal'].'_'.$data['akhir'].'.pdf';
				// $this->load->view('UpahHlCm/PresensiPekerja/V_cetakDetailPresensi', $data);
				$html = $this->load->view('UpahHlCm/PresensiPekerja/V_cetakDetailPresensi', $data, true);
				$pdf->SetHTMLFooter("<i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-HLCM pada oleh ".$this->session->user." tgl. ".date('d/m/Y H:i:s').". Halaman {PAGENO} dari {nb}</i>");
				$pdf->WriteHTML($html, 2);
				$pdf->Output($filename, 'I');
			}else{
				$data = json_decode($data_array->isi, true);
				$awal = $data_array->tgl_awal_periode;
				$akhir = $data_array->tgl_akhir_periode;
				$create_by = $data_array->created_by;
				$create_date = $data_array->created_date;
				$jenis_tampilan = $data_array->jenis_tampilan;
				$jenis_presensi = $data_array->jenis_presensi;
				$pekerja_keluar = $data_array->pekerja_keluar;
				$off_awal = $data_array->tgl_awal_pekerja_keluar;
				$off_akhir = $data_array->tgl_akhir_pekerja_keluar;
				$keterangan = $data_array->keterangan;

				$this->load->library('excel');
				$worksheet = $this->excel->getActiveSheet();

				$worksheet->setCellValue('A1','INFO PEGAWAI');
				$worksheet->mergeCells('A1:J1');
				$worksheet->setCellValue('A2','PERIODE TANGGAL : '.date('d F Y',strtotime($awal))." - ".date('d F Y',strtotime($akhir)));
				$worksheet->mergeCells('A2:J2');

				$worksheet->setCellValue('A3','NO. INDUK');
				$worksheet->setCellValue('B3','NAMA');
				$worksheet->mergeCells('A3:A4');
				$worksheet->mergeCells('B3:B4');

				$simpan_bulan_tahun = "";
				$simpan_bulan = "";
				$simpan_tahun = "";
				$hitung_colspan = 1;
				$tanggal_pertama = "";
				$tanggal_terakhir = "";
				$bulan = array (
								1 =>   'Januari',
									'Februari',
									'Maret',
									'April',
									'Mei',
									'Juni',
									'Juli',
									'Agustus',
									'September',
									'Oktober',
									'November',
									'Desember'
								);
				$kolom_header_bulan = 2;
				$simpan_index = 2;
				foreach ($data['tanggal'] as $dt_bulan) {
					if($dt_bulan['bulan'].$dt_bulan['tahun'] !== $simpan_bulan_tahun){
						if ($simpan_bulan !== "") {
							$worksheet->setCellValueByColumnAndRow ($kolom_header_bulan, 3, $bulan[$dt_bulan['bulan']]." ".$dt_bulan['tahun']);
							$kolom_1 = PHPExcel_Cell::stringFromColumnIndex($simpan_index);
							$kolom_2 = PHPExcel_Cell::stringFromColumnIndex($kolom_header_bulan);
							$worksheet->mergeCells($kolom_1.'3:'.$kolom_2.'3');
							$simpan_index = $kolom_header_bulan;
						}else{
							$worksheet->setCellValueByColumnAndRow ($kolom_header_bulan, 3, $bulan[$dt_bulan['bulan']]." ".$dt_bulan['tahun']);
							$simpan_index = $kolom_header_bulan;
						}
					}
					$simpan_bulan_tahun = $dt_bulan['bulan'].$dt_bulan['tahun'];
					$simpan_bulan = $dt_bulan['bulan'];
					$simpan_tahun = $dt_bulan['tahun'];
					$kolom_header_bulan++;
				}
				$kolom_1 = PHPExcel_Cell::stringFromColumnIndex($simpan_index);
				$kolom_2 = PHPExcel_Cell::stringFromColumnIndex($kolom_header_bulan - 1);
				$worksheet->mergeCells($kolom_1.'3:'.$kolom_2.'3');

				$kolom_header_tanggal = 2;
				foreach ($data['tanggal'] as $dt_tanggal) {
					$worksheet->setCellValueByColumnAndRow ($kolom_header_tanggal, 4,$dt_tanggal['hari']);
					$kolom_header_tanggal++;
				}

				$row_body = 5;
				foreach ($data['absen'] as $abs) {
					$worksheet->setCellValue('A'.$row_body,$abs['noind']);
					$worksheet->setCellValue('B'.$row_body,trim($abs['nama']));
					$kolom_body_tanggal = 2;
					foreach ($data['tanggal'] as $dt_tanggal) {
						$keterangan = "-";
						if (isset($abs['data'][$dt_tanggal['index_tanggal']]) and !empty($abs['data'][$dt_tanggal['index_tanggal']])) {
							$keterangan = $abs['data'][$dt_tanggal['index_tanggal']];
						}
						if ($keterangan == "<span style='color: red'>S?</span>") {
							$worksheet->setCellValueByColumnAndRow ($kolom_body_tanggal,$row_body, 'S?');
							$kolom_body_nama = PHPExcel_Cell::stringFromColumnIndex($kolom_body_tanggal);
							$worksheet->getStyle($kolom_body_nama.$row_body)->applyFromArray(
							    array(
							        'font' => array(
							        	'color' => array('rgb' => 'FF0000')
							        )
							    )
							);
						}else{
							$worksheet->setCellValueByColumnAndRow ($kolom_body_tanggal,$row_body, $keterangan);
						}

						$kolom_body_tanggal++;
					}
					$row_body++;
				}

				$worksheet->getColumnDimension('A')->setWidth('10');
				$worksheet->getColumnDimension('B')->setWidth('20');
				for ($i=2; $i < $kolom_body_tanggal; $i++) {
					$nama_kolom = PHPExcel_Cell::stringFromColumnIndex($i);
					$worksheet->getColumnDimension($nama_kolom)->setWidth('5');
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
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					),
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN)
					)
				),'A3:'.$kolom_2.'4');
				$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN)
					)
				),'A5:'.$kolom_2.($row_body - 1));
				$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					)
				),'C5:'.$kolom_2.($row_body - 1));

				$filename ='Arsip-DetailPresensi-'.$awal.'_'.$akhir.'.xls';
				header('Content-Type: aplication/vnd.ms-excel');
				header('Content-Disposition:attachment;filename="'.$filename.'"');
				header('Cache-Control: max-age=0');
				$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
				$writer->save('php://output');
			}
		}
	}
}
?>
