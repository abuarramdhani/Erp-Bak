<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Index extends CI_Controller {


	public function __construct()
    {
        parent::__construct();

        $this->load->library('Log_Activity');
        $this->load->library('General');
        $this->load->library('encrypt');
        $this->load->model('M_Index');
        $this->load->library('session');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPekerja/SetupPekerjaan/M_pekerjaan');


		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->load->helper('terbilang_helper');
			$this->session->set_userdata('last_page', current_url());
				  //redirect('');
			$this->session->set_userdata('Responsbility', 'some_value');
		}
		date_default_timezone_set('Asia/Jakarta');
		$this->checkSession();
    }
	public function checkSession()
	{
		if($this->session->is_logged){

		}else{
			redirect('');
		}
	}
    public function index()
    {
    	$this->checkSession();
    	$user_id = $this->session->userid;

    	$data['Title']	= 'Setup Pekerjaan';
    	$data['Menu'] = 'Setup Master';
    	$data['SubMenuOne'] = 'Setup Pekerjaan';
    	$data['SubMenuTwo'] = '';

    	$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    	$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
    	$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    	$data['data'] = $this->M_pekerjaan->lihat();

    	$this->load->view('V_Header',$data);
    	$this->load->view('V_Sidemenu',$data);
    	$this->load->view('MasterPekerja/SetupPekerjaan/V_Index',$data);
    	$this->load->view('V_Footer',$data);
    }

	public function create()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
        $user = $this->session->user;

    	$data['Title']	= ' Create Pekerjaan';
    	$data['Menu'] = 'Setup Master';
    	$data['SubMenuOne'] = 'Setup Pekerjaan';
    	$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->form_validation->set_rules('required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MasterPekerja/SetupPekerjaan/V_Create.php',$data);
			$this->load->view('V_Footer',$data);
		}else{

	    $kdpekerjaan		  =	$this->input->post('txtKodeUrut');
		$pekerjaan		      =	$this->input->post('txtPekerjaan');
		$learningperiode      =	$this->input->post('txtLearningPeriodelama');
		$satuan		     	  =	$this->input->post('txtLearningPeriodejenis');
		$jenispekerjaan		  =	$this->input->post('rd_labour');
		$jenisbaju		      =	$this->input->post('rd_kancing');
		$jeniscelana		  =	$this->input->post('rd_celana');
		$status		     	  =	$this->input->post('rd_status');



		$input			= 	array
										(
											'kdpekerjaan'			  =>	$kdpekerjaan,
											'pekerjaan'				  =>	$pekerjaan,
											'learningperiode'		  =>	$learningperiode,
											'satuan'		          =>	$satuan,
											'jenispekerjaan'		  =>	$jenispekerjaan,
											'jenisbaju'		          =>	$jenisbaju,
											'jeniscelana'		      =>	$jeniscelana,
											'status'		          =>	$status


										);

		$cek = $this->M_pekerjaan->cekKodepekerjaan($kdpekerjaan);
		if ($cek == 0) {
			$this->M_pekerjaan->input($input);
            //insert to t_log
			$aksi = 'MASTER PEKERJA';
			$detail = 'Create Pekerjaan kd_pekerjaan='.$kd_pekerjaan;
			$this->log_activity->activity_log($aksi, $detail);
			//
			$this->M_pekerjaan->tlogTambah($kdpekerjaan,$user);
		}
		redirect('MasterPekerja/SetupPekerjaan');
		}


	}

	public function getKodePekerjaan(){
		$kdsie = $this->input->post('kodesie');

		while (strlen($kdsie) < 7) {
			$kdsie .= '0';
		}
		$urut = $this->M_pekerjaan->urut($kdsie);
		if ($urut->num_rows() == 0) {
			$kdsie .= '01';
		}else{
			$kdsie = $urut->row()->kodeselanjutnya;
		}
		echo $kdsie;
	}

	public function delete($id)
		{
			$id	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
			$id	=	$this->encrypt->decode($id);

			$this->checkSession();
		$user_id = $this->session->userid;
		$user = $this->session->user;
		    $kdpekerjaan =$this->M_pekerjaan->cariKodePekerjaan($id);

			$this->M_pekerjaan->delete($id);
            //insert to t_log
			$aksi = 'MASTER PEKERJA';
			$detail = 'Delete Pekerjaan ID='.$id;
			$this->log_activity->activity_log($aksi, $detail);
			//
           $this->M_pekerjaan->tlogHapus($kdpekerjaan,$user);
			redirect('MasterPekerja/SetupPekerjaan');

		}

	public function read($id)
	{

		$this->checkSession();
		$user_id = $this->session->userid;
		$user = $this->session->user;

    	$data['Title']	= 'Setup Pekerjaan';
    	$data['Menu'] = 'Setup Master';
    	$data['SubMenuOne'] = 'Setup Pekerjaan';
    	$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$id	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$id	=	$this->encrypt->decode($id);
		$data['data'] = $this->M_pekerjaan->GetPekerjaan($id);
	// echo "<pre>";print_r($data['data']);exit();

        $this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/SetupPekerjaan/V_Read',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update($encrypt_id)
	{
		$id	=	str_replace(array('-', '_', '~'), array('+', '/', '='), $encrypt_id);
		$id	=	$this->encrypt->decode($id);
        //insert to t_log
        $aksi = 'MASTER PEKERJA';
        $detail = 'Update Pekerjaan hrd_khs.tpekerjaan ID='.$id;
        $this->log_activity->activity_log($aksi, $detail);
        //

		$kdpekerjaan		     			=	$this->input->post('txtKodeUrut');
		$pekerjaan		     			    =	$this->input->post('txtPekerjaan');
		$learningperiode		     		=	$this->input->post('txtLearningPeriodelama');
		$satuan		     			        =	$this->input->post('txtLearningPeriodejenis');
		$jenispekerjaan		     		   =	$this->input->post('rd_labour');

		$jenisbaju		     			    =	$this->input->post('rd_kancing');
		$jeniscelana		     			=	$this->input->post('rd_celana');
		$status		     		             =	$this->input->post('rd_status');

		$this->checkSession();
		$user_id = $this->session->userid;
        $user = $this->session->user;


    	$data['Title']	= 'Edit Pekerjaan';
    	$data['Menu'] = 'Setup Master';
    	$data['SubMenuOne'] = 'Setup Pekerjaan';
		$data['SubMenuTwo'] = '';
		$data['id']			=$encrypt_id;

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

	    $data['editSetupPekerjaan'] = $this->M_pekerjaan->editSetupPekerjaan($id);

		$this->form_validation->set_rules('required');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MasterPekerja/SetupPekerjaan/V_Update.php',$data);
			$this->load->view('V_Footer',$data);
		}else{
		$data			= 	array
										(
											'kdpekerjaan'			  =>	$kdpekerjaan,
											'pekerjaan'				  =>	$pekerjaan,
											'learningperiode'		  =>	$learningperiode,
											'satuan'		          =>	$satuan,
											'jenispekerjaan'		  =>	$jenispekerjaan,
											'jenisbaju'		          =>	$jenisbaju,
											'jeniscelana'		      =>	$jeniscelana,
											'status'		          =>	$status


										);


	        $this->M_pekerjaan->tlogEdit($kdpekerjaan,$user);
			$this->M_pekerjaan->updatepribadi($kdpekerjaan,$id);
			$this->M_pekerjaan->update($id,$data);

		redirect('MasterPekerja/SetupPekerjaan');
		}

	}

	public function daftarDepartemen()
	{
		$resultDepartemen = 	$this->M_pekerjaan->ambilDepartemen();
		echo json_encode($resultDepartemen);
	}

	public function daftarBidang()
	{
		$departemen 	=	$this->input->get('departemen');

		$resultBidang 	=	$this->M_pekerjaan->ambilBidang($departemen);
		echo json_encode($resultBidang);
	}

	public function daftarUnit()
	{
		$bidang 		=	$this->input->get('bidang');

		$resultUnit		=	$this->M_pekerjaan->ambilUnit($bidang);
		echo json_encode($resultUnit);
	}

	public function daftarSeksi()
	{
		$unit 			=	$this->input->get('unit');

		$resultSeksi	=	$this->M_pekerjaan->ambilSeksi($unit);
		echo json_encode($resultSeksi);
	}


}
