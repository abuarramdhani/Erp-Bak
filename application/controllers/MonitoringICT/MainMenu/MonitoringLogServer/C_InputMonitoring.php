<?php defined('BASEPATH') OR exit('No direct script access allowed');
class C_InputMonitoring extends CI_Controller
{
	
	public function __construct()
		{
			parent::__construct();
			$this->load->helper('form');
	        $this->load->helper('url');
	        $this->load->helper('html');
	        $this->load->library('form_validation');
	          //load the login model
			$this->load->library('session');
			$this->load->model('M_Index');
			$this->load->model('SystemAdministration/MainMenu/M_user');
			$this->load->model('MonitoringICT/MainMenu/MonitoringLogServer/M_monitoringserver');
			  
			if($this->session->userdata('logged_in')!=TRUE) {
				$this->load->helper('url');
				$this->session->set_userdata('last_page', current_url());
				$this->session->set_userdata('Responsbility', 'some_value');
			}
		}
	public function checkSession()
		{
			if($this->session->is_logged){
				}else{
					redirect();
				}
		}

	public function index()
		{
			$this->checkSession();
			$user_id = $this->session->userid;
			$data['Menu'] = 'Dashboard';
			$data['SubMenuOne'] = '';
			$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
			$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
			$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
			$data['PekerjaLS']   = $this->M_monitoringserver->getPekerjaLS();
			$data['RuangServer'] = $this->M_monitoringserver->getRuangServer();
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('MonitoringICT/MainMenu/MonitoringLogServer/V_InputMonitoring',$data);
			$this->load->view('V_Footer',$data);
		}

	public function save()
		{
			$ruang_server = $this->input->post('serverRoom');
			$pekerja 	  = $this->input->post('employeeLS');
			$tanggal 	  = $this->input->post('dateLS');
			$jamMasuk 	  = $this->input->post('timeInLS');
			$jamKeluar 	  = $this->input->post('timeOutLS');
			$keperluan 	  = $this->input->post('KeperluanLS');
			$pemberi_izin = $this->session->userid;
			$save_log   =   $this->M_monitoringserver->save_log($tanggal,$jamMasuk,$jamKeluar,$keperluan,$pemberi_izin,$ruang_server);
				$id_log =  $save_log[0]['log_id']; 
			foreach ($pekerja as $pkj) {
				$this->M_monitoringserver->save_petugas($pkj,$id_log);
			}
			redirect('MonitoringServer/Monitoring');
		}

	public function upload()
		{
			$config = array('upload_path' => './assets/logserver/',
                'upload_url' => base_url()  . './assets/logserver/',
                'allowed_types' => 'jpg|gif|png',
                'overwrite' => false,         
		    );

		    $this->load->library('upload', $config);

		    if ($this->upload->do_upload('file')) {
		        $data = $this->upload->data();
		        $array = array(
		            'filelink' => $config['upload_url'] . $data['file_name']
		        );            
		        echo stripslashes(json_encode($array));
		    } else {
		        echo json_encode(array('error' => $this->upload->display_errors('', '')));
		    }
		}

}