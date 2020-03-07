<?php
Defined('BASEPATH') or exit('No Direct Sekrip Akses Allowed');
set_time_limit(0);
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
		$this->load->model('ADMCabang/M_presensibulanan');
		$this->load->model('ADMCabang/M_monitoringpresensi');
		$this->checkSession();
	}

	public function checkSession()
	{
		if($this->session->is_logged){

		} else {
			redirect('index');
		}
	}

	public function index(){
		
		$user_id = $this->session->userid;
		$kodesie = $this->session->kodesie;

		$data['Title'] = 'Monitoring Presensi';
		$data['Menu'] = 'Lihat Monitoring Presensi';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['seksi'] = $this->M_presensibulanan->getSeksiByKodesie($kodesie);
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMCabang/PresensiBulanan/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function MonTahunan(){
		$user_id = $this->session->userid;
		$kodesie = $this->session->kodesie;

		if(!$this->M_monitoringpresensi->getAksesAtasanProduksi($this->session->user)){
			echo "Prohibited";exit();
		}

		$data['Title'] = 'Monitoring Presensi Tahunan';
		$data['Menu'] = 'Lihat Monitoring Presensi Tahunan';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['seksi'] = $this->M_presensibulanan->getSeksiByKodesie($kodesie);

		$data['status'] = $this->M_monitoringpresensi->statusKerja();
		$data['unit'] = $this->M_monitoringpresensi->ambilUnit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMCabang/Monitoring/V_MonTahunan',$data);
		$this->load->view('V_Footer',$data);
	}

	function getMonTahunan(){
		$kodesie = $this->session->kodesie;
		$periode 			= trim($this->input->post('periode'));
		$statusKerja = $this->input->post('statusKerja[]');
		$unitKerja = $this->input->post('unitKerja');
		$seksiKerja = $this->input->post('seksiKerja');

		if(!empty($statusKerja)){
			if(is_array($statusKerja)){

				if(!in_array("", $statusKerja)){
					$statusKerja = array_map(function($val){
						return "'$val'";
					}, $statusKerja);
					$statusKerja = implode(",", $statusKerja);

					$q_status = "AND left(a.noind,1) IN ($statusKerja) ";
				}else{
					$q_status = "";
				}
			}
		}else{
			$q_status = "";
		}

		if(!empty($unitKerja)){
			$q_unit = "AND left(a.kodesie,5) = '$unitKerja'";
		}else{
			$q_unit = "";
		}

		if(!empty($seksiKerja)){
			$seksiKerja = explode(' - ', $seksiKerja)[0];
			$q_seksi = "AND left(a.kodesie,7) = '$seksiKerja' ";
		}else{
			$q_seksi = "";
		}

		$dataTabelPerTahun = [];
		$dataTotalTahunan = [];
		$dataTotalPerTahun = [];
		for($i=1;$i<=12;$i++){
			$dataTotalTahunan[] = $this->M_monitoringpresensi->getDataAbsensiTahunan($periode.'-'.str_pad($i, 2, '0', STR_PAD_LEFT),$kodesie,$q_status,$q_unit,$q_seksi);
		}

		for($i=1;$i<=12;$i++){
			$dataTotalPerTahun[] = $this->M_monitoringpresensi->getDataAbsensiTahunanPerPeriode($periode.'-'.str_pad($i, 2, '0', STR_PAD_LEFT),$kodesie,$q_status,$q_unit,$q_seksi);
		}

			$dataTabelPerTahun = $this->M_monitoringpresensi->getDataPerTahun($periode,$kodesie,$q_status,$q_unit,$q_seksi);

		$periodeBulan = [];

		for($i = 1;$i <=12;$i++){
			array_push($periodeBulan, date('F Y',strtotime($periode.'-'.str_pad($i, 2, '0', STR_PAD_LEFT))));
		}
		// echo "<pre>";print_r($dataTabelPerTahun);exit();

		$persentasePerPeriode = array();
		$kabehData = array();
		$seksiPerTanggal = array();
		$kodesieArr = array();
		$index = 0;

		for ($i=1; $i<=12; $i++) { 
			foreach ($dataTotalTahunan[$index] as $key => $dtTtl) {
				foreach ($dataTotalPerTahun[$index] as $key2 => $dtThn) {
					if($key == $key2){
						if($dtTtl['sum'] == 0 or $dtThn['sum'] == 0){
							$persentasePerPeriode[$dtTtl['seksi']][] = 0;
							$kabehData[] = 0;
						}else{							
							$persentasePerPeriode[$dtTtl['seksi']][] = intval($dtThn['sum']) / intval($dtTtl['sum']) * 100;
							$kabehData[] = intval($dtThn['sum']) / intval($dtTtl['sum']) * 100;
						}

						$seksiPerTanggal[$index][] = $dtTtl['seksi'];
						$kodesieArr[$index][] = $dtTtl['kodesie'];
					}
				}
			}
			$index++;

			$persentasePerPeriode['TARGET'][] = 95;
		}
		$lastKey = key(array_slice($kabehData, -1, 1, true));
		$kabehData[$lastKey+1] = 95;
		
		$data['dataTabelPerTahun'] = $dataTabelPerTahun;
		$data['kabehData'] = $kabehData;
		$data['kodesieArr'] = $kodesieArr;
		$data['seksiPerTanggal'] = $seksiPerTanggal;
		$data['dataTotalTahunan'] = $dataTotalTahunan;
		$data['dataTotalPerTahun'] = $dataTotalPerTahun;
		$data['data'] = $persentasePerPeriode;
		$data['periodeBulan'] = $periodeBulan;


		print_r(json_encode($data));
	}

	public function MonBulanan(){
		$user_id = $this->session->userid;
		$kodesie = $this->session->kodesie;
		if(!$this->M_monitoringpresensi->getAksesAtasanProduksi($this->session->user)){
			echo "Prohibited";exit();
		}

		$data['Title'] = 'Monitoring Presensi Bulanan';
		$data['Menu'] = 'Lihat Monitoring Presensi Bulanan';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['seksi'] = $this->M_presensibulanan->getSeksiByKodesie($kodesie);

		$data['status'] = $this->M_monitoringpresensi->statusKerja();
		$data['unit'] = $this->M_monitoringpresensi->ambilUnit();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMCabang/Monitoring/V_MonBulanan',$data);
		$this->load->view('V_Footer',$data);
	}

	function getMonBulanan(){
		$kodesie = $this->session->kodesie;
		$statusKerja = $this->input->post('statusKerja[]');
		$unitKerja = $this->input->post('unitKerja');
		$seksiKerja = $this->input->post('seksiKerja');

		if(!empty($statusKerja)){
			if(is_array($statusKerja)){

				if(!in_array("", $statusKerja)){
					$statusKerja = array_map(function($val){
						return "'$val'";
					}, $statusKerja);
					$statusKerja = implode(",", $statusKerja);

					$q_status = "AND left(a.noind,1) IN ($statusKerja) ";
				}else{
					$q_status = "";
				}
			}
		}else{
			$q_status = "";
		}

		// echo "<pre>";var_dump($statusKerja);exit();

		if(!empty($unitKerja)){
			$q_unit = "AND left(a.kodesie,5) = '$unitKerja'";
		}else{
			$q_unit = "";
		}

		if(!empty($seksiKerja)){
			$seksiKerja = explode(' - ', $seksiKerja)[0];
			$q_seksi = "AND left(a.kodesie,7) = '$seksiKerja' ";
		}else{
			$q_seksi = "";
		}


		$bulanAwal 				= trim($this->input->post('periodeAwal'));
		$bulanAkhir 			= trim($this->input->post('periodeAkhir'));
		$arrBulan				= $this->input->post('arrBulan');

		$bulanAwal 				= date('Y-m-d',strtotime($bulanAwal));
		$bulanAkhir 			= date('Y-m-d',strtotime($bulanAkhir));

		$periodeBulan = array();

		for($i = 0;$i < count($arrBulan);$i++){
			array_push($periodeBulan, date('F Y',strtotime($arrBulan[$i])));
		}

		$queryPeriode = "";
		$queryPeriode .= "(";
		foreach ($arrBulan as $bln) {
			$queryPeriode .= "'".substr($bln, 0, 7)."'".' , ';
		}
		$queryPeriode = rtrim($queryPeriode, ' , ');
		$queryPeriode .= ")";

		foreach ($arrBulan as $key => $tgl) {
			$dataTotalBulanan[] = $this->M_monitoringpresensi->getDataAbsensiBulanan(substr($tgl, 0,7),$kodesie,$q_status,$q_unit,$q_seksi);
		}

		// echo "<pre>";
		// print_r($dataTotalBulanan);exit();

		foreach ($arrBulan as $key => $tgl) {
			$dataTotalPerBulan[] = $this->M_monitoringpresensi->getDataAbsensiBulananPerPeriode(substr($tgl, 0,7),$kodesie,$q_status,$q_unit,$q_seksi);
		}

		// echo "<pre>";print_r($dataTotalPerBulan);exit();

		$persentasePerPeriode = array();
		$kabehData = array();
		$seksiPerTanggal = array();
		$kodesieArr = array();
		$index = 0;
		foreach ($arrBulan as $keyT => $tgl) {
			foreach ($dataTotalBulanan[$index] as $key => $dtTtl) {
				foreach ($dataTotalPerBulan[$index] as $key2 => $dtBln) {
					if($key == $key2){
						if($dtTtl['sum'] == 0 or $dtBln['sum'] == 0){
							$persentasePerPeriode[$dtTtl['seksi']][] = 0;
							$kabehData[] = 0;
						}else{
							$persentasePerPeriode[$dtTtl['seksi']][] = intval($dtBln['sum']) / intval($dtTtl['sum']) * 100;
							$kabehData[] = intval($dtBln['sum']) / intval($dtBln['sum']) * 100;
						}

						$seksiPerTanggal[$keyT][] = $dtTtl['seksi'];
						$kodesieArr[$keyT][] = $dtTtl['kodesie'];
					}
				}
			}
			$index++;
		}
		// echo "<pre>";
		// print_r($seksiPerTanggal);exit();

		$data['kabehData'] = $kabehData;
		$data['kodesieArr'] = $kodesieArr;
		$data['seksiPerTanggal'] = $seksiPerTanggal;
		$data['dataTotalBulanan'] = $dataTotalBulanan;
		$data['dataTotalPerBulan'] = $dataTotalPerBulan;
		$data['data'] = $persentasePerPeriode;
		$data['periodeBulan'] = $periodeBulan;
		print_r(json_encode($data));
	}

	public function getDetailPekerjaBulanan() {


		$periode = $this->input->get('periode');
		$kodesie = $this->input->get('kodesie');

		$periode = date('Y-m',strtotime($periode));
		// echo $kodesie;exit();
		$data = $this->M_monitoringpresensi->getDetailAbsensiPerbulan($periode,$kodesie);

		print_r(json_encode($data));
		// echo "<pre>";
		// print_r($data);
	}

	public function MonHarian(){
		$user_id = $this->session->userid;
		$kodesie = $this->session->kodesie;
		if(!$this->M_monitoringpresensi->getAksesAtasanProduksi($this->session->user)){
			echo "Prohibited";exit();
		}

		$data['Title'] = 'Monitoring Presensi Harian';
		$data['Menu'] = 'Lihat Monitoring Presensi Harian';
		$data['SubMenuOne'] = '';
		$data['SubMenuTwo'] = '';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		$data['seksi'] = $this->M_presensibulanan->getSeksiByKodesie($kodesie);

		$data['status'] = $this->M_monitoringpresensi->statusKerja();
		$data['unit'] = $this->M_monitoringpresensi->ambilUnit();
		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('ADMCabang/Monitoring/V_MonHarian',$data);
		$this->load->view('V_Footer',$data);
	}

	function getMonHarian(){
		$kodesie = $this->session->kodesie;
		$statusKerja = $this->input->post('statusKerja[]');
		$unitKerja = $this->input->post('unitKerja');
		$seksiKerja = $this->input->post('seksiKerja');
		if(!empty($statusKerja)){
			$statusKerja = array_map(function($val){
				return "'$val'";
			}, $statusKerja);
			$statusKerja = implode(",", $statusKerja);

			$q_status = "AND left(a.noind,1) IN ($statusKerja) ";
		}else{
			$q_status = "";
		}

		if(!empty($unitKerja)){
			$q_unit = "AND left(a.kodesie,5) = '$unitKerja'";
		}else{
			$q_unit = "";
		}

		if(!empty($seksiKerja)){
			$seksiKerja = explode(' - ', $seksiKerja)[0];
			$q_seksi = "AND left(a.kodesie,7) = '$seksiKerja' ";
		}else{
			$q_seksi = "";
		}
		

		$periode 				= trim($this->input->post('periode'));
		$arrTanggal 			= $this->input->post('arrTanggal');

		$tanggalAwal 			= explode(' - ', $periode)[0];
		$tanggalAkhir 			= explode(' - ', $periode)[1];

		$tglString = array();
		for($i=0;$i < count($arrTanggal);$i++){
			array_push($tglString, date('d',strtotime($arrTanggal[$i])).' '.date('F',strtotime($arrTanggal[$i])).' '.date('Y',strtotime($arrTanggal[$i])));
		}
		$dataTotalHarian = array();
		foreach ($arrTanggal as $tgl) {
			$dataTotalHarian[] = $this->M_monitoringpresensi->getDataAbsensiHarianTotal($tgl,$tanggalAkhir,$kodesie,$q_status,$q_unit,$q_seksi);
		}

		// echo "<pre>";
		// print_r($dataTotalHarian);exit();

		$dataPerHari = array();
		foreach ($arrTanggal as $tgl) {
			$dataPerHari[] = $this->M_monitoringpresensi->getDataAbsensiPerHari($tgl,$kodesie,$q_status,$q_unit,$q_seksi);
		}

		// echo "<pre>";
		// print_r($dataPerHari);exit();

		$persentasePerPeriode = array();
		$persentasePerTanggal = array();
		$seksiPerTanggal = array();
		$kabehData = array();
		$kodesieArr = array();
		$index = 0;
		foreach ($arrTanggal as $keyT => $dtTgl) {
			foreach ($dataPerHari[$index] as $key => $dtHr) {
				foreach ($dataTotalHarian[$index] as $key2 => $dtTtl) {
					if($key == $key2){
						if($dtTtl['sum'] == 0 or $dtHr['sum'] == 0){
							$persentasePerPeriode[$dtTtl['seksi']][] = 0;
							$kabehData[] = 0;
						}else{
							$persentasePerPeriode[$dtTtl['seksi']][] = intval($dtHr['sum']) / intval($dtTtl['sum']) * 100;
							$kabehData[] = intval($dtHr['sum']) / intval($dtTtl['sum']) * 100;
						}
						
						$seksiPerTanggal[$keyT][] = $dtTtl['seksi'];
						$kodesieArr[$keyT][] = $dtTtl['kodesie'];
						
					}
					
				}
			}
			$index++;
		}
		$i = 0;



		// echo "<pre>";
		// print_r($persentasePerPeriode);exit();

		$data['kodesieArr'] = $kodesieArr;
		$data['seksiPerTanggal'] = $seksiPerTanggal;
		$data['kabehData'] = $kabehData;
		$data['tanggalRange']	= $tglString;
		$data['dataTotalHari'] = $dataTotalHarian;
		$data['dataPerHari']	= $dataPerHari;
		$data['data']			= $persentasePerPeriode;

		print_r(json_encode($data));
	}

	public function getDetailPekerjaHarian(){
		$statusKerja = $this->input->get('statusKerja[]');
		$unitKerja = $this->input->get('unitKerja');
		$seksiKerja = $this->input->get('seksiKerja');
		// echo "<pre>";var_dump($unitKerja);exit();
		if(!empty($statusKerja)){
			$statusKerja = array_map(function($val){
				return "'$val'";
			}, $statusKerja);
			$statusKerja = implode(",", $statusKerja);

			$q_status = "AND left(a.noind,1) IN ($statusKerja) ";
		}else{
			$q_status = "";
		}

		if(!empty($unitKerja)){
			$q_unit = "AND left(a.kodesie,5) = '$unitKerja'";
		}else{
			$q_unit = "";
		}

		if(!empty($seksiKerja)){
			$seksiKerja = explode(' - ', $seksiKerja)[0];
			$q_seksi = "AND left(a.kodesie,7) = '$seksiKerja' ";
		}else{
			$q_seksi = "";
		}

		$periode = $this->input->get('periode');
		$kodesie = $this->input->get('kodesie');
		$data = $this->M_monitoringpresensi->getDetailAbsensiPerhari($periode,$kodesie,$q_status,$q_unit,$q_seksi);

		print_r(json_encode($data));
		// print_r($data);
	}

	public function getSeksiByUnit(){
		$kodesie = $this->input->get('kodesie');
		$data = $this->M_monitoringpresensi->ambilSeksi($kodesie);

		print_r(json_encode($data));
	}


	function bulanIndo($namaBulan){
	if($namaBulan=="January" or $namaBulan=="01" or $namaBulan=="Jan"){
		return "Januari";
	}elseif ($namaBulan=="February" or $namaBulan=="02" or $namaBulan=="Feb") {
		return "Februari";
	}elseif ($namaBulan=="March" or $namaBulan=="03" or $namaBulan=="Mar") {
		return "Maret";
	}elseif ($namaBulan=="April" or $namaBulan=="04" or $namaBulan=="Apr") {
		return "April";
	}elseif ($namaBulan=="May" or $namaBulan=="05" or $namaBulan=="May") {
		return "Mei";
	}elseif ($namaBulan=="June" or $namaBulan=="06" or $namaBulan=="Jun") {
		return "Juni";
	}elseif ($namaBulan=="July" or $namaBulan=="07" or $namaBulan=="Jul") {
		return "Juli";
	}elseif ($namaBulan=="August" or $namaBulan=="08" or $namaBulan=="Aug") {
		return "Agustus";
	}elseif ($namaBulan=="September" or $namaBulan=="09" or $namaBulan=="Sep") {
		return "September";
	}elseif ($namaBulan=="October" or $namaBulan=="10" or $namaBulan=="Oct") {
		return "Oktober";
	}elseif ($namaBulan=="November" or $namaBulan=="11" or $namaBulan=="Nov") {
		return "November";
	}elseif ($namaBulan=="Desember" or $namaBulan=="12" or $namaBulan=="Dec") {
		return "Desember";
	}else{
		return "tidak diketahui";
	}
}
}
?>