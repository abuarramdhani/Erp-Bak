<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

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
		$this->load->library('Log_Activity');
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
				  //redirect('');
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
		$data['data'] = $this->M_prosesgaji->getRecordAbsenPekerjaByPeriode($tanggalakhir);

		$data['valLink'] = $link;
		// echo "<pre>";print_r($data['data']);exit();

		$arrData = array();
		$angka = 0;
		foreach ($data['data'] as $key) {
			$gpokok = $key['proses_komponen_gaji_pokok'];
			$um = $key['proses_komponen_uang_makan'];
			$lembur = $key['proses_komponen_lembur'];
			$ump = $key['proses_komponen_uang_makan_puasa'];
			$thnbln 	= '';
			$tglawal 	= '';
			$tglakhir 	= '';
			$kd_pekerjaan = '';
			foreach ($data['periodeGaji'] as $prd) {
				if ($prd['rangetanggal'] == $data['periodeGajiSelected']) {
					$thnbln 	= $prd['periode'];
					$tglawal 	= $prd['tanggal_awal'];
					$tglakhir 	= $prd['tanggal_akhir'];
				}
			}

			
			for ($i=0; $i < 8; $i++) {
				if ($key['lokasi_kerja']==$data['gaji'][$i]['lokasi_kerja'] and $key['status']==$data['gaji'][$i]['pekerjaan']) {
					$nominalgpokok = $data['gaji'][$i]['nominal'];
					$kd_pekerjaan = $data['gaji'][$i]['kode_pekerjaan'];
				}
				if ($key['lokasi_kerja']==$data['gaji'][$i]['lokasi_kerja']) {
					$nominalum = $data['gaji'][$i]['uang_makan'];
					$nominalump = $data['gaji'][$i]['uang_makan_puasa'];
				}
			}

			$gajipokok 	= $gpokok*$nominalgpokok;
			
			$uangmakan 	= ($um*$nominalum);
			$uangmakanpuasa = ($ump*$nominalump);

			$gajilembur = $lembur*($nominalgpokok/7);
			$gajilembur = number_format($gajilembur,'0','.','');
			$total 		= $gajipokok+$gajilembur+$uangmakan+$uangmakanpuasa;
			$total 		= number_format($total,'0','.','');

			$createDate = date('Y-m-d H:i:s');

			$arrData[$angka] = array(
				'noind' 			=> $key['noind'],
				'kode_pekerjaan' 	=> $kd_pekerjaan,
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
				'status_perubahan' 	=> '0'
			);

			$cek = $this->M_prosesgaji->getHlcmProses($thnbln,$key['noind']);

			if ($cek !== 0) {
				$this->M_prosesgaji->updateHlcmProses($arrData[$angka]);
				//insert to t_log
				$aksi = 'UPAH HLCM';
				$detail = 'UPDATE data di hlcm_proses noind='.$key['noind'];
				$this->log_activity->activity_log($aksi, $detail);
				//
			}else{
				$this->M_prosesgaji->insertHlcmProses($arrData[$angka]);
				//insert to t_log
				$aksi = 'UPAH HLCM';
				$detail = 'INSERT data di hlcm_proses noind='.$key['noind'];
				$this->log_activity->activity_log($aksi, $detail);
				//
			}
			$arrData[$angka]['nama'] = $key['nama'];
			$arrData[$angka]['pekerjaan'] = $key['status'];
			$arrData[$angka]['lokasi'] = $this->M_prosesgaji->getLocationCode($key['noind']);
			$arrData[$angka]['tambahan'] = $this->M_prosesgaji->getTambahan($key['noind'],$tglawal,$tglakhir);
			$arrData[$angka]['potongan'] = $this->M_prosesgaji->getPotongan($key['noind'],$tglawal,$tglakhir);
			$angka++;
		}
		// echo "<pre>";print_r($arrData);exit();

		$data['hasil'] = $arrData;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/ProsesGaji/V_Index',$data);
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
		$angka = 0;
		foreach ($data['data'] as $key) {
			$data['data'][$angka]['tambahan'] = $this->M_prosesgaji->getTambahan($key['noind'],$key['tgl_awal_periode'],$key['tgl_akhir_periode']);
			$data['data'][$angka]['potongan'] = $this->M_prosesgaji->getPotongan($key['noind'],$key['tgl_awal_periode'],$key['tgl_akhir_periode']);
			$data['data'][$angka]['lokasi'] = $this->M_prosesgaji->getLocationCode($key['noind']);
			$angka++;
		}

		if ($cetak == 'pdf') {
			//insert to t_log
			$aksi = 'UPAH HLCM';
			$detail = 'EXPORT PDF Proses Gaji';
			$this->log_activity->activity_log($aksi, $detail);
			//
			$this->load->library('pdf');
			$pdf = $this->pdf->load();
			$pdf = new mPDF('','A4-L');
			$filename = "Penggajian HLCM Periode - ".$data['periode'].".pdf";
			$html = $this->load->view('UpahHlCm/ProsesGaji/V_cetak', $data, true);

			$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
			$pdf->SetHTMLFooter("<i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-HLCM pada oleh ".$this->session->user." tgl. ".date('d/m/Y H:i:s').". Halaman {PAGENO} dari {nb}</i> ");
			$pdf->WriteHTML($stylesheet1,1);
			$pdf->WriteHTML($html, 2);
			$pdf->Output($filename, 'I');
		}elseif ($cetak == 'xls'){
			//insert to t_log
			$aksi = 'UPAH HLCM';
			$detail = 'EXPORT EXCEL Proses Gaji';
			$this->log_activity->activity_log($aksi, $detail);
			//
			$this->load->library('excel');
			$this->excel->getActiveSheet()->setCellValue('A1','No');
			$this->excel->getActiveSheet()->setCellValue('B1','No. Induk');
			$this->excel->getActiveSheet()->setCellValue('C1','Nama');
			$this->excel->getActiveSheet()->setCellValue('D1','Status');
			$this->excel->getActiveSheet()->setCellValue('E1','Lokasi Kerja');
			$this->excel->getActiveSheet()->mergeCells('A1:A3');
			$this->excel->getActiveSheet()->mergeCells('B1:B3');
			$this->excel->getActiveSheet()->mergeCells('C1:C3');
			$this->excel->getActiveSheet()->mergeCells('D1:D3');
			$this->excel->getActiveSheet()->mergeCells('E1:E3');

			$this->excel->getActiveSheet()->setCellValue('F1','Proses Gaji');
			$this->excel->getActiveSheet()->setCellValue('F2','Komponen');
			$this->excel->getActiveSheet()->setCellValue('F3','Gaji Pokok');
			$this->excel->getActiveSheet()->setCellValue('G3','Uang Makan');
			$this->excel->getActiveSheet()->setCellValue('H3','Uang Makan Puasa');
			$this->excel->getActiveSheet()->setCellValue('I3','Lembur');
			$this->excel->getActiveSheet()->setCellValue('J2','Nominal');
			$this->excel->getActiveSheet()->setCellValue('J3','Gaji Pokok');
			$this->excel->getActiveSheet()->setCellValue('K3','Uang Makan');
			$this->excel->getActiveSheet()->setCellValue('L3','Uang Makan Puasa');
			$this->excel->getActiveSheet()->setCellValue('M3','Lembur');
			$this->excel->getActiveSheet()->mergeCells('F1:M1');
			$this->excel->getActiveSheet()->mergeCells('F2:I2');
			$this->excel->getActiveSheet()->mergeCells('J2:M2');

			$this->excel->getActiveSheet()->setCellValue('N1','Tambahan');
			$this->excel->getActiveSheet()->setCellValue('N2','Komponen');
			$this->excel->getActiveSheet()->setCellValue('N3','Gaji Pokok');
			$this->excel->getActiveSheet()->setCellValue('O3','Uang Makan');
			$this->excel->getActiveSheet()->setCellValue('P3','Lembur');
			$this->excel->getActiveSheet()->setCellValue('Q2','Nominal');
			$this->excel->getActiveSheet()->setCellValue('Q3','Gaji Pokok');
			$this->excel->getActiveSheet()->setCellValue('R3','Uang Makan');
			$this->excel->getActiveSheet()->setCellValue('S3','Lembur');
			$this->excel->getActiveSheet()->mergeCells('N1:S1');
			$this->excel->getActiveSheet()->mergeCells('N2:P2');
			$this->excel->getActiveSheet()->mergeCells('Q2:S2');

			$this->excel->getActiveSheet()->setCellValue('T1','Potongan');
			$this->excel->getActiveSheet()->setCellValue('T2','Komponen');
			$this->excel->getActiveSheet()->setCellValue('T3','Gaji Pokok');
			$this->excel->getActiveSheet()->setCellValue('U3','Uang Makan');
			$this->excel->getActiveSheet()->setCellValue('V3','Lembur');
			$this->excel->getActiveSheet()->setCellValue('W2','Nominal');
			$this->excel->getActiveSheet()->setCellValue('W3','Gaji Pokok');
			$this->excel->getActiveSheet()->setCellValue('X3','Uang Makan');
			$this->excel->getActiveSheet()->setCellValue('Y3','Lembur');
			$this->excel->getActiveSheet()->mergeCells('T1:Y1');
			$this->excel->getActiveSheet()->mergeCells('T2:V2');
			$this->excel->getActiveSheet()->mergeCells('W2:Y2');

			$this->excel->getActiveSheet()->setCellValue('Z1','Total Gaji');
			$this->excel->getActiveSheet()->mergeCells('Z1:Z3');

			$a = 2;
			foreach ($data['data'] as $val) {
				$this->excel->getActiveSheet()->setCellValue('A'.($a+2),$a-1);
				$this->excel->getActiveSheet()->setCellValue('B'.($a+2),$val['noind']);
				$this->excel->getActiveSheet()->setCellValue('C'.($a+2),$val['nama']);
				$this->excel->getActiveSheet()->setCellValue('D'.($a+2),$val['pekerjaan']);
				$this->excel->getActiveSheet()->setCellValue('E'.($a+2),$val['lokasi']);
				$this->excel->getActiveSheet()->setCellValueExplicit('F'.($a+2),number_format($val['jml_gp'],'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
				$this->excel->getActiveSheet()->setCellValueExplicit('G'.($a+2),number_format($val['jml_um'],'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
				$this->excel->getActiveSheet()->setCellValueExplicit('H'.($a+2),number_format($val['jml_ump'],'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
				$this->excel->getActiveSheet()->setCellValueExplicit('I'.($a+2),number_format($val['jml_lbr'],'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
				$this->excel->getActiveSheet()->setCellValueExplicit('J'.($a+2),number_format($val['gp'],'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
				$this->excel->getActiveSheet()->setCellValueExplicit('K'.($a+2),number_format($val['um'],'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
				$this->excel->getActiveSheet()->setCellValueExplicit('L'.($a+2),number_format($val['ump'],'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
				$this->excel->getActiveSheet()->setCellValueExplicit('M'.($a+2),number_format($val['lmbr'],'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
				if (!empty($val['tambahan'])) {
					$this->excel->getActiveSheet()->setCellValueExplicit('N'.($a+2),number_format($val['tambahan']->gp,'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
					$this->excel->getActiveSheet()->setCellValueExplicit('O'.($a+2),number_format($val['tambahan']->um,'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
					$this->excel->getActiveSheet()->setCellValueExplicit('P'.($a+2),number_format($val['tambahan']->lembur,'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
					$this->excel->getActiveSheet()->setCellValueExplicit('Q'.($a+2),number_format($val['tambahan']->nominal_gp,'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
					$this->excel->getActiveSheet()->setCellValueExplicit('R'.($a+2),number_format($val['tambahan']->nominal_um,'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
					$this->excel->getActiveSheet()->setCellValueExplicit('S'.($a+2),number_format($val['tambahan']->nominal_lembur,'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
					$val['total_bayar'] += ($val['tambahan']->nominal_gp + $val['tambahan']->nominal_um + $val['tambahan']->nominal_lembur);
				}else{
					$this->excel->getActiveSheet()->setCellValueExplicit('N'.($a+2),number_format(0,'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
					$this->excel->getActiveSheet()->setCellValueExplicit('O'.($a+2),number_format(0,'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
					$this->excel->getActiveSheet()->setCellValueExplicit('P'.($a+2),number_format(0,'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
					$this->excel->getActiveSheet()->setCellValueExplicit('Q'.($a+2),number_format(0,'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
					$this->excel->getActiveSheet()->setCellValueExplicit('R'.($a+2),number_format(0,'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
					$this->excel->getActiveSheet()->setCellValueExplicit('S'.($a+2),number_format(0,'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
				}

				if (!empty($val['potongan'])) {
					$this->excel->getActiveSheet()->setCellValueExplicit('T'.($a+2),number_format($val['potongan']->gp,'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
					$this->excel->getActiveSheet()->setCellValueExplicit('U'.($a+2),number_format($val['potongan']->um,'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
					$this->excel->getActiveSheet()->setCellValueExplicit('V'.($a+2),number_format($val['potongan']->lembur,'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
					$this->excel->getActiveSheet()->setCellValueExplicit('W'.($a+2),number_format($val['potongan']->nominal_gp,'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
					$this->excel->getActiveSheet()->setCellValueExplicit('X'.($a+2),number_format($val['potongan']->nominal_um,'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
					$this->excel->getActiveSheet()->setCellValueExplicit('Y'.($a+2),number_format($val['potongan']->nominal_lembur,'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
					$val['total_bayar'] -= ($val['potongan']->nominal_gp + $val['potongan']->nominal_um + $val['potongan']->nominal_lembur);
				}else{
					$this->excel->getActiveSheet()->setCellValueExplicit('T'.($a+2),number_format(0,'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
					$this->excel->getActiveSheet()->setCellValueExplicit('U'.($a+2),number_format(0,'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
					$this->excel->getActiveSheet()->setCellValueExplicit('V'.($a+2),number_format(0,'2',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
					$this->excel->getActiveSheet()->setCellValueExplicit('W'.($a+2),number_format(0,'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
					$this->excel->getActiveSheet()->setCellValueExplicit('X'.($a+2),number_format(0,'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
					$this->excel->getActiveSheet()->setCellValueExplicit('Y'.($a+2),number_format(0,'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
				}

				$this->excel->getActiveSheet()->setCellValueExplicit('Z'.($a+2),number_format($val['total_bayar'],'0',',','.'),PHPExcel_Cell_DataType::TYPE_STRING);
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
				),'A1:Z'.($a+1));
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
				),'A1:Z3');
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
				),'D3:Z'.($a+1));
			$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
			$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth('30');
			$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
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
