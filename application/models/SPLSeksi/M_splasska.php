<?php
class M_splasska extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->spl = $this->load->database('spl_db', true);
		$this->prs = $this->load->database('personalia', true);
	}

	public function show_spl($dari, $sampai, $status, $lokasi, $noind, $akses_sie, $kodesie){
		$x = 0;
		$akses = '';

		foreach ($akses_sie as $as) {
			if ($x == 0) {
				$akses = "b.kodesie like '$as%'";
			} else {
				$akses .= " or b.kodesie like '$as%'";
			}
			$x++;
		}

		if(!empty($dari) || !empty($sampai)){
			$periode = "and a.tgl_lembur between '$dari' AND '$sampai'";
		} else {
			$periode = "";
		}

		$sql = "select a.*, b.nama, d.kodesie, d.seksi, d.unit, d.dept, e.nama_lembur, c.Deskripsi
			from splseksi.tspl a
			inner join hrd_khs.tpribadi b ON a.noind = b.noind 
			inner join splseksi.tjenislembur e ON a.kd_lembur = e.kd_lembur 
			inner join splseksi.tstatus_spl c ON a.status = c.id_status 
			inner join hrd_khs.tseksi d ON b.kodesie = d.kodesie 
			where a.status like '%$status%' $periode
				and a.perbantuan='N' and ($akses) and d.kodesie like '$kodesie%' 
				and b.noind like '$noind%' and b.lokasi_kerja like '%$lokasi%'
			order by a.tgl_lembur, d.seksi, a.kd_lembur, b.nama, a.jam_mulai_lembur, a.Jam_Akhir_Lembur";

		$query = $this->spl->query($sql);
		return $query->result_array();
	}

	public function show_finger_user($fill)
	{
		$this->spl->where($fill);
		$query = $this->spl->get('splseksi.tfinger_php');
		return $query->row();
	}

	public function show_finger_activation($filter)
	{
		$this->spl->where($filter);
		$query = $this->spl->get('splseksi.tcode_fingerprint');
		return $query->row();
	}

	public function cek_spl($spl_id)
	{
		$sql = "select 
					round(
						(
							timestampdiff(
								second,
								convert(concat(Tgl_Lembur,' ',Jam_Mulai_Lembur), DATETIME),
								(
									case when Jam_Mulai_Lembur > Jam_Akhir_Lembur then 
										convert(concat(date_add(Tgl_Lembur, interval 1 day),' ',Jam_Akhir_Lembur), DATETIME)
									else 
										convert(concat(Tgl_Lembur,' ',Jam_Akhir_Lembur), DATETIME)
									end
								)
							)
						)/3600
					,2) -
					(
						case when Break = 'Y' then 
							0.25
						else 
							0
						end 
					) -
					(
						case when Istirahat = 'Y' then 
							0.75
						else 
							0
						end 
					) as jml_lembur , 
					Kd_Lembur as kode,
					Tgl_Lembur as tanggal,
					Noind as noind,
					Jam_Mulai_Lembur as awal,
					Jam_Akhir_Lembur as akhir
				from splseksi.tspl 
				where ID_SPL = '$spl_id' 
				order by Tgl_Lembur desc";
		$query = $this->spl->query($sql);
		return $query->row();
	}

	public function get_wkt_pkj($noind, $tanggal)
	{
		$sql = "select jam_kerja from \"Presensi\".tshiftpekerja 
				where tanggal = '$tanggal' and noind = '$noind'";
		return $this->prs->query($sql)->row()->jam_kerja;
	}

	public function cek_hl($noind, $tanggal)
	{
		$sql = "select * from \"Presensi\".tdatapresensi 
				where noind = '$noind' and tanggal = '$tanggal' and kd_ket = 'HL'";
		return $this->prs->query($sql)->num_rows();
	}

	public function insert_tdatapresensi_hl($awal, $akhir, $noind, $tanggal, $lembur)
	{
		$sql = "insert into \"Presensi\".tdatapresensi
				(tanggal,noind,kodesie,masuk,keluar,kd_ket,total_lembur,ket,user_,noind_baru,create_timestamp)
				select '$tanggal',noind,kodesie,'masuk','keluar','HL','biasa','ERSPL',noind_baru,now()
				from hrd_khs.tpribadi 
				where noind = '$noind'";
		$this->prs->query($sql);
	}

	public function cek_tdatapresensi($noind, $tanggal)
	{
		$sql = "select * from \"Presensi\".tdatapresensi 
				where noind = '$noind' and tanggal = '$tanggal' and kd_ket in ('PKJ','PDL')";
		return $this->prs->query($sql)->row();
	}

	public function update_tdatapresensi($kd_ket, $noind, $tanggal, $lembur)
	{
		$sql = "update \"Presensi\".tdatapresensi 
				set kd_ket = '$kd_ket',
				total_lembur = '$lembur',
				last_action = 'UPDATE',
				last_action_date = now()
				where noind = '$noind' and tanggal = '$tanggal'";
		$this->prs->query($sql);
	}

	public function recheck_spl($spl_id)
	{
		$sql = "select * from splseksi.tspl where ID_SPL ='$spl_id'";
		$result = $this->spl->query($sql)->row();
		$sql = "select * from \"Presensi\".tdatapresensi where noind = '" . $result->Noind . "' and tanggal = '" . $result->Tgl_Lembur . "'";
		return $this->prs->query($sql)->num_rows();
	}

	public function get_tdatapresensi($noind, $tanggal)
	{
		$sql = "select * from \"Presensi\".tdatapresensi where noind = '$noind' and tanggal = '$tanggal'";
		return $this->prs->query($sql)->row();
	}
}
