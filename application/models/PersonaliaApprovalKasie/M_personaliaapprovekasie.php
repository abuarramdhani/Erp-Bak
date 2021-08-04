<?php
defined('BASEPATH') or exit('No Direct Script Access ALlowed');
/**
 *
 */
class M_personaliaapprovekasie extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->erp = $this->load->database('erp_db', TRUE);
		$this->personalia = $this->load->database('personalia', TRUE);
		$this->spl = $this->load->database('spl_db', TRUE);
	}

	public function getSPLOpenCountByNoind($noind){
		$sql = "select count(*) as jumlah
				from splseksi.tspl a
				inner join hrd_khs.tpribadi b ON a.noind = b.noind
				where a.status = '01'
				and left(b.kodesie,7) in (
					select left(c.kodesie,7)
					from splseksi.takses_seksi c 
					where c.noind = '$noind'
				)";
		$result = $this->spl->query($sql)->row();
		if (!empty($result)) {
			return $result->jumlah;
		}else{
			return 0;
		}
	}

	public function getRencanaLemburByNoindAtasan($noind){
		$sql = "select count(*) as jumlah
				from \"Presensi\".t_rencana_lembur
				where status_approve = 0
				and atasan = '$noind'";
		$result = $this->personalia->query($sql)->row();
		if (!empty($result)) {
			return $result->jumlah;
		}else{
			return 0;
		}
	}

	public function getPerizinanDInasByNoindAtasan($noind){
		$today = date('Y-m-d');
		$sql = "select count(*) as jumlah
				from \"Surat\".tperizinan
				where status = 0
					and atasan_aproval = '$noind'
					and created_date::date = '$today'";
		$result = $this->personalia->query($sql)->row();
		if (!empty($result)) {
			return $result->jumlah;
		}else{
			return 0;
		}
	}

	public function getKaizenByNoindAtasan($noind){
		//$sql = "select count(*) as jumlah
		//		from si.si_kaizen a 
		//		left join si.si_approval b 
		//		on a.kaizen_id = b.kaizen_id
		//		and a.status = b.\"level\"
		//		where b.status in (2,7)
		//		and b.approver = '$noind'";
		//coba tiket bug  dari pak amri
		$sql = "SELECT count (kaizen.kaizen_id) as jumlah
					FROM si.si_kaizen kaizen 
					INNER JOIN (SELECT approval1.* 
									FROM si.si_approval approval1
									INNER JOIN (SELECT max(level) levelist ,kaizen_id from si.si_approval where approver = '$noind' group by kaizen_id) approval2 
											ON approval1.level = approval2.levelist and approval1.kaizen_id = approval2.kaizen_id
									WHERE approval1.approver = '$noind') approval ON approval.kaizen_id = kaizen.kaizen_id
					WHERE approval.ready = '1'
					AND approval.status = 2
					AND kaizen.status <> 8 ";
		$result = $this->erp->query($sql)->row();
		if (!empty($result)) {
			return $result->jumlah;
		}else{
			return 0;
		}
	}

	public function getAbsenOnlineByApprover($noind){
		$sql = "select count(*) as jumlah
				from at.at_absen a
				left join at.at_absen_approval b 
				on a.absen_id = b.absen_id
				where a.status = 0
				and b.\"level\" = 1
				and left(b.approver,5) = '$noind'";
		$result = $this->erp->query($sql)->row();
		if (!empty($result)) {
			return $result->jumlah;
		}else{
			return 0;
		}
	}

	public function getPerizinanPribadi($noind){
		$today = date('Y-m-d');
		$sql = "select count(*) as jumlah
				from \"Surat\".tizin_pribadi
				where atasan = '$noind'
					and appr_atasan is null
					and created_date::date = '$today'";
		$result = $this->personalia->query($sql)->row();
		if (!empty($result)) {
			return $result->jumlah;
		}else{
			return 0;
		}
	}

	public function getTukarShiftByApprover($noind){
		$sql = "select count(*) as jumlah
                from
                    ips.tinput_tukar_shift
                where appr_ = '$noind'
					and approve1_tgl is not null
					and approve2_tgl is not null
					and approve_timestamp = '9999-12-12 00:00:00' 
					and status = '01'";
        $result = $this->erp->query($sql)->row();
		if (!empty($result)) {
			return $result->jumlah;
		}else{
			return 0;
		}
	}

	public function getImportShiftByAtasan($noind){
		$sql = "select count(*) as jumlah
				from ips.t_shift_pekerja
				where tgl_approve is null 
				and approve_by is null
				and atasan = '$noind'";
		$result = $this->erp->query($sql)->row();
		if (!empty($result)) {
			return $result->jumlah;
		}else{
			return 0;
		}
	}

	public function getCutiByApprover($noind){
		$sql = "select count(*) as jumlah
				from lm.lm_pengajuan_cuti a 
				left join lm.lm_approval_cuti b 
				on a.lm_pengajuan_cuti = b.lm_pengajuan_cuti_id
				where b.approver = '$noind'
				and b.status = '1'";
        $result = $this->erp->query($sql)->row();
		if (!empty($result)) {
			return $result->jumlah;
		}else{
			return 0;
		}
	}

} ?>