<?php
Defined('BASEPATH') or exit('No Direct Sekrip Akses Allowed');
set_time_limit(0);
/**
 * 
 */
class C_PresensiHarian extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('file');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('ADMCabang/M_presensiharian');
		$this->load->model('ADMCabang/M_monitoringpresensi');
		$this->checkSession();
		date_default_timezone_set('Asia/Jakarta');
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
		$kodesie = $this->session->kodesie;

		$data['Title'] = 'Presensi Harian';
		$data['Menu'] = 'Lihat Presensi Harian';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['seksi'] = $this->M_presensiharian->getSeksiByKodesie($kodesie);
		if(!$this->M_monitoringpresensi->getAksesAtasanProduksi($this->session->user)){
			unset($data['UserMenu'][2]);
			unset($data['UserMenu'][3]);
		}

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMCabang/Presensi/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function ExportExcel(){
		$this->load->library('excel');

		$kodesie = $this->session->kodesie;
		$pekerja = $this->M_presensiharian->getPekerjaByKodesie($kodesie);
		$seksi = $this->M_presensiharian->getSeksiByKodesie($kodesie);
		$tanggal = $this->input->post('txtPeriodePresensiHarian');
		
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,1,'Data Presensi');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,2,'Kodesie');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,3,'Seksi');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,4,'Tanggal');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,2,': '.$seksi['0']['kodesie']);
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,3,': '.$seksi['0']['seksi']);
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,4,': '.$tanggal);
		
		$i = 6;
		foreach ($pekerja as $val) {
			$i = $i+1;
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,'Noind');
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$val['noind']);
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,$i+1,'Nama');
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,$i+1,$val['nama']);
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,$i+2,'seksi');
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,$i+2,$val['seksi']);
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,$i+3,'Tanggal');
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,$i+3,'Shift');
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2,$i+3,'Point');
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(3,$i+3,'Waktu');

			$i = $i+4;
			$shift = $this->M_presensiharian->getShiftByNoind($val['noind'],$tanggal);
			foreach ($shift as $key) {
				$presensi = $this->M_presensiharian->getPresensiByNoind($val['noind'],$key['tanggal']);
				$tim = $this->M_presensiharian->getTIMByNoind($val['noind'],$key['tanggal']);
				$ket = $this->M_presensiharian->getKeteranganByNoind($val['noind'],$key['tanggal']);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,$key['tgl']);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$key['shift']);
				if (!empty($tim)) {
					foreach ($tim as $valTim) {
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$valTim['point']);
					}
				}
				if (!empty($presensi)) {
					$j = 3;
					foreach ($presensi as $waktu) {
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j,$i,$waktu['waktu']);
						$j++;
					}
					foreach ($ket as $keterangan) {
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j,$i,$keterangan['keterangan']);
						$j++;
					}
				}else{
					$j = 3;
					foreach ($ket as $keterangan) {
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j,$i,$keterangan['keterangan']);
						$j++;
					}
				}
				$i++;
			}
		}

		$filename ='Daftar Hadir '.$tanggal.'_'.$seksi['0']['seksi'].'.ods';
		header('Content-Type: aplication/vnd.ms-excel');
		header('Content-Disposition:attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
		$writer->save('php://output');
	}
	public function ExportExcelv2(){
		$this->load->library('excel');

		$kodesie = $this->session->kodesie;
		$pekerja = $this->M_presensiharian->getPekerjaByKodesie($kodesie);
		$seksi = $this->M_presensiharian->getSeksiByKodesie($kodesie);
		$tanggal = $this->input->post('txtPeriodePresensiHarian');
		
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,1,'Data Presensi');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,2,'Kodesie');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,3,'Seksi');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,4,'Tanggal');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,2,': '.$seksi['0']['kodesie']);
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,3,': '.$seksi['0']['seksi']);
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,4,': '.$tanggal);
		
		$i = 6;
		$i = $i+1;
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,'Noind');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,'Nama');
		// $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,'seksi');
		// $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,$i+2,$seksi['0']['seksi']);
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,'Tanggal');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,'Shift');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,'Point');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,'Waktu');
		foreach ($pekerja as $val) {
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,$i+1,$val['noind']);
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,$i+1,$val['nama']);
			// $i = $i+1;
			$shift = $this->M_presensiharian->getShiftByNoind($val['noind'],$tanggal);
			foreach ($shift as $key) {
				$presensi = $this->M_presensiharian->getPresensiByNoind($val['noind'],$key['tanggal']);
				$tim = $this->M_presensiharian->getTIMByNoind($val['noind'],$key['tanggal']);
				$ket = $this->M_presensiharian->getKeteranganByNoind($val['noind'],$key['tanggal']);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2,$i+1,$key['tgl']);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(3,$i+1,$key['shift']);
				if (!empty($tim)) {
					foreach ($tim as $valTim) {
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow(4,$i+1,$valTim['point']);
					}
				}
				if (!empty($presensi)) {
					$j = 5;
					foreach ($presensi as $waktu) {
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+1,$waktu['waktu']);
						$j++;
					}
					foreach ($ket as $keterangan) {
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+1,$keterangan['keterangan']);
						$j++;
					}
				}else{
					$j = 7;
					foreach ($ket as $keterangan) {
						$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j,$i+1,$keterangan['keterangan']);
						$j++;
					}
				}
				$i++;
			}
		}

		$filename ='Daftar Hadir '.$tanggal.'_'.$seksi['0']['seksi'].'.ods';
		header('Content-Type: aplication/vnd.ms-excel');
		header('Content-Disposition:attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
		$writer->save('php://output');
	}

	public function ExportPdf()
	{
		$this->load->library('pdf');
		$pnoind = $this->session->user;
		$nama = $this->M_presensiharian->ambilNamaPekerjaByNoind($pnoind);
		$kodesie = $this->session->kodesie;
		$data['kodesie'] = $kodesie;
		$data['pekerja'] = $this->M_presensiharian->getPekerjaByKodesie($kodesie);
		$data['seksi'] = $this->M_presensiharian->getSeksiByKodesie($kodesie);
		$tanggal = $this->input->post('txtPeriodePresensiHarian');
		$data['tanggal'] = $tanggal;
		// echo "<pre>";
		// print_r($data['pekerja']);
		// exit();
		$pekerja = $data['pekerja'];
		$seksi = $data['seksi'];
		$jmlpekerja = count($pekerja);
		$noind = "";
		for ($i=0; $i < $jmlpekerja; $i++) { 
			if ($i == 0) {
				if ($jmlpekerja == 1) {
					$noind = "'".$pekerja[$i]['noind']."'";
				}else{
					$noind = "'".$pekerja[$i]['noind'];
				}
			}else{
				if ($i == $jmlpekerja - 1) {
					$noind = $noind."','".$pekerja[$i]['noind']."'";
				}else{
					$noind = $noind."','".$pekerja[$i]['noind'];
				}
			}
		}
		$data['shift'] = $this->M_presensiharian->getShiftArrayNoind($noind,$tanggal);
		$data['presensi'] = $this->M_presensiharian->getPresensiArrayNoind($noind,$tanggal);
		$data['tim'] = $this->M_presensiharian->getTIMArrayNoind($noind,$tanggal);
		$data['ket'] = $this->M_presensiharian->getKeteranganArrayNoind($noind,$tanggal);

		$angka1 = 1;
		foreach ($pekerja as $val) {
			$arr[$angka1] = array(
				'noind' => $val['noind'],
				'nama' => $val['nama'],
				'seksi' => $val['seksi'],
			);

			$shift = $this->M_presensiharian->getShiftByNoind($val['noind'],$tanggal);
			$angka2 = 0;
			$simpan = 0;
			foreach ($shift as $key) {	
				$presensi = $this->M_presensiharian->getPresensiByNoind($val['noind'],$key['tanggal']);
				$tim = $this->M_presensiharian->getTIMByNoind($val['noind'],$key['tanggal']);
				$ket = $this->M_presensiharian->getKeteranganByNoind($val['noind'],$key['tanggal']);
				$arr[$angka1]['data'][$angka2]['tgl'] = $key['tgl'];
				$arr[$angka1]['data'][$angka2]['shift'] = $key['shift'];
				if (!empty($tim)) {
					$angka3 = 0;
					foreach ($tim as $valTim) {
						$arr[$angka1]['data'][$angka2]['tim'][$angka3] = $valTim['point'];
						$angka3++;
					}
				}
				if (!empty($presensi)) {
					$angka3 = 0;
					foreach ($presensi as $waktu) {
						$arr[$angka1]['data'][$angka2]['wkt'][$angka3] = $waktu['waktu'];
						$angka3++;
					}
					if ($simpan <= ($angka3)) {
						$simpan = $angka3;
					}
				}

				$angka3 = 0;
				foreach ($ket as $keterangan) {
					$arr[$angka1]['data'][$angka2]['ket'][$angka3] = $keterangan['keterangan'];
					$angka3++;
				}
				$angka2++;
			}
			$arr[$angka1]['max'] = $simpan;
			$angka1++;
		}
		// $angka1 = 0;
		// foreach ($data['shift'] as $key ) {
		// 	$arr[$angka1] = array(
		// 		'noind' => $key['noind'],
		// 		'tgl' => $key['tanggal'],
		// 		'shift' => $key['shift']
		// 	);

		// 	$waktu = $this->M_presensiharian->getPresensiByNoind($key['noind'],$key['tanggal']);
		// 	$angka = 0;
		// 	foreach ($waktu as $val) {
		// 		$arr[$angka1]['waktu'][$angka] = $val['waktu'];
		// 		$angka++;
		// 	}
		// 	$angka1++;
		// }
		// echo "<pre>";
		// print_r($arr);
		// exit();
		$data['pekerja'] = $arr;
		$today = date('d-m-Y H:i:s');
		$seksi = $data['seksi'];

		$tgl = explode(' - ', $tanggal);
		$tgl1 =$tgl[0];
		$tgl2 =$tgl[1];

		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8', 'A4', 8, '', 5, 5, 30, 15, 10, 20);
		$filename = 'Rekap_Presensi_v1-'.$seksi[0]['seksi'].'_'.$tanggal.'.pdf';

		// $this->load->view('ADMCabang/Presensi/V_presensi1_pdf', $data);
		// exit();
		$html = $this->load->view('ADMCabang/Presensi/V_presensi1_pdf', $data, true);
		$pdf->setHTMLHeader('
				<table width="100%">
					<tr>
						<td width="50%"><h2><b>Data Absen Pekerja</b></h2></td>
						<td><h4>Dicetak Oleh '.$pnoind.' - '.$nama[0]['nama'].' pada Tanggal '.$today.'</h4></td>
					</tr>
					<tr>
						<td colspan="2"><h4>Seksi '.$seksi[0]['seksi'].'</h4></td>
					</tr>
					<tr>
						<td colspan="2"><h4> Tanggal Absen '.$tgl1.' s.d. '.$tgl2.'</h4></td>
					</tr>
				</table>
			');
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'D');
	}

	public function ExportPdfv2()
	{
		$this->load->library('pdf');
		$pnoind = $this->session->user;
		$nama = $this->M_presensiharian->ambilNamaPekerjaByNoind($pnoind);
		$kodesie = $this->session->kodesie;
		$data['kodesie'] = $kodesie;
		$data['pekerja'] = $this->M_presensiharian->getPekerjaByKodesie($kodesie);
		$data['seksi'] = $this->M_presensiharian->getSeksiByKodesie($kodesie);
		$tanggal = $this->input->post('txtPeriodePresensiHarian');
		$data['tanggal'] = $tanggal;
		// echo "<pre>";
		// print_r($data['pekerja']);
		// exit();
		$pekerja = $data['pekerja'];
		$seksi = $data['seksi'];
		$jmlpekerja = count($pekerja);
		$noind = "";
		for ($i=0; $i < $jmlpekerja; $i++) { 
			if ($i == 0) {
				if ($jmlpekerja == 1) {
					$noind = "'".$pekerja[$i]['noind']."'";
				}else{
					$noind = "'".$pekerja[$i]['noind'];
				}
			}else{
				if ($i == $jmlpekerja - 1) {
					$noind = $noind."','".$pekerja[$i]['noind']."'";
				}else{
					$noind = $noind."','".$pekerja[$i]['noind'];
				}
			}
		}
		$data['shift'] = $this->M_presensiharian->getShiftArrayNoind($noind,$tanggal);
		$data['presensi'] = $this->M_presensiharian->getPresensiArrayNoind($noind,$tanggal);
		$data['tim'] = $this->M_presensiharian->getTIMArrayNoind($noind,$tanggal);
		$data['ket'] = $this->M_presensiharian->getKeteranganArrayNoind($noind,$tanggal);
		

		// echo "<pre>";
		// print_r($data['presensi']);
		// exit();

		$angka1 = 1;
		$simpan2 = 0;
		foreach ($pekerja as $val) {
			$arr[$angka1] = array(
				'noind' => $val['noind'],
				'nama' => $val['nama'],
				'seksi' => $val['seksi'],
			);

			$shift = $this->M_presensiharian->getShiftByNoind($val['noind'],$tanggal);
			$angka2 = 0;
			$simpan = 0;

			foreach ($shift as $key) {	
				$presensi = $this->M_presensiharian->getPresensiByNoind($val['noind'],$key['tanggal']);
				$tim = $this->M_presensiharian->getTIMByNoind($val['noind'],$key['tanggal']);
				$ket = $this->M_presensiharian->getKeteranganByNoind($val['noind'],$key['tanggal']);
				$arr[$angka1]['data'][$angka2]['tgl'] = $key['tgl'];
				$arr[$angka1]['data'][$angka2]['shift'] = $key['shift'];
				if (!empty($tim)) {
					$angka3 = 0;
					foreach ($tim as $valTim) {
						$arr[$angka1]['data'][$angka2]['tim'][$angka3] = $valTim['point'];
						$angka3++;
					}
				}
				if (!empty($presensi)) {
					$angka3 = 0;
					foreach ($presensi as $waktu) {
						$arr[$angka1]['data'][$angka2]['wkt'][$angka3] = $waktu['waktu'];
						$angka3++;
					}
					if ($simpan <= ($angka3)) {
						$simpan = $angka3;
					}
				}

				$angka3 = 0;
				foreach ($ket as $keterangan) {
					$arr[$angka1]['data'][$angka2]['ket'][$angka3] = $keterangan['keterangan'];
					$angka3++;
				}
				$angka2++;
			}
			$arr[$angka1]['max'] = $simpan;
			if ($simpan2 <= $simpan) {
				$simpan2 = $simpan;
			}
			$angka1++;
		}

		$data['max'] = $simpan2;
		// $angka1 = 0;
		// foreach ($data['shift'] as $key ) {
		// 	$arr[$angka1] = array(
		// 		'noind' => $key['noind'],
		// 		'tgl' => $key['tanggal'],
		// 		'shift' => $key['shift']
		// 	);

		// 	$waktu = $this->M_presensiharian->getPresensiByNoind($key['noind'],$key['tanggal']);
		// 	$angka = 0;
		// 	foreach ($waktu as $val) {
		// 		$arr[$angka1]['waktu'][$angka] = $val['waktu'];
		// 		$angka++;
		// 	}
		// 	$angka1++;
		// }
		// echo "<pre>";
		// print_r($arr);
		// exit();
		$data['pekerja'] = $arr;
		$today = date('d-m-Y H:i:s');
		$seksi = $data['seksi'];

		$tgl = explode(' - ', $tanggal);
		$tgl1 =$tgl[0];
		$tgl2 =$tgl[1];

		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8', 'A4', 8, '', 5, 5, 30, 15, 10, 20);
		$filename = 'Rekap_Presensi_v2-'.$seksi[0]['seksi'].'_'.$tanggal.'.pdf';

		// $this->load->view('ADMCabang/Presensi/V_presensi1_pdf', $data);
		// exit();
		$html = $this->load->view('ADMCabang/Presensi/V_presensi1v2_pdf', $data, true);
		$pdf->setHTMLHeader('
				<table width="100%">
					<tr>
						<td width="50%"><h2><b>Data Absen Pekerja</b></h2></td>
						<td><h4>Dicetak Oleh '.$pnoind.' - '.$nama[0]['nama'].' pada Tanggal '.$today.'</h4></td>
					</tr>
					<tr>
						<td colspan="2"><h4>Seksi '.$seksi[0]['seksi'].'</h4></td>
					</tr>
					<tr>
						<td colspan="2"><h4> Tanggal Absen '.$tgl1.' s.d. '.$tgl2.'</h4></td>
					</tr>
				</table>
			');
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'D');
	}
}
?>