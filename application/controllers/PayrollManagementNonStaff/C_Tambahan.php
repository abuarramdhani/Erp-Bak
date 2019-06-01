<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Tambahan extends CI_Controller
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
		$this->load->model('PayrollManagementNonStaff/M_tambahan');

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

		$data['Title'] = 'Tambahan';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Input Tambahan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Tambahan'] = $this->M_tambahan->getTambahan();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/Tambahan/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Tambahan';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Input Tambahan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/Tambahan/V_create', $data);
		$this->load->view('V_Footer',$data);	
	}

	public function Import()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Tambahan';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Input Tambahan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* LINES DROPDOWN DATA */
		$data['Title'] = 'Import Data Tambahan';

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/Tambahan/V_import', $data);
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
			'kurang_bayar' => $this->input->post('txtKurangBayarHeader'),
			'lain_lain' => $this->input->post('txtLainLainHeader'),
		);
		$this->M_tambahan->setTambahan($data);
		$header_id = $this->db->insert_id();

		redirect(site_url('PayrollManagementNonStaff/ProsesGaji/Tambahan'));
	}

	public function doImport(){
		$this->session->set_userdata('ImportProgress', '0');

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
					'bulan_gaji' => utf8_encode($db_record['BLN_GJ']),
					'tahun_gaji' => utf8_encode($db_record['THN_GJ']),
					'noind' => utf8_encode($db_record['NOIND']),
					'kurang_bayar' => utf8_encode($db_record['TAMBAHAN']),
				);

				$data2 = array(
					'bulan_gaji' => utf8_encode($db_record['BLN_GJ']),
					'tahun_gaji' => utf8_encode($db_record['THN_GJ']),
					'noind' => utf8_encode($db_record['NOIND']),
					'pot_lebih_bayar' => utf8_encode($db_record['POT']),
				);

				$this->M_tambahan->setTambahan($data);
				$this->M_tambahan->setPotongan($data2);

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

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Tambahan';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Input Tambahan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['Tambahan'] = $this->M_tambahan->getTambahan($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/Tambahan/V_update', $data);
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
			'kurang_bayar' => $this->input->post('txtKurangBayarHeader',TRUE),
			'lain_lain' => $this->input->post('txtLainLainHeader',TRUE),
			);
		$this->M_tambahan->updateTambahan($data, $plaintext_string);

		redirect(site_url('PayrollManagementNonStaff/ProsesGaji/Tambahan'));
	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Tambahan';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Input Tambahan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['Tambahan'] = $this->M_tambahan->getTambahan($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/Tambahan/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_tambahan->deleteTambahan($plaintext_string);

		redirect(site_url('PayrollManagementNonStaff/ProsesGaji/Tambahan'));
    }

    public function showList(){
		$requestData= $_REQUEST;

		// print_r($requestData);exit;

		$columns = array(   
			0=> 'noind',
			1=> 'noind',
			2=> 'noind',
			3=> 'bulan_gaji',
			4=> 'tahun_gaji',
			5=> 'kurang_bayar',
			6=> 'lain_lain',

		);

		$data_table = $this->M_tambahan->getTambahanDatatables();
		$totalData = $data_table->num_rows();
		$totalFiltered = $totalData;

		if(!empty($requestData['search']['value'])) {
			$data_table = $this->M_tambahan->getTambahanSearch($requestData['search']['value']);
			$totalFiltered = $data_table->num_rows();

			$data_table = $this->M_tambahan->getTambahanOrderLimit($requestData['search']['value'], $columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'], $requestData['length'], $requestData['start']);
		}
		else{
			$data_table = $this->M_tambahan->getTambahanOrderLimit($searchValue = NULL, $columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'], $requestData['length'], $requestData['start']);
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
			$encrypted_string = $this->encrypt->encode($result['tambahan_id']);
			$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);

			$bulan_gaji = date('F', mktime(0, 0, 0, $result['bulan_gaji'], 1));

			$count--;
			if ($count != 0) {
				$json .= '["'.$no.'", "<a style=\'margin-right:4px\' href=\''.base_url('PayrollManagementNonStaff/ProsesGaji/Tambahan/read/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Read Data\'><span class=\'fa fa-list-alt fa-2x\'></span></a><a style=\'margin-right:4px\' href=\''.base_url('PayrollManagementNonStaff/ProsesGaji/Tambahan/update/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Edit Data\'><span class=\'fa fa-pencil-square-o fa-2x\'></span></a><a href=\''.base_url('PayrollManagementNonStaff/ProsesGaji/Tambahan/delete/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Hapus Data\' onclick=\"return confirm(\'Are you sure you want to delete this item?\');\"><span class=\'fa fa-trash fa-2x\'></span></a>", "'.$result['noind'].'", "'.$result['employee_name'].'", "'.$bulan_gaji.'", "'.$result['tahun_gaji'].'", "'.$result['kurang_bayar'].'", "'.$result['lain_lain'].'"],';
			}
			else{
				$json .= '["'.$no.'", "<a style=\'margin-right:4px\' href=\''.base_url('PayrollManagementNonStaff/ProsesGaji/Tambahan/read/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Read Data\'><span class=\'fa fa-list-alt fa-2x\'></span></a><a style=\'margin-right:4px\' href=\''.base_url('PayrollManagementNonStaff/ProsesGaji/Tambahan/update/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Edit Data\'><span class=\'fa fa-pencil-square-o fa-2x\'></span></a><a href=\''.base_url('PayrollManagementNonStaff/ProsesGaji/Tambahan/delete/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Hapus Data\' onclick=\"return confirm(\'Are you sure you want to delete this item?\');\"><span class=\'fa fa-trash fa-2x\'></span></a>", "'.$result['noind'].'", "'.$result['employee_name'].'", "'.$bulan_gaji.'", "'.$result['tahun_gaji'].'", "'.$result['kurang_bayar'].'", "'.$result['lain_lain'].'"]';
			}
			$no++;
		}
		$json .= ']}';

		echo $json;
	}

	public function downloadExcel()
    {
		$filter = $this->input->get('filter');
		$column_table = array('', 'noind', 'employee_name', 'bulan_gaji', 'tahun_gaji', 'kurang_bayar', 'lain_lain');
		$column_view = array('No', 'Noind', 'Nama', 'Bulan Gaji', 'Tahun Gaji', 'Kurang Bayar', 'Lain Lain');
		$data_table = $this->M_tambahan->getTambahanSearch($filter)->result_array();

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

		header('Content-Disposition: attachment;filename="Tambahan.xlsx"');
		$objWriter->save("php://output");
	}

}

/* End of file C_Tambahan.php */
/* Location: ./application/controllers/PayrollManagementNonStaff/C_Tambahan.php */
/* Generated automatically on 2017-03-20 13:43:45 */