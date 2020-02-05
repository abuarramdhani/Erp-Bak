<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_index extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia',TRUE);
    }

   public function GetIzin($no_induk)
	{
		$sql = "SELECT a.*,
                (case when a.jenis_izin = '1' then 'DINAS PUSAT' when a.jenis_izin = '2' then 'DINAS TUKSONO' else 'DINAS MLATI' end) as to_dinas,
                (select string_agg(concat(noind,' - ',trim(nama)),'<br>') from hrd_khs.tpribadi b where position(b.noind in a.noind)>0) as pekerja
                FROM \"Surat\".tperizinan a WHERE a.atasan_aproval LIKE '%$no_induk%'
                order by a.status, a.izin_id DESC";

		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	 public function IzinApprove($no_induk)
	{
		$sql = "SELECT a.*,
                (select string_agg(concat(noind,' - ',trim(nama)),'<br>') from hrd_khs.tpribadi b where position(b.noind in a.noind)>0) as pekerja
                FROM \"Surat\".tperizinan a WHERE a.atasan_aproval LIKE '%$no_induk%' and status = '1'
                order by a.created_date DESC";

		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	 public function IzinUnApprove($no_induk)
	{
        $today = date('Y-m-d');
		$sql = "SELECT a.*,
                (select string_agg(concat(noind,' - ',trim(nama)),'<br>') from hrd_khs.tpribadi b where position(b.noind in a.noind)>0) as pekerja
                FROM \"Surat\".tperizinan a WHERE a.atasan_aproval LIKE '%$no_induk%' and status = '0' AND created_date::date = '$today'
                order by a.created_date DESC";

		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	 public function IzinReject($no_induk)
	{
        $today = date('Y-m-d');
		$sql = "SELECT a.*,
                (select string_agg(concat(noind,' - ',trim(nama)),'<br>') from hrd_khs.tpribadi b where position(b.noind in a.noind)>0) as pekerja
                FROM \"Surat\".tperizinan a WHERE a.atasan_aproval LIKE '%$no_induk%' and status IN ('2', '5') OR (status = '0' AND created_date::date < '$today')
                order by a.created_date DESC";

		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function update($status, $idizin)
    {
        $sql = "update \"Surat\".tperizinan
                set status ='$status'
                WHERE izin_id ='$idizin'";
        $query = $this->personalia->query($sql);
    }

	public function updatePekerja($status, $idizin)
    {
        $sql = "update \"Surat\".tpekerja_izin
                set status_jalan ='$status'
                WHERE izin_id ='$idizin'";
        $query = $this->personalia->query($sql);
    }

    public function update_tperizinan($noind, $status, $id, $imPlace)
    {
        $sql = "update \"Surat\".tperizinan
        set status ='$status', noind = '$noind', tujuan = '$imPlace'
        WHERE izin_id ='$id'";
        $query = $this->personalia->query($sql);
    }

	public function updatePekerjaBerangkat($noind, $status, $idizin)
    {
        $sql = "UPDATE \"Surat\".tpekerja_izin
                set status_jalan ='$status'
                WHERE izin_id ='$idizin' AND noind = '$noind'";
        $query = $this->personalia->query($sql);
    }

    public function taktual_izin($pekerja)
    {
        $this->personalia->insert('Surat.taktual_izin',$pekerja);
        return;
    }

    public function cekIzin($idizin)
    {
        $sql = "SELECT * FROM \"Surat\".tperizinan WHERE izin_id::text = '$idizin'";

        $query = $this->personalia->query($sql);
        return $query->result_array();
    }

     public function deletemakan($idizin)
    {
	    $sql = "DELETE from \"Surat\".tpekerja_izin tpi
	                where tpi.izin_id='$idizin'";
	    $this->personalia->query($sql);
	    return;
    }

    public function getTujuanMakan($idizin)
    {
        $sql = "SELECT * FROM \"Surat\".tpekerja_izin WHERE izin_id = '$idizin'";
        return $this->personalia->query($sql)->result_array();
    }

    public function getTujuan($id, $noind, $param)
    {
        $new = '';
        if ($param == true) {
            $new = "AND noind IN ('$noind')";
        }else {
            $new = "AND noind = '$noind'";
        }
        $sql = "SELECT trim(tujuan) as tujuan FROM \"Surat\".tpekerja_izin WHERE izin_id = '$id' $new";
        return $this->personalia->query($sql)->result_array();
    }

    public function getPekerjaEdit($idizin)
    {
        $sql = "SELECT ti.*, (SELECT trim(nama) FROM hrd_khs.tpribadi where noind = ti.noind and keluar = '0') as nama, tper.keterangan, cast(tper.created_date as date), tper.berangkat
                FROM \"Surat\".tpekerja_izin ti
                LEFT JOIN \"Surat\".tperizinan tper ON tper.izin_id = ti.izin_id::int
                WHERE ti.izin_id = '$idizin'";
      return $this->personalia->query($sql)->result_array();
    }

    public function getDataPekerja($a, $b)
    {
        $sql = "SELECT * FROM \"Surat\".tpekerja_izin WHERE izin_id = '$b' AND noind = '$a'";
        return $this->personalia->query($sql)->result_array();
    }

    public function pekerja($noind)
    {
        $sql = "SELECT noind, trim(nama) as nama from hrd_khs.tpribadi where noind in ('$noind') ";
        return $this->personalia->query($sql)->result_array();
    }

    public function getImel($key)
    {
        $sql = "SELECT email_internal from hrd_khs.tpribadi where noind in ('$key')";
        return $this->personalia->query($sql)->row()->email_internal;
    }

} ?>
