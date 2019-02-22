<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_MonitoringKebutuhan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('M_Index');
		$this->load->model('SystemAdministration/MainMenu/M_user');

		$this->load->model('ItemManagement/Admin/Hitung/M_monitoringkebutuhan');
		  
		if($this->session->userdata('logged_in')!=TRUE) {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			$this->session->set_userdata('Responsbility', 'some_value');
		}
	}

	public function checkSession(){
		if($this->session->is_logged){
			
		}else{
			redirect();
		}
	}

	public function index()
	{
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Hitung';
		$data['SubMenuOne'] = 'Monitoring Kebutuhan';
		$data['SubMenuTwo'] = '';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['MonitoringKebutuhan'] = $this->M_monitoringkebutuhan->MonitoringKebutuhan();
		$data['PeriodeKebutuhan'] = $this->M_monitoringkebutuhan->PeriodeMonitoring();
		$data['BarangKebutuhan'] = $this->M_monitoringkebutuhan->BarangMonitoring();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ItemManagement/Admin/Hitung/MonitoringKebutuhan/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function detail(){
		$periode = $this->input->post('periode');
		$kodesie = $this->input->post('kd_sie');

		$data['GetPekerjaan'] = $this->M_monitoringkebutuhan->GetPekerjaan($periode,$kodesie);
		$data['GetDetailBarang'] = $this->M_monitoringkebutuhan->GetDetailBarang($periode,$kodesie);

		$this->load->view('ItemManagement/Admin/Hitung/MonitoringKebutuhan/V_Detail',$data);
	}

	public function export(){
		$data['MonitoringKebutuhan'] = $this->M_monitoringkebutuhan->MonitoringKebutuhan();
		$data['PeriodeKebutuhan'] = $this->M_monitoringkebutuhan->PeriodeMonitoring();
		$data['BarangKebutuhan'] = $this->M_monitoringkebutuhan->BarangMonitoring();

		$this->load->library('pdf');
		$pdf = $this->pdf->load();

		$pdf = new mPDF('', 'A4-L', 0, '', 5, 5, 10, 12);

		$filename = 'Monitoring-Kebutuhan-'.time();

		$stylesheet = file_get_contents('assets/plugins/bootstrap/3.3.6/css/bootstrap.css');

		$html = $this->load->view('ItemManagement/Admin/Hitung/MonitoringKebutuhan/V_Table_Export', $data, true);

		$pdf->setFooter('Halaman {PAGENO} dari {nbpg}');
		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html,2);
		$pdf->Output($filename, 'I');
	}

}
