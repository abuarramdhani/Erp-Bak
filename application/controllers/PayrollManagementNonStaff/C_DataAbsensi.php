<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

set_time_limit(0);
class C_DataAbsensi extends CI_Controller
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

		$this->load->library('csvimport');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PayrollManagementNonStaff/M_dataabsensi');

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	/* LIST DATA */
	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Data Absensi';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Data Absensi';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_dataabsensi->getDataPresensi();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/DataAbsensi/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function download_data(){
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Download Data';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Data Absensi';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['user'] = $this->session->user;
		$data['data'] = $this->M_dataabsensi->getDataPresensi();

		$this->M_dataabsensi->updateProgress('Download Absensi',0,$user);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/DataAbsensi/V_copy', $data);
		$this->load->view('V_Footer',$data);
	}

	public function doDownload(){
		$user = $this->session->user;
		$this->M_dataabsensi->updateProgress('Download Absensi',0,$user);

		$periode = $this->input->post('checkPenggajian');

		$column_view = array('NO','NOIND','NAMA','KODESIE','BLN_GAJI','THN_GAJI','HM01','HM02','HM03','HM04','HM05','HM06','HM07','HM08','HM09','HM10','HM11','HM12','HM13','HM14','HM15','HM16','HM17','HM18','HM19','HM20','HM21','HM22','HM23','HM24','HM25','HM26','HM27','HM28','HM29','HM30','HM31','JAM_LEMBUR','HMP','HMU','HMS','HMM','HM','UBT','HUPAMK','IK','IKSKP','IKSKU','IKSKS','IKSKM','IKJSP','IKJSU','IKJSS','IKJSM','ABS','T','SKD','CUTI','HL','PT','PI','PM','DL','TAMBAHAN','DUKA','POTONGAN','HC','JML_UM','CICIL','POTONGAN_KOPERASI','UBS','UM_PUASA','SK_CT','POT_2','TAMB_2','KODE_LOKASI','JML_IZIN','JML_MANGKIR','KET');
		$column_table = array('absensi_id','noind','employee_name','kodesie','bln_gaji','thn_gaji','hm01','hm02','hm03','hm04','hm05','hm06','hm07','hm08','hm09','hm10','hm11','hm12','hm13','hm14','hm15','hm16','hm17','hm18','hm19','hm20','hm21','hm22','hm23','hm24','hm25','hm26','hm27','hm28','hm29','hm30','hm31','jam_lembur','hmp','hmu','hms','hmm','hm','ubt','hupamk','ik','ikskp','iksku','iksks','ikskm','ikjsp','ikjsu','ikjss','ikjsm','abs','t','skd','cuti','hl','pt','pi','pm','dl','tambahan','duka','potongan','hc','jml_um','cicil','potongan_koperasi','ubs','um_puasa','sk_ct','pot_2','tamb_2','kode_lokasi','jml_izin','jml_mangkir','ket');

		$filename ='Data Absensi.xls';
		header('Content-Type: aplication/vnd.ms-excel');
		header('Content-Disposition:attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		if ($periode) {
			//insert to sys.log_activity
			$aksi = 'Payroll Management NStaf';
			$detail = "Download data absensi periode=$periode";
			$this->log_activity->activity_log($aksi, $detail);
			//
			$this->load->library("excel");
			$objPHPExcel = $this->excel;
			$objPHPExcel->setActiveSheetIndex(0);
			$column = 0;
			foreach($column_view as $cv){
				$kolom = PHPExcel_Cell::stringFromColumnIndex($column);
				$objPHPExcel->getActiveSheet()->setCellValue($kolom.'1', $cv);
				$column++;
			}
			$row = 2;
			$persen = count($periode);
			$selesai = 0;
			foreach ($periode as $key) {
				$record = array();
				$dt = explode("-", $key);
				$record = $this->M_dataabsensi->getDetailDataPresensi($dt['0'],$dt['1'],$dt['2']);

				foreach ($record as $rec) {
					$column = 0;
					foreach ($rec as $val) {
						if ($column == 0) {
							$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, $row, $row-1);
						}elseif ($column == 1) {
							$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, $row, $val);
						}elseif ($rec['employee_name'] == $val) {
							$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $rec['employee_name']);
						}else{
							$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column+1, $row, $val);
						}

						$column++;
					}
					$row++;
				}
				$selesai++;
				$persentase = ($selesai/$persen)*100;
				$persentase = round($persentase);

				$cek_data = $this->M_dataabsensi->getProgress($user,'Import Absensi');
				if ($cek_data == 0) {
					$this->M_dataabsensi->setProgress('Download Absensi',$persentase,$user);
				}else{
					$this->M_dataabsensi->updateProgress('Download Absensi',$persentase,$user);
				}

				session_write_close();
				flush();
			}
			// exit();


			$writer = PHPExcel_IOFactory::createWriter($this->excel,'Excel5');
			$writer->save('php://output');
		}else{
			echo "Periode Kosong";
		}
	}

	public function getDetailData(){
		$bulan 	= $this->input->get('bulan');
		$tahun 	= $this->input->get('tahun');
		$ket 	= $this->input->get('ket');

		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Detail Data';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Data Absensi';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['user'] = $this->session->user;
		$data['data'] = $this->M_dataabsensi->getDetailDataPresensi($bulan,$tahun,$ket);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/DataAbsensi/V_copydetail', $data);
		$this->load->view('V_Footer',$data);

	}

	public function check_server(){
		$hasil = $this->M_dataabsensi->check_connection();
		echo $hasil;
	}

	public function import_data(){
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Import Data';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Data Absensi';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['user'] = $this->session->user;

		$this->M_dataabsensi->updateProgress('Import Absensi',0,$user);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/DataAbsensi/V_import', $data);
		$this->load->view('V_Footer',$data);
	}

	public function doImport(){
		$user = $this->session->user;
		$this->M_dataabsensi->updateProgress('Import Absensi',0,$user);
		$bln_gaji = $this->input->post('slcBulan');
		$thn_gaji = $this->input->post('txtTahun');

		$fileName = time().'-'.trim(addslashes($_FILES['file']['name']));
		$fileName = str_replace(' ', '_', $fileName);

		$config['upload_path'] = 'assets/upload/PayrollNonstaff/DataAbsensi/';
		$config['file_name'] = $fileName;
		$config['allowed_types'] = '*';

		$this->load->library('upload', $config);

		$data['upload_data'] = '';
		if ($this->upload->do_upload('file')) {
			//insert to sys.log_activity
			$aksi = 'Payroll Management NStaf';
			$detail = "Import data absensi periode=$thn_gaji $bln_gaji";
			$this->log_activity->activity_log($aksi, $detail);
			//
			$uploadData = $this->upload->data();
			$inputFileName = 'assets/upload/PayrollNonstaff/DataAbsensi/'.$uploadData['file_name'];
			$inputFileType = $uploadData['file_type'];

			$ket_ijin = array("SKD", "M", "CT", "S1", "S2", "S3", "SU", "T3");

			$this->load->library('excel');

			$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
	        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
	        $objPHPExcel = $objReader->load($inputFileName);

			$sheet = $objPHPExcel->setActiveSheetIndex(0);
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();
			$columnCount = 	PHPExcel_Cell::columnIndexFromString($highestColumn);
			$sheetHead = $sheet->rangeToArray(
				'A1:'.$highestColumn.'1',NULL,TRUE,FALSE
			);

			$sheetData = $sheet->rangeToArray(
				'A2:'.$highestColumn.$highestRow,NULL,TRUE,FALSE
			);

			$db_record = array();

			for ($row=0; $row <= $highestRow - 2 ; $row++) {
				$a = array();
				for ($column=0; $column <= $columnCount - 1; $column++) {
					$headTitle = explode(',', $sheetHead[0][$column]);
					$a[$headTitle[0]] = $sheetData[$row][$column];
				}
				$db_record[$row] = $a;
			}

			// echo "<pre>";print_r($db_record);exit();

			flush();
			for ($i=0; $i <= $highestRow - 2; $i++) {
				$jml_ijin = array();
				$jml_mangkir = array();

				for ($y=1; $y <= 31; $y++) {
					$x = str_pad($y, 2, "0", STR_PAD_LEFT);
					if (in_array(str_replace(' ', '', utf8_encode($db_record[$i]['HM'.$x])), $ket_ijin) || str_replace(' ', '', utf8_encode($db_record[$i]['HM'.$x]) == '') ){
						$waktuijin=utf8_encode($db_record[$i]['HM'.$x]);
						$waktuijin=(float)$waktuijin;
						$jml_ijin[] = 0;
					}
					else{
						$waktuijin=utf8_encode($db_record[$i]['HM'.$x]);
						$waktuijin=(float)$waktuijin;
						$jml_ijin[] = $waktuijin;
					}

					if (str_replace(' ', '', utf8_encode($db_record[$i]['HM'.$x])) == 'M') {
						$jml_mangkir[] = 1;
					}
					else{
						$jml_mangkir[] = 0;
					}
				}

				$sum_ijin = array_sum($jml_ijin);
				$sum_mangkir = array_sum($jml_mangkir);

				$data = array(
					'bln_gaji' => $bln_gaji,
					'thn_gaji' => $thn_gaji,
					'noind' => utf8_encode($db_record[$i]['NOIND']),
					'kodesie' => utf8_encode($db_record[$i]['KODESIE']),
					'hm01' => utf8_encode($db_record[$i]['HM01']),
					'hm02' => utf8_encode($db_record[$i]['HM02']),
					'hm03' => utf8_encode($db_record[$i]['HM03']),
					'hm04' => utf8_encode($db_record[$i]['HM04']),
					'hm05' => utf8_encode($db_record[$i]['HM05']),
					'hm06' => utf8_encode($db_record[$i]['HM06']),
					'hm07' => utf8_encode($db_record[$i]['HM07']),
					'hm08' => utf8_encode($db_record[$i]['HM08']),
					'hm09' => utf8_encode($db_record[$i]['HM09']),
					'hm10' => utf8_encode($db_record[$i]['HM10']),
					'hm11' => utf8_encode($db_record[$i]['HM11']),
					'hm12' => utf8_encode($db_record[$i]['HM12']),
					'hm13' => utf8_encode($db_record[$i]['HM13']),
					'hm14' => utf8_encode($db_record[$i]['HM14']),
					'hm15' => utf8_encode($db_record[$i]['HM15']),
					'hm16' => utf8_encode($db_record[$i]['HM16']),
					'hm17' => utf8_encode($db_record[$i]['HM17']),
					'hm18' => utf8_encode($db_record[$i]['HM18']),
					'hm19' => utf8_encode($db_record[$i]['HM19']),
					'hm20' => utf8_encode($db_record[$i]['HM20']),
					'hm21' => utf8_encode($db_record[$i]['HM21']),
					'hm22' => utf8_encode($db_record[$i]['HM22']),
					'hm23' => utf8_encode($db_record[$i]['HM23']),
					'hm24' => utf8_encode($db_record[$i]['HM24']),
					'hm25' => utf8_encode($db_record[$i]['HM25']),
					'hm26' => utf8_encode($db_record[$i]['HM26']),
					'hm27' => utf8_encode($db_record[$i]['HM27']),
					'hm28' => utf8_encode($db_record[$i]['HM28']),
					'hm29' => utf8_encode($db_record[$i]['HM29']),
					'hm30' => utf8_encode($db_record[$i]['HM30']),
					'hm31' => utf8_encode($db_record[$i]['HM31']),
					'jam_lembur' => utf8_encode($db_record[$i]['JLB']),
					'hmp' => utf8_encode($db_record[$i]['HMP']),
					'hmu' => utf8_encode($db_record[$i]['HMU']),
					'hms' => utf8_encode($db_record[$i]['HMS']),
					'hmm' => utf8_encode($db_record[$i]['HMM']),
					'hm' => utf8_encode($db_record[$i]['HM']),
					'ubt' => utf8_encode($db_record[$i]['UBT']),
					'hupamk' => utf8_encode($db_record[$i]['HUPAMK']),
					'ik' => utf8_encode($db_record[$i]['IK']),
					'ikskp' => utf8_encode($db_record[$i]['IKSKP']),
					'iksku' => utf8_encode($db_record[$i]['IKSKU']),
					'iksks' => utf8_encode($db_record[$i]['IKSKS']),
					'ikskm' => utf8_encode($db_record[$i]['IKSKM']),
					'ikjsp' => utf8_encode($db_record[$i]['IKJSP']),
					'ikjsu' => utf8_encode($db_record[$i]['IKJSU']),
					'ikjss' => utf8_encode($db_record[$i]['IKJSS']),
					'ikjsm' => utf8_encode($db_record[$i]['IKJSM']),
					'abs' => utf8_encode($db_record[$i]['ABS']),
					't' => utf8_encode($db_record[$i]['T']),
					'skd' => utf8_encode($db_record[$i]['SKD']),
					'cuti' => utf8_encode($db_record[$i]['CTI']),
					'hl' => utf8_encode($db_record[$i]['HL']),
					'pt' => utf8_encode($db_record[$i]['PT']),
					'pi' => utf8_encode($db_record[$i]['PI']),
					'pm' => utf8_encode($db_record[$i]['PM']),
					'dl' => utf8_encode($db_record[$i]['DL']),
					'tambahan' => utf8_encode($db_record[$i]['TAMBAHAN']),
					'potongan' => utf8_encode($db_record[$i]['POTONGAN']),
					'duka' => utf8_encode($db_record[$i]['DUKA']),
					'hc' => utf8_encode($db_record[$i]['HC']),
					'jml_um' => utf8_encode($db_record[$i]['JML_UM']),
					'cicil' => utf8_encode($db_record[$i]['CICIL']),
					'potongan_koperasi' => utf8_encode($db_record[$i]['POTKOP']),
					'ubs' => utf8_encode($db_record[$i]['UBS']),
					'um_puasa' => utf8_encode($db_record[$i]['UM_PUASA']),
					'sk_ct' => utf8_encode($db_record[$i]['SK_CT']),
					'pot_2' => utf8_encode($db_record[$i]['POT_2']),
					'tamb_2' => utf8_encode($db_record[$i]['TAMB_2']),
					'kode_lokasi' => utf8_encode($db_record[$i]['KD_LKS']),
					'ket' => utf8_encode($db_record[$i]['KET']),
					'jml_izin' => $sum_ijin,
					'jml_mangkir' => $sum_mangkir
				);
				$where = array(
						'bln_gaji' => $bln_gaji,
						'thn_gaji' => $thn_gaji,
						'noind' => utf8_encode($db_record[$i]['NOIND'])
					);
				$cek_data = $this->M_dataabsensi->cek_absensi($where);
				if ($cek_data == 0) {
					$this->M_dataabsensi->setAbsensi($data);
				}else{
					$this->M_dataabsensi->updateAbsensi($data,$where);
				}


				$ImportProgress = ($i/($highestRow - 2))*100;
				$ImportProgress = round($ImportProgress);
				$cek_data = $this->M_dataabsensi->getProgress($user,'Import Absensi');
				if ($cek_data == 0) {
					$this->M_dataabsensi->setProgress('Import Absensi',$ImportProgress,$user);
				}else{
					$this->M_dataabsensi->updateProgress('Import Absensi',$ImportProgress,$user);
				}
				session_write_close();
				flush();
			}
			// unlink($inputFileName);
			// redirect(site_url('PayrollManagementNonStaff/ProsesGaji/DataAbsensi'));
			// $this->import_data();
		}
		else{
			echo $this->upload->display_errors();
		}
	}

	public function getProgressData(){
		$user = $this->input->get('user');
		$type = $this->input->get('type');
		$data = $this->M_dataabsensi->getProgress($user,$type);
		echo round($data,2);
		exit();
	}

	public function clear_data(){
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Clear Data';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Data Absensi';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/DataAbsensi/V_clear', $data);
		$this->load->view('V_Footer',$data);
	}

	public function doClearData(){
		$bln_gaji = $this->input->post('slcBulan');
		$thn_gaji = $this->input->post('txtTahun');

		$data = array(
			'bln_gaji' => $bln_gaji,
			'thn_gaji' => $thn_gaji,
		);
		//insert to sys.log_activity
		$aksi = 'Payroll Management NStaf';
		$detail = "Clear data absensi periode=$thn_gaji $bln_gaji";
		$this->log_activity->activity_log($aksi, $detail);
		//

		$this->M_dataabsensi->clearAbsensi($data);
	}

	public function showList(){
		$requestData= $_REQUEST;

		// print_r($requestData);exit;

		$columns = array(
			0 => 'noind',
			1 => 'noind',
			2 => 'employee_name',
			3 => 'kodesie',
			4 => 'unit_name',
			5 => 'bln_gaji',
			6 => 'thn_gaji',
			7 => 'hm01',
			8 => 'hm02',
			9 => 'hm03',
			10 => 'hm04',
			11 => 'hm05',
			12 => 'hm06',
			13 => 'hm07',
			14 => 'hm08',
			15 => 'hm09',
			16 => 'hm10',
			17 => 'hm11',
			18 => 'hm12',
			19 => 'hm13',
			20 => 'hm14',
			21 => 'hm15',
			22 => 'hm16',
			23 => 'hm17',
			24 => 'hm18',
			25 => 'hm19',
			26 => 'hm20',
			27 => 'hm21',
			28 => 'hm22',
			29 => 'hm23',
			30 => 'hm24',
			31 => 'hm25',
			32 => 'hm26',
			33 => 'hm27',
			34 => 'hm28',
			35 => 'hm29',
			36 => 'hm30',
			37 => 'hm31',
			38 => 'jam_lembur',
			39 => 'hmp',
			40 => 'hmu',
			41 => 'hms',
			42 => 'hmm',
			43 => 'hm',
			44 => 'ubt',
			45 => 'hupamk',
			46 => 'ik',
			47 => 'ikskp',
			48 => 'iksku',
			49 => 'iksks',
			50 => 'ikskm',
			51 => 'ikjsp',
			52 => 'ikjsu',
			53 => 'ikjss',
			54 => 'ikjsm',
			55 => 'abs',
			56 => 't',
			57 => 'skd',
			58 => 'cuti',
			59 => 'hl',
			60 => 'pt',
			61 => 'pi',
			62 => 'pm',
			63 => 'dl',
			64 => 'tambahan',
			65 => 'duka',
			66 => 'potongan',
			67 => 'hc',
			68 => 'jml_um',
			69 => 'cicil',
			70 => 'potongan_koperasi',
			71 => 'ubs',
			72 => 'um_puasa',
			73 => 'sk_ct',
			74 => 'pot_2',
			75 => 'tamb_2',
			76 => 'kode_lokasi',
			77 => 'jml_izin',
			78 => 'jml_mangkir'

		);

		$data_table = $this->M_dataabsensi->getAbsensiDatatables($requestData['dataFilter']);
		$totalData = $data_table->num_rows();
		$totalFiltered = $totalData;

		if(!empty($requestData['search']['value'])) {
			$data_table = $this->M_dataabsensi->getAbsensiSearch($requestData['search']['value'],$requestData['dataFilter']);
			$totalFiltered = $data_table->num_rows();

			$data_table = $this->M_dataabsensi->getAbsensiOrderLimit($requestData['search']['value'], $columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'], $requestData['length'], $requestData['start']);
		}
		else{
			$data_table = $this->M_dataabsensi->getAbsensiOrderLimit($searchValue = NULL, $columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'], $requestData['length'], $requestData['start'],$requestData['dataFilter']);
		}

		$data = array();
		$no = 1;
		$data_array = $data_table->result_array();

		$json = "{";
		$json .= '"draw":'.intval( $requestData['draw'] ).',';
		$json .= '"recordsTotal":'.intval( $totalData ).',';
		$json .= '"recordsFiltered":'.intval( $totalFiltered ).',';
		$json .= '"data":[';

		$count = count($data_array);
		$no = 1;

		//json_encode alternative
		foreach ($data_array as $result) {
			$count--;
			if ($count != 0) {
				$json .= '["'.$no.'", "'.$result['noind'].'", "'.$result['employee_name'].'", "'.$result['kodesie'].'", "'.$result['unit_name'].'", "'.$result['bln_gaji'].'", "'.$result['thn_gaji'].'", "'.$result['hm01'].'", "'.$result['hm02'].'", "'.$result['hm03'].'", "'.$result['hm04'].'", "'.$result['hm05'].'", "'.$result['hm06'].'", "'.$result['hm07'].'", "'.$result['hm08'].'", "'.$result['hm09'].'", "'.$result['hm10'].'", "'.$result['hm11'].'", "'.$result['hm12'].'", "'.$result['hm13'].'", "'.$result['hm14'].'", "'.$result['hm15'].'", "'.$result['hm16'].'", "'.$result['hm17'].'", "'.$result['hm18'].'", "'.$result['hm19'].'", "'.$result['hm20'].'", "'.$result['hm21'].'", "'.$result['hm22'].'", "'.$result['hm23'].'", "'.$result['hm24'].'", "'.$result['hm25'].'", "'.$result['hm26'].'", "'.$result['hm27'].'", "'.$result['hm28'].'", "'.$result['hm29'].'", "'.$result['hm30'].'", "'.$result['hm31'].'", "'.$result['jam_lembur'].'", "'.$result['hmp'].'", "'.$result['hmu'].'", "'.$result['hms'].'", "'.$result['hmm'].'", "'.$result['hm'].'", "'.$result['ubt'].'", "'.$result['hupamk'].'", "'.$result['ik'].'", "'.$result['ikskp'].'", "'.$result['iksku'].'", "'.$result['iksks'].'", "'.$result['ikskm'].'", "'.$result['ikjsp'].'", "'.$result['ikjsu'].'", "'.$result['ikjss'].'", "'.$result['ikjsm'].'", "'.$result['abs'].'", "'.$result['t'].'", "'.$result['skd'].'", "'.$result['cuti'].'", "'.$result['hl'].'", "'.$result['pt'].'", "'.$result['pi'].'", "'.$result['pm'].'", "'.$result['dl'].'", "'.$result['tambahan'].'", "'.$result['duka'].'", "'.$result['potongan'].'", "'.$result['hc'].'", "'.$result['jml_um'].'", "'.$result['cicil'].'", "'.$result['potongan_koperasi'].'", "'.$result['ubs'].'", "'.$result['um_puasa'].'", "'.$result['sk_ct'].'", "'.$result['pot_2'].'", "'.$result['tamb_2'].'", "'.$result['kode_lokasi'].'", "'.$result['jml_izin'].'", "'.$result['jml_mangkir'].'"],';
			}
			else{
				$json .= '["'.$no.'", "'.$result['noind'].'", "'.$result['employee_name'].'", "'.$result['kodesie'].'", "'.$result['unit_name'].'", "'.$result['bln_gaji'].'", "'.$result['thn_gaji'].'", "'.$result['hm01'].'", "'.$result['hm02'].'", "'.$result['hm03'].'", "'.$result['hm04'].'", "'.$result['hm05'].'", "'.$result['hm06'].'", "'.$result['hm07'].'", "'.$result['hm08'].'", "'.$result['hm09'].'", "'.$result['hm10'].'", "'.$result['hm11'].'", "'.$result['hm12'].'", "'.$result['hm13'].'", "'.$result['hm14'].'", "'.$result['hm15'].'", "'.$result['hm16'].'", "'.$result['hm17'].'", "'.$result['hm18'].'", "'.$result['hm19'].'", "'.$result['hm20'].'", "'.$result['hm21'].'", "'.$result['hm22'].'", "'.$result['hm23'].'", "'.$result['hm24'].'", "'.$result['hm25'].'", "'.$result['hm26'].'", "'.$result['hm27'].'", "'.$result['hm28'].'", "'.$result['hm29'].'", "'.$result['hm30'].'", "'.$result['hm31'].'", "'.$result['jam_lembur'].'", "'.$result['hmp'].'", "'.$result['hmu'].'", "'.$result['hms'].'", "'.$result['hmm'].'", "'.$result['hm'].'", "'.$result['ubt'].'", "'.$result['hupamk'].'", "'.$result['ik'].'", "'.$result['ikskp'].'", "'.$result['iksku'].'", "'.$result['iksks'].'", "'.$result['ikskm'].'", "'.$result['ikjsp'].'", "'.$result['ikjsu'].'", "'.$result['ikjss'].'", "'.$result['ikjsm'].'", "'.$result['abs'].'", "'.$result['t'].'", "'.$result['skd'].'", "'.$result['cuti'].'", "'.$result['hl'].'", "'.$result['pt'].'", "'.$result['pi'].'", "'.$result['pm'].'", "'.$result['dl'].'", "'.$result['tambahan'].'", "'.$result['duka'].'", "'.$result['potongan'].'", "'.$result['hc'].'", "'.$result['jml_um'].'", "'.$result['cicil'].'", "'.$result['potongan_koperasi'].'", "'.$result['ubs'].'", "'.$result['um_puasa'].'", "'.$result['sk_ct'].'", "'.$result['pot_2'].'", "'.$result['tamb_2'].'", "'.$result['kode_lokasi'].'", "'.$result['jml_izin'].'", "'.$result['jml_mangkir'].'"]';
			}
			$no++;
		}
		$json .= ']}';

		echo $json;
	}

	public function downloadExcel()
    {
		//insert to sys.log_activity
		$aksi = 'Payroll Management NStaf';
		$detail = "Download Excel data absensi";
		$this->log_activity->activity_log($aksi, $detail);
		//
		$filter = $this->input->get('filter');
		$datafilter = $this->input->get('data');
		$column_table = array('', 'noind', 'employee_name', 'kodesie', 'unit_name', 'bln_gaji', 'thn_gaji', 'hm01', 'hm02', 'hm03',
			'hm04', 'hm05', 'hm06', 'hm07', 'hm08', 'hm09', 'hm10', 'hm11', 'hm12', 'hm13', 'hm14', 'hm15', 'hm16', 'hm17', 'hm18', 'hm19',
			'hm20', 'hm21', 'hm22', 'hm23', 'hm24', 'hm25', 'hm26', 'hm27', 'hm28', 'hm29', 'hm30', 'hm31', 'jam_lembur', 'hmp',
			'hmu', 'hms', 'hmm', 'hm', 'ubt', 'hupamk', 'ik', 'ikskp', 'iksku', 'iksks', 'ikskm', 'ikjsp', 'ikjsu', 'ikjss',
			'ikjsm', 'abs', 't', 'skd', 'cuti', 'hl', 'pt', 'pi', 'pm', 'dl', 'tambahan', 'duka', 'potongan', 'hc', 'jml_um',
			'cicil', 'potongan_koperasi', 'ubs', 'um_puasa', 'sk_ct', 'pot_2', 'tamb_2', 'kode_lokasi', 'jml_izin',
			'jml_mangkir');
		$column_view = array('no', 'no induk', 'nama', 'kodesie', 'nama unit', 'bulan gaji', 'tahun gaji', 'hm01', 'hm02', 'hm03', 'hm04',
			'hm05', 'hm06', 'hm07', 'hm08', 'hm09', 'hm10', 'hm11', 'hm12', 'hm13', 'hm14', 'hm15', 'hm16', 'hm17',
			'hm18', 'hm19', 'hm20', 'hm21', 'hm22', 'hm23', 'hm24', 'hm25', 'hm26', 'hm27', 'hm28', 'hm29', 'hm30',
			'hm31', 'jam lembur', 'hmp', 'hmu', 'hms', 'hmm', 'hm', 'ubt', 'hupamk', 'ik', 'ikskp', 'iksku',
			'iksks', 'ikskm', 'ikjsp', 'ikjsu', 'ikjss', 'ikjsm', 'abs', 't', 'skd', 'cuti', 'hl', 'pt', 'pi',
			'pm', 'dl', 'tambahan', 'duka', 'potongan', 'hc', 'jumlah um', 'cicil', 'potongan koperasi', 'ubs',
			'um puasa', 'sk ct', 'pot 2', 'tamb 2', 'kode lokasi', 'jml izin', 'jml mangkir');
		$data_table = $this->M_dataabsensi->getAbsensiSearch($filter,$datafilter)->result_array();

		$this->load->library("excel");
		$objPHPExcel = $this->excel;
		$objPHPExcel->setActiveSheetIndex(0);
		$column = 0;

		foreach($column_view as $cv){
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, 1, strtoupper($cv));
			$column++;
		}
		// print_r($data_table);
		$excel_row = 2;
		foreach($data_table as $dt){
			$excel_col = 0;
			foreach($column_table as $ct){
				if($ct == ''){
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($excel_col, $excel_row, $excel_row-1);
					// echo $excel_row-1;
				}else{
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($excel_col, $excel_row, $dt[$ct]);
					// echo $dt[$ct];
				}
				$excel_col++;
				// print_r($dt);
			}
			$excel_row++;
		}
		// exit();
		$objPHPExcel->getActiveSheet()->setTitle('Quick ERP');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

		header('Content-Disposition: attachment;filename="DataAbsensi.xlsx"');
		$objWriter->save("php://output");
	}

}

/* End of file C_Kondite.php */
/* Location: ./application/controllers/PayrollManagementNonStaff/C_Kondite.php */
/* Generated automatically on 2017-03-20 13:35:14 */
