<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Approval extends CI_Controller {

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
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		  //$this->load->model('CustomerRelationship/M_Index');
    }

	//HALAMAN INDEX
	public function index(){
		$this->checkSession();
		$user_id = $this->session->userid;

		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = 'Approval';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_upahphl->dataApproval();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/MasterData/V_Approval',$data);
		$this->load->view('V_Footer',$data);

	}

	public function checkSession(){
		if($this->session->is_logged){

		}else{
			redirect('');
		}
	}

	public function editData($id)
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Master Data';
		$data['SubMenuOne'] = 'Approval';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $this->M_upahphl->ambilDataApproval($id);
		$data['id'] = $id;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('UpahHlCm/MasterData/V_EditApproval',$data);
		$this->load->view('V_Footer',$data);
	}

	public function batalkan()
	{
		redirect('HitungHlcm/Approval');
	}
	public function ambilpekerja()
	{
		$pekerja = strtoupper($this->input->get('term'));
		$data = $this->M_upahphl->pekerjaApproval($pekerja);

		echo json_encode($data);
	}
	public function namaChange()
	{
		$noind = $this->input->post('noind');
		$data = $this->M_upahphl->namaPekerja($noind);
		if (substr($noind, 0,1) == 'R') {
			$array = array('nama' => $data[0]['nama'],
							'jabatan' => $data[0]['pekerjaan']);
		}else{
			$array = array('nama' => $data[0]['nama'],
							'jabatan' => $data[0]['jabatan']);
		}

		echo json_encode($array);
	}

	public function simpanEdit()
	{
		$id = $this->input->post('id_appproval');
		$nama = $this->input->post('namapekerja');
		$noind = $this->input->post('noindukpekerja');
		$posisi = $this->input->post('posisipekerja');
		$loker = $this->input->post('lokasikerja');
		$jabatan = $this->input->post('jabatanpekerja');

		if ($noind != null) {
			$array = array(
							'noind' => $noind,
							'nama' => $nama,
							'id_status' => $posisi,
							'lokasi_kerja' => $loker,
							'jabatan' => $jabatan,
						);

		}else {
			$array = array(
							'id_status' => $posisi,
							'lokasi_kerja' => $loker,
						);
		}
		$this->M_upahphl->simpanApproval($id,$array);
		//insert to t_log
			$aksi = 'UPAH HLCM';
			$detail = 'UPDATE HLCM ID='.$id;
			$this->log_activity->activity_log($aksi, $detail);
		//
		redirect('HitungHlcm/Approval');
	}

}
