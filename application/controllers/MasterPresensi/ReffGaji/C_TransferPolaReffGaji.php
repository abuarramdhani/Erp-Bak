<?php
Defined('BASEPATH') or exit('NO DIrect Script Access Allowed');

set_time_limit(0);
ini_set("memory_limit","-1");
setlocale(LC_TIME, "id_ID.utf8");
date_default_timezone_set("Asia/Jakarta");

class C_TransferPolaReffGaji extends CI_Controller
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
		$this->load->model('MasterPresensi/ReffGaji/M_transferpolareffgaji');
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
		$this->M_transferpolareffgaji->deleteProgres($user);

		$data['Title']			=	'Pekerja Keluar';
		$data['Menu'] 			= 	'Reff Gaji';
		$data['SubMenuOne'] 	= 	'Pekerja Keluar';
		$data['SubMenuTwo'] 	= 	'';

		$data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
		$data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);

		$data['user'] = $this->session->user;

		$this->load->view('V_Header',$data);
		$this->load->view('V_Sidemenu',$data);
		$this->load->view('MasterPresensi/ReffGaji/TransferPolaReffGaji/V_index',$data);
		$this->load->view('V_Footer',$data);
	}

	public function proses(){
		$tglawal = $this->input->get('tglawal');
		$tglakhir = $this->input->get('tglakhir');

		if (empty($tglawal)) {
			$tglawal = $this->input->post('tglawal');
			$tglakhir = $this->input->post('tglakhir');
		}

		$arraytglawal = explode("-", $tglawal);
		$arraytglakhir = explode("-", $tglakhir);

		$data = $this->M_transferpolareffgaji->getPola($tglawal,$tglakhir);
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		$jumlahPekerja = $this->M_transferpolareffgaji->getCountNumber($tglawal,$tglakhir);
		$jumlah = count($data);
		$user = $this->session->user;
		$this->M_transferpolareffgaji->insertProgres($user,$jumlah + $jumlahPekerja);
		$progres = 0;
		$this->M_transferpolareffgaji->updateProgres($user,$progres);
		//insert to t_log
		$aksi = 'MASTER PRESENSI';
		$detail = 'Update \"Presensi\".progress_transfer_reffgaji where user_='.$user.' set progres='.$progres;
		$this->log_activity->activity_log($aksi, $detail);
		//
		session_write_close();
		flush();
		$datajadi = array();
		$datapdf = array();
		$angka = 0;
		$simpan_noind = "";
		$simpan_tanggal = "";
		$bulan_str = "";
		foreach ($data as $dt) {
			if ($dt['noind'] !== $simpan_noind) {
				if($simpan_noind !== ""){
					$angka++;
				}
				$lokasi_kerja = $this->M_transferpolareffgaji->getLokasi($dt['noind']);
				$datajadi[$angka] = array(
					'noindlama' => '',
					'noind' => $dt['noind'],
					'namaopr' => $dt['nama'],
					'kodesie' => $dt['kodesie'],
					'tgl_gj' => '0000-00-00',
					'hma15' => '',
					'hma16' => '',
					'hma17' => '',
					'hma18' => '',
					'hma19' => '',
					'hma20' => '',
					'hma21' => '',
					'hma22' => '',
					'hma23' => '',
					'hma24' => '',
					'hma25' => '',
					'hma26' => '',
					'hma27' => '',
					'hma28' => '',
					'hma29' => '',
					'hma30' => '',
					'hma31' => '',
					'hm01' => '',
					'hm02' => '',
					'hm03' => '',
					'hm04' => '',
					'hm05' => '',
					'hm06' => '',
					'hm07' => '',
					'hm08' => '',
					'hm09' => '',
					'hm10' => '',
					'hm11' => '',
					'hm12' => '',
					'hm13' => '',
					'hm14' => '',
					'hm15' => '',
					'hm16' => '',
					'hm17' => '',
					'hm18' => '',
					'hm19' => '',
					'hm20' => '',
					'hm21' => '',
					'hm22' => '',
					'hm23' => '',
					'hm24' => '',
					'hm25' => '',
					'hm26' => '',
					'hm27' => '',
					'hm28' => '',
					'hm29' => '',
					'hm30' => '',
					'hm31' => '',
					'jlb' => 0,
					'hmp' => 0,
					'hmu' => 0,
					'ifung' => 0,
					'ipres' => 0,
					'ikond' => 0,
					'hm' => 0,
					'ubt' => 0,
					'hupamk' => 0,
					'ikskp' => 0,
					'iksku' => 0,
					'iksks' => 0,
					'ikskm' => 0,
					'ikjsp' => 0,
					'ikjsu' => 0,
					'ikjss' => 0,
					'ikjsm' => 0,
					't' => 0,
					'skd' => 0,
					'jml_um' => 0,
					'hms' => 0,
					'hmm' => 0,
					'jlb' => 0,
					'abs' => 0,
					'hl' => 0,
					'cti' => 0,
					'ik' => 0,
					'potongan' => 0,
					'tambahan' => 0,
					'duka' => 0,
					'pt' => 0,
					'pi' => 0,
					'pm' => 0,
					'dl' => 0,
					'rev_sk' => 0,
					'rev_sp' => 0,
					'rev_ct' => 0,
					'rev_ik' => 0,
					'hc' => 0,
					'cicil' => 0,
					'potkop' => 0,
					'ubs' => 0,
					'um_puasa' => 0,
					'sk_ct' => 0,
					'pot_2' => '0',
					'tamb_2' => '0',
					'KD_LKS' => $lokasi_kerja,
					'KET' => '-',
					'bhmp' => 0,
					'bhmu' => 0,
					'bhms' => 0,
					'bhmm' => 0
				);
			}
			$arraytanggal = explode("-", $dt['tanggal']);
			if ($arraytglawal['1'] == $arraytglakhir['1']) {
				$bulan_str = "hm";
			}else{
				if ($arraytglawal['1'] == $arraytanggal['1']) {
					$bulan_str = 'hma';
				}else{
					$bulan_str = "hm";
				}
			}

			if ($dt['kd_ket'] == "TM") {
				$datajadi[$angka][$bulan_str.$arraytanggal['2']] = "M";
			}elseif ($dt['kd_ket'] == "TIK" or $dt['kd_ket'] == "PSP") {
				$ijin = 1 - $this->M_transferpolareffgaji->hitung_tik($dt['noind'],$dt['tanggal']);
				$insKon = $this->M_transferpolareffgaji->hitungIk($dt['noind'],$dt['tanggal']);
				if(floatval($insKon) < 1){
					$datajadi[$angka][$bulan_str.$arraytanggal['2']] = $ijin;
					if (strtolower($dt['inisial']) == "s1") {
						$datajadi[$angka]['hmp'] -= 1;
					}elseif (strtolower($dt['inisial']) == "s2") {
						$datajadi[$angka]['hms'] -= 1;
					}elseif (strtolower($dt['inisial']) == "s3") {
						$datajadi[$angka]['hmm'] -= 1;
					}elseif (strtolower($dt['inisial']) == "su") {
						$datajadi[$angka]['hmu'] -= 1;
					}else{
						$datajadi[$angka]['hmp'] -= 1;
					}
				}else{
					$datajadi[$angka][$bulan_str.$arraytanggal['2']] = strtolower($dt['inisial']);
				}
			}elseif ($dt['kd_ket'] !== "PKJ" and $dt['kd_ket'] !== "PLB" and $dt['kd_ket'] !== "HL" ) {
				if ($dt['kd_ket'] == "PSK") {
					$datajadi[$angka][$bulan_str.$arraytanggal['2']] = "SKD";
				}elseif (substr($dt['kd_ket'], 0, 1) == "C") {
					$datajadi[$angka][$bulan_str.$arraytanggal['2']] = "CT";
				}elseif ($dt['kd_ket'] == "PRM") {
					$datajadi[$angka][$bulan_str.$arraytanggal['2']] = "RM";
				}elseif ($dt['kd_ket'] !== "TT") {
					$datajadi[$angka][$bulan_str.$arraytanggal['2']] = "S1";
					$datajadi[$angka]['hmp'] += 1;
				}elseif ($dt['kd_ket'] == "TT") {
					// $datajadi[$angka][$bulan_str.$arraytanggal['2']] = strtoupper($dt['inisial']);
					// if (strtolower($dt['inisial']) == "s1") {
					// 	$datajadi[$angka]['hmp'] += 1;
					// }elseif (strtolower($dt['inisial']) == "s2") {
					// 	$datajadi[$angka]['hms'] += 1;
					// }elseif (strtolower($dt['inisial']) == "s3") {
					// 	$datajadi[$angka]['hmm'] += 1;
					// }elseif (strtolower($dt['inisial']) == "su") {
					// 	$datajadi[$angka]['hmu'] += 1;
					// }
				}
			}elseif ($dt['kd_ket'] !== "HL") {
				if (strtolower($dt['inisial']) !== "s1" and strtolower($dt['inisial']) !== "s2" and strtolower($dt['inisial']) !== "s3" and strtolower($dt['inisial']) !== "su" ) {
					$datajadi[$angka][$bulan_str.$arraytanggal['2']] = "S1";
					$datajadi[$angka]['hmp'] += 1;
				}else{
					$datajadi[$angka][$bulan_str.$arraytanggal['2']] = strtoupper($dt['inisial']);
					if (strtolower($dt['inisial']) == "s1") {
						$datajadi[$angka]['hmp'] += 1;
					}elseif (strtolower($dt['inisial']) == "s2") {
						$datajadi[$angka]['hms'] += 1;
					}elseif (strtolower($dt['inisial']) == "s3") {
						$datajadi[$angka]['hmm'] += 1;
					}elseif (strtolower($dt['inisial']) == "su") {
						$datajadi[$angka]['hmu'] += 1;
					}
				}

			}



			$simpan_tanggal = $dt['tanggal'];
			$simpan_noind = $dt['noind'];

			$progres +=1;
			$this->M_transferpolareffgaji->updateProgres($user,$progres);
			//insert to t_log
			$aksi = 'MASTER PRESENSI';
			$detail = 'Update \"Presensi\".progress_transfer_reffgaji where user_='.$user.' set progres='.$progres;
			$this->log_activity->activity_log($aksi, $detail);
			//
			session_write_close();
			flush();
		}

		// echo "<pre>";
		// print_r($datajadi);
		// echo "</pre>";
		$waktu = time();
		$table = new XBase\WritableTable(FCPATH."assets/upload/TransferReffGaji/lv_info_pola.dbf");
		$table->openWrite(FCPATH."assets/upload/TransferReffGaji/lv_info_pola".$waktu.".dbf");

		foreach ($datajadi as $value) {
			$record = $table->appendRecord();
			$record->NOINDLAMA = $value['noindlama'];
			$record->NOIND = $value['noind'];
			$record->NAMAOPR = $value['namaopr'];
			$record->KODESIE = $value['kodesie'];
			$record->TGL_GJ = $value['tgl_gj'];
			$record->HMA15 = $value['hma15'];
			$record->HMA16 = $value['hma16'];
			$record->HMA17 = $value['hma17'];
			$record->HMA18 = $value['hma18'];
			$record->HMA19 = $value['hma19'];
			$record->HMA20 = $value['hma20'];
			$record->HMA21 = $value['hma21'];
			$record->HMA22 = $value['hma22'];
			$record->HMA23 = $value['hma23'];
			$record->HMA24 = $value['hma24'];
			$record->HMA25 = $value['hma25'];
			$record->HMA26 = $value['hma26'];
			$record->HMA27 = $value['hma27'];
			$record->HMA28 = $value['hma28'];
			$record->HMA29 = $value['hma29'];
			$record->HMA30 = $value['hma30'];
			$record->HMA31 = $value['hma31'];
			$record->HM01 = $value['hm01'];
			$record->HM02 = $value['hm02'];
			$record->HM03 = $value['hm03'];
			$record->HM04 = $value['hm04'];
			$record->HM05 = $value['hm05'];
			$record->HM06 = $value['hm06'];
			$record->HM07 = $value['hm07'];
			$record->HM08 = $value['hm08'];
			$record->HM09 = $value['hm09'];
			$record->HM10 = $value['hm10'];
			$record->HM11 = $value['hm11'];
			$record->HM12 = $value['hm12'];
			$record->HM13 = $value['hm13'];
			$record->HM14 = $value['hm14'];
			$record->HM15 = $value['hm15'];
			$record->HM16 = $value['hm16'];
			$record->HM17 = $value['hm17'];
			$record->HM18 = $value['hm18'];
			$record->HM19 = $value['hm19'];
			$record->HM20 = $value['hm20'];
			$record->HM21 = $value['hm21'];
			$record->HM22 = $value['hm22'];
			$record->HM23 = $value['hm23'];
			$record->HM24 = $value['hm24'];
			$record->HM25 = $value['hm25'];
			$record->HM26 = $value['hm26'];
			$record->HM27 = $value['hm27'];
			$record->HM28 = $value['hm28'];
			$record->HM29 = $value['hm29'];
			$record->HM30 = $value['hm30'];
			$record->HM31 = $value['hm31'];
			$record->JLB = $value['jlb'];
			$record->HMP = $value['hmp'];
			$record->HMU = $value['hmu'];
			$record->IFUNG = $value['ifung'];
			$record->IPRES = $value['ipres'];
			$record->IKOND = $value['ikond'];
			$record->HM = $value['hm'];
			$record->UBT = $value['ubt'];
			$record->HUPAMK = $value['hupamk'];
			$record->IKSKP = $value['ikskp'];
			$record->IKSKU = $value['iksku'];
			$record->IKSKS = $value['iksks'];
			$record->IKSKM = $value['ikskm'];
			$record->IKJSP = $value['ikjsp'];
			$record->IKJSU = $value['ikjsu'];
			$record->IKJSS = $value['ikjss'];
			$record->IKJSM = $value['ikjsm'];
			$record->T = $value['t'];
			$record->SKD = $value['skd'];
			$record->JML_UM = $value['jml_um'];
			$record->HMS = $value['hms'];
			$record->HMM = $value['hmm'];
			$record->JLB = $value['jlb'];
			$record->ABS = $value['abs'];
			$record->HL = $value['hl'];
			$record->CTI = $value['cti'];
			$record->IK = $value['ik'];
			$record->POTONGAN = $value['potongan'];
			$record->TAMBAHAN = $value['tambahan'];
			$record->DUKA = $value['duka'];
			$record->PT = $value['pt'];
			$record->PI = $value['pi'];
			$record->PM = $value['pm'];
			$record->DL = $value['dl'];
			$record->REV_SK = $value['rev_sk'];
			$record->REV_SP = $value['rev_sp'];
			$record->REV_CT = $value['rev_ct'];
			$record->REV_IK = $value['rev_ik'];
			$record->HC = $value['hc'];
			$record->CICIL = $value['cicil'];
			$record->POTKOP = $value['potkop'];
			$record->UBS = $value['ubs'];
			$record->UM_PUASA = $value['um_puasa'];
			$record->SK_CT = $value['sk_ct'];
			$record->POT_2 = $value['pot_2'];
			$record->TAMB_2 = $value['tamb_2'];
			$record->KD_LKS = $value['KD_LKS'];
			$record->KET = $value['KET'];
			// $record->BHMP = $value['bhmp'];
			// $record->BHMU = $value['bhmu'];
			// $record->BHMS = $value['bhms'];
			// $record->BHMM = $value['bhmm'];
			$table->writeRecord();

			$progres +=1;
			$this->M_transferpolareffgaji->updateProgres($user,$progres);
			//insert to t_log
			$aksi = 'MASTER PRESENSI';
			$detail = 'Update \"Presensi\".progress_transfer_reffgaji where user_='.$user.' set progres='.$progres;
			$this->log_activity->activity_log($aksi, $detail);
			//
			session_write_close();
			flush();

			if (substr($value['noind'], 0, 1) == 'A') {
				$datapdf[] = $value;
			}
		}

		$table->close();

		$data['datajadi'] = $datapdf;
		$pdf = $this->pdf->load();
		$pdf = new mPDF('utf-8', 'A4', 8, '', 10, 10, 10, 10, 10, 5);
		// $this->load->view('MasterPresensi/ReffGaji/TransferPolaReffGaji/V_cetak', $data);
		$html = $this->load->view('MasterPresensi/ReffGaji/TransferPolaReffGaji/V_cetak', $data, true);
		$waktu_cetak = strftime('%d/%h/%Y %H:%M:%S');
		$pdf->SetHTMLFooter("<i style='font-size: 8pt'>Halaman ini dicetak melalui Aplikasi QuickERP-MasterPresensi oleh ".$this->session->user." ".$this->session->employee." pada tgl. ".$waktu_cetak.". Halaman {PAGENO} dari {nb}</i>");
		$pdf->WriteHTML($html, 2);
		$pdf->Output(FCPATH."assets/upload/TransferReffGaji/lv_info_pola".$waktu.".pdf", 'F');
		// $pdf->Output($filename, 'I');
		echo '<a href="'.site_url("MasterPresensi/ReffGaji/TransferPolaReffGaji/download?file=lv_info_pola&type=dbf&time=".$waktu).'" class="btn btn-info">lv_info_pola.dbf</a>
		<a href="'.site_url("MasterPresensi/ReffGaji/TransferPolaReffGaji/download?file=lv_info_pola&type=pdf&time=".$waktu).'" class="btn btn-danger">lv_info_pola.pdf</a>';
	}

	public function cekProgress(){
		$user = $this->input->get('user');
		$data = $this->M_transferpolareffgaji->getProgres($user);
		if (!empty($data)) {
			if ($data->progress == $data->total) {
				$this->M_transferpolareffgaji->deleteProgres($user);
				//insert to t_log
				$aksi = 'MASTER PRESENSI';
				$detail = 'Delete \"Presensi\".progress_transfer_reffgaji where user_='.$user;
				$this->log_activity->activity_log($aksi, $detail);
				//
			}
			echo round(($data->progress/$data->total)*100);
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
		header('Content-disposition: attachment; filename='.$file.".".$type);
		// header("Content-type: application/octet-stream");
		echo $data;
	}

} ?>
