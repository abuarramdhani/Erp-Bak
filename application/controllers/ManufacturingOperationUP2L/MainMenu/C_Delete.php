<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class C_Delete extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('ManufacturingOperationUP2L/MainMenu/M_deleteup2l');

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

		$data['Title'] = 'Hapus Data';
		$data['Menu'] = 'Manufacturing Operation';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id, $this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $this->session->responsibility_id);

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('ManufacturingOperationUP2L/Delete/V_index', $data);
		$this->load->view('V_Footer', $data);
    }

    public function delete_massal()
	{
		$sdsaw = explode('-', $this->input->post('month'));
		
		$kdos = $this->M_deleteup2l->mo($sdsaw[1], $sdsaw[0]);

		foreach ($kdos as $di) {
			$this->M_deleteup2l->bongkarScrapEmployeeOfMoulding($di['moulding_id']);
		}
		$this->M_deleteup2l->deleteAll($sdsaw[1], $sdsaw[0]); // sdsaw1 = bulan, sdsaw0 = tahun
		redirect(base_url('ManufacturingOperationUP2L/DeleteDataUP2L'));
    }
}