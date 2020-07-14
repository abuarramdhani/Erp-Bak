<?php 

Defined('BASEPATH') or exit('No direct script access allowed');

class C_SetupQuestioner extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('file');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('PNBPAdministrator/M_setupquestioner');

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
		$user = $this->session->user;

		$data['Title'] = 'Setup Questioner';
		$data['Menu'] = 'Setup Questioner';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['periode'] = $this->M_setupquestioner->getPeriode();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PNBPAdministrator/SetupQuestioner/V_index.php',$data);
		$this->load->view('V_Footer',$data);

	}

	public function Create(){
		$periode = $this->input->post('txtPeriodeQuestioner');
		$prd = explode(" - ", $periode);
		$cek = $this->M_setupquestioner->cekPeriode($prd['0'],$prd['1']);
		if ($cek == 0) {
			$arrayData = array(
				'periode_awal' 	=> $prd['0'], 
				'periode_akhir' => $prd['1'], 
				'created_by' 	=> $this->session->user
			);
			$this->M_setupquestioner->insertPeriode($arrayData);
		}
		

		redirect(site_url('PNBP/SetupQuestioner'));
	}

	public function Delete($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$this->M_setupquestioner->deletePeriode($plaintext_string);

		redirect(site_url('PNBP/SetupQuestioner'));
	}

	public function Edit($id){
		$user_id = $this->session->userid;
		$user = $this->session->user;
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$data['Title'] = 'Setup Questioner';
		$data['Menu'] = 'Setup Questioner';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['urutan'] = $this->M_setupquestioner->getUrutanById($plaintext_string);
		$data['encrypt_link'] = $id;
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('PNBPAdministrator/SetupQuestioner/V_edit',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Save($id){
		$plaintext_string = str_replace(array('-', '_', '~'), array('+', '/', '='), $id);
		$plaintext_string = $this->encrypt->decode($plaintext_string);

		$urutan = $this->input->post('txtInput');
		// echo "<pre>";
		// print_r($urutan);exit();

		foreach ($urutan as $key) {
			if ($key['urutan'] !== "") {
				$cek = $this->M_setupquestioner->getUrutanByPeriodeAndNoUrut($key['id_pernyataan'],$key['id_periode']);
				if ($cek > 0) {
					$this->M_setupquestioner->updateUrutan($key['urutan'],$key['id_pernyataan'],$key['id_periode']);
				}else{
					$array = array(
						'no_urut' => $key['urutan'],
						'id_pernyataan' => $key['id_pernyataan'],
						'id_periode' => $key['id_periode']
					);
					$this->M_setupquestioner->insertUrutan($array);
				}
			}
		}

		redirect(site_url('PNBP/SetupQuestioner'));
	}
}

?>