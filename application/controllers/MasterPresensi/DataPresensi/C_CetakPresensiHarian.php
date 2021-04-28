<?php 
Defined('BASEPATH') or exit('No DIrect Script Access Allowed');

set_time_limit(1800);
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

	public function getData()
	{
		$lokasi_kerja = $this->input->get('lokasi_kerja');
		$kode_induk = $this->input->get('kode_induk');
		$periode = $this->input->get('tanggal');
		$tanggal_awal = explode(" - ", $periode)[0];
		$tanggal_akhir = explode(" - ", $periode)[1];

		$filter = array();
		$filter_lokasi_kerja = "";
		if (isset($lokasi_kerja) && !empty($lokasi_kerja)) {
			foreach (explode(",", $lokasi_kerja) as $lks) {
				if ($filter_lokasi_kerja == "") {
					$filter_lokasi_kerja .= "'$lks'";
				}else{
					$filter_lokasi_kerja .= ",'$lks'";
				}
			}
			$filter['lokasi_kerja'] = $filter_lokasi_kerja;
		}
		$filter_kode_induk = "";
		if (isset($kode_induk) && !empty($kode_induk)) {
			foreach (explode(",", $kode_induk) as $kdi) {
				if ($filter_kode_induk == "") {
					$filter_kode_induk .= "'$kdi'";
				}else{
					$filter_kode_induk .= ",'$kdi'";
				}
			}
			$filter['kode_induk'] = $filter_kode_induk;
		}

		$workers = $this->M_cetakpresensiharian->getPekerjaByFilter($filter,$tanggal_awal);
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

	public function cetak_pdf()
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


		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->debug = true;
		$pdf = new mPDF('utf-8', 'A4', 10, '', 10, 10, 10, 10, 10, 10);
		$filename = 'PRESENSI_HARIAN.pdf';
		$pdf->WriteHTML($html);
		$pdf->Output($filename, 'I');
		
	}

}
?>