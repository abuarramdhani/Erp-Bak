<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');
/**
 *
 */

class C_PekerjaKeluar extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		require_once APPPATH . 'third_party/phpxbase/Column.php';
		require_once APPPATH . 'third_party/phpxbase/Record.php';
		require_once APPPATH . 'third_party/phpxbase/Memo.php';
		require_once APPPATH . 'third_party/phpxbase/Table.php';
		require_once APPPATH . 'third_party/phpxbase/WritableTable.php';

		$this->load->library('session');
		$this->load->library('General');
		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPresensi/ReffGaji/M_pekerjakeluar');
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

	public function index(){
		$user_id = $this->session->userid;

		$data['Title']			=	'Pekerja Keluar';
		$data['Menu'] 			= 	'Reff Gaji';
		$data['SubMenuOne'] 	= 	'Pekerja Keluar';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/ReffGaji/PekerjaKeluar/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function proses_hitung($puasa,$tgl_puasa,$prd_gaji,$status_pekerja,$noind,$pot_seragam){
		$noind_ = "";
		if(!empty($noind)){
			foreach ($noind as $key) {
				if($key !== ""){
					if($noind_ == ""){
						$noind_ = "'".$status_pekerja.$key."'";
					} else {
						$noind_ .= ",'".$status_pekerja.$key."'";
					}
				}

			}
		}

		if($noind_ == ""){
			$noind_pekerja = "and left(noind,1) ='$status_pekerja'";
		}else{
			$noind_pekerja = "and noind in ($noind_)";
		}
		// echo $noind_pekerja;exit();
		$pekerja_keluar = $this->M_pekerjakeluar->getPekerjaKeluar($prd_gaji, $noind_pekerja);
		// echo "<pre>";print_r($pekerja_keluar);exit();
		$gaji = array();
		$angka = 0;
		foreach ($pekerja_keluar as $pkj) {
			$gaji[$angka]['noind'] = $pkj['noind'];
			$gaji[$angka]['nama'] = $pkj['nama'];
			$gaji[$angka]['nama_lengkap'] = $pkj['nama_lengkap'];
			$gaji[$angka]['kodesie'] = $pkj['kodesie'];
			$gaji[$angka]['seksi'] = $pkj['seksi'];
			$gaji[$angka]['tgl_keluar'] = $pkj['tglkeluar'];
			$gaji[$angka]['lokasi_kerja'] = $pkj['lokasi_kerja'];
			$gaji[$angka]['gp'] = 0;
			$gaji[$angka]['ip'] = 0;
			$gaji[$angka]['ik'] = 0;
			$gaji[$angka]['ubt'] = 0;
			$gaji[$angka]['upamk'] = 0;
			$gaji[$angka]['if'] = 0;
			$gaji[$angka]['lembur'] = 0;
			$gaji[$angka]['htm'] = 0;
			$gaji[$angka]['tambahan'] = 0;
			$gaji[$angka]['um_puasa'] = 0;
			$gaji[$angka]['ims'] = 0;
			$gaji[$angka]['imm'] = 0;
			$gaji[$angka]['ipt'] = 0;
			$gaji[$angka]['um_cabang'] = 0;
			$gaji[$angka]['pot_seragam'] = 0;
			$gaji[$angka]['pot_lain'] = 0;
			$gaji[$angka]['sisa_cuti'] = 0;
			$gaji[$angka]['sk_susulan'] = 0;
			$gaji[$angka]['cuti_susulan'] = 0;
			$gaji[$angka]['tik'] = 0;
			$gaji[$angka]['tm'] = 0;
			$gaji[$angka]['jkn'] = "";
			$gaji[$angka]['jht'] = "";
			$gaji[$angka]['jp'] = "";
			$gaji[$angka]['jml_jkn'] = 0;
			$gaji[$angka]['jml_jht'] = 0;
			$gaji[$angka]['jml_jp'] = 0;

			$kom_ip 		= 0;
			$kom_ik 		= 0;
			$kom_ubt 		= 0;
			$kom_upamk 		= 0;
			$kom_if 		= 0;
			$kom_lembur 	= 0;
			$kom_htm 		= 0;
			$kom_tambahan 	= 0;
			$kom_um_puasa 	= 0;
			$kom_ims 		= 0;
			$kom_imm 		= 0;
			$kom_ipt 		= 0;
			$kom_um_cabang	= 0;
			$kom_pot_seragam = 0;
			$kom_pot_lain	= 0;
			$kom_jkn 		= "Tidak";
			$kom_jht 		= "Tidak";
			$kom_jp 		= "Tidak";
			$kom_jml_jkn	= 0;
			$kom_jml_jht	= 0;
			$kom_jml_jp	= 0;

			$tgl_bulan_awal = $this->M_pekerjakeluar->cekProsesGaji($pkj['noind'], $pkj['tglkeluar']);
			$tgl_cut_awal = $this->M_pekerjakeluar->cekProsesGaji2($pkj['noind'], $pkj['tglkeluar']);
			$tgl_bulan_berjalan_awal = $this->M_pekerjakeluar->cekProsesGaji3($pkj['noind'], $pkj['tglkeluar']);


			if ($status_pekerja == 'A' || $status_pekerja == 'B' || $status_pekerja == 'D') {
				$kom_ip = $this->M_pekerjakeluar->set_Ip($pkj['noind'],$tgl_bulan_awal,$pkj['tglkeluar']);
			}

			if ($status_pekerja == 'A' || $status_pekerja == 'B') {
				$kom_ubt = $this->M_pekerjakeluar->hitung_Ubt($pkj['noind'],$tgl_bulan_awal,$pkj['tglkeluar']);
				if($pkj['upamk'] == 'Ya'){
					$kom_upamk = $this->M_pekerjakeluar->hitung_Upamk($pkj['noind'],$tgl_bulan_awal,$pkj['tglkeluar']);
				}
			}

			if ($status_pekerja == 'A' || $status_pekerja == 'B' || $status_pekerja == 'D' || $status_pekerja == 'T' || $status_pekerja == 'E' || $status_pekerja == 'H') {
				if ($status_pekerja == 'H' || $status_pekerja == 'T') {
					$tgl_diangkat_3_bulan = date('Y-m-d', strtotime( $pkj['diangkat']."+3 months"));
					if($pkj['tglkeluar'] >= $tgl_diangkat_3_bulan){
						$kom_ip = $this->M_pekerjakeluar->set_Ik($pkj['noind'],$tgl_bulan_awal,$pkj['tglkeluar']);
					}else{
						$kom_ip = 0;
					}
				}else{
					$kom_ik = $this->M_pekerjakeluar->set_Ik($pkj['noind'],$tgl_bulan_awal,$pkj['tglkeluar']);
				}
			}

			if ($status_pekerja == 'D') {
				$cek_noind_berubah = $this->M_pekerjakeluar->cek_noind_berubah($pkj['noind']);
				if($cek_noind_berubah > 0){
					$kom_htm = $this->M_pekerjakeluar->hitung_Htm_diangkat($pkj['noind'],$tgl_cut_awal,$pkj['tglkeluar']);
					$kom_tik = $this->M_pekerjakeluar->hitung_tik_diangkat($pkj['noind'],$tgl_cut_awal,$pkj['tglkeluar']);
					$kom_tm  = $this->M_pekerjakeluar->hitung_tm_diangkat($pkj['noind'],$tgl_cut_awal,$pkj['tglkeluar']);
				}else{
					$cek_cutoff = $this->M_pekerjakeluar->cek_cutoff_custom($pkj['noind']);
					if($cek_cutoff == "0"){
						$kom_htm = $this->M_pekerjakeluar->hitung_Htm_tdk_cutoff($pkj['noind'],$tgl_cut_awal,$pkj['tglkeluar']);
						$kom_tik = $this->M_pekerjakeluar->hitung_tik_tdk_cutoff($pkj['noind'],$tgl_cut_awal,$pkj['tglkeluar']);
						$kom_tm  = $this->M_pekerjakeluar->hitung_tm_tdk_cutoff($pkj['noind'],$tgl_cut_awal,$pkj['tglkeluar']);
					}else{
						$kom_htm = $this->M_pekerjakeluar->hitung_Htm($pkj['noind'],$tgl_cut_awal,$pkj['tglkeluar']);
						$kom_tik = $this->M_pekerjakeluar->hitung_tik($pkj['noind'],$tgl_cut_awal,$pkj['tglkeluar']);
						$kom_tm  = $this->M_pekerjakeluar->hitung_tm($pkj['noind'],$tgl_cut_awal,$pkj['tglkeluar']);
					}
				}
			}else{
				$cek_cutoff = $this->M_pekerjakeluar->cek_cutoff_custom($pkj['noind']);
				if($cek_cutoff == "0"){
					$kom_htm = $this->M_pekerjakeluar->hitung_Htm_tdk_cutoff($pkj['noind'],$tgl_cut_awal,$pkj['tglkeluar']);
					$kom_tik = $this->M_pekerjakeluar->hitung_tik_tdk_cutoff($pkj['noind'],$tgl_cut_awal,$pkj['tglkeluar']);
					$kom_tm  = $this->M_pekerjakeluar->hitung_tm_tdk_cutoff($pkj['noind'],$tgl_cut_awal,$pkj['tglkeluar']);
				}else{
					$kom_htm = $this->M_pekerjakeluar->hitung_Htm($pkj['noind'],$tgl_cut_awal,$pkj['tglkeluar']);
					$kom_tik = $this->M_pekerjakeluar->hitung_tik($pkj['noind'],$tgl_cut_awal,$pkj['tglkeluar']);
					$kom_tm  = $this->M_pekerjakeluar->hitung_tm($pkj['noind'],$tgl_cut_awal,$pkj['tglkeluar']);
				}
			}

			$kom_sisa_cuti = $this->M_pekerjakeluar->get_sisa_cuti($pkj['noind'],$pkj['tglkeluar']);
			$kom_sk_susulan = $this->M_pekerjakeluar->get_sk_susulan($pkj['noind']);
			$kom_cuti_susulan = $this->M_pekerjakeluar->get_cuti_susulan($pkj['noind']);

			if ($puasa == 'on' || $puasa == '1' || $puasa == 'true') {
				$kom_um_puasa = $this->M_pekerjakeluar->getKomUmPuasa($pkj['noind'],$tgl_bulan_awal,$pkj['tglkeluar'],$tgl_puasa);
			}

			if ($status_pekerja == 'A' || ($status_pekerja == 'B' && $pkj['kd_jabatan'] >= 14 && $pkj['kd_jabatan'] <= 12) || ($status_pekerja == 'D' && $pkj['kd_jabatan'] == 13) || $status_pekerja == 'E' || $status_pekerja == 'T' || $status_pekerja == 'H' || ($status_pekerja == 'J' && $pkj['kd_jabatan'] >= 14 && $pkj['kd_jabatan'] <= 12) ) {
				$kom_lembur = $this->M_pekerjakeluar->hitung_lembur($pkj['noind'],$tgl_cut_awal,$pkj['tglkeluar']);
			}

			$kom_ims = $this->M_pekerjakeluar->hitung_ims($pkj['noind'],$tgl_cut_awal,$pkj['tglkeluar']);
			$kom_imm = $this->M_pekerjakeluar->hitung_imm($pkj['noind'],$tgl_cut_awal,$pkj['tglkeluar']);

			if ($pkj['lokasi_kerja'] !== '01' && $pkj['lokasi_kerja'] !== '02' && $pkj['lokasi_kerja'] !== '03' && $pkj['lokasi_kerja'] !== '04' && (substr($pkj['noind'], 0, 1) == 'B' || substr($pkj['noind'], 0, 1) == 'D') ) {
				$kom_um_cabang = $this->M_pekerjakeluar->hitung_um_cabang($pkj['noind'],$tgl_cut_awal,$pkj['tglkeluar']);
			}

			if ($pkj['lokasi_kerja'] == '02') {
				if($status_pekerja == 'B' || $status_pekerja == 'D' || $status_pekerja == 'T' || $status_pekerja == 'J'){
					$kom_ipt = $this->M_pekerjakeluar->set_ipt($pkj['noind'],$tgl_bulan_awal,$pkj['tglkeluar']);
				}
			}

			$kom_tambahan = $this->M_pekerjakeluar->hitung_tambahan($pkj['noind'],$pkj['tglkeluar']);

			if ($status_pekerja == 'B' || $status_pekerja == 'D' || $status_pekerja == 'J') {
				if($cek_cutoff == 0){
					$kom_if = $this->M_pekerjakeluar->hitung_If_tdk_cutoff($pkj['noind'],$tgl_cut_awal,$pkj['tglkeluar']);
				}else{
					$kom_if = $this->M_pekerjakeluar->hitung_If($pkj['noind'],$tgl_cut_awal,$pkj['tglkeluar']);
				}
			}

			if($status_pekerja == 'H'){
				$kom_pot_seragam = $this->M_pekerjakeluar->get_pot_seragam($pkj['noind'],$pot_seragam);
			}
			$kom_pot_lain = $this->M_pekerjakeluar->potongan($pkj['noind']);

			$pot_bpjs = $this->M_pekerjakeluar->get_bpjs($pkj['noind']);
			$kom_jkn = $pot_bpjs->jkn;
			$kom_jht = $pot_bpjs->jht;
			$kom_jp = $pot_bpjs->jp;

			$kom_jml_jkn = $this->M_pekerjakeluar->jumlah_jkn($pkj['noind']);
			$kom_jml_jht = $this->M_pekerjakeluar->jumlah_jht($pkj['noind']);
			$kom_jml_jp = $this->M_pekerjakeluar->jumlah_jp($pkj['noind']);


			$gaji[$angka]['ip'] = round($kom_ip,2);
			$gaji[$angka]['ik'] = round($kom_ik,2);
			$gaji[$angka]['if'] = round($kom_if,2);
			$gaji[$angka]['ubt'] = round($kom_ubt,2);
			$gaji[$angka]['upamk'] = round($kom_upamk,2);
			$gaji[$angka]['htm'] = round($kom_htm,2);
			$gaji[$angka]['um_puasa'] = round($kom_um_puasa,2);
			$gaji[$angka]['lembur'] = round($kom_lembur,2);
			$gaji[$angka]['imm'] = round($kom_imm,2);
			$gaji[$angka]['ims'] = round($kom_ims,2);
			$gaji[$angka]['ipt'] = round($kom_ipt,2);
			$gaji[$angka]['um_cabang'] = round($kom_um_cabang,2);
			$gaji[$angka]['tambahan'] = $kom_tambahan;
			$gaji[$angka]['pot_seragam'] = $kom_pot_seragam;
			$gaji[$angka]['pot_lain'] = $kom_pot_lain;
			$gaji[$angka]['sisa_cuti'] = $kom_sisa_cuti;
			$gaji[$angka]['sk_susulan'] = $kom_sk_susulan;
			$gaji[$angka]['cuti_susulan'] = $kom_cuti_susulan;
			$gaji[$angka]['tik'] = round($kom_tik,2);
			$gaji[$angka]['tm'] = round($kom_tm,2);
			$gaji[$angka]['jkn'] = $kom_jkn;
			$gaji[$angka]['jht'] = $kom_jht;
			$gaji[$angka]['jp'] = $kom_jp;
			$gaji[$angka]['jml_jkn'] = $kom_jml_jkn;
			$gaji[$angka]['jml_jht'] = $kom_jml_jht;
			$gaji[$angka]['jml_jp'] = $kom_jml_jp;

			$this->M_pekerjakeluar->delete_reffgajikeluar($pkj['noind']);
			$susulan = "";
			if ($gaji[$angka]['sk_susulan']  +  $gaji[$angka]['cuti_susulan'] > 0){
				$susulan = ($gaji[$angka]['sk_susulan']  +  $gaji[$angka]['cuti_susulan']).'GP';
			}else{
				$susulan = "-";
			}
			$array_insert = array(
				'tanggal_keluar' => $gaji[$angka]['tgl_keluar'] ,
				'noind' 		 => $gaji[$angka]['noind'] ,
				'nama' 		 	 => $gaji[$angka]['nama_lengkap'] ,
				'kodesie'		 => $gaji[$angka]['kodesie'] ,
				'ipe'			 => $gaji[$angka]['ip'] ,
				'ika'			 => $gaji[$angka]['ik'] ,
				'ief'			 => $gaji[$angka]['if'] ,
				'ubt'			 => $gaji[$angka]['ubt'] ,
				'upamk'		 	 => $gaji[$angka]['upamk'] ,
				'ims'			 => $gaji[$angka]['ims'] ,
				'imm'			 => $gaji[$angka]['imm'] ,
				'jam_lembur'	 => $gaji[$angka]['lembur'] ,
				'htm'			 => $gaji[$angka]['tm'] ,
				'ijin'			 => $gaji[$angka]['tik'] ,
				'ct'			 => $gaji[$angka]['sisa_cuti'] ,
				'plain'		 	 => $gaji[$angka]['pot_seragam'] + $gaji[$angka]['pot_lain'],
				'ket'			 => $susulan ,
				'um_puasa'		 => $gaji[$angka]['um_puasa'] ,
				'ipet'			 => $gaji[$angka]['ipt'] ,
				'um_cabang'	 	 => $gaji[$angka]['um_cabang'],
				'jml_jkn'		 => $gaji[$angka]['jml_jkn'],
				'jml_jht'		 => $gaji[$angka]['jml_jht'],
				'jml_jp'		 => $gaji[$angka]['jml_jp'],
				'lokasi_krj'	 => $gaji[$angka]['lokasi_kerja']
			);
			// echo "<pre>";print_r($array_insert);exit();
			$this->M_pekerjakeluar->insert_reffgajikeluar($array_insert);

			$cek_noind_berubah = $this->M_pekerjakeluar->cek_noind_berubah($pkj['noind']);
			if($cek_noind_berubah > 0){
				unset($gaji[$angka]);
			}else{
				$angka++;
			}
		}

		return $gaji;
	}

	public function Proses(){
		if(!isset($_POST) or empty($_POST)){
			redirect(site_url('MasterPresensi/ReffGaji/PekerjaKeluar/'));
		}
		$user_id = $this->session->userid;
		$tgl_cetak 		= $this->input->post('txtTglCetak');
		$puasa 			= $this->input->post('txtPuasa');
		$tgl_puasa = "";
		if ($puasa == 'on' || $puasa == '1' || $puasa == 'true') {
			$tgl_puasa 		= $this->input->post('txtPeriodePuasa');
		}
		$prd_gaji 		= $this->input->post('txtPeriodeGaji');
		$status_pekerja = $this->input->post('slcStatusPekerja');
		$noind 			= $this->input->post('slcPekerja');
		$pot_seragam 	= $this->input->post('txtPotSeragam');
		// echo "<pre>";print_r($_POST);exit();
		$gaji = $this->proses_hitung($puasa,$tgl_puasa,$prd_gaji,$status_pekerja,$noind,$pot_seragam);

		// echo "<pre>";print_r($gaji);exit();

		$data['Title']			=	'Pekerja Keluar';
		$data['Menu'] 			= 	'Reff Gaji';
		$data['SubMenuOne'] 	= 	'Pekerja Keluar';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['data'] = $gaji;
		$data['filter'] = $_POST;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/ReffGaji/PekerjaKeluar/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function getPekerja(){
		$nomor = $this->input->get('term');
		$kode = $this->input->get('kode');
		$data = $this->M_pekerjakeluar->getPekerja($kode,$nomor);
		echo json_encode($data);
	}

	public function Export(){
		if(!isset($_POST) or empty($_POST)){
			redirect(site_url('MasterPresensi/ReffGaji/PekerjaKeluar/'));
		}
		$user_id = $this->session->userid;
		$tgl_cetak 		= $this->input->post('txtTglCetak2');
		$puasa 			= $this->input->post('txtPuasa2');
		$tgl_puasa = "";
		if ($puasa == 'on' || $puasa == '1' || $puasa == 'true') {
			$tgl_puasa 		= $this->input->post('txtPeriodePuasa2');
		}
		$prd_gaji 		= $this->input->post('txtPeriodeGaji2');
		$status_pekerja = $this->input->post('slcStatusPekerja2');
		$noind 			= $this->input->post('slcPekerja2');
		$pot_seragam 	= $this->input->post('txtPotSeragam2');
		$gaji = $this->proses_hitung($puasa,$tgl_puasa,$prd_gaji,$status_pekerja,$noind,$pot_seragam);

		$waktu = time();
		if($status_pekerja == 'B' || $status_pekerja == 'D' || $status_pekerja == 'J' || $status_pekerja == 'T'){
			$table = new XBase\WritableTable(FCPATH."assets/upload/PekerjaKeluar/STAFF.dbf");
			$table->openWrite(FCPATH."assets/upload/PekerjaKeluar/STAFF_".$waktu.".dbf");

			foreach($gaji as $dt){
				$pri = $this->M_pekerjakeluar->get_tpribadi($dt['noind']);
				$record = $table->appendRecord();
				$record->NOIND	= $dt['noind'];
				$record->NOINDBR	= "";
				$record->NAMA	= $dt['nama'];
				$record->KODESEK	=$pri->kodesie;
				$record->SEKSI	= $pri->seksi;
				$record->UNIT	= $pri->unit;
				$record->DEPT	= $pri->dept;
				$record->KODEREK	= "";
				$record->KPPH	= "";
				$record->GAJIP	= "";
				$record->UJAM	= "";
				$record->UPAMK	= "";
				$record->INSK	= "";
				$record->INSP	= "";
				$record->INSF	= "";
				$record->P_ASTEK	= "";
				$record->BLKERJA	= "";
				$record->ANGG_SPSI	= "";
				$record->ANGG_KOP	= "";
				$record->ANGG_DUKA	= "";
				$record->ANGG_JKN	= "";
				$record->HR_I	= $dt['tik'];
				$record->HR_ABS	= $dt['tm'];
				$record->HR_IK	= $dt['ik'];
				$record->HR_IP	= $dt['ip'];
				$record->HR_IF	= $dt['if'];
				$record->HR_S2	= $dt['ims'];
				$record->HR_S3	= $dt['imm'];
				$record->HUPAMK	= $dt['upamk'];
				$record->JAM_LBR	= $dt['lembur'];
				$record->HR_UM	= $dt['um_puasa'];
				$record->HR_CATER	= "";
				$record->HR_CUTI = $dt['sisa_cuti'];
				$record->P_BONSB	= "";
				$record->P_I_KOP	= "";
				$record->P_UT_KOP	= "";
				$record->P_LAIN	= "";
				$record->P_DUKA	= "";
				$record->P_SPSI	= "";
				$record->T_GAJIP	= "";
				$record->T_INSK	= "";
				$record->T_INSP	= "";
				$record->T_INSF	= "";
				$record->T_IMS	= "";
				$record->T_IMM	= "";
				$record->T_ULEMBUR	= "";
				$record->T_UMAKAN	= "";
				$record->T_CATERING	= "";
				$record->TUPAMK	= "";
				$record->T_TAMBAH1	= "";
				$record->P_UTANG	= "";
				$record->TRANSFER	= "";
				$record->XDUKA	= "";
				$record->PTKP	= "";
				$record->SUBTOTAL1	= "";
				$record->SUBTOTAL2	= "";
				$record->SUBTOTAL3	= "";
				$record->TERIMA	= "";
				$record->KET	= "";
				$record->TKENAPJK	= "";
				$record->TTAKPJK	= "";
				$record->KOREKSI1	= "";
				$record->KOREKSI2	= "";
				$record->DLOBAT	= "";
				$record->KHARGA	= "";
				$record->HRD_IP	= "";
				$record->HRD_IK	= "";
				$record->HRD_IF	= "";
				$record->HRM_GP	= "";
				$record->HRM_IP	= "";
				$record->HRM_IK	= "";
				$record->HRM_IF	= "";
				$record->TGLRMH	= "";
				$record->UBT	= $dt['ubt'];
				$record->TUBT	= "";
				$record->IFDRMLAMA	= "";
				$record->STATUS	= "";
				$record->BANK	= "";
				$record->KODEBANK	= "";
				$record->NOREK	= "";
				$record->POTBANK	= "";
				$record->NAMAPEMREK	= "";
				$record->PERSEN	= "";
				$record->JSPSI	= "";
				$record->STRUKTUR	= "";
				$record->UMP	= "";
				$record->REK_DPLK	= "";
				$record->POT_DPLK	= "";
				$record->UBS	= "";
				$record->KD_LKS	= $pri->lokasi_kerja;
				$record->HR_IPT	= $dt['ipt'];
				$record->HR_UMC	= $dt['um_cabang'];
				$record->ANGG_JKN = $dt['jkn'];
				$record->ANGG_JHT = $dt['jht'];
				$record->ANGG_JP = $dt['jp'];
				$table->writeRecord();
			}

			$table->close();
			redirect(site_url("assets/upload/PekerjaKeluar/STAFF_".$waktu.".dbf"));
		}else{
			$table = new XBase\WritableTable(FCPATH."assets/upload/PekerjaKeluar/NONSTAFF.DBF");
			$table->openWrite(FCPATH."assets/upload/PekerjaKeluar/NONSTAFF_".$waktu.".dbf");

			foreach($gaji as $dt){
				$pri = $this->M_pekerjakeluar->get_tpribadi($dt['noind']);
				$record 			= $table->appendRecord();
				$record->NOIND		= $dt['noind'];
				$record->NAMAOPR	= $dt['nama'];
				$record->JLB		= $dt['lembur'];
				$record->HMS		= $dt['ims'];
				$record->HMM		= $dt['imm'];
				$record->IPRES		= $dt['ip'];
				$record->IKOND		= $dt['ik'];
				$record->UBT		= $dt['ubt'];
				$record->HUPAMK		= $dt['upamk'];
				$record->UMP		= $dt['um_puasa'];
				$record->IK			= $dt['tik'];
				$record->ABS		= $dt['tm'];
				$record->TAMBAHAN	= $dt['tambahan'];
				$record->POTONGAN 	= "";
				$record->KD_LKS		= $pri->lokasi_kerja;
				$record->POTSERAGAM = $dt['pot_seragam'];
				$record->JKN 		= $dt['jkn'];
				$record->JHT 		= $dt['jht'];
				$record->JP 		= $dt['jp'];

				$table->writeRecord();
			}

			$table->close();
			redirect(site_url("assets/upload/PekerjaKeluar/NONSTAFF_".$waktu.".dbf"));
		}
	}

	public function exportExcel(){
		if(!isset($_POST) or empty($_POST)){
			redirect(site_url('MasterPresensi/ReffGaji/PekerjaKeluar/'));
		}
		$user_id = $this->session->userid;
		$tgl_cetak 		= $this->input->post('txtTglCetak2');
		$puasa 			= $this->input->post('txtPuasa2');
		$tgl_puasa = "";
		if ($puasa == 'on' || $puasa == '1' || $puasa == 'true') {
			$tgl_puasa 		= $this->input->post('txtPeriodePuasa2');
		}
		$prd_gaji 		= $this->input->post('txtPeriodeGaji2');
		$status_pekerja = $this->input->post('slcStatusPekerja2');
		$noind 			= $this->input->post('slcPekerja2');
		$pot_seragam 	= $this->input->post('txtPotSeragam2');

		$gaji = $this->proses_hitung($puasa,$tgl_puasa,$prd_gaji,$status_pekerja,$noind,$pot_seragam);

		$this->load->library('excel');
		$doc = $this->excel;
		// print_r($_POST);exit();
		// set active sheet
		$doc->setActiveSheetIndex(0);
		$objexcel = $doc->getActiveSheet();
		// read data to active sheet
		$objexcel->setCellValue('A1','No');
		$objexcel->setCellValue('B1','No Induk');
		$objexcel->setCellValue('C1','Nama');
		$objexcel->setCellValue('D1','Kodesie');
		$objexcel->setCellValue('E1','Seksi');
		$objexcel->setCellValue('F1','Tanggal Keluar');
		$objexcel->setCellValue('G1','IP');
		$objexcel->setCellValue('H1','IK');
		$objexcel->setCellValue('I1','IF');
		$objexcel->setCellValue('J1','UBT');
		$objexcel->setCellValue('K1','UPAMK');
		$objexcel->setCellValue('L1','HTM');
		$objexcel->setCellValue('M1','TIK');
		$objexcel->setCellValue('N1','TM');
		$objexcel->setCellValue('O1','UM Puasa');
		$objexcel->setCellValue('P1','Lembur');
		$objexcel->setCellValue('Q1','IMM');
		$objexcel->setCellValue('R1','IMS');
		$objexcel->setCellValue('S1','IPT');
		$objexcel->setCellValue('T1','UM Cabang');
		$objexcel->setCellValue('U1','Sisa Cuti');
		$objexcel->setCellValue('V1','Keterangan');
		$objexcel->setCellValue('W1','Pot. Seragam');
		$objexcel->setCellValue('X1','Pot. Lain');
		$objexcel->setCellValue('Y1','JKN');
		$objexcel->setCellValue('Z1','JHT');
		$objexcel->setCellValue('AA1','JP');
		$objexcel->setCellValue('AB1','Jumlah JKN');
		$objexcel->setCellValue('AC1','Jumlah JHT');
		$objexcel->setCellValue('AD1','Jumlah JP');

		$num = 2;
		$nomor = 1;
		foreach($gaji as $gj){
			$objexcel->setCellValue('A'.$num,$nomor);
			$objexcel->setCellValue('B'.$num,$gj['noind']);
			$objexcel->setCellValue('C'.$num,$gj['nama']);
			$objexcel->setCellValue('D'.$num,$gj['kodesie']);
			$objexcel->setCellValue('E'.$num,$gj['seksi']);
			$objexcel->setCellValue('F'.$num,$gj['tgl_keluar']);
			$objexcel->setCellValue('G'.$num,$gj['ip']);
			$objexcel->setCellValue('H'.$num,$gj['ik']);
			$objexcel->setCellValue('I'.$num,$gj['if']);
			$objexcel->setCellValue('J'.$num,$gj['ubt']);
			$objexcel->setCellValue('K'.$num,$gj['upamk']);
			$objexcel->setCellValue('L'.$num,$gj['htm']);
			$objexcel->setCellValue('M'.$num,$gj['tik']);
			$objexcel->setCellValue('N'.$num,$gj['tm']);
			$objexcel->setCellValue('O'.$num,$gj['um_puasa']);
			$objexcel->setCellValue('P'.$num,$gj['lembur']);
			$objexcel->setCellValue('Q'.$num,$gj['imm']);
			$objexcel->setCellValue('R'.$num,$gj['ims']);
			$objexcel->setCellValue('S'.$num,$gj['ipt']);
			$objexcel->setCellValue('T'.$num,$gj['um_cabang']);
			$objexcel->setCellValue('U'.$num,$gj['sisa_cuti']);
			$objexcel->setCellValue('V'.$num,$gj['cuti_susulan'] + $gj['sk_susulan']);
			$objexcel->setCellValue('W'.$num,$gj['pot_seragam']);
			$objexcel->setCellValue('X'.$num,$gj['pot_lain']);
			$objexcel->setCellValue('Y'.$num,$gj['jkn']);
			$objexcel->setCellValue('Z'.$num,$gj['jht']);
			$objexcel->setCellValue('AA'.$num,$gj['jp']);
			$objexcel->setCellValue('AB'.$num,$gj['jml_jkn']);
			$objexcel->setCellValue('AC'.$num,$gj['jml_jht']);
			$objexcel->setCellValue('AD'.$num,$gj['jml_jp']);
			$num++;
			$nomor++;
		}


		//save our workbook as this file name
		$filename = 'PekerjaKeluar.xls';
		//mime type
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($doc, 'Excel5');
		$objWriter->save('php://output');
	}

	public function print_pdf(){
		if(!isset($_GET) or empty($_GET)){
			redirect(site_url('MasterPresensi/ReffGaji/PekerjaKeluar/'));
		}
		$user_id = $this->session->userid;
		$tgl_cetak 		= $this->input->get('txtTglCetak2');
		$puasa 			= $this->input->get('txtPuasa2');
		$tgl_puasa = "";
		if ($puasa == 'on' || $puasa == '1' || $puasa == 'true') {
			$tgl_puasa 		= $this->input->get('txtPeriodePuasa2');
		}
		$prd_gaji 		= $this->input->get('txtPeriodeGaji2');
		$status_pekerja = $this->input->get('slcStatusPekerja2');
		$noind 			= $this->input->get('slcPekerja2');
		$pot_seragam 	= $this->input->get('txtPotSeragam2');

		$gaji = $this->proses_hitung($puasa,$tgl_puasa,$prd_gaji,$status_pekerja,$noind,$pot_seragam);

		$data['data'] = $gaji;
		$data['pos'] = $_GET;
		$this->load->library('pdf');

		$pdf = $this->pdf->load();
		$pdf = new mPDF('','A4-L',0,'',10,10,10,10,0,5);
		$filename = 'Gaji.pdf';

		$html = $this->load->view('MasterPresensi/ReffGaji/PekerjaKeluar/V_print',$data, true);

		$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
		$pdf->SetHTMLFooter("<i style='font-size: 8pt'>Dicetak oleh ".$this->session->user." tgl. ". date('d/m/Y', time())."</i>");
		$pdf->WriteHTML($stylesheet1,1);
		$pdf->WriteHTML($html, 2);
		$pdf->Output($filename, 'I');
	}

	public function detail_absensi($noind){

		$user_id = $this->session->userid;

		$data['Title']			=	'Pekerja Keluar';
		$data['Menu'] 			= 	'Reff Gaji';
		$data['SubMenuOne'] 	= 	'Pekerja Keluar';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['pribadi'] = $this->M_pekerjakeluar->getPribadi($noind);
		$data['presensi'] = $this->M_pekerjakeluar->getDetailPresensi($noind);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/ReffGaji/PekerjaKeluar/V_detail', $data);
		$this->load->view('V_Footer',$data);
	}
}
?>
