<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Potongan extends CI_Controller
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
			'pot_spsi' => $this->input->post('txtPotSpsiHeader'),
			'pot_duka' => $this->input->post('txtPotDukaHeader'),
			'pot_koperasi' => $this->input->post('txtPotKoperasiHeader'),
			'pot_hutang_lain' => $this->input->post('txtPotHutangLainHeader'),
			'pot_dplk' => $this->input->post('txtPotDplkHeader'),
			'pot_thp' => $this->input->post('txtPotThpHeader'),
		);
		$this->M_potongan->setPotongan($data);
		$header_id = $this->db->insert_id();

		redirect(site_url('PayrollManagementNonStaff/ProsesGaji/Potongan'));		
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
			'pot_spsi' => $this->input->post('txtPotSpsiHeader',TRUE),
			'pot_duka' => $this->input->post('txtPotDukaHeader',TRUE),
			'pot_koperasi' => $this->input->post('txtPotKoperasiHeader',TRUE),
			'pot_hutang_lain' => $this->input->post('txtPotHutangLainHeader',TRUE),
			'pot_dplk' => $this->input->post('txtPotDplkHeader',TRUE),
			'pot_thp' => $this->input->post('txtPotThpHeader',TRUE),
			);
		$this->M_potongan->updatePotongan($data, $plaintext_string);

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

		redirect(site_url('PayrollManagementNonStaff/ProsesGaji/Potongan'));
    }



}

/* End of file C_Potongan.php */
/* Location: ./application/controllers/PayrollManagementNonStaff/C_Potongan.php */
/* Generated automatically on 2017-03-20 13:40:14 */