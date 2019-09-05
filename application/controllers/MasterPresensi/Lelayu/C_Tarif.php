<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 */
class C_Tarif extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->helper('form');
    $this->load->helper('url');
    $this->load->helper('html');

    $this->load->library('form_validation');
    $this->load->library('session');
    $this->load->library('encrypt');

    $this->load->model('SystemAdministration/MainMenu/M_user');
    $this->load->model('MasterPresensi/Lelayu/M_lelayu');
    ini_set('date.timezone', 'Asia/Jakarta');

    $this->checkSession();
  }

  public function checkSession()
  {
    if ($this->session->is_logged) {
      // code...
    }else {
      redirect('index');
    }
  }

  public function index()
  {
    $user = $this->session->username;
    $user_id = $this->session->userid;

    $data['Title'] = 'Setup Tarif Perusahaan';
    $data['Menu'] = 'Master Presensi';
    $data['SubMenuOne'] = '';
    $data['SubMenuTwo'] = '';

    $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

    $data['perusahaan'] = $this->M_lelayu->getDukaPerusahaan();

    $this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/Lelayu/V_tarif_perusahaan');
		$this->load->view('V_Footer',$data);
  }

  public function detail()
  {
    $data = $this->M_lelayu->getDukaPerusahaan();
    echo json_encode($data);
  }
}
?>
