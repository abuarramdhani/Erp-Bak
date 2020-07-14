<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_izindinasptm extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->erp = $this->load->database('erp_db',TRUE);
        $this->personalia = $this->load->database('personalia',TRUE);
    }

    public function getPekerjaDinasHariIni(){
		$sql = "select * 
				from ( 
					select 
						tai.izin_id,
						tpi.noind,
						tpri.nama,
						tpri.tempat_makan,
						tpi.makan,
						tai.tujuan,
						tai.created_date::date as tanggal,
						tp.keterangan, 
						case when tp.jenis_izin = '1' then 'PUSAT' 
						when tp.jenis_izin = '2' then 'TUKSONO' 
						when tp.jenis_izin = '3' then 'MLATI' 
						else 'TIDAK DIKETAHUI' 
						end as jenis_dinas, 
						case when (
							select count(*) 
							from \"Catering\".tpesanantambahan_detail tptd 
							inner join \"Catering\".tpesanantambahan tpt 
							on tptd.id_tambahan = tpt.id_tambahan 
							Where tpt.fd_tanggal = current_date 
							and tptd.fs_noind = tai.noinduk
						) > 0 then 
							'Sudah diproses'
						else 
							'Belum diproses'
						end as diproses 
					from \"Surat\".taktual_izin tai 
					inner join \"Surat\".tpekerja_izin tpi 
					on tai.noinduk = tpi.noind 
					and tai.izin_id = tpi.izin_id 
					inner join \"Surat\".tperizinan tp 
					on tai.izin_id::int = tp.izin_id 
					left join hrd_khs.tpribadi tpri 
					on tpri.noind = tai.noinduk 
					Where tai.created_date:: Date = current_date 
					and tai.created_date::time < '09:30'::time 
					and tpi.makan = '1' 
					and tp.status = 1 
				) as tbl 
				order by diproses,jenis_dinas,tujuan,izin_id,noind ";
		return $this->personalia->query($sql)->result_array();
    }

    public function getPekerjaDinasHariIniBelumTerproses(){
		$sql = "select * 
				from ( 
					select 
						tai.izin_id,
						tpi.noind,
						tpri.nama,
						tpri.tempat_makan,
						tpi.makan,
						tai.tujuan,
						tai.created_date::date as tanggal,
						tp.keterangan, 
						case when tp.jenis_izin = '1' then 'PUSAT' 
						when tp.jenis_izin = '2' then 'TUKSONO' 
						when tp.jenis_izin = '3' then 'MLATI' 
						else 'TIDAK DIKETAHUI' 
						end as jenis_dinas, 
						case when (
							select count(*) 
							from \"Catering\".tpesanantambahan_detail tptd 
							inner join \"Catering\".tpesanantambahan tpt 
							on tptd.id_tambahan = tpt.id_tambahan 
							Where tpt.fd_tanggal = current_date 
							and tptd.fs_noind = tai.noinduk
						) > 0 then 
							'Sudah diproses'
						else 
							'Belum diproses'
						end as diproses 
					from \"Surat\".taktual_izin tai 
					inner join \"Surat\".tpekerja_izin tpi 
					on tai.noinduk = tpi.noind 
					and tai.izin_id = tpi.izin_id 
					inner join \"Surat\".tperizinan tp 
					on tai.izin_id::int = tp.izin_id 
					left join hrd_khs.tpribadi tpri 
					on tpri.noind = tai.noinduk 
					Where tai.created_date:: Date = current_date 
					and tai.created_date::time < '09:30'::time 
					and tpi.makan = '1' 
					and tp.status = 1 
				) as tbl 
				where diproses = 'Belum diproses'
				order by diproses,jenis_dinas,tujuan,izin_id,noind ";
		return $this->personalia->query($sql)->result_array();
    }

    public function getUserCateringByNoind($noind){
    	$sql = "select eea.employee_code, eea.employee_name, eea.internal_mail, sugm.*
				from er.er_employee_all eea
				inner join sys.sys_user su on eea.employee_id=su.employee_id
				inner join sys.sys_user_application sua on su.user_id = sua.user_id
				inner join sys.sys_user_group_menu sugm on sua.user_group_menu_id = sugm.user_group_menu_id
				where eea.employee_code = '$noind' and sugm.user_group_menu_id = '2491'";
		return $this->erp->query($sql)->result_array();
    }

}

?>