<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_ProsesGaji extends CI_Controller {

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
		$this->load->view('UpahHlCm/ProsesGaji/V_Index',$data);
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
			$data['data'] 	= $this->M_prosesgaji->prosesHitung($tanggalawal,$tanggalakhir,$lokasi_kerja,$periode_puasa);
		}else{
			$data['data'] 	= $this->M_prosesgaji->prosesHitung($tanggalawal,$tanggalakhir,$lokasi_kerja);
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
						$total 		= $gajipokok1+$gajilembur1+$uangmakan1;
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
						$total 		+= $gajipokok2+$gajilembur2+$uangmakan2;
						$gajipokok 	= $gajipokok1+$gajipokok2;
						$uangmakan 	= $uangmakan1+$uangmakan2+$uangmakanpuasa1+$uangmakanpuasa2;
						$gajilembur = $gajilembur1+$gajilembur2;
						$gajilembur = number_format($gajilembur,'0','.','');
						$total 		= number_format($total,'0','.','');
						// echo $gajipokok1."-".$gajipokok2."<br>";
						// echo $uangmakan1."-".$uangmakan2."<br>";
						// echo $gajilembur1."-".$gajilembur2."<br>";
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
					$uangmakan 	= ($um*$nominalum) + ($ump*$nominalump);
				}else{
					$uangmakan 	= ($um*$nominalum) + ($ump*$nominalum);
				}
				
				$gajilembur = $lembur*($nominalgpokok/7);
				$gajilembur = number_format($gajilembur,'0','.','');
				$total 		= $gajipokok+$gajilembur+$uangmakan;
				$total 		= number_format($total,'0','.','');
			}
			
			date_default_timezone_set('Asia/Jakarta');
			$createDate = date('Y-m-d H:i:s');

			$arrData[$angka] = array(
				'noind' 			=> $key['noind'],
				'kode_pekerjaan' 	=> $key['kdpekerjaan'],
				'periode' 			=> $thnbln,
				'jml_gp' 			=> $gpokok,
				'gp' 				=> $gajipokok,
				'jml_um' 			=> $um + $ump,
				'um' 				=> $uangmakan,
				'jml_lbr' 			=> $lembur,
				'lmbr' 				=> $gajilembur,
				'total_bayar' 		=> $total,
				'tgl_awal_periode' 	=> $tglawal,
				'tgl_akhir_periode' => $tglakhir,
				'creation_date' 	=> $createDate,
				'lokasi_kerja'		=> $key['lokasi_kerja']
			);

			$cek = $this->M_prosesgaji->getHlcmProses($thnbln,$key['noind']);
			
			if ($cek !== 0) {
				$this->M_prosesgaji->updateHlcmProses($arrData[$angka]);
			}else{
				$this->M_prosesgaji->insertHlcmProses($arrData[$angka]);
			}
			$arrData[$angka]['nama'] = $key['nama'];
			$arrData[$angka]['pekerjaan'] = $key['pekerjaan'];
			// echo $puasa."<p style='color: red;'>".$key['noind']."</p><br>";
			$angka++;
		}
		// echo "<pre>";
		// print_r($arrData);
		// exit();
		$data['hasil'] = $arrData;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/ProsesGaji/V_Index',$data);
		$this->load->view('V_Footer',$data);
		
		
	}

	public function printProses($cetak,$periode,$lokasi = FALSE){
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
			$data['data'] = $this->M_prosesgaji->getHlcmProsesPrint($periode,$lokasi);
		}else{
			$data['data'] = $this->M_prosesgaji->getHlcmProsesPrint($periode);
		}

		if ($cetak == 'pdf') {
			$this->load->library('pdf');
			$pdf = $this->pdf->load();
			$pdf = new mPDF('','A4-L');
			$filename = "Penggajian HLCM Periode - ".$data['periode'].".pdf";
			$html = $this->load->view('UpahHlCm/ProsesGaji/V_cetak', $data, true);
			// print_r($data['data']);exit();
			// $this->load->view('UpahHlCm/ProsesGaji/V_cetak', $data['data']);

			$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
			$pdf->WriteHTML($stylesheet1,1);
			$pdf->WriteHTML($html, 2);
			$pdf->Output($filename, 'I');
		}elseif ($cetak == 'xls'){
			$this->load->library('excel');
			$this->excel->getActiveSheet()->setCellValue('A1','No');
			$this->excel->getActiveSheet()->setCellValue('B1','Nama');
			$this->excel->getActiveSheet()->setCellValue('C1','Status');
			$this->excel->getActiveSheet()->setCellValue('D1','Komponen');
			$this->excel->getActiveSheet()->setCellValue('D2','Gaji Pokok');
			$this->excel->getActiveSheet()->setCellValue('E2','Uang Makan');
			$this->excel->getActiveSheet()->setCellValue('F2','Lembur');
			$this->excel->getActiveSheet()->setCellValue('G1','Nominal');
			$this->excel->getActiveSheet()->setCellValue('G2','Gaji Pokok');
			$this->excel->getActiveSheet()->setCellValue('H2','Uang Makan');
			$this->excel->getActiveSheet()->setCellValue('I2','Lembur');
			$this->excel->getActiveSheet()->setCellValue('J1','Total Gaji');
			$this->excel->getActiveSheet()->mergeCells('A1:A2');
			$this->excel->getActiveSheet()->mergeCells('B1:B2');
			$this->excel->getActiveSheet()->mergeCells('C1:C2');
			$this->excel->getActiveSheet()->mergeCells('D1:F1');
			$this->excel->getActiveSheet()->mergeCells('G1:I1');
			$this->excel->getActiveSheet()->mergeCells('J1:J2');

			$a = 1;
			foreach ($data['data'] as $val) {
				$this->excel->getActiveSheet()->setCellValue('A'.($a+2),$a);
				$this->excel->getActiveSheet()->setCellValue('B'.($a+2),$val['nama']);
				$this->excel->getActiveSheet()->setCellValue('C'.($a+2),$val['pekerjaan']);
				$this->excel->getActiveSheet()->setCellValueExplicit('D'.($a+2),number_format($val['jml_gp'],'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
				$this->excel->getActiveSheet()->setCellValueExplicit('E'.($a+2),number_format($val['jml_um'],'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
				$this->excel->getActiveSheet()->setCellValueExplicit('F'.($a+2),number_format($val['jml_lbr'],'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
				$this->excel->getActiveSheet()->setCellValueExplicit('G'.($a+2),number_format($val['gp'],'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
				$this->excel->getActiveSheet()->setCellValueExplicit('H'.($a+2),number_format($val['um'],'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
				$this->excel->getActiveSheet()->setCellValueExplicit('I'.($a+2),number_format($val['lmbr'],'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
				$this->excel->getActiveSheet()->setCellValueExplicit('J'.($a+2),number_format($val['total_bayar'],'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
				$a++;
			}
			$this->excel->getActiveSheet()->setCellValue('A'.($a+3),"Periode : ".$data['periode']);
			//style
			$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN)
					),
					'alignment' => array(
						'wrap' => true,
						'horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					)
				),'A1:J'.($a+1));
			$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					),
					'fill' =>array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
							'argb' => '0000ccff')
					)
				),'A1:J2');
			$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					)
				),'A3:A'.($a+1));
			$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					)
				),'D3:J'.($a+1));
			$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth('30');
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
			$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth('10');
			$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth('10');
			$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth('10');
			$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth('10');
			$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth('10');
			$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth('10');
			$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth('13');
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
