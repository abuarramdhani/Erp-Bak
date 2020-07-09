<?php
Defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 */
class C_infokirim extends CI_Controller
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
		$this->load->model('WasteManagementSeksi/MainMenu/M_info');

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
		redirect(site_url('WasteManagementSeksi/InfoKirimLimbah/Grafik'));
		$kodesie = substr($this->session->kodesie, 0,7);
		$user_id = $this->session->userid;

		$data['Title'] = 'Info Kirim Limbah';
		$data['Menu'] = 'Kirim Limbah';
		$data['SubMenuOne'] = 'Info Limbah';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['seksi'] = $this->M_info->getSeksi();
		$data['limbah'] = $this->M_info->getLimbah();
		$data['kodesie'] = $kodesie;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagementSeksi/InfoKirimLimbah/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Grafik(){
		$kodesie = substr($this->session->kodesie, 0,7);
		$user_id = $this->session->userid;

		$data['Title'] = 'Info Kirim Limbah';
		$data['Menu'] = 'Kirim Limbah';
		$data['SubMenuOne'] = 'Info Limbah';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['seksi'] = $this->M_info->getSeksi();
		$data['limbah'] = $this->M_info->getLimbah();
		
		if (!empty($_POST)) {
			$data['kodesie'] = $this->input->post('txtValueSek');
			$data['periode'] = $this->input->post('txtPeriodeInfo');
			$data['kategori'] = $this->input->post('txtPilihKat');
			$data['text'] = $this->input->post('txtHiddenValue');
			$periode = $this->input->post('txtPeriodeInfo');
			$periode = explode(" - ", $periode);
			if (isset($_POST['txtValueSek'])) {
				$data['value'] = $this->input->post('txtValueSek');
				$data['tabel'] = $this->M_info->chartLimbah($data['value'],$periode);
			}else{
				$data['value'] = $this->input->post('txtValueLim');
				$data['tabel'] = $this->M_info->chartSeksi($data['value'],$periode);
			}
		}else{
			$pd = $this->M_info->getPeriodeDefault();
			$data['periode'] = $pd[0]['awal']." - ".$pd[0]['akhir'];
			$data['kategori'] = "seksi";
			foreach ($data['seksi'] as $key) {
				if ($kodesie == $key['section_code']) {
					$data['text'] = $key['section_name'];
				}
			}
			
			$data['tabel'] = $this->M_info->chartLimbah($kodesie);
		}
		

		// print_r($_POST);
		// echo $data['value'].$data['text'].$data['kategori'];
		// exit;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('WasteManagementSeksi/InfoKirimLimbah/V_grafik',$data);
		$this->load->view('V_Footer',$data);
	}

	public function Chart(){

		$periode = $this->input->post('txtPeriodeInfo');
		$periode = explode(" - ", $periode);
		if (isset($_POST['txtValueSek'])) {
			$seksi = $this->input->post('txtValueSek');
			$data['chart'] = $this->M_info->chartLimbah($seksi,$periode);
		}else if(isset($_POST['txtValueLim'])){
			$limbah = $this->input->post('txtValueLim');
			$data['chart'] = $this->M_info->chartSeksi($limbah,$periode);
		}

		echo json_encode($data);
		
	}

}
?>