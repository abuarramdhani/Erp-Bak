<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_index extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia',TRUE);    
    }

    public function tseksi( $keyword = FALSE )
	{
		$parameter_keyword 	=	"";
		if($keyword !== FALSE)
		{
			$parameter_keyword 		= "	and 	(
			seksi like '%$keyword%'
			or kodesie like '%$keyword%'
			)";
		}

		$tseksi 		= "	SELECT distinct rtrim(seksi) as daftar_tseksi, SUBSTRING(kodesie, 0, 8) kodesie
							FROM hrd_khs.tseksi where rtrim(seksi) != '-' 
							$parameter_keyword 
							order by rtrim(seksi);";
		// echo "<pre>"; print_r($tseksi); exit;
		$query 			=	$this->personalia->query($tseksi);
		return $query->result_array();
	}
	public function ambilDaftarnoind($KodeSeksi, $PeriodeShift)
 	{
 		$ambilDaftarnoind 		= "SELECT Distinct rtrim(noind) noind
 		FROM \"Presensi\".tshiftpekerja
 		WHERE TO_CHAR(tanggal, 'yyyy-mm') LIKE '%$PeriodeShift%' and kodesie like '$KodeSeksi%'
 		ORDER BY rtrim(noind)";
		// echo "<pre>"; print_r($ambilDaftarPolaShift); exit; 

		$query 	= $this->personalia->query($ambilDaftarnoind);
		return $query->result_array();
 	}

	public function ambilDaftarPolaShift($KodeSeksi, $PeriodeShift, $noind)
 	{
 		$ambilDaftarPolaShift 		= "SELECT tsp.tanggal, tsp.noind, tsp.kd_shift, ts.inisial
 		FROM \"Presensi\".tshiftpekerja as tsp
 		left join \"Presensi\".tshift ts on ts.kd_shift = tsp.kd_shift
 		WHERE TO_CHAR(tanggal, 'yyyy-mm') LIKE '%$PeriodeShift%' and kodesie like '$KodeSeksi%' and noind = rtrim('$noind')
 		ORDER BY tanggal";
		// echo "<pre>"; print_r($ambilDaftarPolaShift); exit; 

		$query 	= $this->personalia->query($ambilDaftarPolaShift);
		return $query->result_array();
 	}

 	public function detail_shift($hari, $inisial)
 	{
 		$hari = ucfirst($hari);
 		$inisial = strtoupper($inisial);
 		$sql = "select tj.* from \"Presensi\".tshift ts
				left join \"Presensi\".tjamshift tj on tj.kd_shift = ts.kd_shift
				where ts.inisial = '$inisial' and tj.hari = '$hari'";
				// echo json_encode($sql);
		$query = $this->personalia->query($sql);
		return $query->result_array();
 	}

 	public function getKS($noind, $col = false)
 	{
 		$sql = "select * from hrd_khs.tpribadi where noind = '$noind'";
		
		$query = $this->personalia->query($sql);
		if ($col == false) {
			return $query->row()->kodesie;
		}else{
			return $query->row()->$col;
		}
 	}

 	public function insert_shift($data)
 	{
 		$insert = $this->db->insert('ips.t_shift_pekerja', $data);

 		return true;
 	}

 	public function getAtasan($noind)
 	{
 		$sql = "select distinct
					tp.noind,
					rtrim(tp.nama) nama,
					rtrim(ts.seksi) seksi,
					coalesce(
						(select array_agg(noind||' - '||rtrim(nama) order by kd_jabatan,noind) from hrd_khs.tpribadi where keluar = '0' and kd_jabatan in ('13') and substring(kodesie, 1, 7) = substring(tp.kodesie, 1, 7) and kd_jabatan<tp.kd_jabatan),
						(select array_agg(noind||' - '||rtrim(nama) order by kd_jabatan,noind) from hrd_khs.tpribadi where keluar = '0' and kd_jabatan in ('11','12') and substring(kodesie, 1, 7) = substring(tp.kodesie, 1, 7) and kd_jabatan<tp.kd_jabatan),
						(select array_agg(noind||' - '||rtrim(nama) order by kd_jabatan,noind) from hrd_khs.tpribadi where keluar = '0' and kd_jabatan in ('10') and substring(kodesie, 1, 7) = substring(tp.kodesie, 1, 7) and kd_jabatan<tp.kd_jabatan),
						(select array_agg(noind||' - '||rtrim(nama) order by kd_jabatan,noind) from hrd_khs.tpribadi where keluar = '0' and kd_jabatan in ('09') and substring(kodesie, 1, 5) = substring(tp.kodesie, 1, 5) and kd_jabatan<tp.kd_jabatan),
						(select array_agg(noind||' - '||rtrim(nama) order by kd_jabatan,noind) from hrd_khs.tpribadi where keluar = '0' and kd_jabatan in ('08') and substring(kodesie, 1, 5) = substring(tp.kodesie, 1, 5) and kd_jabatan<tp.kd_jabatan),
						(select array_agg(noind||' - '||rtrim(nama) order by kd_jabatan,noind) from hrd_khs.tpribadi where keluar = '0' and kd_jabatan in ('07') and substring(kodesie, 1, 3) = substring(tp.kodesie, 1, 3) and kd_jabatan<tp.kd_jabatan),
						(select array_agg(noind||' - '||rtrim(nama) order by kd_jabatan,noind) from hrd_khs.tpribadi where keluar = '0' and kd_jabatan in ('06') and substring(kodesie, 1, 3) = substring(tp.kodesie, 1, 3) and kd_jabatan<tp.kd_jabatan),
						(select array_agg(noind||' - '||rtrim(nama) order by kd_jabatan,noind) from hrd_khs.tpribadi where keluar = '0' and kd_jabatan in ('05') and substring(kodesie, 1, 3) = substring(tp.kodesie, 1, 3) and kd_jabatan<tp.kd_jabatan),
						(select array_agg(noind||' - '||rtrim(nama) order by kd_jabatan,noind) from hrd_khs.tpribadi where keluar = '0' and kd_jabatan in ('04') and substring(kodesie, 1, 1) = substring(tp.kodesie, 1, 1) and kd_jabatan<tp.kd_jabatan),
						(select array_agg(noind||' - '||rtrim(nama) order by kd_jabatan,noind) from hrd_khs.tpribadi where keluar = '0' and kd_jabatan in ('03') and substring(kodesie, 1, 1) = substring(tp.kodesie, 1, 1) and kd_jabatan<tp.kd_jabatan),
						(select array_agg(noind||' - '||rtrim(nama) order by kd_jabatan,noind) from hrd_khs.tpribadi where keluar = '0' and kd_jabatan in ('02') and substring(kodesie, 1, 1) = substring(tp.kodesie, 1, 1) and kd_jabatan<tp.kd_jabatan)
					) atasan_langsung
				from
					hrd_khs.tpribadi tp left join hrd_khs.tseksi ts on substring(tp.kodesie,1,7) = substring(ts.kodesie,1,7)
				where 
					tp.keluar = '0'
					and noind = '$noind'
				group by
					tp.noind,
					tp.nama,
					tp.kodesie,
					ts.seksi,
					tp.kd_jabatan
				order by 2;";

 		$query = $this->personalia->query($sql);
		return $query->result_array();
 	}

 	public function listImpShift($kodesie, $noind)
 	{
 		$ks = substr($kodesie, 0,7);
 		$sql = "select
					substring(kodesie, 0, 8) kodesie,
					substring(tanggal::text, 0, 8) periode,
					tsp.tgl_import,
					count(noind) jum,
					rtrim(es.section_name) seksi,
					tsp.atasan,
					tsp.alasan,
					ea.employee_name,
					tsp.tgl_approve
				from
					ips.t_shift_pekerja tsp
				left join er.er_section es on
					es.section_code = tsp.kodesie
				left join er.er_employee_all ea on
					ea.employee_code = tsp.atasan
				where
					substring(kodesie, 0, 8) = '$ks'
					or tsp.atasan = '$noind'
					or tsp.import_by = '$noind'
				group by
					substring(kodesie, 0, 8),
					substring(tanggal::text, 0, 8),
					tgl_import,
					es.section_name,
					tsp.atasan,
					tsp.alasan,
					ea.employee_name,
					tsp.tgl_approve
				order by
					tsp.tgl_import desc";
		$query = $this->db->query($sql);
		return $query->result_array();
 	}

 	public function getPkjShift($list, $pr)
 	{
 		$sql = "SELECT distinct(noind) FROM \"Presensi\".tshiftpekerja
				where noind in ('$list') and tanggal::text like '$pr%'";
		$query = $this->personalia->query($sql);
		return $query->result_array();
 	}

 	public function listImpShiftUniq($kodesie, $pr, $tgl_imp)
 	{
 		$ks = substr($kodesie, 0,7);
 		$sql = "select
					alasan,
					tgl_approve,
					tgl_import
				from
					ips.t_shift_pekerja tsp
				where
					substring(kodesie, 0, 8) = '$ks'
					and tsp.tgl_import = '$tgl_imp'
					and tanggal::text like '$pr%'
				group by
					alasan,
					tgl_approve,
					tgl_import";
		$query = $this->db->query($sql);
		return $query->result_array();
 	}
}