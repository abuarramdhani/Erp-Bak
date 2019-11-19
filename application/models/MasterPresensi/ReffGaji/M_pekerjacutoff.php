<?php 
defined('BASEPATH') or exit('No Direct Script Access ALlowed');
/**
 *
 */
class M_pekerjacutoff extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->personalia = $this->load->database('personalia', TRUE);
	}

	public function getPeriodeCutoff(){
		$sql = "select tanggal_proses,count(*) as jumlah 
				from \"Presensi\".tcutoff_custom_terproses 
				where terakhir = '1'
				group by tanggal_proses
				order by tanggal_proses desc";
		return $this->personalia->query($sql)->result_array();
	}

	public function getCutoffDetail($periode){
		$sql = "select a.noind,
					b.nama,
					(select concat(seksi,' / ',unit) from hrd_khs.tseksi c  where b.kodesie = c.kodesie) as seksi
				from \"Presensi\".tcutoff_custom_terproses a
				left join hrd_khs.tpribadi b
				on a.noind = b.noind
				where a.terakhir = '1'
				and a.tanggal_proses = '$periode'
				order by a.noind";
		return $this->personalia->query($sql)->result_array();
	}

	public function getPekerja($key){
		$sql = "select noind,nama from hrd_khs.tpribadi where upper(noind) like upper('%$key%') or upper(nama) like upper('%$key%')";
		return $this->personalia->query($sql)->result_array();
	}

	public function getCutoffDetailPekerja($noind){
		$sql = "select a.noind,
					b.nama,
					(select concat(seksi,' / ',unit) from hrd_khs.tseksi c  where b.kodesie = c.kodesie) as seksi,
					case when to_char(a.tanggal_proses,'mm') = '01' then 
						concat('Januari ',to_char(a.tanggal_proses,'yyyy'))
					when to_char(a.tanggal_proses,'mm') = '02' then 
						concat('Februari ',to_char(a.tanggal_proses,'yyyy'))
					when to_char(a.tanggal_proses,'mm') = '03' then 
						concat('Maret ',to_char(a.tanggal_proses,'yyyy'))
					when to_char(a.tanggal_proses,'mm') = '04' then 
						concat('April ',to_char(a.tanggal_proses,'yyyy'))
					when to_char(a.tanggal_proses,'mm') = '05' then 
						concat('Mei ',to_char(a.tanggal_proses,'yyyy'))
					when to_char(a.tanggal_proses,'mm') = '06' then 
						concat('Juni ',to_char(a.tanggal_proses,'yyyy'))
					when to_char(a.tanggal_proses,'mm') = '07' then 
						concat('Juli ',to_char(a.tanggal_proses,'yyyy'))
					when to_char(a.tanggal_proses,'mm') = '08' then 
						concat('Agustus ',to_char(a.tanggal_proses,'yyyy'))
					when to_char(a.tanggal_proses,'mm') = '09' then 
						concat('September ',to_char(a.tanggal_proses,'yyyy'))
					when to_char(a.tanggal_proses,'mm') = '10' then 
						concat('Oktober ',to_char(a.tanggal_proses,'yyyy'))
					when to_char(a.tanggal_proses,'mm') = '11' then 
						concat('November ',to_char(a.tanggal_proses,'yyyy'))
					when to_char(a.tanggal_proses,'mm') = '12' then 
						concat('Desember ',to_char(a.tanggal_proses,'yyyy'))
					end 
					as periode,
					tanggal_proses
				from \"Presensi\".tcutoff_custom_terproses a
				left join hrd_khs.tpribadi b
				on a.noind = b.noind
				where a.terakhir = '1'
				and a.noind = '$noind'
				order by a.tanggal_proses";
		return $this->personalia->query($sql)->result_array();
	}

	public function getDetailPekerja($noind){
		$sql = "select b.noind,
					b.nama,
					(select concat(seksi,' / ',unit) from hrd_khs.tseksi c  where b.kodesie = c.kodesie) as seksi
				from hrd_khs.tpribadi b
				where b.noind = '$noind'";
		return $this->personalia->query($sql)->result_array();
	}

}
?>