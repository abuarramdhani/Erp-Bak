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
			seksi like '$keyword%'
			or kodesie like '%$keyword%'
			)";
		}

		$tseksi 		= "	SELECT distinct seksi as daftar_tseksi, SUBSTRING(kodesie, 0, 7) kodesie
							FROM hrd_khs.tseksi where seksi not like '%-%' 
							$parameter_keyword 
							order by seksi;";
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
} ?>