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
}
?>