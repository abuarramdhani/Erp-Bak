<?php 
    class C_TerimaLppb extends CI_Controller{
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
            $data['Menu'] = 'Terima Lppb';
            $data['SubMenuOne'] = '';
            $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
            $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
            $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
    
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('MonitoringLppbQC/Menu/V_TerimaLppb',$data);
            $this->load->view('V_Footer',$data);
        }

        public function getTerima(){
            $data['getTerima'] = $this->M_lppbqc->getTerima();
            // print_r($data['getTerima']); exit();
            $this->load->view('MonitoringLppbQC/Menu/V_TblTerimaLppb', $data);
        }

        public function sdhTerima(){
            $id_kirim = $this->input->post('id_kirim');
            $line_num = $this->input->post('line_num');
            $status = $this->input->post('status');

            if (!$this->input->is_ajax_request()) {
                echo "Akses Terlarang !!";
            } else {
                $update = $this->M_lppbqc->sdhTerima($id_kirim, $line_num, $status);
                
                echo json_encode(1);
            }
        }

    }
?>