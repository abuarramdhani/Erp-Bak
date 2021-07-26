<?php 
defined('BASEPATH') or exit("Access Denied");
/**
 * 
 */
class M_bantuanupah extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->personalia = $this->load->database('personalia', true);
	}

	function getHubunganKerja()
	{
		$sql = "select fs_noind,fs_ket
			from hrd_khs.tnoind
			order by fs_noind";
		return $this->personalia->query($sql)->result_array();
	}

	function getbantuanUpahAll()
	{
		$sql = "select a.*,b.nama
			from \"Presensi\".t_bantuan_upah a 
			inner join hrd_khs.tpribadi b 
			on a.created_by = b.noind
			order by a.created_at desc ";
		return $this->personalia->query($sql)->result_array();
	}

	function insertBantuanUpah($data)
	{
		$this->personalia->insert("\"Presensi\".t_bantuan_upah", $data);
		return $this->personalia->insert_id();
	}

	function insertBantuanUpahDetail($data)
	{
		$this->personalia->insert("\"Presensi\".t_bantuan_upah_detail", $data);
	}

	function deleteBantuanUpah($id)
	{
		$this->personalia->where('id', $id);
		$this->personalia->delete("\"Presensi\".t_bantuan_upah");
	}

	function deleteBantuanUpahDetail($id)
	{
		$this->personalia->where('id_bantuan_upah',$id);
		$this->personalia->delete("\"Presensi\".t_bantuan_upah_detail");
	}

	function getBantuanUpahDetail($id)
	{
		$this->personalia->where('id_bantuan_upah', $id);
		return $this->personalia->get("\"Presensi\".t_bantuan_upah_detail")->result_array();
	}

	function getBantuanUpah($id)
	{
		$this->personalia->where('id', $id);
		return $this->personalia->get("\"Presensi\".t_bantuan_upah")->row();
	}

	function getPekerja($hubker,$awal,$akhir)
	{
		if (!empty($hubker)) {
			$string = "";
			foreach ($hubker as $hk) {
				if (empty($string)) {
					$string = "'".$hk."'";
				}else{
					$string .= ",'".$hk."'";
				}
			}
			$where = "and left(tdp.noind,1) in ($string)";
		}else{
			$where = "";
		}
		$sql = "select tdp.noind
			from \"Presensi\".tdatapresensi tdp
			where tdp.tanggal between ? and ?
			and tdp.kd_ket in ('PRM','PSK','PKJ')
			and replace(trim(tdp.alasan),' ','') like '%ISOLASIDIRI%'
			$where
			group by tdp.noind
			order by tdp.noind";
		return $this->personalia->query($sql,array($awal,$akhir))->result_array();
	}

	function getHasil($noind,$awal,$akhir)
	{
		$sql = "select t1.noind,
				t1.nama,
				t1.lokasi_kerja,
				t1.klasifikasi,
				t1.mulai,
				t1.selesai,
				t1.alasan,
				case when tki.kom_gp != '-' then jumlah::varchar else '-' end as gp_jumlah,
				case when tki.kom_gp != '-' then tki.kom_gp else '-' end as gp_persen,
				case when tki.kom_if != '-' then jumlah::varchar else '-' end as if_jumlah,
				case when tki.kom_if != '-' then tki.kom_if else '-' end as if_persen,
				case when tki.kom_ip != '-' then jumlah::varchar else '-' end as ip_jumlah,
				case when tki.kom_ip != '-' then tki.kom_ip else '-' end as ip_persen,
				case when tki.kom_ip != '-' then jumlah::varchar else '-' end as ip_jumlah,
				case when tki.kom_ip != '-' then tki.kom_ip else '-' end as ip_persen,
				case when tki.kom_ipt != '-' then jumlah::varchar else '-' end as ipt_jumlah,
				case when tki.kom_ipt != '-' then tki.kom_ipt else '-' end as ipt_persen,
				case when tki.kom_ik != '-' then jumlah::varchar else '-' end as ik_jumlah,
				case when tki.kom_ik != '-' then tki.kom_ik else '-' end as ik_persen,
				case when tki.kom_ikr != '-' then jumlah::varchar else '-' end as ikr_jumlah,
				case when tki.kom_ikr != '-' then tki.kom_ikr else '-' end as ikr_persen,
				case when tki.ins_patuh != '-' then jumlah::varchar else '-' end as ins_patuh_jumlah,
				case when tki.ins_patuh != '-' then tki.ins_patuh else '-' end as ins_patuh_persen,
				case when tki.ins_mahal != '-' then jumlah::varchar else '-' end as ins_mahal_jumlah,
				case when tki.ins_mahal != '-' then tki.ins_mahal else '-' end as ins_mahal_persen,
				case when tki.ins_tempat != '-' then jumlah::varchar else '-' end as ins_tempat_jumlah,
				case when tki.ins_tempat != '-' then tki.ins_tempat else '-' end as ins_tempat_persen,
				case when tki.ins_disiplin != '-' then jumlah::varchar else '-' end as ins_disiplin_jumlah,
				case when tki.ins_disiplin != '-' then tki.ins_disiplin else '-' end as ins_disiplin_persen,
				case when tki.ins_abc != '-' then jumlah::varchar else '-' end as ins_abc_jumlah,
				case when tki.ins_abc != '-' then tki.ins_abc else '-' end as ins_abc_persen,
				case when tki.kom_ubt != '-' then jumlah::varchar else '-' end as ubt_jumlah,
				case when tki.kom_ubt != '-' then tki.kom_ubt else '-' end as ubt_persen,
				case when tki.kom_upamk != '-' then jumlah::varchar else '-' end as upamk_jumlah,
				case when tki.kom_upamk != '-' then tki.kom_upamk else '-' end as upamk_persen
			from (
				select
				  tdp.noind,
				  tp.nama,
				  tor.kd_jabatan,
				  tor.jabatan,
				  case tp.lokasi_kerja 
				  	when '01' then 
				  		'pusat'
				  	when '02' then 
				  		'tuksono'
				  	when '03' then 
				  		'pusat'
				  	when '04' then 
				  		'pusat'
				  	else 
				  		'cabang'
				  end as lokasi,
				  tlk.lokasi_kerja,
				  string_agg(tdp.tanggal::date::varchar,' ; ' order by tdp.tanggal) as tanggal,
				  min(tdp.tanggal::date) as mulai, 
				  max(tdp.tanggal::date) as selesai,
				  count(*) as jumlah,
				  replace(trim(tdp.alasan),' ','') as alasan,
				  case when tp.lokasi_kerja in ('01','02','03','04') then 
					  case trim(tor.jabatan)
					    when 'Direktur Utama' then 
					      'Pekerja Tetap Staf'
					    when 'Kepala Departemen' then 
					      'Pekerja Tetap Staf'
					    when 'Wakil Kepala Departemen' then 
					      'Pekerja Tetap Staf'
					    when 'Asisten Kepala Departemen' then 
					      'Pekerja Tetap Staf'
					    when 'Koordinator Bidang' then 
					     'Pekerja Tetap Staf'
					    when 'Asisten Kepala Bidang' then 
					      'Pekerja Tetap Staf'
					    when 'Kepala Bidang' then 
					     'Pekerja Tetap Staf'
					    when 'Kepala Unit' then 
					      'Pekerja Tetap Staf'
					    when 'Asisten Kepala Unit' then 
					     'Pekerja Tetap Staf'
					    when 'Kepala Seksi Utama' then 
					     'Pekerja Tetap Staf'
					    when 'Kepala Seksi Madya' then 
					      'Pekerja Tetap Staf'
					    when 'Kepala Seksi Pratama' then 
					      'Pekerja Tetap Staf'
					    when 'Supervisor' then 
					     'Pekerja Tetap Staf'
					    when 'Pekerja Staf' then 
					     'Pekerja Tetap Staf'
					    when 'Pekerja Non Staf' then
					      'Pekerja Tetap Non Staf'
					    when 'Pekerja Kontrak Staff' then 
					      'Pekerja Kontrak Staf'
					    when 'Pekerja Kontrak Nonstaff' then 
					      'Pekerja Kontrak Non Staf'
					    when 'Pekerja Outsourcing' then 
					     'Pekerja Outsourching'
					    when 'Trainee staff' then 
					      ''
					    when 'TKPW' then 
					      ''
					    when 'Tenaga Harian Lepas' then 
					     'Pekerja Harian Lepas'
					    when 'PEMBORONGAN' then 
					      'Pekerja Outsourching'
					    when 'TRAINEE NONSTAFF' then 
					      ''
					    when 'PKL Non Staff' then 
					      ''
					    when 'PKL Staff' then 
					      '' 
					  end
					else 
						case when left(tdp.noind,1) != 'C' then 
							'pekerja Tetap Staf Pusat ditempatkan di Cabang'
						else 
							case right(left(tdp.noind,3),1)
								when '1' then 
									'Pekerja Tetap'
								when '2' then 
									'Pekerja Kontrak'
								when '3' then 
									'Pekerja Outsourching'
								when '4' then
									'Harian Lepas'
								else 
									''
							end
						end
					end as klasifikasi
				from \"Presensi\".tdatapresensi tdp
				left join hrd_khs.tpribadi tp 
					on tp.noind = tdp.noind
				left join hrd_khs.torganisasi tor 
					on tor.kd_jabatan=tp.kd_jabatan
				left join hrd_khs.tlokasi_kerja tlk 
					on tlk.id_=tp.lokasi_kerja
				where tdp.tanggal between ? and ?
				/*and tdp.kd_ket in ('PRM','PSK','PKJ') ada keterangan selain PRM, PSK, PKJ*/
				and replace(trim(tdp.alasan),' ','') like '%ISOLASIDIRI%'
				and tdp.noind = ?
				group by tdp.noind,
				  tp.nama,
				  tor.kd_jabatan,
				  tor.jabatan,
				  tp.lokasi_kerja,
				  tlk.lokasi_kerja,
				  replace(trim(tdp.alasan),' ','')
			) as t1 
			left join \"Presensi\".t_komponen_isolasi tki
			on t1.lokasi = tki.lokasi
			and replace(trim(t1.alasan),' ','') = replace(trim(tki.kategori),' ','')
			and t1.klasifikasi = tki.hubungan_kerja
			order by 1,t1.mulai";
		return $this->personalia->query($sql,array($awal,$akhir,$noind))->result_array();
	}

	function getProgress($user)
	{
		$this->personalia->where('user_', $user);
		$this->personalia->where('menu','BantuanUpah');
		return $this->personalia->get("\"Presensi\".progress_transfer_reffgaji")->row();
	}

	function deleteProgress($user)
	{
		$this->personalia->where('user_', $user);
		$this->personalia->where('menu','BantuanUpah');
		$this->personalia->delete("\"Presensi\".progress_transfer_reffgaji");
	}

	function updateProgress($user,$progress,$ket)
	{
		$this->personalia->where('user_', $user);
		$this->personalia->where('menu','BantuanUpah');
		$data = array(
			'progress' => $progress,
			'keterangan' => $ket
		);
		$this->personalia->update("\"Presensi\".progress_transfer_reffgaji", $data);
	}

	function insertProgress($user,$total)
	{
		$data = array(
			'user_' => $user,
			'progress' => 0,
			'total' => $total,
			'menu' => 'BantuanUpah',
			'keterangan' => 'Mulai Proses'
		);
		$this->personalia->insert("\"Presensi\".progress_transfer_reffgaji",$data);
	}

	function getTanggalDataPres($noind,$alasan,$awal,$akhir){
		$sql = "select *
			from \"Presensi\".tdatapresensi
			where noind = ?
			and tanggal between ? and ?
			and replace(trim(alasan),' ','') = ?
			order by tanggal;";
		return $this->personalia->query($sql,array($noind,$awal,$akhir,$alasan))->result_array();
	}

	function cek_ijin_keluar($keluar,$masuk,$break_mulai,$break_selesai,$ist_mulai,$ist_selesai){
		$jam_ijin = 0;

		if($ist_mulai < $break_mulai ){
	        $aa = $break_mulai;
	        $bb = $break_selesai;
	        $break_mulai = $ist_mulai;
	        $break_selesai = $ist_selesai;
	        $ist_mulai = $aa;
	        $ist_selesai = $bb;
	    }

	    if($keluar >= $ist_mulai && $masuk >= $ist_mulai){
	        If($ist_selesai >= $keluar && $ist_selesai >= $masuk){
	            $lama_izin = $masuk - $keluar;
	            $lama_istirahat = $ist_selesai - $ist_mulai;
	            $jam_ijin = $lama_izin - $lama_istirahat;          
	        }elseif($keluar >= $ist_selesai && $masuk >= $ist_selesai){
	            $jam_ijin = $masuk - $keluar;
	        }else{
	            $jam_ijin = $masuk - $ist_selesai;
	        }
	    }elseif($keluar <= $ist_mulai && $masuk >= $ist_mulai){
	        if($ist_selesai >= $keluar && $ist_selesai >= $masuk){
	            if($keluar <= $break_mulai && $keluar <= $break_selesai){
	                $sebelum_break = $break_mulai - $keluar;
	                $setelah_break = $ist_mulai - $break_selesai;
	                $jam_ijin = $sebelum_break + $setelah_break;              
	            }elseif($keluar > $break_mulai && $keluar <= $break_selesai){
	                $jam_ijin = $ist_mulai - $break_selesai;
	            }else{
	                $jam_ijin = $ist_mulai - $keluar;
	                if($jam_ijin <= 30){
	                    $jam_ijin = 0;
	                }else{
	                    $jam_ijin = $jam_ijin;
	                }                
	            }        
	        }elseif($keluar <= $ist_selesai && $masuk > $ist_selesai){
	            if($keluar <= $break_mulai){
	                $sebelum_break = $break_mulai - $keluar;
	                $sebelum_istirahat = $ist_mulai - $break_selesai;
	                $setelah_istirahat = $masuk - $ist_selesai;
	                if($sebelum_break < 0){
	                    $sebelum_break = 0;
	                }
	                if($sebelum_istirahat < 0){
	                    $sebelum_istirahat = 0;
	                }
	                if($setelah_istirahat < 0){
	                    $setelah_istirahat = 0;
	                }
	                $jam_ijin = $sebelum_break + $sebelum_istirahat + $setelah_istirahat;
	            }elseif($keluar > $break_mulai && $keluar >= $break_selesai){
	                $sebelum_istirahat = $ist_mulai - $keluar;
	                $setelah_istirahat = $masuk - $ist_selesai;
	                $jam_ijin = $sebelum_istirahat + $setelah_istirahat;
	            }elseif($keluar >= $break_mulai && $keluar <= $break_selesai){
	                $sebelum_istirahat = $ist_mulai - $break_selesai;
	                $setelah_istirahat = $masuk - $ist_selesai;
	                $jam_ijin = $sebelum_istirahat + $setelah_istirahat;
	            }
	        }
	    }else{
	        if($keluar >= $break_mulai && $masuk >= $break_mulai){
	            if($break_selesai >= $keluar && $break_selesai >= $masuk){
	                $jam_ijin = 0;
	            }elseif($keluar >= $break_selesai && $masuk >= $break_selesai){
	                $jam_ijin = $masuk - $keluar;
	            }else{
	                $jam_ijin = $masuk - $break_selesai;
	            }            
	        }elseif($keluar <= $break_mulai && $masuk >= $break_mulai){
	            if($break_selesai >= $keluar && $break_selesai >= $masuk){
	                $jam_ijin = $break_mulai - $keluar;
	            }else{
	                $sebelum_break = $break_mulai - $keluar;
	                $setelah_break = $masuk - $break_selesai;
	                $jam_ijin = $sebelum_break + $setelah_break;                
	            }
	        }else{
	            $jam_ijin = $masuk - $keluar;
	        }        
	    }

	    if ($jam_ijin > 0 && $jam_ijin < 60) {
	        $jam_ijin = $jam_ijin/60;
	    }else if($jam_ijin >= 60){
	        $jam_ijin = $jam_ijin/60;
	    }else if($jam_ijin < 0){
	    	$jam_ijin = 0;
	    }

		return $jam_ijin;
	}

	function cek_bebas_denda_if($keluar,$masuk,$ist_mulai,$ist_selesai){
		$hasil = false;
		if ($keluar < $ist_mulai && $keluar < $ist_selesai) {
			if($masuk <= $ist_selesai) {
				$hit = $ist_mulai - $keluar;
				if ($hit <= 1800) {
					$hasil = true;
				}else{
					$hasil = false;
				}
			}
		}

		return $hasil;
	}

	function hitungIp($noind,$tanggal){
		$sql = "select count(tdp.tanggal) as jml
				FROM \"Presensi\".TDataPresensi tdp INNER JOIN
				(SELECT DISTINCT * from \"Presensi\".TShiftPekerja) tsp ON tdp.tanggal = tsp.tanggal AND tdp.noind = tsp.noind
				WHERE tdp.tanggal = '$tanggal'
				AND (tdp.kd_ket = 'PKJ' or (tdp.kd_ket = 'PDL') or (tdp.kd_ket = 'PDB') or tdp.kd_ket = 'PLB' or tdp.kd_ket = 'PID'or tdp.kd_ket = 'PRM')
				AND tdp.noind = '$noind'";
		$result1 = $this->personalia->query($sql)->result_array();

		$sql = "select a.tanggal, a.noind,
						concat(a.tanggal::date,' ',a.keluar)::timestamp as keluar,
						case when a.masuk::time < a.keluar::time then
							concat((a.tanggal + interval '1 day')::date,' ',a.masuk)::timestamp
						else
							concat(a.tanggal::date,' ',a.masuk)::timestamp
						end as masuk,
						a.kd_ket,
						b.jam_kerja,
						case when b.jam_msk::time > b.ist_mulai::time then
							concat((a.tanggal + interval '1 day')::date,' ',b.ist_mulai)::timestamp
						else
							concat(a.tanggal::date,' ',b.ist_mulai)::timestamp
						end as ist_mulai,
						case when b.jam_msk::time > b.ist_selesai::time then
							concat((a.tanggal + interval '1 day')::date,' ',b.ist_selesai)::timestamp
						else
							concat(a.tanggal::date,' ',b.ist_selesai)::timestamp
						end as ist_selesai,
						case when b.jam_msk::time > b.break_mulai::time then
							concat((a.tanggal + interval '1 day')::date,' ',b.break_mulai)::timestamp
						else
							concat(a.tanggal::date,' ',b.break_mulai)::timestamp
						end as break_mulai,
						case when b.jam_msk::time > b.break_selesai::time then
							concat((a.tanggal + interval '1 day')::date,' ',b.break_selesai)::timestamp
						else
							concat(a.tanggal::date,' ',b.break_selesai)::timestamp
						end as break_selesai
				FROM \"Presensi\".TDataPresensi a INNER JOIN
				\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
				WHERE (a.tanggal = '$tanggal') AND (a.kd_ket = 'PSP') AND (a.noind = '$noind') 
				Union
				SELECT a.tanggal, a.noind,
					concat(a.tanggal::date,' ',a.keluar)::timestamp as keluar,
					case when a.masuk::time < a.keluar::time then
						concat((a.tanggal + interval '1 day')::date,' ',a.masuk)::timestamp
					else
						concat(a.tanggal::date,' ',a.masuk)::timestamp
					end as masuk,
					a.kd_ket,
					b.jam_kerja,
					case when b.jam_msk::time > b.ist_mulai::time then
						concat((a.tanggal + interval '1 day')::date,' ',b.ist_mulai)::timestamp
					else
						concat(a.tanggal::date,' ',b.ist_mulai)::timestamp
					end as ist_mulai,
					case when b.jam_msk::time > b.ist_selesai::time then
						concat((a.tanggal + interval '1 day')::date,' ',b.ist_selesai)::timestamp
					else
						concat(a.tanggal::date,' ',b.ist_selesai)::timestamp
					end as ist_selesai,
					case when b.jam_msk::time > b.break_mulai::time then
						concat((a.tanggal + interval '1 day')::date,' ',b.break_mulai)::timestamp
					else
						concat(a.tanggal::date,' ',b.break_mulai)::timestamp
					end as break_mulai,
					case when b.jam_msk::time > b.break_selesai::time then
						concat((a.tanggal + interval '1 day')::date,' ',b.break_selesai)::timestamp
					else
						concat(a.tanggal::date,' ',b.break_selesai)::timestamp
					end as break_selesai
				FROM \"Presensi\".TDataTIM a INNER JOIN
				\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
				WHERE (a.tanggal = '$tanggal') AND (a.kd_ket = 'TIK') AND (a.noind = '$noind')
				ORDER BY tanggal";
		$result2 = $this->personalia->query($sql)->result_array();
		if(!empty($result1)){
			$nilai = $result1['0']['jml'];
		}else{
			$nilai = 0;
		}
		$simpan_tgl = "";
		$lanjut = false;

		foreach ($result2 as $tik) {
			if ($tik['tanggal'] !== $simpan_tgl) {
				$lanjut = false;
			}
			$keluar = strtotime($tik['keluar']);
			$masuk = strtotime($tik['masuk']);
			$ist_mulai = strtotime($tik['ist_mulai']);
			$ist_selesai = strtotime($tik['ist_selesai']);
			$break_mulai = strtotime($tik['break_mulai']);
			$break_selesai = strtotime($tik['break_selesai']);
			if ($ist_mulai < $break_mulai) {
				$simpan_ist_mulai = $ist_mulai;
				$simpan_ist_selesai = $ist_selesai;
				$ist_mulai = $break_mulai;
				$ist_selesai = $break_selesai;
				$break_mulai = $simpan_ist_mulai;
				$break_selesai = $simpan_ist_selesai;
			}

			$ijin = $this->cek_ijin_keluar($keluar,$masuk,$break_mulai,$break_selesai,$ist_mulai,$ist_selesai);
			if ($ijin <= 0) {
				$nilai = $nilai;
			}else if($ijin > 0 && $ijin <= 60){
				$nilai = $nilai;
			}else{
				if($lanjut == false){
					$nilai -= 1;
				}
			}

			$simpan_tgl = $tik['tanggal'];
		}

		return $nilai;
	}

	function hitungIk($noind,$tanggal){
		$sql = "select count(tdp.tanggal) as jml
				FROM \"Presensi\".TDataPresensi tdp INNER JOIN
				(SELECT DISTINCT * from \"Presensi\".TShiftPekerja) tsp ON tdp.tanggal = tsp.tanggal AND tdp.noind = tsp.noind
				WHERE tdp.tanggal = '$tanggal'
				AND (tdp.kd_ket = 'PKJ' or (tdp.kd_ket = 'PDL') or (tdp.kd_ket = 'PDB') or tdp.kd_ket = 'PLB' or tdp.kd_ket = 'PID' or tdp.kd_ket = 'PRM')
				AND tdp.noind = '$noind'";
		$result1 = $this->personalia->query($sql)->result_array();

		$sql = "select a.tanggal, a.noind,
						concat(a.tanggal::date,' ',a.keluar)::timestamp as keluar,
						case when a.masuk::time < a.keluar::time then
							concat((a.tanggal + interval '1 day')::date,' ',a.masuk)::timestamp
						else
							concat(a.tanggal::date,' ',a.masuk)::timestamp
						end as masuk,
						a.kd_ket,
						b.jam_kerja,
						case when b.jam_msk::time > b.ist_mulai::time then
							concat((a.tanggal + interval '1 day')::date,' ',b.ist_mulai)::timestamp
						else
							concat(a.tanggal::date,' ',b.ist_mulai)::timestamp
						end as ist_mulai,
						case when b.jam_msk::time > b.ist_selesai::time then
							concat((a.tanggal + interval '1 day')::date,' ',b.ist_selesai)::timestamp
						else
							concat(a.tanggal::date,' ',b.ist_selesai)::timestamp
						end as ist_selesai,
						case when b.jam_msk::time > b.break_mulai::time then
							concat((a.tanggal + interval '1 day')::date,' ',b.break_mulai)::timestamp
						else
							concat(a.tanggal::date,' ',b.break_mulai)::timestamp
						end as break_mulai,
						case when b.jam_msk::time > b.break_selesai::time then
							concat((a.tanggal + interval '1 day')::date,' ',b.break_selesai)::timestamp
						else
							concat(a.tanggal::date,' ',b.break_selesai)::timestamp
						end as break_selesai
				FROM \"Presensi\".TDataPresensi a INNER JOIN
				\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
				WHERE (a.tanggal = '$tanggal') AND (a.kd_ket = 'PSP') AND (a.noind = '$noind')
				Union
				SELECT a.tanggal, a.noind,
						concat(a.tanggal::date,' ',a.keluar)::timestamp as keluar,
						case when a.masuk::time < a.keluar::time then
							concat((a.tanggal + interval '1 day')::date,' ',a.masuk)::timestamp
						else
							concat(a.tanggal::date,' ',a.masuk)::timestamp
						end as masuk,
						a.kd_ket,
						b.jam_kerja,
						case when b.jam_msk::time > b.ist_mulai::time then
							concat((a.tanggal + interval '1 day')::date,' ',b.ist_mulai)::timestamp
						else
							concat(a.tanggal::date,' ',b.ist_mulai)::timestamp
						end as ist_mulai,
						case when b.jam_msk::time > b.ist_selesai::time then
							concat((a.tanggal + interval '1 day')::date,' ',b.ist_selesai)::timestamp
						else
							concat(a.tanggal::date,' ',b.ist_selesai)::timestamp
						end as ist_selesai,
						case when b.jam_msk::time > b.break_mulai::time then
							concat((a.tanggal + interval '1 day')::date,' ',b.break_mulai)::timestamp
						else
							concat(a.tanggal::date,' ',b.break_mulai)::timestamp
						end as break_mulai,
						case when b.jam_msk::time > b.break_selesai::time then
							concat((a.tanggal + interval '1 day')::date,' ',b.break_selesai)::timestamp
						else
							concat(a.tanggal::date,' ',b.break_selesai)::timestamp
						end as break_selesai
				FROM \"Presensi\".TDataTIM a INNER JOIN
				\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
				WHERE (a.tanggal = '$tanggal') AND (a.kd_ket = 'TIK') AND (a.noind = '$noind')
				ORDER BY tanggal";
		$result2 = $this->personalia->query($sql)->result_array();
		if(!empty($result1)){
			$nilai = $result1['0']['jml'];
		}else{
			$nilai = 0;
		}
		$simpan_tgl = "";
		$lanjut = false;
		foreach ($result2 as $tik) {
			if ($tik['tanggal'] !== $simpan_tgl) {
				$lanjut = false;
			}
			$keluar = strtotime($tik['keluar']);
			$masuk = strtotime($tik['masuk']);
			$ist_mulai = strtotime($tik['ist_mulai']);
			$ist_selesai = strtotime($tik['ist_selesai']);
			$break_mulai = strtotime($tik['break_mulai']);
			$break_selesai = strtotime($tik['break_selesai']);
			if ($ist_mulai < $break_mulai) {
				$simpan_ist_mulai = $ist_mulai;
				$simpan_ist_selesai = $ist_selesai;
				$ist_mulai = $break_mulai;
				$ist_selesai = $break_selesai;
				$break_mulai = $simpan_ist_mulai;
				$break_selesai = $simpan_ist_selesai;
			}

			$ijin = $this->cek_ijin_keluar($keluar,$masuk,$break_mulai,$break_selesai,$ist_mulai,$ist_selesai);
			if ($ijin <= 0) {
				$nilai = $nilai;
			}else if($ijin > 0 && $ijin <= 30){
				$cek_denda = $this->cek_bebas_denda_if($keluar,$masuk,$ist_mulai,$ist_selesai);
				if ($cek_denda == false) {
					if($lanjut == false) {
						$nilai -= 1;
					}
				}
			}else{
				if($lanjut == false){
					$nilai -= 1;
				}
			}

			$simpan_tgl = $tik['tanggal'];
		}
		// echo $result1['0']['jml']."<br>".$nilai;exit();
		return $nilai;
	}

	function hitungIpt($noind,$tanggal){
		$sql = " select * 
				 from hrd_khs.tpribadi a 
				 where a.noind = '$noind' 
				 and ( 
				     a.lokasi_kerja = '02' 
				     or 
				     ( 
				         select count(*) 
				         from hrd_khs.tmutasi b 
				         Where a.noind = b.noind 
				         and b.tglberlaku between '$tanggal' and now() 
				         and ( 
				                 b.lokasilm = '02' 
				                 or 
				                 b.lokasibr = '02' 
				             ) 
				      ) > 0 
				     ) ";
		$result = $this->personalia->query($sql)->result_array();
		if (!empty($result)) {
			$sql = "select noind ,lokasilm, lokasibr,
						 case when lokasilm != '02' then
						     tglberlaku 
						 else 
						     '$tanggal'
						 end as mulai, 
						 case when lokasibr != '02' then  
						     case when '$tanggal' > tglberlaku - interval '1 day' then
						         tglberlaku -Interval  '1 day' 
						     Else 
						         '$tanggal' 
						     end
						 else 
						      '$tanggal' 
						 end as selesai 
					from hrd_khs.tmutasi 
					where tglberlaku between '$tanggal' and now() 
					and (lokasilm ='02' or lokasibr = '02') 
					and noind = '$noind' ";
			$result_2 = $this->personalia->query($sql)->row();
			if (!empty($result_2)) {
				foreach ($result_2 as $key) {
					$awal = $key->mulai;
					$akhir = $key->selesai;

					$sql = "select count(tdp.tanggal) as jml
							FROM \"Presensi\".TDataPresensi tdp INNER JOIN
							(SELECT DISTINCT * from \"Presensi\".TShiftPekerja) tsp ON tdp.tanggal = tsp.tanggal AND tdp.noind = tsp.noind
							WHERE tdp.tanggal >= '$awal' AND tdp.tanggal <= '$akhir'
							AND (tdp.kd_ket = 'PKJ' or (tdp.kd_ket = 'PDL') or (tdp.kd_ket = 'PDB') or tdp.kd_ket = 'PLB' or tdp.kd_ket = 'PID' or tdp.kd_ket = 'PRM')
							AND tdp.noind = '$noind'";
					$result1 = $this->personalia->query($sql)->result_array();

					$sql = "select a.tanggal, a.noind,
									concat(a.tanggal::date,' ',a.keluar)::timestamp as keluar,
									case when a.masuk::time < a.keluar::time then
										concat((a.tanggal + interval '1 day')::date,' ',a.masuk)::timestamp
									else
										concat(a.tanggal::date,' ',a.masuk)::timestamp
									end as masuk,
									a.kd_ket,
									b.jam_kerja,
									case when b.jam_msk::time > b.ist_mulai::time then
										concat((a.tanggal + interval '1 day')::date,' ',b.ist_mulai)::timestamp
									else
										concat(a.tanggal::date,' ',b.ist_mulai)::timestamp
									end as ist_mulai,
									case when b.jam_msk::time > b.ist_selesai::time then
										concat((a.tanggal + interval '1 day')::date,' ',b.ist_selesai)::timestamp
									else
										concat(a.tanggal::date,' ',b.ist_selesai)::timestamp
									end as ist_selesai,
									case when b.jam_msk::time > b.break_mulai::time then
										concat((a.tanggal + interval '1 day')::date,' ',b.break_mulai)::timestamp
									else
										concat(a.tanggal::date,' ',b.break_mulai)::timestamp
									end as break_mulai,
									case when b.jam_msk::time > b.break_selesai::time then
										concat((a.tanggal + interval '1 day')::date,' ',b.break_selesai)::timestamp
									else
										concat(a.tanggal::date,' ',b.break_selesai)::timestamp
									end as break_selesai
							FROM \"Presensi\".TDataPresensi a INNER JOIN
							\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
							WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'PSP') AND (a.noind = '$noind') AND
							(a.tanggal <= '$akhir')
							Union
							SELECT a.tanggal, a.noind,
								concat(a.tanggal::date,' ',a.keluar)::timestamp as keluar,
								case when a.masuk::time < a.keluar::time then
									concat((a.tanggal + interval '1 day')::date,' ',a.masuk)::timestamp
								else
									concat(a.tanggal::date,' ',a.masuk)::timestamp
								end as masuk,
								a.kd_ket,
								b.jam_kerja,
								case when b.jam_msk::time > b.ist_mulai::time then
									concat((a.tanggal + interval '1 day')::date,' ',b.ist_mulai)::timestamp
								else
									concat(a.tanggal::date,' ',b.ist_mulai)::timestamp
								end as ist_mulai,
								case when b.jam_msk::time > b.ist_selesai::time then
									concat((a.tanggal + interval '1 day')::date,' ',b.ist_selesai)::timestamp
								else
									concat(a.tanggal::date,' ',b.ist_selesai)::timestamp
								end as ist_selesai,
								case when b.jam_msk::time > b.break_mulai::time then
									concat((a.tanggal + interval '1 day')::date,' ',b.break_mulai)::timestamp
								else
									concat(a.tanggal::date,' ',b.break_mulai)::timestamp
								end as break_mulai,
								case when b.jam_msk::time > b.break_selesai::time then
									concat((a.tanggal + interval '1 day')::date,' ',b.break_selesai)::timestamp
								else
									concat(a.tanggal::date,' ',b.break_selesai)::timestamp
								end as break_selesai
							FROM \"Presensi\".TDataTIM a INNER JOIN
							\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
							WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir')
							ORDER BY tanggal";
					$result2 = $this->personalia->query($sql)->result_array();
					if(!empty($result1)){
						$nilai = $result1['0']['jml'];
					}else{
						$nilai = 0;
					}
					$simpan_tgl = "";
					$lanjut = false;

					foreach ($result2 as $tik) {
						if ($tik['tanggal'] !== $simpan_tgl) {
							$lanjut = false;
						}
						$keluar = strtotime($tik['keluar']);
						$masuk = strtotime($tik['masuk']);
						$ist_mulai = strtotime($tik['ist_mulai']);
						$ist_selesai = strtotime($tik['ist_selesai']);
						$break_mulai = strtotime($tik['break_mulai']);
						$break_selesai = strtotime($tik['break_selesai']);
						if ($ist_mulai < $break_mulai) {
							$simpan_ist_mulai = $ist_mulai;
							$simpan_ist_selesai = $ist_selesai;
							$ist_mulai = $break_mulai;
							$ist_selesai = $break_selesai;
							$break_mulai = $simpan_ist_mulai;
							$break_selesai = $simpan_ist_selesai;
						}

						$ijin = $this->cek_ijin_keluar($keluar,$masuk,$break_mulai,$break_selesai,$ist_mulai,$ist_selesai);
						if ($ijin <= 0) {
							$nilai = $nilai;
						}else if($ijin > 0 && $ijin <= 60){
							$nilai = $nilai;
						}else{
							if($lanjut == false){
								$nilai -= 1;
							}
						}

						$simpan_tgl = $tik['tanggal'];
					}

				}
			}else{
				$awal = $tanggal;
				$akhir = $tanggal;

				$sql = "select count(tdp.tanggal) as jml
						FROM \"Presensi\".TDataPresensi tdp INNER JOIN
						(SELECT DISTINCT * from \"Presensi\".TShiftPekerja) tsp ON tdp.tanggal = tsp.tanggal AND tdp.noind = tsp.noind
						WHERE tdp.tanggal >= '$awal' AND tdp.tanggal <= '$akhir'
						AND (tdp.kd_ket = 'PKJ' or (tdp.kd_ket = 'PDL') or (tdp.kd_ket = 'PDB') or tdp.kd_ket = 'PLB' or tdp.kd_ket = 'PID' or tdp.kd_ket = 'PRM')
						AND tdp.noind = '$noind'";
				$result1 = $this->personalia->query($sql)->result_array();

				$sql = "select a.tanggal, a.noind,
								concat(a.tanggal::date,' ',a.keluar)::timestamp as keluar,
								case when a.masuk::time < a.keluar::time then
									concat((a.tanggal + interval '1 day')::date,' ',a.masuk)::timestamp
								else
									concat(a.tanggal::date,' ',a.masuk)::timestamp
								end as masuk,
								a.kd_ket,
								b.jam_kerja,
								case when b.jam_msk::time > b.ist_mulai::time then
									concat((a.tanggal + interval '1 day')::date,' ',b.ist_mulai)::timestamp
								else
									concat(a.tanggal::date,' ',b.ist_mulai)::timestamp
								end as ist_mulai,
								case when b.jam_msk::time > b.ist_selesai::time then
									concat((a.tanggal + interval '1 day')::date,' ',b.ist_selesai)::timestamp
								else
									concat(a.tanggal::date,' ',b.ist_selesai)::timestamp
								end as ist_selesai,
								case when b.jam_msk::time > b.break_mulai::time then
									concat((a.tanggal + interval '1 day')::date,' ',b.break_mulai)::timestamp
								else
									concat(a.tanggal::date,' ',b.break_mulai)::timestamp
								end as break_mulai,
								case when b.jam_msk::time > b.break_selesai::time then
									concat((a.tanggal + interval '1 day')::date,' ',b.break_selesai)::timestamp
								else
									concat(a.tanggal::date,' ',b.break_selesai)::timestamp
								end as break_selesai
						FROM \"Presensi\".TDataPresensi a INNER JOIN
						\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
						WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'PSP') AND (a.noind = '$noind') AND
						(a.tanggal <= '$akhir')
						Union
						SELECT a.tanggal, a.noind,
							concat(a.tanggal::date,' ',a.keluar)::timestamp as keluar,
							case when a.masuk::time < a.keluar::time then
								concat((a.tanggal + interval '1 day')::date,' ',a.masuk)::timestamp
							else
								concat(a.tanggal::date,' ',a.masuk)::timestamp
							end as masuk,
							a.kd_ket,
							b.jam_kerja,
							case when b.jam_msk::time > b.ist_mulai::time then
								concat((a.tanggal + interval '1 day')::date,' ',b.ist_mulai)::timestamp
							else
								concat(a.tanggal::date,' ',b.ist_mulai)::timestamp
							end as ist_mulai,
							case when b.jam_msk::time > b.ist_selesai::time then
								concat((a.tanggal + interval '1 day')::date,' ',b.ist_selesai)::timestamp
							else
								concat(a.tanggal::date,' ',b.ist_selesai)::timestamp
							end as ist_selesai,
							case when b.jam_msk::time > b.break_mulai::time then
								concat((a.tanggal + interval '1 day')::date,' ',b.break_mulai)::timestamp
							else
								concat(a.tanggal::date,' ',b.break_mulai)::timestamp
							end as break_mulai,
							case when b.jam_msk::time > b.break_selesai::time then
								concat((a.tanggal + interval '1 day')::date,' ',b.break_selesai)::timestamp
							else
								concat(a.tanggal::date,' ',b.break_selesai)::timestamp
							end as break_selesai
						FROM \"Presensi\".TDataTIM a INNER JOIN
						\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
						WHERE (a.tanggal >= '$awal') AND (a.kd_ket = 'TIK') AND (a.noind = '$noind') AND (a.tanggal <= '$akhir')
						ORDER BY tanggal";
				$result2 = $this->personalia->query($sql)->result_array();
				if(!empty($result1)){
					$nilai = $result1['0']['jml'];
				}else{
					$nilai = 0;
				}
				$simpan_tgl = "";
				$lanjut = false;

				foreach ($result2 as $tik) {
					if ($tik['tanggal'] !== $simpan_tgl) {
						$lanjut = false;
					}
					$keluar = strtotime($tik['keluar']);
					$masuk = strtotime($tik['masuk']);
					$ist_mulai = strtotime($tik['ist_mulai']);
					$ist_selesai = strtotime($tik['ist_selesai']);
					$break_mulai = strtotime($tik['break_mulai']);
					$break_selesai = strtotime($tik['break_selesai']);
					if ($ist_mulai < $break_mulai) {
						$simpan_ist_mulai = $ist_mulai;
						$simpan_ist_selesai = $ist_selesai;
						$ist_mulai = $break_mulai;
						$ist_selesai = $break_selesai;
						$break_mulai = $simpan_ist_mulai;
						$break_selesai = $simpan_ist_selesai;
					}

					$ijin = $this->cek_ijin_keluar($keluar,$masuk,$break_mulai,$break_selesai,$ist_mulai,$ist_selesai);
					if ($ijin <= 0) {
						$nilai = $nilai;
					}else if($ijin > 0 && $ijin <= 60){
						$nilai = $nilai;
					}else{
						if($lanjut == false){
							$nilai -= 1;
						}
					}

					$simpan_tgl = $tik['tanggal'];
				}
			}

			return $nilai;
		}else{
			return 0;
		}
	}

	function hitungIf($noind,$tanggal){
		$sql = "select count(a.tanggal) as jml 
				FROM \"Presensi\".TDataPresensi a INNER JOIN 
				\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal 
				AND a.noind = b.noind 
				WHERE a.tanggal = '$tanggal'
				AND (a.kd_ket = 'PKJ' or (a.kd_ket = 'PDL') or (a.kd_ket = 'PDB') or a.kd_ket = 'PLB' or a.kd_ket = 'PID' or a.kd_ket = 'PRM') 
				AND a.noind = '$noind'";
		$result1 = $this->personalia->query($sql)->result_array();

		$sql = "SELECT a.tanggal, a.noind,
							concat(a.tanggal::date,' ',a.keluar)::timestamp as keluar,
							case when a.masuk::time < a.keluar::time then
								concat((a.tanggal + interval '1 day')::date,' ',a.masuk)::timestamp
							else
								concat(a.tanggal::date,' ',a.masuk)::timestamp
							end as masuk,
							a.kd_ket,
							b.jam_kerja,
							case when b.jam_msk::time > b.ist_mulai::time then
								concat((a.tanggal + interval '1 day')::date,' ',b.ist_mulai)::timestamp
							else
								concat(a.tanggal::date,' ',b.ist_mulai)::timestamp
							end as ist_mulai,
							case when b.jam_msk::time > b.ist_selesai::time then
								concat((a.tanggal + interval '1 day')::date,' ',b.ist_selesai)::timestamp
							else
								concat(a.tanggal::date,' ',b.ist_selesai)::timestamp
							end as ist_selesai,
							case when b.jam_msk::time > b.break_mulai::time then
								concat((a.tanggal + interval '1 day')::date,' ',b.break_mulai)::timestamp
							else
								concat(a.tanggal::date,' ',b.break_mulai)::timestamp
							end as break_mulai,
							case when b.jam_msk::time > b.break_selesai::time then
								concat((a.tanggal + interval '1 day')::date,' ',b.break_selesai)::timestamp
							else
								concat(a.tanggal::date,' ',b.break_selesai)::timestamp
							end as break_selesai
					FROM \"Presensi\".TDataTIM a INNER JOIN
					\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
					WHERE (a.tanggal = '$tanggal') AND (a.kd_ket = 'TIK') AND (a.noind = '$noind')
					UNION
					SELECT a.tanggal, a.noind,
									concat(a.tanggal::date,' ',a.keluar)::timestamp as keluar,
									case when a.masuk::time < a.keluar::time then
										concat((a.tanggal + interval '1 day')::date,' ',a.masuk)::timestamp
									else
										concat(a.tanggal::date,' ',a.masuk)::timestamp
									end as masuk,
									a.kd_ket,
									b.jam_kerja,
									case when b.jam_msk::time > b.ist_mulai::time then
										concat((a.tanggal + interval '1 day')::date,' ',b.ist_mulai)::timestamp
									else
										concat(a.tanggal::date,' ',b.ist_mulai)::timestamp
									end as ist_mulai,
									case when b.jam_msk::time > b.ist_selesai::time then
										concat((a.tanggal + interval '1 day')::date,' ',b.ist_selesai)::timestamp
									else
										concat(a.tanggal::date,' ',b.ist_selesai)::timestamp
									end as ist_selesai,
									case when b.jam_msk::time > b.break_mulai::time then
										concat((a.tanggal + interval '1 day')::date,' ',b.break_mulai)::timestamp
									else
										concat(a.tanggal::date,' ',b.break_mulai)::timestamp
									end as break_mulai,
									case when b.jam_msk::time > b.break_selesai::time then
										concat((a.tanggal + interval '1 day')::date,' ',b.break_selesai)::timestamp
									else
										concat(a.tanggal::date,' ',b.break_selesai)::timestamp
									end as break_selesai
							FROM \"Presensi\".TDataPresensi a INNER JOIN
							\"Presensi\".TShiftPekerja b ON a.tanggal = b.tanggal AND a.noind = b.noind
							WHERE (a.kd_ket = 'PSP') AND (a.noind = '$noind') AND (a.tanggal = '$tanggal')
					ORDER BY tanggal";
		$result2 = $this->personalia->query($sql)->result_array();
		if(!empty($result1)){
			$nilai = $result1['0']['jml'];
		}else{
			$nilai = 0;
		}
			
		$simpan_tgl = "";
		$lanjut = false;
		foreach ($result2 as $tik) {
			if ($tik['tanggal'] !== $simpan_tgl) {
				$lanjut = false;
			}
			$keluar = strtotime($tik['keluar']);
			$masuk = strtotime($tik['masuk']);
			$ist_mulai = strtotime($tik['ist_mulai']);
			$ist_selesai = strtotime($tik['ist_selesai']);
			$break_mulai = strtotime($tik['break_mulai']);
			$break_selesai = strtotime($tik['break_selesai']);
			if ($ist_mulai < $break_mulai) {
				$simpan_ist_mulai = $ist_mulai;
				$simpan_ist_selesai = $ist_selesai;
				$ist_mulai = $break_mulai;
				$ist_selesai = $break_selesai;
				$break_mulai = $simpan_ist_mulai;
				$break_selesai = $simpan_ist_selesai;
			}

			$ijin = $this->cek_ijin_keluar($keluar,$masuk,$break_mulai,$break_selesai,$ist_mulai,$ist_selesai) / ($tik['jam_kerja'] * 60);
			$ijin = number_format($ijin, 2);
			// echo "ijine:".$ijin."<br>";
			if ($ijin <= 0) {
				$nilai = $nilai;
			}else if($ijin > 0 && $ijin <= 30){
				$cek_denda = $this->cek_bebas_denda_if($keluar,$masuk,$ist_mulai,$ist_selesai);
				if ($cek_denda == false) {
					if($lanjut == false) {
						$nilai -= $ijin;
					}
				}
			}else{
				if($lanjut == false){
					$nilai -= $ijin;
				}
			}

			$simpan_tgl = $tik['tanggal'];
		}

		return $nilai;
	}

}
?>

