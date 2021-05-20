<?php 
defined("BASEPATH") or exit("No DIrect Script Access Allowed");
ini_set('date.timezone', 'Asia/Jakarta');
ini_set('memory_limit', '2048M');
set_time_limit(0);
/**
 * 
 */
class C_DetailPresensi extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPresensi/DataPresensi/M_detailpresensi');
		$this->checkSession();
	}

	function checkSession()
	{
		if (!$this->session->is_logged) redirect('');
	}

	public function index()
	{
		$user_id = $this->session->userid;
		
		$data['Title'] = 'Detail Presensi';
		$data['Header'] = 'Detail Presensi';
		$data['Menu'] = 'Data Presensi';
		$data['SubMenuOne'] = 'Detail Presensi';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['lokasi_kerja'] = $this->M_detailpresensi->getLokasiKerja();
		$data['kode_induk'] = $this->M_detailpresensi->getKodeInduk();
		$data['tanggal'] = $this->M_detailpresensi->getTanggalDefault();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/DataPresensi/DetailPresensi/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	function getAbsen($jenis_presensi, $jenis_tampilan, $kode_induk, $lokasi_kerja, $periode, $pekerja_keluar, $periode_pekerja_keluar,$kodesie){
    	
    	if ($jenis_presensi == "Presensi") {
    		$absen = $this->M_detailpresensi->getAbsenByParams($kode_induk,$lokasi_kerja,$periode,$pekerja_keluar,$periode_pekerja_keluar,$kodesie);
			$datareal = array();
			$simpan_noind = "";
			$angka = 0;
			foreach ($absen as $key) {
				$keterangan = "";
				$susulan_ct = array();
				$susulan_psk = array();
				if ($simpan_noind !== $key['noind']) {
					$angka++;
					$datareal[$angka] = array(
							'nama' 	=> $key['nama'],
							'noind' => $key['noind'],
							'unit' 	=> $key['unit'],
							'seksi' => $key['seksi'],
							'data' 	=> array()
						);
				}

				if ($key['kd_ket'] == "TT") {
					$keterangan = "T";
				}elseif($key['kd_ket'] == "TM"){
					$keterangan = "M";
				}elseif ($key['kd_ket'] == "TIK") {
					$keterangan = $this->M_detailpresensi->getProporsionalTIK($key['noind'],$key['tanggal']);
				}elseif ($key['kd_ket'] == "CT") {
					$susulan_ct = $this->M_detailpresensi->getSusulan("CT",$key['noind'],$key['tanggal']);
					if (!empty($susulan_ct)) {
						$keterangan = "CT*";
					}else{
						$keterangan = "CT";
					}
				}elseif ($key['kd_ket'] == "PSK") {
					$susulan_psk = $this->M_detailpresensi->getSusulan("SK",$key['noind'],$key['tanggal']);
					if (!empty($susulan_psk)) {
						$keterangan = "SK*";
					}else{
						$keterangan = "SK";
					}
				}elseif ($key['kd_ket'] !== "PKJ" and $key['kd_ket'] !== "PLB" and $key['kd_ket'] !== "HL") {
					$keterangan = substr($key['kd_ket'], -2);
				}elseif ($key['kd_ket'] !== "HL") {
					if ($jenis_tampilan == "1") {
						$keterangan = "/";
					}else{
						$keterangan = $this->M_detailpresensi->getInisial($key['noind'],$key['tanggal']);
					}

				}

				if ($keterangan !== "") {
					$datareal[$angka]['data'][$key['index_tanggal']] = $keterangan;
				}
				$simpan_noind = $key['noind'];
			}
    	}else{
    		$absen = $this->M_detailpresensi->getLemburByParams($kode_induk,$lokasi_kerja,$periode,$pekerja_keluar,$periode_pekerja_keluar,$kodesie);
			$datareal = array();
			$simpan_noind = "";
			$angka = 0;
			foreach ($absen as $key) {
				$keterangan = "";
				$susulan_ct = array();
				$susulan_psk = array();
				if ($simpan_noind !== $key['noind']) {
					$angka++;
					$datareal[$angka] = array(
							'nama' 	=> $key['nama'],
							'noind' => $key['noind'],
							'unit' 	=> $key['unit'],
							'seksi' => $key['seksi'],
							'total' => 0,
							'data' 	=> array()
						);
				}


				$keterangan = round(floatval($key['total_lembur']),2);

				$datareal[$angka]['data'][$key['index_tanggal']] = $keterangan;
				$datareal[$angka]['total'] += $keterangan;

				$simpan_noind = $key['noind'];
			}
    	}

    	return $datareal;
	}

	function getData(){
		$jenis_presensi 		= $this->input->get('jenisPresensi');
    	$jenis_tampilan 		= $this->input->get('jenisTampilan');
    	$kode_induk 			= $this->input->get('kodeInduk');
    	$lokasi_kerja 			= $this->input->get('lokasiKerja');
    	$periode 				= $this->input->get('periodeAbsen');
    	$pekerja_keluar 		= $this->input->get('pekerjaKeluar');
    	$periode_pekerja_keluar = $this->input->get('periodePekerjaKeluar');
    	$kodesie 				= $this->input->get('kodesie');

    	$datareal = $this->getAbsen($jenis_presensi, $jenis_tampilan, $kode_induk, $lokasi_kerja, $periode, $pekerja_keluar, $periode_pekerja_keluar, $kodesie);
    	$data = array();

		$data_tanggal = $this->M_detailpresensi->getTanggalByParams($periode);
    	//header awal
		$header_bulan = '<th class="bg-primary" rowspan="2" style="text-align: center;vertical-align: middle;">No. Induk</th>
						<th class="bg-primary" rowspan="2" style="text-align: center;vertical-align: middle;">Nama</th>
						<th class="bg-primary" rowspan="2" style="text-align: center;vertical-align: middle;">Unit</th>
						<th class="bg-primary" rowspan="2" style="text-align: center;vertical-align: middle;">Seksi</th>';
		$header_tanggal = "";
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
		foreach ($data_tanggal as $dt_bulan) {
			$header_tanggal .= "<th class='bg-primary' style='text-align: center'>".$dt_bulan['hari']."</th>";
			if($dt_bulan['bulan'].$dt_bulan['tahun'] == $simpan_bulan_tahun){
				$hitung_colspan++;
			}else{
				if ($simpan_bulan !== "") {
					$header_bulan .= "<th class='bg-primary' colspan='".$hitung_colspan."' style='text-align: center'>".$bulan[$simpan_bulan]." ".$simpan_tahun."</th>";
					$hitung_colspan = 1;
				}else{
					$tanggal_pertama = $dt_bulan['tanggal'];
				}
			}
			$simpan_bulan_tahun = $dt_bulan['bulan'].$dt_bulan['tahun'];
			$simpan_bulan = $dt_bulan['bulan'];
			$simpan_tahun = $dt_bulan['tahun'];
		}
		$header_bulan .= "<th class='bg-primary' colspan='".$hitung_colspan."' style='text-align: center'>".$bulan[$simpan_bulan]." ".$simpan_tahun."</th>";
		if ($jenis_presensi != "Presensi") {
			$header_bulan .= '<th class="bg-primary" rowspan="2" style="text-align: center;vertical-align: middle;">Total Lembur</th>';
		}
		$tanggal_terakhir = $dt_bulan['tanggal'];
		$data['header'] = "<tr>$header_bulan</tr><tr>$header_tanggal</tr>";
		//header akhir
		//body awal
		$body = "";
		foreach ($datareal as $abs) {
			$body .= "<tr><td style='text-align: center;vertical-align: middle'>".$abs['noind'];
			$body .= "<input type='hidden' value='".$tanggal_pertama." - ".$tanggal_terakhir."'>";
			$body .= "</td><td>".$abs['nama']."</td>";
			$body .= "</td><td>".$abs['unit']."</td>";
			$body .= "</td><td>".$abs['seksi']."</td>";
			foreach ($data_tanggal as $dt_tanggal) {
				$keterangan = "-";
				if (isset($abs['data'][$dt_tanggal['index_tanggal']]) and !empty($abs['data'][$dt_tanggal['index_tanggal']])) {
					$keterangan = $abs['data'][$dt_tanggal['index_tanggal']];
				}
				$body .= "<td style='text-align: center;vertical-align: middle'>$keterangan</td>";
			}
			if ($jenis_presensi != "Presensi") {
				$body .= "<td>".$abs['total']."</td>";
			}
			$body .= "</tr>";
		}
		$data['body'] = $body;
		//body akhir
    	echo json_encode($data);
	}

	function getPdf(){
		$jenis_presensi 		= $this->input->get('jenisPresensi');
    	$jenis_tampilan 		= $this->input->get('jenisTampilan');
    	$kode_induk 			= $this->input->get('kodeInduk');
    	$lokasi_kerja 			= $this->input->get('lokasiKerja');
    	$periode 				= $this->input->get('periodeAbsen');
    	$pekerja_keluar 		= $this->input->get('pekerjaKeluar');
    	$periode_pekerja_keluar = $this->input->get('periodePekerjaKeluar');
    	$kodesie 				= $this->input->get('kodesie');

		$data['datareal'] 		= $this->getAbsen($jenis_presensi, $jenis_tampilan, $kode_induk, $lokasi_kerja, $periode, $pekerja_keluar, $periode_pekerja_keluar, $kodesie);
		$data['jenis_presensi'] = $jenis_presensi;
		$data['tanggal'] 		= $this->M_detailpresensi->getTanggalByParams($periode);
		$data['periode'] 		= $periode;
		$data['bulan'] 			= array (
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
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->debug = true;
		// echo "<pre>";print_r($data['datareal']);exit();
		$pdf = new mPDF('utf-8', 'A4-L', 8, 'courier', 5, 5, 10, 10, 5, 5);
		$filename = 'Detail_'.$jenis_presensi.'_'.$periode.'_'.$kode_induk."_".$lokasi_kerja.'.pdf';
		$html = $this->load->view('MasterPresensi/DataPresensi/DetailPresensi/V_Pdf', $data, true);
		$waktu = date('d/M/Y H:i:s');

		$prd = explode(" - ", $periode);
		$awal = $prd[0];
		$akhir = $prd[1];

		$head = "";
		if (!empty(trim($kodesie)) && trim($kodesie) != "0") {
			$head .= " kodesie : ".$kodesie;
		}
		if (!empty(trim($lokasi_kerja)) && trim($lokasi_kerja) != "0") {
			$head .= " lokasi kerja : ".$lokasi_kerja;
		}
		if (!empty(trim($kode_induk)) && trim($kode_induk) != "0") {
			$head .= " kode induk : ".$kode_induk;
		}
		if (!empty(trim($pekerja_keluar)) && trim($pekerja_keluar) != "false") {
			$head .= " Pekerja Keluar";
		}

		$pdf->SetHTMLHeader("<table style='width: 100%;border-bottom: 1px solid black;'>
				<tr>
					<td style='width: 50%'>Data Rekap $jenis_presensi Periode ".date("d F Y", strtotime($awal))." s/d ".date("d F Y", strtotime($akhir))."</td>
					<td style='width: 50%'>$head</td>
				</tr>
			</table>");
		$pdf->SetHTMLFooter("<table style='width: 100%;border-top: 1px solid black;'>
				<tr>
					<td style='vertical-align: middle;'><i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP Master Presensi pada oleh ".$this->session->user." - ".$this->session->employee." tgl. ".$waktu." WIB.</i></td>
					<td style='text-align: right;vertical-align: middle;'>{PAGENO} of {nb}</td>
				</tr>
			</table>");
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');

	}

	function getExcel(){
		$jenis_presensi 		= $this->input->get('jenisPresensi');
    	$jenis_tampilan 		= $this->input->get('jenisTampilan');
    	$kode_induk 			= $this->input->get('kodeInduk');
    	$lokasi_kerja 			= $this->input->get('lokasiKerja');
    	$periode 				= $this->input->get('periodeAbsen');
    	$pekerja_keluar 		= $this->input->get('pekerjaKeluar');
    	$periode_pekerja_keluar = $this->input->get('periodePekerjaKeluar');
    	$kodesie 				= $this->input->get('kodesie');

    	$data = $this->getAbsen($jenis_presensi, $jenis_tampilan, $kode_induk, $lokasi_kerja, $periode, $pekerja_keluar, $periode_pekerja_keluar,$kodesie);
    	$data_tanggal = $this->M_detailpresensi->getTanggalByParams($periode);
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

		$this->load->library('excel');
		$worksheet = $this->excel->getActiveSheet();

		$prd = explode(" - ", $periode);
		$awal = $prd[0];
		$akhir = $prd[1];

		$worksheet->setCellValue('A1',"Data Rekap $jenis_presensi");
		$worksheet->mergeCells('A1:C1');
		$worksheet->setCellValue('A2',"Periode ".date("d F Y", strtotime($awal))." s/d ".date("d F Y", strtotime($akhir)));
		$worksheet->mergeCells('A2:C2');

		$worksheet->setCellValue('A3','No.');
		$worksheet->mergeCells('A3:A4');
		$worksheet->setCellValue('B3','No. Induk');
		$worksheet->mergeCells('B3:B4');
		$worksheet->setCellValue('C3','Nama');
		$worksheet->mergeCells('C3:C4');
		$worksheet->setCellValue('D3','Unit');
		$worksheet->mergeCells('D3:D4');
		$worksheet->setCellValue('E3','Seksi');
		$worksheet->mergeCells('E3:E4');
		$simpan_kolom = "F";
		for ($i=0; $i < count($data_tanggal); $i++) { 
			if ($i == count($data_tanggal) -1 || $data_tanggal[$i]['bulan'] != $data_tanggal[$i+1]['bulan']) {
				$current_kolom = PHPExcel_Cell::stringFromColumnIndex($i + 5);
				$worksheet->setCellValue($simpan_kolom.'3',$bulan[$data_tanggal[$i]['bulan']]." ".$data_tanggal[$i]['tahun']);
				$worksheet->mergeCells($simpan_kolom.'3:'.$current_kolom.'3');
				$simpan_kolom = PHPExcel_Cell::stringFromColumnIndex($i + 6);
			}
		}
		foreach ($data_tanggal as $key => $tanggal) {
			$worksheet->setCellValueByColumnAndRow(5+$key,4,$tanggal['hari']);
		}

		if ($jenis_presensi != "Presensi") {
			$last_date_kolom = $current_kolom;
			$current_kolom = $simpan_kolom;
			$worksheet->setCellValue($current_kolom.'3','Total Lembur');
			$worksheet->mergeCells($current_kolom.'3:'.$current_kolom.'4');
		}

		$row = 4;
		foreach ($data as $key_pkj => $pkj) {
			$row = $key_pkj + 4;
			$worksheet->setCellValue('A'.$row,$key_pkj);
			$worksheet->setCellValue('B'.$row,$pkj['noind']);
			$worksheet->setCellValue('C'.$row,$pkj['nama']);
			$worksheet->setCellValue('D'.$row,$pkj['unit']);
			$worksheet->setCellValue('E'.$row,$pkj['seksi']);
			
			foreach ($data_tanggal as $key_tgl => $tgl) {
				$keterangan = "-";
				if (isset($pkj['data'][$tgl['index_tanggal']])) {
					$keterangan = $pkj['data'][$tgl['index_tanggal']];
				}
				$worksheet->setCellValueByColumnAndRow(5+$key_tgl,$row,$keterangan);
			}
			if ($jenis_presensi != "Presensi") {
				$worksheet->setCellValue($current_kolom.$row,'=SUM(F'.$row.':'.$last_date_kolom.$row.')');
			}
		}

		$worksheet->duplicateStyleArray(
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				)
			),'A3:'.$current_kolom.$row);
		$worksheet->duplicateStyleArray(
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				)
			),'C4:E'.$row);
		$this->excel->getActiveSheet()->duplicateStyleArray(
			array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				)
			),'A3:'.$current_kolom.$row);

		if ($jenis_presensi == "Presensi") {
			$warna= "006EE7B7";
		}else{
			$warna = "00C4B5FD";
		}

		$this->excel->getActiveSheet()->duplicateStyleArray(
			array(
				'fill' =>array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
							'argb' => $warna
						)
				)
			),'A3:'.$current_kolom.'4');

		$worksheet->getColumnDimension('A')->setWidth('5');
		$worksheet->getColumnDimension('B')->setWidth('10');
		$worksheet->getColumnDimension('C')->setWidth('20');
		$worksheet->getColumnDimension('D')->setWidth('20');
		$worksheet->getColumnDimension('E')->setWidth('20');
		for ($i=0; $i < count($data_tanggal); $i++) {
			$nama_kolom = PHPExcel_Cell::stringFromColumnIndex($i + 5);
			$worksheet->getColumnDimension($nama_kolom)->setWidth('5');
		}

		$worksheet->freezePane('D5');

		$filename ='Detail_'.$jenis_presensi.'_'.$periode.'_'.$kode_induk."_".$lokasi_kerja.'.xls';
		header('Content-Type: aplication/vnd.ms-excel');
		header('Content-Disposition:attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
		$writer->save('php://output');
	}

	function getWaktu(){
		$periode = $this->input->get('periode');
    	$prd = explode(" - ", $periode);
    	$noind = $this->input->get('noind');
    	$data = $this->M_detailpresensi->getWaktuAbsen(trim($noind),$prd['0'],$prd['1']);
    	echo json_encode($data);
		// print_r($_GET);
	}

	function getKodesie()
	{
		$key = $this->input->get('term');
		$kodesie = $this->input->get('prev');
		$tingkat = $this->input->get('tingkat');

		$data= $this->M_detailpresensi->getKodesie($key,$kodesie,$tingkat);
		
		echo json_encode($data);
	}
}

?>