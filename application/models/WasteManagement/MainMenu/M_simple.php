<?php
Defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 
 */
class M_simple extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getLimbahjenis(){
		$query = 	"select id_jenis_limbah id_jenis,kode_limbah ,jenis_limbah 
					from ga.ga_limbah_jenis 
					order by kode_limbah,jenis_limbah";
		$result = $this->db->query($query);
		return $result->result_array();
	}

	public function getSimpleData(){
		$query = 	"select distinct limkir.id_jenis_limbah,
									limjen.jenis_limbah 
					from ga.ga_limbah_kirim limkir
					inner join ga.ga_limbah_jenis limjen
						on limjen.id_jenis_limbah = limkir.id_jenis_limbah";
		$result = $this->db->query($query);
		return $result->result_array();
	}

	public function getSimpleDataById($id){
		$query = 	"select simple.id_simple,jenis.jenis_limbah,to_char(simple.periode, 'month YYYY') periode 
					from ga.ga_limbah_simple simple 
					inner join ga.ga_limbah_jenis jenis on simple.id_jenis_limbah = jenis.id_jenis_limbah 
					where id_simple = '$id'; ";
		$result = $this->db->query($query);
		return $result->result_array();
	}

	public function insertSimple($jenis,$periode){
		$query = "select max(cast(id_simple as int))+1 max from ga.ga_limbah_simple";
		$result = $this->db->query($query);
		$arr = $result->result_array();
		if ($arr['0']['max'] == null) {
			$arr['0']['max'] = '1';
		}
		$id = $arr['0']['max'];
		$periode = $periode." 01";
		$query = "insert into ga.ga_limbah_simple values('$id','$jenis','$periode');";
		$this->db->query($query);
	}

	public function delSimple($id){
		$query = "delete from ga.ga_limbah_simple where id_simple = '$id';";
		$this->db->query($query);
		$query = "delete from ga.ga_limbah_simple_detail where id_simple = '$id';";
		$this->db->query($query);
	}

	public function getSimpleDetail($id){
		$query = 	"select detail.id_simple_detail, jenis.kode_limbah,to_char(detail.tanggal_dihasilkan, 'DD month YYYY') tanggal_dihasilkan,detail.kode_manifest,detail.jumlah
					from ga.ga_limbah_simple_detail detail
					inner join ga.ga_limbah_jenis jenis on jenis.id_jenis_limbah = detail.id_jenis_limbah 
					where id_simple = '$id' 
					order by jenis.kode_limbah;";
		$result = $this->db->query($query);
		return $result->result_array();
	}

	public function getJenisKodelimbahBySimple($id){
		$query = "select jenis.id_jenis_limbah, jenis.jenis_limbah, jenis.kode_limbah from ga.ga_limbah_simple simple inner join ga.ga_limbah_jenis jenis on simple.id_jenis_limbah = jenis.id_jenis_limbah where simple.id_simple = '$id';";
		$result = $this->db->query($query);
		return $result->result_array();
	}

	// public function insertSimpleDetail($id_simple, $data){
	// 	$query = "select max(cast(id_simple_detail as int))+1 max from ga.ga_limbah_simple_detail";
	// 	$result = $this->db->query($query);
	// 	$arr = $result->result_array();
	// 	if ($arr['0']['max'] == null) {
	// 		$arr['0']['max'] = '1';
	// 	}
	// 	$id_detail 	= $arr['0']['max'];
	// 	$jenis 		= $data['Jenis'];
	// 	$tanggal 	= $data['Tanggal'];
	// 	$manifest 	= $data['Manifest'];
	// 	$jumlah 	= $data['Jumlah'];
	// 	$catatan 	= $data['Catatan'];
	// 	$query = "insert into ga.ga_limbah_simple_detail
	// 	(id_simple_detail, id_simple, id_jenis_limbah, tanggal_dihasilkan, kode_manifest, jumlah, catatan)
	// 	 values('$id_detail','$id_simple','$jenis','$tanggal','$manifest','$jumlah','$catatan')";

	// 	// echo $query;
	// 	// exit;

	// 	 $this->db->query($query);
	// }

	public function insertSimpleDetail($id_simple, $arrkirim){

		foreach ($arrkirim as $key) {
			$query = "select max(cast(id_simple_detail as int))+1 max from ga.ga_limbah_simple_detail";

			$result = $this->db->query($query);
			$arr = $result->result_array();
			if ($arr['0']['max'] == null) {
				$arr['0']['max'] = '1';
			}
			$id_detail 	= $arr['0']['max'];

			$query = 	"insert into ga.ga_limbah_simple_detail
						(id_simple_detail, id_simple, id_jenis_limbah, tanggal_dihasilkan,jumlah)
					 	select '$id_detail','$id_simple', id_jenis_limbah, cast(tanggal_kirim as date), cast(cast(berat_kirim as float)/1000 as float)
						from ga.ga_limbah_kirim where id_kirim = '".$key."'";
			 $this->db->query($query);
			 $query = 	"update ga.ga_limbah_kirim set status_simple = '1'
						where id_kirim = '".$key."';";
			 $this->db->query($query);
		}
	}

	public function getSimpleDetailById($id){
		$query = "select id_simple, to_char(tanggal_dihasilkan, 'DD month YYYY') tanggal_dihasilkan, kode_manifest, jumlah, catatan from ga.ga_limbah_simple_detail where id_simple_detail = '$id'";
		$result = $this->db->query($query);
		return $result->result_array();
	}

	public function delSimpleDetail($id){
		$query = "select id_simple from ga.ga_limbah_simple_detail where id_simple_detail = '$id';";
		$result = $this->db->query($query);
		$query = "delete from ga.ga_limbah_simple_detail where id_simple_detail = '$id';";
		$this->db->query($query);
		return $result->result_array();
	}

	public function UpdateSimpleDetail($id_detail,$data){
		$tanggal 	= $data['Tanggal'];
		$manifest 	= $data['Manifest'];
		$jumlah 	= $data['Jumlah'];
		$catatan 	= $data['Catatan'];
		$query = "update ga.ga_limbah_simple_detail set tanggal_dihasilkan = '$tanggal', kode_manifest = '$manifest', jumlah = '$jumlah', catatan = '$catatan' where id_simple_detail = '$id_detail'";
		$this->db->query($query);
	}

	public function getExportSimpleDetail($id){
		$query = "select jenis.kode_limbah, to_char(detail.tanggal_dihasilkan, 'YYYY-MM-DD') tanggal_dihasilkan, detail.masa_simpan, detail.tps, detail.sumber, detail.kode_manifest , detail.pengirim_nama, detail.jumlah, detail.catatan
			from ga.ga_limbah_simple_detail detail
			inner join ga.ga_limbah_jenis jenis on jenis.id_jenis_limbah = detail.id_jenis_limbah
			where detail.id_simple ='$id';";
		$result = $this->db->query($query);
		return $result->result_array();
	}

	public function getLimbahKirimBySimple($id){
		$query = 	"select cast(lk.tanggal_kirim as date) tanggal,
					es.section_name seksi,
					lk.berat_kirim berat,
					lk.id_kirim,
					lk.status_simple status,
					lj.jenis_limbah jenis
					from ga.ga_limbah_simple ls
					inner join ga.ga_limbah_kirim lk
						on lk.id_jenis_limbah = ls.id_jenis_limbah 
						and to_char(lk.tanggal_kirim,'yyyy m') = to_char(ls.periode,'yyyy m')
						and lk.status_simple = '0'
					inner join er.er_section es
						on es.section_code = concat(lk.kodesie_kirim,'00')
					inner join ga.ga_limbah_jenis lj
						on lj.id_jenis_limbah = lk.id_jenis_limbah
					where id_simple = '$id'
					order by lk.status_simple, cast(lk.tanggal_kirim as date) asc";
		$result = $this->db->query($query);
		return $result->result_array();
	}

	public function getLimbahKirimByID0($id){
		$query = 	"select cast(lk.tanggal_kirim as date) tanggal,
							es.section_name seksi,
							lk.berat_kirim berat,
							lk.id_kirim,
							lk.status_simple status,
							lj.jenis_limbah jenis
					from ga.ga_limbah_kirim lk
					inner join er.er_section es
						on es.section_code = concat(lk.kodesie_kirim,'00')
					inner join ga.ga_limbah_jenis lj
						on lj.id_jenis_limbah = lk.id_jenis_limbah
					where lk.status_simple = '0'
					and lk.id_jenis_limbah = '$id'
					order by lk.status_simple, cast(lk.tanggal_kirim as date) asc";
		$result = $this->db->query($query);
		return $result->result_array();
	}

	public function getLimbahKirimByID1($id){
		$query = 	"select cast(lk.tanggal_kirim as date) tanggal,
							es.section_name seksi,
							lk.berat_kirim berat,
							lk.id_kirim,
							lk.status_simple status,
							lj.jenis_limbah jenis
					from ga.ga_limbah_kirim lk
					inner join er.er_section es
						on es.section_code = concat(lk.kodesie_kirim,'00')
					inner join ga.ga_limbah_jenis lj
						on lj.id_jenis_limbah = lk.id_jenis_limbah
					where lk.status_simple = '1'
					and lk.id_jenis_limbah = '$id'
					order by lk.status_simple, cast(lk.tanggal_kirim as date) asc";
		$result = $this->db->query($query);
		return $result->result_array();
	}

	public function getExport($text){
		$query = "	select 	limjen.kode_limbah,
							cast(limkir.tanggal_kirim as date) tanggal_dihasilkan, 
							'90' masa_simpan,
							'MASUK KE TPS INTERNAL' tps,
							'TPS INTERNAL' sumber,
							'' kode_manifest,
							'CV. Karya Hidup Sentosa' pengirim_nama,
							cast(limkir.berat_kirim as float)/1000 jumlah,
							'' catatan
					from ga.ga_limbah_kirim limkir
					inner join ga.ga_limbah_jenis limjen
						on limjen.id_jenis_limbah = limkir.id_jenis_limbah
					where limkir.id_kirim in($text)";
		$result = $this->db->query($query);
		return $result->result_array();
	}

	public function getExportAll($id){
		$query = "	select 	limjen.kode_limbah,
							cast(limkir.tanggal_kirim as date) tanggal_dihasilkan, 
							'90' masa_simpan,
							'MASUK KE TPS INTERNAL' tps,
							'TPS INTERNAL' sumber,
							'' kode_manifest,
							'CV. Karya Hidup Sentosa' pengirim_nama,
							cast(limkir.berat_kirim as float)/1000 jumlah,
							'' catatan
					from ga.ga_limbah_kirim limkir
					inner join ga.ga_limbah_jenis limjen
						on limjen.id_jenis_limbah = limkir.id_jenis_limbah
					where limkir.id_jenis_limbah = '$id'";
		$result = $this->db->query($query);
		return $result->result_array();
	}

	public function updateStatus($text){
		$query = "update ga.ga_limbah_kirim set status_simple = '1' where id_kirim in($text)";
		$this->db->query($query);
	}

	public function getDeleteKirimInsertBackup($text){
		$sql2 = "insert into ga.ga_limbah_kirim_backup
				(id_kirim, id_jenis_limbah, tanggal_kirim, kodesie_kirim, bocor, jumlah_kirim, ket_kirim, berat_kirim, status_kirim, created_by, created_date, noind_pengirim, status_simple)
				select id_kirim, id_jenis_limbah, tanggal_kirim, kodesie_kirim, bocor, jumlah_kirim, ket_kirim, berat_kirim, status_kirim, created_by, created_date, noind_pengirim, status_simple
				from ga.ga_limbah_kirim where id_kirim in($text)";
		$this->db->query($sql2);

		$sql1 = "delete from ga.ga_limbah_kirim where id_kirim in ($text)";
		$this->db->query($sql1);
	}

	var $table = 'ga.ga_limbah_kirim lk';
	var $table1 = 'er.er_section es';
	var $table2 = 'ga.ga_limbah_jenis lj';
	var	$column_select = array('cast(lk.tanggal_kirim as date) tanggal_kirim','section_name','berat_kirim','jenis_limbah');
	var	$column_order = array('cast(lk.tanggal_kirim as date) tanggal_kirim','section_name','berat_kirim','jenis_limbah');
	var	$column_search = array('cast(lk.tanggal_kirim as date) tanggal_kirim','section_name','berat_kirim','jenis_limbah');
	var $order = array('cast(lk.tanggal_kirim as date)' => 'desc');

	public function simple_table_query($id){
	    $this->db->select($this->column_select);	
	    $this->db->from($this->table);
	    $this->db->join($this->table1,"es.section_code = concat(lk.kodesie_kirim,'00')",'left');
	    $this->db->join($this->table2,"lj.id_jenis_limbah = lk.id_jenis_limbah",'left');
	    $this->db->where('lk.status_simple','1');
	    $this->db->where('lk.id_jenis_limbah', $id);
	    $i = 0;
	    foreach ($this->column_search as $item) {
    		if ($_POST['search']['value']) {
    			if ($i===0) {
    				$this->db->group_start();
    				$this->db->like($item,$_POST['search']['value']);
    			}else{
    				$this->db->or_like($item,$_POST['search']['value']);
    			}
    			if (count($this->column_search)-1 == $i) {
    				$this->db->group_end();
    			}
    			$i++;
    		}
    	}
    	if (isset($_POST['order'])) {
    		$this->db->order_by($this->column_order[$_POST['order']['0']['column']],$_POST['order']['0']['dir']);
    	}elseif (isset($this->order)) {
    		$order = $this->order;
    		$this->db->order_by(key($order),$order[key($order)]);
    	}
    }

    public function simple_table($id){
    	$this->simple_table_query($id);
    	if ($_POST['length'] != -1) {
    		$this->db->limit($_POST['length'],$_POST['start']);
    		$query = $this->db->get();
    		return $query->result();
    	}
    }

    public function count_filtered($id){
    	$this->simple_table_query($id);
    	$query = $this->db->get();
    	return $query->num_rows();
    }

    public function count_all($id){
    	$this->db->from($this->table);
    	$this->db->join($this->table1,"es.section_code = concat(lk.kodesie_kirim,'00')",'left');
	    $this->db->join($this->table2,"lj.id_jenis_limbah = lk.id_jenis_limbah",'left');
	    $this->db->where('lk.status_simple','1');
	    $this->db->where('lk.id_jenis_limbah', $id);
    	$query = $this->db->get();
    	return $query->num_rows();
    }
}
?>