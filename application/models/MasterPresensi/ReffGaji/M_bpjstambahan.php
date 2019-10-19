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

	var $table = 'hrd_khs.tpribadi';
	var	$column_order = array('noind','noind','nama','seksi',4,'noind');
	var	$column_search = array('noind','nama','seksi');
	var $order = array('noind' => 'asc');
	var $select = "tpribadi.noind,tpribadi.nama,
				case when trim(tseksi.seksi) != '-' then
					concat(tseksi.seksi)
				when trim(tseksi.unit) != '-' then
					concat('UNIT ',tseksi.unit)
				when  trim(tseksi.bidang) != '-' then
					concat('BIDANG ',tseksi.bidang)
				when  trim(tseksi.dept) != '-' then
					concat('DEPT ',tseksi.dept)
				else
					'-'
				end as seksi,
				(
					select count(*)
					from hrd_khs.tbpjs_tambahan c
					where tpribadi.noind = c.noind
					and status = '1'
				) as jumlah";
		var $where = "tpribadi.bpjs_kes = '1' and tpribadi.keluar = '0'";
	public function user_table_query(){

		$this->personalia->select($this->select);
		$this->personalia->from($this->table);
		$this->personalia->join('hrd_khs.tseksi','tseksi.kodesie=tpribadi.kodesie','left');
		$this->personalia->where($this->where);
		$i = 0;
		foreach ($this->column_search as $item) {
			if ($_POST['search']['value']) {
				if ($i===0) {
					$this->personalia->group_start();
					$this->personalia->like($item,strtoupper($_POST['search']['value']));
				}else{
					$this->personalia->or_like($item,strtoupper($_POST['search']['value']));
				}
				if (count($this->column_search)-1 == $i) {
					$this->personalia->group_end();
				}
				$i++;
			}
		}
		if (isset($_POST['order'])) {
			$this->personalia->order_by($this->column_order[$_POST['order']['0']['column']],$_POST['order']['0']['dir']);
		}elseif (isset($this->order)) {
			$order = $this->order;
			$this->personalia->order_by(key($order),$order[key($order)]);
		}
	}

	public function user_table(){
		$this->user_table_query();
		if ($_POST['length'] != -1) {
			$this->personalia->limit($_POST['length'],$_POST['start']);
			$query = $this->personalia->get();
			return $query->result();
		}
	}

	public function count_filtered(){
		$this->user_table_query();
		$query = $this->personalia->get();
		return $query->num_rows();
	}

	public function count_all(){
		$this->personalia->select($this->select);
		$this->personalia->from($this->table);
		$this->personalia->where($this->where);
		$this->personalia->join('hrd_khs.tseksi','tseksi.kodesie=tpribadi.kodesie','left');
		$query = $this->personalia->get();
		return $query->num_rows();
	}



}

?>
