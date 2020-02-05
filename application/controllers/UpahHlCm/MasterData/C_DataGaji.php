<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_DataGaji extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
		$this->load->library('Log_Activity');
        $this->load->library('form_validation');
          //load the login model
		$this->load->library('session');
		  //$this->load->library('Database');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('UpahHlCm/M_upahphl');


		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('index');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
    }

	//HALAMAN INDEX
	public function index(){
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/MasterData/V_DataGaji',$data);
		$this->load->view('V_Footer',$data);

	}

	public function checkSession(){
		if($this->session->is_logged){

		}else{
			redirect('');
		}
	}
	public function tambahData(){
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Dashboard';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/MasterData/V_TambahDataGaji');
		$this->load->view('V_Footer',$data);

	}
	public function batalkan()
	{
		redirect('HitungHlcm/DataGaji');
	}
	public function getDataGaji()
	{
		$lokasi_kerja = $this->input->post('loker');
		$data 		= $this->M_upahphl->ambilDataGaji($lokasi_kerja);
		if ($data[0]['pekerjaan'] == 'KEPALA TUKANG') {
			$array = array(
							'kepalatukang' => $data[0]['nominal'],
							'tukang' => $data[1]['nominal'],
							'serabutan' => $data[2]['nominal'],
							'tenaga' => $data[3]['nominal'],
							'uangmakan' => $data[0]['uang_makan'],
							'uangmakanpuasa' => $data[0]['uang_makan_puasa']
						);
		} else if ($data[0]['pekerjaan'] == 'TUKANG') {
			$array = array(
							'kepalatukang' => $data[3]['nominal'],
							'tukang' => $data[0]['nominal'],
							'serabutan' => $data[1]['nominal'],
							'tenaga' => $data[2]['nominal'],
							'uangmakan' => $data[0]['uang_makan'],
							'uangmakanpuasa' => $data[0]['uang_makan_puasa']
						);
		}else if ($data[0]['pekerjaan'] == 'SERABUTAN') {
			$array = array(
							'kepalatukang' => $data[2]['nominal'],
							'tukang' => $data[3]['nominal'],
							'serabutan' => $data[0]['nominal'],
							'tenaga' => $data[1]['nominal'],
							'uangmakan' => $data[0]['uang_makan'],
							'uangmakanpuasa' => $data[0]['uang_makan_puasa']
						);
		}else if ($data[0]['pekerjaan'] == 'TENAGA') {
			$array = array(
							'kepalatukang' => $data[1]['nominal'],
							'tukang' => $data[2]['nominal'],
							'serabutan' => $data[3]['nominal'],
							'tenaga' => $data[0]['nominal'],
							'uangmakan' => $data[0]['uang_makan'],
							'uangmakanpuasa' => $data[0]['uang_makan_puasa']
						);
		}
		echo json_encode($array);
	}
	public function simpanDataGaji()
	{
		$lokasi_kerja= $this->input->post('pekerja_cbg');
		$kepalatukang= $this->input->post('kepalatukang');
		$tukang= $this->input->post('tukang');
		$serabutan= $this->input->post('serabutan');
		$tenaga= $this->input->post('tenaga');
		$uang_makan= $this->input->post('uang_makan');
		$uang_makan_puasa = $this->input->post('uang_makan_puasa');

		$nomkepala = array('nominal' => $kepalatukang);
		$nomtukang = array('nominal' => $tukang);
		$nomserabutan = array('nominal' => $serabutan);
		$nomtenaga = array('nominal' => $tenaga);
		$uangmakan = array('uang_makan' => $uang_makan);
		$uangmakanpuasa = array('uang_makan_puasa' => $uang_makan_puasa);

		$data = $this->M_upahphl->updateKepalaTukang($lokasi_kerja,$nomkepala);
		$data = $this->M_upahphl->updateTukang($lokasi_kerja,$nomtukang);
		$data = $this->M_upahphl->updateSerabutan($lokasi_kerja,$nomserabutan);
		$data = $this->M_upahphl->updateTenaga($lokasi_kerja,$nomtenaga);
		$data = $this->M_upahphl->updateUangMakan($lokasi_kerja,$uangmakan);
		$data = $this->M_upahphl->updateUangMakanPuasa($lokasi_kerja,$uangmakanpuasa);

		//insert to t_log
			$aksi = 'UPAH HLCM';
			$detail = 'SAVE DATA GAJI';
			$this->log_activity->activity_log($aksi, $detail);
		//

		redirect('HitungHlcm/DataGaji');
	}
}
