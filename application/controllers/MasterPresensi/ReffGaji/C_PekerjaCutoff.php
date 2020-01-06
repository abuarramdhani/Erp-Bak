<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_PekerjaCutoff extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		require_once APPPATH . 'third_party/phpxbase/Column.php';
		require_once APPPATH . 'third_party/phpxbase/Record.php';
		require_once APPPATH . 'third_party/phpxbase/Memo.php';
		require_once APPPATH . 'third_party/phpxbase/Table.php';
		require_once APPPATH . 'third_party/phpxbase/WritableTable.php';

		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('General');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPresensi/ReffGaji/M_pekerjacutoff');
		$this->load->model('MasterPresensi/ReffGaji/M_transferreffgaji');
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

	public function index(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Pekerja Cutoff';
		$data['Menu'] 			= 	'Reff Gaji';
		$data['SubMenuOne'] 	= 	'Pekerja Cutoff';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['user'] = $this->session->user;
		$data['data'] = $this->M_pekerjacutoff->getPeriodeCutoff();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/ReffGaji/PekerjaCutoff/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function d($periode){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Pekerja Cutoff';
		$data['Menu'] 			= 	'Reff Gaji';
		$data['SubMenuOne'] 	= 	'Pekerja Cutoff';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['user'] = $this->session->user;
		$data['data'] = $this->M_pekerjacutoff->getCutoffDetail($periode);
		$data['periode'] = $periode;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/ReffGaji/PekerjaCutoff/V_detail',$data);
		$this->load->view('V_Footer',$data);
	}

	public function pekerja($noind = FALSE){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Pekerja Cutoff';
		$data['Menu'] 			= 	'Reff Gaji';
		$data['SubMenuOne'] 	= 	'Pekerja Cutoff';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['user'] = $this->session->user;
		if ($noind !== FALSE) {
			$data['data'] = $this->M_pekerjacutoff->getCutoffDetailPekerja($noind);
			$data['pekerja'] = $this->M_pekerjacutoff->getDetailPekerja($noind);
		}
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/ReffGaji/PekerjaCutoff/V_pekerja',$data);
		$this->load->view('V_Footer',$data);
	}

	public function search(){
		$key = $this->input->get('term');
		$data = $this->M_pekerjacutoff->getPekerja($key);
		echo json_encode($data);
	}

	public function searchAktif(){
		$key = $this->input->get('term');
		$data = $this->M_pekerjacutoff->getPekerjaAktif($key);
		echo json_encode($data);
	}

	public function pekerjaDetail(){
		$noind = $this->input->geT('noind');
		$detail = $this->M_pekerjacutoff->getCutoffDetailPekerja($noind);
		$pekerja = $this->M_pekerjacutoff->getDetailPekerja($noind);
		$data = array(
			'data' => $detail,
			'pekerja' => $pekerja['0']
		);
		echo json_encode($data);
	}

	public function pdf($key,$value){
		if ($key == "p") {
			$data['data'] = $this->M_pekerjacutoff->getCutoffDetail($value);
			$data['periode'] = $value;

			$pdf = $this->pdf->load();
			$pdf = new mPDF('utf-8', 'A4', 8, '', 12, 15, 15, 15, 10, 5);
			$filename = 'Pekerja Cutoff periode '.$value.'.pdf';
			// $this->load->view('MasterPresensi/ReffGaji/PekerjaCutoff/V_pcetak', $data);
			$html = $this->load->view('MasterPresensi/ReffGaji/PekerjaCutoff/V_pcetak', $data, true);
			$pdf->SetHTMLFooter("<i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-MasterPresensi oleh ".$this->session->user." pada tgl. ".strftime('%d/%h/%Y %H:%M:%S').". Halaman {PAGENO} dari {nb}</i>");
			$pdf->WriteHTML($html, 2);
			$pdf->Output($filename, 'I');
		}elseif ($key == "n") {
			$data['data'] = $this->M_pekerjacutoff->getCutoffDetailPekerja($value);
			$data['pekerja'] = $this->M_pekerjacutoff->getDetailPekerja($value);

			$pdf = $this->pdf->load();
			$pdf = new mPDF('utf-8', 'A4', 8, '', 10, 10, 10, 10, 10, 5);
			$filename = 'Pekerja Cutoff noind '.$value.'.pdf';
			// $this->load->view('MasterPresensi/ReffGaji/PekerjaCutoff/V_ncetak', $data);
			$html = $this->load->view('MasterPresensi/ReffGaji/PekerjaCutoff/V_ncetak', $data, true);
			$pdf->SetHTMLFooter("<i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-MasterPresensi oleh ".$this->session->user." pada tgl. ".strftime('%d/%h/%Y %H:%M:%S').". Halaman {PAGENO} dari {nb}</i>");
			$pdf->WriteHTML($html, 2);
			$pdf->Output($filename, 'I');
		}else{
			redirect(base_url('MasterPresensi/ReffGaji/PekerjaCutoffReffGaji'));
		}
	}

	public function xls($key,$value){
		if ($key == "p" and !empty($value)) {
			$data = $this->M_pekerjacutoff->getCutoffDetail($value);
			$periode = $value;
			$prd = explode("-", $periode);

			$this->load->library('excel');
			$worksheet = $this->excel->getActiveSheet();

			$worksheet->setCellValue('A1','Pekerja dibayar Cutoff');
			$worksheet->mergeCells('A1:D1');
			$worksheet->setCellValue('A2',$prd['1'].$prd['0']);
			$worksheet->mergeCells('A2:D2');

			$worksheet->setCellValue('A4','No.');
			$worksheet->setCellValue('B4','No. Induk');
			$worksheet->setCellValue('C4','Nama');
			$worksheet->setCellValue('D4','Seksi');

			$nomor = 1;
			if(!empty($data)){				
				foreach ($data as $key) {
					$worksheet->setCellValue('A'.($nomor + 4),$nomor);
					$worksheet->setCellValue('B'.($nomor + 4),$key['noind']);
					$worksheet->setCellValue('C'.($nomor + 4),$key['nama']);
					$worksheet->setCellValue('D'.($nomor + 4),$key['seksi']);
					$nomor++;
				}
			}else{
				$worksheet->setCellValue('A5','Tidak Ditemukan Data untuk Nomor Induk '.$pekerja['0']['noind'].' di Data Pekerja Cut Off');
				$worksheet->mergeCells('A5:D5');
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
					)
				),'A4:D4');
			$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN)
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					)
				),'A4:D'.($nomor + 3));
			$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					)
				),'C5:D'.($nomor + 3));

			$worksheet->getColumnDimension('A')->setWidth('5');
			$worksheet->getColumnDimension('B')->setWidth('10');
			$worksheet->getColumnDimension('C')->setWidth('20');
			$worksheet->getColumnDimension('D')->setWidth('30');
			$worksheet->getStyle('C5:D'.($nomor + 3))->getAlignment()->setWrapText(true);

			$filename ='Pekerja_CutOff-periode-'.$prd['1'].$prd['0'].'.xls';
			header('Content-Type: aplication/vnd.ms-excel');
			header('Content-Disposition:attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');
			$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
			$writer->save('php://output');
		}elseif ($key == "n" and !empty($value)) {
			$data = $this->M_pekerjacutoff->getCutoffDetailPekerja($value);
			$pekerja = $this->M_pekerjacutoff->getDetailPekerja($value);
			
			$this->load->library('excel');
			$worksheet = $this->excel->getActiveSheet();

			$worksheet->setCellValue('A1','Pekerja dibayar Cutoff');
			$worksheet->mergeCells('A1:D1');

			$worksheet->setCellValue('A3','No. Induk');
			$worksheet->setCellValue('B3',$pekerja['0']['noind']);
			$worksheet->setCellValue('A4','Nama');
			$worksheet->setCellValue('B4',$pekerja['0']['nama']);
			$worksheet->setCellValue('A5','Seksi / Unit');
			$worksheet->setCellValue('B5',$pekerja['0']['seksi']);
			$worksheet->mergeCells('B3:D3');
			$worksheet->mergeCells('B4:D4');
			$worksheet->mergeCells('B5:D5');

			$worksheet->setCellValue('A7','No.');
			$worksheet->setCellValue('B7','Periode');
			$worksheet->mergeCells('B7:D7');

			$nomor = 1;
			if(!empty($data)){
				foreach ($data as $key) {
					$worksheet->setCellValue('A'.($nomor + 7),$nomor);
					$worksheet->setCellValue('B'.($nomor + 7),$key['periode']);
					$worksheet->mergeCells('B'.($nomor + 7).':D'.($nomor + 7));
					$nomor++;
				}
			}else{
				$worksheet->setCellValue('A8','Tidak Ditemukan Data untuk Nomor Induk '.$pekerja['0']['noind'].' di Data Pekerja Cut Off');
				$worksheet->mergeCells('A8:D8');
			}

			$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					)
				),'A1:A1');
			$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'fill' =>array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
							'argb' => '00ccffcc')
					)
				),'A7:D7');
			$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					),
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN)
					)
				),'A7:D'.($nomor + 6));
			$filename ='Pekerja_CutOff-noind-'.$pekerja['0']['noind'].'.xls';
			header('Content-Type: aplication/vnd.ms-excel');
			header('Content-Disposition:attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');
			$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
			$writer->save('php://output');
		}else{
			redirect(base_url('MasterPresensi/ReffGaji/PekerjaCutoffReffGaji'));
		}
	}

	public function hitung(){
		// echo "<pre>".date('Y-m-d');print_r($_POST);exit();
		$waktu = time();
		$output = "";
		$output_2 = "";
		$jumlah_staff = 0;
		$jumlah_nonstaff = 0;
		
		$nomor_surat = $this->input->post('cutoff_nomor_surat');
		$mengetahui = $this->input->post('cutoff_mengetahui');
		$to_staff = $this->input->post('cutoff_kepada_staff');
		$to_nonstaff = $this->input->post('cutoff_kepada_nonstaff');
		$dibuat = $this->session->user;
		$dibuat_oleh = $this->session->employee;
		$prd = $this->input->post('cutoff_periode_susulan');
		$periode = $this->M_pekerjacutoff->getcutoffByPeriode($prd);
		$noind = $this->input->post('txtNoindPekerjaCutoff');
		$data_memo = array(
			'nomor_surat' 		=> $nomor_surat,
			'mengetahui' 		=> $this->M_pekerjacutoff->getNamaByNoind($mengetahui),
			'jabatan_1'			=> $this->M_pekerjacutoff->getJabByNoind($mengetahui),
			'kepada_staff' 		=> $to_staff,
			'kepada_nonstaff' 	=> $to_nonstaff,
			'dibuat' 			=> $this->M_pekerjacutoff->getNamaByNoind($dibuat),
			'jabatan_2' 		=> $this->M_pekerjacutoff->getJabByNoind($dibuat),
			'periode'			=> $periode,
			'seksi'				=> $this->M_pekerjacutoff->getSeksiByNoind($dibuat),
			'cutawal'			=> $this->M_pekerjacutoff->getCutoffAwal($periode),
			'akhirbulan'		=> $this->M_pekerjacutoff->getAkhirbulan($periode)
		);
		$data['memo'] = $data_memo;
		
		$noind_text = "''";
		if (!empty($noind)) {
			foreach ($noind as $ni) {
				$noind_text .= ",'$ni'";
			}
		}

		//staff
		
		$data_staff = $this->M_pekerjacutoff->getPekerjaCufOffAktif($periode,"'B','D','J','T'",$noind_text);
		// echo "<pre>";print_r($data_staff);exit();
		if(!empty($data_staff)){
			$index = 0;
			foreach ($data_staff as $dt_staff) {
				$data_staff[$index]['htm'] = $this->M_pekerjacutoff->hitung_htm_dipilih($periode,$dt_staff['noind']);
				$kode_noind = substr($dt_staff['noind'],0,1);
				if($kode_noind = "B" or $kode_noind = "D" or $kode_noind = "J"){
					$data_staff[$index]['ief'] = $this->M_pekerjacutoff->hitung_if_dipilih($periode,$dt_staff['noind']);
				}
				$index++;
			}
		}

		if (!empty($data_staff)) {
			
			$table3 = new XBase\WritableTable(FCPATH."assets/upload/TransferReffGaji/lv_info2.dbf");
			$table3->openWrite(FCPATH."assets/upload/TransferReffGaji/Cutoff_STAFF".$periode.$waktu.".dbf");
			foreach ($data_staff as $ds) {
				$jabatan = $this->M_transferreffgaji->getStatusJabatan($ds['noind']);
				if ($jabatan <= 11) {
					$st = "3";
				}
				elseif ($jabatan == 12 or $jabatan == 13) {
					$st = "2";
				}
				elseif ($jabatan >= 14) {
					$st = "1";
				}

				$tpribadi = $this->M_transferreffgaji->getPribadi($ds['noind']);
				if (substr($ds['noind'], 0,1) == "B"){
					$spsi = "T";
					$duka = "T";
					if (trim($tpribadi->nokoperasi) == "Ya") {
						$kop = "T";
					}else{
						$kop = "F";
					}
				}else{
					$spsi = "F";
					$duka = "F";
					$kop = "F";
				}

				if (empty($ds['xduka']) or $ds['xduka'] == "") {
					$duk = "0";
				}else{
					$duk = $ds['xduka'];
				}

				if (empty($ds['ubs']) or $ds['ubs'] == "") {
					$ubs = "0";
				}else{
					$ubs = $ds['ubs'];
				}

				if ($ds['kodesie'] == "401010102") {
					$asdf = "0";
				}

				if (empty($ds['angg_jkn']) or $ds['angg_jkn'] == "t") {
					$angg_jkn_bpjs_kes = "T";
				}else{
					$angg_jkn_bpjs_kes = "F";
				}

				$um_ = floatval($ds['hl']) + floatval($ds['ct']) + floatval($ds['um_puasa']);

				$seksi2 = $this->M_transferreffgaji->getSeksi2($ds['kodesie']);
				$seksi = $this->M_transferreffgaji->getSeksi($ds['kodesie']);

				if (!empty($seksi2)) {
					if ($seksi2->kodesek == "401013") {
						$kodsie = "040004";
					}else{
						$kodsie = $seksi2->kodesek;
					}
				}else{
					$kodsie = "";
				}
				// if (round($ds['plain']) > 0) {
					// echo round($ds['plain']);exit();
				// }
				if(trim($ds['ket']) == "-"){
					$ds['ket'] = "";
				}
				$record = $table3->appendRecord();
				$record->NOIND = $ds['noind'];
				$record->NOINDBR = '';
				$record->NAMA = $ds['nama'];
				$record->KODESEK = $kodsie;
				$record->SEKSI = $seksi->seksi;
				$record->UNIT = $seksi->unit;
				$record->DEPT = $seksi->dept;
				$record->KODEREK = '';
				$record->KPPH = '';
				$record->GAJIP = 0;
				$record->UJAM = 0;
				$record->UPAMK = 0;
				$record->INSK = 0;
				$record->INSP = 0;
				$record->INSF = 0;
				$record->P_ASTEK = 0;
				$record->BLKERJA = 0;
				$record->ANGG_SPSI = $spsi;
				$record->ANGG_KOP = $kop;
				$record->ANGG_DUKA = $duka;
				$record->HR_I = round($ds['ijin'], 2);
				$record->HR_ABS =  round($ds['htm'],2) ;
				$record->HR_IK =  round($ds['ika'],2) ;
				$record->HR_IP =  round($ds['ipe'],2) ;
				$record->HR_IF =  round($ds['ief'], 2) ;
				$record->HR_S2 =  round($ds['ims'], 2) ;
				$record->HR_S3 =  round($ds['imm'], 2) ;
				$record->HUPAMK =  round($ds['upamk'], 2) ;
				$record->JAM_LBR =  round($ds['jam_lembur'], 2) ;
				$record->HR_UM =  $um_ ;
				$record->HR_CATER = 0;
				$record->P_BONSB = 0;
				$record->P_I_KOP =  round($ds['pikop']);
				$record->P_UT_KOP =  round($ds['putkop']) ;
				$record->P_LAIN = round($ds['plain']);
				$record->P_DUKA =  round($ds['pduka']) ;
				$record->P_SPSI =  round($ds['pspsi']) ;
				$record->T_GAJIP = 0;
				$record->T_INSK = 0;
				$record->T_INSP = 0;
				$record->T_INSF = 0;
				$record->T_IMS = 0;
				$record->T_IMM = 0;
				$record->T_ULEMBUR = 0;
				$record->T_UMAKAN = 0;
				$record->T_CATERING = 0;
				$record->TUPAMK = 0;
				$record->T_TAMBAH1 = 0;
				$record->P_UTANG = 0;
				$record->TRANSFER = 0;
				$record->XDUKA =  $duk ;
				$record->PTKP = 0;
				$record->SUBTOTAL1 = 0;
				$record->SUBTOTAL2 = 0;
				$record->SUBTOTAL3 = 0;
				$record->TERIMA = 0;
				$record->KET =  Trim($ds['ket']) ;
				$record->TKENAPJK =  round($ds['tkpajak'], 2) ;
				$record->TTAKPJK = 0;
				$record->KOREKSI1 = '';
				$record->KOREKSI2 = '';
				$record->KHARGA = 0;
				$record->HRD_IP = 0;
				$record->HRD_IK = 0;
				$record->HRD_IF = 0;
				$record->HRM_GP = 0;
				$record->HRM_IP = 0;
				$record->HRM_IK = 0;
				$record->HRM_IF = 0;
				$record->TGLRMH = '';
				$record->UBT =  round($ds['ubt'], 2) ;
				$record->TUBT = 0;
				$record->IFDRMLAMA = 0;
				$record->STATUS = '';
				$record->BANK = '';
				$record->KODEBANK = '';
				$record->NOREK = '';
				$record->POTBANK = 0;
				$record->NAMAPEMREK = '';
				$record->PERSEN = 0;
				$record->JSPSI = '';
				$record->STRUKTUR =  Trim($st) ;
				$record->UMP = 0;
				$record->REK_DPLK = '';
				$record->POT_DPLK = 0;
				$record->UBS =  floatval($ubs) ;
				$record->ANGG_JKN =  $angg_jkn_bpjs_kes ;
				$record->KD_LKS =  $ds['lokasi_krj'] ;
				$record->HR_IPT =  floatval($ds['ipet']) ;
				$record->HR_UMC =  floatval($ds['um_cabang']) ;
				$record->DLOBAT =  floatval($ds['dldobat']);
				$record->JKN =  $ds['jml_jkn'] ;
				$record->JHT =  $ds['jml_jht'] ;
				$record->JP =  $ds['jml_jp'] ;
				// echo "<pre>";print_r($record);exit();
				$table3->writeRecord();
				$jumlah_staff++;
			}
			$table3->close();
			
			$data['data'] = $data_staff;
			$data['cut'] = $this->M_pekerjacutoff->getCutoffDetail($periode);
			$data['jenis'] = "staff";
			$pdf = $this->pdf->load();
			$pdf = new mPDF('utf-8', 'A4', 8, '', 10, 10, 10, 10, 10, 5);
			$filename = 'STAFF'.$periode.$waktu.'.pdf';
			// $this->load->view('MasterPresensi/ReffGaji/PekerjaCutoff/V_cetak', $data);
			$html = $this->load->view('MasterPresensi/ReffGaji/PekerjaCutoff/V_cetak', $data, true);
			$html2 = $this->load->view('MasterPresensi/ReffGaji/PekerjaCutoff/V_cetak_lampiran', $data, true);
			$pdf->SetHTMLFooter("<i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-MasterPresensi oleh ".$this->session->user." ".$this->session->employee." pada tgl. ".strftime('%d/%h/%Y %H:%M:%S').". Halaman {PAGENO} dari {nb}</i>");
			$pdf->WriteHTML($html, 2);
			$pdf->AddPage('L','','','','', 10, 10, 10, 10, 10, 5);
			$pdf->WriteHTML($html2, 2);
			$pdf->Output(FCPATH."assets/upload/TransferReffGaji/Cutoff_".$filename, 'F');
			// $pdf->Output($filename, 'I');
			$output .= '<div class="col-lg-6" style="text-align: right">DBF : <a href="'.site_url("MasterPresensi/ReffGaji/PekerjaCutoffReffGaji/download?file=Cutoff_STAFF".$periode."&time=".$waktu."&ext=dbf") .'" class="btn btn-info">STAFF_'.date('my',strtotime($periode)).'</a></div>';
			$output_2 .= '<div class="col-lg-6" style="text-align: right">PDF : <a href="'.site_url("MasterPresensi/ReffGaji/PekerjaCutoffReffGaji/download?file=Cutoff_STAFF".$periode."&time=".$waktu."&ext=pdf") .'" class="btn btn-danger">STAFF_'.date('my',strtotime($periode)).'</a></div>';
			$file_staff = "Cutoff_STAFF".$periode.$waktu;
		}else{
			$output .= '<div class="col-lg-6">-</div>';
			$output_2 .= '<div class="col-lg-6">-</div>';
			$file_staff = "-";
		}
		
		//non-staff
		$data_nonstaff = $this->M_pekerjacutoff->getPekerjaCufOffAktif($periode,"'A','H','E'",$noind_text);
		// echo "<pre>";print_r($data_nonstaff);exit();
		if(!empty($data_staff)){
			$index = 0;
			foreach ($data_staff as $dt_staff) {
				$data_staff[$index]['htm'] = $this->M_pekerjacutoff->hitung_htm_dipilih($periode,$dt_staff['noind']);
				$index++;
			}
		}
		
		if (!empty($data_nonstaff)) {
			$table4 = new XBase\WritableTable(FCPATH."assets/upload/TransferReffGaji/lv_info.dbf");
			$table4->openWrite(FCPATH."assets/upload/TransferReffGaji/Cutoff_NONSTAFF".$periode.$waktu.".dbf");

			foreach ($data_nonstaff as $dn) {
				if (empty($dn['upamk']) or trim($dn['upamk']) == "") {
					$upamk_ = "0";
				}else{
					$upamk_ = $dn['upamk'];
				}
				if (empty($dn['um']) or trim($dn['um']) == "") {
					$um = "0";
				}else{
					$um = $dn['um'];
				}
				if (empty($dn['ims']) or trim($dn['ims']) == "") {
					$ims = "0";
				}else{
					$ims = $dn['ims'];
				}
				if (empty($dn['imm']) or trim($dn['imm']) == "") {
					$imm = "0";
				}else{
					$imm = $dn['imm'];
				}
				if (empty($dn['jam_lembur']) or trim($dn['jam_lembur']) == "") {
					$jam_lembur = "0";
				}else{
					$jam_lembur = $dn['jam_lembur'];
				}
				if (empty($dn['ipe']) or trim($dn['ipe']) == "") {
					$ipe = "0";
				}else{
					$ipe = $dn['ipe'];
				}
				if (empty($dn['ika']) or trim($dn['ika']) == "") {
					$ika = "0";
				}else{
					$ika = $dn['ika'];
				}
				if (empty($dn['ief']) or trim($dn['ief']) == "") {
					$ief = "0";
				}else{
					$ief = $dn['ief'];
				}
				if (empty($dn['ubt']) or trim($dn['ubt']) == "") {
					$ubt = "0";
				}else{
					$ubt = $dn['ubt'];
				}
				if (empty($dn['ubs']) or trim($dn['ubs']) == "") {
					$ubs = "0";
				}else{
					$ubs = $dn['ubs'];
				}
				if (empty($dn['um_puasa']) or trim($dn['um_puasa']) == "") {
					$um_puasa = "0";
				}else{
					$um_puasa = $dn['um_puasa'];
				}

				$sk_ct_susul = "0";
				if (substr($dn['noind'], 0,1) == "A" or substr($dn['noind'], 0,1) == "H") {
					if (trim($dn['ket']) !== "-") {
						$sk_ct_susul = substr(trim($dn['ket']), 0,strlen($dn['ket']) - 2);
					}else{
						$sk_ct_susul = "";
					}
				}
				$potkop = $dn['putkop'] + $dn['pikop'];

				$record = $table4->appendRecord();
				$record->NOINDLAMA = '';
				$record->NOIND = $dn['noind'] ;
				$record->NAMAOPR =  $dn['nama'] ;
				$record->KODESIE =  $dn['kodesie'] ;
				$record->TGL_GJ = '0000-00-00';
				$record->HMA15 = '';
				$record->HMA16 = '';
				$record->HMA17 = '';
				$record->HMA18 = '';
				$record->HMA19 = '';
				$record->HMA20 = '';
				$record->HMA21 = '';
				$record->HMA22 = '';
				$record->HMA23 = '';
				$record->HMA24 = '';
				$record->HMA25 = '';
				$record->HMA26 = '';
				$record->HMA27 = '';
				$record->HMA28 = '';
				$record->HMA29 = '';
				$record->HMA30 = '';
				$record->HMA31 = '';
				$record->HM01 = '';
				$record->HM02 = '';
				$record->HM03 = '';
				$record->HM04 = '';
				$record->HM05 = '';
				$record->HM06 = '';
				$record->HM07 = '';
				$record->HM08 = '';
				$record->HM09 = '';
				$record->HM10 = '';
				$record->HM11 = '';
				$record->HM12 = '';
				$record->HM13 = '';
				$record->HM14 = '';
				$record->HM15 = '';
				$record->HM16 = '';
				$record->HM17 = '';
				$record->HM18 = '';
				$record->HM19 = '';
				$record->HM20 = '';
				$record->HM21 = '';
				$record->HM22 = '';
				$record->HM23 = '';
				$record->HM24 = '';
				$record->HM25 = '';
				$record->HM26 = '';
				$record->HM27 = '';
				$record->HM28 = '';
				$record->HM29 = '';
				$record->HM30 = '';
				$record->HM31 = '';
				$record->JLB = 0;
				$record->HMP = 0;
				$record->HMU = 0;
				$record->HM = 0;
				$record->IPRES =  round($ipe,2) ;
				$record->IKOND =  round($ika,2) ;
				$record->IFUNG =  round($ief,2) ;
				$record->UBT =  round($ubt,2) ;
				$record->HUPAMK = round($upamk_,2) ;
				$record->IKSKP = 0;
				$record->IKSKU = 0;
				$record->IKSKS = 0;
				$record->IKSKM = 0;
				$record->IKJSP = 0;
				$record->IKJSU = 0;
				$record->IKJSS = 0;
				$record->IKJSM = 0;
				$record->T = 0;
				$record->SKD = 0;
				$record->JML_UM =  round($um,2) ;
				$record->HMS =  round($ims,2) ;
				$record->HMM =  round($imm,2) ;
				$record->JLB =  round($jam_lembur,2) ;
				$record->ABS = round($dn['htm'],2) ;
				$record->HL =  round($dn['hl'],2) ;
				$record->CTI =  $dn['ct'] ;
				$record->IK =  round($dn['ijin'], 2) ;
				$record->POTONGAN =  round($dn['pot']) + round($dn['plain']) ;
				$record->TAMBAHAN =  $dn['tamb_gaji'] ;
				$record->DUKA =  $dn['pduka'] ;
				$record->PT = 0;
				$record->PI = 0;
				$record->PM = 0;
				$record->DL = 0;
				$record->REV_SK = 0;
				$record->REV_SP = 0;
				$record->REV_CT = 0;
				$record->REV_IK = 0;
				$record->HC = 0;
				$record->CICIL =  $dn['cicil'] ;
				$record->POTKOP =  $potkop;
				$record->UBS =  round($ubs,2) ;
				$record->UM_PUASA =  $um_puasa ;
				$record->SK_CT = round($sk_ct_susul) ;
				$record->POT_2 =  $dn['potongan_str'] ;
				$record->TAMB_2 =  $dn['tambahan_str'] ;
				$record->KD_LKS =  $dn['lokasi_krj'] ;
				$record->KET = '';
				$record->UANGDL =  round($dn['dldobat']);
				$record->JKN =  $dn['jml_jkn'] ;
				$record->JHT =  $dn['jml_jht'] ;
				$record->JP =  $dn['jml_jp'] ;
				$table4->writeRecord();
				$jumlah_nonstaff++;
			}
			$table4->close();
			
			$data['data'] = $data_nonstaff;
			$data['cut'] = $this->M_pekerjacutoff->getCutoffDetail($periode);
			$data['jenis'] = "nonstaff";
			$pdf = $this->pdf->load();
			$pdf = new mPDF('utf-8', 'A4', 8, '', 10, 10, 10, 10, 10, 5);
			$filename = 'NONSTAFF'.$periode.$waktu.'.pdf';
			// $this->load->view('MasterPresensi/ReffGaji/PekerjaCutoff/V_cetak', $data);
			$html = $this->load->view('MasterPresensi/ReffGaji/PekerjaCutoff/V_cetak', $data, true);
			$html2 = $this->load->view('MasterPresensi/ReffGaji/PekerjaCutoff/V_cetak_lampiran', $data, true);
			$pdf->SetHTMLFooter("<i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-MasterPresensi oleh ".$this->session->user." ".$this->session->employee." pada tgl. ".strftime('%d/%h/%Y %H:%M:%S').". Halaman {PAGENO} dari {nb}</i>");
			$pdf->WriteHTML($html, 2);
			$pdf->AddPage('L','','','','', 10, 10, 10, 10, 10, 5);
			$pdf->WriteHTML($html2, 2);
			// $pdf->Output($filename, 'I');
			$pdf->Output(FCPATH."assets/upload/TransferReffGaji/Cutoff_".$filename, 'F');
			$output .= '<div class="col-lg-6" style="text-align: left"><a href="'.site_url("MasterPresensi/ReffGaji/PekerjaCutoffReffGaji/download?file=Cutoff_NONSTAFF".$periode."&time=".$waktu."&ext=dbf") .'" class="btn btn-info">NONSTAFF_'.date('my',strtotime($periode)).'</a></div>';
			$output_2 .= '<div class="col-lg-6" style="text-align: left"><a href="'.site_url("MasterPresensi/ReffGaji/PekerjaCutoffReffGaji/download?file=Cutoff_NONSTAFF".$periode."&time=".$waktu."&ext=pdf") .'" class="btn btn-danger">NONSTAFF_'.date('my',strtotime($periode)).'</a></div>';
			$file_nonstaff = "Cutoff_NONSTAFF".$periode.$waktu;
		}else{
			$output .= '<div class="col-lg-6">-</div>';
			$output_2 .= '<div class="col-lg-6">-</div>';
			$file_nonstaff = "-";
		}
		
		$data_insert = array(
			'nomor_surat' 		=> $nomor_surat,
			'mengetahui' 		=> $mengetahui,
			'kepada_staff' 		=> $to_staff,
			'kepada_nonstaff' 	=> $to_nonstaff,
			'created_by' 		=> $dibuat,
			'file_staff' 		=> $file_staff,
			'file_nonstaff' 	=> $file_nonstaff,
			'periode'			=> $periode
		);

		$this->M_pekerjacutoff->insertMemo($data_insert);

		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Pekerja Cutoff';
		$data['Menu'] 			= 	'Reff Gaji';
		$data['SubMenuOne'] 	= 	'Pekerja Cutoff';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['output'] = $output;
		$data['output_2'] = $output_2;
		$data['jumlah_staff'] = $jumlah_staff;
		$data['jumlah_nonstaff'] = $jumlah_nonstaff;
		$data['periode'] = $periode;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/ReffGaji/PekerjaCutoff/V_hitung',$data);
		$this->load->view('V_Footer',$data);
		
	}

	public function download(){
		$file = $this->input->get('file');
		$waktu = $this->input->get('time');
		$extensi = $this->input->get('ext');
		
		$data = file_get_contents(site_url('assets/upload/TransferReffGaji/'.$file.$waktu.".".$extensi));
		
		header('Content-disposition: attachment; filename='.$file.".".$extensi);
		
		echo $data;
	}

	public function memo(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Pekerja Cutoff';
		$data['Menu'] 			= 	'Reff Gaji';
		$data['SubMenuOne'] 	= 	'Pekerja Cutoff';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/ReffGaji/PekerjaCutoff/V_memo',$data);
		$this->load->view('V_Footer',$data);
	}

	public function list_memo(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Pekerja Cutoff';
		$data['Menu'] 			= 	'Reff Gaji';
		$data['SubMenuOne'] 	= 	'Pekerja Cutoff';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$data['data'] = $this->M_pekerjacutoff->getMemoList();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/ReffGaji/PekerjaCutoff/V_list_memo',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getPekerjaCutoffMemo(){
		$periode = $this->input->get('periode');
		$periode = substr($periode,0,6);

		$cekCutoff = $this->M_pekerjacutoff->cekCutoffPeriode($periode);
		$cekCutoffPlus1 = $this->M_pekerjacutoff->cekCutoffPeriodePlus1($periode);

		if(!empty($cekCutoff) and !empty($cekCutoffPlus1)){
			$dataarray = $this->M_pekerjacutoff->getPekerjaCutoffAll($periode);
			
			$datastring = "<table class='table table-bordered table-hover table-striped'>
							<thead>
								<tr>
									<th>
										pilih
									</th>
									<th>
										No. Induk
									</th>
									<th>
										Nama
									</th>
									<th>
										Seksi
									</th>
									<th>
										Keluar
									</th>
									<th>
										Sumber
									</th>
								</tr>
							</thead>
							<tbody>";
			
			foreach ($dataarray as $key) {
				$datastring.= " <tr>
									<td>
										<input type='checkbox' value='".$key['noind']."' name='txtNoindPekerjaCutoff[]' class='txtNoindPekerjaCutoff'>
									</td>
									<td>".$key['noind']."</td>
									<td>".$key['nama']."</td>
									<td>".$key['seksi']."</td>
									<td>".$key['status_keluar']."</td>
									<td>".$key['asal']."</td>
								</tr>";
			}

			$datastring .= "</tbody></table>";

			echo $datastring;			
		}else{
			if (empty($cekCutoff)) {
				echo "Tidak Ada Periode Cutoff";
			}else{
				echo "Tidak Ada Periode Cutoff + 1";
			}
		}

	}

	public function PekerjaCutoffMemoDelete($id){
		$decrypted_String = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$decrypted_String = $this->encrypt->decode($decrypted_String);
		$this->M_pekerjacutoff->deleteMemo($decrypted_String);
		redirect(site_url('MasterPresensi/ReffGaji/PekerjaCutoffMemo'));
	}

	public function susulan(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Pekerja Cutoff';
		$data['Menu'] 			= 	'Reff Gaji';
		$data['SubMenuOne'] 	= 	'Pekerja Cutoff';
		$data['SubMenuTwo'] 	= 	'Pekerja Cutoff Susulan';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['user'] = $this->session->user;
		$data['data'] = $this->M_pekerjacutoff->getPeriodeCutoffSusulan();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/ReffGaji/PekerjaCutoff/V_susulan',$data);
		$this->load->view('V_Footer',$data);
	}

	public function detail_susulan($periode){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Pekerja Cutoff';
		$data['Menu'] 			= 	'Reff Gaji';
		$data['SubMenuOne'] 	= 	'Pekerja Cutoff';
		$data['SubMenuTwo'] 	= 	'Pekerja Cutoff Susulan';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['user'] = $this->session->user;
		$data['periode'] = $periode;
		$data['data'] = $this->M_pekerjacutoff->getDetailCutoffSusulan($periode);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/ReffGaji/PekerjaCutoff/V_susulan_detail',$data);
		$this->load->view('V_Footer',$data);
	}

	public function hapus_susulan($periode,$noind){

		$this->M_pekerjacutoff->hapusPekerjaCutoffSusulan($periode,$noind);

		redirect(site_url('MasterPresensi/ReffGaji/PekerjaCutoffReffGaji/detail_susulan/'.$periode));
	}

	public function cetak_susulan($jenis,$periode){
		if ($jenis == "xls") {
			$data = $this->M_pekerjacutoff->getDetailCutoffSusulan($periode);
			
			$this->load->library('excel');
			$worksheet = $this->excel->getActiveSheet();

			$worksheet->setCellValue('A1','Pekerja dibayar Cutoff (Susulan)');
			$worksheet->mergeCells('A1:D1');
			$worksheet->setCellValue('A2',$periode);
			$worksheet->mergeCells('A2:D2');

			$worksheet->setCellValue('A4','No.');
			$worksheet->setCellValue('B4','No. Induk');
			$worksheet->setCellValue('C4','Nama');
			$worksheet->setCellValue('D4','Seksi');

			$nomor = 1;
			if(!empty($data)){				
				foreach ($data as $key) {
					$worksheet->setCellValue('A'.($nomor + 4),$nomor);
					$worksheet->setCellValue('B'.($nomor + 4),$key['noind']);
					$worksheet->setCellValue('C'.($nomor + 4),$key['nama']);
					$worksheet->setCellValue('D'.($nomor + 4),$key['seksi']);
					$nomor++;
				}
			}else{
				$worksheet->setCellValue('A5','Tidak Ditemukan Data untuk Nomor Induk '.$pekerja['0']['noind'].' di Data Pekerja Cut Off');
				$worksheet->mergeCells('A5:D5');
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
					)
				),'A4:D4');
			$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN)
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					)
				),'A4:D'.($nomor + 3));
			$this->excel->getActiveSheet()->duplicateStyleArray(
				array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
					)
				),'C5:D'.($nomor + 3));

			$worksheet->getColumnDimension('A')->setWidth('5');
			$worksheet->getColumnDimension('B')->setWidth('10');
			$worksheet->getColumnDimension('C')->setWidth('20');
			$worksheet->getColumnDimension('D')->setWidth('30');
			$worksheet->getStyle('C5:D'.($nomor + 3))->getAlignment()->setWrapText(true);

			$filename ='Pekerja_CutOff-periode-'.$periode.'.xls';
			header('Content-Type: aplication/vnd.ms-excel');
			header('Content-Disposition:attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');
			$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
			$writer->save('php://output');
		}else{
			$data['data'] = $this->M_pekerjacutoff->getDetailCutoffSusulan($periode);
			$data['periode'] = $periode;

			$pdf = $this->pdf->load();
			$pdf = new mPDF('utf-8', 'A4', 8, '', 12, 15, 15, 15, 10, 5);
			$filename = 'Pekerja Cutoff Susulan periode '.$periode.'.pdf';
			// $this->load->view('MasterPresensi/ReffGaji/PekerjaCutoff/V_susulan_cetak', $data);
			$html = $this->load->view('MasterPresensi/ReffGaji/PekerjaCutoff/V_susulan_cetak', $data, true);
			$pdf->SetHTMLFooter("<i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-MasterPresensi oleh ".$this->session->user." pada tgl. ".strftime('%d/%h/%Y %H:%M:%S').". Halaman {PAGENO} dari {nb}</i>");
			$pdf->WriteHTML($html, 2);
			$pdf->Output($filename, 'I');
		}
	}

	public function susulan_add_new($periode){
		$noind = $this->input->post('txtnoindpekerja');
		$user = $this->session->user;
		$cek = $this->M_pekerjacutoff->cekCutoffSusulan($noind,$periode);
		if(count($cek) == 0){
			$this->M_pekerjacutoff->insertCutOffSusulan($noind,$periode,$user);
		}
		redirect(site_url('MasterPresensi/ReffGaji/PekerjaCutoffReffGaji/detail_susulan/'.$periode));
	}
}
?>