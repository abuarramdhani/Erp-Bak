<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Potongan extends CI_Controller
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
		$this->load->model('PayrollManagementNonStaff/M_potongan');

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

		$data['Title'] = 'Potongan';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Input Potongan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Potongan'] = $this->M_potongan->getPotongan();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/Potongan/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Potongan';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Input Potongan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/Potongan/V_create', $data);
		$this->load->view('V_Footer',$data);
	}

	public function Import()
	{
		$user = $this->session->user;
		$this->M_dataabsensi->updateProgress('Import Potongan',0,$user);
		$user_id = $this->session->userid;

		$data['Title'] = 'Potongan';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Input Potongan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* LINES DROPDOWN DATA */
		$data['Title'] = 'Import Data Potongan';

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/Potongan/V_import', $data);
		$this->load->view('V_Footer',$data);
	}

	public function doCreate(){
		$noind_kodesie = $this->input->post('cmbNoindHeader');
		$explode = explode(' - ', $noind_kodesie);
		$noind = $explode[0];
		$kodesie = $explode[1];

		$data = array(
			'noind' => $noind,
			'bulan_gaji' => $this->input->post('txtBulanGajiHeader'),
			'tahun_gaji' => $this->input->post('txtTahunGajiHeader'),
			'pot_lebih_bayar' => $this->input->post('txtPotLebihBayarHeader'),
			'pot_gp' => $this->input->post('txtPotGpHeader'),
			'pot_dl' => $this->input->post('txtPotDlHeader'),
			'pot_duka' => $this->input->post('txtPotDukaHeader'),
			'pot_koperasi' => $this->input->post('txtPotKoperasiHeader'),
			'pot_hutang_lain' => $this->input->post('txtPotHutangLainHeader'),
			'pot_tkp' => $this->input->post('txtPotThpHeader'),
		);
		$this->M_potongan->setPotongan($data);
		$header_id = $this->db->insert_id();
		//insert to sys.log_activity
		$aksi = 'Payroll Management NStaf';
		$detail = "Create Potongan noind=$noind";
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect(site_url('PayrollManagementNonStaff/ProsesGaji/Potongan'));
	}

	public function doImport(){
		$user = $this->session->user;
		$this->M_dataabsensi->updateProgress('Import Potongan',0,$user);

		$fileName = time().'-'.trim(addslashes($_FILES['file']['name']));
		$fileName = str_replace(' ', '_', $fileName);

		$config['upload_path'] = 'assets/upload/PayrollNonStaff/Potongan/';
		$config['file_name'] = $fileName;
		$config['allowed_types'] = '*';

		$this->load->library('upload', $config);

		$data['upload_data'] = '';
		if ($this->upload->do_upload('file')) {
			//insert to sys.log_activity
			$aksi = 'Payroll Management NStaf';
			$detail = "Import Potongan filename=$fileName";
			$this->log_activity->activity_log($aksi, $detail);
			//
			$uploadData = $this->upload->data();
			$inputFileName = 'assets/upload/PayrollNonStaff/Potongan/'.$uploadData['file_name'];
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
				$data = array(
					'bulan_gaji' => utf8_encode($db_record[$i]['BLN_GJ']),
					'tahun_gaji' => utf8_encode($db_record[$i]['THN_GJ']),
					'noind' => utf8_encode($db_record[$i]['NOIND']),
					'pot_lebih_bayar' => utf8_encode($db_record[$i]['POT']),
				);

				$data2 = array(
					'bulan_gaji' => utf8_encode($db_record[$i]['BLN_GJ']),
					'tahun_gaji' => utf8_encode($db_record[$i]['THN_GJ']),
					'noind' => utf8_encode($db_record[$i]['NOIND']),
					'kurang_bayar' => utf8_encode($db_record[$i]['TAMBAHAN']),
				);

				$this->M_potongan->setPotongan($data);
				$this->M_potongan->setTambahan($data2);

				$ImportProgress = ($i/($highestRow - 2))*100;
				$cek_data = $this->M_dataabsensi->getProgress($user,'Import Potongan');
				if ($cek_data == 0) {
					$this->M_dataabsensi->setProgress('Import Potongan',$ImportProgress,$user);
				}else{
					$this->M_dataabsensi->updateProgress('Import Potongan',$ImportProgress,$user);
				}
				session_write_close();
				flush();
			}
			unlink($inputFileName);
			//redirect(site_url('PayrollManagementNonStaff/ProsesGaji/DataAbsensi'));
		}
		else{
			echo $this->upload->display_errors();
		}
	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Potongan';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Input Potongan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['Potongan'] = $this->M_potongan->getPotongan($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/Potongan/V_update', $data);
		$this->load->view('V_Footer',$data);
	}

	public function doUpdate($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		$noind_kodesie = $this->input->post('cmbNoindHeader');
		$explode = explode(' - ', $noind_kodesie);
		$noind = $explode[0];
		$kodesie = $explode[1];

		$data = array(
			'noind' => $noind,
			'bulan_gaji' => $this->input->post('txtBulanGajiHeader',TRUE),
			'tahun_gaji' => $this->input->post('txtTahunGajiHeader',TRUE),
			'pot_lebih_bayar' => $this->input->post('txtPotLebihBayarHeader',TRUE),
			'pot_gp' => $this->input->post('txtPotGpHeader',TRUE),
			'pot_dl' => $this->input->post('txtPotDlHeader',TRUE),
			'pot_duka' => $this->input->post('txtPotDukaHeader',TRUE),
			'pot_koperasi' => $this->input->post('txtPotKoperasiHeader',TRUE),
			'pot_hutang_lain' => $this->input->post('txtPotHutangLainHeader',TRUE),
			'pot_tkp' => $this->input->post('txtPotThpHeader',TRUE),
			);
		$this->M_potongan->updatePotongan($data, $plaintext_string);
		//insert to sys.log_activity
		$aksi = 'Payroll Management NStaf';
		$detail = "Update Potongan id=$plaintext_string Noind=$noind";
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect(site_url('PayrollManagementNonStaff/ProsesGaji/Potongan'));
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Potongan';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Input Potongan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['Potongan'] = $this->M_potongan->getPotongan($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/Potongan/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_potongan->deletePotongan($plaintext_string);
		//insert to sys.log_activity
		$aksi = 'Payroll Management NStaf';
		$detail = "Delete Potongan id=$plaintext_string";
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect(site_url('PayrollManagementNonStaff/ProsesGaji/Potongan'));
    }

    public function showList(){
		$requestData= $_REQUEST;

		// print_r($requestData);exit;

		$columns = array(
			0 => 'noind',
			1 => 'noind',
			2 => 'noind',
			3 => 'bulan_gaji',
			4 => 'tahun_gaji',
			5 => 'pot_lebih_bayar',
			6 => 'pot_gp',
			7 => 'pot_dl',
			9 => 'pot_duka',
			9 => 'pot_koperasi',
			10 => 'pot_hutang_lain',
			11 => 'pot_tkp'
		);

		$data_table = $this->M_potongan->getPotonganDatatables();
		$totalData = $data_table->num_rows();
		$totalFiltered = $totalData;

		if(!empty($requestData['search']['value'])) {
			$data_table = $this->M_potongan->getPotonganSearch($requestData['search']['value']);
			$totalFiltered = $data_table->num_rows();

			$data_table = $this->M_potongan->getPotonganOrderLimit($requestData['search']['value'], $columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'], $requestData['length'], $requestData['start']);
		}
		else{
			$data_table = $this->M_potongan->getPotonganOrderLimit($searchValue = NULL, $columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'], $requestData['length'], $requestData['start']);
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
			$encrypted_string = $this->encrypt->encode($result['potongan_id']);
			$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);

			$bulan_gaji = date('F', mktime(0, 0, 0, $result['bulan_gaji'], 1));

			$count--;
			if ($count != 0) {
				$json .= '["'.$no.'", "<a style=\'margin-right:4px\' href=\''.base_url('PayrollManagementNonStaff/ProsesGaji/Potongan/read/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Read Data\'><span class=\'fa fa-list-alt fa-2x\'></span></a><a style=\'margin-right:4px\' href=\''.base_url('PayrollManagementNonStaff/ProsesGaji/Potongan/update/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Edit Data\'><span class=\'fa fa-pencil-square-o fa-2x\'></span></a><a href=\''.base_url('PayrollManagementNonStaff/ProsesGaji/Potongan/delete/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Hapus Data\' onclick=\"return confirm(\'Are you sure you want to delete this item?\');\"><span class=\'fa fa-trash fa-2x\'></span></a>", "'.$result['noind'].'", "'.$result['employee_name'].'", "'.$bulan_gaji.'", "'.$result['tahun_gaji'].'", "'.$result['pot_lebih_bayar'].'", "'.$result['pot_gp'].'", "'.$result['pot_dl'].'", "'.$result['pot_duka'].'", "'.$result['pot_koperasi'].'", "'.$result['pot_hutang_lain'].'", "'.$result['pot_tkp'].'"],';
			}
			else{
				$json .= '["'.$no.'", "<a style=\'margin-right:4px\' href=\''.base_url('PayrollManagementNonStaff/ProsesGaji/Potongan/read/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Read Data\'><span class=\'fa fa-list-alt fa-2x\'></span></a><a style=\'margin-right:4px\' href=\''.base_url('PayrollManagementNonStaff/ProsesGaji/Potongan/update/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Edit Data\'><span class=\'fa fa-pencil-square-o fa-2x\'></span></a><a href=\''.base_url('PayrollManagementNonStaff/ProsesGaji/Potongan/delete/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Hapus Data\' onclick=\"return confirm(\'Are you sure you want to delete this item?\');\"><span class=\'fa fa-trash fa-2x\'></span></a>", "'.$result['noind'].'", "'.$result['employee_name'].'", "'.$bulan_gaji.'", "'.$result['tahun_gaji'].'", "'.$result['pot_lebih_bayar'].'", "'.$result['pot_gp'].'", "'.$result['pot_dl'].'", "'.$result['pot_duka'].'", "'.$result['pot_koperasi'].'", "'.$result['pot_hutang_lain'].'", "'.$result['pot_tkp'].'"]';
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
		$detail = "Export Excel Potongan filter=$filter";
		$this->log_activity->activity_log($aksi, $detail);
		//
		$column_table = array('', 'noind', 'employee_name', 'bulan_gaji', 'tahun_gaji', 'pot_lebih_bayar', 'pot_gp', 'pot_dl',
			'pot_duka', 'pot_koperasi', 'pot_hutang_lain', 'pot_tkp');
		$column_view = array('No', 'Noind', 'Nama', 'Bulan Gaji', 'Tahun Gaji', 'Pot Lebih Bayar', 'Pot Gp', 'Pot Dl',
			'Pot Duka', 'Pot Koperasi', 'Pot Hutang Lain', 'Pot Thp');
		$data_table = $this->M_potongan->getPotonganSearch($filter)->result_array();

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

		header('Content-Disposition: attachment;filename="Potongan.xlsx"');
		$objWriter->save("php://output");
	}

}

/* End of file C_Potongan.php */
/* Location: ./application/controllers/PayrollManagementNonStaff/C_Potongan.php */
/* Generated automatically on 2017-03-20 13:40:14 */
