<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_MasterGaji extends CI_Controller
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
		$this->load->model('PayrollManagementNonStaff/M_mastergaji');

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

		$data['Title'] = 'Master Gaji';
		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = 'Data Gaji';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['MasterGaji'] = $this->M_mastergaji->getMasterGaji();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/MasterGaji/V_index', $data);
		$this->load->view('V_Footer',$data);
	}

	/* NEW DATA */
	public function create()
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Master Gaji';
		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = 'Data Gaji';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/MasterGaji/V_create', $data);
		$this->load->view('V_Footer',$data);	
	}

	public function doCreate(){
		$noind_kodesie = $this->input->post('cmbNoindHeader');
		$explode = explode(' - ', $noind_kodesie);
		$noind = $explode[0];
		$kodesie = $explode[1];

		$data = array(
			'noind' => $noind,
			'kodesie' => $this->input->post('cmbKodesieHeader'),
			'kelas' => $this->input->post('txtKelasHeader'),
			'gaji_pokok' => $this->input->post('txtGajiPokokHeader'),
			'insentif_prestasi' => $this->input->post('txtInsentifPrestasiHeader'),
			'insentif_masuk_sore' => $this->input->post('txtInsentifMasukSoreHeader'),
			'insentif_masuk_malam' => $this->input->post('txtInsentifMasukMalamHeader'),
			'ubt' => $this->input->post('txtUbtHeader'),
			'upamk' => $this->input->post('txtUpamkHeader'),
		);
		$this->M_mastergaji->setMasterGaji($data);
		$header_id = $this->db->insert_id();

		redirect(site_url('PayrollManagementNonStaff/MasterData/DataGaji'));

	}

	/* UPDATE DATA */
	public function update($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Master Gaji';
		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = 'Data Gaji';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['MasterGaji'] = $this->M_mastergaji->getMasterGaji($plaintext_string);

		/* LINES DATA */

		/* HEADER DROPDOWN DATA */

		/* LINES DROPDOWN DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/MasterGaji/V_update', $data);
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
			'kelas' => $this->input->post('txtKelasHeader',TRUE),
			'gaji_pokok' => $this->input->post('txtGajiPokokHeader',TRUE),
			'insentif_prestasi' => $this->input->post('txtInsentifPrestasiHeader',TRUE),
			'insentif_masuk_sore' => $this->input->post('txtInsentifMasukSoreHeader',TRUE),
			'insentif_masuk_malam' => $this->input->post('txtInsentifMasukMalamHeader',TRUE),
			'ubt' => $this->input->post('txtUbtHeader',TRUE),
			'upamk' => $this->input->post('txtUpamkHeader',TRUE),
			);
		$this->M_mastergaji->updateMasterGaji($data, $plaintext_string);

		redirect(site_url('PayrollManagementNonStaff/MasterData/DataGaji'));

	}

	/* READ DATA */
	public function read($id)
	{
		$user_id = $this->session->userid;

		$data['Title'] = 'Master Gaji';
		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = 'Data Gaji';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['id'] = $id;

		/* HEADER DATA */
		$data['MasterGaji'] = $this->M_mastergaji->getMasterGaji($plaintext_string);

		/* LINES DATA */

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/MasterGaji/V_read', $data);
		$this->load->view('V_Footer',$data);
	}

    /* DELETE DATA */
    public function delete($id)
    {
        $plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_mastergaji->deleteMasterGaji($plaintext_string);

		redirect(site_url('PayrollManagementNonStaff/MasterData/DataGaji'));
    }

    public function import_data(){
    	$user_id = $this->session->userid;

		$data['Title'] = 'Import Data';
		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = 'Data Gaji';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PayrollManagementNonStaff/MasterGaji/V_import', $data);
		$this->load->view('V_Footer',$data);
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
					'noind' => $db_record['NOIND'],
					'kodesie' => $db_record['KODESIE'],
					'kelas' => $db_record['KELAS'],
					'gaji_pokok' => $db_record['GP'],
					'insentif_prestasi' => $db_record['IP'],
					'insentif_masuk_sore' => $db_record['IMS'],
					'insentif_masuk_malam' => $db_record['IMM'],
					'ubt' => $db_record['UBT'],
					'upamk' => $db_record['UPAMK'],
				);

				$this->M_mastergaji->setMasterGaji($data);

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

	public function showList(){
		$requestData= $_REQUEST;

		// print_r($requestData);exit;

		$columns = array(  
			0=> 'noind',
			1=> 'noind',
			2=> 'noind',
			3=> 'employee_name',
			4=> 'kodesie',
			5=> 'unit_name',
			6=> 'kelas',
			7=> 'gaji_pokok',
			8=> 'insentif_prestasi',
			9=> 'insentif_masuk_sore',
			10=> 'insentif_masuk_malam',
			11=> 'ubt',
			12=> 'upamk'

		);

		$data_table = $this->M_mastergaji->getMasterGajiDatatables();
		$totalData = $data_table->num_rows();
		$totalFiltered = $totalData;

		if(!empty($requestData['search']['value'])) {
			$data_table = $this->M_mastergaji->getMasterGajiSearch($requestData['search']['value']);
			$totalFiltered = $data_table->num_rows();

			$data_table = $this->M_mastergaji->getMasterGajiOrderLimit($requestData['search']['value'], $columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'], $requestData['length'], $requestData['start']);
		}
		else{
			$data_table = $this->M_mastergaji->getMasterGajiOrderLimit($searchValue = NULL, $columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir'], $requestData['length'], $requestData['start']);
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
			$encrypted_string = $this->encrypt->encode($result['master_gaji_id']);
			$encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);

			$count--;
			if ($count != 0) {
				$json .= '["'.$no.'", "<a style=\'margin-right:4px\' href=\''.base_url('PayrollManagementNonStaff/MasterData/DataGaji/read/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Read Data\'><span class=\'fa fa-list-alt fa-2x\'></span></a><a style=\'margin-right:4px\' href=\''.base_url('PayrollManagementNonStaff/MasterData/DataGaji/update/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Edit Data\'><span class=\'fa fa-pencil-square-o fa-2x\'></span></a><a href=\''.base_url('PayrollManagementNonStaff/MasterData/DataGaji/delete/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Hapus Data\' onclick=\'return confirm(\'Are you sure you want to delete this item?\');\'><span class=\'fa fa-trash fa-2x\'></span></a>", "'.$result['noind'].'", "'.$result['employee_name'].'", "'.$result['kodesie'].'", "'.$result['unit_name'].'", "'.$result['kelas'].'", "'.$result['gaji_pokok'].'", "'.$result['insentif_prestasi'].'", "'.$result['insentif_masuk_sore'].'", "'.$result['insentif_masuk_malam'].'", "'.$result['ubt'].'", "'.$result['upamk'].'"],';
			}
			else{
				$json .= '["'.$no.'", "<a style=\'margin-right:4px\' href=\''.base_url('PayrollManagementNonStaff/MasterData/DataGaji/read/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Read Data\'><span class=\'fa fa-list-alt fa-2x\'></span></a><a style=\'margin-right:4px\' href=\''.base_url('PayrollManagementNonStaff/MasterData/DataGaji/update/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Edit Data\'><span class=\'fa fa-pencil-square-o fa-2x\'></span></a><a href=\''.base_url('PayrollManagementNonStaff/MasterData/DataGaji/delete/'.$encrypted_string.'').'\' data-toggle=\'tooltip\' data-placement=\'bottom\' title=\'Hapus Data\' onclick=\'return confirm(\'Are you sure you want to delete this item?\');\'><span class=\'fa fa-trash fa-2x\'></span></a>", "'.$result['noind'].'", "'.$result['employee_name'].'", "'.$result['kodesie'].'", "'.$result['unit_name'].'", "'.$result['kelas'].'", "'.$result['gaji_pokok'].'", "'.$result['insentif_prestasi'].'", "'.$result['insentif_masuk_sore'].'", "'.$result['insentif_masuk_malam'].'", "'.$result['ubt'].'", "'.$result['upamk'].'"]';
			}
			$no++;
		}
		$json .= ']}';

		echo $json;
	}

}

/* End of file C_MasterGaji.php */
/* Location: ./application/controllers/PayrollManagementNonStaff/C_MasterGaji.php */
/* Generated automatically on 2017-03-20 13:42:33 */