<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Kondite extends CI_Controller
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
		$this->load->model('PayrollManagementNonStaff/M_kondite');

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

		$data['Title'] = 'Kondite';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Insentif Kondite';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/Kondite/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create($term)
	{
		$user_id = $this->session->userid;

		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Insentif Kondite';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */
		//$data['EmployeeAll'] = $this->M_kondite->getEmployeeAll();
		//$data['Section'] = $this->M_kondite->getSection();

		/* LINES DROPDOWN DATA */


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		if ($term == 'seksi') {
			$data['Title'] = 'Input Insentif Kondite Per Seksi';
			$this->load->view('PayrollManagementNonStaff/Kondite/V_create_per_seksi', $data);
		}
		elseif ($term == 'pekerja') {
			$data['Title'] = 'Input Insentif Kondite Per Pekerja';
			$this->load->view('PayrollManagementNonStaff/Kondite/V_create', $data);
		}else{
			redirect(site_url('PayrollManagementNonStaff/ProsesGaji/Kondite'));
		}

		$this->load->view('V_Footer',$data);
	}

	public function Import()
	{
		$user = $this->session->user;
		$this->M_dataabsensi->updateProgress('Import Kondite',0,$user);
		$user_id = $this->session->userid;

		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Insentif Kondite';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Title'] = 'Import Data Insentif Kondite';

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/Kondite/V_import', $data);
		$this->load->view('V_Footer',$data);
	}

	public function doCreate($term){
		if ($term == 'seksi') {
			$tanggal = $this->input->post('txtTanggalHeader');
			$kodesie = $this->input->post('cmbKodesie');
			$kodesie = substr($kodesie, 0, 6);
			$noind = $this->input->post('txtNoindHeader');

			for ($i=0; $i < count($noind); $i++) {

				$data = array(
					'noind' => $noind[$i],
					'kodesie' => $kodesie,
					'tanggal' => $tanggal,
					'mk' => $this->input->post('txtMKHeader['.$i.']'),
					'bki' => $this->input->post('txtBKIHeader['.$i.']'),
					'bkp' => $this->input->post('txtBKPHeader['.$i.']'),
					'tkp' => $this->input->post('txtTKPHeader['.$i.']'),
					'kb' => $this->input->post('txtKBHeader['.$i.']'),
					'kk' => $this->input->post('txtKKHeader['.$i.']'),
					'ks' => $this->input->post('txtKSHeader['.$i.']'),
					'creation_date' => 'NOW()',
					'created_by' => $this->session->userid,
				);
				$this->M_kondite->setKondite($data);

			}
			//insert to sys.log_activity
			$aksi = 'Payroll Management NStaf';
			$detail = "Create kondite noind=$noind";
			$this->log_activity->activity_log($aksi, $detail);
			//

			redirect(site_url('PayrollManagementNonStaff/ProsesGaji/Kondite'));
		}
		elseif ($term == 'pekerja') {
			$tanggal = $this->input->post('txtTanggalHeader');
			$noind_kodesie = $this->input->post('cmbNoindHeader');
			$explode = explode(' - ', $noind_kodesie);
			$noind = $explode[0];
			$kodesie = $explode[1];
			$kodesie = substr($kodesie, 0, 6);

			for ($i=0; $i < count($tanggal); $i++) {

				$data = array(
					'noind' => $noind,
					'kodesie' => $kodesie,
					'tanggal' => $tanggal[$i],
					'mk' => $this->input->post('txtMKHeader['.$i.']'),
					'bki' => $this->input->post('txtBKIHeader['.$i.']'),
					'bkp' => $this->input->post('txtBKPHeader['.$i.']'),
					'tkp' => $this->input->post('txtTKPHeader['.$i.']'),
					'kb' => $this->input->post('txtKBHeader['.$i.']'),
					'kk' => $this->input->post('txtKKHeader['.$i.']'),
					'ks' => $this->input->post('txtKSHeader['.$i.']'),
					'creation_date' => 'NOW()',
					'created_by' => $this->session->userid,
				);

			}
			$this->M_kondite->setKondite($data);
			//insert to sys.log_activity
			$aksi = 'Payroll Management NStaf';
			$detail = "Create kondite noind=$noind";
			$this->log_activity->activity_log($aksi, $detail);
			//

			redirect(site_url('PayrollManagementNonStaff/ProsesGaji/Kondite'));
		}
		else{
			redirect(site_url('PayrollManagementNonStaff/ProsesGaji/Kondite'));
		}

	}

	public function doImport(){
		$user = $this->session->user;
		$this->M_dataabsensi->updateProgress('Import Kondite',0,$user);

		$fileName = time().'-'.trim(addslashes($_FILES['file']['name']));
		$fileName = str_replace(' ', '_', $fileName);

		$config['upload_path'] = 'assets/upload/PayrollNonStaff/InsKondite/';
		$config['file_name'] = $fileName;
		$config['allowed_types'] = '*';

		$this->load->library('upload', $config);

		$data['upload_data'] = '';
		if ($this->upload->do_upload('file')) {
			//insert to sys.log_activity
			$aksi = 'Payroll Management NStaf';
			$detail = "Import kondite filename=$fileName";
			$this->log_activity->activity_log($aksi, $detail);
			//
			$uploadData = $this->upload->data();
			$inputFileName = 'assets/upload/PayrollNonStaff/InsKondite/'.$uploadData['file_name'];
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
					'tanggal' => utf8_encode($db_record[$i]['TGL']),
					'noind' => utf8_encode($db_record[$i]['NOIND']),
					'mk' => utf8_encode($db_record[$i]['KONDITE1']),
					'bki' => utf8_encode($db_record[$i]['KONDITE2']),
					'bkp' => utf8_encode($db_record[$i]['KONDITE3']),
					'tkp' => utf8_encode($db_record[$i]['KONDITE4']),
					'kb' => utf8_encode($db_record[$i]['KONDITE5']),
					'kk' => utf8_encode($db_record[$i]['KONDITE6']),
					'ks' => utf8_encode($db_record[$i]['KONDITE7']),
					'kodesie' => utf8_encode($db_record[$i]['KODESIE']),
					'creation_date' => 'NOW()',
					'created_by' => $this->session->userid,
				);

				$this->M_kondite->setKondite($data);

				$ImportProgress = ($i/($highestRow - 2))*100;
				$ImportProgress = round($ImportProgress);

				$cek_data = $this->M_dataabsensi->getProgress($user,'Import Kondite');
				if ($cek_data == 0) {
					$this->M_dataabsensi->setProgress('Import Kondite',$ImportProgress,$user);
				}else{
					$this->M_dataabsensi->updateProgress('Import Kondite',$ImportProgress,$user);
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

		$data['Title'] = 'Kondite';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Insentif Kondite';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['Kondite'] = $this->M_kondite->getKondite($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */
		$data['EmployeeAll'] = $this->M_kondite->getEmployeeAll();
		$data['Section'] = $this->M_kondite->getSection();

		/* LINES DROPDOWN DATA */


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/Kondite/V_update', $data);
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
			'kodesie' => $this->input->post('cmbKodesieHeader',TRUE),
			'tanggal' => $this->input->post('txtTanggalHeader',TRUE),
			'mk' => $this->input->post('txtMKHeader',TRUE),
			'bki' => $this->input->post('txtBKIHeader',TRUE),
			'bkp' => $this->input->post('txtBKPHeader',TRUE),
			'tkp' => $this->input->post('txtTKPHeader',TRUE),
			'kb' => $this->input->post('txtKBHeader',TRUE),
			'kk' => $this->input->post('txtKKHeader',TRUE),
			'ks' => $this->input->post('txtKSHeader',TRUE)
			);
		$this->M_kondite->updateKondite($data, $plaintext_string);
		//insert to sys.log_activity
		$aksi = 'Payroll Management NStaf';
		$detail = "Update kondite noind=$noind";
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect(site_url('PayrollManagementNonStaff/ProsesGaji/Kondite'));

	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Kondite';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Insentif Kondite';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['Kondite'] = $this->M_kondite->getKondite($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/Kondite/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

	/* DELETE DATA */
	public function delete($id)
	{
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_kondite->deleteKondite($plaintext_string);
		//insert to sys.log_activity
		$aksi = 'Payroll Management NStaf';
		$detail = "Delete kondite Id=$plaintext_string";
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect(site_url('PayrollManagementNonStaff/ProsesGaji/Kondite'));
	}


	public function clear_data(){
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Clear Data';
		$data['Menu'] = 'Proses Gaji';
		$data['SubMenuOne'] = 'Insentif Kondite';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/Kondite/V_clear', $data);
		$this->load->view('V_Footer',$data);
	}

	public function doClearData(){
		$bln_gaji = $this->input->post('slcBulan');
		$thn_gaji = $this->input->post('txtTahun');

		$this->M_kondite->clearKondite($bln_gaji,$thn_gaji);
		//insert to sys.log_activity
		$aksi = 'Payroll Management NStaf';
		$detail = "Clear Data kondite periode=$thn_gaji $bln_gaji";
		$this->log_activity->activity_log($aksi, $detail);
		//
		redirect(site_url('PayrollManagementNonStaff/ProsesGaji/Kondite'));
	}

	public function getPekerja(){
		$kodesie = $this->input->post('kodesie');
		$date = $this->input->post('date');
		echo $kodesie."-".$date;
		$data = $this->M_kondite->getPekerja($kodesie,$date);

		if (count($data) > 0) {
			foreach ($data as $data) {
				echo '
					<tr>
						   <td width="30%">
						   		'.$data['employee_code'].' - '.$data['employee_name'].'
								  <input type="hidden" class="form-control" name="txtNoindHeader[]" value="'.$data['employee_code'].'" required>
						   </td>
						   <td width="7%"><input type="text" class="form-control text-center" name="txtMKHeader[]" placeholder="MK" maxlength="1" required></td>
						   <td width="7%"><input type="text" class="form-control text-center" name="txtBKIHeader[]" placeholder="BKI" maxlength="1" required></td>
						   <td width="7%"><input type="text" class="form-control text-center" name="txtBKPHeader[]" placeholder="BKP" maxlength="1" required></td>
						   <td width="7%"><input type="text" class="form-control text-center" name="txtTKPHeader[]" placeholder="TKP" maxlength="1" required></td>
						   <td width="7%"><input type="text" class="form-control text-center" name="txtKBHeader[]" placeholder="KB" maxlength="1" required></td>
						   <td width="7%"><input type="text" class="form-control text-center" name="txtKKHeader[]" placeholder="KK" maxlength="1" required></td>
						   <td width="7%"><input type="text" class="form-control text-center" name="txtKSHeader[]" placeholder="KS" maxlength="1" required></td>
					</tr>
				';
			}
		}
		else{
			echo '
				<tr>
					<td colspan="8" class="text-center"><h4>No Data Found, Please select other Section Code</h4></td>
				</tr>
			';
		}

	}

	public function getTglShift(){
		$noind = $this->input->post('noind');
		$noind = substr($noind, 0, 5);
		$tgl1 = $this->input->post('tgl1');
		$tgl2 = $this->input->post('tgl2');

		$data = $this->M_kondite->getTglShift($noind,$tgl1,$tgl2);

		if (count($data) > 0) {
			foreach ($data as $data) {
				echo '
					<tr>
						   <td width="30%" class="text-center">
						   		'.$data['tanggal'].'
								  <input type="hidden" class="form-control" name="txtTanggalHeader[]" value="'.$data['tanggal'].'" required>
						   </td>
						   <td width="7%"><input type="text" class="form-control text-center" name="txtMKHeader[]" placeholder="MK" maxlength="1" required></td>
						   <td width="7%"><input type="text" class="form-control text-center" name="txtBKIHeader[]" placeholder="BKI" maxlength="1" required></td>
						   <td width="7%"><input type="text" class="form-control text-center" name="txtBKPHeader[]" placeholder="BKP" maxlength="1" required></td>
						   <td width="7%"><input type="text" class="form-control text-center" name="txtTKPHeader[]" placeholder="TKP" maxlength="1" required></td>
						   <td width="7%"><input type="text" class="form-control text-center" name="txtKBHeader[]" placeholder="KB" maxlength="1" required></td>
						   <td width="7%"><input type="text" class="form-control text-center" name="txtKKHeader[]" placeholder="KK" maxlength="1" required></td>
						   <td width="7%"><input type="text" class="form-control text-center" name="txtKSHeader[]" placeholder="KS" maxlength="1" required></td>
					</tr>
				';
			}
		}
		else{
			echo '
				<tr>
					<td colspan="8" class="text-center"><h4>No Data Found, Please select other Section Code</h4></td>
				</tr>
			';
		}

	}

	public function showList(){
		$requestData= $_REQUEST;

		// print_r($requestData);exit;

		$columns = array(
			0 => 'noind',
			1 => 'noind',
			2 => 'noind',
			3 => 'employee_name',
			4 => 'kodesie',
			5 => 'unit_name',
			6 => 'tanggal',
			7 => 'mk',
			8 => 'bki',
			9 => 'bkp',
			10 => 'tkp',
			11 => 'kb',
			12 => 'kk',
			13 => 'ks'
		);

		$data_table = $this->M_kondite->getKonditeDatatables();
		$totalData = $data_table->num_rows();
		$totalFiltered = $totalData;

		if(!empty($requestData['search']['value'])) {
			$data_table = $this->M_kondite->getKonditeSearch($requestData['search']['value']);
			$totalFiltered = $data_table->num_rows();

			$data_table = $this->M_kondite->getKonditeOrderLimit($requestData['search']['value'], $columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'], $requestData['length'], $requestData['start']);
		}
		else{
			$data_table = $this->M_kondite->getKonditeOrderLimit($searchValue = NULL, $columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'], $requestData['length'], $requestData['start']);
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
			$encrypted_string = $this->encrypt->encode($result['kondite_id']);
			$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
			$count--;
			if ($count != 0) {
				$json .= '["'.$no.'","<a style=\'margin-right:4px\' href=\''.base_url('PayrollManagementNonStaff/ProsesGaji/Kondite/read/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Read Data\'><span class=\'fa fa-list-alt fa-2x\'></span></a><a style=\'margin-right:4px\' href=\''.base_url('PayrollManagementNonStaff/ProsesGaji/Kondite/update/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Edit Data\'><span class=\'fa fa-pencil-square-o fa-2x\'></span></a><a href=\''.base_url('PayrollManagementNonStaff/ProsesGaji/Kondite/delete/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Hapus Data\' onclick=\"return confirm(\'Are you sure you want to delete this item?\');\"><span class=\'fa fa-trash fa-2x\'></span></a>","'.$result['noind'].'","'.$result['employee_name'].'","'.$result['kodesie'].'","'.$result['unit_name'].'","'.$result['tanggal'].'","'.$result['mk'].'","'.$result['bki'].'","'.$result['bkp'].'","'.$result['tkp'].'","'.$result['kb'].'","'.$result['kk'].'","'.$result['ks'].'"],';
			}
			else{
				$json .= '["'.$no.'","<a style=\'margin-right:4px\' href=\''.base_url('PayrollManagementNonStaff/ProsesGaji/Kondite/read/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Read Data\'><span class=\'fa fa-list-alt fa-2x\'></span></a><a style=\'margin-right:4px\' href=\''.base_url('PayrollManagementNonStaff/ProsesGaji/Kondite/update/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Edit Data\'><span class=\'fa fa-pencil-square-o fa-2x\'></span></a><a href=\''.base_url('PayrollManagementNonStaff/ProsesGaji/Kondite/delete/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Hapus Data\' onclick=\"return confirm(\'Are you sure you want to delete this item?\');\"><span class=\'fa fa-trash fa-2x\'></span></a>","'.$result['noind'].'","'.$result['employee_name'].'","'.$result['kodesie'].'","'.$result['unit_name'].'","'.$result['tanggal'].'","'.$result['mk'].'","'.$result['bki'].'","'.$result['bkp'].'","'.$result['tkp'].'","'.$result['kb'].'","'.$result['kk'].'","'.$result['ks'].'"]';
			}
			$no++;
		}
		$json .= ']}';

		echo $json;
	}

	public function downloadExcel()
    {
		$filter = $this->input->get('filter');
		$column_table = array('', 'noind', 'employee_name', 'kodesie', 'unit_name', 'tanggal', 'mk', 'bki', 'bkp', 'tkp', 'kb', 'kk', 'ks');
		$column_view = array('no', 'noind', 'nama', 'kodesie', 'nama unit', 'tanggal', 'mk', 'bki', 'bkp', 'tkp', 'kb', 'kk', 'ks');
		$data_table = $this->M_kondite->getKonditeSearch($filter)->result_array();

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

		header('Content-Disposition: attachment;filename="Kondite.xlsx"');
		$objWriter->save("php://output");
	}

}

/* End of file C_Kondite.php */
/* Location: ./application/controllers/PayrollManagementNonStaff/C_Kondite.php */
/* Generated automatically on 2017-03-20 13:35:14 */
