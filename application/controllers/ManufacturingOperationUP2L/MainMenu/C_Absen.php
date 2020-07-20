<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class C_Absen extends CI_Controller
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
		$this->load->model('ManufacturingOperationUP2L/MainMenu/M_absen');

        $this->checkSession();
        date_default_timezone_set("Asia/Jakarta");
	}

	public function checkSession()
	{
		if ($this->session->is_logged) { } else {
			redirect('');
		}
	}

	public function index()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Absen';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$data['show'] = $this->M_absen->index_data();

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/Absen/V_index', $data);
		$this->load->view('V_Footer', $data);
    }

    public function view_create()
	{
		$user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Absen';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
        $data['pekerja'] = $this->M_absen->pekerja();
		
		for ($i=1;$i<count($data['pekerja']);$i++) {
			$data['data_p'][] = $data['pekerja'][$i]['no_induk'].' | '.$data['pekerja'][$i]['nama'];
		}

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/Absen/V_create', $data);
		$this->load->view('V_Footer', $data);
    }

    public function save_create()
    {
		$induk ='';
		$nama = '';
		foreach ($this->input->post('txt_employee') as $em) {
			$all = explode('|', $em);
			$induk .= ','.trim($all[0]);
			$nama .= ','.trim($all[1]);
		}

		$data = array(
			'nama'					=> substr($nama, 1),
			'no_induk'				=> substr($induk, 1),
			'alasan'				=> '',
			'category_produksi'		=> 'Absen',
			'presensi'				=> $this->input->post('absPrs'),
			'nilai_ott'				=> 0,
			'lembur'				=> FALSE,
			'produksi'				=> 'T',
			'created_date'			=> $this->input->post('absTgl'),
		);
		$this->M_absen->save_create($data);
        redirect(site_url('ManufacturingOperationUP2L/Absen/view_create'));
    }

    public function read_data($id)
    {
        $user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Absen';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
        
        $data['show'] = $this->M_absen->byId($id);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/Absen/V_read', $data);
		$this->load->view('V_Footer', $data);
    }

    public function update_data($id)
    {
        $user = $this->session->username;

		$user_id = $this->session->userid;

		$data['Title'] = 'Absen';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);
		$data['pekerja'] = $this->M_absen->pekerja();
		
		for ($i=1; $i < count($data['pekerja']); $i++) {
			$data['data_p'][] = $data['pekerja'][$i]['no_induk'].' | '.$data['pekerja'][$i]['nama'];
		}
        $data['show'] = $this->M_absen->byId($id);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/Absen/V_update', $data);
		$this->load->view('V_Footer', $data);
    }

    public function save_update()
    {
        $id = $this->input->post('absId');
        $nama = explode(' | ', $this->input->post('txt_employee'));
        $data  = array(
			'nama'					=> $nama[1],
			'no_induk'				=> $nama[0],
			'category_produksi'		=> 'Absen',
			'alasan'				=> '',
			'presensi'				=> $this->input->post('absPrs'),
			'nilai_ott'				=> 0,
			'lembur'				=> FALSE,
			'produksi'				=> 'T',
			'created_date'			=> $this->input->post('absTgl'),
        );

        $this->M_absen->save_update($data, $id);
        redirect(site_url('ManufacturingOperationUP2L/Absen'));
    }

    public function delete_data($id)
    {
        $this->M_absen->delete($id);
        redirect(site_url('ManufacturingOperationUP2L/Absen'));
	}
	
	public function pekerja()
	{
		$pekerja = $this->M_absen->pekerjaAjax(strtolower(array_keys($_GET)[0]));
		echo json_encode($pekerja);
	}
}