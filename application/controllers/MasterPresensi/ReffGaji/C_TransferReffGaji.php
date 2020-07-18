<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set("memory_limit","-1");

class C_TransferReffGaji extends CI_Controller
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

		$this->load->library('Log_Activity');
		$this->load->library('session');
		$this->load->library('General');
		$this->load->library('pdf');

		$this->load->model('SystemAdministration/MainMenu/M_user');
		$this->load->model('MasterPresensi/ReffGaji/M_transferreffgaji');
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
		$user = $this->session->user;

		$data['Title']			=	'Pekerja Keluar';
		$data['Menu'] 			= 	'Reff Gaji';
		$data['SubMenuOne'] 	= 	'Pekerja Keluar';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['cutoff'] = $this->M_transferreffgaji->getCutOff();
		$data['user'] = $this->session->user;

		$this->M_transferreffgaji->deleteProgres($user);

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/ReffGaji/TransferReffGaji/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function proses(){
		$user = $this->session->user;
		$periode = $this->input->post('periode');
		if (empty($periode)) {
			$periode = $this->input->get('periode');
			$noMemoStaff = $this->input->get('staff');
			$noMemoNonstaff = $this->input->get('nonstaff');
		}
		$bulan = array(
			1 => "Januari",
			2 => "Februari",
			3 => "Maret",
			4 => "April",
			5 => "Mei",
			6 => "Juni",
			7 => "Juli",
			8 => "Agustus",
			9 => "September",
			10 => "Oktober",
			11 => "November",
			12 => "Desember"
		);

		$waktu = time();
		$waktu_string = strftime('%d/%h/%Y %H:%M:%S',$waktu);
		$hari_string = strftime('%d/%h/%Y',$waktu);
		$bulan_gaji = $bulan[intval(substr($periode, 0, 2))]." 20".substr($periode, 2, 2);
		$periode_penggajian = $this->M_transferreffgaji->getPeriodePenggajianByPeriode($periode);

		$data_pkl_non = $this->M_transferreffgaji->getDataPkl('F',$periode); // pkl non staff
		$data_staff = $this->M_transferreffgaji->getDataStaff($periode); // staff lama & staff baru
		$data_nonstaff = $this->M_transferreffgaji->getDataNonStaff($periode); // non-staff
		$data_os = $this->M_transferreffgaji->getDataOs($periode); // os
		$data_cetak_per_kode_induk = $this->M_transferreffgaji->getDataCetakPerKodeInduk($periode); // cetak per kode induk
		$data_cetak_per_kodesie = $this->M_transferreffgaji->getDataCetakPerKodesie($periode); // cetak per seksi
		$data_rekap = $this->M_transferreffgaji->getRekapNominal($periode); // rekap nominal

		$jumlah_total = count($data_pkl_non) + (count($data_staff)*2) + count($data_nonstaff) + count($data_os) + count($data_cetak_per_kode_induk) + count($data_cetak_per_kodesie) + count($data_rekap);
		$this->M_transferreffgaji->insertProgres($user,$periode,$jumlah_total);
		$progres = 0;
		$this->M_transferreffgaji->updateProgres($user,$progres,"Mempersiapkan Data");
		session_write_close();
		flush();

		$data_download = "";
		//pkl non staff
		if (!empty($data_pkl_non)) {
			$table = new XBase\WritableTable(FCPATH."assets/upload/TransferReffGaji/lv_info.dbf");
			$table->openWrite(FCPATH."assets/upload/TransferReffGaji/PKLNONSTAFFDATA-ABS".$periode.$waktu.".dbf");

			$gol_pkl = $this->M_transferreffgaji->getGolPkl();
			if (!empty($gol_pkl)) {
				foreach ($gol_pkl as $gp) {
					$record = $table->appendRecord();
					$record->NOINDLAMA = '';
					$record->NOIND = $gp['golpkl'];
					$record->NAMAOPR = '';
					$record->KODESIE = '';
					$record->TGL_GJ = '0000-00-00';
					$record->HMA15 = '';
					$record->HMA16 = '';
					$record->HMA17 = '';
					$record->HMA18 = '';
					$record->HMA19 = '';
					$record->HMA20 = '';
					$record->HMA21 = '';
					$record->HMA22 = '';
					$record->HMA23 = '';
					$record->HMA24 = '';
					$record->HMA25 = '';
					$record->HMA26 = '';
					$record->HMA27 = '';
					$record->HMA28 = '';
					$record->HMA29 = '';
					$record->HMA30 = '';
					$record->HMA31 = '';
					$record->HM01 = '';
					$record->HM02 = '';
					$record->HM03 = '';
					$record->HM04 = '';
					$record->HM05 = '';
					$record->HM06 = '';
					$record->HM07 = '';
					$record->HM08 = '';
					$record->HM09 = '';
					$record->HM10 = '';
					$record->HM11 = '';
					$record->HM12 = '';
					$record->HM13 = '';
					$record->HM14 = '';
					$record->HM15 = '';
					$record->HM16 = '';
					$record->HM17 = '';
					$record->HM18 = '';
					$record->HM19 = '';
					$record->HM20 = '';
					$record->HM21 = '';
					$record->HM22 = '';
					$record->HM23 = '';
					$record->HM24 = '';
					$record->HM25 = '';
					$record->HM26 = '';
					$record->HM27 = '';
					$record->HM28 = '';
					$record->HM29 = '';
					$record->HM30 = '';
					$record->HM31 = '';
					$record->JLB = 0;
					$record->HMP = 0;
					$record->HMU = 0;
					$record->IFUNG = 0;
					$record->IPRES = 0;
					$record->IKOND = 0;
					$record->HM = 0;
					$record->UBT = 0;
					$record->HUPAMK = 0;
					$record->IKSKP = 0;
					$record->IKSKU = 0;
					$record->IKSKS = 0;
					$record->IKSKM = 0;
					$record->IKJSP = 0;
					$record->IKJSU = 0;
					$record->IKJSS = 0;
					$record->IKJSM = 0;
					$record->T = 0;
					$record->SKD = 0;
					$record->JML_UM = 0;
					$record->HMS = 0;
					$record->HMM = 0;
					$record->JLB = 0;
					$record->ABS = 0;
					$record->HL = 0;
					$record->CTI = 0;
					$record->IK = 0;
					$record->POTONGAN = 0;
					$record->TAMBAHAN = 0;
					$record->DUKA = 0;
					$record->PT = 0;
					$record->PI = 0;
					$record->PM = 0;
					$record->DL = 0;
					$record->REV_SK = 0;
					$record->REV_SP = 0;
					$record->REV_CT = 0;
					$record->REV_IK = 0;
					$record->HC = 0;
					$record->POTKOP = 0;
					$record->CICIL = 0;
					$record->UBS = 0;
					$record->UM_PUASA = 0;
					$record->SK_CT = 0;
					$record->POT_2 = '0';
					$record->TAMB_2 = '0';
					$record->KD_LKS = '';
					$record->KET = '';
					$record->UANGDL = 0;
					$table->writeRecord();

					$data_pkj_pkl_non = $this->M_transferreffgaji->getDataPkjPkl('F',$periode,$gp['golpkl']);
					if (!empty($data_pkj_pkl_non)) {
						foreach ($data_pkj_pkl_non as $dppn) {
							if(trim($dppn['ket']) == "-"){
								$dppn['ket'] = "";
							}
							$record = $table->appendRecord();
							$record->NOINDLAMA = '';
							$record->NOIND = $dppn['noind'];
							$record->NAMAOPR = $dppn['nama'];
							$record->KODESIE = $dppn['kodesie'];
							$record->TGL_GJ = '0000-00-00';
							$record->HMA15 = '';
							$record->HMA16 = '';
							$record->HMA17 = '';
							$record->HMA18 = '';
							$record->HMA19 = '';
							$record->HMA20 = '';
							$record->HMA21 = '';
							$record->HMA22 = '';
							$record->HMA23 = '';
							$record->HMA24 = '';
							$record->HMA25 = '';
							$record->HMA26 = '';
							$record->HMA27 = '';
							$record->HMA28 = '';
							$record->HMA29 = '';
							$record->HMA30 = '';
							$record->HMA31 = '';
							$record->HM01 = '';
							$record->HM02 = '';
							$record->HM03 = '';
							$record->HM04 = '';
							$record->HM05 = '';
							$record->HM06 = '';
							$record->HM07 = '';
							$record->HM08 = '';
							$record->HM09 = '';
							$record->HM10 = '';
							$record->HM11 = '';
							$record->HM12 = '';
							$record->HM13 = '';
							$record->HM14 = '';
							$record->HM15 = '';
							$record->HM16 = '';
							$record->HM17 = '';
							$record->HM18 = '';
							$record->HM19 = '';
							$record->HM20 = '';
							$record->HM21 = '';
							$record->HM22 = '';
							$record->HM23 = '';
							$record->HM24 = '';
							$record->HM25 = '';
							$record->HM26 = '';
							$record->HM27 = '';
							$record->HM28 = '';
							$record->HM29 = '';
							$record->HM30 = '';
							$record->HM31 = '';
							$record->JLB = 0;
							$record->HMP = 0;
							$record->HMU = 0;
							$record->IFUNG = 0;
							$record->IPRES = round($dppn['ipe'],2);
							$record->IKOND = round($dppn['ika'],2);
							$record->HM = round($dppn['ief'],2);
							$record->UBT = round($dppn['ubt'],2);
							$record->HUPAMK = round($dppn['upamk'],2);
							$record->IKSKP = 0;
							$record->IKSKU = 0;
							$record->IKSKS = 0;
							$record->IKSKM = 0;
							$record->IKJSP = 0;
							$record->IKJSU = 0;
							$record->IKJSS = 0;
							$record->IKJSM = 0;
							$record->T = 0;
							$record->SKD = 0;
							$record->JML_UM = round($dppn['um'],2);
							$record->HMS = round($dppn['ims'],2);
							$record->HMM = round($dppn['imm'],2);
							$record->JLB = round($dppn['jam_lembur'],2);
							$record->ABS =  round($dppn['htm'],2) ;
							$record->HL = round($dppn['hl']) ;
							$record->CTI =  round($dppn['ct'],2) ;
							$record->IK =  round($dppn['ijin'],2) ;
							$record->POTONGAN = round($dppn['pot']) + round($dppn['plain']);
							$record->TAMBAHAN =  $dppn['tamb_gaji'] ;
							$record->DUKA =  $dppn['pduka'] ;
							$record->PT = 0;
							$record->PI = 0;
							$record->PM = 0;
							$record->DL = 0;
							$record->REV_SK = 0;
							$record->REV_SP = 0;
							$record->REV_CT = 0;
							$record->REV_IK = 0;
							$record->HC = 0;
							$record->CICIL = 0;
							$record->POTKOP = 0;
							$record->UBS = 0;
							$record->UM_PUASA =  $dppn['um_puasa'] ;
							$record->SK_CT = 0;
							$record->POT_2 =  $dppn['potongan_str'] ;
							$record->TAMB_2 =  $dppn['tambahan_str'] ;
							$record->KD_LKS =  $dppn['lokasi_krj'] ;
							$record->KET =  TRIM($dppn['ket']) ;
							$record->UANGDL =  round($dppn['dldobat'],2);
							$record->JKN =  $dppn['jml_jkn'] ;
							$record->JHT =  $dppn['jml_jht'] ;
							$record->JP =  $dppn['jml_jp'] ;
							$table->writeRecord();

							$progres +=1;
							$this->M_transferreffgaji->updateProgres($user,$progres,'Memproses DBF PKLNONSTAFFDATA-ABS');
							//insert to t_log
							$aksi = 'MASTER PRESENSI';
							$detail = 'Update reff gaji pkl non staf noind='.$dppn['noind'];
							$this->log_activity->activity_log($aksi, $detail);
							//
							session_write_close();
							flush();
						}
					}
				}
			}
			$table->close();
			$data_download .= '<a href="'.site_url("MasterPresensi/ReffGaji/TransferReffGaji/download?file=PKLNONSTAFFDATA-ABS".$periode."&time=".$waktu."&type=dbf").'" class="btn btn-info">PKLNONSTAFFDATA-ABS'.$periode.'</a>';
		}

		//staff lama
		if (!empty($data_staff)) {
			$table3 = new XBase\WritableTable(FCPATH."assets/upload/TransferReffGaji/lv_info2.dbf");
			$table3->openWrite(FCPATH."assets/upload/TransferReffGaji/PER".$periode.$waktu.".dbf");
			foreach ($data_staff as $ds) {
				$ip_lama = 0;
				$ik_lama = 0;
				$ipt_lama = 0;
				//SEMENTARA BELUM DIGUNAKAN DAHULU
				// $data_pekerja_keluar = $this->M_transferreffgaji->getPekerjaKeluar($ds['nik'],$periode);
				// if(!empty($data_pekerja_keluar)){
				// 	$ds['ief'] += $data_pekerja_keluar->ief;
				// 	$ds['ims'] += $data_pekerja_keluar->ims;
				// 	$ds['imm'] += $data_pekerja_keluar->imm;
				// 	$ds['jam_lembur'] += $data_pekerja_keluar->jam_lembur;
				// 	$ds['um_cabang'] += $data_pekerja_keluar->um_cabang;
				// 	$ds['dldobat'] += $data_pekerja_keluar->dldobat;
				// 	$ds['htm'] += $data_pekerja_keluar->htm;
				// 	$ds['ijin'] += $data_pekerja_keluar->ijin;
				// 	$ip_lama = floatval($data_pekerja_keluar->ipe);
				// 	$ik_lama = floatval($data_pekerja_keluar->ika);
				// 	$ipt_lama = floatval($data_pekerja_keluar->ipet);
				// }
				$jabatan = $this->M_transferreffgaji->getStatusJabatan($ds['noind']);
				if ($jabatan <= 11) {
					$st = "3";
				}
				elseif ($jabatan == 12 or $jabatan == 13) {
					$st = "2";
				}
				elseif ($jabatan >= 14) {
					$st = "1";
				}

				$tpribadi = $this->M_transferreffgaji->getPribadi($ds['noind']);
				if (substr($ds['noind'], 0,1) == "B"){
					$spsi = "T";
					$duka = "T";
					if (trim($tpribadi->nokoperasi) == "Ya") {
						$kop = "T";
					}else{
						$kop = "F";
					}
				}else{
					$spsi = "F";
					$duka = "F";
					$kop = "F";
				}

				if (empty($ds['xduka']) or $ds['xduka'] == "") {
					$duk = "0";
				}else{
					$duk = $ds['xduka'];
				}

				if (empty($ds['ubs']) or $ds['ubs'] == "") {
					$ubs = "0";
				}else{
					$ubs = $ds['ubs'];
				}

				if ($ds['kodesie'] == "401010102") {
					$asdf = "0";
				}

				if (empty($ds['angg_jkn']) or $ds['angg_jkn'] == "t") {
					$angg_jkn_bpjs_kes = "T";
				}else{
					$angg_jkn_bpjs_kes = "F";
				}

				$um_ = floatval($ds['hl']) + floatval($ds['um_puasa']);

				$seksi2 = $this->M_transferreffgaji->getSeksi2($ds['kodesie']);
				$seksi = $this->M_transferreffgaji->getSeksi($ds['kodesie']);

				if (!empty($seksi2)) {
					if ($seksi2->kodesek == "401013") {
						$kodsie = "040004";
					}else{
						$kodsie = $seksi2->kodesek;
					}
				}else{
					$kodsie = "";
				}
				// if (round($ds['plain']) > 0) {
					// echo round($ds['plain']);exit();
				// }
				if(trim($ds['ket']) == "-"){
					$ds['ket'] = "";
				}
				if (substr($ds['noind'], 0,1) == "Q") {
					$ds['ijin'] = 0;
					$ds['htm'] = 0;
					$ds['ika'] = 0;
					$ds['ipe'] = 0;
					$ds['ief'] = 0;
					$ds['ims'] = 0;
					$ds['imm'] = 0;
				}

				$record = $table3->appendRecord();
				$record->NOIND = $ds['noind'];
				$record->NOINDBR = '';
				$record->NAMA = $ds['nama'];
				$record->KODESEK = $kodsie;
				$record->SEKSI = $seksi->seksi;
				$record->UNIT = $seksi->unit;
				$record->DEPT = $seksi->dept;
				$record->KODEREK = '';
				$record->KPPH = '';
				$record->GAJIP = 0;
				$record->UJAM = 0;
				$record->UPAMK = 0;
				$record->INSK = 0;
				$record->INSP = 0;
				$record->INSF = 0;
				$record->P_ASTEK = 0;
				$record->BLKERJA = 0;
				$record->ANGG_SPSI = $spsi;
				$record->ANGG_KOP = $kop;
				$record->ANGG_DUKA = $duka;
				$record->HR_I = round($ds['ijin'], 2);
				$record->HR_ABS =  round($ds['htm'],2) ;
				$record->HR_IK =  round($ds['ika'],2) ;
				$record->HR_IP =  round($ds['ipe'],2) ;
				$record->HR_IF =  round($ds['ief'], 2) ;
				$record->HR_S2 =  round($ds['ims'], 2) ;
				$record->HR_S3 =  round($ds['imm'], 2) ;
				$record->HUPAMK =  round($ds['upamk'], 2) ;
				$record->JAM_LBR =  round($ds['jam_lembur'], 2) ;
				$record->HR_UM =  $um_ ;
				$record->HR_CATER = 0;
				$record->P_BONSB = 0;
				$record->P_I_KOP =  round($ds['pikop']);
				$record->P_UT_KOP =  round($ds['putkop']) ;
				$record->P_LAIN = round($ds['plain']);
				$record->P_DUKA =  round($ds['pduka']) ;
				$record->P_SPSI =  round($ds['pspsi']) ;
				$record->T_GAJIP = 0;
				$record->T_INSK = 0;
				$record->T_INSP = 0;
				$record->T_INSF = 0;
				$record->T_IMS = 0;
				$record->T_IMM = 0;
				$record->T_ULEMBUR = 0;
				$record->T_UMAKAN = 0;
				$record->T_CATERING = 0;
				$record->TUPAMK = 0;
				$record->T_TAMBAH1 = 0;
				$record->P_UTANG = 0;
				$record->TRANSFER = 0;
				$record->XDUKA =  $duk ;
				$record->PTKP = 0;
				$record->SUBTOTAL1 = 0;
				$record->SUBTOTAL2 = 0;
				$record->SUBTOTAL3 = 0;
				$record->TERIMA = 0;
				$record->KET =  (str_replace("Hari","",str_replace(".00","",Trim($ds['ket']))) !== "0" and str_replace("Hari","",str_replace(".00","",Trim($ds['ket']))) !== "") ? str_replace(".00","",Trim($ds['ket'])) : '-' ;
				$record->TKENAPJK =  round($ds['tkpajak'], 2) ;
				$record->TTAKPJK = 0;
				$record->KOREKSI1 = '';
				$record->KOREKSI2 = '';
				$record->KHARGA = 0;
				$record->HRD_IP = 0;
				$record->HRD_IK = 0;
				$record->HRD_IF = 0;
				$record->HRM_GP = 0;
				$record->HRM_IP = 0;
				$record->HRM_IK = 0;
				$record->HRM_IF = 0;
				$record->TGLRMH = '';
				$record->UBT =  round($ds['ubt'], 2) ;
				$record->TUBT = 0;
				$record->IFDRMLAMA = 0;
				$record->STATUS = '';
				$record->BANK = '';
				$record->KODEBANK = '';
				$record->NOREK = '';
				$record->POTBANK = 0;
				$record->NAMAPEMREK = '';
				$record->PERSEN = 0;
				$record->JSPSI = '';
				$record->STRUKTUR =  Trim($st) ;
				$record->UMP = 0;
				$record->REK_DPLK = '';
				$record->POT_DPLK = 0;
				$record->UBS =  floatval($ubs) ;
				$record->ANGG_JKN =  $angg_jkn_bpjs_kes ;
				$record->KD_LKS =  $ds['lokasi_krj'] ;
				$record->HR_IPT =  floatval($ds['ipet']) ;
				$record->HR_UMC =  floatval($ds['um_cabang']) ;
				$record->DLOBAT =  floatval($ds['dldobat']);
				$record->JKN =  $ds['jml_jkn'] ;
				$record->JHT =  $ds['jml_jht'] ;
				$record->JP =  $ds['jml_jp'] ;
				$record->HR_CUTI = floatval($ds['ct']);
				$record->HR_IP_LM = $ip_lama;
				$record->HR_IK_LM = $ik_lama;
				$record->HR_IPT_LM = $ipt_lama;
				// echo "<pre>";print_r($record);exit();
				$table3->writeRecord();

				$progres +=1;
				$this->M_transferreffgaji->updateProgres($user,$progres,"Memproses DBF PER");
				//insert to t_log
				$aksi = 'MASTER PRESENSI';
				$detail = 'Update reff gaji staf lama noind='.$ds['noind'];
				$this->log_activity->activity_log($aksi, $detail);
				//
				session_write_close();
				flush();

			}
			$table3->close();
			$data_download .= '<a href="'.site_url("MasterPresensi/ReffGaji/TransferReffGaji/download?file=PER".$periode."&time=".$waktu."&type=dbf") .'" class="btn btn-info">PER'.$periode.'</a>';
		}

		//staff baru
		if (!empty($data_staff)) {
			$table3_new = new XBase\WritableTable(FCPATH."assets/upload/TransferReffGaji/lv_info2_new.dbf");
			$table3_new->openWrite(FCPATH."assets/upload/TransferReffGaji/PERNEW".$periode.$waktu.".dbf");
			foreach ($data_staff as $ds) {
				$ip_lama = 0;
				$ik_lama = 0;
				$ipt_lama = 0;
				//SEMENTARA BELUM DIGUNAKAN DAHULU
				// $data_pekerja_keluar = $this->M_transferreffgaji->getPekerjaKeluar($ds['nik'],$periode);
				// if(!empty($data_pekerja_keluar)){
				// 	$ds['ief'] += $data_pekerja_keluar->ief;
				// 	$ds['ims'] += $data_pekerja_keluar->ims;
				// 	$ds['imm'] += $data_pekerja_keluar->imm;
				// 	$ds['jam_lembur'] += $data_pekerja_keluar->jam_lembur;
				// 	$ds['um_cabang'] += $data_pekerja_keluar->um_cabang;
				// 	$ds['dldobat'] += $data_pekerja_keluar->dldobat;
				// 	$ds['htm'] += $data_pekerja_keluar->htm;
				// 	$ds['ijin'] += $data_pekerja_keluar->ijin;
				// 	$ip_lama = floatval($data_pekerja_keluar->ipe);
				// 	$ik_lama = floatval($data_pekerja_keluar->ika);
				// 	$ipt_lama = floatval($data_pekerja_keluar->ipet);
				// }
				$jabatan = $this->M_transferreffgaji->getStatusJabatan($ds['noind']);
				if ($jabatan <= 11) {
					$st = "3";
				}
				elseif ($jabatan == 12 or $jabatan == 13) {
					$st = "2";
				}
				elseif ($jabatan >= 14) {
					$st = "1";
				}
				$tpribadi = $this->M_transferreffgaji->getPribadi($ds['noind']);
				if (substr($ds['noind'], 0,1) == "B"){
					$spsi = "T";
					$duka = "T";
					if (trim($tpribadi->nokoperasi) == "Ya") {
						$kop = "T";
					}else{
						$kop = "F";
					}
				}else{
					$spsi = "F";
					$duka = "F";
					$kop = "F";
				}
				if (empty($ds['xduka']) or $ds['xduka'] == "") {
					$duk = "0";
				}else{
					$duk = $ds['xduka'];
				}
				if (empty($ds['ubs']) or $ds['ubs'] == "") {
					$ubs = "0";
				}else{
					$ubs = $ds['ubs'];
				}
				if ($ds['kodesie'] == "401010102") {
					$asdf = "0";
				}
				if (empty($ds['angg_jkn']) or $ds['angg_jkn'] == "t") {
					$angg_jkn_bpjs_kes = "T";
				}else{
					$angg_jkn_bpjs_kes = "F";
				}
				$um_ = floatval($ds['hl']) + floatval($ds['um_puasa']);
				$seksi2 = $this->M_transferreffgaji->getSeksi2($ds['kodesie']);
				$seksi = $this->M_transferreffgaji->getSeksi($ds['kodesie']);
				if (!empty($seksi2)) {
					if ($seksi2->kodesek == "401013") {
						$kodsie = "040004";
					}else{
						$kodsie = $seksi2->kodesek;
					}
				}else{
					$kodsie = "";
				}
				// if (round($ds['plain']) > 0) {
					// echo round($ds['plain']);exit();
				// }
				if(trim($ds['ket']) == "-"){
					$ds['ket'] = "";
				}
				if (substr($ds['noind'], 0,1) == "Q") {
					$ds['ijin'] = 0;
					$ds['htm'] = 0;
					$ds['ika'] = 0;
					$ds['ipe'] = 0;
					$ds['ief'] = 0;
					$ds['ims'] = 0;
					$ds['imm'] = 0;
				}
				if (!isset($ds['ikh'])) {
					$ds['ikh'] = 0;
				}
				if (!isset($ds['tp'])) {
					$ds['tp'] = 0;
				}
				if (!isset($ds['hari_tkpw'])) {
					$ds['hari_tkpw'] = 0;
				}
				if (!isset($ds['jam_tkpw'])) {
					$ds['jam_tkpw'] = 0;
				}
				if (!isset($ds['pkl'])) {
					$ds['pkl'] = 0;
				}
				$record = $table3_new->appendRecord();
				$record->NOIND = $ds['noind'];
				$record->NOINDBR = '';
				$record->NAMA = $ds['nama'];
				$record->JABATAN = $ds['jabatan'];
				$record->KODESEK = $kodsie;
				$record->SEKSI = $seksi->seksi;
				$record->UNIT = $seksi->unit;
				$record->DEPT = $seksi->dept;
				$record->KODEREK = '';
				$record->KPPH = '';
				$record->GAJIP = 0;
				$record->UJAM = 0;
				$record->UPAMK = 0;
				$record->INSK = 0;
				$record->INSP = 0;
				$record->INSF = 0;
				$record->P_ASTEK = 0;
				$record->BLKERJA = 0;
				$record->ANGG_SPSI = $spsi;
				$record->ANGG_KOP = $kop;
				$record->ANGG_DUKA = $duka;
				$record->HR_I = round($ds['ijin'], 2);
				$record->HR_ABS =  round($ds['htm'],2) ;
				$record->HR_IK =  round($ds['ika'],2) ;
				$record->HR_IP =  round($ds['ipe'],2) ;
				$record->HR_IF =  round($ds['ief'], 2) ;
				$record->HR_IKH = round($ds['ikh'],2);
				$record->HR_TP = round($ds['tp'],2);
				$record->HR_TKPW = round($ds['hari_tkpw'],2);
				$record->JAM_TKPW = round($ds['jam_tkpw'],2);
				$record->JAM_PKL = $ds['pkl'];
				$record->HR_S2 =  round($ds['ims'], 2) ;
				$record->HR_S3 =  round($ds['imm'], 2) ;
				$record->HUPAMK =  round($ds['upamk'], 2) ;
				$record->JAM_LBR =  round($ds['jam_lembur'], 2) ;
				$record->HR_UM =  $um_ ;
				$record->HR_CUTI = floatval($ds['ct']);
				$record->HR_CATER = 0;
				$record->P_BONSB = 0;
				$record->P_I_KOP =  round($ds['pikop']);
				$record->P_UT_KOP =  round($ds['putkop']) ;
				$record->P_LAIN = round($ds['plain']);
				$record->P_DUKA =  round($ds['pduka']) ;
				$record->P_SPSI =  round($ds['pspsi']) ;
				$record->T_GAJIP = 0;
				$record->T_INSK = 0;
				$record->T_INSP = 0;
				$record->T_INSF = 0;
				$record->T_IMS = 0;
				$record->T_IMM = 0;
				$record->T_ULEMBUR = 0;
				$record->T_UMAKAN = 0;
				$record->T_CATERING = 0;
				$record->TUPAMK = 0;
				$record->T_TAMBAH1 = 0;
				$record->P_UTANG = 0;
				$record->TRANSFER = 0;
				$record->XDUKA =  $duk ;
				$record->PTKP = 0;
				$record->SUBTOTAL1 = 0;
				$record->SUBTOTAL2 = 0;
				$record->SUBTOTAL3 = 0;
				$record->TERIMA = 0;
				$record->KET =  (str_replace("Hari","",str_replace(".00","",Trim($ds['ket']))) !== "0" and str_replace("Hari","",str_replace(".00","",Trim($ds['ket']))) !== "") ? str_replace(".00","",Trim($ds['ket'])) : '-' ;
				$record->TKENAPJK =  round($ds['tkpajak'], 2) ;
				$record->TTAKPJK = 0;
				$record->KOREKSI1 = '';
				$record->KOREKSI2 = '';
				$record->KHARGA = 0;
				$record->HRD_IP = 0;
				$record->HRD_IK = 0;
				$record->HRD_IF = 0;
				$record->HRM_GP = 0;
				$record->HRM_IP = 0;
				$record->HRM_IK = 0;
				$record->HRM_IF = 0;
				$record->TGLRMH = '';
				$record->UBT =  round($ds['ubt'], 2) ;
				$record->TUBT = 0;
				$record->IFDRMLAMA = 0;
				$record->STATUS = '';
				$record->BANK = '';
				$record->KODEBANK = '';
				$record->NOREK = '';
				$record->POTBANK = 0;
				$record->NAMAPEMREK = '';
				$record->PERSEN = 0;
				$record->JSPSI = '';
				$record->STRUKTUR =  Trim($st) ;
				$record->UMP = 0;
				$record->REK_DPLK = '';
				$record->POT_DPLK = 0;
				$record->UBS =  floatval($ubs) ;
				$record->ANGG_JKN =  $angg_jkn_bpjs_kes ;
				$record->KD_LKS =  $ds['lokasi_krj'] ;
				$record->HR_IPT =  floatval($ds['ipet']) ;
				$record->HR_UMC =  floatval($ds['um_cabang']) ;
				$record->DLOBAT =  floatval($ds['dldobat']);
				$record->JKN =  $ds['jml_jkn'] ;
				$record->JHT =  $ds['jml_jht'] ;
				$record->JP =  $ds['jml_jp'] ;
				$record->HR_IP_LM = $ip_lama;
				$record->HR_IK_LM = $ik_lama;
				$record->HR_IPT_LM = $ipt_lama;
				// echo "<pre>";print_r($record);exit();
				$table3_new->writeRecord();
				$progres +=1;
				$this->M_transferreffgaji->updateProgres($user,$progres,"Memproses DBF PERNEW");
				//insert to t_log
				$aksi = 'MASTER PRESENSI';
				$detail = 'Update reff gaji staf naru noind='.$ds['noind'];
				$this->log_activity->activity_log($aksi, $detail);
				//
				session_write_close();
				flush();
			}
			$table3_new->close();
			$data_download .= '<a href="'.site_url("MasterPresensi/ReffGaji/TransferReffGaji/download?file=PERNEW".$periode."&time=".$waktu."&type=dbf") .'" class="btn btn-info">PERNEW'.$periode.'</a>';
		}

		//non-staff
		if (!empty($data_nonstaff)) {
			$table4 = new XBase\WritableTable(FCPATH."assets/upload/TransferReffGaji/lv_info.dbf");
			$table4->openWrite(FCPATH."assets/upload/TransferReffGaji/DATA-ABS".$periode.$waktu.".dbf");

			foreach ($data_nonstaff as $dn) {
				if (empty($dn['upamk']) or trim($dn['upamk']) == "") {
					$upamk_ = "0";
				}else{
					$upamk_ = $dn['upamk'];
				}
				if (empty($dn['um']) or trim($dn['um']) == "") {
					$um = "0";
				}else{
					$um = $dn['um'];
				}
				if (empty($dn['ims']) or trim($dn['ims']) == "") {
					$ims = "0";
				}else{
					$ims = $dn['ims'];
				}
				if (empty($dn['imm']) or trim($dn['imm']) == "") {
					$imm = "0";
				}else{
					$imm = $dn['imm'];
				}
				if (empty($dn['jam_lembur']) or trim($dn['jam_lembur']) == "") {
					$jam_lembur = "0";
				}else{
					$jam_lembur = $dn['jam_lembur'];
				}
				if (empty($dn['ipe']) or trim($dn['ipe']) == "") {
					$ipe = "0";
				}else{
					$ipe = $dn['ipe'];
				}
				if (empty($dn['ika']) or trim($dn['ika']) == "") {
					$ika = "0";
				}else{
					$ika = $dn['ika'];
				}
				if (empty($dn['ief']) or trim($dn['ief']) == "") {
					$ief = "0";
				}else{
					$ief = $dn['ief'];
				}
				if (empty($dn['ubt']) or trim($dn['ubt']) == "") {
					$ubt = "0";
				}else{
					$ubt = $dn['ubt'];
				}
				if (empty($dn['ubs']) or trim($dn['ubs']) == "") {
					$ubs = "0";
				}else{
					$ubs = $dn['ubs'];
				}
				if (empty($dn['um_puasa']) or trim($dn['um_puasa']) == "") {
					$um_puasa = "0";
				}else{
					$um_puasa = $dn['um_puasa'];
				}

				$sk_ct_susul = "0";
				if (substr($dn['noind'], 0,1) == "A" or substr($dn['noind'], 0,1) == "H") {
					if (trim($dn['ket']) !== "-") {
						$sk_ct_susul = substr(trim($dn['ket']), 0,strlen($dn['ket']) - 2);
					}else{
						$sk_ct_susul = "";
					}
				}
				$potkop = $dn['putkop'] + $dn['pikop'];

				$record = $table4->appendRecord();
				$record->NOINDLAMA = '';
				$record->NOIND = $dn['noind'] ;
				$record->NAMAOPR =  $dn['nama'] ;
				$record->KODESIE =  $dn['kodesie'] ;
				$record->TGL_GJ = '0000-00-00';
				$record->HMA15 = '';
				$record->HMA16 = '';
				$record->HMA17 = '';
				$record->HMA18 = '';
				$record->HMA19 = '';
				$record->HMA20 = '';
				$record->HMA21 = '';
				$record->HMA22 = '';
				$record->HMA23 = '';
				$record->HMA24 = '';
				$record->HMA25 = '';
				$record->HMA26 = '';
				$record->HMA27 = '';
				$record->HMA28 = '';
				$record->HMA29 = '';
				$record->HMA30 = '';
				$record->HMA31 = '';
				$record->HM01 = '';
				$record->HM02 = '';
				$record->HM03 = '';
				$record->HM04 = '';
				$record->HM05 = '';
				$record->HM06 = '';
				$record->HM07 = '';
				$record->HM08 = '';
				$record->HM09 = '';
				$record->HM10 = '';
				$record->HM11 = '';
				$record->HM12 = '';
				$record->HM13 = '';
				$record->HM14 = '';
				$record->HM15 = '';
				$record->HM16 = '';
				$record->HM17 = '';
				$record->HM18 = '';
				$record->HM19 = '';
				$record->HM20 = '';
				$record->HM21 = '';
				$record->HM22 = '';
				$record->HM23 = '';
				$record->HM24 = '';
				$record->HM25 = '';
				$record->HM26 = '';
				$record->HM27 = '';
				$record->HM28 = '';
				$record->HM29 = '';
				$record->HM30 = '';
				$record->HM31 = '';
				$record->JLB = 0;
				$record->HMP = 0;
				$record->HMU = 0;
				$record->HM = 0;
				$record->IPRES =  round($ipe,2) ;
				$record->IKOND =  round($ika,2) ;
				$record->IFUNG =  round($ief,2) ;
				$record->UBT =  round($ubt,2) ;
				$record->HUPAMK = round($upamk_,2) ;
				$record->IKSKP = 0;
				$record->IKSKU = 0;
				$record->IKSKS = 0;
				$record->IKSKM = 0;
				$record->IKJSP = 0;
				$record->IKJSU = 0;
				$record->IKJSS = 0;
				$record->IKJSM = 0;
				$record->T = 0;
				$record->SKD = 0;
				$record->JML_UM =  round($um,2) ;
				$record->HMS =  round($ims,2) ;
				$record->HMM =  round($imm,2) ;
				$record->JLB =  round($jam_lembur,2) ;
				$record->ABS = round($dn['htm'],2) ;
				$record->HL =  round($dn['hl'],2) ;
				$record->CTI =  $dn['ct'] ;
				$record->IK =  round($dn['ijin'], 2) ;
				$record->POTONGAN =  round($dn['pot']) + round($dn['plain']) ;
				$record->TAMBAHAN =  $dn['tamb_gaji'] ;
				$record->DUKA =  $dn['pduka'] ;
				$record->PT = 0;
				$record->PI = 0;
				$record->PM = 0;
				$record->DL = 0;
				$record->REV_SK = 0;
				$record->REV_SP = 0;
				$record->REV_CT = 0;
				$record->REV_IK = 0;
				$record->HC = 0;
				$record->CICIL =  $dn['cicil'] ;
				$record->POTKOP =  $potkop;
				$record->UBS =  round($ubs,2) ;
				$record->UM_PUASA =  $um_puasa ;
				$record->SK_CT = round($sk_ct_susul) ;
				$record->POT_2 =  $dn['potongan_str'] ;
				$record->TAMB_2 =  $dn['tambahan_str'] ;
				$record->KD_LKS =  $dn['lokasi_krj'] ;
				$record->KET = '';
				$record->UANGDL =  round($dn['dldobat']);
				$record->JKN =  $dn['jml_jkn'] ;
				$record->JHT =  $dn['jml_jht'] ;
				$record->JP =  $dn['jml_jp'] ;
				$table4->writeRecord();

				$progres +=1;
				$this->M_transferreffgaji->updateProgres($user,$progres,"Memproses DBF DATA-ABS");
				//insert to t_log
				$aksi = 'MASTER PRESENSI';
				$detail = 'Update reff gaji non staf noind='.$dn['noind'];
				$this->log_activity->activity_log($aksi, $detail);
				//
				session_write_close();
				flush();
			}
			$table4->close();
			$data_download .= '<a href="'.site_url("MasterPresensi/ReffGaji/TransferReffGaji/download?file=DATA-ABS".$periode."&time=".$waktu."&type=dbf") .'" class="btn btn-info">DATA-ABS'.$periode.'</a>';
		}

		//os
		if (!empty($data_os)) {
			$table5 = new XBase\WritableTable(FCPATH."assets/upload/TransferReffGaji/lv_info3.dbf");
			$table5->openWrite(FCPATH."assets/upload/TransferReffGaji/K".$periode.$waktu.".dbf");

			foreach ($data_os as $do) {
				if (empty($dn['upamk']) or trim($do['upamk']) == "") {
					$upamk_ = "0";
				}else{
					$upamk_ = $do['upamk'];
				}
				if (empty($do['um']) or trim($do['um']) == "") {
					$um = "0";
				}else{
					$um = $do['um'];
				}
				if (empty($do['ims']) or trim($do['ims']) == "") {
					$ims = "0";
				}else{
					$ims = $do['ims'];
				}
				if (empty($do['imm']) or trim($do['imm']) == "") {
					$imm = "0";
				}else{
					$imm = $do['imm'];
				}
				if (empty($do['jam_lembur']) or trim($do['jam_lembur']) == "") {
					$jam_lembur = "0";
				}else{
					$jam_lembur = $do['jam_lembur'];
				}
				if (empty($do['ipe']) or trim($do['ipe']) == "") {
					$ipe = "0";
				}else{
					$ipe = $do['ipe'];
				}
				if (empty($do['ika']) or trim($do['ika']) == "") {
					$ika = "0";
				}else{
					$ika = $do['ika'];
				}
				if (empty($do['ief']) or trim($do['ief']) == "") {
					$ief = "0";
				}else{
					$ief = $do['ief'];
				}
				if (empty($do['ubt']) or trim($do['ubt']) == "") {
					$ubt = "0";
				}else{
					$ubt = $do['ubt'];
				}
				if (empty($do['ubs']) or trim($do['ubs']) == "") {
					$ubs = "0";
				}else{
					$ubs = $do['ubs'];
				}
				if (empty($do['um_puasa']) or trim($do['um_puasa']) == "") {
					$um_puasa = "0";
				}else{
					$um_puasa = $do['um_puasa'];
				}

				$sk_ct_susul = "0";
				if (substr($do['noind'], 0,1) == "A" or substr($do['noind'], 0,1) == "H") {
					if (trim($do['ket']) !== "-") {
						$sk_ct_susul = substr(trim($do['ket']), 0,strlen($do['ket']) - 2);
					}else{
						$sk_ct_susul = "";
					}
				}
				$potkop = $do['putkop'] + $do['pikop'];

				$tpribadi = $this->M_transferreffgaji->getPribadi($do['noind']);
				$seksi = $this->M_transferreffgaji->getSeksi($do['kodesie']);
				if (!empty($tpribadi)) {
					$asalOS = trim($tpribadi->asal_outsourcing);
					if ($tpribadi->keluar == "t") {
						$tgl_keluar = $tpribadi->tglkeluar;
					}else{
						$tgl_keluar = '0000-00-00';
					}
					$record = $table5->appendRecord();
					$record->NOIND = $do['noind'];
					$record->NAMAOPR =  $do['nama'];
					$record->KODESIE =  $do['kodesie'];
					$record->SEKSI =  $seksi->seksi;
					$record->TGL_GJ = '0000-00-00';
					$record->JLB =  round($jam_lembur,2) ;
					$record->HMM =  round($imm,2) ;
					$record->IFUNG =  round($ief,2) ;
					$record->IK =  round($do['ijin'],2) ;
					$record->ABS =  round($do['htm'],2) ;
					$record->UM_PUASA =  $um_puasa ;
					$record->ASAL_OS =  $asalOS;
					$record->TGL_KELUAR =  $tgl_keluar ;
					$record->KD_LKS =  $do['lokasi_krj'];
					$record->POTONGAN = round($do['plain']);
					$record->JKN =  $do['jml_jkn'] ;
					$record->JHT =  $do['jml_jht'] ;
					$record->JP =  $do['jml_jp'] ;
					$table5->writeRecord();

					$progres +=1;
					$this->M_transferreffgaji->updateProgres($user,$progres,"Memproses DBF K");
					//insert to t_log
					$aksi = 'MASTER PRESENSI';
					$detail = 'Update reff gaji noind='.$do['noind'];
					$this->log_activity->activity_log($aksi, $detail);
					//
					session_write_close();
					flush();
				}
			}

			$table5->close();
			$data_download .= '<a href="'.site_url("MasterPresensi/ReffGaji/TransferReffGaji/download?file=K".$periode."&time=".$waktu."&type=dbf") .'" class="btn btn-info">K'.$periode.'</a>';
		}
		
		if (!empty($data_download)) {
			$data_download .= '<br><br>';
		}

		// cetak per kode induk
		if (!empty($data_cetak_per_kode_induk)) {
			$pdf_cetak_per_kode_induk = $this->pdf->load();
			$pdf_cetak_per_kode_induk->debug = true;
			$pdf_cetak_per_kode_induk = new mPDF('utf-8', 'A4-L', 8, '', 10, 10, 20, 25, 5, 5);
			$filename = 'CETAKALL'.$periode.$waktu.'.pdf';

			// $html_cetak_per_kode_induk = $this->cetakAll($data_cetak_per_kode_induk,$user,$progres);
			$html_cetak_per_kode_induk = "<!DOCTYPE html>
						<html>
							<body style=\"font-family: monospace; font-size: 8pt;\">";
			if (isset($data_cetak_per_kode_induk) && !empty($data_cetak_per_kode_induk)) {
				$simpan_kode_induk = "";
				$nomor = 1;
				$simpan_dldobat = 0;
				$simpan_pduka_spsi = 0;
				$simpan_putkop_pikop = 0;
				$simpan_plain = 0;
				$simpan_pot_plain = 0;
				foreach ($data_cetak_per_kode_induk as $key => $value) {
					if ($simpan_kode_induk != substr($value['noind'], 0, 1)) {
						if ($simpan_kode_induk !== "") {
							if (in_array($simpan_kode_induk, array("A","E","H","T","F","K","P"))) {
								$html_cetak_per_kode_induk .= "
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>".$simpan_pduka_spsi."</td>
									<td>".$simpan_pot_plain."</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>".$simpan_dldobat."</td>
									<td></td>
									<td></td>
								</tr>";
							}elseif(in_array($simpan_kode_induk, array("B","D","G","J"))){
								$html_cetak_per_kode_induk .= "
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>".$simpan_dldobat."</td>
									<td></td>
									<td>".$simpan_putkop_pikop."</td>
									<td>".$simpan_pduka_spsi."</td>
									<td>".$simpan_plain."</td>
								</tr>";
							}elseif(in_array($simpan_kode_induk, array("Q"))){
								$html_cetak_per_kode_induk .= "
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>".$simpan_dldobat."</td>
									<td></td>
									<td>".$simpan_putkop_pikop."</td>
									<td>".$simpan_pduka_spsi."</td>
									<td>".$simpan_plain."</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>";
							}else{
								$html_cetak_per_kode_induk .= "
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>";
							}
							$html_cetak_per_kode_induk .= "</tbody></table><div style='page-break-after: always'></div>";
						}
						if (in_array(substr($value['noind'], 0, 1), array("A","E","H","P","T"))) {
							$html_cetak_per_kode_induk .= "<table border='1' style='border: 0.5px solid black;border-collapse: collapse;width: 100%;font-size: 8pt'>
									<thead>
										<tr>
											<td style='width: 3%;text-align: center;'>NO</td>
											<td style='width: 6%;text-align: center;'>KODESIE</td>
											<td style='width: 4%;text-align: center;'>NOIND</td>
											<td style='width: 11%;text-align: center;'>NAMA</td>
											<td style='width: 3%;text-align: center;'>IP</td>
											<td style='width: 3%;text-align: center;'>IK</td>
											<td style='width: 3%;text-align: center;'>IF</td>
											<td style='width: 3%;text-align: center;'>HTM</td>
											<td style='width: 4%;text-align: center;'>UBT</td>
											<td style='width: 4%;text-align: center;'>UPAMK</td>
											<td style='width: 3%;text-align: center;'>UM</td>
											<td style='width: 3%;text-align: center;'>IMS</td>
											<td style='width: 3%;text-align: center;'>IMM</td>
											<td style='width: 4%;text-align: center;'>LEMBUR</td>
											<td style='width: 3%;text-align: center;'>CT</td>
											<td style='width: 3%;text-align: center;'>HL</td>
											<td style='width: 5%;text-align: center;'>P.DUKA</td>
											<td style='width: 4%;text-align: center;'>POT.</td>
											<td style='width: 4%;text-align: center;'>TAMB.</td>
											<td style='width: 4%;text-align: center;'>IJIN</td>
											<td style='width: 4%;text-align: center;'>UBS</td>
											<td style='width: 4%;text-align: center;'>UMP</td>
											<td style='width: 4%;text-align: center;'>DL&OBAT</td>
											<td style='width: 4%;text-align: center;'>POT.2</td>
											<td style='width: 4%;text-align: center;'>TAMB.2</td>
										</tr>
									</thead>
									<tbody>";
						}elseif(in_array(substr($value['noind'], 0, 1), array("B","D","G","J"))){
							$html_cetak_per_kode_induk .= "<table border='1' style='border: 0.5px solid black;border-collapse: collapse;font-size: 8pt'>
									<thead>
										<tr>
											<td style='width: 40px;text-align: center'>NO</td>
											<td style='width: 40px;text-align: center'>NOIND</td>
											<td style='width: 100px;text-align: center'>NAMA KARYAWAN</td>
											<td style='width: 110px;text-align: center'>NAMA SEKSI</td>
											<td style='width: 65px;text-align: center'>LOKASI KRJ</td>
											<td style='width: 30px;text-align: center'>IK</td>
											<td style='width: 30px;text-align: center'>IP</td>
											<td style='width: 30px;text-align: center'>IPT</td>
											<td style='width: 30px;text-align: center'>IF</td>
											<td style='width: 30px;text-align: center'>S2</td>
											<td style='width: 30px;text-align: center'>S3</td>
											<td style='width: 30px;text-align: center'>JAM LBR</td>
											<td style='width: 30px;text-align: center'>UM</td>
											<td style='width: 30px;text-align: center'>UMC</td>
											<td style='width: 30px;text-align: center'>UBT</td>
											<td style='width: 30px;text-align: center'>HUP AMK</td>
											<td style='width: 90px;text-align: center'>KET. ABSEN</td>
											<td style='width: 60px;text-align: center'>DL&OBAT</td>
											<td style='width: 40px;text-align: center'>I+ ABS</td>
											<td style='width: 60px;text-align: center'>P.KOPR</td>
											<td style='width: 60px;text-align: center'>P.DUKA+SPSI</td>
											<td style='width: 60px;text-align: center'>P.LAIN</td>
										</tr>
									</thead>
									<tbody>";
						}elseif(in_array(substr($value['noind'], 0, 1), array("Q"))){
							$html_cetak_per_kode_induk .= "<table border='1' style='border: 0.5px solid black;border-collapse: collapse;width: 100%;font-size: 8pt'>
									<thead>
										<tr>
											<td style='width: 4%;text-align: center'>NO</td>
											<td style='width: 4%;text-align: center'>NOIND</td>
											<td style='width: 8%;text-align: center'>NAMA KARYAWAN</td>
											<td style='width: 8%;text-align: center'>NAMA SEKSI</td>
											<td style='width: 8%;text-align: center'>LOKASI KRJ</td>
											<td style='width: 4%;text-align: center'>IK</td>
											<td style='width: 4%;text-align: center'>IP</td>
											<td style='width: 4%;text-align: center'>IPT</td>
											<td style='width: 4%;text-align: center'>IF</td>
											<td style='width: 4%;text-align: center'>S2</td>
											<td style='width: 4%;text-align: center'>S3</td>
											<td style='width: 4%;text-align: center'>JAMLBR</td>
											<td style='width: 4%;text-align: center'>UM</td>
											<td style='width: 4%;text-align: center'>UMC</td>
											<td style='width: 4%;text-align: center'>UBT</td>
											<td style='width: 4%;text-align: center'>HUPAMK</td>
											<td style='width: 4%;text-align: center'>KET.ABSEN</td>
											<td style='width: 4%;text-align: center'>DL&OBAT</td>
											<td style='width: 4%;text-align: center'>I+ABS</td>
											<td style='width: 4%;text-align: center'>P.KOPR</td>
											<td style='width: 4%;text-align: center'>P.DUKA+SPSI</td>
											<td style='width: 4%;text-align: center'>P.LAIN</td>
											<td style='width: 4%;text-align: center'>SEKOLAH</td>
											<td style='width: 4%;text-align: center'>JURUSAN</td>
											<td style='width: 4%;text-align: center'>PEND.</td>
										</tr>
									</thead>
									<tbody>";
						}elseif(in_array(substr($value['noind'], 0, 1), array("F","K"))){
							$html_cetak_per_kode_induk .= "<table border='1' style='border: 0.5px solid black;width:100%;border-collapse: collapse;'>
									<thead>
										<tr>
											<td style='width: 3%;text-align: center;'>NO</td>
											<td style='width: 6%;text-align: center;'>KODESIE</td>
											<td style='width: 4%;text-align: center;'>NOIND</td>
											<td style='width: 11%;text-align: center;'>NAMA</td>
											<td style='width: 3%;text-align: center;'>IP</td>
											<td style='width: 3%;text-align: center;'>IK</td>
											<td style='width: 3%;text-align: center;'>HM</td>
											<td style='width: 4%;text-align: center;'>HTM</td>
											<td style='width: 4%;text-align: center;'>UBT</td>
											<td style='width: 4%;text-align: center;'>UPAMK</td>
											<td style='width: 3%;text-align: center;'>UM</td>
											<td style='width: 3%;text-align: center;'>IMS</td>
											<td style='width: 3%;text-align: center;'>IMM</td>
											<td style='width: 4%;text-align: center;'>LEMBUR</td>
											<td style='width: 3%;text-align: center;'>CT</td>
											<td style='width: 3%;text-align: center;'>HL</td>
											<td style='width: 5%;text-align: center;'>P.DUKA</td>
											<td style='width: 4%;text-align: center;'>POT.</td>
											<td style='width: 4%;text-align: center;'>TAMB.</td>
											<td style='width: 3%;text-align: center;'>IJIN</td>
											<td style='width: 4%;text-align: center;'>UBS</td>
											<td style='width: 4%;text-align: center;'>UMP</td>
											<td style='width: 4%;text-align: center;'>DL&OBAT</td>
											<td style='width: 4%;text-align: center;'>POT.2</td>
											<td style='width: 4%;text-align: center;'>TAMB.2</td>
										</tr>
									</thead>
									<tbody>";
						}else{
							$html_cetak_per_kode_induk .= "<table border='1' style='border: 0.5px solid black;border-collapse: collapse;'>
									<thead>
										<tr>
											<td>NO</td>
											<td>NOIND</td>
											<td>NAMA KARYAWAN</td>
											<td>NAMA SEKSI</td>
											<td>LOKASI KRJ</td>
										</tr>
									</thead>
									<tbody>";
						}
						$nomor = 1;
						$simpan_dldobat = 0;
						$simpan_pduka_spsi = 0;
						$simpan_putkop_pikop = 0;
						$simpan_plain = 0;
						$simpan_pot_plain = 0;
					}
					if ($value['cutoff'] == '~') {
						$tanda = '~';
					}elseif ($value['cutoff'] == '0') {
						$tanda = '';
					}else{
						$tanda = '*';
					}
					if (in_array(substr($value['noind'], 0, 1), array("A","E","H","T","F","K","P"))) {
						$html_cetak_per_kode_induk .= "
						<tr>
							<td>".$tanda.$nomor."</td>
							<td>".$value['kodesie']."</td>
							<td>".$value['noind']."</td>
							<td>".substr($value['nama'], 0, 18)."</td>
							<td style='text-align: right;'>".$value['ipe']."</td>
							<td style='text-align: right;'>".$value['ika']."</td>
							<td style='text-align: right;'>".$value['ief']."</td>
							<td style='text-align: right;'>".$value['htm']."</td>
							<td style='text-align: right;'>".$value['ubt']."</td>
							<td style='text-align: right;'>".$value['upamk']."</td>
							<td style='text-align: right;'>".$value['um']."</td>
							<td style='text-align: right;'>".$value['ims']."</td>
							<td style='text-align: right;'>".$value['imm']."</td>
							<td style='text-align: right;'>".$value['jam_lembur']."</td>
							<td style='text-align: right;'>".$value['ct']."</td>
							<td style='text-align: right;'>".$value['hl']."</td>
							<td style='text-align: right;'>".(intval(trim($value['pduka'])) + intval(trim($value['pspsi'])))."</td>
							<td style='text-align: right;'>".(intval(trim($value['pot'])) + intval(trim($value['plain'])))."</td>
							<td style='text-align: right;'>".$value['tamb_gaji']."</td>
							<td style='text-align: right;'>".$value['ijin']."</td>
							<td style='text-align: right;'>".$value['ubs_rp']."</td>
							<td style='text-align: right;'>".$value['um_puasa']."</td>
							<td style='text-align: right;'>".$value['dldobat']."</td>
							<td style='text-align: right;'>".$value['potongan_str']."</td>
							<td style='text-align: right;'>".$value['tambahan_str']."</td>
						</tr>";
					}elseif(in_array(substr($value['noind'], 0, 1), array("B","D","G","J"))){
						$html_cetak_per_kode_induk .= "
						<tr>
							<td>".$tanda.$nomor."</td>
							<td>".$value['noind']."</td>
							<td>".substr($value['nama'],0,15)."</td>
							<td>".substr($value['seksi'],0,16)."</td>
							<td>".substr($value['lokasi_krj'],0,9)."</td>
							<td style='text-align: right;'>".$value['ika']."</td>
							<td style='text-align: right;'>".$value['ipe']."</td>
							<td style='text-align: right;'>".$value['ipet']."</td>
							<td style='text-align: right;'>".$value['ief']."</td>
							<td style='text-align: right;'>".$value['ims']."</td>
							<td style='text-align: right;'>".$value['imm']."</td>
							<td style='text-align: right;'>".$value['jam_lembur']."</td>
							<td style='text-align: right;'>".($value['hl'] + $value['ct'] + $value['um_puasa'])."</td>
							<td style='text-align: right;'>".$value['um_cabang']."</td>
							<td style='text-align: right;'>".$value['ubt']."</td>
							<td style='text-align: right;'>".$value['upamk']."</td>
							<td>".wordwrap(str_replace(".00", "", trim($value['ket'])),13,"<br>", true)."</td>
							<td style='text-align: right;'>".$value['dldobat']."</td>
							<td style='text-align: right;'>".($value['ijin'] + $value['htm'])."</td>
							<td style='text-align: right;'>".(intval(trim($value['putkop'])) + intval(trim($value['pikop'])))."</td>
							<td style='text-align: right;'>".(intval(trim($value['pduka'])) + intval(trim($value['pspsi'])))."</td>
							<td style='text-align: right;'>".$value['plain']."</td>
						</tr>";
					}elseif(in_array(substr($value['noind'], 0, 1), array("Q"))){
						$html_cetak_per_kode_induk .= "
						<tr>
							<td>".$tanda.$nomor."</td>
							<td>".$value['noind']."</td>
							<td>".substr($value['nama'],0,15)."</td>
							<td>".substr($value['seksi'],0,16)."</td>
							<td>".substr($value['lokasi_krj'],0,9)."</td>
							<td style='text-align: right;'>".$value['ika']."</td>
							<td style='text-align: right;'>".$value['ipe']."</td>
							<td style='text-align: right;'>".$value['ipet']."</td>
							<td style='text-align: right;'>".$value['ief']."</td>
							<td style='text-align: right;'>".$value['ims']."</td>
							<td style='text-align: right;'>".$value['imm']."</td>
							<td style='text-align: right;'>".$value['jam_lembur']."</td>
							<td style='text-align: right;'>".($value['hl'] + $value['ct'] + $value['um_puasa'])."</td>
							<td style='text-align: right;'>".$value['um_cabang']."</td>
							<td style='text-align: right;'>".$value['ubt']."</td>
							<td style='text-align: right;'>".$value['upamk']."</td>
							<td>".$value['ket']."</td>
							<td style='text-align: right;'>".$value['dldobat']."</td>
							<td style='text-align: right;'>".($value['ijin'] + $value['htm'])."</td>
							<td style='text-align: right;'>".(intval(trim($value['putkop'])) + intval(trim($value['pikop'])))."</td>
							<td style='text-align: right;'>".(intval(trim($value['pduka'])) + intval(trim($value['pspsi'])))."</td>
							<td style='text-align: right;'>".$value['plain']."</td>
							<td>".substr($value['sekolah'], 0, 10)."</td>
							<td>".substr($value['jurusan'], 0, 10)."</td>
							<td>".substr($value['pendidikan'], 0, 5)."</td>
						</tr>";
					}else{
						$html_cetak_per_kode_induk .= "
						<tr>
							<td>".$tanda.$nomor."</td>
							<td>".$value['noind']."</td>
							<td>".$value['nama']."</td>
							<td>".$value['seksi']."</td>
							<td>".$value['lokasi_krj']."</td>
						</tr>";
					}
					$simpan_kode_induk = substr($value['noind'], 0, 1);

					$simpan_dldobat += intval(trim($value['dldobat']));
					$simpan_pduka_spsi += (intval(trim($value['pduka'])) + intval(trim($value['pspsi'])));
					$simpan_putkop_pikop += (intval(trim($value['putkop'])) + intval(trim($value['pikop'])));
					$simpan_plain += intval(trim($value['plain']));
					$simpan_pot_plain = (intval(trim($value['pot'])) + intval(trim($value['plain'])));

					$nomor++;
					$progres +=1;
					$this->M_transferreffgaji->updateProgres($user,$progres,"Memproses PDF CETAKALL");
					session_write_close();
					flush();
				}
			}
			if (in_array($simpan_kode_induk, array("A","E","H","T","F","K","P"))) {
				$html_cetak_per_kode_induk .= "
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>".$simpan_pduka_spsi."</td>
					<td>".$simpan_pot_plain."</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>".$simpan_dldobat."</td>
					<td></td>
					<td></td>
				</tr>";
			}elseif(in_array($simpan_kode_induk, array("B","D","G","J"))){
				$html_cetak_per_kode_induk .= "
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>".$simpan_dldobat."</td>
					<td></td>
					<td>".$simpan_putkop_pikop."</td>
					<td>".$simpan_pduka_spsi."</td>
					<td>".$simpan_plain."</td>
				</tr>";
			}elseif(in_array($simpan_kode_induk, array("Q"))){
				$html_cetak_per_kode_induk .= "
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>".$simpan_dldobat."</td>
					<td></td>
					<td>".$simpan_putkop_pikop."</td>
					<td>".$simpan_pduka_spsi."</td>
					<td>".$simpan_plain."</td>
					<td></td>
					<td></td>
					<td></td>
				</tr>";
			}else{
				$html_cetak_per_kode_induk .= "
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>";
			}
			$html_cetak_per_kode_induk .= "</tbody>
									</table>
								</body>
							</html>";
			$pdf_cetak_per_kode_induk->setHTMLHeader("<table style='width: 100%'>
									<tr>
										<td style='width: 10%'>Data Bulan</td>
										<td style='width: 3%'>:</td>
										<td style='width: 10%'>$bulan_gaji</td>
										<td style='width: 10%'>Tanggal Cetak</td>
										<td style='width: 3%'>:</td>
										<td style='width: 64%'>".$hari_string."</td>
									</tr>
									<tr>
										<td colspan='6'>$periode_penggajian</td>
									</tr>
								</table>");
			$pdf_cetak_per_kode_induk->SetHTMLFooter("<table style='width: 100%'>
					<tr>
						<td style='width: 50%'></td>
						<td style='width: 20%;text-align: center;'>Kasie,</td>
						<td style='width: 20%;text-align: center;'>Atasan,</td>
					</tr>
					<tr>
						<td style='vertical-align: bottom'><i>* Dibayar cutoff.<br>Halaman ini dicetak melalui Aplikasi QuickERP-MasterPresensi oleh ".$this->session->user." ".$this->session->employee." pada tgl. ".$waktu_string.".</i></td>
						<td></td>
						<td>&nbsp;<br>&nbsp;</td>
					</tr>
					<tr>
						<td><i>Halaman {PAGENO} dari {nb}</i></td>
						<td style='text-align: center;'>(".ucwords(strtolower($this->session->employee)).")</td>
						<td style='text-align: center;'>(..................)</td>
					</tr>
				</table>");
			$pdf_cetak_per_kode_induk->WriteHTML($html_cetak_per_kode_induk);
			// $pdf_cetak_per_kode_induk->Output($filename, 'I');
			$pdf_cetak_per_kode_induk->Output(FCPATH."assets/upload/TransferReffGaji/".$filename, 'F');
			$data_download .= '<a href="'.site_url("MasterPresensi/ReffGaji/TransferReffGaji/download?file=CETAKALL".$periode."&time=".$waktu."&type=pdf") .'" class="btn btn-danger">CETAKALL'.$periode.'</a>';
		}

		// cetak per kode seksi
		if (!empty($data_cetak_per_kodesie)) {
			$pdf_cetak_per_kodesie = $this->pdf->load();
			$pdf_cetak_per_kodesie->debug = true;
			$pdf_cetak_per_kodesie = new mPDF('utf-8', 'A4-L', 8, '', 10, 10, 10, 20, 10, 5);
			$filename = 'CETAKSEKSI'.$periode.$waktu.'.pdf';

			$html_cetak_per_kodesie = "<!DOCTYPE html>
						<html>
							<body style=\"font-family: monospace; font-size: 8pt;\">";
			if (isset($data_cetak_per_kodesie) && !empty($data_cetak_per_kodesie)) {
				$simpan_kode_induk = "";
				$simpan_kodesie = "";
				$simpan_asal_os = "";
				$nomor = 1;
				foreach ($data_cetak_per_kodesie as $key => $value) {
					if ($simpan_kode_induk != substr($value['noind'], 0, 1) && $simpan_kode_induk !== "") {
						$html_cetak_per_kodesie .= "</tbody></table><div style='page-break-after: always'></div>";
					}
					if (substr($value['kodesie'], 0, 7) != $simpan_kodesie || (in_array(substr($value['noind'], 0, 1), array("P","K")) && $simpan_asal_os != $value['asal_outsourcing'])) {
						if ($simpan_kodesie != "" && $simpan_kode_induk == substr($value['noind'], 0, 1)) {
							$html_cetak_per_kodesie .= "</tbody></table><br><br>";
						}
						if(in_array(substr($value['noind'], 0, 1), array("P","K"))){
							$asal_os = "<tr>
											<td>Unit</td>
											<td>:</td>
											<td colspan='4'>".$value['asal_outsourcing']."</td>
										</tr>";
						}else{
							$asal_os = "";
						}
						$html_cetak_per_kodesie .= "<table style='width: 100%'>
									".$asal_os."
									<tr>
										<td>Unit</td>
										<td>:</td>
										<td colspan='4'>".$value['unit']."</td>
									</tr>
									<tr>
										<td>Seksi</td>
										<td>:</td>
										<td colspan='4'>".$value['seksi']."</td>
									</tr>
									<tr>
										<td style='width: 10%'>Data Bulan</td>
										<td style='width: 3%'>:</td>
										<td style='width: 10%'>$bulan_gaji</td>
										<td style='width: 10%'>Tanggal Cetak</td>
										<td style='width: 3%'>:</td>
										<td style='width: 64%'>".$hari_string."</td>
									</tr>
									<tr>
										<td colspan='6'>$periode_penggajian</td>
									</tr>
								</table>";
						if (in_array(substr($value['noind'], 0, 1), array("A","E","H","T","P"))) {
							$html_cetak_per_kodesie .= "<table border='1' style='border: 0.5px solid black;width:100%;border-collapse: collapse;'>
									<thead>
										<tr>
											<td style='width: 3%;text-align: center;'>NO</td>
											<td style='width: 6%;text-align: center;'>KODESIE</td>
											<td style='width: 4%;text-align: center;'>NOIND</td>
											<td style='width: 11%;text-align: center;'>NAMA</td>
											<td style='width: 3%;text-align: center;'>IP</td>
											<td style='width: 3%;text-align: center;'>IK</td>
											<td style='width: 3%;text-align: center;'>IF</td>
											<td style='width: 3%;text-align: center;'>HTM</td>
											<td style='width: 4%;text-align: center;'>UBT</td>
											<td style='width: 4%;text-align: center;'>UPAMK</td>
											<td style='width: 3%;text-align: center;'>UM</td>
											<td style='width: 3%;text-align: center;'>IMS</td>
											<td style='width: 3%;text-align: center;'>IMM</td>
											<td style='width: 4%;text-align: center;'>LEMBUR</td>
											<td style='width: 3%;text-align: center;'>CT</td>
											<td style='width: 3%;text-align: center;'>HL</td>
											<td style='width: 5%;text-align: center;'>P.DUKA</td>
											<td style='width: 4%;text-align: center;'>POT.</td>
											<td style='width: 4%;text-align: center;'>TAMB.</td>
											<td style='width: 4%;text-align: center;'>IJIN</td>
											<td style='width: 4%;text-align: center;'>UBS</td>
											<td style='width: 4%;text-align: center;'>UMP</td>
											<td style='width: 4%;text-align: center;'>DL&OBAT</td>
											<td style='width: 4%;text-align: center;'>POT.2</td>
											<td style='width: 4%;text-align: center;'>TAMB.2</td>
										</tr>
									</thead>
									<tbody>";
						}elseif(in_array(substr($value['noind'], 0, 1), array("B","D","G","J"))){
							$html_cetak_per_kodesie .= "<table border='1' style='border: 0.5px solid black;border-collapse: collapse;'>
									<thead>
										<tr>
											<td style='width: 40px;text-align: center'>NO</td>
											<td style='width: 40px;text-align: center'>NOIND</td>
											<td style='width: 100px;text-align: center'>NAMA KARYAWAN</td>
											<td style='width: 110px;text-align: center'>NAMA SEKSI</td>
											<td style='width: 65px;text-align: center'>LOKASI KRJ</td>
											<td style='width: 30px;text-align: center'>IK</td>
											<td style='width: 30px;text-align: center'>IP</td>
											<td style='width: 30px;text-align: center'>IPT</td>
											<td style='width: 30px;text-align: center'>IF</td>
											<td style='width: 30px;text-align: center'>S2</td>
											<td style='width: 30px;text-align: center'>S3</td>
											<td style='width: 30px;text-align: center'>JAM LBR</td>
											<td style='width: 30px;text-align: center'>UM</td>
											<td style='width: 30px;text-align: center'>UMC</td>
											<td style='width: 30px;text-align: center'>UBT</td>
											<td style='width: 30px;text-align: center'>HUP AMK</td>
											<td style='width: 90px;text-align: center'>KET. ABSEN</td>
											<td style='width: 60px;text-align: center'>DL&OBAT</td>
											<td style='width: 40px;text-align: center'>I+ ABS</td>
											<td style='width: 60px;text-align: center'>P.KOPR</td>
											<td style='width: 60px;text-align: center'>P.DUKA+SPSI</td>
											<td style='width: 60px;text-align: center'>P.LAIN</td>
										</tr>
									</thead>
									<tbody>";
						}elseif(in_array(substr($value['noind'], 0, 1), array("Q"))){
							$html_cetak_per_kodesie .= "<table border='1' style='border: 0.5px solid black;width:100%;border-collapse: collapse;'>
									<thead>
										<tr>
											<td style='width: 4%;text-align: center'>NO</td>
											<td style='width: 4%;text-align: center'>NOIND</td>
											<td style='width: 8%;text-align: center'>NAMA KARYAWAN</td>
											<td style='width: 8%;text-align: center'>NAMA SEKSI</td>
											<td style='width: 8%;text-align: center'>LOKASI KRJ</td>
											<td style='width: 4%;text-align: center'>IK</td>
											<td style='width: 4%;text-align: center'>IP</td>
											<td style='width: 4%;text-align: center'>IPT</td>
											<td style='width: 4%;text-align: center'>IF</td>
											<td style='width: 4%;text-align: center'>S2</td>
											<td style='width: 4%;text-align: center'>S3</td>
											<td style='width: 4%;text-align: center'>JAMLBR</td>
											<td style='width: 4%;text-align: center'>UM</td>
											<td style='width: 4%;text-align: center'>UMC</td>
											<td style='width: 4%;text-align: center'>UBT</td>
											<td style='width: 4%;text-align: center'>HUPAMK</td>
											<td style='width: 4%;text-align: center'>KET.ABSEN</td>
											<td style='width: 4%;text-align: center'>DL&OBAT</td>
											<td style='width: 4%;text-align: center'>I+ABS</td>
											<td style='width: 4%;text-align: center'>P.KOPR</td>
											<td style='width: 4%;text-align: center'>P.DUKA+SPSI</td>
											<td style='width: 4%;text-align: center'>P.LAIN</td>
											<td style='width: 4%;text-align: center'>SEKOLAH</td>
											<td style='width: 4%;text-align: center'>JURUSAN</td>
											<td style='width: 4%;text-align: center'>PEND.</td>
										</tr>
									</thead>
									<tbody>";
						}elseif(in_array(substr($value['noind'], 0, 1), array("F","K"))){
							$html_cetak_per_kodesie .= "<table border='1' style='border: 0.5px solid black;width:100%;border-collapse: collapse;'>
									<thead>
										<tr>
											<td style='width: 3%;text-align: center;'>NO</td>
											<td style='width: 6%;text-align: center;'>KODESIE</td>
											<td style='width: 4%;text-align: center;'>NOIND</td>
											<td style='width: 11%;text-align: center;'>NAMA</td>
											<td style='width: 3%;text-align: center;'>IP</td>
											<td style='width: 3%;text-align: center;'>IK</td>
											<td style='width: 3%;text-align: center;'>HM</td>
											<td style='width: 4%;text-align: center;'>HTM</td>
											<td style='width: 4%;text-align: center;'>UBT</td>
											<td style='width: 4%;text-align: center;'>UPAMK</td>
											<td style='width: 3%;text-align: center;'>UM</td>
											<td style='width: 3%;text-align: center;'>IMS</td>
											<td style='width: 3%;text-align: center;'>IMM</td>
											<td style='width: 4%;text-align: center;'>LEMBUR</td>
											<td style='width: 3%;text-align: center;'>CT</td>
											<td style='width: 3%;text-align: center;'>HL</td>
											<td style='width: 5%;text-align: center;'>P.DUKA</td>
											<td style='width: 4%;text-align: center;'>POT.</td>
											<td style='width: 4%;text-align: center;'>TAMB.</td>
											<td style='width: 3%;text-align: center;'>IJIN</td>
											<td style='width: 4%;text-align: center;'>UBS</td>
											<td style='width: 4%;text-align: center;'>UMP</td>
											<td style='width: 4%;text-align: center;'>DL&OBAT</td>
											<td style='width: 4%;text-align: center;'>POT.2</td>
											<td style='width: 4%;text-align: center;'>TAMB.2</td>
										</tr>
									</thead>
									<tbody>";
						}else{
							$html_cetak_per_kodesie .= "<table border='1' style='border: 0.5px solid black;border-collapse: collapse;'>
									<thead>
										<tr>
											<td>NO</td>
											<td>NOIND</td>
											<td>NAMA KARYAWAN</td>
											<td>NAMA SEKSI</td>
											<td>LOKASI KRJ</td>
										</tr>
									</thead>
									<tbody>";
						}
						$nomor = 1;
					}
					if ($value['cutoff'] == '~') {
						$tanda = '~';
					}elseif ($value['cutoff'] == '0') {
						$tanda = '';
					}else{
						$tanda = '*';
					}
					if (in_array(substr($value['noind'], 0, 1), array("A","E","H","T","F","K","P"))) {
						$html_cetak_per_kodesie .= "
						<tr>
							<td>".$tanda.$nomor."</td>
							<td>".$value['kodesie']."</td>
							<td>".$value['noind']."</td>
							<td>".substr($value['nama'], 0, 18)."</td>
							<td style='text-align: right;'>".$value['ipe']."</td>
							<td style='text-align: right;'>".$value['ika']."</td>
							<td style='text-align: right;'>".$value['ief']."</td>
							<td style='text-align: right;'>".$value['htm']."</td>
							<td style='text-align: right;'>".$value['ubt']."</td>
							<td style='text-align: right;'>".$value['upamk']."</td>
							<td style='text-align: right;'>".$value['um']."</td>
							<td style='text-align: right;'>".$value['ims']."</td>
							<td style='text-align: right;'>".$value['imm']."</td>
							<td style='text-align: right;'>".$value['jam_lembur']."</td>
							<td style='text-align: right;'>".$value['ct']."</td>
							<td style='text-align: right;'>".$value['hl']."</td>
							<td style='text-align: right;'>".(intval(trim($value['pduka'])) + intval(trim($value['pspsi'])))."</td>
							<td style='text-align: right;'>".(intval(trim($value['pot'])) + intval(trim($value['plain'])))."</td>
							<td style='text-align: right;'>".$value['tamb_gaji']."</td>
							<td style='text-align: right;'>".$value['ijin']."</td>
							<td style='text-align: right;'>".$value['ubs_rp']."</td>
							<td style='text-align: right;'>".$value['um_puasa']."</td>
							<td style='text-align: right;'>".$value['dldobat']."</td>
							<td style='text-align: right;'>".$value['potongan_str']."</td>
							<td style='text-align: right;'>".$value['tambahan_str']."</td>
						</tr>";
					}elseif(in_array(substr($value['noind'], 0, 1), array("B","D","G","J"))){
						$html_cetak_per_kodesie .= "
						<tr>
							<td>".$tanda.$nomor."</td>
							<td>".$value['noind']."</td>
							<td>".substr($value['nama'],0,15)."</td>
							<td>".substr($value['seksi'],0,16)."</td>
							<td>".substr($value['lokasi_krj'],0,9)."</td>
							<td style='text-align: right;'>".$value['ika']."</td>
							<td style='text-align: right;'>".$value['ipe']."</td>
							<td style='text-align: right;'>".$value['ipet']."</td>
							<td style='text-align: right;'>".$value['ief']."</td>
							<td style='text-align: right;'>".$value['ims']."</td>
							<td style='text-align: right;'>".$value['imm']."</td>
							<td style='text-align: right;'>".$value['jam_lembur']."</td>
							<td style='text-align: right;'>".($value['hl'] + $value['ct'] + $value['um_puasa'])."</td>
							<td style='text-align: right;'>".$value['um_cabang']."</td>
							<td style='text-align: right;'>".$value['ubt']."</td>
							<td style='text-align: right;'>".$value['upamk']."</td>
							<td>".wordwrap(str_replace(".00", "", trim($value['ket'])),13,"<br>", true)."</td>
							<td style='text-align: right;'>".$value['dldobat']."</td>
							<td style='text-align: right;'>".($value['ijin'] + $value['htm'])."</td>
							<td style='text-align: right;'>".(intval(trim($value['putkop'])) + intval(trim($value['pikop'])))."</td>
							<td style='text-align: right;'>".(intval(trim($value['pduka'])) + intval(trim($value['pspsi'])))."</td>
							<td style='text-align: right;'>".$value['plain']."</td>
						</tr>";
					}elseif(in_array(substr($value['noind'], 0, 1), array("Q"))){
						$html_cetak_per_kode_induk .= "
						<tr>
							<td>".$tanda.$nomor."</td>
							<td>".$value['noind']."</td>
							<td>".substr($value['nama'],0,15)."</td>
							<td>".substr($value['seksi'],0,16)."</td>
							<td>".substr($value['lokasi_krj'],0,9)."</td>
							<td style='text-align: right;'>".$value['ika']."</td>
							<td style='text-align: right;'>".$value['ipe']."</td>
							<td style='text-align: right;'>".$value['ipet']."</td>
							<td style='text-align: right;'>".$value['ief']."</td>
							<td style='text-align: right;'>".$value['ims']."</td>
							<td style='text-align: right;'>".$value['imm']."</td>
							<td style='text-align: right;'>".$value['jam_lembur']."</td>
							<td style='text-align: right;'>".($value['hl'] + $value['ct'] + $value['um_puasa'])."</td>
							<td style='text-align: right;'>".$value['um_cabang']."</td>
							<td style='text-align: right;'>".$value['ubt']."</td>
							<td style='text-align: right;'>".$value['upamk']."</td>
							<td>".$value['ket']."</td>
							<td style='text-align: right;'>".$value['dldobat']."</td>
							<td style='text-align: right;'>".($value['ijin'] + $value['htm'])."</td>
							<td style='text-align: right;'>".(intval(trim($value['putkop'])) + intval(trim($value['pikop'])))."</td>
							<td style='text-align: right;'>".(intval(trim($value['pduka'])) + intval(trim($value['pspsi'])))."</td>
							<td style='text-align: right;'>".$value['plain']."</td>
							<td>".substr($value['sekolah'], 0, 10)."</td>
							<td>".substr($value['jurusan'], 0, 10)."</td>
							<td>".substr($value['pendidikan'], 0, 5)."</td>
						</tr>";
					}else{
						$html_cetak_per_kodesie .= "
						<tr>
							<td>".$tanda.$nomor."</td>
							<td>".$value['noind']."</td>
							<td>".$value['nama']."</td>
							<td>".$value['seksi']."</td>
							<td>".$value['lokasi_krj']."</td>
						</tr>";
					}
					$simpan_kodesie = substr($value['kodesie'], 0, 7);
					$simpan_asal_os = trim($value['asal_outsourcing']);
					$simpan_kode_induk = substr($value['noind'], 0, 1);
					$nomor++;
					$progres +=1;
					$this->M_transferreffgaji->updateProgres($user,$progres,"Memproses PDF CETAKSEKSI");
					session_write_close();
					flush();
				}
			}
			$html_cetak_per_kodesie .= "</tbody>
									</table>
								</body>
							</html>";
			// echo $html_cetak_per_kodesie;exit();
			$pdf_cetak_per_kodesie->SetHTMLFooter("<table style='width: 100%'>
					<tr>
						<td style='width: 50%'></td>
						<td style='width: 20%;text-align: center;'>Kasie,</td>
						<td style='width: 20%;text-align: center;'>Atasan,</td>
					</tr>
					<tr>
						<td style='vertical-align: bottom'><i>* Dibayar cutoff.<br>Halaman ini dicetak melalui Aplikasi QuickERP-MasterPresensi oleh ".$this->session->user." ".$this->session->employee." pada tgl. ".$waktu_string.".</i></td>
						<td></td>
						<td>&nbsp;<br>&nbsp;</td>
					</tr>
					<tr>
						<td><i>Halaman {PAGENO} dari {nb}</i></td>
						<td style='text-align: center;'>(".ucwords(strtolower($this->session->employee)).")</td>
						<td style='text-align: center;'>(..................)</td>
					</tr>
				</table>");
			$pdf_cetak_per_kodesie->WriteHTML($html_cetak_per_kodesie);
			// $pdf_cetak_per_kodesie->Output($filename, 'I');
			$pdf_cetak_per_kodesie->Output(FCPATH."assets/upload/TransferReffGaji/".$filename, 'F');
			$data_download .= '<a href="'.site_url("MasterPresensi/ReffGaji/TransferReffGaji/download?file=CETAKSEKSI".$periode."&time=".$waktu."&type=pdf") .'" class="btn btn-danger">CETAKSEKSI'.$periode.'</a>';
		}

		// rekap nominal
		if (!empty($data_rekap)) {
			$pdf_rekap = $this->pdf->load();
			$pdf_rekap->debug = true;
			$pdf_rekap = new mPDF('utf-8', 'A4', 8, '', 10, 10, 10, 10, 10, 5);
			$filename = 'REKAP'.$periode.$waktu.'.pdf';
			// $html_rekap = $this->rekapNominal($data_rekap,$user,$progres,$bulan_gaji,$hari_string,$periode_penggajian,$noMemoStaff,$noMemoNonstaff);
			$html_rekap = "<!DOCTYPE html>
			<html>
			<body style=\"font-family: arial; font-size: 12pt;\">
				<div style=\"padding-top: 150px;\">
					<h2 style=\"text-align: center\">MEMO</h2>
					<table style='width: 100%'>
						<tr>
							<td style=\"width: 18%\">No</td>
							<td style=\"width: 2%\">:</td>
							<td style=\"width: 60%\">$noMemoNonstaff</td>
							<td style=\"width: 20%\">".strftime('%d %B %Y')."</td>
						</tr>
						<tr>
							<td>Hal</td>
							<td>:</td>
							<td colspan=\"2\">Memo Penggajian Pekerja Non Staf Aktif</td>
						</tr>
						<tr>
							<td>Dari</td>
							<td>:</td>
							<td colspan=\"2\">Seksi Hubungan Kerja</td>
						</tr>
						<tr>
							<td><b>Kepada</b></td>
							<td>:</td>
							<td colspan=\"2\"><b>Bpk Subardi (Akuntansi)</b></td>
						</tr>
					</table>
					<p>Dengan hormat,</p>
					<p>Mohon diperhitungkan pada penggajian bulan <b>$bulan_gaji</b> untuk pekerja NON STAFF, dengan data terlampir.</p>
					<p>Demikian pemberitahuan ini kami sampaikan. Atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>
					<table style='width: 100%'>
						<tr>
							<td style=\"width:50%;text-align: center\">Mengetahui,</td>
							<td style=\"width:50%;text-align: center\">Hormat kami,</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td style=\"text-align: center\"><b><u>Bambang Yudhosuseno</b></u></td>
							<td style=\"text-align: center\"><b><u>Reny Sulistiyaningtyas</b></u></td>
						</tr>
						<tr>
							<td style=\"text-align: center\">As. Ka. Dept. Personalia</td>
							<td style=\"text-align: center\">Kasie Madya Hubungan Kerja</td>
						</tr>
					</table>
				</div>
				<div style=\"page-break-after: always;\"></div>
				<div style=\"padding-top: 150px;\">
					<h2 style=\"text-align: center\">MEMO</h2>
					<table style='width: 100%'>
						<tr>
							<td style=\"width: 18%\">No</td>
							<td style=\"width: 2%\">:</td>
							<td style=\"width: 60%\">$noMemoStaff</td>
							<td style=\"width: 20%\">".strftime('%d %B %Y',time())."</td>
						</tr>
						<tr>
							<td>Hal</td>
							<td>:</td>
							<td colspan=\"2\">Memo Penggajian Pekerja Non Staf Aktif</td>
						</tr>
						<tr>
							<td>Dari</td>
							<td>:</td>
							<td colspan=\"2\">Seksi Hubungan Kerja</td>
						</tr>
						<tr>
							<td><b>Kepada</b></td>
							<td>:</td>
							<td colspan=\"2\"><b>Ibu RR. Angela</b></td>
						</tr>
					</table>
					<p>Dengan hormat,</p>
					<p>Mohon diperhitungkan pada penggajian bulan <b>$bulan_gaji</b> untuk pekerja STAFF, dengan data terlampir.</p>
					<p>Demikian pemberitahuan ini kami sampaikan. Atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>
					<table style='width: 100%'>
						<tr>
							<td style=\"width:50%;text-align: center\">Mengetahui,</td>
							<td style=\"width:50%;text-align: center\">Hormat kami,</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td style=\"text-align: center\"><b><u>Bambang Yudhosuseno</b></u></td>
							<td style=\"text-align: center\"><b><u>Reny Sulistiyaningtyas</b></u></td>
						</tr>
						<tr>
							<td style=\"text-align: center\">As. Ka. Dept. Personalia</td>
							<td style=\"text-align: center\">Kasie Madya Hubungan Kerja</td>
						</tr>
					</table>
				</div>
				<div style=\"page-break-after: always;\"></div>
				<label>Rekap Nominal Penggajian</label>
				<table style='width: 100%'>
					<tr>
						<td style='width: 20%'>Data Bulan</td>
						<td style='width: 3%'>:</td>
						<td style='width: 27%'>$bulan_gaji</td>
						<td style='width: 20%'>Tanggal Cetak</td>
						<td style='width: 3%'>:</td>
						<td style='width: 27%'>$hari_string</td>
					</tr>
					<tr>
						<td colspan='6'>$periode_penggajian</td>
					</tr>
				</table>
				<table style=\"border-collapse: collapse;border: 0.5px solid black;width: 100%\" border=\"1\">
					<thead>
						<tr>
							<th style=\"width: 5%\">No</th>
							<th style=\"width: 11%\">Kode Induk</th>
							<th style=\"width: 14%\">DL&OBAT</th>
							<th style=\"width: 14%\">P.DUKA</th>
							<th style=\"width: 14%\">SPSI</th>
							<th style=\"width: 14%\">IKOP</th>
							<th style=\"width: 14%\">UTKOP</th>
							<th style=\"width: 14%\">POT. LAIN</th>
						</tr>
					</thead>
					<tbody>";
			$nomor = 1;
			$total_uang_dl = 0;
			$total_pot_duka = 0;
			$total_pot_ikop = 0;
			$total_pot_spsi = 0;
			$total_pot_utkop = 0;
			$total_pot_lain = 0;
			if (isset($data_rekap) && !empty($data_rekap)) {
				foreach ($data_rekap as $key => $value) {
					$html_rekap .= "<tr>
							<td style=\"margin-left: 15px;margin-right: 15px;text-align: center;\">".$nomor."</td>
							<td style=\"margin-left: 15px;margin-right: 15px;text-align: center;\">".$value['kode_induk']."</td>
							<td style=\"margin-left: 15px;margin-right: 15px;text-align: right;\">".number_format( $value['uang_dl'], 0, ',', '.')."</td>
							<td style=\"margin-left: 15px;margin-right: 15px;text-align: right;\">".number_format( $value['pot_duka'], 0, ',', '.')."</td>
							<td style=\"margin-left: 15px;margin-right: 15px;text-align: right;\">".number_format( $value['pot_spsi'], 0, ',', '.')."</td>
							<td style=\"margin-left: 15px;margin-right: 15px;text-align: right;\">".number_format( $value['pot_ikop'], 0, ',', '.')."</td>
							<td style=\"margin-left: 15px;margin-right: 15px;text-align: right;\">".number_format( $value['pot_utkop'], 0, ',', '.')."</td>
							<td style=\"margin-left: 15px;margin-right: 15px;text-align: right;\">".number_format( $value['pot_lain'], 0, ',', '.')."</td>
						</tr>";
					$total_uang_dl 		+= $value['uang_dl'];
					$total_pot_duka 	+= $value['pot_duka'];
					$total_pot_ikop 	+= $value['pot_ikop'];
					$total_pot_spsi 	+= $value['pot_spsi'];
					$total_pot_utkop 	+= $value['pot_utkop'];
					$total_pot_lain 	+= $value['pot_lain'];
					$nomor++;
					$progres +=1;
					$this->M_transferreffgaji->updateProgres($user,$progres,"Memproses PDF REKAP");
					session_write_close();
					flush();
				}
			}
			$html_rekap .= "	<tr>
							<td colspan=\"2\">Total</td>
							<td style=\"margin-left: 15px;margin-right: 15px;text-align: right;\">".number_format($total_uang_dl, 0, ',','.')."</td>
							<td style=\"margin-left: 15px;margin-right: 15px;text-align: right;\">".number_format($total_pot_duka, 0, ',','.')."</td>
							<td style=\"margin-left: 15px;margin-right: 15px;text-align: right;\">".number_format($total_pot_spsi, 0, ',','.')."</td>
							<td style=\"margin-left: 15px;margin-right: 15px;text-align: right;\">".number_format($total_pot_ikop, 0, ',','.')."</td>
							<td style=\"margin-left: 15px;margin-right: 15px;text-align: right;\">".number_format($total_pot_utkop, 0, ',','.')."</td>
							<td style=\"margin-left: 15px;margin-right: 15px;text-align: right;\">".number_format($total_pot_lain, 0, ',','.')."</td>
						</tr>
					</tbody>
				</table>
				<table style=\"width: 100%\">
					<tr>
						<td style=\"width: 60%\"></td>
						<td style=\"width: 40%;text-align: center;\">Yogyakarta, ".strftime("%d %B %Y")."</td>
					</tr>
					<tr>
						<td style=\"width: 60%\"></td>
						<td style=\"width: 40%;text-align: center;\">Dicetak oleh,</td>
					</tr>
					<tr>
						<td style=\"width: 60%\"></td>
						<td style=\"width: 40%\">&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br></td>
					</tr>
					<tr>
						<td style=\"width: 60%\"></td>
						<td style=\"width: 40%;text-align: center;\">".ucwords(strtolower($this->session->employee))."</td>
					</tr>
				</table>
			</body>
			</html>";
			$pdf_rekap->SetHTMLFooter("<i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-MasterPresensi oleh ".$this->session->user." ".$this->session->employee." pada tgl. ".$waktu_string.". Halaman {PAGENO} dari {nb}</i>");
			$pdf_rekap->WriteHTML($html_rekap);
			$pdf_rekap->Output(FCPATH."assets/upload/TransferReffGaji/".$filename, 'F');
			$data_download .= '<a href="'.site_url("MasterPresensi/ReffGaji/TransferReffGaji/download?file=REKAP".$periode."&time=".$waktu."&type=pdf") .'" class="btn btn-danger">REKAP'.$periode.'</a>';
		}
		//finish

		$lama_waktu = time() - $waktu;
		$data_download = '
		<h5>lama proses :'.($lama_waktu/60).' Menit</h5>
		<br>
		<br>'.$data_download;
		echo $data_download;		
	}

	public function cekProgress(){
		$user = $this->input->get('user');
		$data = $this->M_transferreffgaji->getProgres($user);
		if (!empty($data)) {
			if ($data->progress == $data->total) {
				$this->M_transferreffgaji->deleteProgres($user);
				//insert to t_log
				$aksi = 'MASTER PRESENSI';
				$detail = "Delete \"Presensi\".progress_transfer_reffgaji where user_ = '$user' and menu = 'transferreffgaji'";
				$this->log_activity->activity_log($aksi, $detail);
				//
			}
			$json = array(
				'progress' 		=> floor(($data->progress/$data->total)*100),
				'keterangan' 	=> $data->keterangan
			);
			echo json_encode($json);
		}else{
			echo "kosong";
		}
	}

	public function download(){
		$file = $this->input->get('file');
		$waktu = $this->input->get('time');
		$type = $this->input->get('type');
		// print_r($_GET);exit();
		// echo site_url('assets/upload/TransferReffGaji/'.$file.$waktu.".dbf");exit();
		$data = file_get_contents(site_url('assets/upload/TransferReffGaji/'.$file.$waktu.".".$type));
		// echo $data;
		header('Content-disposition: attachment; filename='.$file.'.'.$type);
		// header("Content-type: application/octet-stream");
		echo $data;
	}

	public function search(){
		$key = $this->input->get('term');
		$jenis = $this->input->get('jenis');
		$data = array();
		if($jenis == "khusus"){
			$data = $this->M_transferreffgaji->getPekerjaKhusus($key);
		}else{
			$data = $this->M_transferreffgaji->getPekerjaAktif($key);
		}
		echo json_encode($data);
	}

	public function prosesKhusus(){
		$periode = $this->input->post('MPR-transferreffgaji-khusus-periode');
		$noind = $this->input->post('MPR-transferreffgaji-khusus-noind');
		$atasan = $this->input->post('MPR-transferreffgaji-khusus-noind-atasan');
		$user = $this->session->user;
		// echo "<pre>";print_r($_POST);exit();
		$data = $this->M_transferreffgaji->getDetailPekerjaKhusus($noind,$periode);
		$ttd = $this->M_transferreffgaji->getNamaTerang($atasan,$user,$noind);
		$sks = $this->M_transferreffgaji->getSeksiPekerja($noind);
		$frm = $this->M_transferreffgaji->getFormulaKhususPekerja($noind);
		$this->load->library('excel');
		$doc = $this->excel;
		// print_r($_POST);exit();
		// set active sheet
		$doc->setActiveSheetIndex(0);
		$objexcel = $doc->getActiveSheet();
		// read data to active sheet
		$objexcel->setCellValue('A1','Data Presensi');
		$objexcel->setCellValue('A2','=A11');
		$objexcel->setCellValue('B2','-');
		$objexcel->setCellValue('A3','No. Induk');
		$objexcel->setCellValue('B3',$noind);
		$objexcel->setCellValue('A4','Nama');
		$objexcel->setCellValue('B4',$ttd->nama_pekerja);
		$objexcel->setCellValue('A5',$sks->jab);
		$objexcel->setCellValue('B5',$sks->jab_2);

		if($frm->formula_id == 4) { // J Pak Sudadyo
			$objexcel->setCellValue('A10','TANGGAL');
			$objexcel->setCellValue('B10','HARI');
			$objexcel->setCellValue('C10','WAKTU');
			$objexcel->mergeCells('C10:D10');
			$objexcel->setCellValue('E10','JML');
			$objexcel->setCellValue('F10','IST');
			$objexcel->setCellValue('G10','TTL JAM');
			$objexcel->setCellValue('H10','JAM KERJA');

			$num = 11;
			$nomor = 1;
			foreach($data as $gj){
				$objexcel->setCellValue('A'.$num,date("Y-m-d",strtotime($gj['dates'])));
				$objexcel->setCellValue('B'.$num,$gj['nama_hari']);
				if($gj['masuk'] == "00:00:00" and $gj['keluar'] == "00:00:00"){
					$objexcel->setCellValue('C'.$num,$gj['keterangan']);
					$objexcel->mergeCells("C$num:D$num");
				}else{
					$objexcel->setCellValue('C'.$num,$gj['masuk']);
					$objexcel->setCellValue('D'.$num,$gj['keluar']);
				}
				if ($gj['jumlah'] == '0' and $gj['nama_hari'] == 'Minggu') {
					$objexcel->setCellValue('H'.$num,$gj['jam_kerja']);
				}else{
					$objexcel->setCellValue('E'.$num,$gj['jumlah']);
					$objexcel->setCellValue('F'.$num,$gj['ttl_pot_ist']);
					$objexcel->setCellValue('G'.$num,$gj['ttl_jam']);
					$objexcel->setCellValue('H'.$num,$gj['jam_kerja']);
				}
				$num++;
				$nomor++;
			}
			$objexcel->setCellValue('C2','=A'.($num-1));
			$objexcel->setCellValue('G'.$num,'=SUM(G11:G'.($num-1).')');
			$objexcel->setCellValue('H'.$num,'JAM');

			$num += 2;
			$objexcel->setCellValue('F'.$num,"Yogyakarta, ".strftime("%d %B %Y"));
			$objexcel->mergeCells("F$num:H$num");
			$num += 1;
			$objexcel->setCellValue('B'.$num,"Mengetahui,");
			$objexcel->mergeCells("B$num:D$num");
			$objexcel->setCellValue('F'.$num,"Dicetak Oleh,");
			$objexcel->mergeCells("F$num:H$num");
			$num += 3;
			$objexcel->setCellValue('B'.$num,$ttd->nama_atasan);
			$objexcel->mergeCells("B$num:D$num");
			$objexcel->setCellValue('F'.$num,$ttd->nama_user);
			$objexcel->mergeCells("F$num:H$num");
			$num += 1;
			$objexcel->setCellValue('B'.$num,$ttd->jabatan_atasan);
			$objexcel->mergeCells("B$num:D$num");
			$objexcel->setCellValue('F'.$num,$ttd->jabatan_user);
			$objexcel->mergeCells("F$num:H$num");

			$objexcel->duplicateStyleArray(
						array(
							'alignment' => array(
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
								'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
							),
							'borders' => array(
								'allborders' => array(
									'style' => PHPExcel_Style_Border::BORDER_THIN)
							),
							'fill' =>array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'startcolor' => array(
									'argb' => '00C0C0C0')
							),
							'font' => array(
								'bold' => true
							)
						),'A10:H10');
			$objexcel->duplicateStyleArray(
						array(
							'font' => array(
								'bold' => true
							)
						),'A1:H9');
			$objexcel->duplicateStyleArray(
						array(
							'borders' => array(
								'allborders' => array(
									'style' => PHPExcel_Style_Border::BORDER_THIN)
							)
						),'A11:H'.(9 + $nomor));

		}elseif ($frm->formula_id == 5) { // G Bu Esti
			$objexcel->setCellValue('A10','TANGGAL');
			$objexcel->setCellValue('B10','HARI');
			$objexcel->setCellValue('C10','WAKTU');
			$objexcel->mergeCells('C10:D10');
			$objexcel->setCellValue('E10','JML');
			$objexcel->setCellValue('F10','IST');
			$objexcel->setCellValue('G10','TTL JAM');
			$objexcel->setCellValue('H10','JAM KERJA');
			$objexcel->setCellValue('I10','TTL HARI');

			$num = 11;
			$nomor = 1;
			foreach($data as $gj){
				$objexcel->setCellValue('A'.$num,date("Y-m-d",strtotime($gj['dates'])));
				$objexcel->setCellValue('B'.$num,$gj['nama_hari']);
				if($gj['masuk'] == "00:00:00" and $gj['keluar'] == "00:00:00"){
					$objexcel->setCellValue('C'.$num,$gj['keterangan']);
					$objexcel->mergeCells("C$num:D$num");
				}else{
					$objexcel->setCellValue('C'.$num,$gj['masuk']);
					$objexcel->setCellValue('D'.$num,$gj['keluar']);
				}
				if ($gj['jumlah'] == '0' and $gj['nama_hari'] == 'Minggu') {
					$objexcel->setCellValue('H'.$num,$gj['jam_kerja']);
				}else{
					$objexcel->setCellValue('E'.$num,$gj['jumlah']);
					$objexcel->setCellValue('F'.$num,$gj['ttl_pot_ist']);
					$objexcel->setCellValue('G'.$num,$gj['ttl_jam']);
					$objexcel->setCellValue('H'.$num,$gj['jam_kerja']);
					$objexcel->setCellValue('I'.$num,$gj['ttl_hari']);
				}
				$num++;
				$nomor++;
			}
			$objexcel->setCellValue('C2','=A'.($num-1));
			$objexcel->setCellValue('G'.$num,'=SUM(G11:G'.($num-1).')');
			$objexcel->setCellValue('H'.$num,'JAM');
			$objexcel->setCellValue('I'.$num,'=SUM(I11:I'.($num-1).')');
			$objexcel->setCellValue('J'.$num,'HARI');

			$num += 2;
			$objexcel->setCellValue('F'.$num,"Yogyakarta, ".strftime("%d %B %Y"));
			$objexcel->mergeCells("F$num:H$num");
			$num += 1;
			$objexcel->setCellValue('B'.$num,"Mengetahui,");
			$objexcel->mergeCells("B$num:D$num");
			$objexcel->setCellValue('F'.$num,"Dicetak Oleh,");
			$objexcel->mergeCells("F$num:H$num");
			$num += 3;
			$objexcel->setCellValue('B'.$num,$ttd->nama_atasan);
			$objexcel->mergeCells("B$num:D$num");
			$objexcel->setCellValue('F'.$num,$ttd->nama_user);
			$objexcel->mergeCells("F$num:H$num");
			$num += 1;
			$objexcel->setCellValue('B'.$num,$ttd->jabatan_atasan);
			$objexcel->mergeCells("B$num:D$num");
			$objexcel->setCellValue('F'.$num,$ttd->jabatan_user);
			$objexcel->mergeCells("F$num:H$num");

			$objexcel->duplicateStyleArray(
						array(
							'alignment' => array(
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
								'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
							),
							'borders' => array(
								'allborders' => array(
									'style' => PHPExcel_Style_Border::BORDER_THIN)
							),
							'fill' =>array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'startcolor' => array(
									'argb' => '00C0C0C0')
							),
							'font' => array(
								'bold' => true
							)
						),'A10:I10');
			$objexcel->duplicateStyleArray(
						array(
							'font' => array(
								'bold' => true
							)
						),'A1:I9');
			$objexcel->duplicateStyleArray(
						array(
							'borders' => array(
								'allborders' => array(
									'style' => PHPExcel_Style_Border::BORDER_THIN)
							)
						),'A11:I'.(9 + $nomor));

		}elseif ($frm->formula_id == 3) { // G Pak Giovan
			$objexcel->setCellValue('A10','TANGGAL');
			$objexcel->setCellValue('B10','HARI');
			$objexcel->setCellValue('C10','WAKTU');
			$objexcel->mergeCells('C10:D10');
			$objexcel->setCellValue('E10','JML');
			$objexcel->setCellValue('F10','IST');
			$objexcel->setCellValue('G10','TTL JAM');
			$objexcel->setCellValue('H10','TTL JAM/MINGGU');

			$num = 11;
			$nomor = 1;
			$ttl_minggu = 0;
			$minggu = 0;
			$awal_minggu = 11;
			$jam_seminggu = 0;
			$dihitung_bulanlalu = $this->M_transferreffgaji->getDetailGiovanBulanLalu($noind,date("Y-m-d",strtotime($data[0]['dates'])));
			
			foreach($data as $gj){
				if($minggu == $gj['minggu']){
					$ttl_minggu += $gj['ttl_jam'];
				}else{
					if($minggu !== 0){
						$jam_seminggu = 0;
						if($awal_minggu == 11){
							if ($dihitung_bulanlalu > 32) {
								$jam_seminggu = 0;
							}else{
								$jam_seminggu = $ttl_minggu + $dihitung_bulanlalu;
								if($jam_seminggu > 32){							
									$jam_seminggu = 32 - $dihitung_bulanlalu;							
								}else{
									$jam_seminggu = $ttl_minggu;
								}								
							}
						}else{
							$jam_seminggu = $ttl_minggu;
							if($jam_seminggu > 32){							
								$jam_seminggu = 32;							
							}
						}
						$objexcel->setCellValue('H'.($awal_minggu),$jam_seminggu);
						$objexcel->mergeCells("H$awal_minggu:H".($num - 2));
						$awal_minggu = $num;
						$ttl_minggu = $gj['ttl_jam'];
					}else{
						$ttl_minggu = $gj['ttl_jam'];
					}
				}
				$minggu = $gj['minggu'];

				$objexcel->setCellValue('A'.$num,date("Y-m-d",strtotime($gj['dates'])));
				$objexcel->setCellValue('B'.$num,$gj['nama_hari']);
				if($gj['masuk'] == "00:00:00" and $gj['keluar'] == "00:00:00"){
					$objexcel->setCellValue('C'.$num,$gj['keterangan']);
					$objexcel->mergeCells("C$num:D$num");
				}else{
					$objexcel->setCellValue('C'.$num,$gj['masuk']);
					$objexcel->setCellValue('D'.$num,$gj['keluar']);				
				}
				if ($gj['jumlah'] == '0' and $gj['nama_hari'] == 'Minggu') {

				}else{
					$objexcel->setCellValue('E'.$num,$gj['jumlah']);
					$objexcel->setCellValue('F'.$num,$gj['ttl_pot_ist']);
					$objexcel->setCellValue('G'.$num,$gj['ttl_jam']);					
				}
				$num++;
				$nomor++;
			}
			if($minggu !== 0){
				if($ttl_minggu > 32){
					$objexcel->setCellValue('H'.($awal_minggu),32);							
				}else{
					$objexcel->setCellValue('H'.($awal_minggu),$ttl_minggu);
				}
				$objexcel->mergeCells("H$awal_minggu:H".($num - 1));
			}
			$objexcel->setCellValue('C2','=A'.($num-1));
			$objexcel->setCellValue('H'.$num,'=SUM(H11:H'.($num-1).')');
			$objexcel->setCellValue('I'.$num,'JAM');

			$num += 2;
			$objexcel->setCellValue('F'.$num,"Yogyakarta, ".strftime("%d %B %Y"));
			$objexcel->mergeCells("F$num:H$num");
			$num += 1;
			$objexcel->setCellValue('B'.$num,"Mengetahui,");
			$objexcel->mergeCells("B$num:D$num");
			$objexcel->setCellValue('F'.$num,"Dicetak Oleh,");
			$objexcel->mergeCells("F$num:H$num");
			$num += 3;
			$objexcel->setCellValue('B'.$num,$ttd->nama_atasan);
			$objexcel->mergeCells("B$num:D$num");
			$objexcel->setCellValue('F'.$num,$ttd->nama_user);
			$objexcel->mergeCells("F$num:H$num");
			$num += 1;
			$objexcel->setCellValue('B'.$num,$ttd->jabatan_atasan);
			$objexcel->mergeCells("B$num:D$num");
			$objexcel->setCellValue('F'.$num,$ttd->jabatan_user);
			$objexcel->mergeCells("F$num:H$num");

			$objexcel->duplicateStyleArray(
						array(
							'alignment' => array(
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
								'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
							),
							'borders' => array(
								'allborders' => array(
									'style' => PHPExcel_Style_Border::BORDER_THIN)
							),
							'fill' =>array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'startcolor' => array(
									'argb' => '00C0C0C0')
							),
							'font' => array(
								'bold' => true
							)
						),'A10:H10');
			$objexcel->duplicateStyleArray(
						array(
							'font' => array(
								'bold' => true
							)
						),'A1:H9');
			$objexcel->duplicateStyleArray(
						array(
							'borders' => array(
								'allborders' => array(
									'style' => PHPExcel_Style_Border::BORDER_THIN)
							)
						),'A11:H'.(9 + $nomor));
		}			

		//save our workbook as this file name
		$filename = "PekerjaKhusus$periode$noind.xls";
		//mime type
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($doc, 'Excel5');
		$objWriter->save('php://output');
	}

}

?>