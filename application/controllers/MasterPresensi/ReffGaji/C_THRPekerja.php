<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
setlocale(LC_TIME, "id_ID.utf8");
ini_set('memory_limit', '-1');

class C_THRPekerja extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('Log_Activity');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('General');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPresensi/ReffGaji/M_thrpekerja');
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

		$data['Title']			=	'THR Pekerja';
		$data['Menu'] 			= 	'Penggajian';
		$data['SubMenuOne'] 	= 	'THR Pekerja';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_thrpekerja->getTHRAll();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/ReffGaji/THRPekerja/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function tambah(){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Tambah THR Pekerja';
		$data['Menu'] 			= 	'Penggajian';
		$data['SubMenuOne'] 	= 	'THR Pekerja';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/ReffGaji/THRPekerja/V_tambah',$data);
		$this->load->view('V_Footer',$data);
	}

	public function simpan(){
		$idul_fitri = $this->input->post('txtTHRTanggalIdulFitri');
		$dibuat 	= $this->input->post('txtTHRTanggalDibuat');
		$mengetahui = $this->input->post('slcTHRMengetahui');

		$data_thr = array(
			'tgl_idul_fitri'	=> $idul_fitri,
			'tgl_dibuat'		=> $dibuat,
			'mengetahui'		=> $mengetahui,
			'created_by'		=> $this->session->user
		);

		$id_thr = $this->M_thrpekerja->insertTHR($data_thr);

		$pekerja = $this->M_thrpekerja->getPekerjaAll();
		if (!empty($pekerja)) {
			for ($i=0; $i < count($pekerja); $i++) { 
				$tahun 	= 0;
				$tahun1 = 0;
				$bulan 	= 0;
				$bulan1 = 0;
				$hari 	= 0;
				$bulan_thr = 0;

				$a 			= $pekerja[$i]['masukkerja'];
				$year_a 	= intval(date('Y',strtotime($a)));
				$month_a 	= intval(date('m',strtotime($a)));
				$day_a 		= intval(date('d',strtotime($a)));

				$b 			= $pekerja[$i]['diangkat'];
				$year_b 	= intval(date('Y',strtotime($b)));
				$month_b 	= intval(date('m',strtotime($b)));
				$day_b 		= intval(date('d',strtotime($b)));

				$c 			= $idul_fitri;
				$year_c 	= intval(date('Y',strtotime($c)));
				$month_c 	= intval(date('m',strtotime($c)));
				$day_c 		= intval(date('d',strtotime($c)));

				$d 			= $pekerja[$i]['kode_status_kerja'];
				$e 			= $pekerja[$i]['kd_jabatan'];

				if (in_array($d, array('K','P'))) {
					if ($day_c - $day_a < 0) {
						if ($month_c == 3) {
							if ($year_c%4 == 0) {
								$hari = $day_c + 29 - $day_a;
							}else{
								$hari = $day_c + 28 - $day_a;
							}
						}else{
							if (in_array($month_c, array(5,7,10,12))) {
								$hari = $day_c + 30 - $day_a;
							}else{
								$hari = $day_c + 31 - $day_a;
							}
						}
						$bulan1 = $month_c - 1;
					}else{
						$hari = $day_c - $day_a;
						$bulan1 = $month_c;
					}

					if ($bulan1 -  $month_a < 0) {
						$bulan = $bulan1 + 12 - $month_a;
						$tahun1 = $year_c - 1;
					}else{
						$bulan = $bulan1 - $month_a;
						$tahun1 = $year_c;
					}

					if ($year_a <= 1900) {
						$tahun = 0;
					}else{
						$tahun = $tahun1 - $year_a;
					}
					$pekerja[$i]['diangkat'] = $pekerja[$i]['masukkerja'];
				}else{
					if ($day_c - $day_b < 0) {
						if ($month_c == 3) {
							if ($year_c%4 == 0) {
								$hari = $day_c + 29 - $day_b;
							}else{
								$hari = $day_c + 28 - $day_b;
							}
						}else{
							if (in_array($month_c, array(5,7,10,12))) {
								$hari = $day_c + 30 - $day_b;
							}else{
								$hari = $day_c + 31 - $day_b;
							}
						}
						$bulan1 = $month_c - 1;
					}else{
						$hari = $day_c - $day_b;
						$bulan1 = $month_c;
					}

					if ($bulan1 -  $month_b < 0) {
						$bulan = $bulan1 + 12 - $month_b;
						$tahun1 = $year_c - 1;
					}else{
						$bulan = $bulan1 - $month_b;
						$tahun1 = $year_c;
					}

					if ($year_b <= 1900) {
						$tahun = 0;
					}else{
						$tahun = $tahun1 - $year_b;
					}
				}

				if ($tahun >= 1) {
					$bulan_thr = 12;
				}elseif ($bulan >= 1) {
					$bulan_thr = $bulan;
				}else{
					$bulan_thr = 0;
				}
				if (strtotime($b) > strtotime($c)) {
					$bulan_thr = 0;
					$tahun = 0;
					$bulan = 0;
					$hari = 0;
				}
				$pekerja[$i]['masa_kerja'] 	= $tahun." tahun ".$bulan." bulan ".$hari." hari";
				$pekerja[$i]['bulan_thr'] 	= $bulan_thr;
				$pekerja[$i]['proporsi'] 	= round($bulan_thr/12,2);

				$data_thr_detail = array(
					'id_thr'		=> $id_thr,
					'noind'			=> $pekerja[$i]['noind'],
					'nama'			=> $pekerja[$i]['nama'],
					'seksi'			=> $pekerja[$i]['seksi'],
					'masukkerja'	=> $pekerja[$i]['masukkerja'],
					'diangkat'		=> $pekerja[$i]['diangkat'],
					'masa_kerja'	=> $pekerja[$i]['masa_kerja'],
					'bulan_thr'		=> $pekerja[$i]['bulan_thr'],
					'proporsi'		=> $pekerja[$i]['proporsi'],
				);

				$this->M_thrpekerja->insertTHRDetail($data_thr_detail);
			}
		}
		// exit();
		redirect(base_url('MasterPresensi/ReffGaji/THR/lihat/'.$id_thr));
	}

	public function lihat($id){
		$user_id = $this->session->userid;
		$user = $this->session->user;

		$data['Title']			=	'Lihat THR Pekerja';
		$data['Menu'] 			= 	'Penggajian';
		$data['SubMenuOne'] 	= 	'THR Pekerja';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['id_thr'] = $id;
		$data['data'] = $this->M_thrpekerja->getTHRDetailByIdTHR($id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/ReffGaji/THRPekerja/V_lihat',$data);
		$this->load->view('V_Footer',$data);
	}

	public function cetak($id){
		$data['data'] = $this->M_thrpekerja->getTHRDetailByIdTHR($id);
		$data['mengetahui'] = $this->M_thrpekerja->getTHRById($id);
		// print_r($data['mengetahui']);exit();
		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8', 'A4', 8, '', 12, 10, 10, 10, 10, 5);
		$filename = 'Pekerja Cutoff periode '.$value.'.pdf';
		// $this->load->view('MasterPresensi/ReffGaji/THRPekerja/V_cetak', $data);
		$html = $this->load->view('MasterPresensi/ReffGaji/THRPekerja/V_cetak', $data, true);
		$pdf->SetHTMLFooter("<i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-MasterPresensi oleh ".$this->session->user." - ".$this->session->employee." pada tgl. ".strftime('%d/%h/%Y %H:%M:%S').". Halaman {PAGENO} dari {nb}</i>");
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');
	}

	public function transfer($id){
		require_once APPPATH . 'third_party/phpxbase/Column.php';
		require_once APPPATH . 'third_party/phpxbase/Record.php';
		require_once APPPATH . 'third_party/phpxbase/Memo.php';
		require_once APPPATH . 'third_party/phpxbase/Table.php';
		require_once APPPATH . 'third_party/phpxbase/WritableTable.php';

		$data = $this->M_thrpekerja->getTHRDetailByIdTHR($id);
		// echo "<pre>";print_r($data);exit();

		$waktu = date('Y-m-d H:i:s');
		$table = new XBase\WritableTable(FCPATH."assets/upload/TransferReffGaji/lv_info2_thr.dbf");
		$table->openWrite(FCPATH."assets/upload/TransferReffGaji/PER_THR_".$waktu.".dbf");

		foreach ($data as $dt) {

			$seksi = $this->M_transferreffgaji->getSeksi($dt['kodesie']);
			$seksi2 = $this->M_transferreffgaji->getSeksi2($dt['kodesie']);

			if (!empty($seksi2)) {
				if ($seksi2->kodesek == "401013") {
					$kodsie = "040004";
				}else{
					$kodsie = $seksi2->kodesek;
				}
			}else{
				$kodsie = "";
			}

			$record = $table->appendRecord();
			$record->NOIND = $dt['noind'];
			$record->NOINDBR = '';
			$record->NAMA = $dt['nama'];
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
			$record->ANGG_SPSI = "F";
			$record->ANGG_KOP = "F";
			$record->ANGG_DUKA = "F";
			$record->HR_I = 0;
			$record->HR_ABS =  0;
			$record->HR_IK =  0;
			$record->HR_IP =  0;
			$record->HR_IF =  0;
			$record->HR_S2 =  0;
			$record->HR_S3 =  0;
			$record->HUPAMK =  0;
			$record->JAM_LBR =  0;
			$record->HR_UM =  0;
			$record->HR_CATER = 0;
			$record->P_BONSB = 0;
			$record->P_I_KOP =  0;
			$record->P_UT_KOP =  0;
			$record->P_LAIN = 0;
			$record->P_DUKA =  0;
			$record->P_SPSI =  0;
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
			$record->XDUKA = 0;
			$record->PTKP = 0;
			$record->SUBTOTAL1 = 0;
			$record->SUBTOTAL2 = 0;
			$record->SUBTOTAL3 = 0;
			$record->TERIMA = 0;
			$record->KET =  '';
			$record->TKENAPJK =  0;
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
			$record->UBT =  0;
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
			$record->STRUKTUR =  '';
			$record->UMP = 0;
			$record->REK_DPLK = '';
			$record->POT_DPLK = 0;
			$record->UBS =  0;
			$record->ANGG_JKN =  'F';
			$record->KD_LKS =  '';
			$record->HR_IPT =  0;
			$record->HR_UMC =  0;
			$record->DLOBAT =  0;
			$record->JKN =  0;
			$record->JHT =  0;
			$record->JP =  0;
			$record->HR_CUTI = 0;
			$record->HR_IP_LM = 0;
			$record->HR_IK_LM = 0;
			$record->HR_IPT_LM = 0;
			$record->BL_THR = $dt['bulan_thr'];
			$record->BL_UBTHR = in_array(substr($dt['noind'], 0,1), array('A','B')) ? $dt['bulan_thr'] : 0; 
			$record->XTHR = 0;
			$record->XUBTHR = 0;
			$record->THR = 0;
			$record->UBTHR = 0;
			// echo "<pre>";print_r($record);exit();
			$table->writeRecord();
		}
		$table->close();

		redirect(base_url("assets/upload/TransferReffGaji/PER_THR_".$waktu.".dbf"));
	}

	public function export($id){
		$data = $this->M_thrpekerja->getTHRDetailByIdTHR($id);
		$mengetahui = $this->M_thrpekerja->getTHRById($id);

		$this->load->library('excel');
		$worksheet = $this->excel->getActiveSheet();

		$worksheet->setCellValue('A1','No.');
		$worksheet->setCellValue('B1','No. Induk');
		$worksheet->setCellValue('C1','Nama');
		$worksheet->setCellValue('D1','Seksi');
		$worksheet->setCellValue('E1','Diangkat');
		$worksheet->setCellValue('F1','Masa Kerja');
		$worksheet->setCellValue('G1','Bulan THR');
		$worksheet->setCellValue('H1','Proporsi');

		$nomor = 1;
		foreach ($data as $dt) {
			$worksheet->setCellValue('A'.($nomor+1),$nomor);
			$worksheet->setCellValue('B'.($nomor+1),$dt['noind']);
			$worksheet->setCellValue('C'.($nomor+1),$dt['nama']);
			$worksheet->setCellValue('D'.($nomor+1),$dt['seksi']);
			$worksheet->setCellValue('E'.($nomor+1),$dt['diangkat']);
			$worksheet->setCellValue('F'.($nomor+1),$dt['masa_kerja']);
			$worksheet->setCellValue('G'.($nomor+1),$dt['bulan_thr']);
			$worksheet->setCellValue('H'.($nomor+1),$dt['proporsi']);
			$nomor++;
		}

		$this->excel->getActiveSheet()->duplicateStyleArray(
			array(
				'fill' =>array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'startcolor' => array(
						'argb' => '00ccffcc')
				)
			),'A1:H1');
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
			),'A1:H'.($nomor));
		$this->excel->getActiveSheet()->duplicateStyleArray(
			array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				)
			),'C2:D'.($nomor));

		$worksheet->getColumnDimension('A')->setWidth('10');
		$worksheet->getColumnDimension('B')->setWidth('10');
		$worksheet->getColumnDimension('C')->setWidth('20');
		$worksheet->getColumnDimension('D')->setWidth('30');
		$worksheet->getColumnDimension('E')->setWidth('10');
		$worksheet->getColumnDimension('F')->setWidth('20');
		$worksheet->getColumnDimension('G')->setWidth('10');
		$worksheet->getColumnDimension('H')->setWidth('10');
		$worksheet->getStyle('C2:D'.($nomor + 3))->getAlignment()->setWrapText(true);

		$filename ='THR-'.$mengetahui['0']['tgl_idul_fitri'].'_'.$mengetahui['0']['tgl_dibuat'].'.xls';
		header('Content-Type: aplication/vnd.ms-excel');
		header('Content-Disposition:attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
		$writer->save('php://output');
	}

	public function getPekerja(){
		$key = $this->input->get('term');
		$data = $this->M_thrpekerja->getPekerjaByKey($key);
		echo json_encode($data);
	}

	public function hapus($id){
		$this->M_thrpekerja->hapusTHRByID($id);
		redirect(base_url('MasterPresensi/ReffGaji/THR/'));
	}

}

?>