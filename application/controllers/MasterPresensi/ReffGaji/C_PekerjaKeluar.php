<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');
/**
 *
 */
setlocale(LC_TIME, "id_ID.utf8");
date_default_timezone_set("Asia/Jakarta");

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

		$this->load->library('Log_Activity');
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

	public function proses_hitung($puasa,$tgl_puasa,$prd_gaji,$status_pekerja,$noind,$pot_seragam,$chk_khusus,$khusus){
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

		$pekerja_keluar = $this->M_pekerjakeluar->getPekerjaKeluar($prd_gaji, $noind_pekerja);

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
			$gaji[$angka]['um_dl'] = 0;
			$gaji[$angka]['ket'] = "";
			$gaji[$angka]['pot_susulan'] = "";
			$gaji[$angka]['tam_susulan'] = "";
			$gaji[$angka]['jml_duka'] = 0;
			$gaji[$angka]['nom_duka'] = 0;

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
			$kom_jml_jp		= 0;
			$kom_um_dl 		= 0;
			$kom_ket		= "";
			$kom_pot_susulan = "";
			$kom_tam_susulan = "";
			$kom_jml_duka  = 0;
			$kom_nom_duka  = 0;

			$tgl_bulan_awal = $this->M_pekerjakeluar->cekProsesGaji($pkj['noind'], $pkj['tglkeluar']);
			$tgl_cut_awal = $this->M_pekerjakeluar->cekProsesGaji2($pkj['noind'], $pkj['tglkeluar']);
			$tgl_cut_awal_ = $tgl_cut_awal;
			$tgl_bulan_berjalan_awal = $this->M_pekerjakeluar->cekProsesGaji3($pkj['noind'], $pkj['tglkeluar']);
			$tgl_keluar = $pkj['tglkeluar'];

			if($chk_khusus == "khusus"){
				if ($khusus == "sebelum") {
					$tgl_keluar = date('Y-m-d',strtotime($tgl_bulan_berjalan_awal.' -1 day'));
				}else{
					$tgl_cut_awal = $tgl_bulan_berjalan_awal;
					$tgl_bulan_awal = $tgl_bulan_berjalan_awal;
				}
			}

			$cek_cutoff = $this->M_pekerjakeluar->cek_cutoff_custom($pkj['noind'],$pkj['tglkeluar']);
+			$hitung_cutoff = $this->M_pekerjakeluar->cek_cutoff_custom_hitung($pkj['noind'],$pkj['tglkeluar']);

			// komponen utama start
			if ($status_pekerja == 'A' || $status_pekerja == 'B' || $status_pekerja == 'D') {
				$kom_ip = $this->M_pekerjakeluar->set_Ip($pkj['noind'],$tgl_bulan_awal,$tgl_keluar);
			}

			if ($status_pekerja == 'A' || $status_pekerja == 'B') {
				$kom_ubt = $this->M_pekerjakeluar->hitung_Ubt($pkj['noind'],$tgl_bulan_awal,$tgl_keluar);
				if($pkj['upamk'] == 'Ya'){
					$kom_upamk = $this->M_pekerjakeluar->hitung_Upamk($pkj['noind'],$tgl_bulan_awal,$tgl_keluar);
				}
			}

			if ($status_pekerja == 'A' || $status_pekerja == 'B' || $status_pekerja == 'D' || $status_pekerja == 'T' || $status_pekerja == 'E' || $status_pekerja == 'H') {
				if ($status_pekerja == 'H' || $status_pekerja == 'T') {
					$tgl_diangkat_3_bulan = date('Y-m-d', strtotime( $pkj['diangkat']." +3 months"));
					if($pkj['tglkeluar'] >= $tgl_diangkat_3_bulan){
						$kom_ip = $this->M_pekerjakeluar->set_Ik($pkj['noind'],$tgl_bulan_awal,$tgl_keluar);
					}else{
						$kom_ip = 0;
					}
				}else{
					$kom_ik = $this->M_pekerjakeluar->set_Ik($pkj['noind'],$tgl_bulan_awal,$tgl_keluar);
				}
			}

			if ($status_pekerja == 'D' || $status_pekerja == 'E') {
				$cek_noind_berubah = $this->M_pekerjakeluar->cek_noind_berubah($pkj['noind']);
				if($cek_noind_berubah > 0){
					$kom_tik = $this->M_pekerjakeluar->hitung_tik_diangkat($pkj['noind'],$tgl_cut_awal,$tgl_keluar);
					$kom_tm  = $this->M_pekerjakeluar->hitung_tm_diangkat($pkj['noind'],$tgl_cut_awal,$tgl_keluar);
					$kom_htm = $kom_tik + $kom_tm;
				}else{
					if($cek_cutoff == "0"){
						$kom_tik = $this->M_pekerjakeluar->hitung_tik_tdk_cutoff($pkj['noind'],$tgl_cut_awal,$pkj['tglkeluar'],$chk_khusus,$khusus,$hitung_cutoff);
						$kom_tm  = $this->M_pekerjakeluar->hitung_tm_tdk_cutoff($pkj['noind'],$tgl_cut_awal,$pkj['tglkeluar'],$chk_khusus,$khusus,$hitung_cutoff);
						$kom_htm = $kom_tik + $kom_tm;
					}else{
						$kom_tik = $this->M_pekerjakeluar->hitung_tik($pkj['noind'],$tgl_cut_awal,$pkj['tglkeluar'],$chk_khusus,$khusus,$hitung_cutoff);
						$kom_tm  = $this->M_pekerjakeluar->hitung_tm($pkj['noind'],$tgl_cut_awal,$pkj['tglkeluar'],$chk_khusus,$khusus,$hitung_cutoff);
						$kom_htm = $kom_tik + $kom_tm;
					}
				}
			}else{
				if($cek_cutoff == "0"){
					$kom_tik = $this->M_pekerjakeluar->hitung_tik_tdk_cutoff($pkj['noind'],$tgl_cut_awal,$pkj['tglkeluar'],$chk_khusus,$khusus,$hitung_cutoff);
					$kom_tm  = $this->M_pekerjakeluar->hitung_tm_tdk_cutoff($pkj['noind'],$tgl_cut_awal,$pkj['tglkeluar'],$chk_khusus,$khusus,$hitung_cutoff);
					$kom_htm = $kom_tik + $kom_tm;
				}else{
					$kom_tik = $this->M_pekerjakeluar->hitung_tik($pkj['noind'],$tgl_cut_awal,$pkj['tglkeluar'],$chk_khusus,$khusus,$hitung_cutoff);
					$kom_tm  = $this->M_pekerjakeluar->hitung_tm($pkj['noind'],$tgl_cut_awal,$pkj['tglkeluar'],$chk_khusus,$khusus,$hitung_cutoff);
					$kom_htm = $kom_tik + $kom_tm;
				}
			}

			$kom_sisa_cuti = $this->M_pekerjakeluar->get_sisa_cuti($pkj['noind'],$tgl_keluar);

			if ($puasa == 'puasa') {
				$kom_um_puasa = $this->M_pekerjakeluar->getKomUmPuasa($pkj['noind'],$tgl_bulan_awal,$tgl_keluar,$tgl_puasa);
			}

			if ($status_pekerja == 'A' || ($status_pekerja == 'B' && $pkj['kd_jabatan'] >= 14 && $pkj['kd_jabatan'] <= 12) || ($status_pekerja == 'D' && $pkj['kd_jabatan'] == 13) || $status_pekerja == 'E' || $status_pekerja == 'T' || $status_pekerja == 'H' || ($status_pekerja == 'J' && $pkj['kd_jabatan'] >= 14 && $pkj['kd_jabatan'] <= 12) ) {
				$kom_lembur = $this->M_pekerjakeluar->hitung_lembur($pkj['noind'],$tgl_cut_awal,$tgl_keluar);
			}

			$kom_ims = $this->M_pekerjakeluar->hitung_ims($pkj['noind'],$tgl_cut_awal,$tgl_keluar);
			$kom_imm = $this->M_pekerjakeluar->hitung_imm($pkj['noind'],$tgl_cut_awal,$tgl_keluar);

			if ($pkj['id_lokasi_kerja'] !== '01' && $pkj['id_lokasi_kerja'] !== '02' && $pkj['id_lokasi_kerja'] !== '03' && $pkj['id_lokasi_kerja'] !== '04' && (substr($pkj['noind'], 0, 1) == 'B' || substr($pkj['noind'], 0, 1) == 'D') ) {
				$kom_um_cabang = $this->M_pekerjakeluar->hitung_um_cabang($pkj['noind'],$tgl_cut_awal,$tgl_keluar);
			}

			if ($pkj['id_lokasi_kerja'] == '02') {
				if($status_pekerja == 'B' || $status_pekerja == 'D' || $status_pekerja == 'T' || $status_pekerja == 'J'){
					$kom_ipt = $this->M_pekerjakeluar->set_ipt($pkj['noind'],$tgl_bulan_awal,$tgl_keluar);
				}

			}

			$kom_tambahan = $this->M_pekerjakeluar->hitung_tambahan($pkj['noind'],$tgl_keluar);

			if ($status_pekerja == 'B' || $status_pekerja == 'D' || $status_pekerja == 'J') {
				if($cek_cutoff == 0){
					$kom_if = $this->M_pekerjakeluar->hitung_If_tdk_cutoff($pkj['noind'],$tgl_cut_awal,$pkj['tglkeluar'],$chk_khusus,$khusus,$hitung_cutoff);
				}else{
					$kom_if = $this->M_pekerjakeluar->hitung_If($pkj['noind'],$tgl_cut_awal,$pkj['tglkeluar'],$chk_khusus,$khusus,$hitung_cutoff);
				}
			}


			if ($chk_khusus == "khusus") {
				if ($khusus == "sesudah") {
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

					$kom_um_dl = $this->M_pekerjakeluar->get_uang_dl($pkj['noind'],$tgl_cut_awal_,$tgl_keluar);
					
					$kom_jml_duka = $this->M_pekerjakeluar->jumlah_duka($pkj['noind'],$tgl_cut_awal_,$tgl_keluar);
					$kom_nom_duka = $this->M_pekerjakeluar->nominal_duka($pkj['noind'],$tgl_cut_awal_,$tgl_keluar);
				}
			}else{
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

				$kom_um_dl = $this->M_pekerjakeluar->get_uang_dl($pkj['noind'],$tgl_cut_awal,$tgl_keluar);
				
				$kom_jml_duka = $this->M_pekerjakeluar->jumlah_duka($pkj['noind'],$tgl_cut_awal,$tgl_keluar);
				$kom_nom_duka = $this->M_pekerjakeluar->nominal_duka($pkj['noind'],$tgl_cut_awal,$tgl_keluar);
			}



			//komponen utama end

			//susulan start
			$kom_sk_susulan = $this->M_pekerjakeluar->get_sk_susulan($pkj['noind']);
			$kom_cuti_susulan = $this->M_pekerjakeluar->get_cuti_susulan($pkj['noind']);

			$susulan = $this->M_pekerjakeluar->get_kom_susulan($pkj['noind'],$tgl_keluar);
			if (!empty($susulan)) {
				$ifsusulan = "0";
                $gpsusulan = "0";
                $ipsusulan = "0";
                $iksusulan = "0";
                $upamksusulan = "0";
                $ubtsusulan = "0";
                $umcsusulan = "0";
                $iptsusulan = "0";
                $immsusulan = "0";
                $imssusulan = "0";

                $gpsusulantotal = "0";
                $ifsusulantotal = "0";
                $ipsusulantotal = "0";
                $iksusulantotal = "0";
                $upamksusulantotal = "0";
                $ubtsusulantotal = "0";
                $umcsusulantotal = "0";
                $iptsusulantotal = "0";
                $immsusulantotal = "0";
                $imssusulantotal = "0";

                foreach ($susulan as $ssl) {
                	$d1 = new DateTime($ssl['tanggal']);
                	$d2 = new DateTime($tgl_cut_awal);
                	$dateInterval = $d2->diff($d1);
                	$totalselisih = 12 * $dateInterval->y + $dateInterval->m;

                	If ($status_pekerja == "B" Or $status_pekerja == "D" Or $status_pekerja == "J") {
                        $ifsusulan = $this->M_pekerjakeluar->if_susulan($pkj['noind'], $ssl['tanggal']);
                        $ifsusulan = round($ifsusulan, 2);
                        $ifsusulantotal = $ifsusulantotal + ($ifsusulan - $ssl['if_']);
                	}

                    $gpsusulan = 1 - $this->M_pekerjakeluar->htm_susulan($pkj['noind'], $ssl['tanggal'], $ssl['tanggal']);
                    $gpsusulan = round($gpsusulan, 2);
                    $gpsusulantotal = $gpsusulantotal + ($gpsusulan - $ssl['gp']);

                    If (($status_pekerja == "B" Or $status_pekerja == "D" Or $status_pekerja == "J") And $totalselisih > 1) {
                        $iptsusulan = $this->M_pekerjakeluar->ipt_susulan($pkj['noind'], $ssl['tanggal']);
                        $iptsusulan = round($iptsusulan, 2);
                        $iptsusulantotal = $iptsusulantotal + ($iptsusulan - $ssl['ipt']);
                    }

                    If ($status_pekerja == "B" Or $status_pekerja == "D" ){
                        $umcsusulan = $this->M_pekerjakeluar->um_cabang_susulan($pkj['noind'], $ssl['tanggal']);
                        $umcsusulan = round($umcsusulan, 2);
                        $umcsusulantotal = $umcsusulantotal + ($umcsusulan - $ssl['umc']);
                    }

                    If (($status_pekerja == "B" Or $status_pekerja == "D") And $totalselisih > 1) {
                        $ipsusulan = $this->M_pekerjakeluar->ip_susulan($pkj['noind'], $ssl['tanggal']);
                        $ipsusulan = round($ipsusulan, 2);
                        $ipsusulantotal = $ipsusulantotal + ($ipsusulan - $ssl['ip_']);
                    }

                    If (($status_pekerja == "B" Or $status_pekerja == "A") And $totalselisih > 1) {
                        $upamksusulan = $this->M_pekerjakeluar->upamk_susulan($pkj['noind'], $ssl['tanggal']);
                        $upamksusulan = round($upamksusulan, 2);
                        $upamksusulantotal = $upamksusulantotal + ($upamksusulan - $ssl['upamk']);

                        $ubtsusulan = $this->M_pekerjakeluar->ubt_susulan($pkj['noind'], $ssl['tanggal']);
                        $ubtsusulan = round($ubtsusulan, 2);
                        $ubtsusulantotal = $ubtsusulantotal + ($ubtsusulan - $ssl['ubt']);
                    }

                    If (($status_pekerja == "B" Or $status_pekerja == "D") And $totalselisih > 1) {
                        $iksusulan = $this->M_pekerjakeluar->ik_susulan($pkj['noind'], $ssl['tanggal']);
                        $iksusulan = round($iksusulan, 2);
                        $iksusulantotal = $iksusulantotal + ($iksusulan - $ssl['Ik_']);
                   	}

                    If ($status_pekerja == "T" And $totalselisih > 1) {
                        $ipsusulan = $this->M_pekerjakeluar->iph_susulan($pkj['noind'], $ssl['tanggal']);
                        $ipsusulan = round($ipsusulan, 2);
                        $ipsusulantotal = $ipsusulantotal + ($ipsusulan - $ssl['ip_']);
					}

                    $immsusulan = $this->M_pekerjakeluar->imm_susulan($pkj['noind'], $ssl['tanggal']);
                    $immsusulan = round($immsusulan, 2);
                    $immsusulantotal = $immsusulantotal + ($immsusulan - $ssl['imm']);

                    $imssusulan = $this->M_pekerjakeluar->ims_susulan($pkj['noind'], $ssl['tanggal']);
                    $imssusulan = round($imssusulan, 2);
                    $imssusulantotal = $imssusulantotal + ($imssusulan - $ssl['ims']);

                }


                if($status_pekerja == 'B' || $status_pekerja == 'D' || $status_pekerja == 'T' || $status_pekerja == 'J'){
                	$gpsusulantotal += ($gaji[$angka]['sk_susulan']  +  $gaji[$angka]['cuti_susulan']);

                	if($gpsusulantotal != "0"){
                		$kom_ket = round($gpsusulantotal,2)."GP";
                	}

                	if($ifsusulantotal != "0"){
                		$kom_ket .= round($ifsusulantotal,2)."IF";
                	}

                	if($ipsusulantotal != "0"){
                		$kom_ket .= round($ipsusulantotal,2)."IP";
                	}

                	if($iksusulantotal != "0"){
                		$kom_ket .= round($iksusulantotal,2)."IK";
                	}

                	if($iptsusulantotal != "0"){
                		$kom_ket .= round($iptsusulantotal,2)."IPT";
                	}

                	if($ubtsusulantotal != "0"){
                		$kom_ket .= round($ubtsusulantotal,2)."UBT";
                	}

                	if($upamksusulantotal != "0"){
                		$kom_ket .= round($upamksusulantotal,2)."UPAMK";
                	}

                	if($immsusulantotal != "0"){
                		$kom_ket .= round($immsusulantotal,2)."IMM";
                	}

                	if($imssusulantotal != "0"){
                		$kom_ket .= round($imssusulantotal,2)."IMS";
                	}

                	if($umcsusulantotal != "0"){
                		$kom_ket .= round($umcsusulantotal,2)."UMC";
                	}
                }else{
                	if($gpsusulantotal != "0"){
                		if ($gpsusulantotal < 0) {
                			$kom_pot_susulan .= round($gpsusulantotal,2)."GP";
                		}else{
                			$kom_tam_susulan .= round($gpsusulantotal,2)."GP";
                		}
                	}

                	if($ipsusulantotal != "0"){
                		if ($ipsusulantotal < 0) {
                			$kom_pot_susulan .= round($ipsusulantotal,2)."IP";
                		}else{
                			$kom_tam_susulan .= round($ipsusulantotal,2)."IP";
                		}
                	}

                	if($iksusulantotal != "0"){
                		if ($iksusulantotal < 0) {
                			$kom_pot_susulan .= round($iksusulantotal,2)."IK";
                		}else{
                			$kom_tam_susulan .= round($iksusulantotal,2)."IK";
                		}
                	}

                	if($ubtsusulantotal != "0"){
                		$kom_ubt += round($ubtsusulantotal,2);
                	}

                	if($upamksusulantotal != "0"){
                		$kom_upamk += round($upamksusulantotal,2);
                	}

                	if($immsusulantotal != "0"){
                		$kom_imm += round($immsusulantotal,2);
                	}

                	if($imssusulantotal != "0"){
                		$kom_ims += round($imssusulantotal,2);
                	}
                }
			}

			if($kom_ket == ""){
				if ($kom_sk_susulan  +  $kom_cuti_susulan > 0){
					$kom_ket = ($kom_sk_susulan  +  $kom_cuti_susulan).'GP';
				}else{
					$kom_ket = "-";
				}
			}
			//susulan end

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
			$gaji[$angka]['um_dl'] = $kom_um_dl;
			$gaji[$angka]['ket'] = $kom_ket;
			$gaji[$angka]['pot_susulan'] = $kom_pot_susulan;
			$gaji[$angka]['tam_susulan'] = $kom_tam_susulan;
			$gaji[$angka]['jml_duka'] = $kom_jml_duka;
			$gaji[$angka]['nom_duka'] = $kom_nom_duka;

			$this->M_pekerjakeluar->delete_reffgajikeluar($pkj['noind']);
			//insert to t_log
			$aksi = 'MASTER PRESENSI';
			$detail = 'Delete Reff Gaji Pekerja Keluar noind='.$pkj['noind'];
			$this->log_activity->activity_log($aksi, $detail);
			//

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
				'ket'			 => $gaji[$angka]['ket'] ,
				'um_puasa'		 => $gaji[$angka]['um_puasa'] ,
				'ipet'			 => $gaji[$angka]['ipt'] ,
				'um_cabang'	 	 => $gaji[$angka]['um_cabang'],
				'jml_jkn'		 => $gaji[$angka]['jml_jkn'],
				'jml_jht'		 => $gaji[$angka]['jml_jht'],
				'jml_jp'		 => $gaji[$angka]['jml_jp'],
				'lokasi_krj'	 => $gaji[$angka]['lokasi_kerja'],
				'dldobat'		 => $gaji[$angka]['um_dl'],
				'tambahan_str'	 => $gaji[$angka]['tam_susulan'],
				'potongan_str'	 => $gaji[$angka]['pot_susulan'],
				'xduka'			 => $gaji[$angka]['jml_duka'],
				'pduka'			 => $gaji[$angka]['nom_duka']
			);
			// echo "<pre>";print_r($array_insert);
			$this->M_pekerjakeluar->insert_reffgajikeluar($array_insert);
			//insert to t_log
			$aksi = 'MASTER PRESENSI';
			$detail = 'Insert Reff Gaji Pekerja Keluar noind='.$gaji[$angka]['noind'];
			$this->log_activity->activity_log($aksi, $detail);
			//

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
		// echo "<pre>";print_r($_POST);exit();
		if(!isset($_POST) or empty($_POST)){
			redirect(site_url('MasterPresensi/ReffGaji/PekerjaKeluar/'));
		}
		$user_id = $this->session->userid;
		$puasa 			= $this->input->post('txtPuasa');
		$tgl_puasa = "";
		if ($puasa == 'puasa') {
			$tgl_puasa 		= $this->input->post('txtPeriodePuasa');
		}
		$prd_gaji 		= $this->input->post('txtPeriodeGaji');
		$status_pekerja = $this->input->post('slcStatusPekerja');
		$noind 			= $this->input->post('slcPekerja');
		$pot_seragam 	= $this->input->post('txtPotSeragam');
		$chk_khusus 	= $this->input->post('txtKhususPKJKeluarCheckList');
		$khusus  		= $this->input->post('txtKhususPKJKeluar');

		$gaji = $this->proses_hitung($puasa,$tgl_puasa,$prd_gaji,$status_pekerja,$noind,$pot_seragam,$chk_khusus,$khusus);

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
		$puasa 			= $this->input->post('txtPuasa2');
		$tgl_puasa = "";
		if ($puasa == 'puasa') {
			$tgl_puasa 		= $this->input->post('txtPeriodePuasa2');
		}
		$prd_gaji 		= $this->input->post('txtPeriodeGaji2');
		$status_pekerja = $this->input->post('slcStatusPekerja2');
		$noind 			= $this->input->post('slcPekerja2');
		$pot_seragam 	= $this->input->post('txtPotSeragam2');
		$chk_khusus 	= $this->input->post('txtKhususPKJKeluarCheckList2');
		$khusus  		= $this->input->post('txtKhususPKJKeluar2');
		$gaji = $this->proses_hitung($puasa,$tgl_puasa,$prd_gaji,$status_pekerja,$noind,$pot_seragam,$chk_khusus,$khusus);

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
				$record->P_DUKA	= $dt['nom_duka'];
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
				$record->DUKA 		= $dt['nom_duka'];

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
		$puasa 			= $this->input->post('txtPuasa2');
		$tgl_puasa = "";
		if ($puasa == 'puasa') {
			$tgl_puasa 		= $this->input->post('txtPeriodePuasa2');
		}
		$prd_gaji 		= $this->input->post('txtPeriodeGaji2');
		$status_pekerja = $this->input->post('slcStatusPekerja2');
		$noind 			= $this->input->post('slcPekerja2');
		$pot_seragam 	= $this->input->post('txtPotSeragam2');
		$chk_khusus 	= $this->input->post('txtKhususPKJKeluarCheckList2');
		$khusus  		= $this->input->post('txtKhususPKJKeluar2');
		$gaji = $this->proses_hitung($puasa,$tgl_puasa,$prd_gaji,$status_pekerja,$noind,$pot_seragam,$chk_khusus,$khusus);

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
		$objexcel->setCellValue('AE1','Jumlah Duka');
		$objexcel->setCellValue('AF1','Total Duka');

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
			$objexcel->setCellValue('AE'.$num,$gj['jml_duka']);
			$objexcel->setCellValue('AF'.$num,$gj['nom_duka']);
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
		$waktu = strftime('%d/%h/%Y %H:%M:%S');
		// echo strftime('%d/%h/%Y %H:%M:%S');exit();
		if(!isset($_GET) or empty($_GET)){
			redirect(site_url('MasterPresensi/ReffGaji/PekerjaKeluar/'));
		}
		$user_id = $this->session->userid;
		$puasa 			= $this->input->get('txtPuasa2');
		$tgl_puasa = "";
		if ($puasa == 'puasa') {
			$tgl_puasa 		= $this->input->get('txtPeriodePuasa2');
		}
		$prd_gaji 		= $this->input->get('txtPeriodeGaji2');
		$status_pekerja = $this->input->get('slcStatusPekerja2');
		$noind 			= $this->input->get('slcPekerja2');
		$pot_seragam 	= $this->input->get('txtPotSeragam2');
		$chk_khusus 	= $this->input->get('txtKhususPKJKeluarCheckList2');
		$khusus  		= $this->input->get('txtKhususPKJKeluar2');
		$gaji = $this->proses_hitung($puasa,$tgl_puasa,$prd_gaji,$status_pekerja,$noind,$pot_seragam,$chk_khusus,$khusus);

		$data['data'] = $gaji;
		$data['pos'] = $_GET;
		$this->load->library('pdf');

		$pdf = $this->pdf->load();
		$pdf = new mPDF('','A4-L',0,'',5,5,5,25,0,5);
		$filename = 'Gaji.pdf';

		$html = $this->load->view('MasterPresensi/ReffGaji/PekerjaKeluar/V_print',$data, true);
		$stylesheet1 = file_get_contents(base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css'));
		$pdf->SetHTMLFooter("<i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-MasterPresensi oleh ".$this->session->user." ".$this->session->employee." pada tgl. ".$waktu.". Halaman {PAGENO} dari {nb}</i>");
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
