<?php 
defined('BASEPATH') or exit('No Direct Script Access ALlowed');
/**
 * 
 */
class M_bpjstambahan extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->personalia = $this->load->database('personalia', TRUE);
	}

	public function getPekerja(){
		$sql = "select a.noind,a.nama,
					case when trim(b.seksi) != '-' then 
						concat(b.seksi)
					when trim(b.unit) != '-' then 
						concat('UNIT ',b.unit)
					when  trim(b.bidang) != '-' then 
						concat('BIDANG ',b.bidang)
					when  trim(b.dept) != '-' then 
						concat('DEPT ',b.dept)
					else 
					 	'-'
					end as seksi,
					(
						select count(*) 
						from hrd_khs.tbpjs_tambahan c 
						where a.noind = c.noind 
						and status = '1'
					) as jumlah
				from hrd_khs.tpribadi a
				left join hrd_khs.tseksi b 
				on a.kodesie = b.kodesie
				where a.bpjs_kes = '1' 
				and a.keluar = '0'";
		return $this->personalia->query($sql)->result_array();
	}

	public function getKeluarga($noind){
		$sql = " select trim(b.jenisanggota) as jenisanggota,
						coalesce(trim(a.nama),'-') as nama,
						coalesce(trim(a.nik),'-') as nik,
						to_char(a.tgllahir,'dd/Mon/yyyy') as tgllahir,
						coalesce(trim(a.alamat),'-') as alamat,
						case when coalesce(c.status,'0') = '1' then
							'YA'
						else 
							'TIDAK'
						end as status
				 from hrd_khs.tkeluarga a
				 inner join hrd_khs.tmasterkel b 
				 on a.nokel = b.nokel
				 left join hrd_khs.tbpjs_tambahan c 
				 on a.noind = c.noind 
				 and trim(a.nama) = trim(c.nama)
				 where a.noind  ='$noind'
				 order by a.nokel";
		return $this->personalia->query($sql)->result_array();
	}

	public function tambah($noind,$nama){
		$sql = "insert into hrd_khs.tbpjs_tambahan
				(noind,nokel,nama,nik,status,created_by)
				select noind,trim(nokel),trim(nama),trim(nik),'1','$noind' 
				from hrd_khs.tkeluarga
				where noind = '$noind'
				and trim(nama) = '$nama' ";
		$this->personalia->query($sql);
	}

	public function hapus($noind,$nama){
		$sql = "delete from hrd_khs.tbpjs_tambahan 
				where noind = '$noind'
				and trim(nama) = '$nama' ";
		$this->personalia->query($sql);
	}

}

?>