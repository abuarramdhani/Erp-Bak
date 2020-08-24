<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_edittempatmakan extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->personalia = $this->load->database('personalia',TRUE);
	}

	public function getSeksiByKeyKodesieLevel($key,$kodesie,$level){
		$where = "";
		$kondisi = array();
		if ($level == 'departemen') {
			$where = "where upper(dept) like upper(concat(?,'%'))";
			$kolom = "dept";
			$panjang = 1;
			$kondisi = array($panjang,$key);
		}elseif ($level == 'bidang') {
			$where = "where upper(bidang) like upper(concat(?,'%')) and left(kodesie,1) = ? ";
			$kolom = "bidang";
			$panjang = 3;
			$kondisi = array($panjang,$key,$kodesie);
		}elseif ($level == 'unit') {
			$where = "where upper(unit) like upper(concat(?,'%')) and left(kodesie,3) = ? ";
			$kolom = "unit";
			$panjang = 5;
			$kondisi = array($panjang,$key,$kodesie);
		}elseif ($level == 'seksi') {
			$where = "where upper(seksi) like upper(concat(?,'%')) and left(kodesie,5) = ? ";
			$kolom = "seksi";
			$panjang = 7;
			$kondisi = array($panjang,$key,$kodesie);
		}elseif ($level == 'pekerjaan') {
			$where = "where upper(pekerjaan) like upper(concat(?,'%')) and left(kodesie,7) = ? ";
			$kolom = "pekerjaan";
			$panjang = 9;
			$kondisi = array($panjang,$key,$kodesie);
		}
		$sql = "select distinct left(kodesie,?) as kodesie, 
					case when trim($kolom) = '-' then concat('SEMUA ',upper('$kolom')) else trim($kolom) end as nama
				from hrd_khs.tseksi
				$where
				order by 1 ";
		return $this->personalia->query($sql,$kondisi)->result_array();
	}

	public function getTempatMakanByKeyStat($key,$stat){
		if ($stat == 'lama') {
			$union = "union select '--SEMUA TEMPAT MAKAN--' ";
		}else{
			$union = "";
		}

		$sql = "select * 
				from (
					select fs_tempat_makan
					from \"Catering\".ttempat_makan
					where upper(fs_tempat_makan) like upper(concat(?,'%')) 
					$union
				) as tbl 
				order by fs_tempat_makan collate \"C\" ";
		return $this->personalia->query($sql,array($key))->result_array();
	}

	public function getLokasiKerjaByKey($key){
		$sql = "select id_ as kode_lokasi, lokasi_kerja
				from hrd_khs.tlokasi_kerja
				where upper(id_) like concat(?,'%') or upper(lokasi_kerja) like upper(concat(?,'%')) 
				union select '-','SEMUA LOKASI KERJA'
				order by 1 ";
		return $this->personalia->query($sql,array($key,$key))->result_array();
	}

	public function getKodeIndukByKey($key){
		$sql = "select fs_noind,fs_ket
				from hrd_khs.tnoind
				where upper(fs_noind) like upper(concat(?,'%')) or upper(fs_ket) like upper(concat(?,'%')) 
				union select '-','SEMUA KODE INDUK'
				order by 1 ";
		return $this->personalia->query($sql,array($key,$key))->result_array();
	}

	public function getPekerjaByKodesie($kodesie){
		$sql = "select tp.noind,trim(tp.nama) as nama, tp.tempat_makan, tl.lokasi_kerja 
				from hrd_khs.tpribadi tp 
				left join hrd_khs.tlokasi_kerja tl 
				on tp.lokasi_kerja = tl.id_
				where tp.keluar = '0'
				and tp.kodesie like concat(?,'%')
				order by tp.noind";
		return $this->personalia->query($sql,array($kodesie))->result_array();
	}

	public function getPekerjaByKodesieLokasiKodeIndukTempatMakan($kodesie,$lokasi,$kode_induk,$tempat_makan){
		$where = "";
		if ($kodesie != "") {
			$where = " and tp.kodesie like '".$kodesie."%' ";
		}
		if ($lokasi != "") {
			$where .= " and tp.lokasi_kerja = '".$lokasi."' ";
		}
		if ($kode_induk != "") {
			$where .= " and tp.kode_status_kerja = '".$kode_induk."' ";
		}
		if ($tempat_makan != "") {
			$where .= " and tp.tempat_makan = '".$tempat_makan."' ";
		}

		$sql = "select tp.noind, tp.tempat_makan
				from hrd_khs.tpribadi tp 
				where tp.keluar = '0'
				$where
				order by tp.noind";
		return $this->personalia->query($sql)->result_array();
	}

	public function updateTempatMakanByNoind($tempat_makan,$noind){
		$sql = "update hrd_khs.tpribadi set tempat_makan = ?
				where noind = ?";
		return $this->personalia->query($sql,array($tempat_makan,$noind));
	}

	public function insertEditTempatMakan($insert){
		$this->personalia->insert('"Catering".t_edit_tempat_makan',$insert);
	}
}
?>
