<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class C_HitungGajiPersonalia extends CI_Controller {

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
		$this->load->library('encrypt');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('UpahHlCm/M_prosesgaji');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
		date_default_timezone_set('Asia/Jakarta');
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

		$data['periodeGaji'] = $this->M_prosesgaji->getCutOffGaji();
		$data['hasil'] = array();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/ProsesGaji/GajiPersonalia/V_Index',$data);
		$this->load->view('V_Footer',$data);
		
	}
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}

	public function getData()
	{
		$link = '';
		$periode = $this->input->post('periodeData');
		$link = $this->encrypt->encode($periode);
		$link = str_replace(array('+', '/', '='), array('-', '_', '~'), $link);
		$periode = explode(' - ', $periode);
		$tanggalawal = date('Y-m-d',strtotime($periode[0]));
		$tanggalakhir = date('Y-m-d',strtotime($periode[1]));
		$keluar = $this->input->post('keluar');
		$link .= '/'.$keluar;
		$loker = $this->input->post('lokasi_kerja');
		$puasa = $this->input->post('puasa');
		if ($puasa == 'on' || $puasa == 'true' || $puasa == 't') {
			$periode_puasa = $this->input->post('periodePuasa');
		}
		if ($loker == null or $loker == "") {
			$lokasi_kerja = "";
		}else {
			$lokasi_kerja = "AND tp.lokasi_kerja='$loker'";
			$link .= '/'.$loker;
		}

		$this->checkSession();
		$user_id = $this->session->userid;
		
		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['periodeGaji'] = $this->M_prosesgaji->getCutOffGaji();
		$data['periodeGajiSelected'] = $this->input->post('periodeData');
		$data['gaji']	= $this->M_prosesgaji->ambilNominalGaji();
		if ($puasa == 'on' || $puasa == 'true' || $puasa == 't') {
			$data['data'] 	= $this->M_prosesgaji->prosesHitung($tanggalawal,$tanggalakhir,$lokasi_kerja,$keluar,$periode_puasa);
		}else{
			$data['data'] 	= $this->M_prosesgaji->prosesHitung($tanggalawal,$tanggalakhir,$lokasi_kerja,$keluar);
		}

		// echo "<pre>";print_r($data['data']);
		// exit();
		
		$data['valLink'] = $link;
		
		$arrData = array();
		$angka = 0;
		
		foreach ($data['data'] as $key) {
			$gpokok = $key['gpokok'];
			$um = ($key['um'] - $key['ump']);
			$lembur = $key['lembur'];
			$ump = $key['ump'];
			$puasa = $key['puasa'];
			$thnbln 	= '';
			$tglawal 	= '';
			$tglakhir 	= '';
			foreach ($data['periodeGaji'] as $prd) {
				if ($prd['rangetanggal'] == $data['periodeGajiSelected']) {
					$thnbln 	= $prd['periode'];
					$tglawal 	= $prd['tanggal_awal'];
					$tglakhir 	= $prd['tanggal_akhir'];
				}
			}

			$cekUbahPekerjaan = $this->M_prosesgaji->getUbahPekerjaan($key['noind'],$key['kdpekerjaan'],$tglawal,$tglakhir,'cek');
			if ($cekUbahPekerjaan == 1) {
				$tanggalPerubahan = $this->M_prosesgaji->getUbahPekerjaan($key['noind'],$key['kdpekerjaan'],$tglawal,$tglakhir,'tanggal');
				
				foreach ($tanggalPerubahan as$val) {
					$dataPerubahanSebelum = $this->M_prosesgaji->getNominalPerubahan($tglawal,$val['tanggal_akhir_berlaku'],$key['noind']);
					for ($i=0; $i < 8; $i++) { 
						if ($val['lokasi_kerja']==$data['gaji'][$i]['lokasi_kerja'] and $val['kode_pekerjaan2']==$data['gaji'][$i]['kode_pekerjaan']) {
							$nominalgpokok = $data['gaji'][$i]['nominal'];
						}
						if ($val['lokasi_kerja']==$data['gaji'][$i]['lokasi_kerja']) {
							$nominalum = $data['gaji'][$i]['uang_makan'];
							$nominalump = $data['gaji'][$i]['uang_makan_puasa'];
						}
					}
					foreach ($dataPerubahanSebelum as $value) {
						$gajipokok1 	= $value['gpokok']*$nominalgpokok;
						if ($puasa == 't' or $puasa == 'true') {
							$uangmakanpuasa1 = $value['ump']*$nominalump;
						}else{
							$uangmakanpuasa1 = $value['ump']*$nominalum;
						}
						$uangmakan1 	= ($value['um'] - $value['ump'])*$nominalum;
						
						$gajilembur1 = $value['lembur']*($nominalgpokok/7);
						$total 		= $gajipokok1+$gajilembur1+$uangmakan1+$uangmakanpuasa1;

						$createDate = date('Y-m-d H:i:s');

						$arrdetail = array(
							'noind' 			=> $key['noind'],
							'kode_pekerjaan' 	=> $val['kode_pekerjaan2'],
							'periode' 			=> $thnbln,
							'gp' 				=> $value['gpokok'],
							'jml_gp'			=> $gajipokok1,
							'um' 				=> $value['um'] - $value['ump'],
							'jml_um' 			=> $uangmakan1,
							'ump' 				=> $value['ump'],
							'jml_ump' 			=> $uangmakanpuasa1,
							'lmbr' 				=> $value['lembur'],
							'jml_lbr' 			=> $gajilembur1,
							'lokasi_kerja' 		=> $val['lokasi_kerja'],
							'creation_date' 	=> $createDate,
							'tgl_awal_periode' 	=> $tglawal,
							'tgl_akhir_periode' => $tglakhir
						);

						$cek = $this->M_prosesgaji->getHlcmProsesDetail($thnbln,$key['noind'],$val['kode_pekerjaan2']);
			
						if ($cek !== 0) {
							$this->M_prosesgaji->updateHlcmProsesDetail($arrdetail);
						}else{
							$this->M_prosesgaji->insertHlcmProsesDetail($arrdetail);
						}
					}
					$dataPerubahanSesudah = $this->M_prosesgaji->getNominalPerubahan($val['tanggal_mulai_berlaku'],$tglakhir,$key['noind']);
					for ($i=0; $i < 8; $i++) { 
						if ($val['lokasi_kerja']==$data['gaji'][$i]['lokasi_kerja'] and $val['kode_pekerjaan']==$data['gaji'][$i]['kode_pekerjaan']) {
							$nominalgpokok = $data['gaji'][$i]['nominal'];
						}
						if ($val['lokasi_kerja']==$data['gaji'][$i]['lokasi_kerja']) {
							$nominalum = $data['gaji'][$i]['uang_makan'];
							$nominalump = $data['gaji'][$i]['uang_makan_puasa'];
						}
					}
					foreach ($dataPerubahanSesudah as $value) {
						$gajipokok2 	= $value['gpokok']*$nominalgpokok;
						$uangmakan2 	= ($value['um'] - $value['ump'])*$nominalum;
						if ($puasa == 't' or $puasa == 'true') {
							$uangmakanpuasa2 = $value['ump']*$nominalump;
						}else{
							$uangmakanpuasa2 = $value['ump']*$nominalum;
						}
						
						$gajilembur2 = $value['lembur']*($nominalgpokok/7);
						$total 		+= $gajipokok2+$gajilembur2+$uangmakan2+$uangmakanpuasa2;
						$gajipokok 	= $gajipokok1+$gajipokok2;
						$uangmakan 	= $uangmakan1+$uangmakan2;
						$uangmakanpuasa = $uangmakanpuasa1+$uangmakanpuasa2;
						$gajilembur = $gajilembur1+$gajilembur2;
						$gajilembur = number_format($gajilembur,'0','.','');
						$total 		= number_format($total,'0','.','');

						$createDate = date('Y-m-d H:i:s');

						$arrdetail['2'] = array(
							'noind' 			=> $key['noind'],
							'kode_pekerjaan' 	=> $val['kode_pekerjaan'],
							'periode' 			=> $thnbln,
							'gp' 				=> $value['gpokok'],
							'jml_gp'			=> $gajipokok2,
							'um' 				=> $value['um'] - $value['ump'],
							'jml_um' 			=> $uangmakan2,
							'ump' 				=> $value['ump'],
							'jml_ump' 			=> $uangmakanpuasa1,
							'lmbr' 				=> $value['lembur'],
							'jml_lbr' 			=> $gajilembur2,
							'lokasi_kerja' 		=> $val['lokasi_kerja'],
							'creation_date' 	=> $createDate,
							'tgl_awal_periode' 	=> $tglawal,
							'tgl_akhir_periode' => $tglakhir
						);

						$cek = $this->M_prosesgaji->getHlcmProsesDetail($thnbln,$key['noind'],$val['kode_pekerjaan']);
			
						if ($cek !== 0) {
							$this->M_prosesgaji->updateHlcmProsesDetail($arrdetail);
						}else{
							$this->M_prosesgaji->insertHlcmProsesDetail($arrdetail);
						}
					}
				}
			}else{
				for ($i=0; $i < 8; $i++) { 
					if ($key['lokasi_kerja']==$data['gaji'][$i]['lokasi_kerja'] and $key['kdpekerjaan']==$data['gaji'][$i]['kode_pekerjaan']) {
						$nominalgpokok = $data['gaji'][$i]['nominal'];
					}
					if ($key['lokasi_kerja']==$data['gaji'][$i]['lokasi_kerja']) {
						$nominalum = $data['gaji'][$i]['uang_makan'];
							$nominalump = $data['gaji'][$i]['uang_makan_puasa'];
					}
				}

				$gajipokok 	= $gpokok*$nominalgpokok;
				if ($puasa == 't' or $puasa == 'true') {
					$uangmakan 	= ($um*$nominalum);
					$uangmakanpuasa = ($ump*$nominalump);
				}else{
					$uangmakan 	= ($um*$nominalum);
					$uangmakanpuasa = ($ump*$nominalum);
				}
				
				$gajilembur = $lembur*($nominalgpokok/7);
				$gajilembur = number_format($gajilembur,'0','.','');
				$total 		= $gajipokok+$gajilembur+$uangmakan+$uangmakanpuasa;
				$total 		= number_format($total,'0','.','');
			}
			
			
			$createDate = date('Y-m-d H:i:s');

			if ($cekUbahPekerjaan == 1) {
				$status_perubahan = '1';
			}else{
				$status_perubahan = '0';
			}

			$arrData[$angka] = array(
				'noind' 			=> $key['noind'],
				'kode_pekerjaan' 	=> $key['kdpekerjaan'],
				'periode' 			=> $thnbln,
				'jml_gp' 			=> $gpokok,
				'gp' 				=> $gajipokok,
				'jml_um' 			=> number_format($um,2),
				'um' 				=> $uangmakan,
				'jml_ump'			=> $ump,
				'ump' 				=> $uangmakanpuasa,
				'jml_lbr' 			=> $lembur,
				'lmbr' 				=> $gajilembur,
				'total_bayar' 		=> $total,
				'tgl_awal_periode' 	=> $tglawal,
				'tgl_akhir_periode' => $tglakhir,
				'creation_date' 	=> $createDate,
				'lokasi_kerja'		=> $key['lokasi_kerja'],
				'status_perubahan' 	=> $status_perubahan
			);

			$cek = $this->M_prosesgaji->getHlcmProses($thnbln,$key['noind']);
			
			if ($cek !== 0) {
				$this->M_prosesgaji->updateHlcmProses($arrData[$angka]);
			}else{
				$this->M_prosesgaji->insertHlcmProses($arrData[$angka]);
			}
			$arrData[$angka]['nama'] = $key['nama'];
			$arrData[$angka]['pekerjaan'] = $key['pekerjaan'];
			$arrData[$angka]['lokasi'] = $this->M_prosesgaji->getLocationCode($key['noind']);
			$arrData[$angka]['tambahan'] = $this->M_prosesgaji->getTambahan($key['noind'],$tglawal,$tglakhir);
			$arrData[$angka]['potongan'] = $this->M_prosesgaji->getPotongan($key['noind'],$tglawal,$tglakhir);
			// echo $puasa."<p style='color: red;'>".$key['noind']."</p><br>";
			$angka++;
		}
		// echo "<pre>";
		// print_r($arrData);
		// exit();
		$data['hasil'] = $arrData;


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/ProsesGaji/GajiPersonalia/V_Index',$data);
		$this->load->view('V_Footer',$data);
		
		
	}

	public function printProses($cetak,$periode,$keluar = FALSE,$lokasi = FALSE){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $periode);
		$plaintext_string = $this->encrypt->decode($plaintext_string);
		$data = array();
		$periode = '';
		$cutoff = $this->M_prosesgaji->getCutOffGaji('All');
		foreach ($cutoff as $cut) {
			if ($cut['rangetanggal'] == $plaintext_string) {
				$periode = $cut['periode'];
				$data['periode'] = $cut['bulan']." ".$cut['tahun'];
			}
		}
		
		if (isset($lokasi) and !empty($lokasi)) {
			if (isset($keluar) and !empty($keluar)) {
				$data['data'] = $this->M_prosesgaji->getHlcmProsesPrint($periode,$keluar,$lokasi);
			}else{
				$data['data'] = $this->M_prosesgaji->getHlcmProsesPrint($periode,FALSE,$lokasi);
			}
		}else{
			if (isset($keluar) and !empty($keluar)) {
				$data['data'] = $this->M_prosesgaji->getHlcmProsesPrint($periode,$keluar);
			}else{
				$data['data'] = $this->M_prosesgaji->getHlcmProsesPrint($periode);
			}
		}
		// echo "<pre>";
		// print_r($data['data']);
		// exit();
		$angka = 0;
		foreach ($data['data'] as $key) {
			$data['data'][$angka]['tambahan'] = $this->M_prosesgaji->getTambahan($key['noind'],$key['tgl_awal_periode'],$key['tgl_akhir_periode']);
			$data['data'][$angka]['potongan'] = $this->M_prosesgaji->getPotongan($key['noind'],$key['tgl_awal_periode'],$key['tgl_akhir_periode']);
			$data['data'][$angka]['lokasi'] = $this->M_prosesgaji->getLocationCode($key['noind']);
			$angka++;
		}
		// echo "<pre>";
		// print_r($data['data']);
		// exit();

		if ($cetak == 'pdf') {
			$this->load->library('pdf');
			$pdf = $this->pdf->load();
			$pdf = new mPDF('','A4-L');
			$filename = "Penggajian HLCM Periode - ".$data['periode'].".pdf";
			$html = $this->load->view('UpahHlCm/ProsesGaji/V_cetak', $data, true);
			// print_r($data['data']);exit();
			// $this->load->view('UpahHlCm/ProsesGaji/V_cetak', $data);exit();

			$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
			$pdf->SetHTMLFooter("<i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-HLCM pada oleh ".$this->session->user." tgl. ".date('d/m/Y H:i:s').". Halaman {PAGENO} dari {nb}</i> ");
			$pdf->WriteHTML($stylesheet1,1);
			$pdf->WriteHTML($html, 2);
			$pdf->Output($filename, 'I');
		}elseif ($cetak == 'xls'){
			$this->load->library('excel');
			$worksheet = $this->excel->getActiveSheet();
			// echo "<pre>";
			// print_r($data['data']);exit();

			$period = explode(' ', $data['periode']);

			$worksheet->setCellValue('A1','REKAP HITUNG GAJI '.strtoupper($data['periode']));
			$worksheet->mergeCells('A1:O1');
			$worksheet->setCellValue('A2','PERIODE TANGGAL : '.date('d F Y',strtotime($period[0]))." - ".date('d F Y',strtotime($period[1])));
			$worksheet->mergeCells('A2:O2');
			$worksheet->setCellValue('A3','NO');
			$worksheet->setCellValue('B3','NO INDUK');
			$worksheet->setCellValue('C3','NAMA');
			$worksheet->setCellValue('D3','LOKASI KERJA');
			$worksheet->setCellValue('E3','STATUS');
			$worksheet->setCellValue('F3','GAJI');
			$worksheet->setCellValue('J3','TAMBAHAN');
			$worksheet->setCellValue('M3','POTONGAN');
			$worksheet->setCellValue('F4','Gaji Pokok');
			$worksheet->setCellValue('G4','Lembur');
			$worksheet->setCellValue('H4','Uang Makan');
			$worksheet->setCellValue('I4','Uang Makan Puasa');
			$worksheet->setCellValue('J4','Gaji Pokok');
			$worksheet->setCellValue('K4','Lembur');
			$worksheet->setCellValue('L4','Uang Makan');
			$worksheet->setCellValue('M4','Gaji Pokok');
			$worksheet->setCellValue('N4','Lembur');
			$worksheet->setCellValue('O4','Uang Makan');

			$worksheet->mergeCells('A3:A4');
			$worksheet->mergeCells('B3:B4');
			$worksheet->mergeCells('C3:C4');
			$worksheet->mergeCells('D3:D4');
			$worksheet->mergeCells('E3:E4');
			$worksheet->mergeCells('F3:I3');
			$worksheet->mergeCells('J3:L3');
			$worksheet->mergeCells('M3:O3');

			$a = 2;
			$nomor = 1;

			if (isset($data['data']) and !empty($data['data'])) {
				$nomor = 1;
				foreach ($data['data'] as $key) {
					$worksheet->setCellValue('A'.($nomor + 4),$nomor);
					$worksheet->setCellValue('B'.($nomor + 4),$key['noind']);
					$worksheet->setCellValue('C'.($nomor + 4),$key['nama']);
					$worksheet->setCellValue('D'.($nomor + 4),$key['lokasi_kerja']);
					$worksheet->setCellValue('E'.($nomor + 4),$key['pekerjaan']);
					$worksheet->setCellValue('F'.($nomor + 4),$key['jml_gp']);
					$worksheet->setCellValue('G'.($nomor + 4),$key['jml_lbr']);
					$worksheet->setCellValue('H'.($nomor + 4),$key['jml_um']);
					$worksheet->setCellValue('I'.($nomor + 4),$key['jml_ump']);
					if (!empty($key['tambahan'])) {
					$worksheet->setCellValue('J'.($nomor + 4),$key['tambahan']->gp);
					$worksheet->setCellValue('K'.($nomor + 4),$key['tambahan']->lembur);
					$worksheet->setCellValue('L'.($nomor + 4),$key['tambahan']->um);
					}else{
					$worksheet->setCellValue('J'.($nomor + 4),0);
					$worksheet->setCellValue('K'.($nomor + 4),0);
					$worksheet->setCellValue('L'.($nomor + 4),0);	
					}
					if (!empty($key['potongan'])) {
					$worksheet->setCellValue('M'.($nomor + 4),$key['potongan']->gp);
					$worksheet->setCellValue('N'.($nomor + 4),$key['potongan']->lembur);
					$worksheet->setCellValue('O'.($nomor + 4),$key['potongan']->um);
					}else{
					$worksheet->setCellValue('M'.($nomor + 4),0);
					$worksheet->setCellValue('N'.($nomor + 4),0);
					$worksheet->setCellValue('O'.($nomor + 4),0);	
					}
					// $worksheet->setCellValue('M'.($nomor + 4),$key['gp_potongan']);
					// $worksheet->setCellValue('N'.($nomor + 4),$key['lembur_potongan']);
					// $worksheet->setCellValue('O'.($nomor + 4),$key['um_potongan']);
					$worksheet->getStyle("F".($nomor + 4))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					$worksheet->getStyle("G".($nomor + 4))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					$worksheet->getStyle("H".($nomor + 4))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					$worksheet->getStyle("I".($nomor + 4))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					$worksheet->getStyle("J".($nomor + 4))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					$worksheet->getStyle("K".($nomor + 4))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					$worksheet->getStyle("L".($nomor + 4))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					$worksheet->getStyle("M".($nomor + 4))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					$worksheet->getStyle("N".($nomor + 4))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					$worksheet->getStyle("O".($nomor + 4))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					$nomor++;
				}
			}

			// foreach ($data['data'] as $val) {
			// 	$this->excel->getActiveSheet()->setCellValue('A'.($a+2),$a-1);
			// 	$this->excel->getActiveSheet()->setCellValue('B'.($a+2),$val['noind']);
			// 	$this->excel->getActiveSheet()->setCellValue('C'.($a+2),$val['nama']);
			// 	$this->excel->getActiveSheet()->setCellValue('D'.($a+2),$val['pekerjaan']);
			// 	$this->excel->getActiveSheet()->setCellValue('E'.($a+2),$val['lokasi']);
			// 	$this->excel->getActiveSheet()->setCellValueExplicit('F'.($a+2),number_format($val['jml_gp'],'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
			// 	$this->excel->getActiveSheet()->setCellValueExplicit('G'.($a+2),number_format($val['jml_um'],'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
			// 	$this->excel->getActiveSheet()->setCellValueExplicit('H'.($a+2),number_format($val['jml_ump'],'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
			// 	$this->excel->getActiveSheet()->setCellValueExplicit('I'.($a+2),number_format($val['jml_lbr'],'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
			// 	$this->excel->getActiveSheet()->setCellValueExplicit('J'.($a+2),number_format($val['gp'],'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
			// 	$this->excel->getActiveSheet()->setCellValueExplicit('K'.($a+2),number_format($val['um'],'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
			// 	$this->excel->getActiveSheet()->setCellValueExplicit('L'.($a+2),number_format($val['ump'],'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
			// 	$this->excel->getActiveSheet()->setCellValueExplicit('M'.($a+2),number_format($val['lmbr'],'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
				// if (!empty($val['tambahan'])) {
				// 	$this->excel->getActiveSheet()->setCellValueExplicit('N'.($a+2),number_format($val['tambahan']->gp,'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
				// 	$this->excel->getActiveSheet()->setCellValueExplicit('O'.($a+2),number_format($val['tambahan']->um,'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
				// 	$this->excel->getActiveSheet()->setCellValueExplicit('P'.($a+2),number_format($val['tambahan']->lembur,'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
				// 	$this->excel->getActiveSheet()->setCellValueExplicit('Q'.($a+2),number_format($val['tambahan']->nominal_gp,'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
				// 	$this->excel->getActiveSheet()->setCellValueExplicit('R'.($a+2),number_format($val['tambahan']->nominal_um,'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
				// 	$this->excel->getActiveSheet()->setCellValueExplicit('S'.($a+2),number_format($val['tambahan']->nominal_lembur,'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
				// 	$val['total_bayar'] += ($val['tambahan']->nominal_gp + $val['tambahan']->nominal_um + $val['tambahan']->nominal_lembur);
				// }else{
				// 	$this->excel->getActiveSheet()->setCellValueExplicit('N'.($a+2),number_format(0,'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
				// 	$this->excel->getActiveSheet()->setCellValueExplicit('O'.($a+2),number_format(0,'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
				// 	$this->excel->getActiveSheet()->setCellValueExplicit('P'.($a+2),number_format(0,'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
				// 	$this->excel->getActiveSheet()->setCellValueExplicit('Q'.($a+2),number_format(0,'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
				// 	$this->excel->getActiveSheet()->setCellValueExplicit('R'.($a+2),number_format(0,'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
				// 	$this->excel->getActiveSheet()->setCellValueExplicit('S'.($a+2),number_format(0,'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
				// }

			// 	if (!empty($val['potongan'])) {
			// 		$this->excel->getActiveSheet()->setCellValueExplicit('T'.($a+2),number_format($val['potongan']->gp,'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
			// 		$this->excel->getActiveSheet()->setCellValueExplicit('U'.($a+2),number_format($val['potongan']->um,'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
			// 		$this->excel->getActiveSheet()->setCellValueExplicit('V'.($a+2),number_format($val['potongan']->lembur,'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
			// 		$this->excel->getActiveSheet()->setCellValueExplicit('W'.($a+2),number_format($val['potongan']->nominal_gp,'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
			// 		$this->excel->getActiveSheet()->setCellValueExplicit('X'.($a+2),number_format($val['potongan']->nominal_um,'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
			// 		$this->excel->getActiveSheet()->setCellValueExplicit('Y'.($a+2),number_format($val['potongan']->nominal_lembur,'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
			// 		$val['total_bayar'] -= ($val['potongan']->nominal_gp + $val['potongan']->nominal_um + $val['potongan']->nominal_lembur);
			// 	}else{
			// 		$this->excel->getActiveSheet()->setCellValueExplicit('T'.($a+2),number_format(0,'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
			// 		$this->excel->getActiveSheet()->setCellValueExplicit('U'.($a+2),number_format(0,'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
			// 		$this->excel->getActiveSheet()->setCellValueExplicit('V'.($a+2),number_format(0,'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
			// 		$this->excel->getActiveSheet()->setCellValueExplicit('W'.($a+2),number_format(0,'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
			// 		$this->excel->getActiveSheet()->setCellValueExplicit('X'.($a+2),number_format(0,'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
			// 		$this->excel->getActiveSheet()->setCellValueExplicit('Y'.($a+2),number_format(0,'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
			// 	}

			// 	$this->excel->getActiveSheet()->setCellValueExplicit('Z'.($a+2),number_format($val['total_bayar'],'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
			// 	$a++;
			// }
			// $this->excel->getActiveSheet()->setCellValue('A'.($a+3),"Periode : ".$data['periode']);
			//style
			$this->excel->getActiveSheet()->duplicateStyleArray(
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				)
			),'A1:O1');
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
			),'A3:O4');
			$this->excel->getActiveSheet()->duplicateStyleArray(
			array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN)
				)
			),'A5:O'.($nomor + 3));
			$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth('15');
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth('30');
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth('10');
			$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth('10');
			$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth('10');
			$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth('10');
			$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth('10');
			$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth('10');
			$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth('10');
			$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth('10');
			$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth('13');
			//Paper
			$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_WorkSheet_PageSetup::ORIENTATION_LANDSCAPE);
			$this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_WorkSheet_PageSetup::PAPERSIZE_A4);
			$this->excel->getActiveSheet()->getPageMargins()->setTop(0.2);
			$this->excel->getActiveSheet()->getPageMargins()->setLeft(0.2);
			$this->excel->getActiveSheet()->getPageMargins()->setRight(0.2);
			$this->excel->getActiveSheet()->getPageMargins()->setBottom(0.2);

			$filename ="Penggajian HLCM Periode - ".$data['periode'].".xls";
			header('Content-Type: aplication/vnd.ms-excel');
			header('Content-Disposition:attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');

			$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
			$writer->save('php://output');
		}else{
			$this->checkSession();
			$user_id = $this->session->userid;
			
			$data['Title'] = 'View Arsip';
			$data['Menu'] = 'Menu Cetak';
			$data['SubMenuOne'] = 'Cetak Arsip';
			$data['SubMenuTwo'] = '';
			
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('UpahHlCm/MenuCetak/V_viewarsip',$data);
			$this->load->view('V_Footer',$data);
		}
	}
	
}
