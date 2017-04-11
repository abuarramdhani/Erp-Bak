<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_TransaksiPenggajian extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('SystemAdministration/MainMenu/M_user');
        $this->load->model('PayrollManagement/BrowseTransaksiPenggajian/M_transaksipenggajian');
        if($this->session->userdata('logged_in')!=TRUE) {
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
            $this->session->set_userdata('Responsbility', 'some_value');
        }
    }

	public function index()
    {
        $this->checkSession();
        $user_id = $this->session->userid;
        
        $data['Menu'] = 'Payroll Management';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
        $this->load->view('V_Header',$data);
        $this->load->view('V_Sidemenu',$data);
        $this->load->view('PayrollManagement/BrowseTransaksiPenggajian/V_index', $data);
        $this->load->view('V_Footer',$data);
    }
	
	public function Check(){
		$this->checkSession();
        $user_id = $this->session->userid;
        
        $data['Menu'] = 'Payroll Management';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$varPeriode	= $this->input->post('txtPeriodeHitung',TRUE);
		$varYear		= substr($varPeriode,0,4);
		$varMonth		= substr($varPeriode,5,2);
	
		$checkPeriode	= $this->M_transaksipenggajian->checkPeriode($varYear,$varMonth);
		if($checkPeriode){
			$getDataPenggajian	= $this->M_transaksipenggajian->getDataPenggajian($varYear,$varMonth);
			
			$data['getDataPenggajian_data'] = $getDataPenggajian;
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('PayrollManagement/BrowseTransaksiPenggajian/V_index', $data);
			$this->load->view('V_Footer',$data);
		}else{
			$checkAvailNoind	= $this->M_transaksipenggajian->checkAvailNoind();
			
			$data['checkAvailNoind_data'] = $checkAvailNoind;
			$data['varYear']	= $varYear;
			$data['varMonth']	= $varMonth;
			$this->load->view('V_Header',$data);
			$this->load->view('V_Sidemenu',$data);
			$this->load->view('PayrollManagement/BrowseTransaksiPenggajian/V_check_master', $data);
			$this->load->view('V_Footer',$data);
		}
	}
	
		public function Hitung(){
		$this->checkSession();
        $user_id = $this->session->userid;
        
        $data['Menu'] = 'Payroll Management';
        $data['SubMenuOne'] = '';
        $data['SubMenuTwo'] = '';

        $data['UserMenu'] = $this->M_user->getUserMenu($user_id,$this->session->responsibility_id);
        $data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id,$this->session->responsibility_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id,$this->session->responsibility_id);
		
		$varYear	= $this->input->post('txtYear',TRUE);
		$varMonth	= $this->input->post('txtMonth',TRUE);
		$varDate	= $varYear."-".$varMonth."-20";
		$date			= date('Y-m-d');
		$getDataGajianPersonalia	= $this->M_transaksipenggajian->getDataGajianPersonalia($varYear,$varMonth,$date);
		$no = 0;
		foreach($getDataGajianPersonalia as $row1){
			$noind = $row1->noind;
			$kd_status_kerja = $row1->kd_status_kerja;
			$kd_hubungan_kerja = $row1->kd_hubungan_kerja;
			$stat_pajak = $row1->stat_pajak;
			if($stat_pajak == "KS"){
				$stat_pajak	= "TK";
			}
			$jt_anak = $row1->jt_anak;
			$jt_bkn_anak = $row1->jt_bkn_anak;
			$jt_pajak	= ((int)$jt_anak)+((int)$jt_bkn_anak);
			if($jt_pajak > 3){
				$jt_pajak = 3;
			}
			$no_koperasi = $row1->no_koperasi;
			$masukkerja	= $row1->masuk_kerja;
			$p_tanggal = $row1->tanggal;
			$p_kd_jabatan = $row1->kd_jabatan;
			$kodesie = $row1->kodesie;
			$umur = $row1->umur;
			$p_ip = $row1->p_ip;
			$p_ik = $row1->p_ik;
			$p_i_f = $row1->p_if;
			$p_if_htg_bln_lalu = $row1->if_htg_bln_lalu;
			$p_ubt = $row1->p_ubt;
			$p_upamk = $row1->p_upamk;
			$p_um = $row1->p_um;
			$p_ims = $row1->p_ims;
			$p_imm = $row1->p_imm;
			$p_lembur = $row1->lembur;
			$p_htm = $row1->htm;
			$p_ijin = $row1->ijin;
			$p_ijin_htg_bln_lalu = $row1->ijin_htg_bln_lalu;
			$p_pot = $row1->pot;
			$p_tamb_gaji = $row1->tamb_gaji;
			$p_hl = $row1->hl;
			$p_ct = $row1->ct;
			$p_putkop = $row1->putkop;
			$p_plain = $row1->plain;
			$p_pikop = $row1->pikop;
			$p_pspsi = $row1->pspsi;
			$p_putang = $row1->putang;
			$p_dl = $row1->dl;
			$p_tkpajak = $row1->tkpajak;
			$p_ttpajak = $row1->ttpajak;
			$p_pduka = $row1->pduka;
			$p_utambahan = $row1->utambahan;
			$p_btransfer = $row1->btransfer;
			$p_denda_ik = $row1->denda_ik;
			$p_lebih_bayar = $row1->p_lebih_bayar;
			$p_pgp = $row1->pgp;
			$p_tlain = $row1->tlain;
			$p_xduka = $row1->xduka;
			$p_ket = $row1->ket;
			$p_cicil = $row1->cicil;
			$p_ubs = $row1->ubs;
			$p_ubs_rp = $row1->ubs_rp;
			$p_um_puasa = $row1->p_um_puasa;
			$p_kd_jns_transaksi = $row1->kd_jns_transaksi;
			$r_gaji_pokok = $row1->gaji_pokok;
			$r_i_f = $row1->i_f;
			$r_upamk = $row1->upamk;
			$r_insentif_kemahalan = $row1->insentif_kemahalan;
			$r_pot_pensiun = $row1->pot_pensiun;
			$kd_bank = $row1->kd_bank;
			$no_rekening = $row1->no_rekening;
			$nama_pemilik_rekening = $row1->nama_pemilik_rekening;
			$r_ip = $row1->ip;
			$r_ik = $row1->ik;
			$r_ims = $row1->ims;
			$r_imm = $row1->imm;
			$r_pot_duka = $row1->pot_duka;
			$r_spsi = $row1->spsi;
			$r_ubt = $row1->ubt;
			$r_um = $row1->um;
			$p_jkk = $row1->set_jkk;
			$p_jkm = $row1->set_jkm;
			$p_jht_kary = $row1->jht_kary;
			$p_jht_prshn = $row1->jht_prshn;
			$p_jkn_kary = $row1->jkn_kary;
			$p_jkn_prshn = $row1->jkn_prshn;
			$p_jpn_kary = $row1->jpn_kary;
			$p_jpn_prshn = $row1->jpn_prshn;
			$p_max_jab = $row1->max_jab;
			$p_persentase_jab = $row1->persentase_jab;
			$p_max_pensiun = $row1->max_pensiun;
			$r_jkk = $row1->jkk;
			$r_jkm = $row1->jkm;
			$r_jht_karyawan = $row1->jht_karyawan;
			$r_jht_perusahaan = $row1->jht_perusahaan;
			$r_jpk_karyawan = $row1->jpk_karyawan;
			$r_jpk_perusahaan = $row1->jpk_perusahaan;
			$r_batas_umur_jp = $row1->batas_umur_jpk;
			$r_batas_jpk = $row1->batas_jpk;
			$r_batas_max_jkn = $row1->batas_max_jkn;
			$r_jkn_tg_kary = $row1->jkn_tg_kary;
			$r_jkn_tg_prshn = $row1->jkn_tg_prshn;
			$r_insentif_kemahalan = $row1->insentif_kemahalan;
			$std_jam = $row1->std_jam;
			$presentase = $row1->prosentase;
			$thr = $row1->thr;
			$ubthr = $row1->ubthr;
			$bln_sakit = $row1->bulan_sakit;
			$klaim_cuti = $row1->klaim_cuti;
			$klaim_dl = $row1->klaim_dl;
			$pot_transfer = $row1->pot_transfer;
			$pot_transfer_tg_prshn = $row1->pot_transfer_tg_prshn;
			
			$r_kp = 0;
			$r_tkp = 0;
			$getKp	= $this->M_transaksipenggajian->getKp($noind,$varYear,$varMonth);
			foreach($getKp as $row){
				$r_kp		= $row->tambahan;
				$r_desc_kp	= $row->desc_;
			}
			
			$getTkp	= $this->M_transaksipenggajian->getTkp($noind,$varYear,$varMonth);
			foreach($getTkp as $row){
				$r_tkp		= $row->tambahan;
				$r_desc_tkp	= $row->desc_;
			}
			
			$getTransaksiPajak	= $this->M_transaksipenggajian->getTransaksiPajak($varYear,$noind);
			foreach($getTransaksiPajak as $row){
				$r_gaji_sd_bln_tsb	= $row->penghasilan_sd_bln_tsb;
			}
		
			$getMasterPtkp			= $this->M_transaksipenggajian->getMasterPtkp($stat_pajak,$jt_pajak,$date);
			foreach($getMasterPtkp as $row){
				$fx_ptkp	= $row->ptkp_per_tahun;
				$fx_stat_pajak	= $row->status_pajak;
			}
			$fx_cicilan_hutang = 0;
			$getHutang	= $this->M_transaksipenggajian->getHutang($noind,$varMonth,$varYear);
			foreach($getHutang as $row){
				$fx_cicilan_hutang = $fx_cicilan_hutang + $row->jumlah_transaksi;
			}
			
			$getPekerjaSakit	= $this->M_transaksipenggajian->getPekerjaSakit($bln_sakit);
			foreach($getPekerjaSakit as $row){
				$p_sakit = $row->persentase;
			}
			
			$getParameterPPh	= $this->M_transaksipenggajian->getParameterPPh();
			// PERHITUNGAN KODE STATUS  " B "
					if(substr($noind,0,1)=="B" or substr($noind,0,1)=="D" or substr($noind,0,1)=="J" or substr($noind,0,1)=="G"){
 						$fx_gaji_pokok	= $r_gaji_pokok;																											//KOMPONEN GAJI POKOK
						$fx_ik						= $p_ik * $r_ik;																										//KOMPONEN INSENTIF KOGNITE
						$fx_ip						= $p_ip * $r_ip;
						if(substr($noind,0,1)=="B" or substr($noind,0,1)=="D"){
								$fx_if						= $p_i_f * $r_i_f;																								//KOMPONEN INSENTIF FUNGSIONAL
								$fx_if_htg_bln_lalu	= $p_if_htg_bln_lalu * $r_i_f;																			//KOMPONEN IF HTG BLN LALU
						}else{
								$fx_if						= 0;
								$fx_if_htg_bln_lalu	= 0;
						}
						if(substr($noind,0,1)=="J"){
								$fx_ikr						= $p_i_f * $r_i_f;																								//KOMPONEN INSENTIF KERAJINAN
								$fx_ikr_htg_bln_lalu	= $p_if_htg_bln_lalu * $r_i_f;																		//KOMPONEN IF HTG BLN LALU
						}else{
								$fx_ikr						= 0;
								$fx_ikr_htg_bln_lalu	= 0;
						}
						$fx_imm					= $p_imm * $r_imm;																									//KOMPONEN INSENTIF MASUK MALAM
						$fx_ims					= $p_ims * $r_ims;																									//KOMPONEN INSENTIF MASUK SORE
						$fx_ubt					= $p_ubt * $r_ubt;																									//KOMPONEN UANG BANTU TRANSPORT
						$fx_upamk				= $p_upamk * $r_upamk;																						//KOMPONEN UPAH PENGHARGAAN ATAS MASA KERJA
						$fx_lembur				= (((($r_gaji_pokok / 30) + $r_um ) * 30 ) * $std_jam) * $p_lembur;						//KOMPONEN LEMBUR
						$fx_um					= $p_um * $r_um;																									//KOMPONEN UANG MAKAN
						$fx_klaim_cuti			= $klaim_cuti;																											//KLAIM SISA CUTI	
						$fx_klaim_dl			= $klaim_dl;																												//KLAIM DINAS LUAR
						$fx_kp						= $r_kp;																													//KOREKSI KENA PAJAK
						$fx_htm					= (($p_htm + $p_ijin) * ($r_gaji_pokok/30));															//POTONGAN HARI TIDAK MASUK
						$fx_tkp					= $r_tkp;																													//KOREKSI TIDAK KENA PAJAK
						$fx_thr					= $thr;																														//KOMPONEN THR
						$fx_ubthr				= $ubthr;																													//KOMPONEN UBTHR
						$fx_insentif_kemahalan				= $r_insentif_kemahalan * $p_i_f;														//KOMPONEN INSENTIF KEMAHALAN
						$fx_jht_p					= (($r_gaji_pokok * $r_jht_perusahaan)/100) * $p_jht_prshn;								//JAMINAN HARI TUA TANGGUNGAN PERUSAHAAN
						$fx_jht_k					= (($r_gaji_pokok * $r_jht_karyawan)/100) * $p_jht_kary;										//JAMINAN HARI TUA TANGGUNGAN KARYAWAN
						if($umur > $r_batas_umur_jp){
							if($fx_gaji_pokok > $r_batas_jpk){
								$fx_jpp			= (($r_batas_jpk * $r_jpk_perusahaan)/100) * $p_jpn_prshn;								//JAMINAN PENSIUN TANGGUNGAN PERUSAHAAN
							}else{
								$fx_jpp			= (($r_gaji_pokok * $r_jpk_perusahaan)/100) * $p_jpn_prshn;								//JAMINAN PENSIUN TANGGUNGAN PERUSAHAAN
							}
						}else{
							$fx_jpp					= 0;
						}
						$fx_jpk					= (($r_gaji_pokok * $r_jpk_karyawan)/100) * $p_jpn_kary;									//JAMINAN PENSIUN TANGGUNGAN KARYAWAN
						$fx_jkm					= (($r_gaji_pokok * $r_jkm)/100) * $p_jkm;																//JAMINAN KEMATIAN
						if($fx_gaji_pokok>$r_batas_max_jkn){
							$fx_jkn_p			= (($r_batas_max_jkn * $r_jkn_tg_prshn)/100) * $p_jkn_prshn;							//JAMINAN KESEHATAN (BPJS) TANGGUNGAN PERUSAHAAN
						}else{
							$fx_jkn_p			= (($r_gaji_pokok * $r_jkn_tg_prshn)/100) * $p_jkn_prshn;									//JAMINAN KESEHATAN (BPJS) TANGGUNGAN PERUSAHAAN
						}
						$fx_jkn_k				= (($r_gaji_pokok * $r_jkn_tg_kary)/100) * $p_jkn_kary;										//JAMINAN KESEHATAN (BPJS) TANGGUNGAN KARYAWAN
						$fx_jkk					= (($r_gaji_pokok * $r_jkk)/100) * $p_jkk;																//JAMINAN KECELAKAAN KERJA
						$fx_pikop				= $p_pikop;																												//POTONGAN KOPERASI
						$fx_putkop				= $p_putkop;																											//POTONGAN KOPERASI
						$fx_pot_lain			= $p_plain;																												//POTONGAN LAIN-LAIN
						$fx_pot_spsi			= $p_pspsi;																												//POTONGAN SPSI
						$fx_pot_duka			= $p_pduka;																											//POTONGAN DUKA
						$fx_um_puasa		= ($p_um_puasa * $r_um);																						//UANG MAKAN PUASA
						$fx_pot_transfer	= ($pot_transfer - $pot_transfer_tg_prshn);															//POTONGAN TRANSFER
						if(empty($getPekerjaSakit)){
							$fx_pot_skt_panjang	= 0;																													//POTONGAN SAKIT BERKEPANJANGAN	
						}else{
							$fx_pot_skt_panjang	= (($r_gaji_pokok * $p_sakit)/100);																	//POTONGAN SAKIT BERKEPANJANGAN	
						}
						$pph = 0;
						$pph21 = 0;
						
						//PERHITUNGAN PAJAK
						do{
						$pph=$pph21;
						if($p_upamk == 0){
							$pr_upamk = 0;
						}else{
							$pr_upamk = $r_upamk * 25;
						}
						$std_insentif		= ($r_ik * 25) + ($r_ip * 25) + ($r_i_f * 25) + ($r_ubt * 25) + $pr_upamk;
						$std_gaji				=  $fx_gaji_pokok + $std_insentif ;
						$gp_bln_ini			= ($fx_gaji_pokok - $fx_htm);
						$insentif_bln_ini	= $fx_if + $fx_ip + $fx_ik + $fx_ims + $fx_imm + $fx_ubt + $fx_upamk ;
						$gaji_sbln			= $gp_bln_ini + $insentif_bln_ini + $fx_klaim_dl + $fx_thr + $fx_ubthr + $fx_lembur + $fx_kp + $pph21 + $fx_klaim_cuti;
						$ttl_premi			= $fx_jkk + $fx_jkm + $fx_jkn_p + $fx_jht_p + $fx_jpp ;
						$gaji_bruto			= $gaji_sbln + $ttl_premi;
						if(($gaji_bruto * $p_persentase_jab) > $p_max_jab){
							$fx_bea_jab		= $p_max_jab;
						}else{
							$fx_bea_jab		= $gaji_bruto * $p_persentase_jab;
						}
						$pot					=  $fx_jht_k + $fx_jkn_k + $fx_jpk;
						if($pot > $p_max_pensiun){
							$pot = $p_max_pensiun;
						}
						$ttl_pot = $fx_bea_jab + $pot;
						$gaji_netto			= $gaji_bruto - $ttl_pot;
						if(empty($r_gaji_sd_bln_tsb)){
							$r_gaji_sd_bln_tsb = 0;
						}
						$gaji_sd_bln_tsb= $gaji_netto + $r_gaji_sd_bln_tsb;
						$gaji_setahun		= $gaji_sd_bln_tsb+((12 - ((int)01)) * (($std_gaji + $ttl_premi)-$ttl_pot));
						$gaji_kena_ptkp	= $gaji_setahun - $fx_ptkp;
						if($gaji_kena_ptkp <= 0){
							$gaji_kena_ptkp = 0;
						}
						
						$pemb_gaji_kena_ptkp	= floor($gaji_kena_ptkp/1000)*1000;
						$Pph21_setahun = 0;
						foreach($getParameterPPh as $row){
							$pph_bwh 		= $row->batas_bawah;
							$pph_ats 			= $row->batas_atas;
							$pph_percent 	= $row->persen;
							$pph_lv				= $row->kd_pph;
							$pph_range		= $row->selisih;
							$pph_bef			= $row->bef;
							if($pph_lv == "1"){
								if($pemb_gaji_kena_ptkp >= $pph_bwh and $pemb_gaji_kena_ptkp <= $pph_ats){
									$step1 = ($pemb_gaji_kena_ptkp * $pph_percent)/100;
								}else{
									$step1 = ($pph_ats * $pph_percent)/100;
								}
							}elseif($pph_lv == "2"){
								if($pemb_gaji_kena_ptkp - $pph_bef >= $pph_range){
									$step1 = ($pph_range * $pph_percent)/100;
								}else{
									if(($pemb_gaji_kena_ptkp -  $pph_bef) * $pph_percent > 0){
										$step1 =(($pemb_gaji_kena_ptkp -  $pph_bef) * $pph_percent)/100;
									}else{
										$step1 = 0;
									}
								}
							}elseif($pph_lv == "3"){
									if($pemb_gaji_kena_ptkp>$pph_ats){
										$step1 = ($pph_range * $pph_percent)/100;
									}else{
										if($pemb_gaji_kena_ptkp - $pph_ats > 0){
											$step1 = (($pemb_gaji_kena_ptkp - $pph_range) * $pph_percent)/100;
										}else{
											$step1 = 0;
										}											
									}
							}else{
									if($pemb_gaji_kena_ptkp - $pph_range > 0){
										$step1 = (($pemb_gaji_kena_ptkp - $pph_range) * $pph_range)/100;
									}else{
										$step1 = 0;
									}
							}
							$Pph21_setahun = $Pph21_setahun + $step1;
						}
						$pajak_setahun = round($Pph21_setahun,2);
						$pajak_sebulan = round(($pajak_setahun/12),2);
						// $pph21 = ($pajak*$bulanKe)-($row->pajak_bulan_lalu);
						$pph21 = 0;
						}while($pph!=$pph21);
		
						if($pph21<0){
							$pajak_dibayar = 0;
									}else {
							$pajak_dibayar = round($pph21,0);		
						}
						$fx_pajak				= $pajak_dibayar;																																			//UANG TAMBAHAN PAJAK
						
						//SUBTOTAL
						$subtotal1	= round($fx_gaji_pokok + $fx_ik + $fx_ip + $fx_if  + $fx_imm + $fx_ims + $fx_lembur + $fx_um + $fx_ubt + $fx_upamk + $fx_pajak + $fx_kp + $fx_insentif_kemahalan  - $fx_htm,0);
						$subtotal2	= round($subtotal1 + $fx_klaim_dl + $fx_thr + $fx_ubthr,2);
						$subtotal3	= round($subtotal2 - $fx_jht_k - $fx_jkn_k - $fx_jpk - $fx_pikop - $fx_putkop - $fx_cicilan_hutang - $fx_pot_duka - $fx_pot_spsi - $fx_pot_lain,0);
						//INSERT PEMBAYARAN PENGGAJIAN
						$data = array(
												'id_pembayaran_gaji' => str_replace(' ','',$noind.$varMonth.$varYear.date('His')),
												'tanggal' => $varDate,
												'noind' => $noind,
												'kd_status_kerja' => $kd_status_kerja,
												'kd_jabatan' => $p_kd_jabatan,
												'kodesie' => $kodesie,
												'kd_bank' => $kd_bank,
												'gaji_pokok' => $fx_gaji_pokok,
												'gaji_asuransi' => round($gaji_bruto,0),
												'gaji_bln_ini' => round($gaji_netto,0),
												'p_if' => $p_i_f,
												't_if' => $fx_if,
												'p_if_htg_bln_lalu' => "0",
												't_if_htg_bln_lalu' => "0",
												'p_ip' => $p_ip,
												't_ip' => $fx_ip,
												'p_ik' => $p_ik,
												't_ik' => $fx_ik,
												'p_ikr' => $p_i_f,
												't_ikr' => $fx_ikr,
												'p_ikr_htg_bln_lalu' => "0",
												't_ikr_htg_bln_lalu' => "0",
												'p_ikmhl' => $p_i_f,
												't_ikmhl' => $fx_insentif_kemahalan,
												'p_ikmhl_htg_bln_lalu' => "0",
												't_ikmhl_htg_bln_lalu' => "0",
												'p_ims' => $p_ims,
												't_ims' => $fx_ims,
												't_imm' => $p_imm,
												't_ims' => $fx_imm,
												'p_lembur' => $p_lembur,
												't_lembur' => round($fx_lembur,0),
												'p_ubt' => $p_ubt,
												'n_ubt' => $p_ubt,
												't_ubt' => $fx_ubt,
												'p_upamk' => $p_upamk,
												't_upamk' => $fx_upamk,
												'klaim_bln_lalu' => "",
												'klaim_pengangkatan' => "",
												'klaim_sisa_cuti' => $fx_klaim_cuti,
												'tkena_pajak' => $fx_kp,
												'konpensasi_lembur' => "",
												'rapel_gaji' => "",
												'htm' => $p_htm,
												'ijin' => $p_ijin,
												'pot_htm' => round($fx_htm,0),
												'htm_htg_bln_lalu' => "0",
												'ijin_htg_bln_lalu' => "0",
												'pot_htm_htg_bln_lalu' => "0",
												'pot_sakit_berkepanjangan' => round($fx_pot_skt_panjang,0),
												'subtotal_dibayarkan' => "",
												'klaim_dl' => $fx_klaim_dl,
												'thr' => $fx_thr,
												'ubthr' => $fx_ubthr,
												'klaim_sdh_byr' => "",
												'pajak' => $fx_pajak,
												'subtotal1' => $subtotal1,
												'subtotal2' => $subtotal2,
												'tt_pajak' => $fx_tkp,
												'pot_jht' => $fx_jht_k,
												'pot_jkn' => $fx_jkn_k,
												'pot_jpn' => $fx_jkm,
												'putkop' => $fx_putkop,
												'pikop' => $fx_pikop,
												'pot_kop' => "",
												'putang' => $fx_cicilan_hutang,
												'pduka' => $fx_pot_duka,
												'pspsi' => $fx_pot_spsi,
												'pot_pensiun' => $fx_jpk,
												'plain' => $fx_pot_lain,
												't_um_puasa' => $fx_um_puasa,
												'btransfer' => $fx_pot_transfer,
												'subtotal3' => $subtotal3,
												'kd_jns_transaksi' => "1",
										);
						// INSERT PEMBAYARAN PENGGAJIAN
						$this->M_transaksipenggajian->insert($data);
						$data_asuransi = array(
							'id_riw_pekerja' => str_replace(' ','',"ASR".$noind.$varMonth.$varYear.date('His')),
							'masuk_kerja'  => date('Y-m-d',strtotime($masukkerja)),
							'id_gajian'  => str_replace(' ','',$noind.$varMonth.$varYear.date('His')),
							'tanggal'  => $varDate,
							'noind'  => $noind,
							'kd_hubungan_kerja'  => $kd_hubungan_kerja,
							'kd_status_kerja'  => $kd_status_kerja,
							'gaji_asuransi'  => $fx_gaji_pokok,
							'trf_jkk'  => $r_jkk."%",
							'jkk'  => $fx_jkk,
							'trf_jht_kary'  => $p_jht_kary."%",
							'jht_kary'  => $fx_jht_k,
							'trf_jht_prshn'  => $p_jht_prshn."%",
							'jht_prshn'  => $fx_jht_p,
							'trf_jkm'  => $r_jkm."%",
							'jkm'  => $fx_jkm,
							'batas_max_jkn'  => $r_batas_max_jkn,
							'trf_jkn_kary'  => $p_jkn_kary."%",
							'jkn_kary'  => $fx_jkn_k,
							'trf_jkn_prshn'  => $p_jkn_prshn."%",
							'jkn_prshn'  => $fx_jkn_p,
							'kelas_perawatan'  => "",
							'batas_max_jpn'  => $r_batas_jpk,
							'trf_jpn_kary'  => $p_jpn_kary,
							'jpn_kary'  => $fx_jpk,
							'trf_jpn_prshn'  => $p_jpn_prshn,
							'jpn_prshn'  => $fx_jpp,
						);
						$this->M_transaksipenggajian->insert_asuransi($data_asuransi);
						
						$data_pajak = array(
							'tanggal'	=> $varDate,
							'noind'	=> $noind,
							'kd_area_pajak'	=> '',
							'status_pajak'	=> $fx_stat_pajak,
							'id_riwayat_ptkp'	=> $fx_ptkp,
							'penghasilan_tetap_per_bln' => $std_gaji,
							'penghasilan_bruto' => round($gaji_bruto,2),
							'periode_jst' => round($fx_jht_p,2),
							'premi_jkk' => round($fx_jkk,2),
							'premi_jk' => round($fx_jkm,2),
							'premi_jkn' => round($fx_jkn_p,2),
							'premi_jpensiun_prshn' => round($fx_jpp,2),
							'biaya_jabatan' => round($fx_bea_jab,2),
							'iuran_pensiun' =>round( $p_max_pensiun,2),
							'iuran_jht' => round($fx_jht_k,2),
							'iuran_jkn' => round($fx_jkn_k,2),
							'iuran_jpensiun_kar' => round($fx_jpk,2),
							'penghasilan_neto' => round($gaji_netto,2),
							'penghasilan_sd_bln_tsb' => round($gaji_sd_bln_tsb,2),
							'gaji_disetahunkan' => round($gaji_setahun,2),
							'ptkp_setahun' => round($fx_ptkp,2),
							'pkp_setahun' => round($gaji_kena_ptkp,2),
							'pkp_setahun_pembulatan' => round($pemb_gaji_kena_ptkp,2),
							'id_pph' => "",
							'id_bbn_pengurang' => "",
							'bayar_pph' => round($pajak_setahun,2),
							'pajak_disetahunkan' => round($pajak_setahun,2),
							'pajak_per_bln' => round($pajak_sebulan,2),
							'pajak_yang_dibayar_bln_tsb' => round($fx_pajak,2),
							'kelebihan_bayar' => "",
						);
						
						$this->M_transaksipenggajian->insert_transaksi_pajak($data_pajak);
						
						$data_insentif_kemahalan = array(
							'tanggal'		=> $varDate,
							'noind'			=> $noind,
							'kd_hubungan_kerja'	=> $kd_hubungan_kerja,
							'kd_status_kerja'		=> $kd_status_kerja,
							'kd_jabatan'		=> $kd_jabatan,
							'kodesie'		=> $kodesie,
							'p_if'			=> $p_i_f,
							'n_kmh'		=> $r_insentif_kemahalan,
							't_kmh'			=> $fx_insentif_kemahalan,
						);
						
						
					
						$this->M_transaksipenggajian->insert_transaksi_insentif_kemahalan($data_insentif_kemahalan);
						//REVIEW PERHITUNGAN 
						// echo "<table>";
						// echo "<tr><td>gaji pokok</td><td>= ".$fx_gaji_pokok."</td></tr>";
						// echo "<tr><td>insentif</td><td>= ".$std_insentif."</td></tr>";
						// echo "<tr><td>gaji pokok bln ini</td><td>= ".$gp_bln_ini."</td></tr>";
						// echo "<tr><td>insentif bln ini</td><td>= ".$insentif_bln_ini."</td></tr>";
						// echo "<tr><td>perjalanan dinas</td><td>= ".$fx_klaim_dl."</td></tr>";
						// echo "<tr><td>thr</td><td>= ".$fx_thr."</td></tr>";
						// echo "<tr><td>ubthr</td><td>= ".$fx_ubthr."</td></tr>";
						// echo "<tr><td>lembur</td><td>= ".$fx_lembur."</td></tr>";
						// echo "<tr><td>koreksi</td><td>= ".$fx_kp."</td></tr>";
						// echo "<tr><td>penghasilan sebulan</td><td>= ".$gaji_sbln."</td></tr>";
						// echo "<tr><td>premi jkk</td><td>= ".$fx_jkk."</td></tr>";
						// echo "<tr><td>premi jk</td><td>= ".$fx_jkm."</td></tr>";
						// echo "<tr><td>premi jkn</td><td>= ".$fx_jkn_p."</td></tr>";
						// echo "<tr><td>premi jht</td><td>= ".$fx_jht_p."</td></tr>";
						// echo "<tr><td>premi jp</td><td>= ".$fx_jpp."</td></tr>";
						// echo "<tr><td>total premi</td><td>= ".$ttl_premi."</td></tr>";
						// echo "<tr><td>jumlah penghasilan bruto</td><td>= ".$gaji_bruto."</td></tr>";
						// echo "<tr><td>biaya jabatan</td><td>= ".$fx_bea_jab."</td></tr>";
						// echo "<tr><td>pot jht</td><td>= ".$fx_jht_k."</td></tr>";
						// echo "<tr><td>pot jkn</td><td>= ".$fx_jkn_k."</td></tr>";
						// echo "<tr><td>pot jp</td><td>= ".$fx_jpk."</td></tr>";
						// echo "<tr><td>total pengurangan</td><td>= ".$ttl_pot."</td></tr>";
						// echo "<tr><td>penghasilan netto sebulan</td><td>= ".$gaji_netto."</td></tr>";
						// echo "<tr><td>penghasilan netto setahun</td><td>= ".$gaji_setahun."</td></tr>";
						// echo "<tr><td>PTKP</td><td>= ".$fx_ptkp."</td></tr>";
						// echo "<tr><td>penghasilan kena pajak setahun</td><td>= ".$gaji_kena_ptkp."</td></tr>";
						// echo "<tr><td>pembulatan</td><td>= ".$pemb_gaji_kena_ptkp."</td></tr>";
						// echo "<tr><td>pph21 setahun</td><td>= ((".$gaji_kena_ptkp." -  ".$pph_bef.") * ".$pph_percent.")/100</td></tr>";
						// echo "<tr><td>pph21 setahun</td><td>= ".$Pph21_setahun."</td></tr>";
						// echo "<tr><td>pph21 sebulan</td><td>= ".$pajak_sebulan."</td></tr>";
						// echo "<tr><td>yang harus di bayar</td><td>= ".$fx_pajak."</td></tr>";
						// echo "</table>";
					}
		}
	}

    public function checkSession(){
        if($this->session->is_logged){
            
        }else{
            redirect(site_url());
        }
    }

    public function formValidation()
    {
	}

}

/* End of file C_TransaksiHutang.php */
/* Location: ./application/controllers/PayrollManagement/TransaksiHutang/C_TransaksiHutang.php */
/* Generated automatically on 2016-11-29 08:18:23 */