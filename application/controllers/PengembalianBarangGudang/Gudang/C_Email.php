<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Email extends CI_Controller {
    public function __construct(){
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('html');
        $this->load->library('session');
		$this->load->library('form_validation');
        $this->load->library('PHPMailerAutoload');
        
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PengembalianBarangGudang/M_pengembalianbrg');
        
        $this->checkSession();
    }

    public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect('');
		}
    }

    public function index(){
		$user = $this->session->username;
        $user_id = $this->session->userid;

        $data['Title'] = 'Setting Email Pengembalian Barang';
        $data['Menu'] = 'Setting Email';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

        $data['email'] = $this->M_pengembalianbrg->getEmail();

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PengembalianBarangGudang/V_Email',$data);
        $this->load->view('V_Footer',$data);
    }

    public function getEmailPic(){
        $term = $this->input->post('term');
        $data = $this->M_pengembalianbrg->getEmailPic($term);
        if (!empty($data)) {
            echo json_encode($data);
        }else {
            echo json_encode(0);
        }
    }

    public function SaveEmail(){
        $pic    = $this->input->post('pic');
        $email  = $this->input->post('email');
        $ket    = $this->input->post('ket');
            
        $this->M_pengembalianbrg->SaveEmail($pic, $email, $ket);
    }

    public function DeleteEmail(){
        $pic    = $this->input->post('pic');
        $email  = $this->input->post('email');
        $ket    = $this->input->post('ket');

        $this->M_pengembalianbrg->DeleteEmail($pic, $email, $ket);
    }
}

?>