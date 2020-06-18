<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_LihatTransact extends CI_Controller
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
		$this->load->model('StockGdSparepart/M_transact');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index()
	{
		$user = $this->session->username;
		$user_id = $this->session->userid;

		$data['Title'] = 'Lihat Transact';
		$data['Menu'] = 'Lihat Transact';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('StockGdSparepart/V_Transact');
		$this->load->view('V_Footer',$data);
    }
    
    public function searchData(){
        $tglAwal = $this->input->post('tglAw');
        $tglAkhir = $this->input->post('tglAk');
        $subinv = $this->input->post('subinv');
        $kode_brg = $this->input->post('kode_brg');
        $kode_awal = $this->input->post('kode_awal');
        $data['tglAw'] = $tglAwal;
        $data['tglAk'] = $tglAkhir;
        $data['subinv'] = $subinv;

        if ($kode_awal != '') {
            $kode = "AND msib.segment1 LIKE '%'||'$kode_awal'||'%'";
        }else {
            $kode = '';
        }
        if ($kode_brg != '') {
            $brg = "AND msib.segment1 = '$kode_brg'";
        }else {
            $brg = '';
        }

        $data['data'] = $this->M_transact->getData($tglAwal, $tglAkhir, $subinv, $brg, $kode);
        // echo "<pre>";print_r($data['data']);exit();

        $this->load->view('StockGdSparepart/V_TblTransact', $data);
    }

}