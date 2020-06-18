<?php defined('BASEPATH') OR exit('No direct script access allowed');
class C_Quesioner extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('Excel');
        $this->load->model('M_Index');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('MasterPekerja/Quesioner/M_quesioner');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
        }
        
        if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
         }
        if($this->session->is_logged == FALSE){
            redirect();
        }
        
    }

    public function ListDataResikoPribadi()
    {
        $user_id = $this->session->userid;
        
        $data['Menu'] = 'Quesioner';
		$data['SubMenuOne'] = 'Data Resiko Pribadi';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
        
        $data['data_resiko_pribadi'] = $this->M_quesioner->getAllData();
        // echo '<pre>';
        // print_r($dat);
        // exit;

        $this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Quesioner/V_DataResikoPribadi',$data);
        $this->load->view('V_Footer',$data);
    }

    public function RekapKondisiKesehatan()
    {
        $user_id = $this->session->userid;

        $data['Menu'] = 'Quesioner';
		$data['SubMenuOne'] = 'Rekap Kondisi Kesehatan';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['rekap_kondisi_kesehatan'] = $this->M_quesioner->getAllDataRekapKondisiKesehatan();

        $this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Quesioner/V_RekapKondisiKesehatan',$data);
        $this->load->view('V_Footer',$data);
    }

    public function PekerjaBelumInput(){
        $user_id = $this->session->userid;

        $data['Title'] = 'Pekerja Belum Input';
        $data['Menu'] = 'Quesioner';
        $data['SubMenuOne'] = 'Pekerja Belum Input';
        $data['SubMenuTwo'] = '';
        
        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['data'] = $this->M_quesioner->getAllDataPekerjaBelumInput();

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('MasterPekerja/Quesioner/V_PekerjaBelumInput',$data);
        $this->load->view('V_Footer',$data);
    }

    public function PekerjaTidakHadirBelumInput(){
        $user_id = $this->session->userid;

        $data['Title'] = 'Pekerja Tidak Hadir Belum Input';
        $data['Menu'] = 'Quesioner';
        $data['SubMenuOne'] = 'Pekerja Tidak Hadir Belum Input';
        $data['SubMenuTwo'] = '';
        
        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['data'] = $this->M_quesioner->getAllDataPekerjaTidakHadirBelumInput();

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('MasterPekerja/Quesioner/V_PekerjaTidakHadir',$data);
        $this->load->view('V_Footer',$data);
    }
}