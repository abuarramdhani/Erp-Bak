<?php 
    class C_MonLppb extends CI_Controller{
        function __construct() {
            parent::__construct();
            date_default_timezone_set('Asia/Jakarta');
            if(!$this->session->userdata('logged_in')) {
                $this->load->helper('url');
                $this->session->set_userdata('last_page', current_url());
                $this->session->set_userdata('Responsbility', 'some_value');
            }
            $this->load->helper('form');
            $this->load->helper('url');
            $this->load->helper('html');
            $this->load->library('Log_Activity');
            $this->load->library('form_validation');
            $this->load->library('session');
            $this->load->library('upload');
            $this->load->model('M_Index');
            $this->load->model('SystemAdministration/MainMenu/M_user');
            $this->load->model('MonitoringLppbQC/M_lppbqc');
        }

        public function checkSession(){
            if ($this->session->is_logged) {
    
            }else{
                redirect();
            }
        }

        public function index(){
            $this->checkSession();
            $user_id = $this->session->userid;
            $no_induk = $this->session->userdata('user');
            $data['Menu'] = 'Monitoring Lppb';
            $data['SubMenuOne'] = '';
            $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
            $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
            $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
    
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('MonitoringLppbQC/Menu/V_MonLppb',$data);
            $this->load->view('V_Footer',$data);
        }

        public function getMon(){
            $param = $this->input->post('params');
            $data['getMonLppb'] = $this->M_lppbqc->getMon($param);
            // echo json_encode($data);
            $this->load->view('MonitoringLppbQC/Menu/V_TblMonLppb', $data);
        }
                
    }

?>