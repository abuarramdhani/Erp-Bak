<?php
Defined('BASEPATH') or exit('No direct Script access allowed');
/**
 *
 */
class C_EditTempatMakan extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('form_validation');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('CateringManagement/Extra/M_edittempatmakan');
		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('');
		}
	}

	public function index(){
		$user_id = $this->session->userid;
		$kodesie = $this->session->kodesie;

		$data['Title'] = 'Edit Tempat Makan';
		$data['Header'] = 'Edit Tempat Makan';
		$data['Menu'] = 'Extra';
		$data['SubMenuOne'] = 'Edit Tempat Makan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);


		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Extra/EditTempatMakan/V_index.php',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getSeksi(){
		$level = $this->input->get('level');
		$kodesie = $this->input->get('kodesie');
		$key = $this->input->get('term');

		$data = $this->M_edittempatmakan->getSeksiByKeyKodesieLevel($key,$kodesie,$level);
		echo json_encode($data);
	}

	public function getTempatMakan(){
		$key = $this->input->get('term');
		$stat = $this->input->get('stat');

		$data = $this->M_edittempatmakan->getTempatMakanByKeyStat($key,$stat);
		echo json_encode($data);
	}

	public function getLokasiKerja(){
		$key = $this->input->get('term');

		$data = $this->M_edittempatmakan->getLokasiKerjaByKey($key);
		echo json_encode($data);
	}

	public function getKodeInduk(){
		$key = $this->input->get('term');

		$data = $this->M_edittempatmakan->getKodeIndukByKey($key);
		echo json_encode($data);
	}

	public function getPekerja(){
		$kodesie = $this->input->get('kodesie');
		if (substr($kodesie, -2) == "00") {
			$kodesie = substr($kodesie, 0, strlen($kodesie) - 2);
		}elseif ($kodesie == '-') {
			$kodesie = "";
		}
		
		$data = $this->M_edittempatmakan->getPekerjaByKodesie($kodesie);
		echo json_encode($data);
	}

	public function simpanPerPekerja(){
		$noind = $this->input->post('noind');
		$tempat_makan = $this->input->post('tempat_makan');
		$kodesie = $this->input->post('kodesie');
		$tempat_makan_lama = $this->input->post('tempat_makan_lama');

		$this->M_edittempatmakan->updateTempatMakanByNoind($tempat_makan,$noind);

		$insert = array(
			'noind' => $noind,
			'tempat_makan_lama' => $tempat_makan_lama,
			'tempat_makan_baru' => $tempat_makan,
			'created_by' => $this->session->user
		);

		$this->M_edittempatmakan->insertEditTempatMakan($insert);

		if (substr($kodesie, -2) == "00") {
			$kodesie = substr($kodesie, 0, strlen($kodesie) - 2);
		}elseif ($kodesie == '-') {
			$kodesie = "";
		}


		$data = $this->M_edittempatmakan->getPekerjaByKodesie($kodesie);
		echo json_encode($data);
	}
}
?>
