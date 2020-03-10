<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_tukar extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia',TRUE);    
    }
    
    public function getDaftar($term)
    {
    	$sql = "Select noind, rtrim(nama) nama from hrd_khs.tpribadi where keluar = '0'
    			and (noind like '%$term%' or nama like '%$term%')";
    	$query = $this->personalia->query($sql);
    	return $query->result_array();
    }

    public function getDetail($noind, $tanggal)
    {
    	$tanggal = date('Y-m-d', strtotime($tanggal));
    	$sql = "select
    				tp.noind,
					rtrim(tp.nama) nama,
					rtrim(ts.shift) shift,
					rtrim(ts.kd_shift) kd_shift,
					substring(tsh.tanggal::text,0,11) tanggal
				from
					hrd_khs.tpribadi tp
				left join \"Presensi\".tshiftpekerja tsh on
					tp.noind = tsh.noind
				left join \"Presensi\".tshift ts on
					ts.kd_shift = tsh.kd_shift
				where
					tp.noind = '$noind'
					and tsh.tanggal = '$tanggal'";
		$query = $this->personalia->query($sql);
    	return $query->result_array();
    }

    public function getDaftarShift($term, $kd = 'false')
    {
    	$sql = "select rtrim(kd_shift) kd_shift, rtrim(shift) shiftnya, rtrim(inisial) from \"Presensi\".tshift where shift like '%$term%' and rtrim(kd_shift) != '$kd'";
    	$query = $this->personalia->query($sql);
    	return $query->result_array();
    }

    public function getJamShift($kd, $hari)
    {
    	$sql = "SELECT * FROM \"Presensi\".tjamshift
				where kd_shift = '$kd' and hari = '$hari'";
		$query = $this->personalia->query($sql);
    	return $query->result_array();
    }

    public function insertTukar($data)
    {
        if (count($data) > 1)
            $this->db->insert_batch('ips.tinput_tukar_shift', $data);
        else
    	   $this->db->insert('ips.tinput_tukar_shift', $data[0]);
    }

    public function insertTukarPersonalia($data)
    {
        if (count($data) > 1)
        $this->personalia->insert_batch('"Presensi".tinput_tukar_shift', $data);
        else
    	$this->personalia->insert('"Presensi".tinput_tukar_shift', $data[0]);

    }

    public function getShiftnya($kd)
    {
    	$sql = "select rtrim(kd_shift) kd_shift, rtrim(shift) shiftnya, rtrim(inisial) from \"Presensi\".tshift where kd_shift = '$kd';";
    	$query = $this->personalia->query($sql);
    	return $query->row()->shiftnya;
    }

    public function getListTukar($noind)
    {
    	$sql = "select
                    group_id,
                    min(tanggal1) tanggal_min,
                    max(tanggal1) tanggal_max,
                    noind1,
                    noind2,
                    status,
                    optpekerja,
                    create_timestamp,
                    (select employee_name from er.er_employee_all where employee_code = noind1) nama1,
                    (select employee_name from er.er_employee_all where employee_code = noind2) nama2
                from
                    ips.tinput_tukar_shift
                where noind1 = '$noind' or noind2 = '$noind' or appr_ = '$noind' or user_ = '$noind'
                group by
                    group_id,
                    noind1,
                    noind2,
                    status,
                    optpekerja,
                    create_timestamp
                order by 
                    create_timestamp desc";
    	$query = $this->db->query($sql);
    	return $query->result_array();
    }

    public function getKodesie($noind)
    {
    	$sql = "select * from hrd_khs.tpribadi where noind in ('$noind')";
    	$query = $this->personalia->query($sql);
    	return $query->result_array();
    }

    public function getGroupId()
    {
        $sql = "select COALESCE(max(group_id), 0) max from ips.tinput_tukar_shift";
        $query = $this->db->query($sql);
        return $query->row()->max+1;
    }
}