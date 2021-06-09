<?php
defined('BASEPATH') OR die('No direct script access allowed');

class C_Index extends CI_Controller {
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_Index', 'index');  
    $this->load->model('SystemAdministration/MainMenu/M_user', 'user');
    $this->load->library('../controllers/PerhitunganHargaSparepart/_modules/C_UserData', null, 'user_data');
    $this->user_data->checkLoginSession();
  }

  public function index()
  {    
		$view_data = $this->user_data->getUserMenu();
    $view_data->Menu = '';
		$view_data->SubMenuOne = '';

    $this->load->view('V_Header', $view_data);
    $this->load->view('V_Sidemenu', $view_data);
    $this->load->view('PerhitunganHargaSparepart/V_Index', $view_data);
    $this->load->view('V_Footer', $view_data);
  }
}

