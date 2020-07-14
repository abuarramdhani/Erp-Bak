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
		$data['Menu'] = 'Extra';
		$data['SubMenuOne'] = 'Edit Tempat Makan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Seksi'] = $this->M_edittempatmakan->getSekNamaByKodesie($kodesie);
		$data['Kode'] = $this->M_edittempatmakan->getKodeSeksi();
		$data['data'] = $this->M_edittempatmakan->getShow();
		$data['Makan'] = $this->M_edittempatmakan->getMakan();

		// echo "<pre>";
		// print_r($data['data']);
		// exit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Extra/EditTempatMakan/V_index.php',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getKirimID()
	{
		$kodesie=$this->input->POST('seksi');
		$data = $this->M_edittempatmakan->getID($kodesie);

		$array = array(
							'dept' => $data[0]['dept'],
			 				'bidang' => $data[0]['bidang'],
			 				'unit' => $data[0]['unit'],
			 				'seksi' => $data[0]['seksi'],
			 				'pekerjaan' => $data[0]['pekerjaan'],
			 				'tempat_makan' => $data[0]['tempat_makan'],
		);
		echo json_encode($array);
	}

	public function edit($noind){
		$user_id = $this->session->userid;
		$kodesie = $this->session->kodesie;

		$data['Title'] = 'Edit Tempat Makan';
		$data['Menu'] = 'Extra';
		$data['SubMenuOne'] = 'Edit Tempat Makan';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['Seksi'] = $this->M_edittempatmakan->getSekNamaByKodesie($kodesie);
		$data['Kode'] = $this->M_edittempatmakan->getKodeSeksi();
		$data['data'] = $this->M_edittempatmakan->getShow();
		$data['edit'] = $this->M_edittempatmakan->edit();
		$data['tempat'] = $this->M_edittempatmakan->getTempat();
		$data['value'] = $this->M_edittempatmakan->getEdit($noind);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('CateringManagement/Extra/EditTempatMakan/V_edit.php',$data);
		$this->load->view('V_Footer',$data);
	}

	public function update()
	{
		$noind = $this->input->POST('txtNoind');
		$makan = $this->input->POST('txtTmp1');
		$makan1 = $this->input->POST('txtTmp2');

		$update = $this->M_edittempatmakan->update($noind,$makan,$makan1);

		redirect(site_url('CateringManagement/Extra/EditTempatMakan/'));
	}

	public function updateAll()
	{
		$user = $this->session->user;
		$kodesie =$this->input->POST('kodesie');
		$makan1 = $this->input->post('makan1');
		$makan2 = $this->input->post('makan2');
		$updateAll = $this->M_edittempatmakan->updateAll($makan1,$makan2,$kodesie);
		$updatelog = $this->M_edittempatmakan->insertLog($user,$makan1,$makan2,$kodesie);
	}

	public function updateStaff()
	{
		$user = $this->session->user;
		$kodesie =$this->input->POST('kodesie');
		$makan1 = $this->input->post('makan1');
		$makan2 = $this->input->post('makan2');
		$updateStaff = $this->M_edittempatmakan->updateStaff($makan1,$makan2,$kodesie);
		$updatelog = $this->M_edittempatmakan->insertLoga($user,$makan1,$makan2,$kodesie);
	}

	public function updateNonStaff()
	{
		$user = $this->session->user;
		$kodesie =$this->input->POST('kodesie');
		$makan1 = $this->input->post('makan1');
		$makan2 = $this->input->post('makan2');
		$updateNonStaff = $this->M_edittempatmakan->updateNonStaff($makan1,$makan2,$kodesie);
		$updatelog = $this->M_edittempatmakan->insertLogb($user,$makan1,$makan2,$kodesie);
	}
}
?>
