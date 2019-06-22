<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_SparePart extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
      
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('session');
        $this->load->model('M_index');
        $this->load->model('WarehouseMPO/M_sparepart');
        $this->load->model('SystemAdministration/MainMenu/M_user');
      
        if($this->session->userdata('logged_in')!=TRUE) {
          $this->load->helper('url');
          $this->session->set_userdata('last_page', current_url());
          $this->session->set_userdata('Responsbility', 'some_value');
        }
    }
  
  public function checkSession(){
    if($this->session->is_logged){
      
    }else{
      redirect('');
    }
  }
  
  public function index()
  {
    $this->checkSession();
    $user_id = $this->session->userid;
    
    $data['Menu'] = 'Dashboard';
    $data['SubMenuOne'] = '';
    $data['SubMenuTwo'] = '';
    
    $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    $data['line'] = $this->M_sparepart->lineSpare();
    $data['show'] = $this->M_sparepart->allSpare();
    
    // echo "<pre>";
    // print_r($data);
    // exit();

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('WarehouseMPO/SparePart/V_SparePart',$data);
    $this->load->view('V_Footer',$data);
    
  }


  public function filter(){

    $this->checkSession();
    $user_id = $this->session->userid;
    
    $data['Menu'] = 'Dashboard';
    $data['SubMenuOne'] = '';
    $data['SubMenuTwo'] = '';
    
    $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    $tanggalSPBSawal = $this->input->post('tanggalSPBSawal');
    $tanggalSPBSakhir = $this->input->post('tanggalSPBSakhir');
    $tanggalKirimAwal = $this->input->post('tanggalKirimAwal');
    $tanggalKirimAkhir = $this->input->post('tanggalKirimAkhir');
    $noSPB = $this->input->post('no_SPB');
    
    // echo $tanggalSPBSakhir;
    // echo $tanggalSPBSawal;
    // exit();

    $data['show'] = $this->M_sparepart->filterSpare($tanggalSPBSawal,$tanggalSPBSakhir,$tanggalKirimAwal,$tanggalKirimAkhir,$noSPB);

    $data['line'] = $this->M_sparepart->lineSpare();
    
    // echo "<pre>";
    // print_r($data);
    // exit();

    $this->load->view('V_Header',$data);
    $this->load->view('V_Sidemenu',$data);
    $this->load->view('WarehouseMPO/SparePart/V_SparePart',$data);
    $this->load->view('V_Footer',$data);

  }
}
