<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_approval extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia',TRUE);
    }

    public function getShift($pr, $noind)
    {
    	// $ks = substr($kodesie, 0, 7);
    	$sql = "select
					substring(kodesie, 0, 8) kodesie,
					substring(tanggal::text, 0, 8) periode,
					tsp.tgl_import,
					count(noind) jum,
					rtrim(es.section_name) seksi
				from
					ips.t_shift_pekerja tsp
				left join er.er_section es on
					es.section_code = tsp.kodesie
				where
					substring(tanggal::text, 0, 8) = '$pr'
					and tgl_approve is null
					and tsp.atasan = '$noind'
				group by
					substring(kodesie, 0, 8),
					substring(tanggal::text, 0, 8),
					tgl_import,
					es.section_name
				order by
					jum desc";
		// echo $sql;exit();
		$query = $this->db->query($sql);
		return $query->result_array();
    }

    public function getShiftDev($pr)
    {
    	$sql = "select
					substring(kodesie, 0, 8) kodesie,
					substring(tanggal::text, 0, 8) periode,
					tsp.tgl_import,
					count(noind) jum,
					rtrim(es.section_name) seksi
				from
					ips.t_shift_pekerja tsp
				left join er.er_section es on
					es.section_code = tsp.kodesie
				where
					substring(tanggal::text, 0, 8) = '$pr'
					and tgl_approve is null
				group by
					substring(kodesie, 0, 8),
					substring(tanggal::text, 0, 8),
					tgl_import,
					es.section_name
				order by
					jum desc";

		$query = $this->db->query($sql);
		return $query->result_array();
    }

    public function getDetail($ks, $pr, $imp)
    {
    	$sql = "select tsp.*, ts.inisial from ips.t_shift_pekerja tsp
    			left join ips.tshift ts on ts.kd_shift = tsp.kd_shift
				where substring(kodesie, 0, 8) = '$ks'
				and tsp.tgl_import = '$imp'
				and tanggal::text like '$pr%'";
		$query = $this->db->query($sql);
		return $query->result_array();
    }

    public function getPkjDist($ks, $pr, $tgl_imp)
    {
    	$sql = "select
					distinct(noind), ee.employee_name
				from
					ips.t_shift_pekerja tsp
					left join er.er_employee_all ee on ee.employee_code = tsp.noind
				where
					substring(kodesie, 0, 8) = '$ks'
					and tanggal::text like '$pr%'
					and tgl_import = '$tgl_imp'
					order by ee.employee_name;";

		$query = $this->db->query($sql);
		return $query->result_array();
    }

    public function getDetailPersonalia($ks, $pr)
    {
    	$sql = "select
					tsp.*,
					ts.inisial
				from
					\"Presensi\".tshiftpekerja tsp
				left join \"Presensi\".tshift ts on
					ts.kd_shift = tsp.kd_shift
				where
					substring(kodesie, 0, 8) = '$ks'
					and tanggal::text like '$pr%';";
		$query = $this->personalia->query($sql);
		return $query->result_array();
    }

    public function getPkjDistPersonalia($ks, $pr, $noind)
    {
    	$sql = "select
					distinct(tsp.noind), ee.nama
				from
					\"Presensi\".tshiftpekerja tsp
					left join hrd_khs.tpribadi ee on ee.noind = tsp.noind
				where
					substring(ee.kodesie, 0, 8) = '$ks'
					and tanggal::text like '$pr%'
					and tsp.noind in ('$noind')
					order by ee.nama";
		// echo $sql;exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
    }

    public function getCurrentShift($noind, $tgl, $usr, $act, $date, $tgl_imp)
    {
    	$sql = "select
				tanggal,
				noind,
				kd_shift,
				kodesie,
				tukar,
				jam_msk,
				jam_akhmsk,
				jam_plg,
				break_mulai,
				break_selesai,
				ist_mulai,
				ist_selesai,
				jam_kerja,
				'$usr' as user_,
				'$act' as last_action,
				'$date' as last_action_date
			from
				ips.t_shift_pekerja
				where
					noind = '$noind'
					and tgl_import = '$tgl_imp'
					and tanggal::text like '$tgl%'";
		$query = $this->db->query($sql);
		return $query->result_array();
    }

    public function insetShift($data)
    {
    	$this->personalia->insert('"Presensi".tshiftpekerja', $data);
    }

    public function insetShiftHapus($data)
    {
    	$this->personalia->insert('"Presensi".tshiftpekerja_hapus', $data);
    }

    public function updateShift($data, $noind, $tgl)
    {
    	$this->personalia->where('noind', $noind);
    	$this->personalia->where('tanggal', $tgl);
    	$this->personalia->update('"Presensi".tshiftpekerja', $data);
    }

    public function to_move($noind, $tgl, $usr, $act, $date)
    {
    	$sql = "select 
    			*, 
    			'$usr' as user_,
				'$act' as last_action,
				'$date' as last_action_date
				 from \"Presensi\".tshiftpekerja 
		    	where
					noind = '$noind'
					and tanggal::text like '$tgl%'";
		// echo $sql;exit();
		$query = $this->personalia->query($sql);
		return $query->result_array();
    }

    public function updateApprove($tgl_imp, $ks, $data)
    {
    	$this->db->where('tgl_import', $tgl_imp);
    	$this->db->like('kodesie', $ks, 'after');
    	$this->db->update('ips.t_shift_pekerja', $data);
    }

    public function delShift($noind, $tgl)
    {
    	$this->personalia->where('noind', $noind);
    	$this->personalia->where('tanggal', $tgl);
		$this->personalia->delete('"Presensi".tshiftpekerja');
    }

    public function getListApp($noind)
    {
    	$tgl = date('Y-m-d');
    	$sql = "select
                    group_id,
                    min(tanggal1) tanggal_min,
                    max(tanggal1) tanggal_max,
                    noind1,
                    noind2,
                    status,
                    optpekerja,
                    create_timestamp,
                    approve_timestamp,
                    (select employee_name from er.er_employee_all where employee_code = noind1) nama1,
                    (select employee_name from er.er_employee_all where employee_code = noind2) nama2,
                    min(tanggal1)::date - '$tgl'::date beda
                from
                    ips.tinput_tukar_shift
                where
                	(noind1 = '$noind'
					and approve1_tgl is null and status != '03')
					or (noind2 = '$noind'
					and approve2_tgl is null and status != '03')
					or (appr_ = '$noind'
					and approve1_tgl is not null
					and approve2_tgl is not null
					and approve_timestamp = '9999-12-12 00:00:00' and status != '03')
                group by
                    group_id,
                    noind1,
                    noind2,
                    status,
                    optpekerja,
                    approve_timestamp,
                    create_timestamp
                order by 
                    create_timestamp desc";
		$query = $this->db->query($sql);
		return $query->result_array();
    }

    public function getListId($id)
    {
    	$sql = "select
					substring(min(tanggal1)::text,0,11) min,
					substring(max(tanggal1)::text,0,11) max,
					string_agg(shift1, ';') shift1,
					string_agg(shift2, ';') shift2,
					string_agg(substring(tanggal1::text,0,11), ';') tgl_arr,
					noind1,
					noind2,
					status,
					optpekerja,
					create_timestamp,
					reject_by,
					appr_,
					approve1_tgl,
					approve2_tgl,
					approve_timestamp,
					group_id,
					alasan,
					(select employee_name from er.er_employee_all where employee_code = noind1) nama1,
				    (select employee_name from er.er_employee_all where employee_code = noind2) nama2,
				    (select employee_name from er.er_employee_all where employee_code = appr_) nama3
				from
					ips.tinput_tukar_shift
				where
					group_id = '$id'
				group by
					group_id,
					noind1,
					noind2,
					status,
					optpekerja,
					reject_by,
					appr_,
					approve1_tgl,
					approve2_tgl,
					approve_timestamp,
					group_id,
					alasan,
					create_timestamp
				order by 
					create_timestamp desc";
		$query = $this->db->query($sql);
		return $query->row_array();
    }

    public function upTS($l, $id, $duo, $tgl)
    {
    	
    	$sql = "update ips.tinput_tukar_shift set $l = '$tgl' $duo where group_id = '$id'";
    	$query = $this->db->query($sql);
    }

    public function upTS_rej($noind, $tgl, $id, $alasan)
    {
    	$sql = "update ips.tinput_tukar_shift set approve_timestamp = '$tgl', reject_by = '$noind', status = '03', alasan='$alasan'  where group_id = '$id'";
    	$query = $this->db->query($sql);
    }

    public function getTukar($id)
    {
    	$sql = "select * from ips.tinput_tukar_shift where tukar_id = '$id' limit 1";

    	$query = $this->db->query($sql);
		return $query->result_array();
    }

    public function getTukarGroup($id)
    {
    	$sql = "select * from ips.tinput_tukar_shift where group_id = '$id'";

    	$query = $this->db->query($sql);
		return $query->result_array();
    }

    public function insertTukar($data)
    {
    	$this->personalia->insert('"Presensi".tinput_tukar_shift', $data);
    }

    public function getKD($nama_sf)
    {
    	$sql = "select rtrim(kd_shift) kd_shift, rtrim(shift) shiftnya, rtrim(inisial) from \"Presensi\".tshift where shift like '%$nama_sf%';";
    	$query = $this->personalia->query($sql);
    	return $query->row()->kd_shift;
    }

    public function upPkj($tgl, $noind, $kd)
    {
    	$now = date('Y-m-d H:i:s');
    	$sql = "update \"Presensi\".tshiftpekerja set kd_shift = '$kd', last_action = 'UPDATE', last_action_date = '$now' where rtrim(noind) = '$noind' and tanggal = '$tgl'";
    	$query = $this->personalia->query($sql);
    }

    public function insTlog($tgl, $vno, $shift1, $shift2, $appr)
    {
    	$sql = "INSERT INTO hrd_khs.tlog (wkt, menu, ket, noind, jenis, program, noind_baru) VALUES('$tgl', 'POLA SHIFT -> TUKAR SHIFT', '$vno $shift1 <-> $shift2', '$appr', 'UPDATE -> TSHIFTPEKERJA', 'POLA SHIFT', NULL);";
    	$query = $this->personalia->query($sql);
    }

    public function up_pers($tgl, $noind1, $noind2, $create, $now, $status)
    {
    	$noind1 = rtrim($noind1);
    	$noind2 = rtrim($noind2);
    	$sql = "Update \"Presensi\".tinput_tukar_shift set status = '$status', approve_timestamp = '$now' where tanggal1 = '$tgl' and rtrim(noind1) = '$noind1' and rtrim(noind2) = '$noind2' and create_timestamp = '$create'";
    	$query = $this->personalia->query($sql);
    }
}