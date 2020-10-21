<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class C_Ovpekerja extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('form_validation');
		$this->load->library('Log_Activity');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('ciqrcode');
		$this->load->library('general');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('er/RekapTIMS/M_overtime');
		$this->load->model('er/RekapTIMS/M_rekapmssql');
		$this->load->model('OvertimePekerja/M_ovpekerja');
		$this->checkSession();
		date_default_timezone_set("Asia/Jakarta");
	}

	public function checkSession()
	{
		if($this->session->is_logged){
		} else {
			redirect('');
		}
	}

	public function index()
	{
		$data  = $this->general->loadHeaderandSidemenu('Overtime Pekerja', 'Overtime Pekerja', '', '', '');

        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('OvertimePekerja/V_Index',$data);
        $this->load->view('V_Footer',$data);
	}

	public function rekap()
	{
		$data  = $this->general->loadHeaderandSidemenu('Overtime Pekerja', 'Overtime Pekerja', 'Rekap', '', '');
		$user = $this->session->user;
		$data['pkj'] = $this->M_ovpekerja->getPekerjanSeksi($user);
		// print_r($data['pkj']);exit();

		$data['status'] = $this->M_rekapmssql->statusKerja();
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('OvertimePekerja/V_Rekap',$data);
        $this->load->view('V_Footer',$data);
	}

	public function cari_ovp()
	{
		$user_id = $this->session->userid;
		$periode = $this->input->post('txtTanggalRekap');
		$dept = $this->input->post('cmbDepartemen');
		$bid = $this->input->post('cmbBidang');
		$unit = $this->input->post('cmbUnit');
		$seksi = $this->input->post('cmbSeksi');
		$hubker = $this->input->post('statushubker');
		$all = $this->input->post('statusAll');
		$detail = $this->input->post('detail');

		$date = explode(' - ', $periode);
		$tgl1 = date('M',strtotime($date[0]));
		$tgl2 = date('M Y',strtotime($date[1]));
		$data['periodeM'] = $tgl1." - ".$tgl2;

		$hub = "";
		$exhub = "";
		if (isset($all) and !empty($all) and $all == '1') {
			$shk = $this->M_rekapmssql->statusKerja();
			foreach ($shk as $key) {
				if ($hub == "") {
					$hub = "'".$key['fs_noind']."'";
					$exhub = $key['fs_noind'];
				}else{
					$hub .= ",'".$key['fs_noind']."'";
					$exhub .= "-".$key['fs_noind'];
				}
			}
		}else{
			foreach ($hubker as $key) {
				if ($hub == "") {
					$hub = "'".$key."'";
					$exhub = $key;
				}else{
					$hub .= ",'".$key."'";
					$exhub .= "-".$key;
				}
			}
		}

		$kdsie = $dept;
		if (isset($bid) and !empty($bid) and substr($bid, -2) !== '00') {
			$kdsie = $bid;
		}

		if (isset($unit) and !empty($unit) and substr($unit, -2) !== '00') {
			$kdsie = $unit;
		}

		if (isset($seksi) and !empty($seksi) and substr($seksi, -2) !== '00') {
			$kdsie = $seksi;
		}
			// echo $kdsie;exit();
		$data['detail'] = $detail;
		$prd = explode(' - ', $periode);
		if ($kdsie == '0') {
			$dataOvertime = $this->M_overtime->getData($prd[0],$prd[1],$hub,$kdsie=false,$detail);
		}else{
			$dataOvertime = $this->M_overtime->getData($prd[0],$prd[1],$hub,$kdsie,$detail);
		}
		// echo "<pre>";
		// print_r($dataOvertime);
		$data['table'] = $dataOvertime;
		$data['export'] = $kdsie.'_'.$exhub.'_'.$periode.'_'.$detail;
		$html = $this->load->view('OvertimePekerja/V_Table',$data);
		echo json_encode($html);
	}
}