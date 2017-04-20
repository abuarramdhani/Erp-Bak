<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Kondite extends CI_Controller
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
		$this->load->model('PayrollManagementNonStaff/M_kondite');

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
					'MK' => $this->input->post('txtMKHeader['.$i.']'),
					'BKI' => $this->input->post('txtBKIHeader['.$i.']'),
					'BKP' => $this->input->post('txtBKPHeader['.$i.']'),
					'TKP' => $this->input->post('txtTKPHeader['.$i.']'),
					'KB' => $this->input->post('txtKBHeader['.$i.']'),
					'KK' => $this->input->post('txtKKHeader['.$i.']'),
					'KS' => $this->input->post('txtKSHeader['.$i.']'),
					'creation_date' => 'NOW()',
					'created_by' => $this->session->userid,
				);
				$this->M_kondite->setKondite($data);

			}

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
					'MK' => $this->input->post('txtMKHeader['.$i.']'),
					'BKI' => $this->input->post('txtBKIHeader['.$i.']'),
					'BKP' => $this->input->post('txtBKPHeader['.$i.']'),
					'TKP' => $this->input->post('txtTKPHeader['.$i.']'),
					'KB' => $this->input->post('txtKBHeader['.$i.']'),
					'KK' => $this->input->post('txtKKHeader['.$i.']'),
					'KS' => $this->input->post('txtKSHeader['.$i.']'),
					'creation_date' => 'NOW()',
					'created_by' => $this->session->userid,
				);
				$this->M_kondite->setKondite($data);

			}

			redirect(site_url('PayrollManagementNonStaff/ProsesGaji/Kondite'));
		}
		else{
			redirect(site_url('PayrollManagementNonStaff/ProsesGaji/Kondite'));
		}
		
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
					'tanggal' => utf8_encode($db_record['TGL']),
					'noind' => utf8_encode($db_record['NOIND']),
					'MK' => utf8_encode($db_record['KONDITE1']),
					'BKI' => utf8_encode($db_record['KONDITE2']),
					'BKP' => utf8_encode($db_record['KONDITE3']),
					'TKP' => utf8_encode($db_record['KONDITE4']),
					'KB' => utf8_encode($db_record['KONDITE5']),
					'KK' => utf8_encode($db_record['KONDITE6']),
					'KS' => utf8_encode($db_record['KONDITE7']),
					'creation_date' => 'NOW()',
					'created_by' => $this->session->userid,
				);

				$this->M_kondite->setKondite($data);

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
			'MK' => $this->input->post('txtMKHeader',TRUE),
			'BKI' => $this->input->post('txtBKIHeader',TRUE),
			'BKP' => $this->input->post('txtBKPHeader',TRUE),
			'TKP' => $this->input->post('txtTKPHeader',TRUE),
			'KB' => $this->input->post('txtKBHeader',TRUE),
			'KK' => $this->input->post('txtKKHeader',TRUE),
			'KS' => $this->input->post('txtKSHeader',TRUE)
			);
		$this->M_kondite->updateKondite($data, $plaintext_string);

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

		redirect(site_url('PayrollManagementNonStaff/ProsesGaji/Kondite'));
	}

	public function getPekerja(){
		$kodesie = $this->input->post('kodesie');
		$date = $this->input->post('date');
		
		$data = $this->M_kondite->getPekerja($kodesie,$date);

		if (count($data) > 0) {
			foreach ($data as $data) {
				echo '
					<tr>
						   <td width="30%">
						   		'.$data['noind'].' - '.$data['nama'].'
								  <input type="hidden" class="form-control" name="txtNoindHeader[]" value="'.$data['noind'].'" required>
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
			7 => '"MK"',
			8 => '"BKI"',
			9 => '"BKP"',
			10 => '"TKP"',
			11 => '"KB"',
			12 => '"KK"',
			13 => '"KS"'
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
				$json .= '["'.$no.'","<a style=\'margin-right:4px\' href=\''.base_url('PayrollManagementNonStaff/ProsesGaji/Kondite/read/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Read Data\'><span class=\'fa fa-list-alt fa-2x\'></span></a><a style=\'margin-right:4px\' href=\''.base_url('PayrollManagementNonStaff/ProsesGaji/Kondite/update/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Edit Data\'><span class=\'fa fa-pencil-square-o fa-2x\'></span></a><a href=\''.base_url('PayrollManagementNonStaff/ProsesGaji/Kondite/delete/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Hapus Data\' onclick=\"return confirm(\'Are you sure you want to delete this item?\');\"><span class=\'fa fa-trash fa-2x\'></span></a>","'.$result['noind'].'","'.$result['employee_name'].'","'.$result['kodesie'].'","'.$result['unit_name'].'","'.$result['tanggal'].'","'.$result['MK'].'","'.$result['BKI'].'","'.$result['BKP'].'","'.$result['TKP'].'","'.$result['KB'].'","'.$result['KK'].'","'.$result['KS'].'"],';
			}
			else{
				$json .= '["'.$no.'","<a style=\'margin-right:4px\' href=\''.base_url('PayrollManagementNonStaff/ProsesGaji/Kondite/read/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Read Data\'><span class=\'fa fa-list-alt fa-2x\'></span></a><a style=\'margin-right:4px\' href=\''.base_url('PayrollManagementNonStaff/ProsesGaji/Kondite/update/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Edit Data\'><span class=\'fa fa-pencil-square-o fa-2x\'></span></a><a href=\''.base_url('PayrollManagementNonStaff/ProsesGaji/Kondite/delete/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Hapus Data\' onclick=\"return confirm(\'Are you sure you want to delete this item?\');\"><span class=\'fa fa-trash fa-2x\'></span></a>","'.$result['noind'].'","'.$result['employee_name'].'","'.$result['kodesie'].'","'.$result['unit_name'].'","'.$result['tanggal'].'","'.$result['MK'].'","'.$result['BKI'].'","'.$result['BKP'].'","'.$result['TKP'].'","'.$result['KB'].'","'.$result['KK'].'","'.$result['KS'].'"]';
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