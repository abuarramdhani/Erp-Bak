<?php 
Defined('BASEPATH') or exit('No DIrect Script Access Allowed');
ini_set('date.timezone', 'Asia/Jakarta');
ini_set('memory_limit', '2048M');
set_time_limit(0);
/**
 * 
 */
class C_CetakPresensiHarian extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPresensi/DataPresensi/M_cetakpresensiharian');
		$this->checkSession();
	}

	function checkSession()
	{
		if (!$this->session->is_logged) redirect('');
	}

	public function index()
	{
		$user_id = $this->session->userid;
		
		$data['Title'] = 'Cetak Presensi Harian';
		$data['Header'] = 'Cetak Presensi Harian';
		$data['Menu'] = 'Data Presensi';
		$data['SubMenuOne'] = 'Cetak Presensi Harian';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['lokasi_kerja'] = $this->M_cetakpresensiharian->getLokasiKerja();
		$data['kode_induk'] = $this->M_cetakpresensiharian->getKodeInduk();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/DataPresensi/CetakPresensiHarian/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getPekerja()
	{
		$key = $this->input->get('term');
		$data = $this->M_cetakpresensiharian->getPekerjaByKey($key);
		echo json_encode($data);
	}

	public function transformFilter($ingredients)
	{
		$result = "";
		if (isset($ingredients) && !empty($ingredients)) {
			foreach (explode(",", $ingredients) as $ing) {
				if ($result == "") {
					$result .= "'$ing'";
				}else{
					$result .= ",'$ing'";
				}
			}
			return $result;
		}else{
			return false;
		}
			
	}

	public function getData()
	{
		$lokasi_kerja 	= $this->input->get('lokasi_kerja');
		$kode_induk 	= $this->input->get('kode_induk');
		$kodesie 		= $this->input->get('kodesie');
		$noind 			= $this->input->get('noind');

		$periode 		= $this->input->get('tanggal');
		$tanggal_awal = explode(" - ", $periode)[0];
		$tanggal_akhir = explode(" - ", $periode)[1];

		$filter = array(
			'lokasi_kerja' 	=> $this->transformFilter($lokasi_kerja),
			'kode_induk' 	=> $this->transformFilter($kode_induk),
			'kodesie' 		=> $this->transformFilter($kodesie),
			'noind' 		=> $this->transformFilter($noind)
		);


		$workers = $this->M_cetakpresensiharian->getPekerjaByFilter($filter,$tanggal_awal,$tanggal_akhir);
		$data = array();
		if (isset($workers) && !empty($workers)) {
			foreach ($workers as $key => $worker) {
				$max_kolom = 2;
				$data[$key] = $worker;
				$shifts = $this->M_cetakpresensiharian->getShiftPekerjaByNoindPeriode($worker['noind'],$tanggal_awal,$tanggal_akhir);
				if (isset($shifts) || !empty($shifts)) {
					foreach ($shifts as $key2 => $shift) {
						$data[$key]['presensi_harian'][$key2] = $shift;
						$data[$key]['presensi_harian'][$key2]['point'] = $this->M_cetakpresensiharian->getPointByNoindTanggal($worker['noind'],$shift['tanggal']);
						$data[$key]['presensi_harian'][$key2]['ket'] = $this->M_cetakpresensiharian->getketeranganByNoindTanggal($worker['noind'],$shift['tanggal']);
						$data[$key]['presensi_harian'][$key2]['absen'] = $this->M_cetakpresensiharian->getPresensiHarianByNoindTanggal($worker['noind'],$shift['tanggal']);
						if ($max_kolom < count($data[$key]['presensi_harian'][$key2]['absen'])) {
							$max_kolom = count($data[$key]['presensi_harian'][$key2]['absen']);
						}
					}
				}
				$data[$key]['max_kolom'] = $max_kolom;
			}

		}
		return $data;
	}

	public function getMonth($number)
	{
		$bulan = array(
			1 => 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'
		);
		return $bulan[$number];
	}

	public function export_pdf()
	{
		$data['data'] 			= $this->getData();
		$data['lokasi_kerja'] 	= $this->input->get('lokasi_kerja');
		$data['kode_induk'] 	= $this->input->get('kode_induk');
		$data['kodesie'] 		= $this->input->get('kodesie');
		$data['noind'] 			= $this->input->get('noind');
		$data['periode'] 		= $this->input->get('tanggal');
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->debug = true;
		$pdf = new mPDF('utf-8', 'A4', 9, '', 10, 10, 10, 15, 10, 10);
		$filename = 'PRESENSI_HARIAN_'.$data['lokasi_kerja'].'_'.$data['kode_induk'].'.pdf';
		$html = $this->load->view('MasterPresensi/DataPresensi/CetakPresensiHarian/V_Pdf', $data, true);
		
		$waktu = date('d/M/Y H:i:s');
		$pdf->SetHTMLFooter("<table style='width: 100%;border-top: 1px solid black;'>
				<tr>
					<td style='vertical-align: middle;'><i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP Master Presensi pada oleh ".$this->session->user." - ".$this->session->employee." tgl. ".$waktu." WIB.</i></td>
					<td style='text-align: right;vertical-align: middle;'>{PAGENO} of {nb}</td>
				</tr>
			</table>");
		$pdf->WriteHTML($html);
		$pdf->Output($filename, 'D');	
	}

	function generate_excel_structure(){
		$this->load->library('excel');
		$worksheet = $this->excel->getActiveSheet();
		$data = $this->getData();
		$lokasi_kerja 	= $this->input->get('lokasi_kerja');
		$kode_induk 	= $this->input->get('kode_induk');
		$kodesie 		= $this->input->get('kodesie');
		$noind 			= $this->input->get('noind');
		$periode 		= $this->input->get('tanggal');
		$prd = explode(" - ", $periode);

		$awal = date("d",strtotime($prd[0]))." ".$this->getMonth(intval(date("m",strtotime($prd[0]))))." ".date("Y",strtotime($prd[0]));
		$akhir = date("d",strtotime($prd[1]))." ".$this->getMonth(intval(date("m",strtotime($prd[1]))))." ".date("Y",strtotime($prd[1]));
		$worksheet->setCellValue('A1','Periode');
		$worksheet->setCellValue('B1',$awal." s/d ".$akhir);
		
		$nomor = 2;
		if (isset($lokasi_kerja) && !empty($lokasi_kerja)) {
			$worksheet->setCellValue('A'.$nomor,'Lokasi Kerja');
			$worksheet->setCellValue('B'.$nomor,$lokasi_kerja);
			$nomor++;
		}

		if (isset($kode_induk) && !empty($kode_induk)) {
			$worksheet->setCellValue('A'.$nomor,'Kode Induk');
			$worksheet->setCellValue('B'.$nomor,$kode_induk);
			$nomor++;
		}

		if (isset($kodesie) && !empty($kodesie)) {
			$worksheet->setCellValue('A'.$nomor,'Kodesie');
			$worksheet->setCellValue('B'.$nomor,$kodesie);
			$nomor++;
		}

		if (isset($noind) && !empty($noind)) {
			$worksheet->setCellValue('A'.$nomor,'No. Induk');
			$worksheet->setCellValue('B'.$nomor,$noind);
			$nomor++;
		}
		
		$nomor++;
		$kolom_min = 0;
		$kolom_max = 4;
		$printed = 0;
		$kolom_max_all = $kolom_max;
		$simpan_row_min = 0;
		foreach ($data as $dt) {
			$simpan_row_min = $nomor;
			$nomor += 1;
			$row_min = $nomor;
			$kolom_a = PHPExcel_Cell::stringFromColumnIndex($kolom_min);
			$kolom_b = PHPExcel_Cell::stringFromColumnIndex($kolom_min + 1);
			$kolom_c = PHPExcel_Cell::stringFromColumnIndex($kolom_min + 2);
			$kolom_d = PHPExcel_Cell::stringFromColumnIndex($kolom_min + 3);
			$kolom_e = PHPExcel_Cell::stringFromColumnIndex($kolom_min + 4);
			$kolom_f = PHPExcel_Cell::stringFromColumnIndex($kolom_min + 5);
			$kolom_g = PHPExcel_Cell::stringFromColumnIndex($kolom_min + 6);

			$worksheet->setCellValue($kolom_a.$nomor,'No. Induk');
			$worksheet->setCellValue($kolom_b.$nomor,$dt['noind']);
			$worksheet->mergeCells($kolom_b.$nomor.':'.$kolom_f.$nomor);

			$nomor += 1;
			$worksheet->setCellValue($kolom_a.$nomor,'Nama');
			$worksheet->setCellValue($kolom_b.$nomor,$dt['nama']);
			$worksheet->mergeCells($kolom_b.$nomor.':'.$kolom_f.$nomor);

			$nomor += 1;
			$worksheet->setCellValue($kolom_a.$nomor,'Unit');
			$worksheet->setCellValue($kolom_b.$nomor,$dt['unit']);
			$worksheet->mergeCells($kolom_b.$nomor.':'.$kolom_f.$nomor);

			$nomor += 1;
			$worksheet->setCellValue($kolom_a.$nomor,'Seksi');
			$worksheet->setCellValue($kolom_b.$nomor,$dt['seksi']);
			$worksheet->mergeCells($kolom_b.$nomor.':'.$kolom_f.$nomor);

			$kolom_kiri = PHPExcel_Cell::stringFromColumnIndex($kolom_min);
			$kolom_kanan = PHPExcel_Cell::stringFromColumnIndex($kolom_min + $kolom_max + 1);
			$worksheet->duplicateStyleArray(
			array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				)
			),$kolom_kiri.$row_min.':'.$kolom_kanan.$nomor);

			$nomor += 1;
			$worksheet->getRowDimension($nomor)->setRowHeight(5);

			$nomor += 1;
			$row_min = $nomor;
			$worksheet->setCellValue($kolom_a.$nomor,'Tanggal');
			$worksheet->setCellValue($kolom_b.$nomor,'Shift');
			$worksheet->setCellValue($kolom_c.$nomor,'Point');

			$tmp_kolom_max = $kolom_max;
			for ($i=0; $i < $dt['max_kolom']; $i++) { 
				if ($kolom_max < $i + 3) {
					$kolom_max = $i + 3;
				}
				if ($kolom_max > $kolom_max_all) {
					$kolom_max_all = $kolom_max;
				}
				$worksheet->setCellValueByColumnAndRow($i+3 + $kolom_min,$nomor,"waktu ".($i+1));

			}
			$kolom_max++;
			$kolom_kanan = PHPExcel_Cell::stringFromColumnIndex($kolom_min + $kolom_max);
			$worksheet->setCellValue($kolom_kanan.$nomor,'Keterangan');

			$kolom_kiri = PHPExcel_Cell::stringFromColumnIndex($kolom_min);
			// $kolom_max++;
			$kolom_kanan = PHPExcel_Cell::stringFromColumnIndex($kolom_min + $kolom_max);

			$this->excel->getActiveSheet()->duplicateStyleArray(
			array(
				'fill' =>array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
							'argb' => '0060A5FA'
						)
				)
			),$kolom_kiri.$row_min.':'.$kolom_kanan.$nomor);

			$nomor += 1;
			if (isset($dt['presensi_harian']) && !empty($dt['presensi_harian'])) {
				foreach ($dt['presensi_harian'] as $harian) {
					$worksheet->setCellValue($kolom_a.($nomor),date('d',strtotime($harian['tanggal']))." ".$this->getMonth(intval(date('m',strtotime($harian['tanggal']))))." ".date('Y',strtotime($harian['tanggal'])));
					$worksheet->setCellValue($kolom_b.($nomor),$harian['shift']);
					$worksheet->setCellValue($kolom_c.($nomor),$harian['point'] != "0" ? $harian['point'] : '');
					for ($i=0; $i < $dt['max_kolom']; $i++) { 
						if (isset($harian['absen']) && !empty($harian['absen']) && isset($harian['absen'][$i]) && !empty($harian['absen'][$i])) {
							$worksheet->setCellValueByColumnAndRow($i+3 + $kolom_min,$nomor,$harian['absen'][$i]['waktu']);
						}
					}
					$worksheet->setCellValueByColumnAndRow($i+3 + $kolom_min,$nomor,$harian['ket']);
					$nomor++;
				}
			}

			$worksheet->duplicateStyleArray(
			array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				)
			),$kolom_kiri.$row_min.':'.$kolom_kanan.($nomor -1));
			$kolom_max = $tmp_kolom_max;
			$printed++;
			if ($printed%5 == 0) { // kebawah
				$nomor += 2;
				$kolom_min = 0;
				$kolom_max = 4;
				$kolom_max_all = $kolom_max;
			}else{ // ke samping
				$kolom_min += $kolom_max_all + 3;
				$nomor = $simpan_row_min;
				$kolom_max = 4;
				$kolom_max_all = $kolom_max;
			}
		}
	}

	public function export_excel()
	{
		$this->generate_excel_structure();

		$filename ='PRESENSI_HARIAN.xls';
		header('Content-Type: aplication/vnd.ms-excel');
		header('Content-Disposition:attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
		$writer->save('php://output');
	}

	function view_excel()
	{
		$this->generate_excel_structure();

		$data['filename'] ='PRESENSI_HARIAN'.time().'.xls';
		// header('Content-Type: aplication/vnd.ms-excel');
		// header('Content-Disposition:attachment;filename="'.$data['filename'].'"');
		// header('Cache-Control: max-age=0');
		$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
		$writer->save(str_replace(__FILE__, 'assets/generated/CetakPresensiHarian/'.$data['filename'], __FILE__));

		$this->load->view('MasterPresensi/DataPresensi/CetakPresensiHarian/V_Excel',$data);
	}

	function getKodesie()
	{
		$key = $this->input->get('term');
		$kodesie = $this->input->get('prev');
		$tingkat = $this->input->get('tingkat');

		$data= $this->M_cetakpresensiharian->getKodesie($key,$kodesie,$tingkat);
		
		echo json_encode($data);
	}

	function getSeksi()
	{
		$kodesie = $this->input->get('kodesie');

		$data= $this->M_cetakpresensiharian->getSeksiByKodesie($kodesie);

		echo json_encode($data);
	}

}
?>