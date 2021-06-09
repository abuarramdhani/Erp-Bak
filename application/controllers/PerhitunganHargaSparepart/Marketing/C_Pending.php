<?php
defined('BASEPATH') or die('No direct script access allowed');

class C_Pending extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_Index', 'index');
    $this->load->model('SystemAdministration/MainMenu/M_user', 'user');
    $this->load->library('../controllers/PerhitunganHargaSparepart/_modules/C_UserData', null, 'user_data');
    $this->load->model('PerhitunganHargaSparepart/M_calculate_spt', 'calculate_spt');
    $this->user_data->checkLoginSession();
  }

  public function index()
  {
    $view_data = $this->user_data->getUserMenu();
    $view_data->Menu = 'Daftar Pending';
    $view_data->SubMenuOne = '';

    $view_data->pending_rows = $this->calculate_spt->selectPending();

    // echo "<pre>";
    // print_r($view_data);
    // exit();

    $this->load->view('V_Header', $view_data);
    $this->load->view('V_Sidemenu', $view_data);
    $this->load->view('PerhitunganHargaSparepart/Marketing/V_Pending', $view_data);
    $this->load->view('V_Footer', $view_data);
  }
}
