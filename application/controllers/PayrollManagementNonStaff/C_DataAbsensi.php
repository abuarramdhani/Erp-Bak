<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_DataAbsensi extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

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

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/DataAbsensi/V_copy', $data);
		$this->load->view('V_Footer',$data);
	}

	public function check_server(){
		sleep(5);
		echo 1;
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

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/DataAbsensi/V_import', $data);
		$this->load->view('V_Footer',$data);
	}

	public function doImport(){
		$this->session->set_userdata('ImportProgress', '0');

		$bln_gaji = $this->input->post('slcBulan');
		$thn_gaji = $this->input->post('txtTahun');

		$fileName = time().'-'.trim(addslashes($_FILES['file']['name']));
		$fileName = str_replace(' ', '_', $fileName);

		$config['upload_path'] = 'assets/upload/';
		$config['file_name'] = $fileName;
		$config['allowed_types'] = '*';

		$this->load->library('upload', $config);

		$data['upload_data'] = '';
		if ($this->upload->do_upload('file')) {
			$uploadData = $this->upload->data();
			$inputFileName = 'assets/upload/'.$uploadData['file_name'];

			$ket_ijin = array("SKD", "M", "CT", "S1", "S2", "S3", "SU", "T3");

			//$inputFileName = 'assets/upload/1490317033-AHK0117_1234.dbf';
			$db = dbase_open($inputFileName, 0);
			//print_r(dbase_get_header_info($db));
			$db_rows = dbase_numrecords($db);
			echo $db_rows; flush();
			for ($i=1; $i <= $db_rows; $i++) {
				$jml_ijin = array();
				$jml_mangkir = array();

				$db_record = dbase_get_record_with_names($db, $i);

				for ($y=1; $y <= 31; $y++) {
					$x = str_pad($y, 2, "0", STR_PAD_LEFT);
					if (in_array(str_replace(' ', '', utf8_encode($db_record['HM'.$x])), $ket_ijin) || str_replace(' ', '', utf8_encode($db_record['HM'.$x]) == '') ){
						$waktuijin=utf8_encode($db_record['HM'.$x]);
						$waktuijin=(float)$waktuijin;
						$jml_ijin[] = 0;
						echo "ijin ".$waktuijin."<br>";
					}
					else{
						$waktuijin=utf8_encode($db_record['HM'.$x]);
						$waktuijin=(float)$waktuijin;
						$jml_ijin[] = $waktuijin;
						echo "ijin ".$waktuijin."<br>";
					}

					if (str_replace(' ', '', utf8_encode($db_record['HM'.$x])) == 'M') {
						$jml_mangkir[] = 1;
						echo "mangkir ".utf8_encode($db_record['HM'.$x])."<br>";
					}
					else{
						$jml_mangkir[] = 0;
						echo "mangkir ".utf8_encode($db_record['HM'.$x])."<br><br>";
					}
				}

				print_r($jml_ijin);

				$sum_ijin = array_sum($jml_ijin);
				$sum_mangkir = array_sum($jml_mangkir);

				$data = array(
					'bln_gaji' => $bln_gaji,
					'thn_gaji' => $thn_gaji,
					'noind' => utf8_encode($db_record['NOIND']),
					'kodesie' => utf8_encode($db_record['KODESIE']),
					'HM01' => utf8_encode($db_record['HM01']),
					'HM02' => utf8_encode($db_record['HM02']),
					'HM03' => utf8_encode($db_record['HM03']),
					'HM04' => utf8_encode($db_record['HM04']),
					'HM05' => utf8_encode($db_record['HM05']),
					'HM06' => utf8_encode($db_record['HM06']),
					'HM07' => utf8_encode($db_record['HM07']),
					'HM08' => utf8_encode($db_record['HM08']),
					'HM09' => utf8_encode($db_record['HM09']),
					'HM10' => utf8_encode($db_record['HM10']),
					'HM11' => utf8_encode($db_record['HM11']),
					'HM12' => utf8_encode($db_record['HM12']),
					'HM13' => utf8_encode($db_record['HM13']),
					'HM14' => utf8_encode($db_record['HM14']),
					'HM15' => utf8_encode($db_record['HM15']),
					'HM16' => utf8_encode($db_record['HM16']),
					'HM17' => utf8_encode($db_record['HM17']),
					'HM18' => utf8_encode($db_record['HM18']),
					'HM19' => utf8_encode($db_record['HM19']),
					'HM20' => utf8_encode($db_record['HM20']),
					'HM21' => utf8_encode($db_record['HM21']),
					'HM22' => utf8_encode($db_record['HM22']),
					'HM23' => utf8_encode($db_record['HM23']),
					'HM24' => utf8_encode($db_record['HM24']),
					'HM25' => utf8_encode($db_record['HM25']),
					'HM26' => utf8_encode($db_record['HM26']),
					'HM27' => utf8_encode($db_record['HM27']),
					'HM28' => utf8_encode($db_record['HM28']),
					'HM29' => utf8_encode($db_record['HM29']),
					'HM30' => utf8_encode($db_record['HM30']),
					'HM31' => utf8_encode($db_record['HM31']),
					'jam_lembur' => utf8_encode($db_record['JLB']),
					'HMP' => utf8_encode($db_record['HMP']),
					'HMU' => utf8_encode($db_record['HMU']),
					'HMS' => utf8_encode($db_record['HMS']),
					'HMM' => utf8_encode($db_record['HMM']),
					'HM' => utf8_encode($db_record['HM']),
					'UBT' => utf8_encode($db_record['UBT']),
					'HUPAMK' => utf8_encode($db_record['HUPAMK']),
					'IK' => utf8_encode($db_record['IK']),
					'IKSKP' => utf8_encode($db_record['IKSKP']),
					'IKSKU' => utf8_encode($db_record['IKSKU']),
					'IKSKS' => utf8_encode($db_record['IKSKS']),
					'IKSKM' => utf8_encode($db_record['IKSKM']),
					'IKJSP' => utf8_encode($db_record['IKJSP']),
					'IKJSU' => utf8_encode($db_record['IKJSU']),
					'IKJSS' => utf8_encode($db_record['IKJSS']),
					'IKJSM' => utf8_encode($db_record['IKJSM']),
					'ABS' => utf8_encode($db_record['ABS']),
					'T' => utf8_encode($db_record['T']),
					'SKD' => utf8_encode($db_record['SKD']),
					'cuti' => utf8_encode($db_record['CTI']),
					'HL' => utf8_encode($db_record['HL']),
					'PT' => utf8_encode($db_record['PT']),
					'PI' => utf8_encode($db_record['PI']),
					'PM' => utf8_encode($db_record['PM']),
					'DL' => utf8_encode($db_record['DL']),
					'tambahan' => utf8_encode($db_record['TAMBAHAN']),
					'potongan' => utf8_encode($db_record['POTONGAN']),
					'duka' => utf8_encode($db_record['DUKA']),
					'HC' => utf8_encode($db_record['HC']),
					'jml_UM' => utf8_encode($db_record['JML_UM']),
					'cicil' => utf8_encode($db_record['CICIL']),
					'potongan_koperasi' => utf8_encode($db_record['POTKOP']),
					'UBS' => utf8_encode($db_record['UBS']),
					'UM_puasa' => utf8_encode($db_record['UM_PUASA']),
					'SK_CT' => utf8_encode($db_record['SK_CT']),
					'POT_2' => utf8_encode($db_record['POT_2']),
					'TAMB_2' => utf8_encode($db_record['TAMB_2']),
					'kode_lokasi' => utf8_encode($db_record['KD_LKS']),
					'jml_izin' => $sum_ijin,
					'jml_mangkir' => $sum_mangkir,
					'bhmp' => utf8_encode($db_record['BHMP']),
					'bhms' => utf8_encode($db_record['BHMS']),
					'bhmm' => utf8_encode($db_record['BHMM']),
				);
				$this->M_dataabsensi->setAbsensi($data);

				$ImportProgress = ($i/$db_rows)*100;
				$this->session->set_userdata('ImportProgress', $ImportProgress);
				flush();
			}
			unlink($inputFileName);
			//redirect(site_url('PayrollManagementNonStaff/ProsesGaji/DataAbsensi'));
		}
		else{
			echo $this->upload->display_errors();
		}
	}

	public function getImportData(){
		echo number_format($this->session->userdata('ImportProgress'),0,"",".");
		flush();
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
			7 => 'HM01',
			8 => 'HM02',
			9 => 'HM03',
			10 => 'HM04',
			11 => 'HM05',
			12 => 'HM06',
			13 => 'HM07',
			14 => 'HM08',
			15 => 'HM09',
			16 => 'HM10',
			17 => 'HM11',
			18 => 'HM12',
			19 => 'HM13',
			20 => 'HM14',
			21 => 'HM15',
			22 => 'HM16',
			23 => 'HM17',
			24 => 'HM18',
			25 => 'HM19',
			26 => 'HM20',
			27 => 'HM21',
			28 => 'HM22',
			29 => 'HM23',
			30 => 'HM24',
			31 => 'HM25',
			32 => 'HM26',
			33 => 'HM27',
			34 => 'HM28',
			35 => 'HM29',
			36 => 'HM30',
			37 => 'HM31',
			38 => 'jam_lembur',
			39 => 'HMP',
			40 => 'HMU',
			41 => 'HMS',
			42 => 'HMM',
			43 => 'HM',
			44 => 'UBT',
			45 => 'HUPAMK',
			46 => 'IK',
			47 => 'IKSKP',
			48 => 'IKSKU',
			49 => 'IKSKS',
			50 => 'IKSKM',
			51 => 'IKJSP',
			52 => 'IKJSU',
			53 => 'IKJSS',
			54 => 'IKJSM',
			55 => 'ABS',
			56 => 'T',
			57 => 'SKD',
			58 => 'cuti',
			59 => 'HL',
			60 => 'PT',
			61 => 'PI',
			62 => 'PM',
			63 => 'DL',
			64 => 'tambahan',
			65 => 'duka',
			66 => 'potongan',
			67 => 'HC',
			68 => 'jml_UM',
			69 => 'cicil',
			70 => 'potongan_koperasi',
			71 => 'UBS',
			72 => 'UM_puasa',
			73 => 'SK_CT',
			74 => 'POT_2',
			75 => 'TAMB_2',
			76 => 'kode_lokasi',
			77 => 'jml_izin',
			78 => 'jml_mangkir'

		);

		$data_table = $this->M_dataabsensi->getAbsensiDatatables();
		$totalData = $data_table->num_rows();
		$totalFiltered = $totalData;

		if(!empty($requestData['search']['value'])) {
			$data_table = $this->M_dataabsensi->getAbsensiSearch($requestData['search']['value']);
			$totalFiltered = $data_table->num_rows();

			$data_table = $this->M_dataabsensi->getAbsensiOrderLimit($requestData['search']['value'], $columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'], $requestData['length'], $requestData['start']);
		}
		else{
			$data_table = $this->M_dataabsensi->getAbsensiOrderLimit($searchValue = NULL, $columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'], $requestData['length'], $requestData['start']);
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
				$json .= '["'.$no.'", "'.$result['noind'].'", "'.$result['employee_name'].'", "'.$result['kodesie'].'", "'.$result['unit_name'].'", "'.$result['bln_gaji'].'", "'.$result['thn_gaji'].'", "'.$result['HM01'].'", "'.$result['HM02'].'", "'.$result['HM03'].'", "'.$result['HM04'].'", "'.$result['HM05'].'", "'.$result['HM06'].'", "'.$result['HM07'].'", "'.$result['HM08'].'", "'.$result['HM09'].'", "'.$result['HM10'].'", "'.$result['HM11'].'", "'.$result['HM12'].'", "'.$result['HM13'].'", "'.$result['HM14'].'", "'.$result['HM15'].'", "'.$result['HM16'].'", "'.$result['HM17'].'", "'.$result['HM18'].'", "'.$result['HM19'].'", "'.$result['HM20'].'", "'.$result['HM21'].'", "'.$result['HM22'].'", "'.$result['HM23'].'", "'.$result['HM24'].'", "'.$result['HM25'].'", "'.$result['HM26'].'", "'.$result['HM27'].'", "'.$result['HM28'].'", "'.$result['HM29'].'", "'.$result['HM30'].'", "'.$result['HM31'].'", "'.$result['jam_lembur'].'", "'.$result['HMP'].'", "'.$result['HMU'].'", "'.$result['HMS'].'", "'.$result['HMM'].'", "'.$result['HM'].'", "'.$result['UBT'].'", "'.$result['HUPAMK'].'", "'.$result['IK'].'", "'.$result['IKSKP'].'", "'.$result['IKSKU'].'", "'.$result['IKSKS'].'", "'.$result['IKSKM'].'", "'.$result['IKJSP'].'", "'.$result['IKJSU'].'", "'.$result['IKJSS'].'", "'.$result['IKJSM'].'", "'.$result['ABS'].'", "'.$result['T'].'", "'.$result['SKD'].'", "'.$result['cuti'].'", "'.$result['HL'].'", "'.$result['PT'].'", "'.$result['PI'].'", "'.$result['PM'].'", "'.$result['DL'].'", "'.$result['tambahan'].'", "'.$result['duka'].'", "'.$result['potongan'].'", "'.$result['HC'].'", "'.$result['jml_UM'].'", "'.$result['cicil'].'", "'.$result['potongan_koperasi'].'", "'.$result['UBS'].'", "'.$result['UM_puasa'].'", "'.$result['SK_CT'].'", "'.$result['POT_2'].'", "'.$result['TAMB_2'].'", "'.$result['kode_lokasi'].'", "'.$result['jml_izin'].'", "'.$result['jml_mangkir'].'", "'.$result['bhmp'].'", "'.$result['bhms'].'", "'.$result['bhmm'].'"],';
			}
			else{
				$json .= '["'.$no.'", "'.$result['noind'].'", "'.$result['employee_name'].'", "'.$result['kodesie'].'", "'.$result['unit_name'].'", "'.$result['bln_gaji'].'", "'.$result['thn_gaji'].'", "'.$result['HM01'].'", "'.$result['HM02'].'", "'.$result['HM03'].'", "'.$result['HM04'].'", "'.$result['HM05'].'", "'.$result['HM06'].'", "'.$result['HM07'].'", "'.$result['HM08'].'", "'.$result['HM09'].'", "'.$result['HM10'].'", "'.$result['HM11'].'", "'.$result['HM12'].'", "'.$result['HM13'].'", "'.$result['HM14'].'", "'.$result['HM15'].'", "'.$result['HM16'].'", "'.$result['HM17'].'", "'.$result['HM18'].'", "'.$result['HM19'].'", "'.$result['HM20'].'", "'.$result['HM21'].'", "'.$result['HM22'].'", "'.$result['HM23'].'", "'.$result['HM24'].'", "'.$result['HM25'].'", "'.$result['HM26'].'", "'.$result['HM27'].'", "'.$result['HM28'].'", "'.$result['HM29'].'", "'.$result['HM30'].'", "'.$result['HM31'].'", "'.$result['jam_lembur'].'", "'.$result['HMP'].'", "'.$result['HMU'].'", "'.$result['HMS'].'", "'.$result['HMM'].'", "'.$result['HM'].'", "'.$result['UBT'].'", "'.$result['HUPAMK'].'", "'.$result['IK'].'", "'.$result['IKSKP'].'", "'.$result['IKSKU'].'", "'.$result['IKSKS'].'", "'.$result['IKSKM'].'", "'.$result['IKJSP'].'", "'.$result['IKJSU'].'", "'.$result['IKJSS'].'", "'.$result['IKJSM'].'", "'.$result['ABS'].'", "'.$result['T'].'", "'.$result['SKD'].'", "'.$result['cuti'].'", "'.$result['HL'].'", "'.$result['PT'].'", "'.$result['PI'].'", "'.$result['PM'].'", "'.$result['DL'].'", "'.$result['tambahan'].'", "'.$result['duka'].'", "'.$result['potongan'].'", "'.$result['HC'].'", "'.$result['jml_UM'].'", "'.$result['cicil'].'", "'.$result['potongan_koperasi'].'", "'.$result['UBS'].'", "'.$result['UM_puasa'].'", "'.$result['SK_CT'].'", "'.$result['POT_2'].'", "'.$result['TAMB_2'].'", "'.$result['kode_lokasi'].'", "'.$result['jml_izin'].'", "'.$result['jml_mangkir'].'", "'.$result['bhmp'].'", "'.$result['bhms'].'", "'.$result['bhmm'].'"]';
			}
			$no++;
		}
		$json .= ']}';

		echo $json;
	}

}

/* End of file C_Kondite.php */
/* Location: ./application/controllers/PayrollManagementNonStaff/C_Kondite.php */
/* Generated automatically on 2017-03-20 13:35:14 */