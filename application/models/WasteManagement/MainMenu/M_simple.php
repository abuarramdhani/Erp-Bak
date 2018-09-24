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
		$query = 	"select simple.id_simple,jenis.jenis_limbah,to_char(simple.periode, 'month YYYY') periode 
					from ga.ga_limbah_simple simple 
					inner join ga.ga_limbah_jenis jenis on simple.id_jenis_limbah = jenis.id_jenis_limbah 
					order by simple.periode desc; ";
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

	public function insertSimpleDetail($id_simple, $data){
		$query = "select max(cast(id_simple_detail as int))+1 max from ga.ga_limbah_simple_detail";
		$result = $this->db->query($query);
		$arr = $result->result_array();
		if ($arr['0']['max'] == null) {
			$arr['0']['max'] = '1';
		}
		$id_detail 	= $arr['0']['max'];
		$jenis 		= $data['Jenis'];
		$tanggal 	= $data['Tanggal'];
		$manifest 	= $data['Manifest'];
		$jumlah 	= $data['Jumlah'];
		$catatan 	= $data['Catatan'];
		$query = "insert into ga.ga_limbah_simple_detail
		(id_simple_detail, id_simple, id_jenis_limbah, tanggal_dihasilkan, kode_manifest, jumlah, catatan)
		 values('$id_detail','$id_simple','$jenis','$tanggal','$manifest','$jumlah','$catatan')";

		// echo $query;
		// exit;

		 $this->db->query($query);
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
}
?>