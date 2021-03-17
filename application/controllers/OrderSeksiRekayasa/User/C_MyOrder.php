<?php defined('BASEPATH')OR die('No direct script access allowed');
class C_MyOrder extends CI_Controller {
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
        $this->load->model('OrderSeksiRekayasa/M_submitorder');
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
		$data['Menu'] = 'My Order';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		// $data['myorder'] = $this->M_submitorder->getMyOrder($no_induk, FALSE);
		$data['All_Order'] = $this->M_submitorder->getMyOrder($no_induk, FALSE);
		$data['Upload_Otorisasi'] = $this->M_submitorder->getMyOrder($no_induk, 0);
		$data['Menunggu_Diterima'] = $this->M_submitorder->getMyOrder($no_induk, 1);
		$data['Order_Diterima'] = $this->M_submitorder->getMyOrder($no_induk, 2);

		// print_r($data['Order_Diterima']); exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('OrderSeksiRekayasa/User/V_MyOrder',$data);
		$this->load->view('V_Footer',$data);

	}

	public function otorisasi($id){
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'My Order';
		$data['SubMenuOne'] = '';
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['myorder'] = $this->M_submitorder->getOrder($id);
		// echo "<pre>"; print_r($data['order']); die;

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
		$this->load->view('OrderSeksiRekayasa/User/V_Otorisasi', $data);
		$this->load->view('V_Footer',$data);
	}

	public function saveotorisasi(){
		// echo "<pre>";
        // print_r($_FILES);
		// die;
		$no_order = $this->input->post('NoOrder');
		$nama_alat_mesin = $this->input->post('NamaAlatMesin');
		$status = 1;
		// echo "<pre>";print_r($status);die;
		if (!empty($_FILES['FileOtorisasi']['name'])) {
            // upload area
            if (!is_dir('./assets/upload/OrderSeksiRekayasa')) {
                mkdir('./assets/upload/OrderSeksiRekayasa/Otorisasi', 0777, true);
                chmod('./assets/upload/OrderSeksiRekayasa/Otorisasi', 0777);
			}
			
			$config['upload_path'] = './assets/upload/OrderSeksiRekayasa/Otorisasi';
            $config['allowed_types'] = '*';
			$config['overwrite'] 	= true;
			$name = str_replace(' ', '_', $nama_alat_mesin);
			$dname = explode(".", $_FILES['FileOtorisasi']['name']);
			$ext = end($dname);
            $config['file_name'] = 'Otorisasi_'.$name.'.'.$ext;
            $config['max_size'] = 0;
            // $config['max_width'] = 1024;
            // $config['max_height'] = 768;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (! $this->upload->do_upload('FileOtorisasi')) {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
            } else {
                $data = array('upload_data' => $this->upload->data());
            }
			$path_otorisasi = $config['upload_path'].'/'.$config['file_name'];
			$ext_otorisasi = $ext;
			$filename_otorisasi = $config['file_name'];
		}
		else {
			$path_otorisasi = null;
			$ext_otorisasi = null;
			$filename_otorisasi = null;
		}
		// echo "<pre>";print_r($path_otorisasi);die;
		$save = [
			'id_order' => $no_order,
			'status' => $status,
			'dokumen_otorisasi' => $path_otorisasi,
			'ext_otorisasi' => $ext_otorisasi,
			'filename_otorisasi' => $filename_otorisasi,
		];

		$this->M_submitorder->upOtorisasi($save);
		redirect('OrderSeksiRekayasa/MyOrder');
	}
    
}
?>