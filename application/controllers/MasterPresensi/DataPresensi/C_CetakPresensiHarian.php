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
				$max_kolom = 4;
				$data[$key] = $worker;
				$shifts = $this->M_cetakpresensiharian->getShiftPekerjaByNoindPeriode($worker['noind'],$tanggal_awal,$tanggal_akhir);
				if (isset($shifts) || !empty($shifts)) {
					foreach ($shifts as $key2 => $shift) {
						$data[$key]['presensi_harian'][$key2] = $shift;
						$data[$key]['presensi_harian'][$key2]['point'] = $this->M_cetakpresensiharian->getPointByNoindTanggal($worker['noind'],$shift['tanggal']);
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
		$data = $this->getData();
		$html = "";

		foreach ($data as $key => $dt) {
			if ($html != "") {
				$html .= "<br>";
			}
			$html .= "
			<table style='page-break-inside: avoid;'>
				<tr>
					<td>No. Induk</td>
					<td>&nbsp;:&nbsp;<td>
					<td>".$dt['noind']."</td>
				</tr>
				<tr>
					<td>Nama</td>
					<td>&nbsp;:&nbsp;<td>
					<td>".$dt['nama']."</td>
				</tr>
				<tr>
					<td>Seksi/Unit</td>
					<td>&nbsp;:&nbsp;<td>
					<td>".$dt['seksi']." / ".$dt['unit']."</td>
				</tr>
			</table>
			";

			$waktu_header = "";
			for ($i=0; $i < $dt['max_kolom']; $i++) { 
				$waktu_header .= "<th>Waktu ".($i+1)."</th>";
			}

			$record = "";
			if (isset($dt['presensi_harian']) && !empty($dt['presensi_harian'])) {
				foreach ($dt['presensi_harian'] as $harian) {
					$waktu_body = "";
					for ($i=0; $i < $dt['max_kolom']; $i++) { 
						if (isset($harian['absen']) && !empty($harian['absen']) && isset($harian['absen'][$i]) && !empty($harian['absen'][$i])) {
							$waktu_body .= "<td style='text-align: center'>".$harian['absen'][$i]['waktu']."</td>";
						}else{
							$waktu_body .= "<td></td>";
						}
					}
					$record .= "
					<tr>
						<td style='text-align: center'>".date('d',strtotime($harian['tanggal']))." ".$this->getMonth(intval(date('m',strtotime($harian['tanggal']))))." ".date('Y',strtotime($harian['tanggal']))."</td>
						<td style='text-align: center'>".$harian['shift']."</td>
						<td style='text-align: center'>".$harian['point']."</td>
						$waktu_body
					</tr>
					";
				}
			}

			$html .= "
			<table style='width: 100%; border: 1px solid black; border-collapse: collapse;' border='1'>
				<thead>
					<tr>
						<th style='width: 15%;'>Tanggal</th>
						<th style='width: 15%;'>Shift</th>
						<th style='width: 10%;'>Point</th>
						$waktu_header
					</tr>
				</thead>
				<tbody>
					$record
				</tbody>
			</table>
			";
		}

		$lokasi_kerja 	= $this->input->get('lokasi_kerja');
		$kode_induk 	= $this->input->get('kode_induk');
		$kodesie 		= $this->input->get('kodesie');
		$noind 			= $this->input->get('noind');
		$periode 		= $this->input->get('tanggal');

		$header = "<table style='width: 100%;border-bottom: 1px solid black;'>
			<tr>
				<td style='width: 20%'>Periode</td>
				<td style='width: 5%'>:</td>
				<td>$periode</td>
			</tr>
		";
		if (isset($lokasi_kerja) && !empty($lokasi_kerja)) {
			$header .= "
			<tr>
				<td>Lokasi Kerja</td>
				<td>:</td>
				<td>$lokasi_kerja</td>
			</tr>
			";
		}
		if (isset($kode_induk) && !empty($kode_induk)) {
			$header .= "
			<tr>
				<td>Kode Induk</td>
				<td>:</td>
				<td>$kode_induk</td>
			</tr>
			";
		}
		if (isset($kodesie) && !empty($kodesie)) {
			$header .= "
			<tr>
				<td>Kodesie</td>
				<td>:</td>
				<td>$kodesie</td>
			</tr>
			";
		}
		if (isset($noind) && !empty($noind)) {
			$header .= "
			<tr>
				<td>No. Induk</td>
				<td>:</td>
				<td>$noind</td>
			</tr>
			";
		}
		$header .= "</table>";
		$html = $header.$html;

		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->debug = true;
		$pdf = new mPDF('utf-8', 'A4', 9, '', 10, 10, 10, 15, 10, 10);
		$filename = 'PRESENSI_HARIAN.pdf';
		$pdf->SetHTMLFooter("<table style='width: 100%;border-top: 1px solid black;'>
				<tr>
					<td style='vertical-align: middle;'><i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP Master Presensi pada oleh ".$this->session->user." - ".$this->session->employee." tgl. ".$waktu." WIB.</i></td>
					<td style='text-align: right;vertical-align: middle;'>{PAGENO} of {nb}</td>
				</tr>
			</table>");
		$pdf->WriteHTML($html);
		$pdf->Output($filename, 'I');	
	}

	public function export_excel()
	{
		$this->load->library('excel');
		$worksheet = $this->excel->getActiveSheet();
		$data = $this->getData();



		$nomor = 1;
		foreach ($data as $dt) {
			$worksheet->setCellValue('A'.($nomor+1),'No. Induk');
			$worksheet->setCellValue('B'.($nomor+1),$dt['noind']);
			$worksheet->mergeCells('B'.($nomor+1).':G'.($nomor+1));

			$worksheet->setCellValue('A'.($nomor+2),'Nama');
			$worksheet->setCellValue('B'.($nomor+2),$dt['nama']);
			$worksheet->mergeCells('B'.($nomor+2).':G'.($nomor+2));

			$worksheet->setCellValue('A'.($nomor+3),'Seksi');
			$worksheet->setCellValue('B'.($nomor+3),$dt['seksi']);
			$worksheet->mergeCells('B'.($nomor+3).':G'.($nomor+3));

			$worksheet->setCellValue('A'.($nomor+4),'Unit');
			$worksheet->setCellValue('B'.($nomor+4),$dt['unit']);
			$worksheet->mergeCells('B'.($nomor+4).':G'.($nomor+4));

			$worksheet->setCellValue('A'.($nomor+6),'Tanggal');
			$worksheet->setCellValue('B'.($nomor+6),'Shift');
			$worksheet->setCellValue('C'.($nomor+6),'Point');

			for ($i=0; $i < $dt['max_kolom']; $i++) { 
				$worksheet->setCellValueByColumnAndRow($i+3,$nomor+6,"waktu ".($i+1));

			}

			$nomor += 7;
			if (isset($dt['presensi_harian']) && !empty($dt['presensi_harian'])) {
				foreach ($dt['presensi_harian'] as $harian) {
					$worksheet->setCellValue('A'.($nomor),date('d',strtotime($harian['tanggal']))." ".$this->getMonth(intval(date('m',strtotime($harian['tanggal']))))." ".date('Y',strtotime($harian['tanggal'])));
					$worksheet->setCellValue('B'.($nomor),$harian['shift']);
					$worksheet->setCellValue('C'.($nomor),$harian['point']);
					for ($i=0; $i < $dt['max_kolom']; $i++) { 
						if (isset($harian['absen']) && !empty($harian['absen']) && isset($harian['absen'][$i]) && !empty($harian['absen'][$i])) {
							$worksheet->setCellValueByColumnAndRow($i+3,$nomor,$harian['absen'][$i]['waktu']);
						}
					}
					$nomor++;
				}
			}

		}

		$filename ='PRESENSI_HARIAN.xls';
		header('Content-Type: aplication/vnd.ms-excel');
		header('Content-Disposition:attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
		$writer->save('php://output');
	}

	function getKodesie()
	{
		$data= $this->M_cetakpresensiharian->getKodesie();
		echo json_encode($data);
	}

}
?>