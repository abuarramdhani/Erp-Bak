<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_report extends CI_Model
{

	function kenaikangaji(){
		$sql = "
			WITH
				r_active (noind, tgl_berlaku, gp, if) AS
			  		(select noind, tgl_berlaku, CAST (gaji_pokok AS NUMERIC), CAST (i_f AS NUMERIC)
			 		 from pr.pr_riwayat_gaji
			  		where tgl_tberlaku = '9999-12-31'),

			 	r_innactive (noind, tgl_berlaku, gp, if) AS
			  		(select noind, tgl_berlaku, CAST (gaji_pokok AS NUMERIC), CAST (i_f AS NUMERIC)
			  		from pr.pr_riwayat_gaji
			  		where tgl_tberlaku != '9999-12-31')

			select
			 	ra.noind,
			 	mp.nama,
			 	ms.seksi,
			 		case when ra.tgl_berlaku
					is NULL then null 	
					else to_char(ra.tgl_berlaku, 'DD/MM/YYYY')
					end as tgl_berlaku,
			 	ra.gp as gaji_pokok,
			 	case when ri.noind is null then (0) else (ra.gp-ri.gp) end as kenaikan_gp,
			 	ra.if as if,
			 	case when ri.noind is null then (0) else (ra.if-ri.if) end as kenaikan_if

			from r_active ra
			 	left join r_innactive ri on ra.noind = ri.noind
			 	left join pr.pr_master_pekerja mp on ra.noind = mp.noind
			 	left join pr.pr_master_seksi ms on mp.kodesie = ms.kodesie

			order by noind asc
			limit 70
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function rincianhutang($id){
		$sql = "
			WITH
		 		
		 		data_hutang (noind,nama,jabatan,seksi,status_kerja,no_hutang,tgl_pengajuan,total_hutang,jml_cicilan,status_lunas) AS
		  		(select
		   		 	mp.noind, mp.nama, mp.jabatan, ms.seksi, mt.status_kerja,
		    	 	hk.no_hutang,
		   		 	case when hk.tgl_pengajuan is null then null else to_char(hk.tgl_pengajuan , 'DD/MM/YYYY') end as tgl_pengajuan,
		    	 	CAST(hk.total_hutang AS NUMERIC) AS total_hutang, hk.jml_cicilan, status_lunas
		   		from pr.pr_hutang_karyawan hk
		    	 	left join pr.pr_master_pekerja mp on hk.noind = mp.noind
		    	 	left join pr.pr_master_seksi ms on mp.kodesie = ms.kodesie
		    	 	left join pr.pr_master_status_kerja mt on mp.kd_status_kerja = mt.kd_status_kerja
		   		where hk.no_hutang = '$id' ),
		  		
		  		data_cicilan (no_hutang, sudah_dibayar) AS
		   		(select
		    	 	th.no_hutang,
		   		 	sum(CAST(th.jumlah_transaksi AS NUMERIC)) as sudah_dibayar
		    	from pr.pr_transaksi_hutang th
		    	where th.no_hutang = '$id'
		    	group by th.no_hutang)

				select *, htg.total_hutang-ccl.sudah_dibayar as sisa_angsuran
				from data_hutang htg
				left join data_cicilan ccl on htg.no_hutang = ccl.no_hutang
			";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function cicilanhutang($id){
		$sql = " 
			select *,
		 	case when tgl_transaksi is null then null else to_char(tgl_transaksi , 'DD/MM/YYYY') end as tgl_transaksi
		 	from pr.pr_transaksi_hutang where no_hutang = '$id' ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

}