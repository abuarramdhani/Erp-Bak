<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_MonitoringBon extends CI_Controller {

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

		$this->load->model('ItemManagement/User/M_monitoringbon');
		  
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
		$data['Menu'] = 'Monitoring Bon';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$user_kodesie = $this->M_monitoringbon->UserKodesie($user_id);
		foreach ($user_kodesie as $uk) {
			$kodesie = $uk['kodesie'];
		}
		$periode = date('Ym');
		$data['MonitoringBon'] = $this->M_monitoringbon->MonitoringBonList($kodesie, $periode);
		$data['KodeBon'] = $this->M_monitoringbon->KodeBon($kodesie, $periode);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ItemManagement/User/MonitoringBon/V_Index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function filterPeriode(){
		$user_id = $this->session->userid;
		$periode = $this->input->get('periode');
		$user_kodesie = $this->M_monitoringbon->UserKodesie($user_id);
		foreach ($user_kodesie as $uk) {
			$kodesie = $uk['kodesie'];
		}
		$data['MonitoringBon'] = $this->M_monitoringbon->MonitoringBonList($kodesie, $periode);
		$data['KodeBon'] = $this->M_monitoringbon->KodeBon($kodesie, $periode);

		$this->load->view('ItemManagement/User/MonitoringBon/V_Table',$data);
	}

	public function show_alert($message,$type,$redirect){
		$alert = '
				<div class="alert '.$type.' flyover flyover-top">
					<span style="float: right;cursor:pointer" onclick="$(this).parent().removeClass(\'in\')">
						<b style="color: #fff;">&times;</b>
					</span>
					'.$message.'
				</div>

				<script type="text/javascript">
					$(document).ready(function(){
						setTimeout(function(){
							$(".flyover-top").addClass("in");
						}, 10);
						setTimeout(function(){
							$(".flyover-top").removeClass("in");
						}, 5000);
					});
				</script>
				';
		$this->session->set_flashdata('alert',$alert);
		redirect($redirect);
	}

	public function create(){
		$this->checkSession();
		$user_id = $this->session->userid;
		$data['Menu'] = 'Setup Kebutuhan';
		
		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$user_kodesie = $this->M_monitoringbon->UserKodesie($user_id);
		foreach ($user_kodesie as $uk) {
			$kodesie = $uk['kodesie'];
			$kodesie_detail = $uk['seksi'];
		}

		$kode = '1';
		get_kode_blanko:
		$now = Date('Ymd');
		$kode_blanko = $now.str_pad($kode, 4, "0", STR_PAD_LEFT);
		$CheckBlanko = $this->M_monitoringbon->CheckBlanko($kode_blanko);
		if($CheckBlanko != 0){
			$kode++;
			GOTO get_kode_blanko;
		}

		$data['kode_blanko'] = $kode_blanko;
		$data['user_kodesie'] = $kodesie;
		$data['user_kodesie_detail'] = $kodesie_detail;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ItemManagement/User/MonitoringBon/V_Create',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getItem(){
		$periode = $this->input->get('periode');
		$term = $this->input->get('term');
		$user_id = $this->session->userid;
		$user_kodesie = $this->M_monitoringbon->UserKodesie($user_id);
		foreach ($user_kodesie as $uk) {
			$kodesie = $uk['kodesie'];
		}
		$itemOption = $this->M_monitoringbon->getItem($term,$kodesie,$periode);

		echo json_encode($itemOption);
	}

	public function getBonDetail(){
		$kode_barang = $this->input->get('kode_barang');
		$kodesie = $this->input->get('kodesie');
		$periode = $this->input->get('periode');
		$BatasBon = $this->M_monitoringbon->getBonItem($periode, $kodesie, $kode_barang);

		foreach ($BatasBon as $bb) {
			if ($bb['stok'] >= $bb['total_kebutuhan']) {
				echo $bb['total_kebutuhan'];
			}
			else{
				echo $bb['stok'];
			}
		}
	}

	public function insert(){
		$this->checkSession();
		$user_id = $this->session->userid;
		
		$kode_blanko = $this->input->post('txt_kode_blanko');
		$periode = $this->input->post('txt_periode');
		$kodesie = $this->input->post('txt_kodesie');

		$kode_barang = $this->input->post('txt_kode_barang');
		$jumlah = $this->input->post('txt_jumlah');

		$CheckBlanko = $this->M_monitoringbon->CheckBlanko($kode_blanko);
		if ($CheckBlanko == 0) {
			for ($i=0; $i < count($kode_barang); $i++) { 
				$insert = $this->M_monitoringbon->insert($kode_blanko, $periode, $kodesie, $kode_barang[$i], $jumlah[$i]);
				if ($insert == 1) {
					$update_stock = $this->M_monitoringbon->UpdateStock($periode, $kodesie, $kode_barang[$i], $jumlah[$i]);
					$update_stock_master = $this->M_monitoringbon->UpdateStockMaster($kode_barang[$i], $jumlah[$i]);
				}
				$result[] = $insert;

			}
			if (in_array(0, $result)) {
				$this->show_alert('Error Ocured when inserting Item', 'alert-danger', base_url('ItemManagement/User/MonitoringBon'));
			}
			else{
				$this->show_alert('Item Created Successfully', 'bg-primary', base_url('ItemManagement/User/MonitoringBon'));
			}
		}
		else{
			$this->show_alert('Kode Blanko Sudah ada', 'alert-danger', base_url('ItemManagement/User/MonitoringBon/create'));
		}
	}

	public function export(){
		$user_id = $this->session->userid;
		$periode = $this->input->post('txt_periode_bon');
		$user_kodesie = $this->M_monitoringbon->UserKodesie($user_id);
		foreach ($user_kodesie as $uk) {
			$kodesie = $uk['section_code'];
		}
		$data['MonitoringBon'] = $this->M_monitoringbon->MonitoringBonList($kodesie, $periode);
		$data['KodeBon'] = $this->M_monitoringbon->KodeBon($kodesie, $periode);

		$this->load->library('pdf');
		$pdf = $this->pdf->load();

		$pdf = new mPDF('', 'A4-L', 0, '', 5, 5, 10, 12);

		$filename = 'Monitoring-Bon-'.time();

		$stylesheet = file_get_contents('assets/plugins/bootstrap/3.3.6/css/bootstrap.css');

		$html = $this->load->view('ItemManagement/User/MonitoringBon/V_Table_Export', $data, true);

		$pdf->setFooter('Halaman {PAGENO} dari {nbpg}');
		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html,2);
		$pdf->Output($filename, 'I');
	}
}
