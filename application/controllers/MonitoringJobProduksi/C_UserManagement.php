<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_UserManagement extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('PHPMailerAutoload');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MonitoringJobProduksi/M_usermng');

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

		$data['Title'] = 'User Management';
		$data['Menu'] = 'User Management';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MonitoringJobProduksi/V_UserMng', $data);
		$this->load->view('V_Footer',$data);
    }

    public function getdata(){
        $getdata = $this->M_usermng->getUser('');
        foreach ($getdata as $key => $val) {
            $user = $this->M_usermng->getuserMJP($val['NO_INDUK']);
            $getdata[$key]['NAMA'] = $user[0]['nama'];
        }
        $data['data'] = $getdata;
        $this->load->view('MonitoringJobProduksi/V_TblUser', $data);
    }
    
	public function getuserMJP(){
		$term = $this->input->get('term',TRUE);
		$term = strtoupper($term);
		$data = $this->M_usermng->getUserMjp($term);
		// echo "<pre>";print_r($data);exit();
		echo json_encode($data);
    }

    public function saveUser(){
        $jenis 	= $this->input->post('jenis');
        $user 	= $this->input->post('user');

        $cek = $this->M_usermng->getUser("where no_induk = '$user'");
        if (empty($cek)) {
            $this->M_usermng->saveuser($jenis, $user);
            $ket = 'oke';
        }else {
            $ket = 'not';
        }
        echo $ket;
	}
	
	public function editUser(){
		$noind 	= $this->input->post('noind');
		$nama 	= $this->input->post('nama');
		$jenis 	= $this->input->post('jenis');
		$jenis2 = $jenis == 'Admin' ? 'Superuser' : 'Admin';
		$view 	= '<div class="panel-body">
						<div class="col-md-3 text-right">
							<label>Nama :</label>
						</div>
						<div class="col-md-8">
							<input class="form-control" value="'.$noind.' - '.$nama.'" readonly>
							<input type="hidden" name="noind" value="'.$noind.'">
						</div>
					</div>
					<div class="panel-body">
						<div class="col-md-3 text-right">
							<label>Jenis :</label>
						</div>
						<div class="col-md-8">
							<select name="jenis" id="jenis" class="form-control select2" style="width:100%">
								<option value="'.$jenis.'">'.$jenis.'</option>
								<option value="'.$jenis2.'">'.$jenis2.'</option>
							</select>
						</div>
					</div>
					<div class="panel-body text-center">
						<button class="btn btn-success" formaction="'.base_url("MonitoringJobProduksi/UserManagement/updateUser").'"><i class="fa fa-save"></i> Save</button>
					</div>';
		echo $view;
	}
	
    public function updateUser(){
        $jenis 	= $this->input->post('jenis');
		$user 	= $this->input->post('noind');
		// echo "<pre>";print_r($jenis);exit();
		$this->M_usermng->updateUser($jenis, $user);
		redirect(base_url("MonitoringJobProduksi/UserManagement"));
	}

	public function deleteUser(){
        $jenis 	= $this->input->post('jenis');
        $user 	= $this->input->post('noind');
		$this->M_usermng->deleteUser($jenis, $user);
	}
    
}