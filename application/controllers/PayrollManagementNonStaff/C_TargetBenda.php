<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_TargetBenda extends CI_Controller
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
		$this->load->model('PayrollManagementNonStaff/M_targetbenda');

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

		$data['Title'] = 'Target Benda';
		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = 'Data Target';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['TargetBenda'] = $this->M_targetbenda->getTargetBenda();

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
			'target_utama' => $this->input->post('txtTargetUtamaHeader'),
			'target_sementara' => $this->input->post('txtTargetSementaraHeader'),
			'waktu_setting' => $this->input->post('txtWaktuSettingHeader'),
			'tgl_berlaku' => $this->input->post('txtTglBerlakuHeader'),
			'tgl_input' => 'NOW()',
		);
		$this->M_targetbenda->setTargetBenda($data);
		$header_id = $this->db->insert_id();

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
			'target_utama' => $this->input->post('txtTargetUtamaHeader',TRUE),
			'target_sementara' => $this->input->post('txtTargetSementaraHeader',TRUE),
			'waktu_setting' => $this->input->post('txtWaktuSettingHeader',TRUE),
			'tgl_berlaku' => $this->input->post('txtTglBerlakuHeader',TRUE),
			);
		$this->M_targetbenda->updateTargetBenda($data, $plaintext_string);

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

		redirect(site_url('PayrollManagementNonStaff/MasterData/TargetBenda'));
    }



}

/* End of file C_TargetBenda.php */
/* Location: ./application/controllers/PayrollManagement/MainMenu/C_TargetBenda.php */
/* Generated automatically on 2017-03-23 13:51:52 */