<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_DataLKHSeksi extends CI_Controller
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

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PayrollManagementNonStaff/M_datalkhseksi');

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

		$data['Title'] = 'Data LKH Seksi';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Data LKH Seksi';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/DataLKHSeksi/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	public function download_data(){
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Download Data';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Data LKH Seksi';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/DataLKHSeksi/V_copy', $data);
		$this->load->view('V_Footer',$data);
	}

	public function check_server(){
		echo 1;
		sleep(5);
	}

	public function import_data(){
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Import Data';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Data LKH Seksi';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/DataLKHSeksi/V_import', $data);
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
			// $inputFileName = 'assets/upload/1490405144-PROD0117_(copy).dbf';
			$db = dbase_open($inputFileName, 0);
			// print_r(dbase_get_header_info($db));
			$db_rows = dbase_numrecords($db);
			for ($i=1; $i <= $db_rows; $i++) {
				$db_record = dbase_get_record_with_names($db, $i);

				$data = array(
					'tgl' => $db_record['TGL'],
					'noind' => $db_record['NOIND'],
					'kode_barang' => $db_record['KODEPART'],
					'kode_proses' => $db_record['KODEPRO'],
					'jml_barang' => $db_record['JUMLAH'],
					'reject' => ($db_record['JUMLAH'] - $db_record['BAIK']),
					'afmat' => $db_record['AFMAT'],
					'afmch' => $db_record['AFMCH'],
					'repair' => $db_record['REP'],
					'setting_time' => $db_record['SETTING'],
					'shift' => $db_record['SHIFT'],
					'status' => $db_record['STATUS'],
					'kode_barang_target_sementara' => $db_record['KODESAMA'],
					'kode_proses_target_sementara' => $db_record['PROSAMA'],
				);

				$this->M_datalkhseksi->setLKHSeksi($data);

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

	public function clear_data(){
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Clear Data';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Data LKH Seksi';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/DataLKHSeksi/V_clear', $data);
		$this->load->view('V_Footer',$data);
	}

	public function doClearData(){
		$bln_gaji = $this->input->post('slcBulan');
		$thn_gaji = $this->input->post('txtTahun');

		$firstdate = date('Y-m-01', strtotime($thn_gaji.'-'.$bln_gaji.'-01'));
		$lastdate = date('Y-m-t', strtotime($thn_gaji.'-'.$bln_gaji.'-01'));

		$this->M_datalkhseksi->clearData($firstdate, $lastdate);
	}

	public function showList(){
		$requestData= $_REQUEST;

		// print_r($requestData);exit;

		$columns = array(   
			0 => 'noind',
			1 => 'tgl',
			2 => 'noind',
			3 => 'kode_barang',
			4 => 'kode_proses',
			5 => 'jml_barang',
			6 => 'afmat',
			7 => 'afmch',
			8 => 'repair',
			9 => 'reject',
			10 => 'setting_time',
			11 => 'shift',
			12 => 'status',
			13 => 'kode_barang_target_sementara',
			14 => 'kode_proses_target_sementara'
		);

		$data_table = $this->M_datalkhseksi->getLKHSeksiDatatables();
		$totalData = $data_table->num_rows();
		$totalFiltered = $totalData;

		if(!empty($requestData['search']['value'])) {
			$data_table = $this->M_datalkhseksi->getLKHSeksiSearch($requestData['search']['value']);
			$totalFiltered = $data_table->num_rows();

			$data_table = $this->M_datalkhseksi->getLKHSeksiOrderLimit($requestData['search']['value'], $columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'], $requestData['length'], $requestData['start']);
		}
		else{
			$data_table = $this->M_datalkhseksi->getLKHSeksiOrderLimit($searchValue = NULL, $columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'], $requestData['length'], $requestData['start']);
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
		foreach ($data_array as $result) {
			$count--;
			if ($count != 0) {
				$json .= '["'.$no.'", "'.$result['tgl'].'", "'.$result['noind'].'", "'.$result['employee_name'].'", "'.$result['kode_barang'].'", "'.$result['kode_proses'].'", "'.$result['jml_barang'].'", "'.$result['afmat'].'", "'.$result['afmch'].'", "'.$result['repair'].'", "'.$result['reject'].'", "'.$result['setting_time'].'", "'.$result['shift'].'", "'.$result['status'].'", "'.$result['kode_barang_target_sementara'].'", "'.$result['kode_proses_target_sementara'].'"],';
			}
			else{
				$json .= '["'.$no.'", "'.$result['tgl'].'", "'.$result['noind'].'", "'.$result['employee_name'].'", "'.$result['kode_barang'].'", "'.$result['kode_proses'].'", "'.$result['jml_barang'].'", "'.$result['afmat'].'", "'.$result['afmch'].'", "'.$result['repair'].'", "'.$result['reject'].'", "'.$result['setting_time'].'", "'.$result['shift'].'", "'.$result['status'].'", "'.$result['kode_barang_target_sementara'].'", "'.$result['kode_proses_target_sementara'].'"]';
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