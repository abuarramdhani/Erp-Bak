<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Rekap extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');

		$this->load->library('Log_Activity');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('encrypt');
		$this->load->library('upload');
		$this->load->library('General');
		$this->load->library('pdf');

		$this->load->model('MasterPekerja/Rekap/M_lapkunjungan');
		$pdf 	=	$this->pdf->load();
		date_default_timezone_set('Asia/Jakarta');

		$this->checkSession();
	}

	public function checkSession()
	{
		if(!($this->session->is_logged))
		{
			redirect('');
		}
	}

	function index()
	{
		$user_id = $this->session->userid;

		$data['Header']			=	'Master Pekerja - Quick ERP';
		$data['Title']			=	'Master Pekerja';
		$data['Menu'] 			= 	'';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['lapkun']			= $this->M_lapkunjungan->getDataLapkun();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Rekap/V_Index_Lapkun',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getInfoPekerja(){
		$keyword 	 = strtoupper($this->input->get('term'));
		$infoPekerja = $this->M_lapkunjungan->getInfoPekerja($keyword);
		echo json_encode($infoPekerja);
	}

	public function addLaporanKunjungan(){
		$user_id = $this->session->userid;

		$data['Header']			=	'Master Pekerja - Quick ERP';
		$data['Title']			=	'Master Pekerja';
		$data['Menu'] 			= 	'';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Rekap/V_LapKunjungan');
		$this->load->view('V_Footer',$data);

	}

	public function previewLaporanKunjungan(){
		$atasan 				= $this->input->post('atasan');
		$petugas 				= $this->input->post('petugas');
		$pekerja 				= $this->input->post('pekerja');
		$diagnosa 				= $this->input->post('diagnosa');
		$hal 					= $this->input->post('hal');
		$latar_belakang 		= $this->input->post('latar_belakang');
		$hasil_laporan 			= $this->input->post('LapKun');

		$save_latar_belakang	= "";
		for($i=0;$i < count($latar_belakang);$i++){
			$save_latar_belakang .= ' , '.$latar_belakang[$i];
		}
		$save_latar_belakang = ltrim($save_latar_belakang,' , ');
		$data = array();

		if(!empty($atasan)){
			$atasan 		= explode(' - ', $atasan);
			$noindAtasan	= $atasan[0];
			$namaAtasan 	= $atasan[1];
			$jabatanAtasan 	= $atasan[2];
		}

		if(!empty($petugas)){
			$petugas 		= explode(' - ', $petugas);
			$noindPetugas	= $petugas[0];
			$namaPetugas 	= $petugas[1];
			$seksiPetugas 	= $petugas[2];
		}


		if(!empty($pekerja)){
			$pekerja 		= explode(' - ', $pekerja);
			$noindPekerja 	= $pekerja[0];
			$namaPekerja 	= $pekerja[1];
			$seksiPekerja 	= $pekerja[2];
			if ($pekerja[3] == 'TKS') {
				$alamatPekerja 	= $pekerja[4];
			}else {
				$alamatPekerja 	= $pekerja[3];
			}
		}
		$tanggal_laporan = date('Y-m-d');
		$bulan_laporan	 = substr($tanggal_laporan, 0, 7);
		$no_surat 		 = $this->M_lapkunjungan->getNomorSurat($bulan_laporan);

		$bulan = date('m');
		if($bulan == "01"){
			$bulan = "Januari";
		}elseif ($bulan == "02") {
			$bulan = "Februari";
		}elseif($bulan == "03"){
			$bulan = "Maret";
		}elseif($bulan == "04"){
			$bulan = "April";
		}elseif($bulan == "05"){
			$bulan = "Mei";
		}elseif ($bulan == "06") {
			$bulan = "Juni";
		}elseif($bulan == "07"){
			$bulan = "Juli";
		}elseif($bulan == "08"){
			$bulan = "Agustus";
		}elseif($bulan == "09"){
			$bulan = "September";
		}elseif ($bulan == "10") {
			$bulan = "Oktober";
		}elseif($bulan == "11"){
			$bulan = "November";
		}else{
			$bulan = "Desember";
		}

		$data['diagnosa']			= $diagnosa;
		$data['hal']				= $hal;
		$data['latar_belakang']		= $latar_belakang;
		$data['hasil_laporan']		= $hasil_laporan;

		if($noindAtasan != "null"){
			$data['noind_atasan'] 		= $noindAtasan;
		}else{
			$data['noind_atasan'] 		= "";
		}

		if($namaAtasan != "null"){
			$data['nama_atasan']		= $namaAtasan;
		}else{
			$data['nama_atasan']		= "";
		}

		if($jabatanAtasan != "null"){
			$data['jabatan_atasan']		= $jabatanAtasan;
		}else{
			$data['jabatan_atasan']		= "";
		}

		if($noindPetugas != "null"){
			$data['noind_petugas'] 		= $noindPetugas;
		}else{
			$data['noind_petugas'] 		= "";
		}

		if($namaPetugas != "null"){
			$data['nama_petugas']		= $namaPetugas;
		}else{
			$data['nama_petugas']		= "";
		}

		if($seksiPetugas != "null"){
			$data['seksi_petugas']		= $seksiPetugas;
		}else{
			$data['seksi_petugas']		= "";
		}

		if($noindPekerja != "null"){
			$data['noind_pekerja']		= $noindPekerja;
		}else{
			$data['noind_pekerja']		= "";
		}

		if($namaPekerja != "null"){
			$data['nama_pekerja']		= $namaPekerja;
		}else{
			$data['nama_pekerja']		= "";
		}

		if($seksiPekerja != "null"){
			$data['seksi_pekerja']		= $seksiPekerja;
		}else{
			$data['seksi_pekerja']		= "";
		}

		if($alamatPekerja != "null"){
			$data['alamat_pekerja']		= $alamatPekerja;
		}else{
			$data['alamat_pekerja']		= "";
		}

		if($latar_belakang != "null"){
			$data['latar_belakang']		= $latar_belakang;
		}else{
			$data['latar_belakang']		= "";
		}

		$data['infoPetugas'] = $petugas;

		echo json_encode($data);
	}

	public function cetakLaporanKunjungan(){
		$atasan 				= $this->input->post('atasan');
		$petugas 				= $this->input->post('petugas');
		$pekerja 				= $this->input->post('pekerja');
		$diagnosa 				= $this->input->post('diagnosa');
		$hal 					= $this->input->post('hal');
		$latar_belakang 		= $this->input->post('latar_belakang');
		$hasil_laporan 			= $this->input->post('LapKun');
		$save_latar_belakang	= "";
		for($i=0;$i < count($latar_belakang);$i++){
			$save_latar_belakang .= ' , '.$latar_belakang[$i];
		}
		$save_latar_belakang = ltrim($save_latar_belakang,' , ');
		$data = array();

		if(!empty($atasan)){
			$atasan 		= explode(' - ', $atasan);
			$noindAtasan	= $atasan[0];
			$namaAtasan 	= $atasan[1];
			$jabatanAtasan 	= $atasan[2];
		}

		if(!empty($petugas)){
			$petugas 		= explode(' - ', $petugas);
			$noindPetugas	= $petugas[0];
			$namaPetugas 	= $petugas[1];
			$seksiPetugas 	= $petugas[2];
		}


		if(!empty($pekerja)){
			$pekerja 		= explode(' - ', $pekerja);
			$noindPekerja 	= $pekerja[0];
			$namaPekerja 	= $pekerja[1];
			$seksiPekerja 	= $pekerja[2];
			if ($pekerja[3] == 'TKS') {
				$alamatPekerja 	= $pekerja[4];
			}else {
				$alamatPekerja 	= $pekerja[3];
			}
		}
		$tanggal_laporan = date('Y-m-d');
		$bulan_laporan	 = substr($tanggal_laporan, 0, 7);

		$max_no_surat 	 = $this->M_lapkunjungan->getMaxNoSurat($bulan_laporan);
		if(!empty($max_no_surat)){
			$max_no_surat	 = $max_no_surat[0]['max_no_surat'];
			$no_surat	 	 = explode('/', $max_no_surat);
			$no_surat 		 = str_pad($no_surat[0] + 1 ,3,"0",STR_PAD_LEFT);
		}else{
			$no_surat 		 = str_pad(1 ,3,"0",STR_PAD_LEFT);
		}

		$bulan = date('m');
		if($bulan == "01"){
			$bulan = "Januari";
		}elseif ($bulan == "02") {
			$bulan = "Februari";
		}elseif($bulan == "03"){
			$bulan = "Maret";
		}elseif($bulan == "04"){
			$bulan = "April";
		}elseif($bulan == "05"){
			$bulan = "Mei";
		}elseif ($bulan == "06") {
			$bulan = "Juni";
		}elseif($bulan == "07"){
			$bulan = "Juli";
		}elseif($bulan == "08"){
			$bulan = "Agustus";
		}elseif($bulan == "09"){
			$bulan = "September";
		}elseif ($bulan == "10") {
			$bulan = "Oktober";
		}elseif($bulan == "11"){
			$bulan = "November";
		}else{
			$bulan = "Desember";
		}

		$data['diagnosa']			= $diagnosa;
		$data['hal']				= $hal;
		$data['latar_belakang']		= $latar_belakang;
		$data['hasil_laporan']		= $hasil_laporan;

		if($noindAtasan != "null"){
			$data['noind_atasan'] 		= $noindAtasan;
		}else{
			$data['noind_atasan'] 		= "";
		}

		if($namaAtasan != "null"){
			$data['nama_atasan']		= $namaAtasan;
		}else{
			$data['nama_atasan']		= "";
		}

		if($jabatanAtasan != "null"){
			$data['jabatan_atasan']		= $jabatanAtasan;
		}else{
			$data['jabatan_atasan']		= "";
		}


		if($noindPetugas != "null"){
			$data['noind_petugas'] 		= $noindPetugas;
		}else{
			$data['noind_petugas'] 		= "";
		}

		if($namaPetugas != "null"){
			$data['nama_petugas']		= $namaPetugas;
		}else{
			$data['nama_petugas']		= "";
		}

		if($seksiPetugas != "null"){
			$data['seksi_petugas']		= $seksiPetugas;
		}else{
			$data['seksi_petugas']		= "";
		}

		if($noindPekerja != "null"){
			$data['noind_pekerja']		= $noindPekerja;
		}else{
			$data['noind_pekerja']		= "";
		}

		if($namaPekerja != "null"){
			$data['nama_pekerja']		= $namaPekerja;
		}else{
			$data['nama_pekerja']		= "";
		}

		if($seksiPekerja != "null"){
			$data['seksi_pekerja']		= $seksiPekerja;
		}else{
			$data['seksi_pekerja']		= "";
		}

		if($alamatPekerja != "null"){
			$data['alamat_pekerja']		= $alamatPekerja;
		}else{
			$data['alamat_pekerja']		= "";
		}

		if($latar_belakang != "null"){
			$data['latar_belakang']		= $latar_belakang;
		}else{
			$data['latar_belakang']		= "";
		}

		$save_no_surat = $no_surat."/".date('m')."/".date('Y');

		$simpanLaporan = [
			'hal_laporan' 			=> $hal,
			'nama_petugas' 			=> $namaPetugas,
			'noinduk_petugas'		=> $noindPetugas,
			'seksi_petugas'			=> $seksiPetugas,
			'nama_pekerja'			=> $namaPekerja,
			'noinduk_pekerja'		=> $noindPekerja,
			'seksi_pekerja'			=> $seksiPekerja,
			'alamat_pekerja'		=> $alamatPekerja,
			'diagnosa' 				=> $diagnosa,
			'latar_belakang'		=> $save_latar_belakang,
			'hasil_laporan'			=> $hasil_laporan,
			'tanggal_laporan'		=> date('Y-m-d'),
			'no_surat'				=> $save_no_surat,
			'noinduk_atasan'		=> $noindAtasan,
			'nama_atasan'			=> $namaAtasan,
			'jabatan_atasan'			=> $jabatanAtasan
		];

		$this->M_lapkunjungan->saveLaporan($simpanLaporan);

		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Save Laporan Kunjungan Nomor Surat='.$save_no_surat;
		$this->log_activity->activity_log($aksi, $detail);
		//

		redirect('MasterPekerja/LaporanKunjungan/index');
	}

	function cetakPDF($id_laporan){
		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Cetak PDF Laporan Kunjungan ID='.$id_laporan;
		$this->log_activity->activity_log($aksi, $detail);
		//
		$data_pdf 				= $this->M_lapkunjungan->getDataPDF($id_laporan);
		$save_latar_belakang	= "";
		for($i=0;$i < count($latar_belakang);$i++){
			$save_latar_belakang .= ' , '.$latar_belakang[$i];
		}
		$save_latar_belakang = ltrim($save_latar_belakang,' , ');

		$noindAtasan	= $data_pdf[0]['noinduk_atasan'];
		$namaAtasan 	= $data_pdf[0]['nama_atasan'];
		$jabatanAtasan 	= $data_pdf[0]['jabatan_atasan'];

		$noindPetugas	= $data_pdf[0]['noinduk_petugas'];
		$namaPetugas 	= $data_pdf[0]['nama_petugas'];
		$seksiPetugas 	= $data_pdf[0]['seksi_petugas'];

		$noindPekerja 	= $data_pdf[0]['noinduk_pekerja'];
		$namaPekerja 	= $data_pdf[0]['nama_pekerja'];
		$seksiPekerja 	= $data_pdf[0]['seksi_pekerja'];
		$alamatPekerja 	= $data_pdf[0]['alamat_pekerja'];

		$hal 			= $data_pdf[0]['hal_laporan'];
		$diagnosa		= $data_pdf[0]['diagnosa'];

		$latar_belakang = explode(' , ', $data_pdf[0]['latar_belakang']);
		$hasil_laporan 	= $data_pdf[0]['hasil_laporan'];
		$tanggal_laporan = date('Y-m-d');
		$bulan_laporan	 = substr($tanggal_laporan, 0, 7);
		$no_surat 		 = $$data_pdf[0]['no_surat'];

		$bulan = date('m');
		if($bulan == "01"){
			$bulan = "Januari";
		}elseif ($bulan == "02") {
			$bulan = "Februari";
		}elseif($bulan == "03"){
			$bulan = "Maret";
		}elseif($bulan == "04"){
			$bulan = "April";
		}elseif($bulan == "05"){
			$bulan = "Mei";
		}elseif ($bulan == "06") {
			$bulan = "Juni";
		}elseif($bulan == "07"){
			$bulan = "Juli";
		}elseif($bulan == "08"){
			$bulan = "Agustus";
		}elseif($bulan == "09"){
			$bulan = "September";
		}elseif ($bulan == "10") {
			$bulan = "Oktober";
		}elseif($bulan == "11"){
			$bulan = "November";
		}else{
			$bulan = "Desember";
		}

		$data['diagnosa']			= $diagnosa;
		$data['hal']				= $hal;
		$data['latar_belakang']		= $latar_belakang;
		$data['hasil_laporan']		= $hasil_laporan;

		if($noindAtasan != "null"){
			$data['noind_atasan'] 		= $noindAtasan;
		}else{
			$data['noind_atasan'] 		= "";
		}

		if($namaAtasan != "null"){
			$data['nama_atasan']		= $namaAtasan;
		}else{
			$data['nama_atasan']		= "";
		}

		if($jabatanAtasan != "null"){
			$data['jabatan_atasan']		= $jabatanAtasan;
		}else{
			$data['jabatan_atasan']		= "";
		}

		if($noindPetugas != "null"){
			$data['noind_petugas'] 		= $noindPetugas;
		}else{
			$data['noind_petugas'] 		= "";
		}

		if($namaPetugas != "null"){
			$data['nama_petugas']		= $namaPetugas;
		}else{
			$data['nama_petugas']		= "";
		}

		if($seksiPetugas != "null"){
			$data['seksi_petugas']		= $seksiPetugas;
		}else{
			$data['seksi_petugas']		= "";
		}

		if($noindPekerja != "null"){
			$data['noind_pekerja']		= $noindPekerja;
		}else{
			$data['noind_pekerja']		= "";
		}

		if($namaPekerja != "null"){
			$data['nama_pekerja']		= $namaPekerja;
		}else{
			$data['nama_pekerja']		= "";
		}

		if($seksiPekerja != "null"){
			$data['seksi_pekerja']		= $seksiPekerja;
		}else{
			$data['seksi_pekerja']		= "";
		}

		if($alamatPekerja != "null"){
			$data['alamat_pekerja']		= $alamatPekerja;
		}else{
			$data['alamat_pekerja']		= "";
		}

		if($latar_belakang != "null"){
			$data['latar_belakang']		= $latar_belakang;
		}else{
			$data['latar_belakang']		= "";
		}

		$save_no_surat = str_pad($no_surat,3,"0",STR_PAD_LEFT)."/".date('m')."/".date('Y');


		$pdf 	=	new mPDF('','A4',0,'', '20,066mm', '20,066mm', '45,066mm', '20,066mm','20,066mm',0);
		$pdf->SetHTMLHeader('<div style="border: 2px solid #000;margin-bottom: 10px;">
		<table border="0" width="100%" style="margin: 1px;">
			<tr style="width: 100%">
				<td style="height:100%; width:10%;">
					<img src="'.base_url('assets/img/logo.png') .'" width="60px" height="70px">
				</td>
				<td style="height:100%; width:50%;">
					<p style="font-size:16px; font-weight:bold;">CV. KARYA HIDUP SENTOSA</p>
					<p style="font-size:16px; font-weight:bold;">DEPARTEMEN PERSONALIA</p>
					<p style="font-size:16px; font-weight:bold;">SEKSI HUBUNGAN KERJA</p>
				</td>
				<td style="height: 100%;width: 12%;font-size: 12px;">
					<p>No</p>
					<p>TGL</p>
					<p>HAL</p>
					<p>HLM</p>
				</td>
				<td style="height: 100%;width: 5%;font-size: 12px;">
					<p> : </p>
					<p> : </p>
					<p> : </p>
					<p> : </p>
				</td>
				<td style="height: 100%;width: 20%;font-size: 12px;text-align: right;">
					<p>'.$data_pdf[0]['no_surat'].'</p>
					<p>'.date('d').' '.$bulan.' '.date('Y').'</p>
					<p>Laporan Kunjungan</p>
					<p><b>{PAGENO} / {nbpg}</b></p>
				</td>

			</tr>
		</table>
		</div>');

		$html 	= $this->load->view('MasterPekerja/Rekap/V_Cetak_PDF_LaporanKunjungan',$data,true);
		$stylesheet = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
		$pdf->WriteHTML($stylesheet,1);
		$pdf->AddPage();

		$pdf->WriteHTML($html,2);
		$pdf->setTitle("Laporan Kunjungan");
		$pdf->Output("Laporan Kunjungan", 'I');
	}

	public function ExportRekap(){
		$user_id = $this->session->userid;

		$data['Header']			=	'Master Pekerja - Quick ERP';
		$data['Title']			=	'Master Pekerja';
		$data['Menu'] 			= 	'';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['lapkun']			= $this->M_lapkunjungan->getDataLapkun();

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Rekap/V_ExportRekap',$data);
		$this->load->view('V_Footer',$data);
	}

	public function cetakExcel(){
		$this->load->library('Excel');
		$periode 		= $this->input->get('periode');
		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Cetak Excel Laporan Kunjungan Periode='.$periode;
		$this->log_activity->activity_log($aksi, $detail);
		//
		$periode 		= explode(' - ', $periode);

		$tanggal_awal 	= $periode[0];
		$tanggal_akhir 	= $periode[1];
		$tanggal_awal	= str_replace('/', '-', $tanggal_awal);
		$tanggal_akhir	= str_replace('/', '-', $tanggal_akhir);

		$tanggal_awal= date('Y-m-d',strtotime($tanggal_awal));
		$tanggal_akhir= date('Y-m-d',strtotime($tanggal_akhir));

		$data['rekap'] = $this->M_lapkunjungan->getLapkunPeriode($tanggal_awal,$tanggal_akhir);
		$data['tanggal_awal'] 	= $tanggal_awal;
		$data['tanggal_akhir']	= $tanggal_akhir;

		$this->load->view('MasterPekerja/Rekap/V_Cetak_Excel_LaporanKunjungan.php',$data);
	}

	function editLaporan($id_laporan){
		$user_id = $this->session->userid;

		$data['Header']			=	'Master Pekerja - Quick ERP';
		$data['Title']			=	'Master Pekerja';
		$data['Menu'] 			= 	'';
		$data['SubMenuOne'] 	= 	'';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] 		= $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$detail 					= $this->M_lapkunjungan->getDataPDF($id_laporan);

		$data['id_laporan']			= $detail[0]['id_laporan'];
		$data['hal_laporan']		= $detail[0]['hal_laporan'];
		$data['nama_petugas']		= $detail[0]['nama_petugas'];
		$data['noinduk_petugas']	= $detail[0]['noinduk_petugas'];
		$data['seksi_petugas']		= $detail[0]['seksi_petugas'];
		$data['nama_pekerja']		= $detail[0]['nama_pekerja'];
		$data['noinduk_pekerja']	= $detail[0]['noinduk_pekerja'];
		$data['seksi_pekerja']		= $detail[0]['seksi_pekerja'];
		$data['alamat_pekerja']		= $detail[0]['alamat_pekerja'];
		$data['diagnosa']			= $detail[0]['diagnosa'];
		$data['latar_belakang']		= explode(' , ', $detail[0]['latar_belakang']);
		$data['hasil_laporan']		= $detail[0]['hasil_laporan'];
		$data['no_surat']			= $detail[0]['no_surat'];
		$data['tanggal_laporan']	= $detail[0]['tanggal_laporan'];
		$data['nama_atasan']		= $detail[0]['nama_atasan'];
		$data['noinduk_atasan']		= $detail[0]['noinduk_atasan'];
		$data['jabatan_atasan']		= $detail[0]['jabatan_atasan'];

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPekerja/Rekap/V_Edit_Lapkun',$data);
		$this->load->view('V_Footer',$data);
	}

	function updateLaporanKunjungan(){
		$id_laporan				= $this->input->post('id_laporan');
		$atasan 				= $this->input->post('atasan');
		$petugas 				= $this->input->post('petugas');
		$pekerja 				= $this->input->post('pekerja');
		$diagnosa 				= $this->input->post('diagnosa');
		$hal 					= $this->input->post('hal');
		$latar_belakang 		= $this->input->post('latar_belakang');
		$hasil_laporan 			= $this->input->post('LapKun');
		$save_latar_belakang	= "";
		for($i=0;$i < count($latar_belakang);$i++){
			$save_latar_belakang .= ' , '.$latar_belakang[$i];
		}
		$save_latar_belakang = ltrim($save_latar_belakang,' , ');
		$data = array();

		if(!empty($atasan)){
			$atasan 		= explode(' - ', $atasan);
			$noindAtasan	= $atasan[0];
			$namaAtasan 	= $atasan[1];
			$jabatanAtasan 	= $atasan[2];
		}

		if(!empty($petugas)){
			$petugas 		= explode(' - ', $petugas);
			$noindPetugas	= $petugas[0];
			$namaPetugas 	= $petugas[1];
			$seksiPetugas 	= $petugas[2];
		}


		if(!empty($pekerja)){
			$pekerja 		= explode(' - ', $pekerja);
			$noindPekerja 	= $pekerja[0];
			$namaPekerja 	= $pekerja[1];
			$seksiPekerja 	= $pekerja[2];
			if ($pekerja[3] == 'TKS') {
				$alamatPekerja 	= $pekerja[4];
			}else {
				$alamatPekerja 	= $pekerja[3];
			}
		}
		$tanggal_laporan = date('Y-m-d');
		$bulan_laporan	 = substr($tanggal_laporan, 0, 7);
		$no_surat 		 = $this->input->post('no_surat');

		$bulan = date('m');
		if($bulan == "01"){
			$bulan = "Januari";
		}elseif ($bulan == "02") {
			$bulan = "Februari";
		}elseif($bulan == "03"){
			$bulan = "Maret";
		}elseif($bulan == "04"){
			$bulan = "April";
		}elseif($bulan == "05"){
			$bulan = "Mei";
		}elseif ($bulan == "06") {
			$bulan = "Juni";
		}elseif($bulan == "07"){
			$bulan = "Juli";
		}elseif($bulan == "08"){
			$bulan = "Agustus";
		}elseif($bulan == "09"){
			$bulan = "September";
		}elseif ($bulan == "10") {
			$bulan = "Oktober";
		}elseif($bulan == "11"){
			$bulan = "November";
		}else{
			$bulan = "Desember";
		}

		$data['diagnosa']			= $diagnosa;
		$data['hal']				= $hal;
		$data['latar_belakang']		= $latar_belakang;
		$data['hasil_laporan']		= $hasil_laporan;

		if($noindAtasan != "null"){
			$data['noind_atasan'] 		= $noindAtasan;
		}else{
			$data['noind_atasan'] 		= "";
		}

		if($namaAtasan != "null"){
			$data['nama_atasan']		= $namaAtasan;
		}else{
			$data['nama_atasan']		= "";
		}

		if($jabatanAtasan != "null"){
			$data['jabatan_atasan']		= $jabatanAtasan;
		}else{
			$data['jabatan_atasan']		= "";
		}


		if($noindPetugas != "null"){
			$data['noind_petugas'] 		= $noindPetugas;
		}else{
			$data['noind_petugas'] 		= "";
		}

		if($namaPetugas != "null"){
			$data['nama_petugas']		= $namaPetugas;
		}else{
			$data['nama_petugas']		= "";
		}

		if($seksiPetugas != "null"){
			$data['seksi_petugas']		= $seksiPetugas;
		}else{
			$data['seksi_petugas']		= "";
		}

		if($noindPekerja != "null"){
			$data['noind_pekerja']		= $noindPekerja;
		}else{
			$data['noind_pekerja']		= "";
		}

		if($namaPekerja != "null"){
			$data['nama_pekerja']		= $namaPekerja;
		}else{
			$data['nama_pekerja']		= "";
		}

		if($seksiPekerja != "null"){
			$data['seksi_pekerja']		= $seksiPekerja;
		}else{
			$data['seksi_pekerja']		= "";
		}

		if($alamatPekerja != "null"){
			$data['alamat_pekerja']		= $alamatPekerja;
		}else{
			$data['alamat_pekerja']		= "";
		}

		if($latar_belakang != "null"){
			$data['latar_belakang']		= $latar_belakang;
		}else{
			$data['latar_belakang']		= "";
		}

		$simpanLaporan = [
			'hal_laporan' 			=> $hal,
			'nama_petugas' 			=> $namaPetugas,
			'noinduk_petugas'		=> $noindPetugas,
			'seksi_petugas'			=> $seksiPetugas,
			'nama_pekerja'			=> $namaPekerja,
			'noinduk_pekerja'		=> $noindPekerja,
			'seksi_pekerja'			=> $seksiPekerja,
			'alamat_pekerja'		=> $alamatPekerja,
			'diagnosa' 				=> $diagnosa,
			'latar_belakang'		=> $save_latar_belakang,
			'hasil_laporan'			=> $hasil_laporan,
			'tanggal_laporan'		=> date('Y-m-d'),
			'no_surat'				=> $no_surat,
			'noinduk_atasan'		=> $noindAtasan,
			'nama_atasan'			=> $namaAtasan,
			'jabatan_atasan'		=> $jabatanAtasan
		];

		$this->M_lapkunjungan->updateLaporanKunjungan($id_laporan,$simpanLaporan);
		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Update Laporan Kunjungan ID='.$id_laporan;
		$this->log_activity->activity_log($aksi, $detail);
		//
		redirect('MasterPekerja/LaporanKunjungan/index');
	}

	function hapusLaporan(){
		$id_laporan 		= $this->input->post('id_laporan');
		$hapus 				= $this->M_lapkunjungan->deleteLaporan($id_laporan);
		//insert to t_log
		$aksi = 'MASTER PEKERJA';
		$detail = 'Delete Laporan Kunjungan ID='.$id_laporan;
		$this->log_activity->activity_log($aksi, $detail);
		//
	}
}
