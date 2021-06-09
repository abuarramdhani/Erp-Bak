<?php
    class C_KirimLppb extends CI_Controller{
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
            $data['Menu'] = 'Kirim Lppb';
            $data['SubMenuOne'] = '';
            $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
            $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
            $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
            // $data['cek'] = $this->M_lppbqc->getDetail(313790);
            // print_r($data['cek']); exit();
    
            $this->load->view('V_Header',$data);
            $this->load->view('V_Sidemenu',$data);
            $this->load->view('MonitoringLppbQC/Menu/V_KirimLppb',$data);
            $this->load->view('V_Footer',$data);
        }

        public function getNoInduk(){
            $term = strtoupper($this->input->post('term'));
            $data = $this->M_lppbqc->getNoInduk($term);
            echo json_encode($data);
        }

        public function getNama(){
            $no_induk = $this->input->post('params');
            $data = $this->M_lppbqc->getNama($no_induk);
            echo json_encode($data);
        }

        public function getNoLppb(){
            $term = $this->input->post('term');
            $data = $this->M_lppbqc->getNoLppb($term);
            echo json_encode($data);
        }

        public function getDetail(){
            $params = $this->input->post('params');
            $data = $this->M_lppbqc->getDetail($params);
            echo json_encode($data);
        }

        public function Save(){
            $newNumber = $this->M_lppbqc->getIDKirim();

            // ======== header data ===========
            $no_induk = $this->input->post('no_induk');
            $nama = $this->input->post('nama');
            $hari_tgl = $this->input->post('hari_tgl');
            $jam = $this->input->post('jam');
            // ======== line data ===========
            $no = $this->input->post('no');
            $sh = $this->input->post('sh');
            $sl = $this->input->post('sl');
            $no_lppb = $this->input->post('no_lppb');
            $nama_vendor = $this->input->post('nama_vendor');
            $kode_komponen = $this->input->post('kode_komponen');
            $nama_komponen = $this->input->post('nama_komponen');
            $jumlah = $this->input->post('jumlah');
            $ok = $this->input->post('ok');
            $not_ok = $this->input->post('not_ok');
            $keterangan = $this->input->post('keterangan');

            foreach ($no as $key => $l) {
                $data = [
                    'ID_KIRIM' => $newNumber,
                    'NO_INDUK_PENGIRIM' =>  $no_induk,
                    'NAMA_PENGIRIM' => $nama,
                    'TANGGAL_KIRIM' => $hari_tgl,
                    'JAM' => $jam,
                    'LINE_NUM' => $no[$key],
                    'SHIPMENT_HEADER_ID' => $sh[$key],
                    'SHIPMENT_LINE_ID' => $sl[$key],
                    'NO_LPPB' => $no_lppb[$key],
                    'NAMA_VENDOR' => $nama_vendor[$key],
                    'KODE_KOMPONEN' => $kode_komponen[$key],
                    'NAMA_KOMPONEN' => $nama_komponen[$key],
                    'JUMLAH' => $jumlah[$key],
                    'OK' => $ok[$key],
                    'NOT_OK' => $not_ok[$key],
                    'KETERANGAN' => $keterangan[$key],
                    'STATUS' => 1
                ];
                $this->M_lppbqc->insert($data);
            }

            echo '<script type="text/javascript">
            function openWindows(){
                window.location.replace("'.base_url('MonitoringLppbQC/KirimLppb').'");
            }
            openWindows();
            </script>';
        }
        
    }
?>