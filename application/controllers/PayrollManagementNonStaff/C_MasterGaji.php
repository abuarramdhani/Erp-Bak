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

}

/* End of file C_MasterGaji.php */
/* Location: ./application/controllers/PayrollManagementNonStaff/C_MasterGaji.php */
/* Generated automatically on 2017-03-20 13:42:33 */