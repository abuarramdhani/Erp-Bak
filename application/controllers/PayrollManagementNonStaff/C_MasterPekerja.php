<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MasterPekerja extends CI_Controller
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

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PayrollManagementNonStaff/M_masterpekerja');

		$this->checkSession();
	}

	/* CHECK SESSION */
	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	/* LIST DATA */
	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Master Pekerja';
		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = 'Master Pekerja';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		// $data['TargetBenda'] = $this->M_masterpekerja->getMasterPekerja();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/MasterPekerja/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Target Benda';
		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = 'Data Target';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['TargetBenda'] = $this->M_masterpekerja->getMasterPekerja($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/MasterPekerja/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_masterpekerja->deleteTargetBenda($plaintext_string);
		//insert to sys.log_activity
		$aksi = 'Payroll Management NStaf';
		$detail = "Delete Master Data Pekerja id=$plaintext_string";
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect(site_url('PayrollManagementNonStaff/MasterData/TargetBenda'));
    }

    public function import_data(){
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Import Data';
		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = 'Master Pekerja';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/MasterPekerja/V_import', $data);
		$this->load->view('V_Footer',$data);
	}

	public function doImport(){

		$fileName = time().'-'.trim(addslashes($_FILES['file']['name']));
		$fileName = str_replace(' ', '_', $fileName);

		$config['upload_path'] = 'assets/upload/PayrollNonstaff/MasterPekerja/';
		$config['file_name'] = $fileName;
		$config['allowed_types'] = '*';

		$this->load->library('upload', $config);

		$data['upload_data'] = '';
		if ($this->upload->do_upload('file')) {
			//insert to sys.log_activity
			$aksi = 'Payroll Management NStaf';
			$detail = "Import Master Data Pekerja filename=$fileName";
			$this->log_activity->activity_log($aksi, $detail);
			//
			$uploadData = $this->upload->data();
			$inputFileName = 'assets/upload/PayrollNonstaff/MasterPekerja/'.$uploadData['file_name'];
			$inputFileType = $uploadData['file_type'];
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

			for ($i=1; $i <= $highestRow - 2; $i++) {

				$dataCekUpdate = array(
					'rtrim(employee_code)' => rtrim(utf8_encode($db_record[$i]['NOIND'])),
				);

				$data = array(
					'employee_code' => utf8_encode($db_record[$i]['NOIND']),
					'employee_name' => utf8_encode($db_record[$i]['NAMA']),
					'sex' => utf8_encode($db_record[$i]['JENKEL']),
					'address' => utf8_encode($db_record[$i]['ALAMAT']),
					'telephone' => '',
					'handphone' => utf8_encode($db_record[$i]['NO_HP']),
					'worker_recruited_date' => utf8_encode($db_record[$i]['DIANGKAT']),
					'worker_start_working_date' => utf8_encode($db_record[$i]['MASUK_KERJ']),
					'section_code' => utf8_encode($db_record[$i]['KODESIE']),
					'resign' => utf8_encode($db_record[$i]['KELUAR']),
					'resign_date' => utf8_encode($db_record[$i]['TGL_KELUAR']),
					'new_employee_code' => utf8_encode($db_record[$i]['NOIND_BARU']),
					'worker_status_code' => utf8_encode($db_record[$i]['KD_STATUS_']),
					'location_code' => utf8_encode($db_record[$i]['ID_LOK_KER']),
					'worker_code' => utf8_encode($db_record[$i]['NIK']),

				);

				$cekUpdate = $this->M_masterpekerja->cekUpdate($dataCekUpdate);
				if ($cekUpdate->num_rows() != 0) {
					foreach ($cekUpdate->result() as $dataUpdateOld) {
						$employee_id = $dataUpdateOld->employee_id;
					}
					$this->M_masterpekerja->updateMasterPekerja($data, $employee_id);
				}
				else{
					$this->M_masterpekerja->setMasterPekerja($data);
				}


				// print_r($data);

			}
			unlink($inputFileName);
			//redirect(site_url('PayrollManagementNonStaff/ProsesGaji/DataAbsensi'));
		}
		else{
			echo $this->upload->display_errors();
		}
	}

	public function showList(){
		$requestData= $_REQUEST;

		// print_r($requestData);exit;

		$columns = array(
			0 => 'employee_code',
			1 => 'employee_code',
			2 => 'employee_code',
			3 => 'employee_name',
			4 => 'sex',
			5 => 'address',
			6 => 'telephone',
			7 => 'handphone',
			8 => 'worker_recruited_date',
			9 => 'worker_start_working_date',
			10 => 'section_code',
			11 => 'resign',
			12 => 'resign_date',
			13 => 'new_employee_code',
			14 => 'worker_status_code',
			15 => 'location_code',
			16 => 'worker_code',
			17 => 'outstation_position',
		);

		$data_table = $this->M_masterpekerja->getMasterPekerjaDatatables();
		$totalData = $data_table->num_rows();
		$totalFiltered = $totalData;

		if(!empty($requestData['search']['value'])) {
			$data_table = $this->M_masterpekerja->getMasterPekerjaSearch($requestData['search']['value']);
			$totalFiltered = $data_table->num_rows();

			$data_table = $this->M_masterpekerja->getMasterPekerjaOrderLimit($requestData['search']['value'], $columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'], $requestData['length'], $requestData['start']);
		}
		else{
			$data_table = $this->M_masterpekerja->getMasterPekerjaOrderLimit($searchValue = NULL, $columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'], $requestData['length'], $requestData['start']);
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
				$json .= '["'.$no.'", "'.$result['employee_code'].'", "'.$result['employee_name'].'", "'.$result['sex'].'", "'.$result['address'].'", "'.$result['telephone'].'", "'.$result['handphone'].'", "'.$result['worker_recruited_date'].'", "'.$result['worker_start_working_date'].'", "'.$result['section_code'].'", "'.$result['section_name'].'", "'.$result['resign'].'", "'.$result['resign_date'].'", "'.$result['new_employee_code'].'", "'.$result['worker_status_code'].'", "'.$result['location_code'].'", "'.$result['worker_code'].'"],';
			}
			else{
				$json .= '["'.$no.'", "'.$result['employee_code'].'", "'.$result['employee_name'].'", "'.$result['sex'].'", "'.$result['address'].'", "'.$result['telephone'].'", "'.$result['handphone'].'", "'.$result['worker_recruited_date'].'", "'.$result['worker_start_working_date'].'", "'.$result['section_code'].'", "'.$result['section_name'].'", "'.$result['resign'].'", "'.$result['resign_date'].'", "'.$result['new_employee_code'].'", "'.$result['worker_status_code'].'", "'.$result['location_code'].'", "'.$result['worker_code'].'"]';
			}
			$no++;
		}
		$json .= ']}';

		echo $json;
	}

	public function downloadExcel()
    {
		$filter = $this->input->get('filter');
		//insert to sys.log_activity
		$aksi = 'Payroll Management NStaf';
		$detail = "Export Excel Master Data Pekerja filter=$filter";
		$this->log_activity->activity_log($aksi, $detail);
		//
		$column_table = array('', 'employee_code', 'employee_name', 'sex', 'address', 'telephone', 'handphone', 'worker_recruited_date',
			'worker_start_working_date', 'section_code', 'section_name', 'resign', 'resign_date', 'new_employee_code',
			'worker_status_code', 'location_code', 'worker_code');
		$column_view = array('No', 'Employee Code', 'Employee Name', 'Sex', 'Address', 'Telephone', 'Handphone', 'Recruited Date',
			'Start Working', 'Section Code', 'Section Name', 'Resign?', 'Resign Date', 'New Employee Code', 'Worker Status',
			'Location Code', 'Worker Code');
		$data_table = $this->M_masterpekerja->getMasterPekerjaSearch($filter)->result_array();

		$this->load->library("Excel");
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$column = 0;

		foreach($column_view as $cv){
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $cv);
			$column++;
		}

		$excel_row = 2;
		foreach($data_table as $dt){
			$excel_col = 0;
			foreach($column_table as $ct){
				if($ct == ''){
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($excel_col, $excel_row, $excel_row-1);
				}else{
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($excel_col, $excel_row, $dt[$ct]);
				}
				$excel_col++;
			}
			$excel_row++;
		}

		$objPHPExcel->getActiveSheet()->setTitle('Quick ERP');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

		header('Content-Disposition: attachment;filename="MasterPekerja.xlsx"');
		$objWriter->save("php://output");
	}

}

/* End of file C_TargetBenda.php */
/* Location: ./application/controllers/PayrollManagement/MainMenu/C_TargetBenda.php */
/* Generated automatically on 2017-03-23 13:51:52 */
