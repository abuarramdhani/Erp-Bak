<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_OutPart extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		  
        $this->load->helper('url');
        $this->load->helper('html');
		$this->load->library('session');
		$this->load->model('M_index');
		$this->load->model('WarehouseMPO/M_outpart');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
    }
	
	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
	}
	
	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		$compile = $this->input->post('compile');

		$spbs_awal = $this->input->post('txtSpbsAwal');
		$spbs_akhir = $this->input->post('txtSpbsAkhir');
		$kirim_awal = $this->input->post('txtKirimAwal');
		$kirim_akhir = $this->input->post('txtKirimAkhir');
		$spbs_num = $this->input->post('txtSpbsNum');
		$subname = $this->input->post('txtSubName');
		$job = $this->input->post('txtJob');

		$data['spbs_awal'] = $spbs_awal;
		$data['spbs_akhir'] = $spbs_akhir;
		$data['kirim_awal'] = $kirim_awal;
		$data['kirim_akhir'] = $kirim_akhir;
		$data['spbs_num'] = $spbs_num;
		$data['subname'] = $subname;
		$data['job'] = $job;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		// if (empty($compile)) {
		// 	$data['outpartAll'] = $this->M_outpart->indexOut();
		// }else{
		// 	$data['outpartAll'] = $this->M_outpart->indexWarehouse($compile);
		// }

		$data['warehouse'] = $this->M_outpart->getWarehouse();
		$data['subkont'] = $this->M_outpart->getSubkont();

		$data['outpartAll'] = $this->M_outpart->allPengeluaran($spbs_awal,$spbs_akhir,$kirim_awal,$kirim_akhir,$spbs_num,$subname,$job);

		// echo "<pre>";
		// print_r($data);
		// exit();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WarehouseMPO/Pengeluaran/V_OutPart',$data);
		$this->load->view('V_Footer',$data);
		
	}

	public function filterByGudang($compile = false)
	{
		$this->checkSession();
		$user_id = $this->session->userid;

		// $compile = $this->input->post('compile');

		$data['compile'] = $compile;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		// $data['outpartAll'] = $this->M_outpart->indexOut();
		$data['warehouse'] = $this->M_outpart->getWarehouse();
		$data['subkont'] = $this->M_outpart->getSubkont();

		if ($compile == FALSE) {
			$data['outpartAll'] = $this->M_outpart->indexOut();
		}else{
			$data['outpartAll'] = $this->M_outpart->indexWarehouse($compile);
		}

		// echo "<pre>";
		// print_r($data);
		// exit();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WarehouseMPO/Pengeluaran/V_OutPart',$data);
		$this->load->view('V_Footer',$data);
		
	}

	public function filterOut($compile = false)
	{
		$this->checkSession();
		$user_id = $this->session->userid;

	//----------------------------------------------------------------//
		$spbs_awal = $this->input->post('txtSpbsAwal');
		if($spbs_awal){
			$spbs_awal = date_format(date_create($spbs_awal),'d/M/Y');
		}

	//----------------------------------------------------------------//
		$spbs_akhir = $this->input->post('txtSpbsAkhir');
		if($spbs_akhir){
			$spbs_akhir = date_format(date_create($spbs_akhir),'d/M/Y');
		}


	//----------------------------------------------------------------//
		$kirim_awal = $this->input->post('txtKirimAwal');
		if($kirim_awal){
			$kirim_awal = date_format(date_create($kirim_awal),'d/M/Y');
		}
		

	//----------------------------------------------------------------//
		$kirim_akhir = $this->input->post('txtKirimAkhir');
		if($kirim_akhir){
			$kirim_akhir = date_format(date_create($kirim_akhir),'d/M/Y');
		}

	//----------------------------------------------------------------//
		$spbs_num = $this->input->post('txtSpbsNum');

	//----------------------------------------------------------------//
		$subname = $this->input->post('txtSubName');

	//----------------------------------------------------------------//
		$job = $this->input->post('txtJob');


		$data['spbs_awal'] = $spbs_awal;
		$data['spbs_akhir'] = $spbs_akhir;
		$data['kirim_awal'] = $kirim_awal;
		$data['kirim_akhir'] = $kirim_akhir;
		$data['spbs_num'] = $spbs_num;
		$data['subname'] = $subname;
		$data['job'] = $job;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['outpartAll'] = $this->M_outpart->allPengeluaran($spbs_awal,$spbs_akhir,$kirim_awal,$kirim_akhir,$spbs_num,$subname,$job);

		// echo "<pre>";
		// print_r($data);
		// exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WarehouseMPO/Pengeluaran/V_OutPart',$data);
		$this->load->view('V_Footer',$data);

		//redirect(base_url('MonitoringBarangGudang/Pengeluaran'));
	}

}
