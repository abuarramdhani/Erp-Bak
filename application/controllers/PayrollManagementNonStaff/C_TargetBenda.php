<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_TargetBenda extends CI_Controller
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
		$this->load->model('PayrollManagementNonStaff/M_targetbenda');

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

		$data['Title'] = 'Target Benda';
		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = 'Data Target';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		// $data['TargetBenda'] = $this->M_targetbenda->getTargetBenda();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/TargetBenda/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Target Benda';
		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = 'Data Target';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/TargetBenda/V_create', $data);
		$this->load->view('V_Footer',$data);
	}

	public function doCreate(){
		$data = array(
			'kodesie' => $this->input->post('cmbKodesieHeader'),
			'kode_barang' => $this->input->post('txtKodeBarangHeader'),
			'nama_barang' => $this->input->post('txtNamaBarangHeader'),
			'kode_proses' => $this->input->post('txtKodeProsesHeader'),
			'nama_proses' => $this->input->post('txtNamaProsesHeader'),
			'jumlah_operator' => $this->input->post('txtJumlahOperatorHeader'),
			'target_utama_senin_kamis' => $this->input->post('txtTargetUtamaSeninKamis'),
			'target_utama_senin_kamis_4' => $this->input->post('txtTargetUtamaSeninKamis4'),
			'target_sementara_senin_kamis' => $this->input->post('txtTargetSementaraSeninKamis'),
			'target_utama_jumat_sabtu' => $this->input->post('txtTargetUtamaJumatSabtu'),
			'target_utama_jumat_sabtu_4' => $this->input->post('txtTargetUtamaJumatSabtu4'),
			'target_sementara_jumat_sabtu' => $this->input->post('txtTargetSementaraJumatSabtu'),
			'waktu_setting' => $this->input->post('txtWaktuSettingHeader'),
			'tgl_berlaku' => $this->input->post('txtTglBerlakuHeader'),
			'tgl_input' => 'NOW()',
		);
		$this->M_targetbenda->setTargetBenda($data);
		$header_id = $this->db->insert_id();
		//insert to sys.log_activity
		$aksi = 'Payroll Management NStaf';
		$detail = "Create Data Target benda kode_barang=".$this->input->post('txtKodeBarangHeader');
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect(site_url('PayrollManagementNonStaff/MasterData/TargetBenda'));
	}

	/* UPDATE DATA */
	public function update($id)
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
		$data['TargetBenda'] = $this->M_targetbenda->getTargetBenda($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/TargetBenda/V_update', $data);
		$this->load->view('V_Footer',$data);
	}

	public function doUpdate($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		$data = array(
			'kodesie' => $this->input->post('cmbKodesieHeader',TRUE),
			'kode_barang' => $this->input->post('txtKodeBarangHeader',TRUE),
			'nama_barang' => $this->input->post('txtNamaBarangHeader',TRUE),
			'kode_proses' => $this->input->post('txtKodeProsesHeader',TRUE),
			'nama_proses' => $this->input->post('txtNamaProsesHeader',TRUE),
			'jumlah_operator' => $this->input->post('txtJumlahOperatorHeader',TRUE),
			'target_utama_senin_kamis' => $this->input->post('txtTargetUtamaSeninKamis',TRUE),
			'target_utama_senin_kamis_4' => $this->input->post('txtTargetUtamaSeninKamis4',TRUE),
			'target_sementara_senin_kamis' => $this->input->post('txtTargetSementaraSeninKamis',TRUE),
			'target_utama_jumat_sabtu' => $this->input->post('txtTargetUtamaJumatSabtu',TRUE),
			'target_utama_jumat_sabtu_4' => $this->input->post('txtTargetUtamaJumatSabtu4',TRUE),
			'target_sementara_jumat_sabtu' => $this->input->post('txtTargetSementaraJumatSabtu',TRUE),
			'waktu_setting' => $this->input->post('txtWaktuSettingHeader',TRUE),
			'tgl_berlaku' => $this->input->post('txtTglBerlakuHeader',TRUE),
			);
		$this->M_targetbenda->updateTargetBenda($data, $plaintext_string);
		//insert to sys.log_activity
		$aksi = 'Payroll Management NStaf';
		$detail = "Update Data Target benda id=$plaintext_string";
		$this->log_activity->activity_log($aksi, $detail);
		//
		redirect(site_url('PayrollManagementNonStaff/MasterData/TargetBenda'));

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
		$data['TargetBenda'] = $this->M_targetbenda->getTargetBenda($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/TargetBenda/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_targetbenda->deleteTargetBenda($plaintext_string);
		//insert to sys.log_activity
		$aksi = 'Payroll Management NStaf';
		$detail = "Delete Data Target benda id=$plaintext_string";
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect(site_url('PayrollManagementNonStaff/MasterData/TargetBenda'));
    }

    public function doClearData()
    {
		$this->M_targetbenda->clearData();

		redirect(site_url('PayrollManagementNonStaff/MasterData/TargetBenda'));
	}

    public function import_data(){
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Import Data';
		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = 'Data Target';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/TargetBenda/V_import', $data);
		$this->load->view('V_Footer',$data);
	}

	public function doImport(){

		$fileName = time().'-'.trim(addslashes($_FILES['file']['name']));
		$fileName = str_replace(' ', '_', $fileName);

		$config['upload_path'] = 'assets/upload/';
		$config['file_name'] = $fileName;
		$config['allowed_types'] = '*';

		$this->load->library('upload', $config);

		$data['upload_data'] = '';
		if ($this->upload->do_upload('file')) {
			//insert to sys.log_activity
			$aksi = 'Payroll Management NStaf';
			$detail = "Import Data Target benda filename=$fileName";
			$this->log_activity->activity_log($aksi, $detail);
			//
			$uploadData = $this->upload->data();
			$inputFileName = 'assets/upload/'.$uploadData['file_name'];
			// $inputFileName = 'assets/upload/1490405144-PROD0117_(copy).dbf';
			$db = dbase_open($inputFileName, 0);
			// print_r(dbase_get_header_info($db));
			$db_rows = dbase_numrecords($db);
			for ($i=1; $i <= $db_rows; $i++) {
				$db_record = dbase_get_record_with_names($db, $i);

				$data = array(
					'kodesie' => utf8_encode($db_record['KODESIE']),
					'kode_barang' => utf8_encode($db_record['KODEBRG']),
					'nama_barang' => utf8_encode($db_record['NAMABRG']),
					'kode_proses' => utf8_encode($db_record['KODEPRO']),
					'nama_proses' => utf8_encode($db_record['PROSES']),
					'jumlah_operator' => utf8_encode($db_record['JMLOPR']),
					'target_utama_senin_kamis' => utf8_encode($db_record['PSK54']),
					'target_utama_senin_kamis_4' => utf8_encode($db_record['PSK44']),
					'target_utama_jumat_sabtu' => utf8_encode($db_record['PJS54']),
					'target_utama_jumat_sabtu_4' => utf8_encode($db_record['PJS44']),
					'waktu_setting' => utf8_encode($db_record['WAKTU_SETT']),
					'tgl_berlaku' => utf8_encode($db_record['TG_LAKU']),
					'tgl_input' => utf8_encode($db_record['TG_INPUT'])
				);
				$this->M_targetbenda->setTargetBenda($data);
				//insert to sys.log_activity
				$aksi = 'Payroll Management NStaf';
				$detail = "Set Data Target benda kode_barang=".utf8_encode($db_record['KODEBRG']);
				$this->log_activity->activity_log($aksi, $detail);
				//
			}
			// exit;
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
			0 => 'kodesie',
			1 => 'kodesie',
			2 => 'kodesie',
			3 => 'kode_barang',
			4 => 'nama_barang',
			5 => 'kode_proses',
			6 => 'nama_proses',
			7 => 'jumlah_operator',
			8 => 'target_utama',
			9 => 'target_sementara',
			10 => 'waktu_setting',
			11 => 'tgl_berlaku',
			12 => 'tgl_input',
			13 => 'learning_periode',

		);

		$data_table = $this->M_targetbenda->getTargetBendaDatatables();
		$totalData = $data_table->num_rows();
		$totalFiltered = $totalData;

		if(!empty($requestData['search']['value'])) {
			$data_table = $this->M_targetbenda->getTargetBendaSearch($requestData['search']['value']);
			$totalFiltered = $data_table->num_rows();

			$data_table = $this->M_targetbenda->getTargetBendaOrderLimit($requestData['search']['value'], $columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'], $requestData['length'], $requestData['start']);
		}
		else{
			$data_table = $this->M_targetbenda->getTargetBendaOrderLimit($searchValue = NULL, $columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'], $requestData['length'], $requestData['start']);
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
			$encrypted_string = $this->encrypt->encode($result['target_benda_id']);
			$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);

			$count--;
			if ($count != 0) {
				$json .= '["'.$no.'", "<a style=\'margin-right:4px\' href=\''.base_url('PayrollManagementNonStaff/MasterData/TargetBenda/read/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Read Data\'><span class=\'fa fa-list-alt fa-2x\'></span></a><a style=\'margin-right:4px\' href=\''.base_url('PayrollManagementNonStaff/MasterData/TargetBenda/update/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Edit Data\'><span class=\'fa fa-pencil-square-o fa-2x\'></span></a><a href=\''.base_url('PayrollManagementNonStaff/MasterData/TargetBenda/delete/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Hapus Data\' onclick=\'return confirm(\'Are you sure you want to delete this item?\');\'><span class=\'fa fa-trash fa-2x\'></span></a>", "'.$result['kodesie'].'", "'.$result['unit_name'].'", "'.$result['kode_barang'].'", "'.$result['nama_barang'].'", "'.$result['kode_proses'].'", "'.$result['nama_proses'].'", "'.$result['jumlah_operator'].'", "'.$result['target_utama_senin_kamis'].'", "'.$result['target_utama_senin_kamis_4'].'", "'.$result['target_sementara_senin_kamis'].'", "'.$result['target_utama_jumat_sabtu'].'", "'.$result['target_utama_jumat_sabtu_4'].'", "'.$result['target_sementara_jumat_sabtu'].'", "'.$result['waktu_setting'].'", "'.$result['tgl_berlaku'].'", "'.$result['tgl_input'].'", "'.$result['learning_periode'].'"],';
			}
			else{
				$json .= '["'.$no.'", "<a style=\'margin-right:4px\' href=\''.base_url('PayrollManagementNonStaff/MasterData/TargetBenda/read/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Read Data\'><span class=\'fa fa-list-alt fa-2x\'></span></a><a style=\'margin-right:4px\' href=\''.base_url('PayrollManagementNonStaff/MasterData/TargetBenda/update/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Edit Data\'><span class=\'fa fa-pencil-square-o fa-2x\'></span></a><a href=\''.base_url('PayrollManagementNonStaff/MasterData/TargetBenda/delete/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Hapus Data\' onclick=\'return confirm(\'Are you sure you want to delete this item?\');\'><span class=\'fa fa-trash fa-2x\'></span></a>", "'.$result['kodesie'].'", "'.$result['unit_name'].'", "'.$result['kode_barang'].'", "'.$result['nama_barang'].'", "'.$result['kode_proses'].'", "'.$result['nama_proses'].'", "'.$result['jumlah_operator'].'", "'.$result['target_utama_senin_kamis'].'", "'.$result['target_utama_senin_kamis_4'].'", "'.$result['target_sementara_senin_kamis'].'", "'.$result['target_utama_jumat_sabtu'].'", "'.$result['target_utama_jumat_sabtu_4'].'", "'.$result['target_sementara_jumat_sabtu'].'", "'.$result['waktu_setting'].'", "'.$result['tgl_berlaku'].'", "'.$result['tgl_input'].'", "'.$result['learning_periode'].'"]';
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
		$detail = "Export Excel Data Target benda filter=$filter";
		$this->log_activity->activity_log($aksi, $detail);
		//
		$column_table = array('', 'kodesie', 'unit_name', 'kode_barang', 'nama_barang', 'kode_proses', 'nama_proses',
			'jumlah_operator', 'target_utama_senin_kamis', 'target_utama_senin_kamis_4', 'target_sementara_senin_kamis',
			'target_utama_jumat_sabtu', 'target_utama_jumat_sabtu_4', 'target_sementara_jumat_sabtu', 'waktu_setting',
			'tgl_berlaku', 'tgl_input');
		$column_view = array('No','Kodesie','Nama Unit','Kode Barang','Nama Barang','Kode Proses','Nama Proses','Jumlah Operator',
			'Target Utama Senin Kamis','Target Utama Senin Kamis 4','Target Sementara Senin Kamis','Target Utama Jumat Sabtu',
			'Target Utama Jumat Sabtu 4','Target Sementara Jumat Sabtu','Waktu Setting','Tgl Berlaku','Tgl Input');
		$data_table = $this->M_targetbenda->getTargetBendaSearch($filter)->result_array();

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

		header('Content-Disposition: attachment;filename="TargetBenda.xlsx"');
		$objWriter->save("php://output");
	}

}

/* End of file C_TargetBenda.php */
/* Location: ./application/controllers/PayrollManagement/MainMenu/C_TargetBenda.php */
/* Generated automatically on 2017-03-23 13:51:52 */
