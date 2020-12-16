<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_Peti extends CI_Controller
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
		$this->load->model('StockGdSparepart/M_lihatstock');

		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index()
	{
		$user = $this->session->user;
		$user_id = $this->session->userid;

		$data['Title'] = 'Monitoring Peti';
		$data['Menu'] = 'Monitoring Peti';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		$UserMenu = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		// echo "<pre>";print_r($UserMenu);exit();

		if ($user == 'B0597' || $user == 'B0892') {
			$data['UserMenu'][] = $UserMenu[0];
			$data['UserMenu'][] = $UserMenu[1];
		}else {
			$data['UserMenu'] = $UserMenu;
		}
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('StockGdSparepart/V_Peti', $data);
		$this->load->view('V_Footer',$data);
    }

    function searchData(){
		$tglAw 			= date('d/m/Y');
		$tglAk 			= date('d/m/Y');
		$subinv 		= 'SP-YSP';
		$kode_awal	= $this->M_lihatstock->getdataPeti('');
		$data['tglAw'] 	= $tglAw;
		$data['tglAk'] 	= $tglAk;
		$data['subinv'] = $subinv;
		$data['siapa']  = $this->session->user;
		$datanya = array();
    for ($i=0; $i < count($kode_awal); $i++) { 
			$kode = "and msib.segment1 = '".$kode_awal[$i]['kode']."'";
			$getdata = $this->M_lihatstock->getData($tglAw, $tglAk, $subinv, $kode, '','');
			$getdata[0]['JML_PETI'] = $kode_awal[$i]['peti'];
			array_push($datanya, $getdata[0]);
		}
        $data['data'] = $datanya;
		// echo "<pre>";print_r($data['data']);exit();
		
		$this->load->view('StockGdSparepart/V_TblPeti', $data);
    }

    public function savepeti(){
        $item = $this->input->post('item');
				$jml 	= $this->input->post('jml');
				$jml 	= empty($jml) ? 'NULL' : $jml;
				$this->M_lihatstock->updatePeti($item, $jml);
    }
    
}