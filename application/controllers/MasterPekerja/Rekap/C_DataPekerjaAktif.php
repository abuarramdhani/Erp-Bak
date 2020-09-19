<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class C_DataPekerjaAktif extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('Log_Activity');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('upload');
		$this->load->library('General');
		$this->load->library('pdf');
		$this->load->library('KonversiBulan');

		$this->load->model('MasterPekerja/Rekap/M_lapkunjungan');
		$this->load->model('MasterPekerja/Rekap/M_rekapkecelakaan');
		$this->load->model('MasterPekerja/Rekap/M_datapekerjaaktif');
		$this->load->model('SiteManagement/MainMenu/M_ordermobile');
		$this->load->model('CivilMaintenanceOrder/M_civil');
		$this->load->model('MasterPekerja/CetakDataPekerja/M_datapekerja');
		$pdf 	=	$this->pdf->load();
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

	public function index()
	{
		$data  = $this->general->loadHeaderandSidemenu('Master Pekerja', 'Data Pekerja Aktif', 'Rekap', 'Data Pekerja Aktif', '');
		$data['loker'] = $this->M_datapekerja->getLokasiKerja('');
		// print_r($loker);exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Rekap/DataPekerjaAktif/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function get_datapekerjaaktif()
	{
		$lokasi = $this->input->get('lokasi');
		$tanggal = $this->input->get('tanggal');

		$tgl = date('F', strtotime($tanggal));
		$etgl = explode('-', $tanggal);
		$tgl = $this->konversibulan->KonversiKeBulanIndonesia($tgl);
		$tgl = $etgl[2].' '.$tgl.' '.$etgl[0];

		$loker = $this->M_datapekerjaaktif->getLokasiKerjabyID($lokasi);
		$loker = $loker['lokasi_kerja'];
		if ($lokasi == '00') {
			$lokasi = '';
			$loker = 'SEMUA LOKASI KERJA';
		}
		$list = $this->M_datapekerjaaktif->dpa_getListSeksi();
		$allArr = array();
		$x = 0;
		$a = 0; $e = 0; $f = 0; $q = 0; $h = 0; $b = 0; $d = 0; $g = 0; $j = 0; $l = 0; $k = 0; $c = 0; $t = 0; $max = 0;
		foreach ($list as $key) {
			if($key['seksi'] != '-')
				$txt = $key['seksi'];
			elseif($key['unit'] != '-')
				$txt = "UNIT ".$key['unit'];
			elseif($key['bidang'] != '-')
				$txt = "BIDANG ".$key['bidang'];
			elseif($key['dept'] != '-')
				$txt = "DEPT ".$key['dept'];
			else 
				$txt = '-';

			if ($key['seksi'] == '-' || $key['seksi'] == '') {
				$x++;
				$angka = $x;
			}else{
				$angka = '';
			}

			$row = $this->M_datapekerjaaktif->getPerRow2($lokasi, $tanggal, $key['kodesie']);

			$a += $row['a'];
			$e += $row['e'];
			$f += $row['f'];
			$q += $row['q'];
			$h += $row['h'];
			$b += $row['b'];
			$d += $row['d'];
			$g += $row['g'];
			$j += $row['j'];
			$l += $row['l'];
			$k += $row['k'];
			$c += $row['c'];
			$t += $row['t'];

			$jx = 0;
			foreach ($row as $j) {
				$jx+= $j;
			}
			$max += $jx;

			$row['jml'] = $jx;
			$row['txt'] = $txt;
			$row['angka'] = $angka;
			$allArr[] = $row;

		}
		$narr = array
		(
			'a' => $a,
			'e' => $e,
			'f' => $f,
			'q' => $q,
			'h' => $h,
			'b' => $b,
			'd' => $d,
			'g' => $g,
			'j' => $j,
			'l' => $l,
			'k' => $k,
			'c' => $c,
			't' => $t,
			'jml' => $max,
			'txt' => 'JUMLAH',
			'angka' => ''
			);
		$allArr[] = $narr;
		$data['list'] = $allArr;
		$html = $this->load->view('MasterPekerja/Rekap/DataPekerjaAktif/V_Table',$data, true);
		// print_r($html);
		$data['table'] = $html;
		$data['tanggal'] = $tgl;
		$data['lokasi'] = $loker;

		echo json_encode($data);
	}
}
