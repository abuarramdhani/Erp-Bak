<?php
defined("BASEPATH") or die("This script cannot access directly");

set_time_limit(0);
ini_set('date.timezone', 'Asia/Jakarta');
/**
 * Ez debugging
 */
if (!function_exists('debug')) {
  function debug($arr)
  {
    echo "<pre>";
    print_r($arr);
    die;
  }
}

class C_DeklarasiSehat extends CI_Controller
{
  /**
   * user logged, created by session
   */
  protected $user_logged;
  /**
   * Select param item and type of param
   */
  // protected $param;

  public function __construct()
  {
    parent::__construct();

    $this->load->model('SystemAdministration/MainMenu/M_user');
    $this->load->model('MasterPekerja/Pekerja/DeklarasiSehat/M_deklarasisehat', 'ds');

    // load another class
    // $this->load->library('../controllers/MasterPekerja/Pekerja/PencarianPekerja/Data_Pencarian');

    // $this->table_head_default = $this->data_pencarian->table_head_default; // array
    // $this->table_head_jabatan = $this->data_pencarian->table_head_jabatan; // array
    // $this->param = $this->data_pencarian->param; // array

    $this->user_logged = @$this->session->user ?: null;
    $this->user_id = $this->session->userid ?: null;

    $this->sessionCheck();
  }

  private function sessionCheck()
  {
    return $this->user_logged or redirect(base_url('MasterPekerja'));
  }

  /**
   * Pages
   * @url MasterPekerja/DeklarasiSehat
   *
   */
  public function index()
  {
    $data['Menu'] = 'Pekerja';
    $data['SubMenuOne'] = 'Deklarasi Sehat';
    $data['SubMenuTwo'] = 'Deklarasi Sehat';

    $data['UserMenu'] = $this->M_user->getUserMenu($this->user_id, $this->session->responsibility_id);
    $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($this->user_id, $this->session->responsibility_id);
    $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($this->user_id, $this->session->responsibility_id);

		$data['pertanyaan'] = $this->ds->getPernyataanDeklarasi();

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('MasterPekerja/Pekerja/DeklarasiSehat/V_Index', $data);
    $this->load->view('MasterPekerja/Pekerja/DeklarasiSehat/V_Footer', $data);
    // $this->load->view('V_Footer', $data);
  }

	public function getSeksi($value='')
	{
		$term = strtoupper($this->input->post('term'));
		echo json_encode($this->ds->getSeksi($term));
	}

	public function employee($value='')
	{
		$term = strtoupper($this->input->post('term'));
		echo json_encode($this->ds->employee($term, $this->input->post('kodesie')));
	}

	public function getDataFiltered($value='')
	{
		if ($this->user_logged) {
			$data['master'] = $this->ds->masterdeklarasisehat($this->input->post());
			$data['pertanyaan'] = $this->ds->getPernyataanDeklarasi();
			// debug($data['master']);
			$this->load->view('MasterPekerja/Pekerja/DeklarasiSehat/V_Ajax_filter_data', $data);
		}
	}

}
