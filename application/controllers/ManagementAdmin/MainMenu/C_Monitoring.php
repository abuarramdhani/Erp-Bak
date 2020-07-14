<?php
Defined('BASEPATH') or exit('No Direct Sekrip Akses Allowed');
/**
 * 
 */
class C_Monitoring extends CI_Controller
{
	
	function __construct()
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
		$this->load->model('ManagementAdmin/M_monitoring');

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

		$data['Title'] = 'Management Admin';
		$data['Menu'] = 'Laporan';
		$data['SubMenuOne'] = 'Monitoring';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->form_validation->set_rules('required');	
		if($this->form_validation->run() === TRUE){
			// print_r($_POST);exit();
			$periode = $this->input->post('txtPeriodeMonitoring');
			$tanggal = explode(" - ", $periode);
			$tgl = "";
			foreach ($tanggal as $key) {
				if ($tgl == "") {
					$tgl = " and cast(start_time as date) between '".$key."'";
				}else{
					$tgl = $tgl." and '".$key."'";
				}
			}
			$pekerja = $this->input->post('txtPekerjaMonitoring');
			$id_pkj = "";
			if (!empty($pekerja)) {
				foreach ($pekerja as $key) {
					if ($id_pkj == "") {
						$id_pkj = "'".$key."'";
					}else{
						$id_pkj = $id_pkj.",'".$key."'";
					}
				}
				$id_pkj = " and id_pekerja in (".$id_pkj.") ";
			}
			$pekerjaan = $this->input->post('selectPekerjaanMonitoring');
			$id_pkjn = "";
			if (!empty($pekerjaan)) {
				foreach ($pekerjaan as $key) {
					if ($id_pkjn == "") {
						$id_pkjn = "'".$key."'";
					}else{
						$id_pkjn = $id_pkjn.",'".$key."'";
					}
				}
				$id_pkjn = " and pekerjaan in (select pekerjaan from ma.ma_target where id_target in (".$id_pkjn.")) ";
			}
			$data['table'] = $this->M_monitoring->getData($tgl,$id_pkj,$id_pkjn);
		}

		$data['pekerjaan'] = $this->M_monitoring->getPekerjaan();
		
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ManagementAdmin/Laporan/V_monitoring',$data);
		$this->load->view('V_Footer',$data);
	}
}
?>